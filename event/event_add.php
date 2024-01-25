<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
    	header("Location: ../index/index.php");
    }

    $e_name = $e_type = $exp = $st_date = $ed_date = '';

    $errors  = array('e_name'=>'','e_type'=>'','exp'=>'','st_date'=>'','ed_date'=>'');

    if(isset($_POST['add'])){
    	$e_name = $_POST['e_name'];
    	$e_type = $_POST['e_type'];
        $exp = $_POST['exp'];
    	$st_date = $_POST['st_date'];
    	$ed_date = $_POST['ed_date'];




    	if(empty($e_name)){
    		$errors['e_name'] = "Name must not be empty!";
    	}

    	if(empty($e_type)){
    		$errors['e_type'] = "Type must not be empty!";
    	}else{
    		if(!preg_match('/[SE]/i',$e_type)){
    			$errors['e_type'] = "Only 'S','E' are allowed!";
    		}
    	}

        if($e_type == 'E'){
            if(empty($exp)){
                $errors['exp'] = "Expense must not be empty!";

            }else{
                if(!preg_match('/[0-9]/i',$exp)){
                    $errors['exp'] = "Expense must be numbers!";

                }
            }
        }

    	if(empty($st_date)){
    		$errors['st_date'] = "Start date must not be empty!";
    	}else{
            if (strtotime($st_date) < strtotime(date("Y/m/d"))) {
                $errors['st_date'] = "Must be a valid date!";
            }
    	}

    	if(empty($ed_date)){
    		$errors['ed_date'] = "End date must not be empty!";
    	}else{
            if (strtotime($ed_date) < strtotime($st_date)) {
                $errors['ed_date'] = "Must be a valid date!";
            }
    	}

    	if(array_filter($errors)){

    	}else{
            //Get eid
            $query = "SELECT `auto_increment`  FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'events'";
            $result = mysqli_query($con,$query);
            if($result){
                $eid = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $eid = $eid[1]['auto_increment'];
            }else{
                echo 'query error:'.mysqli_error($con);

            }

    		//clean input string
	    	$e_name = mysqli_real_escape_string($con,$_POST['e_name']);
	    	$e_type = mysqli_real_escape_string($con,$_POST['e_type']);
            $exp = mysqli_real_escape_string($con,$_POST['exp']);
	    	$st_date = mysqli_real_escape_string($con,$_POST['st_date']);
	    	$ed_date = mysqli_real_escape_string($con,$_POST['ed_date']);

	    	//query
	    	$query = "INSERT INTO events(e_name,e_type,st_date,ed_date) VALUES('$e_name','$e_type','$st_date','$ed_date')";
            $result = mysqli_query($con,$query);
	    	if($result){
	    			//success
	    		}else{
	                echo 'query error:'.mysqli_error($con);
	    		}

            //Add for Exhibition or Seminar
            if($e_type == 'E'){

                $query = "INSERT INTO exhibition(eid,exp) VALUES($eid,$exp)";
                $result = mysqli_query($con,$query);

                if($result){
                    //success
                    header('Location: event.php');
                    die;
                }else{
                    echo 'query error:'.mysqli_error($con);

                }
            }else{
                $query = "INSERT INTO seminar(eid) VALUES($eid)";
                $result = mysqli_query($con,$query);

                if($result){
                    //success
                    header('Location: event.php');
                    die;
                }else{
                    echo 'query error:'.mysqli_error($con);

                }

            }
        }  





    }





 ?>

 <!DOCTYPE html>
 <html>
  	<?php  include('../templates/header_event.php'); ?>
  	<section class="container grey-text">
  		<h4 class="center">Add Event</h4>
  		<form class="white" action = "event_add.php" method = "POST">
  			<label>Event name:</label>
  			<input type="text" name="e_name" value = "<?php  echo $e_name ?>">
  			<div class="red-text"><?php  echo$errors['e_name']; ?></div>

 			<label>Event type:</label>
  			<input type="text" name="e_type" value = "<?php  echo $e_type ?>">
  			<div class="red-text"><?php  echo$errors['e_type']; ?></div>

            <label>Expense:</label>
            <input type="text" name="exp" value = "<?php  echo $exp ?>">
            <div class="red-text"><?php  echo$errors['exp']; ?></div>



 			<label>Start date:</label>
  			<input type="date" name="st_date" value = "<?php  echo $st_date ?>">
  			<div class="red-text"><?php  echo$errors['st_date']; ?></div>

  			<label>End date:</label>
  			<input type="date" name="ed_date" value = "<?php  echo $ed_date ?>">
  			<div class="red-text"><?php  echo$errors['ed_date']; ?></div>

  			<div class="center">
                <input type="submit" name="add" value="add" class="btn brand">
            </div>

  			
  		</form>
  	</section>


 	<?php  include('../templates/footer.php'); ?>


 </html>
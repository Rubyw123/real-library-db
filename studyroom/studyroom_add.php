<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
    	header("Location: ../index/index.php");
    }

    $room_no = $capacity ='';

    $errors  = array('room_no'=>'','capacity'=>'');

    if(isset($_POST['add'])){
    	$room_no = $_POST['room_no'];
    	$capacity = $_POST['capacity'];


    	if(empty($room_no)){
    		$errors['room_no'] = "Room number must not be empty!";
    	}else{
    		if(!(is_numeric($room_no))){
    			$errors['room_no'] = "Must be a valid room number!";
    		}
    	}

    	if(empty($capacity)){
    		$errors['capacity'] = "Capacity must not be empty!";
    	}else{
    		if(!($capacity>=0 && $capacity<=5)){
    			$errors['capacity'] = "The maximum capacity is 5!";
    		}
    	}

    	if(array_filter($errors)){

    	}else{

    		//clean input string
	    	$room_no = mysqli_real_escape_string($con,$_POST['room_no']);
	    	$capacity = mysqli_real_escape_string($con,$_POST['capacity']);

	    	//query
	    	$query = "INSERT INTO study_room(r_no, capacity) VALUES('$room_no','$capacity')";
            $result = mysqli_query($con,$query);
	    	if($result){
                header("Location: studyroom.php");
	    		}else{
	                echo 'query error:'.mysqli_error($con);
	    		}
           
        }  


    }





 ?>

 <!DOCTYPE html>
 <html>
  	<?php  include('../templates/header_study.php'); ?>
  	<section class="container grey-text">
  		<h4 class="center">Add Study Rooms</h4>
  		<form class="white" action = "studyroom_add.php" method = "POST">
  			<label>Room Number:</label>
  			<input type="text" name="room_no" value = "<?php  echo $room_no ?>">
  			<div class="red-text"><?php  echo$errors['room_no']; ?></div>

 			<label>Capacity:</label>
  			<input type="text" name="capacity" value = "<?php  echo $capacity ?>">
  			<div class="red-text"><?php  echo$errors['capacity']; ?></div>

  			<div class="center">
                <input type="submit" name="add" value="add" class="btn brand">
            </div>

  			
  		</form>
  	</section>


 	<?php  include('../templates/footer.php'); ?>


 </html>
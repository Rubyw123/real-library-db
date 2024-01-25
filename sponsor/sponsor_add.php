<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
    	header("Location: ../index/index.php");
    }

    $amt = $sid= $eid = $seminar = '';
    $errors = array('amt'=>'');

    if(isset($_GET['eid'])){
    	$eid = mysqli_real_escape_string($con,$_GET['eid']);

    	$query = "SELECT * from seminar where eid = $eid";

    	$result = mysqli_query($con,$query);

    	$seminar = mysqli_fetch_assoc($result);
    }
    if(isset($_GET['sid'])){
    	$sid = mysqli_real_escape_string($con,$_GET['sid']);
    	//print_r(gettype($sid));
    	//$sid = $_GET['sid'];

    	$query = "SELECT * from sponsor where sid = $sid";

    	$result = mysqli_query($con,$query);

    	$sponsor = mysqli_fetch_assoc($result);


    }

    if(isset($_POST['confirm'])){
    	$eid = mysqli_real_escape_string($con,$_POST['eid_to_add']);
    	$sid = mysqli_real_escape_string($con,$_POST['sid_to_add']);
    	$amount = $_POST['amt'];

    	if(empty($amount)){
    		$errors['amt'] = "Amount must no be empty!";
    	}else{
    		if(!is_numeric($amount)){
    			$errors['amt'] = "Amount must be numbers!";

    		}
    	}

    	if(array_filter($errors)){

    	}else{

    		$amount = mysqli_real_escape_string($con,$_POST['amt']);
    		print_r(gettype($amount));

    		//query
    		// $query = "INSERT INTO sp_se(sid,eid,amount) VALUES('$sid','$eid','$amount')";

    		$query = "CALL ADD_SPON($sid,$eid,$amount)";

    		$result = mysqli_query($con,$query);
    		if($result){
    			header("Location: ../event/event_detail.php?eid=$eid");
    			die;
    		}else{
    			echo 'query error:'.mysqli_error($con);

    		}

    	}
    }





 ?>

 <!DOCTYPE html>
 <html>

  	<?php  include('../templates/header_event.php'); ?>
  		<section class="container grey-text">
  			<form class="white" action = "sponsor_add.php" method = "POST">
 				<label>Sponsor Amount:</label>
  				<input type="number" name="amt" value = "<?php  echo $amt ?>">
  				<div class="red-text"><?php  echo$errors['amt']; ?></div>


				<input type="hidden" name="eid_to_add" value = "<?php echo $seminar['eid'] ?>">

				<input type="hidden" name="sid_to_add" value = "<?php echo $sponsor['sid'] ?>">

  				<div class="center">
                <input type="submit" name="confirm" value="confirm" class="btn brand">
            	</div>

  			</form>


  		</section>


  	<?php  include('../templates/footer.php'); ?>

 </html>
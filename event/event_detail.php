<?php
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);


	//Find cid/aid according to user type
	$user_type = $user_data['user_type'];
	$user_id = $user_data['user_id'];

    //Add event to customers/authors
    if(isset($_POST['register'])){
		$eid_to_register = mysqli_real_escape_string($con,$_POST['eid_to_register']);

		if($user_type == 'C'){
			$query = "INSERT INTO c_ex (eid,cid) VALUES('$eid_to_register','$user_id')";

		}else{
			$query = "INSERT INTO au_se (author_id,eid) VALUES('$user_id','$eid_to_register')";
		}


		try{
    		$result = mysqli_query($con,$query);
	    	if($result){
			//success

			header('Location: event_add_success.php');
			}else{
				echo 'query error'.mysqli_error($conn);
			}
    	}catch(Exception $e){
    		//print_r($e);
			header('Location: event_add_fail.php');
    	}
		
	}



    //check get request id param
    if(isset($_GET['eid'])){
    	$eid = mysqli_real_escape_string($con,$_GET['eid']);

    	$query1 = "SELECT * FROM events WHERE eid = $eid";

    	//get the query result
		$result1 = mysqli_query($con,$query1);

		//fetch result in array format
		$event = mysqli_fetch_assoc($result1);

		mysqli_free_result($result1);

    	$query2 = "SELECT a.s_fname, a.s_lname,b.amount From
			(SELECT s_fname,s_lname,sid FROM sponsor WHERE sid in (SELECT sid FROM sp_se WHERE eid = $eid))a
			right join(Select amount,sid from sp_se where eid = $eid)b
			on a.sid = b.sid";

		$result2 = mysqli_query($con,$query2);
		if($result2){
			$sponsors = mysqli_fetch_all($result2,MYSQLI_ASSOC);
			mysqli_free_result($result2);

		}



		mysqli_close($con);

		//print_r($event);


    }else{
    	echo "something wrong.";
    }


 ?>

 <!DOCTYPE html>
 <html>
 	<?php  include('../templates/header_event.php'); ?>
 	<div class="container center">
 		<?php if($event): ?>
	 		<h4><?php echo htmlspecialchars($event['e_name']); ?></h4>
	 		<h5> Event type: </h5>
	 		<?php if($event['e_type'] == 'S'): ?>
	 			<p> Seminar</p>

	 		<?php else: ?>
	 			<p> Exhibition</p>

	 		<?php endif; ?>

	 		<p>Start by: <?php  echo htmlspecialchars($event['st_date']); ?></p>
	 		<p>End by: <?php echo date($event['ed_date']); ?></p>

	 		<h5> Sponsors:</h5>
	 		<?php foreach($sponsors as $sponsor): ?>
	 			<p>
		 			<?php echo htmlspecialchars($sponsor['s_fname'])." ".htmlspecialchars($sponsor['s_lname']) ?>
		 			<?php if ($user_type == 'E'):?>
		 				<?php echo "$".htmlspecialchars($sponsor['amount']) ?>

		 			<?php endif ?>
		 		</p>

	 		<?php endforeach; ?>

	 		<?php if($user_type != 'E'): ?>
		 		<!-- Register form -->
		 		<form action = "event_detail.php" method="POST">
		 				
		 			<input type="hidden" name="eid_to_register" value = "<?php echo $event['eid'] ?>">
		 			<input type="submit" name="register" value="register" class="btn brand z-depth-0">
		 		</form>
		 	<?php endif; ?>

 		<?php else: ?>
 		<h5>No such event exists!</h5>

 		<?php endif; ?>

 	</div>
 		






  	<?php  include('../templates/footer.php'); ?>

 </html>
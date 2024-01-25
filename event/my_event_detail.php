<?php
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_type = $user_data['user_type'];
	$user_id = $user_data['user_id'];

	// print_r($user_id);
	// print_r($user_type);

    //Add event to customers/authors
    if(isset($_POST['delete'])){
		$eid_to_delete = mysqli_real_escape_string($con,$_POST['eid_to_delete']);

		//Find cid/aid according to user type
		
		if($user_type == 'C'){
			$query = "DELETE FROM c_ex WHERE eid = $eid_to_delete and cid = $user_id";

		}else{
			$query = "DELETE FROM au_se WHERE eid = $eid_to_delete and author_id = $user_id";
		}


	
    		$result = mysqli_query($con,$query);
	    	if($result){
			//success
			header('Location: my_event.php');
			die;
			}else{
				echo 'query error'.mysqli_error($conn);
			}
	    	
		
	}


    //check get request id param
    if(isset($_GET['eid'])){
    	$eid = mysqli_real_escape_string($con,$_GET['eid']);
    	// print_r($eid);

    	if($user_type == 'C'){
			$query = "SELECT a.eid,a.e_name,a.e_type,a.st_date,a.ed_date,b.reg_id 
			FROM (select * from events)a
			right join (select reg_id,eid from c_ex where cid = $user_id and eid = $eid)b
			ON a.eid = b.eid";

		}else{
			$query = "SELECT a.eid,a.e_name,a.e_type,a.st_date,a.ed_date,b.inv_id 
			FROM (select * from events)a
			right join (select inv_id,eid from au_se where author_id = $user_id and eid = $eid)b
			ON a.eid = b.eid";
		}



    	//get the query result
		$result = mysqli_query($con,$query);

		//fetch result in array format
		$event = mysqli_fetch_assoc($result);
		//print_r($event['eid']);
		// print_r($event['e_name']);

		// mysqli_free_result($result);
		// mysqli_close($con);



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

	 		<?php if($event['e_type'] == 'S'): ?>
	 			<h5> Invitation ID: </h5>
	 			<p><?php echo htmlspecialchars($event['inv_id']); ?></p>

	 		<?php else: ?>
	 			<h5> Register ID:</h5>
	 			<p><?php echo htmlspecialchars($event['reg_id']); ?></p>

	 		<?php endif; ?>




	 		<p>Start by: <?php  echo htmlspecialchars($event['st_date']); ?></p>
	 		<p>End by: <?php echo date($event['ed_date']); ?></p>

	 		<!-- Register form -->
	 		<form action = "my_event_detail.php" method="POST">
	 				
	 			<input type="hidden" name="eid_to_delete" value = "<?php echo $event['eid'] ?>">
	 			<input type="submit" name="delete" value="delete" class="btn brand z-depth-0">
	 		</form>

 		<?php else: ?>
 		<h5>No such event exists!</h5>

 		<?php endif; ?>

 	</div>
 		






  	<?php  include('../templates/footer.php'); ?>

 </html>
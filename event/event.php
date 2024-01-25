<?php 
session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);


    //query to get all events
    $query = "SELECT eid,e_name,e_type,st_date,ed_date FROM events ORDER BY st_date DESC";

    try{
    	$result = mysqli_query($con,$query);
    }catch(Exception $e){
    	print_r("test");
    }
    
    if($result){
	    //fetch the resulting row as an array
	    $events = mysqli_fetch_all($result,MYSQLI_ASSOC);

	    //free result from memory
	    mysqli_free_result($result);

		//close conn
		mysqli_close($con);


		//print_r($events[0]['e_name']);

    }else{
    	print_r("test");
    }

	


 ?>

 <!DOCTYPE html>
 <html>
	<?php  include('../templates/header_event.php'); ?>
	<h4 class="center brand-text">Current Events</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($events as $event):   ?>
				<div class="col s6 md3">
					<div class="card z-depth-0">
						<div class="card-image center">
							<img src="../img/1.png">
							<span class="card-title"><?php echo htmlspecialchars($event['e_name']); ?></span>
						</div>
						<div class="card-content">
							<li><?php echo "Start date: ".htmlspecialchars($event['st_date']); ?></li>
							<li><?php echo "End date: ".htmlspecialchars($event['ed_date']); ?></li>
							
						</div>

						<div class="card-action right-align">
							<a class = "brand-text" href="event_detail.php?eid=<?php echo $event['eid'] ?>">More Info</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php  include('../templates/footer.php'); ?>

 </html>
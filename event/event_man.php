<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
    	header("Location: ../index/index.php");
    }

    //query to get exhibition
    $query1 = "SELECT eid,e_name,e_type,st_date,ed_date FROM events WHERE eid in (Select eid FROM exhibition) ORDER BY st_date DESC";

    //query to get seminars
    $query2 = "SELECT eid,e_name,e_type,st_date,ed_date FROM events WHERE eid in (Select eid FROM seminar) ORDER BY st_date DESC";



    $result1 = mysqli_query($con,$query1);
    $result2 = mysqli_query($con,$query2);

    if($result1){
    	$exhibitions = mysqli_fetch_all($result1,MYSQLI_ASSOC);

    	//free result from memory
	    mysqli_free_result($result1);


    }else{
    	echo 'query error:'.mysqli_error($con);
    }


    if($result2){
    	$seminar = mysqli_fetch_all($result2,MYSQLI_ASSOC);

    	//free result from memory
	    mysqli_free_result($result2);

		//close conn

    }else{
    	echo 'query error:'.mysqli_error($con);
    }








 ?>


 <!DOCTYPE html>
 <html>
 <?php  include('../templates/header_event_admin.php'); ?>

 	<h4 class="center grey-text">Exhibitions</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($exhibitions as $event):   ?>
				<div class="col s12 m6">
					<div class="card z-depth-0">
						<div class="card-content center">
							<span class="card-title brand-text"><?php echo htmlspecialchars($event['e_name']); ?></span>
						</div>
						<div class="card-content">
							<li><?php echo "Start date: ".htmlspecialchars($event['st_date']); ?></li>
							<li><?php echo "End date: ".htmlspecialchars($event['ed_date']); ?></li>
							
						</div>

						<div class="card-action center-align">
							<div id = "link-container">
								<a class = "btn brand z-depth-0" href="event_detail.php?eid=<?php echo $event['eid'] ?>">More Info</a>
							</div>
							

						</div>

							

					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<h4 class="center grey-text">Seminar</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($seminar as $event):   ?>
				<div class="col s12 m6">
					<div class="card z-depth-0">
						<div class="card-content center">
							<span class="card-title brand-text"><?php echo htmlspecialchars($event['e_name']); ?></span>
						</div>
						<div class="card-content">
							<li><?php echo "Start date: ".htmlspecialchars($event['st_date']); ?></li>
							<li><?php echo "End date: ".htmlspecialchars($event['ed_date']); ?></li>
							
						</div>

						<div class="card-action center-align">
							<a class = "btn brand z-depth-0" href="event_detail.php?eid=<?php echo $event['eid'] ?>">More Info</a>
							<a class = "btn brand z-depth-0" href="../sponsor/sponsor_list.php?eid=<?php echo $event['eid'] ?>">Add Sponsor</a>
				

						</div>

							

					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>


 	<?php  include('../templates/footer.php'); ?>

 </html>
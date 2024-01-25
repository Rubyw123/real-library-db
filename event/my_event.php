<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];
    $user_type = $user_data['user_type'];


    if($user_type == 'C'){
        $query = "SELECT eid,e_name,e_type,st_date,ed_date FROM events WHERE eid in ( Select eid FROM c_ex WHERE cid = $user_id)";

    }else{
        $query = "SELECT eid,e_name,e_type,st_date,ed_date FROM events WHERE eid in ( Select eid FROM au_se WHERE author_id = $user_id)";

    }

    $result = mysqli_query($con,$query);

    if($result){
    	$events = mysqli_fetch_all($result,MYSQLI_ASSOC);

    }else{
    	echo 'query error:'.mysqli_error($con);
    }






 ?>




 <!DOCTYPE html>
 <html>
 	<?php  include('../templates/header_event.php'); ?>
 	<h4 class="center grey-text">My Events</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($events as $event):   ?>
				<div class="col s12 m6">
					<div class="card z-depth-0">
						<div class="card-content center">
							<span class="card-title brand-text"><?php echo htmlspecialchars($event['e_name']); ?></span>
						</div>
						<div class="card-content">
							<li><?php echo "Start date: ".htmlspecialchars($event['st_date']); ?></li>
							<li><?php echo "End date: ".htmlspecialchars($event['ed_date']); ?></li>
							
						</div>

						<div class="card-action right-align">
							<a class = "brand-text" href="my_event_detail.php?eid=<?php echo $event['eid'] ?>">More Info</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>


 	<?php  include('../templates/footer.php'); ?>


 </html>
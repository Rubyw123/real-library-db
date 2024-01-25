<?php 
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
    	header("Location: ../index/index.php");
    }

    //query to get all the sponsors
    $query  = "SELECT * FROM sponsor ORDER BY sid DESC";

    $result = mysqli_query($con,$query);

    if($result){
    	$sponsors = mysqli_fetch_all($result,MYSQLI_ASSOC);

    }else{
    	echo 'query error:'.mysqli_error($con);
    }

    if(isset($_GET['eid'])){
    	$eid = mysqli_real_escape_string($con,$_GET['eid']);
    }
 ?>

 <!DOCTYPE html>
 <html>
 	<?php  include('../templates/header_event.php'); ?>
 	<h4 class="center grey-text">Sponsor lists</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($sponsors as $sponsor):   ?>
				<div class="col s12 m6">
					<div class="card z-depth-0">
						<div class="card-content center">
							<span class="card-title brand-text">
								<?php echo htmlspecialchars($sponsor['s_fname'])." ".htmlspecialchars($sponsor['s_lname']); 
								?>
								
							</span>
						</div>
						

						<div class="card-action right-align">
							<a class = "brand-text" href="sponsor_add.php?eid=<?php echo $eid ?>&sid=<?php echo $sponsor['sid'] ?>">Select</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>


 	<?php  include('../templates/footer.php'); ?>

 </html>
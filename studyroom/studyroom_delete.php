<?php

session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);

    //check if it's a employee
    if($user_data['user_type'] != 'E'){
        header("Location: ../index/index.php");
    }


    $sql = 'SELECT * FROM study_room ORDER BY capacity';
    $result = mysqli_query($con, $sql);
    $studyrooms = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    mysqli_free_result($result);

	if (isset($_POST['delete'])) {
		$room_to_delete = mysqli_real_escape_string($con, $_POST['room_to_delete']);

		$query = "DELETE FROM study_room WHERE r_no = $room_to_delete";

		$result = mysqli_query($con, $query);
		if ($result) {
			//success

			header('Location: studyroom.php');
			die;
		} else {
			echo 'query error' . mysqli_error($conn);

		}
	}

?>

<!DOCTYPE html>
<html>

    <?php include('../templates/header_study.php'); ?>
    <br />
    <br />

    <h4 class="center grey-text">Study Rooms</h4>
    <div class="container">
        <div class="row">
            <?php foreach($studyrooms as $studyroom): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($studyroom['r_no']) ?></h6>
                            <div><?php echo 'Capacity: '; echo htmlspecialchars($studyroom['capacity']) ?></div>
                        </div>
                        <!-- <div class = "card-action right-align">
                            <a href="#" class="brand-text">more info</a>
                        </div> -->

						<div class="card-action center">
							<form action = "studyroom_delete.php" method="POST">
 				
 								<input type="hidden" name="room_to_delete" value = "<?php echo htmlspecialchars($studyroom['r_no']) ?>"> 
 								<input type="submit" name="delete" value="delete" class="btn brand z-depth-0">
 							</form>
						</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
   
    <?php  include('../templates/footer.php'); ?>

</html>
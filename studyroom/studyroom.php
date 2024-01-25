<?php

session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);


    $sql = 'SELECT * FROM study_room';
    $result = mysqli_query($con, $sql);
    $studyrooms = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    mysqli_free_result($result);

?>

<!DOCTYPE html>
<html>

    <?php include('../templates/header_study.php'); ?>
    <br />
    <br />
    <!-- <a href="reservation.php" class="btn brand z-depth-0" style="margin-left:200px;">Reserve Now</a> -->

    <h4 class="center grey-text">Study Rooms</h4>
    <div class="container">
        <div class="row">
            <?php foreach($studyrooms as $studyroom): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <!-- <form action="reservation.php" method="POST" class="white">
                                <input type="submit" name="r_no" value="<?php echo htmlspecialchars($studyroom['r_no']) ?>" class="btn brand">
                            </form> -->
                            <h6><?php echo htmlspecialchars($studyroom['r_no']) ?></h6>
                            <div><?php echo 'Capacity: '; echo htmlspecialchars($studyroom['capacity']) ?></div>
                        </div>
                        <div class="card-action right-align">
							<a class = "brand-text" href="reservation.php?r_no=<?php echo htmlspecialchars($studyroom['r_no']) ?>">Reserve Now</a>
						</div>
                   
                      
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
   
    <?php  include('../templates/footer.php'); ?>

</html>
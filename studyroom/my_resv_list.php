<?php

session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];



    $sql = "SELECT * FROM cu_st WHERE cid= $user_id";
    $result = mysqli_query($con, $sql);
    $resvs = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    mysqli_free_result($result);
?>

<!DOCTYPE html>
<html>

    <?php include('../templates/header_study.php'); ?>
    <br />

    <h4 class="center grey-text">My Reservation List</h4>
    <div class="container">
        <div class="row">
            <?php foreach($resvs as $resv): ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <div><?php echo 'Room No: '; echo htmlspecialchars($resv['r_no']) ?></div>
                            <div><?php echo 'Date: '; echo htmlspecialchars($resv['r_date']) ?></div>
                            <div><?php echo 'Time Slot: '; echo htmlspecialchars($resv['r_timeslot']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
   
    <?php  include('../templates/footer.php'); ?>

</html>
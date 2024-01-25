<?php
session_start();

	include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);




 ?>

 <!DOCTYPE html>
 <html>
    <?php  include('../templates/header_event.php'); ?>

    <div class="container center">
        <h4>Register successfully!</h4>
        <p>Click following link to go back</p>
        <a href="event.php">Back</a><br><br>

    </div>
    <?php  include('../templates/footer.php'); ?>

 </html>
<?php 
session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con)


    //$user_data['user_id']


 ?>


 <!DOCTYPE html>
 <html>
    <?php  include('../templates/header_index.php'); ?>
	<center>

		<img src="../img/5.png" alt="cover" width="1000" height="700">
	
	</center>

    <?php  include('../templates/footer.php'); ?>




 <!-- <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>My website</title>
 </head>
 <body>

 	<a href="login/logout.php">Logout</a>
 	<h1>This is the index page</h1>

 	<br>
 	Hello,<?php echo $user_data['user_name']; ?>.
 
 </body> -->
 </html>
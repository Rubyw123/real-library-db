<?php
session_start();

	include('../config/connection.php');
	include('functions.php');

	//User does not have to signup on signup page
	//$user_data = check_login($con)

	$user_name = $password = '';
	$errors = array('user_name'=>'','password'=>'');

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		//check user name
		if(empty($user_name)){
			$errors['user_name'] = 'A user name is required <br/>';

		}else{
			//Check for special characters
			$user_name = $_POST['user_name'];
			if(!preg_match('#^[\\w-]{3,20}$#', $user_name)){
				$errors['user_name'] = 'User name must be letters, numbers and underscore.';
			}
		}

		if(empty($password)){
			$errors['password'] = 'password must not be empty!';
		}else{
			$password = $_POST['password'];
			// if(!preg_match('#^[\\w?+*!#$%&-]{6,20}$#',$password)){
			// 	$errors['password'] = 'Try a new password.';
			// }
		}

		if(array_filter($errors)){
			//echo 'Errors in the form';

		}else{
			//TODOS: whats this
			$user_name = mysqli_real_escape_string($con,$_POST['user_name']);
			$password = mysqli_real_escape_string($con,$_POST['password']);


			//query
			$query = "SELECT * FROM users WHERE user_name = '$user_name' limit 1";

			$result = mysqli_query($con,$query);

			// read from db to check user_name
            if($result){
                //success
                if($result && mysqli_num_rows($result) > 0){
                	$user_data = mysqli_fetch_assoc($result);
                	echo openssl_decrypt($user_data['password'],"DES-ECB","1234321",0,"12345678910");
                	if(openssl_decrypt($user_data['password'],"DES-ECB","1234321",0,"12345678910") === $password){
                		$_SESSION['user_id'] = $user_data['user_id'];
                		header('Location: ../index/index.php');
                		die;
                	}

                }
                $errors['password'] = 'Wrong password!';


            }else{
                echo 'query error:'.mysqli_error($con);
            }
		}


	}
?>


<!DOCTYPE html>
<html>
	<?php  include('../templates/header_login.php'); ?>
	<section class="container grey-text">
	        <h4 class="center">Login</h4>
	        <form class="white" action = "login.php" method="POST">
	            <label>User Name:</label>
	            <input type="text" name="user_name" value = "<?php  echo $user_name ?>">
	            <div class="red-text"><?php  echo$errors['user_name']; ?></div>

	            <label>Password:</label>
	            <input type="password" name="password" value = "<?php  echo $password ?>">
	            <div class="red-text"><?php  echo$errors['password']; ?></div>

	            <div class="center">
	                <input type="submit" name="Login"value = "Login" class = "btn brand z-depth-0">
	            </div>

	            <div id = "link-container">
	            	<a href="signup.php">Not a user? Click to signup</a><br><br>
	            </div>

	            
	        </form>
	</section>





	<?php  include('../templates/footer.php'); ?>








 <!-- <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Login</title>
 </head>
 <body>

 	<style type="text/css">
 			
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

 	</style>

 	<div id = "box">
 		
 		<form method = "POST">
 			<div style = "font-size: 20px; margin: 10px;">Login</div>


 			<input type="text" name="user_name"><br><br>
 			<input type="password" name="password"><br><br>


 			<input type="submit" value="Login"><br><br>

 			<a href="signup.php">Click to Signup</a><br><br>

 		</form>
 	</div>
 
 </body> -->
 </html> 
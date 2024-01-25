<?php

session_start();

	include('../config/connection.php');
	include('functions.php');

	//User does not have to signup on signup page
	//$user_data = check_login($con)

	$user_name = $password = $type = '';
	$errors = array('user_name'=>'','password'=>'','type'=>'');




	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$type = $_POST['type'];



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
			$password = mysqli_real_escape_string($con,openssl_encrypt($_POST['password'],"DES-ECB","1234321",0,"12345678910"));
			$type = mysqli_real_escape_string($con,$_POST['type']);


			if(empty($type)){
				$type = 'C';
			}else{
				$type = 'A';
			}

			print_r($type);

			//user_id
			//$user_id = random_num(5);

			//query
			$query = "INSERT INTO users(user_name,password,user_type) VALUES('$user_name','$password','$type')";

			// save to db and check
            if(mysqli_query($con,$query)){
                //success
                header('Location: login.php');
                die;
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
	        <h4 class="center">Signup</h4>
	        <form class="white" action = "signup.php" method="POST">
	            <label>User Name:</label>
	            <input type="text" name="user_name" value = "<?php  echo $user_name ?>">
	            <div class="red-text"><?php  echo$errors['user_name']; ?></div>

	            <label>Password:</label>
	            <input type="password" name="password" value = "<?php  echo $password ?>">
	            <div class="red-text"><?php  echo$errors['password']; ?></div>


	            <!-- Customer or Author -->
	            <label>Type (check if you are an author):</label>
	            <p>
		            <li>
		            	
		            	<div class="left">
		            	<label>
	        				<input type="checkbox" name = "type" value = "A"/>
	        				<span>Author</span>
	      				</label>
		            </div>
		             
		            </li>
		        </p>
	            
 
        			
	            <p>
	            	<div class="center">
	                <input type="submit" name="Signup"value = "Signup" class = "btn brand z-depth-0">
	            </div>

	            </p>

	            
	            <div id = "link-container">
	            	<a href="login.php">Already a user? Click to login</a><br><br>
	            </div>
	        </form>
	</section>





	<?php  include('../templates/footer.php'); ?>

 <!-- <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Signup</title>
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
 			<div style = "font-size: 20px; margin: 10px;">Signup</div>


 			<input type="text" name="user_name"><br><br>
 			<input type="password" name="password"><br><br>


 			<input type="submit" value="Signup"><br><br>

 			<a href="login.php">Click to Login</a><br><br>

 		</form>
 	</div>
 
 </body> -->
 </html> 
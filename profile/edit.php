<?php 
//Connection setup
session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];
    $user_type = $user_data['user_type'];

    //Initialzation variables
    $fname = $lname = $c_fname = $c_lname = $p_no = $email = $id_type = $id_no = '';
    $zip = $afname = $alname = $st_addr = $city = $state =$country = $zipcode = $email_addr = '';

    $errors = array('c_fname'=>'','c_lname'=>'','p_no'=>'','email'=>'','id_type'=>'','id_no'=>'','st_addr'=>'','city'=>'','state'=>'','country'=>'','zipcode'=>'');


    if(isset($_POST['confirm'])){


    	//Customer
    	if($user_type == 'C'){
    		$c_fname = $_POST['fname'];
    		$c_lname = $_POST['lname'];
    		$p_no = $_POST['p_no'];
    		$email = $_POST['email'];
    		$id_type = $_POST['id_type'];
    		$id_no = $_POST['id_no'];


    		//check input fields
    		if(empty($c_fname)){
    			$errors['c_fname'] = "First name must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$c_fname)){
    				$errors['c_fname'] = "Name should only contain letters!";
    			}
    		}


     		if(empty($c_lname)){
    			$errors['c_lname'] = "Last name must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$c_lname)){
    				$errors['c_lname'] = "Name should only contain letters!";
    			}
    		}

    		if(empty($p_no)){
    			$errors['p_no'] = "Phone number must not be empty!";

    		}else{
    			if(!preg_match('/[0-9]{10}/i',$p_no)){
    				$errors['p_no'] = "Only numbers allowed!";
    			}
    		}

    		if(empty($email)){
    			$errors['email'] = "Email must not be empty!";

    		}else{
    			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                	$errors['email']  = 'Email must be a valid email address';
            	}
    		}

    		if(empty($id_type)){
    			$errors['id_type'] = "ID type must not be empty!";

    		}else{
    			if(!preg_match('/[SDP]/i',$id_type)){
    				$errors['id_type'] = "Only 'S','D','P' are allowed!";
    			}
    		}

    		if(empty($id_no)){
    			$errors['id_no'] = "ID number must not be empty!";

    		}else{
    			if(!preg_match('/[a-zA-Z0-9]/i',$id_no)){
    				$errors['id_no'] = "Only numbers and letters allowed!";
    			}
    		}


    	}
    	//Author
    	else{
    		$afname = $_POST['fname'];
    		$alname = $_POST['lname'];
    		$st_addr = $_POST['st_addr'];
    		$city = $_POST['city'];
    		$state = $_POST['state'];
    		$country = $_POST['country'];
    		$zipcode = $_POST['zip'];
    		$email_addr = $_POST['email'];

    		//Check input fields
    		if(empty($afname)){
    			$errors['c_fname'] = "First name must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$afname)){
    				$errors['c_fname'] = "Name should only contain letters!";
    			}
    		}


     		if(empty($alname)){
    			$errors['c_lname'] = "Last name must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$alname)){
    				$errors['c_lname'] = "Name should only contain letters!";
    			}
    		}

			if(empty($st_addr)){
    			$errors['st_addr'] = "Street must not be empty!";

    		}else{
    			if(!preg_match('/[a-zA-Z0-9]/i',$st_addr)){
    				$errors['st_addr'] = "Only numbers and letters allowed!";
    			}
    		}

			if(empty($city)){
    			$errors['city'] = "City must not be empty!";

    		}else{
    			if(!preg_match('/[a-zA-Z0-9]/i',$city)){
    				$errors['city'] = "Only numbers and letters allowed!";
    			}
    		}

			if(empty($state)){
    			$errors['state'] = "State must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$state)){
    				$errors['state'] = "Only letters allowed!";
    			}
    		}

     		if(empty($country)){
    			$errors['country'] = "Country must not be empty!";

    		}else{
    			if(!preg_match('/[a-z\s]/i',$country)){
    				$errors['country'] = "Country should only contain letters!";
    			}
    		}

    		if(empty($zipcode)){
    			$errors['zipcode'] = "zipcode must not be empty!";

    		}else{
    			if(!preg_match('/[0-9]/i',$zipcode)){
    				$errors['zipcode'] = "Only numbers allowed!";
    			}
    		}

	   		if(empty($email_addr)){
	    			$errors['email_addr'] = "Email must not be empty!";

	    		}else{
	    			if(!filter_var($email_addr, FILTER_VALIDATE_EMAIL)){
	                	$errors['email']  = 'Email must be a valid email address';
	            	}
	    		}

	    }

	    //Check if any input errors
	    if(array_filter($errors)){

	    }else{
	    	//Customer
	    	if($user_type == 'C'){
	    		//clean input string
	    		$c_fname = mysqli_real_escape_string($con,$_POST['fname']);
	    		$c_lname = mysqli_real_escape_string($con,$_POST['lname']);
	    		$p_no = mysqli_real_escape_string($con,$_POST['p_no']);
	    		$email = mysqli_real_escape_string($con,$_POST['email']);
	    		$id_type = mysqli_real_escape_string($con,$_POST['id_type']);
	    		$id_no = mysqli_real_escape_string($con,$_POST['id_no']);

	    		//query
	    		$query = "INSERT INTO customer(cid,c_fname,c_lname,p_no,email,id_type,id_no) VALUES($user_id,'$c_fname','$c_lname','$p_no','$email','$id_type','$id_no') ON DUPLICATE KEY UPDATE c_fname = '$c_fname',c_lname = '$c_lname',p_no = '$p_no',email = '$email',id_type = '$id_type',id_no = '$id_no'";

	    		if(mysqli_query($con,$query)){
	    			//success
	    			header('Location: my_profile.php');
	    			die;
	    		}else{
	                echo 'query error:'.mysqli_error($con);
	    		}



	    	}
	    	//Author
	    	else{
	    		//clean input string
	    		$afname = mysqli_real_escape_string($con,$_POST['fname']);
	    		$alname = mysqli_real_escape_string($con,$_POST['lname']);
	    		$st_addr = mysqli_real_escape_string($con,$_POST['st_addr']);
	    		$city = mysqli_real_escape_string($con,$_POST['city']);
	    		$state = mysqli_real_escape_string($con,$_POST['state']);
	    		$country = mysqli_real_escape_string($con,$_POST['country']);
	    		$zipcode = mysqli_real_escape_string($con,$_POST['zip']);
	    		$email_addr = mysqli_real_escape_string($con,$_POST['email']);

	    		//query
	    		$query = "INSERT INTO authors(author_id,afname,alname,st_addr,city,state,country,zipcode,email_addr) VALUES($user_id,'$afname','$alname','$st_addr','$city','$state','$country','$zipcode','$email_addr') ON DUPLICATE KEY UPDATE afname = '$afname',alname = '$alname', st_addr = '$st_addr',city = '$city',state = '$state',country = '$country',zipcode = '$zipcode',email_addr = '$email_addr' ";

	    		if(mysqli_query($con,$query)){
	    			//success
	    			header('Location: my_profile.php');
	    			die;
	    		}else{
	                echo 'query error:'.mysqli_error($con);
	    		}


	    	}
	    }

    }




 ?>
 <!DOCTYPE html>
 <html>
    <?php  include('../templates/header_index.php'); ?>
    <section class="container grey-text">
    	<h4 class="center">Edit Profile</h4>
    	<form class="white" action = "edit.php" method="POST">
    		<?php if($user_type == 'C'): ?>
    			<label>First Name:</label>
	            <input type="text" name="fname" value = "<?php  echo $fname ?>">
	            <div class="red-text"><?php  echo$errors['c_fname']; ?></div>

	            <label>Last Name:</label>
	            <input type="text" name="lname" value = "<?php  echo $lname ?>">
	            <div class="red-text"><?php  echo$errors['c_lname']; ?></div>

	            <label>Phone Number:</label>
	            <input type="text" name="p_no" value = "<?php  echo $p_no ?>">
	            <div class="red-text"><?php  echo$errors['p_no']; ?></div>

	            <label>Email:</label>
	            <input type="text" name="email" value = "<?php  echo $email ?>">
	            <div class="red-text"><?php  echo$errors['email']; ?></div>

	            <label>ID Type:</label>
	            <input type="text" name="id_type" value = "<?php  echo $id_type ?>">
	            <div class="red-text"><?php  echo$errors['id_type']; ?></div>

	            <label>ID Number:</label>
	            <input type="text" name="id_no" value = "<?php  echo $id_no ?>">
	            <div class="red-text"><?php  echo$errors['id_no']; ?></div>



    		<?php else: ?>
    			<label>First Name:</label>
	            <input type="text" name="fname" value = "<?php  echo $fname ?>">
	            <div class="red-text"><?php  echo$errors['c_fname']; ?></div>

	            <label>Last Name:</label>
	            <input type="text" name="lname" value = "<?php  echo $lname ?>">
	            <div class="red-text"><?php  echo$errors['c_lname']; ?></div>

	            <label>Street:</label>
	            <input type="text" name="st_addr" value = "<?php  echo $st_addr ?>">
	            <div class="red-text"><?php  echo$errors['st_addr']; ?></div>

	            <label>City:</label>
	            <input type="text" name="city" value = "<?php  echo $city ?>">
	            <div class="red-text"><?php  echo$errors['city']; ?></div>

	            <label>State:</label>
	            <input type="text" name="state" value = "<?php  echo $state ?>">
	            <div class="red-text"><?php  echo$errors['state']; ?></div>

	            <label>Country:</label>
	            <input type="text" name="country" value = "<?php  echo $country ?>">
	            <div class="red-text"><?php  echo$errors['country']; ?></div>


	            <label>Zipcode:</label>
	            <input type="text" name="zip" value = "<?php  echo $zip ?>">
	            <div class="red-text"><?php  echo$errors['zipcode']; ?></div>
	            
	            <label>Email:</label>
	            <input type="text" name="email" value = "<?php  echo $email ?>">
	            <div class="red-text"><?php  echo$errors['email']; ?></div>


    		<?php endif; ?>

    		<div class="center">
	                <input type="submit" name="confirm"value = "confirm" class = "btn brand z-depth-0">
	        </div>
    		

    	</form>
    	

    </section>

    <?php  include('../templates/footer.php'); ?>


 </html>
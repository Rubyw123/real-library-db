<?php 
session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];
    $user_type = $user_data['user_type'];

    if($user_type == 'C'){
        $query = "SELECT * FROM customer WHERE cid = '$user_id' limit 1 ";

    }else{
        $query = "SELECT * FROM authors WHERE author_id = '$user_id' limit 1 ";

    }

    try{
        $result = mysqli_query($con,$query);
        if($result){
            //success
            if($result && mysqli_num_rows($result) > 0){
                $profile_data = mysqli_fetch_assoc($result);
            }
        }else{
            header("Location: edit.php");
            print_r("not found!");

        }
    }catch(Exception $e){
        //redirect to edit profile
        header("Location: edit.php");

        print_r("not found!");

    }


 ?>

 <!DOCTYPE html>
 <html>
    <?php  $header_loc = ($user_type == 'E')? '../templates/header_admin.php' : '../templates/header_profile.php';?>

    <?php  include($header_loc); ?>



    <?php if(!empty($profile_data) || $user_type == 'E'): ?>

        <div class="container center">
            <h4>User Profile</h4>
                    <table class="striped centered">
                        <!-- <tr><th colspan="2">User Details:</th></tr> -->

                        <?php if($user_type == 'C'): ?>
                            <tr><th><i class="bi bi-envelope"></i> ID</th><td><?php echo htmlspecialchars($profile_data['cid']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Email</th><td><?php echo htmlspecialchars($profile_data['email']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> First name</th><td><?php echo htmlspecialchars($profile_data['c_fname']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Last name</th><td><?php echo htmlspecialchars($profile_data['c_lname']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Phone</th><td><?php echo htmlspecialchars($profile_data['p_no']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> ID Type</th><td>
                                <?php if(htmlspecialchars($profile_data['id_type']) == 'S'): ?>
                                    SSN

                                <?php elseif(htmlspecialchars($profile_data['id_type']) == 'D'): ?>
                                    Driver License

                                <?php else: ?>
                                    Passport

                                <?php endif; ?>
                                </td></tr>
                                <tr><th><i class="bi bi-envelope"></i> ID Number</th><td><?php echo htmlspecialchars($profile_data['id_no']) ?></td></tr>


                        <?php elseif($user_type == 'A'): ?>
                            <tr><th><i class="bi bi-envelope"></i> ID</th><td><?php echo htmlspecialchars($profile_data['author_id']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Email</th><td><?php echo htmlspecialchars($profile_data['email_addr']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> First name</th><td><?php echo htmlspecialchars($profile_data['afname']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Last name</th><td><?php echo htmlspecialchars($profile_data['alname']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Street</th><td><?php echo htmlspecialchars($profile_data['st_addr']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> City</th><td><?php echo htmlspecialchars($profile_data['city']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> State</th><td><?php echo htmlspecialchars($profile_data['state']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Country</th><td><?php echo htmlspecialchars($profile_data['country']) ?></td></tr>
                            <tr><th><i class="bi bi-envelope"></i> Zipcode</th><td><?php echo htmlspecialchars($profile_data['zipcode']) ?></td></tr>
                        <?php else: ?>
                            <tr><th><i class="bi bi-envelope"></i> Account Details:</th><td>Admin!</td></tr>


                        <?php endif; ?>
                    </table>
        </div>
        <div class="center">
        <?php if($user_type != 'E'): ?>
            <a href="edit.php" class = "btn brand z-depth-0">
                Edit
            </a>
        <?php endif; ?>
            <a href="../login/logout.php" class = "btn brand z-depth-0">
                Logout
            </a>


        </div>

    <?php else: 
        header("Location: edit.php");

    ?>

<?php endif; ?>

    




    <?php  include('../templates/footer.php'); ?>



 </html>
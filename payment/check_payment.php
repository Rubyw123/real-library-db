<?php
    session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];



    // $sql = "SELECT * FROM cu_st WHERE cid= $user_id";
    // $result = mysqli_query($con, $sql);
    // $resvs = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    // mysqli_free_result($result);



    // $payments = $inv_no = '';
    // $errors = array('inv_no' => '');
    $sql = "SELECT * FROM payment NATURAL JOIN invoice NATURAL JOIN rental WHERE cid= $user_id ORDER BY p_no DESC";
    $result = mysqli_query($con, $sql);
    $payments = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    mysqli_free_result($result);


    // if (isset($_POST['check'])) {

    //     if (empty($_POST['inv_no'])) {
    //         $errors['inv_no'] = 'An invoice number is required <br />';
    //     } else {
    //         $inv_no = $_POST['inv_no'];
    //         $sql1 = "select * from invoice where invoice_id= '$inv_no'";
    //         $result1 = $con->query($sql1);
            
    //         if ($result1->num_rows > 0) {
    //             while($row = $result1->fetch_assoc()) {
    //                 $invoice_amt = $row['invoice_amt'];
    //                 $errors['inv_no'] = "Balance: " . $row['invoice_amt'];
    //             }
    //         } else {
    //             $errors['inv_no'] =  "Invalid Invoice Number!";
    //         }
    //     }
        
    // }


    
?>

<!DOCTYPE html>
<html>
    <?php include('../templates/header_payment.php'); ?>
    <br />


    <!-- <section class="container grey-text">
            <h4 class="center">Check Your Payments</h4>
            <form action="check_payment.php" method="POST" class="white">
                <label>Please Enter Your Invoice Number:</label>
                <input type="text" name="inv_no" value="<?php echo htmlspecialchars($inv_no) ?>">
                <div class="red-text"><?php echo $errors['inv_no']; ?></div>
                <div class="center">
                    <input type="submit" name="check" value="check" class="btn brand">
                </div>
            </form>
    </section> -->


    <h4 class="center grey-text">Payment History</h4>
    <div class="container">
        <div class="row">
            <?php if($payments!= null): ?>
                <?php foreach($payments as $payment): ?>
                    <div class="col s6 md3">
                        <div class="card z-depth-0">
                            <div class="card-content center">

                                <div><?php echo 'Name: '; echo htmlspecialchars($payment['ch_fname']);
                                echo ' '; echo htmlspecialchars($payment['ch_lname'])?></div>
                                <div><?php echo 'Payment Amount: '; echo htmlspecialchars($payment['p_amt']) ?></div>
                                <div><?php echo 'Payment Method: '; echo htmlspecialchars($payment['p_method']) ?></div>
                                <div><?php echo 'Invoice No: '; echo htmlspecialchars($payment['invoice_id']) ?></div>
                                <div><?php echo 'Payment No: '; echo htmlspecialchars($payment['p_no']) ?></div>
                                
                            </div>
                            <!-- <div class = "card-action right-align">
                                <a href="#" class="brand-text">more info</a>
                            </div> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <?php  include('../templates/footer.php'); ?>

</html>
<?php
   session_start();


   include('../config/connection.php');
   include('../login/functions.php');

   $user_data = check_login($con);




    $date = date("Y-m-d");
    $inv_no =  $_SESSION['Pay_invoice'] = $_POST['Pay_invoice'];

    $p_amount = $p_method = $fname = $lname = $c_no = "";
    $errors = array('p_amount'=>'', 'p_method'=>'', 'fname'=>'', 'lname'=>'', 'c_no'=>'','inv_no'=>'');


    $sql1 = "select * from invoice where invoice_id= '$inv_no'";
    $result1 = $con->query($sql1);

    if ($result1->num_rows > 0) {
        while($row = $result1->fetch_assoc()) {
            $total_amt = $row['invoice_amt'];
        }
} else {
    // header("Location: invoice_amt_fail.php");
        }

    if (isset($_POST['submit'])) {

        if (empty($_POST['fname'])) {
            $errors['fname'] = 'First name is required <br />';
        } else {
            $fname = $_POST['fname'];
            if (!(preg_match('/[a-zA-Z]/', $fname))) {
                $errors['fname'] = 'Must be letters <br />';
            }
        }

        if (empty($_POST['lname'])) {
            $errors['lname'] = 'Last name is required <br />';
        } else {
            $lname = $_POST['lname'];
            if (!(preg_match('/[a-zA-Z]/', $lname))) {
                $errors['lname'] = 'Must be letters <br />';
            }
        }

        if (empty($_POST['p_amount'])) {
            $errors['p_amount'] = 'A payment amount is required <br />';

        } else {
            $p_amount = $_POST['p_amount'];
            if (!($p_amount>=0 && $p_amount<=$total_amt)) {
                $errors['p_amount'] = "Must be a valid amount <br />";
            }
        }

        if (empty($_POST['p_method'])) {
            $errors['p_method'] = 'A payment method is required <br />';
        } else {
            $p_method = $_POST['p_method'];
            if (!($p_method=='Cash' || $p_method=='Credit' || $p_method=='Debit' || $p_method=='Paypal')) {
                $errors['p_method'] = "Must be a valid payment method <br />";
            }
        }

        if(empty($_POST['c_no']) && $p_method != 'Cash'){
            $errors['c_no'] = 'A card/account number is required <br />';
        } else {
            $c_no = $_POST['c_no'];
            if(!(is_numeric($c_no)) && $p_method != 'Cash'){
                $errors['c_no'] = "Must be a valid card/account number";
            }
        }


        if(!(array_filter($errors))){
            
            $sql = "insert into payment (p_date, p_amt, ch_fname, ch_lname, p_method, inst_no, invoice_id) 
            values ('$date', '$p_amount', '$fname','$lname','$p_method','$c_no','$inv_no')";
            mysqli_query($con,$sql);

            $sql2 = "update invoice set invoice_amt = invoice_amt - '$p_amount' where invoice_id= '$inv_no'";
            mysqli_query($con,$sql2);

            header("Location: after_pay.php");

        }

    }


?>

<!DOCTYPE html>
<html>
    <?php include('../templates/header_payment.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Make a Payment</h4>
        <form action="payment.php" method="POST" class="white">
            <label>Invoice Number:</label>
            <input type="text" name="Pay_invoice" value="<?php echo isset($_POST["Pay_invoice"])?$_POST["Pay_invoice"]:"";?>" readonly="readonly">
            <label>Amount Balance:</label>
            <input type="text" name="total_amt" value="<?php echo htmlspecialchars($total_amt);?>" readonly="readonly">
            <!-- <input type="text" name="inv_no" value="<?php echo htmlspecialchars($inv_no) ?>" >
            <div class="red-text"><?php echo $errors['inv_no']; ?></div> -->
            <label>First Name:</label>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($fname) ?>">
            <div class="red-text"><?php echo $errors['fname']; ?></div>
            <label>Last Name:</label>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($lname) ?>">
            <div class="red-text"><?php echo $errors['lname']; ?></div>
            <label>Payment Amount:</label>
            <input type="text" name="p_amount" value="<?php echo htmlspecialchars($p_amount) ?>">
            <div class="red-text"><?php echo $errors['p_amount']; ?></div>
            <label>Payment Method (Debit/Credit/Paypal/Cash):</label>
            <input type="text" name="p_method" value="<?php echo htmlspecialchars($p_method) ?>">
            <div class="red-text"><?php echo $errors['p_method']; ?></div>
            <label>Card/Account Number (if applicable):</label>
            <input type="text" name="c_no" value="<?php echo htmlspecialchars($c_no) ?>">
            <div class="red-text"><?php echo $errors['c_no']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand">
            </div>

        </form>
    </section>
    <?php  include('../templates/footer.php'); ?>

</html>
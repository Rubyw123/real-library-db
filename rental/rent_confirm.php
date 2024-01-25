<script language="javascript">
    function pass_info() {
        let com_obj = document.getElementsByName("select")[0];
        com_obj.name = "cancel";
    }

    function check_date() {
        let obj_exp = document.getElementsByName("expected_return_date")[0];
        if (obj_exp.value == "") {
            alert("Please input a valid date!");
            return false;
        }
        return true;
    }

    function calc_fee() {
        let bor_date = document.getElementsByName("borrow_date")[0].value;
        let ret_date = document.getElementsByName("expected_return_date")[0].value;
        let fee_obj = document.getElementsByName("anticipated_expense")[0];
        bor_date = (new Date(bor_date.replace(/-/g, "/"))).getTime();
        ret_date = (new Date(ret_date.replace(/-/g, "/"))).getTime();
        fee_obj.value = (0.2 * Math.ceil((ret_date - bor_date) / (1000 * 60 * 60 * 24))).toFixed(1);
    }
</script>

<?php
  session_start();
error_reporting(E_ERROR);ini_set("display_errors","Off");

  include('../config/connection.php');
  include('../login/functions.php');

  $user_data = check_login($con);
  $cid = $user_data['user_id'];
  $ID = $con;

  $isbn = key($_POST);
  $S = $_POST["Page"];
  $topic = $_POST["topic"];
  $search = $_POST["search"];
  $result = mysqli_query($ID,"SELECT b_name FROM books WHERE isbn = $isbn");
  $b_name = mysqli_fetch_array($result)[0];
  $borrow_date = date("Y-m-d");
  $expected_return_date = date("Y-m-d",strtotime('+1 day'));

  $isbn = htmlspecialchars($isbn);
  $b_name = htmlspecialchars($b_name);
  $borrow_date = htmlspecialchars($borrow_date);
  $expected_return_date = htmlspecialchars($expected_return_date);
  $S = htmlspecialchars($S);
  $topic = htmlspecialchars($topic);
  $search = htmlspecialchars($search);
?>

<!DOCTYPE html>
<html>
<?php include('../templates/header_index.php'); ?>

<section class="container grey-text">
    <h4 class="center">Confirm Rental</h4>
    <form action="rent.php" method="POST" class="white">
        <input name="select" type="hidden" value="" />
        <label>ISBN:</label>
        <input type="text" name="isbn" value="<?php echo $isbn;?>" readonly="readonly" />
        <label>Book Name:</label>
        <input type="text" name="b_name" value="<?php echo $b_name;?>" readonly="readonly" />
        <label>Borrow Date:</label>
        <input type="date" name="borrow_date" value="<?php echo $borrow_date ?>" readonly="readonly" />
        <label>Expected Return Date:</label>
        <input type="date" name="expected_return_date" value="" min="<?php echo $expected_return_date ?>"  oninput="calc_fee();" />
        <label>Anticipated Expense:</label>
        <input type="text" name="anticipated_expense" value="" readonly="readonly" />
        <input name="Page" type="hidden" value="<?php echo $S; ?>" />
        <input name="topic" type="hidden" value="<?php echo $topic; ?>" />
        <input name="search" type="hidden" value="<?php echo $search; ?>" />
        <p align="center">
            <input type="submit" name="confirm" value="confirm" style="position:center; width:100px; height:40px; margin:10px; border-color:white; background-color:lightgreen " onclick="return check_date()"/>
            <input type="submit" name="cancel" value="cancel" style="position:center; width:100px; border-color:white; height:40px; margin:10px; background-color:lightcoral" onclick="pass_info()" />
        </p>
    </form>
</section>
<?php  include('../templates/footer.php'); ?>

</html>
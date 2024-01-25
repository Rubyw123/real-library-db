<script langage="javascript">
    var page_max = 1;
    var page_cur = 1;

    function confirm_pay(t) {
        let invoice_id = t.name;
        if (confirm("Are you sure to pay the invoice with ID '" + invoice_id + "' ?")) {
            document.getElementsByName('Pay_invoice')[0].value = invoice_id;
            return true;
        } else return false;
    }

    function check_page(t) {
        let comm_name = t.name;
        let page_new;
        page_max = document.getElementsByName("Page_max")[0].value - 1 + 1;
        page_cur = document.getElementsByName("Page")[0].value - 1 + 1;

        switch (comm_name) {
            case "PageUp":
                page_new = page_cur - 1;
                break;
            case "PageDown":
                page_new = page_cur + 1;
                break;
            case "ToPage":
                page_new = document.getElementsByName("ToPageNo")[0].value;
        }

        let Page_request = document.getElementsByName("Page_request")[0];
        Page_request.value = page_new;

        if (page_new%1 == 0 && page_new >= 1 && page_new <= page_max) { return true; }
        else {
            document.getElementsByName("ToPageNo")[0].value = page_cur;
            return false;
        }
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

$page_volume = 5;
$page_cur = 1;
$return_success_note = 0;
$request = key($_POST);

if(isset($request)&&$request!=""){

    switch($request){
        case "Page_Change":
            $page_cur = mysqli_real_escape_string($ID,$_POST["Page_request"]); break;
        case "Return":
            break;
        default:
            echo "DEFAULT";
    }
}

$result = mysqli_query($ID,"SELECT count(*) FROM (SELECT * FROM invoice WHERE invoice_amt >= 0) A JOIN
                            (SELECT * FROM rental WHERE cid = $cid) B ON A.ren_id = B.ren_id;");
$record_num = mysqli_fetch_array($result)[0];
$page_max = ceil($record_num/$page_volume);
if($page_max == 0) $page_max = 1;

if($page_cur > $page_max) $page_cur = $page_max;

$pos_fisrt = ($page_cur-1)*$page_volume;
$result = mysqli_query($ID,"SELECT i_id,rs,bd,ed,ad,b_name,c_id,i_a FROM
                            (SELECT * FROM (SELECT i_id,rental_sta rs,borrow_date bd,exp_return_date ed,act_return_date ad,i_a,copy_id c_id FROM
                            (SELECT invoice_id i_id,invoice_amt i_a,ren_id FROM invoice
                            WHERE invoice_amt >= 0) A JOIN
                            (SELECT * FROM rental WHERE cid = $cid) B ON A.ren_id = B.ren_id) C LEFT JOIN (SELECT copy_id,isbn FROM copies) D ON C.c_id = D.copy_id) E
                            LEFT JOIN (SELECT b_name,isbn FROM books) F ON E.isbn = F.isbn ORDER BY i_a DESC LIMIT $pos_fisrt,$page_volume;");

$page_cur = htmlspecialchars($page_cur);
$page_max = htmlspecialchars($page_max);
?>
<!DOCTYPE HTML>
<html>
<?php include("../templates/header_rental.php");?>

<section class="">
    <form>
        <table width="800px">
            <tr>
                <td>
                    <h5>My Invoice</h5>
                </td>
            </tr>
        </table>
    </form>

    <form name="page_control" method="post" action="show_invoice.php">
        <input name="Page_Change" type="hidden" />
        <input name="Page_request" type="hidden" value=1 />
        <table bordercolor="#999999" bgcolor="#FFFFFF">
            <tr>
                <td colspan="3">
                    <h7>
                        <b>Set Pages</b>
                    </h7>
                </td>
            </tr>
            <tr>
                <td width="10px">
                    <input name="PageUp" type="submit" value="PageUp" onclick="return check_page(this)" />
                </td>
                <td width="10px">
                    <input name="PageDown" type="submit" value="PageDown" onclick="return check_page(this)" />
                </td>
                <td width="10px">
                    <input name="ToPage" type="submit" value="ToPage" onclick="return check_page(this)" />
                </td>
                <td width="50px">
                    <input name="ToPageNo" type="text" value="<?php echo $page_cur; ?>" style="border:1px solid #000000; height: 30px; margin-top:9px;" />
                </td>
                <td width="250px">
                    <?php echo $page_cur."/".$page_max; ?>
                </td>
                <td width="400px"></td>
            </tr>
        </table>
    </form>


    <form name="invoice_list" method="post" action="../payment/payment.php" onsubmit="">
        <input name="Pay_invoice" type="hidden" value="return" />
        <table width="800" border="1" cellspacing="1" bordercolor="#999999" bgcolor="#FFFFFF">
            <tr>
                <td colspan="3">
                    <h7>
                        <b>Result List</b>
                    </h7>
                </td>
            </tr>
            <tr>
                <td width="100px">Invoice ID</td>
                <td width="20px">Status</td>
                <td width="100px">Borrow Date</td>
                <td width="100px">Expected Return Date</td>
                <td width="100px">Actual Return Date</td>
                <td width="100px">Book Name</td>
                <td width="50px">Copy ID</td>
                <td width="50px">Fee</td>
                <td width="50px" align="center">Operation</td>
            </tr>
            <?php while($myrows = mysqli_fetch_array($result)){ ?>
            <tr>
                <?php $col_num = count($myrows);
                      for($i = 0;$i < $col_num/2;$i++){ ?>
                <td>
                    <?php echo htmlspecialchars($myrows[$i]); ?>
                </td>
                <?php }
                      if($myrows['i_a'] == 0){
                          $pay_dis = htmlspecialchars('disabled=""');
                          $pay_info = htmlspecialchars("paid");
                      }else{
                          $pay_dis = "";
                          $pay_info = htmlspecialchars("pay");
                      }
                ?>
                <td align="center">
                    <input name="<?php echo htmlspecialchars($myrows[0]); ?>" type="submit" value="<?php echo htmlspecialchars($pay_info); ?>" onclick="return confirm_pay(this)" <?php echo $pay_dis ?> />
                </td>
            </tr>
            <?php }?>
        </table>
        <input name="Page" type="hidden" value="<?php echo $page_cur ?>" />
        <input name="Act_return_date" type="hidden" />
        <input name="Page_max" type="hidden" value="<?php echo $page_max ?>" />
    </form>
    <form>
        <?php echo " there are ".$record_num." records in total"; ?>
    </form>
</section>

<?php include("../templates/footer.php");?>

</html>
<script langage="javascript">
    var page_max = 1;
    var page_cur = 1;
    function pass_info1(t) {
        if (confirm("Are you sure to delete this author?")) {
            let author_button = t.value;
            let real_au_id = document.getElementsByName(author_button)[0].value;
            let obj_del = document.getElementsByName("delete_author")[0];
            obj_del.value = real_au_id;
            return true;
        } else return false;
    }

    function pass_info2(t) {
        if (confirm("Are you sure to add this author to this book?")) {
            let author_id = t.name;
            let obj_add = document.getElementsByName("add_author")[0];
            obj_add.value = author_id;
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

$page_volume = 6;
$page_cur = 1;
$isbn = 0;
$search_name = "";
$request = key($_POST);

// print_r($_POST);

if(isset($request)&&$request!=""){
    //echo "request is ".$request;
    $b_name = mysqli_real_escape_string($ID,$_POST['b_name']);
    $isbn = mysqli_real_escape_string($ID,$_POST['isbn']);
    $search_name = mysqli_real_escape_string($ID,$_POST['search_name']);

    switch($request){
        case "Page_Change":
            $page_cur = mysqli_real_escape_string($ID,$_POST["Page_request"]); break;
        case "initial_edit_author":
            $isbn = mysqli_real_escape_string($ID,$_POST['isbn']);
            break;
        case "search":
            $search_name = mysqli_real_escape_string($ID,$_POST['search_name']);
            break;
        case "add_author":
            $author_id = mysqli_real_escape_string($ID,$_POST["add_author"]);
            $page_cur = mysqli_real_escape_string($ID,$_POST["Page"]);
            try{
                mysqli_query($ID,"INSERT INTO author_book VALUES($author_id,$isbn);");
            }catch(Exception $e){
                // echo "Error ".$e->getMessage();
            }
            break;
        case "delete_author":
            $author_id = mysqli_real_escape_string($ID,$_POST["delete_author"]);
            $page_cur = mysqli_real_escape_string($ID,$_POST["Page"]);
            try{
                mysqli_query($ID,"DELETE FROM author_book WHERE author_id = $author_id AND isbn = $isbn;");
            }
            catch(Exception $e){

            }

        default:
            // echo "DEFAULT";
	break;
    }
}

if($search_name == ""){
    $search_comm = "";
}else{
    $search_comm = " AND afname LIKE '%$search_name%' OR alname LIKE '%$search_name%'";
}

$result = mysqli_query($ID,"SELECT count(*) FROM authors WHERE 1 = 1 $search_comm");
$record_num = mysqli_fetch_array($result)[0];
$page_max = ceil($record_num/$page_volume);
if($page_max == 0) $page_max = 1;

if($page_cur > $page_max) $page_cur = $page_max;

$pos_fisrt = ($page_cur-1)*$page_volume;
$result = mysqli_query($ID,"SELECT author_id,afname,alname,city,state,country,email_addr Email FROM authors WHERE 1 = 1 $search_comm LIMIT $pos_fisrt,$page_volume;");
$result_a = mysqli_query($ID,"SELECT author_id,afname,alname FROM authors WHERE author_id IN (SELECT author_id FROM author_book WHERE isbn = $isbn);");

$b_name = htmlspecialchars($b_name);
$isbn = htmlspecialchars($isbn);
$search_name = htmlspecialchars($search_name);
$page_cur = htmlspecialchars($page_cur);

?>
<!DOCTYPE HTML>

<?php include("../templates/header_rental.php");?>


    <form method="post" action="modify_book.php">
        <input name="<?php echo $isbn; ?>" type="hidden" value="<?php echo $isbn; ?>" />
        <table width="800px">
            <tr>
                <td>
                    <h5>Edit Author For Book: <?php echo $b_name." with ISBN: ".$isbn; ?></h5>
                </td>
                <td align="right" style="">
                    <input name="return" type="submit" value="return" class="right" />
                </td>
            </tr>
        </table>
    </form>

<form name="book_author" method="post" action="edit_author.php">
    <input name="delete_author" type="hidden" value=0 />
    <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
    <input name="b_name" type="hidden" value="<?php echo $b_name; ?>" />
    <input name="Page" type="hidden" value="<?php echo $page_cur; ?>" />
    <input name="search_name" type="hidden" value="<?php echo $search_name ?>" />
    <table bgcolor="#FFFFFF">
        <tr>
            <td>
                <h7>
                    <b>Authors of the book</b>
                </h7>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                while($myrows = mysqli_fetch_array($result_a)){
                    $str0 = htmlspecialchars("X $myrows[0] | $myrows[1] $myrows[2]");
                ?><input name="author_button" type="submit" value="<?php echo $str0 ?>" style="width:max-content; margin: 2px;" onclick="return pass_info1(this)"/>
                <input name="<?php echo $str0 ?>" type="hidden" value="<?php echo $myrows[0] ?>" />
                <?php
                }
                ?>
            </td>
        </tr>
    </table>
    </form>

<form name="filter" method="post" action="edit_author.php">
    <input name="search" type="hidden" value="">
    <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
    <input name="b_name" type="hidden" value="<?php echo $b_name; ?>" />
    <table  bgcolor="#FFFFFF">
    <tr><td colspan="2"><h7><b>Search Authors</b></h7></td></tr>
    <tr>
    <td width="50px">Name:</td><td width="300px"><input name="search_name" type="text" STYLE="border:1px solid #000000; height: 30px; width:400px; margin-top:9px;"></td>
    <td width="50px"><input name="confirm" type="submit" value="search"></td>
    <td width="400px"></td>
    </tr>
    </table>
</form>

    <form name="page_control" method="post" action="edit_author.php">
        <input name="Page_Change" type="hidden" />
        <input name="Page_request" type="hidden" value=1 />
        <input name="b_name" type="hidden" value="<?php echo $b_name;?>" />
        <input name="isbn" type="hidden" value="<?php echo $isbn;?>" />
        <input name="search_name" type="hidden" value="<?php echo $search_name ?>" />
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
<!--Display and selection Function Module-->
    <form name="author_list" method="post" action="edit_author.php" onsubmit="">
        <input name="add_author" type="hidden" value=0 />
        <table name="author_table" width="800" border="1" cellspacing="1" bordercolor="#999999" bgcolor="#FFFFFF">
            <tr>
                <td colspan="7">
                    <h7>
                        <b>Result List</b>
                    </h7>
                </td>
            </tr>
            <tr>
                <td width="50px">ID</td>
                <td width="100px">First Name</td>
                <td width="100px">Last Name</td>
                <td width="150px">City</td>
                <td width="50px">State</td>
                <td width="100px">Country</td>
                <td width="200px" align="center">E_mail</td>
                <td width="50px" align="center">Operation</td>
            </tr>
            <?php while($myrows = mysqli_fetch_array($result)){ ?>
            <tr>
                <?php $col_num = count($myrows);
                      for($i = 0;$i < $col_num/2;$i++){ ?>
                <td>
                    <?php echo htmlspecialchars($myrows[$i]) ?>
                </td>
                <?php } ?>
                <td align="center">
                    <input name="<?php echo htmlspecialchars($myrows[0]) ?>" type="submit" value="add" id="<?php echo htmlspecialchars($myrows[4])?>" onclick="return pass_info2(this)" />
                </td>
            </tr>
            <?php }?>
        </table>
        <input name="Page" type="hidden" value="<?php echo $page_cur ?>" />
        <input name="Page_max" type="hidden" value="<?php echo $page_max ?>" />
        <input name="isbn" type="hidden" value="<?php echo $isbn ?>" />
        <input name="b_name" type="hidden" value="<?php echo $b_name; ?>" />
        <input name="search_name" type="hidden" value="<?php echo $search_name ?>" />
    </form>

    <form>
        <?php echo " there are ".$record_num." records in total"; ?>
    </form>


<?php include("../templates/footer.php");?>

















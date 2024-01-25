<script language="javascript">
    // JAVASCRIPT FUNCTIONS for confirming or validating the users' operations before submitting
    // check if the page will exceed the region after pageup and pagedown
    function check_page(op) {
        let new_page = op + p0;
        if (new_page < 1 || new_page > page_max) {
            return false;
        } else {
            return true;
        }
    }

    // check if the page will exceed the region after goto a page
    function check_page2() {
        let new_page = document.getElementById("Page1").value;
        if (new_page < 0 || new_page > page_max || isNaN(new_page)) {
            document.getElementById("Page1").value = p0;
            return false;
        } else {
            return true;
        }
    }

    function pass_info(t) {
        if (confirm("Are you sure to delete this copy?")) {
            let copy_id = t.name;
            let input_d = document.getElementsByName("delete")[0];
            input_d.setAttribute('value', copy_id);
            return true;
        } else return false;
    }

    function add_au() {
        let obj_info = document.getElementsByName("info")[0];
        obj_info.action = "edit_author.php";
        let obj_comm1 = document.getElementById("comm_name1");
        obj_comm1.name = "initial_edit_author";
    }

    function exit_modifiy() {
        let obj_exit = document.getElementsByName("main_bar");
        obj_exit.action = "./manage_book.php";
    }

</script>

<?php
// Connection to SQL
session_start();
error_reporting(E_ERROR);ini_set("display_errors","Off");
    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $cid = $user_data['user_id'];
    $ID = $con;


// ++++++++++++++++++++++++++++++++++++++++OPERATION OF SERVER++++++++++++++++++++++++++++++++++++++++
// Initializing the variables
$S = 1; // The No. of page will be sent
$page_vol = 6;
$isbn = 0;
$input = key($_POST); // Extract the key of the first elements from POST (restoring command word from the BROWSER)
$read_flag = 1;

// test the name of command word
// print_r($_POST);
if(isset($input) && $input!=""){
    $isbn = mysqli_real_escape_string($ID,$_POST['isbn']);
    $S = mysqli_real_escape_string($ID,$_POST["Page"]);
    if($input == "UpPage"){
        $S = $_POST["Page"] - 1;
    }elseif($input == "DownPage"){
        $S = $_POST["Page"] + 1;
    }elseif($input == "ToPage"){
        $S = $_POST["Page1"];
    }elseif($input == "delete"){
        $copy_id = mysqli_real_escape_string($ID,$_POST["delete"]);
        if($copy_id == 0){
            mysqli_query($ID,"CALL ADD_A_COPY($isbn);");
        }else{
            try{
                // echo "DELETE FROM copies WHERE copy_id = $copy_id";
                mysqli_query($ID,"DELETE FROM copies WHERE copy_id = $copy_id");
            }
            catch(Exception $e){
?><script>alert('Error! Reason is <?php echo $e->getMessage();?>')</script><?php
            }
        }
    }else if($input == "add_a_book"){
        $S = 1;
        $b_name = mysqli_real_escape_string($ID,$_POST['b_name']);
        $topic = mysqli_real_escape_string($ID,$_POST['topic']);
        $No_copy = mysqli_real_escape_string($ID,$_POST['No_copy']);
        // echo "ISBN is ".$isbn;
        try{
            mysqli_query($ID,"CALL ADD_A_BOOK('$isbn','$b_name','$topic',$No_copy)");
?><script>alert('Add successfully! Now you can edit the author and copy info!')</script><?php
        }
        catch(Exception $e){
            ?><script>alert("Add failed! The reason is " + "<?php echo $e->getMessage();?>" );
                window.location.href = "add_book.php";
                </script><?php
            echo "REDIRECTING........";
            $read_flag = 0;
        }
    }elseif($input == "delete_book"){
        try{
            mysqli_query($ID,"DELETE FROM books WHERE isbn = $isbn");
                         ?><script>alert("Delete successfully!!!" );
                window.location.href = "manage_book.php";
</script><?php

        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    else{
        $S = 1;
        $isbn = $input;
    }
}
if($read_flag == 1){
// Displaying the current suitation of books


// Start checking the number of the books consistent with all the filters and page info for telling the total number of pages
$result = mysqli_query($ID,"SELECT count(*) FROM copies WHERE isbn = $isbn");
$myrow = mysqli_fetch_array($result);
$book_num = $myrow[0];
$S_max = ceil($book_num/$page_vol);
if($S_max == 0) $S_max = 1;
if($S > $S_max) $S = $S_max;
$pos = ($S-1)*$page_vol; // The position of the first books in that page

//CHECK THE AUTHOR INFO
$result_a = mysqli_query($ID,"SELECT author_id,afname,alname FROM authors WHERE author_id IN (SELECT author_id FROM author_book WHERE isbn = $isbn);");

//CHECK THE COPY INFO
$result = mysqli_query($ID,"SELECT * FROM books WHERE isbn = $isbn");
$book_info = mysqli_fetch_array($result);
$name = $book_info['b_name']; $topic = $book_info['topic'];


// Start checking copies details with all the filters and page info
$result = mysqli_query($ID,"SELECT a.copy_id,c_status,cid,ren_id FROM (SELECT * FROM copies WHERE isbn = $isbn) a LEFT JOIN
(SELECT * FROM rental WHERE rental_sta = 'B') b ON a.copy_id = b.copy_id LIMIT $pos,$page_vol");

$isbn = htmlspecialchars($isbn);
$S = htmlspecialchars($S);
$topic = htmlspecialchars($topic);
$book_num = htmlspecialchars($book_num);

?>

<!--++++++++++++++++++++++++++++++++++++++++OPERATION OF BROWSER++++++++++++++++++++++++++++++++++++++++-->
<!--Restore some variables on the webpage for confirming or validating-->
<?php include("../templates/header_rental.php");?>
<body>
<script> 
    var page_max = <?php echo $S_max?>;
    var p0 = <?php echo $S?>;
</script>

<form name = "main_bar" method="post" action="modify_book.php">
    <table width="800px">
        <tr>
            <td width="720px">
                <h5>Book Information Management</h5>
            </td>
            <td align="center">
                <input name="delete_book" value="delete" type="submit" class="right" style="border-color:white; background-color:lightcoral" onclick="return confirm('Are you sure to delete this book?');"/>
            </td>
            <td align="center">
                <input name="return" value="exit" type="button" onclick="window.location.href='manage_book.php'" class="right" >
            </td>
        </tr>
    </table>
    <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
    <input name="Page" type="hidden" value="<?php echo $S; ?>" />

</form>

    <!--Info Management Module-->
    <form name="info" method="post" action="modify_book.php">
        <input id="comm_name1" name="edit_basic_info" type="hidden" value="">
        <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
        <input name="b_name" type="hidden" value="<?php echo $name; ?>" />
        <table bgcolor="#FFFFFF">
            <tr>
                <td colspan="4">
                    <h7>
                        <b>Basic Information</b>
                    </h7>
                </td>
            </tr>
            <tr><td>ISBN: </td><td><?php echo $isbn?></td><td>Name: </td><td><?php echo $name?></td></tr>
            <tr><td>Topic:</td><td><?php echo $topic?></td></tr>
            <tr><td>Author:</td><td><input name="add_author" type="submit" value="Edit Author" onclick="add_au()" style="width:max-content;" /></td></tr>


            <tr><td colspan="4">
                    <?php
                    while($myrows = mysqli_fetch_array($result_a)){
                        $str0 = htmlspecialchars("$myrows[0]: $myrows[1] $myrows[2] |");
                        echo $str0;
                    }
                    ?>
            </td></tr>
        </table>
    </form>




<!--Page Function Module-->
<form name="control" method="post" action="modify_book.php">
    <table bgcolor="#FFFFFF">
    <tr><td colspan="3"><h7><b>Set Pages</b></h7></td></tr>
    <tr>
    <td width="10px"><input name="UpPage" type="submit" value="UpPage" onclick="return check_page(-1)" /></td>
    <td width="10px"><input name="DownPage" type="submit" value="DownPage" onclick="return check_page(1)" /></td>
    <td width="10px"><input name="ToPage" type="submit" value="To Page" onclick="return check_page2()" /></td>
    <td width="50px"><input name="Page1" type="text" value="<?php echo $S; ?>" id="Page1" STYLE="border:1px solid #000000; height: 30px; margin-top:9px;"/></td>
    <td width="250px"><script> document.write(p0 +"/"+page_max);</script></td>
    <td width="400px"></td>
    </tr></table>
    <input name="Page" type="hidden" value="<?php echo $S; ?>" />
    <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
</form>

<!--Display and selection Function Module-->
<form name="books" method="post" action="modify_book.php">
    <input name="delete" type="hidden" value=0 />
    <table width="800" border="1" cellpadding="1" cellspacing="1" bordercolor="#999999" bgcolor="#FFFFFF">
        <tr><td colspan="4"><h7><b>Result List</b></h7></td><td><input type="submit" name="add" value="add a copy" onclick="return confirm('Are you sure to add a new copy?')"></td></tr>
        <tr>
            <td width="160px" align="center">Copy ID</td><td width="160px" align="center">Availability</td>
            <td width="160px" align="center">Customer</td><td width="160px" align="center">Rental ID</td>
            <td width="160px" align="center">OPERATION</td>
        </tr>
        <?php
        while($myrows = mysqli_fetch_array($result)){
            $num_at = count($myrows);
            $books_table[$myrows[0]] = $myrows[1];
        ?>
        <tr>
            <?php for($i = 0;$i < $num_at/2;$i++){ ?>
            <td align="center">
                <?php echo htmlspecialchars($myrows[$i]);?>
            </td>
            <?php }?>

            <td align="center">
                <input name="<?php echo htmlspecialchars($myrows[0]); ?>" type="submit" value="delete" style="border-color:white; background-color:lightcoral" onclick="return pass_info(this)" ;/ />
            </td>

        </tr>
        <?php } ?>
    </table>
    <input name="Page" type="hidden" value="<?php echo $S; ?>" />
    <input name="isbn" type="hidden" value="<?php echo $isbn; ?>" />
</form>
<form><?php echo " there are ".$book_num." records in total"; ?></form>
    </body>

<?php }?>

<?php include("../templates/footer.php");?>
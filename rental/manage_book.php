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
        if (new_page <= 0 || new_page > page_max || isNaN(new_page)) {
            document.getElementById("Page1").value = p0;
            return false;
        } else {
            return true;
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

//check if it's a employee
if($user_data['user_type'] != 'E'){
        header("Location: ../index/index.php");
}

// ++++++++++++++++++++++++++++++++++++++++OPERATION OF SERVER++++++++++++++++++++++++++++++++++++++++
// Initializing the variables
$S = 1; // The No. of page will be sent 
$page_vol = 6;
$topic_c = ""; // The command words of selecting the topic of books, NULL is ALL topics
$search_c = ""; // The command words of selecting book by name, NULL is ALL books
$input = key($_POST); // Extract the key of the first elements from POST (restoring command word from the BROWSER)
//print_r($_POST);
if(((int)!isset($_POST["Page"]))||$_POST["Page"] == "") $S = 1;
else
    $S = $_POST["Page"];

if(((int)!isset($_POST["Topic"]))||$_POST["Topic"] == "all"||$_POST["Topic"] == "") $topic_c = "";
else{
    $topic = mysqli_real_escape_string($ID,$_POST["Topic"]);
    $topic_c = " AND topic = "."'$topic'";
}

if(((int)!isset($_POST["search"]))||$_POST["search"] == "") $search_c ="";
else{
    $b_name = mysqli_real_escape_string($ID,$_POST["search"]);
    $search_c = " AND b_name LIKE "."'%$b_name%'";
}

// test the name of command word
if(isset($input) && $input!=""){
    //++++++++++++++++++++++++++++++++++++++++ TOPIC (FILTER) FUNCTION: APPLY THE ALL FILTER CONDITIONS
    if($input == "Topic"){

    }else{
        //++++++++++++++++++++++++++++++++++++++++ CHANGE PAGE FUNCTION: UPPAGE AND DOWNPAGE
        if($input == "UpPage"){
            $S = mysqli_real_escape_string($ID,$_POST["Page"]) - 1;
        }elseif($input == "DownPage"){
            $S = mysqli_real_escape_string($ID,$_POST["Page"]) + 1;
        }elseif($input == "ToPage"){
            $S = mysqli_real_escape_string($ID,$_POST["Page1"]);
        }
    }
}

// Start checking the number of the books consistent with all the filters and page info for telling the total number of pages
$result = mysqli_query($ID,"SELECT count(*) FROM books WHERE 1 = 1 $topic_c $search_c");
$myrow = mysqli_fetch_array($result);
$book_num = $myrow[0];

$S = round($S);
$S_max = ceil($book_num/$page_vol);
if($S_max == 0) $S_max = 1;
if($S > $S_max) $S = $S_max;
// Displaying the current suitation of books
$pos = ($S-1)*$page_vol; // The position of the first books in that page

// Start checking books details with all the filters and page info
$result = mysqli_query($ID,"SELECT a.*,ifnull(b.num,0) num FROM books a LEFT JOIN (SELECT count(*) num,isbn FROM copies GROUP BY isbn) b ON a.isbn = b.isbn
WHERE 1 = 1 $topic_c $search_c LIMIT $pos,$page_vol;");

$S = htmlspecialchars($S);
$topic = htmlspecialchars($topic);
$b_name = htmlspecialchars($b_name);
$book_num = htmlspecialchars($book_num);

?>

<!--++++++++++++++++++++++++++++++++++++++++OPERATION OF BROWSER++++++++++++++++++++++++++++++++++++++++-->
<!--Restore some variables on the webpage for confirming or validating-->
<?php include("../templates/header_rental.php");?>
<body>
<script> 
    var page_max = <?php echo $S_max; ?>;
    var p0 = <?php echo $S?>;
</script>

<form>
    <table width="800px">
        <tr>
            <td>
                <h5>Book Management</h5>
            </td>
        </tr>
    </table>
</form>

<!--Filter Function Module-->
<form name="filter" method="post" action="manage_book.php">
    <table  bgcolor="#FFFFFF">
    <tr><td colspan="3"><h7><b>Search Books</b></h7></td></tr>
    <tr>
    <td width="10px">Topic:</td><td width="100px"><select name="Topic" title="Topic" id="s1" style="border:1px solid #000000; display:block; height:32px; width:150px; margin-top:1px;">
        <option value="all" selected>All</option>
        <option value="society">society</option>
        <option value="education">education</option>
        <option value="science">science</option>
        <option value="culture">culture</option>
        <option value="history">history</option>
        <option value="arts">arts</option>
        <option value="travel">travel</option>
        <option value="fiction">fiction</option>
        <option value="children">children</option>
        <option value="other">other</option>
    </select></td>
    <td width="10px">Name:</td><td width="150px"><input name="search" type="text" STYLE="border:1px solid #000000; height: 30px; width:200px; margin-top:9px;"></td>
    <td width="100px"><input name="confirm" type="submit" value="search"></td>
    <td width="400px"></td>
    </tr>
    </table>
</form>

<!--Page Function Module-->
<form name="control" method="post" action="manage_book.php">
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
    <input name="Topic" type="hidden" value="<?php echo $topic; ?>" />
    <input name="search" type="hidden" value="<?php echo $b_name; ?>" >
</form>

<!--Display and selection Function Module-->
<form name="books" method="post" action="modify_book.php">
    <table width="800" border="1" cellpadding="1" cellspacing="1" bordercolor="#999999" bgcolor="#FFFFFF">
        <tr><td colspan="4"><h7><b>Result List</b></h7></td><td><input type="button" name="add" value="+ add book" onclick="window.location.href='./add_book.php'"></td></tr>
        <tr>
            <td width="50px">ISBN</td><td width="200px">BOOK NAME</td><td width="100px">TOPIC</td><td width="20px">AMOUNT</td><td width="50px" align="center">OPERATION</td>
        </tr>
        <?php
        while($myrows = mysqli_fetch_array($result)){
            $num_at = count($myrows);
            $books_table[$myrows[0]] = $myrows[1];
        ?>
        <tr>
            <?php for($i = 0;$i < $num_at/2;$i++){ ?>
            <td>
                <?php echo htmlspecialchars($myrows[$i]);?>
            </td>
            <?php }?>

            <td align="center">
                <input id="<?php echo htmlspecialchars($myrows[1]); ?>" name="<?php echo htmlspecialchars($myrows[0]); ?>" type="submit" value="modify"/>
            </td>

        </tr>
        <?php } ?>
    </table>
    <input name="Page0" type="hidden" value="<?php echo $S; ?>" />
    <input name="Topic" type="hidden" value="<?php echo $topic; ?>" />
    <input name="search" type="hidden" value="<?php echo $b_name; ?>" >
</form>
<form><?php echo " there are ".$book_num." records in total"; ?></form>
    </body>


<?php include("../templates/footer.php");?>
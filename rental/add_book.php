<script>
    function check_vaild() {
        let isbn = document.getElementsByName('isbn')[0].value;
        let name = document.getElementsByName('b_name')[0].value;
        let no_cpoy = document.getElementsByName('No_copy')[0].value;
        if (/^\d+$/.test(isbn) && isbn.length == 13) {

            if (name.length > 0) {
                if (/^\d+$/.test(no_cpoy) && no_cpoy < 1000) {
                    return true;
                }
                else {
                    alert("invalid number of copies");
                    return false;
                }
            } else {
                alert("invalid book name");
                return false;
            }
        } else {
            alert("invalid ISBN");
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

    $comm = key($_POST);
    if(isset($comm)&&$comm!=""){
        echo "DEFAULT";
    }
?>

<?php include("../templates/header_index.php");?>
<br><br>
	<section class="container grey-text">
	        <h5 class="center">The Information of The New Book</h5>
	        <form class="white" action = "modify_book.php" method="POST" onsubmit="return check_vaild();">
                <input name="add_a_book" type="hidden" value="">

	            <label>ISBN:</label>
	            <input name="isbn" type="text" value="0000000000000">
                <div></div>

	            <label>Name:</label>
	            <input name="b_name" type="text" value="">
                <div></div>

                <label>Topic:</label>
	            <select name="topic" style="border:1px solid #000000; display:block; height:40px; width:420px; margin-bottom:8px; margin-top:8px;">
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
                </select>
                <div></div>

                <label>No. of copies:</label>
	            <input name="No_copy" type="text" value="">
                <div></div>

	            <div class="center">
	                <input name="NEXT" type="submit" value="confirm" class = "btn brand z-depth-0" style="width: 100px; margin:10px;">
                    <input name="EXIT" type="button" value="exit" class = "btn brand z-depth-0" onclick="window.location.href = './manage_book.php';" style="width: 100px; margin:10px;">
	            </div>
	            
	        </form>
	</section>

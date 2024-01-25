<?php

session_start();


    include('../config/connection.php');
    include('../login/functions.php');

    $user_data = check_login($con);
    $user_id = $user_data['user_id'];



    $date = $time_slot = '';
    $errors = array('date'=>'', 'time_slot'=>'');
    if (isset($_POST['r_no'])) {
        $room_no  = $_SESSION['r_no'] = $_POST['r_no'];
    }
    if (isset($_GET['r_no'])) {
        $room_no  = $_SESSION['r_no'] = $_GET['r_no'];
    }


 
    if(isset($_POST['submit'])){

     
        if(empty($_POST['date'])){
            $errors['date'] = 'A date is required <br />';
            
        }else {
            $date = $_POST['date'];
            if (strtotime($date) < strtotime(date("Y/m/d"))) {
                $errors['date'] = "Must be a valid date <br />";
            }
        }
        // !(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)

        if(empty($_POST['time_slot'])){
            $errors['time_slot'] = 'A time slot is required <br />';
        }else {
            $time_slot = $_POST['time_slot'];
            if(!( $time_slot=='A'||$time_slot=='B'||$time_slot=='C'||$time_slot=='D')){
                $errors['time_slot'] = "Must be one of 'A', 'B', 'C', 'D' <br />";
            }
        }
        

        if(!(array_filter($errors))){

            try{
                $add = mysqli_query($con, "CALL RESERVE_ROOM('$user_id','$date','$room_no','$time_slot')");
                if($add){
                //success
                header('Location: my_resv_list.php');
                }else{
                    echo 'query error'.mysqli_error($con);
                }
            }catch(Exception $e){
                header('Location: resv_fail.php');
            }
        }



     
    }

    


?>

<!DOCTYPE html>
<html>
    <?php include('../templates/header_study.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Make a Reservation</h4>
        <form action="reservation.php" method="POST" class="white">
            <!-- <label>Customer Number:</label>
            <input type="text" name="user_id" value="<?php echo $user_id;?>" readonly="readonly">
            <div class="red-text"><?php echo $errors['custm_no']; ?></div> -->
            <label>Room Number:</label>
            <input type="text" name="r_no" value="<?php echo $room_no;?>" readonly="readonly">
            <!-- <input type="text" name="room_no" value="<?php echo htmlspecialchars($room_no) ?>"> -->
            <!-- <div class="red-text"><?php echo $errors['room_no']; ?></div> -->
            <label>Date:</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($date) ?>">
            <div class="red-text"><?php echo $errors['date']; ?></div>
            <label>Time Slot (A: 8am-10am, B: 11am-1pm, C: 1pm-3pm, D: 4pm-6pm):</label>
            <input type="text" name="time_slot" value="<?php echo htmlspecialchars($time_slot) ?>">
            <div class="red-text"><?php echo $errors['time_slot']; ?></div>   
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand">
            </div>
        </form>
        <li><a href="resv_list.php" class="btn brand z-depth-o">Reservation List</a></li>
    </section>
    



    <?php  include('../templates/footer.php'); ?>

</html>

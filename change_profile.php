<?php
session_start();

$username = $_SESSION['username'];
$current_pw = $_POST['password'];
$new_pw = $_POST['new_password'];
$email = $_POST['email'];
$_SESSION['change_success'] = 1;

$db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
mysqli_select_db($db, 'decksite') or die(mysqli_error($db));

$query = "SELECT user_id, user_pw, user_email FROM login_info WHERE user_id = '$username'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
if ($result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        if($row['user_pw'] == $current_pw){
            $update = "UPDATE login_info SET user_pw = '$new_pw' WHERE user_id = '$username'";
            mysqli_query($db, $update) or die(mysqli_error($db));
            $_SESSION['change_success'] = 2;  
        }else{
            $_SESSION['change_success'] = 1;
        }
        if($email !=""){
            $update = "UPDATE login_info SET user_email = '$email' WHERE user_id = '$username'";
            mysqli_query($db, $update) or die(mysqli_error($db));  
            $_SESSION['change_success'] = 2;
        }
    }
}
header('Location: edit_profile.php');
?>
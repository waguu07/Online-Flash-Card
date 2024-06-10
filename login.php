<?php
session_start();
if(isset($_SESSION['authuser'])){

    header('Location: main_page.php');
}

?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Online Flash Card - Login</title>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>      
        <div class = "prompt">
            <h1>
                Online Flash Card
            </h1>
            <form action="" method = "post">
            <div class="identify">
                <label for="username" id="lab">Username: </label>    
                <input type = "text" id = "username" name = "username" required><br>
                <label for="password" id = lab>Password: </label>   
                <input type = "password" id = "password" name = "password" required><br>
                <input type ="submit" id="lab" class="button"name = "submit" value = "Submit">
            </div>
                
      
            <?php
            if(isset($_POST['submit'])){
   
                $id = $_POST['username'];
                $pw = $_POST['password'];


                $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
                mysqli_select_db($db, 'decksite') or die(mysqli_error($db));
                $query = "SELECT user_id FROM login_info WHERE EXISTS(/*SQL EXISTS Operator W3School*/
                    SELECT user_id FROM login_info WHERE user_id = '$id')                   
                ";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                $result = mysqli_num_rows($result);    
                if($result){
                    $query = "SELECT user_id, user_pw FROM login_info WHERE user_id = '$id'";
                    $row = mysqli_query($db, $query) or die(mysqli_error($db));
                    $row = mysqli_fetch_assoc($row);
                    extract($row);
                    if($user_pw != $pw){
                        echo '<script>alert("Wrong Login Information");</script>';
                    }else {
                        $_SESSION['authuser'] = 1;
                        $_SESSION['username']= $id;
                        header('Location: main_page.php');
                        
                    }
                }else{
                    echo '<script>alert("Wrong Login Information");</script>';
                }

                
            }
            ?>
            <p>Don't have an account? <a href ="signup.php">Sign Up</a></p>
        </form>

        </div>
    </body>
</html>


<!DOCTYPE html>
<html lang = 'en'>
    <head>
        <meta charset = 'utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Flash Card - Sign Up</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <div class="prompt">
            <h1>
                Sign up
            </h1>
            <form id ="form_id" method="post">
                <div class="identify">
                    <label for="username" id="lab">Username: </label>    
                    <input type = "text" id = "username" name = "username" required><br>
                    <label for="email" id = lab>Email: </label>    
                    <input type = "email" id = "email" name = "email"><br>
                    <label for="password" id = lab>Password: </label>    
                    <input type = "password" id = "password" name = "password" required><br>
                    <label for= "password" id = lab>Confirm Password: </label>    
                    <input type = "password" id = "c_password" name = "c_password" required><br>
                    
                    <input type="submit" id = "button" value= "submit" name = "submit"> 
                </div>
                <br>
                <p>Already have an account?  <a href="login.php">Login</a></p>
                <?php

                    if(isset($_POST['submit'])){
                        $id = $_POST['username'];
                        $password = $_POST['password'];
                        $c_password = $_POST['c_password'];
                        $email = $_POST['email'];

                        $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
                        mysqli_select_db($db, 'decksite') or die(mysqli_error($db));

                        $query = "SELECT user_id FROM login_info WHERE EXISTS(/*SQL EXISTS Operator W3School*/
                            SELECT user_id FROM login_info WHERE user_id = '$id')                   
                        ";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));    
                        $row = mysqli_num_rows($result);
                        
                        if($row){
                            echo '<script>alert("Username is already taken");</script>';
                        }else if($password != $c_password){
                            echo '<script>alert("Please re-enter the password");</script>';
                            
                        } else{
                            echo '<script>alert("Account Created");</script>';
                            $query = "INSERT INTO login_info(user_id, user_pw, user_email)
                            VALUES
                                ('$id','$password','$email')";
                            mysqli_query($db,$query) or die(mysqli_error($db));

                            header('Location: login.php');
                        }
                    }
                    ?>
            </form>      
        </div>
    </body>
</html>



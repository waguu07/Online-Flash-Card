<?php
session_start();
if(!isset($_SESSION['authuser'])){
    header('Location: login.php');
}
$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang= "en">
    <head>
    <title>Online Flash Card - Edit Profile</title>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <header>
            <h1>
                Welcome
                <?php
                echo $username;
                if(isset($_SESSION['change_success'])){
                    if($_SESSION['change_success'] == 1 ){
                        echo '<script>alert("Failed to change profile")</script>';
                    }else if($_SESSION['change_success'] == 2){
                        echo '<script>alert("Changed profile")</script>';
                    }
                }
                $_SESSION['change_success'] = 0;
                ?>
                <button id="menu" onclick="SignOut()">Sign Out</button>
                <script>
                    function SignOut(){
                        window.location = "logout.php";
                    }
                </script>
            </h1>
        </header>
        <nav>
            <ul>
                <li><a href="main_page.php">View Deck</a></li>
                <li><a href="create_deck.php">Create Deck</a></li>
                <li><a href="edit_deck.php">Edit Deck</a></li>
                <li><a href="search_deck.php">Search Deck</a></li>
                <li class="current"><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
        </nav>
        
        <div class="identify">
            <form action="change_profile.php" method="post">
            <label for="email" id = lab>Email: </label>    
                <input type = "email" id = "email" name = "email"><br>
                <label for="password" id = lab>Password: </label>    
                <input type = "password" id = "password" name = "password"><br>
                <label for= "newpassword" id = lab>New Password: </label>    
                <input type = "password" id = "newpassword" name = "new_password"><br>
                <input type="submit" name="submit">
            </form>
        </div>
    </body>
</html>
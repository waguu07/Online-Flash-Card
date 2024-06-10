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
    <title>Online Flash Card - Create Deck</title>
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
                <li class="current"><a href="create_deck.php">Create Deck</a></li>
                <li><a href="edit_deck.php">Edit Deck</a></li>
                <li><a href="search_deck.php">Search Deck</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
        </nav>
        
        <div>
            <form action="" method="post">
                <label for="deckname">Deck Name: </label>
                <input type="text" id="deckname" name="deckname">
                <input type="submit" name="submit" onclick="AddDeck()">
            </form>
        </div>
        <?php
            if(isset($_POST['submit'])){
                $deckname = $_POST['deckname'];
                if($deckname == ''){
                    return;
                }
                $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
                mysqli_select_db($db, 'decksite') or die(mysqli_error($db));

                $query = "SELECT deck_name FROM deck_info WHERE EXISTS(/*SQL EXISTS Operator W3School*/
                    SELECT deck_name FROM deck_info WHERE deck_name = '$deckname')                   
                ";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));    
                $row = mysqli_num_rows($result);
                if($row){
                    echo '<script>alert("Deck is already created");</script>';
                }else{
                    $query = "INSERT INTO deck_info(user_id, deck_name)
                    VALUES('$username','$deckname')";
            mysqli_query($db,$query) or die(mysqli_error($db));
            
            $query = "SELECT deck_id FROM deck_info WHERE deck_name = '$deckname' AND user_id = '$username'";

            $result = mysqli_query($db,$query) or die(mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
            $ans = $row["deck_id"];
            $ans = 'table' . $ans;
            $query = "CREATE TABLE $ans (/*SQL PRIMARY KEY Constraint W3School*/
                    word_id INT AUTO_INCREMENT PRIMARY KEY,
                    word_front VARCHAR(255) NOT NULL,
                    word_back VARCHAR(255) NOT NULL
            );"
            ;
            mysqli_query($db,$query) or die(mysqli_error($db));
            echo "<script>alert('Deck Added!')</script>";
        }
                }

        ?>
    </body>
</html>

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
    <title>Online Flash Card - Edit Deck</title>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <style>

            .collapsible {
                background-color: #55AD9B;
                color: white;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
            }


            .content {
                padding: 0 18px;
   
                overflow: hidden;
                background-color: #F1F8E8;
                height: 100px;
                align-content: center;
            }
        </style>
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
                <li><a href="create_deck.php">Create Deck</a></li>
                <li class="current"><a href="edit_deck.php">Edit Deck</a></li>
                <li><a href="search_deck.php">Search Deck</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
        </nav>

        <form action="edit_deck.php" method="post">
            <label for="table">Select Table: </label>
            <select name="table" id="table" required>
                <option value ="" selected disabled hidden>Choose a Deck</option> <!--taken from internet-->
                <?php
                $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
                mysqli_select_db($db, 'decksite') or die(mysqli_error($db));
                $query = "SELECT deck_name FROM deck_info WHERE user_id = '$username'";
                $result = mysqli_query($db,$query) or die(mysqli_error($db));
                if ($result->num_rows > 0){
                    while($row = mysqli_fetch_array($result)) {
                        echo "<option value=\"$row[0]\">$row[0]</option>";
                    }
                }

                ?>
            </select>
            <input type="submit" value="Select" name ="select">
        </form>
        <?php
            
            if(isset($_POST['table'])){
                $table_name = $_POST['table'];
                $_SESSION['current_edit_name'] = $table_name;
                $query = "SELECT deck_id FROM deck_info WHERE deck_name = '$table_name' AND user_id = '$username'";
                $result = mysqli_query($db,$query) or die(mysqli_error($db));
                $row = mysqli_fetch_assoc($result);
                $ans = $row["deck_id"];
                $ans = 'table' . $ans;
                $_SESSION['current_edit'] = $ans;
            }
            if(isset($_SESSION['current_edit'])){
                $ans = $_SESSION['current_edit'];
                $query = "SELECT * FROM $ans";
                $result = mysqli_query($db,$query) or die(mysqli_error($db));
                echo '<br>';
                echo '<p>'.$_SESSION['current_edit_name'].'</p>';
                echo 
                '<table class = "table" cellspacing="2" cellpadding="2" border="1">
                    <tr>
                        <th>#</th>
                        <th>Front</th>
                        <th>Back</th>    
                    </tr>';
                while($row = mysqli_fetch_assoc($result)){
                    extract($row);
                    echo '<tr>';
                    echo '<td>'.$word_id. '</td>';
                    echo '<td>'.$word_front. '</td>';
                    echo '<td>'.$word_back. '</td>';
                    echo '</tr>';
                }
                echo'</table>';
            }else{
                echo '<br>';
                echo '<p class="table">No table selected</p>';
                echo '<br>';
            }
        ?>
        <p class="collapsible">Add Word</p>
        <div class="content">
            <form class="edit" action="" method="post">
                <input type="text" name="front" placeholder ="Front">
                <input type="text" name="back" placeholder = "Back">
                <input type="submit" name = "add" value="Add">
            </form>
            <?php
                if((isset($_POST['front'])||isset($_POST['back'])) && isset($_SESSION['current_edit'])){
                    $deck = $_SESSION['current_edit'];
                    $front = $_POST['front'];
                    $back = $_POST['back'];
                    $query = "INSERT INTO $deck(word_front, word_back) VALUES ('$front', '$back')";
                    mysqli_query($db,$query) or die(mysqli_error($db));
                    echo "<script>alert('Card Added!')</script>";
                    header('Location: edit_deck.php');
                }
            ?>
        </div>
        <p class="collapsible">Remove Word</p>
        <div class="content">
            <form class= "edit" action="" method="post">
                <input type="text" name="id" placeholder="ID">
                <input type="submit" name="remove" value="Remove">
            </form>
            <?php
                if(isset($_POST['id']) && isset($_SESSION['current_edit'])){
                    $deck = $_SESSION['current_edit'];
                    $id = $_POST['id'];
                    $query = "DELETE FROM $deck WHERE word_id = '$id'";
                    mysqli_query($db,$query) or die(mysqli_error($db));
                    echo "<script>alert('Card Removed!')</script>";
                    header('Location: edit_deck.php');
                }
            ?>
        </div>

    </body>
</html>
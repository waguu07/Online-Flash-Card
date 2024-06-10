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
    <title>Online Flash Card - Seach Deck</title>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <style>

            
            .collapsible {/*How TO - Collapse W3school*/
                font-family: monospace;
                text-decoration: none;
                font-weight: bold;
                display: inline-block;
                border:none;
                background: #55AD9B;
                color: white;
                padding: 5px;
                border-radius: 5px;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                text-align: center;
                font-size: 20px;
            }

            .active, .collapsible:hover {/*How TO - Collapse W3school*/
                background-color: #006769; 
            }

            .content {/*How TO - Collapse W3school*/
                padding: 0 18px;
                display: none;
                overflow: hidden;
                background-color: #F1F8E8;
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
                <li><a href="edit_deck.php">Edit Deck</a></li>
                <li class="current"><a href="search_deck.php">Search Deck</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
        </nav>
        <div>
            <form action="" method="POST">
                <label for="search">Seach Deck: </label>
                <input type="text" id="search" name="search">
                <input type="submit" value="search"><br>
            </form>

        </div>
        <?php
        $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
        mysqli_select_db($db, 'decksite') or die(mysqli_error($db));
        $query = "SELECT deck_name FROM deck_info";
        $result = mysqli_query($db,$query) or die(mysqli_error($db));

        if(isset($_POST['search'])){
            $table_name = $_POST['search'];
            $query = "SELECT deck_id, user_id FROM deck_info WHERE deck_name = '$table_name'";
            $result = mysqli_query($db,$query) or die(mysqli_error($db));
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    extract($row);
                    echo '<p>'.$user_id.'</p>
                    <button type="button" class="collapsible">'.$table_name.'</button>
                    <div class="content">';//How TO - Collapse W3school
                    $ans = 'table'.$deck_id;
                    $table_query = "SELECT * FROM $ans";
                    $table_result = mysqli_query($db,$table_query) or die(mysqli_error($db));
                    echo 
                    '<table cellspacing="2" cellpadding="2" border="1">';
                        while($table_row = mysqli_fetch_assoc($table_result)){
                            extract($table_row);
                            echo '<tr>';
                            echo '<td>'.$word_front. '</td>';
                            echo '<td>'.$word_back. '</td>';
                            echo '</tr>';
                        }
                    echo'</table>';
                    echo'</div>';
                }
            }else{
                echo '<p>No results Found</p>';
            }
        }
        ?>
        <script>/*How TO - Collapse W3school*/
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                content.style.display = "none";
                } else {
                content.style.display = "block";
                }
            });
        }
        </script>
    </body>
</html>

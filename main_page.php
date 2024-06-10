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
    <title>Online Flash Card - View Deck</title>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <style>


            .flip-card {/*How To - Flip Card W3school*/
                background-color: transparent;
                width: 300px;
                height: 50px;
                perspective: 1000px;
                margin: 10px;
                display: inline-block;
            }

            .flip-card-inner {/*How To - Flip Card W3school*/
                position: relative;
                width: 100%;
                height: 100%;
                text-align: center;
                transition: transform 0.6s;
                transform-style: preserve-3d;
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            }

            .flip-card:hover .flip-card-inner {/*How To - Flip Card W3school*/
                transform: rotateY(180deg);
            }

            .flip-card-front, .flip-card-back {/*How To - Flip Card W3school*/
                position: absolute;
                width: 100%;
                height: 100%;
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
            }

            .flip-card-front {/*How To - Flip Card W3school*/
                background-color: #95D2B3;
                color: black;
            }

            .flip-card-back {/*How To - Flip Card W3school*/
                background-color: #55AD9B;
                color: white;
                transform: rotateY(180deg); 
            }
        </style>
    </head>
    <body>
        <header>
        <h1>
            Welcome
            <?php
            echo $username;
            $word_data = [];

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
                <li class="current"><a href="main_page.php">View Deck</a></li>
                <li><a href="create_deck.php">Create Deck</a></li>
                <li><a href="edit_deck.php">Edit Deck</a></li>
                <li><a href="search_deck.php">Search Deck</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
            </ul>
        </nav>
        <form action="main_page.php" method="post">
            <label for="table">Select Table: </label>
            <select name="table" id="table" required>
                <option value ="" selected disabled hidden>Choose a Deck</option> <!--Stack Overflow: How can I set the default value for an HTML <select> element?-->
                <?php
                $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
                mysqli_select_db($db, 'decksite') or die(mysqli_error($db));
                $query = "SELECT deck_name FROM deck_info WHERE user_id = '$username'";
                $result = mysqli_query($db,$query) or die(mysqli_error($db));

                if ($result->num_rows > 0){
                    while($row = mysqli_fetch_array($result)) {
                        echo "<option value=\"$row[0]\">$row[0]</option>";//How TO - Custom Select Box W3School
                    }
                }

                ?>
            </select>
            <input type="submit" value="Select" name ="select"><br><br>
        </form>
        <?php
            if(isset($_POST['table'])){
                $table_name = $_POST['table'];
                $table_query = "SELECT deck_id FROM deck_info WHERE deck_name = '$table_name' AND user_id = '$username'";
                $table_result = mysqli_query($db,$table_query) or die(mysqli_error($db));
                $table_row = mysqli_fetch_assoc($table_result);
                $word_name = $table_row["deck_id"];
                $word_name = 'table' . $word_name;
                $word_query= "SELECT word_front, word_back FROM $word_name";
                $word_result = mysqli_query($db, $word_query) or die(mysqli_error($db));

                while($word_row = mysqli_fetch_assoc($word_result)){
                    $word_data[] = $word_row;
                }

                foreach ($word_data as $w){//How To - Flip Card W3school
                    echo '<div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <p>'.$w['word_front'].'</p>
                            </div>
                            <div class="flip-card-back">
                                <p>'.$w['word_back'].'</p>
                            </div>
                        </div>
                    </div>';
                }
            }else{
                echo "<p>No table selected</p>";
            }
        ?>
        

    </body>
</html>

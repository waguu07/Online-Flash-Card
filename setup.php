<?php
    $db = mysqli_connect('localhost', 'root', '') or die ('Unable to connect');
    $query = 'CREATE DATABASE IF NOT EXISTS decksite';
    mysqli_query($db, $query) or die(mysqli_error($db));

    mysqli_select_db($db,'decksite') or die(mysqli_error($db));

    $query = 'CREATE TABLE login_info(
        user_id VARCHAR(255) PRIMARY KEY,
        user_pw VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL
        );'
        ;
    mysqli_query($db,$query) or die(mysqli_error($db));
    
    $query = 'CREATE TABLE deck_info(
        deck_id int AUTO_INCREMENT PRIMARY KEY,
        deck_name VARCHAR(255) NOT NULL,
        rating FLOAT Not NULL,
        user_id VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES login_info(user_id)
        );'
        ;
    mysqli_query($db,$query) or die(mysqli_error($db));
    echo 'all setup!';
?>
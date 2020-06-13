<?php

    include('database_connection.php');
    
    $text = $_POST['text'];
    date_default_timezone_set("UTC");
    $creation_date = date('Y-m-d H-i-s', strtotime('-3 Hour'));

    $query = mysqli_query($db_connection, "INSERT INTO annotation (full_text, creation_date) VALUES ('$text', '$creation_date')");

    if ($query == true) {
        echo "Added new Annotation with Success!";
    } else {
        echo "Failed to add new annotation! :(";
    }

?>
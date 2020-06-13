<?php
    
    include('database_connection.php');
    
    $result = mysqli_query($db_connection, "SELECT * FROM annotation", MYSQLI_USE_RESULT);

    echo json_encode(mysqli_fetch_all($result));

?>
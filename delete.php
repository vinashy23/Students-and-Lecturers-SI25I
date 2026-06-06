<?php

include 'connection.php';

if(isset($_GET['nidn'])){

    $nidn = $_GET['nidn'];

    mysqli_query(
        $conn,
        "DELETE FROM lecturer WHERE NIDN='$nidn'"
    );

    echo "success";
}

?>

<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nidn = $_POST['nidn'];
    $name = $_POST['name'];
    $major = $_POST['major'];
    $course = $_POST['course'];

    $sql = "INSERT INTO lecturer (NIDN, Name, Major, Course)
            VALUES ('$nidn', '$name', '$major', '$course')";

    if(mysqli_query($conn, $sql)){
        echo "success";
    } else {
        echo "error";
    }
}

?>
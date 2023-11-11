<?php
    $hostname = "localhost";
    $username = "root";
    $password = "123456";
    $database = "car_parking";
    
    $con = mysqli_connect($hostname, $username, $password, $database);
    
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    
?>
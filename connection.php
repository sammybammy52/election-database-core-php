<?php

    $servername="localhost";
    $username="root";
    $password="";
$dbname = "bincomphptest";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //echo 'e work';

    // Check connection
    if(!$conn){
        //die("Connection failed: ".mysqli_connect_error());
        echo 'e no work';
    }

 ?>
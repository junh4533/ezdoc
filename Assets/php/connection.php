<?php
    $host = "localhost";
    $host_user = "root";
    $host_pass = "";
    $database = "scheduling";
    $port = "3306";

    // connect to mysql
    $mysql = mysqli_connect($host, $host_user, $host_pass);
    if(!$mysql) {
        die("Cannot connect to database.");
    }

    // select the appropriate database
    $selected = mysqli_select_db($mysql, $database);
    if(!$selected) {
        die("Cannot select database.");
    }
?>
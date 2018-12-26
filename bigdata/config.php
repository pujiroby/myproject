<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $databasename = "simbada-kotamalang-2017";
    $mysqli = new mysqli( $host, $username, $password, $databasename );
    if ($mysqli->connect_error){
        echo 'Gagal koneksi ke database';
    } else {}
?>


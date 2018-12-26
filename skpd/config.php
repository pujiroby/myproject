<?php
    $host = "localhost";
    $username = "root";
    $password = "4dm1n1234567";
    $databasename = "simbada-kotamalang-2018";
    $mysqli = new mysqli( $host, $username, $password, $databasename );
    if ($mysqli->connect_error){
        echo 'Gagal koneksi ke database';
    } else {}
?>


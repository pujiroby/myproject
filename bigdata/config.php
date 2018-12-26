<?php
    $host = "192.168.22.100";
    $username = "root";
    $password = "4dm1n1234567";
    $databasename = "simbada-kotamalang-2017";
    $mysqli = new mysqli( $host, $username, $password, $databasename );
    if ($mysqli->connect_error){
        echo 'Gagal koneksi ke database';
    } else {}
?>


<?php
    $host = "192.168.22.101";
    $username = "root";
    $password = "4dm1n1234567";
    $databasename = "puji";
    $mysqli = new mysqli( $host, $username, $password, $databasename );
    if ($mysqli->connect_error){
        echo 'Gagal koneksi ke database';
    } else {}
?>


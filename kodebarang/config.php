<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $databasename = "simbadatool";
    $mysqli = new mysqli( $host, $username, $password, $databasename );
    if ($mysqli->connect_error){
        echo 'Gagal koneksi ke database';
    } else {}
?>


<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tugasbesar_m1_thafallah2";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
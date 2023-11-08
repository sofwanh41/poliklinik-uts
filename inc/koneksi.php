<?php
$host = "localhost";
$user = "root";  // Sesuaikan jika berbeda
$pass = "";      // Sesuaikan jika berbeda
$db = "polikliniktopwan";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi Gagal: " . $mysqli->connect_error);
}

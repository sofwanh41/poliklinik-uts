<?php
include("C:/xampp/htdocs/poliklinik-topwan/inc/koneksi.php");

// Logika penyimpanan data periksa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    $waktu = $_POST['waktu'];
    $obat = $_POST['obat'];
    $catatan = $_POST['catatan'];

    $query = "INSERT INTO periksa(id_dokter, id_pasien, tanggal_periksa, waktu, obat, catatan) VALUES ('$id_dokter', '$id_pasien', '$tanggal_periksa', '$waktu', '$obat', '$catatan')";

    if ($mysqli->query($query)) {
        header("Location: index.php?page=periksa/periksa");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}

// Logika penghapusan data periksa
if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM periksa WHERE id='$id'";

    if ($mysqli->query($query)) {
        header("Location: index.php?page=periksa/periksa");
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}

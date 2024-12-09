<?php
$host = "localhost"; // Nama host
$user = "root";      // Username database
$password = "";      // Password database
$dbname = "fp_adopsi"; // Nama database

// Buat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

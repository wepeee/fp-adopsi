<?php
session_start(); // Mulai session
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if (!empty($nama) && !empty($email) && !empty($notelp) && !empty($password)) {
        $query = "INSERT INTO users (nama, email, notelp, password) VALUES ('$nama', '$email', '$notelp', '$password')";
        if (mysqli_query($conn, $query)) {
            // Jika berhasil, set pesan ke session
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: ../register.php"); // Arahkan kembali ke halaman register
            exit;
        } else {
            // Jika gagal, set pesan error ke session
            $_SESSION['error'] = "Terjadi kesalahan: " . mysqli_error($conn);
            header("Location: ../register.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Harap isi semua field!";
        header("Location: ../register.php");
        exit;
    }
}

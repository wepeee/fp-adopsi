<?php
session_start(); // Mulai session
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : 'user'; // Default role adalah 'user'

    // Validasi input
    if (!empty($nama) && !empty($email) && !empty($notelp) && !empty($password)) {
        // Periksa apakah email sudah terdaftar
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Jika email sudah terdaftar
            $_SESSION['error'] = "Email sudah terdaftar. Silakan gunakan email lain.";
            header("Location: ../register.php");
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menambahkan data ke database
        $query = "INSERT INTO users (nama, email, password, notelp, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Binding parameter
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $email, $hashedPassword, $notelp, $role);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, set pesan ke session
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: ../login.php"); // Arahkan ke halaman login
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

<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Menyimpan data pengguna ke session
                $_SESSION['user'] = $user;

                // Cek role pengguna
                if ($user['role'] == 'admin') {
                    // Jika admin, arahkan ke halaman admin
                    header("Location: ../admin_dashboard.php"); // Ganti dengan halaman admin yang sesuai
                    exit;
                } else {
                    // Jika user biasa, arahkan ke halaman utama
                    header("Location: ../index.php");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Password salah!";
                header("Location: ../login.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Email tidak terdaftar.";
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Harap isi semua field!";
        header("Location: ../login.php");
        exit;
    }
}

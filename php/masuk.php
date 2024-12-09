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
                $_SESSION['user'] = $user;
                header("Location: ../index.php");
                exit;
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

<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['user'])) {
  // Jika sudah login, redirect ke halaman utama atau dashboard
  header("Location: index.php"); // Ganti dengan halaman yang sesuai
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once 'php/db_config.php';

  // Ambil data dari form login
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $password = isset($_POST['password']) ? $_POST['password'] : null;

  if (!empty($email) && !empty($password)) {
    // Query untuk mencari user berdasarkan email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);

      // Verifikasi password
      if (password_verify($password, $user['password'])) {
        // Simpan data user ke session
        $_SESSION['user'] = $user;

        // Cek role pengguna
        if ($user['role'] === 'admin') {
          // Jika admin, arahkan ke halaman admin
          header("Location: admin_dashboard.php"); // Ganti dengan halaman admin
        } else {
          // Jika user biasa, arahkan ke halaman utama
          header("Location: index.php"); // Ganti dengan halaman utama
        }
        exit;
      } else {
        $_SESSION['error'] = "Password salah!";
        header("Location: login.php");
        exit;
      }
    } else {
      $_SESSION['error'] = "Email tidak terdaftar.";
      header("Location: login.php");
      exit;
    }
  } else {
    $_SESSION['error'] = "Harap isi semua field!";
    header("Location: login.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="src/css/style.css" />
  <link rel="stylesheet" href="src/css/login.css" />
</head>

<body>
  <nav>
    <img src="src/images/logo.png" alt="logo" />
  </nav>

  <div class="yellow-box"></div>

  <main>
    <div class="logo-login">
      <img src="src/images/logo.png" alt="logo" />
    </div>
    <div class="container-form">
      <h2>Login</h2>
      <hr />

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $_SESSION['error'];
          unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            aria-describedby="emailHelp"
            required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required />
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
      </form>

      <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
  </main>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous">
  </script>
  <script>
    if (performance.navigation.type == 2) {
      location.reload(true);
    }
  </script>
</body>

</html>
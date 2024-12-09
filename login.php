<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['user'])) {
  // Jika sudah login, redirect ke halaman utama atau dashboard
  header("Location: index.php"); // Ganti dengan halaman yang sesuai
  exit;
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
      <form method="POST" action="./php/masuk.php">
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
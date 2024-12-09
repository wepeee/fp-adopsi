<?php
session_start();

// Mencegah halaman disimpan dalam cache oleh browser
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
  // Jika tidak, redirect ke halaman login
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="src/css/style.css" />
  <link rel="stylesheet" href="src/css/hewan.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <div class="container">
        <img src="src/images/logo.png" alt="" />
      </div>
      <div class="container">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse my-link"
          id="navbarSupportedContent">
          <ul class="my-link navbar-nav me-auto mb-2 mb-lg-0 ml">
            <li class="nav-item ms-3">
              <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
            </li>

            <li class="nav-item ms-3">
              <?php if (isset($_SESSION['user'])): ?>
                <!-- Menampilkan nama lengkap pengguna -->
                <p class="nav-link" style="font-style: italic;"><?php echo "Halo, " . $_SESSION['user']['nama']; ?></p>
              <?php else: ?>
                <!-- Tombol Masuk jika belum login -->
                <a class="nav-link btn-masuk" href="login.php">Masuk</a>
              <?php endif; ?>
            </li>

            <li class="nav-item ms-3">
              <?php if (isset($_SESSION['user'])): ?>
                <!-- Tombol Logout jika sudah login -->
                <a class="nav-link" href="logout.php">Logout</a>
              <?php else: ?>
                <!-- Tombol Daftar jika belum login -->
                <a class="nav-link" href="register.php">Daftar</a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="yellow-box d-flex justify-content-between">
    <form style="width: 20%" class="d-flex" role="search">
      <input
        class="form-control me-2"
        type="search"
        placeholder="Search"
        aria-label="Search" />
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
    <div class="dropdown">
      <button
        class="btn btn-light dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        Kategori
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Anjing</a></li>
        <li><a class="dropdown-item" href="#">Kucing</a></li>
        <li><a class="dropdown-item" href="#">Lain lain</a></li>
      </ul>
    </div>
  </div>

  <div class="container-fluid d-flex justify-content-around flex-wrap">
    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>

    <div class="card" style="width: 18rem">
      <img
        src="src/images/kucing/cat.4001.jpg"
        class="card-img-top"
        alt="cat" />
      <div class="card-body">
        <h5 class="card-title">Nama Kucing</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the
          bulk of the card's content.
        </p>
        <a href="#" class="btn badge text-bg-primary rounded-pill">Detail</a>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
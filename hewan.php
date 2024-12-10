<?php
session_start();

include 'php/db_config.php';

// Ambil data dari database, termasuk fitur pencarian
$searchQuery = ""; // Variabel pencarian default kosong

if (isset($_GET['search']) && !empty($_GET['search'])) {
  $searchQuery = mysqli_real_escape_string($conn, $_GET['search']); // Hindari SQL Injection
  $query = "SELECT * FROM item_hewan WHERE nama LIKE '%$searchQuery%'";
} else {
  $query = "SELECT * FROM item_hewan"; // Jika tidak ada pencarian, ambil semua data
}

$result = mysqli_query($conn, $query);

if (!$result) {
  echo "Gagal mengambil data dari database: " . mysqli_error($conn);
  exit;
}

// Mencegah halaman disimpan dalam cache oleh browser
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Hewan</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="src/css/style.css" />
  <link rel="stylesheet" href="src/css/hewan.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <div class="container">
        <img src="src/images/logo.png" alt="Logo" />
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
                <p class="nav-link" style="font-style: italic;"><?php echo "Halo, " . $_SESSION['user']['nama']; ?></p>
              <?php else: ?>
                <a class="nav-link btn-masuk" href="login.php">Masuk</a>
              <?php endif; ?>
            </li>
            <li class="nav-item ms-3">
              <?php if (isset($_SESSION['user'])): ?>
                <a class="nav-link" href="logout.php">Logout</a>
              <?php else: ?>
                <a class="nav-link" href="register.php">Daftar</a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="yellow-box d-flex justify-content-between">
    <form style="width: 20%" class="d-flex" role="search" method="GET">
      <input
        class="form-control me-2"
        type="search"
        name="search"
        value="<?php echo htmlspecialchars($searchQuery); ?>"
        placeholder="Search by name"
        aria-label="Search" />
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </div>

  <div class="container-fluid d-flex justify-content-around flex-wrap">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($item = mysqli_fetch_assoc($result)): ?>
        <div class="card" style="width: 18rem">
          <img src="<?php echo $item['gambar']; ?>" class="card-img-top" alt="<?php echo $item['nama']; ?>" />
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="card-title"><?php echo $item['nama']; ?></h5>
              <p class="card-text">
                <?php echo substr($item['deskripsi'], 0, 100); ?>...
              </p>
            </div>
            <a style="width: fit-content;" href="detail.php?id=<?php echo $item['id']; ?>" class="btn badge text-bg-primary rounded-pill mt-2">Detail</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center mt-4">Tidak ada hasil yang ditemukan untuk pencarian "<?php echo htmlspecialchars($searchQuery); ?>".</p>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
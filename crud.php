<?php
// Hubungkan ke database
include 'php/db_config.php'; // Pastikan file ini ada dan jalurnya benar
session_start();

// Cek apakah user login sebagai admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Handle Create (Tambah)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar'];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($gambar['name']);

    if (move_uploaded_file($gambar['tmp_name'], $targetFile)) {
        $query = "INSERT INTO item_hewan (nama, deskripsi, gambar) VALUES ('$nama', '$deskripsi', '$targetFile')";
        if (mysqli_query($conn, $query)) {
            echo "Item berhasil ditambahkan!";
        } else {
            echo "Gagal menambahkan item.";
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM item_hewan WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "Item berhasil dihapus!";
    } else {
        echo "Gagal menghapus item.";
    }
}

// Ambil semua data item hewan
$query = "SELECT * FROM item_hewan";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Admin - Item Hewan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/css/index.css">
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
                            <a class="nav-link active" aria-current="page" href="./admin_dashboard.php">Home</a>
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
    <div class="container my-5">
        <h1 class="display-4">CRUD Admin - Item Hewan</h1>

        <!-- Form Create Item -->
        <h2>Tambah Item Hewan</h2>
        <form action="crud.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Hewan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Hewan</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Tambah Item</button>
        </form>

        <hr>

        <!-- Tabel Item Hewan -->
        <form action="cetak-pdf.php" method="post">
            <button type="submit" class="btn btn-primary">Cetak PDF</button>
        </form>
        <h2>Daftar Item Hewan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><img src="<?php echo $item['gambar']; ?>" width="100" alt="Gambar Hewan"></td>
                        <td><?php echo $item['nama']; ?></td>
                        <td><?php echo substr($item['deskripsi'], 0, 100); ?>...</td>
                        <td>
                            <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="crud.php?delete=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

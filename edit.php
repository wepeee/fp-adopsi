<?php
session_start();
require_once 'php/db_config.php';

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID hewan yang dipilih
if (isset($_GET['id'])) {
    $hewanId = $_GET['id'];

    // Ambil data hewan berdasarkan ID
    $query = "SELECT * FROM item_hewan WHERE id = '$hewanId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $hewan = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error'] = "Hewan tidak ditemukan.";
        header("Location: crud.php");
        exit;
    }
} else {
    $_SESSION['error'] = "ID hewan tidak ditemukan.";
    header("Location: crud.php");
    exit;
}

// Proses pembaruan data hewan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : $hewan['nama'];
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : $hewan['deskripsi'];
    $gambarLama = $hewan['gambar']; // Menyimpan gambar lama

    // Proses upload gambar baru jika ada
    if ($_FILES['gambar']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Cek apakah file yang diupload adalah gambar
        if (getimagesize($_FILES["gambar"]["tmp_name"])) {
            // Simpan file gambar yang diupload
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
                $gambar = $targetFile; // Gambar baru
            } else {
                $_SESSION['error'] = "Terjadi kesalahan saat mengupload gambar.";
                header("Location: edit.php?id=$hewanId");
                exit;
            }
        } else {
            $_SESSION['error'] = "Hanya file gambar yang diperbolehkan.";
            header("Location: edit.php?id=$hewanId");
            exit;
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar = $gambarLama;
    }

    // Query untuk memperbarui data hewan
    $updateQuery = "UPDATE item_hewan SET nama = '$nama', deskripsi = '$deskripsi', gambar = '$gambar' WHERE id = '$hewanId'";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['success'] = "Data hewan berhasil diperbarui.";
        header("Location: crud.php"); // Arahkan ke crud.php setelah update berhasil
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Hewan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Hewan</h2>
        <hr />

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Hewan</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($hewan['nama']); ?>" required />
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Hewan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($hewan['deskripsi']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Hewan</label>
                <input type="file" class="form-control" id="gambar" name="gambar" />
                <small>Jika tidak ingin mengubah gambar, biarkan kosong.</small>
                <div class="mt-3">
                    <img src="<?php echo $hewan['gambar']; ?>" alt="Gambar Hewan" width="200px" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="crud.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
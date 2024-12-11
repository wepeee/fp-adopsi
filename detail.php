<?php
// Hubungkan ke database
include 'php/db_config.php'; // Pastikan file ini ada dan jalurnya benar

// Cek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data item berdasarkan ID
    $query = "SELECT * FROM item_hewan WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    // Cek jika data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $item = mysqli_fetch_assoc($result);
    } else {
        echo "Item tidak ditemukan.";
        exit;
    }
} else {
    echo "ID item tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Item Hewan</title>
    <!-- Link ke CSS Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
</head>

<body>
    <div class="container my-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-4">Detail Hewan: <?php echo $item['nama']; ?></h1>
            </div>
        </div>

        <!-- Grid layout -->
        <div class="row align-items-start">
            <!-- Card untuk foto dan nama -->
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $item['gambar']; ?>" class="card-img-top" alt="<?php echo $item['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo $item['nama']; ?></h5>
                    </div>
                </div>
            </div>

            <!-- Deskripsi di sebelah card -->
            <div class="col-md-8">
                <h3>Deskripsi</h3>
                <p><?php echo $item['deskripsi']; ?></p>

                <!-- Kembali ke halaman sebelumnya -->
                <a href="hewan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-7b1HbmQ1nxOHuHtcWzpAcsgTcqVYvPhb5t3T5GOPFuyllKfqJvWcLqnozKlzpxgV" crossorigin="anonymous"></script>
</body>

</html>

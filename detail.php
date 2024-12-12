<?php
// Hubungkan ke database
include 'php/db_config.php';
require 'fpdf/fpdf.php';

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

// PDF
if (isset($_GET['export']) && $_GET['export'] == 'pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Detail Hewan: ' . $item['nama'], 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, "Nama: " . $item['nama']);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 10, "Deskripsi: " . $item['deskripsi']);

    $pdf->Output('D', $item['nama'] . '_detail.pdf');
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
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $item['gambar']; ?>" class="card-img-top" alt="<?php echo $item['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo $item['nama']; ?></h5>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h3>Deskripsi</h3>
                <p><?php echo $item['deskripsi']; ?></p>

                <a href="detail.php?id=<?php echo $id; ?>&export=pdf" class="btn btn-primary">Export ke PDF</a>

                <!-- Kembali ke halaman sebelumnya -->
                <a href="hewan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-7b1HbmQ1nxOHuHtcWzpAcsgTcqVYvPhb5t3T5GOPFuyllKfqJvWcLqnozKlzpxgV" crossorigin="anonymous"></script>
</body>

</html>

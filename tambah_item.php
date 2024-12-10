<?php
// Hubungkan ke database
include 'php/db_config.php'; // Pastikan file ini ada dan jalurnya benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar'];

    // Validasi upload gambar
    $targetDir = "uploads/"; // Pastikan folder uploads ada di direktori yang sama dengan file PHP ini
    $targetFile = $targetDir . basename($gambar['name']);
    $uploadOk = 1;

    // Cek apakah file gambar
    if (!empty($gambar['tmp_name']) && file_exists($gambar['tmp_name'])) {
        $check = getimagesize($gambar['tmp_name']);
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
    } else {
        echo "Gambar tidak diunggah.";
        $uploadOk = 0;
    }

    // Batasi jenis file
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Upload file
    if ($uploadOk === 1 && move_uploaded_file($gambar['tmp_name'], $targetFile)) {
        // Simpan data ke database
        $query = "INSERT INTO item_hewan (nama, deskripsi, gambar) VALUES ('$nama', '$deskripsi', '$targetFile')";
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Item berhasil ditambahkan!');
                    window.location.href = 'hewan.php'; // Arahkan kembali ke halaman hewan.php
                  </script>";
        } else {
            echo "Gagal menambahkan item: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}

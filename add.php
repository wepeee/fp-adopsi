<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Hewan</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Tambah Item Hewan</h2>
        <form method="POST" action="./tambah_item.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Hewan</label>
                <input type="file" class="form-control" id="gambar" name="gambar" required>

            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Hewan</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Hewan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
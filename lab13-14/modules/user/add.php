<?php
// modules/user/add.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../views/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = $_POST['nama'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? 0;
    $harga_beli = $_POST['harga_beli'] ?? 0;
    $stok = $_POST['stok'] ?? 0;
    $gambar = '';

    // simple file upload handling if image provided
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
        $uploadDir = __DIR__ . '/../../assets/img/';
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $filename);
        $gambar = $filename;
    }

    $sql = "INSERT INTO data_barang (kategori,nama,gambar,harga_beli,harga_jual,stok) VALUES ('" . mysqli_real_escape_string($koneksi,$kategori) . "','" . mysqli_real_escape_string($koneksi,$nama) . "','" . mysqli_real_escape_string($koneksi,$gambar) . "'," . intval($harga_beli) . "," . intval($harga_jual) . "," . intval($stok) . ")";
    if(mysqli_query($koneksi, $sql)){
        header("Location: index.php?page=user/list");
        exit;
    } else {
        echo '<p>Gagal menyimpan: ' . mysqli_error($koneksi) . '</p>';
    }
}
?>
<h1>Tambah Barang</h1>

<a href="index.php?page=user/list" class="btn btn-secondary">
    ← Kembali ke List
</a>

<div class="form-wrapper">
<form method="post" enctype="multipart/form-data" class="form-card">

    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama" required>
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" required>
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" required>
    </div>

    <div class="form-group">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" required>
    </div>

    <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stok" required>
    </div>

    <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*">
    </div>

    <button class="btn btn-primary" type="submit">
        Simpan Data
    </button>

</form>
</div>

<?php require_once __DIR__ . '/../../views/footer.php'; ?>
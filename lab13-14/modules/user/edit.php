<?php
// modules/user/edit.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../views/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id <= 0){
    echo '<p>ID tidak valid</p>';
    require_once __DIR__ . '/../../views/footer.php';
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = $_POST['nama'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $harga_jual = intval($_POST['harga_jual'] ?? 0);
    $harga_beli = intval($_POST['harga_beli'] ?? 0);
    $stok = intval($_POST['stok'] ?? 0);

    // optional gambar update
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
        $uploadDir = __DIR__ . '/../../assets/img/';
        if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $filename);
        $gambar_sql = ", gambar='" . mysqli_real_escape_string($koneksi,$filename) . "'";
    } else {
        $gambar_sql = '';
    }

    $sql = "UPDATE data_barang SET kategori='" . mysqli_real_escape_string($koneksi,$kategori) . "', nama='" . mysqli_real_escape_string($koneksi,$nama) . "', harga_beli=" . $harga_beli . ", harga_jual=" . $harga_jual . ", stok=" . $stok . $gambar_sql . " WHERE id_barang=" . $id;
    if(mysqli_query($koneksi, $sql)){
       header("Location: index.php?page=user/list");
       exit;
    } else {
        echo '<p>Gagal update: ' . mysqli_error($koneksi) . '</p>';
    }
}

$res = mysqli_query($koneksi, "SELECT * FROM data_barang WHERE id_barang=" . $id);
$row = mysqli_fetch_assoc($res);
if(!$row){
    echo '<p>Data tidak ditemukan</p>';
    require_once __DIR__ . '/../../views/footer.php';
    exit;
}
?>
<h1>Ubah Barang</h1>

<a href="index.php?page=user/list" class="btn btn-secondary">
    ← Kembali ke List
</a>

<div class="form-wrapper">
<form method="post" enctype="multipart/form-data" class="form-card">

    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($row['nama']); ?>" required>
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori"
               value="<?= htmlspecialchars($row['kategori']); ?>" required>
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" name="harga_beli"
               value="<?= htmlspecialchars($row['harga_beli']); ?>" required>
    </div>

    <div class="form-group">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual"
               value="<?= htmlspecialchars($row['harga_jual']); ?>" required>
    </div>

    <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stok"
               value="<?= htmlspecialchars($row['stok']); ?>" required>
    </div>

    <div class="form-group">
        <label>Gambar <small>(biarkan kosong jika tidak ingin ganti)</small></label>
        <input type="file" name="gambar" accept="image/*">
    </div>

    <button class="btn btn-primary" type="submit">
        Simpan Perubahan
    </button>

</form>
</div>

<?php require_once __DIR__ . '/../../views/footer.php'; ?>
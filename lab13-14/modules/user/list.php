<?php
// modules/user/list.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../views/header.php';

/* ======================
   SEARCH & PAGINATION
====================== */
$per_page = 2;

$hal = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
if ($hal < 1) $hal = 1;

$offset = ($hal - 1) * $per_page;

// keyword pencarian
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';

// kondisi search
$where = '';
if (!empty($keyword)) {
    $where = "WHERE nama LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
}

// hitung total data (pakai WHERE juga)
$count_sql = "SELECT COUNT(*) AS total FROM data_barang $where";
$count_res = mysqli_query($koneksi, $count_sql);
$count_row = mysqli_fetch_assoc($count_res);
$total_data = $count_row['total'];

$total_halaman = ceil($total_data / $per_page);

// query data
$sql = "SELECT * FROM data_barang 
        $where
        ORDER BY id_barang ASC
        LIMIT $per_page OFFSET $offset";
$res = mysqli_query($koneksi, $sql);

?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Data Barang</h1>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="index.php?page=user/add" class="btn btn-primary btn-sm">
            Tambah Barang
        </a>
    <?php endif; ?>
</div>


<form method="get" class="search-form">
    <input type="hidden" name="page" value="user/list">
    <input 
        type="text" 
        name="keyword" 
        placeholder="Cari nama / kategori..."
        value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
        class="form-control"
    >
    <button type="submit" class="btn">
        <i class="fas fa-search"></i> Cari
    </button>
    <?php if (!empty($_GET['keyword'])): ?>
        <a href="index.php?page=user/list" class="btn" style="background: #f0f0f0; color: #666; text-decoration: none;">
            <i class="fas fa-times"></i> Reset
        </a>
    <?php endif; ?>
</form>


<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
    <tr>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga Jual</th>
        <th>Harga Beli</th>
        <th>Stok</th>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <th>Aksi</th>
        <?php endif; ?>
    </tr>
    </thead>

<tbody>
<?php
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';

        echo '<td>' . (!empty($row['gambar']) 
            ? '<img src="assets/img/' . htmlspecialchars($row['gambar']) . '" style="max-width:80px;">' 
            : '') . '</td>';

        echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
        echo '<td>' . htmlspecialchars($row['kategori']) . '</td>';
        echo '<td>' . htmlspecialchars($row['harga_jual']) . '</td>';
        echo '<td>' . htmlspecialchars($row['harga_beli']) . '</td>';
        echo '<td>' . htmlspecialchars($row['stok']) . '</td>';

        // 👉 AKSI HANYA UNTUK ADMIN
        if ($_SESSION['role'] === 'admin') {
            echo '<td class="actions">
                    <a href="index.php?page=user/edit&id=' . $row['id_barang'] . '" 
                       class="btn btn-warning btn-sm">Ubah</a>
                    <a href="index.php?page=user/delete&id=' . $row['id_barang'] . '" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm(\'Hapus data?\')">Hapus</a>
                  </td>';
        }

        echo '</tr>';
    }
} else {
    $colspan = ($_SESSION['role'] === 'admin') ? 7 : 6;
    echo '<tr><td colspan="'.$colspan.'">Tidak ada data.</td></tr>';
}
?>
</tbody>

</table>
</div>

<!-- PAGINATION -->
<nav>
<ul class="pagination pagination-sm">

<?php if ($hal > 1): ?>
<li class="page-item">
    <a class="page-link"
       href="index.php?page=user/list&hal=<?= $hal-1 ?>&keyword=<?= urlencode($keyword) ?>">
       Previous
    </a>
</li>
<?php endif; ?>

<?php for ($i=1; $i<=$total_halaman; $i++): ?>
<li class="page-item <?= $i==$hal?'active':'' ?>">
    <a class="page-link"
       href="index.php?page=user/list&hal=<?= $i ?>&keyword=<?= urlencode($keyword) ?>">
       <?= $i ?>
    </a>
</li>
<?php endfor; ?>

<?php if ($hal < $total_halaman): ?>
<li class="page-item">
    <a class="page-link"
       href="index.php?page=user/list&hal=<?= $hal+1 ?>&keyword=<?= urlencode($keyword) ?>">
       Next
    </a>
</li>
<?php endif; ?>

</ul>
</nav>



<?php require_once __DIR__ . '/../../views/footer.php'; ?>
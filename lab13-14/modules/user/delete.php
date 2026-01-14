<?php
// modules/user/delete.php
require_once __DIR__ . '/../../config/database.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id > 0){
    mysqli_query($koneksi, "DELETE FROM data_barang WHERE id_barang=" . $id);
}
header("Location: index.php?page=user/list");
exit;
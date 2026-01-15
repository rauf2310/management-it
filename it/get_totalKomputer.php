<?php
require 'function.php'; // Memanggil koneksi $conn

// Query untuk menjumlahkan semua stok di tabel stok barang
// Sesuaikan 'jumlah' dengan nama kolom stok Anda
$qkomputer = mysqli_query($c, "SELECT COUNT(idkom) as idkom FROM tbl_komputer");
$data = mysqli_fetch_array($qkomputer);
echo ($data['idkom'] > 0) ? $data['idkom'] : 0;
?>
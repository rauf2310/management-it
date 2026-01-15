<?php
require 'function.php'; // Memanggil koneksi $conn

// Query untuk menjumlahkan semua stok di tabel stok barang
// Sesuaikan 'jumlah' dengan nama kolom stok Anda
$qbarang = mysqli_query($c, "SELECT SUM(jumlah) as jumlah FROM tbl_stock");
$data = mysqli_fetch_array($qbarang);
echo ($data['jumlah'] > 0) ? $data['jumlah'] : 0;
?>
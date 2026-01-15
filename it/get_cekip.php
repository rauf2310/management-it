<?php
// Ganti sesuai dengan file koneksi Anda
include "koneksi.php";

// Cek koneksi
if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// GANTI NAMA KOLOM & TABEL DI BAWAH INI SESUAI DATABASE ANDA
$sql = "
    SELECT ip_komputer as ip FROM tbl_komputer WHERE ip_komputer != ''
    UNION
    SELECT ip_printer as ip FROM tbl_printer WHERE ip_printer != ''
    UNION
    SELECT ip_dvr as ip FROM tbl_dvr WHERE ip_dvr != ''
";

$query = mysqli_query($c, $sql);

if (!$query) {
    die("Error Query: " . mysqli_error($c));
}

$hasil = [];
while ($row = mysqli_fetch_assoc($query)) {
    $hasil[] = $row['ip'];
}

// Tampilkan untuk tes
header('Content-Type: application/json');
echo json_encode($hasil);

<?php
// 1 .LOGIKA REFRESH 5 DETIK UNTUK INDEX.PHP KELP IT
require 'ceklogin.php';
$queryTotal = mysqli_query($c, "SELECT COUNT(idmasalah) AS total FROM tbl_masalah");
$dataTotal  = mysqli_fetch_assoc($queryTotal);
echo $dataTotal['total'] ?? 0;
?>
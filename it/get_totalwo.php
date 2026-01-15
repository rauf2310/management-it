<?php 
require "function.php";// mengambil koneksi $c

$qwo = mysqli_query($c, "SELECT COUNT(idmis) as idmis FROM tbl_mis");
$data = mysqli_fetch_array($qwo);
echo ($data['idmis']> 0) ? $data['idmis'] : 0;
?>
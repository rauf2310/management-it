<?php
require 'ceklogin.php'; 

// 1. Ambil Total untuk Badge (Jika ingin disatukan)
$queryTotal = mysqli_query($c, "SELECT COUNT(idmasalah) AS total FROM tbl_masalah");
$dataTotal  = mysqli_fetch_assoc($queryTotal);
$total_angka = $dataTotal['total'] ?? 0;

// 2. Ambil Data Tabel
$get = mysqli_query($c, "SELECT * FROM tbl_masalah ORDER BY idmasalah DESC");
$i = 1;
$html_tabel = "";

while ($p = mysqli_fetch_array($get)) {
    $idm     = $p['idmasalah'];
    $nama    = $p['nuser'];
    $bagian  = strtoupper($p['nbagian']);
    $problem = $p['problem'];
    $waktu   = date('d M Y, H:i', strtotime($p['datetime']));

    $html_tabel .= "
    <tr>
        <td>" . $i++ . "</td>
        <td class='fw-bold text-dark'>$nama</td>
        <td> 
            <span class='badge bg-light text-primary border border-primary px-3 py-2'>$bagian</span>
        </td>
        <td>$problem</td>
        <td>
            <small class='text-muted'><i class='far fa-clock me-1'></i>$waktu</small>
        </td>
        <td class='no-print text-center'>
            <a href='mis.php?id=$idm' class='btn btn-primary btn-sm rounded-pill px-4 shadow-sm text-decoration-none'>
                <i class='fas fa-tools me-1'></i> Kerjakan
            </a>
        </td>
    </tr>";
}

// Kirim hasil dalam format JSON agar bisa dibaca JavaScript
echo json_encode([
    'total' => $total_angka,
    'tabel' => $html_tabel
]);
?>
<?php
// 1. Matikan tampilan error ke layar agar tidak mengotori file Excel
error_reporting(0);
ini_set('display_errors', 0);

// 2. Mulai output buffering untuk memastikan tidak ada spasi bocor
ob_start();

include "function.php";

$type  = $_GET['type'] ?? '';
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

// ... logika query tetap sama ...
if ($type == 'komputer') {
    $sql = "SELECT * FROM tbl_komputer";
    $filename = "Laporan_Aset_Komputer";
} elseif ($type == 'printer') {
    $sql = "SELECT * FROM tbl_printer";
    $filename = "Laporan_Aset_Printer";
} elseif ($type == 'dvr') {
    $sql = "SELECT * FROM tbl_dvr";
    $filename = "Laporan_Aset_DVR & NVR";
} elseif ($type == 'laptop') {
    $sql = "SELECT * FROM tbl_laptop";
    $filename = "Laporan_Aset_Laptop";
} elseif ($type == 'router') {
    $sql = "SELECT * FROM tbl_router";
    $filename = "Laporan_Aset_Router";
} else {
    exit;
}

if (!empty($start) && !empty($end)) {
    $sql .= " WHERE tgl_update BETWEEN '$start' AND '$end'";
}

$query = mysqli_query($c, $sql);

// 3. Bersihkan buffer jika ada output yang tidak sengaja keluar sebelumnya
ob_end_clean();

// 4. Header Ekspor
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
?>
<table border="1">
    <thead>
        <tr>
            <th style="background-color: #d3d3d3; font-weight: bold;">No</th>
            <?php
            $fields = mysqli_fetch_fields($query);
            foreach ($fields as $field) {
                // LOGIKA: Jika nama kolom mengandung kata 'id', maka lewati (Skip)
                if (stripos($field->name, 'id') !== false) continue;

                $label = strtoupper(str_replace('_', ' ', $field->name));
                echo "<th style='background-color: #d3d3d3; font-weight: bold;'>" . $label . "</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td align='center'>" . $no++ . "</td>";
            foreach ($row as $key => $value) {
                // LOGIKA: Lewati kolom yang mengandung kata 'id'
                if (stripos($key, 'id') !== false) continue;

                // Pastikan IP Address tetap terbaca sebagai teks di Excel
                $style = (stripos($key, 'ip') !== false) ? "style='mso-number-format:\"\@\";'" : "";

                echo "<td $style>" . htmlspecialchars($value ?? '-') . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php
require 'ceklogin.php';

// Ambil total jumlah total wo
$queryTotal = mysqli_query($c, "SELECT COUNT(idmis) AS total FROM tbl_mis");
$dataTotal  = mysqli_fetch_assoc($queryTotal);
$totalBarangM = $dataTotal['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Detail Work Order | PT.CMBP</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesdetWo.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body class="sb-nav-fixed bg-light">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                        <div>
                            <h1 class="fw-bold text-dark h2">📊 Detail Work Order</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Work Order</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="index.php" class="btn bg-warning rounded-pill px-4"><i class="fas fa-home me-2"></i> Beranda</a>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card border-0 shadow-sm border-start border-primary border-4">
                                <div class="card-body p-4">
                                    <div class="small text-muted text-uppercase fw-bold">Total Pekerjaan</div>
                                    <div class="h2 fw-bold mb-0 text-primary"><?= number_format($totalBarangM); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card mb-5 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-table me-2 text-primary"></i>Rincian Log Aktivitas Work Order
                            </h5>
                            <button onclick="exportToExcel()" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                <i class="fas fa-file-excel me-2"></i>Ekspor Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User / Dept</th>
                                        <th>Masalah</th>
                                        <th>CM/PM</th>
                                        <th>H/S/N/A</th>
                                        <th>Perangkat</th>
                                        <th>Uraian</th>
                                        <th>Waktu Pengerjaan</th>
                                        <th>Teknisi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get = mysqli_query($c, "SELECT * FROM tbl_mis ORDER BY idmis DESC");
                                    $i = 1;
                                    while ($p = mysqli_fetch_array($get)) {
                                        $idmis   = $p['idmis'];
                                        $user    = $p['user'];
                                        $dept    = $p['departement'];
                                        $prob    = $p['problem'];
                                        $cm_pm   = $p['cm_pm'];
                                        $hsna    = $p['kategori'];
                                        $pkjc    = $p['hardware'];
                                        $uraian  = $p['pengerjaan'];
                                        $mulai   = $p['mulai'];
                                        $selesai = $p['selesai'];
                                        $teknisi = $p['nama'] ?? '-';
                                        $status  = $p['status'] ?? 'Selesai';

                                        // Hitung Work Time
                                        $display_time = "0 Menit";
                                        if (!empty($mulai) && !empty($selesai)) {
                                            $diff = strtotime($selesai) - strtotime($mulai);
                                            $minutes = floor($diff / 60);
                                            $display_time = ($minutes > 60) ? floor($minutes / 60) . " Jam " . ($minutes % 60) . " Menit" : $minutes . " Menit";
                                        }
                                    ?>
                                        <tr>
                                            <td><span class="text-muted fw-bold"><?= $i++ ?></span></td>
                                            <td>
                                                <div class="fw-bold"><?= $user ?></div>
                                                <div class="small text-muted"><?= $dept ?></div>
                                            </td>
                                            <td style="vertical-align: top;">
                                                <div style="white-space: normal; word-break: break-word;">
                                                    <?= $prob ?>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-type"><?= $cm_pm ?></span></td>
                                            <td><span class="badge bg-light text-dark border"><?= $hsna ?></span></td>
                                            <td><span class="badge bg-light text-dark border"><?= $pkjc ?></span></td>
                                            <td style="vertical-align: top;">
                                                <div style="white-space: normal; word-break: break-word;">
                                                    <?= $uraian ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="small"><i class="far fa-play-circle text-success me-1"></i><?= date('d/m H:i', strtotime($mulai)) ?></div>
                                                <div class="small"><i class="far fa-check-circle text-danger me-1"></i><?= date('d/m H:i', strtotime($selesai)) ?></div>
                                                <div class="fw-bold mt-1" style="font-size: 0.75rem;">⏱ <?= $display_time ?></div>
                                            </td>
                                            <td><span class="fw-semibold"><?= $teknisi ?></span></td>
                                            <td>
                                                <?php
                                                $badgeClass = ($status == 'Selesai') ? 'bg-success' : 'bg-warning text-dark';
                                                echo "<span class='badge rounded-pill $badgeClass px-3'>$status</span>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });

        // untuk export Excel
        function exportToExcel() {
            // 1. Ambil tabel asli
            const originalTable = document.getElementById("datatablesSimple");

            // 2. Buat duplikat tabel agar tidak merusak tampilan web
            const tempTable = originalTable.cloneNode(true);

            // 3. Cari semua baris di tabel duplikat
            const rows = tempTable.querySelectorAll('tr');

            rows.forEach(row => {
                // Targetkan kolom "Waktu Pengerjaan" (index ke-7, hitungan mulai dari 0)
                const timeCell = row.cells[7];

                if (timeCell) {
                    // Ambil semua elemen div di dalam sel waktu
                    const divs = timeCell.querySelectorAll('div');
                    if (divs.length >= 3) {
                        const mulai = divs[0].innerText.trim();
                        const selesai = divs[1].innerText.trim();
                        const durasi = divs[2].innerText.replace('⏱', '').trim();

                        // Gabungkan dengan pemisah strip
                        timeCell.innerText = mulai + " - " + selesai + " - " + durasi;
                    }
                }

                // 4. Hapus semua icon (i) dan teks "Font Awesome" di seluruh sel
                const allCells = row.querySelectorAll('td');
                allCells.forEach(td => {
                    const icons = td.querySelectorAll('i');
                    icons.forEach(icon => icon.remove());

                    // Bersihkan sisa teks Font Awesome jika masih ada
                    if (td.innerText.includes("Font Awesome")) {
                        td.innerText = td.innerText.replace(/Font Awesome fontawesome\.com/g, "");
                    }
                });
            });

            // 5. Ekspor ke Excel
            const wb = XLSX.utils.table_to_book(tempTable, {
                sheet: "Work Order"
            });
            const date = new Date().toISOString().slice(0, 10);
            XLSX.writeFile(wb, "Detail_Work_Order_" + date + ".xlsx");
        }
    </script>
</body>

</html>
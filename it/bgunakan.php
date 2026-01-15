<?php
require "ceklogin.php";
// Pastikan variabel koneksi $c sudah ada di sini atau include file koneksi
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemakaian Barang - MIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/stylesbgunakan.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/img/logo1.png" alt="Logo PT CMBP" height="40" class="d-inline-block align-top me-2">
                <span class="brand-text">PT CMBP</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="index.php" class="btn btn-light rounded-pill px-4 me-2">
                    <i class="fas fa-home me-2"></i>Beranda
                </a>
                <a href="logout.php" class="btn btn-outline-danger rounded-pill px-4">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-7 text-center text-md-start">
                <h2 class="fw-bold m-0" style="letter-spacing: -1px;">Log Pemakaian Barang</h2>
                <p class="text-muted m-0">Rincian aktivitas penggunaan aset dan material teknisi.</p>
            </div>
            <div class="col-md-5 text-center text-md-end mt-3 mt-md-0">
                <?php
                // Menghitung total barang keluar
                $count_query = mysqli_query($c, "SELECT SUM(jumlah) as total FROM tbl_mis WHERE barangpakai != ''");
                $count_res = mysqli_fetch_assoc($count_query);
                ?>
                <div class="total-badge shadow-sm">
                    <i class="fas fa-boxes me-2"></i>Total pemakaian barang: <?= $count_res['total'] ?? 0 ?> Unit
                </div>
            </div>
        </div>

        <div class="card card-custom border-0 shadow-sm">

            <!-- BUTTON CETAK PRINT -->
            <div class="card-header bg-white py-4 px-4 border-bottom border-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold m-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Work Order</h5>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light border btn-print px-3" onclick="window.print()">
                            <i class="fas fa-print me-1 text-secondary"></i> Cetak Laporan
                        </button>
                        <button class="btn btn-sm btn-success border px-3" onclick="exportToExcelFormal()">
                            <i class="fas fa-file-excel me-1"></i> Ekspor Excel
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th class="ps-4 text-center">No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Keperluan / Pengerjaan</th>
                                <th>Teknisi</th>
                                <th>Waktu Input</th>
                                <th class="text-center pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query difilter agar hanya menampilkan yang ada nama barangnya
                            $get = mysqli_query($c, "SELECT * FROM tbl_mis WHERE barangpakai IS NOT NULL AND barangpakai <> '' ORDER BY idmis DESC");
                            $i = 1;

                            if (mysqli_num_rows($get) > 0) {
                                while ($p = mysqli_fetch_array($get)) {
                            ?>
                                    <tr>
                                        <td class="ps-4 text-center fw-bold text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($p['barangpakai']) ?></div>
                                            <small class="text-muted text-uppercase" style="font-size: 10px;">Item Terdata</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                                                <?= htmlspecialchars($p['jumlah']) ?> <small>Unit</small>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="badge-keperluan d-inline-block shadow-sm">
                                                <i class="fas fa-toolbox me-1 small"></i> <?= htmlspecialchars($p['pengerjaan']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    <i class="fas fa-user small"></i>
                                                </div>
                                                <span class="small fw-semibold"><?= htmlspecialchars($p['nama']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark"><?= date('d M Y', strtotime($p['datetimem'])) ?></div>
                                            <div class="text-muted" style="font-size: 11px;"><i class="far fa-clock me-1"></i><?= date('H:i', strtotime($p['datetimem'])) ?> WIB</div>
                                        </td>
                                        <td class="text-center pe-4 text-success">
                                            <i class="fas fa-check-double shadow-sm p-2 bg-success bg-opacity-10 rounded-circle" style="font-size: 12px;"></i>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center py-5'><img src='assets/img/empty.png' height='80' class='mb-3 d-block mx-auto opacity-50'><span class='text-muted'>Tidak ada catatan pemakaian barang hari ini.</span></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function exportToExcelFormal() {
            const table = document.getElementById("datatablesSimple");
            if (!table) {
                console.error("Tabel tidak ditemukan");
                return;
            }

            const rows = Array.from(table.querySelectorAll('tr'));

            const data = rows.map((row, rowIndex) => {
                // Ambil semua cell kecuali kolom terakhir (Aksi)
                const cells = Array.from(row.cells).slice(0, -1);

                return cells.map(cell => {
                    // 1. Ambil teks dan bersihkan spasi di ujung
                    let text = cell.innerText.trim();

                    // 2. Hapus baris baru/Enter dan karakter aneh lainnya
                    text = text.replace(/[\r\n\x0B\x0C\x85]/g, ' ');

                    // 3. FIX KHUSUS TANGGAL: Pisahkan tahun dan jam jika menempel
                    // Contoh: "202518:00" -> "2025 18:00"
                    text = text.replace(/(\d{4})(\d{2}:\d{2})/, '$1 $2');

                    // 4. Pastikan kata "WIB" dipisahkan spasi jika menempel
                    text = text.replace(/(\d{2}:\d{2})(WIB)/, '$1 $2');

                    // 5. Bersihkan spasi ganda menjadi spasi tunggal
                    return text.replace(/\s+/g, ' ').trim();
                });
            });

            // Buat Workbook & Sheet
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);

            // PENGATURAN LEBAR KOLOM (Sangat Penting untuk Kerapihan)
            // Sesuaikan indeks kolom (0, 1, 2...) dengan urutan tabel Anda
            const colWidths = [{
                    wch: 6
                }, // Kolom 0 (No)
                {
                    wch: 30
                }, // Kolom 1 (Waktu Input) -> Dibuat lebar agar satu baris
                {
                    wch: 25
                }, // Kolom 2
                {
                    wch: 20
                }, // Kolom 3
                {
                    wch: 20
                } // Kolom 4
            ];
            ws['!cols'] = colWidths;

            // Tambahkan ke Workbook
            XLSX.utils.book_append_sheet(wb, ws, "Log Laporan");

            // Penamaan file dengan tanggal hari ini
            const today = new Date().toISOString().slice(0, 10);
            const filename = `Laporan_MIS_CMBP_${today}.xlsx`;

            // Download File
            XLSX.writeFile(wb, filename);
        }
    </script>
</body>

</html>
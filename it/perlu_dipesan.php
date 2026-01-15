<?php
require 'ceklogin.php';

// --- LOGIKA UPDATE (Paling Atas) ---
if (isset($_POST['simpan_batas'])) {
    $nama_barang = mysqli_real_escape_string($c, $_POST['nama_barang_target']);
    $angka_baru = mysqli_real_escape_string($c, $_POST['angka_baru']);

    $update = mysqli_query($c, "UPDATE tbl_stock SET stock_min = '$angka_baru' WHERE nmbarang = '$nama_barang'");

    if ($update) {
        header("Location: perlu_dipesan.php"); // Redirect agar form tidak terkirim ulang saat refresh
        exit();
    }
}

$query = "SELECT * FROM tbl_stock ORDER BY nmbarang ASC";
$ambil_stok = mysqli_query($c, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Perlu Dipesan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="stylesPdipesan.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container py-5">
        <div class="glass-card shadow">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
                <div>
                    <h2 class="fw-bold text-white mb-1">Stock Optimization</h2>
                    <p class="text-white-50 mb-0 small">Kelola ambang batas stok barang secara dinamis.</p>
                </div>

                <div class="search-container d-flex align-items-center gap-2">
                    <a href="index.php" class="btn-home-glass" title="Kembali ke Beranda">
                        <i class="fas fa-home"></i>
                    </a>

                    <div class="search-box flex-grow-1">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="form-control-glass" placeholder="Cari barang / status">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table-glass w-100">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start">Informasi Barang</th>
                            <th>Stok Saat Ini</th>
                            <th>Batas Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $modals = ""; // Variabel penampung modal agar tidak merusak tabel
                        while ($row = mysqli_fetch_array($ambil_stok)):
                            $no++;
                            $stok = $row['jumlah'];
                            $batas = $row['stock_min'] ?? 2;
                            $nmbarang = $row['nmbarang'];

                            if ($stok <= 0) {
                                $pill = "pill-danger";
                                $status_txt = "Habis Total";
                            } elseif ($stok <= $batas) {
                                $pill = "pill-warning";
                                $status_txt = "Perlu Dipesan";
                            } else {
                                $pill = "pill-success";
                                $status_txt = "Stok Aman";
                            }

                            // --- Simpan kode modal ke variabel untuk ditampilkan di luar tabel nanti ---
                            ob_start(); ?>
                            <div class="modal fade" id="modalMin<?= $no; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content border-0">
                                        <form method="POST">
                                            <div class="modal-header border-0 pb-0">
                                                <h6 class="modal-title fw-bold text-dark">Set Minimum Limit</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-muted small mb-3"><?= htmlspecialchars($nmbarang); ?></p>
                                                <input type="hidden" name="nama_barang_target" value="<?= htmlspecialchars($nmbarang); ?>">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold text-dark text-start d-block">Batas Baru</label>
                                                    <input type="number" name="angka_baru" class="form-control-modern text-center" value="<?= $batas; ?>" min="0">
                                                </div>
                                                <button type="submit" name="simpan_batas" class="btn-save w-100">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $modals .= ob_get_clean();
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-white"><?= htmlspecialchars($nmbarang); ?></div>
                                </td>
                                <td class="text-center text-white">
                                    <span class="fs-5 fw-bold"><?= $stok; ?></span>
                                    <small class="text-white-50 ms-1">Unit</small>
                                </td>
                                <td class="text-center">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalMin<?= $no; ?>" class="btn badge-edit-min border-0">
                                        <span><?= $batas; ?></span>
                                        <i class="fas fa-pen-nib ms-2"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="status-pill <?= $pill; ?>">
                                        <i class="fas fa-circle me-1 small"></i> <?= $status_txt; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalContainer">
        <?= $modals; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>

</html>
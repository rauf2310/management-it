<?php
require 'ceklogin.php';

// Ambil total jumlah unit barang
$queryTotal = mysqli_query($c, "SELECT SUM(jumlah) AS total FROM tbl_stock");
$dataTotal  = mysqli_fetch_assoc($queryTotal);
$totalBarangM = $dataTotal['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Stock Barang | PT CMBP</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesbmasuk.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

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

    <div class="container mt-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-7">
                <h1 class="display-6 fw-bold mb-1">Manajemen Stok <span class="text-primary">Barang</span></h1>
                <p class="text-muted mb-0">Kelola dan pantau persediaan barang masuk secara real-time.</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end gap-2">
                    <button class="btn btn-primary btn-lg shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        <i class="fas fa-plus me-2"></i>Tambah Barang Baru
                    </button>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="small text-muted text-uppercase fw-bold mb-1">Total Unit Tersedia</div>
                    <div class="h2 fw-800 mb-0"><?= number_format($totalBarangM); ?> <span class="fs-6 text-muted fw-normal">Unit</span></div>
                </div>
            </div>
        </div>

        <div class="glass-card mb-5">
            <div class="p-4 border-bottom bg-white">
                <h5 class="mb-0 fw-bold"><i class="fas fa-table me-2 text-primary"></i>Rincian Inventory</h5>
            </div>
            <div class="p-0">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama & Merek</th>
                                <th>Stok</th>
                                <th>Tgl Masuk</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $get = mysqli_query($c, "SELECT * FROM tbl_stock ORDER BY idstock DESC");
                            $i = 1;
                            while ($p = mysqli_fetch_array($get)) {
                                $idstock = $p['idstock'];
                                $nmbarang = $p['nmbarang'];
                                $jumlah = $p['jumlah'];
                                $datetime = $p['datetime'];
                            ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted"><?= $i++ ?></td>
                                    <td class="fw-bold text-dark"><?= $nmbarang ?></td>
                                    <td><span class="status-badge"><?= $jumlah ?> Unit</span></td>
                                    <td><i class="far fa-calendar-alt me-2 text-muted"></i><?= date('d M Y', strtotime($datetime)) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#edit<?= $idstock ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#delete<?= $idstock ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 px-4 pt-4">
                    <h5 class="fw-bold">Tambah Unit Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body px-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama & Merek Barang</label>
                            <input type="text" name="nmbarang" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: Monitor Dell 24 Inch" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jumlah Unit</label>
                            <input type="number" name="jumlah" class="form-control form-control-lg bg-light border-0" placeholder="0" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light btn-modern w-100 mb-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambahbarangbaru" class="btn btn-add btn-modern w-100">Simpan Data</button>
                    </div>
                </form>
            </div>
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
    </script>
</body>

</html>
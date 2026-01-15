<?php
require "ceklogin.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Dashboard | </title>
    <link rel="icon" type="image/png" href="assets/img/logo1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="css/stylesindexx.css" rel="stylesheet" />
</head>

<body>
    <div class="bg-glow"></div>

    <div class="container py-5">
        <header class="mb-4">
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">
                    <img src="assets/img/logo1.png" alt="Logo" style="height: 100px;" class="me-3">
                    <div>
                        <h1 class="fw-bold text-white mb-0">
                            MIS / IT <span class="text-warning ms-3">PT.CMBP</span>
                        </h1>
                        <p class="text-white-50 mb-0">Sistem Manajemen Aset & Infrastruktur</p>
                    </div>
                </div>

                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Keluar</span>
                </a>
            </div>

            <hr class="border-secondary mt-4 opacity-25">
        </header>

        <section class="mb-5">
            <h5 class="section-title"><i class="fas fa-microchip"></i> Aset & Infrastruktur Details</h5>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="detAset.php" class="menu-card primary">
                        <div class="icon-box"><i class="fas fa-desktop"></i></div>
                        <div class="card-content">
                            <h3>Detail ASET & IP</h3>
                            <p>Monitoring Semua Aset dan IP</p>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="detDVR.php" class="menu-card secondary">
                        <div class="icon-box"><i class="fas fa-video"></i></div>
                        <div class="card-content">
                            <h3>Details DVR & CCTV</h3>
                            <p>Monitoring titik kamera & penyimpanan</p>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="infrastruktur.php" class="menu-card dark">
                        <div class="icon-box"><i class="fas fa-network-wired"></i></div>
                        <div class="card-content">
                            <h3 class="fw-bold text-white">Infrastruktur IT</h3>
                            <p class="text-white-50">Ekosistem Jaringan & Server Perusahaan</p>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h5 class="section-title"><i class="fas fa-clipboard-list"></i> IT / MIS</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
                    </div>
                    <a href="detMasalah.php" class="service-card danger">
                        <div class="d-flex align-items-center gap-4">
                            <div class="icon-circle"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <h4>Request Detail Masalah</h4>
                                <p>Laporan Masuk Request masalah</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="detWo.php" class="service-card success">
                        <div class="d-flex align-items-center gap-4">
                            <div class="icon-circle"><i class="fas fa-tools"></i></div>
                            <div>
                                <h4>Detail Work Order</h4>
                                <p>Report maintenance & perbaikan</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section>
            <h5 class="section-title"><i class="fas fa-boxes-stacked"></i> penyimpanan & Stock Control</h5>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="bmasuk.php" class="stock-card">
                        <i class="fas fa-warehouse"></i>
                        <span>Stock Barang</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="bgunakan.php" class="stock-card">
                        <i class="fas fa-boxes"></i>
                        <span>Barang Digunakan</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="perlu_dipesan.php" class="stock-card warning">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Perlu Dipesan</span>
                        <div class="notif-dot"></div>
                    </a>
                </div>
            </div>
        </section>
    </div>

</body>

</html>
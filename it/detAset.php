<?php
require "ceklogin.php";


?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data KOMPUTER | PT.CMBP</title>
    <link rel="icon" type="image/png" href="assets/img/logo1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/stylesaset.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>

<body>
    <div class="parallax-bg"></div>

    <div class="container">
        <header class="mb-5 header-vscode">
            <div class="d-flex align-items-center p-4 container-glass">
                <div class="logo-wrapper me-4">
                    <img src="assets/img/logo1.png" alt="Logo" style="height: 85px;" class="logo-3d">
                </div>

                <div class="header-content">
                    <h1 class="fw-bold mt-2 text-white tracking-tight">
                        <i class="fas fa-server text-info-glow"></i>
                        DATA ASET IT <span class="brand-gold">PT.CMBP</span>
                    </h1>
                    <div class="d-flex align-items-center mt-2">
                        <div class="status-indicator">
                            <span class="status-dot"></span>
                            <span class="status-text">SYSTEM CONNECTED</span>
                        </div>
                        <div class="divider-vertical"></div>
                        <p class="text-white-50 mb-0 font-monospace small">Monitoring Spesifikasi Hardware & Jaringan IT</p>
                    </div>
                </div>

                <div class="ms-auto vscode-decor">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </header>

        <div class="d-flex flex-wrap align-items-center justify-content-between ">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <button class=" btn btn-search-premium fw-bold d-flex align-items-center gap-2"
                    onclick="cekIpTersedia()">
                    <i class="fas fa-search-location"></i>
                    <span>Cari IP yang Belum Dipakai</span>

                </button>
                <a href="detAset.php" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; border-radius: 8px;">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="prosesCetakMasal()">
                    <i class="fas fa-print"></i> Cetak QRcode Terpilih
                </button>
                <button type="button" class="btn btn-outline-success btn-sm px-3" onclick="exportData('komputer')">
                    <i class="fas fa-desktop me-1"></i> Komputer
                </button>

                <button type="button" class="btn btn-outline-success btn-sm px-3" onclick="exportData('printer')">
                    <i class="fas fa-print me-1"></i> Printer
                </button>

                <button type="button" class="btn btn-outline-success btn-sm px-3" onclick="exportData('dvr')">
                    <i class="fas fa-video me-1"></i> DVR
                </button>

                <button type="button" class="btn btn-outline-success btn-sm px-3" onclick="exportData('laptop')">
                    <i class="fas fa-laptop me-1"></i> Laptop
                </button>

                <button type="button" class="btn btn-outline-success btn-sm px-3" onclick="exportData('router')">
                    <i class="fas fa-network-wired me-1"></i> Router
                </button>
            </div>
        </div>

        <div id="hasilCekIp" class="mt-3 mb-3 d-none">
            <div class="card bg-dark border-info">
                <div class="card-header text-info fw-bold">Daftar IP yang Kosong (Tersedia):</div>
                <div class="card-body">
                    <div id="listIpKosong" class="d-flex flex-wrap gap-2 text-white"></div>
                </div>
            </div>
        </div>

        <form method="POST">
            <div class="top-bar">
                <div class="search-wrapper">

                    <div class="search-input-group">
                        <label class="text-dim mb-1 small"><i class="fas fa-search me-1"></i> Pencarian</label>
                        <input type="text" id="searchInput" onkeyup="resetAndSearch()" placeholder="Cari data...">
                    </div>

                    <div class="filter-date-item" style="width: 100px;">
                        <label class="small">Tampilkan</label>
                        <select id="entriesPerPage" class="form-select input-date-custom" onchange="initPagination()">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <form method="GET" action="" class="mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="filter-date-item">
                                <label class="d-block small fw-bold"><i class="fas fa-calendar-alt"></i> Dari</label>
                                <input type="date" name="dateStart" class="input-date-custom" value="<?= $dateStart ?>">
                            </div>

                            <div class="filter-date-item">
                                <label class="d-block small fw-bold"><i class="fas fa-calendar-check"></i> Sampai</label>
                                <input type="date" name="dateEnd" class="input-date-custom" value="<?= $dateEnd ?>">
                            </div>

                            <div class="pt-3">
                                <button type="submit" class="btn-save-gradient" style="height: 40px; border-radius: 8px; padding: 0 20px; border: none; font-weight: bold; background: #0284c7; color: white;">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>

                                <?php if (!empty($dateStart)): ?>
                                    <a href="detAset.php" class="btn btn-sm btn-light border ms-2">Reset</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($dateStart) && !empty($dateEnd)): ?>
                            <div class="alert alert-primary py-2 px-3 mt-3" style="border-radius: 10px; border: none; background: #e0f2fe; color: #0369a1; display: inline-block;">
                                <i class="fas fa-info-circle me-2"></i>
                                Data Periode: <strong><?= date('d M Y', strtotime($dateStart)) ?></strong> - <strong><?= date('d M Y', strtotime($dateEnd)) ?></strong>
                                <a href="detAset.php" class="ms-2 text-decoration-none" style="color: #0369a1;"><i class="fas fa-times-circle"></i></a>
                            </div>
                        <?php endif; ?>
                    </form>

                    <a href="detAset.php" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 45px; width: 45px; border-radius: 10px;">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>



                <div class="action-buttons">
                    <button type="button"
                        class="btn btn-save-gradient px-3"
                        title="Tambah Asset Baru"
                        data-bs-toggle="modal"
                        data-bs-target="#modalPilihan"
                        style="height: 45px; border-radius: 10px;">
                        <i class="fas fa-plus"></i>
                    </button>

                    <a href="index.php" class="btn btn-outline-light px-3 d-flex align-items-center" style="height: 45px; border-radius: 10px;">
                        <i class="fas fa-home"></i>
                    </a>
                </div>
            </div>
        </form>

        <div class="table-wrapper mt-4">
            <table id="itTable" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>
                            ✔️
                        </th>
                        <th>No</th>
                        <th>Identitas</th>
                        <th>perangkat & Network</th>
                        <th>Device</th>
                        <th>Hardware & Spesifikasi</th>
                        <th>Tambahan & Kategori</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ambil input tanggal
                    $dateStart = isset($_GET['dateStart']) ? mysqli_real_escape_string($c, $_GET['dateStart']) : '';
                    $dateEnd   = isset($_GET['dateEnd']) ? mysqli_real_escape_string($c, $_GET['dateEnd']) : '';

                    $filterSql = "";
                    if (!empty($dateStart) && !empty($dateEnd)) {
                        // Gunakan spasi di awal string filter
                        $filterSql = " WHERE DATE(tgl_update) BETWEEN '$dateStart' AND '$dateEnd'";
                    }

                    $i = 1; // Nomor urut mulai dari 1

                    // --- LOOP 1: TABEL KOMPUTER ---
                    $sqlKom = "SELECT * FROM tbl_komputer " . $filterSql . " ORDER BY INET_ATON(ipaddreses) ASC";
                    $resKom = mysqli_query($c, $sqlKom);

                    while ($p = mysqli_fetch_array($resKom)) {
                        $idk = $p['idkom'];
                    ?>

                        <tr>
                            <td>
                                <input type="checkbox" class="barcode-checkbox"
                                    data-kode="<?= htmlspecialchars($p['kode_aset'] ?? ''); ?>"
                                    data-user="<?= htmlspecialchars($p['npengguna'] ?? ''); ?>">
                            </td>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="user-info">
                                    <b><?= htmlspecialchars($p['npengguna'] ?? '-'); ?></b>
                                    <span class="d-block text-white"><?= htmlspecialchars($p['dept'] ?? '-'); ?></span>
                                </div>
                                <?php if (!empty($p['namapc']) && $p['namapc'] !== '-'): ?>
                                    <span><i class="far fa-user"></i> <?= htmlspecialchars($p['namapc']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span><i class="fas fa-desktop text-info me-1"></i> <?= htmlspecialchars($p['perangkat'] ?? 'Aset'); ?></span>
                                </div>

                                <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">
                                    <i class="bi bi-hdd-network text-primary"></i> <?= htmlspecialchars($p['ipaddreses'] ?? '-'); ?>
                                </div>
                            </td>
                            <td>
                                <div class="py-1">
                                    <div class="text-warning" style="font-size: 0.85rem;">
                                        <i class="fas fa-barcode me-1"></i><?= htmlspecialchars($p['kode_aset'] ?? '-'); ?>
                                    </div>
                                    <?php if (!empty($p['useraccount']) && $p['useraccount'] !== '-'): ?>
                                        <span class="d-block text-white">
                                            <?= htmlspecialchars($p['useraccount']); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($p['macaddreses']) && $p['macaddreses'] !== '-'): ?>
                                        <small class="d-block text-secondary mt-1">
                                            <?= htmlspecialchars($p['macaddreses']); ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div style="font-size: 0.75rem; line-height: 1.2;">
                                    <?php
                                    $icons = ['motherboard' => 'bi bi-motherboard', 'prosesor' => 'bi bi-cpu', 'memory' => 'bi bi-memory', 'videog' => 'bi bi-gpu-card', 'storage' => 'bi bi-device-hdd'];
                                    foreach ($icons as $key => $icon) {
                                        if (!empty($p[$key]) && $p[$key] !== '-') {
                                            echo "<div class='mb-1'><i class='$icon text-info me-2'></i>" . htmlspecialchars($p[$key]) . "</div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-dark border border-secondary text-uppercase shadow-sm"
                                        style="font-size: 0.65rem; padding: 4px 8px; color: #0dcaf0;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.6rem;"></i>
                                        <?= htmlspecialchars($p['kategori_group']); ?>
                                    </span>
                                    <div class="small text-white">
                                        <ul class="p-0 m-0" style="list-style: none;">
                                            <?php
                                            $others = ['monitor', 'psu', 'cassing'];
                                            foreach ($others as $item) {
                                                if (!empty($p[$item]) && $p[$item] !== '-') {
                                                    echo "<li>" . htmlspecialchars($p[$item]) . "</li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center text-white-50"
                                        style="font-size: 0.68rem; margin-left: -5px; opacity: 0.8;">
                                        <i class="bi bi-clock-history me-1" style="font-size: 0.75rem;"></i>
                                        <span><?= date('d/m/y H:i', strtotime($p['tgl_update'])); ?></span>
                                    </div>
                                </div>
                            </td>

                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">

                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        onclick="pilihModal(this)"
                                        data-perangkat="<?= htmlspecialchars(trim($p['perangkat'] ?? '')); ?>"
                                        data-idkom="<?= $idk; ?>"
                                        data-dept="<?= htmlspecialchars($p['dept'] ?? ''); ?>"
                                        data-npengguna="<?= htmlspecialchars($p['npengguna'] ?? ''); ?>"
                                        data-useraccount="<?= htmlspecialchars($p['useraccount'] ?? ''); ?>"
                                        data-kode_aset="<?= htmlspecialchars($p['kode_aset'] ?? ''); ?>"
                                        data-kategori_group="<?= htmlspecialchars($p['kategori_group'] ?? ''); ?>"
                                        data-namapc="<?= htmlspecialchars($p['namapc'] ?? ''); ?>"
                                        data-ipaddreses="<?= $p['ipaddreses'] ?? ''; ?>"
                                        data-mac="<?= $p['macaddreses'] ?? ''; ?>"
                                        data-prosesor="<?= htmlspecialchars($p['prosesor'] ?? ''); ?>"
                                        data-motherboard="<?= htmlspecialchars($p['motherboard'] ?? ''); ?>"
                                        data-memory="<?= htmlspecialchars($p['memory'] ?? ''); ?>"
                                        data-storage="<?= htmlspecialchars($p['storage'] ?? ''); ?>"
                                        data-psu="<?= htmlspecialchars($p['psu']); ?>"
                                        data-videog="<?= htmlspecialchars($p['videog']); ?>"
                                        data-cassing="<?= htmlspecialchars($p['cassing']); ?>"
                                        data-monitor="<?= htmlspecialchars($p['monitor']); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                        data-id="<?= $p['idkom']; ?>"
                                        data-nama="<?= htmlspecialchars($p['npengguna']); ?>"
                                        data-kode="<?= htmlspecialchars($p['kode_aset']); ?>"
                                        data-tipe="komputer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    ?>

                    <?php
                    // --- LOOP 2: TABEL PRINTER ---
                    $sqlPri = "SELECT * FROM tbl_printer " . $filterSql . " ORDER BY INET_ATON(ip_perangkat) ASC";
                    $resPri = mysqli_query($c, $sqlPri);
                    while ($p = mysqli_fetch_array($resPri)) {
                        $idp = $p['id_printer'];
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="barcode-checkbox"
                                    data-kode="<?= htmlspecialchars($p['kode_aset'] ?? ''); ?>"
                                    data-user="<?= htmlspecialchars($p['pengguna'] ?? ''); ?>">
                            </td>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="user info">
                                    <b><?= htmlspecialchars($p['pengguna'] ?? '-'); ?></b>
                                    <span class="d-block text-white"><?= htmlspecialchars($p['departemen'] ?? '-'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span class="text-bold"><i class="fas fa-print text-success me-1"></i> <?= htmlspecialchars($p['perangkat'] ?? 'Aset'); ?></span>
                                </div>
                                <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">
                                    <i class="bi bi-hdd-netwstring: ork text-warning"></i> <?= htmlspecialchars($p['ip_perangkat'] ?? '-'); ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-warning" style="font-size: 0.85rem;">
                                    <i class="fas fa-barcode me-1"></i><?= htmlspecialchars($p['kode_aset'] ?? '-'); ?>
                                </div>
                            </td>
                            <td>
                                <div class="spec-print">
                                    <?php
                                    if (!empty($p['spesifikasi_prangkat'])) {
                                        // Memecah teks berdasarkan titik
                                        $specs = explode('.', $p['spesifikasi_prangkat']);
                                        foreach ($specs as $spec) {
                                            $spec = trim($spec); // Menghilangkan spasi di awal/akhir
                                            if (!empty($spec)) {
                                                echo "<div>• " . htmlspecialchars($spec) . "</div>";
                                            }
                                        }
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-dark border border-secondary text-uppercase shadow-sm"
                                        style="font-size: 0.65rem; padding: 4px 8px; color: #0dcaf0;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.6rem;"></i>
                                        <?= htmlspecialchars($p['kategori_group']); ?>
                                    </span>

                                    <div class="d-flex align-items-center text-white-50"
                                        style="font-size: 0.68rem; margin-left: -5px; opacity: 0.8;">
                                        <i class="bi bi-clock-history me-1" style="font-size: 0.75rem;"></i>
                                        <span><?= date('d/m/y H:i', strtotime($p['tgl_update'])); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">

                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        onclick="pilihModal(this)"
                                        data-perangkat="<?= htmlspecialchars($p['perangkat'] ?? ''); ?>"
                                        data-idp="<?= $p['id_printer']; ?>"
                                        data-pengguna="<?= htmlspecialchars($p['pengguna'] ?? ''); ?>"
                                        data-departemen="<?= htmlspecialchars($p['departemen'] ?? ''); ?>"
                                        data-ip_perangkat="<?= htmlspecialchars($p['ip_perangkat'] ?? ''); ?>"
                                        data-kode_aset="<?= htmlspecialchars($p['kode_aset'] ?? ''); ?>"
                                        data-kategori_group="<?= htmlspecialchars($p['kategori_group'] ?? ''); ?>"
                                        data-spesifikasi_perangkat="<?= htmlspecialchars($p['spesifikasi_prangkat'] ?? ''); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger btn-hapus"
                                        data-bs-toggle="modal" data-bs-target="#modalHapus"
                                        data-id="<?= $p['id_printer']; ?>"
                                        data-nama="<?= htmlspecialchars($p['pengguna']); ?>"
                                        data-kode="<?= htmlspecialchars($p['kode_aset']); ?>"
                                        data-tipe="printer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    ?>

                    <?php
                    // --- LOOP 3: TABEL DVR ---
                    $sqlDvr = "SELECT * FROM tbl_dvr " . $filterSql . " ORDER BY INET_ATON(ip_dvr) ASC";
                    $resDvr = mysqli_query($c, $sqlDvr);
                    while ($p = mysqli_fetch_array($resDvr)) {
                        $idd = $p['id_dvr'];
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="barcode-checkbox"
                                    data-kode="<?= htmlspecialchars($p['kode_dvr'] ?? ''); ?>"
                                    data-user="<?= htmlspecialchars($p['devisi_dvr'] ?? ''); ?>">
                            </td>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="user-info">
                                    <div class="fw-bold text-uppercase">
                                        <?= htmlspecialchars($p['devisi_dvr'] ?? '-'); ?>
                                    </div>
                                    <div class="text-white-50 small mt-1 d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot me-2 text-danger"></i>
                                        <span><?= htmlspecialchars($p['lokasi_simpan'] ?? '-'); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span><i class="fas fa-video text-danger me-1"></i> <?= htmlspecialchars($p['perangkat'] ?? 'Aset'); ?></span>
                                </div>
                                <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">
                                    <i class="bi bi-hdd-network text-primary"></i> <?= htmlspecialchars($p['ip_dvr'] ?? '-'); ?>
                                </div>
                            </td>
                            </td>
                            <td>
                                <div class="text-warning" style="font-size: 0.85rem;">
                                    <i class="fas fa-barcode me-1"></i><?= htmlspecialchars($p['kode_dvr'] ?? '-'); ?>
                                </div>
                                <small class="d-block text-white mt-1"><?= htmlspecialchars($p['channel_dvr'] ?? '-'); ?></small>
                            </td>
                            <td>
                                <div class="specd-print">
                                    <?php
                                    if (!empty($p['spesifikasi_dvr'])) {
                                        // Memecah teks berdasarkan titik
                                        $spedvr = explode('.', $p['spesifikasi_dvr']);
                                        foreach ($spedvr as $specd) {
                                            $specd = trim($specd); // Menghilangkan spasi di awal/akhir
                                            if (!empty($spec)) {
                                                echo "<div>• " . htmlspecialchars($specd) . "</div>";
                                            }
                                        }
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-dark border border-secondary text-uppercase shadow-sm"
                                        style="font-size: 0.65rem; padding: 4px 8px; color: #0dcaf0;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.6rem;"></i>
                                        <?= htmlspecialchars($p['kategori_group']); ?>
                                    </span>
                                    <div class="d-flex align-items-center text-white-50"
                                        style="font-size: 0.68rem; margin-left: -5px; opacity: 0.8;">
                                        <i class="bi bi-clock-history me-1" style="font-size: 0.75rem;"></i>
                                        <span><?= date('d/m/y H:i', strtotime($p['tgl_update'])); ?></span>
                                    </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">

                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        onclick="pilihModal(this)"
                                        data-perangkat="dvr"
                                        data-idd="<?= $idd; ?>"
                                        data-ip_dvr="<?= htmlspecialchars($p['ip_dvr'] ?? ''); ?>"
                                        data-devisi_dvr="<?= htmlspecialchars($p['devisi_dvr'] ?? ''); ?>"
                                        data-lokasi="<?= htmlspecialchars($p['lokasi_simpan'] ?? ''); ?>"
                                        data-kode_dvr="<?= htmlspecialchars($p['kode_dvr'] ?? ''); ?>"
                                        data-channel_dvr="<?= htmlspecialchars($p['channel_dvr'] ?? ''); ?>"
                                        data-kategori_group="<?= htmlspecialchars($p['kategori_group'] ?? ''); ?>"
                                        data-spesifikasi_dvr="<?= htmlspecialchars($p['spesifikasi_dvr'] ?? ''); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-danger btn-sm btn-hapus"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus"
                                        data-id="<?= $p['id_dvr']; ?>"
                                        data-nama="<?= htmlspecialchars($p['devisi_dvr']); ?>"
                                        data-kode="<?= htmlspecialchars($p['kode_dvr']); ?>"
                                        data-tipe="dvr">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    ?>

                    <?php
                    // --- LOOP 4: TABEL LAPTOP ---
                    $sqlLap = "SELECT * FROM tbl_laptop " . $filterSql . " ORDER BY INET_ATON(ip_laptop) ASC";
                    $resLap = mysqli_query($c, $sqlLap);

                    while ($p = mysqli_fetch_array($resLap)) {
                        $idlap = $p['id_laptop'];
                    ?>

                        <tr>
                            <td>
                                <input type="checkbox" class="barcode-checkbox"
                                    data-kode="<?= htmlspecialchars($p['kode_laptop'] ?? ''); ?>"
                                    data-user="<?= htmlspecialchars($p['pengguna'] ?? ''); ?>">
                            </td>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="user-info">
                                    <b><?= htmlspecialchars($p['pengguna'] ?? '-'); ?></b>
                                    <span class="d-block text-white"><?= htmlspecialchars($p['devisi_laptop'] ?? '-'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span><i class="fas fa-laptop text-primary me-1"></i> <?= htmlspecialchars($p['perangkat'] ?? 'Aset'); ?></span>
                                </div>

                                <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">
                                    <i class="bi bi-hdd-network text-primary"></i> <?= htmlspecialchars($p['ip_laptop'] ?? '-'); ?>
                                </div>
                            </td>
                            <td>
                                <div class="py-1">
                                    <div class="text-warning" style="font-size: 0.85rem;">
                                        <i class="fas fa-barcode me-1"></i><?= htmlspecialchars($p['kode_laptop'] ?? '-'); ?>
                                    </div>
                                    <span class="d-block text-white">
                                        <?= htmlspecialchars($p['tipe_laptop']); ?>
                                    </span>

                                    <small class="d-block text-white mt-1">
                                        <?= htmlspecialchars($p['os']); ?>
                                    </small>
                                    <small class="d-block text-white mt-1">
                                        <?= htmlspecialchars($p['sn_laptop']); ?>
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span class="d-block text-white">
                                    <?= htmlspecialchars($p['prosesor']); ?>
                                </span>
                                <span class="d-block text-white">
                                    <?= htmlspecialchars($p['ram']); ?>
                                </span>
                                <span class="d-block text-white">
                                    <?= htmlspecialchars($p['storage']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-dark border border-secondary text-uppercase shadow-sm"
                                        style="font-size: 0.65rem; padding: 4px 8px; color: #0dcaf0;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.6rem;"></i>
                                        <?= htmlspecialchars($p['kategori_group']); ?>
                                    </span>
                                    <div class="d-flex align-items-center text-white-50"
                                        style="font-size: 0.68rem; margin-left: -5px; opacity: 0.8;">
                                        <i class="bi bi-clock-history me-1" style="font-size: 0.75rem;"></i>
                                        <span><?= date('d/m/y H:i', strtotime($p['tgl_update'])); ?></span>
                                    </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">

                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        onclick="pilihModal(this)"
                                        data-perangkat="Laptop"
                                        data-idlap="<?= $idlap; ?>"
                                        data-pengguna="<?= htmlspecialchars($p['pengguna']); ?>"
                                        data-devisi_laptop="<?= htmlspecialchars($p['devisi_laptop']); ?>"
                                        data-kategori_group="<?= htmlspecialchars($p['kategori_group']); ?>"
                                        data-kode_laptop="<?= htmlspecialchars($p['kode_laptop']); ?>"
                                        data-tipe_laptop="<?= htmlspecialchars($p['tipe_laptop']); ?>"
                                        data-sn_laptop="<?= htmlspecialchars($p['sn_laptop']); ?>"
                                        data-prosesor="<?= htmlspecialchars($p['prosesor']); ?>"
                                        data-ram="<?= htmlspecialchars($p['ram']); ?>"
                                        data-storage="<?= htmlspecialchars($p['storage']); ?>"
                                        data-os="<?= htmlspecialchars($p['os']); ?>"
                                        data-ip_laptop="<?= htmlspecialchars($p['ip_laptop']); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-danger btn-sm btn-hapus"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus"
                                        data-id="<?= $p['id_laptop']; ?>"
                                        data-nama="<?= htmlspecialchars($p['pengguna']); ?>"
                                        data-kode="<?= htmlspecialchars($p['kode_laptop']); ?>"
                                        data-tipe="laptop">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    ?>

                    <?php
                    // --- LOOP 5: TABEL ROUTER ---
                    $sqlRou = "SELECT * FROM tbl_router " . $filterSql . " ORDER BY INET_ATON(link_access) ASC";
                    $resRou = mysqli_query($c, $sqlRou);

                    while ($p = mysqli_fetch_array($resRou)) {
                        $idrou = $p['id_router'];
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="barcode-checkbox"
                                    data-kode="<?= htmlspecialchars($p['kode_aset'] ?? ''); ?>"
                                    data-user="<?= htmlspecialchars($p['divisi'] ?? ''); ?>">
                            </td>
                            <td><?= $i++; ?></td>
                            <td>
                                <div class="user-info">
                                    <b><?= htmlspecialchars($p['divisi'] ?? '-'); ?></b>
                                    <span class="d-block text-white small"><?= htmlspecialchars($p['kategori'] ?? '-'); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span><i class="fas fa-wifi text-info me-1"></i> <?= htmlspecialchars($p['perangkat']); ?></span>
                                </div>
                                <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">

                                    <div class="net-code mb-1" style="font-family: monospace; font-size: 0.85rem;">
                                        <i class="bi bi-hdd-network text-primary"></i> <?= htmlspecialchars($p['link_access'] ?? '-'); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="py-1">
                                    <div class="text-warning" style="font-size: 0.85rem;">
                                        <i class="fas fa-barcode me-1"></i><?= htmlspecialchars($p['kode_aset'] ?? '-'); ?>
                                    </div>
                                    <small class="d-block text-white">
                                        <?= htmlspecialchars($p['spesifikasi_alat'] ?? '-'); ?>
                                    </small>
                                    <small class="d-block text-white mt-1">
                                        User: <?= htmlspecialchars($p['username_admin'] ?? '-'); ?>
                                    </small>
                                    <small class="d-block text-white">
                                        Pass: <?= htmlspecialchars($p['password_admin'] ?? '-'); ?>
                                    </small>
                                    <small class="d-block text-white-50">
                                        <?= htmlspecialchars($p['mac_address'] ?? '-'); ?>
                                    </small>

                                </div>
                            </td>
                            <td>
                                <div class="wireless-info">
                                    <span class="d-block text-info fw-bold"><i class="fas fa-wifi"></i> <?= htmlspecialchars($p['ssid_name'] ?? '-'); ?></span>
                                    <span class="d-block text-white small">Pass: <?= htmlspecialchars($p['ssid_password'] ?? '-'); ?></span>
                                    <div class="mt-1">
                                        <span class="badge bg-warning text-dark small">2.4G: <?= htmlspecialchars($p['channel_24g'] ?? '-'); ?></span>
                                        <span class="badge bg-info text-dark small">5.0G: <?= htmlspecialchars($p['channel_50g'] ?? '-'); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-start gap-1">
                                    <span class="badge bg-dark border border-secondary text-uppercase shadow-sm"
                                        style="font-size: 0.65rem; padding: 4px 8px; color: #0dcaf0;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.6rem;"></i>
                                        <?= htmlspecialchars($p['kategori']); ?>
                                    </span>
                                    <div class="d-flex align-items-center text-white-50"
                                        style="font-size: 0.68rem; margin-left: -5px; opacity: 0.8;">
                                        <i class="bi bi-clock-history me-1" style="font-size: 0.75rem;"></i>
                                        <span><?= date('d/m/y H:i', strtotime($p['tgl_update'])); ?></span>
                                    </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        onclick="pilihModal(this)"
                                        data-perangkat="Router"
                                        data-id="<?= $p['id_router']; ?>"
                                        data-kode_aset="<?= htmlspecialchars($p['kode_aset']); ?>"
                                        data-divisi="<?= htmlspecialchars($p['divisi']); ?>"
                                        data-kategori="<?= htmlspecialchars($p['kategori']); ?>"
                                        data-spesifikasi="<?= htmlspecialchars($p['spesifikasi_alat']); ?>"
                                        data-link="<?= htmlspecialchars($p['link_access']); ?>"
                                        data-mac="<?= htmlspecialchars($p['mac_address']); ?>"
                                        data-user_admin="<?= htmlspecialchars($p['username_admin']); ?>"
                                        data-pass_admin="<?= htmlspecialchars($p['password_admin']); ?>"
                                        data-ssid="<?= htmlspecialchars($p['ssid_name']); ?>"
                                        data-pass_ssid="<?= htmlspecialchars($p['ssid_password']); ?>"
                                        data-ch24="<?= htmlspecialchars($p['channel_24g']); ?>"
                                        data-ch50="<?= htmlspecialchars($p['channel_50g']); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        class="btn btn-danger btn-sm btn-hapus"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus"
                                        data-id="<?= $p['id_router']; ?>"
                                        data-nama="<?= htmlspecialchars($p['divisi']); ?>"
                                        data-kode="<?= htmlspecialchars($p['kode_aset']); ?>"
                                        data-tipe="router">
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

    <!-- MODAL ASET -->
    <div class="modal fade" id="modalPilihan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Kategori Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahKomputer" data-bs-dismiss="modal">
                                <i class="fas fa-desktop mb-2 d-block fa-2x"></i> Komputer
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahLaptop" data-bs-dismiss="modal">
                                <i class="fas fa-laptop mb-2 d-block fa-2x"></i> Laptop
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahPrinter" data-bs-dismiss="modal">
                                <i class="fas fa-print mb-2 d-block fa-2x"></i> Printer / Scanner / Fotocopy
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahDVR" data-bs-dismiss="modal">
                                <i class="fas fa-video mb-2 d-block fa-2x"></i> DVR / NVR
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahRouter" data-bs-dismiss="modal">
                                <i class="fas fa-network-wired mb-2 d-block fa-2x"></i> Router / Wifi
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#modalTambahCCTVIP" data-bs-dismiss="modal">
                                <i class="fas fa-video mb-2 d-block fa-2x"></i> CCTV IP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH KOMPUTER -->
    <div class="modal fade" id="modalTambahKomputer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4"><i class="fas fa-plus-circle me-2"></i>Tambah Komputer baru</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna / Mesin</label>
                                        <input type="text" name="npengguna" placeholder="Nama Lengkap" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Departemen</label>
                                        <input type="text" name="dept" placeholder="Masukkan bagian" class="form-control" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nama PC</label>
                                            <input type="text" name="namapc" placeholder="192168xx-PC" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select" style="color: black; background-color: #fff;" required>
                                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-primary me-2"></i>Hardware / Spesifikasi
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Processor</label>
                                        <input type="text" name="prosesor" placeholder="Core i7 / Ryzen 5" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Motherboard</label>
                                        <input type="text" name="motherboard" placeholder="ASUS PRIME B450M" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Memory (RAM)</label>
                                            <input type="text" name="memory" placeholder="16GB DDR4" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">VGA / GPU</label>
                                            <input type="text" name="videog" placeholder="Nvidia RTX 3060" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Device & Network
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">User Account</label>
                                            <input type="text" name="useraccount" placeholder="Windows Account" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold text-muted italic">Perangkat (Read Only)</label>
                                            <input type="text" value="Komputer" class="form-control" disabled style="background-color: rgba(255,255,255,0.1); color: #fff; cursor: not-allowed; border-style: dashed;">
                                            <input type="hidden" name="perangkat" value="Komputer">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">IP Address</label>
                                            <input type="text" name="ipaddreses" placeholder="192.168.x.x" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">MAC Address</label>
                                            <input type="text" name="mac" placeholder="08-BF-B8-18-D3-59" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-orange h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-keyboard text-warning me-2"></i>Component
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Storage</label>
                                            <input type="text" name="storage" placeholder="SSD 128GB" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Monitor</label>
                                            <input type="text" name="monitor" placeholder="AOC 21 Inc" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">PSU</label>
                                            <input type="text" name="psu" placeholder="Contoh: 450W" class="form-control">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">Casing</label>
                                            <input type="text" name="cassing" placeholder="Merk Casing" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewkomputer" class="btn btn-save-gradient px-4">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL TAMBAH Laptop -->
    <div class="modal fade" id="modalTambahLaptop" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Laptop Baru
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna</label>
                                        <input type="text" name="pengguna" placeholder="Masukkan nama lengkap" class="form-control" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Divisi</label>
                                            <input type="text" name="devisi_laptop" placeholder="Contoh: IT/HRD" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select" style="color: black; background-color: #fff;" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Perangkat</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark border-secondary text-white">🖥️</span>
                                            <input type="text" class="form-control bg-light" value="Laptop" disabled>
                                        </div>
                                        <input type="hidden" name="perangkat" value="Laptop">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-primary me-2"></i>Hardware Core
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Processor</label>
                                        <input type="text" name="prosesor" placeholder="Contoh: Intel Core i5-1240P" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Memory (RAM)</label>
                                            <input type="text" name="memory" placeholder="Contoh: 8GB / 16GB" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Storage</label>
                                            <input type="text" name="storage" placeholder="Contoh: SSD 512GB" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sistem Operasi (OS)</label>
                                        <input type="text" name="os" placeholder="Contoh: Windows 11 / MacOS" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-section section-green p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Network & Device Info
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Tipe & Merk Laptop</label>
                                            <input type="text" name="tipe_laptop" placeholder="Contoh: ThinkPad L14" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">IP Address</label>
                                            <input type="text" name="ip_laptop" placeholder="192.168.x.x" class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Serial Number (SN)</label>
                                            <input type="text" name="sn_laptop" placeholder="Masukkan nomor seri" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewLaptop" class="btn btn-save-gradient px-4">
                            <i class="fas fa-save me-2"></i> Simpan Data Laptop
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL TAMBAH PRINTER -->
    <div class="modal fade" id="modalTambahPrinter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Aset Perangkat Baru
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm" style="background: rgba(0, 123, 255, 0.05);">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas Pengguna
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna / Mesin</label>
                                        <input type="text" name="pengguna" placeholder="Contoh: Budi Santoso atau flexo / Mesin" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Departemen</label>
                                        <input type="text" name="departemen" placeholder="Contoh: IT Support / Finance" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori Lokasi</label>
                                        <select name="kategori_group" class="form-select e_kategori_group" required>
                                            <option value="" disabled selected>-- Pilih Kategori --</option>
                                            <option value="Office">Office</option>
                                            <option value="Produksi">Produksi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm" style="background: rgba(40, 167, 69, 0.05);">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Spesifikasi & Koneksi
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Spesifikasi Alat</label>
                                        <textarea name="spesifikasi_prangkat" placeholder="Contoh: EPSON L3110, Inkjet, USB Connection" class="form-control" rows="3" required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">IP Address</label>
                                            <input type="text" name="ip_perangkat" placeholder="192.168.x.x" class="form-control">
                                            <small class="text-muted small-text">Kosongkan jika USB</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Jenis Perangkat</label>
                                            <select name="perangkat" class="form-select" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="Printer">Printer (PR)</option>
                                                <option value="Scanner">Scanner (SC)</option>
                                                <option value="Fotocopy">Fotocopy (FC)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewPrinter" class="btn btn-primary btn-save-gradient px-5">
                            <i class="fas fa-save me-2"></i>Simpan Aset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL TAMBAH DVR -->
    <div class="modal fade" id="modalTambahDVR" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-video me-2"></i>Tambah DVR / NVR Baru
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-map-marker-alt text-info me-2"></i>Identitas & Lokasi
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Divisi</label>
                                            <input type="text" name="dept" placeholder="Contoh: IT / Security" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select" style="color: black; background-color: #fff;" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Titik Lokasi Perangkat</label>
                                        <input type="text" name="lokasi" placeholder="Contoh: Ruang Scurity / Area Sortir" class="form-control">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-bold">Jenis Perangkat</label>
                                        <select name="perangkat" class="form-select" style="color: black; background-color: #fff;">
                                            <option value="DVR">🎦 DVR (Analog)</option>
                                            <option value="NVR">🎦 NVR (IP Cam)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-success me-2"></i>Spesifikasi & Network
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Model / Tipe Spesifikasi</label>
                                        <input type="text" name="spesifikasi" placeholder="Contoh: HIKVISION DS-7616NI" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Jumlah Channel</label>
                                            <select name="channel" class="form-select" style="color: black; background-color: #fff;">
                                                <option value="4 Channel">4 Channel</option>
                                                <option value="8 Channel">8 Channel</option>
                                                <option value="16 Channel">16 Channel</option>
                                                <option value="32 Channel">32 Channel</option>
                                                <option value="64 Channel">64 Channel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold text-primary">IP Address</label>
                                            <input type="text" name="ip" placeholder="192.168.x.x" class="form-control border-primary border-opacity-25">
                                        </div>
                                    </div>
                                    <div class="mb-0 italic text-muted small">
                                        <i class="fas fa-info-circle me-1"></i> Pastikan IP Address tidak konflik dengan perangkat lain.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewDVR" class="btn btn-save-gradient px-4">
                            <i class="fas fa-save me-2"></i> Simpan DVR/NVR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL TAMBAH Router -->
    <div class="modal fade" id="modalTambahRouter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-router me-2"></i>Tambah Perangkat Router / AP
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-id-card text-info me-2"></i>Identitas & Management
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Divisi</label>
                                            <input type="text" name="divisi" placeholder="Masukkan Divisi" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori Group</label>
                                            <select name="kategori" class="form-select" style="color: black; background-color: #fff;" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Spesifikasi Alat</label>
                                        <input type="text" name="spesifikasi_alat" placeholder="Merk & Tipe Perangkat" class="form-control">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Link Access (IP)</label>
                                            <input type="text" name="link_access" placeholder="192.168.x.x" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">MAC Address</label>
                                            <input type="text" name="mac_address" placeholder="00:00:00:00:00:00" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">User Admin</label>
                                            <input type="text" name="username_admin" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Pass Admin</label>
                                            <input type="text" name="password_admin" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-wifi text-primary me-2"></i>Wireless & Channel
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nama SSID</label>
                                            <input type="text" name="ssid_name" maxlength="40" placeholder="Nama WiFi" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Password SSID</label>
                                            <input type="text" name="ssid_password" maxlength="30" placeholder="Password WiFi" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Channel 2.4G</label>
                                            <input type="text" name="channel_24g" placeholder="Ch 2.4G" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Channel 5.0G</label>
                                            <input type="text" name="channel_50g" placeholder="Ch 5.0G" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-boldc">Perangkat (Read Only)</label>
                                        <input type="text" value="Router" class="form-control" disabled style="background-color: rgba(255,255,255,0.1); color: #fff; cursor: not-allowed; border-style: dashed;">
                                        <input type="hidden" name="perangkat" value="Router">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewRouter" class="btn btn-save-gradient px-4">
                            <i class="fas fa-save me-2"></i> Simpan Router
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal edit asset -->
    <div class="modal fade" id="modalEditKomputer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-edit me-2 text-warning"></i>Perbarui Data Komputer
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <input type="hidden" name="idkom" class="e_idkom">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna</label>
                                        <input type="text" name="npengguna" class="form-control e_npengguna" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Departemen</label>
                                        <input type="text" name="dept" class="form-control e_dept" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nama PC</label>
                                            <input type="text" name="namapc" class="form-control e_namapc">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select e_kategori_group" style="color: black; background-color: #fff;" required>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-primary me-2"></i>Hardware
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Processor</label>
                                        <input type="text" name="prosesor" class="form-control e_prosesor">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Motherboard</label>
                                        <input type="text" name="motherboard" class="form-control e_motherboard">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Memory (RAM)</label>
                                            <input type="text" name="memory" class="form-control e_memory">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">VGA / GPU</label>
                                            <input type="text" name="videog" class="form-control e_videog">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Network & Device
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">User Account</label>
                                            <input type="text" name="useraccount" class="form-control e_useraccount">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kode Aset (Read Only)</label>
                                            <input type="text"
                                                name="kode_aset"
                                                class="form-control e_kode_aset"
                                                readonly
                                                style="background-color: rgba(255,255,255,0.05); color: #fff; border-style: dashed; cursor: not-allowed;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">IP Address</label>
                                            <input type="text" name="ipaddreses" class="form-control e_ipaddreses">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">MAC Address</label>
                                            <input type="text" name="mac" class="form-control e_mac">
                                        </div>
                                    </div>
                                    <input type="hidden" name="perangkat" class="e_perangkat" value="Komputer">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-orange h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-keyboard text-warning me-2"></i>Component
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Storage</label>
                                            <input type="text" name="storage" class="form-control e_storage">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Monitor</label>
                                            <input type="text" name="monitor" class="form-control e_monitor">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">PSU</label>
                                            <input type="text" name="psu" class="form-control e_psu">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label fw-bold">Casing</label>
                                            <input type="text" name="cassing" class="form-control e_cassing">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="updatekomputer" class="btn btn-save-gradient px-4">
                            <i class="fas fa-sync-alt me-2"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditLaptop" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-edit me-2 text-warning"></i>Perbarui Data Laptop
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_laptop" class="e_id_laptop">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas Pengguna
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna</label>
                                        <input type="text" name="pengguna" class="form-control e_pengguna" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Divisi</label>
                                        <input type="text" name="devisi_laptop" class="form-control e_devisi_laptop" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select e_kategori_group" style="color: black; background-color: #fff;" required>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold text-muted italic">Kode Aset</label>
                                            <input type="text" name="kode_laptop" class="form-control e_kode_laptop" readonly style="background-color: rgba(255,255,255,0.05); border-style: dashed; color: #fff;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-primary me-2"></i>Hardware & Spesifikasi
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Processor</label>
                                        <input type="text" name="prosesor" class="form-control e_prosesor">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Memory (RAM)</label>
                                            <input type="text" name="ram" class="form-control e_ram">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Storage</label>
                                            <input type="text" name="storage" class="form-control e_storage">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sistem Operasi (OS)</label>
                                        <input type="text" name="os" class="form-control e_os">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-section section-green p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Network & Device Details
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Tipe & Merk Laptop</label>
                                            <input type="text" name="tipe_laptop" class="form-control e_tipe_laptop">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">IP Address</label>
                                            <input type="text" name="ip_laptop" class="form-control e_ip_laptop">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Serial Number</label>
                                            <input type="text" name="sn_laptop" class="form-control e_sn_laptop">
                                        </div>
                                    </div>
                                    <input type="hidden" name="perangkat" value="Laptop">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="update_lapt" class="btn btn-save-gradient px-4">
                            <i class="fas fa-sync-alt me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPrinter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-edit me-2"></i>Edit Data Perangkat
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_printer" class="e_id_printer">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm" style="background: rgba(0, 123, 255, 0.05);">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-user-tag text-info me-2"></i>Identitas Pengguna
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pengguna / Mesin</label>
                                        <input type="text" name="pengguna" class="form-control e_pengguna" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Departemen</label>
                                        <input type="text" name="departemen" class="form-control e_departemen" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori Lokasi</label>
                                        <select name="kategori_group" class="form-select e_kategori_group" required>
                                            <option value="Office">Office</option>
                                            <option value="Produksi">Produksi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm" style="background: rgba(40, 167, 69, 0.05);">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-success me-2"></i>Spesifikasi & Network
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kode Aset (Read Only)</label>
                                        <input type="text" class="form-control e_kode_aset" readonly style="background-color: #e9ecef; color: #666;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Spesifikasi Alat</label>
                                        <textarea name="spesifikasi_prangkat" class="form-control e_spesifikasi_prangkat" rows="3" required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">IP Perangkat</label>
                                            <input type="text" name="ip_perangkat" class="form-control e_ip_perangkat">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Jenis Perangkat (Read Only) </label>
                                            <input type="text" name="perangkat" class="form-control e_perangkat" readonly style="background-color: #f8f9fa;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="updatePrinter" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditDvr" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-edit me-2 text-warning"></i>Perbarui Data DVR / NVR
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_dvr" class="e_id_dvr">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-network-wired text-info me-2"></i>Identitas & Network
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Divisi</label>
                                            <input type="text" name="devisi_dvr" class="form-control e_devisi_dvr" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori</label>
                                            <select name="kategori_group" class="form-select e_kategori_group" style="color: black; background-color: #fff;" required>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Titik Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control e_lokasi">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-bold text-primary">IP Address</label>
                                        <input type="text" name="ip_dvr" class="form-control e_ip_dvr border-primary border-opacity-25">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-green h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-microchip text-success me-2"></i>Device & Spesifikasi
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Model / Spesifikasi</label>
                                        <textarea name="spesifikasi_dvr" class="form-control e_spesifikasi_dvr" rows="2" placeholder="Contoh: HIKVISION DS-7616NI"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kode Aset</label>
                                            <input type="text" name="kode_dvr" class="form-control e_kode_dvr bg-light" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Channel</label>
                                            <select name="channel_dvr" class="form-select e_channel_dvr" style="color: black; background-color: #fff;">
                                                <option value="4 Channel">4 Channel</option>
                                                <option value="8 Channel">8 Channel</option>
                                                <option value="16 Channel">16 Channel</option>
                                                <option value="32 Channel">32 Channel</option>
                                                <option value="64 Channel">64 Channel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="update_dvr" class="btn btn-save-gradient px-4">
                            <i class="fas fa-sync-alt me-2"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditRouter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Perangkat Router / AP
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_router" class="e_id_router">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-section section-blue h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-id-card text-info me-2"></i>Identitas & Management
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Divisi</label>
                                            <input type="text" name="divisi" class="form-control e_divisi" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Kategori Group</label>
                                            <select name="kategori" class="form-select e_kategori" style="color: black; background-color: #fff;" required>
                                                <option value="Office">Office</option>
                                                <option value="Produksi">Produksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Spesifikasi Alat</label>
                                        <input type="text" name="spesifikasi_alat" class="form-control e_spesifikasi">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Link Access (IP)</label>
                                            <input type="text" name="link_access" class="form-control e_link">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">MAC Address</label>
                                            <input type="text" name="mac_address" class="form-control e_mac">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">User Admin</label>
                                            <input type="text" name="username_admin" class="form-control e_user_admin">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Pass Admin</label>
                                            <input type="text" name="password_admin" class="form-control e_pass_admin">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-section section-purple h-100 p-3 rounded-3 shadow-sm">
                                    <h4 class="section-title mb-4 border-bottom pb-2">
                                        <i class="fas fa-wifi text-primary me-2"></i>Wireless & Channel
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nama SSID</label>
                                            <input type="text" name="ssid_name" maxlength="40" class="form-control e_ssid">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Password SSID</label>
                                            <input type="text" name="ssid_password" maxlength="30" class="form-control e_pass_ssid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold text-warning">Channel 2.4G</label>
                                            <input type="text" name="channel_24g" class="form-control e_ch24">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold text-info">Channel 5.0G</label>
                                            <input type="text" name="channel_50g" class="form-control e_ch50">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kode Aset</label>
                                        <input type="text" name="kode_aset" class="form-control e_kode_aset bg-dark text-warning border-0 opacity-75" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="editRouter" class="btn btn-save-gradient px-4">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS ASSET -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-0 shadow-lg">
                <form method="POST">
                    <div class="modal-body text-center p-5">
                        <i class="fas fa-exclamation-circle text-danger fa-4x mb-4"></i>

                        <h3 class="mb-3 fw-bold">Konfirmasi Hapus</h3>
                        <p class="fs-6 opacity-75">Apakah Anda yakin ingin menghapus data aset berikut?</p>

                        <div class="p-3 mb-4 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2);">
                            <h5 id="namaHapus" class="text-warning mb-1"></h5>
                            <code id="kodeHapus" class="text-info d-block"></code>
                        </div>

                        <input type="hidden" name="id_data" id="id_data">
                        <input type="hidden" name="tipe_data" id="tipe_data">
                    </div>

                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-outline-secondary px-4 me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="proses_hapus" class="btn btn-danger px-4">Ya, Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script_detAset.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        // UNTUK HAPUS 
        $(document).on('click', '.btn-hapus', function() {
            // 1. Ambil data dari atribut 'data-...' pada tombol yang diklik
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var kode = $(this).data('kode'); // Ini harus ada
            var tipe = $(this).data('tipe');

            // 2. Masukkan data tersebut ke dalam elemen modal
            $('#id_data').val(id);
            $('#tipe_data').val(tipe);
            $('#namaHapus').text(nama);
            $('#kodeHapus').text(kode);
        });
    </script>

    <div id="floating-pagination-container">
        <div class="pagination-label">Page</div>
        <ul class="pagination mb-0" id="paginationWrapper">
        </ul>
    </div>
    <a href="#" id="btn-back-to-top" class="d-flex shadow shadow-lg">
        <i class="fas fa-arrow-up"></i>
    </a>
</body>

</html>
<?php
// Koneksi database
include 'ceklogin.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>DATA DVR & CCTV PT.CMBP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/stylesDVR.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="parallax-bg"></div>

    <div class="container">
        <div class="header-wrapper">
            <header>
                <div class="brand-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div class="brand-text">
                    <h1>DATA DVR & CCTV PT.CMBP</h1>
                    <p>Infrastruktur IT // DVR & CCTV </p>
                </div>
            </header>

            <nav class="action-buttons">
                <a href="index.php" class="btn-nav" title="Beranda">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
                <button type="button" class="btn-nav" data-bs-toggle="modal" data-bs-target="#modalTambahDVR">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>Tambah DVR</span>
                </button>
                <button type="button" class="btn-nav" data-bs-toggle="modal" data-bs-target="#modalTambahCCTV">
                    <i class="fas fa-plus-circle me-2"></i> Tambah CCTV
                </button>
                <button class="btn-nav btn-filter" onclick="bukaModalFilter()">
                    <i class="fas fa-calendar-alt"></i> <span>Filter</span>
                </button>
                <a href="detDVR.php" class="btn-nav btn-refresh">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </nav>
        </div>

        <div class="search-section" style="margin-bottom: 25px;">
            <div class="search-box" style="position: relative; max-width: 450px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--accent-cyan); pointer-events: none;"></i>

                <input type="text" id="searchInput"
                    placeholder="Cari IP Address, Lokasi, atau Nama User..."
                    onkeyup="searchTable()"
                    style="width: 100%; padding: 14px 15px 14px 45px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; color: #fff; outline: none; transition: 0.3s;">
            </div>
        </div>



        <div class="table-wrapper">
            <table id="itTable">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="10%">DEVISI</th>
                        <th width="12%">USER</th>
                        <th width="10%">CODE</th>
                        <th width="18%">NAMA BARANG</th>
                        <th width="12%">IP & CHANNEL</th>
                        <th width="18%">SPESIFIKASI</th>
                        <th width="9%">TGL UPDATE</th>
                        <th width="8%" style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 1. LOGIKA FILTER - Tangkap input filter jika ada
                    $tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
                    $tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

                    if ($tgl_mulai != '' && $tgl_selesai != '') {
                        // Query jika filter aktif
                        $get = mysqli_query($c, "SELECT * FROM tbl_dvr WHERE tgl_update BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY id_dvr DESC");
                    } else {
                        // Query default jika tidak ada filter
                        $get = mysqli_query($c, "SELECT * FROM tbl_dvr ORDER BY id_dvr DESC");
                    }

                    $i = 1;

                    // 2. LOOPING DATA KE DALAM TABEL
                    while ($p = mysqli_fetch_array($get)) {
                        // Pastikan key sesuai database, jika di DB adalah idalat maka gunakan idalat
                        $id = $p['id_dvr'];
                    ?>
                        <tr>
                            <td style="text-align: center; color: var(--text-gray);"><?= $i++; ?></td>

                            <td style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">
                                <a href="javascript:void(0)"
                                    onclick="showTotalCamera('<?= htmlspecialchars($p['devisi_dvr']); ?>')"
                                    class="link-devisi"
                                    title="Klik untuk detail kamera <?= htmlspecialchars($p['devisi_dvr']); ?>">
                                    <i class="fas fa-video" style="font-size: 0.7rem; margin-right: 5px; opacity: 0.6;"></i>
                                    <?= htmlspecialchars($p['devisi_dvr']); ?>
                                </a>
                            </td>

                            <td>
                                <span style="color: #fff; font-weight: 600;">
                                    <i class="fas fa-user-circle" style="color: var(--accent-cyan); font-size: 0.8rem; margin-right: 5px;"></i>
                                    <?= htmlspecialchars($p['user_dvr']); ?>
                                </span>
                            </td>

                            <td><code class="net-code"><?= htmlspecialchars($p['code_dvr']); ?></code></td>

                            <td>
                                <div style="font-size: 0.8rem; line-height: 1.5; color: #cbd5e0; max-width: 280px; word-wrap: break-word;">
                                    <?= nl2br(htmlspecialchars($p['perangkat'])); ?>
                                </div>
                            </td>
                            <td>
                                <strong style="color: #fff;"><?= htmlspecialchars($p['ip_dvr']); ?></strong>
                                <small style="display: block; margin-top: 4px; color: var(--text-gray);">
                                    <i class="fas fa-map-marker-alt" style="color: var(--danger-red); font-size: 0.7rem;"></i>
                                    <?= htmlspecialchars($p['channel_dvr']); ?>
                                </small>
                            </td>

                            <td>
                                <div style="font-size: 0.8rem; line-height: 1.5; color: #cbd5e0; max-width: 280px; word-wrap: break-word;">
                                    <?= nl2br(htmlspecialchars($p['spesifikasi_dvr'])); ?>
                                </div>
                            </td>

                            <td>
                                <div style="font-size: 0.75rem; color: var(--accent-cyan); white-space: nowrap;">
                                    <i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($p['tgl_update'])); ?>
                                </div>
                            </td>

                            <td style="text-align:center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <button type="button"
                                        class="btn-action-mini btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditSingle"
                                        data-bs-id="<?= $id; ?>"
                                        data-bs-devisi="<?= htmlspecialchars($p['devisi_dvr']); ?>"
                                        data-bs-user="<?= htmlspecialchars($p['user_dvr']); ?>"
                                        data-bs-namabarang="<?= htmlspecialchars($p['perangkat']); ?>"
                                        data-bs-code="<?= htmlspecialchars($p['code_dvr']); ?>"
                                        data-bs-ip="<?= htmlspecialchars($p['ip_dvr']); ?>"
                                        data-bs-channel="<?= htmlspecialchars($p['channel_dvr']); ?>"
                                        data-bs-spesifikasi="<?= htmlspecialchars($p['spesifikasi_dvr']); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button type="button"
                                        class="btn-action-mini btn-hapus"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapusSingle"
                                        data-bs-id="<?= $id; ?>"
                                        data-bs-nama="<?= htmlspecialchars($p['perangkat']); ?>"
                                        data-bs-devisi="<?= htmlspecialchars($p['devisi_dvr']); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    <?php
                    } // End While 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal tambah cctv -->
    <div class="modal fade" id="modalTambahCCTV" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-box shadow-cyan border-0">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4"><i class="fas fa-video me-2"></i>Tambah Unit CCTV Baru</h3>
                </div>

                <form method="POST" class="modal-form">
                    <div class="modal-body p-4">
                        <div class="row g-4">

                            <div class="col-12">
                                <div class="form-section section-blue h-100">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Divisi / Departemen</label>
                                            <select name="devisi" class="form-select" required>
                                                <option value="" selected disabled>Pilih Divisi...</option>
                                                <option value="KANTOR">KANTOR</option>
                                                <option value="FLEXO">FLEXO</option>
                                                <option value="HRD">HRD</option>
                                                <option value="FINISHING">FINISHING</option>
                                                <option value="CORR 220">CORR 220</option>
                                                <option value="CORR 250">CORR 250</option>
                                                <option value="PLANT SEPATU">PLANT SEPATU</option>
                                                <option value="POS SECURITY">POS SECURITY</option>
                                                <option value="WAREHOUS">WAREHOUS</option>
                                                <option value="PLANT 02">PLANT 02</option>
                                                <option value="XPDC">XPDC</option>
                                                <option value="MOUNTING">MOUNTING</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Kamera</label>
                                            <input type="text" name="nama_kamera" placeholder="Contoh: Camera 01" class="form-control" required>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Lokasi Spesifik</label>
                                            <input type="text" name="lokasi" placeholder="Contoh: AREA CONVAYER LOADING" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4 py-3">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="addnewcctv" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal tambah dvr -->
    <div class="modal fade" id="modalTambahDVR" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: #1a2635; color: #fff; border: 1px solid rgba(0, 217, 255, 0.2); box-shadow: 0 0 20px rgba(0, 217, 255, 0.1);">

                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient-custom mb-0 fs-4">
                        <i class="fas fa-video me-2"></i>Tambah Unit DVR Baru
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST">
                    <div class="modal-body px-4 py-4">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label text-info small fw-bold">NAMA BARANG / PRASARANA</label>
                                <input type="text" name="namabarang" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" required placeholder="Contoh: DVR CCTV">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-info small fw-bold">CODE</label>
                                <input type="text" name="code" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" placeholder="DVR-CCTV 2201010">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">DIVISI</label>
                                <input type="text" name="divisi" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" required placeholder="Contoh: IT / Security">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">USER</label>
                                <input type="text" name="user" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" required placeholder="Contoh: ADMIN">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">IP ADDRESS</label>
                                <input type="text" name="ip" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" required placeholder="192.168.1.x">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">JUMLAH CHANNEL</label>
                                <select name="channel" class="form-select bg-dark text-white border-secondary shadow-none focus-cyan">
                                    <option value="4 Channel">4 Channel</option>
                                    <option value="8 Channel">8 Channel</option>
                                    <option value="16 Channel">16 Channel</option>
                                    <option value="32 Channel">32 Channel</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label text-info small fw-bold">SPESIFIKASI LENGKAP</label>
                                <textarea name="spesifikasi" class="form-control bg-dark text-white border-secondary shadow-none focus-cyan" rows="3" placeholder="Contoh: HIKVISION DS-7616NI / 16P16. HDD 4TB"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-secondary border-opacity-10 px-4">
                        <button type="button" class="btn btn-outline-secondary px-4 text-white" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submit_dvr" class="btn btn-primary px-4 shadow-cyan-btn">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal edit table -->
    <div class="modal fade" id="modalEditSingle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: #1a2635; color: #fff; border: 1px solid rgba(0, 217, 255, 0.2);">
                <div class="modal-header border-bottom border-secondary border-opacity-10 px-4">
                    <h3 class="text-gradient mb-0 fs-4"><i class="fas fa-edit me-2"></i>Edit Data Asset</h3>
                </div>
                <form method="POST">
                    <input type="hidden" name="id_alat" id="form-id">

                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">DEVISI</label>
                                <input type="text" name="devisi" id="form-devisi" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">USER</label>
                                <input type="text" name="user" id="form-user" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label text-info small fw-bold">NAMA BARANG</label>
                                <input type="text" name="namabarang" id="form-namabarang" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-info small fw-bold">CODE (IP/ID)</label>
                                <input type="text" name="code" id="form-code" class="form-control bg-dark text-white border-secondary">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">IP ADDRESS</label>
                                <input type="text" name="ip" id="form-ip" class="form-control bg-dark text-white border-secondary">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-info small fw-bold">CHANNEL</label>
                                <select name="channel" id="form-channel" class="form-select bg-dark text-white border-secondary">
                                    <option value="4 Channel">4 Channel</option>
                                    <option value="8 Channel">8 Channel</option>
                                    <option value="16 Channel">16 Channel</option>
                                    <option value="32 Channel">32 Channel</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-info small fw-bold">SPESIFIKASI</label>
                                <textarea name="spesifikasi" id="form-spesifikasi" class="form-control bg-dark text-white border-secondary" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="updatedvr" class="btn btn-primary px-4">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal hapus table -->
    <div class="modal fade" id="modalHapusSingle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #1a2635; color: #fff; border: 1px solid rgba(239, 68, 68, 0.4);">
                <div class="modal-header border-bottom border-secondary border-opacity-10">
                    <h5 class="modal-title text-danger"><i class="fas fa-trash me-2"></i>Hapus Aset</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <input type="hidden" name="id_alat" id="hapus-id">

                    <div class="modal-body text-center py-4">
                        <p class="mb-2 text-muted small">Anda akan menghapus aset dari devisi:</p>
                        <div id="hapus-devisi" class="badge bg-info text-dark mb-3" style="text-transform: uppercase; letter-spacing: 1px;"></div>

                        <p class="mb-1">Nama Barang:</p>
                        <h5 id="hapus-nama" class="text-white fw-bold"></h5>

                        <p class="small text-danger mt-4 opacity-75">
                            <i class="fas fa-info-circle me-1"></i> Data ini akan dihapus permanen dari sistem.
                        </p>
                    </div>

                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="hapusasset" class="btn btn-danger px-4">Ya, Hapus Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal filter -->
    <div id="modalFilter" class="modal-bg" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center; backdrop-filter:blur(5px);">
        <div class="modal-box" style="background:#1a2635; padding:30px; border-radius:15px; border:1px solid var(--accent-cyan); width:90%; max-width:400px; box-shadow:0 20px 50px rgba(0,0,0,0.5);">
            <div class="modal-header" style="margin-bottom:20px; display:flex; align-items:center; gap:10px; color:#fff;">
                <i class="fas fa-filter" style="color:var(--accent-cyan);"></i>
                <h3 style="margin:0; font-size:1.2rem;">Filter Periode Data</h3>
            </div>

            <form method="GET" action="">
                <div style="margin-bottom:15px;">
                    <label style="display:block; color:var(--accent-cyan); font-size:0.75rem; margin-bottom:8px; font-weight:600;">TANGGAL MULAI</label>
                    <input type="date" name="tgl_mulai"
                        style="width:100%; padding:12px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(0,0,0,0.2); color:#fff; outline:none; color-scheme: dark;"
                        required>
                </div>

                <div style="margin-bottom:25px;">
                    <label style="display:block; color:var(--accent-cyan); font-size:0.75rem; margin-bottom:8px; font-weight:600;">TANGGAL SELESAI</label>
                    <input type="date" name="tgl_selesai"
                        style="width:100%; padding:12px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(0,0,0,0.2); color:#fff; outline:none; color-scheme: dark;"
                        required>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="tutupModalFilter()" style="padding:10px 20px; border-radius:8px; border:1px solid #666; background:transparent; color:#ccc; cursor:pointer;">Batal</button>
                    <button type="submit" style="padding:10px 20px; border-radius:8px; border:none; background:var(--accent-cyan); color:var(--bg-dark); font-weight:bold; cursor:pointer;">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- modal untuk view detail kamera -->
    <div id="modalDetailKamera" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.85); align-items:center; justify-content:center; backdrop-filter:blur(5px);">
        <div style="background:#1a2635; margin:auto; padding:25px; width:75%; max-width:900px; border-radius:15px; border: 1px solid var(--accent-cyan); box-shadow: 0 20px 60px rgba(0,0,0,0.6);">

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom:15px;">
                <h3 style="color:var(--accent-cyan); margin:0; font-size:1.3rem; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-list-ul"></i>
                    <span>DATA KAMERA DEVISI: <span id="namaDevisiModal" style="color:#fff;"></span></span>
                </h3>
            </div>

            <div id="isiModalDetail" style="max-height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: var(--accent-cyan) transparent;">
            </div>


            <div style="margin-top: 20px; text-align: right;">
                <button onclick="$('#modalDetailKamera').fadeOut(300)" style="padding: 8px 20px; border-radius: 6px; border: 1px solid #4a5568; background: transparent; color: #a0aec0; cursor: pointer; transition: 0.3s;" onmouseover="this.style.color='#fff'">Tutup</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script_dvr.js"></script>
</body>

</html>
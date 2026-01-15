<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Infrastruktur & Manajemen IT | PT. CMBP</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link href="css/stylesinfrastruktur.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/logo1.png" alt="CMBP" style="height: 40px;">
                <div class="border-start ps-3 ms-3">
                    <span class="d-block text-secondary fw-bold small uppercase mb-0" style="letter-spacing: 2px;">Infrastruktur IT</span>
                    <span class="fw-bold text-dark fs-5">PT. <span class="text-warning">CIPTA MULTI BUANA PERKASA</span></span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link fw-600" href="#dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link fw-600" href="#monitoring">Monitoring</a></li>
                    <li class="nav-item"><a class="nav-link fw-600" href="#struktur">Tim IT</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-primary rounded-pill px-4" href="index.php">Keluar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-gradient text-center shadow">
        <div class="container">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">Sistem Monitoring Terpusat</span>
            <h1 class="display-4 fw-800 mb-3">Informasi Tata Kelola IT</h1>
            <p class="lead opacity-75 mb-5 mx-auto" style="max-width: 800px;">
                Manajemen infrastruktur digital yang andal untuk mendukung performa operasional PT. CMBP secara real-time dan berkelanjutan.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#monitoring" class="btn btn-info rounded-pill px-4 py-2 fw-bold shadow-sm">Status Server</a>
                <a href="#mapping" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">Topologi Jaringan</a>
            </div>
        </div>
    </header>

    <main class="container mb-5" style="margin-top: -60px;">

        <section id="dashboard" class="mb-5">
            <div class="swiper-container-wrapper">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        $inventory_stats = [
                            ['label' => 'Desktop PC',  'count' => 145, 'icon' => 'fa-desktop',      'bg' => '#e0f2fe', 'color' => '#0369a1'],
                            ['label' => 'Laptop',      'count' => 62,  'icon' => 'fa-laptop',       'bg' => '#f3e8ff', 'color' => '#7e22ce'],
                            ['label' => 'Printer',     'count' => 28,  'icon' => 'fa-print',        'bg' => '#ecfdf5', 'color' => '#047857'],
                            ['label' => 'CCTV Unit',   'count' => 84,  'icon' => 'fa-video',        'bg' => '#fee2e2', 'color' => '#b91c1c'],
                            ['label' => 'Router',      'count' => 15, 'icon' => 'fa-network-wired', 'bg' => '#eff6ff', 'color' => '#1d4ed8'],
                            ['label' => 'UPS',         'count' => 22,  'icon' => 'fa-battery-full', 'bg' => '#fefce8', 'color' => '#a16207'],
                        ];

                        foreach ($inventory_stats as $stat): ?>
                            <div class="swiper-slide">
                                <div class="glass-card d-flex align-items-center">
                                    <div class="stat-icon" style="background: <?= $stat['bg'] ?>; color: <?= $stat['color'] ?>;">
                                        <i class="fas <?= $stat['icon'] ?>"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-0"><?= $stat['count'] ?></h4>
                                        <span class="text-muted small fw-600"><?= $stat['label'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination" style="position: relative; margin-top: 30px;"></div>
                </div>

                <div class="swiper-button-prev-custom">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="swiper-button-next-custom">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </section>

        <section id="monitoring" class="mb-5">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="glass-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0"><i class="fas fa-server text-success me-2"></i>Server Health Status</h5>
                            <span class="badge bg-success-subtle text-success border border-success px-3">Live</span>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6 border-end">
                                <p class="fw-bold mb-2">Main Data Center</p>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">CPU Load</span>
                                        <span class="fw-bold">14%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 14%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">Storage</span>
                                        <span class="fw-bold text-danger">92%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center text-success small">
                                    <i class="fas fa-thermometer-half me-2"></i> Suhu Ruang: 22°C (Normal)
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="fw-bold mb-2">Cloud Backup Server</p>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">CPU Load</span>
                                        <span class="fw-bold">5%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 5%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">RAM usage</span>
                                        <span class="fw-bold">42%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 42%"></div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center text-primary small">
                                    <i class="fas fa-clock me-2"></i> Uptime: 45 Hari 12 Jam
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="glass-card">
                        <h5 class="fw-bold mb-4"><i class="fas fa-history text-warning me-2"></i>Log Backup Harian</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead>
                                    <tr class="text-muted small">
                                        <th>SISTEM</th>
                                        <th>STATUS</th>
                                        <th>WAKTU</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Database ERP</td>
                                        <td><span class="status-indicator bg-light-success">Success</span></td>
                                        <td class="small">02:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>File Server HRD</td>
                                        <td><span class="status-indicator bg-light-success">Success</span></td>
                                        <td class="small">03:15 AM</td>
                                    </tr>
                                    <tr>
                                        <td>CCTV Storage</td>
                                        <td><span class="status-indicator bg-light-danger">Failed</span></td>
                                        <td class="small">04:00 AM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-3">Detail Semua Log</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="struktur" class="mb-5">
            <h3 class="fw-bold mb-4">Manajemen & Strategi IT</h3>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="org-card shadow-sm border-primary">
                                <div class="profile-img"><i class="fas fa-user-tie"></i></div>
                                <h5 class="fw-bold mb-1">IT Manager</h5>
                                <p class="text-primary small fw-bold">Strategic Planning & IT Budgeting</p>
                                <p class="text-muted small mb-0 px-md-5">Penanggung jawab utama seluruh aset teknologi dan kebijakan keamanan data PT. CMBP.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-card shadow-sm" style="border-top-color: var(--success);">
                                <div class="profile-img"><i class="fas fa-server"></i></div>
                                <h6 class="fw-bold mb-1">System Admin</h6>
                                <p class="text-success small fw-bold">Server & Cloud</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-card shadow-sm" style="border-top-color: var(--warning);">
                                <div class="profile-img"><i class="fas fa-network-wired"></i></div>
                                <h6 class="fw-bold mb-1">Network Eng.</h6>
                                <p class="text-warning small fw-bold">Connectivity</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-card shadow-sm" style="border-top-color: var(--secondary);">
                                <div class="profile-img"><i class="fas fa-headset"></i></div>
                                <h6 class="fw-bold mb-1">IT Support</h6>
                                <p class="text-secondary small fw-bold">Helpdesk</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="glass-card h-100">
                        <h5 class="fw-bold mb-3"><i class="fas fa-bullseye text-primary me-2"></i>Visi IT PT. CMBP</h5>
                        <p class="small text-muted mb-4 italic">"Menjadi pilar teknologi yang andal dan inovatif untuk pertumbuhan berkelanjutan."</p>
                        <div class="info-box p-3 bg-white rounded-4 border mb-3">
                            <h6 class="fw-bold mb-1 small text-primary">Target 2026</h6>
                            <p class="mb-0 x-small text-muted">99.9% Network Uptime & ISO 27001 Security Standard.</p>
                        </div>
                        <img src="https://via.placeholder.com/300x150?text=Security+First" class="img-fluid rounded-4" alt="banner">
                    </div>
                </div>
            </div>
        </section>

        <section id="mapping" class="mb-5">
            <div class="glass-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h4 class="fw-bold mb-2">Topologi Infrastruktur</h4>
                        <p class="text-muted small mb-4">Skema interkoneksi antar gedung (Point-to-Point) dan distribusi jaringan lokal.</p>
                        <div class="topology-box">

                            <div class="text-center">
                                <i class="fas fa-project-diagram fa-3x text-muted opacity-25 mb-3"></i><br>
                                <span class="text-muted small">Klik untuk memperbesar Topologi High-Res</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ps-lg-4 mt-4 mt-lg-0">
                        <h6 class="fw-bold mb-3 text-uppercase small">Spesifikasi Jalur</h6>
                        <div class="p-3 bg-white rounded-4 border mb-3">
                            <p class="small mb-1 fw-bold text-primary"><i class="fas fa-bolt me-2"></i>Backbone</p>
                            <span class="x-small text-muted">Fiber Optic Core 12 Multimode (Gedung A-B)</span>
                        </div>
                        <div class="p-3 bg-white rounded-4 border mb-3">
                            <p class="small mb-1 fw-bold text-success"><i class="fas fa-wifi me-2"></i>Access Point</p>
                            <span class="x-small text-muted">Ubiquiti UniFi 6 Pro (34 Titik)</span>
                        </div>
                        <div class="p-3 bg-white rounded-4 border">
                            <p class="small mb-1 fw-bold text-danger"><i class="fas fa-shield-virus me-2"></i>Firewall</p>
                            <span class="x-small text-muted">FortiGate 60F Unified Threat Mgmt</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-dark text-white py-5">
        <div class="container text-center">
            <h4 class="fw-bold mb-2">PT. CMBP</h4>
            <p class="text-white-50 small mb-4">IT Operations Department - Operational Center</p>
            <div class="opacity-50">
                <i class="fab fa-linkedin mx-2"></i>
                <i class="fas fa-envelope mx-2"></i>
            </div>
            <hr class="my-4 opacity-25">
            <p class="x-small opacity-50 mb-0">© 2026 IT Management PT. CMBP. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper(".mySwiper", {
                // Pengaturan Dasar
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                grabCursor: true, // Mengubah kursor menjadi tangan saat hover

                // Autoplay
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false, // Autoplay tetap jalan meski user klik slide
                    pauseOnMouseEnter: true, // Berhenti saat mouse berada di atas slide
                },

                // Navigasi Custom
                navigation: {
                    nextEl: ".swiper-button-next-custom",
                    prevEl: ".swiper-button-prev-custom",
                },

                // Indikator Titik (Pagination)
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true, // Membuat titik pagination lebih cantik jika banyak
                },

                // Responsivitas (Breakpoint)
                breakpoints: {
                    // Mobile (Layar >= 640px)
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    // Tablet/Desktop (Layar >= 1024px)
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 25,
                    },
                },
            });
        });
    </script>
</body>

</html>
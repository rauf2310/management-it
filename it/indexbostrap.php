<?php
require 'ceklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PT.CMBP</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">PT.CMBP</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            IT HELP
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="mis.php">MIS / IT</a>
                                <a class="nav-link" href="user.php">Request User</a>
                                <a class="nav-link" href="detWo.php">Report WO</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            BARANG
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="bgunakan.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></i></div>
                                    Barang digunakan
                                </a>
                                <a class="nav-link" href="perlu_dipesan.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></i></div>
                                    Perlu dipesan
                                </a>
                                <a class="nav-link" href="bmasuk.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-folder-open"></i></i></div>
                                    Barang masuk / stock
                                </a>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventory" aria-expanded="false" aria-controls="collapseInventory">
                            <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                            INVENTORY IT
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="detKomputer.php">Komputer</a>
                                <a class="nav-link" href="detDVR.php">DVR & CCTV</a>
                                <a class="nav-link" href="detWo.php">Jaringan & Wifi</a>
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main id="content-to-refresh">
                <div class="container-fluid px-4">
                    <h1 class="mt-4">👨‍💻 Dashboard 👩‍💻</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Report MIS / IT PT.CMBP</li>
                    </ol>
                    <div class="row">

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>INFO Help MIS / IT</span>
                                    <span id="total-notif" class="badge bg-danger p-2" style="min-width: 30px;">
                                        0
                                    </span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="detmasalah.php">Lihat Detail Problem</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>Total Work Order</span>
                                    <span id="total-wo-notif" class="badge bg-danger p-2" style="min-width: 30px;">
                                        0
                                    </span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="detWo.php">Lihat Detail WO</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>Total Stock Barang</span>
                                    <span id="total-barang-notif" class="badge bg-danger p-2" style="min-width: 30px;">
                                        0
                                    </span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="bmasuk.php">Lihat Detail Stock</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary text-white mb-4">
                                <div class="card-body">Barang yang haruss dipesan</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="perlu_dipesan.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>





                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>Total DVR & CCTV</span>
                                    <span id="total-cctv-notif" class="badge bg-danger p-2" style="min-width: 30px;">
                                        0
                                    </span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="detDVR.php">Lihat Detail DVR & CCTV</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <span>Total Komputer</span>
                                    <span id="total-komputer-notif" class="badge bg-danger p-2" style="min-width: 30px;">
                                        0
                                    </span>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="detKomputer.php">Lihat Detail Komputer</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary text-white mb-4">
                                <div class="card-body">Total Penambahan PC, CCTV dan PRINTER</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Chart Work Order /Bulan
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Char bar WO /Tahun
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Jalankan fungsi refreshTotal setiap 5000 milidetik (2 detik)u/ total masalah
        //CODE MENGGUNAKAN JQUERY
        function refreshTotal() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_total.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Update isi span dengan data terbaru dari database
                    document.getElementById('total-notif').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
        // Jalankan fungsi setiap 2000ms (2 detik)
        setInterval(refreshTotal, 1000);

        // Jalankan fungsi refreshTotal setiap 5000 milidetik (2 detik) u/total barang
        //CODE MENGGUNAKAN VANILAJS
        $(document).ready(function() {
            function updateStock() {
                $.ajax({
                    url: 'get_totalbarang.php', // Mengarah ke file baru Anda
                    type: 'GET',
                    success: function(data) {
                        // Update angka di dalam span badge
                        $('#total-barang-notif').html(data);
                    },
                    error: function() {
                        console.error("Gagal mengambil data stok.");
                    }
                });
            }

            // Jalankan fungsi setiap 2000ms (5 detik)
            setInterval(updateStock, 1000);
        });

        // Jalankan fungsi refreshTotal setiap 5000 milidetik (2 detik) u/total wo
        //CODE MENGGUNAKAN VANILAJS
        $(document).ready(function() {
            function updateStock() {
                $.ajax({
                    url: 'get_totalwo.php', // Mengarah ke file baru Anda
                    type: 'GET',
                    success: function(data) {
                        // Update angka di dalam span badge
                        $('#total-wo-notif').html(data);
                    },
                    error: function() {
                        console.error("Gagal mengambil data stok.");
                    }
                });
            }

            // Jalankan fungsi setiap 2000ms (5 detik)
            setInterval(updateStock, 1000);
        });
        // Jalankan fungsi refreshTotal setiap 1000 milidetik (1 detik) u/total komputer
        //CODE MENGGUNAKAN VANILAJS
        $(document).ready(function() {
            function updateStock() {
                $.ajax({
                    url: 'get_totalKomputer.php', // Mengarah ke file baru Anda
                    type: 'GET',
                    success: function(data) {
                        // Update angka di dalam span badge
                        $('#total-komputer-notif').html(data);
                    },
                    error: function() {
                        console.error("Gagal mengambil data stok.");
                    }
                });
            }

            // Jalankan fungsi setiap 2000ms (5 detik)
            setInterval(updateStock, 1000);
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Problem - IT Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/stylesdetmasalah.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark m-0">
                <i class="fas fa-clipboard-list me-2"></i>Details HelpDesk 
                <span id="total-notif" class="badge bg-danger ms-2">0</span>
            </h3>
            <div class="no-print">
                <a href="index.php" class="btn bg-warning rounded-pill px-4"><i class="fas fa-home me-2"></i> Beranda</a>
                <!-- <button onclick="exportToCSV()" class="btn btn-success rounded-pill px-4"><i class="fas fa-file-excel me-2"></i> Export</button> -->
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Bagian</th>
                                <th>Problem</th>
                                <th>Waktu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="konten-tabel">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadData() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_detmasalah.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var respon = JSON.parse(xhr.responseText);
                    // Update isi tabel
                    document.getElementById('konten-tabel').innerHTML = respon.tabel;
                    // Update angka total
                    document.getElementById('total-notif').innerHTML = respon.total;
                }
            };
            xhr.send();
        }

        // Jalankan otomatis
        loadData(); 
        setInterval(loadData, 5000);

        function exportToCSV() {
            // ... (Fungsi export Anda yang lama di sini) ...
        }
    </script>
</body>

</html>
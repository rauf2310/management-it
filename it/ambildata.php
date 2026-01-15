<?php 
require "function.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Import Data - tbl_komputer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .upload-area {
            border: 2px dashed #dee2e6;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            background: #fff;
            transition: 0.3s;
        }
        .upload-area:hover {
            border-color: #0d6efd;
            background-color: #f1f7ff;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold">Manajemen Inventaris</h3>
                <p class="text-secondary">Silakan unggah file Excel untuk memperbarui <strong>tbl_komputer</strong></p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <?php if(isset($_GET['status'])): ?>
                        <?php if($_GET['status'] == 'success'): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>Data berhasil diimpor!</div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="proses_import.php" method="POST" enctype="multipart/form-data">
                        <div class="upload-area mb-4">
                            <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                            <h6 class="mb-2">Pilih File Excel Anda</h6>
                            <p class="small text-muted mb-3">Hanya mendukung format .xlsx atau .xls</p>
                            
                            <input class="form-control" type="file" name="file_excel" id="file_excel" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_import" class="btn btn-primary btn-lg">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Mulai Import Data
                            </button>
                            <button type="reset" class="btn btn-link btn-sm text-decoration-none text-muted">Batal</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="mt-4 p-3 bg-white rounded shadow-sm">
                <h6 class="fw-bold"><i class="fas fa-info-circle me-2 text-info"></i>Format Kolom Excel:</h6>
                <table class="table table-sm table-bordered mt-2 small">
                    <thead class="table-light">
                        <tr>
                            <th>Kolom A</th>
                            <th>Kolom B</th>
                            <th>Kolom C</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nama Komputer</td>
                            <td>Spesifikasi</td>
                            <td>Stok</td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-0 xsmall text-muted">*Pastikan baris pertama adalah judul kolom (header).</p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
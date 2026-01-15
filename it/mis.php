<?php
require 'function.php';

// Ambil ID dari URL (dikirim dari tombol 'Kerjakan')
$id_masalah = isset($_GET['id']) ? $_GET['id'] : '';
$id_hapus = isset($_GET['id']) ? $_GET['id'] : '';
$u = "";
$d = "";
$p = "";

// Opsional: Ambil detail masalah untuk ditampilkan sebagai info di form
$info_user = "";
if (!empty($id_masalah)) {
    // Ambil data lengkap: user, bagian, dan problem
    $ambil = mysqli_query($c, "SELECT * FROM tbl_masalah WHERE idmasalah = '$id_masalah'");
    if ($data = mysqli_fetch_assoc($ambil)) {
        $u = $data['nuser'];
        $d = $data['nbagian'];
        $p = $data['problem'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kerja Mis / IT</title>
    <link href="css/stylesmis.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <form method="POST" id="formLaporan">
        <input type="hidden" name="id_masalah_hapus" value="<?= $id_masalah; ?>">
        <input type="hidden" name="user" value="<?= $u; ?>">
        <input type="hidden" name="departement" value="<?= $d; ?>">
        <input type="hidden" name="problem_awal" value="<?= $p; ?>">
        <input type="hidden" name="id_masalah_hapus" value="<?= $id_hapus; ?>">

        <div class="container">
            <a href="index.php" class="btn-home" title="Kembali ke Beranda">
                <i class="fas fa-home"></i>
            </a>
            <h1>From Laporan Kerja IT</h1>

            <?php if (!empty($u)): ?>
                <div style="background: #000000ff; padding: 10px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #2196F3;">
                    <small>Mengerjakan Laporan:</small><br>
                    <strong><?= $u; ?></strong> (<?= $d; ?>) - <em><?= $p; ?></em>
                </div>
            <?php endif; ?>

            <div class="form-wrapper">
                <div class="input-card" data-tilt>
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="nama" placeholder="Nama" required autocomplete="off">
                </div>

                <div class="input-card card-large" data-tilt>
                    <i class="fas fa-hammer icon"></i>
                    <textarea name="pengerjaan" placeholder="Detail Pengerjaan" required autocomplete="off"></textarea>
                </div>

                <div class="input-card" data-tilt>
                    <i class="fas fa-microchip icon"></i>
                    <input list="cmpm-list" name="cm/pm" id="cmpm-input" placeholder="CM / PM" required autocomplete="off">
                    <datalist id="cmpm-list">
                        <option value="CM"></option>
                        <option value="PM"></option>
                    </datalist>
                </div>

                <div class="input-card" data-tilt>
                    <i class="fas fa-hammer icon"></i>
                    <input list="kategori-list1" name="hardware" id="pkjc-input" placeholder="P / K / J / C " autocomplete="off">
                    <datalist id="kategori-list1">
                        <option value="Printer"></option>
                        <option value="Komputer"></option>
                        <option value="Jaringan"></option>
                        <option value="CCTV"></option>
                    </datalist>
                </div>

                <div class="input-card" data-tilt>
                    <i class="fas fa-tag icon"></i>
                    <input list="kategori-list" name="kategori" id="kategori-input" class="form-control" placeholder="Pilih Kategori" required autocomplete="off">
                    <datalist id="kategori-list">
                        <option value="Hardware"></option>
                        <option value="Software"></option>
                        <option value="Network"></option>
                        <option value="Administrasi"></option>
                    </datalist>
                </div>

                <div class="input-card" data-tilt>
                    <i class="fas fa-tools icon"></i>
                    <input list="bpakai-listn" name="barangpakai" id="barang-input" class="form-control" placeholder="Nama Barang / kosongkan" autocomplete="off">
                    <datalist id="bpakai-listn">
                        <?php
                        $query1 = mysqli_query($c, "SELECT nmbarang FROM tbl_stock");
                        while ($data = mysqli_fetch_array($query1)) {
                            echo "<option value='" . $data['nmbarang'] . "'>";
                        }
                        ?>
                    </datalist>
                </div>

                <div class="input-card" data-tilt>
                    <i class="fas fa-list-ol icon"></i>
                    <input type="number" name="jumlah" placeholder="Jumlah / kosongkan">
                </div>
                <div class="input-card" data-tilt>
                    <i class="fas fa-calendar-plus icon"></i>
                    <input type="text" name="mulai" placeholder="Waktu Mulai"
                        onfocus="(this.type='datetime-local')"
                        onblur="if(!this.value)this.type='text'" required>
                </div>
                <div class="input-card" data-tilt>
                    <i class="fas fa-calendar-plus icon"></i>
                    <input type="text" name="selesai" placeholder="Waktu Selesai"
                        onfocus="(this.type='datetime-local')"
                        onblur="if(!this.value)this.type='text'" required>
                </div>
                <div class="input-card" data-tilt>
                    <i class="fas fa-clock icon"></i>
                    <input list="kategori-list2" type="text" name="durasi" id="durasi_pengerjaan" placeholder="Waktu Pengerjaan" readonly>
                </div>

                <button type="submit" name="submit_laporan" class="submit-button" data-tilt>Kirim Data</button>
            </div>
        </div>
    </form>

    <script type="text/javascript" src="https://unpkg.com/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>

    <script>
        // Fungsi Validasi Datalist
        function setupValidation(inputId, listId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);

            input.addEventListener('blur', function() {
                const options = Array.from(list.options).map(opt => opt.value);
                if (input.value !== "" && !options.includes(input.value)) {
                    alert("Pilihan '" + input.value + "' tidak ada dalam daftar. Mohon pilih opsi yang tersedia.");
                    input.value = ""; // Mengosongkan kembali jika salah
                    input.focus();
                }
            });
        }

        // Jalankan validasi untuk semua field yang menggunakan datalist
        setupValidation('cmpm-input', 'cmpm-list');
        setupValidation('kategori-input', 'kategori-list');
        setupValidation('barang-input', 'bpakai-listn');
        setupValidation('pkjc-input', 'kategori-list1');
    </script>
</body>

</html>
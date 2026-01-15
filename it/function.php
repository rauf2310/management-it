<?php

session_start();


//  <--buat koneksi -->
$c = mysqli_connect('localhost', 'root', '', 'it');

// <-- untuk cek koneksi -->
// if ($c) {
//     echo '<script>alert("berhasil");</script>';
// }

// buat function login user
if (isset($_POST['login'])) {
    // inisialisasi variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check  = mysqli_query($c, "SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if ($hitung > 0) {
        // jika data ditemukan
        // login berhasil
        $_SESSION['login'] = 'true';
        header('location:index.php');
        exit;
    } else {
        // data tidak ditemukan
        // gagal login
        echo '
        <script>
        alert("Username atau Password Salah !! ");
        window.location.href="login.php"
        </script>
        ';
    }
}

// tambah barang baru u/bmasuk.php
if (isset($_POST['tambahbarangbaru'])) {
    $nmb = mysqli_real_escape_string($c, $_POST['nmbarang']);
    $jumlah     = (int)$_POST['jumlah'];

    // 1. Cek apakah barang dengan nama dan merek yang sama sudah ada
    $cek_stok = mysqli_query($c, "SELECT * FROM tbl_stock WHERE nmbarang='$nmb'");
    $data = mysqli_fetch_array($cek_stok);

    if (mysqli_num_rows($cek_stok) > 0) {
        // 2. Jika ADA, ambil jumlah lama dan tambahkan dengan jumlah baru
        $jumlah_sekarang = $data['jumlah'];
        $jumlah_baru = $jumlah_sekarang + $jumlah;

        // Update stok yang ada
        $query_aksi = mysqli_query($c, "UPDATE tbl_stock SET jumlah='$jumlah_baru' WHERE nmbarang='$nmb'");
    } else {
        // 3. Jika TIDAK ADA, masukkan sebagai baris baru
        $query_aksi = mysqli_query($c, "INSERT INTO tbl_stock (nmbarang,jumlah) VALUES ('$nmb', '$jumlah')");
    }

    // Redirect setelah sukses
    if ($query_aksi) {
        header('location:bmasuk.php');
    } else {
        echo '
        <script>
        alert("Gagal memproses data barang !! ");
        window.location.href="bmasuk.php"
        </script>
        ';
    }
}

//edit barang u/bmasuk.php
if (isset($_POST['editbarang'])) {
    $idm      = $_POST['idm']; // ID dari input hidden
    $nmbarang = $_POST['nmbarang'];
    $jumlah   = $_POST['jumlah'];

    $update = mysqli_query($c, "UPDATE tbl_stock SET nmbarang='$nmbarang', jumlah='$jumlah' WHERE idstock='$idm'");

    if ($update) {
        header('location:bmasuk.php'); // atau halaman Anda saat ini
    } else {
        echo "Gagal Update Data";
    }
}

//menyimpan data masalah u/user.php
if (isset($_POST['kirimrequest'])) {
    // 1. Ambil data (Pastikan name di POST sama dengan name di HTML)
    $nreq   = $_POST['namarequest'];   // Diubah dari namarequser jadi namarequest
    $breq   = $_POST['bagianrequest'];
    $req    = $_POST['request'];

    // 2. Query INSERT (Pastikan nama kolom di database sesuai: nuser, nbagian, problem)
    $simpan = mysqli_query($c, "INSERT INTO tbl_masalah (nuser, nbagian, problem) 
                                   VALUES ('$nreq', '$breq', '$req')");

    if ($simpan) {
        echo "<script>
                alert('Berhasil mengirim permintaan bantuan!');
                window.location.href='user.php'; 
              </script>";
    } else {
        // Menampilkan pesan error jika query gagal
        echo "<script>
                alert('Gagal mengirim data: " . mysqli_error($conn) . "');
              </script>";
    }
}

//tombol simpan mis.php menghapuss masalah dan menghapus stock barang
if (isset($_POST['submit_laporan'])) {
    $id_masalah     = $_POST['id_masalah_hapus'];
    // Data tambahan dari tbl_masalah (u, d, p)
    $u_user         = mysqli_real_escape_string($c, $_POST['user']);
    $d_dept         = mysqli_real_escape_string($c, $_POST['departement']);
    $p_problem      = mysqli_real_escape_string($c, $_POST['problem_awal']);

    $nama           = mysqli_real_escape_string($c, $_POST['nama']);
    $pengerjaan     = mysqli_real_escape_string($c, $_POST['pengerjaan']);
    $cmpm           = mysqli_real_escape_string($c, $_POST['cm/pm']);
    $pkjc           = mysqli_real_escape_string($c, $_POST['hardware']);
    $kategori       = mysqli_real_escape_string($c, $_POST['kategori']);

    // --- TAMBAHAN DATA WAKTU ---
    $mulai          = mysqli_real_escape_string($c, $_POST['mulai']);
    $selesai        = mysqli_real_escape_string($c, $_POST['selesai']);
    $worktime       = mysqli_real_escape_string($c, $_POST['durasi']); // Mengambil nilai dari input durasi

    // Mengambil name="barangpakai"
    $nama_barang    = trim(mysqli_real_escape_string($c, $_POST['barangpakai']));
    $jumlah_dipakai = (int)$_POST['jumlah'];

    // 1. Simpan ke tbl_mis
    $add_to_mis = mysqli_query($c, "INSERT INTO tbl_mis (user, departement, problem, nama, pengerjaan, cm_pm, hardware, kategori, barangpakai, jumlah, mulai, selesai, worktime) 
                     VALUES ('$u_user', '$d_dept', '$p_problem', '$nama', '$pengerjaan', '$cmpm', '$pkjc', '$kategori', '$nama_barang', '$jumlah_dipakai', '$mulai', '$selesai', '$worktime')");

    if ($add_to_mis) {
        // 2. Hapus antrean tbl_masalah
        if (!empty($id_masalah)) {
            mysqli_query($c, "DELETE FROM tbl_masalah WHERE idmasalah = '$id_masalah'");
        }

        // 3. Logika Potong Stok
        if (!empty($nama_barang) && $jumlah_dipakai > 0) {

            // Cari barang di tbl_stock
            $query_cek = mysqli_query($c, "SELECT * FROM tbl_stock WHERE nmbarang = '$nama_barang'");
            $data_stok = mysqli_fetch_assoc($query_cek);

            if ($data_stok) {
                $stok_sekarang = (int)$data_stok['jumlah']; // Sesuai nama kolom Anda: jumlah

                if ($stok_sekarang >= $jumlah_dipakai) {
                    $stok_baru = $stok_sekarang - $jumlah_dipakai;

                    // Update stok
                    $update = mysqli_query($c, "UPDATE tbl_stock SET jumlah = '$stok_baru' WHERE nmbarang = '$nama_barang'");

                    if ($update) {
                        echo "<script>alert('Berhasil! Sisa stok $nama_barang sekarang: $stok_baru'); window.location.href='detmasalah.php';</script>";
                    }
                } else {
                    echo "<script>alert('Gagal! Stok $nama_barang tidak cukup (Sisa: $stok_sekarang)'); window.location.href='detmasalah.php';</script>";
                }
            } else {
                // Jika masuk ke sini, nama barang yang diinput tidak ada di tbl_stock
                echo "<script>alert('Laporan tersimpan, tapi stok tidak berkurang karena nama barang [$nama_barang] tidak cocok dengan data di gudang.'); window.location.href='detmasalah.php';</script>";
            }
        } else {
            echo "<script>alert('Laporan Berhasil disimpan tanpa pemakaian barang.'); window.location.href='detmasalah.php';</script>";
        }
    }
}

// update data ASET u/detAset.php <___________________________-
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. LOGIKA UPDATE KOMPUTER
    if (isset($_POST['update_kom'])) {
        $idkom        = $_POST['idkom'];
        $dept         = mysqli_real_escape_string($c, $_POST['dept']);
        $npengguna    = mysqli_real_escape_string($c, $_POST['npengguna']);
        $useraccount  = mysqli_real_escape_string($c, $_POST['useraccount']);
        $kodea        = mysqli_real_escape_string($c, $_POST['kode_aset']);
        $perangkat    = mysqli_real_escape_string($c, $_POST['perangkat']); // Pastikan input hidden ada
        $prosesor     = mysqli_real_escape_string($c, $_POST['prosesor']);
        $motherboard  = mysqli_real_escape_string($c, $_POST['motherboard']);
        $memory       = mysqli_real_escape_string($c, $_POST['memory']);
        $videog       = mysqli_real_escape_string($c, $_POST['videog']);
        $namapc       = mysqli_real_escape_string($c, $_POST['namapc']);
        $ipaddreses   = mysqli_real_escape_string($c, $_POST['ipaddreses']);
        $macaddreses  = mysqli_real_escape_string($c, $_POST['mac']);
        $storage      = mysqli_real_escape_string($c, $_POST['storage']);
        $monitor      = mysqli_real_escape_string($c, $_POST['monitor']);
        $psu          = mysqli_real_escape_string($c, $_POST['psu']);
        $cassing      = mysqli_real_escape_string($c, $_POST['cassing']);
        $kategori     = mysqli_real_escape_string($c, $_POST['kategori_group']);

        // Cek duplikasi Kode Aset selain ID yang sedang diedit
        $cekKode = mysqli_query($c, "SELECT * FROM tbl_komputer WHERE kode_aset = '$kodea' AND idkom <> '$idkom'");

        if (mysqli_num_rows($cekKode) > 0) {
            echo "<script>
                alert('Gagal Update! Kode Aset ($kodea) sudah digunakan.');
                window.history.back();
              </script>";
        } else {
            $queryUpdate = "UPDATE tbl_komputer SET 
            dept = '$dept', 
            npengguna = '$npengguna', 
            useraccount = '$useraccount', 
            kode_aset = '$kodea', 
            perangkat = '$perangkat', 
            prosesor = '$prosesor', 
            motherboard = '$motherboard', 
            memory = '$memory', 
            videog = '$videog', 
            namapc = '$namapc', 
            ipaddreses = '$ipaddreses', 
            macaddreses = '$macaddreses', 
            storage = '$storage', 
            monitor = '$monitor', 
            psu = '$psu', 
            cassing = '$cassing',
            kategori_group = '$kategori',
            tgl_update = NOW() 
            WHERE idkom = '$idkom'";

            if (mysqli_query($c, $queryUpdate)) {
                echo "<script>alert('Data Komputer Berhasil Diupdate 👍'); window.location='detAset.php';</script>";
            } else {
                echo "Error: " . mysqli_error($c);
            }
        }
    }

    // --- 2. LOGIKA UPDATE LAPTOP ---
    if (isset($_POST['update_lapt'])) {
        // Ambil ID
        $idlap = mysqli_real_escape_string($c, $_POST['id_laptop']);

        // Ambil data sesuai dengan 'name' di form HTML
        $pengguna     = mysqli_real_escape_string($c, $_POST['pengguna']);
        $devisi       = mysqli_real_escape_string($c, $_POST['devisi_laptop']);
        $prosesor     = mysqli_real_escape_string($c, $_POST['prosesor']);
        $ram          = mysqli_real_escape_string($c, $_POST['ram']);
        $storage      = mysqli_real_escape_string($c, $_POST['storage']);
        $ip_laptop    = mysqli_real_escape_string($c, $_POST['ip_laptop']);
        $tipe_laptop  = mysqli_real_escape_string($c, $_POST['tipe_laptop']);
        $os           = mysqli_real_escape_string($c, $_POST['os']);
        $sn_laptop    = mysqli_real_escape_string($c, $_POST['sn_laptop']);
        $kategori     = mysqli_real_escape_string($c, $_POST['kategori_group']);
        $kode_laptop  = mysqli_real_escape_string($c, $_POST['kode_laptop']);
        $perangkat    = mysqli_real_escape_string($c, $_POST['perangkat']);

        // UPDATE Query (Pastikan nama kolom di tabel Anda benar)
        // Saya asumsikan nama kolom database mengikuti standar tbl_laptop Anda sebelumnya
        $queryUpdatelapt = "UPDATE tbl_laptop SET 
        pengguna        = '$pengguna', 
        devisi_laptop   = '$devisi', 
        perangkat       = '$perangkat', 
        prosesor        = '$prosesor', 
        ram             = '$ram', 
        storage         = '$storage', 
        ip_laptop       = '$ip_laptop', 
        tipe_laptop     = '$tipe_laptop', 
        os              = '$os', 
        sn_laptop       = '$sn_laptop', 
        kategori_group  = '$kategori',
        kode_laptop     = '$kode_laptop',
        tgl_update      = NOW() 
        WHERE id_laptop = '$idlap'";

        if (mysqli_query($c, $queryUpdatelapt)) {
            echo "<script>
                alert('Data Laptop Berhasil Diupdate 👍'); 
                window.location.href='detAset.php';
              </script>";
        } else {
            // die() akan menghentikan halaman sehingga Anda bisa membaca errornya
            die("Error pada database: " . mysqli_error($c));
        }
    }

    // --- 3. LOGIKA UPDATE PRINTER ---
    // Menangani Update Data Perangkat (Printer, Scanner, Fotocopy)
    if (isset($_POST['updatePrinter'])) {
        $idp          = mysqli_real_escape_string($c, $_POST['id_printer']);
        $pengguna     = mysqli_real_escape_string($c, $_POST['pengguna']);
        $departemen   = mysqli_real_escape_string($c, $_POST['departemen']);
        $kategori     = mysqli_real_escape_string($c, $_POST['kategori_group']);
        $spesifikasi  = mysqli_real_escape_string($c, $_POST['spesifikasi_prangkat']);
        $ip_perangkat = mysqli_real_escape_string($c, $_POST['ip_perangkat']);
        $perangkat    = mysqli_real_escape_string($c, $_POST['perangkat']);

        // 2. Query Update ke Database
        $queryUpdate = "UPDATE tbl_printer SET 
                        pengguna             = '$pengguna',
                        departemen           = '$departemen',
                        kategori_group       = '$kategori',
                        spesifikasi_prangkat = '$spesifikasi',
                        ip_perangkat         = '$ip_perangkat'
                    WHERE id_printer = '$idp'";

        // 3. Eksekusi Query dan Cek Hasil
        if (mysqli_query($c, $queryUpdate)) {
            echo "<script>
                alert('Data $perangkat berhasil diperbarui!');
                window.location.href='detAset.php';
              </script>";
        } else {
            echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($c) . "');
                window.location.href='detAset.php';
              </script>";
        }
    }

    // --- 4. LOGIKA UPDATE DVR ---
    if (isset($_POST['update_dvr'])) {
        $idd    = mysqli_real_escape_string($c, $_POST['id_dvr']);
        $dept   = mysqli_real_escape_string($c, $_POST['devisi_dvr']);
        $ipdvr  = mysqli_real_escape_string($c, $_POST['ip_dvr']);
        $kode   = mysqli_real_escape_string($c, $_POST['kode_dvr']);
        $chand  = mysqli_real_escape_string($c, $_POST['channel_dvr']);
        $spekd  = mysqli_real_escape_string($c, $_POST['spesifikasi_dvr']);
        $kategori     = mysqli_real_escape_string($c, $_POST['kategori_group']);

        // Validasi Duplicate Kode (Kecuali milik sendiri)
        $cek = mysqli_query($c, "SELECT * FROM tbl_dvr WHERE kode_dvr = '$kode' AND id_dvr <> '$idd'");

        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Gagal! Kode $kode sudah digunakan DVR lain.'); window.history.back();</script>";
        } else {
            $queryUpdateDvr = "UPDATE tbl_dvr SET 
            devisi_dvr      = '$dept', 
            ip_dvr          = '$ipdvr',
            kode_dvr        = '$kode', 
            channel_dvr     = '$chand', 
            spesifikasi_dvr = '$spekd', 
            kategori_group  = '$kategori', 
            tgl_update      = NOW() 
            WHERE id_dvr    = '$idd'";

            if (mysqli_query($c, $queryUpdateDvr)) {
                echo "<script>alert('Data DVR Berhasil Diupdate 👍'); window.location='detAset.php';</script>";
            } else {
                echo "Gagal Update: " . mysqli_error($c);
            }
        }
    }

    // --- 5. LOGIKA UPDATE ROUTER ---
    if (isset($_POST['editRouter'])) {
        // 1. Ambil data dari form dan bersihkan (Security)
        $id_router        = mysqli_real_escape_string($c, $_POST['id_router']);
        $divisi           = mysqli_real_escape_string($c, $_POST['divisi']);
        $kategori         = mysqli_real_escape_string($c, $_POST['kategori']);
        $spesifikasi_alat = mysqli_real_escape_string($c, $_POST['spesifikasi_alat']);
        $link_access      = mysqli_real_escape_string($c, $_POST['link_access']);
        $mac_address      = mysqli_real_escape_string($c, $_POST['mac_address']);
        $username_admin   = mysqli_real_escape_string($c, $_POST['username_admin']);
        $password_admin   = mysqli_real_escape_string($c, $_POST['password_admin']);
        $ssid_name        = mysqli_real_escape_string($c, $_POST['ssid_name']);
        $ssid_password    = mysqli_real_escape_string($c, $_POST['ssid_password']);
        $channel_24g      = mysqli_real_escape_string($c, $_POST['channel_24g']);
        $channel_50g      = mysqli_real_escape_string($c, $_POST['channel_50g']);

        // 2. Query Update
        $queryUpdate = "UPDATE tbl_router SET 
                        divisi           = '$divisi',
                        kategori         = '$kategori',
                        spesifikasi_alat = '$spesifikasi_alat',
                        link_access      = '$link_access',
                        mac_address      = '$mac_address',
                        username_admin   = '$username_admin',
                        password_admin   = '$password_admin',
                        ssid_name        = '$ssid_name',
                        ssid_password    = '$ssid_password',
                        channel_24g      = '$channel_24g',
                        channel_50g      = '$channel_50g'
                    WHERE id_router = '$id_router'";

        // 3. Eksekusi
        if (mysqli_query($c, $queryUpdate)) {
            echo "<script>
                alert('Berhasil memperbarui data router!');
                window.location.replace('detAset.php'); 
              </script>";
        } else {
            echo "<script>
                alert('Gagal memperbarui: " . mysqli_error($c) . "');
              </script>";
        }
    }
}

// TAMBAH data komputer u/detAset.php
if (isset($_POST['addnewkomputer'])) {
    // Ambil data dari form (Identitas)
    $dept         = mysqli_real_escape_string($c, $_POST['dept']);
    $npengguna    = mysqli_real_escape_string($c, $_POST['npengguna']);
    $useraccount  = mysqli_real_escape_string($c, $_POST['useraccount']);
    $kategori_group    = mysqli_real_escape_string($c, $_POST['kategori_group']);
    $perangkat    = mysqli_real_escape_string($c, $_POST['perangkat']);

    // Ambil data dari form (Hardware Core)
    $prosesor     = mysqli_real_escape_string($c, $_POST['prosesor']);
    $memory       = mysqli_real_escape_string($c, $_POST['memory']);
    $videog       = mysqli_real_escape_string($c, $_POST['videog']);
    $motherboard  = mysqli_real_escape_string($c, $_POST['motherboard']);

    // Ambil data dari form (Network)
    $namapc       = mysqli_real_escape_string($c, $_POST['namapc']);
    $ipaddreses   = mysqli_real_escape_string($c, $_POST['ipaddreses']);
    $macaddreses  = mysqli_real_escape_string($c, $_POST['mac']);

    // Ambil data dari form (Component)
    $storage      = mysqli_real_escape_string($c, $_POST['storage']);
    $monitor      = mysqli_real_escape_string($c, $_POST['monitor']);
    $psu          = mysqli_real_escape_string($c, $_POST['psu']);
    $cassing      = mysqli_real_escape_string($c, $_POST['cassing']);
    // $keyboard     = mysqli_real_escape_string($c, $_POST['keyboard']);
    // $mouse        = mysqli_real_escape_string($c, $_POST['mouse']);

    // Query Insert ke Database
    $query = "INSERT INTO tbl_komputer (
                dept, npengguna, useraccount, perangkat, 
                prosesor, memory, videog, motherboard, 
                namapc, ipaddreses, macaddreses, 
                storage, monitor, psu, cassing, kategori_group
              ) VALUES (
                '$dept', '$npengguna', '$useraccount', '$perangkat', 
                '$prosesor', '$memory', '$videog', '$motherboard', 
                '$namapc', '$ipaddreses', '$macaddreses', 
                '$storage', '$monitor', '$psu', '$cassing', '$kategori_group'
              )";

    $simpan = mysqli_query($c, $query);

    if ($simpan) {
        echo "<script>
                alert('Data Komputer Baru Berhasil ditambahkan 👍');
                window.location.href='detAset.php';
              </script>";
    } else {
        // Jika gagal, tampilkan error
        echo "Gagal menyimpan data: " . mysqli_error($c);
    }
}

// TAMBAH data laptop u/ detAset.php
if (isset($_POST['addnewLaptop'])) {
    // Pastikan koneksi $c tersedia

    $pengguna   = mysqli_real_escape_string($c, $_POST['pengguna']);
    $devisi     = mysqli_real_escape_string($c, $_POST['devisi_laptop']);
    $prosesor   = mysqli_real_escape_string($c, $_POST['prosesor']);
    $memory     = mysqli_real_escape_string($c, $_POST['memory']);
    $storage    = mysqli_real_escape_string($c, $_POST['storage']);
    $perangkat  = mysqli_real_escape_string($c, $_POST['perangkat']);
    $ip_laptop  = mysqli_real_escape_string($c, $_POST['ip_laptop']);
    $tipe_merk  = mysqli_real_escape_string($c, $_POST['tipe_laptop']);
    $os         = mysqli_real_escape_string($c, $_POST['os']);
    $sn_laptop  = mysqli_real_escape_string($c, $_POST['sn_laptop']);
    $kategori   = mysqli_real_escape_string($c, $_POST['kategori_group']);

    // Query - Pastikan nama kolom ram vs memory sudah sesuai dengan struktur table anda
    $query = "INSERT INTO tbl_laptop (
                devisi_laptop, pengguna, perangkat, tipe_laptop, 
                prosesor, ram, storage, os, sn_laptop, 
                kategori_group, ip_laptop
              ) VALUES (
                '$devisi', '$pengguna', '$perangkat', '$tipe_merk', 
                '$prosesor', '$memory', '$storage', '$os', '$sn_laptop', 
                '$kategori', '$ip_laptop'
              )";

    if (mysqli_query($c, $query)) {
        echo "<script>
                alert('Data Laptop Baru Berhasil ditambahkan 👍');
                window.location.href='detAset.php';
              </script>";
    } else {
        // Menampilkan pesan error yang lebih spesifik jika gagal
        echo "<script>alert('Gagal simpan: " . mysqli_error($c) . "');</script>";
    }
}

// TAMBAH data printer/aset u/detAset.php
if (isset($_POST['addnewPrinter'])) {
    $pengguna      = mysqli_real_escape_string($c, $_POST['pengguna']);
    $dept          = mysqli_real_escape_string($c, $_POST['departemen']);
    $kategori_g    = mysqli_real_escape_string($c, $_POST['kategori_group']);
    $spesifikasi   = mysqli_real_escape_string($c, $_POST['spesifikasi_prangkat']);
    $ip_perangkat  = mysqli_real_escape_string($c, $_POST['ip_perangkat']);
    $perangkat     = mysqli_real_escape_string($c, $_POST['perangkat']);

    $querySave = "INSERT INTO tbl_printer (
        departemen, 
        pengguna, 
        ip_perangkat, 
        perangkat, 
        spesifikasi_prangkat, 
        kategori_group
    ) VALUES (
        '$dept', 
        '$pengguna', 
        '$ip_perangkat', 
        '$perangkat', 
        '$spesifikasi', 
        '$kategori_g'
    )";

    if (mysqli_query($c, $querySave)) {
        echo "<script>
                alert('Berhasil menyimpan data $perangkat');
                window.location.href='detAset.php';
              </script>";
    } else {
        echo "Gagal Simpan: " . mysqli_error($c);
    }
}

// TAMBAH data DVR u/detAset.php
if (isset($_POST['addnewDVR'])) {
    // Ambil data dari form (Identitas)
    $dept         = mysqli_real_escape_string($c, $_POST['dept']);
    $ip           = mysqli_real_escape_string($c, $_POST['ip']);
    $lokasi  = mysqli_real_escape_string($c, $_POST['lokasi']);
    $perangkat    = mysqli_real_escape_string($c, $_POST['perangkat']);
    $spek    = mysqli_real_escape_string($c, $_POST['spesifikasi']);
    $channel    = mysqli_real_escape_string($c, $_POST['channel']);
    $kategori_group  = mysqli_real_escape_string($c, $_POST['kategori_group']);

    // Query Insert ke Database
    $query = "INSERT INTO tbl_dvr (
                devisi_dvr, perangkat, ip_dvr, channel_dvr,
                lokasi_simpan, spesifikasi_dvr, kategori_group
              ) VALUES (
                '$dept', '$perangkat', '$ip', '$channel',
                '$lokasi', '$spek', '$kategori_group'
              )";

    $simpan = mysqli_query($c, $query);

    if ($simpan) {
        echo "<script>
                alert('Data DVR Baru Berhasil ditambahkan 👍');
                window.location.href='detAset.php';
              </script>";
    } else {
        // Jika gagal, tampilkan error
        echo "Gagal menyimpan data: " . mysqli_error($c);
    }
}

// TAMBAH data router u/detAset.php
if (isset($_POST['addnewRouter'])) {
    // 1. Tangkap data dari form modal dan bersihkan
    $kategori         = mysqli_real_escape_string($c, $_POST['kategori']);
    $divisi           = mysqli_real_escape_string($c, $_POST['divisi']);
    $spesifikasi_alat = mysqli_real_escape_string($c, $_POST['spesifikasi_alat']);
    $link_access      = mysqli_real_escape_string($c, $_POST['link_access']);
    $mac_address      = mysqli_real_escape_string($c, $_POST['mac_address']);
    $username_admin   = mysqli_real_escape_string($c, $_POST['username_admin']);
    $password_admin   = mysqli_real_escape_string($c, $_POST['password_admin']);
    $ssid_name        = mysqli_real_escape_string($c, $_POST['ssid_name']);
    $ssid_password    = mysqli_real_escape_string($c, $_POST['ssid_password']);
    $channel_24g      = mysqli_real_escape_string($c, $_POST['channel_24g']);
    $channel_50g      = mysqli_real_escape_string($c, $_POST['channel_50g']);
    $perangkat        = mysqli_real_escape_string($c, $_POST['perangkat']);

    // 2. Query INSERT (Sudah diperbaiki koma yang berlebih)
    $query = "INSERT INTO tbl_router (
                kategori, 
                divisi, 
                perangkat, 
                spesifikasi_alat, 
                link_access, 
                mac_address, 
                username_admin, 
                password_admin, 
                ssid_name, 
                ssid_password, 
                channel_24g, 
                channel_50g
              ) VALUES (
                '$kategori', 
                '$divisi', 
                '$perangkat', 
                '$spesifikasi_alat', 
                '$link_access', 
                '$mac_address', 
                '$username_admin', 
                '$password_admin', 
                '$ssid_name', 
                '$ssid_password', 
                '$channel_24g', 
                '$channel_50g'
              )";

    // 3. Eksekusi query
    if (mysqli_query($c, $query)) {
        echo "<script>
                alert('Berhasil! Data Router telah tersimpan.');
                window.location.href = 'detAset.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan: " . mysqli_error($c) . "');
              </script>";
    }
}

// HAPUS data ASSET u/detAset.php
if (isset($_POST['proses_hapus'])) {
    $id   = mysqli_real_escape_string($c, $_POST['id_data']);
    $tipe = mysqli_real_escape_string($c, $_POST['tipe_data']);

    $tabel = "";
    $kolom = "";

    if ($tipe == 'komputer') {
        $tabel = "tbl_komputer";
        $kolom = "idkom";
    } elseif ($tipe == 'printer') {
        $tabel = "tbl_printer";
        $kolom = "id_printer";
    } elseif ($tipe == 'dvr') {
        $tabel = "tbl_dvr";
        $kolom = "id_dvr";
    } elseif ($tipe == 'laptop') {
        $tabel = "tbl_laptop";
        $kolom = "id_laptop";
    } elseif ($tipe == 'router') {
        $tabel = "tbl_router";
        $kolom = "id_router";
    }

    if ($tabel != "" && $kolom != "") {
        $sql = "DELETE FROM $tabel WHERE $kolom = '$id'";
        $hapus = mysqli_query($c, $sql);

        if ($hapus) {
            // Gunakan window.location.replace agar tidak muncul pesan "Confirm Form Resubmission"
            echo "<script>
                    alert('Data $tipe berhasil dihapus!'); 
                    window.location.replace('detAset.php');
                  </script>";
        } else {
            echo "Error: " . mysqli_error($c);
        }
    } else {
        echo "<script>alert('Tipe perangkat tidak dikenali!');</script>";
    }
}


// TAMBAH DVR BARU U/detDVR.php
if (isset($_POST['submit_dvr'])) {
    // 1. Tangkap data dari form modal
    // Gunakan mysqli_real_escape_string untuk mencegah SQL Injection
    $nama_barang = mysqli_real_escape_string($c, $_POST['namabarang']);
    $code_aset   = mysqli_real_escape_string($c, $_POST['code']);
    $divisi      = mysqli_real_escape_string($c, $_POST['divisi']);
    $user_dvr    = mysqli_real_escape_string($c, $_POST['user']);
    $ip_dvr      = mysqli_real_escape_string($c, $_POST['ip']);
    $channel     = mysqli_real_escape_string($c, $_POST['channel']); // Mengambil nilai seperti "16 Channel"
    $spesifikasi = mysqli_real_escape_string($c, $_POST['spesifikasi']);

    // 2. Query Insert ke Database
    // Sesuaikan nama tabel (tbl_dvr) dan nama kolomnya
    $querySimpan = "INSERT INTO tbl_dvr (namabarang, code, devisi, user, ip, channel, spesifikasi) 
                    VALUES ('$nama_barang', '$code_aset', '$divisi', '$user_dvr', '$ip_dvr', '$channel', '$spesifikasi')";

    $eksekusi = mysqli_query($c, $querySimpan);

    // 3. Notifikasi Berhasil atau Gagal
    if ($eksekusi) {
        echo "
        <script>
            alert('Data Tambah DVR Berhasil Disimpan 👍');
            window.location.href='detDVR.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal menyimpan data: " . mysqli_error($c) . "');
            window.location.href='detDVR.php';
        </script>";
    }
}


// update tombol update dvr u/detDVR.php 
if (isset($_POST['updatedvr'])) {
    $id_alat     = $_POST['id_alat'];
    $devisi      = mysqli_real_escape_string($c, $_POST['devisi']);
    $user        = mysqli_real_escape_string($c, $_POST['user']);
    $namabarang  = mysqli_real_escape_string($c, $_POST['namabarang']);
    $code        = mysqli_real_escape_string($c, $_POST['code']);
    $ip          = mysqli_real_escape_string($c, $_POST['ip']);
    $channel     = mysqli_real_escape_string($c, $_POST['channel']); // Akan menangkap "4 Channel", dll
    $spesifikasi = mysqli_real_escape_string($c, $_POST['spesifikasi']);
    $tgl_update  = date('Y-m-d H:i:s');

    $queryUpdate = "UPDATE tbl_dvr SET 
        devisi      = '$devisi', 
        user        = '$user', 
        namabarang  = '$namabarang', 
        code        = '$code', 
        ip          = '$ip', 
        channel     = '$channel', 
        spesifikasi = '$spesifikasi',
        tgl_update  = '$tgl_update'
        WHERE id_alat = '$id_alat'";

    if (mysqli_query($c, $queryUpdate)) {
        echo "<script>alert('Data Berhasil Diperbarui 👍'); window.location.href='detDVR.php';</script>";
    } else {
        echo "Error: " . mysqli_error($c);
    }
}

// untuk hapus pada table dvr u/detDVR.php 
if (isset($_POST['hapusasset'])) {
    $id_alat = $_POST['id_alat'];

    // Query untuk menghapus data berdasarkan ID
    $queryHapus = mysqli_query($c, "DELETE FROM tbl_dvr WHERE id_alat = '$id_alat'");

    if ($queryHapus) {
        echo "<script>alert('Data Berhasil Dihapus!'); window.location.href='detDVR.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($c) . "');</script>";
    }
}

// TAMBAH CCTV BARU U/detDVR.php
if (isset($_POST['addnewcctv'])) {

    // Ambil data dari input name="..."
    $devisi      = mysqli_real_escape_string($c, $_POST['devisi']);
    $nama_kamera = mysqli_real_escape_string($c, $_POST['nama_kamera']);
    $lokasi      = mysqli_real_escape_string($c, $_POST['lokasi']);

    $query = "INSERT INTO tbl_cctv (devisi, nkamera, lokasi) VALUES ('$devisi', '$nama_kamera', '$lokasi')";
    // quesry insert ke database

    $simpan = mysqli_query($c, $query);
    if ($simpan) {
        echo "<script>
                alert('Data CCTV berhasil disimpan 👍');
                window.location.href = 'detDVR.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($c);
    }
}

<?php
require 'function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Halaman Login Aplikasi" />
    <meta name="author" content="" />
    <title>Request</title>
    <link href="css/stylesuser.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <!-- <a href="index.php" class="btn-home" title="Kembali ke Beranda">
            <i class="fas fa-home"></i>
        </a> -->
        <h2>FORM HELP IT</h2>
        <form method="POST">
            <div class="input-group">
                <input class="form-control" id="inputUsername" name="namarequest" type="text" placeholder="Nama" required autocomplete="off">
            </div>
            <div class="input-group">
                <input class="form-control" id="inputPassword" name="bagianrequest" type="text" placeholder="Bagian / Departement" required autocomplete="off">
            </div>
            <div class="input-group">
                <div class="input-group">
                    <textarea class="form-control" name="request" type="text" placeholder="Deskripsi Problem" required autocomplete="off"></textarea>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" name="kirimrequest">Kirim</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
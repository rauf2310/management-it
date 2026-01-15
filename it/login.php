<?php
require 'function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - Dept IT</title>
    <link rel="icon" type="image/png" href="assets/img/logo1.png">
    <link href="styleslogin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form method="POST">
            <div class="input-group">
                <input id="inputUsername" name="username" type="text" placeholder="Username" required autocomplete="off">
            </div>
            <div class="input-group">
                <input id="inputPassword" name="password" type="password" placeholder="Password" required autocomplete="off">
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
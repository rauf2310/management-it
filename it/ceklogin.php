<?php 

require 'function.php';

if(isset($_SESSION['login'])){
    //maka login
} else {
    header('location:login.php');
}


?>
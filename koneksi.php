<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "localhost";
$user = "root";
$password = "";
$nama_database = "ikhsan";
$db = mysqli_connect($server, $user, $password, $nama_database);
if( !$db ){
die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

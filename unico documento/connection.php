<?php
echo '<pre>';
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'certificados2';

$connect = new mysqli($host, $user, $password, $database);
if ($connect->connect_errno) {
  echo 'Falha ao conectar: (' . $connect->connect_errno . ") " . $connect->connect_error;
}

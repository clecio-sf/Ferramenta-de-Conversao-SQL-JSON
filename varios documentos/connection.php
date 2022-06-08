<?php
echo '<pre>';
$host = 'localhost';
$user = 'root';
$pASsword = '';
$databASe = 'certificados';

$connect = new mysqli($host, $user, $pASsword, $databASe);
if ($connect->connect_errno) {
  echo 'Falha ao conectar: (' . $connect->connect_errno . ") " . $connect->connect_error;
}

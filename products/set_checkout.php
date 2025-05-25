<?php
session_start();
include_once("../config.php");

if (!isset($_SESSION['user'])) {
  header("Location: ../login/");
  exit();
}

// Ambil data dari fetch JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id_peyek'])) {
  http_response_code(400);
  echo "Data tidak lengkap";
  exit();
}

$jumlah_harga = $data['jumlah'] * $data['harga'];

// Simpan ke session
$_SESSION['checkout'] = [
  'id_peyek' => $data['id_peyek'],
  'nama' => $data['nama'],
  'topping' => $data['topping'],
  'harga' => $data['harga'],
  'jumlah' => $data['jumlah'],
  'jumlah_harga' => $jumlah_harga,
  'gambar' => $data['gambar']
];

// Tidak perlu query ulang ke DB karena semua data sudah dikirim dari JS
echo "Checkout disimpan";
?>
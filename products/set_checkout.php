<?php
session_start();
include_once("../config.php");

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
  header("Location: ../login/");
  exit();
}

// Ambil data dari GET atau POST
$id_peyek = $_GET['id'] ?? $_POST['id'] ?? null;
$jumlah = $_GET['jumlah'] ?? $_POST['jumlah'] ?? 1; // default 1

if (!$id_peyek) {
  echo "ID produk tidak ditemukan.";
  exit();
}

// Query data peyek dari database
$query = "SELECT * FROM peyek WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_peyek);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "Produk tidak ditemukan.";
  exit();
}

$data = $result->fetch_assoc();

// Simpan ke session checkout
$_SESSION['checkout'] = [
  'id_peyek' => $data['id'],
  'nama' => $data['nama'],
  'topping' => $data['topping'],
  'harga' => $data['harga'],
  'jumlah' => $jumlah,
  'gambar' => $data['gambar']
];

// Redirect ke halaman checkout
header("Location: ../order/index.php");
exit();
?>
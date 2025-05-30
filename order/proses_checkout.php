<?php
session_start();
include_once("../config.php");// koneksi ke database

// Asumsi sudah login
$user =  $_SESSION['user'] ?? null;
if (!$user) {
    die("User belum login.");
}

$id_user = $user['id_user'] ?? null;
// Ambil data dari POST
$pemesan = $_POST['pemesan'];
$telepon = $_POST['telepon'];
$kecamatan = $_POST['kecamatan'];
$desa = $_POST['desa'];
$alamat = $_POST['alamat'];
$pesan = $_POST['pesan'] ?? '';
$metode_pembayaran = $_POST['payment']; // Ambil salah satu
$hrg_ongkir = 5000; //jika ada ongkir tetap, bisa diubah sesuai logika bisnis
$diskon = 2000; // bisa dihitung otomatis kalau ada logika diskon
$biaya_admin = 0; // contoh
$jumlah = $_SESSION['checkout']['jumlah'] ?? 1;
$harga = $_SESSION['checkout']['harga'] ?? 20000;
$id_peyek = $_SESSION['checkout']['id_peyek'] ?? 'P001';

// Validasi lokasi
$stmt = $conn->prepare("SELECT id_lokasi FROM lokasi WHERE kecamatan = ? AND desa = ?");
$stmt->bind_param("ss", $kecamatan, $desa);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if (!$row) {
    die("Lokasi tidak valid");
}
$id_lokasi = $row['id_lokasi'];

// Hitung total bayar
$jumlah_bayar = ($jumlah * $harga) + $hrg_ongkir + $biaya_admin - $diskon;

// 1. Simpan ke payment
$stmt = $conn->prepare("INSERT INTO payment (metode, biaya_admin, jumlah_bayar) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $metode_pembayaran, $biaya_admin, $jumlah_bayar);
$stmt->execute();
$id_payment = $conn->insert_id;

// 2. Simpan ke orders
$stmt = $conn->prepare("INSERT INTO orders (id_user, id_lokasi, pesan, id_payment, hrg_ongkir, diskon) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiii", $id_user, $id_lokasi, $pesan, $id_payment, $hrg_ongkir, $diskon);
$stmt->execute();
$id_order = $conn->insert_id;

// 3. Simpan ke order_items
$stmt = $conn->prepare("INSERT INTO order_items (id_order, id_peyek, jumlah_kg, harga_per_kg) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isdi", $id_order, $id_peyek, $jumlah, $harga);
$stmt->execute();

// Redirect ke halaman sukses atau tampilkan pesan
header("Location: checkout_sukses.php?id_order=$id");
exit;
?>

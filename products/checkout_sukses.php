<?php
session_start();
include_once("../config.php");

if (!isset($_GET['id_order'])) {
    die("ID order tidak ditemukan.");
}

$id_order = (int) $_GET['id_order'];

// Ambil data order
$sql = "SELECT o.*, p.metode, p.jumlah_bayar, p.tgl_payment, l.kecamatan, l.desa 
        FROM orders o
        JOIN payment p ON o.id_payment = p.id_payment
        JOIN lokasi l ON o.id_lokasi = l.id_lokasi
        WHERE o.id_order = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_order);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order tidak ditemukan.");
}

$order = $result->fetch_assoc();

// Ambil item pemesanan
$stmt = $conn->prepare("SELECT oi.*, py.nama_peyek FROM order_items oi
                        JOIN peyek py ON oi.id_peyek = py.id_peyek
                        WHERE oi.id_order = ?");
$stmt->bind_param("i", $id_order);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0bf0f4e.js" crossorigin="anonymous"></script>
    <style>
        *{
            zoom: 110%;
        }
        body {
            padding-top: 80px; /* agar tidak tertutup navbar */
            background-color: #f8f9fa;
        }

        nav{
            background-color: #C6AC66;
            font-family: 'Courier New', Courier, monospace;
            font-size: smaller;
            height: 60px;
        }

        footer {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
            background-color: #c8ae7c;
        }

        .social-icons a {
            font-size: 1.25rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white me-3" href="../login/">Login</a>
                <a class="nav-link d-inline text-white" href="#">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main class="container flex-grow-1">
        <div class="text-center mb-4">
            <h2>🎉 Pemesanan Berhasil!</h2>
            <p class="lead">Terima kasih atas pesanan Anda. Berikut adalah detail pemesanan:</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Informasi Order</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>ID Order:</strong> <?= $order['id_order'] ?></li>
                    <li class="list-group-item"><strong>Tanggal Pesan:</strong> <?= $order['tgl_pesan'] ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= ucfirst($order['status']) ?></li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5>Alamat Pengiriman</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Kecamatan:</strong> <?= htmlspecialchars($order['kecamatan']) ?></li>
                    <li class="list-group-item"><strong>Desa:</strong> <?= htmlspecialchars($order['desa']) ?></li>
                    <li class="list-group-item"><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($order['pesan'])) ?></li>
                </ul>
            </div>
        </div>

        <h5>Detail Produk</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah (kg)</th>
                        <th>Harga/kg</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($items as $item):
                        $sub = $item['jumlah_kg'] * $item['harga_per_kg'];
                        $subtotal += $sub;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_peyek']) ?></td>
                            <td><?= $item['jumlah_kg'] ?> kg</td>
                            <td>Rp<?= number_format($item['harga_per_kg'], 0, ',', '.') ?></td>
                            <td>Rp<?= number_format($sub, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h5>Ringkasan Pembayaran</h5>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Subtotal:</strong> Rp<?= number_format($subtotal, 0, ',', '.') ?></li>
            <li class="list-group-item"><strong>Ongkir:</strong> Rp<?= number_format($order['hrg_ongkir'], 0, ',', '.') ?></li>
            <li class="list-group-item"><strong>Diskon:</strong> Rp<?= number_format($order['diskon'], 0, ',', '.') ?></li>
            <li class="list-group-item"><strong>Biaya Admin:</strong> Rp<?= number_format($order['jumlah_bayar'] - $subtotal - $order['hrg_ongkir'] + $order['diskon'], 0, ',', '.') ?></li>
            <li class="list-group-item"><strong>Total Bayar:</strong> <span class="fw-bold">Rp<?= number_format($order['jumlah_bayar'], 0, ',', '.') ?></span></li>
        </ul>

        <h5>Metode Pembayaran</h5>
        <p><?= strtoupper($order['metode']) ?> (dibayar pada <?= $order['tgl_payment'] ?>)</p>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-3">
        <div class="container">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 mb-md-0 mb-3">
                    <h5 class="text-dark fw-bold mb-2">Peyek Kriuk ENI</h5>
                    <div class="social-icons">
                        <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6 text-md-end">
                    <p class="text-dark mb-1">085229297152</p>
                    <p class="text-muted mb-0">Terbis, Kismantoro, Wonogiri, Jawa Tengah</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

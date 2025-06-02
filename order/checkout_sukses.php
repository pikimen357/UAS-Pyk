<?php
session_start();
include_once("../config.php");

// Redirect jika tidak login
if (!isset($_SESSION['user'])) {
    header("Location: ../login/");
    exit();
}

$user = $_SESSION['user'];

if (!isset($_GET['id'])) {
    die("ID order tidak ditemukan.");
}

$id_order = (int) $_GET['id'];

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
        /* * {
            zoom: 100%;
        } */

        body {
            padding-top: 80px;
            /* agar tidak tertutup navbar */
            background-color: #f8f9fa;
        }

        nav {
            background-color: #C6AC66;
            font-family: 'Courier New', Courier, monospace;
            font-size: smaller;
            height: 70px;
        }

        .sub-navbar {
            background-color: rgb(255, 252, 247);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            margin-top: 65px;
            /* Adjust sesuai tinggi navbar utama */
            height: 50px;
        }

        .sub-navbar .nav-link {
            color: #000000 !important;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
            margin: 0 5px;
        }


        .sub-navbar .nav-link.active {
            /* background-color: rgba(255, 255, 255, 0.3); */
            font-weight: 600;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .sub-navbar {
                padding: 10px 0;
            }

            .sub-navbar .nav-link {
                padding: 6px 15px;
                margin: 2px;
                font-size: 14px;
            }
        }

        main {
            margin-top: 70px;
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
                <a class="nav-link d-inline text-white fw-bold" href="#"><?= strtoupper(htmlspecialchars($user['nama'])) ?></a>
            </div>
        </div>
    </nav>


    <nav class="sub-navbar fixed-top">
        <div class="container">
            <ul class="nav justify-content-evenly">
                <li class="nav-item">
                    <a class="nav-link" href="../products/index.php">Daftar Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../orders/index.php">Pesanan Anda</a>
                </li>
            </ul>
        </div>
    </nav>



    <!-- Konten -->
    <main class="container flex-grow-1">

        <div class="container p-5 bg-white shadow-sm rounded mb-2" style="font-size: smaller;">


            <div class="text-center mb-5">
                <h2> Pemesanan Berhasil!</h2>
                <p class="lead">Terima kasih atas pesanan Anda</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <h5>Informasi Order</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID Order:</strong><br> <?= $order['id_order'] ?></li>
                        <li class="list-group-item"><strong>Tanggal Pesan:</strong><br> <?= $order['tgl_pesan'] ?></li>
                        <li class="list-group-item"><strong>Status:</strong><br> <?= strtoupper($order['status']) ?></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h5>Alamat Pengiriman</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Kecamatan:</strong><br> <?= htmlspecialchars($order['kecamatan']) ?></li>
                        <li class="list-group-item"><strong>Desa:</strong><br> <?= htmlspecialchars($order['desa']) ?></li>
                        <li class="list-group-item"><strong>Alamat:</strong><br> <?= nl2br(htmlspecialchars($order['alamat_kirim'])) ?></li>
                    </ul>
                </div>
            </div>

            <h5>Detail Produk</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
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
            <ul class="list-group mb-4" style="font-size: larger;">
                <li class="list-group-item"><strong>Subtotal:</strong> Rp<?= number_format($subtotal, 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Ongkir:</strong> Rp<?= number_format($order['hrg_ongkir'], 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Diskon:</strong> Rp<?= number_format($order['diskon'], 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Biaya Admin:</strong> Rp<?= number_format($order['jumlah_bayar'] - $subtotal - $order['hrg_ongkir'] + $order['diskon'], 0, ',', '.') ?></li>
                <li class="list-group-item"><strong>Total Bayar:</strong> <span class="fw-bold">Rp<?= number_format($order['jumlah_bayar'], 0, ',', '.') ?></span></li>
            </ul>

            <h5>Metode Pembayaran</h5>
            <?php if ($order['metode'] == 'qris') : ?>
                <img src="../assets/qris.png" alt="" srcset="" style="width: 100px; height: 45px;">
            <?php elseif ($order['metode'] == 'gopay') : ?>
                <img src="../assets/gopay.png" alt="" srcset="" style="width: 100px; height: 45px;">
            <?php elseif ($order['metode'] == 'cod') : ?>
                <img src="../assets/cod.png" alt="" srcset="" style="width: 100px; height: 45px;">

            <?php endif; ?>
            <!-- <p class="fw-bold" style="font-size: x-large"><?= strtoupper($order['metode']) ?></p> -->


            <?php if ($order['status'] == 'belum bayar') : ?>
                <form action="proses_pembayaran.php" method="POST">
                    <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                    <div class="row mb-4 mt-3">
                        <div class="col-md-6 text-center mt-4">
                            <button type="submit" id="btnBayar" class="btn btn-primary p-3" style="width: 190px;">Bayar Sekarang</button>
                        </div>
                        <div class="col-md-6 text-center mt-4">
                            <a href="../orders/index.php" class="btn btn-secondary p-3" style="width: 190px;">Kembali</a>
                        </div>
                    </div>
                </form>
            <?php elseif ($order['status'] == 'diproses') : ?>
                <div class="container">
                    <p class="mt-3 fs-5 fst-italic" style="font-family:'Times New Roman', 'Times, serif';">
                        Dibayar pada: <?php echo $order['tgl_payment'] ?>
                    </p>
                </div>
                <div class="text-center mt-4">
                    <a href="../orders/index.php" class="btn btn-primary p-3" style="width: 190px;">Kembali</a>
                </div>
            <?php elseif ($order['status'] == 'selesai') : ?>
                <div class="text-center mt-4 fs-4">
                    <a href="#" class="btn btn-success p-3" style="width: 190px;">Review</a>
                </div>
            <?php endif ?>


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
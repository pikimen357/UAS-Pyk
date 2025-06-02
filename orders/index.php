<?php
session_start();
include_once("../config.php");

// Redirect jika tidak login
if (!isset($_SESSION['user'])) {
  header("Location: ../login/");
  exit();
}

$user = $_SESSION['user'];
$user_id = $user['id_user'];

$sql = "SELECT o.id_order,p2.nama_peyek,p2.gambar ,oi.jumlah_kg,o.tgl_pesan, p.jumlah_bayar, o.status  FROM orders
JOIN Peyek.order_items oi on orders.id_order = oi.id_order
JOIN Peyek.payment p on p.id_payment = orders.id_payment
JOIN Peyek.peyek p2 on p2.id_peyek = oi.id_peyek
JOIN Peyek.orders o on o.id_order = oi.id_order
WHERE o.id_user = $user_id";
$result = $conn->query($sql);

// Function to format currency
function formatRupiah($angka) {
    return "Rp" . number_format($angka, 0, ',', '.');
}

// Function to format date
function formatTanggal($tanggal) {
    return date('d F Y', strtotime($tanggal));
}

// Function to get status badge class
function getStatusBadge($status) {
    switch(strtolower($status)) {
        case 'selesai':
            return 'bg-primary text';
        case 'belum bayar':
            return 'bg-danger text';
        case 'diproses':
            return 'bg-success text-white';
        case 'dibatalkan':
            return 'bg-secondary';
        default:
            return 'bg-primary';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
    <style>
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

        footer h5{
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            font-size: 28px;
            color: #333;
        }

        .order-list {
            margin-bottom: 30px;
        }

        .order-card {
            background-color: #f3f0e9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .order-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .order-date, .order-price {
            color: #666;
            font-size: 14px;
        }

        .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #C6AC66;
            border-color: #C6AC66;
            padding: 8px 16px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #b39b59;
            border-color: #b39b59;
        }

        .pagination .page-link {
            color: #2a2821;
        }

        .pagination .page-item.active .page-link {
            background-color: #e6e2d7;
            border-color: #ddd8cc;
            color: white;
        }

        .social-icons a {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .img-fluid{
            max-width: 300px;
        }

        @media (max-width: 768px) {
            .img-fluid{
                max-width: 100px;
            }
            
            .social-icons {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/index.php">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white me-3" href="../login/index.php">Login</a>
                <a class="nav-link d-inline text-white" href="#"><?= strtoupper(htmlspecialchars($user['nama'])) ?></a>
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


    <!-- Main Content -->
    <main class="d-flex justify-content-center  container pt-5" style="margin-top: 90px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-4 fw-bold">Daftar Pesanan</h2>
                
                <!-- Order Cards -->
                <div class="order-list mb-5">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="order-card mb-4 rounded">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                                        <img src="<?php echo !empty($row['gambar']) ? '../assets/' . $row['gambar'] : '../assets/default.png'; ?>" 
                                             alt="<?php echo htmlspecialchars($row['nama_peyek']); ?>" 
                                             class="img-fluid rounded w-100" style="width: 100%; height: auto;">
                                    </div>
                                    <div class="col-md-7 col-sm-9">
                                        <h5 class="order-title">
                                            <?php echo htmlspecialchars($row['nama_peyek']); ?> 
                                            (<?php echo $row['jumlah_kg']; ?> kg)
                                        </h5>
                                        <p class="order-date mb-1">
                                            Tanggal: <?php echo formatTanggal($row['tgl_pesan']); ?>
                                        </p>
                                        <p class="order-price mb-1">
                                            Total: <?php echo formatRupiah($row['jumlah_bayar']); ?>
                                        </p>
                                        <!-- <span class="badge <?php echo getStatusBadge($row['status']); ?> p-3 w-50 mt-4" >
                                            <?php echo ucfirst($row['status']); ?>
                                        </span> -->
                                    </div>
                                    <div class="col-md-3  mt-3 mt-md-0 text-md-end">
                                        <button  type="button" class="btn <?php echo getStatusBadge($row['status']); ?> btn-sm text-white fw-bold p-2 rounded" style="width: 110px;"  onclick="lihatDetail(<?php echo $row['id_order']; ?>)">
                                            <?php echo ucfirst($row['status']); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">Tidak ada pesanan</h4>
                            <p>Anda belum memiliki pesanan apapun. Silakan mulai berbelanja untuk melihat riwayat pesanan Anda di sini.</p>
                            <hr>
                            <p class="mb-0">
                                <a href="../landing/index.php" class="btn btn-primary">Mulai Belanja</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                

            </div>
        </div>
    </main>

    <footer class="mt-auto py-3">
        <div class="container">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 mb-md-0 mb-3">
                    <h5 class="text-white fw-bold mb-2">Peyek Kriuk ENI</h5>
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
                    <p class="text-dark mb-0 text-muted">Terbis, Kismantoro, Wonogiri, Jawa Tengah</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function lihatDetail(idOrder) {
            // Redirect ke halaman detail pesanan
            window.location.href = '../order/checkout_sukses.php?id=' + idOrder;
        }
    </script>
    <script src="./app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>
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
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/index.php">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white me-3" href="../login/index.php">Login</a>
                <a class="nav-link d-inline text-white" href="#">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="d-flex container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-4 fw-bold">Daftar Pesanan</h2>
                
                <!-- Order Cards -->
                <div class="order-list">
                    <!-- Order 1 -->
                    <div class="order-card mb-3 rounded" style="background-color: #f3f0e9; max-width: 340px;">
                        <div class="row align-items-center p-3">
                            <div class="col-md-2 col-sm-3 mb-3 mb-md-0">
                                <img src="../assets/pkacang.png" alt="Peyek Kacang" class="img-fluid rounded" style="width: 300px;">
                            </div>
                            <div class="col-md-7 col-sm-9">
                                <h5 class="order-title">Peyek Kacang (0,5 kg)</h5>
                                <p class="order-date mb-1">Tanggal: 21 Mei 2024</p>
                                <p class="order-price mb-1">Total: Rp28.500</p>
                                <span class="badge bg-success">Selesai</span>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                <button class="btn btn-primary">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order 2 -->
                    <div class="order-card mb-3 rounded" style="background-color: #f3f0e9; max-width: 340px;">
                        <div class="row align-items-center p-3">
                            <div class="col-md-2 col-sm-3 mb-3 mb-md-0">
                                <img src="../assets/rebon.png" alt="Peyek Kacang" class="img-fluid rounded" style="width: 300px;">
                            </div>
                            <div class="col-md-7 col-sm-9">
                                <h5 class="order-title">Peyek Udang (0,5 kg)</h5>
                                <p class="order-date mb-1">Tanggal: 18 Mei 2024</p>
                                <p class="order-price mb-1">Total: Rp32.500</p>
                                <span class="badge bg-warning text-dark">Dikirim</span>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                <button class="btn btn-primary">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order 3 -->
                    <div class="order-card mb-3 rounded" style="background-color: #f3f0e9; max-width: 340px;">
                        <div class="row align-items-center p-3">
                            <div class="col-md-2 col-sm-3 mb-3 mb-md-0">
                                <img src="../assets/rebon.png" alt="Peyek Teri" class="img-fluid rounded" style="width: 300px;">
                            </div>
                            <div class="col-md-7 col-sm-9">
                                <h5 class="order-title">Peyek Teri (1 kg)</h5>
                                <p class="order-date mb-1">Tanggal: 15 Mei 2024</p>
                                <p class="order-price mb-1">Total: Rp55.000</p>
                                <span class="badge bg-success">Selesai</span>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                <button class="btn btn-primary">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order 4 -->
                    <div class="order-card mb-3 rounded" style="background-color: #f3f0e9; max-width: 340px;">
                        <div class="row align-items-center p-3">
                            <div class="col-md-2 col-sm-3 mb-3 mb-md-0">
                                <img src="../assets/kedelai.png" alt="Peyek Mix" class="img-fluid rounded" style="width: 300px;">
                            </div>
                            <div class="col-md-7 col-sm-9">
                                <h5 class="order-title">Peyek Mix (0,5 kg)</h5>
                                <p class="order-date mb-1">Tanggal: 10 Mei 2024</p>
                                <p class="order-price mb-1">Total: Rp30.000</p>
                                <span class="badge bg-secondary">Dibatalkan</span>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                <button class="btn btn-primary">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <!-- <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav> -->
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

    <script src="./app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>
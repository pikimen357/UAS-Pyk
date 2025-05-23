<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white me-3" href="../login/">Login</a>
                <a class="nav-link d-inline text-white" href="#">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="order-container p-4">
                    <h2 class="text-center mb-4">Detail Pemesanan</h2>
                    
                    <div class="product-info mb-4">
                        <div class="text-center mb-3">
                            <img src="../assets/pkacang.png" alt="Peyek Kacang" class="product-image">
                        </div>
                        <h4 class="product-title">Peyek Kacang (0,5 kg)</h4>
                        <p class="product-description text-muted">Kacang Tanah</p>
                    </div>
                    
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="pemesan" class="form-label">Pemesan</label>
                                <input type="text" class="form-control" id="pemesan" placeholder="Rahmad">
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon (WhatsApp)</label>
                                <input type="text" class="form-control" id="telepon" placeholder="085324521">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" placeholder="Kismantoro">
                            </div>
                            <div class="col-md-6">
                                <label for="desa" class="form-label">Desa</label>
                                <input type="text" class="form-control" id="desa" placeholder="Plosorejo">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Detail Alamat</label>
                            <textarea class="form-control" id="alamat" rows="3" placeholder="RT.02 RW.01 (Depan rumah pak kades)"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="pesan" class="form-label">Pesan Khusus</label>
                            <textarea class="form-control" id="pesan" rows="3" placeholder="Tolong peyeknya jangan terlalu keras"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="payment-methods">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="gopay" checked>
                                    <label class="form-check-label" for="gopay">
                                        <img src="../assets/gopay.png" alt="GoPay" class="payment-logo">
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="qris">
                                    <label class="form-check-label" for="qris">
                                        <img src="../assets/qris.png" alt="QRIS" class="payment-logo">
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="cod">
                                    <label class="form-check-label" for="cod">
                                        <img src="../assets/cod.png" alt="COD" class="payment-logo">
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="price-summary mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <p>Harga: Rp25.000/kg</p>
                                    <p>Ongkir: Rp5.000</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p>Biaya admin: Rp500</p>
                                    <p>Diskon: Rp2.000</p>
                                </div>
                            </div>
                            <div class="total-price">
                                <h5 class="text-center">Total: Rp28.500</h5>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg" id="beli">Beli</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-auto py-3" style="background-color: #c8ae7c;">
        <div class="container ">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 mb-md-0 mb-3">
                    <h5 class="text-white fw-bold mb-0">Peyek Kriuk ENI</h5>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-md-6 text-md-end">
                    <p class="text-dark mb-1">Telp: 085229297152</p>
                    <p class="text-dark mb-0 text-muted">Kismantoro, Wonogiri, Jawa Tengah</p>
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
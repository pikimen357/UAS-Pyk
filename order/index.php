<?php
session_start();
include_once("../config.php");

// Redirect jika tidak login
if (!isset($_SESSION['user'])) {
  header("Location: ../login/");
  exit();
}

$user = $_SESSION['user'];
$checkout = $_SESSION['checkout'] ?? null;

$lokasi_list = [];
$res = mysqli_query($conn, "SELECT * FROM lokasi");
while ($row = mysqli_fetch_assoc($res)) {
    $lokasi_list[] = $row;
}

if (!$checkout) {
  echo "Tidak ada data produk untuk checkout.";
  exit();
}



$ongkir = 5000; // Asumsi ongkir tetap
$diskon = 2000;

// $total = ($checkout['jumlah'] * $checkout['harga']) + $ongkir + $biaya_admin - $diskon;
?>

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
                            <img src="<?= htmlspecialchars($checkout['gambar']) ?>" alt="Produk" class="product-image">
                        </div>
                        <h4 class="product-title"><?= htmlspecialchars($checkout['nama']) ?> (<?= $checkout['jumlah'] ?> kg)</h4>
                        <p class="product-description text-muted"><?= htmlspecialchars($checkout['topping']) ?></p>
                    </div>

                    
                    <form method="post" action="proses_checkout.php">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="pemesan" class="form-label">Pemesan</label>
                                <input type="text" class="form-control" id="pemesan" name="pemesan"
                                    value="<?= htmlspecialchars($user['nama']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon (WhatsApp)</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                    value="<?= htmlspecialchars($user['telepon'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label" for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" onchange="filterDesa()" class="form-select" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <?php
                                    $unique_kec = array_unique(array_column($lokasi_list, 'kecamatan'));
                                    foreach ($unique_kec as $kec) {
                                        $selected = ($user['kecamatan'] ?? '') === $kec ? 'selected' : '';
                                        echo "<option value=\"$kec\" $selected>$kec</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="desa">Desa</label>
                                <select name="desa" id="desa" class="form-select" required>
                                    <option value=""><?= htmlspecialchars($user['desa'] ?? 'Pilih Desa') ?></option>
                                </select>
                            </div>
                        </div>



                        <div class="mb-3">
                            <label for="alamat" class="form-label">Detail Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($user['alamat']) ?></textarea>

                        </div>

                        <div class="mb-4">
                            <label for="pesan" class="form-label">Pesan Khusus</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="payment-methods">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="gopay" value="gopay" checked>
                                    <label class="form-check-label" for="gopay">
                                        <img src="../assets/gopay.png" alt="GoPay" class="payment-logo">
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="qris" value="qris">
                                    <label class="form-check-label" for="qris">
                                        <img src="../assets/qris.png" alt="QRIS" class="payment-logo">
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment" id="cod" value="cod">
                                    <label class="form-check-label" for="cod">
                                        <img src="../assets/cod.png" alt="COD" class="payment-logo">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="price-summary mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <p>Harga: Rp<?= number_format($checkout['jumlah_harga'], 0, ',', '.') ?></p>
                                    <p>Ongkir: Rp5.000</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="fst-italic">Diskon: Rp<?= number_format($diskon, 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <div class="total-price">
                                <h5 class="text-center">Total: Rp<?= 
                                // $total = ($checkout['jumlah'] * $checkout['harga']) + $ongkir + $biaya_admin - $diskon;
                                $tot_ech = number_format(($checkout['jumlah'] * $checkout['harga']) + $ongkir + $biaya_admin - $diskon, 0, ',', '.') ?></h5>
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

    <script>
            const lokasiList = <?= json_encode($lokasi_list) ?>;

            function filterDesa() {
                const kecamatan = document.getElementById('kecamatan').value;
                const desaSelect = document.getElementById('desa');

                // Kosongkan desa
                desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

                // Filter desa berdasarkan kecamatan
                const desaList = lokasiList.filter(loc => loc.kecamatan === kecamatan);

                desaList.forEach(loc => {
                    const option = document.createElement('option');
                    option.value = loc.desa;
                    option.textContent = loc.desa;
                    desaSelect.appendChild(option);
                });

                // Jika user sebelumnya sudah punya desa, coba set lagi secara otomatis
                <?php if (!empty($user['desa'])): ?>
                    const userDesa = <?= json_encode($user['desa']) ?>;
                    desaSelect.value = userDesa;
                <?php endif; ?>
            }

            // Auto trigger saat load (jika ada default dari user)
            window.addEventListener('DOMContentLoaded', function () {
                <?php if (!empty($user['kecamatan'])): ?>
                    document.getElementById('kecamatan').value = <?= json_encode($user['kecamatan']) ?>;
                    filterDesa();
                <?php endif; ?>
            });
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
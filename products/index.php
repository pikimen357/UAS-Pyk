<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/index.php");
    exit();
}
$user = $_SESSION['user'];

include_once("../config.php");

$sql = "SELECT * FROM peyek";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Beli Peyek</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
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



  <main>
    <div class="d-flex justify-content-center align-items-center container" id="orderCont">
      <div class="box-wrapper row gap-1 mt-2" style="width: 380px;">
        <div class="col  mt-2" style="margin-right: 8px;">
          <img src="../assets/pkacang.png" class="mt-1" id="topImg" data-id="pkcg" alt="">
        </div>
        <div class="col  mt-2" id="col2">
          <h5 id="Pkacang">Peyek Kacang</h5>
          <p id="hargaDisplay" style="font-size: 10px;"><strong>Rp50.000/kg</strong></p>
          <p id="toping" class="transparent-text">Toping kacang tanah</p>
          <label for="jumlah" style="font-size: 10px;">Jumlah (kg):</label>
          <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
            <button type="button" class="btn btn-outline-dark" id="minus"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .5rem;">−</button>
            <input type="text" class="form-control form-control-sm" id="jumlah" value="0.5" readonly>
            <button type="button" class="btn btn-outline-dark" id="plus"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .5rem;">＋</button>
          </div>
          <p class="mt-2" id="harga" value="50000"></p>
        </div>

        <button class="btn btn-dark btn-sm mt-2 p-2 mb-2" id="checkout">Checkout</button>
      </div>
    </div>


    <div class="d-flex justify-content-center container p-4 mt-5" id="varCont">
      <div class="row w-100 mb-5" style="max-width: 600px;">
        <h2 id="varianLain" class="mb-4 fw-bold fs-3">Varian Lainnya</h2>
        <?php while($row = $result->fetch_assoc()) { ?>
          <div class="col varian-item p-3 mb-4" style="line-height: 22px; cursor: pointer;"
            data-id="<?= $row['id_peyek'] ?>"
            data-nama="<?= $row['nama_peyek'] ?>"
            data-harga="<?= $row['hrg_kiloan'] ?>"
            data-topping="<?= $row['topping'] ?>"
            data-gambar="<?= $row['gambar'] ?>">
            <img src="<?= $row['gambar'] ?>" class="Vlimg" alt="">
            <h3 class="mt-3" style="font-size: 13.5px;"><?= $row['nama_peyek'] ?></h3>
            <p>
              <span class="transparent-text"><?= ucfirst($row['topping']) ?></span><br>
              Rp<?= number_format($row['hrg_kiloan'], 0, ',', '.') ?>/kg
            </p>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>

  <footer class="mt-auto py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-md-0 mb-3">
          <h5 class="text-white fw-bold mb-2">Peyek Kriuk ENI</h5>
          <div class="social-icons">
            <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-dark me-2"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="text-dark me-2"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-md-6 text-md-end">
          <p class="text-dark mb-1">085229297152</p>
          <p class="text-dark mb-0 text-muted">Terbis, Kismantoro, Wonogiri, Jawa Tengah</p>
        </div>
      </div>
    </div>
  </footer>


  <script src="app.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>

</html>

<?php $conn->close(); ?>

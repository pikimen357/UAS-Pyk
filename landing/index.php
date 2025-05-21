<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white me-3" href="http://localhost:3000/signup/index.php">Daftar</a>
                <a class="nav-link d-inline text-white" href="http://localhost:3000/login/index.php">Login</a>
            </div>
        </div>
    </nav>

    <main >
        <div class="container mb-2 p-4">
            <h1 class="fw-bold mt-4">Peyek Kriuk Pawon Eny</h1>
            <p class="transparent-text">Rempeyek renyah dipadukan dengan citarasa <br>khas bumbu daerah yang menggugah
                selera.</p>
            <button type="button"  id="pesan1"   class="btn btn-dark">Pesan Sekarang</button>
        </div>

        <img src="../assets/pkacang.png" class="p-4" id="topImg" alt="">

        <div class="container mb-3 p-4">
            <h2 class="fw-bold mt-4 mb-3">Varian rasa nabati</h2>
            <div class="row" id="varian">
                <div class="col">
                    <img src="../assets/kedelai.png" class="" alt="">
                    <h3 class="mt-3">Peyek Kedelai</h3>
                    <p class="transparent-text">Varian toping paling banyak dipesan karena citarasa kedelai lokal yang
                        gurih dan renyah</p>
                </div>
                <div class="col">
                    <img src="../assets/kacang.png" class="" alt="">
                    <h3 class="mt-3">Peyek Kacang</h3>
                    <p class="transparent-text">Peyek dengan perpaduan khas antara bumbu dengan topping kacang yang
                        gurih membuat anda ketagihan</p>
                </div>
            </div>
            <button type="button" class="btn btn-dark">Pesan</button>
        </div>

        <div class="container mb-5 p-4">
            <h2 class="fw-bold mt-4 mb-3">Varian rasa hewani</h2>
            <div class="row align-items-center">
                <!-- Kolom Kiri (teks) -->
                <div class="col-md-6">
                    <h3 class=" ">Toping Udang rebon</h3>
                    <p class="text-muted">
                        Citarasa asin gurih yang dihasilkan dari udang rebon akan membuat lidah terasa bergoyang dengan
                        rasanya
                    </p>

                    <h3 class=" mt-4">Toping Teri</h3>
                    <p class="text-muted">
                        Ikan Teri yang gurih merupakan kombinasi yang lezat ketika dipadukan dengan bumbu tradisional.
                    </p>

                </div>

                <!-- Kolom Kanan (gambar) -->
                <div class="col-md-6 text-begin" id="imgRebon">
                    <img src="../assets/rebon.png" alt="Peyek Udang & Teri" class="img-fluid rounded">
                </div>

            </div>
            <button type="button" class="btn btn-dark mt-3">Pesan</button>
        </div>
        <div class="container mb-5 p-4">
            <h4 class="fw-bold mb-4">Review Pemesan</h4>
            <div class="row g-3">

                <!-- Review 1 -->
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100 position-relative">
                        <!-- Bintang -->
                        <span class="position-absolute top-0 end-0 p-2">
                            ⭐⭐⭐
                        </span>
                        <p class="fw-semibold">“Enak Banget Bikin Nagih”</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="../assets/profile.png" alt="Foto Farhan" class="rounded-circle me-2" width="40"
                                height="40">
                            <div>
                                <p class="mb-0 fw-bold">Farhan</p>
                                <small class="text-muted">Jakarta</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100 position-relative">
                        <!-- Bintang -->
                        <span class="position-absolute top-0 end-0 p-2">
                            ⭐⭐
                        </span>
                        <p class="fw-semibold">“Langsung dihabisin suamiku dong”</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="../assets/profile.png" alt="Foto Indah" class="rounded-circle me-2" width="40"
                                height="40">
                            <div>
                                <p class="mb-0 fw-bold">Indah</p>
                                <small class="text-muted">Solo</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </main>

    <footer class="mt-auto py-3" style="background-color: #c8ae7c;">
        <div class="container ">
            <div class="row">

                <!-- Kolom Kiri -->
                <div class="col-md-6 mb-md-0 mb-3">
                    <h5 class="fw-bold mb-0">Peyek Kriuk ENI</h5>
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
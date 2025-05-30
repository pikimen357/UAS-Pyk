<?php
include_once("../config.php");

$lokasi_list = [];
$res = mysqli_query($conn, "SELECT * FROM lokasi");
while ($row = mysqli_fetch_assoc($res)) {
    $lokasi_list[] = $row;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $password = $_POST['password'];
    $desa = $_POST['desa'];
    $kecamatan = $_POST['kecamatan'];
    $alamat = $_POST['alamat'];

    $errors = [];

    if (empty($nama)) $errors[] = "Nama tidak boleh kosong";
    if (empty($telepon)) $errors[] = "Telepon tidak boleh kosong";
    if (empty($password)) $errors[] = "Password tidak boleh kosong";
    if (empty($desa)) $errors[] = "Desa tidak boleh kosong";
    if (empty($kecamatan)) $errors[] = "Kecamatan tidak boleh kosong";
    if (empty($alamat)) $errors[] = "Alamat tidak boleh kosong";

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT id_lokasi FROM lokasi WHERE desa = ? AND kecamatan = ?");
        mysqli_stmt_bind_param($stmt, "ss", $desa, $kecamatan);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_lokasi);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($id_lokasi) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO user(nama, telepon, password, id_lokasi, alamat) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $nama, $telepon, $password_hash, $id_lokasi, $alamat);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo '<div class="alert alert-success m-3" style="margin-top: 100px;">Akun berhasil dibuat!</div>';
        } else {
            echo "<div class='alert alert-danger m-3' style='margin-top: 100px;'>Lokasi tidak ditemukan.</div>";
        }
    } else {
        foreach ($errors as $e) {
            echo "<div class='alert alert-warning m-3'>$e</div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- HEADER JANGAN DIUBAH -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/index.php">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white" href="../login/index.php">Login</a>
            </div>
        </div>
    </nav>

    <div id="signup" class="container p-4 fw-bold fs-6" style="background-color: #c8ae7c;">
        <form action="index.php" method="post" class="p-3">

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="nama" class="form-label text-white">Nama</label>
                    <input type="text" name="nama" id="nama" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="telepon" class="form-label text-white">Telepon</label>
                    <input type="text" name="telepon" id="telepon" required class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label  text-white" for="password">Password</label>
                    <input type="password" name="password" id="password" required class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label  text-white" for="password">Konfirm password</label>
                    <input type="password" name="password" id="password" required class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label  class="form-label  text-white"  for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" onchange="filterDesa()" class="form-select" required>
                        <option value="">Pilih Kecamatan</option>
                        <?php
                        $unique_kec = array_unique(array_column($lokasi_list, 'kecamatan'));
                        foreach ($unique_kec as $kec) {
                            echo "<option value=\"$kec\">$kec</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label  text-white" for="desa">Desa</label>
                    <select name="desa" id="desa" class="form-select" required>
                        <option value="">Pilih Desa</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label text-white">Detail Alamat</label>
                <textarea name="alamat" id="alamat" required class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <div class="p-2">
                    <input type="submit" value="Buat Akun" name="submit" class="btn btn-primary" style="width: 112px;">
                </div>
                <div class="p-2">
                    <a href="index.php" class="btn btn-danger" style="width: 112px;">Batal</a>
                </div>
            </div>
        </form>
    </div>



    <!-- FOOTER JANGAN DIUBAH -->
    <footer class="mt-auto py-3" style="background-color: #c8ae7c;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-md-0 mb-3">
                    <h5 class="text-white fw-bold mb-0">Peyek Kriuk ENI</h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-dark mb-1">Telp: 085229297152</p>
                    <p class="text-dark mb-0 text-muted">Kismantoro, Wonogiri, Jawa Tengah</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const lokasi = <?php echo json_encode($lokasi_list); ?>;

        function filterDesa() {
            const kecamatan = document.getElementById('kecamatan').value;
            const desaSelect = document.getElementById('desa');
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            lokasi.forEach(lok => {
                if (lok.kecamatan === kecamatan) {
                    const opt = document.createElement('option');
                    opt.value = lok.desa;
                    opt.textContent = lok.desa;
                    desaSelect.appendChild(opt);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>

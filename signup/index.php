<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="http://localhost:3000/landing/index.php">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white" href="http://localhost:3000/login/index.php">Login</a>
            </div>
        </div>
    </nav>

    <?php 
        include_once("../config.php");

        // Ambil daftar lokasi
        $lokasi_list = [];
        $result = mysqli_query($conn, "SELECT * FROM lokasi");
        while ($row = mysqli_fetch_assoc($result)) {
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
                // Ambil id_lokasi
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

                    echo "<div class='alert alert-success m-3'>Akun berhasil dibuat!</div>";
                } else {
                    echo "<div class='alert alert-danger m-3'>ID lokasi tidak ditemukan.</div>";
                }
            } else {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-warning m-3'>$error</div>";
                }
            }
        }
    ?>

    <form action="index.php" method="post" class="container mt-5 p-3">
        <h3 class="mb-4">Form Daftar Akun</h3>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <select name="kecamatan" id="kecamatan" class="form-select" onchange="updateDesaOptions()" required>
                <option value="">Pilih Kecamatan</option>
                <?php
                $kecamatans = array_unique(array_column($lokasi_list, 'kecamatan'));
                foreach ($kecamatans as $kec) {
                    echo "<option value='$kec'>$kec</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="desa" class="form-label">Desa</label>
            <select name="desa" id="desa" class="form-select" required>
                <option value="">Pilih Desa</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Detail Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required></textarea>
        </div>

        <div class="mt-3">
            <input type="submit" value="Buat Akun" name="submit" class="btn btn-secondary">
            <a href="index.php" class="btn btn-danger">Batal</a>
        </div>
    </form>

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
        const lokasiData = <?php echo json_encode($lokasi_list); ?>;

        function updateDesaOptions() {
            const kecamatan = document.getElementById('kecamatan').value;
            const desaSelect = document.getElementById('desa');
            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';

            lokasiData.forEach(lokasi => {
                if (lokasi.kecamatan === kecamatan) {
                    const opt = document.createElement('option');
                    opt.value = lokasi.desa;
                    opt.textContent = lokasi.desa;
                    desaSelect.appendChild(opt);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FvKkzDmjN4jh7vSGo+nDZwxlN+5iA29YwYyUkZT+9yDKQ0SeDq+N58pK9cdwDPYX"
        crossorigin="anonymous"></script>
</body>

</html>

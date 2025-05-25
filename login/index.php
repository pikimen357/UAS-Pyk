<?php
include_once("../config.php");

$successMessage = "";
$errors = [];

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    if (empty($nama)) $errors[] = "Nama tidak boleh kosong";
    if (empty($password)) $errors[] = "Password tidak boleh kosong";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM user JOIN Peyek.lokasi l on l.id_lokasi = user.id_lokasi
        WHERE nama =  ?");
        $stmt->bind_param("s", $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $successMessage = "Login berhasil." . htmlspecialchars($user['nama']) . "!";
                
                // (Opsional) Set session
                session_start();
                $_SESSION['user'] = $user;

                // // Redirect ke dashboard
                header("Location: ../landing/index.php");
                exit;
            } else {
                $errors[] = "Password salah";
            }
        } else {
            $errors[] = "Pengguna tidak ditemukan";
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100"  background="../assets/bumbu.png">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="../landing/index.php">Peyek Kriuk</a>
            <div class="ms-auto">
                <a class="nav-link d-inline text-white" href="../signup/index.php">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="container p-5 rounded" id="loginContainer">
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form action="index.php" method="post">
                 <div class="col-md-6 mb-4 mb-md-0">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" required class="form-control">
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" required class="form-control">
                </div>
                <div class="mt-3">
                    <input type="submit" value="Login" name="submit" class="btn btn-dark">
                    <a href="index.php" class="btn btn-danger">Batal</a>
                </div>
        </form>
    </div>


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



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
</body>

</html>
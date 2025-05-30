<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_order = $_POST['id_order'];

    $sql = "UPDATE orders SET status = 'diproses' WHERE id_order = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_order);

    if ($stmt->execute()) {
        echo "<script>
                alert('Pembayaran berhasil!!');
                window.location.href = '../orders/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memproses pembayaran.');
                window.history.back();
              </script>";
    }
}
?>

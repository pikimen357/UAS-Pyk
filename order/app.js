const beli = document.getElementById('beli');

beli.addEventListener("click", (event) => {
    event.preventDefault();
    window.location.href = 'http://localhost:3000/orders/index.php';
});
const jumlahInput = document.getElementById('jumlah');
const plusBtn = document.getElementById('plus');
const minusBtn = document.getElementById('minus');
const harga = document.getElementById('harga');

let jumlah = 0.5;
const hargaPerKg = 50000;

function updateHarga() {
    const total = jumlah * hargaPerKg;
    harga.textContent = `Rp${total.toLocaleString('id-ID')}`;
}

plusBtn.addEventListener('click', () => {
    if (jumlah < 5) {
        jumlah = parseFloat((jumlah + 0.25).toFixed(2));
        jumlahInput.value = jumlah;
        updateHarga();
    }
});

minusBtn.addEventListener('click', () => {
    if (jumlah > 0.25) {
        jumlah = parseFloat((jumlah - 0.25).toFixed(2));
        jumlahInput.value = jumlah;
        updateHarga();
    }
});

// Panggil saat awal juga
updateHarga();
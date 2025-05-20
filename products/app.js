    const jumlahInput = document.getElementById('jumlah');
    const plusBtn = document.getElementById('plus');
    const minusBtn = document.getElementById('minus');

    let jumlah = 0.5;

    plusBtn.addEventListener('click', () => {
        if(jumlah < 5){
            jumlah = parseFloat((jumlah + 0.25).toFixed(2));
            jumlahInput.value = jumlah;
        }
    });

    minusBtn.addEventListener('click', () => {
        if (jumlah > 0.25) {
            jumlah = parseFloat((jumlah - 0.25).toFixed(2));
            jumlahInput.value = jumlah;
        }
    });
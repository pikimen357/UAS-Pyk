    const jumlahInput = document.getElementById('jumlah');
    const plusBtn = document.getElementById('plus');
    const minusBtn = document.getElementById('minus');
    const harga = document.getElementById('harga');
    const checkout = document.getElementById('checkout');

    const topImg = document.getElementById('topImg');
    const topTitle = document.getElementById('Pkacang');
    const topHargaDisplay = document.getElementById('hargaDisplay');
    const topTopping = document.getElementById('toping');

    const varianItems = document.querySelectorAll('.varian-item');
    // const selectedId = document.querySelector('.varian-item[data-gambar="' + varianItems.src.split('/').pop() + '"]')?.getAttribute("data-id");

    let jumlah = 0.5;
    let hargaPerKg = 50000;

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

    updateHarga();

    checkout.addEventListener('click', () => {
        const data = {
            id_peyek: document.getElementById("topImg").dataset.id,
            nama: document.getElementById("Pkacang").textContent,
            topping: document.getElementById("toping").textContent,
            jumlah: parseFloat(document.getElementById("jumlah").value),
            harga: parseInt(document.getElementById("harga").getAttribute("value")),
            gambar: document.getElementById("topImg").getAttribute("src"),
        };

        fetch("set_checkout.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        }).then(() => {
            window.location.href = "../order/index.php";
        });
    });

    // Fungsi ganti varian utama saat diklik
    varianItems.forEach(item => {
      item.addEventListener('click', () => {
        const nama = item.getAttribute('data-nama');
        const hargaBaru = parseInt(item.getAttribute('data-harga'));
        const topping = item.getAttribute('data-topping');
        const gambar = item.getAttribute('data-gambar');
        const idPeyek = item.getAttribute('data-id');

        topImg.src = gambar;
        topImg.dataset.id = idPeyek;
        topTitle.textContent = nama;
        topHargaDisplay.innerHTML = `<strong>Rp${hargaBaru.toLocaleString('id-ID')}/kg</strong>`;
        topTopping.textContent = `Toping ${topping}`;

        hargaPerKg = hargaBaru;
        harga.setAttribute("value", hargaBaru); 
        updateHarga();
      });
    });
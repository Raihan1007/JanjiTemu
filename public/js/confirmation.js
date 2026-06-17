document.addEventListener('DOMContentLoaded', function() {
    // 1. Ambil data dari lemari browser
    const savedData = localStorage.getItem('dataBooking');

    if (savedData) {
        const data = JSON.parse(savedData);

        // 2. Tempel ke HTML berdasarkan ID yang kita buat tadi
        document.getElementById('conf-ref').textContent = data.referensi;
        document.getElementById('conf-nama').textContent = data.nama;
        document.getElementById('conf-layanan').textContent = data.layanan;
        document.getElementById('conf-petugas').textContent = data.petugas;
        document.getElementById('conf-tanggal').textContent = data.tanggal;
        document.getElementById('conf-waktu').textContent = data.waktu;
    } else {
        console.error("Data tidak ditemukan di LocalStorage!");
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const data = JSON.parse(localStorage.getItem('dataBooking'));
    console.log('DATA', data);
    if (!data) return;

    document.getElementById('c-nama').innerText = data.nama;
    document.getElementById('c-layanan').innerText = data.layanan;
    document.getElementById('c-petugas').innerText = data.petugas;
    document.getElementById('c-tanggal').innerText = data.tanggal;
    document.getElementById('c-jam').innerText = data.jam;
    document.getElementById('ref-code').innerText = data.referensi;

    document.getElementById('f-nama').value = data.nama;
    document.getElementById('f-email').value = data.email;
    document.getElementById('f-hp').value = data.nomor_hp;
    document.getElementById('f-layanan').value = data.layanan_id;
    document.getElementById('f-petugas').value = data.petugas_id;
    document.getElementById('f-tanggal').value = data.tanggal;
    document.getElementById('f-jam').value = data.jam;
});
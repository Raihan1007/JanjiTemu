document.addEventListener('DOMContentLoaded', function() {

    // ================= INPUT & SUMMARY =================
    const inputService = document.getElementById('input-service');
    const inputOfficer = document.getElementById('input-officer');
    const inputDate    = document.getElementById('input-date');
    const timeSlots    = document.querySelectorAll('.time-slot');
    const hiddenTime   = document.getElementById('hidden-time');

    const summaryService = document.getElementById('summary-service');
    const summaryOfficer = document.getElementById('summary-officer');
    const summaryDate    = document.getElementById('summary-date');
    const summaryTime    = document.getElementById('summary-time');

    // ================= UPDATE SUMMARY =================
    if(inputService) {
        inputService.addEventListener('change', () => {
            summaryService.textContent = inputService.value || '-';
        });
    }

    if(inputOfficer) {
        inputOfficer.addEventListener('change', () => {
            summaryOfficer.textContent = inputOfficer.value || '-';
        });
    }

    if(inputDate) {
        const today = new Date().toISOString().split('T')[0];
        inputDate.setAttribute('min', today);

        inputDate.addEventListener('change', () => {
            const dateObj = new Date(inputDate.value);
            if(!isNaN(dateObj)) {
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                summaryDate.textContent = dateObj.toLocaleDateString('id-ID', options);
            }
        });
    }

    timeSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            if (this.classList.contains('disabled')) return;

            timeSlots.forEach(s => s.classList.remove('active'));
            this.classList.add('active');

            const timeVal = this.textContent;
            if(hiddenTime) hiddenTime.value = timeVal;
            if(summaryTime) summaryTime.textContent = timeVal;
        });
    });

    // ================= 🔥 BUTTON NEXT =================
    const btnNext = document.getElementById('btnNext');

    if (btnNext) {
        btnNext.addEventListener('click', function () {

            const data = {
                referensi: 'JT-' + Date.now(),
                
                nama: document.querySelector('[name="nama"]')?.value || '',
                email: document.querySelector('[name="email"]')?.value || '',
                nomor_hp: document.querySelector('[name="nomor_hp"]')?.value || '',
                
                layanan_id: document.querySelector('[name="layanan_id"]')?.value || '',
                layanan: summaryService?.textContent || '',
                
                petugas_id: document.querySelector('[name="petugas_id"]')?.value || '',
                petugas: summaryOfficer?.textContent || '',
                
                tanggal: document.querySelector('[name="tanggal"]')?.value || '',
                jam: hiddenTime?.value || '',
            };

            console.log('DATA BOOKING:', data);

            if (!data.nama || !data.email || !data.nomor_hp || !data.jam) {
                alert('Lengkapi semua data terlebih dahulu!');
                return;
            }

            localStorage.setItem('dataBooking', JSON.stringify(data));

        });
    }

});
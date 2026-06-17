document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // 🔹 ELEMENT
    // =========================
    const layananSelect = document.getElementById('pilihanLayanan');
    const petugasSelect = document.getElementById('pilihanPetugas');
    const tanggalInput  = document.getElementById('tanggalInput');

    const summaryService = document.getElementById('summary-service');
    const summaryOfficer = document.getElementById('summary-officer');
    const summaryDate    = document.getElementById('summary-date');
    const summaryTime    = document.getElementById('summary-time');

    const hiddenTime = document.getElementById('hidden-time');

    // =========================
    // 🔥 1. LOAD PETUGAS
    // =========================
    if (layananSelect) {
        layananSelect.addEventListener('change', function () {

            const layananId   = this.value;
            const layananText = this.options[this.selectedIndex].text;

            summaryService.textContent = layananText;
            summaryOfficer.textContent = "-";

            petugasSelect.innerHTML = '<option disabled selected>Loading...</option>';

            fetch(`/get-petugas/${layananId}`)
                .then(res => res.json())
                .then(data => {

                    petugasSelect.innerHTML = '<option value="" disabled selected>-- Pilih Petugas --</option>';

                    data.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.textContent = p.nama;
                        petugasSelect.appendChild(option);
                    });

                })
                .catch(err => console.error('ERROR GET PETUGAS:', err));

        });
    }

    // =========================
    // 🔥 3. PILIH TANGGAL
    // =========================
    if (tanggalInput) {
        tanggalInput.addEventListener('change', function () {

            summaryDate.innerText = this.value;

            // 🚫 BLOCK WEEKEND
            const date = new Date(this.value);
            const day  = date.getDay();

            if (day === 0 || day === 6) {
                alert('Sabtu dan Minggu tidak tersedia!');
                this.value = '';

                summaryDate.innerText = '-';
                hiddenTime.value = '';
                summaryTime.innerText = '-';

                document.querySelectorAll('.time-slot').forEach(b => {
                    b.classList.remove('active');
                });

                return;
            }

            updateTimeSlots();
        });
    }

    // =========================
    // 🔥 4. CEK SLOT TERPAKAI
    // =========================
    function updateTimeSlots() {

        const petugasId = petugasSelect?.value;
        const tanggal   = tanggalInput?.value;

        if (!petugasId || !tanggal) return;

        fetch(`/get-booked-slots?petugas_id=${petugasId}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {

                console.log('BOOKED SLOT:', data); // 🔍 debug

                document.querySelectorAll('.time-slot').forEach(btn => {

                    const jam = btn.dataset.time;

                    // 🔥 HANDLE FORMAT JAM (09:00 vs 09:00:00)
                    const isBooked = data.includes(jam) || data.includes(jam + ':00');

                    if (isBooked) {
                        btn.disabled = true;
                        btn.classList.add('disabled');
                        btn.classList.remove('active');
                        btn.title = "Sudah dibooking";
                    } else {
                        btn.disabled = false;
                        btn.classList.remove('disabled');
                        btn.title = "";
                    }

                });

            })
            .catch(err => console.error('ERROR SLOT:', err));
    }

    // =========================
    // 🔥 5. PILIH JAM
    // =========================
    document.querySelectorAll('.time-slot').forEach(btn => {

        btn.addEventListener('click', function () {

            if (this.disabled) return;

            document.querySelectorAll('.time-slot').forEach(b => b.classList.remove('active'));

            this.classList.add('active');

            const jam = this.dataset.time;

            hiddenTime.value = jam;
            summaryTime.innerText = jam;

        });

    });

});
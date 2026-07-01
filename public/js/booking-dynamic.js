document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // ELEMENT
    // =========================
    const kategoriSelect = document.getElementById('pilihanKategori');
    const layananSelect = document.getElementById('pilihanLayanan');
    const tanggalInput = document.getElementById('tanggalInput');

    const summaryService = document.getElementById('summary-service');
    const summaryDate = document.getElementById('summary-date');
    const summaryTime = document.getElementById('summary-time');

    const hiddenTime = document.getElementById('hidden-time');

        if (layananSelect) {

        layananSelect.addEventListener('change', function () {

            summaryService.textContent =
                this.options[this.selectedIndex].text;

            updateTimeSlots();

        });

    }

    // =========================
    // PILIH SERVICE
    // =========================
    if (layananSelect) {

        layananSelect.addEventListener('change', function () {

            summaryService.textContent =
                this.options[this.selectedIndex].text;

            updateTimeSlots();

        });

    }

    // =========================
    // PILIH TANGGAL
    // =========================
    if (tanggalInput) {

        tanggalInput.addEventListener('change', function () {

            summaryDate.textContent = this.value;

            const date = new Date(this.value);
            const day = date.getDay();

            // Sabtu & Minggu
            if (day === 0 || day === 6) {

                alert('Sabtu dan Minggu tidak tersedia.');

                this.value = "";

                summaryDate.textContent = "-";
                summaryTime.textContent = "-";

                hiddenTime.value = "";

                document.querySelectorAll('.time-slot').forEach(btn => {

                    btn.classList.remove('active');

                });

                return;
            }

            updateTimeSlots();

        });

    }

    // =========================
    // CEK SLOT BOOKING
    // =========================
    function updateTimeSlots() {

        const layananId = layananSelect.value;
        const tanggal = tanggalInput.value;

        if (!layananId || !tanggal) return;

        fetch(`/get-booked-slots?layanan_id=${layananId}&tanggal=${tanggal}`)
            .then(res => res.json())
            .then(data => {

                document.querySelectorAll('.time-slot').forEach(btn => {

                    const jam = btn.dataset.time;

                    const booked =
                        data.includes(jam) ||
                        data.includes(jam + ":00");

                    if (booked) {

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
            .catch(err => console.error(err));

    }

    // =========================
    // PILIH JAM
    // =========================
    document.querySelectorAll('.time-slot').forEach(btn => {

        btn.addEventListener('click', function () {

            if (this.disabled) return;

            document.querySelectorAll('.time-slot').forEach(b => {

                b.classList.remove('active');

            });

            this.classList.add('active');

            hiddenTime.value = this.dataset.time;

            summaryTime.textContent = this.dataset.time;

        });

    });

});
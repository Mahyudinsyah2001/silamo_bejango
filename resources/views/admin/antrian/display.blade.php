<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white flex flex-col h-screen overflow-hidden">
    <!-- Audio Unlock Overlay -->
    <div id="audioUnlockOverlay"
        class="fixed inset-0 bg-gray-900/95 z-50 flex flex-col justify-center items-center backdrop-blur-sm">
        <button onclick="unlockAudio()"
            class="bg-[#00c0ef] border-[#00c0ef] hover:bg-[#00acd6] text-white font-bold py-5 px-10 rounded-full text-2xl transition-transform hover:scale-105"
            style="box-shadow: 0 0 20px rgba(0,192,239,0.5);">
            ▶ MULAI DISPLAY & AKTIFKAN SUARA PANGGILAN
        </button>
        <p class="text-gray-400 mt-5 text-lg">Browser memblokir pemutaran suara otomatis. Anda harus mengklik tombol di
            atas satu kali.</p>
    </div>

    <!-- Header -->
    <div class="bg-gray-800 border-b border-gray-700 py-4 px-8 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-4">
            <h1 class="text-3xl font-bold tracking-wider">SILAMO BEJANGO</h1>
        </div>
        <div class="text-2xl font-semibold text-gray-300" id="clock">
            10:00:00
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex justify-center items-center p-8">
        <div class="text-center w-full max-w-4xl p-12 bg-gray-800 rounded-3xl shadow-2xl border border-gray-700 transition-all duration-500 scale-100"
            id="cardDisplay">
            <p class="text-3xl text-gray-400 mb-6 font-semibold uppercase tracking-widest">Nomor Antrian Panggilan</p>
            <div class="text-[12rem] font-bold text-yellow-400 leading-none mb-4" id="kodeAntrian">
                ---
            </div>
            <p class="text-4xl text-gray-300 font-light" id="namaSesi">Silahkan Menunggu</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-800 py-3 text-center text-gray-500 text-sm">
        Sistem Informasi Antrian Berbasis Web
    </div>

    <script>
        function unlockAudio() {
            if ('speechSynthesis' in window) {
                // Memainkan suara diam (kosong) agar API Audio/TTS tidak diblokir browser lagi
                const utterance = new SpeechSynthesisUtterance('Display Antrian Diaktifkan.');
                utterance.lang = 'id-ID';
                utterance.rate = 1.0;
                utterance.volume = 0; // mute the initial test
                window.speechSynthesis.speak(utterance);
            }
            document.getElementById('audioUnlockOverlay').style.display = 'none';
        }

        // Jam Digital
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        }
        setInterval(updateClock, 1000);
        updateClock();

        let lastKodeAntrian = '';

        // Fungsi konversi angka ke Bahasa Indonesia (kata utuh)
        function terbilangIndo(n) {
            if (n === 0) return 'nol';
            const satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
            if (n <= 9) return satuan[n];
            if (n === 10) return 'sepuluh';
            if (n === 11) return 'sebelas';
            if (n <= 19) return satuan[n - 10] + ' belas';
            if (n < 100) {
                const puluhan = Math.floor(n / 10);
                const sisa = n % 10;
                return satuan[puluhan] + ' puluh' + (sisa > 0 ? ' ' + satuan[sisa] : '');
            }
            if (n === 100) return 'seratus';
            if (n < 200) {
                const sisa = n - 100;
                return sisa > 0 ? 'seratus ' + terbilangIndo(sisa) : 'seratus';
            }
            return n.toString();
        }

        // Fungsi konversi angka ke Bahasa Sumbawa (kata utuh)
        function terbilangSumbawa(n) {
            if (n === 0) return 'nol';
            const satuan = ['', 'sai', 'dua', 'telu', 'empat', 'lima', 'enam', 'pitu', 'balu', 'siwa'];
            if (n <= 9) return satuan[n];
            if (n === 10) return 'sepuluh';
            if (n === 11) return 'saolas';
            if (n <= 19) return satuan[n - 10] + ' olas';
            if (n < 100) {
                const puluhan = Math.floor(n / 10);
                const sisa = n % 10;
                return satuan[puluhan] + ' puluh' + (sisa > 0 ? ' ' + satuan[sisa] : '');
            }
            if (n === 100) return 'serates';
            if (n < 200) {
                const sisa = n - 100;
                return sisa > 0 ? 'srates ' + terbilangSumbawa(sisa) : 'srates';
            }
            return n.toString();
        }

        // Baca nomor antrian: angka nol di depan dibaca "nol", angka sisanya dibaca utuh
        function bacaNomorIndo(nomor) {
            const leadingZeros = nomor.match(/^(0+)/);
            const nolPrefix = leadingZeros ? leadingZeros[1].split('').map(() => 'nol').join(' ') : '';
            const significant = parseInt(nomor, 10);
            const significantStr = terbilangIndo(significant);
            return nolPrefix ? nolPrefix + ' ' + significantStr : significantStr;
        }

        function bacaNomorSumbawa(nomor) {
            const leadingZeros = nomor.match(/^(0+)/);
            const nolPrefix = leadingZeros ? leadingZeros[1].split('').map(() => 'nol').join(' ') : '';
            const significant = parseInt(nomor, 10);
            const significantStr = terbilangSumbawa(significant);
            return nolPrefix ? nolPrefix + ' ' + significantStr : significantStr;
        }

        function panggilAntrian(nomor, namaSesi) {
            // Animasi flash
            const card = document.getElementById('cardDisplay');
            card.classList.remove('bg-gray-800');
            card.classList.add('bg-gray-700', 'scale-105');
            setTimeout(() => {
                card.classList.remove('bg-gray-700', 'scale-105');
                card.classList.add('bg-gray-800');
            }, 600);

            // Speech Synthesis — leading zeros dibaca "nol", sisanya dibaca kata utuh dua bahasa
            if ('speechSynthesis' in window) {
                setTimeout(() => {
                    const bacaIndo    = bacaNomorIndo(nomor);
                    const bacaSumbawa = bacaNomorSumbawa(nomor);

                    // Terjemahan sesi
                    const sesiIndo = namaSesi ? '. Sesi ' + namaSesi : '';
                    let namaSesiSumbawa = namaSesi ? namaSesi.toLowerCase() : '';
                    if (namaSesiSumbawa.includes('pagi')) namaSesiSumbawa = 'jaga';
                    else if (namaSesiSumbawa.includes('siang')) namaSesiSumbawa = 'tengari';
                    const sesiSumbawa = namaSesi ? '. Sesi ' + namaSesiSumbawa : '';

                    // Bahasa Indonesia dulu, lalu Bahasa Sumbawa
                    const textIndo    = 'Nomor antrian. ' + bacaIndo    + sesiIndo    + '. Silakan menuju loket pendaftaran.';
                    const textSumbawa = 'Nomor antrian. ' + bacaSumbawa + sesiSumbawa + '. Silamo lako loket antrian.';

                    // Jeda sejenak antara dua bahasa
                    const finalSpeechText = textIndo + ' ... ' + textSumbawa;

                    const utterance = new SpeechSynthesisUtterance(finalSpeechText);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.85; // Sedikit dilambatkan agar terdengar jelas
                    window.speechSynthesis.speak(utterance);
                }, 500);
            }
        }

        function checkLatestAntrian() {
            fetch("{{ route('admin.antrian.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data && data.nomor_display) {
                        document.getElementById('kodeAntrian').innerText = data.nomor_display;
                        document.getElementById('namaSesi').innerText = data.nama_sesi ?
                            'Sesi: ' + data.nama_sesi + ' — Mohon Segera Ke Loket' :
                            'Mohon Segera Ke Loket / Verifikasi';

                        if (data.kode_antrian !== lastKodeAntrian) {
                            lastKodeAntrian = data.kode_antrian;
                            panggilAntrian(data.nomor_display, data.nama_sesi);
                        }
                    } else {
                        document.getElementById('kodeAntrian').innerText = '---';
                        document.getElementById('namaSesi').innerText = 'Silahkan Menunggu';
                        lastKodeAntrian = '';
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Interval polling setiap 3 detik
        setInterval(checkLatestAntrian, 3000);
        checkLatestAntrian();

        // Panggil antrian selanjutnya dengan menekan Enter
        document.addEventListener('keydown', function(e) {
            const overlay = document.getElementById('audioUnlockOverlay');
            const isOverlayOpen = overlay && overlay.style.display !== 'none';
            
            if (e.key === 'Enter' && !isOverlayOpen) {
                e.preventDefault();
                
                // Cegah klik ganda / spam Enter yang cepat
                if (window.isCallingNext) return;
                window.isCallingNext = true;

                fetch("{{ route('admin.antrian.panggil-selanjutnya') }}")
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            // Segera perbarui tampilan tanpa menunggu polling 3 detik
                            checkLatestAntrian();
                        } else {
                            alert(data.message || 'Gagal memanggil antrian berikutnya.');
                        }
                    })
                    .catch(error => {
                        console.error('Error calling next queue:', error);
                    })
                    .finally(() => {
                        window.isCallingNext = false;
                    });
            }
        });
    </script>
</body>

</html>

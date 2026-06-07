    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <title>Kartu Undangan</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    </head>
    <body class="min-h-screen bg-slate-900 text-gray-900 font-poppins flex items-center justify-center p-5">
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="card-wrapper bg-white rounded-3xl overflow-hidden shadow-2xl">
                <!-- Card Image with lazy loading -->
                <div class="relative w-full overflow-hidden rounded-3xl bg-gray-200">
                    <img 
                        class="bg-image w-full h-auto block object-cover"
                        src="{{ asset('storage/kartu_undangan.webp') }}" 
                        alt="Kartu Undangan" 
                        loading="lazy"
                        onerror="console.error('Gambar kartu gagal dimuat')"
                    >
                    
                    <!-- QR Code Overlay -->
                    <div class="qr-overlay absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 
                                w-[min(125px,42%)] sm:w-[min(180px,60%)] aspect-square rounded-xl sm:rounded-2xl bg-white/95 border-2 border-white/85
                                flex items-center justify-center p-2 sm:p-3 shadow-lg">
                        <img 
                            id="qrCodeImage" 
                            class="qr-img w-full h-full object-contain rounded-xl"
                            src="" 
                            alt="QR Code"
                            crossorigin="anonymous"
                        />
                    </div>
                </div>
            </div>

            <!-- Message -->
            <p class="mt-4 text-center text-slate-200 text-sm leading-relaxed">
                QR Code akan otomatis muncul di tengah kartu undangan ketika halaman dibuka melalui tombol "Buka Kartu Undangan".
            </p>

            <!-- Action Buttons -->
            <div class="mt-4 flex gap-3 justify-center">
                <a 
                    id="backButton" 
                    href="javascript:history.back()" 
                    class="px-5 py-3 rounded-full font-bold bg-yellow-400 text-slate-900 
                        hover:shadow-lg hover:shadow-yellow-400/25 transition-all duration-200 cursor-pointer"
                >
                    Kembali
                </a>
                <button 
                    id="downloadCard" 
                    class="px-5 py-3 rounded-full font-bold bg-yellow-400 text-slate-900 
                        hover:shadow-lg hover:shadow-yellow-400/25 transition-all duration-200 cursor-pointer
                        disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Download Kartu
                </button>
            </div>

            <!-- Note -->
            <p class="mt-3 text-center text-slate-400 text-xs">
                Jika QR Code tidak tampil, buka kembali dari halaman undangan setelah membuat QR Code.
            </p>
        </div>

        <script>
            const qrImage = document.getElementById('qrCodeImage');
            const downloadBtn = document.getElementById('downloadCard');

            // Parse QR data dari URL parameter atau localStorage
            let qrData = null;
            
            // Coba ambil dari URL parameter terlebih dahulu
            const urlParams = new URLSearchParams(window.location.search);
            const qrParam = urlParams.get('qr');
            
            if (qrParam) {
                try {
                    qrData = decodeURIComponent(qrParam);
                    console.log('QR data loaded from URL parameter');
                } catch (e) {
                    console.error('Error decoding QR parameter:', e);
                }
            }
            
            // Fallback ke localStorage
            if (!qrData) {
                qrData = localStorage.getItem('invitationQrData');
                console.log('QR data loaded from localStorage');
            }
            
            // Tampilkan QR code
            if (qrData) {
                qrImage.src = qrData;
                qrImage.onerror = () => {
                    console.error('QR image failed to load');
                    qrImage.alt = 'QR code gagal dimuat';
                };
                qrImage.onload = () => {
                    console.log('QR image loaded successfully');
                };
            } else {
                qrImage.alt = 'Tidak ada QR code';
                qrImage.classList.add('opacity-30');
            }

            downloadBtn.addEventListener('click', async () => {
                if (!qrData) {
                    alert('QR Code belum tersedia. Silakan kembali ke halaman undangan dan buat QR Code terlebih dahulu.');
                    return;
                }
                
                downloadBtn.disabled = true;
                downloadBtn.textContent = 'Memproses...';
                
                try {
                    const cardElement = document.querySelector('.card-wrapper');
                    const cardImage = cardElement.querySelector('.bg-image');
                    
                    // Wait for image to load
                    if (!cardImage.complete) {
                        await new Promise((resolve, reject) => {
                            cardImage.onload = resolve;
                            cardImage.onerror = () => reject(new Error('Card image failed to load'));
                            setTimeout(() => reject(new Error('Image load timeout')), 10000);
                        });
                    }

                    // Render card to canvas
                    const canvas = await html2canvas(cardElement, {
                        backgroundColor: null,
                        scale: window.devicePixelRatio || 2,
                        useCORS: true,
                        allowTaint: true,
                        logging: false,
                        onclone: (clonedDocument) => {
                            const clonedQr = clonedDocument.getElementById('qrCodeImage');
                            if (clonedQr && qrData) {
                                clonedQr.src = qrData;
                            }
                        }
                    });

                    // Downloada
                    const link = document.createElement('a');
                    link.href = canvas.toDataURL('image/png');
                    link.download = 'kartu  undangan.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                } catch (error) {
                    console.error('Download error:', error);
                    alert('Gagal mengunduh kartu. Silakan coba lagi.');
                } finally {
                    downloadBtn.disabled = false;
                    downloadBtn.textContent = 'Download Kartu';
                }
            });
        </script>
    </body>
    </html>

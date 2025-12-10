<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-bold mb-2">Scan QR</h2>

            <div id="qr-status" class="text-sm font-semibold mb-2 text-gray-700">
                Initializing camera…
            </div>

            <div id="qr-reader" style="width: 100%; height: auto;" class="border rounded"></div>

            <p class="text-sm text-gray-500 mt-2">Gunakan kamera, atau paste kode secara manual di sebelah kanan.</p>
        </div>

        <div>
            <h2 class="text-lg font-bold mb-2">Manual Input</h2>

            <x-filament::input.wrapper>
                <x-filament::input wire:model.live="ticket" placeholder="Masukkan kode tiket" />
            </x-filament::input.wrapper>

            @if ($booking)
                <div class="mt-4 p-4 bg-white shadow rounded">
                    <h3 class="text-xl font-semibold">{{ $booking->movie->title }}</h3>
                    <p class="text-sm text-gray-600">
                        Jadwal: {{ \Carbon\Carbon::parse($booking->movie->show_time)->format('d M Y - H:i') }}
                    </p>
                    <p class="mt-2">Kode: <strong>{{ $booking->ticket_code }}</strong></p>
                    <p>Status:
                        <strong class="{{ $booking->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                            {{ strtoupper($booking->status) }}
                        </strong>
                    </p>

                    @if ($booking->status === 'paid')
                        <x-filament::button wire:click="markAsUsed" color="danger" class="mt-3">
                            Tandai USED
                        </x-filament::button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const status = document.getElementById('qr-status');
        const reader = new Html5Qrcode("qr-reader");

        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        };

        // 1) Ambil kamera
        Html5Qrcode.getCameras().then(cameras => {
            if (!cameras || cameras.length === 0) {
                status.innerText = "No camera detected.";
                return;
            }

            status.innerText = "Camera ready. Please scan your ticket.";

            reader.start(
                cameras[0].id,
                config,
                (decodedText) => {
                    status.innerText = "QR detected!";
                    // Auto update Livewire
                    @this.set('ticket', decodedText);
                },
                () => {
                    // setiap frame gagal scan → jangan ada console.log
                }
            ).catch(err => {
                status.innerText = "Camera failed to start.";
            });

        }).catch(err => {
            status.innerText = "Failed to access camera.";
        });
    });
    </script>
</x-filament::page>

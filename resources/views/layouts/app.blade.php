<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | Appesan</title>

    {{-- Favicon Appesan --}}
    <link rel="icon" href="{{ asset('images/assets/appesan.ico') }}" type="image/x-icon">

    {{-- Tailwind CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.css">

    <style>
        /* Untuk menghilangkan tanda panah ke atas dan bawah pada input type='number' */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    {{-- Notifikasi Tombol --}}
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Apakah anda yakin ingin menghapus data tersebut?')) {
                event.target.closest('form').submit();
            }
        }

        function confirmData(event) {
            event.preventDefault();
            if (confirm('Apakah anda yakin ingin mengkonfirmasi data tersebut?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
</head>

<body class="bg-gray-100">

    <!-- Notifikasi Success -->
    @if (session()->has('success'))
        <div id="notification"
            class="fixed top-4 right-4 z-40 flex justify-center items-center gap-2 bg-green-400 p-3 border border-black rounded-md shadow-lg opacity-0 transform scale-90 transition-all duration-300 ease-in-out">
            <i class="fas fa-check"></i>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Notifikasi Fail -->
    @if (session()->has('fail'))
        <div id="notification"
            class="fixed top-4 right-4 z-40 flex justify-center items-center gap-2 bg-red-500 text-white p-3 border border-black rounded-md shadow-lg opacity-0 transform scale-90 transition-all duration-300 ease-in-out">
            <i class="fas fa-times"></i>
            <p class="font-semibold">{{ session('fail') }}</p>
        </div>
    @endif

    {{-- Navbar --}}
    @if ($title == 'Laporan Keuangan')
    @else
        <x-navbar :judul="$title"></x-navbar>
    @endif

    @if (session()->has('customer'))
        {{-- Tampilan Customer (mobile) --}}
        <div class="p-5 flex justify-center w-full">
            {{ $slot }}
        </div>
    @else
        {{-- Tampilan Pegawai (desktop) --}}
        <div class="p-10 flex justify-center w-full">
            {{ $slot }}
        </div>
    @endif

    {{-- JS Clock --}}
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        window.onload = updateClock; // Initialize clock on page load
    </script>

    {{-- Script Notifikasi --}}
    <script>
        function showNotification() {
            const notification = document.getElementById('notification');
            notification.classList.remove('opacity-0', 'scale-90');
            notification.classList.add('opacity-100', 'scale-100');

            setTimeout(() => {
                notification.classList.remove('opacity-100', 'scale-100');
                notification.classList.add('opacity-0', 'scale-90');
            }, 3000);

            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3500);
        }

        // Panggil fungsi untuk menampilkan notifikasi
        showNotification();
    </script>

    @if (in_array($title, ['Beranda Admin', 'Beranda Kasir', 'Beranda Koki', 'Pesanan']))
        {{-- Script mereload halaman setiap 10 detik --}}
        <script>
            setTimeout(function() {
                window.location.reload();
            }, 10000); // 10 detik
        </script>
    @endif

    {{-- Script AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Script AlpineJS --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>

</body>

</html>

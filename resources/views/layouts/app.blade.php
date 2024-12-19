<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | Appesan</title>

    {{-- Tailwind CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.css">

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
    
    {{-- Navbar --}}
    <x-navbar :judul="$title"></x-navbar>

    @if ($title == 'Menu' || $title == 'Detail Menu' || $title == 'Keranjang' || $title == 'Pesanan' || $title == 'Detail Pesanan')
    <div class="p-5 flex justify-center w-full">
        {{ $slot }}
    </div>
    @else
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
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.js"></script>

    {{-- Script AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>
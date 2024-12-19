<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SweetAlert Example</title>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.css">
</head>
<body class="bg-gray-100">

    <!-- Contoh Konten Halaman -->
    <div class="p-10">
        <h1 class="text-center text-4xl font-bold text-blue-600">Selamat Datang di SweetAlert2 Example</h1>
        <p class="text-center mt-4">Klik tombol di bawah untuk menampilkan SweetAlert2 Notifikasi:</p>

        <div class="flex justify-center mt-5">
            <a href="{{ route('send-notification') }}" class="bg-green-500 text-white p-3 rounded-md hover:bg-green-700">
                Tampilkan Notifikasi
            </a>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.js"></script>

    <!-- Cek dan Tampilkan SweetAlert2 berdasarkan session -->
    @if(session('swal'))
        <script>
            Swal.fire({
                icon: '{{ session('swal')['type'] }}',
                title: 'Notifikasi',
                text: '{{ session('swal')['message'] }}',
                timer: 3000,  // Notifikasi otomatis hilang setelah 3 detik
                showConfirmButton: false  // Sembunyikan tombol konfirmasi
            });
        </script>
    @endif

</body>
</html>

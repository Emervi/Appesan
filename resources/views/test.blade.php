<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SweetAlert Example</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.css">
</head>

<body class="bg-gray-100">

    <!-- Contoh Konten Halaman -->
    <div class="p-10">
        <h1 class="text-center text-4xl font-bold text-blue-600">Selamat Datang di SweetAlert2 Example</h1>
        <p class="text-center mt-4">Klik tombol di bawah untuk menampilkan SweetAlert2 Notifikasi:</p>

        <div class="flex justify-center mt-5">
            <a href="{{ route('send-success') }}"
                class="bg-green-500 text-white p-3 rounded-md hover:bg-green-700">
                Success
            </a>
        </div>

        <div class="flex justify-center mt-5">
            <a href="{{ route('send-fail') }}"
                class="bg-red-500 text-white p-3 rounded-md hover:bg-red-700">
                Fail
            </a>
        </div>
    </div>
    
    <!-- Notifikasi Success -->
    {{-- @if (session()->has('success')) --}}
    <div id="notification"
        class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg border-2 border-black opacity-100 transform scale-90 transition-all duration-300 ease-in-out">
        <p class="font-semibold">Kocak</p>
    </div>
    {{-- @endif --}}

    <!-- Notifikasi Fail -->
    @if (session()->has('fail'))
    <div id="notification"
        class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-lg opacity-0 transform scale-90 transition-all duration-300 ease-in-out">
        <p class="font-semibold">{{ session('fail') }}</p>
    </div>
    @endif

    <script>
        // Script untuk menampilkan notifikasi
        function showNotification() {
            const notification = document.getElementById('notification');
            notification.classList.remove('opacity-0', 'scale-90');
            notification.classList.add('opacity-100', 'scale-100');

            // Sembunyikan notifikasi setelah 3 detik
            setTimeout(() => {
                notification.classList.remove('opacity-100', 'scale-100');
                notification.classList.add('opacity-0', 'scale-90');
            }, 3000);
        }

        // Panggil fungsi untuk menampilkan notifikasi
        showNotification();
    </script>


</body>

</html>

{{-- <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.js"></script>

    <!-- Cek dan Tampilkan SweetAlert2 berdasarkan session -->
    @if (session('swal'))
        <script>
            Swal.fire({
                icon: '{{ session('swal')['type'] }}',
                title: 'Notifikasi',
                text: '{{ session('swal')['message'] }}',
                timer: 3000,  // Notifikasi otomatis hilang setelah 3 detik
                showConfirmButton: false  // Sembunyikan tombol konfirmasi
            });
        </script>
    @endif --}}

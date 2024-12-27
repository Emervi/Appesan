<x-app-layout title="Daftar Transaksi">

    <div x-data="{ isOpenLaporan: false }" class="flex flex-col justify-center w-11/12">

        <!-- Modal laporan transaksi -->
        <div x-show="isOpenLaporan" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

                {{-- form laporan transaksi --}}
                <form action="{{ route('laporan-keuangan') }}" method="POST" id="pdfForm" target="_blank">
                    @csrf

                    <div class="flex justify-end align-middle">
                        <button type="button" @click="isOpenLaporan = false">
                            <i class="fas fa-times text-2xl cursor-pointer"></i>
                        </button>
                    </div>

                    <h2 class="text-center text-2xl font-bold mb-5">Buat Laporan</h2>

                    <div class="mb-5">
                        <label class="font-semibold">Masukan Tanggal Transaksi: </label>

                        <div class="grid grid-cols-3 mt-3">

                            <div>
                                <input type="date" name="tanggalAwal" id="tanggalAwal"
                                    value="{{ old('tanggalAwal') }}" oninput="handleInputTanggal()"
                                    class="bg-gray-200 p-2 rounded mb-1">
                            </div>

                            <div class="flex justify-center">
                                <p class="mt-2">-</p>
                            </div>

                            <div>
                                <input type="date" name="tanggalAkhir" id="tanggalAkhir"
                                    oninput="handleInputTanggal()" value="{{ old('tanggalAkhir') }}"
                                    class="bg-gray-200 p-2 rounded mb-1">
                            </div>

                        </div>

                        <p class="text-red-500 text-sm font-bold mt-2" id="pesanError"></p>

                    </div>

                    <div class="flex justify-end space-x-4">
                        <button id="btnsub" type="submit" disabled
                            class="bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-lg disabled:bg-gray-400">Buat
                            Laporan</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="bg-mB w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">

            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold text-white">Daftar Transaksi</h1>
            </div>

            {{-- Tombol tambah --}}
            <button @click="isOpenLaporan = true"
                class="bg-green-600 p-2 border border-black text-white rounded-md hover:bg-green-700 ml-auto z-10">
                <i class="fas fa-file mr-2"></i>
                Buat Laporan
            </button>
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead class="border border-black">
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-2/12">Oleh Kasir</th>
                        <th class="border border-black w-4/12">Tanggal</th>
                        <th class="border border-black w-4/12">Pendapatan</th>
                        <th class="border border-black w-2/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($transactions as $index => $transaction)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="px-2">{{ $transaction->name }}</td>
                            <td class="px-2">{{ $transaction->transaction_date }}</td>
                            <td class="px-2">Rp. {{ number_format($transaction->income, 0, ',', '.') }}</td>
                            <td class="p-2 flex gap-2 justify-evenly">
                                <form action="{{ route('admin.detail-transaksi', [$transaction->transaction_id]) }}"
                                    method="GET">
                                    @csrf

                                    <button class="bg-yellow-400 p-1.5 rounded border border-black hover:bg-yellow-600">
                                        <i class="fas fa-info-circle"></i>
                                        Detail
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <script>
        function handleInputTanggal() {
            // Ambil nilai tanggal dari inputan
            tanggalAwal = document.getElementById('tanggalAwal').value;
            tanggalAkhir = document.getElementById('tanggalAkhir').value;

            // Jika kedua tanggal sudah diisi, lakukan perbandingan
            if (tanggalAwal && tanggalAkhir) {
                // Bandingkan tanggal
                if (new Date(tanggalAwal) > new Date(tanggalAkhir)) {
                    document.getElementById('btnsub').disabled = true;
                    document.getElementById('pesanError').textContent = "Tanggal awal tidak boleh lebih besar dari tanggal akhir!";
                } else {
                    document.getElementById('btnsub').disabled = false;
                    document.getElementById('pesanError').textContent = "";
                }
            } else {
                document.getElementById('btnsub').disabled = true;
                document.getElementById('pesanError').textContent = "Seluruh kolom tanggal harus diisi!"; // Reset jika input kosong
            }
        }
    </script>

</x-app-layout>
<x-app-layout title="Detail Transaksi">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mB w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">

            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold text-white">Detail Transaksi</h1>
            </div>

            {{-- Tombol tambah --}}
            <a href=""
                class="bg-green-600 p-2 border border-black text-white rounded-md hover:bg-green-700 ml-auto z-10">
                <i class="fas fa-file mr-2"></i>
                Buat Laporan
            </a>
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead class="border border-black">
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-2/12">Oleh Kasir</th>
                        <th class="border border-black w-4/12">Tanggal</th>
                        <th class="border border-black w-4/12">Total Pemasukan</th>
                        <th class="border border-black w-2/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($transaction as $index => $data)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="px-2">{{ $data->name }}</td>
                            <td class="px-2">{{ $data->transaction_date }}</td>
                            <td class="px-2">Rp. {{ number_format($data->income, 0, ',', '.') }}</td>
                            <td class="p-2 flex gap-2 justify-evenly">
                                <a href=""
                                    class="bg-yellow-400 p-1.5 rounded border border-black hover:bg-yellow-600">
                                    <i class="fas fa-info-circle"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</x-app-layout>

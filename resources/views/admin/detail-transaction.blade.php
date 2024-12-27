<x-app-layout title="Detail Transaksi">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mB w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('admin.daftar-transaksi') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold text-white">Detail Transaksi</h1>
            </div>
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead class="border border-black">
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-2/12">Nama Menu</th>
                        <th class="border border-black w-2/12">Harga</th>
                        <th class="border border-black w-4/12">Kuantitas</th>
                        <th class="border border-black w-4/12">Sub Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                        <td class="text-center p-2">1</td>
                        <td class="px-2">Es Matcha</td>
                        <td class="px-2">RP. 25.000</td>
                        <td class="px-2">2</td>
                        <td class="px-2">Rp. 50.000</td>
                    </tr>
                    <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                        <td class="text-center p-2">2</td>
                        <td class="px-2">Croissant</td>
                        <td class="px-2">RP. 45.000</td>
                        <td class="px-2">1</td>
                        <td class="px-2">Rp. 45.000</td>
                    </tr>
                    <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                        <td class="text-center p-2">3</td>
                        <td class="px-2">Pie Buah</td>
                        <td class="px-2">RP. 20.000</td>
                        <td class="px-2">1</td>
                        <td class="px-2">Rp. 20.000</td>
                    </tr>
                    {{-- @foreach ($transaction as $index => $data)
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
                    @endforeach --}}
                </tbody>

            </table>

            <div class="font-semibold text-xl mt-3">
                <p class="bg-white inline-block p-2 rounded-md border border-black">Total: Rp. 115.000</p>
            </div>

        </div>
    </div>

</x-app-layout>
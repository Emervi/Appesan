<x-app-layout title="Detail Transaksi">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mB text-white w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('admin.daftar-transaksi') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold">Detail Transaksi</h1>
            </div>
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md">

            <div class="max-h-64 overflow-y-auto">
                <table class="min-w-full bg-gray-50 w-full border border-black table-auto max-h-36">

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
                        @foreach ($transaction as $index => $data)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="text-center p-2">{{ $index + 1 }}</td>
                            <td class="px-2">{{ $data->name }}</td>
                            <td class="px-2">Rp {{ number_format($data->price, 0, ',', '.') }}</td>
                            <td class="px-2">{{ $data->quantity }}</td>
                            <td class="px-2 font-semibold">Rp {{ number_format($data->sub_total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
    
                </table>
            </div>

            <div class="font-semibold text-xl mt-3">
                <p class="bg-white inline-block p-2 rounded-md border border-black">Total: Rp {{ number_format($transaction[0]->income, 0, ',', '.') }}</p>
            </div>

        </div>
    </div>

</x-app-layout>
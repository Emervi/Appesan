<x-app-layout title="Daftar Koki">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mB w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">

            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold text-white">Daftar Koki</h1>
            </div>

            {{-- Tombol tambah --}}
            <a href="{{ route('admin.tambah-chef') }}"
                class="bg-green-600 p-2 border border-black text-white rounded-md hover:bg-green-700 ml-auto z-10">
                <i class="fas fa-plus mr-2"></i>
                Tambah koki
            </a>
            {{-- 
            absolute: Membuat elemen teks mengambil seluruh ruang dari div induknya.
            inset-0: Memastikan elemen tetap memenuhi ruang (atas, bawah, kiri, kanan diatur menjadi 0).
            flex items-center justify-center: Menempatkan teks tepat di tengah secara vertikal dan horizontal.
            ml-auto pada div yang mengandung tombol membuatnya otomatis berada di ujung kanan.
            --}}
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead class="border border-black">
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-3/12">Nama</th>
                        <th class="border border-black w-3/12">Email</th>
                        <th class="border border-black w-4/12">Alamat</th>
                        <th class="border border-black w-2/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($chefs as $index => $chef)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300">
                            <td class="text-center">{{ $offset + $index + 1 }}</td>
                            <td class="px-2">{{ $chef->name }}</td>
                            <td class="px-2">{{ $chef->email }}</td>
                            <td class="px-2">{{ $chef->address }}</td>
                            <td class="p-2 flex gap-2 justify-evenly">
                                <a href="{{ route('admin.ubah-chef', [$chef->chef_id]) }}"
                                    class="bg-yellow-400 p-1.5 rounded border border-black hover:bg-yellow-600">
                                    <i class="fas fa-pen"></i>
                                    Ubah
                                </a>
                                <form action="{{ route('admin.hapus-chef', [$chef->chef_id]) }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button
                                        class="bg-red-600 p-1.5 rounded border border-black text-gray-100 hover:bg-red-800"
                                        onclick="confirmDelete(event)">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if (empty($chefs[0]))
                        <tr>
                            <td colspan="5" class="text-center font-bold text-xl p-3">Tidak ada koki.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-3">
                @if ($offset > -1)
                    {{-- pagination --}}
                    {{ $chefs->links() }}
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
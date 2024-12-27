<x-app-layout title="Tambah Menu">


    <div class="bg-lB w-1/2 p-3 border-2 border-black rounded-md shadow-md">
        <div class="mb-5 flex justify-between relative">
            <a href="{{ route('admin.daftar-menu') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold">Tambah Menu</h1>
            </div>
        </div>

        <form action="{{ route('admin.simpan-menu') }}" method="POST" class="font-roboto" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between mb-3">
                <div class="w-1/2">
                    <div class="mb-3 mr-3">
                        <h3>Gambar:</h3>
                        <input type="file" name="image"
                            class="w-full p-1.5 h-11 bg-mB rounded border border-black outline-none">
                        @error('image')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <label for="name">Nama:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="Masukan nama" class="w-full p-1.5 rounded border border-black outline-none">
                        @error('name')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <h3>Kategori:</h3>
                        <select name="category" class="w-full p-1.5 rounded border border-black outline-none">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Makanan" {{ old('category') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('category') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Camilan" {{ old('category') == 'Camilan' ? 'selected' : '' }}>Camilan</option>
                            <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="ml-3 mb-3">
                        <label for="price">Harga:</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            placeholder="Masukan harga"
                            class="w-full p-1.5 h-11 rounded border border-black outline-none">
                        @error('price')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ml-3 mb-3.5">
                        <label>Status:</label>
                        <div class="flex items-center gap-2 p-1.5">
                            <input type="radio" id="tersedia" name="status" value="Tersedia" {{ old('status') == "Tersedia" ? 'checked' : '' }} class="size-6"> <label for="tersedia">Tersedia</label>
                            <input type="radio" id="kosong" name="status" value="Kosong" {{ old('status') == "Kosong" ? 'checked' : '' }} class="size-6 ml-3"> <label for="kosong">Kosong</label>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ml-3 mb-3">
                        <label for="description">Deskripsi:</label>
                        <textarea name="description" id="description" placeholder="Masukan deskripsi"
                            class="w-full h-24 p-1.5 rounded border border-black resize-none outline-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-mB p-1.5 text-white rounded border border-black hover:bg-dB">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Submit
                </button>
            </div>

        </form>
    </div>

</x-app-layout>
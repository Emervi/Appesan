<x-app-layout title="Ubah Menu">

    <div class="bg-lB w-1/2 p-3 border-2 border-black rounded-md shadow-md">
        <div class="mb-5 flex justify-between relative">
            <a href="{{ route('admin.daftar-menu') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold">Ubah Menu</h1>
            </div>
        </div>

        @foreach ( $menu as $data )
        <form action="{{ route('admin.update-menu', [$data->menu_id]) }}" method="POST" class="font-roboto" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="flex justify-between mb-3">
                <div class="w-1/2">
                    <div class="mb-3 mr-3">
                        <h3>Gambar:</h3>
                        <input type="file" name="image"
                            class="w-full p-1.5 bg-mB rounded border border-black outline-none">
                        @error('image')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <h3>Nama:</h3>
                        <input type="text" name="name" value="{{ old('name', $data->name) }}" placeholder="Masukan nama"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('name')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <h3>Kategori:</h3>
                        <select name="category" class="w-full p-1.5 rounded border border-black outline-none">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Makanan" {{ old('category', $data->category) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Minuman" {{ old('category', $data->category) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Camilan" {{ old('category', $data->category) == 'Camilan' ? 'selected' : '' }}>Camilan</option>
                            <option value="Dessert" {{ old('category', $data->category) == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <h3>Deskripsi:</h3>
                        <textarea name="description" placeholder="Masukan deskripsi"
                            class="w-full h-24 p-1.5 rounded border border-black resize-none outline-none">{{ old('description', $data->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="ml-3 mb-3">
                        <h3>Gambar saat ini:</h3>
                        <div class="bg-mB flex flex-col justify-center items-center p-0.5 rounded border border-black">
                            <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu" class="size-28 rounded-md">
                        </div>
                    </div>

                    <div class="ml-3 mb-2.5">
                        <h3 for="price">Harga:</h3>
                        <input type="number" name="price" value="{{ old('price', $data->price) }}"
                            placeholder="Masukan harga"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('price')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ml-3 mb-3">
                        <label>Status:</label>
                        <div class="flex items-center gap-2 p-1.5">
                            <input type="radio" id="tersedia" name="status" value="Tersedia" {{ old('status') || $data->status == "Tersedia" ? 'checked' : '' }} class="size-6"> <label for="tersedia">Tersedia</label>
                            <input type="radio" id="kosong" name="status" value="Kosong" {{ old('status') || $data->status == "Kosong" ? 'checked' : '' }} class="size-6 ml-3"> <label for="kosong">Kosong</label>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-mB p-1.5 text-white rounded border border-black hover:bg-dB">
                    <i class="fas fa-save mr-2"></i>
                    Update
                </button>
            </div>

        </form>
        @endforeach
    </div>

</x-app-layout>
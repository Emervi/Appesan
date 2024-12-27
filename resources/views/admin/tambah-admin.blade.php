<x-app-layout title="Tambah Admin">


    <div class="bg-lB w-1/2 p-3 border-2 border-black rounded-md shadow-md">
        <div class="mb-5 flex justify-between relative">
            <a href="{{ route('admin.daftar-admin') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold">Tambah Admin</h1>
            </div>
        </div>

        <form action="{{ route('admin.simpan-admin') }}" method="POST" class="font-roboto">
            @csrf

            <div class="flex justify-between mb-3">
                <div class="w-1/2">
                    <div class="mb-3 mr-3">
                        <label for="name">Nama:</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukan nama"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('name')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukan email"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('email')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="ml-3 mb-3">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}"
                            placeholder="Masukan password"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('password')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ml-3 mb-3">
                        <label for="address">Alamat:</label>
                        <textarea name="address" id="address" placeholder="Masukan alamat"
                            class="w-full h-24 p-1.5 rounded border border-black resize-none outline-none">{{ old('address') }}</textarea>
                        @error('address')
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
<x-app-layout title="Ubah Pelanggan">

    <div class="bg-lB w-1/2 p-3 border-2 border-black rounded-md shadow-md">
        <div class="mb-5 flex justify-between relative">
            <a href="{{ route('admin.daftar-customer') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold">Ubah Pelanggan</h1>
            </div>
        </div>

        @foreach ( $customer as $data )
        <form action="{{ route('admin.update-customer', [$data->customer_id]) }}" method="POST" class="font-roboto">
            @csrf
            @method('put')

            <div class="flex justify-between mb-3">
                <div class="w-1/2">
                    <div class="mb-3 mr-3">
                        <h3>Nama:</h3>
                        <input type="text" name="name" value="{{ old('name', $data->name) }}" placeholder="Masukan nama"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('name')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mr-3">
                        <h3>Email:</h3>
                        <input type="email" name="email" value="{{ old('email', $data->email) }}" placeholder="Masukan email"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('email')
                            <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="ml-3 mb-3">
                        <h3>Username:</h3>
                        <input type="text" name="username" value="{{ old('username', $data->username) }}" placeholder="Masukan username"
                            class="w-full p-1.5 rounded border border-black outline-none">
                        @error('username')
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

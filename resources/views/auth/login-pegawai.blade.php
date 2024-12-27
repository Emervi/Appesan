<x-app-layout title="Login Pegawai">

    {{-- <div class="bg-red-500 sm:bg-orange-500 md:bg-yellow-500 lg:bg-green-500 xl:bg-blue-500"> --}}
        {{-- <p>WARNA</p> --}}
    {{-- </div> --}}

    <div class="container bg-lB w-full sm:w-1/2 md:w-2/5 lg:w-1/3 xl:w-1/3 rounded border-2 border-black flex flex-col items-center p-3">
        <h2 class="text-4xl font-semibold mb-3">Login Pegawai</h2>

        <form action="{{ route('login-pegawai') }}" method="POST" class="w-full">
            @csrf

            <div class="mb-3">
                <h3>Email:</h3>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email"
                    class="w-full p-1.5 rounded border border-black">
                @error('email')
                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <h3>Password:</h3>
                <input type="password" name="password" placeholder="Masukan Password"
                    class="w-full p-1.5 rounded border border-black">
                @error('password')
                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full flex justify-center">
                <button class="font-medium bg-dY w-1/3 py-2 rounded border border-black">Submit</button>
            </div>

        </form>

    </div>

</x-app-layout>
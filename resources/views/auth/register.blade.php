<x-app-layout title="Register">

    <div class="bg-lB w-full sm:w-1/2 md:w-2/5 lg:w-1/3 xl:w-1/3 rounded border-2 border-black flex flex-col items-center p-3">
        <h2 class="text-4xl font-semibold mb-3">Register</h2>

        <form action="" method="" class="w-full">
            @csrf

            <div class="mb-3">
                <h3>Nama:</h3>
                <input type="text" name="name" class="w-full p-1.5 rounded border border-black" placeholder="Masukan Nama">
            </div>

            <div class="mb-3">
                <h3>Username:</h3>
                <input type="text" name="username" class="w-full p-1.5 rounded border border-black" placeholder="Masukan Username">
            </div>

            <div class="mb-3">
                <h3>Email:</h3>
                <input type="email" name="email" class="w-full p-1.5 rounded border border-black" placeholder="Masukan Email">
            </div>

            <div class="mb-2">
                <h3>Password:</h3>
                <input type="password" name="password" class="w-full p-1.5 rounded border border-black" placeholder="Masukan Password">
            </div>

            <p class="text-sm mb-5">Sudah punya akun? <a href="{{ route('login') }}"
                    class="underline text-blue-800">klik disini!</a></p>

            <div class="w-full flex justify-center">
                <button class="font-medium bg-dY w-1/3 py-2 rounded border border-black">Submit</button>
            </div>

        </form>

    </div>

</x-app-layout>

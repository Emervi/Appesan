<x-app-layout :title="'Detail Menu'">

    @foreach ( $menu as $data )
    <div class="bg-mY p-2 rounded-md shadow-md border-2 border-black">
        <div class="flex justify-between mb-5 relative font-poppins">
            <a href="{{ route('menu') }}" class="z-20">
                <i class="fas fa-arrow-left text-4xl"></i>
            </a>
            <div class="absolute inset-0 flex justify-center items-center mt-3">
                <h1 class="text-center text-2xl font-bold">{{ $data->name }}</h1>
            </div>
        </div>

        <div class="font-roboto">
            <div class="mb-2">
                <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu" class="w-full h-60 object-cover rounded">
            </div>
            <h2 class="font-semibold text-2xl">{{ $data->formatted_price }}</h2>
            <p class="text-base mb-3">Kategori: {{ $data->category }}</p>
            <p class="text-lg">{{ $data->description }}</p>
        </div>
    </div>        
    @endforeach

</x-app-layout>
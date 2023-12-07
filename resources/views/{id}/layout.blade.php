<!-- resources/views/layouts/app.blade.php -->

<html>

<head>
    <title>Easy Order</title>
    @vite('resources/js/tw-elements.umd.min.js')
    @vite('resources/css/app.css')
    @vite('resources/css/all.css')

</head>
@php
    // Mendapatkan nilai angka dari URL
    $angka = request()->segment(1);
    $type = request()->segment(2);
@endphp

<body class="bg-[#e6e6e6]">
    <div class="md:container mx-auto min-h-screen flex flex-col px-5 py-3">
        <div class="header w-full">
            <p class="font-semibold text-xl text-neutral-700 text-left">EasyOrder</p>
        </div>
        @yield('content')
        <div id="footer"
            class="print:hidden flex flex-row items-center justify-center gap-5 md:gap-8 fixed bottom-5 left-[50%] right-[50%]">
            <a href="{{ route('menuPesanan', ['id_toko' => $angka, 'kategori' => 'makanan']) }}"
                class="food flex flex-col items-center h-full"><i
                    class="fa-solid fa-burger {{ $type == 'food' ? 'text-slate-300' : 'text-white' }} text-2xl"></i><span
                    class="text-gray-500 text-xl">food</span></a>
            <a href="{{ route('menuPesanan', ['id_toko' => $angka, 'kategori' => 'minuman']) }}"
                class="drink flex flex-col items-center h-full"><i
                    class="fa-solid fa-champagne-glasses {{ $type == 'drink' ? 'text-slate-300' : 'text-white' }} text-2xl"></i><span
                    class="text-gray-500 text-xl">drink</span>
            </a>
            <a href="{{ route('menuPesanan', ['id_toko' => $angka, 'kategori' => 'dessert']) }}"
                class="dessert flex flex-col items-center h-full"><i
                    class="fa-solid fa-lemon {{ $type == 'dessert' ? 'text-slate-300' : 'text-white' }} text-2xl"></i><span
                    class="text-gray-500 text-xl">dessert</span></a>
            <a href="{{ route('indexCart', $angka) }}"
                class="cart fixed flex justify-center items-center bottom-8 left-5 rounded-full w-16 h-16 {{ $type == 'cart' ? 'bg-neutral-100' : 'bg-neutral-300 ' }} shadow-md"><i
                    class="fa-solid fa-cart-shopping {{ $type == 'cart' ? 'text-slate-300' : 'text-white ' }} text-3xl"></i></a>
        </div>

    </div>
    @vite('resources/js/main.js')
</body>

</html>

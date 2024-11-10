<!-- resources/views/layouts/app.blade.php -->

<html>

<head>
    <title>Easy Order</title>
    @vite('resources/js/tw-elements.umd.min.js')
    @vite('resources/css/app.css')
    @vite('resources/css/all.css')
    @vite('resources/css/pelanggan.js')
    <style>
        /* .header {
            padding: 8px 24px;
            /* Padding atas dan bawah 8px, kiri dan kanan 24px */
        transition: padding 0.3s ease-in-out;
        /* Efek transisi pada padding */


        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #f0f0f0;
            padding: 10px 32pt;
            /* Ganti dengan warna abu-abu cerah yang diinginkan */
            z-index: 1000;
            /* Sesuaikan jika diperlukan agar tetap muncul di atas konten lain */
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
            transition: padding 0.3s ease-in-out, background-color 0.3s ease-in-out;
            /* Efek transisi pada padding dan background-color */
        }

        */ .listItem {
            display: flex;
            overflow-x: auto;
            /* Tambahkan overflow-x untuk scrolling horizontal jika terlalu banyak item */
            gap: 16px;
            /* Atur jarak antar item */
        }

        .item {
            flex: 0 0 200px;
            /* Tentukan lebar item */
        }

        /* Tambahkan warna latar belakang dan efek transisi untuk indikasi hover */
        .item:hover {
            background-color: #f0f0f0;
            transform: translateY(-1px);
        }

        .custom-scroll {
            overflow: auto;
            scrollbar-width: thin;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 8px;
            /* Atur lebar scrollbar */
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #808080;
            /* Warna bagian yang dapat di-scroll */
            height: 24px;
            /* Atur panjang scrollbar */
        }

        .custom-scroll::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>


</head>
@php
    // Mendapatkan nilai angka dari URL
    $angka = request()->segment(1);
    $type = request()->segment(2);
    $quantity = intval($__env->yieldContent('quantity'));
@endphp
{{-- @dd($toko) --}}

<body class="bg-[#e6e6e6]">
    <div class="print:hidden header w-full shadow-md px-[4vw] py-2 flex flex-row justify-between items-center bg-[#e6e6e6]"data-te-sticky-init
        data-te-sticky-boundary="true" data-te-sticky-direction="both" data-te-sticky-delay="75"
        data-te-sticky-z-index="499">
        <a href="/{{ $angka }}"
            class="print:hidden font-semibold text-2xl text-neutral-700 text-left hover:text-slate-500 transition-colors duration-200">EasyOrder</a>
        <div class="cart print:hidden">
            <a href="{{ route('indexCart', $angka) }}" class="cart flex justify-center items-center relative  w-10 h-10">
                <i
                    class="fa-solid fa-cart-shopping {{ $type == 'cart' ? 'text-slate-300' : 'text-white ' }} text-3xl hover:text-slate-100 transition-colors duration-200 group absolute top-0 left-0">
                </i>
                <p
                    class="text-sm text-white rounded-full w-[25px] h-[25px] text-center absolute bottom-0 right-0 group-hover:hover:text-slate-50 flex justify-center items-center p-0 {{ $quantity >= 1 ? 'bg-neutral-600' : 'bg-red-600' }}">


                    {{ $quantity !== '' ? $quantity : 0 }}
                </p>


            </a>
        </div>
    </div>
    <div class="md:container mx-auto flex flex-col px-5 py-3 print:p-0 print:m-0 relative print:w-fit">
        @yield('content')
    </div>
    @vite('resources/js/main.js')
    <script>
        window.onscroll = function() {
            var header = document.querySelector('.header');
            if (window.pageYOffset > 0) {
                header.classList.add('fixed-header');
            } else {
                header.classList.remove('fixed-header');
            }
        };
    </script>
</body>

</html>

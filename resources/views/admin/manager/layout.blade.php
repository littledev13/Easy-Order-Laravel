<!-- resources/views/layouts/app.blade.php -->

<html>

<head>
    <title>@yield('title') | Easy Order</title>
    @vite('resources/js/tw-elements.umd.min.js')
    @vite('resources/css/app.css')
    @vite('resources/css/all.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mx-auto">
        @section('header')
            <nav class="w-full sticky top-0 left-0 flex flex-row justify-between items-center">
                <h2 class="text-3xl text-[#101024] px-3">
                    Easy<sub>order</sub>
                </h2>
                <div class="navigation mt-3">
                    <ul class="flex flex-row gap-4 text-lg px-2 pb-1 w-fit border-b-2 border-slate-300 uppercase">
                        <li
                            class="hover:scale-110  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                            <a href="{{ route('manager.akun') }}">Akun</a>
                        </li>
                        <li
                            class="hover:scale-110  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                            <a href="{{ route('manager.menu') }}">Menu</a>
                        </li>
                        <li
                            class="hover:scale-110  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                            <a href="{{ route('manager.laporan') }}">laporan</a>
                        </li>
                        <li>
                            <a href="/logout.php"
                                class="w-fit h-fit rounded px-2 py-1 flex flex-row gap-1 items-center hover:cursor-pointer shadow-md bg-red-400 hover:bg-red-500 text-white scale-[.80]">
                                <i class="fa-solid fa-right-from-bracket"></i>

                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        @show
        @yield('content')
    </div>
    @vite('resources/js/main.js')
</body>

</html>

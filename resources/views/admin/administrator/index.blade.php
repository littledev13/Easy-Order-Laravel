<!-- resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Toko Not Found')

@section('header')
    <nav class="w-full sticky top-0 left-0 flex flex-row justify-between items-center">
        <h2 class="text-3xl text-[#101024] px-3">
            Easy<sub>order</sub>
        </h2>
        <div class="navigation mt-3">
            <ul class="flex flex-row gap-4 text-lg px-2 pb-1 w-fit border-b-2 border-slate-300 uppercase">
                <li
                    class="hover:scale-125  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                    <a href="/dashboard/toko">Toko</a>
                </li>
                <li
                    class="hover:scale-125  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                    <a href="/dashboard/akun">Akun</a>
                </li>
                <li
                    class="hover:scale-125  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                    <a href="/dashboard/menu">Menu</a>
                </li>
                <li
                    class="hover:scale-125  text-black text-center px-2 py-1 hover: hover:bg-slate-200 rounded-md transition-all duration-150">
                    <a href="/dashboard/pesanan">pesanan</a>
                </li>
                <li>
                    <a href="/logout.php"
                        class="w-fit h-fit rounded px-2 py-1 flex flex-row gap-1 items-center hover:cursor-pointer shadow-md bg-red-400 hover:bg-red-500 text-white scale-[.80]">
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
    <div class="w-full flex flex-col justify-center items-center gap-5">
        <a href="/logout.php">logout</a>
        <p class="text-2xl text-gray-600">harap scan barcode dari toko untuk memesan</p>
        <p class="text-lg text-gray-400">atau</p>
        <p class="text-2xl text-gray-600">Harap melakukan pemesanan, melalui a yang di sediakan toko</p>
        <p>{{ $user }}</p>
    </div>
@endsection

<!-- resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Toko Not Found')


@section('content')
    <div class="w-full h-full flex flex-col justify-center items-center gap-5">
        <p class="text-2xl text-gray-600">harap scan barcode dari toko untuk memesan</p>
        <p class="text-lg text-gray-400">atau</p>
        <p class="text-2xl text-gray-600">Harap melakukan pemesanan, melalui link yang di sediakan toko</p>
    </div>
@endsection

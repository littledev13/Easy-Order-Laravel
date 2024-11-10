<!-- resources/views/child.blade.php -->

@extends('admin.manager.layout')

@section('title', 'Manage Toko')
@section('id', $level->id)


@section('content')
    <div class="w-full flex flex-col justify-center items-center md:h-[90vh]">
        <p class="text-slate-400 text-2xl">Selamat Datang {{ $level->level }}</p>
        <p class="text-slate-400 text-2xl">Silahkan pilih menu</p>
    </div>
@endsection

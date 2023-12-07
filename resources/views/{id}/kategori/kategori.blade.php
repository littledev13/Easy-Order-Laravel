@extends('{id}.layout')
@php
    $angka = request()->segment(1);
@endphp


@section('content')
    <div
        class="w-full h-full flex flex-col md:flex-row md:flex-wrap justify-center items-center gap-5 md:justify-normal md:items-start md:pb-32 ">
        @forelse ($menu as $item)
            <form action="{{ route('updateCart', $angka) }}" method="post">
                @csrf
                @method('POST')
                <div
                    class="card max-w-[400px] h-[140px] rounded-lg bg-white flex flex-row items-center box-content overflow-hidden shadow-md shadow-gray-400 pr-2">

                    <div class="hidden">
                        <input type="text" value="{{ $item->id }}" name="id">
                        <input type="text" value="{{ $item->nama }}" name="nama">
                        <input type="text" value="{{ $item->harga }}" name="harga">
                        <input type="number" value="1" name="quantity">
                    </div>

                    <div class="img ">
                        <img src="/img/menu/{{ $item->image_url }}" alt=""
                            class="h-[140px] object-cover object-center">
                    </div>
                    <div class="details h-full  min-w-[250px] px-2">
                        <p class="text-xl font-semibold text-neutral-900">{{ $item->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $item->deskripsi }}</p>
                    </div>
                    <div class="action flex flex-col items-center gap-5">
                        <button type="submit" name="action" value="add"
                            class="btn  w-8 h-8 hover:text-slate-400 rounded-full text-slate-200 flex place-items-center justify-center">
                            <i class="fa-solid fa-circle-plus text-2xl"></i>
                        </button>
                        <button type="submit" name="action" value="minus"
                            class="btn  w-8 h-8 hover:text-slate-400 rounded-full text-slate-200 flex place-items-center justify-center">
                            <i class="fa-solid fa-circle-minus text-2xl"></i>
                        </button>
                    </div>
                </div>
            </form>

        @empty
            <p class="text-slate-400 text-2xl mt-[37vh] text-center w-full">Menu belum ada</p>
        @endforelse
    </div>
@endsection

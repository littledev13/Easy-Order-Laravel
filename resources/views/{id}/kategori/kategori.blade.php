@extends('{id}.layout')
@php
    $id = request()->segment(1);
    $kategori = request()->segment(2);
@endphp
@section('quantity', $quantity)

@section('content')
    <div
        class="w-full h-full flex flex-col md:flex-row md:flex-wrap justify-center items-center  md:justify-normal md:items-start md:pb-32">
        <p class="w-full text-center text-2xl text-neutral-800 font-semibold capitalize border-b-2 border-neutral-400 mb-5">
            {{ $kategori }}</p>
        <a href="{{ route('pesan', $id) }}"
            class=" px-5 py-2 text-white bg-primary rounded-md hover:bg-primary-600 hover:text-slate-100 hover:shadow-md"
            data-te-ripple-init data-te-ripple-color="light"><i class="fa-solid fa-arrow-left-long"></i></a>
        <div class="w-full mt-3 flex flex-row flex-wrap gap-4">
            @forelse ($menu as $item)
                <div class="item w-[200px] bg-white rounded transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-2 relative overflow-hidden"
                    data-te-ripple-init data-te-ripple-color="light">
                    <a href="{{ route('details', [$id, $kategori, $item->id]) }}"
                        class=" bg-transparent absolute w-full h-full top-0"></a>
                    <div class="image w-[200px] h-[200px]">
                        <img src="{{ asset('img/menu/' . $item->image_url) }}" alt=""
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-[4px] flex flex-col justify-between gap-5">
                        <div class="title">
                            <p>{{ $item->nama }}</p>
                        </div>
                        <div class="w-full flex flex-row justify-between items-center">
                            <div class="flex flex-row items-center gap-1 text-red-600 font-semibold">
                                <p class="text-sm">Rp</p>
                                <p>{{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                            <p>{{ $item->stock }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-2xl mt-[37vh] text-center w-full">Menu belum ada</p>
            @endforelse
        </div>
    </div>
@endsection

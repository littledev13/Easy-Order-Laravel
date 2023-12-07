<!-- resources/views/child.blade.php -->

@extends('admin.kasir.layout')

@section('title', 'Pesanan')



@section('content')
    <div class="w-full flex flex-col justify-center items-center ">

        {{-- Todo Title --}}
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800">History</p>
        {{-- Todo Create --}}
        <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-4 mt-5">
            @forelse ($data as $item)
                <div class="px-2 py-3 min-h-[150px] rounded shadow-md bg-slate-200 flex flex-col">
                    <div class="flex flex-row justify-between w-full">
                        <p class="text-slate-400 text-sm">{{ $item->no_nota }}</p>
                        <p class="text-slate-400 text-sm">{{ $item->created_at }}</p>
                    </div>
                    <div class="w-full flex-row justify-between flex h-full ">
                        <div class="flex flex-col justify-center">
                            <p class="text-xl"><span class="text-slate-600">Nama&ensp;&ensp;: </span>{{ $item->pembeli }}
                            </p>
                            <p class="text-xl"><span class="text-slate-600">Total&ensp;&ensp;&ensp;:
                                </span>{{ $item->total_harga }}</p>
                            @if ($item->pembayaran == 'paid')
                                <p class="text-xl text-success-600 uppercase"> <span
                                        class="text-slate-600">Pembayaran&ensp;:
                                    </span>{{ $item->pembayaran }}</p>
                            @else
                                <p class="text-xl text-danger-600 uppercase"> <span class="text-slate-600">Pembayaran&ensp;:
                                    </span>{{ $item->pembayaran }}</p>
                            @endif
                            @if ($item->status == 'dimasak')
                                <p class="text-xl text-warning-600 uppercase"><span class="text-slate-600">Status&ensp;:
                                    </span>{{ $item->status }}</p>
                            @else
                                <p
                                    class="text-xl  uppercase {{ $item->status == 'taked' ? 'text-success-600' : 'text-danger-600' }}">
                                    <span class="text-slate-600">Status&ensp;:
                                    </span>{{ $item->status }}
                                </p>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center items-center mr-5">
                            <i
                                class="fa-solid text-3xl {{ $item->status == 'taked' ? 'fa-circle-check text-success hover:text-success-600' : ($item->status == 'cancel' ? 'text-danger hover:text-danger-600 fa-circle-xmark' : '') }}"></i>

                        </div>
                    </div>
                </div>
            @empty
                <p>data tidak ada</p>
            @endforelse
        </div>


    </div>
@endsection

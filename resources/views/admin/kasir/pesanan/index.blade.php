<!-- resources/views/child.blade.php -->

@extends('admin.kasir.layout')

@section('title', 'Pesanan')



@section('content')
    <div class="w-full flex flex-col justify-center items-center ">
        @if (session()->has('berhasil'))
            <div class="mb-3 inline-flex w-full items-center rounded-lg bg-success-100 px-6 py-5 text-base text-success-700"
                role="alert">
                <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                {{ session('berhasil') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-3 inline-flex w-full items-center rounded-lg bg-danger-100 px-6 py-5 text-base text-danger-700"
                role="alert">
                <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <ul>

                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Todo Title --}}
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800">Pesanan</p>
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
                            @elseif ($item->status == 'matang')
                                <p class="text-xl text-warning-500 uppercase"><span class="text-slate-600">Status&ensp;:
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
                            <a href="{{ route('kasir.details', $item->no_nota) }}" class="hover:text-slate-500">
                                <i class="fa-solid fa-pen-to-square text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>data tidak ada</p>
            @endforelse
        </div>


    </div>
@endsection

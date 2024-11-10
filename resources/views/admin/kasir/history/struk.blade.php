@extends('admin.kasir.layout')
@section('title', 'Pesanan')
@section('content')

    <div
        class="flex flex-col items-center  w-[300px] px-5 py-3 print:p-0 shadow-md print:shadow-none mx-auto mt-5 print:m-0 print:absolute print:left-0 print:top-0">
        <p>{{ $toko->nama }}</p>
        <p>{{ $toko->alamat }}</p>
        <hr class="border-dashed border-slate-400 w-full  my-2">
        <div class="w-full flex flex-col">
            <div class="flex flex-row">
                <p class="w-[100px]">No Nota</p>
                <span>: {{ $nota->no_nota }}</span>
            </div>
            <div class="flex flex-row">
                <p class="w-[100px]">Pembeli</p>
                <span>: {{ $nota->pembeli }}</span>
            </div>
            <div class="flex flex-row">
                <p class="w-[100px]">No Meja</p>
                <span>: {{ $nota->no_meja }}</span>
            </div>
        </div>
        <hr class="border-dashed border-slate-400 w-full my-2">
        @foreach ($pesanan as $item)
            <div class="w-full flex flex-row justify-between items-start">
                <div>
                    <p>{{ $item->menu }}</p>
                    <p class="text-sm text-neutral-500">{{ $item->quantity }}x </p>
                </div>
                <p>Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
            </div>
        @endforeach
        <hr class="border-dashed border-slate-400 w-full my-2">
        <div class="details m-0 w-full">
            <div class="relative mb-3 print:my-0 print:mb-0 flex flex-row justify-between">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <div class="flex flex-row">
                        <span class="w-[100px]">Total</span>
                        <span>:</span>
                    </div>
                </div>
                <p><span class="font-semibold text-neutral-700">Rp
                    </span>{{ number_format($nota->total_harga, 0, ',', '.') }}</p>
            </div>
            <div class="relative my-0 flex flex-row justify-between">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <div class="flex flex-row">
                        <span class="w-[100px]">Pembayaran</span>
                        <span>:</span>
                    </div>
                </div>
                <p>
                    <span class="font-semibold text-neutral-700">Rp </span>
                    {{ number_format(floatval($nota->pembayaran), 0, ',', '.') }}
                </p>
            </div>
            <div class="relative my-0 flex flex-row justify-between">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <div class="flex flex-row">
                        <span class="w-[100px]">Kembalian</span>
                        <span>:</span>
                    </div>
                </div>
                <p><span class="font-semibold text-neutral-700">Rp
                    </span>{{ number_format(floatval($nota->kembalian), 0, ',', '.') }}</p>
            </div>
            <div class="relative mb-3 flex flex-row justify-between print:hidden">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <div class="flex flex-row">
                        <span class="w-[100px]">Pembeli</span>
                        <span>:</span>
                    </div>
                </div>
                <p>{{ $nota->pembeli }}</p>
            </div>
            <div class="w-full flex flex-row justify-center items-center gap-10 print:hidden">
                <a href="{{ route('kasir.history') }}" data-te-ripple-init data-te-ripple-color="light"
                    class="inline-block rounded bg-warning px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-warning-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-warning-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-warning-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] ">
                    Back
                </a>
                <button id="printButton" data-te-ripple-init data-te-ripple-color="light" onclick="window.print()"
                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Print
                </button>
            </div>
            <div class="print:flex flex-col items-center hidden text-lg mt-3">
                <p>Terima Kasih</p>
                <p>Selamat Menikmati</p>
            </div>
        </div>
    </div>
@endsection

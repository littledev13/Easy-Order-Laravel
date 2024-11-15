@extends('{id}.layout')
@php
    // Mendapatkan nilai angka dari URL
    $angka = request()->segment(1);
@endphp
@section('quantity', $quantity)
@section('content')
    {{-- {{ $total_harga }} --}}
    <div class="w-full h-full flex flex-col justify-center items-center md:pb-32">

        @if ($data)
            <div id="pesanan" class="bg-white rounded-md mx-auto w-[340pt] px-6 py-5 shadow-md">
                <p class="w-full text-center font-semibold text-neutral-800 mb-5">Rincian Pesanan</p>
                <form action="{{ route('orderPesanan', $angka) }}" method="post">
                    @csrf
                    @method('POST')
                    @php
                        $index = 0;
                    @endphp
                    @forelse ($data as $item)
                        @php
                            $index += 1;
                        @endphp
                        <div class="flex flex-row items-center gap-3">


                            <div id="item"
                                class="flex flex-row rounded-md shadow shadow-gray-500 px-3 py-2 justify-between items-center mb-3 w-full">
                                <div>

                                    <p class="font-semibold text-neutral-600">{{ $item['nama'] }}</p>
                                    <input type="text" name="nama_menu{{ $index }}" value="{{ $item['nama'] }}"
                                        id="" class="hidden">
                                    <div class="relative mt-2 w-32" data-te-input-wrapper-init>
                                        <input type="number" required
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="exampleFormControlInputNumber" placeholder="Example label"
                                            name="quantity{{ $index }}" value="{{ $item['quantity'] }}"
                                            min="1" max="50" />
                                        <label for="exampleFormControlInputNumber"
                                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Qty
                                        </label>
                                    </div>
                                </div>
                                <p class="text-slate-700"><span class="font-bold text-black">@ </span>Rp.
                                    {{ $item['harga'] }}
                                    <input type="text" name="harga{{ $index }}" value="{{ $item['harga'] }}"
                                        id="" class="hidden">

                                </p>
                            </div>
                            {{-- * Delete --}}
                            <a href="{{ route('deleteItem', [$angka, $item['nama']]) }}"
                                class="text-danger hover:text-danger-600 transition-colors duration-200 text-xl"><i
                                    class="fa-solid fa-circle-xmark"></i></a href="#">
                        </div>
                    @empty
                        <p class="text-slate-400 text-2xl mt-[37vh] text-center w-full md:mt-0">data tidak ada</p>
                    @endforelse



                    <div class="details mt-5">
                        <div class="relative mb-3" data-te-input-wrapper-init>
                            <input type="text"
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.4rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleFormControlInput1" placeholder="Example label" name="total_harga"
                                value="{{ $total_harga }}" readonly />
                            <label for="exampleFormControlInput1"
                                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Total
                                Harga | IDR
                            </label>

                        </div>
                        <div class="relative mb-3" data-te-input-wrapper-init>
                            <input type="number"
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.4rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleFormControlInput1" placeholder="Example label" name="nomor_meja" value=""
                                min="1" max="99" required />
                            <label for="exampleFormControlInput1"
                                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Nomor
                                Meja
                            </label>

                        </div>
                        <div class="relative mb-3" data-te-input-wrapper-init>
                            <input type="text"
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.4rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleFormControlInput1" placeholder="Example label" name="nama" required />
                            <label for="exampleFormControlInput1"
                                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Nama
                                Pemesan
                            </label>
                        </div>
                        <div class="w-full flex flex-row justify-center items-center">
                            <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                                class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                Pesan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <p class="w-[340pt] text-slate-600 text-sm pl-3 mt-2"><i class="fa-solid fa-circle-xmark"></i> untuk Hapus</p>
        @else
            <p class="text-slate-400 text-2xl mt-[37vh] text-center w-full md:mt-0">Tidak ada pesanan</p>
        @endif
        <a href="{{ route('pesan', $angka) }}"
            class=" px-5 py-2 text-white bg-primary rounded-md hover:bg-primary-600 hover:text-slate-100 hover:shadow-md mt-5"
            data-te-ripple-init data-te-ripple-color="light"><i class="fa-solid fa-arrow-left-long"></i></a>
    </div>
@endsection

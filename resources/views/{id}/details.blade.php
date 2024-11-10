@extends('{id}.layout')
@section('quantity', $quantity)

@section('content')
    @php
        $id = request()->segment(1);
        $kategori = request()->segment(2);
    @endphp
    {{-- {{ $menu }} --}}
    <div class="w-full flex flex-col justify-center items-center">
        <form action="{{ route('addPesanan', $id) }}" method="post">
            @csrf
            @method('POST')
            <div class="hidden">
                <input type="text" name="action" value="add">
                <input type="text" name="nama" value="{{ $menu->nama }}">
                <input type="text" name="id_toko" value="{{ $menu->id_toko }}">
                <input type="text" name="harga" value="{{ $menu->harga }}">
            </div>

            <div class="w-full mt-5 mb-3">
                <a href="{{ route('pesan', $id) }}"
                    class="px-5 py-2 text-white bg-primary rounded-md hover:bg-primary-600 hover:text-slate-100 hover:shadow-md"
                    data-te-ripple-init data-te-ripple-color="light"><i class="fa-solid fa-arrow-left-long"></i></a>
            </div>
            <div
                class="w-[60vw] flex flex-row justify-center items-stretch gap-5 h-full bg-white rounded-md shadow-md pr-5">
                <div class="right min-h-[200px] max-h-[350px] rounded-md  overflow-hidden">
                    <img src="{{ asset('img/menu/' . $menu->image_url) }}" alt="{{ $menu->nama }}"
                        class="block h-full w-full rounded-lg object-cover object-center">
                </div>
                <div class="left w-[30vw] h-full pt-3">
                    <p class="title font-semibold text-2xl text-neutral-800 capitalize">{{ $menu->nama }}</p>
                    <div class="flex flex-row items-center gap-1 text-red-600 font-semibold mb-3">
                        <p class="text-sm">Rp</p>
                        <p>{{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="deskripsi">
                        <p class="text-neutral-500 ">deskripsi</p>
                        <p>{{ $menu->deskripsi }}</p>
                    </div>
                    <div class="w-full mt-14 flex flex-col items-center justify-center gap-5">
                        <div class="flex flex-row gap-3 justify-center items-center">
                            {{-- <p>Qty</p> --}}
                            <div class="relative min-w-[72px]" data-te-input-wrapper-init>
                                <input type="number" name="quantity" required
                                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="exampleFormControlInputNumber" placeholder="Example label" min="0" />
                                <label for="exampleFormControlInputNumber"
                                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Qty
                                </label>
                            </div>
                            <p class=" text-slate-500">{{ $menu->stock }}</p>
                        </div>

                        <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                            class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            Add To Cart
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

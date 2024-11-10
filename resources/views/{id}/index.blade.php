@extends('{id}.layout')

@section('quantity', $quantity)
@section('content')
    @php
        $id = request()->segment(1);
        // $kategori = request()->segment(2);
        $groupedItems = collect($menu)->groupBy('kategori');

        // dd($groupedItems);

        // Outputkan hasilnya

    @endphp
    {{-- @dd($groupedItems->keys()) --}}

    <div class="w-full flex flex-col items-center h-[200vh]">
        <div class="intro mt-5 mb-5 text-center">

            <p class="text-slate-400 text-2xl">Selamat Datang di {{ $toko[0]->nama }} </p>
            <p class="text-slate-400 text-2xl">Silahkan pilih menu</p>
        </div>
        <div class="menu w-full bg-white rounded px-7 py-5">
            <p class="mb-2 font-semibold text-neutral-800 drop-shadow-md text-xl">Menu</p>
            <div class="flex flex-row gap-5 flex-wrap">
                @forelse ($pilihan as $item)
                    <div class="flex flex-col items-end justify-end bg-cover  item w-[150px] h-[150px] transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-1 hover:cursor-pointer rounded-md  border-neutral-500  overflow-hidden relative"
                        style="background-image: url('{{ asset('/img/kategori/' . $item->image_url) }}')" data-te-ripple-init
                        data-te-ripple-color="light">
                        <a href="{{ '/' . $id . '/' . $item->nama }}"
                            class=" bg-transparent absolute w-full h-full top-0"></a>
                        <p class="bg-white w-full text-center bottom-1 py-1 capitalize">{{ $item->nama }}</p>
                    </div>
                @empty
                    <p class="text-slate-400 text-2xl">Tidak ada Menu</p>
                @endforelse
                {{-- <div
                    class="flex flex-col items-end justify-end bg-cover item w-[150px] h-[150px] transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-1 hover:cursor-pointer rounded-md  border-neutral-500 bg-[url('https://source.unsplash.com/random/200x200/?Drink')] overflow-hidden">
                    <p class="bg-white w-full text-center bottom-1 py-1 uppercase">Drink</p>
                </div>
                <div
                    class="flex flex-col items-end justify-end bg-cover item w-[150px] h-[150px] transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-1 hover:cursor-pointer rounded-md  border-neutral-500 bg-[url('https://source.unsplash.com/random/300x300/?Dessert')] overflow-hidden">
                    <p class="bg-white w-full text-center bottom-1 py-1 uppercase">Dessert</p>
                </div>
                <div
                    class="flex flex-col items-end justify-end bg-cover item w-[150px] h-[150px] transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-1 hover:cursor-pointer rounded-md  border-neutral-500 bg-[url('https://source.unsplash.com/random/400x400/?fruit')] overflow-hidden">
                    <p class="bg-white w-full text-center bottom-1 py-1 uppercase">fruit</p>
                </div> --}}
            </div>
        </div>
        <div class="w-full mt-5">
            {{-- @foreach ($groupedItems as $sssss => $itemKategori)
                <div class="kategori">
                    <h1>{{ $sssss }}</h1>

                    @foreach ($itemKategori as $item)
                        <div class="item">
                            <p>{{ $item }}</p>
                            <!-- Tampilkan data lain jika diperlukan -->
                        </div>
                    @endforeach
                    <br>
                    <br>
                </div>
            @endforeach --}}
            @php
                $index = 1;
            @endphp
            @foreach ($groupedItems as $title => $itemKategori)
                {{-- @dd($itemKategori) --}}
                <div class="wrap mb-5" id="wrapper">
                    <p class="text-xl font-semibold drop-shadow-md capitalize">{{ $title }}</p>
                    <hr>
                    <div id="wrapper{{ $index }}"
                        class="wrapper flex flex-row gap-5 transition-all duration-300 relative">
                        @if (count($itemKategori) >= 5)
                            <button id="backward{{ $index }}" class="backward absolute top-[45%] left-5 z-50">
                                <i
                                    class="fa-solid fa-circle-arrow-left text-neutral-300 hover:text-neutral-500 text-4xl duration-[250ms] transition-colors"></i>
                            </button>

                            <button id="forward{{ $index }}" class="forward absolute top-[45%] right-5 z-50">
                                <i
                                    class="fa-solid fa-circle-arrow-right text-neutral-300 hover:text-neutral-500 text-4xl duration-[250ms] transition-colors"></i>
                            </button>
                        @endif
                        <div id="listItem{{ $index }}"
                            class="custom-scroll listItem flex flex-row gap-5 w-full overflow-hidden overflow-x-hidden pb-3 pt-1">
                            {{-- @dd(count($itemKategori)) --}}
                            @foreach ($itemKategori as $item)
                                {{-- <div class="item">
                                    <p>{{ $item }}</p>
                                    <!-- Tampilkan data lain jika diperlukan -->
                                </div> --}}
                                <div class="item w-[200px] bg-white rounded transition-transform duration-200 shadow hover:shadow-md hover:-translate-y-2 relative "
                                    data-te-ripple-init data-te-ripple-color="light">
                                    <a href="{{ route('details', [$id, $item->kategori, $item->id]) }}"
                                        class="bg-transparent absolute w-full h-full top-0 @if (strtolower($item->stock) !== 'tersedia') pointer-events-none @endif"></a>

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
                                            <p
                                                class="capitalize @if (strtolower($item->stock) !== 'tersedia') text-red-600 @else text-neutral-500 @endif">
                                                {{ $item->stock }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @if (count($itemKategori) >= 5)
                        <script>
                            let index{{ $index }} = {{ $index }};
                            document.addEventListener('DOMContentLoaded', (e) => {
                                let wrap = document.querySelector(`#listItem${index{{ $index }}}`);
                                let next = document.querySelector(`#forward${index{{ $index }}}`);
                                let back = document.querySelector(`#backward{{ $index }}`);

                                function updateButtons() {
                                    if (wrap.scrollLeft <= 0) {
                                        back.style.display = 'none';
                                        next.style.display = 'block';
                                    } else if (wrap.scrollLeft >= wrap.scrollWidth - wrap.clientWidth) {
                                        back.style.display = 'block';
                                        next.style.display = 'none';
                                    } else {
                                        back.style.display = 'block';
                                        next.style.display = 'block';
                                    }
                                }

                                window.addEventListener('resize', updateButtons);
                                updateButtons();

                                wrap.addEventListener('wheel', (e) => {
                                    e.preventDefault();
                                    wrap.scrollLeft += e.deltaY;
                                    updateButtons();
                                });

                                next.addEventListener('click', (e) => {
                                    wrap.style.scrollBehavior = 'smooth';
                                    wrap.scrollLeft += wrap.clientWidth;
                                    updateButtons();
                                });

                                back.addEventListener('click', (e) => {
                                    wrap.style.scrollBehavior = 'smooth';
                                    wrap.scrollLeft -= wrap.clientWidth;
                                    updateButtons();
                                });
                            });
                        </script>
                    @endif
                </div>
                @php
                    $index += 1;
                @endphp
            @endforeach

        </div>
        {{-- <div class="w-full">Minumam</div> --}}
    </div>
@endsection

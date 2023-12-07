@extends('{id}.layout')
@section('content')
    <div id="pesanan" class="bg-white rounded-md mx-auto w-[340pt] px-6 py-5 shadow-md">
        <p class="w-full text-center font-semibold text-neutral-800 mb-3">Rincian Pesanan</p>
        <div class="w-full text-sm text-slate-400 mb-1"><span class="font-semibold text-black">Nota :
            </span>{{ $data->no_nota }}</div>
        @forelse ($pesanan as $item)
            <div id="item"
                class="flex flex-row rounded-md shadow shadow-gray-500 px-3 py-2 justify-between items-center mb-3">
                <div>
                    <p class="font-semibold text-neutral-600">{{ $item['menu'] }}</p>
                    <p class="text-slate-400 peer block min-h-[auto] w-full rounded border-0 bg-transparent leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlInput1">{{ $item['quantity'] }}</p>
                </div>
                <p class="text-slate-700"><span class="font-bold text-black">@ </span>Rp. {{ $item['harga'] }}


                </p>
            </div>
        @empty
            <p class="text-slate-400 text-2xl mt-[37vh] text-center w-full md:mt-0">data tidak ada</p>
        @endforelse



        <div class="details mt-5">
            <div class="relative mb-3 flex flex-row justify-between">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <span>Total</span>
                    <span>:</span>

                </div>
                <p><span class="font-semibold text-neutral-700">Rp. </span>{{ $data->total_harga }}</p>

            </div>
            <div class="relative mb-3 flex flex-row justify-between">
                <div class="flex flex-row justify-between items-center w-20 font-semibold text-neutral-700">
                    <span>Pembeli</span>
                    <span>:</span>

                </div>
                <p>{{ $data->pembeli }}</p>

            </div>
            <div class="w-full flex flex-row justify-center items-center">
                <button id="printButton" data-te-ripple-init data-te-ripple-color="light"
                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Save
                </button>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            // Menyembunyikan tombol sebelum mencetak
            this.style.display = 'none';

            // Memanggil fungsi window.print() untuk mencetak
            window.print();

            // Menampilkan kembali tombol setelah pencetakan selesai atau dibatalkan
            this.style.display = 'block';
        });
    </script>
@endsection

@extends('admin.administrator.layout')

@section('title', 'Manage akun')

@section('content')
    {{-- {{ dd($pesanan, '\n', $nota) }} --}}
    @php
        $index = 0;
    @endphp
    <div id="pesanan" class="bg-white rounded-md mx-auto w-[340pt] px-6 py-5 shadow-md mt-5">
        <form action="{{ route('pesanan.update', $nota[0]->no_nota) }}" method="post" name="updateForm" id="updateForm">
            @csrf
            @method('PUT')
            <p class="w-full text-center font-semibold text-neutral-800 mb-5">Rincian Pesanan</p>
            <div class="w-full flex flex-row justify-between text-sm text-neutral-500 mb-1">
                <input type="text" name="no_nota" id="" value="{{ $nota[0]->no_nota }}" class="hidden">
                <p>{{ $nota[0]->no_nota }}</p>
                <p>{{ $nota[0]->created_at }}</p>
            </div>
            {{-- {{ print_r($pesanan) }}
            <br>
            <br>
            <br>
            {{ print_r($nota) }} --}}
            @foreach ($pesanan as $item)
                @php
                    $index += 1;
                @endphp
                <div id="item"
                    class="flex flex-row rounded-md shadow shadow-gray-500 px-3 py-2 justify-between items-center mb-3">
                    <div class="">
                        <input type="text" name="menu{{ $index }}" id="" value="{{ $item->menu }}"
                            class="hidden">
                        <input type="text" name="harga{{ $index }}" id="" value="{{ $item->harga }}"
                            class="hidden">
                        <p class="font-semibold text-neutral-600">{{ $item->menu }}</p>
                        <input type="number"
                            class="text-slate-400 peer block min-h-[auto] w-full rounded border-0 bg-transparent leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleFormControlInput1" placeholder="Example label" name="quantity{{ $index }}"
                            value="{{ $item->quantity }}" min="0" />
                    </div>
                    <p class="text-slate-700"><span class="font-bold text-black">@ </span>Rp. {{ $item->harga }}</p>
                </div>
            @endforeach
            {{-- tttt --}}
            <div class="mt-3">
                <div class="relative mb-3" data-te-input-wrapper-init>
                    <input type="text"
                        class="peer block min-h-[auto] w-full rounded border-0 bg-neutral-100 px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:bg-neutral-700 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlInput50" value="{{ $nota[0]->pembeli }}" aria-label="readonly input example"
                        name="pembeli" />
                    <label for="exampleFormControlInput50"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Pembeli
                    </label>
                </div>

                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Status
                    {{ $nota[0]->pembayaran == 'paid' ? '' : 'Pembayaran' }}</label>
                <select
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{ $nota[0]->pembayaran == 'paid' ? 'hidden' : '' }}"
                    required name="pembayaran">
                    <option selected disabled value="">Pembayaran</option>
                    <option value="paid">Paid</option>
                    {{-- <option value="unpaid">Unpaid</option> --}}
                </select>
                <select id="count"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 {{ $nota[0]->pembayaran == 'unpaid' ? 'hidden' : '' }}"
                    required name="status" disabled>
                    <option selected value="{{ $nota[0]->status }}">{{ $nota[0]->status }}</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>

                <div class="w-full mt-7 flex place-content-center gap-10">
                    <div>
                        <a href="{{ route('pesanan') }}"
                            class="mx-auto inline-block rounded bg-info px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-info-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-info-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-info-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            BACK
                        </a>
                    </div>
                    <div>
                        <button type="submit" data-te-ripple-init data-te-ripple-color="light" form="updateForm"
                            class="mx-auto inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] {{ $nota[0]->pembayaran == 'paid' ? 'hidden' : '' }}">
                            Update
                        </button>
                    </div>
        </form>

        <form action="{{ route('pesanan.delete', $nota[0]->no_nota) }}" method="post" name="delForm" id="delForm">
            @csrf
            @method('DELETE')

            <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                class="mx-auto inline-block rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] {{ $nota[0]->pembayaran == 'paid' ? 'hidden' : '' }}"
                onclick="return confirm('Hapus Pesanan?')">
                Cancel
            </button>
        </form>
        <form action="{{ route('pesanan.taked', $nota[0]->no_nota) }}" method="post" name="delForm" id="delForm"
            class="{{ $nota[0]->pembayaran == 'unpaid' ? 'hidden' : '' }}">
            @csrf
            @method('PUT')
            <input type="text" name="no_nota" id="" value="{{ $nota[0]->no_nota }}" class="hidden">
            <input type="text" name="status" id="" value="taked" class="hidden">

            <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                class="mx-auto inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                onclick="return confirm('Menyelesaikan Pesanan?')">
                TAKED
            </button>
        </form>

    </div>
    </div>
    {{-- <script>
        function submitUpdateForm() {
            // Cari formulir dengan ID updateForm
            var updateForm = document.getElementById('updateForm');

            // Periksa apakah formulir ditemukan
            if (updateForm) {
                // Kirimkan submit formulir
                updateForm.submit();
            } else {
                console.error('Formulir dengan ID updateForm tidak ditemukan.');
            }
        }
    </script> --}}

@endsection

<!-- resources/views/child.blade.php -->

@extends('admin.koki.layout')

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
        <div class="w-full mt-5 px-10">
            <form action="" method="GET">
                <div class="relative m-[2px] mb-3 mr-5">
                    <label for="inputSearch" class="sr-only">Search </label>
                    <input id="inputSearch" name="search" type="search" placeholder="Search..."
                        class="block w-64 rounded-lg border-2 dark:border-none dark:bg-neutral-600 py-2 pl-10 pr-4 text-sm focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-400" />
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4 text-neutral-500 dark:text-neutral-200">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                </div>
            </form>
            <table class="min-w-full text-center text-sm font-light">
                <thead class="border-b bg-cyan-400 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                    <tr>
                        <th scope="col" class=" px-6 py-4 border" colspan="1">No</th>
                        <th scope="col" class=" px-6 py-4 border" colspan="2">Pembeli</th>
                        <th scope="col" class=" px-6 py-4 border" colspan="2">No Nota</th>
                        <th scope="col" class="w-fit border" colspan="2">Tgl</th>
                        <th scope="col" class=" px-6 py-4 border" colspan="4">List Pesanan</th>
                        <th scope="col" class=" px-6 py-4 border"colspan="2">Status</th>
                        <th scope="col" class=" px-6 py-4 border" colspan="1">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse ($data as  $akun)
                        @php
                            $index = $data->firstItem() + $loop->index;
                        @endphp
                        <tr class="{{ $index % 2 === 0 ? 'even:bg-white' : 'odd:bg-slate-50' }}">
                            <td class="whitespace-nowrap border" colspan="1">{{ $index }}</td>
                            <td class="whitespace-nowrap border"colspan="2">{{ $akun->pembeli }}</td>
                            <td class="whitespace-nowrap border"colspan="2">{{ $akun->no_nota }}</td>
                            <td class="whitespace-nowrap w-fit border"colspan="2">{{ $akun->updated_at }}</td>
                            <td class="whitespace-nowrap border px-3" colspan="4">
                                <ul class="flex flex-col items-start justify-center gap-2 px-4 py-2 list-disc">
                                    <li class="">
                                        <div class="flex flex-col items-start justify-center">
                                            <p class="font-semibold">Kopi</p>
                                            <span class="text-slate-600">Catatan : Less Sugar</span>
                                        </div>
                                    </li>
                                    <li class="">
                                        <div class="flex flex-col items-start justify-center">
                                            <p class="font-semibold">Kopi</p>
                                            <span class="text-slate-600">Catatan : Less Sugar</span>
                                        </div>
                                    </li>
                                    <li class="">
                                        <div class="flex flex-col items-start justify-center">
                                            <p class="font-semibold">Kopi</p>
                                            <span class="text-slate-600">Catatan : Less Sugar</span>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                            {{-- <td class="whitespace-nowrap border">
                                Rp {{ number_format(floatval($akun->pembayaran), 0, ',', '.') }}

                            </td>
                            @php
                                $kembalian = floatval($akun->pembayaran) - $akun->total_harga;
                            @endphp
                            <td class="whitespace-nowrap border">
                                Rp {{ number_format(floatval($akun->kembalian), 0, ',', '.') }}

                            </td> --}}
                            <td class="whitespace-nowrap border" colspan="2">{{ $akun->status }}</td>
                            <td class="whitespace-nowrap border " colspan="1">
                                <div class="h-full flex flex-row gap-5 items-center justify-center">
                                    <a href="{{ route('koki.details', $akun->no_nota) }}"
                                        class="hover:text-[#0000FF] text-blue-500 text-xl -mt-3">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="whitespace-nowrap border text-center">Data belum
                                ada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="w-full flex flex-row justify-center items-center my-5">
            <nav aria-label="Page navigation example">
                <ul class="list-style-none flex">
                    <!-- Tombol Previous -->
                    @if ($data->onFirstPage())
                        <li>
                            <a
                                class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400">Previous</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $data->previousPageUrl() }}"
                                class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-200 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white">Previous</a>
                        </li>
                    @endif

                    <!-- Tampilkan halaman-halaman -->
                    {{-- @dd($data->totalPage()) --}}
                    @for ($page = max(1, $data->currentPage() - 2); $page <= min($data->lastPage(), $data->currentPage() + 2); $page++)
                        <li aria-current="{{ $page == $data->currentPage() ? 'page' : '' }}">
                            <a href="{{ $data->url($page) }}"
                                class="relative block rounded  px-3 py-1.5 text-sm font-medium text-neutral-600 transition-all duration-300 hover:bg-neutral-200 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white {{ $page == $data->currentPage() ? 'bg-neutral-400 pointer-events-none' : '' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endfor

                    <!-- Tombol Next -->
                    @if ($data->hasMorePages())
                        <li>
                            <a href="{{ $data->nextPageUrl() }}"
                                class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-200 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white">Next</a>
                        </li>
                    @else
                        <li>
                            <a
                                class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400">Next</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

    </div>
@endsection

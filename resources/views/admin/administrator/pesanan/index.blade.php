<!-- resources/views/child.blade.php -->

@extends('admin.administrator.layout')

@section('title', 'Manage Pesanan')



@section('content')
    {{-- @dd($nota) --}}
    {{-- Todo Table --}}
    <div class="overflow-x-auto w-full">
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800 mb-5">Laporan</p>

        {{-- <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8 mx-auto"> --}}
        <div class="overflow-hidden w-[90vw] min-w-[620px] mx-auto">
            <div class="filter m-0 flex justify-between items-center flex-row">
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
                <form action="" method="GET">
                    <div class="relative m-[2px] mb-3 mr-5 flex flex-row items-center gap-3">
                        <input id="inputSearch" name="date" type="date" placeholder="Search..."
                            class="block rounded-lg border-2 dark:border-none dark:bg-neutral-600 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-400" />
                        <button type="submit"
                            class="inline-block rounded bg-primary px-4 pb-1 pt-1.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
            <table class="min-w-full text-center text-sm font-light">
                <colgroup>
                    <col style="width: 1%;" /> <!-- No -->
                    <col style="width: 25%;" /> <!-- Nama -->
                    <col style="width: 25%;" /> <!-- Pemilik -->
                    <col style="width: 10%;" /> <!-- Pemilik -->
                    <col style="width: 7.5%;" /> <!-- Deskripsi -->
                    <col style="width: 7.5%;" /> <!-- Alamat -->
                    <col style="width: 10%;" /> <!-- Action -->
                    <col style="width: 20%;" /> <!-- Action -->
                </colgroup>
                <thead class="border-b bg-cyan-400 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                    <tr>
                        <th scope="col" class=" px-6 py-4 border">No</th>
                        <th scope="col" class=" px-6 py-4 border">Pembeli</th>
                        <th scope="col" class=" px-6 py-4 border">No Nota</th>
                        <th scope="col" class=" px-6 py-4 border">Tgl</th>
                        <th scope="col" class=" px-6 py-4 border">Total Harga</th>
                        <th scope="col" class=" px-6 py-4 border">Pembayaran</th>
                        <th scope="col" class=" px-6 py-4 border">Kembalian</th>
                        <th scope="col" class=" px-6 py-4 border">Status</th>
                        <th scope="col" class=" px-6 py-4 border">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse ($nota as $index => $akun)
                        <tr class="{{ $index % 2 === 0 ? 'even:bg-white' : 'odd:bg-slate-50' }}">
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $index + 1 }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $akun->pembeli }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $akun->no_nota }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $akun->created_at }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">
                                Rp {{ number_format($akun->total_harga, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">
                                Rp {{ number_format(floatval($akun->pembayaran), 0, ',', '.') }}

                            </td>
                            @php
                                $kembalian = floatval($akun->pembayaran) - $akun->total_harga;
                            @endphp
                            <td class="whitespace-nowrap px-6 py-4 border">
                                Rp {{ number_format(floatval($akun->kembalian), 0, ',', '.') }}

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $akun->status }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border ">
                                <div class="h-full flex flex-row gap-5 items-center justify-center">
                                    <a href="{{ route('admin.details', $akun->no_nota) }}"
                                        class="hover:text-[#0000FF] text-blue-500 text-xl -mt-3">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="whitespace-nowrap px-6 py-4 border text-center">Data belum
                                ada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Tampilkan pagination -->
            <div class="w-full flex flex-row justify-center items-center my-5">
                <nav aria-label="Page navigation example">
                    <ul class="list-style-none flex">
                        <!-- Tombol Previous -->
                        @if ($nota->onFirstPage())
                            <li>
                                <a
                                    class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400">Previous</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $nota->previousPageUrl() }}"
                                    class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-200 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white">Previous</a>
                            </li>
                        @endif

                        <!-- Tampilkan halaman-halaman -->
                        {{-- @dd($nota->totalPage()) --}}
                        @for ($page = max(1, $nota->currentPage() - 2); $page <= min($nota->lastPage(), $nota->currentPage() + 2); $page++)
                            <li aria-current="{{ $page == $nota->currentPage() ? 'page' : '' }}">
                                <a href="{{ $nota->url($page) }}"
                                    class="relative block rounded  px-3 py-1.5 text-sm font-medium text-neutral-600 transition-all duration-300 hover:bg-neutral-200 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white {{ $page == $nota->currentPage() ? 'bg-neutral-400 pointer-events-none' : '' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endfor

                        <!-- Tombol Next -->
                        @if ($nota->hasMorePages())
                            <li>
                                <a href="{{ $nota->nextPageUrl() }}"
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
        {{-- </div> --}}
    </div>

@endsection

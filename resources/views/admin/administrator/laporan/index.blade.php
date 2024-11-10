@extends('admin.administrator.layout')

@section('title', 'Laporan')



@section('content')
    <div class="w-full flex flex-col items-center md:h-[90vh]">
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800">Laporan</p>
        <div class="summary w-full mt-5">
            <ul class="w-full ">
                <li class="flex flex-row">
                    <p class="w-[170px] font-semibold">Total Toko</p><span>: {{ $summary['toko'] }}</span>
                </li>
                <li class="flex flex-row">
                    <p class="w-[170px] font-semibold">Pesanan Selesai</p><span>: {{ $summary['nota'] }}</span>
                </li>
                <li class="flex flex-row">
                    <p class="w-[170px] font-semibold">Total Menu</p><span>: {{ $summary['menu'] }}</span>
                </li>
                <li class="flex flex-row">
                    <p class="w-[170px] font-semibold">Total Pendapatan Toko</p><span>:
                        Rp {{ number_format($summary['total_harga'], 0, ',', '.') }}</span>
                </li>
            </ul>
        </div>
        <div class="tabel w-full">
            <table class="w-full text-center text-sm font-light mt-4">
                <colgroup>
                    <col style="width: 1%;" /> <!-- No -->
                    <col style="width: 30%;" /> <!-- Nama -->
                    <col style="width: 29%;" /> <!-- Pemilik -->
                    <col style="width: 10%;" /> <!-- Pemilik -->
                    <col style="width: 15%;" /> <!-- Deskripsi -->
                    <col style="width: 15%;" /> <!-- Alamat -->
                    {{-- <col style="width: 10%;" /> <!-- Action -->
                    <col style="width: 20%;" /> <!-- Action --> --}}
                </colgroup>
                <thead class="border-b bg-cyan-400 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                    <tr>
                        <th scope="col" class=" px-6 py-4 border">No</th>
                        <th scope="col" class=" px-6 py-4 border">Nama Toko</th>
                        <th scope="col" class=" px-6 py-4 border">Owner</th>
                        <th scope="col" class=" px-6 py-4 border">ID Toko</th>
                        <th scope="col" class=" px-6 py-4 border">Pesanan Selesai</th>
                        <th scope="col" class=" px-6 py-4 border">Menu</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse ($data as $index => $tokoItem)
                        <tr class="{{ $index % 2 === 0 ? 'even:bg-white' : 'odd:bg-slate-50' }}">
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $index + 1 }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem['nama'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem['pemilik'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem['id_toko'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem['nota'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem['menu'] }}</td>
                            {{-- <td class="whitespace-nowrap px-6 py-4 border">{{ $tokoItem->total_pesanan }}</td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="whitespace-nowrap px-6 py-4 border text-center">Data belum ada.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
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
    </div>
@endsection

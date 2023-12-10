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
                        Rp. {{ $summary['total_harga'] }}</span>
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
        </div>
    </div>
@endsection

<!-- resources/views/child.blade.php -->

@extends('admin.kasir.layout')

@section('content')
    @php
        $total_nota = [];
        $total_nota_taked = [];
        $total_nota_cancel = [];
        $total_harga_taked = [];

        foreach ($data as $tanggal => $detail) {
            $total_nota[] = $detail['total_nota'];
            $total_nota_taked[] = $detail['jumlah_nota_taked'];
            $total_nota_cancel[] = $detail['jumlah_nota_cancel'];
            $total_harga_taked[] = $detail['total_harga_taked'];
        }
    @endphp
    <div class="w-full flex flex-col items-center md:h-[90vh]">
        <p class="w-full text-center border-b-2 border-slate-400 text-xl font-semibold text-neutral-800">Laporan</p>
        <div class="w-[50%] mt-10">
            <canvas id="myChart"></canvas>
        </div>

        <div class="table mt-10">
            <table class="min-w-full text-center text-sm font-light">
                <colgroup>
                    <col style="width: 5%;" /> <!-- No -->
                    <col style="width: 25%;" /> <!-- Nama -->
                    <col style="width: 17.5%;" /> <!-- Pemilik -->
                    <col style="width: 17.5%;" /> <!-- Deskripsi -->
                    <col style="width: 35%;" /> <!-- Alamat -->
                </colgroup>
                <thead class="border-b bg-cyan-400 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                    <tr>
                        <th scope="col" class=" px-6 py-4 border">No</th>
                        <th scope="col" class=" px-6 py-4 border">Tanggal</th>
                        <th scope="col" class=" px-6 py-4 border">Taked</th>
                        <th scope="col" class=" px-6 py-4 border">Cancel</th>
                        <th scope="col" class=" px-6 py-4 border">Income</th>
                    </tr>
                </thead>
                <tbody class="">
                    @php
                        $no = 0;
                    @endphp
                    @forelse ($data as $index => $item)
                        <tr class="even:bg-white odd:bg-slate-50">
                            @if ($item['jumlah_nota_taked'] >= 1 || $item['jumlah_nota_cancel'] >= 1)
                                <td class="whitespace-nowrap px-6 py-4 border">{{ ++$no }}</td>
                                <td class="whitespace-nowrap px-6 py-4 border">{{ $index }}</td>
                                <td class="whitespace-nowrap px-6 py-4 border">{{ $item['jumlah_nota_taked'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 border">{{ $item['jumlah_nota_cancel'] }}</td>
                                <td class="whitespace-nowrap px-6 py-4 border">{{ $item['total_harga_taked'] }}</td>
                                {{-- @else
                                <td colspan="5" class="whitespace-nowrap px-6 py-4 border text-center">Belum ada data
                                </td> --}}
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="whitespace-nowrap px-6 py-4 border text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_keys($data)),
                datasets: [{
                        label: 'Taked',
                        data: @json($total_nota_taked),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cancel',
                        data: @json($total_nota_cancel),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            max: 150 // Sesuaikan sesuai kebutuhan
                        }
                    }
                }
            }
        });
    </script>
@endsection

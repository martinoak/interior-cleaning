@extends('admin/layout')

@section('head')
    <script src=" https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js "></script>
@endsection

@section('content')
    <div class="heading">
        <h1 class="heading-title">Administrace</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
        <div class="cell flex">
            <div class="cell-content justify-between">
                <h2 class="cell-title">Celkový zisk</h2>
                <p class="cell-text"><i class="text-primary fa-solid fa-dollar-sign icon"></i>{{ number_format($total, 0, ',', ' ') }},-</p>
            </div>
        </div>
        <div class="cell flex">
            <div class="cell-content justify-between">
                <h2 class="cell-title">Roční {{ $annual >= 0 ? 'zisk' : 'ztráta' }}</h2>
                <p class="cell-text"><i class="text-yellow-500 fa-solid fa-dollar-sign icon"></i>{{ number_format($annual, 0, ',', ' ') }},-</p>
            </div>
        </div>
        <div class="cell flex">
            <div class="cell-content justify-between">
                <h2 class="cell-title">Měsíční {{ $month >= 0 ? 'zisk' : 'ztráta' }}</h2>
                <p class="cell-text"><i class="text-green-500 fa-solid fa-dollar-sign icon"></i>{{ number_format($month, 0, ',', ' ') }},-</p>
            </div>
        </div>
        <div class="cell flex">
            <div class="cell-content justify-between">
                <h2 class="cell-title">Zákazníci</h2>
                <p class="cell-text"><i class="text-indigo-700 fa-solid fa-users-line icon"></i>{{ \App\Models\Customer::all()->count() }}</p>
            </div>
        </div>
    </div>
    <div class="flex justify-between gap-4 mb-4">
        <div class="cell w-full sm:w-2/3 hidden sm:block">
            <h2 class="cell-title">Graf výdělků</h2>
            <canvas id="earningChart" class="w-full mt-4"></canvas>
            <script>
                const earning = document.getElementById('earningChart');
                earning.height = 600;

                new Chart(earning, {
                    type: 'line',
                    data: {
                        labels: ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'],
                        datasets: [
                            @foreach($earnings as $year => $yearEarning)
                            {
                                label: {{ $year }},
                                data: [
                                    @foreach($yearEarning as $monthEarning)
                                        {{ $monthEarning }},
                                    @endforeach
                                ],
                                hidden: '{{ $year !== (int)date('Y') }}',
                                borderColor: '{{ config('web.admin.chartColors.'.$year) }}',
                                backgroundColor: 'transparent',
                                pointStyle: 'circle',
                                pointRadius: function (context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    return value === 0 ? 0 : 8
                                },
                                pointBackgroundColor: function (context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    return value < 0 ? 'red' : '{{ config('web.admin.chartColors.'.$year) }}'
                                },
                                pointBorderWidth: 0,
                                tension: 0.1
                            },
                            @endforeach
                        ]
                    }})
            </script>
        </div>
        <div class="cell w-full sm:w-1/3">
            <h2 class="cell-title">Poměr variant</h2>
            <canvas id="variantCharts" class="mt-4"></canvas>
            <script>
                const ctx = document.getElementById('variantCharts');

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: [@foreach($variants as $variant => $count)'{{ $variant }}',@endforeach],
                        datasets: [{
                            data: [@foreach($variants as $count) {{ $count }},@endforeach],
                            backgroundColor: ['rgb(255 145 25)', 'rgb(48 86 211)', 'rgb(21 128 61)'],
                            borderColor: 'transparent',
                            hoverOffset: 6
                        }]
                    }
                });
            </script>
        </div>
    </div>
@endsection

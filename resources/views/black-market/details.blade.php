@section('title', 'OB Tools - Market Price Checker')
<x-app-layout>
    <x-slot:cdn>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/dayjs.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/plugin/customParseFormat.min.js"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Historical Sell Orders - ') . $itemInfo .  ($quality ? ' > Quality: ' . $quality : '') }}
        </h2>
    </x-slot>
    <div class="py-4 sm:px-6 lg:px-8 bg-gray-700 text-sm text-gray-300 leading-tight">
        <p>Welcome to the secret module of Oathbreakers web tool. This was supposed to be a "personal use only" module, but here we are. Few people are given access, so don't tell anyone.</p>
     </div>
    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 grid grid-cols-2 max-sm:grid-cols-1 gap-3">
            @foreach ($object as $item)
                <x-ui.card>
                    <x-slot:title>
                        Quality: {{ $qualityNames[$item->quality] }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.list/>
                    </x-slot:icon>
                    <x-slot:content>
                        <canvas id="barChart{{ $loop->index }}" class="h-96 max-h-96"></canvas>
                    </x-slot>
                </x-ui.card>
            @endforeach
        </div>

    </div>
    <script>
        var ctx = null;
        var myChart = null;
        @foreach ($object as $item)
        ctx = document.getElementById('barChart{{ $loop->index }}').getContext('2d');
        myChart = new Chart(ctx, {
            type: 'line',
            options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return dayjs(this.getLabelForValue(value), "yyyy-MM-dd HH:mm:ss")
                                    .format('MM-DD hh:mm');
                                }
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',

                            // grid line settings
                            grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                            },
                    },
                    }
                },
            data: {
                labels: @json($item->data->timestamps),
                datasets: [{
                    label: 'Avg. Prices',
                    data: @json($item->data->prices_avg),
                    backgroundColor: 'rgba(192, 75, 75, 0.2)',
                    borderColor: 'rgba(192, 75, 75, 1)',
                    borderWidth: 1,
                    yAxisID: 'y',
                },
                {
                    label: 'Item Count',
                    data: @json($item->data->item_count),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1',
                }]
            }
        });
        @endforeach
    </script>
</x-app-layout>

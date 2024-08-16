@extends('layouts.app')

@section('content')
<div class="container">
    <h1>営業データ</h1>
    <div class="row">
        <div class="col-md-12"><canvas id="monthlyOrdersChart"></canvas></div>
        <div class="col-md-6"><canvas id="statusDistributionChart"></canvas></div>
        <div class="col-md-6"><canvas id="userOrderRatesChart"></canvas></div>
    </div>
    <div class="form-group">
        <label for="itemSelect">アイテムを選択してください:</label>
        <select id="itemSelect" class="form-control">
            <option value="" selected disabled>アイテムを選択</option>
            @foreach($items as $item)
            <option value="{{ $item->id}}">Item ID: {{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- 選択されたアイテムの使用率を表示する4つの円グラフ -->
    <div class="row">
        <div class="col-md-6">
            <h3>Diff 使用率</h3>
            <canvas id="diffUsageChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Acc 使用率</h3>
            <canvas id="accUsageChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Cost 使用率</h3>
            <canvas id="costUsageChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Risk 使用率</h3>
            <canvas id="riskUsageChart"></canvas>
        </div>
    </div>
</div>



    <canvas id="customerOrderDataChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 月ごとの受注数データ
        const monthlyOrdersData = @json($monthlyOrders);
        const monthlyOrdersLabels = monthlyOrdersData.map(data => `${data.year}-${data.month}`);
        const monthlyOrdersCounts = monthlyOrdersData.map(data => data.count);

        const monthlyOrdersChart = new Chart(document.getElementById('monthlyOrdersChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: monthlyOrdersLabels,
                datasets: [{
                    label: '月ごとの受注数',
                    data: monthlyOrdersCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // ステータスの分布データ
        const statusDistributionData = @json($statusDistribution);
        const statusDistributionLabels = ['Issued', 'Ordered', 'On Hold'];
        const statusDistributionCounts = [
            statusDistributionData.reduce((acc, data) => acc + (data.issued ? data.count : 0), 0),
            statusDistributionData.reduce((acc, data) => acc + (data.ordered ? data.count : 0), 0),
            statusDistributionData.reduce((acc, data) => acc + (data.on_hold ? data.count : 0), 0)
        ];

        const statusDistributionChart = new Chart(document.getElementById('statusDistributionChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: statusDistributionLabels,
                datasets: [{
                    label: 'ステータスの分布',
                    data: statusDistributionCounts,
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // ユーザごとの受注率データ
        const userOrderRatesData = @json($userOrderRates);
        const userOrderRatesLabels = userOrderRatesData.map(user => user.name);
        const userOrderRatesCounts = userOrderRatesData.map(user => user.estimates_count);

        const userOrderRatesChart = new Chart(document.getElementById('userOrderRatesChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: userOrderRatesLabels,
                datasets: [{
                    label: 'ユーザごとの受注率',
                    data: userOrderRatesCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 顧客ごとの受注データ
        const customerOrderData = @json($customerOrderData);
        const customerOrderLabels = customerOrderData.map(customer => customer.name);
        const customerOrderCounts = customerOrderData.map(customer => customer.estimates_count);

        const customerOrderDataChart = new Chart(document.getElementById('customerOrderDataChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: customerOrderLabels,
                datasets: [{
                    label: '顧客ごとの受注データ',
                    data: customerOrderCounts,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let diffUsageChart, accUsageChart, costUsageChart, riskUsageChart;

        document.getElementById('itemSelect').addEventListener('change', function() {
            const itemId = this.value;

            if (!itemId) {
                return;
            }

            // 選択されたアイテムのデータを取得
            fetch(`{{ route('estimates.itemUsageRates') }}?item_id=${itemId}`)
                .then(response => response.json())
                .then(data => {
                    // Diff 使用率チャート
                    const diffCtx = document.getElementById('diffUsageChart').getContext('2d');
                    if (diffUsageChart) {
                        diffUsageChart.destroy(); // 既存のチャートを破棄
                    }
                    diffUsageChart = new Chart(diffCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Mid', 'High'],
                            datasets: [{
                                label: 'Diff 使用率',
                                data: [data.diff_low, data.diff_mid, data.diff_high],
                                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });

                    // Acc 使用率チャート
                    const accCtx = document.getElementById('accUsageChart').getContext('2d');
                    if (accUsageChart) {
                        accUsageChart.destroy(); // 既存のチャートを破棄
                    }
                    accUsageChart = new Chart(accCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Mid', 'High'],
                            datasets: [{
                                label: 'Acc 使用率',
                                data: [data.acc_low, data.acc_mid, data.acc_high],
                                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });

                    // Cost 使用率チャート
                    const costCtx = document.getElementById('costUsageChart').getContext('2d');
                    if (costUsageChart) {
                        costUsageChart.destroy(); // 既存のチャートを破棄
                    }
                    costUsageChart = new Chart(costCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Mid', 'High'],
                            datasets: [{
                                label: 'Cost 使用率',
                                data: [data.cost_low, data.cost_mid, data.cost_high],
                                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });

                    // Risk 使用率チャート
                    const riskCtx = document.getElementById('riskUsageChart').getContext('2d');
                    if (riskUsageChart) {
                        riskUsageChart.destroy(); // 既存のチャートを破棄
                    }
                    riskUsageChart = new Chart(riskCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Low', 'Mid', 'High'],
                            datasets: [{
                                label: 'Risk 使用率',
                                data: [data.risk_low, data.risk_mid, data.risk_high],
                                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                });
        });
    });
</script>
@endsection

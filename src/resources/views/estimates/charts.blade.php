@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="text-primary fw-bold mb-4">営業データ</h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body"><canvas id="monthlyOrdersChart"></canvas></div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="userOrderRatesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <canvas id="customerOrderDataChart"></canvas>
        </div>
    </div>
</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 月ごとの受注数データ
        const monthlyOrdersData = @js($monthlyOrders);
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
        const statusDistributionData = @js($statusDistribution);
        const statusDistributionLabels = ['発行済', '受注済', '保留中'];
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
        const userOrderRatesData = @js($userOrderRates);
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
        const customerOrderData = @js($customerOrderData);
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
</script>
@endsection

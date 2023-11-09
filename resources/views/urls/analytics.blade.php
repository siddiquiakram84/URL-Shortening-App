<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
</head>
<body>
    <h1>Analytics for {{ $url->original_url }}</h1>

    <p>Total Accesses: {{ $analytics->count() }}</p>

    <!-- Create a canvas element for the chart -->
    <canvas id="analyticsChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accessDates = {!! json_encode($analytics->pluck('access_date')) !!};
            const accessCounts = {!! json_encode($analytics->pluck('access_count')) !!};

            const ctx = document.getElementById('analyticsChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: accessDates,
                    datasets: [{
                        label: 'Access Count',
                        data: accessCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>

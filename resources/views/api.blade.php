<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Historis COVID-19</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            padding: 2em;
            color: #333;
            background-color: #f8f9fa;
        }

        h1 {
            color: #343a40;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #ffffff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5em;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
        }

        .pagination {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 0;
            margin-top: 2em;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a,
        .pagination li span {
            padding: 8px 15px;
            border: 1px solid #ddd;
            color: #0d6efd;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination li.active span {
            background-color: #0d6efd;
            color: #ffffff;
            border-color: #0d6efd;
        }

        .pagination li.disabled span {
            color: #6c757d;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="container">
        <h1>Data Historis COVID-19</h1>
        <p>Menampilkan data deret waktu untuk
            {{ $timeSeriesData->pluck('country')->unique()->implode(', ') }}
        </p>

        <!-- Grafik di atas -->
        <h2>Grafik Perkembangan COVID-19</h2>
        <canvas id="casesChart" width="400" height="200"></canvas>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Negara</th>
                        <th>Total Kasus</th>
                        <th>Total Kematian</th>
                        <th>Total Sembuh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timeSeriesData as $data)
                        <tr>
                            <td>{{ $data['date'] }}</td>
                            <td>{{ $data['country'] }}</td>
                            <td>{{ number_format($data['cases']) }}</td>
                            <td>{{ number_format($data['deaths']) }}</td>
                            <td>{{ number_format($data['recovered']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada data untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-links">
                {{ $timeSeriesData->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Siapkan array dari PHP
        const dates = @json($timeSeriesData->pluck('date')->unique()->values()); // label berdasarkan tanggal unik
        const cases = []; // total cases per hari
        const deaths = []; // total deaths per hari
        const recovered = []; // total recovered per hari

        dates.forEach(date => {
            let totalCases = 0;
            let totalDeaths = 0;
            let totalRecovered = 0;

            @foreach ($timeSeriesData as $item)
                if ('{{ $item['date'] }}' === date) {
                    totalCases += {{ $item['cases'] }};
                    totalDeaths += {{ $item['deaths'] }};
                    totalRecovered += {{ $item['recovered'] }};
                }
            @endforeach

            cases.push(totalCases);
            deaths.push(totalDeaths);
            recovered.push(totalRecovered);
        });

        // Setelah dapat dates, cases, deaths, dan recovered, bikin grafik:
        new Chart(document.getElementById('casesChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                        label: 'Kasus',
                        data: cases,
                        fill: true,
                        borderColor: 'rgba(13, 110, 253, 1)', // biru
                        backgroundColor: 'rgba(13, 110, 253, 0.2)', // biru transparan
                        tension: 0.4
                    },
                    {
                        label: 'Kematian',
                        data: deaths,
                        fill: true,
                        borderColor: 'rgba(220, 53, 69, 1)', // merah
                        backgroundColor: 'rgba(220, 53, 69, 0.2)', // merah transparan
                        tension: 0.4
                    },
                    {
                        label: 'Sembuh',
                        data: recovered,
                        fill: true,
                        borderColor: 'rgba(40, 167, 69, 1)', // hijau
                        backgroundColor: 'rgba(40, 167, 69, 0.2)', // hijau transparan
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Grafik Perkembangan COVID-19 (Kasus, Kematian, Sembuh)'
                    }
                }
            }
        });
    </script>
</body>

</html>

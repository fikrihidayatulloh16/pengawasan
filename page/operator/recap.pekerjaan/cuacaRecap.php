<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<?php

$query = "SELECT c.id_cuaca, c.jam_mulai, c.jam_selesai, c.kondisi 
          FROM cuaca AS c 
          JOIN laporan_harian AS lh ON c.id_laporan_harian = lh.id_laporan_harian
          WHERE c.id_laporan_harian = '$id_laporan_harian'
          ORDER BY id_cuaca ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['jam_mulai'] = date('H:i', strtotime($row['jam_mulai']));
    $row['jam_selesai'] = date('H', strtotime($row['jam_selesai']));
    $data[] = $row;
}

$timeIntervals = [
    '11:00          ', '00:00        01:00', ' ', '02:00
    
    
    03:00',
    '
    
04:00',' ', '      05:00', '07:00        06:00',
    ' ', ' 
    
    08:00', '      10:00
    
    
    09:00 ', ''
];

$timeIntervals2 = [
    '11:00', '00:00', '01:00', '02:00',
    '04:00','06:00 ', '05:00', '06:00', 
    '07:00', '08:00 ', '10:00', '09:00'
];

$index = 0; // Inisialisasi indeks untuk array timeIntervals

// Bagi data menjadi 6 kelompok, setiap kelompok berisi 4 baris data
$chunks = array_chunk($data, 12);

// Menyimpan setiap chunk dalam array
$chunksArray = [];
foreach ($chunks as $index => $chunk) {
    $chunksArray["chunk_" . ($index + 1)] = $chunk;
}
// Sekarang Anda bisa menggunakan array $chunksArray['chunk_1'], $chunksArray['chunk_2'], dst.

// Mengolah chunk untuk dataPoints
$dataPoints1 = [];
foreach ($chunksArray['chunk_1'] as $row) {
    if ($row['kondisi'] === 'cerah') {
        $color = '#FF9705';
    } elseif ($row['kondisi'] === 'gerimis') {
        $color = '#B1B1B1';
    } else { // Asumsikan kondisi ketiga adalah 'mendung'
        $color = '#7C7C7C';
    }
    $dataPoints1[] = [
        'y' => 100 / count($chunksArray['chunk_1']), // Mengasumsikan distribusi merata
        'name' => $timeIntervals[$index], // Mengambil interval waktu dari array
        'color' => $color,
        'exploded'=> true
    ];

    $index++; // Increment indeks
    if ($index >= count($timeIntervals)) { // Reset indeks jika melebihi jumlah interval
        $index = 0;
    }
}

$dataPoints2 = [];
foreach ($chunksArray['chunk_2'] as $row) {
    if ($row['kondisi'] === 'cerah') {
        $color = '#FF9705';
    } elseif ($row['kondisi'] === 'gerimis') {
        $color = '#B1B1B1';
    } else { // Asumsikan kondisi ketiga adalah 'mendung'
        $color = '#7C7C7C';
    }
    $dataPoints2[] = [
        'y' => 100 / count($chunksArray['chunk_2']), // Mengasumsikan distribusi merata
        'name' => $timeIntervals[$index], // Mengambil interval waktu dari array
        'color' => $color,
        'exploded'=> true
    ];

    $index++; // Increment indeks
    if ($index >= count($timeIntervals)) { // Reset indeks jika melebihi jumlah interval
        $index = 0;
    }
}

/* 
$dataPoints2 = [];
foreach ($chunksArray['chunk_2'] as $row) {
    $color = $row['kondisi'] === 'cerah' ? 'lightblue' : 'lightgrey';
    $dataPoints2[] = [
        'y' => 100 / count($chunksArray['chunk_2']), // Mengasumsikan distribusi merata
        'name' => $row['jam_mulai'] . ' - ' . $row['jam_selesai'],
        'color' => $color,
        'exploded'=> true
    ];
*/

// Encode data ke JSON untuk digunakan di JavaScript
    $dataPointsJson1 = json_encode($dataPoints1);
    $dataPointsJson2 = json_encode($dataPoints2);
?>

<div class="card mt-3">
    <h5 class="card-header">
        Data Cuaca Harian
        <a href="cuaca.php" class="btn btn-edit ms-2 mt-0"><i class='bx bxs-edit-alt'></i>EDIT</a>
    </h5>
    <div class="row">
        <div class="col-lg-6">
            <div class="title text-center chart-container">
                <strong>00:00 AM - 12:00 PM</strong>
                <canvas id="chart1" width="400" height="400"></canvas>
            </div>
            <!--
            <div class="card mt-5 mx-5">
                <h5 class="card-header">Data Cuaca</h5>
                <div class="tabel-cuaca-container">
                    <table class="table table-striped tabel-cuaca">
                        <thead>
                            <tr class="text-center">
                                <th class="weather-column">Jam</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <th class="text-center align-middle" style="border-right: black solid;"><?= $row['jam_mulai'] ?></th>
                                <?php }; ?>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr class="text-center align-middle">
                                <th class="weather-column">Cuaca</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                                        <?= $row['kondisi'] ?>
                                    </td>
                                <?php }; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                                -->
        </div>
        
        

        <div class="col-lg-6">
        <div class="title text-center chart-container">
                <strong class="">12:00 PM - 00:00 AM</strong>
                <canvas id="chart2" width="400" height="400"></canvas>
            </div>
<!--
            <div class="card mt-5 mx-5">
                <h5 class="card-header">Data Cuaca</h5>
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-striped tabel-cuaca">
                        <thead>
                            <tr class="text-center">
                                <th class="weather-column">Jam</th>
                                <?php foreach ($chunksArray['chunk_1'] as $row) { ?>
                                    <th class="text-center align-middle" style="border-right: black solid;"><?= $row['jam_mulai'] ?></th>
                                <?php }; ?>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr class="text-center align-middle ">
                                <th class="weather-column">Cuaca</th>
                                <?php foreach ($chunksArray['chunk_2'] as $row) { ?>
                                    <td class="text-center align-middle <?= $row['kondisi'] ?>" style="border-right: black solid;">
                                        <?= $row['kondisi'] ?>
                                    </td>
                                <?php }; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                                -->
        </div>
    </div>

     <!-- Custom Legend -->
     <div class="legend-container">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #FF9705;"></div>
                <div class="legend-label">Cerah</div>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #7C7C7C;"></div>
                <div class="legend-label">Hujan</div>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #B1B1B1;"></div>
                <div class="legend-label">Gerimis</div>
            </div>
        </div>
    
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Fungsi untuk mengonfigurasi dan membuat chart
            function createChart(chartId, dataPoints) {
                const canvas = document.getElementById(chartId);
                if (!canvas) {
                    console.error(`Canvas with ID ${chartId} not found.`);
                    return;
                }

                const labels = dataPoints.map(point => point.name);
                const data = dataPoints.map(point => point.y);
                const backgroundColors = dataPoints.map(point => point.color);

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Data Cuaca Harian',
                        data: data,
                        backgroundColor: backgroundColors,
                        hoverOffset: 4,
                    }]
                };

                const config = {
                    type: 'pie',
                    data: chartData,
                    options: {
                        layout: {
                            padding: {
                                top:50,
                                bottom: 50,
                                left: 60,
                                right: 60,
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                                position: 'top',
                            },
                            tooltip: {
                                enabled: false, // Menonaktifkan tooltip
                            },
                            datalabels: {
                                color: '#000',
                                anchor: 'end',
                                align: 'end',
                                formatter: (value, context) => {
                                    return context.chart.data.labels[context.dataIndex];
                                },
                                font: {
                                    size: 14 // Ukuran font label datalabels
                                },
                                padding: 5, // Menambahkan jarak antara label dan chart
                            },
                        }
                    },
                    plugins: [ChartDataLabels],
                };

                new Chart(canvas.getContext('2d'), config);
            }

            // Ambil data dari PHP
            const dataPoints1 = <?php echo $dataPointsJson1; ?>;
            const dataPoints2 = <?php echo $dataPointsJson2; ?>;

            // Buat chart
            createChart('chart1', dataPoints1);
            createChart('chart2', dataPoints2);
        });
    </script>

</div>

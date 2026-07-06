<?php
require 'cek-sesi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Admin</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/cssku.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <?php
    require 'koneksi.php';
    require('sidebar.php');
    ?>
    <!-- Main Content -->
    <div id="content">
        <?php require('navbar.php'); ?>
        <div class="container-fluid">

            <!-- Income Card -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendapatan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $tanggal = date('Y-m-d');
                    $bulan = date('m');
                    $tahun = date('Y');

                    function createIncomeBox($title, $amount, $icon = 'fa-calendar')
                    {
                        echo "
                            <div class='col-xl-3 col-md-6 mb-4'>
                                <div class='card border-left-success shadow h-100 py-2'>
                                    <div class='card-body'>
                                        <div class='row no-gutters align-items-center'>
                                            <div class='col mr-2'>
                                                <div class='text-xs font-weight-bold text-success text-uppercase mb-1'>$title</div>
                                                <div class='h5 mb-0 font-weight-bold text-gray-800'>Rp. " . (is_null($amount) ? "0" : number_format($amount)) .  "</div>
                                            </div>
                                            <div class='col-auto'>
                                                <i class='fas $icon fa-2x text-gray-300'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }

                    // Pemasukan Hari Ini
                    $pemasukan = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan WHERE tgl_pemasukan='$tanggal'");
                    $p = mysqli_fetch_assoc($pemasukan);
                    createIncomeBox("Pemasukan Hari Ini", $p['total_pemasukan'], "fa-calendar-day");

                    // Pemasukan Bulan Ini
                    $pemasukan = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan WHERE MONTH(tgl_pemasukan)='$bulan'");
                    $p = mysqli_fetch_assoc($pemasukan);
                    createIncomeBox("Pemasukan Bulan Ini", $p['total_pemasukan'], "fa-calendar-alt");

                    // Pemasukan Tahun Ini
                    $pemasukan = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan WHERE YEAR(tgl_pemasukan)='$tahun'");
                    $p = mysqli_fetch_assoc($pemasukan);
                    createIncomeBox("Pemasukan Tahun Ini", $p['total_pemasukan'], "fa-calendar-check");

                    // Seluruh Pemasukan
                    $pemasukan = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan");
                    $p = mysqli_fetch_assoc($pemasukan);
                    createIncomeBox("Seluruh Pemasukan", $p['total_pemasukan'], "fa-money-bill-wave");
                    ?>
                </div>
            </div>


            <!-- Expense Card -->

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengeluaran</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    function createExpenseBox($title, $amount, $icon = 'fa-calendar')
                    {
                        echo "
                            <div class='col-xl-3 col-md-6 mb-4'>
                                <div class='card border-left-danger shadow h-100 py-2'>
                                    <div class='card-body'>
                                        <div class='row no-gutters align-items-center'>
                                            <div class='col mr-2'>
                                                <div class='text-xs font-weight-bold text-danger text-uppercase mb-1'>$title</div>
                                                <div class='h5 mb-0 font-weight-bold text-gray-800'>Rp. " . (is_null($amount) ? "0" : number_format($amount)) . "</div>
                                            </div>
                                            <div class='col-auto'>
                                                <i class='fas $icon fa-2x text-gray-300'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }

                    // Pengeluaran Hari Ini
                    $pengeluaran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE tgl_pengeluaran='$tanggal'");
                    $p = mysqli_fetch_assoc($pengeluaran);
                    createExpenseBox("Pengeluaran Hari Ini", $p['total_pengeluaran'], "fa-calendar-day");

                    // Pengeluaran Bulan Ini
                    $pengeluaran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE MONTH(tgl_pengeluaran)='$bulan'");
                    $p = mysqli_fetch_assoc($pengeluaran);
                    createExpenseBox("Pengeluaran Bulan Ini", $p['total_pengeluaran'], "fa-calendar-alt");

                    // Pengeluaran Tahun Ini
                    $pengeluaran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE YEAR(tgl_pengeluaran)='$tahun'");
                    $p = mysqli_fetch_assoc($pengeluaran);
                    createExpenseBox("Pengeluaran Tahun Ini", $p['total_pengeluaran'], "fa-calendar-check");

                    // Seluruh Pengeluaran
                    $pengeluaran = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran");
                    $p = mysqli_fetch_assoc($pengeluaran);
                    createExpenseBox("Seluruh Pengeluaran", $p['total_pengeluaran'], "fa-money-bill-wave");
                    ?>
                </div>
            </div>


            <!-- Charts Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan dan Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="chart-area">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="chart-area">
                                <canvas id="yearlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->

        <?php require 'footer.php' ?>

    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php require 'logout-modal.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <script>
        // Fetch data for charts (same as before)
        <?php
        $currentYear = date('Y');
        $bulan = mysqli_query($koneksi, "SELECT MONTH(tgl_pemasukan) as bulan, SUM(jumlah) as total_pemasukan_bulan FROM pemasukan  WHERE YEAR(tgl_pemasukan) = $currentYear GROUP BY MONTH(tgl_pemasukan)");
        $tahun = mysqli_query($koneksi, "SELECT YEAR(tgl_pemasukan) as tahun, SUM(jumlah) as total_pemasukan_tahun FROM pemasukan GROUP BY YEAR(tgl_pemasukan)");
        $pengeluaran_bulan = mysqli_query($koneksi, "SELECT MONTH(tgl_pengeluaran) as bulan, SUM(jumlah) as total_pengeluaran_bulan FROM pengeluaran WHERE YEAR(tgl_pengeluaran) = $currentYear GROUP BY MONTH(tgl_pengeluaran)");
        $pengeluaran_tahun = mysqli_query($koneksi, "SELECT YEAR(tgl_pengeluaran) as tahun, SUM(jumlah) as total_pengeluaran_tahun FROM pengeluaran GROUP BY YEAR(tgl_pengeluaran)");

        $data_pemasukan_bulan = $data_pengeluaran_bulan = $data_pemasukan_tahun = $data_pengeluaran_tahun = [];
        $labelsBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $labelsTahun = [];

        while ($row = mysqli_fetch_assoc($bulan)) {
            $data_pemasukan_bulan[$row['bulan']] = $row['total_pemasukan_bulan'];
        }
        while ($row = mysqli_fetch_assoc($pengeluaran_bulan)) {
            $data_pengeluaran_bulan[$row['bulan']] = $row['total_pengeluaran_bulan'];
        }

        while ($row = mysqli_fetch_assoc($tahun)) {
            $labelsTahun[] = $row['tahun'];
            $data_pemasukan_tahun[] = $row['total_pemasukan_tahun'];
        }
        while ($row = mysqli_fetch_assoc($pengeluaran_tahun)) {
            $data_pengeluaran_tahun[] = $row['total_pengeluaran_tahun'];
        }

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($data_pemasukan_bulan[$i])) $data_pemasukan_bulan[$i] = 0;
            if (!isset($data_pengeluaran_bulan[$i])) $data_pengeluaran_bulan[$i] = 0;
        }
        ksort($data_pemasukan_bulan);
        ksort($data_pengeluaran_bulan);
        ?>

        // Monthly Chart
        var ctx = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labelsBulan); ?>,
                datasets: [{
                        label: 'Pemasukan',
                        data: <?= json_encode(array_values($data_pemasukan_bulan)); ?>,
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Pengeluaran',
                        data: <?= json_encode(array_values($data_pengeluaran_bulan)); ?>,
                        backgroundColor: 'rgba(231, 74, 59, 0.05)',
                        borderColor: 'rgba(231, 74, 59, 1)',
                        pointRadius: 3,
                        pointBackgroundColor: 'rgba(231, 74, 59, 1)',
                        pointBorderColor: 'rgba(231, 74, 59, 1)',
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: 'rgba(231, 74, 59, 1)',
                        pointHoverBorderColor: 'rgba(231, 74, 59, 1)',
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return 'Rp.' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });

        // Yearly Chart
        var ctx2 = document.getElementById('yearlyChart').getContext('2d');
        var yearlyChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labelsTahun); ?>,
                datasets: [{
                        label: 'Pemasukan',
                        data: <?= json_encode($data_pemasukan_tahun); ?>,
                        backgroundColor: 'rgba(78, 115, 223, 0.8)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: <?= json_encode($data_pengeluaran_tahun); ?>,
                        backgroundColor: 'rgba(231, 74, 59, 0.8)',
                        borderColor: 'rgba(231, 74, 59, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        },
                        maxBarThickness: 25,
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return 'Rp.' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        });

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>

</body>

</html>
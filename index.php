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


</head>

<body id="page-top">

  <?php
  require('koneksi.php');
  require('sidebar.php');

  $karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan");
  $karyawan = mysqli_num_rows($karyawan);
  $admin = mysqli_query($koneksi, "SELECT * FROM admin");
  $admin = mysqli_num_rows($admin);

  $pengeluaran_hari_ini = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran where tgl_pengeluaran = CURDATE()");
  $pengeluaran_hari_ini = mysqli_fetch_array($pengeluaran_hari_ini);

  $pengeluaran_hari_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE tgl_pengeluaran = CURDATE()");
  $pengeluaran_hari_ini = mysqli_fetch_assoc($pengeluaran_hari_ini);


  $pemasukan_hari_ini = mysqli_query($koneksi, "SELECT jumlah FROM pemasukan where tgl_pemasukan = CURDATE()");
  $pemasukan_hari_ini = mysqli_fetch_array($pemasukan_hari_ini);

  $pemasukan_hari_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan WHERE tgl_pemasukan = CURDATE()");
  $pemasukan_hari_ini = mysqli_fetch_assoc($pemasukan_hari_ini);

  // Menampilkan HB
  $pemasukanHB_hari_ini = mysqli_query($koneksi, "SELECT HB FROM pemasukan where tgl_pemasukan = CURDATE()");
  $pemasukanHB_hari_ini = mysqli_fetch_array($pemasukanHB_hari_ini);

  $pemasukanHB_hari_ini = mysqli_query($koneksi, "SELECT SUM(HB) AS total_pemasukanHB FROM pemasukan WHERE tgl_pemasukan = CURDATE()");
  $pemasukanHB_hari_ini = mysqli_fetch_assoc($pemasukanHB_hari_ini);

  // Query untuk menghitung total pemasukanHB selama 7 hari terakhir
  $mingguanHB = mysqli_query($koneksi, "
SELECT SUM(HB) AS total_mingguanHB FROM pemasukan 
WHERE tgl_pemasukan >= CURDATE() - INTERVAL 6 DAY
");
  $totalMingguanHB = mysqli_fetch_assoc($mingguanHB);
  $jumlahMingguanHB = !empty($totalMingguanHB['total_mingguanHB']) ? $totalMingguanHB['total_mingguanHB'] : 0;




  // Query untuk menghitung total pemasukan selama 7 hari terakhir
  $mingguan = mysqli_query($koneksi, "
SELECT SUM(jumlah) AS total_mingguan FROM pemasukan 
WHERE tgl_pemasukan >= CURDATE() - INTERVAL 6 DAY
");

  $totalMingguan = mysqli_fetch_assoc($mingguan);
  $jumlahMingguan = !empty($totalMingguan['total_mingguan']) ? $totalMingguan['total_mingguan'] : 0;

  // Query untuk menghitung total pengeluaran selama 7 hari terakhir
  $pengeluaranMingguan = mysqli_query($koneksi, "
 SELECT SUM(jumlah) AS total_pengeluaran_mingguan FROM pengeluaran 
 WHERE tgl_pengeluaran >= CURDATE() - INTERVAL 6 DAY
");

  $totalPengeluaranMingguan = mysqli_fetch_assoc($pengeluaranMingguan);
  $jumlahPengeluaranMingguan = !empty($totalPengeluaranMingguan['total_pengeluaran_mingguan']) ? $totalPengeluaranMingguan['total_pengeluaran_mingguan'] : 0;

  // Hitung sisa uang berdasarkan total mingguan
  $uang = $jumlahMingguan - $jumlahPengeluaranMingguan;
  ?>
  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <h1 class="mr-3">Selamat Datang, <?= $_SESSION['nama'] ?></h1>

      <!-- User Information -->
      <ul class="navbar-nav ml-auto">

        <!-- Icons (Pesan & Notifikasi) -->
        <?php require 'pesan.php'; ?>

        <?php require 'user.php'; ?>
      </ul>

    </nav>
    <!-- End of Topbar -->


    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="export-semua.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
      </div>

      <!-- Content Row -->
      <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pemasukan (Hari Ini)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"> Rp.<?= isset($pemasukanHB_hari_ini['total_pemasukanHB']) ? number_format($pemasukanHB_hari_ini['total_pemasukanHB'], 2, ',', '.') : '0,00'; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div> &nbsp Mingguan : Rp.
            <?php
            echo number_format($jumlahMingguanHB, 2, ',', '.');
            ?>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan (Hari Ini)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"> Rp.<?= isset($pemasukan_hari_ini['total_pemasukan']) ? number_format($pemasukan_hari_ini['total_pemasukan'], 2, ',', '.') : '0,00'; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div> &nbsp Mingguan : Rp.
            <?php
            echo number_format($jumlahMingguan, 2, ',', '.');
            ?>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pengeluaran (Hari Ini)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.<?= isset($pengeluaran_hari_ini['total_pengeluaran']) ? number_format($pengeluaran_hari_ini['total_pengeluaran'], 2, ',', '.') : '0,00'; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
              </div>
            </div> &nbsp Mingguan : Rp.
            <?php
            echo number_format($jumlahPengeluaranMingguan, 2, ',', '.');
            ?>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">LABA (MINGGUAN)</div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> <?php if ($uang > 0) {
                                                                                  echo 'Rp.' . number_format($uang, 2, ',', '.');
                                                                                } else {
                                                                                  echo 'Rp.0';
                                                                                } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>

            </div>
            <div class="col">
              <div class="progress progress-sm mr-2">
                <?php
                if ($jumlahMingguan >= 0) {
                  $persentase_laba = $uang / 10000;  // Hitung persentase laba
                } else {
                  $persentase_laba = 0;  // Jika pemasukan 0, laba dianggap 0
                }

                if ($persentase_laba < 1) {
                  $warna = 'danger';
                } else if ($persentase_laba >= 1 && $persentase_laba < 50) {
                  $warna = 'warning';
                } else {
                  $warna = 'info';
                }

                ?>

                <div class="progress-bar bg-<?= $warna ?>" role="progressbar" style="width: 100%" aria-valuenow="<?= $value ?>" aria-valuemin="0" aria-valuemax="100"><span><?= number_format($persentase_laba, 2, ',', '.') ?> %</span></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Loss (Rugi) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">RUGI (MINGGUAN)</div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                        <?php
                        // Menghitung selisih Pendapatan dan Pengeluaran
                        $rugi = $jumlahMingguan - $jumlahPengeluaranMingguan;

                        if ($rugi < 0) {
                          echo 'Rp.' . number_format(abs($rugi), 2, ',', '.');
                        } else {
                          echo 'Rp.0'; // Tidak ada kerugian jika hasil tidak negatif
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="progress progress-sm mr-2">
                <?php
                if ($rugi >= 0) {
                  $warna_rugi = 'danger';
                  $value_rugi = 0;
                } else {
                  $warna_rugi = 'danger';
                  $value_rugi = min(abs($rugi) / 10000, 100); // Hitung persentase, maksimal 100%
                }
                ?>

                <div class="progress-bar bg-<?= $warna_rugi ?>" role="progressbar" style="width: <?= $value_rugi ?>%" aria-valuenow="<?= $value_rugi ?>" aria-valuemin="0" aria-valuemax="100">
                  <span><?= number_format($value_rugi, 2) ?> %</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Admin</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $admin ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Karyawan</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $karyawan ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-lg-8 mb-7">
          <!-- Project Card Example -->
          <div class="card shadow mb-5">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
              <h6 class="m-0 font-weight-bold text-primary">Data Penjualan (HARI INI)</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>

            <div class="card-body">
              <canvas id="revenueChart"></canvas>
              <?php
              // Mengambil data sumber pendapatan dan total stok hari ini
              $today = date('Y-m-d'); // Mendapatkan tanggal hari ini
              $sources = [];
              $results = [];

              // Mengambil semua data dari tabel 'sumber'
              $source_query = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber !=1");
              while ($source = mysqli_fetch_assoc($source_query)) {
                $id_sumber = $source['id_sumber'];

                // Mengambil total stok terjual untuk hari ini
                $hasil_query = mysqli_query($koneksi, "SELECT SUM(jml_satuan) as total_stok FROM pemasukan WHERE id_sumber = $id_sumber AND tgl_pemasukan = '$today'");
                $result = mysqli_fetch_assoc($hasil_query);

                // Memasukkan data sumber dan stok ke dalam array
                $sources[] = $source['nama'];
                $results[] = $result['total_stok'] ?? 0; // Jika null, set ke 0
              }

              // Menyiapkan data untuk Chart.js
              $labels = json_encode($sources); // Nama sumber sebagai label chart
              $amounts = json_encode($results); // Jumlah stok sebagai data chart
              ?>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('revenueChart').getContext('2d');
                var chart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: <?php echo $labels; ?>,
                    datasets: [{
                      label: 'Stok Terjual',
                      data: <?php echo $amounts; ?>,
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(199, 199, 199, 0.8)'
                      ],
                      borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)'
                      ],
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    scales: {
                      y: {
                        beginAtZero: true,
                        ticks: {
                          callback: function(value, index, values) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                          }
                        }
                      }
                    },
                    plugins: {
                      tooltip: {
                        callbacks: {
                          label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                              label += ': ';
                            }
                            if (context.parsed.y !== null) {
                              label += 'Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                            return label;
                          }
                        }
                      },
                      legend: {
                        display: false
                      }
                    }
                  }
                });
              });
            </script>
          </div>
        </div>



        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Perbandingan (Mingguan)</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i> Pendapatan
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-warning"></i> Pengeluaran
                </span><br>
                <span class="mr-2">
                  <i class="fas fa-circle text-primary"></i> Laba
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-danger"></i> Rugi
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
    <!-- /.container-fluid -->

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

  <!-- Page level custom scripts -->
  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

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

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["7 hari lalu", "6 hari lalu", "5 hari lalu", "4 hari lalu", "3 hari lalu", "2 hari lalu", "1 hari lalu"],
        datasets: [{
          label: "Pendapatan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [<?php echo $tujuhhari['0'] ?>, <?php echo $enamhari['0'] ?>, <?php echo $limahari['0'] ?>, <?php echo $empathari['0'] ?>, <?php echo $tigahari['0'] ?>, <?php echo $duahari['0'] ?>, <?php echo $satuhari['0'] ?>],
        }],
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
            time: {
              unit: 'date'
            },
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
              // Include a dollar sign in the ticks
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
  </script>

  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    // Hitung total rugi
    var uang = <?php echo ($jumlahPengeluaranMingguan < $jumlahMingguan) ? ($jumlahMingguan - $jumlahPengeluaranMingguan) / 1000000 : 0; ?>;
    var rugi = <?php echo ($jumlahPengeluaranMingguan > $jumlahMingguan) ? ($jumlahPengeluaranMingguan - $jumlahMingguan) / 1000000 : 0; ?>;

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Pendapatan", "Pengeluaran", "Laba", "Rugi"],
        datasets: [{
          data: [<?php echo $jumlahMingguan / 1000000   ?>, <?php echo $jumlahPengeluaranMingguan / 1000000   ?>, uang, rugi],
          backgroundColor: ['#28a745', '#f6c23e', '#4e73df', '#e74a3b'], // Ganti dengan warna untuk rugi
          hoverBackgroundColor: ['#77dd77', '#ffe680', '#2e59d9', '#ff9999'], // Ganti dengan warna hover untuk rugi
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
  </script>

</body>

</html>
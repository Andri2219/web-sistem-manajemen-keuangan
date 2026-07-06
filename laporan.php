<?php
require 'cek-sesi.php';
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laporan Keuangan</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/cssku.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php require 'sidebar.php'; ?>

  <!-- Main Content -->
  <div id="content">
    <?php require 'navbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">


      <!-- Form Filter Tahun dan Bulan -->
      <form method="GET" action="#" id="filterForm" style="display: flex; flex-grow: 1; gap: 10px; margin-bottom: 20px;">
        <div class="form-group m-0">
          <label for="filterYear" class="m-0">Filter Tahun:</label>
          <select name="year" id="filterYear" class="form-control" style="width: auto;" onchange="this.form.submit();" required>
            <option value="">--Pilih Tahun--</option>
            <?php
            $yearsQuery = mysqli_query($koneksi, "SELECT DISTINCT YEAR(tgl_pemasukan) AS year FROM pemasukan ORDER BY year DESC");
            while ($rowYear = mysqli_fetch_assoc($yearsQuery)) {
              $selectedYear = (isset($_GET['year']) && $_GET['year'] == $rowYear['year']) ? 'selected' : '';
              echo "<option value='{$rowYear['year']}' {$selectedYear}>{$rowYear['year']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group m-0">
          <label for="filterMonth" class="m-0">Filter Bulan:</label>
          <select name="month" id="filterMonth" class="form-control" style="width: auto;" onchange="this.form.submit();">
            <option value="">--Pilih Bulan (Opsional)--</option>
            <?php
            if (isset($_GET['year']) && !empty($_GET['year'])) {
              $selectedYear = $_GET['year'];
              $monthsQuery = mysqli_query($koneksi, "SELECT DISTINCT MONTH(tgl_pemasukan) AS month FROM pemasukan WHERE YEAR(tgl_pemasukan) = '$selectedYear' ORDER BY month ASC");
              $months = [
                '1' => 'Januari',
                '2' => 'Februari',
                '3' => 'Maret',
                '4' => 'April',
                '5' => 'Mei',
                '6' => 'Juni',
                '7' => 'Juli',
                '8' => 'Agustus',
                '9' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
              ];
              while ($rowMonth = mysqli_fetch_assoc($monthsQuery)) {
                $monthNum = $rowMonth['month'];
                $selectedMonth = (isset($_GET['month']) && $_GET['month'] == $monthNum) ? 'selected' : '';
                echo "<option value='{$monthNum}' {$selectedMonth}>{$months[$monthNum]}</option>";
              }
            } else {
              echo '<option value="">Pilih Tahun Terlebih Dahulu</option>';
            }
            ?>
          </select>
        </div>
      </form>

      <!-- Data Tables -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Jumlah Transaksi</th>
                  <th>Jumlah Total Uang</th>
                  <th>Download</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $yearFilter = isset($_GET['year']) ? $_GET['year'] : null;
                $monthFilter = isset($_GET['month']) ? $_GET['month'] : null;

                // Query untuk pemasukan
                $queryPemasukan = "SELECT COUNT(id_pemasukan) AS totalTransaksi, SUM(jumlah) AS totalJumlah FROM pemasukan WHERE 1=1";
                if ($yearFilter) {
                  $queryPemasukan .= " AND YEAR(tgl_pemasukan) = '$yearFilter'";
                }
                if ($monthFilter) {
                  $queryPemasukan .= " AND MONTH(tgl_pemasukan) = '$monthFilter'";
                }
                $resultPemasukan = mysqli_query($koneksi, $queryPemasukan);
                $dataPemasukan = mysqli_fetch_assoc($resultPemasukan);

                // Query untuk pengeluaran
                $queryPengeluaran = "SELECT COUNT(id_pengeluaran) AS totalTransaksi, SUM(jumlah) AS totalJumlah FROM pengeluaran WHERE 1=1";
                if ($yearFilter) {
                  $queryPengeluaran .= " AND YEAR(tgl_pengeluaran) = '$yearFilter'";
                }
                if ($monthFilter) {
                  $queryPengeluaran .= " AND MONTH(tgl_pengeluaran) = '$monthFilter'";
                }
                $resultPengeluaran = mysqli_query($koneksi, $queryPengeluaran);
                $dataPengeluaran = mysqli_fetch_assoc($resultPengeluaran);
                ?>

                <!-- Data Pemasukan -->
                <tr>
                  <td>Pemasukan</td>
                  <td><?= $dataPemasukan['totalTransaksi'] ?? 0 ?></td>
                  <td>Rp. <?= number_format($dataPemasukan['totalJumlah'] ?? 0, 2, ',', '.') ?></td>
                  <td>
                    <!-- Tombol download hanya muncul jika tahun atau bulan dipilih -->
                    <?php if ($yearFilter): ?>
                      <a href="export-pemasukan.php?year=<?= $yearFilter ?>&month=<?= $monthFilter ?>" class="btn btn-primary btn-md"><i class="fa fa-download"></i></a>
                    <?php else: ?>
                      <button class="btn btn-secondary btn-md" disabled><i class="fa fa-download"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>

                <!-- Data Pengeluaran -->
                <tr>
                  <td>Pengeluaran</td>
                  <td><?= $dataPengeluaran['totalTransaksi'] ?? 0 ?></td>
                  <td>Rp. <?= number_format($dataPengeluaran['totalJumlah'] ?? 0, 2, ',', '.') ?></td>
                  <td>
                    <!-- Tombol download hanya muncul jika tahun atau bulan dipilih -->
                    <?php if ($yearFilter): ?>
                      <a href="export-pengeluaran.php?year=<?= $yearFilter ?>&month=<?= $monthFilter ?>" class="btn btn-primary btn-md"><i class="fa fa-download"></i></a>
                    <?php else: ?>
                      <button class="btn btn-secondary btn-md" disabled><i class="fa fa-download"></i></button>
                    <?php endif; ?>
                  </td>
                </tr>

              </tbody>
            </table>
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
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
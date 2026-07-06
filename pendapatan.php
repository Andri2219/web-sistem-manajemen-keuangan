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
  require('sidebar.php'); ?>
  <!-- Main Content -->
  <div id="content">

    <?php require('navbar.php'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Content Row -->
      <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sumber Pendapatan</h6>
          </div>
          <div class="card-body" style="height: 400px; overflow-y: auto; border-radius: 10px; border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <?php
            // Mengambil semua data sumber pendapatan
            $source_query = mysqli_query($koneksi, "SELECT * FROM `sumber` WHERE id_sumber != 1");
            $sources = [];
            while ($row = mysqli_fetch_assoc($source_query)) {
              $sources[] = $row;
            }

            // Mengambil dan menjumlahkan data pemasukan berdasarkan sumber
            $results = [];
            foreach ($sources as $source) {
              $id_sumber = $source['id_sumber'];
              $hasil_query = mysqli_query($koneksi, "SELECT jml_satuan, jumlah FROM pemasukan WHERE id_sumber = $id_sumber");
              $total_amount = 0;
              $total_units = 0;

              while ($row = mysqli_fetch_array($hasil_query)) {
                $total_amount += $row['jumlah']; // Jumlah pemasukan
                $total_units += $row['jml_satuan']; // Total satuan
              }
              $results[$id_sumber] = ['total_amount' => $total_amount, 'total_units' => $total_units];
            }

            // Menyiapkan warna untuk progress bar (otomatis bergantian)
            $colors = ['bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success', 'bg-secondary', 'bg-dark'];

            // Menampilkan data di progress bar
            foreach ($sources as $index => $source) {
              $id_sumber = $source['id_sumber'];
              $total_amount = number_format($results[$id_sumber]['total_amount'], 2, ',', '.');
              $total_units = $results[$id_sumber]['total_units'];
              $progress_width = min($total_units * 1, 100); // Menyesuaikan lebar progress bar dan memastikan tidak lebih dari 100%

              // Mengambil warna berdasarkan indeks, akan diulang jika lebih dari jumlah warna yang tersedia
              $color = $colors[$index % count($colors)];

              // Menggunakan null coalescing untuk menghindari error pada htmlspecialchars
              $nama_inven = htmlspecialchars($source['nama'] ?? '', ENT_QUOTES, 'UTF-8');


              echo '
            <h4 class="small font-weight-bold">' . $nama_inven . '<span class="float-right">Rp. ' . $total_amount . '</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar ' . $color . '" role="progressbar" style="width:' . $progress_width . '%" aria-valuenow="' . $progress_width . '" aria-valuemin="0" aria-valuemax="100">' . $total_units . ' Biji</div>
            </div>
        ';
            }
            ?>
          </div>
        </div>



        <div class="col-lg-6">
          <!-- Collapsable Card Example -->
          <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
              <h6 class="m-0 font-weight-bold text-primary">Catatan 1</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
              <div class="card-body">
                <?php $catatan1 = mysqli_query($koneksi, "SELECT catatan FROM catatan where id_catatan= 1");
                $catatan1 = mysqli_fetch_array($catatan1);
                echo $catatan1['catatan'];
                ?>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
              <h6 class="m-0 font-weight-bold text-primary">Catatan 2</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample1">
              <div class="card-body">
                <?php $catatan2 = mysqli_query($koneksi, "SELECT * FROM catatan where id_catatan= 2");
                $catatan2 = mysqli_fetch_array($catatan2);
                echo $catatan2['catatan'];
                ?></div>
            </div>
          </div>
        </div>



        <!-- DataTales Example -->
        <div class="col-xl-12 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
              <h6 id="titleHeader" class="m-0 font-weight-bold text-primary">Transaksi Masuk</h6>
              <div class="d-flex align-items-center ml-auto" style="gap: 15px;">
                <!-- Tombol Tambah Sumber -->
                <button class="btn btn-success d-flex align-items-center" data-toggle="modal" data-target="#myModalTambah">
                  <i class="fas fa-plus mr-1"></i> Add
                </button>

                <!-- Tombol Filter 7 Hari Ke Depan -->
                <button id="filter7Days" class="btn btn-warning d-flex align-items-center">
                  <i class="fas fa-filter mr-1"></i> 7 Hari
                </button>

                <!-- Tombol Tampilkan Semua -->
                <button id="showAll" class="btn btn-primary d-flex align-items-center">
                  <i class="fas fa-list mr-1"></i> Show All
                </button>

                <!-- Form Filter Tahun dan Bulan -->
                <form method="GET" action="#" id="filterForm" style="display: none; flex-grow: 1;">
                  <div class="d-flex align-items-center" style="gap: 10px; width: 100%;">
                    <!-- Filter Tahun -->
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

                    <!-- Filter Bulan -->
                    <div class="form-group m-0">
                      <label for="filterMonth" class="m-0">Filter Bulan:</label>
                      <select name="month" id="filterMonth" class="form-control" style="width: auto;" onchange="this.form.submit();" required>
                        <option value="">--Pilih Bulan--</option>
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
                  </div>
                </form>

              </div>

              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  // Cek apakah status filter form disimpan di localStorage
                  const filterForm = document.getElementById('filterForm');
                  const titleHeader = document.getElementById('titleHeader');
                  const showAllButton = document.getElementById('showAll');

                  // Ambil status dari localStorage (jika ada)
                  const filterFormVisibility = localStorage.getItem('filterFormVisibility');

                  if (filterFormVisibility === 'visible') {
                    filterForm.style.display = 'flex'; // Jika visibilitasnya 'visible', tampilkan form
                    titleHeader.style.fontSize = '24px'; // Perbesar ukuran font judul
                  } else {
                    filterForm.style.display = 'none'; // Jika tidak, sembunyikan form
                    titleHeader.style.fontSize = '18px'; // Ukuran font normal
                  }

                  // Event listener untuk tombol Show All
                  showAllButton.addEventListener('click', function() {
                    // Toggle visibilitas form
                    if (filterForm.style.display === 'none') {
                      filterForm.style.display = 'flex';
                      titleHeader.style.fontSize = '24px'; // Perbesar ukuran font judul
                      // Simpan status ke localStorage
                      localStorage.setItem('filterFormVisibility', 'visible');
                    } else {
                      filterForm.style.display = 'none';
                      titleHeader.style.fontSize = '18px'; // Ukuran font normal
                      // Simpan status ke localStorage
                      localStorage.setItem('filterFormVisibility', 'hidden');
                    }
                  });
                });
              </script>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Harga</th> <!-- Menambahkan Kolom Harga -->
                      <th>Jumlah Satuan</th> <!-- Menambahkan Kolom Jumlah Satuan -->
                      <th>Total</th>
                      <th>Sumber</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Harga</th> <!-- Menambahkan Kolom Harga -->
                      <th>Jumlah Satuan</th> <!-- Menambahkan Kolom Jumlah Satuan -->
                      <th>Total</th>
                      <th>Sumber</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody id="tableBody">
                    <?php
                    // Get today's date
                    $today = date('Y-m-d');
                    $next7Days = date('Y-m-d', strtotime('+6 days')); // Menggunakan +6 days untuk mencakup 7 hari (hari ini + 6 hari ke depan)

                    // Cek apakah parameter tahun dan bulan (filter) tersedia
                    $filterYear = isset($_GET['year']) ? $_GET['year'] : null;
                    $filterMonth = isset($_GET['month']) ? $_GET['month'] : null;

                    // Query untuk menampilkan data berdasarkan tahun dan bulan
                    if ($filterYear && $filterMonth) {
                      // Jika filter tahun dan bulan diterapkan
                      $query = mysqli_query($koneksi, "
                        SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
                        FROM pemasukan 
                        JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber
                        WHERE YEAR(tgl_pemasukan) = '$filterYear' 
                        AND MONTH(tgl_pemasukan) = '$filterMonth'
                        ORDER BY tgl_pemasukan ASC
                      ");
                    } elseif ($filterYear) {
                      // Jika hanya filter tahun diterapkan
                      $query = mysqli_query($koneksi, "
                        SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
                        FROM pemasukan 
                        JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber
                        WHERE YEAR(tgl_pemasukan) = '$filterYear' 
                        ORDER BY tgl_pemasukan ASC
                      ");
                    } else {
                      // Query untuk menampilkan data pemasukan dalam rentang 7 hari dari hari ini
                      $query = mysqli_query($koneksi, "
SELECT pemasukan.*, 
       sumber.nama AS nama_sumber, 
       sumber.harga AS harga 
FROM pemasukan 
JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber
WHERE tgl_pemasukan BETWEEN '$today' AND '$next7Days'
ORDER BY tgl_pemasukan ASC
");
                    }
                    // Tampilan data
                    if (mysqli_num_rows($query) > 0) {
                      $no = 1;
                      while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                          <td><?= $no++ ?></td> <!-- Display row number -->
                          <td><?= $data['tgl_pemasukan'] ?></td>
                          <td>Rp. <?= number_format($data['harga'], 2, ',', '.'); ?></td>
                          <td><?= $data['jml_satuan'] ?></td>
                          <td>Rp. <?= number_format($data['jumlah'], 2, ',', '.'); ?></td>
                          <td><?= $data['nama_sumber'] ?></td>
                          <td>
                            <!-- Button untuk modal -->
                            <a href=" #" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_pemasukan']; ?>"></a>
                          </td>
                        </tr>

                        <!-- Modal Edit Mahasiswa-->
                        <div class="modal fade" id="myModal<?php echo $data['id_pemasukan']; ?>" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Ubah Data Pendapatan</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <form role="form" action="proses-edit-pemasukan.php" method="get">

                                  <?php
                                  $id = $data['id_pemasukan'];
                                  $query_edit = mysqli_query($koneksi, "SELECT * FROM pemasukan WHERE id_pemasukan='$id'");
                                  $row = mysqli_fetch_array($query_edit);
                                  ?>


                                  <input type="hidden" name="id_pemasukan" value="<?php echo $row['id_pemasukan']; ?>">

                                  <div class="form-group">
                                    <label>Id</label>
                                    <input type="text" name="id_pemasukan" class="form-control" value="<?php echo $row['id_pemasukan']; ?>" disabled>
                                  </div>

                                  <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl_pemasukan" class="form-control" value="<?php echo $row['tgl_pemasukan']; ?>">
                                  </div>

                                  <div class="form-group">
                                    <label>Jumlah Satuan</label>
                                    <input type="number" name="jml_satuan" class="form-control" value="<?php echo $row['jml_satuan']; ?>" required>
                                  </div>


                                  <div class="form-group">
                                    <label>Sumber</label>
                                    <select class="form-control" name="id_sumber" required>
                                      <option value="">--Pilih--</option> <!-- Tambahkan opsi default -->
                                      <?php
                                      // Query untuk mengambil hanya sumber dengan ID tertentu
                                      $queri = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber != 1");

                                      // Periksa apakah data awal sudah ada
                                      $selected_id = isset($row['id_sumber']) ? $row['id_sumber'] : '';

                                      // Tampilkan pilihan dropdown
                                      while ($querynama = mysqli_fetch_array($queri)) {
                                        $selected = ($querynama['id_sumber'] == $selected_id) ? 'selected' : '';
                                        echo '<option value="' . $querynama['id_sumber'] . '" ' . $selected . '>' . $querynama["nama"] . '</option>';
                                      }
                                      ?>
                                    </select>
                                  </div>


                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Ubah</button>
                                    <a href="hapus-pemasukan.php?id_pemasukan=<?= $row['id_pemasukan']; ?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                                  </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
              </div>

            </div>

          </div>
      <?php
                      }
                    }

      ?>
      </tbody>
      </table>

      <script>
        document.getElementById("filter7Days").addEventListener("click", function() {
          // Redirect to pengeluaran.php when the button is clicked
          window.location.href = "pendapatan.php";
        });
      </script>

      <!-- Modal -->
      <div id="myModalTambah" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- konten modal-->
          <div class="modal-content">
            <!-- heading modal -->
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pendapatan</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- body modal -->
            <form action="tambah-pendapatan.php" method="get">
              <div class="modal-body">
                <!-- Input untuk tanggal pemasukan -->
                Tanggal:
                <input type="date" class="form-control" name="tgl_pemasukan" required>

                <!-- Input untuk jumlah satuan -->
                Jumlah Satuan:
                <input type="number" class="form-control" name="jml_satuan" required>

                <!-- Input untuk sumber pemasukan -->
                Sumber:
                <select class="form-control" name='id_sumber'>
                  <option value="">--Pilih--</option> <!-- Tambahkan opsi default -->
                  <?php

                  // Query untuk mengambil hanya sumber dengan ID tertentu
                  $queri = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber != 1");

                  // Inisialisasi variabel no untuk penomoran
                  $no = 1;

                  // Tampilkan pilihan dropdown
                  while ($querynama = mysqli_fetch_array($queri)) {
                    echo '<option value="' . $querynama['id_sumber'] . '">' . $no++ . '.' . $querynama["nama"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <!-- footer modal -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Tambah</button>
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
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
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

  $sekarang = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE()");
  $sekarang = mysqli_fetch_array($sekarang);

  $satuhari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 1 DAY");
  $satuhari = mysqli_fetch_array($satuhari);


  $duahari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 2 DAY");
  $duahari = mysqli_fetch_array($duahari);

  $tigahari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 3 DAY");
  $tigahari = mysqli_fetch_array($tigahari);

  $empathari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 4 DAY");
  $empathari = mysqli_fetch_array($empathari);

  $limahari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 5 DAY");
  $limahari = mysqli_fetch_array($limahari);

  $enamhari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 6 DAY");
  $enamhari = mysqli_fetch_array($enamhari);

  $tujuhhari = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran
WHERE tgl_pengeluaran = CURDATE() - INTERVAL 7 DAY");
  $tujuhhari = mysqli_fetch_array($tujuhhari);
  ?>
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
            <h6 class="m-0 font-weight-bold text-primary">Inven Pengeluaran</h6>
          </div>
          <div class="card-body" style="height: 400px; overflow-y: auto; border-radius: 10px; border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <?php
            // Mengambil semua data inven pengeluaran
            $source_query = mysqli_query($koneksi, "SELECT * FROM `inven` WHERE id_inven");
            if (!$source_query) {
              die("Query Error: " . mysqli_error($koneksi));
            }

            $sources = [];
            while ($row = mysqli_fetch_assoc($source_query)) {
              $sources[] = $row;
            }

            // Mengambil dan menjumlahkan data pengeluaran berdasarkan inven
            $results = [];
            foreach ($sources as $source) {
              $id_inven = $source['id_inven'];
              // Perbaikan query SQL
              $hasil_query = mysqli_query($koneksi, "SELECT jumlah FROM pengeluaran WHERE id_inven = $id_inven AND id_inven");

              if (!$hasil_query) {
                die("Query Error: " . mysqli_error($koneksi));
              }

              $jumlah_amount = 0;
              while ($row = mysqli_fetch_array($hasil_query)) {
                $jumlah_amount += $row['jumlah']; // Menghitung total pengeluaran
              }
              $results[$id_inven] = ['jumlah_amount' => $jumlah_amount];
            }

            // Menyiapkan warna untuk progress bar (otomatis bergantian)
            $colors = ['bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success', 'bg-secondary', 'bg-dark'];

            // Menampilkan data di progress bar
            foreach ($sources as $index => $source) {
              $id_inven = $source['id_inven'];
              $jumlah_amount = $results[$id_inven]['jumlah_amount'] ?? 0; // Menghindari error jika tidak ada jumlah
              $jumlah_amount_formatted = number_format($jumlah_amount, 2, ',', '.'); // Format untuk ditampilkan

              // Sesuaikan pembagi dengan total budget yang relevan
              $persentase = ($jumlah_amount > 0) ? ($jumlah_amount / 1000000) * 10 : 0;

              // Mengambil warna berdasarkan indeks, akan diulang jika lebih dari jumlah warna yang tersedia
              $color = $colors[$index % count($colors)];

              // Menggunakan null coalescing untuk menghindari error pada htmlspecialchars
              $nama_inven = htmlspecialchars($source['nama'] ?? '', ENT_QUOTES, 'UTF-8');

              echo '
            <h4 class="small font-weight-bold">' . $nama_inven . '<span class="float-right">Rp. ' . $jumlah_amount_formatted . '</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar ' . $color . '" role="progressbar" style="width:' . $persentase . '%" aria-valuenow="' . $persentase . '" aria-valuemin="0" aria-valuemax="100">' . round($persentase, 2) . '%</div>
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
                <?php
                $catatan = mysqli_query($koneksi, "SELECT catatan From catatan WHERE id_catatan = 3");
                $catatan = mysqli_fetch_array($catatan);
                echo $catatan['catatan'];
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
                <?php
                $catatan = mysqli_query($koneksi, "SELECT catatan From catatan WHERE id_catatan = 4");
                $catatan = mysqli_fetch_array($catatan);
                echo $catatan['catatan'];
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Area Chart
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="myAreaChart"></canvas>
            </div>
            <hr>
          </div>
        </div>
      </div>-->

      <!-- DataTales Example -->
      <div class="row">
        <div class="col-xl-12 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
              <h6 id="titleHeader" class="m-0 font-weight-bold text-primary">Transaksi Keluar</h6>
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
                        $yearsQuery = mysqli_query($koneksi, "SELECT DISTINCT YEAR(tgl_pengeluaran) AS year FROM pengeluaran ORDER BY year DESC");
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
                          $monthsQuery = mysqli_query($koneksi, "SELECT DISTINCT MONTH(tgl_pengeluaran) AS month FROM pengeluaran WHERE YEAR(tgl_pengeluaran) = '$selectedYear' ORDER BY month ASC");
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
                      <th>Harga</th>
                      <th>Jumlah Satuan</th>
                      <th>Total</th>
                      <th>Inven</th>
                      <th>PJ</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Harga</th>
                      <th>Jumlah Satuan</th>
                      <th>Total</th>
                      <th>Inven</th>
                      <th>PJ</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody id="tableBody">
                    <?php
                    // Get today's date and the date 7 days from now
                    $today = date('Y-m-d');
                    $next7Days = date('Y-m-d', strtotime('+6 days')); // Ditambah 6 hari, sehingga total rentang mencakup 7 hari (hari ini + 6 hari ke depan)

                    // Cek apakah parameter tahun (filter) dan bulan (filter) tersedia
                    $filterYear = isset($_GET['year']) ? $_GET['year'] : null;
                    $filterMonth = isset($_GET['month']) ? $_GET['month'] : null;

                    // Query untuk menampilkan data berdasarkan tahun dan bulan
                    if ($filterYear && $filterMonth) {
                      // Jika filter tahun dan bulan diterapkan
                      $query = mysqli_query($koneksi, "
    SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga_inven, sumber.nama AS nama_sumber, sumber.harga AS harga_sumber, karyawan.nama AS nama_karyawan 
    FROM pengeluaran 
    JOIN inven ON pengeluaran.id_inven = inven.id_inven
    JOIN sumber ON pengeluaran.id_sumber = sumber.id_sumber
    JOIN karyawan ON pengeluaran.id_karyawan = karyawan.id_karyawan
    WHERE YEAR(tgl_pengeluaran) = '$filterYear' 
    AND MONTH(tgl_pengeluaran) = '$filterMonth'
    ORDER BY tgl_pengeluaran ASC
  ");
                    } elseif ($filterYear) {
                      // Jika hanya filter tahun diterapkan
                      $query = mysqli_query($koneksi, "
    SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga_inven, sumber.nama AS nama_sumber, sumber.harga AS harga_sumber, karyawan.nama AS nama_karyawan 
    FROM pengeluaran 
    JOIN inven ON pengeluaran.id_inven = inven.id_inven
    JOIN sumber ON pengeluaran.id_sumber = sumber.id_sumber
    JOIN karyawan ON pengeluaran.id_karyawan = karyawan.id_karyawan
    WHERE YEAR(tgl_pengeluaran) = '$filterYear' 
    ORDER BY tgl_pengeluaran ASC
  ");
                    } else {
                      // Query untuk menampilkan data pengeluaran dalam rentang 7 hari ke depan
                      $query = mysqli_query($koneksi, "
SELECT pengeluaran.*, 
       inven.nama AS nama_inven, 
       inven.harga AS harga_inven, 
       sumber.nama AS nama_sumber, 
       sumber.harga AS harga_sumber, 
       karyawan.nama AS nama_karyawan 
FROM pengeluaran 
JOIN inven ON pengeluaran.id_inven = inven.id_inven
JOIN sumber ON pengeluaran.id_sumber = sumber.id_sumber
JOIN karyawan ON pengeluaran.id_karyawan = karyawan.id_karyawan
WHERE tgl_pengeluaran BETWEEN '$today' AND '$next7Days'
ORDER BY tgl_pengeluaran ASC
");
                    }

                    // Tampilan data
                    if (mysqli_num_rows($query) > 0) {
                      // Your code to display the data

                      $no = 1;
                      while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                          <td><?= $no++ ?></td> <!-- Display row number -->
                          <td><?= $data['tgl_pengeluaran'] ?></td>
                          <td>
                            <?php
                            if (!empty($data['harga_sumber']) && $data['id_sumber'] !== NULL) {
                              echo 'Rp. ' . number_format($data['harga_sumber'], 2, ',', '.');
                            } elseif (!empty($data['harga_inven']) && $data['id_inven'] !== NULL) {
                              echo 'Rp. ' . number_format($data['harga_inven'], 2, ',', '.');
                            } else {
                              echo "Harga tidak tersedia";
                            }
                            ?>
                          </td>
                          <td><?= $data['jml_satuan'] ?></td>
                          <td>Rp. <?= number_format($data['jumlah'], 2, ',', '.'); ?></td>
                          <td>
                            <?php
                            if (!empty($data['nama_sumber']) && $data['id_sumber'] !== NULL) {
                              echo "Return : " . $data['nama_sumber'];
                            } elseif (!empty($data['nama_inven']) && $data['id_inven'] !== NULL) {
                              echo $data['nama_inven'];
                            } else {
                              echo "Nama tidak tersedia";
                            }
                            ?>
                          </td>
                          <td>
                            <?php
                            if (!empty($data['nama_sumber']) && $data['id_sumber'] !== NULL) {
                              echo $data['nama_karyawan'];
                            } elseif (!empty($data['nama_inven']) && $data['id_inven'] !== NULL) {
                              $query_karyawan = mysqli_query($koneksi, "SELECT nama FROM karyawan WHERE id_karyawan = 1");
                              if ($row = mysqli_fetch_array($query_karyawan)) {
                                echo $row['nama'];
                              } else {
                                echo "Karyawan dengan id_karyawan = 1 tidak ditemukan";
                              }
                            } else {
                              echo "Nama tidak tersedia";
                            }
                            ?>
                          </td>
                          <td>
                            <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_pengeluaran']; ?>"></a>
                          </td>
                        </tr>
              </div>
            </div>

            <!-- Modal Edit Mahasiswa-->
            <div class="modal fade" id="myModal<?php echo $data['id_pengeluaran']; ?>" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ubah Data Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <form role="form" action="proses-edit-pengeluaran.php" method="get">

                      <?php
                        $id = $data['id_pengeluaran'];
                        $query_edit = mysqli_query($koneksi, "SELECT * FROM pengeluaran WHERE id_pengeluaran='$id'");
                        $row = mysqli_fetch_array($query_edit);
                      ?>


                      <input type="hidden" name="id_pengeluaran" value="<?php echo $row['id_pengeluaran']; ?>">

                      <div class="form-group">
                        <label>Id</label>
                        <input type="text" name="id_pengeluaran" class="form-control" value="<?php echo $row['id_pengeluaran']; ?>" disabled>
                      </div>

                      <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tgl_pengeluaran" class="form-control" value="<?php echo $row['tgl_pengeluaran']; ?>">
                      </div>

                      <div class="form-group">
                        <label>Jumlah Satuan</label> <!-- Input Jumlah Satuan -->
                        <input type="number" name="jml_satuan" class="form-control" value="<?php echo $row['jml_satuan']; ?>">
                      </div>

                      <div class="form-group">
                        <label>inven</label>
                        <select class="form-control" name='id_inven'>
                          <?php
                          // Query untuk mengambil hanya inven dengan ID tertentu
                          $queri = mysqli_query($koneksi, "SELECT * FROM inven WHERE id_inven");

                          // Inisialisasi variabel no untuk penomoran
                          $noo = 1;

                          // Tampilkan pilihan dropdown
                          while ($querynama = mysqli_fetch_array($queri)) {
                            echo '<option value="' . $querynama['id_inven'] . '">' . $noo++ . '.' . $querynama["nama"] . '</option>';
                          }
                          ?>
                        </select>
                      </div>

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Ubah</button>
                        <a href="hapus-pengeluaran.php?id_pengeluaran=<?= $row['id_pengeluaran']; ?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
      window.location.href = "pengeluaran.php";
    });
  </script>


  <!-- Modal Tambah Pengeluaran -->
  <div id="myModalTambah" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Konten modal -->
      <div class="modal-content">
        <!-- Heading modal -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pengeluaran</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Body modal -->
        <form action="tambah-pengeluaran.php" method="POST">
          <div class="modal-body">
            <!-- Input Tanggal -->
            Tanggal:
            <input type="date" class="form-control" name="tgl_pengeluaran" required>

            <!-- Input untuk jumlah satuan -->
            Jumlah Satuan:
            <input type="number" class="form-control" name="jml_satuan" required>

            <!-- Dropdown Inven -->
            <div>
              Pengeluaran:
              <select class="form-control" name="id_inven" id="invenDropdown" onchange="toggleDropdowns()" required>
                <option value="">--Pilih--</option>
                <?php
                include('koneksi.php'); // Pastikan Anda menyertakan koneksi
                $queri = mysqli_query($koneksi, "SELECT * FROM inven");
                $no = 1;
                while ($querynama = mysqli_fetch_array($queri)) {
                  echo '<option value="' . $querynama['id_inven'] . '">' . $no++ . '.' . $querynama["nama"] . '</option>';
                }
                ?>
              </select>
            </div>

            <!-- Dropdown Sumber -->
            <div id="sumberDropdown" style="display:none;">
              Barang Return:
              <select class="form-control" name="id_sumber">
                <?php
                $queri = mysqli_query($koneksi, "SELECT * FROM sumber");
                $no = 1;
                while ($querynama = mysqli_fetch_array($queri)) {
                  echo '<option value="' . $querynama['id_sumber'] . '">' . $no++ . '.' . $querynama["nama"] . '</option>';
                }
                ?>
              </select>
            </div>

            <!-- Dropdown Karyawan -->
            <div id="karyawanDropdown" style="display:none;">
              Penanggung jawab Return:
              <select class="form-control" name="id_karyawan">
                <?php
                $queri = mysqli_query($koneksi, "SELECT * FROM karyawan"); // Nama tabel diperbaiki
                $no = 1;
                while ($querynama = mysqli_fetch_array($queri)) {
                  echo '<option value="' . $querynama['id_karyawan'] . '">' . $no++ . '.' . $querynama["nama"] . '</option>';
                }
                ?>
              </select>
            </div>

            <script>
              function toggleDropdowns() {
                var invenDropdown = document.getElementById("invenDropdown");
                var sumberDropdown = document.getElementById("sumberDropdown");
                var karyawanDropdown = document.getElementById("karyawanDropdown");

                // Cek apakah pilihan yang dipilih adalah ID 6
                if (invenDropdown.value === "6") {
                  sumberDropdown.style.display = "block"; // Tampilkan dropdown sumber
                  karyawanDropdown.style.display = "block"; // Tampilkan dropdown karyawan
                } else {
                  sumberDropdown.style.display = "none"; // Sembunyikan dropdown sumber
                  karyawanDropdown.style.display = "none"; // Sembunyikan dropdown karyawan
                }
              }
            </script>

          </div>

          <!-- Footer Modal -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Tambah</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    </div>
    <!-- /.container-fluid -->

  </div>

  </div>
  <!-- End of Main Content -->

  <?php require 'footer.php' ?>

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
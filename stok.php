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

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/cssku.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php require 'koneksi.php'; ?>
    <?php require 'sidebar.php'; ?>
    <!-- Main Content -->
    <div id="content">

        <?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!--
            <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Stok</i></button><br>
-->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                    <!-- Tombol Tambah Sumber -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#addSumberModal">
                        <i class="fas fa-plus"></i> <!-- Icon plus dari Font Awesome -->
                        Add
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Margin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Margin</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                // Query to fetch data
                                $query = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber != 1");
                                $no = 1;
                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td> <!-- Display row number -->
                                        <td><?= $data['nama'] ?></td>
                                        <td>Rp. <?= number_format($data['harga'], 2, ',', '.') ?></td>
                                        <td><?= $data['margin'] ?></td>
                                        <td>
                                            <!-- Button untuk modal -->
                                            <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_sumber']; ?>"></a>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Mahasiswa-->
                                    <div class="modal fade" id="myModal<?php echo $data['id_sumber']; ?>" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Produk</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form role="form" action="proses-edit-stok.php" method="get">

                                                        <?php
                                                        $id = $data['id_sumber'];
                                                        $query_edit = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber='$id'");
                                                        //$result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($query_edit)) {
                                                        ?>


                                                            <input type="hidden" name="id_sumber" value="<?php echo $row['id_sumber']; ?>">

                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Harga</label>
                                                                <input type="text" name="harga" class="form-control" value="<?php echo $row['harga']; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Margin</label>
                                                                <input type="text" name="margin" class="form-control" value="<?php echo $row['margin']; ?>">
                                                            </div>


                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Ubah</button>
                                                                <a href="hapus-stok.php?id_sumber=<?= $row['id_sumber']; ?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                                                            </div>
                                                        <?php
                                                        }
                                                        //mysql_close($host);
                                                        ?>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                    <div id="addSumberModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Konten modal -->
                                            <div class="modal-content">
                                                <!-- Heading modal -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Produk</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- Body modal -->
                                                <form action="tambah-stok.php" method="post"> <!-- Mengubah method ke POST -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama">Nama:</label>
                                                            <input type="text" class="form-control" name="nama" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="harga">Harga:</label>
                                                            <input type="number" class="form-control" name="harga" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="margin">Margin:</label>
                                                            <input type="number" class="form-control" name="margin" required>
                                                        </div>
                                                    </div>
                                                    <!-- Footer modal -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Tambah</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    </div>


                <?php
                                }
                ?>
                </tbody>
                </table>
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
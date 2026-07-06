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

</head>

<body id="page-top">
    <?php require 'koneksi.php'; ?>
    <?php require 'sidebar.php'; ?>



    <!-- Main Content -->
    <div id="content">

        <?php require 'navbar.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Row to contain both table and notes -->
            <div class="row">
                <!-- Column for the table (Daftar Stok Inventaris) -->
                <div class="col-xl-7 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Inventaris</h6>
                            <!-- Tombol Tambah Sumber -->
                            <button class="btn btn-success" data-toggle="modal" data-target="#addSumberinven">
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
                                            <th>Inventaris</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Inventaris</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM inven WHERE id_inven != 6");
                                        $no = 1;
                                        while ($data = mysqli_fetch_assoc($query)) {
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td> <!-- Display row number -->
                                                <td><?= $data['nama'] ?></td>
                                                <td><?= $data['harga'] ?></td>
                                                <td>
                                                    <!-- Button untuk modal -->
                                                    <a href="#" type="button" class=" fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_inven']; ?>"></a>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit Mahasiswa-->
                                            <div class="modal fade" id="myModal<?php echo $data['id_inven']; ?>" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Ubah Data Inventaris</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" action="proses-edit-inven.php" method="get">

                                                                <?php
                                                                $id = $data['id_inven'];
                                                                $query_edit = mysqli_query($koneksi, "SELECT * FROM inven WHERE id_inven='$id'");
                                                                //$result = mysqli_query($conn, $query);
                                                                while ($row = mysqli_fetch_array($query_edit)) {
                                                                ?>


                                                                    <input type="hidden" name="id_inven" value="<?php echo $row['id_inven']; ?>">

                                                                    <div class="form-group">
                                                                        <label>Nama</label>
                                                                        <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Harga</label>
                                                                        <input type="text" name="harga" class="form-control" value="<?php echo $row['harga']; ?>">
                                                                    </div>


                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success">Ubah</button>
                                                                        <a href="hapus-inven.php?id_inven=<?= $row['id_inven']; ?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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



                                            <div id="addSumberinven" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Konten modal -->
                                                    <div class="modal-content">
                                                        <!-- Heading modal -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Tambah Inventaris</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Body modal -->
                                                        <form action="tambah-inven.php" method="post"> <!-- Mengubah method ke POST -->
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="nama">Nama:</label>
                                                                    <input type="text" class="form-control" name="nama" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="harga">Harga:</label>
                                                                    <input type="number" class="form-control" name="harga" required>
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

            <!-- Column for the notes (Catatan 1 and Catatan 2) -->
            <div class="col-lg-5">
                <!-- Collapsable Card for Catatan 1 -->
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Catatan 1</h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            <?php
                            $catatan1 = mysqli_query($koneksi, "SELECT catatan FROM catatan where id_catatan= 5");
                            $catatan1 = mysqli_fetch_array($catatan1);
                            echo $catatan1['catatan'];
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Collapsable Card for Catatan 2 -->
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                        <h6 class="m-0 font-weight-bold text-primary">Catatan 2</h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample1">
                        <div class="card-body">
                            <?php
                            $catatan2 = mysqli_query($koneksi, "SELECT * FROM catatan where id_catatan= 6");
                            $catatan2 = mysqli_fetch_array($catatan2);
                            echo $catatan2['catatan'];
                            ?>
                        </div>
                    </div>
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
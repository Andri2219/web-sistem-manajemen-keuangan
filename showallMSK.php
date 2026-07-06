<?php
include 'koneksi.php'; // Pastikan file koneksi di-load sebelum digunakan
?>

<!-- Table Display -->
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <tbody>
    <?php
    $filterYear = isset($_GET['year']) ? $_GET['year'] : null;

    if ($filterYear) {
      // Query data berdasarkan tahun
      $query = mysqli_query($koneksi, "
        SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
        FROM pemasukan 
        JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber
        WHERE YEAR(tgl_pemasukan) = '$filterYear'
        ORDER BY tgl_pemasukan ASC
      ");

      $no = 1;
      while ($data = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $data['tgl_pemasukan'] ?></td>
          <td>Rp. <?= number_format($data['harga'], 2, ',', '.') ?></td>
          <td><?= $data['jml_satuan'] ?></td>
          <td>Rp. <?= number_format($data['jumlah'], 2, ',', '.') ?></td>
          <td><?= $data['nama_sumber'] ?></td>
          <td>
            <!-- Button untuk modal edit -->
            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?= $data['id_pemasukan'] ?>">
              <i class="fa fa-edit"></i>
            </button>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="myModal<?= $data['id_pemasukan'] ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Ubah Data Pemasukan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <form action="proses-edit-pemasukan.php" method="POST">
                  <input type="hidden" name="id_pemasukan" value="<?= $data['id_pemasukan'] ?>">

                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tgl_pemasukan" class="form-control" value="<?= $data['tgl_pemasukan'] ?>">
                  </div>

                  <div class="form-group">
                    <label>Jumlah Satuan</label>
                    <input type="number" name="jml_satuan" class="form-control" value="<?= $data['jml_satuan'] ?>" required>
                  </div>

                  <div class="form-group">
                    <label>Sumber</label>
                    <select class="form-control" name="id_sumber" required>
                      <option value="">--Pilih--</option>
                      <?php
                      $sumberQuery = mysqli_query($koneksi, "SELECT * FROM sumber WHERE id_sumber != 1");
                      while ($sumber = mysqli_fetch_assoc($sumberQuery)) {
                        $selected = ($sumber['id_sumber'] == $data['id_sumber']) ? 'selected' : '';
                        echo "<option value='{$sumber['id_sumber']}' {$selected}>{$sumber['nama']}</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="modal-footer">
                    <a href="hapus-pemasukan.php?id_pemasukan=<?= $data['id_pemasukan'] ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<tr><td colspan='7'>Silakan Pilih Tahun untuk Menampilkan Data</td></tr>";
    }
    ?>
  </tbody>
</table>

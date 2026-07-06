<?php
include 'koneksi.php'; // Pastikan file koneksi di-include

$no = 1;
$query = mysqli_query($koneksi, "SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga_inven, sumber.nama AS nama_sumber, sumber.harga AS harga_sumber, karyawan.nama AS nama_karyawan 
  FROM pengeluaran 
  JOIN inven ON pengeluaran.id_inven = inven.id_inven
  JOIN sumber ON pengeluaran.id_sumber = sumber.id_sumber
  JOIN karyawan ON pengeluaran.id_karyawan = karyawan.id_karyawan");

while ($data = mysqli_fetch_assoc($query)) {
  echo "
    <tr>
      <td>" . $no++ . "</td> <!-- Display row number -->
      <td>{$data['tgl_pengeluaran']}</td>
      <td>";

  // Check for harga_sumber and harga_inven
  if (!empty($data['harga_sumber']) && $data['id_sumber'] !== NULL) {
    echo 'Rp. ' . number_format($data['harga_sumber'], 2, ',', '.');
  } elseif (!empty($data['harga_inven']) && $data['id_inven'] !== NULL) {
    echo 'Rp. ' . number_format($data['harga_inven'], 2, ',', '.');
  } else {
    echo "Harga tidak tersedia";
  }

  echo "</td>
      <td>{$data['jml_satuan']}</td>
      <td>Rp. " . number_format($data['jumlah'], 2, ',', '.') . "</td>
      <td>" . (!empty($data['nama_inven']) ? $data['nama_inven'] : "Nama tidak tersedia") . "</td>
      <td>{$data['nama_karyawan']}</td>
      <td>
        <!-- Button untuk modal edit -->
        <a href='#' class='fa fa-edit btn btn-primary btn-md' data-toggle='modal' data-target='#myModal" . $data['id_pengeluaran'] . "'></a>
      </td>
    </tr>";

  // Modal Edit Pengeluaran
?>
  <!-- Modal Edit Pengeluaran -->
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
              <input type="date" name="tgl_pengeluaran" class="form-control" value="<?php echo $row['tgl_pengeluaran']; ?>" disabled>
            </div>

            <div class="form-group">
              <label>Jumlah Satuan</label> <!-- Input Jumlah Satuan -->
              <input type="number" name="jml_satuan" class="form-control" value="<?php echo $row['jml_satuan']; ?>" disabled>
            </div>

            <div class="form-group">
              <label>Inventaris</label>
              <select class="form-control" name='id_inven' disabled>
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
              <a href="hapus-pengeluaran.php?id_pengeluaran=<?= $row['id_pengeluaran']; ?>" Onclick="return confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
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
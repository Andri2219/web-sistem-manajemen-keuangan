<?php
// Panggil koneksi database
include('koneksi.php');

// Ambil data dari URL
$id_inven = $_GET['id_inven'];
$nama = $_GET['nama'];
$harga = $_GET['harga'];

// Query untuk memanggil prosedur tersimpan dengan parameter lengkap
$query = mysqli_query($koneksi, "CALL update_inven('$id_inven', '$nama', '$harga')");

if ($query) {
    // Redirect ke halaman stok.php jika query berhasil
    header("location:inven.php");
} else {
    // Tampilkan pesan kesalahan jika query gagal
    echo "ERROR, data gagal disimpan: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database (opsional)
// mysqli_close($koneksi);
?>

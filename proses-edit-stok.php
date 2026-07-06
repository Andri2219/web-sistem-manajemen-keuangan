<?php
// Panggil koneksi database
include('koneksi.php');

// Ambil data dari URL
$id_sumber = $_GET['id_sumber'];
$nama = $_GET['nama'];
$harga = $_GET['harga'];
$margin = $_GET['margin'];

// Query untuk memanggil prosedur tersimpan dengan parameter lengkap
$query = mysqli_query($koneksi, "CALL update_sumber('$id_sumber', '$nama', '$harga','$margin')");

if ($query) {
    // Redirect ke halaman stok.php jika query berhasil
    header("location:stok.php");
} else {
    // Tampilkan pesan kesalahan jika query gagal
    echo "ERROR, data gagal disimpan: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database (opsional)
// mysqli_close($koneksi);
?>

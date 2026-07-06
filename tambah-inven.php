<?php
include('koneksi.php');

// Menggunakan POST untuk mengambil data dari formulir
$nama = $_POST['nama'] ?? null; // menggunakan null coalescing untuk menghindari undefined index
$harga = $_POST['harga'] ?? null;

// Periksa apakah data yang diperlukan tidak kosong
if ($nama === null || $harga === null) {
    die("Error: Nama atau jumlah stok tidak boleh kosong.");
}

// Pastikan $harga adalah integer
$harga = (int)$harga; // Mengonversi ke integer, ini juga mencegah SQL injection

// Mengamankan input nama untuk mencegah SQL injection
$nama = mysqli_real_escape_string($koneksi, $nama);

// Query untuk menambahkan data ke database
$query = mysqli_query($koneksi, "CALL insert_inven('$nama', $harga)");

if ($query) {
    // Redirect ke page index
    header("Location: inven.php");
    exit; // Pastikan untuk keluar setelah redirect
} else {
    echo "ERROR: Data gagal ditambahkan. " . mysqli_error($koneksi);
}
?>

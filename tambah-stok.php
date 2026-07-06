<?php
include('koneksi.php');

// Menggunakan POST untuk mengambil data dari formulir
$nama = $_POST['nama'] ?? null; // menggunakan null coalescing untuk menghindari undefined index
$harga = $_POST['harga'] ?? null;
$margin = $_POST['margin'] ?? null;

// Periksa apakah data yang diperlukan tidak kosong
if ($nama === null || $harga === null) {
    die("Error: Nama atau jumlah stok tidak boleh kosong.");
}

// Pastikan $harga adalah integer
$harga = (int)$harga; // Mengonversi ke integer, ini juga mencegah SQL injection

// Query untuk memanggil prosedur tersimpan
$query = mysqli_query($koneksi, "CALL insert_sumber('$nama', '$harga', '$margin')"); // Memanggil prosedur dengan parameter

if ($query) {
    // Redirect ke page index
    header("Location: stok.php");
    exit; // Pastikan untuk keluar setelah redirect
} else {
    echo "ERROR: Data gagal ditambahkan. " . mysqli_error($koneksi);
}
?>

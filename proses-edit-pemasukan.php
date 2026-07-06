<?php

session_start();

include('koneksi.php');

define('LOG', 'log.txt');
function write_log($log)
{
    $time = @date('[Y-d-m:H:i:s]');
    $op = $time . ' ' . $log . "\n" . PHP_EOL;
    $fp = @fopen(LOG, 'a');
    $write = @fwrite($fp, $op);
    @fclose($fp);
}

// Ambil ID pemasukan dari URL
$id = (int) $_GET['id_pemasukan'];
// Ambil data yang akan diedit
$tgl = $_GET['tgl_pemasukan']; // Menggunakan format tanggal yang benar
$jml_satuan = abs((int) $_GET['jml_satuan']); // Jumlah satuan harus integer
$sumber = abs((int) $_GET['id_sumber']); // ID sumber harus integer

//query update
$query = mysqli_query($koneksi, "UPDATE pemasukan SET tgl_pemasukan='$tgl', jml_satuan='$jml_satuan', id_sumber='$sumber' WHERE id_pemasukan='$id' ");

$namaadmin = $_SESSION['nama'];
if ($query) {
    write_log("Nama Admin : " . $namaadmin . " => Edit Pemasukan => " . $id . " => Sukses Edit");
    // Redirect ke page index
    header("location:pendapatan.php");
} else {
    write_log("Nama Admin : " . $namaadmin . " => Edit Pemasukan => " . $id . " => Gagal Edit");
    echo "ERROR, data gagal diupdate" . mysqli_error($koneksi);
}

//mysql_close($host);

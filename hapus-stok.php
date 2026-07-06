<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_sumber'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `sumber` WHERE id_sumber = '$id'");

if ($query) {
 # credirect ke page index
 header("location:stok.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
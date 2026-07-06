<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_catatan'];
$catatan = $_GET['catatan'];

//query update
$query = mysqli_query($koneksi,"UPDATE catatan SET catatan='$catatan' WHERE id_catatan='$id' ");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($Koneksi);
}

//mysql_close($host);
?>
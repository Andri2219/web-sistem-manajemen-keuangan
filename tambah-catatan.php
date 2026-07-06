<?php
//include('dbconnected.php');
include('koneksi.php');

$catatan = $_GET['catatan'];
$letak = $_GET['letak'];


//query update
$query = mysqli_query($koneksi,"INSERT INTO `catatan` (`catatan`, `letak`) VALUES ('$catatan', '$letak', '$pass')");

if ($query) {
 # credirect ke page index
 header("location:profile.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>
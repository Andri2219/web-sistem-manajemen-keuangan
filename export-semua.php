<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Pemasukan_Pengeluaran.xls");

// Ambil parameter tahun dan bulan dari URL
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';

// Load koneksi
include "koneksi.php";

// Query untuk data pemasukan berdasarkan tahun dan bulan
$queryPemasukan = "SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
                   FROM pemasukan 
                   JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber";
if (!empty($year)) {
    $queryPemasukan .= " WHERE YEAR(tgl_pemasukan) = '$year'";
    if (!empty($month)) {
        $queryPemasukan .= " AND MONTH(tgl_pemasukan) = '$month'";
    }
}

// Query untuk data pengeluaran berdasarkan tahun dan bulan
$queryPengeluaran = "SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga  
                     FROM pengeluaran 
                     JOIN inven ON pengeluaran.id_inven = inven.id_inven";
if (!empty($year)) {
    $queryPengeluaran .= " WHERE YEAR(tgl_pengeluaran) = '$year'";
    if (!empty($month)) {
        $queryPengeluaran .= " AND MONTH(tgl_pengeluaran) = '$month'";
    }
}

// Eksekusi query
$resultPemasukan = mysqli_query($koneksi, $queryPemasukan);
$resultPengeluaran = mysqli_query($koneksi, $queryPengeluaran);
?>

<h3>Data Pemasukan</h3>

<?php
// Menampilkan pemasukan berdasarkan bulan
if (mysqli_num_rows($resultPemasukan) > 0) {
    $currentMonth = '';
    while ($data = mysqli_fetch_array($resultPemasukan)) {
        $monthOfRecord = date('m', strtotime($data['tgl_pemasukan']));
        $yearOfRecord = date('Y', strtotime($data['tgl_pemasukan']));
        
        if ($currentMonth != $monthOfRecord) {
            if ($currentMonth != '') {
                echo "</table><br>"; // Close previous table
            }
            // Start a new table for a new month
            echo "<h4>Bulan: " . $monthOfRecord . " Tahun: " . $yearOfRecord . "</h4>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID Pemasukan</th><th>Tgl Pemasukan</th><th>Harga</th><th>Jml_satuan</th><th>Total</th><th>Sumber</th></tr>";
            $currentMonth = $monthOfRecord;
        }
        echo "<tr>";
        echo "<td>" . $data['id_pemasukan'] . "</td>";
        echo "<td>" . $data['tgl_pemasukan'] . "</td>";
        echo "<td>" . $data['harga'] . "</td>";
        echo "<td>" . $data['jml_satuan'] . "</td>";
        echo "<td>" . $data['jumlah'] . "</td>";
        echo "<td>" . $data['nama_sumber'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>"; // Close last table
} else {
    echo "Tidak ada data pemasukan untuk bulan dan tahun ini.";
}
?>

<h3>Data Pengeluaran</h3>

<?php
// Menampilkan pengeluaran berdasarkan bulan
if (mysqli_num_rows($resultPengeluaran) > 0) {
    $currentMonth = '';
    while ($data = mysqli_fetch_array($resultPengeluaran)) {
        $monthOfRecord = date('m', strtotime($data['tgl_pengeluaran']));
        $yearOfRecord = date('Y', strtotime($data['tgl_pengeluaran']));
        
        if ($currentMonth != $monthOfRecord) {
            if ($currentMonth != '') {
                echo "</table><br>"; // Close previous table
            }
            // Start a new table for a new month
            echo "<h4>Bulan: " . $monthOfRecord . " Tahun: " . $yearOfRecord . "</h4>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID Pengeluaran</th><th>Tgl Pengeluaran</th><th>Harga</th><th>Jml_satuan</th><th>Total</th><th>Sumber</th></tr>";
            $currentMonth = $monthOfRecord;
        }
        echo "<tr>";
        echo "<td>" . $data['id_pengeluaran'] . "</td>";
        echo "<td>" . $data['tgl_pengeluaran'] . "</td>";
        echo "<td>" . $data['harga'] . "</td>";
        echo "<td>" . $data['jml_satuan'] . "</td>";
        echo "<td>" . $data['jumlah'] . "</td>";
        echo "<td>" . $data['nama_inven'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>"; // Close last table
} else {
    echo "Tidak ada data pengeluaran untuk bulan dan tahun ini.";
}
?>

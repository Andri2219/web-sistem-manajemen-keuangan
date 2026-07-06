<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Pemasukan.xls");

include "koneksi.php";

// Ambil parameter tahun dan bulan dari URL
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';

// Query untuk data pemasukan berdasarkan filter tahun dan bulan
$queryCondition = "";
if (!empty($year)) {
    $queryCondition .= "YEAR(tgl_pemasukan) = '$year'";
}
if (!empty($month)) {
    $queryCondition .= (!empty($queryCondition) ? " AND " : "") . "MONTH(tgl_pemasukan) = '$month'";
}

$query = "SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
          FROM pemasukan 
          JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber";
if (!empty($queryCondition)) {
    $query .= " WHERE $queryCondition";
}

$result = mysqli_query($koneksi, $query);

// Array untuk nama bulan
$months = [
    '1' => 'Januari',
    '2' => 'Februari',
    '3' => 'Maret',
    '4' => 'April',
    '5' => 'Mei',
    '6' => 'Juni',
    '7' => 'Juli',
    '8' => 'Agustus',
    '9' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

if ($year && !$month) {
    // Jika hanya tahun yang dipilih, tampilkan data untuk setiap bulan dalam tahun tersebut
    foreach ($months as $monthNum => $monthName) {
        $queryMonth = "SELECT pemasukan.*, sumber.nama AS nama_sumber, sumber.harga AS harga 
                       FROM pemasukan 
                       JOIN sumber ON pemasukan.id_sumber = sumber.id_sumber
                       WHERE YEAR(tgl_pemasukan) = '$year' AND MONTH(tgl_pemasukan) = '$monthNum'";
        $resultMonth = mysqli_query($koneksi, $queryMonth);
        
        echo "<h3>Data Pemasukan - $monthName $year</h3>";
        echo "<table border='1' cellpadding='5'>
                <tr>
                    <th>ID Pemasukan</th>
                    <th>Tgl Pemasukan</th>
                    <th>Harga</th>
                    <th>Jml_satuan</th>
                    <th>Total</th>
                    <th>Sumber</th>
                </tr>";
        
        while ($data = mysqli_fetch_array($resultMonth)) {
            echo "<tr>
                    <td>{$data['id_pemasukan']}</td>
                    <td>{$data['tgl_pemasukan']}</td>
                    <td>{$data['harga']}</td>
                    <td>{$data['jml_satuan']}</td>
                    <td>{$data['jumlah']}</td>
                    <td>{$data['nama_sumber']}</td>
                  </tr>";
        }
        
        echo "</table><br />";
    }
} else {
    // Jika tahun dan bulan dipilih
    $monthName = $months[$month] ?? 'Bulan Tidak Diketahui';  // Menangani jika bulan tidak ditemukan
    echo "<h3>Data Pemasukan - $monthName $year</h3>";
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID Pemasukan</th>
                <th>Tgl Pemasukan</th>
                <th>Harga</th>
                <th>Jml_satuan</th>
                <th>Total</th>
                <th>Sumber</th>
            </tr>";
    
    while ($data = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$data['id_pemasukan']}</td>
                <td>{$data['tgl_pemasukan']}</td>
                <td>{$data['harga']}</td>
                <td>{$data['jml_satuan']}</td>
                <td>{$data['jumlah']}</td>
                <td>{$data['nama_sumber']}</td>
              </tr>";
    }

    echo "</table>";
}
?>

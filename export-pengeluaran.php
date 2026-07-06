<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Pengeluaran.xls");

include "koneksi.php";

// Ambil parameter tahun dan bulan dari URL
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';

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
        $queryMonth = "SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga 
                       FROM pengeluaran 
                       JOIN inven ON pengeluaran.id_inven = inven.id_inven
                       WHERE YEAR(tgl_pengeluaran) = '$year' AND MONTH(tgl_pengeluaran) = '$monthNum'";
        $resultMonth = mysqli_query($koneksi, $queryMonth);
        
        echo "<h3>Data Pengeluaran - $monthName $year</h3>";
        echo "<table border='1' cellpadding='5'>
                <tr>
                    <th>ID Pengeluaran</th>
                    <th>Tgl Pengeluaran</th>
                    <th>Harga</th>
                    <th>Jml_satuan</th>
                    <th>Total</th>
                    <th>Sumber</th>
                </tr>";
        
        while ($data = mysqli_fetch_array($resultMonth)) {
            echo "<tr>
                    <td>{$data['id_pengeluaran']}</td>
                    <td>{$data['tgl_pengeluaran']}</td>
                    <td>{$data['harga']}</td>
                    <td>{$data['jml_satuan']}</td>
                    <td>{$data['jumlah']}</td>
                    <td>{$data['nama_inven']}</td>
                  </tr>";
        }
        
        echo "</table><br />";
    }
} else {
    // Jika tahun dan bulan dipilih
    $monthName = $months[$month] ?? 'Bulan Tidak Diketahui';  // Menangani jika bulan tidak ditemukan
    echo "<h3>Data Pengeluaran - $monthName $year</h3>";
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID Pengeluaran</th>
                <th>Tgl Pengeluaran</th>
                <th>Harga</th>
                <th>Jml_satuan</th>
                <th>Total</th>
                <th>Sumber</th>
            </tr>";
    
    $query = "SELECT pengeluaran.*, inven.nama AS nama_inven, inven.harga AS harga 
              FROM pengeluaran 
              JOIN inven ON pengeluaran.id_inven = inven.id_inven
              WHERE YEAR(tgl_pengeluaran) = '$year' AND MONTH(tgl_pengeluaran) = '$month'";

    $result = mysqli_query($koneksi, $query);

    while ($data = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$data['id_pengeluaran']}</td>
                <td>{$data['tgl_pengeluaran']}</td>
                <td>{$data['harga']}</td>
                <td>{$data['jml_satuan']}</td>
                <td>{$data['jumlah']}</td>
                <td>{$data['nama_inven']}</td>
              </tr>";
    }

    echo "</table>";
}
?>

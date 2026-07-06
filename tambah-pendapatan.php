<?php
// Panggil koneksi database
include 'koneksi.php';
session_start(); // Pastikan sesi dimulai

// Cek apakah id_admin sudah ada dalam sesi
if (!isset($_SESSION['id'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location='login.php'; // Ganti dengan halaman login Anda
          </script>";
    exit; // Keluar dari script jika belum login
}

// Ambil data dari form
$tgl_pemasukan = $_GET['tgl_pemasukan'];
$jml_satuan = (int)$_GET['jml_satuan']; // Pastikan ini integer
$id_sumber = $_GET['id_sumber']; // pastikan ini sesuai dengan input form

// Ambil id_admin dari sesi
$id_admin = $_SESSION['id']; // Pastikan id_admin disimpan dalam sesi saat admin login

// Buat array untuk menyimpan id_inven yang akan diproses
$id_inven_list = [];

// Ambil semua id_inven dari tabel inven, kecuali id_inven yang bernilai 6
$query_inven = "SELECT id_inven FROM inven WHERE id_inven != 6";
$result_inven = $koneksi->query($query_inven);

while ($row = $result_inven->fetch_assoc()) {
    $id_inven_list[] = $row['id_inven'];
}

// Jika tidak ada id_inven yang valid, tampilkan pesan dan keluar
if (empty($id_inven_list)) {
    echo "<script>
            alert('Tidak ada ID Inventaris yang valid!');
            document.location='pendapatan.php';
          </script>";
    exit;
}

// Modifikasi query untuk menyertakan id_admin
$stmt = $koneksi->prepare("INSERT INTO pemasukan (tgl_pemasukan, jml_satuan, id_sumber, id_admin) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    echo "Error preparing statement: " . $koneksi->error; // Debugging
    exit;
}
$stmt->bind_param("siis", $tgl_pemasukan, $jml_satuan, $id_sumber, $id_admin); // Bind dengan menambahkan id_admin
$simpan = $stmt->execute();

// Jika query berhasil, tampilkan pesan sukses
if ($simpan) {
    echo "<script>
            alert('Simpan Data Sukses!');
            document.location='pendapatan.php';
        </script>";
} else {
    echo "Error executing query: " . $stmt->error; // Debugging
}

// Tutup statement setelah eksekusi
$stmt->close();

// Tutup koneksi database (opsional)
// mysqli_close($koneksi);
?>

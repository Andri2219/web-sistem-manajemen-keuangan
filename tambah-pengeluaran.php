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
$tgl_pengeluaran = $_POST['tgl_pengeluaran'];
$jml_satuan = $_POST['jml_satuan']; // Pastikan ini integer
$inven = $_POST['id_inven']; // pastikan ini integer
$sumber = $_POST['id_sumber']; // pastikan ini integer

// Ambil id_admin dari sesi
$id_admin = $_SESSION['id']; // Pastikan id_admin disimpan dalam sesi saat admin login
$karyawan = $_POST['id_karyawan']; // pastikan ini integer

// Query untuk memasukkan data pengeluaran
$query = "INSERT INTO pengeluaran (tgl_pengeluaran, jml_satuan, id_inven, id_sumber, id_admin, id_karyawan) VALUES (?, ?, ?, ?, ?, ?)"; // Tambahkan id_admin
$stmt = $koneksi->prepare($query);

// Cek jika statement berhasil disiapkan
if ($stmt === false) {
    echo "Error preparing statement: " . $koneksi->error; // Debugging
    exit;
}

// Ikat parameter dan jalankan query
$stmt->bind_param("siiisi", $tgl_pengeluaran, $jml_satuan, $inven, $sumber, $id_admin, $karyawan); // Bind dengan menambahkan id_admin

if ($stmt->execute()) {
    // Jika berhasil menyimpan, tampilkan pesan sukses dan arahkan ke halaman pengeluaran
    echo "<script>
            alert('Simpan Data Sukses!');
            document.location='pengeluaran.php';
          </script>";
} else {
    // Jika gagal menyimpan, tampilkan pesan error
    echo "Error executing query: " . $stmt->error; // Debugging
}

// Tutup statement
$stmt->close();

// Tutup koneksi
$koneksi->close();
?>

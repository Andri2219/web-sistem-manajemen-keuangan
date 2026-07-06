<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-chart-pie"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Keuangan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Transaksi
    </div>

    <!-- Nav Item - Pendapatan -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="pendapatan.php">
        <i class="fas fa-fw fa-arrow-up"></i>
        <span>Pendapatan</span>
      </a>
    </li>

    <!-- Nav Item - Pengeluaran -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="pengeluaran.php">
        <i class="fas fa-fw fa-arrow-down"></i>
        <span>Pengeluaran</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Detail
    </div>

   <!-- Nav Item - stok -->
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-fw fa-box"></i>
    <span>Stok</span>
  </a>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="stok.php">Stok Produk</a>
    <a class="dropdown-item" href="inven.php">Stok Inventaris</a>
  </div>
</li>



    <li class="nav-item">
      <a class="nav-link collapsed" href="karyawan.php">
        <i class="fas fa-fw fa-users"></i>
        <span>Karyawan</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Tagihan
    </div>

    <!-- Nav Item - Arus Kas -->
<li class="nav-item">
  <a class="nav-link" href="tren.php">
  <i class="fas fa-fw fa-chart-area"></i>
    <span>Arus Kas</span>
  </a>
</li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
      <a class="nav-link" href="laporan.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Laporan</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) 
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

  </ul>
  <!-- End of Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">


    <!-- End of Main Content -->

  </div>
  <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- CSS to make the sidebar fixed and content scrollable -->
<style>
  body {
    overflow-x: hidden;
    /* Prevent horizontal scrolling */
  }

  #wrapper {
    display: flex;
  }

  .sidebar {
    position: fixed;
    /* Keep the sidebar fixed */
    height: 100vh;
    /* Full height */

  }

  #content {
    margin-left: 250px;
    /* Adjust based on sidebar width */
    flex-grow: 1;

  }

  .container-fluid {
    padding-top: 30px;
    /* Space below the navbar */

    height: calc(100vh - 56px);
    /* Subtract navbar height from full height */
  }

  /* Styles for navbar */
  .topbar {
    position: fixed;
    /* Keep the navbar fixed */
    top: 0;
    /* Align to top */
    width: calc(100% - 250px);
    /* Full width minus sidebar */
    z-index: 1000;
    /* Ensure it's above other elements */
  }

  #content {
    margin-top: 56px;
    /* Adjust this margin to the height of the navbar */
  }
</style>
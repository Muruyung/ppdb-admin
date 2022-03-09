<?php
/******************************************
* Filename    : header_login.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Header umum website
*
******************************************/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin MAN 1 Cianjur</title>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/summernote/summernote-bs4.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->
  <!-- jQuery -->
<script src="<?=base_url()?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url()?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block <?php if($halaman=="home"){ echo 'active';} ?>">
        <a href="<?php if($halaman=="home"){ echo '#';}else{ echo base_url(); } ?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block <?php if($halaman=="tabel_pendaftar" || $halaman=="tabel_pendaftar1" ){ echo 'active';} ?>">
        <a href="<?php if($halaman=="tabel_pendaftar"){ echo '#';}else{ echo base_url('C_tabel_pendaftar'); } ?>" class="nav-link">Tabel Pendaftar</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://mail.man1cianjur.com" class="nav-link">Email</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=base_url('C_tabel_pendaftar')?>/download_tbl" class="nav-link">Download Data</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Pemberitahuan</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Lihat Pemberitahuan Lainnya...</a>
        </div>
      </li> -->
      <!-- Logout -->
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url('c_home')?>/logout" class="nav-link">Logout</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

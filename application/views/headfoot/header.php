<?php
/******************************************
* Filename    : header.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-11
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Header umum website
*
******************************************/
?>
<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

     <!-- Site Metas -->
    <title>PPDB Online MAN 1 Cianjur</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- datepicker css -->
    <link href="<?=base_url();?>/assets/css/bootstrap-datepicker3.css" rel="stylesheet" />
    <link href="<?=base_url();?>/assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <link href="<?=base_url();?>/assets/css/bootstrap-datepicker3.standalone.css" rel="stylesheet" />
    <link href="<?=base_url();?>/assets/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" />

    <!-- Site Icons -->
    <link rel="shortcut icon" href="<?=base_url();?>/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?=base_url();?>/assets/images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/style.css">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/versions.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=base_url();?>/assets/css/custom.css">

	<script src="<?=base_url();?>/assets/js/modernizr.custom.79639.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="seo_version bg-dark">

	<!-- LOADER -->
	<div id="preloader">
		<div class="loader-wrapper">
			<div class="loader-new">
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
			</div>
			<div class="text">LOADING...</div>
		</div>
	</div>
	<!-- END LOADER -->

	<!-- Start header -->
	<header class="top-navbar fixed-top">
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color:rgb(28, 104, 117);">
			<div class="container">
				<a class="navbar-brand" href="<?=base_url();?>">
					<img width="35px" src="<?=base_url();?>assets/images/logo_man.png" alt="" />
          <label style="margin-left:5px; color:white;">
            MAN 1 Cianjur
          </label>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-seo" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-seo">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item <?php if ($halaman=='beranda'){echo "active";} ?>"><a class="nav-link" href="<?php if ($halaman=='beranda'){echo "#";}else{echo base_url();} ?>">Beranda</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Pendaftaran</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="<?php if ($halaman=='daftar'){echo "#";}else{echo base_url('C_daftar');} ?>">Pendaftaran Siswa Baru</a>
								<a class="dropdown-item" href="<?php if ($halaman=='cara_daftar'){echo "#";}else{echo base_url('C_cara_daftar');} ?>">Cara Pendaftaran</a>
								<a onclick="maintenance()" class="dropdown-item" href="#">Cara Edit Data dan Lihat Pengumuman</a>
								<a onclick="maintenance()" class="dropdown-item" href="#">Prosedur Pendaftaran</a>
							</div>
						</li>
            <li class="nav-item <?php if ($halaman=='pemberitahuan'){echo 'active';} ?>"><a class="nav-link" href="<?php if ($halaman=='pemberitahuan'){echo "#";}else{echo base_url('C_pemberitahuan');} ?>">Pemberitahuan</a></li>
						<li class="nav-item <?php if ($halaman=='login'){echo 'active';} ?>"><a class="nav-link" href="<?php if ($halaman=='Login'){echo "#";}else{echo base_url('C_login');} ?>">Login</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->

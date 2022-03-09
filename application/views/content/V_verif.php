<?php
/******************************************
* Filename    : V_verif.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Konten untuk verifikasi login admin
*
******************************************/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin MAN 1 Cianjur | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Admin</b> Verifikasi
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masukkan kode verifikasi anda</p>

      <form action="<?=base_url()?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="verif" name="verif" placeholder="Kode Verifikasi" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" onclick="return verifikasi()">Verifikasi</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<script type="text/javascript">
  function verifikasi(){
    var verifikasi = document.getElementById('verif').value;
    if (verifikasi != ""){
      var link = "<?=base_url('c_verif')?>"+"/verif/<?=$u?>/<?=$p?>/"+verifikasi;
      var cek = -3;
      $.ajax({
        type:"GET",
        url:link,
        async:false,
        success:function(isi){
          cek = isi;
        }
      });
      // alert(cek);
      if(cek == 1){
        alert('Selamat anda berhasil login!!');
        return true;
      }else{
        alert('Kode verifikasi salah!!');
        return false;
      }
    }else{
      return true;
    }
  }
</script>

<!-- jQuery -->
<script src="<?=base_url()?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>/assets/dist/js/adminlte.min.js"></script>

</body>
</html>

<?php
/******************************************
* Filename    : V_login.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Konten untuk login admin
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

  <!-- Loading -->
  <link rel="stylesheet" href="<?=base_url()?>/assets/loader.css">
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
      <b>Admin</b> Login
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="<?=base_url('C_verif')?>" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div> -->
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" onclick="return login()">Sign In</button>
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
  <div class="loader" id="loader" style="display:none;"></div>

  <script type="text/javascript">
    function login(){
      var user = document.getElementById('username').value;
      var pass = document.getElementById('password').value;
      if (user != "" && pass != ""){
        var link = "<?=base_url('c_login')?>"+"/login/"+user+"/"+pass;
        var cek = -3;

        $.ajax({
          type:"POST",
          url:link,
          async:false,
          success:function(isi){
            cek = isi;
          }
        });
        if(cek == 1){
          alert('Kode verifikasi akan dikirim melalui email anda. Periksa Inbox atau folder Spam!!');
          return true;
        }else{
          alert('Username atau password salah!!');
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

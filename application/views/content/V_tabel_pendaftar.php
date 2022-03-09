<?php
/******************************************
* Filename    : V_tabel_pendaftar.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Konten untuk tabel pendaftar
*
******************************************/ ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tabel Pendaftar</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
            <li class="breadcrumb-item active">Tabel Pendaftar</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <!-- Tabel umum -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tabel Data Umum Pendaftar</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>NISN</th>
                  <th>Nama Pendaftar</th>
                  <th>Asal Sekolah</th>
                  <th>Jalur Daftar</th>
                  <th>Tahap Daftar</th>
                  <th>Tanggal Daftar</th>
                  <th>Nilai</th>
                  <th>Kelulusan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($siswa as $_siswa) {
                    ?>
                    <tr>
                      <td><?=$_siswa['nisn']?></td>
                      <td><?=$_siswa['nama']?></td>
                      <?php
                      $hasil = "";
                      $tahap = "";
                        foreach ($user as $_user) {
                          if($_user['id_user'] == $_siswa['id']){
                            $tahap = $_user['tahap_daftar'];
                            break;
                          }
                        }
                        foreach ($pendaftaran as $_pendaftaran) {
                          if($_pendaftaran['id_user'] == $_siswa['id']){
                            ?>
                            <td><?=$_pendaftaran['nama_sekolah']?></td>
                            <td><?=$_pendaftaran['jalur_daftar']?></td>
                            <?php
                              if ($tahap != '0'){
                              ?>
                                <td><?=$tahap?></td>
                              <?php
                              }else{
                              ?>
                                <td>Selesai</td>
                              <?php
                              }
                            ?>
                            <td><?=$_pendaftaran['tgl_daftar']?></td>
                            <?php
                            $hasil = $_pendaftaran['kelulusan'];
                            break;
                          }
                        }
                       ?>
                      <?php
                      foreach ($nilai as $_nilai) {
                        if($_nilai['id_user'] == $_siswa['id']){
                          ?>
                          <td><?=$_nilai['nilai']?></td>
                          <?php
                          break;
                        }
                      }
                       ?>
                       <td>
                         <select class="form-control col-sm-8" name="kelulusan<?=$_siswa['id']?>" id="kelulusan<?=$_siswa['id']?>" onchange="pilih_kelulusan(<?=$_siswa['id']?>)">
                           <option value="">-- Pilih Kelulusan --</option>
                           <option value="lulus" <?php if ($hasil == "lulus"){ echo "selected";}?>>Lulus</option>
                           <option value="cadangan" <?php if ($hasil == "cadangan"){ echo "selected";}?>>Lulus Cadangan</option>
                           <option value="tidak_lulus" <?php if ($hasil == "tidak_lulus"){ echo "selected";}?>>Tidak Lulus</option>
                         </select>
                       </td>
                      <td>
                        <a class="btn btn-primary btn-sm" href="<?=base_url('C_lihat_data').'?token='.encrypt_url('id='.$_siswa['id'])?>">
                            <i class="fas fa-folder">
                            </i>
                            Lihat
                        </a>
                      </td>
                    </tr>
                    <?php
                  }
                 ?>
              </tbody>
              <!-- <tfoot>
              <tr>
                <th>Rendering engine</th>
                <th>Browser</th>
                <th>Platform(s)</th>
                <th>Engine version</th>
                <th>CSS grade</th>
              </tr>
              </tfoot> -->
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- Tabel Kelengkapan File -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tabel Berkas Pendaftar</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>NISN</th>
                  <th>Nama Pendaftar</th>
                  <th>Ket.Sehat*</th>
                  <th>Akte*</th>
                  <th>Ket.Baik*</th>
                  <th>KK*</th>
                  <th>Kelulusan*</th>
                  <th>Semester 1*</th>
                  <th>Semester 2*</th>
                  <th>Semester 3*</th>
                  <th>Semester 4*</th>
                  <th>Semester 5*</th>
                  <th>Sertifikat 1</th>
                  <th>Sertifikat 2</th>
                  <th>Sertifikat 3</th>
                  <th>KIP</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($siswa as $_siswa) {
                    ?>
                    <tr>
                      <td><?=$_siswa['nisn']?></td>
                      <td><?=$_siswa['nama']?></td>
                      <?php
                        $cek = false;
                        $loop = true;
                        $jumlah_file = 14;
                        foreach ($file as $_file) {
                          if($_file['id_user'] == $_siswa['id'] && /*($cek || $loop) &&*/ $_file['jenis'] != 'foto_diri'){
                            // $cek = true;
                            // $loop = false;
                            $jumlah_file--;
                            if ($_file['path'] != ""){
                              $jenis = explode(".", decrypt_url($_file['path']));
                            }
                            ?>
                            <td align="center">
                              <?php
                              if ($_file['path'] != ""){
                                if ($jenis[2] != ""){
                                  ?><a href="<?=$link.decrypt_url($_file['path'])?>" target="_blank"><i class="fa fa-check-circle text-success" aria-hidden="true"></i></a><?php
                                }else{
                                  ?><i class="fa fa-times-circle text-danger" aria-hidden="true"></i><?php
                                }
                              }else{
                                ?><i class="fa fa-times-circle text-danger" aria-hidden="true"></i><?php
                              }
                              ?>
                            </td>
                            <?php
                          }/*else{
                            $cek = false;
                          }
                          if ($cek == $loop){
                            break;
                          }*/
                        }
                        for ($c = 0 ; $c < $jumlah_file ; $c++){
                          ?>
                          <td align="center">
                            <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                          </td><?php
                        }
                       ?>
                    </tr>
                    <?php
                  }
                 ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- Tabel username -->
        <?php
        if ($username == encrypt_url('mansacjr') || $username == encrypt_url('muruyung')){
          ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tabel Username dan Password</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>Nama Pendaftar</th>
                    <th>Username</th>
                    <th>Password</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($siswa as $_siswa) {
                      ?>
                      <tr>
                        <td><?=$_siswa['nama']?></td>
                        <?php
                        foreach ($user as $_user) {
                          if($_user['id_user'] == $_siswa['id']){
                            ?>
                            <td><?=$_user['username']?></td>
                            <td><?=$_user['password']?></td>
                            <?php
                            break;
                          }
                        }
                        ?>
                      </tr>
                      <?php
                    }
                  ?>
                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <?php
        }
        ?>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- <footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.0.4
  </div>
  <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
  reserved.
</footer> -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- page script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false
    });
    $('#example2').DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering" : false
    });
    $('#example3').DataTable({
      "responsive": true,
      "autoWidth": false
    });
  });

  function pilih_kelulusan(id){
    var hasil = document.getElementById('kelulusan'+id).value;
    $.ajax({
      type: 'POST',
      url: "<?=base_url('C_tabel_pendaftar').'/set_kelulusan'?>",
      data: {id:id,hasil:hasil},
      cache: false,
      success: function(msg){

      }
    });
  }
</script>

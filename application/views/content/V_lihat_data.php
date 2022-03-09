<?php
/******************************************
* Filename    : V_lihat_data.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Konten untuk isi data pendaftar
*
******************************************/ ?>
<style media="screen">
.gambar-bulat{
  object-fit: cover;
  object-position:top;
  width: 50px;
  height: 50px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <img style="margin-top:-10px;" class="gambar-bulat img-circle img-bordered-sm" src="<?=$link.decrypt_url($file[0]['path'])?>" alt="user image" width="50px">
          &nbsp;
          <label><h1>Data Siswa</h1></label>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('C_tabel_pendaftar')?>">Tabel Pendaftar</a></li>
            <li class="breadcrumb-item active">Data Siswa</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-4 connectedSortable">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Siswa</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Jalur Pendaftaran</label>
                <input type="text" class="form-control" value="<?=$pendaftaran['jalur_daftar']?>" disabled>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputName">NISN</label>
                    <input type="text" class="form-control" value="<?=$siswa['nisn']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputName">NIK</label>
                    <input type="text" class="form-control" value="<?=$siswa['nik']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName">Nama Lengkap</label>
                <input type="text" class="form-control" value="<?=$siswa['nama']?>" disabled>
              </div>
              <div class="form-group">
                <label for="inputName">Jenis Kelamin</label>
                <input type="text" class="form-control" value="<?=$siswa['gender']?>" disabled>
              </div>
              <div class="form-group">
                <label for="inputName">Agama</label>
                <input type="text" class="form-control" value="<?=$siswa['agama']?>" disabled>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputName">Tempat Lahir</label>
                    <input type="text" class="form-control" value="<?=$siswa['tempat_lahir']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputName">Tanggal Lahir</label>
                    <input type="text" class="form-control" value="<?=$siswa['tanggal_lahir']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputName">Hobi</label>
                    <input type="text" class="form-control" value="<?=$siswa['hobi']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputName">Cita-cita</label>
                    <input type="text" class="form-control" value="<?=$siswa['cita-cita']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputDescription">Alamat</label>
                <textarea id="inputDescription" class="form-control" rows="4" disabled><?=$siswa['alamat']?></textarea>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="inputClientCompany">Provinsi</label>
                    <input type="text" class="form-control" value="<?=$provinsi['nama']?>" disabled>
                  </div>
                  <div class="col-md-4">
                    <label for="inputClientCompany">Kabupaten</label>
                    <input type="text" class="form-control" value="<?=$kabupaten['nama']?>" disabled>
                  </div>
                  <div class="col-md-4">
                    <label for="inputClientCompany">Kecamatan</label>
                    <input type="text" class="form-control" value="<?=$kecamatan['nama']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputClientCompany">Desa</label>
                    <input type="text" class="form-control" value="<?=$desa['nama']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputClientCompany">Kode Pos</label>
                    <input type="text" class="form-control" value="<?=$siswa['kode_pos']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Tempat Tinggal Siswa</label>
                <input type="text" class="form-control" value="<?=$siswa['tempat_tinggal']?>" disabled>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputClientCompany">Jarak Lokasi ke Madrasah</label>
                    <input type="text" class="form-control" value="<?=$siswa['jarak']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputClientCompany">Transportasi ke Madrasah</label>
                    <input type="text" class="form-control" value="<?=$siswa['transportasi']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Waktu Tempuh ke Madrasah</label>
                <input type="text" class="form-control" value="<?=$siswa['waktu']?>" disabled>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="inputClientCompany">Status Anak</label>
                    <input type="text" class="form-control" value="<?=$siswa['status_anak']?>" disabled>
                  </div>
                  <div class="col-md-4">
                    <label for="inputClientCompany">Anak Ke</label>
                    <input type="text" class="form-control" value="<?=$siswa['anak_ke']?>" disabled>
                  </div>
                  <div class="col-md-4">
                    <label for="inputClientCompany">Jumlah Saudara</label>
                    <input type="text" class="form-control" value="<?=$siswa['jumlah_sdr']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputClientCompany">Pernah Mengikuti PAUD</label>
                    <input type="text" class="form-control" value="<?=$siswa['paud']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputClientCompany">Pernah Mengikuti TK/RA</label>
                    <input type="text" class="form-control" value="<?=$siswa['tk']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputClientCompany">Tinggi Badan</label>
                <input type="text" class="form-control" value="<?=$siswa['tinggi']?>" disabled>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputClientCompany">Nomor HP</label>
                    <input type="text" class="form-control" value="<?=$siswa['no_hp']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputClientCompany">Email</label>
                    <input type="text" class="form-control" value="<?=$siswa['email']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName">Jurusan Pilihan</label>
                <input type="text" class="form-control" value="<?=$pendaftaran['jurusan']?>" disabled>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php
          if($prestasi[0] != 401){?>
          <div class="card card-fuchsia">
            <div class="card-header">
              <h3 class="card-title">Prestasi</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
              foreach ($prestasi as $_prestasi) {
                ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputClientCompany">Nama Prestasi 1</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['nama_prestasi']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputClientCompany">Tingkat</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['tingkat']?>" disabled>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="inputClientCompany">Bidang</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['bidang']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputClientCompany">Tahun</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['tahun']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputClientCompany">Kategori</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['kategori']?>" disabled>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="inputClientCompany">Prestasi</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['prestasi']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputClientCompany">Penyelenggara</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['penyelenggara']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputClientCompany">Tempat Lomba</label>
                      <input type="text" class="form-control" value="<?=$_prestasi['tempat']?>" disabled>
                    </div>
                  </div>
                </div>
                <?php
              } ?>
            </div>
            <!-- /.card-body -->
          </div>
        <?php } ?>
          <!-- /.card -->
        </div>
        <div class="col-md-4 connectedSortable">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Files</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>File Name</th>
                    <th>File Size</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($file as $_file) {
                    $jenis = explode(".", decrypt_url($_file['path']));
                    if($jenis[2] != ""){
                      //URL of the remote file that you want to get
                      //the file size of.
                      $remoteFile = $link.decrypt_url($_file['path']);
                      //Get the header response for the file in question.
                      $headers = get_headers($remoteFile, 1);
                      //Convert the array keys to lower case for the sake
                      //of consistency.
                      $headers = array_change_key_case($headers);
                      //Set to -1 by default.
                      $fileSize = -1;
                      //Check to see if the content-length key actually exists in
                      //the array before attempting to access it.
                      if(isset($headers['content-length'])){
                        $fileSize = $headers['content-length'];
                      }
                      $fileSize = round($fileSize/1024, 2);
                      $sizetype = 'KB';
                      if($fileSize/1024 >= 1.0){
                        $fileSize = round($fileSize/1024, 2);
                        $sizetype = 'MB';
                      }
                      ?>
                      <tr>
                        <td><?=$_file['jenis'].'.'.$jenis[2]?></td>
                        <td><?=$fileSize.$sizetype?></td>
                        <td class="text-right py-0 align-middle">
                          <div class="btn-group btn-group-sm">
                            <a href="<?=$link.decrypt_url($_file['path'])?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i></a>
                          </div>
                        </td>
                      </tr>
                      <?php
                    }
                  }
                   ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php if ($ayah != 401){ ?>
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Data Orang Tua</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nomor Kartu Keluarga</label>
                  <input type="text" class="form-control" value="<?=$ayah['no_kk']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nama Kepala Keluarga</label>
                  <input type="text" class="form-control" value="<?=$ayah['kepala_klg']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">NIK Ayah</label>
                  <input type="text" class="form-control" value="<?=$ayah['nik']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nama Ayah</label>
                  <input type="text" class="form-control" value="<?=$ayah['nama']?>" disabled>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Tanggal Lahir</label>
                      <input type="text" class="form-control" value="<?=$ayah['tanggal_lahir']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Status Ayah</label>
                      <input type="text" class="form-control" value="<?=$ayah['status_ortu']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pendidikan Ayah</label>
                      <input type="text" class="form-control" value="<?=$ayah['pend']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pekerjaan Ayah</label>
                      <input type="text" class="form-control" value="<?=$ayah['kerja']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Penghasilan/Bulan</label>
                  <input type="text" class="form-control" value="<?=$ayah['penghasilan']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">NIK Ibu</label>
                  <input type="text" class="form-control" value="<?=$ibu['nik']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nama Ibu</label>
                  <input type="text" class="form-control" value="<?=$ibu['nama']?>" disabled>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Tanggal Lahir</label>
                      <input type="text" class="form-control" value="<?=$ibu['tanggal_lahir']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Status Ibu</label>
                      <input type="text" class="form-control" value="<?=$ibu['status_ortu']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pendidikan Ibu</label>
                      <input type="text" class="form-control" value="<?=$ibu['pend']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pekerjaan Ibu</label>
                      <input type="text" class="form-control" value="<?=$ibu['kerja']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nomor HP</label>
                  <input type="text" class="form-control" value="<?=$ayah['no_hp']?>" disabled>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <?php 
          } 
          ?>
          <!-- /.card -->
          <?php
          if($wali != 401){
            ?>
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Data Wali</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputEstimatedBudget">NIK Wali</label>
                  <input type="text" class="form-control" value="<?=$wali['nik']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Nama Wali</label>
                  <input type="text" class="form-control" value="<?=$wali['nama']?>" disabled>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Tanggal Lahir</label>
                  <input type="text" class="form-control" value="<?=$wali['tanggal_lahir']?>" disabled>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pendidikan Wali</label>
                      <input type="text" class="form-control" value="<?=$wali['pend']?>" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="inputEstimatedBudget">Pekerjaan Wali</label>
                      <input type="text" class="form-control" value="<?=$wali['kerja']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEstimatedBudget">Penghasilan/Bulan</label>
                  <input type="text" class="form-control" value="<?=$wali['penghasilan']?>" disabled>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <?php
          }
          ?>
        </div>
        <div class="col-md-4 connectedSortable">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Sekolah Asal</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="inputEstimatedBudget">Jenis Sekolah</label>
                    <input type="text" class="form-control" value="<?=$pendaftaran['sekolah']?>" disabled>
                  </div>
                  <div class="col-md-8">
                    <label for="inputEstimatedBudget">Nama Sekolah</label>
                    <input type="text" class="form-control" value="<?=$pendaftaran['nama_sekolah']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputEstimatedBudget">Status Sekolah</label>
                    <input type="text" class="form-control" value="<?=$pendaftaran['status_sekolah']?>" disabled>
                  </div>
                  <div class="col-md-6">
                    <label for="inputEstimatedBudget">Lokasi Sekolah</label>
                    <input type="text" class="form-control" value="<?=$pendaftaran['lokasi_sekolah']?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget">Alamat Sekolah</label>
                <textarea class="form-control" rows="4" disabled><?=$pendaftaran['alamat_sekolah']?></textarea>
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget">NPSN</label>
                <input type="text" class="form-control" value="<?=$pendaftaran['npsn']?>" disabled>
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget">Tahun Lulus</label>
                <input type="text" class="form-control" value="<?=$pendaftaran['thn_lulus']?>" disabled>
              </div>
              <?php
              if($pendaftaran['no_ijazah'] != ""){
                ?>
                <div class="form-group">
                  <label for="inputEstimatedBudget">No. Ijazah</label>
                  <input type="text" class="form-control" value="<?=$pendaftaran['no_ijazah']?>" disabled>
                </div>
                <?php
              }
               ?>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php if ($nilai[0] != 401){ ?>
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Data Nilai Rapot</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
              foreach ($nilai as $_nilai) {
                ?>
                <h4>Semester <?=$_nilai['semester']?></h4>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">Bahasa Indonesia</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_indonesia']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">Matematika</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_mtk']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">IPS</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_ips']?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">Bahasa Inggris</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_inggris']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">IPA</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_ipa']?>" disabled>
                    </div>
                    <div class="col-md-4">
                      <label for="inputEstimatedBudget">PAI</label>
                      <input type="text" class="form-control" value="<?=$_nilai['nilai_pai']?>" disabled>
                    </div>
                  </div>
                </div>
                <?php
              }
               ?>
            </div>
            <!-- /.card-body -->
          </div>
            <?php
          }
          ?>
          <!-- /.card -->
        </div>
      </div>
    </div>
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
<script src="<?=base_url()?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url()?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url()?>/assets/dist/js/pages/dashboard.js"></script>
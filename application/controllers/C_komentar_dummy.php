<?php
/******************************************
* Filename    : C_komentar.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-06-01
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk sesi komentar
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_komentar extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		// $this->API = api_url();
		$this->API = api_url();
		date_default_timezone_set('Asia/Jakarta');
		// $this->API=decrypt_url($this->session->userdata('api'));

		// $this->API="http://localhost:55620/api";
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
		$data['halaman'] = 'home';
		$data['yang_lalu'] = $this->time_elapsed_string("2020-05-31");
		$data['login'] = 'true';
		if (!is_null($this->session->userdata('data_login')) && !is_null($this->session->userdata('token'))){
			$login['where'] = array(
				'u' => $this->session->userdata('data_login')['username'],
				'p' => $this->session->userdata('data_login')['password']
			);
			$result = json_decode($this->curl->simple_get($this->API.'get_admin', $login, array(CURLOPT_BUFFERSIZE => 10)), true)[0];
			// print_r($result);
			if($result != 401){
				$token = explode(' ',decrypt_url($result['token']))[0];
				if($token == decrypt_url($this->session->userdata('token'))){
					$this->session->set_userdata(['id_user_login'=>encrypt_url('-1')]);
					$this->load->view('content/kokom', $data);
				}else{
					redirect(base_url('C_login'));
				}
			}else{
				redirect(base_url('C_login'));
			}
		}else{
			redirect(base_url('C_login'));
		}
	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'tahun',
			'm' => 'bulan',
			'w' => 'minggu',
			'd' => 'hari',
			'h' => 'jam',
			'i' => 'menit',
			's' => 'detik',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
	}

	function set_suka(){
		if (isset($_GET['id']) && isset($_GET['jenis'])){
			$filedata['data'] = array(
				'id_user' => decrypt_url($this->session->userdata('id_user_login')),
				'id_post' => $_GET['id'],
				'jenis'   => $_GET['jenis']
			);
			$insert =  $this->curl->simple_post($this->API.'sosmed_set_suka', $filedata, array(CURLOPT_BUFFERSIZE => 0));
			echo "";
		}
	}

	function del_suka(){
		if (isset($_GET['id']) && isset($_GET['jenis'])){
			$filedata = array(
				'id_user' => $this->session->userdata('id_user_login'),
				'id_post' => encrypt_url($_GET['id']),
				'jenis'   => $_GET['jenis']
			);
			$delete =  $this->curl->simple_delete($this->API.'sosmed_set_suka', $filedata, array(CURLOPT_BUFFERSIZE => 10));
			if($delete)
			{
				$this->session->set_flashdata('hasil','Delete Data Berhasil');
			}else
			{
				$this->session->set_flashdata('hasil','Delete Data Gagal');
			}
			echo "";
		}
	}

	function set_notif(){
		if (isset($_GET['id']) && isset($_GET['jenis'])){
			$where['where'] = array(
				'id_post' => $_GET['id'],
				'jenis'   => $_GET['jenis']
			);
			$postingan = json_decode($this->curl->simple_get($this->API.'sosmed_get_'.$_GET['jenis'], $where, array(CURLOPT_BUFFERSIZE => 10)), true);
			if ($postingan['id_user'] != decrypt_url($this->session->userdata('id_user_login'))){
				$filedata['data'] = array(
					'id_user_kirim' => decrypt_url($this->session->userdata('id_user_login')),
					'id_post' 	 	=> $_GET['id'],
					'notifikasi'	=> $_GET['notif'],
					'jenis'   	 	=> $_GET['jenis']
				);
				$insert =  $this->curl->simple_post($this->API.'sosmed_set_notifikasi', $filedata, array(CURLOPT_BUFFERSIZE => 0));
			}
			echo "";
		}
	}

	function del_notif(){
		if (isset($_GET['id']) && isset($_GET['jenis'])){
			$filedata = array(
				'id_user_kirim' => '-1',
				'id_post' 	 	=> encrypt_url($_GET['id']),
				'jenis'   	 	=> $_GET['jenis'],
				'notifikasi' 	=> $_GET['notif']
			);
			$delete =  $this->curl->simple_delete($this->API.'sosmed_set_notifikasi', $filedata, array(CURLOPT_BUFFERSIZE => 10));
			if($delete)
			{
				$this->session->set_flashdata('hasil','Delete Data Berhasil');
			}else
			{
				$this->session->set_flashdata('hasil','Delete Data Gagal');
			}
			echo "";
		}
	}

	function set_komentar(){
		if (isset($_POST['komentar']) || $_FILES['file']["name"] != ''){
			$path = "";
			if ($_FILES['file']["name"] != ''){
				$path = $_FILES['file']["name"];
				$jenis = pathinfo($path, PATHINFO_EXTENSION);
				$nama_file = date("Y-m-d_h-i-sa").'-komentar-'.encrypt_url($this->session->userdata('id_user_login')).'.'.$jenis;

				$fotoid = './assets/kokom/'.$nama_file;
				move_uploaded_file($_FILES['file']['tmp_name'],$fotoid);

				$path = base_url().'/assets/kokom/'.$nama_file;
			}
			$filedata['data'] = array(
				'id_user' 	=> '-1',
				'komentar'  => $_POST['komentar'],
				'gambar'  	=> $path
			);
			$insert =  $this->curl->simple_post($this->API.'sosmed_set_komentar', $filedata, array(CURLOPT_BUFFERSIZE => 0));
			print_r($insert);
		}
	}

	function set_edit_komentar(){
		if (isset($_POST['edit_komentar']) || $_FILES['file']["name"] != ''){
			print_r($_POST);
			$path = "";
			$filedata['where'] = array(
				'id' => $_POST['id']
			);
			if ($_FILES['file']["name"] != ''){
				$path = $_FILES['file']["name"];
				$jenis = pathinfo($path, PATHINFO_EXTENSION);
				$nama_file = date("Y-m-d_h-i-sa").'-komentar-'.encrypt_url($this->session->userdata('id_user_login')).'.'.$jenis;

				$fotoid = './assets/kokom/'.$nama_file;
				move_uploaded_file($_FILES['file']['tmp_name'],$fotoid);

				$path = base_url().'/assets/kokom/'.$nama_file;

				$filedata['data'] = array(
					'gambar' => $path
				);
				$update =  $this->curl->simple_put($this->API.'sosmed_set_komentar', $filedata, array(CURLOPT_BUFFERSIZE => 10));
			}
			$filedata['data'] = array(
				'komentar' => $_POST['edit_komentar']
			);
			$update =  $this->curl->simple_put($this->API.'sosmed_set_komentar', $filedata, array(CURLOPT_BUFFERSIZE => 10));
			print_r($update);
		}
	}

	function del_komentar($id){
		if(empty($id)){
			redirect('C_komentar');
		}else{
			$delete =  $this->curl->simple_delete($this->API.'sosmed_del_komentar', array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10));
			if($delete)
			{
				$this->session->set_flashdata('hasil','Delete Data Berhasil');
			}else
			{
				$this->session->set_flashdata('hasil','Delete Data Gagal');
			}
			redirect('C_komentar');
		}
	}

	function set_edit_balasan(){
		if ((isset($_POST['edit_balasan']) || $_FILES["file"]["name"] != '') && isset($_POST['id'])){
			$path = "";

			$filedata['where'] = array(
				'id'=> $_POST['id']
			);
			if ($_FILES['file']["name"] != ''){
				$path = $_FILES['file']["name"];
				echo "masukkk";
				$jenis = pathinfo($path, PATHINFO_EXTENSION);
				$nama_file = date("Y-m-d_h-i-sa").'-komentar-'.encrypt_url($this->session->userdata('id_user_login')).'.'.$jenis;

				$fotoid = './assets/kokom/'.$nama_file;
				move_uploaded_file($_FILES['file']['tmp_name'],$fotoid);

				$path = base_url().'/assets/kokom/'.$nama_file;

				print_r($path);
				$filedata['data'] = array(
					'gambar'=>$path
				);
				$update =  $this->curl->simple_put($this->API.'sosmed_set_balasan', $filedata, array(CURLOPT_BUFFERSIZE => 0));
			}
			$filedata['data'] = array(
				'balasan'=> $_POST['edit_balasan']
			);
			$update =  $this->curl->simple_put($this->API.'sosmed_set_balasan', $filedata, array(CURLOPT_BUFFERSIZE => 0));

			print_r($update);
		}
	}

	function set_balasan(){
		if ((isset($_POST['balasan']) || $_FILES["file"]["name"] != '') && isset($_POST['id'])){
			$path = "";
			if ($_FILES['file']["name"] != ''){
				$path = $_FILES['file']["name"];
				echo "masukkk";
				$jenis = pathinfo($path, PATHINFO_EXTENSION);
				$nama_file = date("Y-m-d_h-i-sa").'-balasan-'.encrypt_url($this->session->userdata('id_user_login')).'.'.$jenis;

				$fotoid = './assets/kokom/'.$nama_file;
				move_uploaded_file($_FILES['file']['tmp_name'],$fotoid);

				$path = base_url().'/assets/kokom/'.$nama_file;

				print_r($path);
			}
			$filedata['data'] = array(
				'id_user' 		=> '-1',
				'id_komentar'  	=> $_POST['id'],
				'balasan'  		=> $_POST['balasan'],
				'gambar'  		=> $path
			);
			$insert =  $this->curl->simple_post($this->API.'sosmed_set_balasan', $filedata, array(CURLOPT_BUFFERSIZE => 0));
			print_r($insert);
		}
	}

	function del_balasan($id){
		if(empty($id)){
			redirect('C_komentar');
		}else{
			$delete =  $this->curl->simple_delete($this->API.'sosmed_del_balasan', array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10));
			if($delete)
			{
				$this->session->set_flashdata('hasil','Delete Data Berhasil');
			}else
			{
				$this->session->set_flashdata('hasil','Delete Data Gagal');
			}
			redirect('C_komentar');
		}
	}

	function get_komentar(){
		$client_url = "http://localhost/ppdb_man_1_cianjur/client/";
		// $client_url = "https://ppdb-man-1-cianjur.com/";
		if (isset($_GET['offset']) && isset($_GET['limit'])){
			$offset = $_GET['offset'];
			$limit = $_GET['limit'];
			$login = $_GET['login'];

			// connection to API
			$komentar = json_decode($this->curl->simple_get($this->API.'sosmed_get_all_komentar', array('limit'=>$limit, 'offset'=>$offset), array(CURLOPT_BUFFERSIZE => 10)), true);
			// print_r($komentar);
			if ($komentar[0] != 401){
				foreach ($komentar as $kom) {
					echo '
					<div class="card card-body" style="margin-top:20px;">
						<div class="row" style="margin-bottom:20px;">
							<div class="col-md-12">
								<div id="komentar'.$kom['id'].'">
								<img src="';
								$user  = json_decode($this->curl->simple_get($this->API.'get_user', array('where'=>['id'=>$kom['id_user']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
								$siswa = json_decode($this->curl->simple_get($this->API.'get_siswa', array('where'=>['id'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
								$file  = json_decode($this->curl->simple_get($this->API.'get_file', array('where'=>['id_user'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
								if ($kom['id_user'] < 0){
									echo 'http://ppdb-man-1-cianjur.com/assets/images/avatar5.png';
								}else
								if ($file == 401 || is_null($file['path'])){
									echo 'https://image.ibb.co/jw55Ex/def_face.jpg';
								}else{
									echo $client_url.decrypt_url($file['path']);
								}
								echo '" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/>
								<div class="float-left" style="margin-left:10px;">
									<strong>';
									if ($kom['id_user'] < 0){
										echo '<span class="text-primary">Admin</span>';
									}else
									if ($siswa == 401){
										echo 'unknown';
									}else{
										echo $siswa['nama'];
									}
									$yang_lalu = $this->time_elapsed_string($kom['tanggal_komentar']);
									echo '</strong>
									<div class="text-secondary" style="font-size:10px;" id="tgl">'.$yang_lalu.'</div>
								</div>
								<div class="float-right dropdown">
									<a href="#" id="dropdown-a" data-toggle="dropdown"><i class="fa fa-pencil-square-o"></i></a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-a">
										<a class="dropdown-item" data-toggle="modal" href="#" data-target="#modalEditKomentar'.$kom['id'].'">Edit</a>
										<a class="dropdown-item" data-toggle="modal" href="#" data-target="#modalHapusKomentar'.$kom['id'].'">Hapus</a>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
								<p class="mt-2">'.$kom['komentar'].'</p>
								<div align="center" class="mb-2" '; if($kom['gambar'] == ""){ echo 'hidden'; } echo '>
									<a href="#" data-toggle="modal" data-target="#modalGambarKomentar'.$kom['id'].'">
										<img src="'.$kom['gambar'].'" alt="" class="img-fluid" style="display:block;">
									</a>
								</div>
								<div>
									<a class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#modal';
									if($login == "true"){
										echo 'Balasan'.$kom['id'];
									}else{
										echo 'Login';
									}
									echo '"> <i class="fa fa-reply"></i> Balas</a>
									<a class="float-right btn ';
									$suka_kom = json_decode($this->curl->simple_get($this->API.'sosmed_get_suka', array('where'=>['id_post'=>$kom['id'], 'jenis'=>'komentar']), array(CURLOPT_BUFFERSIZE => 10)), true);
									if($login == "true"){
										$cek = 0;
										if ($suka_kom[0] != 401){
											foreach($suka_kom as $suka_aja){
												if($suka_aja['id_user'] == decrypt_url($this->session->userdata('id_user_login'))){
													$cek = 1;
													echo 'btn-danger text-white" id="suka_komentar'.$kom['id'].'" onclick=\'tidak_suka('.$kom['id'].',"komentar")\'';
												}
											}
										}
										if ($cek == 0){
											echo 'btn-outline-danger" id="suka_komentar'.$kom['id'].'" onclick=\'suka('.$kom['id'].',"komentar")\'';
										}
									}else{
										echo 'btn-outline-danger" id="suka_komentar'.$kom['id'].'" style="color:black;" data-toggle="modal" data-target="#modalLogin"';
									}
									echo '> <i class="fa fa-heart"></i> Suka </a>';
									if($suka_kom[0] != 401){
										echo '<a class="float-right btn text-black btn-link" style="display:block;" id="jml_suka_komentar'.$kom['id'].'" data-toggle="modal" data-target="#modal';
										if($login == "true"){
											echo 'Menyukai'.$kom['id'];
										}else{
											echo 'Login';
										}
										echo '"><span id="angka_suka_komentar'.$kom['id'].'">'.count($suka_kom).'</span> Menyukai</a>';
									}else{
										echo '<a class="float-right btn text-black btn-link disabled" style="display:none;" id="jml_suka_komentar'.$kom['id'].'"><span id="angka_suka_komentar'.$kom['id'].'">0</span> Menyukai</a>';
									}
									echo '
								</div>
							</div>
						</div>
						<!-- Modal menyukai -->
						<div class="modal fade" id="modalMenyukai'.$kom['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalMenyukaiTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="modalMenyukaiTitle"><b><span id="angka_suka_komentar'.$kom['id'].'">'.count($suka_kom).'</span> Menyukai</b></h3>
										<button type="button" id="close_menyukai'.$kom['id'].'" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body overflow-like">
										<ul class="list-group list-group-flush">';
											foreach($suka_kom as $like_kom){
												$user  = json_decode($this->curl->simple_get($this->API.'get_user', array('where'=>['id'=>$like_kom['id_user']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
												$siswa = json_decode($this->curl->simple_get($this->API.'get_siswa', array('where'=>['id'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
												$file  = json_decode($this->curl->simple_get($this->API.'get_file', array('where'=>['id_user'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];

												if ($like_kom['id_user'] < 0){
													echo '<li class="list-group-item">
													<table>
														<tr class="d-flex align-items-center">
															<td><div><img src="http://ppdb-man-1-cianjur.com/assets/images/avatar5.png" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/></div></td>
															<td><div class="ml-3 mt-auto mb-auto"><b class="text-primary">Admin PPDB</b></div></td>
														</tr>
													</table></li>';
												}else{
													echo '<li class="list-group-item">
													<table>
														<tr class="d-flex align-items-center">
															<td><div><img src="'.base_url().decrypt_url($file['path']).'" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/></div></td>
															<td><div class="ml-3"><b>'.$siswa['nama'].'</b></div></td>
														</tr>
													</table></li>';
												}
											}
										echo
										'</ul>
									</div>
									<!-- start button -->
									<div class="modal-footer">
										<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Kembali</button>
									</div>
									<!-- end button -->
								</div>
							</div>
						</div>
						<!-- End modal menyukai -->
						<!-- Modal Balasan -->
						<div class="modal fade" data-keyboard="false" data-backdrop="static" id="modalBalasan'.$kom['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalBalasanTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="modalBalasanTitle"><b>Balasan</b></h3>
										<button type="button" id="close_balasan'.$kom['id'].'" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="form-group">
												<label for="tulis-balasan">Tulis Balasan:</label>
												<textarea class="editor" id="balasan'.$kom['id'].'" name="balasan'.$kom['id'].'" placeholder="Tulis Balasan..."></textarea>
												<label for="foto" class="mt-4">Upload Gambar:</label>
												<input type="file" class="form-control-file" name="gbr_balasan'.$kom['id'].'" id="gbr_balasan'.$kom['id'].'" accept="image/jpeg, image/png" aria-describedby="fileHelp">
											</div>
										</form>
									</div>
									<!-- start button -->
									<div class="modal-footer" id="kirim_balasan'.$kom['id'].'">
										<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Batalkan</button>
										<button type="button" class="btn btn-info float-right" onclick="kirim('.$kom['id'].',\'balasan\')">Kirim</button>
									</div>
									<div class="modal-footer container" id="mengirim_balasan'.$kom['id'].'" style="display:none;">
										<button type="button" class="btn btn-info float-right" disabled>
											<div class="row justify-content-md-center">
												<div class="col-md-7">
													Mengirimkan
												</div>
												<div class="col-md-3">
													<div class="spinner" role="status">
														<div class="double-bounce1"></div>
														<div class="double-bounce2"></div>
													</div>
												</div>
											</div>
										</button>
									</div>
									<!-- end button -->
								</div>
							</div>
						</div>
						<!-- End modal balasan -->
						<!-- Modal Edit komentar -->
						<div class="modal fade" data-keyboard="false" data-backdrop="static" id="modalEditKomentar'.$kom['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="modalEditTitle"><b>Edit</b></h3>
										<button type="button" id="close_edit_komentar'.$kom['id'].'" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form>
											<div class="form-group">
												<textarea class="editor" id="edit_komentar'.$kom['id'].'">'.$kom['komentar'].'</textarea>
												<div class="mt-4">
													<label for="foto">Ganti Gambar:</label>
													<input type="file" class="form-control-file" name="gbr_edit_komentar'.$kom['id'].'" id="gbr_edit_komentar'.$kom['id'].'" onchange="gbr_upload('.$kom['id'].')" accept="image/jpeg, image/png" aria-describedby="fileHelp">
												</div>
											</div>
										</form>
									</div>
									<!-- start button -->
									<div class="modal-footer" id="kirim_edit_komentar'.$kom['id'].'">
										<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Batalkan</button>
										<button type="button" class="btn btn-info float-right" onclick="kirim('.$kom['id'].',\'edit_komentar\')">Kirim</button>
									</div>
									<div class="modal-footer container" id="mengirim_edit_komentar'.$kom['id'].'" style="display:none;">
										<button type="button" class="btn btn-info float-right" disabled>
											<div class="row justify-content-md-center">
												<div class="col-md-7">
													Mengirimkan
												</div>
												<div class="col-md-3">
													<div class="spinner" role="status">
														<div class="double-bounce1"></div>
														<div class="double-bounce2"></div>
													</div>
												</div>
											</div>
										</button>
									</div>
									<!-- end button -->
								</div>
							</div>
						</div>
						<!-- End Modal edit komentar -->
						<!-- Modal Hapus Komentar -->
						<div class="modal fade" id="modalHapusKomentar'.$kom['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalHapusTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="modalHapusTitle">Anda yakin ingin menghapusnya?</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<a href="'.base_url("c_komentar").'/del_komentar//'.encrypt_url($kom['id']).'" class="btn btn-outline-primary float-right ml-2">Iya</a>
										<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Tidak</button>
									</div>
								</div>
							</div>
						</div>
						<!-- End Modal Hapus Komentar -->
						<!-- Modal Gambar Komentar -->
						<div class="modal fade" id="modalGambarKomentar'.$kom['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalGambarTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="modal-title" id="modalGambarTitle"><b>Lihat Gambar</b></h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body" align="center">
										<img src="'.$kom['gambar'].'" alt="" class="img-fluid" style="display:block;">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Keluar</button>
										<a href="#" class="btn btn-info float-right" download="'.$kom['gambar'].'">Simpan</a>
									</div>
								</div>
							</div>
						</div>
						<!-- End Modal Gambar Komentar -->';
						//=============================== Looping balasan ===============================
						$balasan = json_decode($this->curl->simple_get($this->API.'sosmed_get_balasan', array('where'=>['id_komentar'=>$kom['id']]), array(CURLOPT_BUFFERSIZE => 10)), true);
						if ($balasan[0] != 401){
							foreach ($balasan as $balas) {
								echo '
						<!-- Start inner card -->
						<div class="card card-inner bg-light mb-2">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div>
											<img src="';
											$user  = json_decode($this->curl->simple_get($this->API.'get_user', array('where'=>['id'=>$balas['id_user']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
											$siswa = json_decode($this->curl->simple_get($this->API.'get_siswa', array('where'=>['id'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
											$file  = json_decode($this->curl->simple_get($this->API.'get_file', array('where'=>['id_user'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
											if ($balas['id_user'] < 0){
												echo 'http://ppdb-man-1-cianjur.com/assets/images/avatar5.png';
											}else
											if ($file == 401 || is_null($file['path'])){
												echo 'https://image.ibb.co/jw55Ex/def_face.jpg';
											}else{
												echo $client_url.decrypt_url($file['path']);
											}
											echo '" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/>
											<div class="float-left" style="margin-left:10px;">
												<strong>';
													if ($balas['id_user'] < 0){
														echo '<span class="text-primary">Admin</span>';
													}else
													if ($siswa == 401){
														echo 'unknown';
													}else{
														echo $siswa['nama'];
													}
													$yang_lalu = $this->time_elapsed_string($balas['tanggal_balasan']);
													echo '
												</strong>
												<div class="text-secondary" style="font-size:10px;">'.$yang_lalu.'</div>
											</div>
											<div class="float-right dropdown">
											<a href="#" id="dropdown-a" data-toggle="dropdown"><i class="fa fa-pencil-square-o"></i></a>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-a">
													<a class="dropdown-item" data-toggle="modal" href="#" data-target="#modalEditBalasan'.$balas['id'].'">Edit</a>
													<a class="dropdown-item" data-toggle="modal" href="#" data-target="#modalHapusBalasan'.$balas['id'].'">Hapus</a>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										<p class="mt-2">'.$balas['balasan'].'</p>
										<div align="center" class="mb-2" '; if($balas['gambar'] == ""){ echo 'hidden'; } echo '>
											<a href="#" data-toggle="modal" data-target="#modalGambarBalasan'.$balas['id'].'">
												<img src="'.$balas['gambar'].'" alt="" class="img-fluid" style="display:block;">
											</a>
										</div>
										<!-- <a class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#modal'; if($login == "true"){ echo 'Balasan'; }else{ echo 'Login'; } echo '"> <i class="fa fa-reply"></i> Balas</a> -->
										<a class="float-right btn text-black ';
										$suka_balas = json_decode($this->curl->simple_get($this->API.'sosmed_get_suka', array('where'=>['id_post'=>$balas['id'], 'jenis'=>'balasan']), array(CURLOPT_BUFFERSIZE => 10)), true);
										if($login == "true"){
											$cek = 0;
											if ($suka_balas[0] != 401){
												foreach($suka_balas as $suka_aja){
													if($suka_aja['id_user'] == decrypt_url($this->session->userdata('id_user_login'))){
														$cek = 1;
														echo 'btn-danger text-white" id="suka_balasan'.$balas['id'].'" onclick=\'tidak_suka('.$balas['id'].',"balasan")\'';
													}
												}
											}
											if ($cek == 0){
												echo 'btn-outline-danger" id="suka_balasan'.$balas['id'].'" onclick=\'suka('.$balas['id'].',"balasan")\'';
											}
										}else{
											echo 'btn-outline-danger" id="suka_balasan'.$balas['id'].'" style="color:black;" data-toggle="modal" data-target="#modalLogin"';
										}
										echo '> <i class="fa fa-heart"></i> Suka</a>';
										if($suka_balas[0] != 401){
											echo '<a class="float-right btn text-black btn-link" style="display:block;" id="jml_suka_balasan'.$balas['id'].'" data-toggle="modal" data-target="#modal';
											if($login == "true"){
												echo 'MenyukaiBalasan'.$balas['id'];
											}else{
												echo 'Login';
											}
											echo '"><span id="angka_suka_balasan'.$balas['id'].'">'.count($suka_balas).'</span> Menyukai</a>';
										}else{
											echo '<a class="float-right btn text-black btn-link disabled" style="display:none;" id="jml_suka_balasan'.$balas['id'].'"><span id="angka_suka_balasan'.$balas['id'].'">0</span> Menyukai</a>';
										}
											echo '
									</div>
								</div>
								<!-- Modal menyukai balasan -->
								<div class="modal fade" id="modalMenyukaiBalasan'.$balas['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalMenyukaiBalasanTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="modalMenyukaiBalasanTitle"><b><span id="angka_suka_balasan'.$balas['id'].'">'.count($suka_balas).'</span> Menyukai</b></h3>
												<button type="button" id="close_menyukai'.$balas['id'].'" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body overflow-like">
												<ul class="list-group list-group-flush">';
													foreach($suka_balas as $like_balas){
														$user  = json_decode($this->curl->simple_get($this->API.'get_user', array('where'=>['id'=>$like_balas['id_user']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
														$siswa = json_decode($this->curl->simple_get($this->API.'get_siswa', array('where'=>['id'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
														$file  = json_decode($this->curl->simple_get($this->API.'get_file', array('where'=>['id_user'=>decrypt_url($user['id_user'])]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];

														if ($like_balas['id_user'] < 0){
															echo '<li class="list-group-item">
															<table>
																<tr class="d-flex align-items-center">
																	<td><div><img src="http://ppdb-man-1-cianjur.com/assets/images/avatar5.png" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/></div></td>
																	<td><div class="ml-3"><b class="text-primary">Admin PPDB</b></div></td>
																</tr>
															</table></li>';
														}else{
															echo '<li class="list-group-item">
															<table>
																<tr class="d-flex align-items-center">
																	<td><div><img src="'.base_url().decrypt_url($file['path']).'" onerror="this.onerror=null;this.src=\'https://image.ibb.co/jw55Ex/def_face.jpg\';" class="gambar-bulat float-left rounded-circle"/></div></td>
																	<td><div class="ml-3"><b>'.$siswa['nama'].'</b></div></td>
																</tr>
															</table></li>';
														}
													}
												echo
												'</ul>
											</div>
											<!-- start button -->
											<div class="modal-footer">
												<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Kembali</button>
											</div>
											<!-- end button -->
										</div>
									</div>
								</div>
								<!-- End modal menyukai balasan -->
								<!-- Modal Edit balasan -->
								<div class="modal fade" data-keyboard="false" data-backdrop="static" id="modalEditBalasan'.$balas['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="modalEditTitle"><b>Edit</b></h3>
												<button type="button" id="close_edit_balasan'.$balas['id'].'" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form>
													<div class="form-group">
														<textarea class="editor" id="edit_balasan'.$balas['id'].'">Lorem Ipsum</textarea>
														<div class="mt-4">
															<label for="foto" >Ganti Gambar:</label>
															<input type="file" class="form-control-file" name="gbr_edit_balasan'.$balas['id'].'" id="gbr_edit_balasan'.$balas['id'].'" onchange="gbr_upload('.$balas['id'].')" accept="image/jpeg, image/png" aria-describedby="fileHelp">
														</div>
													</div>
												</form>
											</div>
											<!-- start button -->
											<div class="modal-footer" id="kirim_edit_balasan'.$balas['id'].'">
												<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Batalkan</button>
												<button type="button" class="btn btn-info float-right" onclick="kirim('.$balas['id'].',\'edit_balasan\')">Kirim</button>
											</div>
											<div class="modal-footer container" id="mengirim_edit_balasan'.$balas['id'].'" style="display:none;">
												<button type="button" class="btn btn-info float-right" disabled>
													<div class="row justify-content-md-center">
														<div class="col-md-7">
															Mengirimkan
														</div>
														<div class="col-md-3">
															<div class="spinner" role="status">
																<div class="double-bounce1"></div>
																<div class="double-bounce2"></div>
															</div>
														</div>
													</div>
												</button>
											</div>
											<!-- end button -->
										</div>
									</div>
								</div>
								<!-- End Modal edit balasan -->
								<!-- Modal Hapus Balasan -->
								<div class="modal fade" id="modalHapusBalasan'.$balas['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalHapusTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="modalHapusTitle">Anda yakin ingin menghapusnya?</h3>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<a href="'.base_url("c_komentar").'/del_balasan//'.encrypt_url($balas['id']).'" class="btn btn-outline-primary float-right ml-2">Iya</a>
												<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Tidak</button>
											</div>
										</div>
									</div>
								</div>
								<!-- End Modal Hapus Balasan -->
								<!-- Modal Gambar Balasan -->
								<div class="modal fade" id="modalGambarBalasan'.$balas['id'].'" tabindex="-1" role="dialog" aria-labelledby="modalGambarTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h3 class="modal-title" id="modalGambarTitle"><b>Lihat Gambar</b></h3>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body" align="center">
												<img src="'.$balas['gambar'].'" alt="" class="img-fluid" style="display:block;">
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">Keluar</button>
												<a href="#" class="btn btn-info float-right" download="'.$balas['gambar'].'">Download</a>
											</div>
										</div>
									</div>
								</div>
								<!-- End Modal Gambar Balasan -->
							</div>
						</div>
						<!-- End Inner Card -->';
						}

							}
							echo '
						<div class="card-footer">
							<a href="#" class="btn btn-outline-info btn-block" data-toggle="modal" data-target="#modal';
							if($login == "true"){
								echo 'Balasan'.$kom['id'];
							}else{
								echo 'Login';
							}
							echo '">Tulis Balasan</a>
						</div>
					</div>
					<!-- End modal Body -->';
				}

			}else{
				echo "";

			}
		}
	}
}

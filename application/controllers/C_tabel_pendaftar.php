<?php
/******************************************
* Filename    : C_data_pendaftar.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk halaman tabel data pendaftar
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('./vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class C_tabel_pendaftar extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
		ini_set('max_execution_time', '0'); // for infinite time of execution
		// $this->API = 'http://localhost/ppdb_man_1_cianjur/service/';
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
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
					$data['halaman'] = 'tabel_pendaftar';
					$admin['username'] 	 = encrypt_url($this->session->userdata('data_login')['username']);
					$admin['password'] 	 = encrypt_url($this->session->userdata('data_login')['password']);
					$data['siswa'] 		 = json_decode($this->curl->simple_get($this->API.'get_all_siswa', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['user'] 		 = json_decode($this->curl->simple_get($this->API.'get_all_user', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					$tmp['last']		 = $data['siswa'][count($data['siswa'])-1]['id'];
					$data['username']	 = encrypt_url($this->session->userdata('data_login')['username']);
					// $data['link'] = 'http://localhost/ppdb_man_1_cianjur/client/';
					$data['link'] = 'https://ppdb.man1cianjur.com/';
					$data['pendaftaran'] = json_decode($this->curl->simple_get($this->API.'get_all_pendaftaran', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['file']		 = json_decode($this->curl->simple_get($this->API.'get_all_file', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					// $data['link'] = 'https://ppdb-man-1-cianjur.com/';

					if (is_null($this->session->userdata('last'))){
						$data['nilai']		 = [];
						foreach ($data['siswa'] as $_siswa) {
							$where['where'] = array('id_user' => $_siswa['id']);
							$nilai = json_decode($this->curl->simple_get($this->API.'get_nilai', $where, array(CURLOPT_BUFFERSIZE => 10)), true);
							$hasil = 0;
							if ($nilai[0] != 401){
								foreach ($nilai as $_nilai) {
									$hasil += $_nilai['nilai_inggris'];
									$hasil += $_nilai['nilai_indonesia'];
									$hasil += $_nilai['nilai_mtk'];
									$hasil += $_nilai['nilai_ipa'];
									$hasil += $_nilai['nilai_ips'];
									$hasil += $_nilai['nilai_pai'];
								}
							}
							$data['nilai'] = array_merge($data['nilai'], array(['id_user' => $_siswa['id'], 'nilai' => $hasil]));
						}
						// $admin['where'] = array(
						// 	'username' => encrypt_url($this->session->userdata('data_login')['username']),
						// 	'password' => encrypt_url($this->session->userdata('data_login')['password'])
						// );
						// $data['user'] = json_decode($this->curl->simple_get($this->API.'get_all_user', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
						$tmp['tbl_sess'] = $data;
						$this->session->set_userdata($tmp);
					}else
					if ($this->session->userdata('last') != $tmp['last']){
						$data['nilai'] = $this->session->userdata('tbl_sess')['nilai'];
						foreach ($data['siswa'] as $_siswa) {
							if ($_siswa['id'] > $this->session->userdata('last')){
								$where['where'] = array('id_user' => $_siswa['id']);
								$nilai = json_decode($this->curl->simple_get($this->API.'get_nilai', $where, array(CURLOPT_BUFFERSIZE => 10)), true);
								$hasil = 0;
								if ($nilai[0] != 401){
									foreach ($nilai as $_nilai) {
										$hasil += $_nilai['nilai_inggris'];
										$hasil += $_nilai['nilai_indonesia'];
										$hasil += $_nilai['nilai_mtk'];
										$hasil += $_nilai['nilai_ipa'];
										$hasil += $_nilai['nilai_ips'];
										$hasil += $_nilai['nilai_pai'];
									}
								}
								$data['nilai'] = array_merge($data['nilai'], array(['id_user' => $_siswa['id'], 'nilai' => $hasil]));
							}
						}
						$tmp['tbl_sess'] = $data;
						$this->session->set_userdata($tmp);
					}else{
						$data['nilai'] = $this->session->userdata('tbl_sess')['nilai'];
						// $data['user'] 			 = $this->session->userdata('tbl_sess')['user'];
						// print_r($this->session->userdata('tbl_sess'));
					}

					$this->load->view('headfoot/header_login', $data);
					$this->load->view('headfoot/sidebar');
					$this->load->view('content/V_tabel_pendaftar');
					$this->load->view('headfoot/footer_login');
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

	function set_kelulusan(){
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
					$kelulusan['where'] = ['id_user' => $_POST['id']];
					$kelulusan['data'] 	= ['kelulusan' => $_POST['hasil']];
					$update =  $this->curl->simple_put($this->API.'set_pendaftaran', $kelulusan, array(CURLOPT_BUFFERSIZE => 0));
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

	function download_tbl($limit, $offset, $part){
		$admin = array(
			'username' => encrypt_url($this->session->userdata('data_login')['username']),
			'password' => encrypt_url($this->session->userdata('data_login')['password']),
			'limit'	   => $limit,
			'offset'   => $offset
		);
		$siswa = json_decode($this->curl->simple_get($this->API.'get_all_siswa_limit', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
		if ($siswa[0] != 401){
			// $this->load->library("excel");
			$object = new Spreadsheet();
	
			$object->createSheet(1);
			$object->setActiveSheetIndex(0);
	
			$table_columns = array(
				// tb_siswa
				"No. Peserta", "NIK", "NISN", "Nama", "Jenis Kelamin", "Agama", "Tempat Lahir", "Tanggal Lahir", "Hobi", "Cita-cita",
				"Alamat", "Provinsi", "Kabupaten", "Kecamatan", "Desa", "Kode Pos", "Jarak",
				"Transportasi", "Waktu Tempuh", "Status Anak", "Anak Ke", "Jumlah Saudara", "Tempat Tinggal", "Tinggi", "PAUD", "TK", "No HP", "KIP", "E-Mail",
	
				// tb_ortu
				"No. KK", "Kepala Keluarga", 
				"NIK Ayah", "Nama Ayah", "Tgl.Lahir Ayah", "Status Ayah", "Pendidikan Ayah", "Pekerjaan Ayah", "Penghasilan/Bulan",
				"NIK Ibu", "Nama Ibu","Tgl.Lahir Ibu", "Status Ibu", "Pendidikan Ibu", "Pekerjaan Ibu", "No HP Ortu",
				"Nama Wali", "Tgl.Lahir Wali", "NIK. Wali", "Pendidikan Wali", "Pekerjaan Wali", "Penghasilan Wali",
	
				// tb_pendaftaran
				"Jalur Daftar", "Tanggal Daftar", "Asal Sekolah", "Status Sekolah", "Alamat Sekolah", "Lokasi Sekolah", "NPSN", "Tahun Lulus",
				"No Ijazah", "Jurusan",
	
				// tb_nilai
				"Nilai Inggris Sms1", "Nilai Indonesia Sms1", "Nilai MTK Sms1", "Nilai IPA Sms1", "NIlai IPS Sms1", "Nilai PAI Sms1",
				"Nilai Inggris Sms2", "Nilai Indonesia Sms2", "Nilai MTK Sms2", "Nilai IPA Sms2", "NIlai IPS Sms2", "Nilai PAI Sms2",
				"Nilai Inggris Sms3", "Nilai Indonesia Sms3", "Nilai MTK Sms3", "Nilai IPA Sms3", "NIlai IPS Sms3", "Nilai PAI Sms3",
				"Nilai Inggris Sms4", "Nilai Indonesia Sms4", "Nilai MTK Sms4", "Nilai IPA Sms4", "NIlai IPS Sms4", "Nilai PAI Sms4",
				"Nilai Inggris Sms5", "Nilai Indonesia Sms5", "Nilai MTK Sms5", "Nilai IPA Sms5", "NIlai IPS Sms5", "Nilai PAI Sms5", "Nilai Total",
	
				// tb_prestasi
				"Nama Prestasi 1", "Tingkat Prestasi 1", "Bidang 1", "Tahun 1", "Kategori 1", "Prestasi 1", "Penyelenggara 1", "Tempat Lomba 1",
				"Nama Prestasi 2", "Tingkat Prestasi 2", "Bidang 2", "Tahun 2", "Kategori 2", "Prestasi 2", "Penyelenggara 2", "Tempat Lomba 2",
				"Nama Prestasi 3", "Tingkat Prestasi 3", "Bidang 3", "Tahun 3", "Kategori 3", "Prestasi 3", "Penyelenggara 3", "Tempat Lomba 3"
			);
	
			$column = 1;
	
			foreach($table_columns as $field){
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}
	
			$row = 2;
			$data['nilai']		 = [];
			foreach ($siswa as $_siswa) {
				$where['where'] = array('id_user' => $_siswa['id']);
				$user 			= json_decode($this->curl->simple_get($this->API.'get_user', $where, array(CURLOPT_BUFFERSIZE => 10)), true)[0];
				if ($user['tahap_daftar'] == 0){
					$nilai 			= json_decode($this->curl->simple_get($this->API.'get_nilai', $where, array(CURLOPT_BUFFERSIZE => 10)), true);
					$ayah 			= json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user' => $_siswa['id'], 'jenis' => 'ayah']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$ibu 			= json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user' => $_siswa['id'], 'jenis' => 'ibu']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$wali 			= json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user' => $_siswa['id'], 'jenis' => 'wali']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$prestasi 		= json_decode($this->curl->simple_get($this->API.'get_prestasi', $where, array(CURLOPT_BUFFERSIZE => 10)), true);
					$pendaftaran	= json_decode($this->curl->simple_get($this->API.'get_pendaftaran', $where, array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$provinsi		= json_decode($this->curl->simple_get($this->API.'get_provinsi', array('where'=>['id_prov'=>$_siswa['provinsi']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$kabupaten		= json_decode($this->curl->simple_get($this->API.'get_kabupaten', array('where'=>['id_kab'=>$_siswa['kabupaten']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$kecamatan		= json_decode($this->curl->simple_get($this->API.'get_kecamatan', array('where'=>['id_kec'=>$_siswa['kecamatan']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$desa			= json_decode($this->curl->simple_get($this->API.'get_desa', array('where'=>['id_kel'=>$_siswa['desa']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
	
					$jalur = '';
					if ($pendaftaran['jalur_daftar'] == 'prestasi'){
						$jalur = 'P';
					}else{
						$jalur = 'U';
					}
					$no_peserta = 'MAN-'.$pendaftaran['id'].$jalur;
		
					$column = 1;
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $no_peserta);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$_siswa['nik']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$_siswa['nisn']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['gender']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['agama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['tempat_lahir']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['tanggal_lahir']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['hobi']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['cita-cita']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['alamat']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $provinsi['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $kabupaten['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $kecamatan['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $desa['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['kode_pos']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['jarak']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['transportasi']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['waktu']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['status_anak']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['anak_ke']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['jumlah_sdr']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['tempat_tinggal']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['tinggi']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['paud']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['tk']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['no_hp']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['kip']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_siswa['email']);
		
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$ayah['no_kk']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$ayah['kepala_klg']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$ayah['nik']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['tanggal_lahir']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['status_ortu']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['pend']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['kerja']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['penghasilan']);
		
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$ibu['nik']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ibu['nama']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ibu['tanggal_lahir']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ibu['status_ortu']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ibu['pend']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ibu['kerja']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $ayah['no_hp']);
		
					if ($wali != 401){
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $wali['nama']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $wali['tanggal_lahir']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$wali['nik']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $wali['pend']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $wali['kerja']);
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $wali['penghasilan']);
					}else{
						for($c=0;$c<6;$c++){
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "-");
						}
					}
		
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['jalur_daftar']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['tgl_daftar']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['nama_sekolah']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['status_sekolah']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['alamat_sekolah']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['lokasi_sekolah']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$pendaftaran['npsn']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['thn_lulus']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, "'".$pendaftaran['no_ijazah']);
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $pendaftaran['jurusan']);
					$hasil 					= 0;
					foreach ($nilai as $_nilai) {
						$hasil += $_nilai['nilai_inggris'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_inggris']);
						$hasil += $_nilai['nilai_indonesia'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_indonesia']);
						$hasil += $_nilai['nilai_mtk'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_mtk']);
						$hasil += $_nilai['nilai_ipa'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_ipa']);
						$hasil += $_nilai['nilai_ips'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_ips']);
						$hasil += $_nilai['nilai_pai'];
						$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_nilai['nilai_pai']);
					}
		
					$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $hasil);
		
					if ($prestasi[0] != 401){
						foreach ($prestasi as $_prestasi) {
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['nama_prestasi']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['tingkat']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['bidang']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['tahun']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['kategori']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['prestasi']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['penyelenggara']);
							$object->getActiveSheet()->setCellValueByColumnAndRow($column++, $row, $_prestasi['tempat']);
						}
					}
		
					$row++;
				}
			}
			$object_writer = new Xls($object);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Data Pendaftaran Siswa Baru MAN 1 Cianjur part('.$part.').xls"');
			$object_writer->save('php://output');
			// $object_writer->save('Data Pendaftaran Siswa Baru MAN 1 Cianjur part('.$part.').xlsx');
		}
	}
}

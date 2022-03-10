<?php
/******************************************
* Filename    : C_lihat_data.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk melihat data pendaftar
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_lihat_data extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
		
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
					$data['halaman'] = 'tabel_pendaftar1';
					$data['login'] = 'false';
					// $data['link'] = 'http://localhost/ppdb_man_1_cianjur/client/';
					$data['link'] = 'https://ppdb.man1cianjur.com/';
					$id_user = explode("=", decrypt_url($_GET['token']));
					// Get data untuk dilihat
					$data['siswa'] = json_decode($this->curl->simple_get($this->API.'get_siswa', array('where'=>['id'=>$id_user[1]]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['provinsi'] = json_decode($this->curl->simple_get($this->API.'get_provinsi', array('where'=>['id_prov'=>$data['siswa']['provinsi']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['kabupaten'] = json_decode($this->curl->simple_get($this->API.'get_kabupaten', array('where'=>['id_kab'=>$data['siswa']['kabupaten']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['kecamatan'] = json_decode($this->curl->simple_get($this->API.'get_kecamatan', array('where'=>['id_kec'=>$data['siswa']['kecamatan']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['desa'] = json_decode($this->curl->simple_get($this->API.'get_desa', array('where'=>['id_kel'=>$data['siswa']['desa']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['file'] = json_decode($this->curl->simple_get($this->API.'get_file', array('where'=>['id_user'=>$data['siswa']['id']]), array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['nilai'] = json_decode($this->curl->simple_get($this->API.'get_nilai', array('where'=>['id_user'=>$data['siswa']['id']]), array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['ayah'] = json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user'=>$data['siswa']['id'], 'jenis' => 'ayah']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['ibu'] = json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user'=>$data['siswa']['id'], 'jenis' => 'ibu']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['wali'] = json_decode($this->curl->simple_get($this->API.'get_ortu', array('where'=>['id_user'=>$data['siswa']['id'], 'jenis' => 'wali']), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['pendaftaran'] = json_decode($this->curl->simple_get($this->API.'get_pendaftaran', array('where'=>['id_user'=>$data['siswa']['id']]), array(CURLOPT_BUFFERSIZE => 10)), true)[0];
					$data['prestasi'] = json_decode($this->curl->simple_get($this->API.'get_prestasi', array('where'=>['id_user'=>$data['siswa']['id']]), array(CURLOPT_BUFFERSIZE => 10)), true);

					$this->load->view('headfoot/header_login', $data);
					$this->load->view('headfoot/sidebar');
					$this->load->view('content/V_lihat_data');
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
}

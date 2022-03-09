<?php
/******************************************
* Filename    : C_home.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-21
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk halaman beranda
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_home extends CI_Controller {

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
		// $this->session->set_userdata(['api'=>encrypt_url($api)]);
		$data['halaman'] = 'home';
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
					$data['login'] = 'true';
					$this->session->set_userdata(['id_user_login'=>encrypt_url('-1')]);
					$admin['username'] 	 = encrypt_url($this->session->userdata('data_login')['username']);
					$admin['password'] 	 = encrypt_url($this->session->userdata('data_login')['password']);
					$admin['where'] = array(
						'username' => encrypt_url($this->session->userdata('data_login')['username']),
						'password' => encrypt_url($this->session->userdata('data_login')['password'])
					);
					$data['user'] = json_decode($this->curl->simple_get($this->API.'get_all_user', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['pendaftaran'] = json_decode($this->curl->simple_get($this->API.'get_all_pendaftaran', $admin, array(CURLOPT_BUFFERSIZE => 10)), true);
					$data['smp'] = 0;
					$data['mts'] = 0;
					$data['graf'] = array(
						'april_q1' => 0,
						'april_q2' => 0,
						'april_q3' => 0,
						'april_q4' => 0,
						'mei_q1' => 0,
						'mei_q2' => 0,
						'mei_q3' => 0,
						'mei_q4' => 0
					);
					foreach ($data['pendaftaran'] as $key) {
						if ($key['sekolah'] == 'smp'){
							$data['smp']++;
						}else
						if ($key['sekolah'] == 'mts'){
							$data['mts']++;
						}
						$bln = date("m", strtotime($key['tgl_daftar']));
						$tgl = date("d", strtotime($key['tgl_daftar']));
						if ($bln == 4){
							if (floor($tgl/7) == 0 || (floor($tgl/7) == 1 && $tgl%7 == 0)){
								$data['graf']['april_q1']++;
							}else
							if (floor($tgl/7) == 1 || (floor($tgl/7) == 2 && $tgl%7 == 0)){
								$data['graf']['april_q2']++;
							}else
							if (floor($tgl/7) == 2 || (floor($tgl/7) == 3 && $tgl%7 == 0)){
								$data['graf']['april_q3']++;
							}else
							if (floor($tgl/7) == 3){
								$data['graf']['april_q4']++;
							}
						}else
						if ($bln == 5){
							if (floor($tgl/7) == 0 || (floor($tgl/7) == 1 && $tgl%7 == 0)){
								$data['graf']['mei_q1']++;
							}else
							if (floor($tgl/7) == 1 || (floor($tgl/7) == 2 && $tgl%7 == 0)){
								$data['graf']['mei_q2']++;
							}else
							if (floor($tgl/7) == 2 || (floor($tgl/7) == 3 && $tgl%7 == 0)){
								$data['graf']['mei_q3']++;
							}else
							if (floor($tgl/7) == 3){
								$data['graf']['mei_q4']++;
							}
						}
					}

					$data['selesai'] = 0;
					foreach ($data['user'] as $user){
						if ($user['tahap_daftar'] == 0){
							$data['selesai']++;
						}
					}

					$data['smp'] = number_format(($data['smp']*100)/count($data['pendaftaran']),2,'.','');
					$data['mts'] = number_format(($data['mts']*100)/count($data['pendaftaran']),2,'.','');
					$data['tanggal'] = strtotime($data['pendaftaran'][0]['tgl_daftar']);
					$this->load->view('headfoot/header_login', $data);
					$this->load->view('headfoot/sidebar');
					$this->load->view('content/V_home');
					$this->load->view('headfoot/footer_login');
					// print_r(floor(date("d", $data['tanggal'])/7));
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

	function logout(){
		$this->session->sess_destroy();
    redirect(base_url('c_login'));
	}
}

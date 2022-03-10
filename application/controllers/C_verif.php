<?php
/******************************************
* Filename    : C_verif.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-22
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk verifikasi login admin
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_verif extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
		
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
		$data['u'] = $this->input->post('username');
		$data['p'] = $this->input->post('password');
		// print_r($data);
		$data['halaman'] = 'verif';
		if (!is_null($this->session->userdata('verif')) && $this->session->userdata('verif') == 'true'){
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
						redirect(base_url());
					}else{
						redirect(base_url('C_login'));
					}
				}else{
					redirect(base_url('C_login'));
				}
			}else{
				redirect(base_url('C_login'));
			}
		} else {
			if(is_null($this->session->userdata('verif'))){
				redirect(base_url('C_login'));
			}
			$this->load->view('content/V_verif', $data);
		}
	}

	function verif($u,$p,$token){
		$login['where'] = array(
			'u' => $u,
			'p' => $p
		);
		$result = json_decode($this->curl->simple_get($this->API.'get_admin', $login, array(CURLOPT_BUFFERSIZE => 10)), true)[0];
		$tmp = explode(' ',decrypt_url($result['token']))[0];
		// print_r($tmp);
		if ($token == $tmp){
			$data_login['data_login'] = array(
				'username' => $u,
				'password' => $p
			);
			$this->session->set_userdata($data_login);
			$this->session->set_userdata(['token'=>encrypt_url($token)]);
			$this->session->set_userdata(['verif'=>'true']);
			echo 1;
		}else{
			echo 0;
		}
	}
}

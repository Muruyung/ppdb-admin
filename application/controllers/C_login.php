<?php
/******************************************
* Filename    : C_login.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-02
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk login admin
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
		// $this->API = 'http://localhost/ppdb_man_1_cianjur/service/';
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
		// $this->session->set_userdata(['api'=>encrypt_url($api)]);
		// print_r($this->session->userdata());
		$data['halaman'] = 'login';
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
					$this->load->view('content/V_login', $data);
				}
			}else{
				$this->load->view('content/V_login', $data);
			}
		}else{
			$this->load->view('content/V_login', $data);
		}
	}

	function login($username, $password){
		$panjangacak = 6;
		$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$max=strlen($base)-1;
		$acak='';
		mt_srand((double)microtime()*1000000);

		while (strlen($acak)<$panjangacak) {
			$acak.=$base[mt_rand(0,$max)];
		}

		$data = array(
			'username'	=> $username,
			'password'	=> $password,
			'token'		=> $acak
		);
		$update =  json_decode($this->curl->simple_put($this->API.'set_admin', $data, array(CURLOPT_BUFFERSIZE => 10)), true);
		if ($update['status'] == 'success'){
			$login['where'] = array(
				'u' => $username,
				'p' => $password
			);
			$result = json_decode($this->curl->simple_get($this->API.'get_admin', $login, array(CURLOPT_BUFFERSIZE => 10)), true)[0];
			$email = explode(' ',decrypt_url($result['token']))[1];
			$this->load->config('email');
			$this->load->library('email');

			$from = $this->config->item('smtp_user');

			$this->email->set_newline("\r\n");
			$this->email->from($from);
			$this->email->to($email);
			$this->email->subject('Verifikasi Admin PPDB Online MAN 1 Cianjur');
			$this->email->message('Ini adalah kode verifikasi akun admin PPDB Online Anda:
Kode Verifikasi : '.$acak);
			// $sess['data_login'] = array(
			// 	'username' => encrypt_url($username),
			// 	'password' => encrypt_url($password)
			// );
			$send = $this->email->send();
			$sess['verif'] = "false";
			$this->session->set_userdata($sess);
			echo 1;
		}else{
			echo 0;
		}
	}

	function logout(){
		$this->session->sess_destroy();
    redirect('c_login');
	}
}

<?php
/******************************************
* Filename    : C_pemberitahuan.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-02
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk halaman cara pendaftaran
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_encrypt extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
		
	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
    $data = array(
      'admin' => encrypt_url('mansacjr'),
      ''
    );
		print_r($data);
	}
}

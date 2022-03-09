<?php
/******************************************
* Filename    : C_pemberitahuan.php
* Proggrammer : Robi Naufal Kaosar
* Date        : 2020-04-11
* E-Mail      : robinaufal11@upi.edu
* Deskripsi   : Controller untuk halaman tabel statistik
*
******************************************/
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba_email extends CI_Controller {

	var $API ="";

	function __construct() {
		parent::__construct();
		$this->API = api_url();
// 		$this->API = 'http://localhost/ppdb_man_1_cianjur/service/';

	}

	// proses yang akan di buka saat pertama masuk ke controller
	public function index()
	{
		$this->load->config('email');
		$this->load->library('email');

		$from = $this->config->item('smtp_user');

		$this->email->set_newline("\r\n");
		$this->email->from($from);
		$this->email->to('robinaufal11@gmail.com');
		$this->email->subject('test');
		$this->email->message('apawelah
hayolo');

		if ($this->email->send()) {
			echo 'Your Email has successfully been sent.';
		} else {
			show_error($this->email->print_debugger());
		}
	}
}

?>

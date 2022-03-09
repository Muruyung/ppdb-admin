<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('./vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends Spreadsheet
{
	public function __construct()
	{
		parent::__construct();
	}
}


?>
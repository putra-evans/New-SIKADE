<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of halkade class
 *
 * @author Yogi "solop" Kaputra
 */

class Haldprd extends SLP_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_haldprd' => 'mhaldprd'));
	}

	public function index()
	{
		$this->breadcrumb->add('Halaman DPRD', site_url('haldprd'));

		$this->session_info['page_name'] = "haldprd";
		$this->template->build('vhaldprd', $this->session_info);
	}
}

// This is the end of halkade clas

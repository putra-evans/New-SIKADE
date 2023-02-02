<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of halkade class
 *
 * @author Yogi "solop" Kaputra
 */

class Halkade extends SLP_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_halkade' => 'mhalkade'));
	}

	public function index()
	{
		$this->breadcrumb->add('Halaman Kepala Daerah', site_url('halkade'));

		$this->session_info['page_name'] = "halkade";
		$this->template->build('vhalkade', $this->session_info);
	}
}

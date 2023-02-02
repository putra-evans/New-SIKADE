<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yogi "solop" Kaputra
 */

class Home extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_home' => 'mhome'));
  }

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));

		$this->session_info['page_name'] 			= "Home";
		$this->session_info['list_layanan']			= $this->mhome->getDataLayanan();
    	$this->template->build('vhome', $this->session_info);
	}
}

// This is the end of home clas

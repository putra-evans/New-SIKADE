<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of login class
 *
 * @author Yogi "solop" Kaputra
 */

class Registrasi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Model_registrasi'));
	}
	public function index()
	{
		$this->load->view('form_registrasi');
	}
	public function create()
	{
		$csrfHash = $this->security->get_csrf_hash();

		if ($this->Model_registrasi->validasiDataValue('new') == FALSE) {
			$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
		} else {
			$data = $this->Model_registrasi->insertDataregistrasi();
			if ($data['response'] == 'ERROR') {
				$result = array('status' => 0, 'message' => array('isi' => 'Username <b>' . $data['note'] . '</b> yang diinputkan sudah ada yang menggunakan, silakan inputkan username lain...'), 'csrfHash' => $csrfHash);
			} elseif ($data['response'] == 'NOFILE') {
				$result = array('status' => 0, 'message' => array('isi' => 'Scan Identitas wajib diupload dengan format jpg/jpeg serta ukuran maksimal 500kb...'), 'kode' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 1, 'message' => array('isi' => 'Data user <b>' . $data['note'] . '</b> berhasil ditambahkan, silahkan tunggu aktivasi akun anda...'), 'csrfHash' => $csrfHash);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}

// This is the end of home class

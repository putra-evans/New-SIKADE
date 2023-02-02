<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yogi "solop" Kaputra
 */

class Administrasi extends SLP_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_administrasi' => 'madm', 'model_master' => 'mmas'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data administrasi', '#');

		$this->session_info['page_name'] = "Data administrasi";
		$this->session_info['nm_layanan']  = $this->mmas->getDataFasilitasi();
		$this->template->build('form_administrasi/vlist', $this->session_info);
	}

	public function listview()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$data = array();
			$session = $this->app_loader->current_account();
			if (isset($session)) {
				$param = $this->input->post('param', TRUE);
				$dataList = $this->madm->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $dl['nama_administrasi'];
					$row[] = ucwords(substr(strtolower($dl['nm_layanan']), 0, 200));
					$row[] = $dl['jenis_administrasi'];
					$row[] = convert_status($dl['status']);
					$row[] = '<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="' . $this->encryption->encrypt($dl['id_administrasi']) . '" title="Edit data administrasi"><i class="fa fa-pencil"></i> </button>
										<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($dl['id_administrasi']) . '" title="Delete data administrasi"><i class="fa fa-times"></i> </button>';
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->madm->count_all(),
					"recordsFiltered" => $this->madm->count_filtered($param),
					"data" => $data,
				);
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}

	public function create()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($session)) {
				if ($this->madm->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->madm->insertDataadministrasi();

					if ($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data administrasi gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function details()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_administrasi  	= $this->input->post('token', TRUE);
			if (!empty($id_administrasi) and !empty($session)) {
				$data = $this->madm->getDataDetailadministrasi($this->encryption->decrypt($id_administrasi));
				$row = array();
				$row['nama_administrasi']	= !empty($data) ? $data['nama_administrasi'] : '';
				$row['layanan']				= !empty($data) ? $data['id_layanan'] : '';
				$row['status']				= !empty($data) ? $data['status'] : 1;
				$result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_administrasi 		= escape($this->input->post('tokenId', TRUE));
			if (!empty($session) and !empty($id_administrasi)) {
				if ($this->madm->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->madm->updateDataadministrasi();
					if ($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data administrasi gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  	= $this->app_loader->current_account();
			$csrfHash 	= $this->security->get_csrf_hash();
			$id_administrasi 	= escape($this->input->post('tokenId', TRUE));
			if (!empty($session) and !empty($id_administrasi)) {
				$data = $this->madm->deleteDataadministrasi();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> Telah Didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses Didelete gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	//get data kab/kota
	public function instansi()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$instansi = $this->input->get('instansi', TRUE);
			if (!empty($instansi) and !empty($session)) {
				$data = $this->mmas->getDataMasterInstansi($instansi);
				if (count($data) > 0) {
					$row = array();
					foreach ($data as $key => $val) {
						$row['id'] 		= $val['id'];
						$row['text']	= ($val['status'] == 1) ? "instansi " . $val['name'] : $val['name'];
						$hasil[] = $row;
					}
					$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
				} else
					$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
}

// This is the end of home clas

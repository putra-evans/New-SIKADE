<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yogi "solop" Kaputra
 */

class Fasilitasi extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_fasilitasi' => 'mlay', 'model_master' => 'mmas'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data fasilitasi', '#');

	$this->session_info['page_name'] = "Data fasilitasi";
    $this->session_info['nm_group']  = $this->mmas->getDataGroup();
    $this->template->build('form_fasilitasi/vlist', $this->session_info);
	}

	public function listview()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$data = array();
			$session = $this->app_loader->current_account();
			if(isset($session)){
				$param = $this->input->post('param',TRUE);
		    $dataList = $this->mlay->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
	        $row = array();
	        $row[] = $no;
					$row[] = $dl['nm_layanan'];
					$row[] = '<a href="'.site_url('upload/sop/'.$dl['sop']).'"><font color="red">'.$dl['sop'].'</font></a>';
					$row[] = $dl['nm_group'];
					$row[] = convert_status($dl['status']);
	        $row[] = '<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="'.$this->encryption->encrypt($dl['id_layanan']).'" title="Edit data fasilitasi"><i class="fa fa-pencil"></i> </button>
					  <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="'.$this->encryption->encrypt($dl['id_layanan']).'" title="Delete data fasilitasi"><i class="fa fa-times"></i> </button>';
	        $data[] = $row;
				}

				$output = array(
	        "draw" => $this->input->post('draw'),
	        "recordsTotal" => $this->mlay->count_all(),
	        "recordsFiltered" => $this->mlay->count_filtered($param),
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
			if(!empty($session)) {
				if($this->mlay->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mlay->insertDatafasilitasi();
					if($data['response'] == 'NOFILE') {
						$result = array('status' => 0, 'message' => array('file_ktp' => 'Scan ktp wajib diinputkan dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
					} elseif($data['response'] == 'NOUPLOAD') {
						$result = array('status' => 0, 'message' => array('isi' => 'Dokumen administrasi wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
					} elseif($data['response'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Penambahan data baru atas nama '.$data['nama'].' berhasil...', 'kode' => $data['kode'], 'csrfHash' => $csrfHash);
					}

				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data fasilitasi gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
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
			$id_layanan  	= $this->input->post('token', TRUE);
			if(!empty($id_layanan) AND !empty($session)) {
				$data = $this->mlay->getDataDetaillayanan($this->encryption->decrypt($id_layanan));
				$row = array();
				$row['nm_layanan']	= !empty($data) ? $data['nm_layanan'] : '';
				$row['sop']			= !empty($data) ? $data['sop'] : '';
				$row['group']		= !empty($data) ? $data['group'] : '';
				$row['status']		= !empty($data) ? $data['status'] : 1;
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
			$id_layanan 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($id_layanan)) {
				if($this->mlay->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mlay->updateDatafasilitasi();
					if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama'].'</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data fasilitasi gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
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
			$id_layanan 	= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($id_layanan)) {
				$data = $this->mlay->deleteDatafasilitasi();
				if($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama'].'</b> Telah Didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses Didelete gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}


}

// This is the end of home clas

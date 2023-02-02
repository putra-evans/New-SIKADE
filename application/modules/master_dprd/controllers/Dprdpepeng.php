<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yogi "solop" Kaputra
 */

class Dprdpepeng extends SLP_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_dprdpepeng'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data Administrasi Pengesahan Pengangkatan dan Pemberhentian DPRD', '#');

		$this->session_info['page_name'] = "Data Administrasi Pengesahan Pengangkatan dan Pemberhentian DPRD";
		$this->template->build('form_dprdpepeng/vlist', $this->session_info);
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
				$dataList = $this->model_dprdpepeng->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
					$row = array();

					$id_group = $this->app_loader->current_group();
					$tombol = '';
					if ($id_group == "2") {
						if ($dl['status'] == "ditolak" or $dl['status'] == 'belumdiajukan' or $dl['status'] == "diajukan" or $dl['status'] == "selesai") {
							$tombol .= '';
						} else {
							$tombol .= '<button type="button" class="btn btn-xs btn-orange btnUpload" data-id="' . $this->encryption->encrypt($dl['id_dprdpepeng']) . '" title="Upload"><i class="fa fa-plus"></i> Upload</button>';
						}
						$tombol .= ' <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($dl['id_dprdpepeng']) . '" title="Delete data administrasi"><i class="fa fa-times"></i> Delete</button>';
						$tombol .= '<a type="button" class="btn btn-xs btn-primary" href="' . site_url('master-dprd/dprdpepeng/details/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-eye"></i> Detail </b></a>';
					} else if (($id_group == "3") or ($id_group == "4")) {
						if ($dl['status'] == 'ditolak') {
							$tombol .= '<a type="button" class="btn btn-xs btn-info" href="' . site_url('master-dprd/dprdpepeng/update/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-pencil"></i> Edit </b></a>';
						} else if ($dl['status'] == 'belumdiajukan') {
							$tombol .= '<a type="button" class="btn btn-xs btn-primary" href="' . site_url('master-dprd/dprdpepeng/create/new-register/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-send"></i> Ajukan </b></a>';

							$tombol .= ' <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($dl['id_dprdpepeng']) . '" title="Delete data administrasi"><i class="fa fa-times"></i> Delete</button>';
						}
					} else if ($id_group == "1") {
						$tombol .= '<button type="button" class="btn btn-xs btn-orange btnUpload" data-id="' . $this->encryption->encrypt($dl['id_dprdpepeng']) . '" title="Upload"><i class="fa fa-plus"></i> Upload</button>';
						$tombol .= '<a type="button" class="btn btn-xs btn-primary" href="' . site_url('master-dprd/dprdpepeng/details/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-eye"></i> Detail </b></a>';
						$tombol .= '<a type="button" class="btn btn-xs btn-info" href="' . site_url('master-dprd/dprdpepeng/update/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-pencil"></i> Edit </b></a>';
						$tombol .= '<a type="button" class="btn btn-xs btn-primary" href="' . site_url('master-dprd/dprdpepeng/create/new-register/' . base64_encode($dl['id_dprdpepeng'])) . '"><b><i class="fa fa-send"></i> Ajukan </b></a>';
						$tombol .= ' <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($dl['id_dprdpepeng']) . '" title="Delete data administrasi"><i class="fa fa-times"></i> Delete</button>';
					} else {

						$tombol .= '';
					}

					$year	 	   	= date('Y');
					$month	 	   	= date('m');
					if ($dl['file_pendukung'] == '') {
						$dok = ' <font color ="red">Belum ada file</font>';
					} else {
						$dok = '<a  target="_blank" href="' . site_url('upload/file/pendukung/dprdpepeng/' . $year . '/' . $month . '/' . $dl['file_pendukung']) . '"><font color="green">' . $dl['file_pendukung'] . '</font>  </a> <br>
						<a download href="' . site_url('upload/file/pendukung/dprdpepeng/' . $year . '/' . $month . '/' . $dl['file_pendukung']) . '"> <font color="green"><i class="fa fa-download"> Download</i></font>   </a>';
					}
					if ($dl['keterangan_permohonan'] == '') {
						$sttpermohonan = ' <font color ="red">Belum ada Keterangan</font>';
					} else {
						$sttpermohonan = $dl['keterangan_permohonan'];
					}
					$row[] = $no;
					$row[] = $dl['nama_lengkap'];
					$row[] = $dl['nik'];
					$row[] = $dl['alamat'];
					$row[] = $dl['pemda_lembaga_umum'];
					$row[] = $dok;
					$row[] = ucwords(substr(strtolower($dl['nm_instansi']), 0, 200));
					$row[] = convert_status3($dl['status']);
					$row[] = $sttpermohonan;
					$row[] = $tombol;
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->model_dprdpepeng->count_all(),
					"recordsFiltered" => $this->model_dprdpepeng->count_filtered($param),
					"data" => $data,
				);
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}

	public function create_pendukung()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($session)) {
				if ($this->model_dprdpepeng->validasiDataValuePendukung() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_dprdpepeng->insertDataPendukung();

					if ($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function details($noreg)
	{
		$a = base64_decode($noreg);

		$data_dprdpepeng_diri 	= $this->model_dprdpepeng->AmbildataDiri($a);
		$data_dprdpepeng_adm = $this->model_dprdpepeng->tampilDataAdmDprdPepeng($a);
		$data_dprdpepeng_pend = $this->model_dprdpepeng->EditDataPendDPRDPepeng($a);

		if (!empty($data_dprdpepeng_adm)) {
			$ket = $data_dprdpepeng_adm[0]->keterangan_permohonan;
		} else if (!empty($data_dprdpepeng_pend)) {
			$ket = $data_dprdpepeng_pend[0]->keterangan_permohonan;
		} else {
			$ket = '';
		}


		$cekfile = $this->model_dprdpepeng->getDatadprdpepengupload($a);

		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data  Administrasi Pengesahan Pengangkatan dan Pemberhentian DPRD
		', site_url('master-dprd/dprdpepeng'));
		$this->breadcrumb->add('Registrasi', '');

		$this->session_info['page_name'] = "Detail";
		$this->session_info['data_dprdpepeng_diri']	   		= $data_dprdpepeng_diri;
		$this->session_info['data_dprdpepeng_adm']	   		= $data_dprdpepeng_adm;
		$this->session_info['data_dprdpepeng_pend']	   		= $data_dprdpepeng_pend;
		$this->session_info['cek_file']	   				= $cekfile;
		$this->session_info['keterangan']	   			= $ket;
		$this->template->build('form_dprdpepeng/vdetail', $this->session_info);
	}

	public function updatestatuspermohonan()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_dprdpepeng 		= escape($this->input->post('id_dprdpepeng', TRUE));

			if (!empty($session) and !empty($id_dprdpepeng)) {
				if ($this->model_dprdpepeng->validasiStatusPermohonan() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_dprdpepeng->updatestatuspermohonan();
					if ($data['response'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data status permohonan gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function create()
	{
		$role  = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		if ($role == 'new-register') {
			$this->createForm($id);
		} elseif ($role == 'save-register') {
			$this->createSave();
		} elseif ($role == 'insertadministrasi') {
			$this->createAdm();
		} elseif ($role == 'insertpendukung') {
			$this->createPend();
		} elseif ($role == 'save-ajukan') {
			$this->createAjukan();
		}
	}

	private function createForm($id)
	{
		if ($id != '') {
			$id_dprdpepeng = base64_decode($id);
		} else {
			$id_dprdpepeng = "0";
		}

		$dprd_pepeng = $this->model_dprdpepeng->getDatadprdpepeng($id_dprdpepeng);
		$cekfile 	= $this->model_dprdpepeng->getDatadprdpepengupload($id_dprdpepeng);

		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data Pengesahan Pengangkatan dan Pemberhentian DPRD', site_url('master-dprd/dprdpepeng'));
		$this->breadcrumb->add('Registrasi', '');

		$this->session_info['page_name'] = "Registrasi Baru";
		$this->session_info['list_administrasi']	= $this->model_dprdpepeng->tampilDataAdmDprdPepeng($id_dprdpepeng);
		$this->session_info['list_pendukung']		= $this->model_dprdpepeng->EditDataPendDPRDPepeng($id_dprdpepeng);
		$this->session_info['dprd_pepeng']	   		= $dprd_pepeng;
		$this->session_info['cek_file']	   			= $cekfile;
		$this->template->build('form_dprdpepeng/vadd', $this->session_info);
	}

	public function createSave()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($session)) {
				if ($this->model_dprdpepeng->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'kode' => '', 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_dprdpepeng->insertDataDiriDprdpepeng();
					if ($data['response'] == 'NOFILE') {
						$result = array('status' => 0, 'message' => array('file_ktp' => 'Scan ktp wajib diinputkan dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
					} elseif ($data['response'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Penambahan data baru atas nama ' . $data['nama'] . ' berhasil...', 'kode' => $data['kode'], 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gagal, mohon periksa data kembali...'), 'kode' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function createAdm()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->createAdmDprdpepeng();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil ditambahkan...', 'csrfHash' => $csrfHash);
				} elseif ($data['message'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('isi' => 'Dokumen administrasi wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function createPend()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->createPenddprdpepeng();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil ditambahkan...', 'csrfHash' => $csrfHash);
				} elseif ($data['message'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('isi' => 'Dokumen pendukung wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function createAjukan()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($session)) {
				// if ($this->Model_adminpepeng->validasiDataValue() == FALSE) {
				// 	$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'kode' => '', 'csrfHash' => $csrfHash);
				// } else {
				$data = $this->model_dprdpepeng->insertDataPengajuan();
				if ($data['response'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('file_ktp' => 'Scan ktp wajib diinputkan dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				} elseif ($data['response'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Penambahan data baru atas nama ' . $data['nama'] . ' berhasil...', 'kode' => $data['kode'], 'csrfHash' => $csrfHash);
					// }
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gagal, mohon periksa data kembali...'), 'kode' => '', 'csrfHash' => $csrfHash);
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
			if (!empty($session) and !empty($id_layanan)) {
				$data = $this->model_dprdpepeng->deleteDataAdmincuka();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data <b>' . $data['nama'] . '</b> Telah Didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses Didelete gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function update($a)
	{
		$id = base64_decode($a);
		if (!isset($id))
			redirect('master-dprd/adminpepeng');
		$role  = $this->uri->segment(4);
		if ($role == 'proses-edit') {
			$this->updateDataAdministrasi($id);
		} else if ($role == 'proses-edit-pendukung') {
			$this->updateDataPendukung($id);
		} else if ($role == 'proses-edit-ktp') {
			$this->updateDataKtp($id);
		} else if ($role == 'proses-edit-data') {
			$this->updatedatadiri($id);
		} else if ($role == 'ajukan-kembali') {
			$this->updateajukankembali($id);
		} else {
			$this->updateForm($id);
		}
	}

	// ini merupakan form untuk menampilkan update
	private function updateForm($id)
	{
		$data_dprdpepeng_diri 	= $this->model_dprdpepeng->AmbildataDiri($id);
		$edit_dprdpepeng_adm 	= $this->model_dprdpepeng->tampilDataAdmDprdPepeng($id);
		$data_dprdpepeng_pend 	= $this->model_dprdpepeng->EditDataPendDPRDPepeng($id);

		// var_dump($edit_luarnegeri_adm);
		// exit;
		$cekfile = $this->model_dprdpepeng->getDatadprdpepengupload($id);

		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master Data', '#');
		$this->breadcrumb->add('Halaman Data Administrasi Pengesahan Pengangkatan dan Pemberhentian KDH', site_url('master-dprd/adminpepeng'));
		$this->breadcrumb->add('Registrasi', '');

		$this->session_info['page_name'] = "Edit Data";
		$this->session_info['data_dprdpepeng_diri']	   		= $data_dprdpepeng_diri;
		$this->session_info['edit_dprdpepeng_adm']	   		= $edit_dprdpepeng_adm;
		$this->session_info['data_dprdpepeng_pend']	   		= $data_dprdpepeng_pend;
		$this->session_info['cek_file']	   					= $cekfile;
		$this->session_info['urlform']						= "manajemen/module/update/" . $id;
		$this->template->build('form_dprdpepeng/vedit', $this->session_info);
	}
	// proses update data
	private function updatedatadiri()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				if ($this->model_dprdpepeng->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'kode' => '', 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_dprdpepeng->updateDataDiri();
					if ($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data berhasil diedit...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function updateDataKtp()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->updateDataUploadKtp();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil ditambahkan...', 'csrfHash' => $csrfHash);
				} elseif ($data['message'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('isi' => 'Dokumen administrasi wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function updateDataAdministrasi()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->updateDataUploadAdministrasi();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil ditambahkan...', 'csrfHash' => $csrfHash);
				} elseif ($data['message'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('isi' => 'Dokumen administrasi wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	private function updateDataPendukung()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->updateDataUploadPend();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil ditambahkan...', 'csrfHash' => $csrfHash);
				} elseif ($data['message'] == 'NOFILE') {
					$result = array('status' => 0, 'message' => array('isi' => 'Dokumen pendukung wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	private function updateajukankembali()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			if (!empty($csrfHash)) {
				$data = $this->model_dprdpepeng->updateajukankembali();
				if ($data['response'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data berhasil diedit...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	public function deletedokumenpendukung()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  	= $this->app_loader->current_account();
			$csrfHash 	= $this->security->get_csrf_hash();
			$id 	= escape($this->input->post('id', TRUE));
			if (!empty($session) and !empty($csrfHash) and !empty($id)) {
				$data = $this->model_dprdpepeng->deletedokumenpendukung();
				if ($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data Telah Didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses Didelete gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	public function export_to_pdf()
	{
		//get data
		$no_reg	= escape($this->input->get('registration_number', TRUE));
		$dprd_pepeng = $this->model_dprdpepeng->eksportpdf($no_reg);
		$title = 'BUKTI REGISTRASI';
		//set pdf
		$pdf = new pdf();
		//set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Diskominfo Pemprov Sumatera Barat');
		$pdf->SetTitle('Cetak Bukti Registrasi');
		$pdf->SetSubject('List Cetak Bukti Registrasi');
		$pdf->SetKeywords('Pemakaian, Diskominfo, Sumbar');
		//remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//set margins
		$pdf->SetMargins(5, 10, 5);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		//set default font subsetting mode
		$pdf->setFontSubsetting(true);
		//Set font
		$pdf->SetAutoPageBreak(TRUE, 3);
		//Add a page
		$pdf->AddPage('P', 'A4');
		$pdf->SetFont('dejavusans', '', 12);
		$pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-align:left;font-size:16px;"><b>' . $title . '</b></p>', 0, 0, 0, true, 'L', true);
		$pdf->ln(10);
		$pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-align:left;font-size:20px;"><b>NOMOR REGISTRASI : ' . (!empty($dprd_pepeng) ? $dprd_pepeng['no_urut'] : '') . '</b></p>', 0, 0, 0, true, 'L', true);
		$pdf->ln(10);
		$html = '<table width="100%" border="1" cellspacing="0" cellpadding="3">';

		if (count($dprd_pepeng) > 0) {
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>TANGGAL REGISTRASI</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? tgl_indo_registrasi($dprd_pepeng['create_date']) : '') . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>JAM REGISTRASI</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? tgl_indo_jam($dprd_pepeng['create_date']) : '') . ' WIB</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>NAMA LENGKAP</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? $dprd_pepeng['nama_lengkap'] : '') . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>NIK</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? $dprd_pepeng['nik'] : '') . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>ALAMAT ANDA</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? $dprd_pepeng['alamat'] : '') . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>PEMDA/LEMBAGA/UMUM</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? $dprd_pepeng['pemda_lembaga_umum'] : '') . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td style="width:30%;font-size:12px;"><b>NAMA LAYANAN</b></td>';
			$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
			$html .= '<td style="width:68%;text-align:left;font-size:12px;">' . (!empty($dprd_pepeng) ? $dprd_pepeng['nm_layanan'] : '') . '</td>';
			$html .= '</tr>';
		} else {
			$html .= '<tr>';
			$html .= '<td colspan="3">&nbsp;</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		$pdf->writeHTMLCell(0, 0, 10, '', $html, 0, 0, 0, true, 'L', true);
		$pdf->lastPage();
		//---------------------------------------------------------
		//Close and output PDF document
		$pdf->Output('cetak_bukti_registrasi.pdf', 'D');
		//---------------------------------------------------------
	}
}

// This is the end of home clas

<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yogi "solop" Kaputra
 */

class Admincuti extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_admincuti'));
  }

  public function index()
  {
  	$this->breadcrumb->add('Dashboard', site_url('home'));
  	$this->breadcrumb->add('Master Data', '#');
	$this->breadcrumb->add('Halaman Data admincuti', '#');
  	$this->session_info['page_name'] = "Data admincuti";
  	$this->template->build('form_admincuti/vlist', $this->session_info);
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
		    $dataList = $this->model_admincuti->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
			$row = array();
			
			$id_group = $this->app_loader->current_group();
			$tombol='';
			if (($id_group=="1") OR ($id_group=="2"))
			{
				if ($dl['status_pendukung']=="1")
				{
					$tombol.='';
				}
				else
				{
					$tombol.='<button type="button" class="btn btn-xs btn-orange btnUpload" data-id="'.$this->encryption->encrypt($dl['id_admincuti']).'" title="Upload"><i class="fa fa-plus"></i> Upload </button>';
				}
			}
			else
			{
				$tombol.='';
			}
			$tombol.=' <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="'.$this->encryption->encrypt($dl['id_admincuti']).'" title="Delete data administrasi"><i class="fa fa-times"></i>Delete </button>';

	        $row[] = $no;
				$row[] = $dl['nama_lengkap'];
				$row[] = $dl['nik'];
				$row[] = $dl['alamat'];
				$row[] = $dl['pemda_lembaga_umum'];
				$row[] = $dl['file_ktp'];
				$row[] = ucwords(substr(strtolower($dl['nm_instansi']), 0,200));
				$row[] = convert_status2($dl['status_pendukung']);
				$row[] = $tombol;
	        $data[] = $row;
				}

				$output = array(
	        "draw" => $this->input->post('draw'),
	        "recordsTotal" => $this->model_admincuti->count_all(),
	        "recordsFiltered" => $this->model_admincuti->count_filtered($param),
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
			if(!empty($session)) {
				if($this->model_admincuti->validasiDataValuePendukung() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_admincuti->insertDataPendukung();

					if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama'].'</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gedung gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
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
			$id_pendukung 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($id_pendukung)) {
				if($this->model_admincuti->validasiDataValuePendukung() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_admincuti->updateDataPendukung();
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

  public function create() {
  	$role  = $this->uri->segment(4);
  	$noreg = $this->uri->segment(5);
  	if($role == 'new-register')
  		$this->createForm($noreg);
  	elseif($role == 'save-register')
  		$this->createSave();
  }

  private function createForm($noreg) {
  	$data_cuti = $this->model_admincuti->getDataCuti($noreg);
  	$this->breadcrumb->add('Dashboard', site_url('home'));
  	$this->breadcrumb->add('Master Data', '#');
	$this->breadcrumb->add('Halaman Data admincuti', site_url('master-kade/admincuti'));
	$this->breadcrumb->add('Registrasi', '');

  	$this->session_info['page_name'] = "Registrasi Baru";
  	$this->session_info['list_administrasi']	= $this->model_admincuti->getDataAdministrasi();
  	$this->session_info['data_cuti']	   		= $data_cuti;
  	$this->template->build('form_admincuti/vadd', $this->session_info);
  }

  public function createSave() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if(!empty($session)) {
				if($this->model_admincuti->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'kode' => '', 'csrfHash' => $csrfHash);
				} else {
					$data = $this->model_admincuti->insertDataadmincuti();
					if($data['response'] == 'NOFILE') {
						$result = array('status' => 0, 'message' => array('file_ktp' => 'Scan ktp wajib diinputkan dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
					} elseif($data['response'] == 'NOUPLOAD') {
						$result = array('status' => 0, 'message' => array('isi' => 'Dokumen administrasi wajib diupload dengan format png/jpg/jpeg/pdf serta ukuran maksimal 1MB...'), 'kode' => '', 'csrfHash' => $csrfHash);
					} elseif($data['response'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Penambahan data baru atas nama '.$data['nama'].' berhasil...', 'kode' => $data['kode'], 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data gagal, mohon periksa data kembali...'), 'kode' => '', 'csrfHash' => $csrfHash);
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
			$id_pendukung  	= $this->input->post('token', TRUE);
			if(!empty($id_pendukung) AND !empty($session)) {
				$data = $this->model_admincuti->getDataDetailPendukung($this->encryption->decrypt($id_pendukung));
				$row = array();
				$row['nama_file']		= !empty($data) ? $data['nama_file'] : '';
				$row['file_pendukung']	= !empty($data) ? $data['pendukung'] : '';
				$row['status']			= !empty($data) ? $data['status'] : 1;
				$result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash);
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
			 $idAdminCuti = escape($this->input->post('adminCutiId', TRUE));
			//  die($idAdminCuti);
			 $data = $this->model_admincuti->deleteDataAdmincuti();
			 if(!empty($session) AND !empty($idAdminCuti)) {
				 $data = $this->model_admincuti->deleteDataAdmincuti();
				 if($data['message'] == 'ERROR') {
					 $result = array('status' => 0, 'message' => 'Proses delete data gagal dikarenakan data tidak ditemukan...', 'csrfHash' => $csrfHash);
				 }	else if($data['message'] == 'SUCCESS') {
					 $result = array('status' => 1, 'message' => 'Data telah didelete...', 'csrfHash' => $csrfHash);
				 }
			 } else {
				 $result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrfHash' => $csrfHash);
			 }
			 $this->output->set_content_type('application/json')->set_output(json_encode($result));
		 }
	}


	public function export_to_pdf()
	{
		//get data
		$no_reg	= escape($this->input->get('registration_number', TRUE));
		$dataCuti = $this->model_admincuti->getDataCuti($no_reg);
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
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//set margins
		$pdf->SetMargins(5, 10, 5);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		//set default font subsetting mode
		$pdf->setFontSubsetting(true);
		//Set font
		$pdf->SetAutoPageBreak(TRUE, 3);
		//Add a page
		$pdf->AddPage('P', 'A4');
		$pdf->SetFont('dejavusans', '', 12);
		$pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-align:left;font-size:16px;"><b>'.$title.'</b></p>', 0, 0, 0, true, 'L', true);
		$pdf->ln(10);
		$pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-align:left;font-size:20px;"><b>NOMOR REGISTRASI : '.(!empty($dataCuti) ? $dataCuti['no_urut'] : '').'</b></p>', 0, 0, 0, true, 'L', true);
		$pdf->ln(10);
		$html = '<table width="100%" border="1" cellspacing="0" cellpadding="3">';
		
		if(count($dataCuti) > 0) {
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>TANGGAL REGISTRASI</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? tgl_indo_registrasi($dataCuti['create_date']) : '').'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>JAM REGISTRASI</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? tgl_indo_jam($dataCuti['create_date']) : '').' WIB</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>NAMA LENGKAP</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? $dataCuti['nama_lengkap'] : '').'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>NIK</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? $dataCuti['nik'] : '').'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>ALAMAT ANDA</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? $dataCuti['alamat'] : '').'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>PEMDA/LEMBAGA/UMUM</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? $dataCuti['pemda_lembaga_umum'] : '').'</td>';
			$html .= '</tr>';
			$html .= '<tr>';
				$html .= '<td style="width:30%;font-size:12px;"><b>NAMA LAYANAN</b></td>';
				$html .= '<td style="width:2%;text-align:center;font-size:12px;">:</td>';
				$html .= '<td style="width:68%;text-align:left;font-size:12px;">'.(!empty($dataCuti) ? $dataCuti['nm_layanan'] : '').'</td>';
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
		$pdf->Output('cetak_bukti_registrasi.pdf','D');
		//---------------------------------------------------------
	}


}

// This is the end of home clas

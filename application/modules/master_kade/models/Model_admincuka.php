<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of peralatan model
 *
 * @author Yogi "solop" Kaputra
 */

class model_admincuka extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('nik', 'Nomor Induk Kependudukan', 'required|trim|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('alamat', 'Alamat Anda', 'required|trim');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function validasiDataValuePendukung()
	{
		$this->form_validation->set_rules('nama_file', 'Nama File', 'required|trim');
		if ($_FILES['file_pendukung']['name'] == '') {
			$this->form_validation->set_rules('file_pendukung', 'File Pendukung', 'required|trim');
		}

		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function validasiStatusPermohonan()
	{
		$this->form_validation->set_rules('statusPermohonan', 'Status Permohonan', 'required|trim');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	var $search = array('nama_lengkap', 'pemda_lembaga_umum', 'nm_instansi');
	public function get_datatables($param)
	{
		$this->_get_datatables_query($param);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_filtered($param)
	{
		$this->_get_datatables_query($param);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		if ($this->app_loader->is_operator()) {
			$this->db->where('id_admincuka', instansi($this->app_loader->current_account()));
		}
		return $this->db->count_all_results('ms_admincuka');
	}

	private function _get_datatables_query($param)
	{
		$instansi = instansi($this->app_loader->current_account());
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}
		$this->db->select('a.id_admincuka,
													a.nama_lengkap,
		 											a.nik,
													a.file_ktp,
		 											a.nik,
		 											a.create_date,
		 											a.alamat,
		 											a.pemda_lembaga_umum,
													a.status,
													a.keterangan_permohonan,
		 											b.nm_instansi,
													c.status as status_pendukung,
													c.file_pendukung,
													c.create_date as date_pendukung');
		$this->db->from('ms_admincuka a');
		$this->db->join('ms_instansi b', 'b.id_instansi = a.id_instansi', 'LEFT');
		$this->db->join('ms_pendukungcuka c', 'c.id_admincuka = a.id_admincuka', 'LEFT');
		$this->db->order_by('a.id_admincuka', 'DESC');
		if ($this->app_loader->is_operator()) {
			$this->db->where('b.id_instansi', $instansi);
		}

		$i = 0;
		foreach ($this->search as $item) { // loop column
			if ($_POST['search']['value']) { // if datatable send POST for search
				if ($i === 0) { // first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		$this->db->order_by('a.id_admincuka ASC');
	}

	/*Fungsi Geta Data Kelengkapan Administrasi*/
	public function getDataAdministrasi()
	{
		$this->db->select('a.id_administrasi,
												a.id_layanan,
												a.nama_administrasi,
												a.status,
												b.nm_layanan
												');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_layanan_adm b', 'a.id_layanan = b.id_layanan', 'INNER');
		$this->db->where('a.id_layanan', 5);
		$this->db->where('b.group', 1);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen utama');
		$this->db->order_by('a.id_administrasi', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}
	// fungsi get data dokumen pendukung
	public function getDataDokumenPendukung()
	{
		$this->db->select('a.id_administrasi,
											a.id_layanan,
											a.nama_administrasi,
											a.status,
											b.nm_layanan
											');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_layanan_adm b', 'a.id_layanan = b.id_layanan', 'INNER');
		$this->db->where('a.id_layanan', 5);
		$this->db->where('b.group', 1);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('a.id_administrasi', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	/* Fungsi untuk insert data */
	/* Fungsi untuk insert data */
	public function insertDataDiriCuka()
	{
		$create_by     = $this->app_loader->current_account();
		$instansi 	   = instansi($this->app_loader->current_account());
		$create_date   = date('Y-m-d H:i:s');
		$create_ip     = $this->input->ip_address();
		$nikGet        = escape($this->input->post('nik', TRUE));
		$nama          = escape($this->input->post('nama_lengkap', TRUE));
		$file_ktp      = escape($this->input->post('file_ktp', TRUE));
		$year	 	   = date('Y');
		$month	 	   = date('m');
		$dirname 	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nikGet;

		$jumlahnik    = strlen($nikGet);
		if ($jumlahnik != 16) {
			return array('response' => 'NIKGAGAL', 'kode' => '', 'NIK' => $nikGet);
		}

		if (!is_dir($dirname)) {
			mkdir('./' . $dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './' . $dirname . '/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> $file_ktp,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		// insert data ktp
		// if (!$this->upload->do_upload('file_ktp')) {
		if ($_FILES['file_ktp']['name'] == '') {
			return array('response' => 'NOFILE', 'kode' => '', 'nama' => $nama);
		} else if (!$this->upload->do_upload('file_ktp')) {
			return array('response' => 'NOFILE', 'kode' => '', 'nama' => $nama);
		} else {
			$upload_data = $this->upload->data();
			$images  = $upload_data['file_name'];
			$noreg = time();
			$data = array(
				'no_urut'					=> $noreg,
				'nama_lengkap'				=> $nama,
				'nik'						=> $nikGet,
				'file_ktp'					=> $images,
				'alamat'					=> escape($this->input->post('alamat', TRUE)),
				'pemda_lembaga_umum'		=> escape($this->input->post('pemda_lembaga_umum', TRUE)),
				'status'					=> 'belumdiajukan',
				'id_instansi'				=> $this->db->escape_str($instansi),
				'create_by' 				=> $this->db->escape_str($create_by),
				'create_date' 				=> $this->db->escape_str($create_date),
				'create_ip' 				=> $this->db->escape_str($create_ip),
				'mod_by' 					=> $this->db->escape_str($create_by),
				'mod_date' 					=> $this->db->escape_str($create_date),
				'mod_ip' 					=> $this->db->escape_str($create_ip)
			);

			$this->db->insert('ms_admincuka', $data);
			$id = base64_encode($this->db->insert_id());
			return array('response' => 'SUCCESS', 'kode' => $id, 'nama' => $nama);
		}
	}

	// insert dokumen administrasi
	public function createAdmCuka()
	{
		$create_by     		= $this->app_loader->current_account();
		$create_date   		= date('Y-m-d H:i:s');
		$create_ip     		= $this->input->ip_address();
		$id_adminupload 	= base64_decode($this->input->post('id_adminupload', TRUE));
		$id_admincuka 		= base64_decode($this->input->post('id_admincuka', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatacukaUpload($id_admincuka);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

		if (empty($id_adminupload)) {
			$configPend = array(
				'upload_path' 		=> './' . $dirname1 . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'file_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $configPend);
			$this->upload->initialize($configPend);
			$aksiupload = $this->upload->do_upload('dokumen');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'NIK' => $nik);
			} else {
				$upload_dataPend = $this->upload->data();
				$imagesPend  = $upload_dataPend['file_name'];
				$data = array(
					'id_admincuka' 	=> $id_admincuka,
					'id_administrasi' 		=> $id_administrasi,
					'nama_file'				=> $imagesPend,
					'create_by' 			=> $this->db->escape_str($create_by),
					'create_date' 			=> $this->db->escape_str($create_date),
					'create_ip' 			=> $this->db->escape_str($create_ip),
					'mod_by' 				=> $this->db->escape_str($create_by),
					'mod_date' 				=> $this->db->escape_str($create_date),
					'mod_ip' 				=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_adminupload_cuka', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatacukaUpload($id_admincuka);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

			// ini update data dokumen administrasi
			$config = array(
				'upload_path' 		=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'edit_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('dokumen');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nik);
			} else {
				// $this->upload->do_upload('dokumenPend');
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];
				$data = array(
					'nama_file'			=> $images,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$dataUP = $this->getDataUnlinkedit($id_adminupload);
				$nikunlink 					= $dataUP['nik'];
				$yearunlink 				= $dataUP['year'];
				$monthunlink 				= $dataUP['month'];
				$namafileunlink 			= $dataUP['nama_file'];
				$dirnameunlink 	   			= 'upload/file/administrasi/cuka/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_adminupload_cuka', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}
	// insert dokumen pendukung
	public function createPendCuka()
	{
		$create_by     		= $this->app_loader->current_account();
		$create_date   		= date('Y-m-d H:i:s');
		$create_ip     		= $this->input->ip_address();
		$id_adminupload 	= base64_decode($this->input->post('id_adminupload', TRUE));
		$id_admincuka 		= base64_decode($this->input->post('id_admincuka', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatacukaUpload($id_admincuka);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

		if (empty($id_adminupload)) {
			$configPend = array(
				'upload_path' 		=> './' . $dirname1 . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'file_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $configPend);
			$this->upload->initialize($configPend);
			$aksiupload = $this->upload->do_upload('dokumenPend');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'NIK' => $nik);
			} else {
				$upload_dataPend = $this->upload->data();
				$imagesPend  = $upload_dataPend['file_name'];
				$data = array(
					'id_admincuka' 		=> $id_admincuka,
					'id_administrasi' 	=> $id_administrasi,
					'nama_file'			=> $imagesPend,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_adminupload_cuka', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatacukaUpload($id_admincuka);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

			// ini update data dokumen administrasi
			$config = array(
				'upload_path' 		=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'edit_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('dokumenPend');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nik);
			} else {
				// $this->upload->do_upload('dokumenPend');
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];
				$data = array(
					'nama_file'			=> $images,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$dataUP = $this->getDataUnlinkedit($id_adminupload);
				$nikunlink 					= $dataUP['nik'];
				$yearunlink 				= $dataUP['year'];
				$monthunlink 				= $dataUP['month'];
				$namafileunlink 			= $dataUP['nama_file'];
				$dirnameunlink 	   			= 'upload/file/administrasi/cuka/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_adminupload_cuka', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}
	public function insertDataPengajuan()
	{
		$create_by     	= $this->app_loader->current_account();
		$create_date   	= date('Y-m-d H:i:s');
		$create_ip     	= $this->input->ip_address();
		$nama          	= escape($this->input->post('nama_lengkap', TRUE));
		$id 			= base64_decode($this->input->post('id_admincuka'));
		// var_dump($id);
		// exit;


		$data = array(
			'status' 					=> 'diajukan',
			'create_by' 				=> $this->db->escape_str($create_by),
			'create_date' 				=> $this->db->escape_str($create_date),
			'create_ip' 				=> $this->db->escape_str($create_ip),
			'mod_by' 					=> $this->db->escape_str($create_by),
			'mod_date' 					=> $this->db->escape_str($create_date),
			'mod_ip' 					=> $this->db->escape_str($create_ip)
		);
		$this->db->where('id_admincuka', $id);
		$this->db->update('ms_admincuka', $data);
		// $this->db->insert('ms_adminpepeng', $data);
		$id2 = base64_encode($id);
		return array('response' => 'SUCCESS', 'kode' => $id2, 'nama' => $nama);
	}

	public function insertDataPendukung()
	{
		$create_by     	= $this->app_loader->current_account();
		$create_date   	= date('Y-m-d H:i:s');
		$create_ip     	= $this->input->ip_address();
		$nama			= escape($this->input->post('nama_file', TRUE));
		$id_admincuka	= $this->encryption->decrypt(escape($this->input->post('id_admincuka', TRUE)));
		$file_pendukung = escape($this->input->post('file_pendukung', TRUE));
		$year	 	   	= date('Y');
		$month	 	   	= date('m');
		$dirname 	   = 'upload/file/pendukung/cuka/' . $year . '/' . $month . '/';
		if (!is_dir($dirname)) {
			mkdir('./' . $dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './' . $dirname . '/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> $file_pendukung,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file_pendukung')) {
			return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nama);
		} else {
			$upload_data = $this->upload->data();
			$images  = $upload_data['file_name'];
			$noreg = time();
			$data = array(
				'nama_file'			=> $nama,
				'id_admincuka'		=> $id_admincuka,
				'file_pendukung'	=> $images,
				'status'			=> '1',
				'create_by' 		=> $this->db->escape_str($create_by),
				'create_date' 		=> $this->db->escape_str($create_date),
				'create_ip' 		=> $this->db->escape_str($create_ip),
				'mod_by' 			=> $this->db->escape_str($create_by),
				'mod_date' 			=> $this->db->escape_str($create_date),
				'mod_ip' 			=> $this->db->escape_str($create_ip)
			);
			$this->db->insert('ms_pendukungcuka', $data);
			$updateDataStatus = array(
				'id_admincuka' 		=> $id_admincuka,
				'status' => 'selesai',
				'keterangan_permohonan'		=> 'selesai',
			);
			$this->db->where('id_admincuka', $id_admincuka);
			$this->db->update('ms_admincuka', $updateDataStatus);
			return array('message' => 'SUCCESS', 'kode' => '', 'nama' => $nama);
		}
	}

	public function getDataAdmincuka($id_admincuka)
	{
		$this->db->where('id_admincuka', $id_admincuka);
		$query = $this->db->get('ms_admincuka');
		return $query->row_array();
	}

	public function getDataAdminUpload($id_admincuka)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, nama_file');
		$this->db->where('id_admincuka', $id_admincuka);
		$query = $this->db->get('ms_adminupload_cuka');
		return $query->result_array();
	}

	public function getDatacukaUpload($id_admincuka)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, file_ktp, nik, file_ktp');
		$this->db->where('id_admincuka', $id_admincuka);
		$query = $this->db->get('ms_admincuka');
		return $query->row_array();
	}

	public function getDataUnlinkedit($idupload)
	{
		$this->db->select('date_format(a.create_date,"%Y") as year, 
							date_format(a.create_date,"%m") as month, 
							a.nama_file, 
							b.nik');
		$this->db->from('ms_adminupload_cuka a');
		$this->db->join('ms_admincuka b', 'a.id_admincuka = b.id_admincuka', 'INNER');
		$this->db->where('a.id_adminupload', $idupload);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function deleteDataAdmincuka()
	{
		$id_admincuka = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));

		$checkFile 	= $this->getDatacukaUpload($id_admincuka);
		$file_ktp 	= $checkFile['file_ktp'];
		$year 		= $checkFile['year'];
		$month 		= $checkFile['month'];

		//cek data rs by id
		$dataCT = $this->getDataAdmincuka($id_admincuka);
		$dataUP = $this->getDataAdminUpload($id_admincuka);
		$name	= !empty($dataCT) ? $dataCT['nama_lengkap'] : '';
		$nik	= !empty($dataCT) ? $dataCT['nik'] : '';
		if (count($dataCT) <= 0)
			return array('message' => 'ERROR');
		else {

			foreach ($dataUP as $id) {
				//delete data file di table
				$nama_file 	= $id['nama_file'];
				$year 		= $id['year'];
				$month 		= $id['month'];

				$dirname = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik . '/' . $nama_file;
				unlink($dirname);
				$this->db->where('id_admincuka', $id_admincuka);
				$this->db->delete('ms_adminupload_cuka');
			}

			$dirname = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik . '/' . $file_ktp;
			unlink($dirname);
			$this->db->where('id_admincuka', $id_admincuka);
			$this->db->delete('ms_admincuka');
			$this->delete_data_dukung($id_admincuka);
			return array('message' => 'SUCCESS', 'nama' => $name);
		}
	}

	public function getDataPendukung($id_admincuka)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, file_pendukung as file_support');
		$this->db->where('id_admincuka', $id_admincuka);
		$query = $this->db->get('ms_pendukungcuka');
		return $query->row_array();
	}


	public function delete_data_dukung($id_admincuka)
	{
		$checkFile 		= $this->getDataPendukung($id_admincuka);
		//delete data file di table
		$file_support 	= $checkFile['file_support'];
		$year 			= $checkFile['year'];
		$month 			= $checkFile['month'];
		if ($checkFile != '') {
			$dirname = 'upload/file/pendukung/cuka/' . $year . '/' . $month . '/' . $file_support;
			unlink($dirname);
			$this->db->where('id_admincuka', $id_admincuka);
			$this->db->delete('ms_pendukungcuka');
		} else {
			return array('message' => 'SUCCESS');
		}
	}

	public function getDataListcukaReport($cuka)
	{
		$this->db->select('a.id_admincuka,
									a.nama_lengkap,
									a.nik,
									a.file_ktp,
									a.alamat,
									a.pemda_lembaga_umum,
									a.status,
									c.nm_layanan
											 ');
		if ($cuka != '')
			$this->db->where('a.id_admincuka', $cuka);
		$this->db->order_by('a.id_admincuka ASC');
		$this->db->from('ms_administrasi b');
		$this->db->join('ms_layanan_adm c', 'c.id_layanan = b.id_layanan', 'INNER');
		$query = $this->db->get('ms_admincuka a');
		return $query->result_array();
	}

	/*Fungsi get data edit by id dan url*/
	public function getDatacuka($id)
	{
		$this->db->select('a.id_admincuka,
							a.no_urut,
							a.nama_lengkap,
							a.nik,
							a.create_date,
							a.file_ktp,
							a.alamat,
							a.pemda_lembaga_umum,
							a.status,
							b.nama_file,
							c.nama_administrasi,
							d.nm_layanan');
		$this->db->from('ms_admincuka a');
		$this->db->join('ms_adminupload_cuka b', 'a.id_admincuka = b.id_admincuka', 'LEFT');
		$this->db->join('ms_administrasi c', 'b.id_administrasi = c.id_administrasi', 'LEFT');
		$this->db->join('ms_layanan_adm d', 'c.id_layanan = d.id_layanan', 'LEFT');
		$this->db->where('a.id_admincuka', $id);
		$this->db->order_by('a.id_admincuka DESC');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function eksportpdf($no_reg)
	{
		$this->db->select('a.id_admincuka,
							a.no_urut,
							a.nama_lengkap,
							a.nik,
							a.create_date,
							a.file_ktp,
							a.alamat,
							a.pemda_lembaga_umum,
							a.status,
							b.nama_file,
							c.nama_administrasi,
							d.nm_layanan');
		$this->db->from('ms_admincuka a');
		$this->db->join('ms_adminupload_cuka b', 'a.id_admincuka = b.id_admincuka', 'INNER');
		$this->db->join('ms_administrasi c', 'b.id_administrasi = c.id_administrasi', 'INNER');
		$this->db->join('ms_layanan_adm d', 'c.id_layanan = d.id_layanan', 'INNER');
		$this->db->where('a.no_urut', $no_reg);
		$this->db->order_by('a.id_admincuka DESC');
		$query = $this->db->get();
		return $query->row_array();
	}


	public function tampilAdmDataCuka($a)
	{
		$this->db->select('
			a.id_administrasi, 
			a.nama_administrasi, 
			a.jenis_administrasi,
			a.id_layanan, 
			b.id_adminupload,
			b.nama_file,
			c.nik,
			c.alamat,
			c.pemda_lembaga_umum,
			c.id_admincuka,
			c.file_ktp,
			c.keterangan_permohonan, 
			c.nama_lengkap');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_adminupload_cuka b', 'a.id_administrasi = b.id_administrasi AND b.id_admincuka = ' . $a, 'LEFT');
		$this->db->join('ms_admincuka c', 	'c.id_admincuka = b.id_admincuka', 'LEFT');
		$this->db->where('a.id_layanan', 5);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen utama');
		$this->db->order_by('a.id_administrasi', 'ASC');

		// SELECT * from ms_admincuti a LEFT JOIN ms_adminupload b ON a.id_adminluarnegeri = b.id_adminluarnegeri INNER JOIN ms_administrasi c ON b.id_administrasi = c.id_administrasi INNER JOIN ms_layanan_adm d ON c.id_layanan = d.id_layanan WHERE a.id_adminluarnegeri = '6'
		$query = $this->db->get();
		return $query->result();
	}
	public function tampilDataPendCuka($a)
	{
		$this->db->select('c.id_admincuka,
							c.no_urut,
							c.nama_lengkap,
							c.nik,
							c.create_date,
							c.file_ktp,
							c.alamat,
							c.pemda_lembaga_umum,
							c.status,
							c.keterangan_permohonan,
							b.nama_file,
							b.id_administrasi,
							a.jenis_administrasi,
							a.nama_administrasi');

		$this->db->from('ms_administrasi a');
		$this->db->join('ms_adminupload_cuka b', 'b.id_administrasi = a.id_administrasi', 'LEFT');
		$this->db->join('ms_admincuka c', 'b.id_admincuka = c.id_admincuka', 'INNER');

		// $this->db->join('ms_admincuti c', 'b.id_admincuka = c.id_admincuka AND c.id_admincuka = ' . $a, 'LEFT');
		$this->db->where('c.id_admincuka',  $a);
		$this->db->where('a.id_layanan', 5);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('b.id_admincuka DESC');

		$query = $this->db->get();
		return $query->result();
		// SELECT * from ms_admincuti a INNER JOIN ms_adminupload b ON a.id_adminluarnegeri = b.id_adminluarnegeri INNER JOIN ms_administrasi c ON b.id_administrasi = c.id_administrasi INNER JOIN ms_layanan_adm d ON c.id_layanan = d.id_layanan WHERE a.id_adminluarnegeri = '6' 
	}

	public function updatestatuspermohonan()
	{

		$id_admincuka 					= escape($this->input->post('id_admincuka', TRUE));
		$nama_lengkap 					= escape($this->input->post('nama_lengkap', TRUE));
		$status_permohonan				= escape($this->input->post('statusPermohonan', TRUE));
		$keterangan_permohonan			= escape($this->input->post('keterangan', TRUE));
		$data = array(
			'status'						=> $status_permohonan,
			'keterangan_permohonan'			=> $keterangan_permohonan,
		);
		$this->db->where('id_admincuka', $id_admincuka);
		$this->db->update('ms_admincuka', $data);
		return array('response' => 'SUCCESS', 'kode' => '', 'nama' => $nama_lengkap);
	}



	// function untuk edit data
	public function AmbildataDiri($a)
	{
		$this->db->select('*');
		$this->db->from('ms_admincuka');
		$this->db->where('id_admincuka', $a);
		$this->db->order_by('id_admincuka DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function EditDataPendCuka($a)
	{
		$this->db->select('
			a.id_administrasi, 
			a.nama_administrasi, 
			a.jenis_administrasi,
			a.id_layanan, 
			b.id_adminupload,
			b.nama_file,
			c.nik,
			c.alamat,
			c.pemda_lembaga_umum,
			c.id_admincuka,
			c.file_ktp,
			c.keterangan_permohonan, 
			c.nama_lengkap');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_adminupload_cuka b', 'a.id_administrasi = b.id_administrasi AND b.id_admincuka = ' . $a, 'LEFT');
		$this->db->join('ms_admincuka c', 	'c.id_admincuka = b.id_admincuka', 'LEFT');
		$this->db->where('a.id_layanan', 5);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('a.id_administrasi DESC');

		$query = $this->db->get();
		return $query->result();
	}
	// update data diri pada form edit
	public function updateDataDiri()
	{
		$id_admincuka 		= $this->input->post('id_admincuka', TRUE);
		$nama_lengkap 		= $this->input->post('nama_lengkap', TRUE);
		$nik 				= $this->input->post('nik', TRUE);
		$alamat 			= $this->input->post('alamat', TRUE);
		$pemda_lembaga_umum 			= $this->input->post('pemda_lembaga_umum', TRUE);
		$create_by     = $this->app_loader->current_account();
		$create_date   = date('Y-m-d H:i:s');
		$create_ip     = $this->input->ip_address();
		$data = array(
			'nama_lengkap' 			=> $this->db->escape_str($nama_lengkap),
			'nik' 					=> $this->db->escape_str($nik),
			'alamat' 				=> $this->db->escape_str($alamat),
			'pemda_lembaga_umum' 	=> $this->db->escape_str($pemda_lembaga_umum),
			'create_by' 		=> $this->db->escape_str($create_by),
			'create_date' 		=> $this->db->escape_str($create_date),
			'create_ip' 		=> $this->db->escape_str($create_ip),
			'mod_by' 			=> $this->db->escape_str($create_by),
			'mod_date' 			=> $this->db->escape_str($create_date),
			'mod_ip' 			=> $this->db->escape_str($create_ip)
		);
		$this->db->where('id_admincuka', $id_admincuka);
		$this->db->update('ms_admincuka', $data);
		// untuk unlik saat edit data
		return array('message' => 'SUCCESS', 'nama' => $nik);
	}

	// update dokumen KTP
	public function updateDataUploadKtp()
	{
		$id_admincuka = $this->input->post('id_admincuka', TRUE);
		$create_by     = $this->app_loader->current_account();
		$create_date   = date('Y-m-d H:i:s');
		$create_ip     = $this->input->ip_address();

		// ambil direktori administrasi
		$checkFile 		= $this->getDatacukaUpload($id_admincuka);
		$nik 			= $checkFile['nik'];
		$year 			= $checkFile['year'];
		$month 			= $checkFile['month'];
		$namafile 		= $checkFile['file_ktp'];
		$dirname 	   	= 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;
		// ini update data dokumen administrasi
		$config = array(
			'upload_path' 		=> './' . $dirname . '/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> 'ktp_upload_' . $nik . '_' . time(),
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$upload = $this->upload->do_upload('file_ktp');
		if (!$upload) {
			return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nik);
		} else {
			$upload_data = $this->upload->data();
			$images  = $upload_data['file_name'];
			$data = array(
				'file_ktp'			=> $images,
				'create_by' 		=> $this->db->escape_str($create_by),
				'create_date' 		=> $this->db->escape_str($create_date),
				'create_ip' 		=> $this->db->escape_str($create_ip),
				'mod_by' 			=> $this->db->escape_str($create_by),
				'mod_date' 			=> $this->db->escape_str($create_date),
				'mod_ip' 			=> $this->db->escape_str($create_ip)
			);
			$dirnameunlink 	   			= 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik . '/' . $namafile;
			unlink($dirnameunlink);
			$this->db->where('id_admincuka', $id_admincuka);
			$this->db->update('ms_admincuka', $data);
			// untuk unlik saat edit data
			return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
		}
	}

	// update dok administrasi
	public function updateDataUploadAdministrasi()
	{
		$create_by     		= $this->app_loader->current_account();
		$create_date   		= date('Y-m-d H:i:s');
		$create_ip     		= $this->input->ip_address();
		$id_adminupload 	= base64_decode($this->input->post('id_adminupload', TRUE));
		$id_admincuka 		= base64_decode($this->input->post('id_admincuka', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatacukaUpload($id_admincuka);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

		if (empty($id_adminupload)) {
			$configPend = array(
				'upload_path' 		=> './' . $dirname1 . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'file_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $configPend);
			$this->upload->initialize($configPend);
			$aksiupload = $this->upload->do_upload('dokumen');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'NIK' => $nik);
			} else {
				$upload_dataPend = $this->upload->data();
				$imagesPend  = $upload_dataPend['file_name'];
				$data = array(
					'id_admincuka' 	=> $id_admincuka,
					'id_administrasi' 		=> $id_administrasi,
					'nama_file'				=> $imagesPend,
					'create_by' 			=> $this->db->escape_str($create_by),
					'create_date' 			=> $this->db->escape_str($create_date),
					'create_ip' 			=> $this->db->escape_str($create_ip),
					'mod_by' 				=> $this->db->escape_str($create_by),
					'mod_date' 				=> $this->db->escape_str($create_date),
					'mod_ip' 				=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_adminupload_cuka', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatacukaUpload($id_admincuka);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

			// ini update data dokumen administrasi
			$config = array(
				'upload_path' 		=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'edit_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('dokumen');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nik);
			} else {
				// $this->upload->do_upload('dokumenPend');
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];
				$data = array(
					'nama_file'			=> $images,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$dataUP = $this->getDataUnlinkedit($id_adminupload);
				$nikunlink 					= $dataUP['nik'];
				$yearunlink 				= $dataUP['year'];
				$monthunlink 				= $dataUP['month'];
				$namafileunlink 			= $dataUP['nama_file'];
				$dirnameunlink 	   			= 'upload/file/administrasi/cuka/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_adminupload_cuka', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}

	// update dokumen pendukung
	public function updateDataUploadPend()
	{
		$create_by     	= $this->app_loader->current_account();
		$create_date   	= date('Y-m-d H:i:s');
		$create_ip     	= $this->input->ip_address();
		$iduploadpend 	= $this->input->post('iduploadpend', TRUE);
		$idadmincukapend = $this->input->post('idadmincukapend', TRUE);
		$id_administrasi = $this->input->post('id_administrasi', TRUE);
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatacukaUpload($idadmincukapend);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

		if (empty($iduploadpend)) {
			$configPend = array(
				'upload_path' 		=> './' . $dirname1 . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'file_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $configPend);
			$this->upload->initialize($configPend);
			$aksiupload = $this->upload->do_upload('dokumenPend');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'NIK' => $nik);
			} else {
				$upload_dataPend = $this->upload->data();
				$imagesPend  = $upload_dataPend['file_name'];
				$data = array(
					'id_admincuka' => $idadmincukapend,
					'id_administrasi' 		=> $id_administrasi,
					'nama_file'			=> $imagesPend,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_adminupload_cuka', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatacukaUpload($idadmincukapend);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik;

			// ini update data dokumen administrasi
			$config = array(
				'upload_path' 		=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_name'			=> 'edit_upload_' . $nik . '_' . time(),
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('dokumenPend');
			if (!$aksiupload) {
				return array('message' => 'NOFILE', 'kode' => '', 'nama' => $nik);
			} else {
				// $this->upload->do_upload('dokumenPend');
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];
				$data = array(
					'nama_file'			=> $images,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$dataUP = $this->getDataUnlinkedit($iduploadpend);
				$nikunlink 					= $dataUP['nik'];
				$yearunlink 				= $dataUP['year'];
				$monthunlink 				= $dataUP['month'];
				$namafileunlink 			= $dataUP['nama_file'];
				$dirnameunlink 	   			= 'upload/file/administrasi/cuka/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $iduploadpend);
				$this->db->update('ms_adminupload_cuka', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}

	public function updateajukankembali()
	{
		$id_admincuka 						= escape($this->input->post('id_admincuka', TRUE));
		$nama_lengkap 						= escape($this->input->post('nama_lengkap', TRUE));
		$data = array(
			'status'						=> 'diajukan',
			'keterangan_permohonan'			=> '',
		);
		$this->db->where('id_admincuka', $id_admincuka);
		$this->db->update('ms_admincuka', $data);
		return array('response' => 'SUCCESS', 'kode' => '', 'nama' => $nama_lengkap);
	}

	// delete dokumen edit pendukung
	public function deletedokumenpendukung()
	{

		$id 	= escape($this->input->post('id', TRUE));
		$checkFile 		= $this->getDataUnlinkedit($id);
		//delete data file di table
		$year 			= $checkFile['year'];
		$nik 			= $checkFile['nik'];
		$month 			= $checkFile['month'];
		$nama_file 		= $checkFile['nama_file'];

		if ($checkFile != '') {
			$dirname = 'upload/file/administrasi/cuka/' . $year . '/' . $month . '/' . $nik . '/' . $nama_file;
			unlink($dirname);
			$this->db->where('id_adminupload', $id);
			$this->db->delete('ms_adminupload_cuka');
			return array('message' => 'SUCCESS');
		}
	}
}

// This is the end of auth signin model

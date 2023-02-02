<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of peralatan model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_dprdperawa extends CI_Model
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
			$this->db->where('id_dprdperawa', instansi($this->app_loader->current_account()));
		}
		return $this->db->count_all_results('ms_dprdperawa');
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
		$this->db->select('a.id_dprdperawa,
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
		$this->db->from('ms_dprdperawa a');
		$this->db->join('ms_instansi b', 'b.id_instansi = a.id_instansi', 'LEFT');
		$this->db->join('ms_pendukungdprdperawa c', 'c.id_dprdperawa = a.id_dprdperawa', 'LEFT');
		$this->db->order_by('a.id_dprdperawa', 'DESC');
		if ($this->app_loader->is_operator()) {
			$this->db->where('b.id_instansi', $instansi);
		} else if ($this->app_loader->is_administrator()) {
			$this->db->group_start();
			$this->db->or_where('a.status', 'diajukan');
			$this->db->or_where('a.status', 'diproses');
			$this->db->or_where('a.status', 'ditolak');
			$this->db->or_where('a.status', 'selesai');
			$this->db->group_end();
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
		$this->db->order_by('a.id_dprdperawa ASC');
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
		$this->db->where('a.id_layanan', 7);
		$this->db->where('b.group', 2);
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
		$this->db->where('a.id_layanan', 7);
		$this->db->where('b.group', 2);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('a.id_administrasi', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	/* Fungsi untuk insert data */
	public function insertDataDiriDprdperawa()
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
		$dirname 	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nikGet;

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

			$this->db->insert('ms_dprdperawa', $data);
			$id = base64_encode($this->db->insert_id());
			return array('response' => 'SUCCESS', 'kode' => $id, 'nama' => $nama);
		}
	}

	// insert dokumen administrasi
	public function createAdmDprdperawa()
	{
		$create_by     		= $this->app_loader->current_account();
		$create_date   		= date('Y-m-d H:i:s');
		$create_ip     		= $this->input->ip_address();
		$id_adminupload 	= base64_decode($this->input->post('id_adminupload', TRUE));
		$id_dprdperawa 		= base64_decode($this->input->post('id_dprdperawa', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatadprdperawaupload($id_dprdperawa);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
					'id_dprdperawa' 		=> $id_dprdperawa,
					'id_administrasi' 		=> $id_administrasi,
					'nama_file'				=> $imagesPend,
					'create_by' 			=> $this->db->escape_str($create_by),
					'create_date' 			=> $this->db->escape_str($create_date),
					'create_ip' 			=> $this->db->escape_str($create_ip),
					'mod_by' 				=> $this->db->escape_str($create_by),
					'mod_date' 				=> $this->db->escape_str($create_date),
					'mod_ip' 				=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_dprdupload_perawa', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatadprdperawaupload($id_dprdperawa);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
				$dirnameunlink 	   			= 'upload/file/administrasi/dprdperawa/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_dprdupload_perawa', $data);
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
		$id 			= base64_decode($this->input->post('id_dprdperawa'));
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
		$this->db->where('id_dprdperawa', $id);
		$this->db->update('ms_dprdperawa', $data);
		// $this->db->insert('ms_adminpepeng', $data);
		$id2 = base64_encode($id);
		return array('response' => 'SUCCESS', 'kode' => $id2, 'nama' => $nama);
	}


	// insert dokumen pendukung
	public function createPenddprdperawa()
	{
		$create_by     		= $this->app_loader->current_account();
		$create_date   		= date('Y-m-d H:i:s');
		$create_ip     		= $this->input->ip_address();
		$id_adminupload 	= base64_decode($this->input->post('id_adminupload', TRUE));
		$id_dprdperawa 		= base64_decode($this->input->post('id_dprdperawa', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatadprdperawaupload($id_dprdperawa);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
					'id_dprdperawa' 	=> $id_dprdperawa,
					'id_administrasi' 	=> $id_administrasi,
					'nama_file'			=> $imagesPend,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_dprdupload_perawa', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatadprdperawaupload($id_dprdperawa);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
				$dirnameunlink 	   			= 'upload/file/administrasi/dprdperawa/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_dprdupload_perawa', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}

	public function insertDataPendukung()
	{
		$create_by     	= $this->app_loader->current_account();
		$create_date   	= date('Y-m-d H:i:s');
		$create_ip     	= $this->input->ip_address();
		$nama			= escape($this->input->post('nama_file', TRUE));
		$id_dprdperawa	= $this->encryption->decrypt(escape($this->input->post('id_dprdperawa', TRUE)));
		$file_pendukung = escape($this->input->post('file_pendukung', TRUE));
		$year	 	   	= date('Y');
		$month	 	   	= date('m');
		$dirname 	   = 'upload/file/pendukung/dprdperawa/' . $year . '/' . $month . '/';
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
				'id_dprdperawa'		=> $id_dprdperawa,
				'file_pendukung'	=> $images,
				'status'			=> '1',
				'create_by' 		=> $this->db->escape_str($create_by),
				'create_date' 		=> $this->db->escape_str($create_date),
				'create_ip' 		=> $this->db->escape_str($create_ip),
				'mod_by' 			=> $this->db->escape_str($create_by),
				'mod_date' 			=> $this->db->escape_str($create_date),
				'mod_ip' 			=> $this->db->escape_str($create_ip)
			);
			$this->db->insert('ms_pendukungdprdperawa', $data);
			$updateDataStatus = array(
				'id_dprdperawa' 		=> $id_dprdperawa,
				'status' => 'selesai',
				'keterangan_permohonan'		=> 'selesai',
			);
			$this->db->where('id_dprdperawa', $id_dprdperawa);
			$this->db->update('ms_dprdperawa', $updateDataStatus);
			return array('message' => 'SUCCESS', 'kode' => '', 'nama' => $nama);
		}
	}

	public function getDataAdmindprdperawa($id_dprdperawa)
	{
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$query = $this->db->get('ms_dprdperawa');
		return $query->row_array();
	}

	public function getDataAdminUpload($id_dprdperawa)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, nama_file');
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$query = $this->db->get('ms_dprdupload_perawa');
		return $query->result_array();
	}

	public function getDatadprdperawaupload($id_dprdperawa)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, file_ktp,nik');
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$query = $this->db->get('ms_dprdperawa');
		return $query->row_array();
	}
	public function getDataUnlinkedit($idupload)
	{
		$this->db->select('date_format(a.create_date,"%Y") as year, 
							date_format(a.create_date,"%m") as month, 
							a.nama_file, 
							b.nik');
		$this->db->from('ms_dprdupload_perawa a');
		$this->db->join('ms_dprdperawa b', 'a.id_dprdperawa = b.id_dprdperawa', 'INNER');
		$this->db->where('a.id_adminupload', $idupload);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function deleteDatadprdperawa()
	{
		$id_dprdperawa = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));

		$checkFile 	= $this->getDatadprdperawaupload($id_dprdperawa);
		$file_ktp 	= $checkFile['file_ktp'];
		$year 		= $checkFile['year'];
		$month 		= $checkFile['month'];

		//cek data rs by id
		$dataCT = $this->getDataAdmindprdperawa($id_dprdperawa);
		$dataUP = $this->getDataAdminUpload($id_dprdperawa);
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

				$dirname = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik . '/' . $nama_file;
				unlink($dirname);
				$this->db->where('id_dprdperawa', $id_dprdperawa);
				$this->db->delete('ms_dprdupload_perawa');
			}

			$dirname = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik . '/' . $file_ktp;
			unlink($dirname);
			$this->db->where('id_dprdperawa', $id_dprdperawa);
			$this->db->delete('ms_dprdperawa');
			$this->delete_data_dukung($id_dprdperawa);
			return array('message' => 'SUCCESS', 'nama' => $name);
		}
	}

	public function getDataPendukung($id_dprdperawa)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, file_pendukung as file_support');
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$query = $this->db->get('ms_pendukungdprdperawa');
		return $query->row_array();
	}


	public function delete_data_dukung($id_dprdperawa)
	{
		$checkFile 		= $this->getDataPendukung($id_dprdperawa);
		//delete data file di table
		$file_support 	= $checkFile['file_support'];
		$year 			= $checkFile['year'];
		$month 			= $checkFile['month'];
		if ($checkFile != '') {
			$dirname = 'upload/file/pendukung/dprdperawa/' . $year . '/' . $month . '/' . $file_support;
			unlink($dirname);
			$this->db->where('id_dprdperawa', $id_dprdperawa);
			$this->db->delete('ms_pendukungdprdperawa');
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
	public function getDatadprdperawa($id)
	{
		$this->db->select('a.id_dprdperawa,
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
		$this->db->from('ms_dprdperawa a');
		$this->db->join('ms_dprdupload_perawa b', 'a.id_dprdperawa = b.id_dprdperawa', 'LEFT');
		$this->db->join('ms_administrasi c', 'b.id_administrasi = c.id_administrasi', 'LEFT');
		$this->db->join('ms_layanan_adm d', 'c.id_layanan = d.id_layanan', 'LEFT');
		$this->db->where('a.id_dprdperawa', $id);
		$this->db->order_by('a.id_dprdperawa DESC');
		$query = $this->db->get();
		return $query->row_array();
	}
	public function eksportpdf($no_reg)
	{
		$this->db->select('a.id_dprdperawa,
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
		$this->db->from('ms_dprdperawa a');
		$this->db->join('ms_dprdupload_perawa b', 'a.id_dprdperawa = b.id_dprdperawa', 'INNER');
		$this->db->join('ms_administrasi c', 'b.id_administrasi = c.id_administrasi', 'INNER');
		$this->db->join('ms_layanan_adm d', 'c.id_layanan = d.id_layanan', 'INNER');
		$this->db->where('a.no_urut', $no_reg);
		$this->db->order_by('a.id_dprdperawa DESC');
		$query = $this->db->get();
		return $query->row_array();
	}

	public function tampilDataAdmDprdPerawa($a)
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
							c.id_dprdperawa,
							c.file_ktp,
							c.keterangan_permohonan, 
							c.nama_lengkap');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_dprdupload_perawa b', 'a.id_administrasi = b.id_administrasi AND b.id_dprdperawa = ' . $a, 'LEFT');
		$this->db->join('ms_dprdperawa c', 	'c.id_dprdperawa = b.id_dprdperawa', 'LEFT');
		$this->db->where('a.id_layanan', 7);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen utama');
		$this->db->order_by('a.id_administrasi DESC');

		// SELECT * from ms_adminluarnegeri a INNER JOIN ms_adminupload_luarnegeri b ON a.id_adminluarnegeri = b.id_adminluarnegeri INNER JOIN ms_administrasi c ON b.id_administrasi = c.id_administrasi INNER JOIN ms_layanan_adm d ON c.id_layanan = d.id_layanan WHERE b.id_adminluarnegeri = '11' AND c.jenis_administrasi = 'dokumen utama'

		$query = $this->db->get();
		return $query->result();
	}
	public function tampilDataPendDprdPerawa($a)
	{
		$this->db->select('c.id_dprdperawa,
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
		$this->db->join('ms_dprdupload_perawa b', 'b.id_administrasi = a.id_administrasi', 'LEFT');
		$this->db->join('ms_dprdperawa c', 'b.id_dprdperawa = c.id_dprdperawa', 'INNER');

		// $this->db->join('ms_admincuti c', 'b.id_dprdperawa = c.id_dprdperawa AND c.id_dprdperawa = ' . $a, 'LEFT');
		$this->db->where('c.id_dprdperawa',  $a);
		$this->db->where('a.id_layanan', 7);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('b.id_dprdperawa DESC');

		$query = $this->db->get();
		return $query->result();
		// SELECT * from ms_admincuti a INNER JOIN ms_adminupload b ON a.id_adminluarnegeri = b.id_adminluarnegeri INNER JOIN ms_administrasi c ON b.id_administrasi = c.id_administrasi INNER JOIN ms_layanan_adm d ON c.id_layanan = d.id_layanan WHERE a.id_adminluarnegeri = '6' 
	}

	public function updatestatuspermohonan()
	{

		$id_dprdperawa 					= escape($this->input->post('id_dprdperawa', TRUE));
		$nama_lengkap 					= escape($this->input->post('nama_lengkap', TRUE));
		$status_permohonan				= escape($this->input->post('statusPermohonan', TRUE));
		$keterangan_permohonan			= escape($this->input->post('keterangan', TRUE));
		$data = array(
			'status'						=> $status_permohonan,
			'keterangan_permohonan'			=> $keterangan_permohonan,
		);
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$this->db->update('ms_dprdperawa', $data);
		return array('response' => 'SUCCESS', 'kode' => '', 'nama' => $nama_lengkap);
	}

	// function untuk edit data
	public function AmbildataDiri($a)
	{
		$this->db->select('*');
		$this->db->from('ms_dprdperawa');
		$this->db->where('id_dprdperawa', $a);
		$this->db->order_by('id_dprdperawa DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function EditDataPendDPRDPerawa($a)
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
			c.id_dprdperawa,
			c.file_ktp,
			c.keterangan_permohonan, 
			c.nama_lengkap');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_dprdupload_perawa b', 'a.id_administrasi = b.id_administrasi AND b.id_dprdperawa = ' . $a, 'LEFT');
		$this->db->join('ms_dprdperawa c', 	'c.id_dprdperawa = b.id_dprdperawa', 'LEFT');
		$this->db->where('a.id_layanan', 7);
		$this->db->where('a.status', 1);
		$this->db->where('a.jenis_administrasi', 'dokumen pendukung');
		$this->db->order_by('a.id_administrasi', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}
	public function updateDataDiri()
	{
		$id_dprdperawa 		= $this->input->post('id_dprdperawa', TRUE);
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
			'create_by' 			=> $this->db->escape_str($create_by),
			'create_date' 			=> $this->db->escape_str($create_date),
			'create_ip' 			=> $this->db->escape_str($create_ip),
			'mod_by' 				=> $this->db->escape_str($create_by),
			'mod_date' 				=> $this->db->escape_str($create_date),
			'mod_ip' 				=> $this->db->escape_str($create_ip)
		);
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$this->db->update('ms_dprdperawa', $data);
		// untuk unlik saat edit data
		return array('message' => 'SUCCESS', 'nama' => $nik);
	}
	// update dokumen KTP
	public function updateDataUploadKtp()
	{
		$id_dprdperawa = $this->input->post('id_dprdperawa', TRUE);
		$create_by     = $this->app_loader->current_account();
		$create_date   = date('Y-m-d H:i:s');
		$create_ip     = $this->input->ip_address();

		// ambil direktori administrasi
		$checkFile 		= $this->getDatadprdperawaupload($id_dprdperawa);
		// var_dump($checkFile);
		// exit;
		$nik 			= $checkFile['nik'];
		$year 			= $checkFile['year'];
		$month 			= $checkFile['month'];
		$namafile 		= $checkFile['file_ktp'];
		$dirname 	   	= 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;
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
			$dirnameunlink 	   			= 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik . '/' . $namafile;
			unlink($dirnameunlink);
			$this->db->where('id_dprdperawa', $id_dprdperawa);
			$this->db->update('ms_dprdperawa', $data);
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
		$id_dprdperawa 		= base64_decode($this->input->post('id_dprdperawa', TRUE));
		$id_administrasi 	= base64_decode($this->input->post('id_administrasi', TRUE));
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatadprdperawaupload($id_dprdperawa);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
					'id_dprdperawa' 		=> $id_dprdperawa,
					'id_administrasi' 		=> $id_administrasi,
					'nama_file'				=> $imagesPend,
					'create_by' 			=> $this->db->escape_str($create_by),
					'create_date' 			=> $this->db->escape_str($create_date),
					'create_ip' 			=> $this->db->escape_str($create_ip),
					'mod_by' 				=> $this->db->escape_str($create_by),
					'mod_date' 				=> $this->db->escape_str($create_date),
					'mod_ip' 				=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_dprdupload_perawa', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatadprdperawaupload($id_dprdperawa);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
				$dirnameunlink 	   			= 'upload/file/administrasi/dprdperawa/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $id_adminupload);
				$this->db->update('ms_dprdupload_perawa', $data);
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
		$iddprdperawapend = $this->input->post('iddprdperawapend', TRUE);
		$id_administrasi = $this->input->post('id_administrasi', TRUE);
		// ambil direktori pendukung
		$checkFile1 	= $this->getDatadprdperawaupload($iddprdperawapend);
		$nik			= $checkFile1['nik'];
		$year 			= $checkFile1['year'];
		$month 			= $checkFile1['month'];
		$dirname1	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
					'id_dprdperawa' 	=> $iddprdperawapend,
					'id_administrasi' 	=> $id_administrasi,
					'nama_file'			=> $imagesPend,
					'create_by' 		=> $this->db->escape_str($create_by),
					'create_date' 		=> $this->db->escape_str($create_date),
					'create_ip' 		=> $this->db->escape_str($create_ip),
					'mod_by' 			=> $this->db->escape_str($create_by),
					'mod_date' 			=> $this->db->escape_str($create_date),
					'mod_ip' 			=> $this->db->escape_str($create_ip)
				);
				$this->db->insert('ms_dprdupload_perawa', $data);
				return array('message' => 'SUCCESS', 'namafile' => $imagesPend, 'nama' => $nik);
			}
		} else {
			// ambil direktori administrasi
			$checkFile 		= $this->getDatadprdperawaupload($iddprdperawapend);
			$nik 			= $checkFile['nik'];
			$year 			= $checkFile['year'];
			$month 			= $checkFile['month'];
			$dirname 	   = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik;

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
				$dirnameunlink 	   			= 'upload/file/administrasi/dprdperawa/' . $yearunlink . '/' . $monthunlink . '/' . $nikunlink . '/' . $namafileunlink;
				unlink($dirnameunlink);
				$this->db->where('id_adminupload', $iduploadpend);
				$this->db->update('ms_dprdupload_perawa', $data);
				// untuk unlik saat edit data
				return array('message' => 'SUCCESS', 'namafile' => $images, 'nama' => $nik);
			}
		}
	}
	// delete dokumen edit pendukung
	public function deletedokumenpendukung()
	{

		$id 			= escape($this->input->post('id', TRUE));
		$checkFile 		= $this->getDataUnlinkedit($id);
		//delete data file di table
		$year 			= $checkFile['year'];
		$nik 			= $checkFile['nik'];
		$month 			= $checkFile['month'];
		$nama_file 		= $checkFile['nama_file'];

		if ($checkFile != '') {
			$dirname = 'upload/file/administrasi/dprdperawa/' . $year . '/' . $month . '/' . $nik . '/' . $nama_file;
			unlink($dirname);
			$this->db->where('id_adminupload', $id);
			$this->db->delete('ms_dprdupload_perawa');
			return array('message' => 'SUCCESS');
		}
	}
	public function updateajukankembali()
	{
		$id_dprdperawa 						= escape($this->input->post('id_dprdperawa', TRUE));
		$nama_lengkap 						= escape($this->input->post('nama_lengkap', TRUE));
		$data = array(
			'status'						=> 'diajukan',
			'keterangan_permohonan'			=> '',
		);
		$this->db->where('id_dprdperawa', $id_dprdperawa);
		$this->db->update('ms_dprdperawa', $data);
		return array('response' => 'SUCCESS', 'kode' => '', 'nama' => $nama_lengkap);
	}
}

// This is the end of auth signin model

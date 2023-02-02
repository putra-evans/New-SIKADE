<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of peralatan model
 *
 * @author Yogi "solop" Kaputra
 */

class model_admincuti extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('nik', 'Nomor Induk Kependudukan', 'required|trim');
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
	var $search = array('nama_lengkap', 'nama_lengkap', 'shortname');
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
			$this->db->where('id_admincuti', instansi($this->app_loader->current_account()));
		}
		return $this->db->count_all_results('ms_admincuti');
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
		$this->db->select('a.id_admincuti,
													a.nama_lengkap,
		 											a.nik,
													a.file_ktp,
		 											a.nik,
		 											a.create_date,
		 											a.alamat,
		 											a.pemda_lembaga_umum,
													a.status,
		 											b.nm_instansi,
													c.status as status_pendukung,
													c.file_pendukung,
													c.create_date as date_pendukung');
		$this->db->from('ms_admincuti a');
		$this->db->join('ms_instansi b', 'b.id_instansi = a.id_instansi', 'LEFT');
		$this->db->join('ms_pendukung c', 'c.id_admincuti = a.id_admincuti', 'LEFT');
		$this->db->order_by('a.id_admincuti', 'DESC');
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
		$this->db->order_by('a.id_admincuti ASC');
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
		$this->db->where('a.id_layanan', 4);
		$this->db->where('b.group', 1);
		$this->db->order_by('a.id_administrasi', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getDataDetailPendukung($id_pendukung)
	{
		$this->db->where('id_pendukung', $id_pendukung);
		$query = $this->db->get('ms_pendukung');
		return $query->row_array();
	}

	/* Fungsi untuk insert data */
	public function insertDataadmincuti()
	{
		//get data
		$create_by     = $this->app_loader->current_account();
		$instansi 	   = instansi($this->app_loader->current_account());
		$create_date   = date('Y-m-d H:i:s');
		$create_ip     = $this->input->ip_address();
		$nikGet        = escape($this->input->post('nik', TRUE));
		$nama          = escape($this->input->post('nama_lengkap', TRUE));
		$file_ktp      = escape($this->input->post('file_ktp', TRUE));
		$dokumen	   = escape($this->input->post('id_doc', TRUE));
		$year	 	   = date('Y');
		$month	 	   = date('m');
		$dirname 	   = 'upload/file/cuti/' . $year . '/' . $month . '/' . $nikGet;
		if (!is_dir($dirname)) {
			mkdir('./' . $dirname, 0777, TRUE);
		}
		$jumlahnik    = strlen($nikGet);
		if ($jumlahnik != 16) {
			return array('response' => 'NIKGAGAL', 'kode' => '', 'NIK' => $nikGet);
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
		if (!$this->upload->do_upload('file_ktp')) {
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
				'id_instansi'				=> $this->db->escape_str($instansi),
				'status' 					=> '1',
				'create_by' 				=> $this->db->escape_str($create_by),
				'create_date' 				=> $this->db->escape_str($create_date),
				'create_ip' 				=> $this->db->escape_str($create_ip),
				'mod_by' 					=> $this->db->escape_str($create_by),
				'mod_date' 					=> $this->db->escape_str($create_date),
				'mod_ip' 					=> $this->db->escape_str($create_ip)
			);
			/*query insert*/
			$this->db->insert('ms_admincuti', $data);
			$id = $this->db->insert_id();
			//insert file upload 
			if (count($dokumen) > 0) {
				for ($i = 1; $i <= count($dokumen); $i++) {
					$idAdm = escape($this->input->post('id_doc[' . $i . ']', TRUE));
					$newconfig = array(
						'upload_path' 		=> './' . $dirname . '/',
						'allowed_types' 	=> 'png|jpg|jpeg|pdf',
						'file_name'			=> 'file_upload_' . $nikGet . '_' . $id,
						'file_ext_tolower'	=> TRUE,
						'max_size' 			=> 10240,
						'max_filename' 		=> 0,
						'remove_spaces' 	=> TRUE,
					);
					$this->load->library('upload', $newconfig);
					$this->upload->initialize($newconfig);
					if (!$this->upload->do_upload('file_doc_' . $i)) {
						return array('response' => 'NOUPLOAD', 'kode' => '', 'nama' => $nama);
					} else {
						$upload_file = $this->upload->data();
						$nama_file   = $upload_file['file_name'];
						$data_file = array(
							'id_admincuti'				=> $id,
							'id_administrasi'			=> $idAdm,
							'nama_file'					=> $nama_file,
							'create_by' 				=> $create_by,
							'create_date' 				=> $create_date,
							'create_ip' 				=> $create_ip,
							'mod_by' 					=> $create_by,
							'mod_date' 					=> $create_date,
							'mod_ip' 					=> $create_ip
						);
						/*query insert*/
						$this->db->insert('ms_adminupload', $data_file);
					}
				}
			}
			return array('response' => 'SUCCESS', 'kode' => $noreg, 'nama' => $nama);
		}
	}

	public function insertDataPendukung()
	{
		$create_by     	= $this->app_loader->current_account();
		$create_date   	= date('Y-m-d H:i:s');
		$create_ip     	= $this->input->ip_address();
		$nama			= escape($this->input->post('nama_file', TRUE));
		$id_admincuti	= $this->encryption->decrypt(escape($this->input->post('id_admincuti', TRUE)));
		$file_pendukung = escape($this->input->post('file_pendukung', TRUE));
		$year	 	   	= date('Y');
		$month	 	   	= date('m');
		$dirname 	   = 'upload/file/pendukung/' . $year . '/' . $month . '/';
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
				'id_admincuti'		=> $id_admincuti,
				'file_pendukung'	=> $images,
				'status'			=> '1',
				'create_by' 		=> $this->db->escape_str($create_by),
				'create_date' 		=> $this->db->escape_str($create_date),
				'create_ip' 		=> $this->db->escape_str($create_ip),
				'mod_by' 			=> $this->db->escape_str($create_by),
				'mod_date' 			=> $this->db->escape_str($create_date),
				'mod_ip' 			=> $this->db->escape_str($create_ip)
			);
			$this->db->insert('ms_pendukung', $data);
			return array('message' => 'SUCCESS', 'kode' => '', 'nama' => $nama);
		}
	}

	public function updateDataPendukung()
	{

		$id_layanan	= $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		$nama		= escape($this->input->post('nm_layanan', TRUE));
		$sop      	= escape($this->input->post('sop', TRUE));
		$id_group   = escape($this->input->post('id_group', TRUE));
		$dirname 	   	= 'upload/sop';
		if (!is_dir($dirname)) {
			mkdir('./' . $dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './' . $dirname . '/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> $sop,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('sop')) {
			return array('response' => 'NOFILE', 'kode' => '', 'nama' => $nama);
		} else {
			$upload_data = $this->upload->data();
			$images  = $upload_data['file_name'];
			$noreg = time();
			$data = array(
				'nm_layanan'	=> $nama,
				'sop'			=> $images,
				'group'			=> $id_group,
				'status'		=> escape($this->input->post('status', TRUE))
			);
			$this->db->where('id_layanan', $id_layanan);
			$this->db->update('ms_layanan_adm', $data);
			return array('response' => 'SUCCESS', 'nama' => $nama);
		}
	}

	public function getDataAdmincuti($id_admincuti)
	{
		$this->db->where('id_admincuti', $id_admincuti);
		$query = $this->db->get('ms_admincuti');
		return $query->row_array();
	}

	public function deleteDataAdmincuti()
	{
		$id_admincuti = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		//cek data rs by id
		$dataCT = $this->getDataAdmincuti($id_admincuti);
		$name	= !empty($dataCT) ? $dataCT['nama_lengkap'] : '';
		if (count($dataCT) <= 0)
			return array('message' => 'ERROR');
		else {
			$this->db->where('id_admincuti', $id_admincuti);
			$this->db->delete('ms_admincuti');
			$this->delete_data_dukung($id_admincuti);
			return array('message' => 'SUCCESS', 'nama' => $name);
		}
	}

	public function getDataPendukung($id_admincuti)
	{
		$this->db->select('date_format(create_date,"%Y") as year, date_format(create_date,"%m") as month, file_pendukung as file_support');
		$this->db->where('id_admincuti', $id_admincuti);
		$query = $this->db->get('ms_pendukung');
		return $query->row_array();
	}


	public function delete_data_dukung($id_admincuti)
	{
		$checkFile 		= $this->getDataPendukung($id_admincuti);
		//delete data file di table
		$file_support 	= $checkFile['file_support'];
		$year 			= $checkFile['year'];
		$month 			= $checkFile['month'];

		$dirname = 'upload/file/pendukung/' . $year . '/' . $month . '/' . $file_support;
		unlink($dirname);
		$this->db->where('id_admincuti', $id_admincuti);
		$this->db->delete('ms_pendukung');
	}

	public function getDataListCutiReport($cuti)
	{
		$this->db->select('a.id_admincuti,
									a.nama_lengkap,
									a.nik,
									a.file_ktp,
									a.alamat,
									a.pemda_lembaga_umum,
									a.status,
									c.nm_layanan
											 ');
		if ($cuti != '')
			$this->db->where('a.id_admincuti', $cuti);
		$this->db->order_by('a.id_admincuti ASC');
		$this->db->from('ms_administrasi b');
		$this->db->join('ms_layanan_adm c', 'c.id_layanan = b.id_layanan', 'INNER');
		$query = $this->db->get('ms_admincuti a');
		return $query->result_array();
	}

	/*Fungsi get data edit by id dan url*/
	public function getDataCuti($noreg)
	{
		$this->db->select('a.id_admincuti,
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
		$this->db->from('ms_admincuti a');
		$this->db->join('ms_adminupload b', 'a.id_admincuti = b.id_admincuti', 'INNER');
		$this->db->join('ms_administrasi c', 'b.id_administrasi = c.id_administrasi', 'INNER');
		$this->db->join('ms_layanan_adm d', 'c.id_layanan = d.id_layanan', 'INNER');
		$this->db->where('no_urut', $noreg);
		$this->db->order_by('a.id_admincuti DESC');
		$query = $this->db->get();
		return $query->row_array();
	}
}

// This is the end of auth signin model

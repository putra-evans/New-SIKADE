<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yogi "solop" Kaputra
 */

class Model_administrasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nama_administrasi', 'Nama administrasi', 'required|trim');
		$this->form_validation->set_rules('id_layanan', 'Instansi', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required|trim');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	var $search = array('nm_layanan', 'nama_administrasi', 'jenis_administrasi');
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
			$this->db->where('id_layanan', instansi($this->app_loader->current_account()));
		}
		return $this->db->count_all_results('ms_administrasi');
	}

	private function _get_datatables_query($param)
	{
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}
		$this->db->select('a.id_administrasi,
							 a.nama_administrasi,
							 a.jenis_administrasi,
							 a.id_layanan,
							 a.status,
							 b.nm_layanan');
		$this->db->from('ms_administrasi a');
		$this->db->join('ms_layanan_adm b', 'a.id_layanan = b.id_layanan', 'INNER');
		$this->db->order_by('a.id_administrasi', 'DESC');

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
		$this->db->order_by('b.id_layanan ASC');
	}

	public function getDataListadministrasiReport($instansi, $status)
	{
		if ($instansi != '')
			$this->db->where('id_layanan', $instansi);
		if ($status != '')
			$this->db->where('status', $status);
		$this->db->order_by('id_administrasi ASC');
		$query = $this->db->get('ms_administrasi');
		return $query->result_array();
	}

	public function getDataDetailadministrasi($id_administrasi)
	{
		$this->db->where('id_administrasi', $id_administrasi);
		$query = $this->db->get('ms_administrasi');
		return $query->row_array();
	}

	public function getDataDetailPendukung($id_pendukung)
	{
		$this->db->where('id_pendukung', $id_pendukung);
		$query = $this->db->get('ms_pendukung');
		return $query->row_array();
	}

	public function insertDataadministrasi()
	{
		$create_by    		= $this->app_loader->current_account();
		$create_date 		= gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
		$create_ip    		= $this->input->ip_address();
		$nama_administrasi	= escape($this->input->post('nama_administrasi', TRUE));

		$data = array(
			'nama_administrasi'	=> escape($this->input->post('nama_administrasi', TRUE)),
			'id_layanan'		=> escape($this->input->post('id_layanan', TRUE)),
			'jenis_administrasi'			=> escape($this->input->post('jenis', TRUE)),
			'status'			=> escape($this->input->post('status', TRUE)),
			'create_by'			=> $create_by,
			'create_date'		=> $create_date,
			'create_ip'			=> $create_ip,
			'mod_by'			=> $create_by,
			'mod_date'			=> $create_date,
			'mod_ip'			=> $create_ip
		);
		$this->db->insert('ms_administrasi', $data);
		return array('message' => 'SUCCESS', 'nama' => $nama_administrasi);
	}

	public function updateDataadministrasi()
	{
		$create_by    		= $this->app_loader->current_account();
		$create_date 		= gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
		$create_ip    		= $this->input->ip_address();
		$id_administrasi	= $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		$nama_administrasi	= escape($this->input->post('nama_administrasi', TRUE));

		$data = array(
			'nama_administrasi'	=> escape($this->input->post('nama_administrasi', TRUE)),
			'jenis_administrasi' => escape($this->input->post('jenis', TRUE)),
			'id_layanan'	=> escape($this->input->post('id_layanan', TRUE)),
			'status'		=> escape($this->input->post('status', TRUE)),
			'create_by'		=> $create_by,
			'create_date'	=> $create_date,
			'create_ip'		=> $create_ip,
			'mod_by'		=> $create_by,
			'mod_date'		=> $create_date,
			'mod_ip'		=> $create_ip
		);
		$this->db->where('id_administrasi', $id_administrasi);
		$this->db->update('ms_administrasi', $data);
		return array('message' => 'SUCCESS', 'nama' => $nama_administrasi);
	}

	public function deleteDataadministrasi()
	{
		$id_administrasi = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		//cek data rs by id
		$dataGd = $this->getDataDetailadministrasi($id_administrasi);
		$name	= !empty($dataGd) ? $dataGd['nama_administrasi'] : '';
		if (count($dataGd) <= 0)
			return array('message' => 'ERROR');
		else {
			$this->db->where('id_administrasi', $id_administrasi);
			$this->db->delete('ms_administrasi');
			return array('message' => 'SUCCESS', 'nama' => $name);
		}
	}
}

// This is the end of auth signin model

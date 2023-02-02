<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yogi "solop" Kaputra
 */

class Model_fasilitasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nm_layanan', 'Nama layanan', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
  	validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	var $search = array('nm_layanan', 'nm_layanan', 'shortname');
	public function get_datatables($param)
  {
    $this->_get_datatables_query($param);
    if($_POST['length'] != -1)
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
  	if($this->app_loader->is_operator()) {
      $this->db->where('id_layanan', instansi($this->app_loader->current_account()));
    }
    return $this->db->count_all_results('ms_layanan_adm');
  }

  private function _get_datatables_query($param)
  {
	$post = array();
	if (is_array($param)) {
      foreach ($param as $v) {
        $post[$v['name']] = $v['value'];
      }
    }
		$this->db->select('a.id_layanan,
							 a.nm_layanan,
							 a.sop,
							 a.group,
							 a.status,
							 b.nm_group
							 ');
	$this->db->from('ms_layanan_adm a');
	$this->db->join('ms_group b', 'a.group = b.id_group', 'INNER');

    $i = 0;
    foreach ($this->search as $item) { // loop column
      if($_POST['search']['value']) { // if datatable send POST for search
        if($i===0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
		$this->db->order_by('a.id_layanan ASC');
  }

	public function getDataListlayananReport($instansi, $status)
	{
		if($instansi != '')
			$this->db->where('id_layanan', $instansi);
		if($status != '')
			$this->db->where('status', $status);
		$this->db->order_by('id_layanan ASC');
		$query = $this->db->get('ms_layanan_adm');
    return $query->result_array();
	}

	public function getDataDetaillayanan($id_layanan)
	{
		$this->db->where('id_layanan', $id_layanan);
		$query = $this->db->get('ms_layanan_adm');
		return $query->row_array();
	}

	public function insertDatafasilitasi()
	{
		$nama			= escape($this->input->post('nm_layanan', TRUE));
		$sop      		= escape($this->input->post('sop', TRUE));
		$id_group      	= escape($this->input->post('id_group', TRUE));
		$dirname 	   	= 'upload/sop';
		if (!is_dir($dirname)) {
			mkdir('./'.$dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './'.$dirname.'/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> $sop,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('sop')) {
			return array('response'=>'NOFILE', 'kode'=>'', 'nama'=>$nama);
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
			$this->db->insert('ms_layanan_adm', $data);
			return array('response'=>'SUCCESS','kode'=>'', 'nama'=>$nama);
		}

			
	}

	public function updateDatafasilitasi()
	{
		
		$id_layanan	= $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		$nama		= escape($this->input->post('nm_layanan', TRUE));
		$sop      	= escape($this->input->post('sop', TRUE));
		$id_group   = escape($this->input->post('id_group', TRUE));
		$dirname 	   	= 'upload/sop';
		if (!is_dir($dirname)) {
			mkdir('./'.$dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './'.$dirname.'/',
			'allowed_types' 	=> 'png|jpg|jpeg|pdf',
			'file_name'			=> $sop,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 10240,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('sop')) {
			return array('response'=>'NOFILE', 'kode'=>'', 'nama'=>$nama);
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
			return array('message'=>'SUCCESS', 'nama'=>$nama);
		}
			
	}

	public function deleteDatafasilitasi()
	{
		$id_layanan = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		//cek data rs by id
		$dataGd = $this->getDataDetaillayanan($id_layanan);
		$name	= !empty($dataGd) ? $dataGd['nm_layanan'] : '';
		if(count($dataGd) <= 0)
			return array('message'=>'ERROR');
		else {
			$this->db->where('id_layanan', $id_layanan);
			$this->db->delete('ms_layanan_adm');
			return array('message'=>'SUCCESS', 'nama'=>$name);
		}
	}


}

// This is the end of auth signin model

<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model odp
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

  public function getDataInstansi()
  {
    $this->db->order_by('id_instansi ASC');
    $query = $this->db->get('ms_instansi');
    $dd_instansi[''] = 'Pilih Instansi';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_instansi[$row['id_instansi']] = $row['nm_instansi'];
      }
    }
    return $dd_instansi;
  }

  public function getDataMasterInstansi($id)
  {
    $this->db->where('instansi_id', $id);
    $this->db->order_by('id_instansi ASC');
    $query = $this->db->get('ms_instansi');
    return $query->result_array();
  }

}

// This is the end of auth signin model

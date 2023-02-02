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

	public function getDataFasilitasi()
  {
		$this->db->order_by('id_layanan ASC');
		$query = $this->db->get('ms_layanan_adm');
    $dd_fasilitas[''] = 'Pilih Fasilitasi';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_fasilitas[$row['id_layanan']] = $row['nm_layanan'];
      }
    }
    return $dd_fasilitas;
  }

  public function getDataGroup()
  {
		$this->db->order_by('id_group ASC');
		$query = $this->db->get('ms_group');
    $dd_fasilitas[''] = 'Pilih Pelayanan Administrasi';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_fasilitas[$row['id_group']] = $row['nm_group'];
      }
    }
    return $dd_fasilitas;
  }

}

// This is the end of auth signin model

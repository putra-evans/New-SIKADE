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
    $instansi = instansi($this->app_loader->current_account());
    if($this->app_loader->is_operator()) {
      $this->db->where('id_instansi', $instansi);
    }

    $this->db->where('id_instansi >2');
    $this->db->where('id_instansi <74');
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

  public function getDataGedung()
  {
    $instansi = instansi($this->app_loader->current_account());
    if($this->app_loader->is_operator()) {
      $this->db->where('id_instansi', $instansi);
    }
    $this->db->order_by('id_gedung ASC');
    $query = $this->db->get('ms_gedung');
    $dd_gedung[''] = 'Pilih Gedung';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_gedung[$row['id_gedung']] = $row['nama_gedung'];
      }
    }
    return $dd_gedung;
  }

  public function getDataLantai()
  {
    $instansi = instansi($this->app_loader->current_account());
    if($this->app_loader->is_operator()) {
      $this->db->where('b.id_instansi', $instansi);
    }
    $this->db->join('ms_gedung b', 'b.id_gedung = a.id_gedung', 'INNER');
    $this->db->order_by('a.id_lantai ASC');
    $query = $this->db->get('ms_lantai a');
    $dd_lantai[''] = 'Pilih Lantai';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_lantai[$row['id_lantai']] = $row['nama_lantai'];
      }
    }
    return $dd_lantai;
  }

  public function getDataKategori()
  {
    $this->db->order_by('id_kategori ASC');
    $query = $this->db->get('ms_kategori');
    $dd_kategori[''] = 'Pilih Kategori Ruangan';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_kategori[$row['id_kategori']] = $row['nm_kategori'];
      }
    }
    return $dd_kategori;
  }

  public function getDataRuangan()
  {
    $instansi = instansi($this->app_loader->current_account());
    if($this->app_loader->is_operator()) {
      $this->db->where('b.id_instansi', $instansi);
    }
    $this->db->join('ms_lantai c', 'c.id_lantai = a.id_lantai', 'INNER');
    $this->db->join('ms_gedung b', 'b.id_gedung = c.id_gedung', 'INNER');
    $this->db->order_by('a.id_ruangan ASC');
    $query = $this->db->get('ms_ruangan a');
    $dd_ruangan[''] = 'Pilih Ruangan';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_ruangan[$row['id_ruangan']] = $row['nama_ruangan'];
      }
    }
    return $dd_ruangan;
  }

  public function getDataPeralatan()
  {
    $this->db->order_by('id_peralatan ASC');
    $query = $this->db->get('ms_peralatan');
    $dd_peralatan[''] = 'Pilih Peralatan';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_peralatan[$row['id_peralatan']] = $row['nama_peralatan'];
      }
    }
    return $dd_peralatan;
  }

  public function getTipePeralatanByPeralatan($id)
  {
		$this->db->where('id_peralatan', $id);
		$this->db->order_by('nama_peralatan_detail ASC');
		$query = $this->db->get('ms_peralatan_detail');
    return $query->result_array();
  }

  public function getTypeGedung()
  {
    $this->db->order_by('id_type ASC');
    $query = $this->db->get('ms_type');
    $dd_type[''] = 'Type Gedung';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_type[$row['id_type']] = $row['name_type'];
      }
    }
    return $dd_type;
  }

  public function getDataMasterInstansi($id)
  {
    $this->db->where('instansi_id', $id);
    $this->db->order_by('id_instansi ASC');
    $query = $this->db->get('ms_instansi');
    return $query->result_array();
  }

  public function getDataMasterGedung($id)
  {
    $this->db->where('gedung_id', $id);
    $this->db->order_by('id_gedung ASC');
    $query = $this->db->get('ms_gedung');
    return $query->result_array();
  }

  public function getDataMasterPeralatan($id)
  {
    $this->db->where('peralatan_id', $id);
    $this->db->order_by('id_peralatan ASC');
    $query = $this->db->get('ms_peralatan');
    return $query->result_array();
  }

}

// This is the end of auth signin model

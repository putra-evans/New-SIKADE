<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_home extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*Fungsi Geta Data Kelengkapan Administrasi*/
	public function getDataLayanan()
	{
		$this->db->select('a.id_layanan,
												a.nm_layanan,
												a.sop,
												a.group,
												a.status
												');
		$this->db->from('ms_layanan_adm a');
		$this->db->order_by('a.id_layanan', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getCountAllNotification()
	{
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		return $this->db->count_all_results('ta_notification');
	}

	public function updateDataNotificationAll()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		//update notifikasi
		$this->db->set('unread', 2);
		$this->db->set('mod_by', $create_by);
		$this->db->set('mod_date', $create_date);
		$this->db->set('mod_ip', $create_ip);
		$this->db->where('unread', 1);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		$this->db->update('ta_notification');
		return TRUE;
	}

	public function updateDataNotificationByToken($token)
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		//update notifikasi
		$this->db->set('unread', 2);
		$this->db->set('mod_by', $create_by);
		$this->db->set('mod_date', $create_date);
		$this->db->set('mod_ip', $create_ip);
		$this->db->where('token', $token);
		$this->db->where('unread', 1);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		$this->db->update('ta_notification');
		return TRUE;
	}

	public function deleteDataNotification()
	{
		$token = $this->input->post('checkid');
		foreach ($token as $key => $t) {
			$this->db->where('token', $t);
			$this->db->delete('ta_notification');
		}
		return TRUE;
	}
}

// This is the end of auth signin model

<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of halkade model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_haldprd extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDataListNotification($limit, $offset)
	{
		$this->db->select('a.token,
											 a.sender_id,
											 a.recipient_id,
											 a.type,
											 a.parameters,
											 a.reference,
											 a.unread,
											 DATE_FORMAT(a.create_date, "%d/%m/%Y %h:%i %p") AS create_date,
											 b.fullname,
											 (CASE a.type
											 	WHEN "otg.new" THEN "verifikasi-kasus/kasus-otg"
												WHEN "odp.new" THEN "verifikasi-kasus/kasus-odp"
												WHEN "otg.verified" THEN "otg"
												WHEN "odp.verified" THEN "odp"
												WHEN "case.new" THEN "verifikasi-kasus/kasus"
												WHEN "case.ref" THEN CONCAT("konfirmasi-kasus/identifikasi/review/", a.parameters)
												WHEN "swab.new" THEN "spesimen/pengujian"
												WHEN "swab.result" THEN "konfirmasi-kasus/spesimen"
												WHEN "case.verified" THEN CONCAT("konfirmasi-kasus/identifikasi/review/", a.parameters)
												WHEN "data.new" THEN "rekapitulasi/daily"
												ELSE "halkade"
											 END) AS url');
		$this->db->from('ta_notification a');
		$this->db->join('xi_sa_users b', 'a.sender_id = b.username', 'inner');
		if (!$this->app_loader->is_admin()) {
			$this->db->where('a.recipient_id', $this->app_loader->current_account());
		}
		$this->db->order_by('a.create_date DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result_array();
	}
}

// This is the end of auth signin model

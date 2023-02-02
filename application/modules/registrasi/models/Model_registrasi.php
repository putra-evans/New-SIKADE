<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of auth signin model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_registrasi extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		if ($role == 'new') {
			$valid = 'required|';
		} else {
			$valid = ($this->input->post('password') != '') ? 'required|' : '';
		}
		$this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('tempatLahir', 'Tempat Lahir', 'required');
		$this->form_validation->set_rules('tanggalLahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[xi_sa_users.email]');
		$this->form_validation->set_rules('noHandphone', 'No Handphone', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[6]|alpha_dash');
		$this->form_validation->set_rules('password', 'Password', $valid . 'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
		$this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid . 'matches[password]');
		// $this->form_validation->set_rules('scanId', 'Scan Asli Identitas', 'required');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function insertDataregistrasi()
	{
		$namaLengkap = escape($this->input->post('namaLengkap', TRUE));
		$tempatLahir = escape($this->input->post('tempatLahir', TRUE));
		$tanggalLahir = escape($this->input->post('tanggalLahir', TRUE));
		$username = escape($this->input->post('username', TRUE));
		$password = escape($this->input->post('password', TRUE));
		$jenisKelamin = escape($this->input->post('jenisKelamin', TRUE));
		$alamat = escape($this->input->post('alamat', TRUE));
		$rt = escape($this->input->post('rt', TRUE));
		$rw = escape($this->input->post('rw', TRUE));
		$email = escape($this->input->post('email', TRUE));
		$noHandphone = escape($this->input->post('noHandphone', TRUE));
		$scanId = escape($this->input->post('scanId', TRUE));

		// var_dump('post');
		// exit;
		$create_date = date('Y-m-d H:i:s');
		$create_ip   = $this->input->ip_address();
		$token = generateToken($namaLengkap, $email);

		$year	 	   = date('Y');
		$month	 	   = date('m');
		$dirname 	   = 'upload/file/registrasi/';
		if (!is_dir($dirname)) {
			mkdir('./' . $dirname, 0777, TRUE);
		}
		$config = array(
			'upload_path' 		=> './' . $dirname . '/',
			'allowed_types' 	=> 'jpg|jpeg',
			'file_name'			=> $scanId,
			'file_ext_tolower'	=> TRUE,
			'max_size' 			=> 512000,
			'max_filename' 		=> 0,
			'remove_spaces' 	=> TRUE,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('scanId')) {
			return array('response' => 'NOFILE', 'kode' => '', 'nama' => $namaLengkap);
		} else {
			$upload_data = $this->upload->data();
			$images  = $upload_data['file_name'];
			$data = array(
				'token'				  	 => $token,
				'username' 				 => $username,
				'password' 				 => $this->bcrypt->hash_password($password),
				'email' 				 => $email,
				'fullname' 				 => $namaLengkap,
				'tempat_lahir' 			 => $tempatLahir,
				'tanggal_lahir' 		 => $tanggalLahir,
				'jenis_kelamin' 		 => $jenisKelamin,
				'alamat' 		 		 => $alamat,
				'no_hp' 		 		 => $noHandphone,
				'scan_identitas' 		 => $images,
				'foto_profile' 			 => 'default.png',
				'blokir' 				 => '0',
				'id_status' 			 => '0',
				'validate_email_code'	 => '',
				'validate_email_status'	 => 0,
				'reset_password_code'	 => '',
				'reset_password_status'	 => 0,
				'reset_password_expired' => 0,
				'create_date' 			 => $create_date,
				'create_ip' 			 => $create_ip,
				'mod_date' 				 => $create_date,
				'mod_ip' 				 => $create_ip
			);
			/*query insert*/
			$this->db->where('username', $username);
			$nUser = $this->db->count_all_results('xi_sa_users');
			if ($nUser > 0) {
				return array('response' => 'ERROR', 'note' => $username);
			} else {
				$this->db->insert('xi_sa_users', $data);
				$id_users = $this->db->insert_id();
				$this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
				$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => 4, 'id_status' => 1));
				//insert file upload 
				return array('response' => 'SUCCESS', 'note' => $username);
			}
		}
	}
}

// This is the end of auth signin model

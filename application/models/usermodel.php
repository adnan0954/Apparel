<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model 
{
	public function Login()
	{
		$this->db->where("email", strtolower($this->input->post('Email')));
		$this->db->where("password", ENCRYPTME($this->input->post('Password')));
		$query = $this->db->get("user");

		if($query->num_rows() == 1)
		{
			$rows = $query->row_array();
			$this->session->set_userdata(
				array(
					'email' => $rows['email'],
					'firstname' =>$rows['firstname'],
					'lastname' => $rows['lastname'],
					'loggedin' => TRUE,
					'verified' => $rows['status'],
					'ispremium' => $rows['ispremium']
					));
			return TRUE;
		}
		return FALSE;
	}

	public function RefreshUserData()
	{
		$this->db->where("email", Email());
		$query = $this->db->get("user");

		if($query->num_rows() == 1)
		{
			$rows = $query->row_array();
			$this->session->set_userdata(
				array(
					'email' => $rows['email'],
					'firstname' =>$rows['firstname'],
					'lastname' => $rows['lastname'],
					'verified' => $rows['status'],
					'ispremium' => $rows['ispremium']
					));
		}
	}

	public function CheckUserExist($email)
	{
		$this->db->where("email", strtolower($email));
		$query = $this->db->get("user");
		if($query->num_rows() == 1)
		{
			return TRUE;
		}
		else return FALSE;
	}

	public function CreateUser()
	{
		$data = array(
			'email' => strtolower($this->input->post('Email')),
			'firstname' => $this->input->post('FirstName'),
			'lastname' => $this->input->post('LastName'),
			'password' => ENCRYPTME($this->input->post('Password')),
			'datecreated' => date('Y-m-d H:i:s'),
			'slots' => '0',
			'ispremium' => '0',
			'status' => '0'
			);

		if($this->db->insert('user', $data))
		{
			$this->load->helper('mail');
			SendVerificationMail();
			return TRUE;
		}
		else FALSE;
	}


	public function CheckPassword($password)
	{
		$this->db->where("email", Email());
		$this->db->where("password", ENCRYPTME($Password));
		$query = $this->db->get("user");
		if($query->num_rows() == 1)
		{
			return TRUE;
		}
		else return FALSE;

	}

	public function UpdatePassword($password)
	{
		$data = array('password' => ENCRYPTME($Password));
		$this->db->where('email', Email());
		if($this->db->update('user', $data))
		{
			return TRUE;
		}
		else return FALSE;
	}

	public function VerifyUser($hash)
	{
		$query = $this->db->get_where('verify', array('hash' => $hash), 1);
		if($query->num_rows() == 1)
		{
			$result = $query->row_array();
			$this->db->where('email', $result['email']);
			$this->db->update('user', array('status' => '1'));
			$this->db->where('email', $result['email']);
			$this->db->delete('verify');
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function reset_pass($hash)
	{
		$query = $this->db->get_where('user', array('hash' => $hash), 1);
		if($query->num_rows() == 1){
			$data = array('hash' => '');
			$this->db->where('hash', $hash);
			$this->db->update('user', $data);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function LogOut()
	{
		$this->session->unset_userdata(
			array(
				'email' => "",
				'firstname' => "",
				'lastname' => "",
				'loggedin' => FALSE,
				'verified' => "",
				'ispremium' => ""
				));

		$this->session->sess_destroy();
		return;
	}
}
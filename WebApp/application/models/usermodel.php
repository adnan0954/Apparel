<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model 
{
	public function Login()
	{
		$this->db->where("handle", strtolower($this->input->post('Username')));
		$this->db->where("password", ENCRYPTME($this->input->post('Password')));
		
		$query = $this->db->get("user");

		if($query->num_rows() == 1)
		{
			$rows = $query->row_array();
			$this->session->set_userdata(
				array(
					'email' => $rows['email'],
					'name' => $rows['name'],
					'handle' => $rows['handle'],
					'loggedin' => TRUE,
					'bio' => $rows['bio'],
					'number' => $rows['number'],
					'tags' => explode('/', $rows['tags']),
					'address' => $rows['address'],
					'followers' => $rows['followers'],
					'following' => $rows['following'],
					'profile' => $rows['profile']
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
					'name' =>$rows['name'],
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

	public function CheckHandleExist($handle)
	{
		$this->db->where("handle", strtolower($handle));
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
			'handle' => strtolower($this->input->post('Username')),
			'name' => $this->input->post('Fullname'),
			'password' => ENCRYPTME($this->input->post('Password')),
			'datecreated' => date('Y-m-d H:i:s'),
			'following' => 0,
			'followers' => 0,
			);

		if($this->db->insert('user', $data))
		{
			$this->session->set_userdata(
				array(
					'email' => strtolower($this->input->post('Email')),
					'name' => $this->input->post('Fullname'),
					'handle' => $this->input->post('Username'),
					'loggedin' => TRUE,
					'bio' => "",
					'number' => "",
					'tags' => array(),
					'address' => "",
					'followers' => 0,
					'following' => 0,
					'profile' => $rows['profile']
					));

			return TRUE;
		}
		else FALSE;
	}

	public function UpdateUser()
	{

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
					'email' => '',
					'name' => '',
					'handle' => '',
					'loggedin' => FALSE,
					'bio' => '',
					'number' => '',
					'tags' => array(),
					'address' => '',
					'followers' => '',
					'following' => '',
					'profile' => ''
				));

		$this->session->sess_destroy();
		return;
	}
}
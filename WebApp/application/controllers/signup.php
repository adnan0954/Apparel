<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');
	}

	public function index()
	{
		$error = "";
		$this->validation();

		if($this->input->post('ck_username'))
		{
			if ($this->UserModel->CheckHandleExist(Clean($this->input->post('username'))))
			{
				echo "0";
			}
			else echo "1";
			exit();
		}

		if($this->input->post('ck_email'))
		{
			if ($this->UserModel->CheckUserExist(Clean($this->input->post('email'))))
			{
				echo "0";
			}
			else echo "1";
			exit();
		}		
		
		if($this->input->post('Register'))
		{
			if ($this->form_validation->run() == FALSE)
			{}
			else
			{	
				if($this->UserModel->CreateUser())
				{
					LogAccess();
					redirect('welcome');
					return;
				}
				else
				{
					$error = "Error creating account";
				}
			}
		}
		
		$data['Error'] = $error;
		Head('SIGNUP');
		GetHeader();
		$this->load->view('signup', $data);
		Footer();
		Foot('SIGNUP');
	}

	private function validation() 
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'   => 'Fullname',
				'label'   => 'Full Name',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars'
				),
			array(
				'field'   => 'Username',
				'label'   => 'Username',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars|callback_UsernameCheck'
				),
			array(
				'field'   => 'Email',
				'label'   => 'Email',
				'rules'   => 'trim|valid_email|required|min_length[2]|xss_clean|htmlspecialchars|callback_EmailCheck'
				),
			array(
				'field'   => 'Password',
				'label'   => 'Password',
				'rules'   => 'trim|required|min_length[2|xss_clean|htmlspecialchars'
				)
			);
		$this->form_validation->set_rules($config);
	}
 

	public function EmailCheck($email)
	{
		if ($this->UserModel->CheckUserExist($email))
		{
			$this->form_validation->set_message('callback_EmailCheck', 'Email already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function UsernameCheck($handle)
	{
		if ($this->UserModel->CheckHandleExist($handle))
		{
			$this->form_validation->set_message('callback_UsernameCheck', 'Username already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


}
?>
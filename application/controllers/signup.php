<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');
	}



	public function index()
	{
		$this->validation();
		$error = "";
		
		if($this->input->post('Register'))
		{
			
			if ($this->form_validation->run() == FALSE)
			{
			}
			else
			{	
				if($this->UserModel->CreateUser())
				{
					if($this->UserModel->Login() == TRUE)
				{
					LogAccess();
					redirect('dashboard');
					return;
				}
					
				}
				else
				{
					$error = "Error creating account";
				}
			}
		}
		
		
		Head('SIGNUP');
		GetHeader();
		$this->load->view('signup');
		Footer();
		Foot('SIGNUP');
	}
	private function validation() 
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'   => 'FirstName',
				'label'   => 'First name',
				'rules'   => 'alpha|trim|required|min_length[2]|xss_clean|htmlspecialchars'
				),
			array(
				'field'   => 'LastName',
				'label'   => 'Last name',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars'
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
}

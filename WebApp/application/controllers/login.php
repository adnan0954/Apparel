<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller
{
	public function index()
	{
		if(IsLoggedIn())
		{
			redirect('profile');
			return;
		}

		$this->load->model('UserModel');
		$error = "";
		Head("LOGIN");
		GetHeader();
		$this->validation();

		if($this->input->post('SignIn'))
		{
			if($this->input->post('csrftoken') != $this->session->flashdata('csrftoken'))
			{
				echo ":)";
				return;
			}

			if ($this->form_validation->run() == FALSE)
			{

			}
			else
			{
				if($this->UserModel->Login() == TRUE)
				{
					LogAccess();
					redirect('profile');
					return;
				}
				else
				{					
					LogAttempt();
					$error = "Wrong Username or Password";
				}
			}
		}

		$data['Error'] = $error;
		$this->load->view('signin', $data);
		Footer();
		Foot("LOGIN");
	}
	
	function validation() 
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'   => 'Username',
				'label'   => 'Username',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars'
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
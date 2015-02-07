<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PostModel');

		if(!IsLoggedIn())
		{
			redirect('login');
		}
	}

	public function index()
	{
		$error = "";
		$this->validation();

		if($this->input->post('Post'))
		{
			if ($this->form_validation->run() == FALSE)
			{}
			else
			{	
				if($this->PostModel->SendPost())
				{
					echo "1";
					return;
				}
				else
				{
					echo "Error creating account";
				}
			}
		}
		
		//$data['Error'] = $error;
		Head('POST');
		GetHeader();
		$this->load->view('post', $data);
		Footer();
		Foot('POST');
	}

	private function validation() 
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'   => 'Caption',
				'label'   => 'Caption',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars'
				),
			array(
				'field'   => 'Tags',
				'label'   => 'Tags',
				'rules'   => 'trim|required|min_length[2]|xss_clean|htmlspecialchars'
				),
			);
		$this->form_validation->set_rules($config);
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout extends CI_Controller
{
	public function index()
	{
		$this->load->model('UserModel');
		$this->UserModel->LogOut();
		redirect('main');
	}
}
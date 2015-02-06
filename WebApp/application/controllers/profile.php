<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller {
	
	public function index()
	{
		Head('PROFILE');
		GetHeader();
		$this->load->view('profile');
		Footer();
		Foot('PROFILE');
	}
}
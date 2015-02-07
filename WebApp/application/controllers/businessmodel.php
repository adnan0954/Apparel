<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class businessmodel extends CI_Controller
{
	public function index()
	{
		Head('BUSINESSMODEL');
		GetHeader();
		$this->load->view('businessmodel');
		Footer();
		Foot('BUSINESSMODEL');
	}
}
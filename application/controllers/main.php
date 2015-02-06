<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller
{
	public function index()
	{
		Head('MAIN');
		GetHeader();
		$this->load->view('main');
		Footer();
		Foot('MAIN');
	}
}
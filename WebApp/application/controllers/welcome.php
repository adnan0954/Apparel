<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends CI_Controller {
	
	public function index()
	{
		Head('WELCOME');
		GetHeader();
		$this->load->view('welcome');
		Footer();
		Foot('WELCOME');
	}
}
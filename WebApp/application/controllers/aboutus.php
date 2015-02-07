<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class aboutus extends CI_Controller
{
	public function index()
	{
		Head('ABOUTUS');
		GetHeader();
		$this->load->view('aboutus');
		Footer();
		Foot('ABOUTUS');
	}
}
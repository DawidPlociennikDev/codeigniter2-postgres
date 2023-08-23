<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom404 extends CI_Controller
{
	public function index()
	{
		$this->output->set_status_header(404, 'Not Found');
		$this->load->view('404.php');
	}
}
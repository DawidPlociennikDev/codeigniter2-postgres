<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom404 extends CI_Controller
{
	public function index()
	{
		$this->load->view('404.php');
	}
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define("VIEW_DIR", "front/");

class Home extends CI_Controller
{
	public function index()
	{
		$this->load->view(VIEW_DIR.'index.php');
	}
}
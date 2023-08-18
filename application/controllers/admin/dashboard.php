<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define("VIEW_DIR", "back/");

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('page-not-found');
        }
    }
    public function index()
    {
		$this->load->model('user_model');
        $this->user_model->get_user_comments($this->session->userdata('user_id'));

        $this->load->view(VIEW_DIR . 'index.php');
    }


}

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
        // $this->fillDatabase();
		$this->load->model('user_model');
        $this->user_model->get_user_comments($this->session->userdata('user_id'));

        $this->load->view(VIEW_DIR . 'index.php');
    }

    private function fillDatabase() : void
    {
        $data = array();
        $id[0] = 13;
        $id[1] = 14;
        for ($i = 0; $i < 100000; $i++) {

            $randomBytes = random_bytes(rand(10, 250));
            $randomString = bin2hex($randomBytes);

            $data[] = array(
                'user_id' => $id[rand(0, 1)],
                'comment_text' => $randomString
            );
        }

        $this->db->insert_batch('comments', $data);
    }
}

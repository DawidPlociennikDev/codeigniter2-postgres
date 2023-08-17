<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define("VIEW_DIR", "back/");

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model');
	}

	public function login()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
        } 
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view(VIEW_DIR . 'signin.php');
		} else {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$this->db->save_queries = TRUE;
			$this->user_model->get_user_by_emailEXPLAIN($email);
			$queries = $this->db->queries;
			print_r($queries);

			$this->db->save_queries = TRUE;
			$this->user_model->get_user_by_emailSTATS($email);
			$queries = $this->db->queries;
			print_r($queries);
			exit;
			$user = $this->user_model->get_user_by_email($email);
			if ($user && password_verify($password, $user->password)) {
				$user_data = array(
					'user_id' => $user->id,
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
					'email' => $user->email,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($user_data);
				redirect('dashboard');
			}
			$this->session->set_flashdata('alert_type', 'alert-danger');
			$this->session->set_flashdata('message', 'Invalid email or password');
			$this->load->view(VIEW_DIR . 'signin.php');
		}
	}

	public function register()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
        } 
		$this->form_validation->set_rules('first_name', 'First name', 'required|trim|min_length[2]');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|trim|min_length[2]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view(VIEW_DIR . 'signup.php');
		} else {

			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$hashed_password = password_hash($password, PASSWORD_BCRYPT);

			$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'password' => $hashed_password,
			);

			$this->user_model->insert_user($data);

			$this->session->set_flashdata('alert_type', 'alert-success');
			$this->session->set_flashdata('message', 'Registration has been successful. You can now log in!');
			redirect('/logowanie');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('first_name');
		$this->session->unset_userdata('last_name');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('logged_in');
		$this->session->set_flashdata('alert_type', 'alert-success');
		$this->session->set_flashdata('message', 'Logout successful!');
		redirect('/logowanie');
	}
}

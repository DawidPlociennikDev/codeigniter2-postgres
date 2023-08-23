<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define("VIEW_DIR", "back/");

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('auth_service');
	}

	public function login()
	{
		$this->auth_service->isLogged();
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view(VIEW_DIR . 'signin.php');
		} else {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if ($this->auth_service->login($email, $password)) redirect('dashboard');

			$this->load->view(VIEW_DIR . 'signin.php');
		}
	}

	public function register()
	{
		$this->auth_service->isLogged();
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
				'password' => $hashed_password
			);

			if ($this->auth_service->register($data)) {
				redirect('/logowanie');
			}
			redirect('/rejestracja');
		}
	}

	public function logout()
	{
		$this->auth_service->logout();
		redirect('/logowanie');
	}
}

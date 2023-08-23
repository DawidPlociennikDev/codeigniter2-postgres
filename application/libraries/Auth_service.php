<?php

class Auth_service
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('user_model');
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->ci->user_model->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $user_data = array(
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'logged_in' => TRUE
            );
            $this->ci->session->set_userdata($user_data);
            $this->ci->user_model->updateUserLoginDate($user->id);

            return true;
        }

        $this->ci->session->set_flashdata('alert_type', 'alert-danger');
        $this->ci->session->set_flashdata('message', 'Invalid email or password');
        return false;
    }

    public function isLogged(): void
    {
        if ($this->ci->session->userdata('logged_in')) {
            redirect('dashboard');
        }
    }

    public function register(array $data): bool
    {
        if (@$this->ci->user_model->insertUser($data)) {
            $this->ci->session->set_flashdata('alert_type', 'alert-success');
            $this->ci->session->set_flashdata('message', 'Registration has been successful. You can now log in!');
            return true;
        }

        $this->ci->session->set_flashdata('alert_type', 'alert-danger');
        $this->ci->session->set_flashdata('message', 'Unknown error!');
        return false;
    }

    public function logout(): void
    {
        $this->ci->session->unset_userdata('user_id');
        $this->ci->session->unset_userdata('first_name');
        $this->ci->session->unset_userdata('last_name');
        $this->ci->session->unset_userdata('email');
        $this->ci->session->unset_userdata('logged_in');
        $this->ci->session->set_flashdata('alert_type', 'alert-success');
        $this->ci->session->set_flashdata('message', 'Logout successful!');
    }
}

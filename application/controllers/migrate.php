<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function index()
    {
        $this->load->library('migration');

        if (!$this->migration->current()) {
            show_error($this->migration->error_string());
        }
        echo 'done';
    }

    public function seed()
    {
        $hashed_password = password_hash('zasxcd', PASSWORD_BCRYPT);

        $userData = ['Dawid', 'Płóciennik', 'dawid.plociennik13@gmail.com', $hashed_password];
        $user_id = $this->fillUsersDatabase(...$userData);
        $this->fillCommentsDatabase($user_id);

        $hashed_password = password_hash('johnDoe', PASSWORD_BCRYPT);

        $userData = ['John', 'Doe', 'j.doe@gmail.com', $hashed_password];
        $user_id = $this->fillUsersDatabase(...$userData);
        $this->fillCommentsDatabase($user_id);
    }

    private function fillUsersDatabase(string $first_name, string $last_name, string $email, string $password): int
    {
		$this->load->model('user_model');

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
        );

        return $this->user_model->insert_user($data);
    }

    private function fillCommentsDatabase(int $user_id): void
    {
        $data = array();
        for ($i = 0; $i < 10000; $i++) {

            $randomBytes = random_bytes(rand(10, 250));
            $randomString = bin2hex($randomBytes);

            $data[] = array(
                'user_id' => $user_id,
                'comment' => $randomString
            );
        }

        $this->db->insert_batch('comments', $data);
    }
}

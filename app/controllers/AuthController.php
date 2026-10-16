<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
    }

    public function login()
    {
        $data = [
            'error' => '',
            'registered' => $this->session->flashdata('registered'),
        ];

        if ($this->form_validation->submitted()) {
            $postedUsername = $this->io->post('username');
            $postedPassword = $this->io->post('password');
            $username = is_string($postedUsername) ? trim($postedUsername) : '';
            $password = is_string($postedPassword) ? $postedPassword : '';
            $user = $this->UserModel->find_by_username($username);

            if (!empty($user) && !empty($user['is_active']) && password_verify($password, $user['password'])) {
                $this->session->regenerate_on_login();
                $this->session->set_userdata([
                    'id' => $user['id'],
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'user_role' => $user['role']
                ]);
                header('Location: ' . site_url('/products'));
                exit;
            }

            $data['error'] = 'Invalid username or password.';
        }

        $this->call->view('login', $data);
    }

    public function register()
    {
        $data = ['error' => ''];

        if ($this->form_validation->submitted()) {
            $postedUsername = $this->io->post('username');
            $postedEmail = $this->io->post('email');
            $postedPassword = $this->io->post('password');
            $username = is_string($postedUsername) ? trim($postedUsername) : '';
            $email = is_string($postedEmail) ? trim($postedEmail) : '';
            $password = is_string($postedPassword) ? $postedPassword : '';

            if ($username === '' || strlen($username) > 100) {
                $data['error'] = 'Username is required and must be 100 characters or fewer.';
            } elseif ($email === '' || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Enter a valid email address.';
            } elseif (strlen($password) < 8) {
                $data['error'] = 'Password must be at least 8 characters.';
            } else {
                $existing = $this->db->raw(
                    'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
                    [$username, $email]
                )->fetch(PDO::FETCH_ASSOC);

                if ($existing) {
                    $data['error'] = 'Username or email already exists.';
                } else {
                    $this->db->raw(
                        'INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())',
                        [$username, $email, password_hash($password, PASSWORD_BCRYPT), 'user']
                    );
                    $this->session->set_flashdata('registered', true);
                    header('Location: ' . site_url('/login'));
                    exit;
                }
            }
        }

        $this->call->view('register_view', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        header('Location: ' . site_url('/login'));
        exit;
    }
}
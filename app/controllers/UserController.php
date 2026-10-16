<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserController
 * 
 * Automatically generated via CLI.
 */
class UserController extends Controller
{
    public function showUsers()
    {
        if ($this->session->userdata('user_role') !== 'admin') {
            show_error('403 Forbidden', 'Administrator access is required to view users.', 'error_general', 403);
            exit;
        }

        $data['users'] = $this->db->table('users')
            ->select('id, username, email, role, created_at')
            ->get_all();
        $this->call->view('users', $data);
    }
}
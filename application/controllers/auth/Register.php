<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!function_exists('is_login')) {
            $this->load->helper('auth_helper');
        }
    }
    public function index()
    {
        if (is_login()) {
            $this->session->set_flashdata("warning", "anda sudah login");
            return redirect(base_url('auth/login'));
        }
        $this->load->library("form_validation");
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tbl_users.email]');
        $this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[tbl_users.username]');
        $this->form_validation->set_rules('fullname', 'fullname', 'trim|required');
        $this->form_validation->set_rules('passwordsignin', 'Password', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('confirmpassword', 'confirmpassword', 'trim|required|matches[passwordsignin]');
        if ($this->form_validation->run() == false) {
            $data = [
                'form' => [
                    "action_register" => base_url('auth/register'),
                ],
            ];
            $this->template->load('admin', 'auth/register', $data);
        } else {
            // validasinya success
            $this->_register();
        }
    }
    private function _register()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('passwordsignin'), PASSWORD_DEFAULT);
        $nama_user = $this->input->post('fullname');
        $status = "aktif";

        if ($this->input->get("is") == "customer") {
            $user = $this->db->insert("tbl_users", compact(["email", 'username', 'password', 'nama_user', 'status']));
            $id = $this->db->insert_id();
            $this->db->insert("tbl_role_user", ['role_id' => 4, "user_id" => $id]);
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if (is_login())
            return redirect(base_url('admin/dashboard'));

        $this->load->library("form_validation");
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data = [
                'page_title' => "Login Page",
                'form' => [
                    "action_login" => base_url('auth/login'),
                ],
            ];
            $this->template->load('admin', 'auth/login', $data);
        } else {
            // validasinya success
            $this->_login();
        }
    }
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->where("email", $email)->get("users")->row_array();

        // jika usernya ada
        if ($user) {

            // jika usernya aktif
            if ($user['status'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {

                    $data = [
                        'user_login' => $user['email'],
                        'user_token' => $user['remember_token'],
                    ];
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('success', 'Sukses Login');
                    return redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('warning', "Wrong password!");
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('warning', 'This email has not been activated!');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('danger', 'Email is not registered');
            redirect('auth/login');
        }
    }
}

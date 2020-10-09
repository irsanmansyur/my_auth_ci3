<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
// require APPPATH . '/libraries/REST_Controller.php';


use Restserver\Libraries\RestController;

require(APPPATH . 'libraries/RestController.php');
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class User extends RestController
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 10; // 500 requests per hour per user/key
        $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->helper("my_helper");
    }

    function index_get($id = null)
    { // Users from a data store e.g. database
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $this->response([
            "status" => false,
            "message" => "user tidak Di temukan",
            "data" => []
        ], 200);
    }
    public function login_post()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules("username", "username", "required");
        $this->form_validation->set_rules("password", "Password", "required");
        if ($this->form_validation->run()) {
            $username = $this->post("username");
            $password = $this->post("password");
            $user = $this->db->get_where("tbuser", [
                "username" => $username
            ])->row_array();
            if ($user) {
                if ($password == $user['password']) {
                    $this->response([
                        "status" => true,
                        "message" => "user di temukan",
                        "data" => $user
                    ], 200);
                } else {
                    $this->response([
                        "status" => false,
                        "message" => "Password Salah",
                        "data" => $this->post()
                    ], 200);
                }
            } else $this->response([
                "status" => false,
                "message" => "User tidak di temukan"
            ], 200);
        } else {
            $this->response([
                "status" => false,
                "message" => "Lengkapi data anda",
                "data" => $this->form_validation->error_array()
            ], 400);
        }
    }

    public function register_post()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules("username", "username", "required");
        $this->form_validation->set_rules("password", "Password", "required");
        $this->form_validation->set_rules("noHp", "No hp", "required");
        $this->form_validation->set_rules("email", "email", "required");
        $this->form_validation->set_rules("status", "status", "required");
        if ($this->form_validation->run()) {
            $username = $this->post("username");
            $password = $this->post("password");
            $email = $this->post("email");
            $noHp = $this->post("noHp");
            $status = $this->post("status");
            $data = [
                'status' => $status,
                "password" => $password,
                "email" => $email,
                "username" => $username,
                "noHp" => $noHp
            ];
            $this->db->insert("tbuser", $data);
            $eks = hasilCUD("berhasil ditambahkan");
            $eks->data = $data;
            $this->response($eks, 200);
        } else {
            $this->response([
                "status" => false,
                "message" => "Lengkapi data anda",
                "data" => $this->form_validation->error_array()
            ], 200);
        }
    }
    public function index_put($id = null)
    {
        $tbl = initTable("tbuser", "user");
        $user = $this->db->get_where($this->tbl->name, [$this->tbl->key => $id])->row_array();
        if ($user) {
            $data = $this->put();
            $update = $this->db->update($tbl['name'], $data, [$tbl['key'] => $id]);
            if ($update) {
                $respon = hasilCUD("Data Berhasil Di Update");
                if ($respon->status) {
                    $user = $this->db->get_where($this->tbl->name, [$this->tbl->key => $id])->row_array();
                    $respon->data = $user;
                    $this->response($respon, 201);
                } else
                    $this->response($respon, 200);
            } else
                $this->response(['status' => false, "message" => "Gagal Update", "data" => $user], 200);
        } else
            $this->response(['status' => false, 'message' => "User Tidak Dikenali.!"], 500);
    }
}

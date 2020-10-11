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

class Access extends RestController
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
   public function submenu_delete($submenuId, $roleId)
   {
      $data = [
         "role_id" => $roleId,
         "submenu_id" => $submenuId,
      ];
      $submenuReadyAccess = $this->db->get_where("access_submenu_role", $data)->row();
      if ($submenuReadyAccess) {
         $this->db->where($data)->delete("access_submenu_role");
         return   $this->response([
            "status" => true,
            "message" => "the role access submenu has been removed",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Submenu role access not found",
            "data" => $data
         ], 400);
      }
   }
   public function submenu_post()
   {
      $this->load->library("form_validation");
      $this->form_validation->set_data($this->post());

      $this->form_validation->set_rules("role_id", "role_id", "required");
      $this->form_validation->set_rules("submenu_id", "submenu_id", "required");

      if ($this->form_validation->run()) {

         $data = [
            "role_id" => $this->post("role_id"),
            "submenu_id" => $this->post("submenu_id"),
         ];
         $submenuReadyAccess = $this->db->get_where("access_submenu_role", $data)->row();
         if ($submenuReadyAccess) {
            return   $this->response([
               "status" => true,
               "message" => "Role Already has Access to the Submenu",
               "data" => $data
            ], 200);
         }
         $addedAccess = $this->db->insert("access_submenu_role", $data);
         return   $this->response([
            "status" => true,
            "message" => "have added role access to the submenu",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Lengkapi data anda",
            "data" => $this->form_validation->error_array()
         ], 400);
      }
   }
   public function menu_delete($menuId, $roleId)
   {
      $data = [
         "role_id" => $roleId,
         "menu_id" => $menuId,
      ];
      $menuReadyAccess = $this->db->get_where("access_menu_role", $data)->row();
      if ($menuReadyAccess) {
         $this->db->where($data)->delete("access_menu_role");
         return   $this->response([
            "status" => true,
            "message" => "the role access menu has been removed",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Menu role access not found",
            "data" => $data
         ], 400);
      }
   }
   public function menu_post()
   {
      $this->load->library("form_validation");
      $this->form_validation->set_data($this->post());

      $this->form_validation->set_rules("role_id", "role_id", "required");
      $this->form_validation->set_rules("menu_id", "menu_id", "required");

      if ($this->form_validation->run()) {

         $data = [
            "role_id" => $this->post("role_id"),
            "menu_id" => $this->post("menu_id"),
         ];
         $menuReadyAccess = $this->db->get_where("access_menu_role", $data)->row();
         if ($menuReadyAccess) {
            return   $this->response([
               "status" => true,
               "message" => "Role Already has Access to the Menu",
               "data" => $data
            ], 200);
         }
         $addedAccess = $this->db->insert("access_menu_role", $data);
         return   $this->response([
            "status" => true,
            "message" => "have added role access to the menu",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Lengkapi data anda",
            "data" => $this->form_validation->error_array()
         ], 400);
      }
   }
   public function user_delete($userId, $roleId)
   {
      $data = [
         "role_id" => $roleId,
         "user_id" => $userId,
      ];
      $userReadyAccess = $this->db->get_where("access_role_user", $data)->row();
      if ($userReadyAccess) {
         $this->db->where($data)->delete("access_role_user");
         return   $this->response([
            "status" => true,
            "message" => "the role access Users has been removed",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "User role access not found",
            "data" => $data
         ], 400);
      }
   }
   public function user_post()
   {
      $this->load->library("form_validation");
      $this->form_validation->set_data($this->post());

      $this->form_validation->set_rules("role_id", "role_id", "required");
      $this->form_validation->set_rules("user_id", "user_id", "required");

      if ($this->form_validation->run()) {
         $data = [
            "role_id" => $this->post("role_id"),
            "user_id" => $this->post("user_id"),
         ];
         $userReadyAccess = $this->db->get_where("access_role_user", $data)->row();
         if ($userReadyAccess) {
            return   $this->response([
               "status" => true,
               "message" => "Role Already has Access to the User",
               "data" => $data
            ], 200);
         }
         $addedAccess = $this->db->insert("access_role_user", $data);
         return   $this->response([
            "status" => true,
            "message" => "have added role access to the user",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Lengkapi data anda",
            "data" => $this->form_validation->error_array()
         ], 400);
      }
   }
   public function rule_delete($type, $access_id, $roleId)
   {
      $data = [
         "role_id" => $roleId,
      ];
      if ($type == 'menu') {
         $table = "access_menu_role";
         $data['menu_id'] =  $access_id;
      } elseif ($type == 'user') {
         $table = "access_role_user";
         $data['user_id'] =  $access_id;
      }

      $roleReadyAccess = $this->db->get_where($table, $data)->row();

      if ($roleReadyAccess) {
         $this->db->where($data)->delete($table);
         return   $this->response([
            "status" => true,
            "message" => "the role access has been removed",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "it role access not found",
            "data" => $data
         ], 400);
      }
   }
   public function rule_post($type)
   {

      $this->load->library("form_validation");
      $this->form_validation->set_data($this->post());
      $this->form_validation->set_rules("rule_id", "Rule", "required");
      $this->form_validation->set_rules("access_id", "Access", "required");
      $data = [
         "role_id" => $this->post("rule_id")
      ];

      if ($type == 'menu') {
         $table = "access_menu_role";
         $data['menu_id'] =  $this->post("access_id");
      } elseif ($type == 'user') {
         $table = "access_role_user";
         $data['user_id'] =  $this->post("access_id");
      }
      if ($this->form_validation->run()) {
         $readyAccess = $this->db->get_where($table, $data)->row();
         if ($readyAccess) {
            return   $this->response([
               "status" => true,
               "message" => "Role Already has Access",
               "data" => $data
            ], 200);
         }

         $addedAccess = $this->db->insert($table, $data);
         return   $this->response([
            "status" => true,
            "message" => "have added role access",
            "data" => $data
         ], 200);
      } else {
         $this->response([
            "status" => false,
            "message" => "Please complete the data first",
            "data" => $this->form_validation->error_array()
         ], 400);
      }
   }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends MY_Model
{
  protected $_table = 'menus';
  protected $_rules = [
    array(
      'field' => 'name',
      'label' => 'Nama Menu',
      'rules' => 'required|min_length[3]'
    ),
  ];

  public function __construct()
  {
    parent::__construct();
  }
  public function user()
  {
    if (!is_login())
      return [];

    $this->db->join("table_has_role", "table_has_role.table_id=menus.id");
    $this->db->join("roles", "table_has_role.role_id=roles.id");
    $this->db->where("table_has_role.
    =roles.id");
    $this->db->where;
  }

  public function roles()
  {
    return $this->belongsToMany("permission/Role_model", "model_id", "role_id", "model_has_role")
      ->where("model_type", "Menu_model");
  }


  public function submenus()
  {
    return $this->hasMany("permission/Submenu_model");
  }
}

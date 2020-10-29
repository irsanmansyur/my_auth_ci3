<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
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
    $this->getLastId();
  }
  public function getNewFields()
  {
    $this->db->select("name as koi");
    return  $this->all();
  }
  public function submenu()
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$this->_table' AND  REFERENCED_COLUMN_NAME  IS NOT NULL";
    $rel =  $this->db->query($qr)->row();
    $this->load->model("submenu_model");
    $submenu = $this->submenu_model;
    return  $submenu->all($rel->COLUMN_NAME, $this->{$this->_primaryKey});
  }
}

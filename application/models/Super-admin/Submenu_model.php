<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_model extends CI_Model
{
  protected $_table = 'submenus';
  protected $_rules = [
    array(
      'field' => 'name',
      'label' => 'Nama Sub Menu',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'url',
      'label' => 'URL Sub Menu',
      'rules' => 'required|min_length[3]'
    ),
    array(
      'field' => 'is_access',
      'label' => 'STATUS Sub Menu',
      'rules' => 'required'
    ),
    array(
      'field' => 'menu_id',
      'label' => 'MENU',
      'rules' => 'required'
    ),
  ];

  public function __construct()
  {
    parent::__construct();
  }
}

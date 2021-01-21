<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_model extends MY_Model
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
      'label' => 'Status',
      'rules' => 'required'
    ),
    array(
      'field' => 'menu_id',
      'label' => 'Menu',
      'rules' => 'required'
    ),
  ];

  public function __construct()
  {
    parent::__construct();
  }
}

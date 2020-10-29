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
  }
}

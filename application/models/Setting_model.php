<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_model extends MY_Model
{
  protected $_table = 'settings';

  private $data = [];
  protected $_rules = [
    [
      'field' => 'name',
      'label' => 'Nama Setting',
      'rules' => 'required',
      'errors' => [
        'required' => "Nama harus benar \n %s"
      ],
    ],
    array(
      'field' => 'alamat',
      'label' => 'Alamat',
      'rules' => 'required',
    ),
    array(
      'field' => 'name_app',
      'label' => 'Nama Aplikasi',
      'rules' => 'required',
    ),
    array(
      'field' => 'theme_admin',
      'label' => 'Admin Thema',
      'rules' => 'required',
      'errors' => array(
        'required' => 'You must provide a %s.',
      ),
    )
  ];
  public function __construct()
  {
    parent::__construct();
  }
  function get()
  {
    return $this->db->order_by('name')->get($this->_table)->result();
  }
}

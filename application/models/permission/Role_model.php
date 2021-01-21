<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends MY_Model
{
  protected $_table = 'roles';
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
  public function hasRole($model)
  {
    if (is_string($model))
      $model = setModel($model);
    $this->db->where("model_type", get_class($model));
  }
}

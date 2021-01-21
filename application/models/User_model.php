<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends MY_Model
{
  protected $_table = 'users';
  protected $_rules = [
    [
      'field' => 'name',
      'label' => 'Nama User',
      'rules' => 'required',
      'errors' => [
        'required' => "Nama harus benar \n %s"
      ],
    ],
    array(
      'field' => 'username',
      'label' => 'Username',
      'rules' => 'required',
      "unique" => "username|username"
    ),
    array(
      'field' => 'password',
      'label' => 'Password',
      'rules' => 'required',
      'errors' => array(
        'required' => 'You must provide a %s.',
      ),
    ),
    array(
      'field' => 'email',
      'label' => 'email',
      'rules' => 'required|valid_email',
      "unique" => "email|username"
    ),

  ];
  protected $_beforeInsert = ['setPassword'];
  public function __construct()
  {
    parent::__construct();
  }
  public function roles()
  {
    $model = setModel("permission/Role_model");
    return $this->belongsToMany($model, "model_id", "role_id", "model_has_role")
      ->where("model_has_role.model_type",  get_class($this));
  }
  public function menus()
  {
    $roles = $this->roles;

    $model  = setModel("permission/Menu_model");
    $model->join("model_has_role", "model_has_role.model_id=menus.id", "left");
    $model->where("model_type", get_class($model))
      ->group_by("menus.id");


    if (count($roles) < 1)
      $roles = [0 => ["id" => "tidak ada roll"]];

    $model->where_in("role_id", array_column($roles, "id"));
    $model->__type = "all";

    return $model;
  }

  public function getProfile()
  {
    $image = ["assets/img/profile/default.jpg", "assets/img/default.png", "assets/img/no-image.png"];
    if (isset($this->profile)) {
      if (is_file(FCPATH . 'assets/img/profile/' . $this->profile))
        return base_url('assets/img/profile/' . $this->profile);
    }
    return base_url($image[array_rand($image)]);
  }

  public function setPassword($data)
  {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    return $data;
  }
  public function views()
  {
    return $this->hasMany("View_model", "model_id")
      ->where("model_type", "User_model");
  }
}

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

  public function jumlah_pelanggan()
  {
    $this->db->from("users");
    return $this->db->join("model_has_role", "model_has_role.model_id=users.id")->where("model_has_role.model_type", "User_model")->join("roles", "roles.id=model_has_role.role_id")->where("roles.name", "Pelanggan")->count_all_results();
  }
  public function views()
  {
    return $this->hasMany("View_model", "model_id")
      ->where("model_type", "User_model");
  }


  /**
   * Datatable
   * 
   */
  public function getDatatable()
  {
    $this->searchAndOrder();
    $this->select("COUNT(*) as Jumlah");
    $jml = $this->db->get("users")->row();
    $totalCount =  $jml ? $jml->Jumlah : 0;

    $this->searchAndOrder();
    if (in_array("created_at", $this->getTable("fields"))) {
      if ($this->input->get_post("byMonth")) {
        $this->where("MONTH(created_at)", $this->input->get_post("byMonth"));
      }
      if ($this->input->get_post("byYear")) {
        $this->where("YEAR(created_at)", $this->input->get_post("byYear"));
      }
      if ($this->input->get_post("byDay")) {
        $this->where("DAY(created_at)", $this->input->get_post("byDay"));
      }
    }

    $this->select("COUNT(*) as Jumlah");
    $jml = $this->db->get("users")->row();
    $countFilter =   $jml ? $jml->Jumlah : 0;


    $this->searchAndOrder();
    if (in_array("created_at", $this->getTable("fields"))) {
      if ($this->input->get_post("byMonth")) {
        $this->where("MONTH(created_at)", $this->input->get_post("byMonth"));
      }
      if ($this->input->get_post("byYear")) {
        $this->where("YEAR(created_at)", $this->input->get_post("byYear"));
      }
      if ($this->input->get_post("byDay")) {
        $this->where("DAY(created_at)", $this->input->get_post("byDay"));
      }
    }

    $data = $this->all();
    foreach ($data as $i => $user) {
      $data[$i]->dibuat_pada = _ago($user->created_at);
    }

    $output = array(
      "draw" => $this->input->get_post("draw") ?? 0,
      "recordsTotal" => $totalCount,
      "recordsFiltered" => $countFilter,
      "data" => $data,
      "dataTable" => empty($this->input->post()) ? $this->input->get() : $this->input->post(),
    );
    return $output;
  }
  private function searchAndOrder()
  {
    $search_val = $this->input->get_post("search");
    $search =  is_string($search_val) ? $search_val : (is_array($search_val) ? $search_val['value'] : '');
    if ($search) {
      $this->like("users.name",   $search);
      $this->or_like("users.email",   $search);
      $this->or_like("users.username",   $search);
      isset($this->getTable("fields")['created_at']) &&  $this->or_like("byDay",   $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byMonth",   $search);
      isset($this->getTable("fields")['created_at']) &&   $this->or_like("byYear",   $search);
    }
    if ($this->input->get_post("order")) {
      $orderBy = $this->input->get_post("columns")[$this->input->get_post("order")['0']['column']]['name'];
      $this->db->order_by($orderBy, $this->input->get_post("order")['0']['dir']);
    }
    $length = $this->input->get_post("length") ?? 10;
    $page =  $this->input->get_post("page") ?? 1;
    $start =  $this->input->get_post("start") ??  ($page * $length - $length);

    $this->db->limit($length, $start);
    if ($this->input->get_post("role")) {
      $this->join("access_role_user", "access_role_user.user_id=users.id");
      $this->join("roles", "access_role_user.role_id=roles.id");
      $this->where("roles.name", $this->input->get_post("role"));
    }
  }
}

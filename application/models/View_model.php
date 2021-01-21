<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View_model extends MY_Model
{
  protected $_table = 'views';

  protected $_beforeInsert = ['insert'];
  public function __construct()
  {
    parent::__construct();
  }


  public function makeModel($model, $modelId = null)
  {
    if (is_string($model))
      $model = setModel($model);
    $user_ip = $this->input->ip_address();

    $data = [
      "ip_address" => $user_ip,
      "model_type" => get_class($model),
      "model_id" => $modelId ? $modelId : $model->{$model->getTable("key")},
      "created_at" =>   date("Y-m-d"),
    ];

    if (!$this->first($data))
      $this->save($data);
  }
}

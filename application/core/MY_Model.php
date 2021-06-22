<?php defined('BASEPATH') or exit('No direct script access allowed');


use MyModel\core\Relation;


require(APPPATH . 'core/Relation.php');


class MY_Model extends CI_Model
{
  protected $_table = '';
  protected $_rules = [];
  protected $_allowed = [];

  private $_primaryKey = null;

  public function __construct($type = null)
  {
    if (!$type)
      $this->_setFields();
  }


  public function __get($key)
  {
    if (method_exists(get_class($this), $key)) {
      if (isset($this->{$key}))
        return $this->{$key};
      $model =  $this->{$key}();
      if ($model->__type === "all")
        return  $this->{$key} = $model->all();
      else if ($model->__type === "first") {
        return  $this->{$key} = $model->first();
      }
    }

    return get_instance()->$key;
  }
  public function __call($name, $params)
  {
    if (!method_exists($this, $name) && method_exists(get_instance()->db, $name)) {
      $hasil = get_instance()->db->{$name}($params[0] ?? null, $params[1] ?? null, $params[2] ?? null);
      return $this;
    }
  }

  public function count()
  {
    return $this->db->count_all_results($this->_table);
  }


  private $__table;
  private function _setFields()
  {
    if ($this->db->table_exists($this->_table)) {
      $eks  = $this->db->query("SHOW KEYS FROM $this->_table WHERE Key_name = 'PRIMARY'")->row();
      $this->_primaryKey = $eks->Column_name;
      $fields = $this->db->list_fields($this->_table);
      $this->__table = [
        "name" => $this->_table,
        "fields" => $fields,
        "key" => $eks->Column_name,
      ];
      $default = [];
      foreach ($fields  as $value) {
        $this->{$value} =  null;
        $default[$value]  = null;
      }
      $this->default = (object) $default;
    }
  }

  private function _data($data)
  {
    $fields = $this->__table['fields'];
    if (count($this->_allowed) > 0)
      $fields = $this->_allowed;


    $data = array_merge((array)$this, $data);
    $data =  $this->__beforeInput($data);

    $newData = [];
    if ($fields) {
      foreach ($data as $key => $val) {
        if (in_array($key, $fields)) {
          $this->{$key} = $val;
          if (!is_null($val))
            $newData[$key] =  $val;
        }
      }
    }
    return $newData;
  }


  public function  all($key = null, $val = null)
  {
    $this->db->select($this->_table . ".*", $this->_table . $this->getTable("key"));

    $this->db->from($this->getTable("name"));
    if (is_int($key))
      $this->db->limit($key);
    else if ($key && $key !== "_newFields")
      $this->where($key, $val);

    $all = $this->db->get()->result();
    $ci = get_instance();
    $ci->last_query = $this->db->last_query();
    $a = [];
    foreach ($all as $row => $value) {
      $b =  new $this(true);
      $b->setOutput($value);
      // $this->__setMethod($b);
      $a[] = $b;
    }
    $a =  $a;
    return  $a;
  }

  protected function __setMethod($class)
  {
    $class_methods = get_class_methods($class);
  }


  public function first($id = [], $val = null)
  {
    $key = (string) $this->getTable("key");

    $this->db->select($this->_table . ".*");
    $this->db->from($this->_table);

    if (is_numeric($id)) {
      $this->where($this->_table . "." . $key, $id);
    } elseif ($id && $id !== "_newFields") {
      $this->where($id, $val);
    } elseif (is_null($id)) {
      return false;
    }
    if (!is_numeric($id) && $this->$key != $this->default->$key) {
      $this->where($this->getTable('name') . "." . $key, $this->$key);
    }

    $this->db->limit(1);
    $a = $this->db->get()->row();
    if (!$a)
      return false;

    $b =  new $this;
    $b->setOutput($a);
    return  $b;
  }

  private function setOutput($data)
  {
    $this->default  = (object) $data;
    foreach ($data as $key => $value) {
      $this->{$key} = $value;
    }
    return $this;
  }

  private function setInput(array $data)
  {
    $data = array_merge((array) $this, $data);

    $dt = [];
    foreach ($this->__table['fields'] as $value) {
      if (array_key_exists($value, $data) &&  $data[$value] !== null) {

        if (!isset($this->default) ||  $this->default->{$value}  !=  $data[$value]) {
          $dt[$value] =  $data[$value];
          $this->{$value} =  $data[$value];
        }
      }
    }

    return $dt;
  }
  private function _setData($data, $type = null)
  {
    !is_object($data) || $data = (array) $data;
    $dt = [];
    if ($data) foreach ($data as $key => $val) {
      if (property_exists($this, $key)) {
        $this->{$key} =  $data[$key];
        $dt[$key] = $data[$key];
      }
      if ($type == "_newFields") {
        $this->{$key} =  $data[$key];
      }
    }
    return $dt;
  }


  public function where($key, $value = null)
  {
    if (!is_array($key)) {
      $key = array($key => $value);
    }
    $this->db->where($key);
    return $this;
  }
  public function getTable($key = null)
  {
    $table = isset($this->__table['name']) ? $this->__table['name'] : "";
    if ($this->_table !== $table)
      $this->_setFields();

    if ($key && isset($this->__table[$key]))
      return $this->__table[$key];
    return $this->__table;
  }

  public function __beforeDelete($data)
  {
    $data = (array) $data;
    if (isset($this->_beforeDelete))
      foreach ($this->_beforeDelete as $value) {
        if (method_exists($this, $value)) {
          $data =  $this->{$value}($data);
        }
      }
    return $data;
  }
  public function __beforeInput($data)
  {

    if (isset($this->_beforeInsert))
      foreach ($this->_beforeInsert as $value) {
        if (method_exists($this, $value)) {
          $data =  $this->{$value}($data);
        }
      }
    return $data;
  }
  public function __afterInsert()
  {
    if (isset($this->_afterInsert))
      foreach ($this->_afterInsert as $value) {
        if (method_exists($this, $value)) {
          $this->{$value}($this);
        }
      }
  }

  public function getRules($type = null)
  {

    $filtered = [];
    foreach ($this->_rules as $key => $rule) {
      if (isset($rule["unique"])) {

        $array_unique = explode("|", $rule["unique"]);
        $unique = $array_unique[0];
        $tble = explode(".", $array_unique[0]);
        $tabel = $this->_table;
        $unique = $tble[0];
        if (isset($tble[1])) {
          $tabel = $tble[0];
          $unique = $tble[1];
        }

        if (isset($array_unique[1]) && isset($this->{$array_unique[1]})) {
          $pengecuali =  $array_unique[1];
        } else
          $pengecuali = $this->getTable("key");


        $rule_unique = "|is_unique[{$tabel}.{$unique}]";



        if (isset($this->default) && $this->default->{$rule['field']} == $this->input->post($rule['field']))
          $rule_unique = "";



        $rule["rules"] .= $rule_unique;
        unset($rule["unique"]);
      }
      $filtered[] = $rule;
    }
    if (is_array($type)) {
      if (array_key_exists("except", $type)) {
        $except = $type['except'];
        foreach ($filtered as $key => $val) {
          if (in_array($val['field'], $except))
            unset($filtered[$key]);
        }
        return $filtered;
      } elseif (array_key_exists("allowed", $type)) {
        $allowed  =  $type['allowed'];
        foreach ($filtered as $key => $val) {
          if (!in_array($val['field'], $allowed))
            unset($filtered[$key]);
        }
        return $filtered;
      }
    } else if (is_string($type)) {
      if (array_key_exists($type, $filtered)) {
        $filtered = $filtered[$type];
      }
    }
    $this->_rules = $filtered;
    return $filtered;
  }

  public function save(array $post = [])
  {
    $this->db->reset_query();

    $this->getLastId("id", "");
    $post = array_merge($this->input->post(), $post);

    $dataFarsing = $this->setInput($post);
    $dataBeforeInput = $this->__beforeInput($dataFarsing);

    $this->db->insert($this->__table['name'], $dataBeforeInput);
    $this->{$this->__table['key']} = $this->db->insert_id();

    if ($this->db->affected_rows() < 1) {
      return false;
    }
    $this->setOutput($dataBeforeInput);
    return $this;
  }
  public function update(array $post = [], array $where = null)
  {
    count($post) < 1  && $post = $this->input->post();

    if (isset($this->{$this->__table['key']})) {
      $this->where($this->__table['key'], $this->{$this->__table['key']});
    }
    if ($where && is_array($where) && count($where) > 0)
      $this->where($where);

    $dataFarsing = $this->setInput($post);

    $dataBeforeInput = $this->__beforeInput($dataFarsing);


    if (count($dataBeforeInput) > 0)
      $this->db->update($this->__table['name'], $dataBeforeInput);

    return $this;
  }

  protected   $__afterDelete = [];
  public function delete($id = null)
  {
    $default = $this->default ?? null;
    $keyName = $this->getTable("name") . "." . $this->getTable("key");
    $keyValue = $default->{$this->getTable("key")};

    if ($id) {
      $this->db->where($keyName, $id);
    } else {
      if ($default &&  $keyValue) {
        $this->db->where($keyName, $keyValue);
      }
    }
    $this->__beforeDelete($this);

    $delete = $this->db->delete($this->getTable('name'));

    if ($this->db->affected_rows() > 0) {
      foreach ($this->__afterDelete as $func) {
        $this->{$func}($this);
      }
      $this->_clear();
    }
    return $delete;
  }

  private function _clear()
  {
  }
  public function getLastId($unique = "id", $string = "id-")
  {
    $this->db->select_max($unique);
    $this->db->from($this->_table)->order_by($this->_primaryKey, 'desc');
    $eks = $this->db->get()->row()->{$unique};
    $noUrut = (int) substr($eks, -3, 3);
    $noUrut += 1;
    $kodeName = $string;
    $lastId = $kodeName . sprintf("%03s", $noUrut);
    $this->{$unique} = $lastId;
    return  $lastId;
  }





  //relation
  protected function hasOne($model, $key_child = null)
  {
    if (is_string($model) && !isset($this->{$model}))
      $this->load->model($model) && $model = $this->{$model};

    $has = new $model;
    $parent = $this;
    if (!$key_child || is_null($key_child)) {
      $key_child = $parent->_table . "_id";
      $last = substr($parent->_table, -1);
      if ($last == "s") {
        $key_child = substr_replace($parent->_table, "", -1) . "_id";
      }
    }

    if (!property_exists($has, $key_child)) {
      $has->_status = "Not Relation please set Relation";
      return $has;
    }

    $has->__type = "first";
    $has->{$key_child} = $parent->{$parent->getTable("key")};

    $has->where($key_child, $parent->{$parent->_primaryKey});

    return    $has;
  }

  protected function belongsTo($model, $key_from = null, $key_to = null)
  {
    if (is_string($model)) {
      $model = setModel($model);
    }

    $parent = new $model;
    $children = $this;



    // Create an exception 
    $ex = new Exception();
    $trace = $ex->getTrace();
    $final_call = $trace[1];


    if (isset($this->{$final_call["function"]})) {
      if (isset($trace[2]) && $trace[2]["function"] == "__get" && $trace["args"][0] == $final_call["function"])
        return $this->{$final_call["function"]};
    }

    if (!$key_from || is_null($key_from)) {

      $key_from = $parent->_table . "_id";
      $last = substr($parent->_table, -1);
      if ($last == "s") {
        $key_from = substr_replace($parent->_table, "", -1) . "_id";
      }
    }

    if (!isset($children->{$key_from})) {
      $this->{$final_call["function"]} = $parent;
      $parent->_status = "Not Relation please set Relation";
      return $parent;
    } else {
      $parent->{$parent->getTable("key")} = $children->{$key_from};
    }

    $parent->__type = "first";
    return $parent;
  }
  protected function belongsToMany($model, $key_from = null, $key_to = null, $table_relation = null)
  {
    if (is_string($model)) {
      $model = setModel($model);
    }

    $toModel =  $model;
    $fromModel = $this;

    $all_table = [];
    if (!$key_from || is_null($key_from)) {
      $key_from = $fromModel->_table . "_id";
      $last = substr($fromModel->_table, -1);
      $all_table[0] = $fromModel->_table;
      if ($last == "s") {
        $all_table[0] = substr_replace($fromModel->_table, "", -1);
        $key_from = substr_replace($fromModel->_table, "", -1) . "_id";
      }
    }
    if (!$key_to || is_null($key_to)) {
      $key_to = $toModel->_table . "_id";
      $last = substr($toModel->_table, -1);
      $all_table[1] = $toModel->_table;
      if ($last == "s") {
        $all_table[1] = substr_replace($toModel->_table, "", -1);
        $key_to = substr_replace($toModel->_table, "", -1) . "_id";
      }
    }


    sort($all_table);

    if ($table_relation === null)
      $table_relation = implode("_", $all_table);

    $this->db->reset_query();
    $toModel->db->join($table_relation, $table_relation . "." . $key_to . "=" . $toModel->_table . "." . $toModel->_primaryKey);

    //mencocokkan data tabel sebelumnya 
    $this->db->where("{$table_relation}.$key_from", $fromModel->{$fromModel->_primaryKey});

    $toModel->__tableRelation = $table_relation;
    $toModel->__type = "all";
    $toModel->__modelFrom = $fromModel;
    $toModel->__KeyTo = $key_to;
    $toModel->__keyFrom = $key_from;


    return  $toModel;
  }

  public function async($idInput, array $attr = [])
  {
    $modelRelation = new Relation($this->__tableRelation);

    $modelFrom = $this->__modelFrom;


    $idFrom = (string) $modelFrom->{$modelFrom->_primaryKey};
    $this->db->reset_query();
    $this->db->from($modelRelation->getTable("name"))
      ->where($this->__keyFrom, (string) $modelFrom->{$modelFrom->_primaryKey});
    if (count($attr) > 0)
      $this->db->where($attr);
    $this->db->delete();

    $this->attach($idInput, $attr);

    return $modelRelation;
  }

  public function attach($idInput, array $dataDefault = [])
  {

    if (!is_array($idInput)) {
      $idInput = ["" . $idInput => $dataDefault];
    }


    foreach ($idInput   as  $id => $attr) {
      $modelRelation = new Relation($this->__tableRelation);

      $modelFrom = $this->__modelFrom;

      $data =  [
        $this->__keyFrom => (string) $modelFrom->{$modelFrom->_primaryKey},
        $this->__KeyTo => ($attr && !is_array($attr)) ? $attr : $id,
      ];

      if ($attr && is_array($attr))
        $data = array_merge($data, $attr);
      $data = array_merge($data, $dataDefault);

      $modelRelation->save($data);
    }

    return $modelRelation;
  }

  public function detach($idInput = null, array $dataDefault = [])
  {
    if (!is_array($idInput) && $idInput !== null) {
      $idInput = ["" . $idInput => $dataDefault];
    }

    $modelRelation = new Relation($this->__tableRelation);
    $modelFrom = $this->__modelFrom;

    $this->db->where($this->__keyFrom, $modelFrom->{$modelFrom->_primaryKey});


    if (is_array($idInput) && count($idInput) > 0) {
      $this->db->group_start();
      $no = 0;

      foreach ($idInput   as  $id => $attr) {
        $data =  [
          $this->__KeyTo => $id
        ];


        if ($no === 0)
          $this->db->where($data);
        else
          $this->db->or_where($data);
      }
      $this->db->group_end();
    }

    return   $modelRelation->delete();
  }
  protected function ownedMany($class)
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$this->_table' AND TABLE_NAME='$class->_table'";
    $rel =  $this->db->query($qr)->row();
    if ($rel) {
      return  $class->all($rel->COLUMN_NAME, $this->{$this->_primaryKey});
    }
  }
  protected function hasMany($model, $keyFrom = null)
  {
    if (is_string($model)) {
      $model = setModel($model);
    }

    $toModel =  $model;
    $fromModel = $this;

    if (!$keyFrom || is_null($keyFrom)) {
      $keyFrom = $fromModel->_table . "_id";
      $last = substr($fromModel->_table, -1);
      $all_table[0] = $fromModel->_table;
      if ($last == "s") {
        $all_table[0] = substr_replace($fromModel->_table, "", -1);
        $keyFrom = substr_replace($fromModel->_table, "", -1) . "_id";
      }
    }


    $toModel->where($keyFrom, $fromModel->{$fromModel->_primaryKey});

    $toModel->__type = "all";
    $toModel->pivot = $fromModel;
    return  $toModel;
  }
  public function group($key, $val = null)
  {
    if (is_string($key)) {
      $key = [$key => $val];
    }
    foreach ($key as $y => $v) {
      $this->db->group_by($y, $v);
    }
    return $this;
  }
}

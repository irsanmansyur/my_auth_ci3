<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model
{

  protected $_table = '';
  protected $_rules = [];
  protected $_allowed = [];

  private $_primaryKey = null;

  /**
   * Class constructor
   *
   * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
   * @return	void
   */
  public function __construct()
  {
    $this->_inits();
  }

  /**
   * __get magic
   *
   * Allows models to access CI's loaded classes using the same
   * syntax as controllers.
   *
   * @param	string	$key
   */
  public function __get($key)
  {
    // Debugging note:
    //	If you're here because you're getting an error message
    //	saying 'Undefined Property: system/core/Model.php', it's
    //	most likely a typo in your model code.

    return get_instance()->$key;
  }
  private function _inits()
  {
    $this->_setFields();
  }
  private function _setFields()
  {
    if ($this->db->table_exists($this->_table)) {
      $eks  = $this->db->query("SHOW KEYS FROM $this->_table WHERE Key_name = 'PRIMARY'")->row();
      $this->_primaryKey = $eks->Column_name;
      foreach ($this->db->list_fields($this->_table) as $value) {
        $this->{$value} =  null;
      }
    }
  }
  private function _data($data)
  {
    $fields = $this->db->list_fields($this->_table);
    if (count($this->_allowed) > 0)
      $fields = $this->_allowed;

    $data = array_merge((array)$this, $data);

    $newData = [];
    if ($fields) {
      foreach ($data as $key => $val) {
        if (in_array($key, $fields)) {
          $this->key = $val;
          if ($val)
            $newData[$key] =  $val;
        }
      }
    }
    return $newData;
  }


  public function  all($key = null, $val = null)
  {
    $this->db->from($this->_table);
    if ($key && $key !== "_newFields")
      $this->where($key, $val);

    $all = $this->db->get()->result();

    $a = [];
    foreach ($all as $row => $value) {
      $b =  new $this;
      $b->_setData($value, $key);
      $a[] = $b;
    }
    $a =  $a;
    return  $a;
  }
  public function first($id, $val = null)
  {
    $this->db->from($this->_table);

    if (is_numeric($id)) {
      $this->where($this->_primaryKey, $id);
    } elseif ($id && $id !== "_newFields") {
      $this->where($id, $val);
    }

    $a = $this->db->get()->row();
    if (!$a)
      return false;
    $b =  new $this;
    $b->_setData($a, $id);
    return  $b;
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

  protected function where($key, $value = null)
  {
    if (!is_array($key)) {
      $key = array($key => $value);
    }
    $this->db->where($this->_setData($key));
    return $this;
  }

  public function getRules($type = null)
  {
    $filtered = $this->_rules;
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
        $filtered = array_filter(
          $filtered,
          function ($key) use ($allowed) {
            return in_array($key, $allowed);
          },
          ARRAY_FILTER_USE_KEY
        );
        return $filtered;
      } elseif (array_key_exists("allowed", $type)) {
        $allowed  =  $type['allowed'];
        $filtered = array_filter(
          $filtered,
          function ($key) use ($allowed) {
            return in_array($key, $allowed);
          },
          ARRAY_FILTER_USE_KEY
        );
        return $filtered;
      }
    } else if (is_string($type)) {
      if (array_key_exists($type, $filtered)) {
        $filtered = $filtered[$type];
      }
    }
    return $filtered;
  }

  public function save($post = null)
  {
    $post = $post ?? $this->input->post();
    $this->db->insert($this->_table, $this->_data($post));
    $this->{$this->_primaryKey} = $this->db->insert_id();
    return $this;
  }
  public function update($post = null, $where = null)
  {
    $post = $post ?? $this->input->post();
    if (isset($this->{$this->_primaryKey})) {
      $this->where($this->_primaryKey, $this->{$this->_primaryKey});
    }

    $newPost = $this->_data($post);
    if ($where)
      $this->where(($where));
    $update = $this;
    if ($newPost)
      $update = $newPost;
    $eks = $this->db->update($this->_table, $update);
    return $this;
  }

  public function delete($id = null)
  {
    if (isset($this->{$this->_primaryKey})) {
      $this->where($this->_primaryKey, $this->{$this->_primaryKey});
    }
    return $this->db->delete($this->_table);
  }
  protected function getLastId($unique = "id", $string = "id-")
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
  protected function hasOne($class)
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE TABLE_NAME = '$this->_table' AND  REFERENCED_COLUMN_NAME  IS NOT NULL AND REFERENCED_TABLE_NAME = '$class->_table' ";
    $rel =  $this->db->query($qr)->row();
    if ($rel) {
      return  $class->first($this->{$rel->COLUMN_NAME});
    }
  }
  protected function ownedOne($class)
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME='$this->_table' AND TABLE_NAME ='$class->_table'";
    $rel =  $this->db->query($qr)->row();
    if ($rel) {
      return  $class->first($class->{$rel->COLUMN_NAME});
    }
  }
  protected function ownedMany($class)
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$this->_table' AND TABLE_NAME='$class->_table'";
    $rel =  $this->db->query($qr)->row();
    if ($rel) {
      return  $class->all($rel->COLUMN_NAME, $this->{$this->_primaryKey});
    }
  }
  protected function hasMany($class)
  {
    $qr = "SELECT TABLE_NAME, COLUMN_NAME , REFERENCED_TABLE_NAME , REFERENCED_COLUMN_NAME FROM information_schema . KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$this->_table' AND  REFERENCED_COLUMN_NAME  IS NOT NULL";
    $rel =  $this->db->query($qr)->row();
    if ($rel) {
      return  $class->all($rel->COLUMN_NAME, $this->{$this->_primaryKey});
    }
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_model extends CI_Model
{
   private $table = 'settings';
   private $data = [];
   public function __construct()
   {
      parent::__construct();
   }
   function get()
   {
      return $this->db->order_by('name')->get($this->table)->result();
   }

   function insert($data = [])
   {
      $this->db->insert($this->table, $this->validate($data));

      return $this->db->affected_rows();
   }
   function update($data = [], $where = [])
   {
      $this->db->where($where);
      $this->db->update($this->table, $this->validate($data));
      return $this->db->affected_rows();
   }
   public function where($key, $value = null)
   {
      if (!is_array($key)) {
         $key = array($key => $value);
      }
      $this->db->where($this->validate($key));
      return $this;
   }

   protected function validate($data)
   {
      $fields = $this->db->list_fields($this->table);
      $dt = [];
      foreach ($fields as $field) {
         if (array_key_exists($field, $data))
            $dt[$field] = $data[$field];
      }
      $this->data = $dt;
      return $dt;
   }
   public function set($data)
   {
      $fields = $this->db->getFieldNames($this->table);
      $dt = [];
      foreach ($fields as $field) {
         if (array_key_exists($field, $data))
            $dt[$field] = $data[$field];
      }
      $this->data = $dt;
      return $dt;
   }
}

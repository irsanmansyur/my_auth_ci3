<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
  private $ci;

  public $theme_folder;
  var $template_data = array();
  public $settings;
  public function __construct()
  {
    $this->ci = &get_instance();

    if (!property_exists($this->ci, 'data')) {
      $this->ci->data = [];
    }
    if (!$this->ci->data) {
      $this->ci->data = [];
    }
    $this->loadSetting();
  }

  private function loadSetting()
  {
    $this->ci->load->model('Setting_model', "setting");

    $pr = $this->ci->setting->get();

    $pre = [];
    foreach ($pr as $p) {
      $pre[addslashes($p->name)] = addslashes($p->value);
    }
    if (!isset($pre["theme_admin"])) {
      $this->ci->setting->insert([
        "name" => "theme_admin",
        "value" => "default",
      ]);
      $pre["theme_admin"] = "default";
    }
    if (!isset($pre["theme_public"])) {
      $this->ci->setting->insert([
        "name" => "theme_public",
        "value" => "default",
      ]);
      $pre["theme_public"] = "default";
    }
    $this->settings = (object) $pre;
    $this->ci->data['settings'] = $this->settings;
  }

  // membaca thema jika tidak ditemukan set ke default
  function readTheme($type)
  {
    $theme = array();
    if ($type == 'admin') {
      $theme = ['theme_admin', $this->settings->theme_admin];
    } elseif ($type == 'public') {
      $theme = ['theme_public', $this->settings->theme_public];
    }
    // set theme folder
    if (!file_exists(FCPATH . "themes/{$type}/" . $theme[1])) {
      $where = [
        'name' => $theme[0]
      ];
      $data = [
        'value' => 'default'
      ];
      $this->ci->setting_m->update($data, $where);
      $this->loadSetting();
      return "default";
    } else
      return $theme[1];
  }
  public function load($template = '', $page = '', $data = array(), $return = FALSE)
  {

    // cek ketersediaan template
    if (!file_exists(FCPATH . "themes/{$template}")) {
      die("Template load = [admin/public]");
    }

    // membaca jenis template dan nama tema
    $theme = $this->readTheme($template);

    // cek page ada tidak di tema yang di centang
    $_filePage = FCPATH . "themes/{$template}/{$theme}/pages/{$page}.php";
    if (!file_exists($_filePage))
      $theme = 'default';
    else
      $this->set_content('thema_content', "Tidak ada layout content tersedia");

    $this->set_content('thema_folder', base_url("themes/{$template}/" . $theme . '/'));
    $this->set_content('thema_load', "../../themes/{$template}/{$theme}/");

    // $this->set_content('thema_content', $this->ci->load->view("../../themes/{$template}/{$theme}/pages/" . $data['page'], array_merge($this->ci->data, $data), true));

    return $this->ci->load->view("../../themes/{$template}/{$theme}/pages/" . $page,       array_merge($this->template_data, $this->ci->data, $data), $return);
  }
  // pendukun load
  function set_content($name, $value)
  {
    $this->template_data[$name] = $value;
  }


  public function open_template($type = 'public')
  {
    $folder = "./themes/{$type}";
    if (!($buka_folder = opendir($folder)))
      die("eRorr... Tidak bisa membuka Folder");
    $file_array = array();
    while ($baca_folder = readdir($buka_folder)) {
      if (substr($baca_folder, 0, 1) != '.') {
        $file_array[] =  $baca_folder;
      }
    }
    return $file_array;
  }

  // membaca folder theme
  function bacaThemes($type)
  {
    $folder = "./themes/" . $type . "/";

    if (!($buka_folder = opendir($folder)))
      die("eRorr... Tidak bisa membuka Folder");
    $file_arrays = array();
    while ($baca_folder = readdir($buka_folder)) {
      if (substr($baca_folder, 0, 1) != '.') {
        $file_arrays[] =  $baca_folder;
      }
    }
    return $file_arrays;
  }
}

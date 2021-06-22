<?php
$this->ci = get_instance();
function is_active($class, $method = 'index')
{
  $ci = get_instance();
  if ($class == $ci->router->fetch_class() && $method == $ci->router->fetch_method()) {
    return "active";
  } else return "";
}
if (!function_exists('back')) {
  function back($back = true)
  {
    if (!$back)
      return $_SERVER['HTTP_REFERER'];
    return  redirect($_SERVER['HTTP_REFERER']);
  }
}
if (!function_exists('setModel')) {
  function setModel(string $model)
  {
    $ci = get_instance();
    $arr = explode("/", $model);
    if (isset($arr[1])) {
      !isset($ci->{$arr[1]}) &&  $ci->load->model($model);
      $model = $ci->{$arr[1]};
    } else {
      !isset($ci->{$model}) &&  $ci->load->model($model);
      $model = $ci->{$model};
    }
    return new $model;
  }
}
function is_access($role_id, $menu_id)
{
  $back =  false;
  $ci = get_instance();
  $ci->db->where('role_id', $role_id);
  $ci->db->where('menu_id', $menu_id);
  $result = $ci->db->get('tbl_user_access_menu');
  if ($result->num_rows() > 0) {
    $back = true;
  }
  return $back;
}

//pesan aksi
function hasilCUD($message = "Sukses.!")
{
  $ci = get_instance();
  $hasil = [
    'status' => true,
    'message' => $message,
  ];
  if ($ci->db->affected_rows() < 1) {
    $hasil['status'] = false;
    $hasil['message'] = ($ci->db->error()['message'] == "") ? "Tidak Ada Yang Berubah" : $ci->db->error()['message'];
  }
  $alert = $hasil['status'] ? "success" : "danger";
  $ci->session->set_flashdata('message', "<div class='mb-5 alert alert-{$alert}' role='alert'>{$hasil['message']}.!</div>");
  return (object) $hasil;
}

function cetak($str)
{
  echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function bacaFolder($folder)
{
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

function toDownload($link, $name = "download")
{
  $ci = get_instance();
  // $link = str_replace(" ", '%20', $link);
  if (is_file(FCPATH . $link)) {
    $ci->load->helper('download');
    return force_download($link, null);
  } else {
    $ci->session->set_flashdata('message', "<div class='mb-5 alert alert-danger' role='alert'>GAgal Download.!</div>");
  }
}
function toDelete($link)
{
  unlink($link);
}

function rupiah($angka)
{

  $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
  return $hasil_rupiah;
}


if (!function_exists('old')) {
  function old(string $name, $default = '')
  {
    $ci = get_instance();
    $val = $name . "_val:";

    if (set_value($name, $default) != $default)
      return set_value($name, $default);

    if ($ci->session->flashdata($val)) {
      return $ci->session->flashdata($val);
    }
    return $default;
  }
}
if (!function_exists('hasError')) {
  function hasError(string $name, $del = '', $enddel = '')
  {
    $ci = get_instance();
    $error = $name . "_er:";
    if (form_error($name, $del, $enddel))
      return form_error($name, $del, $enddel);

    if ($ci->session->flashdata($error)) {
      return $del . $ci->session->flashdata($error) . $enddel;
    }
    return "";
  }
}
if (!function_exists('setError')) {
  function setError(string $str, $message = '')
  {
    $ci = get_instance();
    $name = $str . "_er:";
    $val = $str . "_val:";
    if (isset($_POST[$str]))
      $ci->session->set_flashdata($val, $_POST[$str]);
    $ci->session->set_flashdata($name, $message);
  }
}
if (!function_exists('setErrors')) {
  function setErrors(array $errors)
  {
    foreach ($errors as $err => $msg) {
      setError($err, $msg);
    }
  }
}


function _ago($datetime, $full = false)
{
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function indonesia_day($date)
{
  $hari = date("D", strtotime($date));
  switch ($hari) {
    case 'Sun':
      $hari_ini = "Minggu";
      break;
    case 'Mon':
      $hari_ini = "Senin";
      break;
    case 'Tue':
      $hari_ini = "Selasa";
      break;
    case 'Wed':
      $hari_ini = "Rabu";
      break;
    case 'Thu':
      $hari_ini = "Kamis";
      break;
    case 'Fri':
      $hari_ini = "Jumat";
      break;
    case 'Sat':
      $hari_ini = "Sabtu";
      break;
    default:
      $hari_ini = "Tidak di ketahui";
      break;
  }
  return $hari_ini;
}

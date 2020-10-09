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

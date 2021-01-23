<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends MY_Controller
{

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   * 		http://example.com/index.php/welcome
   *	- or -
   * 		http://example.com/index.php/welcome/index
   *	- or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function index()
  {
    $this->load->model("permission/User_model", "user");

    $user = $this->user->first(1);
    die(var_dump(

      can("Master", "Super Admin")
    ));


    die(var_dump($user->views()->select("DAY(created_at) as day")->first()));;
    die(var_dump($this->db->last_query()));

    $isi['data'] =  $this->db->select("u_tbljeniskarya.*,u_tblbutir.namabutir,u_tbljeniskarya.jeniskarya,u_tblsumberbiaya.sumberbiaya")
      ->from("u_tblpenelitian")
      ->join("u_tbljeniskarya", "u_tblpenelitian.idjeniskarya=u_tbljeniskarya.idjeniskarya")
      ->join("u_tblbutir", "u_tblbutir.idbutir=u_tblpenelitian.idbutir")
      ->join("u_tblsumberbiaya", "u_tblsumberbiaya.idsumberbiaya=u_tblpenelitian.idsumberbiaya")
      ->get()->result();
  }
}

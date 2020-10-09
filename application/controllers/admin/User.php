<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	private $rules = array(
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
			'rules' => 'required|is_unique[users.username]'
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
			'rules' => 'required|is_unique[users.email]'
		)
	);
	public function index()
	{
		$this->load->model('visitor_m');
		$dt = $this->visitor_m->getVisitor()->result_array();
		$this->template->load('admin', 'user/dashboard', $this->data);
	}
	public function list()
	{
		in_role([1, 2]);
		$users = $this->db->where('id!=', 1)->get("users");
		$data = [
			'page_title' => "List Users",
			'users'  => $users,
		];

		$this->template->load('admin', 'user/index', $data);
	}
	public function add()
	{
		in_role("1");


		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->rules);

		if ($this->form_validation->run()) {
			$dt = [];
			foreach ($this->input->post() as $row => $value) {
				$dt[$row] = $value;
			}

			$dt['profile'] = $this->upload();

			$user = $this->m_user->tambah($dt);

			redirect(base_url('admin/user/list'));
		} else {
			$this->load->model('role_model', 'm_role');
			$roles = $this->m_role->where('id!=', 1)->get()->result_object();
			$users = $this->m_user->getAllUser();

			$data = [
				'page_title' => "Tambah User",
				'roles' => $roles,
			];
			$this->template->load('admin', 'user/tambah', $data);
		}
	}
	function edit($id)
	{
		in_role("1");
		$rules   = $this->m_user->rules;
		$only = ['password', 'status', 'role_id', 'nama_user'];

		$filtered = [];
		foreach ($rules as $key => $value) {
			if (in_array($value['field'], $only))
				$filtered[] = $value;
		}


		$this->load->library('form_validation');
		$this->form_validation->set_rules($filtered);

		if ($this->form_validation->run() == false) {

			$this->load->model('role_model', 'm_role');
			$roles = $this->m_role->where('id!=', 1)->get()->result_object();
			$user = $this->m_user->get($id)->row_object();

			$data = [
				'page_title' => "edit User",
				'user_edit' => $user,
				'roles' => $roles,
			];
			$this->template->load('admin', 'user/edit', $data);
		} else {
			$dt = [];
			foreach ($this->input->post() as $row => $value) {
				$dt[$row] = $value;
			}
			$dt['profile'] = $this->upload();

			$this->m_user->where('id', $id)->update($dt);


			$this->db->where("user_id", $id);
			$ekss = $this->db->update('tbl_role_user', ['role_id' => $dt['role_id']]);
			redirect('admin/user/list');
		}
	}
	private function upload($filename = 'default.jpg')
	{
		if ($_FILES['gambar']['name']) {
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = '2048';
			$config['upload_path'] = './assets/mobils/';
			$this->load->library('upload', $config);

			if ($this->upload->do_upload('gambar')) {
				if (is_file(FCPATH . 'assets/mobils/' . $filename) && $filename != 'default.jpg')
					unlink(FCPATH . 'assets/mobils/' . $filename);

				$filename = $this->upload->data('file_name');
			} else {
				echo $this->upload->display_errors();
			}
		}
		return $filename;
	}
	function getLog()
	{
		$this->data['log'] = $this->log_model->getId()->result_array();
		$this->template->load('admin', 'user/log/test', $this->data);
	}
	function profile()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('tentang_saya', 'Tentang Saya', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->data['page']['title'] = 'Profile User';
			$this->data['page']['description'] = 'Silahkan lihat data profile anda, dan ubah jika ada yang tidak sesuai dengan anda, </br> Inggat data harus real.!';
			// $this->data['page']['before'] = ['url' => base_url('admin/menu'), "title" => "Menu Access"];
			$this->data['page']['submenu'] = 'Profile User';


			$this->template->load('admin', 'user/profile/index', $this->data);
		} else {

			$upload_image = $_FILES['image']['name'];

			$file = $this->data['user']['file'];
			$id_file = $this->data['user']['file_id'];

			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size']      = '2048';
				$config['upload_path'] = './assets/img/profile/';
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					if (is_file(FCPATH . 'assets/img/profile/' . $file))
						unlink(FCPATH . 'assets/img/profile/' . $file);
					if (is_file(FCPATH . 'assets/img/thumbnail/profile/' . $file))
						unlink(FCPATH . 'assets/img/thumbnail/profile_' . $file);

					$newFile = $this->upload->data('file_name');
					$this->_create_thumbs($newFile);

					$this->load->model("file_model");
					$dt = [
						'file' => $newFile
					];
					$this->file_model->update($id_file, $dt);
				} else {
					echo $this->upload->display_errors();
				}
			}
			$data = [
				'no_hp' => htmlspecialchars($this->input->post('no_hp')),
				'tentang_saya' => htmlspecialchars($this->input->post('tentang_saya')),
				'name' => htmlspecialchars($this->input->post('name')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'tgl_lahir' => strtotime($this->input->post('tgl_lahir'))
			];
			$this->user_model->update($data);
			hasilCUD("Data Berhasil di Ubah");
			header("Refresh:0");
		}
	}

	function changepassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('newPassword', 'Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Repeat Password', 'trim|required|min_length[3]|matches[newPassword]');

		if ($this->form_validation->run() == false) {
			$this->data['page']['title'] = 'Mengganti Password';
			$this->data['page']['description'] = 'Silahkan ubah password lama anda, gunakan karakter yang susah di tebak.!';
			// $this->data['page']['before'] = ['url' => base_url('admin/menu'), "title" => "Menu Access"];
			$this->data['page']['submenu'] = 'Ganti password';
			$this->template->load('admin', 'user/profile/changepassword', $this->data);
		} else {
			$oldPassword = $this->input->post('oldPassword');
			// cek kebenran password lama
			if (password_verify($oldPassword, $this->data['user']['password'])) {
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$email = $this->session->userdata('email');
				$this->db->set('password', $password);
				$this->db->where('email', $email);
				$this->db->update('tbl_user');
				if ($this->db->affected_rows() > 0) {
					$this->session->unset_userdata('email');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
					redirect('admin/auth');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal.!</div>');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password lama tidak cocok.!</div>');
				redirect('admin/user/changepassword');
			}
		}
	}

	public function laporan_pdf()
	{
		$this->load->model('publikasi_model', 'publikasi');
		$this->load->model('pendidikan_model', 'pendd');
		$this->load->model('jabatan_model', 'jabatan');
		$this->load->model('pelatihan_model', 'pelatihan');

		$this->data['get_publikasi'] = $this->publikasi->getId()->result_array();
		$this->data['get_jabatan'] = $this->jabatan->getId()->result_array();
		$this->data['get_pelatihan'] = $this->pelatihan->getId()->result_array();
		$this->data['get_pendd'] = $this->pendd->getId([
			'pendd_user.user_id' => $this->data['user']['id']
		])->result_array();

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-petanikode.pdf";

		$html = $this->load->view('index2', $this->data);
		// $this->pdf->load_html($html);
		// $this->pdf->render();
		// $this->pdf->stream($this->pdf->filename, array("Attachment" => false));
	}
	function _create_thumbs($file_name)
	{
		// Image resizing config
		$config = array(
			// Large Image
			// array(
			//     'image_library' => 'GD2',
			//     'source_image'  => './assets/images/' . $file_name,
			//     'maintain_ratio' => FALSE,
			//     'width'         => 700,
			//     'height'        => 467,
			//     'new_image'     => './assets/images/large/' . $file_name
			// ),
			// Medium Image
			// array(
			//     'image_library' => 'GD2',
			//     'source_image'  => './assets/images/' . $file_name,
			//     'maintain_ratio' => FALSE,
			//     'width'         => 600,
			//     'height'        => 400,
			//     'new_image'     => './assets/images/medium/' . $file_name
			// ),
			// Small Image
			array(
				'image_library' => 'GD2',
				'source_image'  => './assets/img/profile/' . $file_name,
				'maintain_ratio' => FALSE,
				'width'         => 100,
				'height'        => 100,
				'new_image'     => './assets/img/thumbnail/profile_' . $file_name
			)
		);

		$this->load->library('image_lib', $config[0]);
		foreach ($config as $item) {
			$this->image_lib->initialize($item);
			if (!$this->image_lib->resize()) {
				return false;
			}
			$this->image_lib->clear();
		}
	}

	function notif()
	{
		$this->template->load('admin', 'admin/notif', $this->data);
	}
	function notif_action()
	{
		$link = 'admin/notif';
		$this->data['get_notif'] =  $this->notif_model->getId()->row_array();
		$read = $this->notif_model->read();
		$this->template->load('admin', 'admin/notif_action', $this->data);
	}
	function permit(bool $b)
	{
		if (!$b)
			return $this->blocked();
	}
	private function blocked()
	{
		echo "anda diblocked";
		die();
	}
	function log()
	{
	}
	function setting()
	{
		foreach ($_POST as $key => $value) {
			$where['name'] = htmlspecialchars($key);
			$data['title'] = htmlspecialchars($value);
		}
		$this->setting_m->update($where, $data);
	}
}

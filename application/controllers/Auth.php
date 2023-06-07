<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Auth');
	}
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
		$this->load->view('Auth/login');
		// $this->load->view('maintenance');
		// if($this->session->userdata('status') != "login"){
	 		

	 // 	}else{
	 // 		redirect(base_url("Dashboard/index"));
	 // 	}
		
	}
	public function proses_login()
	{
		$this->load->library('session');

		$output = array('error' => false);

		$nik = $_POST['nik'];
		$password = $_POST['password'];

		$data = $this->M_Auth->login($nik, $password);

		if($data->num_rows() > 0){
 			foreach ($data->result() as $value) {
				$data_session = array(
					'NIK' => $value->NIK,
					'NAMA'=> $value->NAMA,
					'JABATAN'=>$value->JABATAN,
					'DEPARTEMEN' =>$value->DEPARTEMEN,
					'SEKSI' => $value->SEKSI,
					'DIVISI' => $value->DIVISI,
					'JENIS_KELAMIN' => $value->JENIS_KELAMIN,
					'LEVEL' => $value->LEVEL,
					'AVATAR'=>$value->AVATAR,
					'KODE_DEPT' => $value->KODE_DEPT,
					'SUB_DEPARTEMEN' => $value->SUB_DEPARTEMEN,
					'status' => "login",
					'marketing'=>$value->SubDepartemen2,
					'DLV' => $value->OTORITAS_DLV,
					'NDV' => $value->OTORITAS_NDV,
					);
	 
				$this->session->set_userdata($data_session);
	 			$output['message'] = 'Berhasil Masuk Kedalam Sistem. Mohon Tunggu...';
 			}
		}else{
			$output['error'] = true;
			$output['message'] = 'Login Gagal. Pengguna Tidak Ditemukan atau Akun Anda Di Non-Aktifkan! Hubungi Admin!';
		}
		// if($data){
		// 	$this->session->set_userdata('user', $data);
		// 	$output['message'] = 'Logging in. Please wait...';
		// }
		// else{
		// 	$output['error'] = true;
		// 	$output['message'] = 'Login Invalid. User not found';
		// }

		echo json_encode($output);
	}
	function Logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function Profile()
	{
		$data['side'] = '';
		$data['page'] = 'Profile';
		$data['avatar'] = $this->M_Auth->getDataAvatar()->result();
		$data['data'] = $this->M_Auth->view_akun()->result();
		$this->load->view("auth/profile/index", $data);
	}
	public function updateAvatar()
	{
		$inputAvatar = $this->input->post("inputAvatar");
		$data = $this->M_Auth->updateAvatar($inputAvatar);
		echo json_encode($data);
	}
	public function updatePassword()
	{
		$inputPassword = $this->input->post("inputPassword");
		$data = $this->M_Auth->updatePassword($inputPassword);
		echo json_encode($data);
	}
}
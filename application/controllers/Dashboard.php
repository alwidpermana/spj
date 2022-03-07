<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		// $this->load->model('M_Login');
		
		$this->load->library('form_validation');
		// $this->load->model('M_TimbangRubber');
		if($this->session->userdata('status') != "login"){
	 		redirect(base_url("Auth/index"));
	 	}
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
		$data['page'] = '';
		$data['side'] = 'dashboard';
		if($this->session->userdata('status') == "login"){
	 		$this->load->view('Dashboard/index', $data);
	 	}else{
	 		redirect(base_url("Auth/index"));		
	 	}
		
	}
}
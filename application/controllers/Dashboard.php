<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		// $this->load->model('M_Login');
		
		$this->load->library('form_validation');
		$this->load->model('M_Monitoring');
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
		$data['tempKendaraan'] = $this->M_Monitoring->getDashboardTemporaryKendaraan()->result();
		$data['tempPIC'] = $this->M_Monitoring->getDashboardTemporaryPIC()->result();
		$data['jmlGenerate'] = $this->M_Monitoring->getDashboardPersentaseJmlGenerate()->num_rows();
		$data['outstanding'] = $this->M_Monitoring->getDashboardOutstanding()->num_rows();
		$data['jml_spj'] = $this->M_Monitoring->getDashboardJumlahSPJ()->num_rows();
		$this->load->view('Dashboard/index', $data);
		
		
	}
	public function pageTest()
	{
		$data['page'] = '-';
		$data['side'] = '-';
		$this->load->view('Dashboard/test', $data);
	}
	public function getJmlSPJForDashboard()
	{
		$data = $this->M_Monitoring->getJmlSPJForDashboard()->result();
		echo json_encode($data);
	}
	
	public function testAPI()
	{

		echo json_encode($data);
	}
	public function saveDeliverySetup()
	{
		$this->load->model('M_Serlok');
		$data = $this->M_Serlok->saveDeliverySetup();
		
		echo json_encode($data);
	}
	public function getWarningLimitSaldo()
	{
		$this->load->model('M_Data_Master');
		$data = $this->M_Data_Master->getLimitSaldo(" AND LIMIT_SALDO >= JUMLAH AND JENIS NOT LIKE '%Non Delivery%'");
		// if ($data->num_rows()>0) {
		// 	$get = $data->row();
		// 	$response = array('status' =>'warning','keterangan'=>$get->DESKRIPSI);
		// }else{
		// 	$response = array('status' =>'success','keterangan'=>'');
		// }
		$response = array('status' =>'success','keterangan'=>'');
		echo json_encode($response);
	}
}
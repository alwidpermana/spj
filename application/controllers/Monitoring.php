<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Auth');
		$this->load->model('M_Data_Master');
		$this->load->model('M_Pengajuan');
		$this->load->model('M_Serlok');
		$this->load->model('M_Monitoring');
		$this->load->library('pdfgenerator');
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
	public function spj()
	{
		$status = $this->input->get("status");
		$data['page'] = 'Monitoring SPJ';
		$data['side'] = 'monitoring-spj';
		$data['status'] = $status;
		$this->load->view('monitoring/spj/index', $data);
	}
	public function getTabelSPJ()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filPeriode = $this->input->get("filPeriode");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id = '', $adjustment='')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$this->load->view("monitoring/spj/tabel", $data);
	}
	public function view_spj($id)
	{
		$data['page'] = 'View SPJ';
		$data['side'] = 'monitoring-spj';
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		if ($id=='') {
			redirect("Monitoring/spj");
		}else{
			$this->load->view("monitoring/spj/view/index", $data);
		}
		
	}
	public function getQrCode()
	{
		$id = $this->input->get("id");
		$getNoSPJ = $this->M_Monitoring->getNoSPJByID($id); 
		$no = $getNoSPJ;
		$namaFile = str_replace("/","",$no);
		$data['nama'] = $namaFile;
		$this->load->view("pengajuan/form/qr_code", $data);
	}
	public function export_spj($id)
	{
		$this->data['title_pdf'] = 'SPJ';
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$getNoSPJ = $this->M_Monitoring->getNoSPJByID($id); 
		$no = $getNoSPJ;
		$namaFile = str_replace("/","",$no);
		$data['nama'] = $namaFile;
		$html = $this->load->view('monitoring/spj/view/export', $data, true);
		$filename = 'SPJ';

		$this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
		$this->pdfgenerator->set_option('isRemoteEnabled', true);
	}
	public function saveDebit()
	{
		$inputDebit = $this->input->post("inputDebit");
		$inputId = $this->input->post("inputId");
		$inputJenis = $this->input->post("inputJenis");
		$inputJenisKasbon = $this->input->post("inputJenisKasbon");
		$data = $this->M_Monitoring->saveDebit($inputDebit, $inputId, $inputJenis, $inputJenisKasbon);
		echo json_encode($data);
	}
	public function kasbon_spj()
	{
		$data['side'] = "monitoring-kasbon-SPJ";
		$data['page'] = 'Kasbon SPJ';
		$data['kasbon'] = 'SPJ';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("monitoring/kasbon/index", $data);
	}
	public function kasbon_bbm()
	{
		$data['side'] = "monitoring-kasbon-BBM";
		$data['page'] = 'Kasbon BBM';
		$data['kasbon'] = 'BBM';
		$this->load->view("monitoring/kasbon/index", $data);
	}
	public function kasbon_tol()
	{
		$data['side'] = "monitoring-kasbon-TOL";
		$data['page'] = 'Kasbon TOL';
		$data['kasbon'] = 'TOL';
		$this->load->view("monitoring/kasbon/index", $data);
	}
	public function getTabelKasbonSPJ()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filPeriode = $this->input->get("filPeriode");
		$filJenis = $this->input->get("filJenis");
		$filStatus = $this->input->get("filStatus");
		$jenisKasbon = $this->input->get("jenisKasbon");
		$jenisID = $filJenis == 'Delivery'? '1':'2';
		if ($filJenis == 'Delivery') {
			$jenisID = '1';
		}elseif($filJenis == 'Non Delivery'){
			$jenisID = '2';
		}else{
			$jenisID = '';
		}
		$data['jenis'] = $jenisKasbon;
		$data['data'] = $this->M_Monitoring->getKasbonSPJ($jenisKasbon, $filJenis, $filBulan, $filTahun)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $jenisID, $filSearch='', $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $jenisID, $filSearch='', $id='')->result();
		$this->load->view("monitoring/kasbon/tabel", $data);
	}
	public function voucher_bbm()
	{
		$data['side'] = 'monitoring-voucher';
		$data['page'] = 'Monitoring - Voucher';
		$this->load->view("monitoring/voucher/index", $data);
	}
	public function getMonVoucherBBM()
	{
		$data['data'] = $this->M_Monitoring->monitoring_voucher()->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $jenisID='', $filSearch='', $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $jenisID='', $filSearch='', $id='')->result();
		$this->load->view("monitoring/voucher/tabel", $data);
	}
}
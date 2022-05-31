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
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id = '', $adjustment='','')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$this->load->view("monitoring/spj/tabel", $data);
	}
	public function view_spj($id)
	{
		$data['page'] = 'View SPJ';
		$data['side'] = 'monitoring-spj';
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='','')->result();
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
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='','')->result();
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
	public function generate_spj()
	{
		$data['side'] = 'monitoring-generate';
		$data['page'] = 'Monitoring Generate SPJ';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("monitoring/generate/index", $data);
	}
	public function getTabelGenerate()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$periodeAwal = $this->input->get("periodeAwal");
		$periodeAkhir = $this->input->get("periodeAkhir");
		$filJenis = $this->input->get("filJenis");
		$filStatus = $this->input->get("filStatus");
		if (date("m", strtotime($periodeAwal))!= date("m", strtotime($periodeAkhir))) {
			$filBulan = '';
		}
		
		$data['data'] = $this->M_Monitoring->getGenerateSPJ($filBulan, $filTahun, $filJenis, $filStatus, $periodeAwal, $periodeAkhir)->result();
		$this->load->view("monitoring/generate/tabel", $data);
	}
	public function listSPJByNoGenerate()
	{
		$noGenerate = $this->input->get("noGenerate");
		$data['data'] = $this->M_Monitoring->getSPJByGenerate($noGenerate)->result();
		$data['pic'] = $this->M_Monitoring->getPendampingByNoGenerate($noGenerate)->result();

		$this->load->view("monitoring/generate/list-spj", $data);
	}
	public function harian()
	{
		$data['side'] = 'monitoring-harian';
		$data['page'] = 'Monitoring Harian SPJ';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view('monitoring/harian/index', $data);
	}
	public function getTabelHarianSPJ()
	{
		date_default_timezone_set('Asia/Jakarta');
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$data['data'] = $this->M_Monitoring->getMonitoringSPJHarian2($filBulan, $filTahun, $filJenis)->result();
		$this->load->view("monitoring/harian/tabel", $data);
	}
	public function getIdSPJ()
	{
		$noSPJ = $this->input->get("noSPJ");
		$sql = $this->db->query("SELECT ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'");
		$data = $sql->row();
		echo json_encode($data);
	}
	public function in_out_kendaraan()
	{
		$data['side'] = 'monitoring-kendaraan';
		$data['page'] = 'Monitoring In Out Kendaraan';
		$this->load->view("monitoring/kendaraan_in_out/index", $data);
	}
	public function getTabelInOutKendaraan()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$data['data'] = $this->M_Monitoring->getInOutKendaraan2($filBulan, $filTahun)->result();
		$data['tgl'] = $this->M_Monitoring->getInOutKendaraanDetail($filBulan, $filTahun)->result();
		$this->load->view("monitoring/kendaraan_in_out/tabel", $data);
	}
	public function in_out_pic()
	{
		$data['side'] = 'monitoring-pic';
		$data['page'] = 'Monitoring In Out PIC';
		$this->load->view("monitoring/pic_in_out/index", $data);
	}
	public function getTabelInOutPIC()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$data['data'] = $this->M_Monitoring->getInOutPIC($filBulan, $filTahun)->result();
		$data['tgl'] = $this->M_Monitoring->getInOutPICDetail($filBulan, $filTahun)->result();
		$this->load->view("monitoring/pic_in_out/tabel", $data);
	}
	public function km_kendaraan()
	{
		$data['side'] = 'monitoring-km';
		$data['page'] = 'Monitoring KM Kendaraan';
		$this->load->view("monitoring/km_kendaraan/index", $data);
	}
	public function getTabelKmKendaraan()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$data['data'] = $this->M_Monitoring->getInOutKendaraan2($filBulan, $filTahun)->result();
		$data['tgl'] = $this->M_Monitoring->getMonitoringKMKendaraan($filBulan, $filTahun)->result();
		$this->load->view("monitoring/km_kendaraan/tabel", $data);
	}
	public function kendaraan_jam_ke_2()
	{
		$data['side'] = 'monitoring-kendaraan_2';
		$data['page'] = 'Monitoring Kendaraan Jam Ke 2';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("monitoring/kendaraan_2/index", $data);
	}
	public function getMonitoringKendaraanKe2()
	{
		date_default_timezone_set('Asia/Jakarta');
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$data['data'] = $this->M_Monitoring->getMonitoringKendaraanKe2($filBulan, $filTahun, $filJenis)->result();
		$this->load->view("monitoring/kendaraan_2/tabel", $data);
	}
	public function pic_jam_ke_2()
	{
		$data['side'] = 'monitoring-pic_2';
		$data['page'] = 'Monitoring PIC Jam Ke 2';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("monitoring/pic_2/index", $data);
	}
	public function getMonitoringPICKe2()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$data['data'] = $this->M_Monitoring->getMonitoringPICKe2($filBulan, $filTahun)->result();
		$data['pic'] = $this->M_Monitoring->getMonitoringPICKe2Detail($filBulan, $filTahun)->result();
		$this->load->view("monitoring/pic_2/tabel", $data);
	}
}
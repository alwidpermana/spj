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
		$this->load->model('M_Implementasi');
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
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$this->load->view('monitoring/spj/index', $data);
	}
	public function getTabelSPJ()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filStatus = $this->input->get("filStatus");
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
		$getData = $this->db->query("SELECT NO_SPJ, JENIS_ID FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id");
		foreach ($getData->result() as $key) {
			$no_spj = $key->NO_SPJ;
			$jenisId = $key->JENIS_ID;
		}
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='','')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic'] = $this->M_Monitoring->getPICPengajuanVersi2($no_spj)->result();
		$data['validasi'] = $this->M_Implementasi->getValidasiSPJ($no_spj)->result();
		$data['jam_tambahan'] = $this->M_Data_Master->getJamTambahan()->result();
		$where = "WHERE ID_JENIS = $jenisId";
		$data['tambahan'] = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
		$data['uang_makan'] = $this->M_Data_Master->getUangMakan()->result();
		$data['adjustment'] = $this->M_Implementasi->getDataAdjustment($no_spj)->result();
		$data['realisasi'] = $this->M_Implementasi->realisasiBiayaSPJ($no_spj)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['history'] = $this->M_Implementasi->getHistoryInOutLokal($no_spj)->result();
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
	public function print_spj($id)
	{
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='','')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$getNoSPJ = $this->M_Monitoring->getNoSPJByID($id); 
		$no = $getNoSPJ;
		$namaFile = str_replace("/","",$no);
		$data['nama'] = $namaFile;
		$getSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id")->row();
		$noSPJ = $getSPJ->NO_SPJ;
		$this->M_Monitoring->saveSPJLog('New',$noSPJ,'Masuk Ke Halaman Print SPJ');
		$this->load->view('monitoring/spj/view/print', $data);
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
		$data['spj'] =$this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$this->load->view("monitoring/kasbon/indexNew", $data);
	}
	public function kasbon_bbm()
	{
		$data['side'] = "monitoring-kasbon-BBM";
		$data['page'] = 'Kasbon BBM';
		$data['kasbon'] = 'BBM';
		$this->load->view("monitoring/kasbon/indexBBM", $data);
	}
	public function kasbon_tol()
	{
		$data['side'] = "monitoring-kasbon-TOL";
		$data['page'] = 'Kasbon TOL';
		$data['kasbon'] = 'TOL';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("monitoring/kasbon/indexTOL", $data);
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
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$this->load->view("monitoring/voucher/index", $data);
	}
	public function getMonVoucherBBM()
	{
		$filSearch = $this->input->get("filSearch");
		$filStatus = $this->input->get("filStatus");
		$filJenis = $this->input->get("filJenis");
		$data['data'] = $this->M_Monitoring->monitoring_voucher($filStatus, $filSearch, $filJenis)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $jenisID='', $filSearch='', $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $jenisID='', $filSearch='', $id='')->result();
		$this->load->view("monitoring/voucher/tabel", $data);
	}
	public function saveNominalVoucherBBM()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputNoVoucher = $this->input->post("inputNoVoucher");
		$inputBiaya = $this->input->post("inputBiaya");
		$inputId = $this->input->post("inputId");
		$inputBiayaAwal = $this->input->post("inputBiayaAwal");
		$data = $this->M_Monitoring->saveNominalVoucherBBM($inputNoSPJ, $inputBiaya);
		$this->M_Monitoring->saveVoucherBBM($inputNoVoucher, $inputBiaya);
		$this->updateSaldo($inputId, $inputBiaya, $inputBiayaAwal);
		echo json_encode($data);
	}
	public function generate_spj()
	{
		$data['side'] = 'monitoring-generate';
		$data['page'] = 'Monitoring SPJ (Per Generate)';
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
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
		$where = " AND TGL_GENERATE BETWEEN '$periodeAwal' AND '$periodeAkhir'";
		$data['data'] = $this->M_Monitoring->getGenerateSPJ($filBulan, $filTahun, $filJenis, $filStatus, $where, '')->result();
		$this->load->view("monitoring/generate/tabel", $data);
	}
	public function listSPJByNoGenerate()
	{
		$noGenerate = $this->input->get("noGenerate");
		$data['data'] = $this->M_Monitoring->getSPJByGenerate($noGenerate)->result();
		$data['pic'] = $this->M_Monitoring->getPendampingByNoGenerate($noGenerate)->result();

		$this->load->view("monitoring/generate/list-spj", $data);
	}
	public function detail_generate($id)
	{
		$data['side'] = 'monitoring-generate';
		$whereID = " WHERE ID = $id";
		$data['generate'] = $this->M_Monitoring->getGenerateSPJ('', '', '', '', '', $whereID)->result();
		$data['page'] = 'Detail Monitoring SPJ (Per Generate)';
		$data['data'] = $this->M_Monitoring->getSPJByIdGenerate($id)->result();
		$data['pic'] = $this->M_Monitoring->getPICByIdGenerate($id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByIdGenerate($id)->result();
		$this->load->view("monitoring/generate/detail", $data);
	}
	public function harian()
	{
		$data['side'] = 'monitoring-harian';
		$data['page'] = 'Monitoring Harian SPJ';
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled'; 
		$this->load->view('monitoring/harian/index', $data);
	}
	public function getTabelHarianSPJ()
	{
		date_default_timezone_set('Asia/Jakarta');
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$data['data'] = $this->M_Monitoring->getMonitoringSPJHarian2($filBulan, $filTahun, $filJenis)->result();
		$data['summaryOK'] = $this->M_Monitoring->getMonitoringSPJHarianSummary($filBulan, $filTahun, $filJenis, "OK")->result();
		// $data['summaryCancel'] = $this->M_Monitoring->getMonitoringSPJHarianSummary($filBulan, $filTahun, $filJenis, $whereCancel)->result();
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
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
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
	public function cancelSPJ()
	{
		$id = $this->input->post("id");
		$status = $this->input->post("status");
		$data = $this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = '$status' WHERE ID_SPJ = $id");
		$getSPJ = $this->db->query("SELECT ID_SPJ, JENIS_ID, TOTAL_UANG_SAKU, TOTAL_UANG_MAKAN, TOTAL_UANG_JALAN, VOUCHER_BBM FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id");
		$voucher = '';
		foreach ($getSPJ->result() as $key) {
			$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN;
			$jenis = $key->JENIS_ID;
			$voucher = $key->VOUCHER_BBM;
			$this->updateSaldoSPJ($id, $total, $jenis, $status);
		}
		$statusVoucher = $status == 'CANCEL'?'NOT':'USED';
		$this->db->query("UPDATE SPJ_VOUCHER_BBM SET STATUS = '$statusVoucher' WHERE NO_VOUCHER = '$voucher'");
		echo json_encode($data);
	}
	public function getMonitoringKasbon()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan") == '' ? '1':$this->input->get("filBulan");
		$tglBulan = '01-'.$filBulan.'-2022';
		$namaBulan = $this->input->get("filBulan") == '' ? '':date("F", strtotime($tglBulan));
		$filJenis = $this->input->get("filJenis");
		$filStatus = $this->input->get("filStatus");
		$data['status'] = $filStatus;
		$data['data'] = $this->M_Monitoring->getKasbonCashFlow($filJenis,$filTahun, $filBulan, $namaBulan, $filStatus)->result();
		$this->load->view("monitoring/kasbon/tabelNew", $data);
	}
	public function getLatestMonthKasbon()
	{
		$filJenis = $this->input->get("filJenis");
		$filBulan = $this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun");
		$data = $this->M_Monitoring->getLastSaldoMonth($filBulan, $filTahun, $filJenis)->row();
		echo json_encode($data);
	}
	public function getMonitoringKasbonBBM()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan") == '' ? '1':$this->input->get("filBulan");
		$tglBulan = '01-'.$filBulan.'-2022';
		$namaBulan = $this->input->get("filBulan") == '' ? '':date("F", strtotime($tglBulan));
		$filJenis = 'Kasbon Voucher BBM';
		$filStatus = $this->input->get("filStatus");

		$data['data'] = $this->M_Monitoring->getKasbonCashFlow($filJenis,$filTahun, $filBulan, $namaBulan, $filStatus)->result();
		$this->load->view("monitoring/kasbon/tabelBBM", $data);
	}
	public function updateSaldo($inputId, $inputBiaya, $inputBiayaAwal)
	{
		$this->load->model('M_Cash_Flow');
		$jenis = 'Kasbon Voucher BBM';
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($jenis, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		$totalSaldo = ($saldo+$inputBiayaAwal) - $inputBiaya;
		$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
		$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $inputBiaya, 'KASBON', $inputId,'VOUCHER');
	}

	public function getBiayaAdmin()
	{
		$filJenis = $this->input->get("filJenis")=='Kasbon TOL Delivery'?'1':'2';
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filStatus = $this->input->get("filStatus");
		$data['data'] = $this->M_Monitoring->getTabelBiayaAdmin($filJenis, $filTahun, $filStatus)->result();
		$this->load->view("monitoring/kasbon/tabelBiayaAdmin", $data);
	}
	public function saveBiayaAdmin()
	{
		$inputTglBiaya = $this->input->post("inputTglBiaya");
		$inputJenis = $this->input->post("inputJenis");
		$inputBiaya = $this->input->post("inputBiaya");
		$inputKeterangan = $this->input->post("inputKeterangan");
		$inputId = $this->input->post("inputID");
		$inputNo = $this->M_Monitoring->getNoBiayaAdmin();
		if ($inputId=='') {
			$data = $this->M_Monitoring->saveBiayaAdmin($inputTglBiaya, $inputJenis, $inputBiaya, $inputKeterangan, $inputNo);
		}else{
			$data = $this->M_Monitoring->updateBiayaAdmin($inputTglBiaya, $inputJenis, $inputBiaya, $inputKeterangan, $inputId);
		}
		
		echo json_encode($data);
	}
	public function getKodeApprove()
	{
		$inputKode = $this->input->get("inputKode");
		$data = $this->M_Monitoring->getKodeApprove($inputKode)->num_rows();
		echo json_encode($data);
	}
	public function approveBiayaAdmin()
	{
		$inputId = $this->input->post("inputId");
		$inputStatus = $this->input->post("inputStatus");
		$kasbon = $this->input->post("kasbon");
		$biaya = $this->input->post("biaya");
		$totalBiaya = $this->input->post("totalBiaya");
		$data = $this->M_Monitoring->approveBiayaAdmin($inputId, $inputStatus);
		if ($inputStatus == 'APPROVED') {
			$this->updateSaldoBiayaAdmin($inputId, $kasbon, $biaya,'-','BIAYA ADMIN');
		}
		
		echo json_encode($data);
	}
	public function hapusBiayaAdmin()
	{
		$id = $this->input->post("id");
		$data = $this->M_Monitoring->hapusBiayaAdmin($id);
		echo json_encode($data);
	}
	public function updateSaldoBiayaAdmin($inputIdSPJ, $kasbon, $totalBiaya, $keterangan, $jenisFK)
	{
		$this->load->model('M_Cash_Flow');
		$id = $inputIdSPJ;
		$jenis = $kasbon;
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($jenis, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		$totalSaldo = $saldo - $totalBiaya;
		$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
		$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalBiaya, $jenisFK, $id,$keterangan);
	}
	public function updateSaldoSPJ($id, $total, $jenis, $status)
	{
		$this->load->model('M_Cash_Flow');
		$kasbon = $jenis == '1'?'Kasbon SPJ Delivery':'Kasbon SPJ Non Delivery';
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($kasbon, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		if ($status == 'CANCEL') {
			$totalSaldo = $status == 'CANCEL'?$saldo+$total:$saldo-$total;
			$this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'SUB KAS');
			$this->db->query("DELETE FROM SPJ_KAS_SUB WHERE JENIS_FK = 'KASBON' AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND FK_ID = $id");
		} else {
			$totalSaldo = $saldo-$total;
			$this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'SUB KAS');
			$this->M_Cash_Flow->saveSubKas($kasbon,'CREDIT', $total, 'KASBON', $id,'TRANSAKSI AWAL');
		}
	}
	public function ng_security()
	{
		$data['side']='monitoring-ng';
		$data['page']='Monitoring NG Security';
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$this->load->view("monitoring/ng/security/index", $data);
	}
	public function monitoringNGSecurity()
	{
		$filBulan = $this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$data['data'] = $this->M_Monitoring->monitoringNGSecurity($filBulan, $filTahun, $filJenis, $filSearch)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$this->load->view("monitoring/ng/security/tabel", $data);
	}
	public function detailNGSecurity()
	{
		$noSPJ = $this->input->get("noSPJ");
		$data['data'] = $this->M_Monitoring->detailNGSecurity($noSPJ)->result();
		$this->M_Implementasi->updateHistoryNG($noSPJ);
		$this->load->view("monitoring/ng/security/detail", $data);
	}
	public function getNotifNGSecurity()
	{
		$data = $this->M_Monitoring->getNotifNGSecurity()->num_rows();
		echo json_encode($data);
	}
	public function getNoBiayaAdmin()
	{
		$data = $this->M_Monitoring->getNoBiayaAdmin();
		echo json_encode($data);
	}
	public function pemakaian_rental()
	{
		$data['side'] = 'monitoring-rental-pemakaian';
		$data['page'] = 'Monitoring Pemakaian Kendaraan Rental';
		$this->load->view("monitoring/rental/pemakaian/index", $data);
	}
	public function listDataRekanan()
	{
		$cari = $this->input->get("cari");
		$sql = $this->M_Data_Master->getDataRekanan($cari);
		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['ID'] , 'text' =>$key['KODE'].' - '.$key['NAMA']);
		}
		echo json_encode($data);
	}
	public function getTabelMonitoringPemakaianKendaraan()
	{
		$filRekanan = $this->input->get("filRekanan");
		$bulan = $this->input->get("filBulan");
		$tahun = $this->input->get("filTahun");
		$data['data'] = $this->M_Monitoring->getTabelMonitoringPemakaianKendaraan($filRekanan, $bulan, $tahun)->result();
		$this->load->view("monitoring/rental/pemakaian/tabel", $data);
	}
	public function jumlah_pemakaian()
	{
		$data['side'] = 'monitoring-rental-jumlah';
		$data['page'] = 'Monitoring Jumlah Pemakaian Kendaraan Rental';
		$this->load->view("monitoring/rental/jumlah/index", $data); 
	}
	public function getTabelJumlahPemakaianKendaraanRental()
	{
		$filBulan = $this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun");
		$data['data']= $this->M_Monitoring->getTabelJumlahPemakaianKendaraanRental($filBulan, $filTahun)->result();
		$this->load->view("monitoring/rental/jumlah/tabel", $data); 
	}
	public function breakdown_pemakaian()
	{
		$data['side'] = 'monitoring-rental-breakdown';
		$data['page'] = 'Breakdown Pemakaian Kendaraan Rental';
		$this->load->view("monitoring/rental/breakdown/index", $data); 
	}
	public function getTabelBreakdownPemakaianKendaraanRental()
	{
		$filRekanan = $this->input->get("filRekanan");
		$tglMulai = $this->input->get("filTglMulai");
		$tglSelesai = $this->input->get("filTglSelesai");
		$filSearch = $this->input->get("filSearch");
		$data['data'] = $this->M_Monitoring->getBreakdownKendaraanRental($filRekanan, $tglMulai, $tglSelesai, $filSearch)->result();
		$this->load->view("monitoring/rental/breakdown/tabel", $data); 
	}
	public function getGroupTujuan()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$groupId = $this->input->get("groupId");
		$data = $this->db->query("SELECT GROUP_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
		$group = $data->GROUP_ID;
		$this->M_Monitoring->saveHistoryReloadLokasi($inputNoSPJ, $groupId, $group);
		echo json_encode($group);
	}
	public function print_generate($id)
	{
		$master = $this->M_Monitoring->getDataPrintSPJ($id)->row();
		$data['master'] = $master;
		$noGenerate = $master->NO_GENERATE;
		$ganjil = " WHERE NO_URUT %2 <> 0";
		$genap = " WHERE NO_URUT %2 = 0 ";
		$data['ganjil'] = $this->M_Monitoring->dataSPJByGenerate($noGenerate, $ganjil)->result();
		$data['genap'] = $this->M_Monitoring->dataSPJByGenerate($noGenerate, $genap)->result();
		$this->load->view("monitoring/generate/print", $data);
	}
	public function getTempBBM_SPJ()
	{
		$user = $this->session->userdata("NIK");
		$filSearch = $this->input->get("filSearch");
		$periodeAwal = $this->input->get("periodeAwal");
		$periodeAkhir = $this->input->get("periodeAkhir");
		$wherePeriode = " AND a.TGL_SPJ BETWEEN '$periodeAwal' AND '$periodeAkhir'";
		$getData = $this->M_Monitoring->getTempDataSPJ_BBM("", $filSearch, $wherePeriode);
		$data='';
		$jmlData = $getData->num_rows();
		$total = 0;
		$check = "";
		$rp = '';
		$read = '';
		foreach ($getData->result() as $key) {
			$check = $key->RP == null ? '' : 'checked';
			$read = $check == 'checked'?'':'readonly';
			if ($key->TOTAL_UANG_BBM != null && $key->RP != null) {
				$rp = $key->RP == null ? round($key->TOTAL_UANG_BBM) : round($key->RP);
			}
			$data .= '<tr>
						<td class="text-center">
							<div class="icheck-orange icheck-kps d-inline">
					          <input 
					            type="checkbox" 
					            id="'.$key->VOUCHER_BBM.'" 
					            name="checkVoucher"
					            noSPJ="'.$key->NO_SPJ.'"
					            voucher="'.$key->VOUCHER_BBM.'"
					            '.$check.'
					            >
					          <label for="'.$key->VOUCHER_BBM.'"></label>
					        </div>
						</td>
						<td>'.$key->NO_SPJ.'</td>
						<td>'.$key->VOUCHER_BBM.'</td>
						<td><input type="number" class="form-control inputTempVoucher" id="'.$key->VOUCHER_BBM.'" noSPJ="'.$key->NO_SPJ.'" voucher="'.$key->VOUCHER_BBM.'" value="'.$rp.'" '.$read.'></td>
					</tr>';
			$check='';
			$rp='';
		}
		$dataKosong = '<tr><td colspan="4" class="text-center">Tidak Ada Data Yang Perlu Diisi Biaya Voucher BBM</td></tr>';
		$kosong = $jmlData==0?$dataKosong:'';



		$json = array('jml'=>$jmlData ,'tabel'=>$data, 'kosong'=>$kosong);
		echo json_encode($json);
	}
	public function deleteTempBBM()
	{
		$user = $this->session->userdata("NIK");
		$data = $this->db->query("DELETE FROM SPJ_TEMP_BBM WHERE PIC_INPUT = '$user'");
		echo json_encode($data);
	}
	public function saveTempBBM_SPJ()
	{
		$noSPJ = $this->input->post("noSPJ");
		$voucher = $this->input->post("voucher");
		$rp = $this->input->post("rp");
		$data = $this->M_Monitoring->saveTempBBM_SPJ($noSPJ, $voucher, $rp);
		echo json_encode($data);
	}
	public function getTotalAndSaldoBBM()
	{
		$getTotal = $this->M_Monitoring->getTotalTempBBM_SPJ()->row();
		$total = $getTotal->RP == null ? 0 : $getTotal->RP;
		$this->load->model('M_Cash_Flow');
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis('Kasbon Voucher BBM','SUB KAS')->row();
		$saldoSPJ = $getSaldo->SALDO;
		$data = array('kasbon' =>round($total),'saldo'=>round($saldoSPJ));
		echo json_encode($data);
	}
	public function saveAllVoucherBBM()
	{
		$getData = $this->M_Monitoring->getTempDataSPJ_BBM(' AND b.RP IS NOT NULL', '', '');
		// $data = array();
		if ($getData->num_rows()>0) {
			foreach ($getData->result() as $key) {
				// $row = array();
				$inputNoSPJ = $key->NO_SPJ;
				$inputBiaya = $key->RP == null ? round($key->TOTAL_UANG_BBM) : round($key->RP);
				$inputNoVoucher = $key->VOUCHER_BBM;
				$inputId = $key->ID_SPJ;
				$inputBiayaAwal = round($key->TOTAL_UANG_BBM);
				// $row['noSPJ'] = $key->NO_SPJ;
				// $row['biaya'] = $key->RP == null ? $key->TOTAL_UANG_BBM : $key->RP;
				// $row['novoucher'] = $key->VOUCHER_BBM;
				// $row['id'] = $key->ID_SPJ;
				// $row['biay_awal'] = $key->TOTAL_UANG_BBM;

				// $data[] = $row;

				$data = $this->M_Monitoring->saveNominalVoucherBBM($inputNoSPJ, $inputBiaya);
				$this->M_Monitoring->saveVoucherBBM($inputNoVoucher, $inputBiaya);
				if ($inputBiaya > 0) {
					$this->updateSaldo($inputId, $inputBiaya, $inputBiayaAwal);
				}
				
			}
		}else{
			$data=false;
		}
		

		echo json_encode($data);
	}
	public function getTotalTempVoucherBBM()
	{
		$total = 0 ;
		$jml = 0;
		$getData = $this->M_Monitoring->getTempDataSPJ_BBM(' AND b.RP IS NOT NULL', '', '');
		if ($getData->num_rows()>0) {
			foreach ($getData->result() as $key) {
				$biaya = $key->RP == null ? $key->TOTAL_UANG_BBM : $key->RP;
				$total += $biaya;	
			}
		}
		$user = $this->session->userdata("NIK");
		$jml = $this->db->query("SELECT ID FROM SPJ_TEMP_BBM WHERE PIC_INPUT = '$user'")->num_rows();
		$data = array('total' =>$total,'jml'=>$jml );
		echo json_encode($data);

	}
	public function kondisiDBTemp()
	{
		$voucher = $this->input->post("voucher");
		$kondisi = $this->input->post('kondisi');
		$noSPJ = $this->input->post("noSPJ");
		$biaya = $this->input->post("biaya") == '' ? 0 :$this->input->post("biaya");
		$data = $this->M_Monitoring->kondisiDBTemp($voucher, $kondisi, $noSPJ, $biaya);
		echo json_encode($data);
	}

}
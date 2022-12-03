<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_Flow extends CI_Controller {
	function __construct(){
		parent::__construct();
		// $this->load->model('M_Login');
		$this->load->model('M_Cash_Flow');
		$this->load->model('M_Data_Master');
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
	public function buku_kas()
	{
		$data['page'] = 'Buku Kas Internal';
		$data['side'] = 'cash_flow-buku';
		$this->load->view("cash_flow/buku_kas/index2", $data);
	}
	public function getSaldoBukuKasInternal()
	{
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis('Modal Awal','KAS INDUK');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo = $key->SALDO;
		}
		echo json_encode($saldo);
	}
	public function getTabelKas()
	{
		$filBulan = $this->input->get("filBulan") == '' ? '1':$this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun") == '' ? date('Y'):$this->input->get("filTahun");
		$tglFilter = '01-'.$filBulan.'-'.$filTahun;
		$textBulan = $this->input->get("filBulan") == ''?'':date('F', strtotime($tglFilter));
		$data['data'] = $this->M_Cash_Flow->getDataBukuKasInternal($filBulan, $filTahun, $textBulan)->result();
		$this->load->view("cash_flow/buku_kas/tabel_kas", $data);
	}
	public function getTabelPengajuanKasInternal()
	{
		$filBulan = $this->input->get("filBulan") == '' ? '1':$this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun") == '' ? date('Y'):$this->input->get("filTahun");
		$tglFilter = '01-'.$filBulan.'-'.$filTahun;
		$bulan = $this->input->get("filBulan") == ''?'':date('F', strtotime($tglFilter));
		$data['data'] = $this->M_Cash_Flow->getTabelPengajuanKasInternal($bulan, $filTahun)->result();
		$this->load->view("cash_flow/buku_kas/tabel_pengajuan_kas", $data);
	}
	public function getTabelModalAwal()
	{
		$filBulan = $this->input->get("filBulan") == '' ? date('n'):$this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun") == '' ? date('Y'):$this->input->get("filTahun");
		$data['data'] = $this->M_Cash_Flow->getDataModalAwal($filBulan, $filTahun)->result();
		$this->load->view("cash_flow/buku_kas/tabel_modal_awal", $data);
	}
	public function saveBukuKas()
	{
		$inputTransaksi = $this->input->post("inputTransaksi");
		$inputTujuan = $this->input->post("inputTujuan");
		$inputBiaya = $this->input->post("inputBiaya");
		$fieldTujuan = $inputTransaksi == 'Modal Awal' ? 'DARI' : 'KE';
		$fieldBiaya = $inputTransaksi == 'Modal Awal' ? 'DEBIT' : 'CREDIT';
		$inputIDPengajuan = $this->input->post("inputIDPengajuan") == '' ? 0 : $this->input->post("inputIDPengajuan");
		$saldo = $this->input->post("saldo");
		$totalSaldo = $inputTransaksi == 'Modal Awal' ? $saldo + $inputBiaya : $saldo - $inputBiaya;
		$data = $this->M_Cash_Flow->saveBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputIDPengajuan);
		$data = $this->M_Cash_Flow->updateSaldo('Modal Awal',$totalSaldo,'KAS INDUK');
		if ($inputTransaksi != 'Modal Awal') {
			$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($inputTujuan,'KAS INDUK')->result();
			$totalSaldo2 = 0;
			foreach ($getSaldo as $sld) {
				$totalSaldo2 = $inputBiaya + $sld->SALDO;
			}
			$data = $this->M_Cash_Flow->updateSaldo($inputTujuan,$totalSaldo2,'KAS INDUK');
			$getLastID = $this->db->query("SELECT TOP 1 ID FROM SPJ_KAS ORDER BY ID DESC");
			$lastID = 0;
			foreach ($getLastID->result() as $last) {
				$lastID = $last->ID; 
			}
			$this->M_Cash_Flow->saveKasInduk($inputTujuan, 'DEBIT',$inputBiaya,'KAS INTERNAL', $lastID);
		}
		
		echo json_encode($data);
	}
	public function saveBukuKas2()
	{
		$inputTransaksi = $this->input->post("inputTransaksi");
		$inputTujuan = $this->input->post("inputTujuan");
		$inputBiaya = $this->input->post("inputBiaya");
		$fieldTujuan = $inputTransaksi == 'Modal Awal' ? 'DARI' : 'KE';
		$fieldBiaya = $inputTransaksi == 'Modal Awal' ? 'DEBIT' : 'CREDIT';
		$inputIDPengajuan = $this->input->post("inputIDPengajuan") == '' ? 0 : $this->input->post("inputIDPengajuan");
		$data = $this->M_Cash_Flow->saveBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputIDPengajuan);
		echo json_encode($data);
	}
	public function cekSaldoAwal()
	{
		$jenis = $this->input->get("jenis");
		$data = $this->M_Cash_Flow->getSaldoPerJenis($jenis,'KAS INDUK')->row();
		echo json_encode($data);
	}
	public function pengajuan()
	{
		$data['side'] = 'cash_flow-pengajuan';
		$data['page'] = 'Pengajuan Sub Kas';
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$this->load->view("cash_flow/pengajuan/index", $data);
	}
	public function getDataPengajuan()
	{
		$filJenis = $this->input->get("filJenis");
		$filStatus = $this->input->get("filStatus");
		$filJenisSPJ = $this->input->get("filJenisSPJ");
		$where = " AND TRANSAKSI != 'Generate'";
		$data['data'] = $this->M_Cash_Flow->getPengajuanSaldoByJenisSPJ($filJenis, $filStatus, $filJenisSPJ, $where)->result();
		$this->load->view("cash_flow/pengajuan/tabel", $data); 
	}
	public function savePengajuanSaldo()
	{
		$inputJenisKasbon = $this->input->post("inputJenisKasbon");
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputBiaya = $this->input->post("inputBiaya");
		$inputJenisData = $this->input->post("inputJenisData");
		$inputID = $this->input->post("inputID");
		if ($inputJenisData == 'tambah') {
			$data = $this->M_Cash_Flow->savePengajuanSaldo($inputJenisKasbon, $inputJenisSPJ, $inputBiaya);
		} else {
			$data = $this->M_Cash_Flow->updatePengajuanSaldo($inputJenisKasbon, $inputJenisSPJ, $inputBiaya, $inputID);
		}
		
		
		echo json_encode($data);
	}
	public function getKodeApprove()
	{
		$jenis = $this->input->get("jenis");
		$inputKodeApprove = $this->input->get("inputKodeApprove");
		$data = $this->M_Cash_Flow->kodeApprove($jenis, $inputKodeApprove)->num_rows();
		echo json_encode($data);
	}
	public function updateBukuKas()
	{
		$inputTransaksi = $this->input->post("inputTransaksi");
		$inputTujuan = $this->input->post("inputTujuan");
		$inputBiaya = $this->input->post("inputBiaya");
		$fieldTujuan = $inputTransaksi == 'Modal Awal' ? 'DARI' : 'KE';
		$fieldBiaya = $inputTransaksi == 'Modal Awal' ? 'DEBIT' : 'CREDIT';
		$inputTujuanAwal = $this->input->post("inputTujuanAwal");
		$inputBiayaAwal = $this->input->post("inputBiayaAwal");
		$saldo = $this->input->post("saldo");
		$inputID = $this->input->post("inputID");
		$data = $this->M_Cash_Flow->updateBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputID);
		$totalSaldo2 = 0;
		$totalSaldo3 = 0;

		if ($inputTransaksi == 'Pinbuk') {
			if ($inputTujuan != $inputTujuanAwal ) {
				$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($inputTujuanAwal,'KAS INDUK');
				foreach ($getSaldo->result() as $sld) {
					$totalSaldo2 = $sld->SALDO - $inputBiayaAwal;
				}
				
				$data = $this->M_Cash_Flow->updateSaldo($inputTujuanAwal,$totalSaldo2,'KAS INDUK');
				

				$getSaldo2 = $this->M_Cash_Flow->getSaldoPerJenis($inputTujuan,'KAS INDUK');
				foreach ($getSaldo2->result() as $sld) {
					$saldoTujuan = $sld->SALDO;
				}
				$totalSaldo3 = $saldoTujuan + $inputBiaya;
			}else{
				$getSaldo2 = $this->M_Cash_Flow->getSaldoPerJenis($inputTujuan,'KAS INDUK');
				foreach ($getSaldo2->result() as $sld) {
					$saldoTujuan = $sld->SALDO;
				}
				if ($inputBiaya == $inputBiayaAwal) {
					$totalSaldo3 = $saldoTujuan;
				}else{
					$totalSaldo3 = ($saldoTujuan - $inputBiayaAwal) + $inputBiaya;
				}
			}

			$data = $this->M_Cash_Flow->updateSaldo($inputTujuan,$totalSaldo3, 'KAS INDUK');	
			
			$this->M_Cash_Flow->updateKasInduk($inputTujuan, 'DEBIT', $inputBiaya, 'KAS INTERNAL', $inputID);
		}
		if ($inputBiayaAwal == $inputBiaya) {
			$totalSaldo = $saldo;
		}else{
			$saldoModalAwal = $inputBiayaAwal > $inputBiaya ? $inputBiayaAwal-$inputBiaya:$inputBiaya-$inputBiayaAwal;
			$totalSaldo = $inputBiayaAwal > $inputBiaya ? $saldoModalAwal + $saldo : $saldo-$saldoModalAwal;
		}
		$data = $this->M_Cash_Flow->updateSaldo('Modal Awal',$totalSaldo,'KAS INDUK');
		// $data = array('modal awal'=>'modal awal','totalSaldo' =>$totalSaldo ,'tujuan pertama'=>$inputTujuanAwal,'total Saldo Tujuan Pertama'=>$totalSaldo2, 'tujuan terakhir' => $inputTujuan, 'totalSaldoAkhir'=>$totalSaldo3 );
		echo json_encode($data);
	}
	public function updateBukuKasPengajuan()
	{
		$inputTransaksi = $this->input->post("inputTransaksi");
		$inputTujuan = $this->input->post("inputTujuan");
		$inputBiaya = $this->input->post("inputBiaya");
		$fieldTujuan = $inputTransaksi == 'Modal Awal' ? 'DARI' : 'KE';
		$fieldBiaya = $inputTransaksi == 'Modal Awal' ? 'DEBIT' : 'CREDIT';
		$inputTujuanAwal = $this->input->post("inputTujuanAwal");
		$inputBiayaAwal = $this->input->post("inputBiayaAwal");
		$inputID = $this->input->post("inputID");
		$data = $this->M_Cash_Flow->updateBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputID);
		echo json_encode($data);
	}
	public function hapusKas()
	{
		$id = $this->input->post("id");
		$transaksi = $this->input->post("transaksi");
		$tujuan = $transaksi == 'Modal Awal'?'Modal Awal':$this->input->post("tujuan");
		$biaya = $this->input->post("biaya");
		$data = $this->M_Cash_Flow->hapusKas($id);
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($tujuan,'KAS INDUK');
		foreach ($getSaldo->result() as $key) {
			$totalSaldo= $key->SALDO - $biaya;
		}
		$data = $this->M_Cash_Flow->updateSaldo($tujuan,$totalSaldo, 'KAS INDUK');
		
		if ($tujuan != 'Modal Awal') {
			$getSaldo2 = $this->M_Cash_Flow->getSaldoPerJenis('Modal Awal','KAS INDUK');
			foreach ($getSaldo2->result() as $key2) {
				$totalSaldo2= $key2->SALDO + $biaya;
			}
			$data = $this->M_Cash_Flow->updateSaldo('Modal Awal',$totalSaldo2, 'KAS INDUK');
			$this->M_Cash_Flow->hapusKasInduk("KAS INTERNAL", $id);
		}
		// $data= array('biaya' =>$biaya ,'totalSaldo1'=>$totalSaldo, 'totalSaldo2'=>$totalSaldo2, 'tujuan'=>$tujuan );
		echo json_encode($data);
	}
	public function hapusKasPengajuan()
	{
		$id = $this->input->post("id");
		$transaksi = $this->input->post("transaksi");
		$tujuan = $transaksi == 'Modal Awal'?'Modal Awal':$this->input->post("tujuan");
		$biaya = $this->input->post("biaya");
		$data = $this->M_Cash_Flow->hapusKas($id);
		echo json_encode($data);
	}
	public function approvePengajuanKasInternal()
	{
		$id = $this->input->post("id");
		$inputTransaksi = $this->input->post("inputTransaksi");
		$inputTujuan = $this->input->post("inputTujuan");
		$inputBiaya = $this->input->post("inputBiaya");
		$fieldTujuan = $inputTransaksi == 'Modal Awal' ? 'DARI' : 'KE';
		$fieldBiaya = $inputTransaksi == 'Modal Awal' ? 'DEBIT' : 'CREDIT';
		$inputIDPengajuan = $this->input->post("inputIDPengajuan") == '' ? 0 : $this->input->post("inputIDPengajuan");
		$saldo = $this->input->post("saldo");
		$totalSaldo = $inputTransaksi == 'Modal Awal' ? $saldo + $inputBiaya : $saldo - $inputBiaya;
		$data = $this->M_Cash_Flow->approvePengajuanKasInternal($id);
		$data = $this->M_Cash_Flow->updateSaldo('Modal Awal',$totalSaldo,'KAS INDUK');
		if ($inputTransaksi != 'Modal Awal') {
			$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($inputTujuan,'KAS INDUK')->result();
			$totalSaldo2 = 0;
			foreach ($getSaldo as $sld) {
				$totalSaldo2 = $inputBiaya + $sld->SALDO;
			}
			$data = $this->M_Cash_Flow->updateSaldo($inputTujuan,$totalSaldo2,'KAS INDUK');
			$getLastID = $this->db->query("SELECT TOP 1 ID FROM SPJ_KAS ORDER BY ID DESC");
			$lastID = 0;
			foreach ($getLastID->result() as $last) {
				$lastID = $last->ID; 
			}
			$this->M_Cash_Flow->saveKasInduk($inputTujuan, 'DEBIT',$inputBiaya,'KAS INTERNAL', $lastID);
		}
		echo json_encode($data);
	}
	public function cancelPengajuan()
	{
		$id = $this->input->post("id");
		$data=$this->M_Cash_Flow->cancelPengajuan($id);
		echo json_encode($data);
	}
	public function my_cash_flow()
	{
		$data['side'] = 'cash_flow-mcf';
		$data['page'] = 'My Cash Flow';
		$data['spj'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$this->load->view("cash_flow/my_cash_flow/index", $data);
	}
	public function getDataMyCashFlow()
	{
		$filTransaksi = $this->input->get("filTransaksi");
		$filJenisKasbon = $this->input->get("filJenisKasbon");
		$filJenisSPJ = $this->input->get("filJenisSPJ");
		$filStatus = $this->input->get("filStatus");
		$data['data'] = $this->M_Cash_Flow->getPengajuanSaldoByJenisSPJ($filJenisKasbon, $filStatus, $filJenisSPJ, '')->result();
		$this->load->view("cash_flow/my_cash_flow/data", $data);
	}
	public function getAllSaldo()
	{
		$data['induk'] = $this->M_Cash_Flow->getAllSaldo('KAS INDUK')->result();
		$data['sub'] = $this->M_Cash_Flow->getAllSaldo('SUB KAS')->result();
		$this->load->view("cash_flow/my_cash_flow/saldo", $data);
	}
	public function approvePengajuan()
	{
		$id = $this->input->post("id");
		$status = $this->input->post("status");
		$kasbon = $this->input->post("kasbon");
		$jumlah = $this->input->post("jumlah");
		$saldo = $this->input->post("saldo");
		$password = $this->input->post("password");
		$data = $this->M_Cash_Flow->approvePengajuan($id, $status, $password);
		if ($status == 'APPROVED') {
			$totalSaldo = $saldo - $jumlah;
			$data = $this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'KAS INDUK');
			$data = $this->M_Cash_Flow->saveKasInduk($kasbon, 'CREDIT',$jumlah,'PENGAJUAN SALDO', $id);
		}
		echo json_encode($data);
	}
	public function receivePengajuan()
	{
		$id = $this->input->post("id");
		$jumlah = $this->input->post("jumlah");
		$kasbon = $this->input->post("kasbon") == 'Kasbon BBM ' ? 'Kasbon Voucher BBM' : $this->input->post("kasbon");
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($kasbon, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		$totalSaldo = $saldo + $jumlah;
		$data = $this->M_Cash_Flow->receivePengajuan($id);
		$data = $this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'SUB KAS');
		$data = $this->M_Cash_Flow->saveSubKas($kasbon,'DEBIT', $jumlah, 'PENGAJUAN SALDO', $id,'-');
		echo json_encode($data);
	}
	public function rekap_saldo()
	{
		$data['side'] = 'cash_flow-rekap';
		$data['page'] = 'Rekap Saldo Per Bulan';
		$this->load->view("cash_flow/rekap_saldo/index", $data);
	}
	public function getDataRekapSaldo()
	{
		$filBulan = $this->input->get("filBulan");
		$filTahun = $this->input->get("filTahun");
		$data['data'] = $this->M_Cash_Flow->getDataMonitoringRekapSaldo($filBulan, $filTahun)->result();
		$this->load->view("cash_flow/rekap_saldo/data", $data);
	}
	public function approveGenerate()
	{
		$id = $this->input->post("id");
		$jenisKasbon = $this->input->post("jenisKasbon");
		$jenisSPJ = $this->input->post("jenisSPJ");
		$jumlah = $this->input->post("jumlah");
		if ($jenisKasbon == 'Kasbon BBM') {
			$jenis = 'Kasbon Voucher BBM';
		}elseif($jenisKasbon == 'Kasbon TOL (Biaya Admin)'){
			$jenis = 'Kasbon TOL '.$jenisSPJ;
		}else{
			$jenis = $jenisKasbon.' '.$jenisSPJ;
		}
		$data = $this->M_Cash_Flow->approveGenerate($id, $jenis, $jumlah);
		echo json_encode($data);
	}
	public function receiveGenerate()
	{
		$id = $this->input->post("id");
		$jenisKasbon = $this->input->post("jenisKasbon");
		$jenisSPJ = $this->input->post("jenisSPJ");
		$jumlah = $this->input->post("jumlah");
		if ($jenisKasbon == 'Kasbon BBM') {
			$kasbon = 'Kasbon Voucher BBM';
		}elseif ($jenisKasbon == 'Kasbon TOL (Biaya Admin)') {
			$kasbon = 'Kasbon TOL '.$jenisSPJ;
		}else{
			$jenisKasbon.' '.$jenisSPJ;
		}
		// $kasbon = $jenisKasbon == 'Kasbon BBM'?'Kasbon Voucher BBM':$jenisKasbon.' '.$jenisSPJ;

		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($kasbon, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		$totalSaldo = $saldo + $jumlah;
		$data = $this->M_Cash_Flow->receivePengajuan($id);
		$data = $this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'SUB KAS');
		$data = $this->M_Cash_Flow->saveSubKas($kasbon,'DEBIT', $jumlah, 'PENGAJUAN SALDO', $id,'GENERATE');
		echo json_encode($data);
	}
	public function cekPasswordReceive()
	{
		$id = $this->input->get("id");
		$inputPassword = $this->input->get("inputPassword");
		$data = $this->db->query("SELECT ID FROM SPJ_PENGAJUAN_SALDO WHERE ID = $id AND PASSWORD_RECEIVE = '$inputPassword'");
		$jumlah = $data->num_rows();
		echo json_encode($jumlah);
	}
	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Implementasi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Auth');
		$this->load->model('M_Data_Master');
		$this->load->model('M_Pengajuan');
		$this->load->model('M_Serlok');
		$this->load->model('M_Monitoring');
		$this->load->library('pdfgenerator');
		$this->load->model('M_Implementasi');
		$this->load->model('M_Cash_Flow');
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
	public function security()
	{
		$data['side'] = 'implementasi-security';
		$data['page'] = 'Security Chek In Out';
		$this->load->view("implementasi/security/index", $data);
	}
	public function verifikasiDataPICOutIn()
	{
		$noSPJ = $this->input->post("noSPJ");
		$status = $this->input->post("status");
		$getGroup = $this->db->query("SELECT GROUP_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'");
		foreach ($getGroup->result() as $key) {
			$group = $key->GROUP_ID;
		}
		if ($group != '4') {
			if ($status == 'OUT') {
				$data = $this->db->query("DELETE FROM SPJ_VALIDASI_PIC WHERE NO_SPJ = '$noSPJ'");
			} else {
				$data = $this->db->query("UPDATE SPJ_VALIDASI_PIC SET SET_IN = null, KETERANGAN_IN = null WHERE NO_SPJ = '$noSPJ'");
			}
		}else{
			$data = true;
		}
		echo json_encode($data);
		
	}
	public function cekSPJ()
	{
		$scan = $this->input->get("scan");
		$data = $this->db->query("SELECT ID_SPJ, STATUS_PERJALANAN, NO_SPJ, STATUS_SPJ FROM SPJ_PENGAJUAN WHERE QR_CODE = '$scan'")->row();
		date_default_timezone_set('Asia/Jakarta');
	    $jam = date('G');
	    $weekend = date("l");
	    if ($weekend =='Saturday' || $weekend == 'Sunday') {
	    	$kerja = false;
	    }elseif ($jam >= 7 && $jam <= 17) {
	    	$kerja = true;
	    } else {
	    	$kerja= false;
	    }

    $response = array('kerja' =>$kerja, 'ID_SPJ'=>$data->ID_SPJ, 'STATUS_PERJALANAN'=>$data->STATUS_PERJALANAN, 'NO_SPJ'=>$data->NO_SPJ, 'STATUS_SPJ'=>$data->STATUS_SPJ,'weekend'=>$weekend);
		echo json_encode($response);
	}
	public function getSPJ()
	{
		$scan = $this->input->get("scan");
		$getId = $this->db->query("SELECT ID_SPJ, NO_SPJ, NO_TNKB, GROUP_ID FROM SPJ_PENGAJUAN WHERE QR_CODE = '$scan'")->result();
		foreach ($getId as $key) {
			$id = $key->ID_SPJ;
			$noSPJ = $key->NO_SPJ;
			$noTNKB = $key->NO_TNKB;
			$group = $key->GROUP_ID;
		}
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, $adjustment='','')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, '')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, '')->result();
		$data['pic2'] = $this->M_Pengajuan->getPengajuanPIC($group, $noSPJ)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, '')->result();
		$data['validasiPIC'] = $this->M_Implementasi->getValidasiPIC($noSPJ, '')->result();
		$data['km'] = $this->M_Implementasi->getKM($noTNKB)->result();
		$data['validasi'] = $this->M_Implementasi->getValidasiSPJ($noSPJ)->result();
		$data['history'] = $this->M_Implementasi->getHistoryInOutLokal($noSPJ)->result();
		$this->load->view("implementasi/security/view", $data);
	}
	public function saveValidasiPIC()
	{
		$isi = $this->input->post("isi");
		$nik = $this->input->post("nik");
		$noSPJ = $this->input->post("noSPJ");
		$field = $this->input->post("field");
		$data = $this->M_Implementasi->saveValidasiPIC($isi, $nik, $noSPJ, $field);
		echo json_encode($data);
	}
	public function cekValidasiPIC()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$jenis = $this->input->get("jenis");
		$sql = $this->db->query("SELECT JENIS_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
		$data = $this->M_Implementasi->cekValidasiPICNew($inputNoSPJ, $jenis)->num_rows();
		$hasil = array('jumlah' =>$data ,'jenis_spj'=>$sql->JENIS_ID);
		echo json_encode($hasil);
	}
	public function saveValidasiOut()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputVerifikasiKendaraan = $this->input->post("inputVerifikasiKendaraan");
		$inputKeteranganKendaraan = $this->input->post("inputKeteranganKendaraan");
		$inputKMOut = $this->input->post("inputKMOut");
		$data = $this->M_Implementasi->saveDataTemp($inputNoSPJ);
		$data = $this->M_Implementasi->saveValidasiOut($inputNoSPJ, $inputVerifikasiKendaraan, $inputKeteranganKendaraan, $inputKMOut);
		echo json_encode($data);
	}
	public function saveValidasiOutLokal()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputVerifikasiKendaraan = $this->input->post("inputVerifikasiKendaraan");
		$inputKeteranganKendaraan = $this->input->post("inputKeteranganKendaraan");
		$inputKMOut = $this->input->post("inputKMOut");
		$inputKMIn = $this->input->post("inputKMIn");

		$getHistory=$this->M_Implementasi->getHistoryInOutLokal($inputNoSPJ);
		// $km = $getHistory->num_rows()==0?$inputKMOut:$inputKMIn;
		$km = $inputKMOut;
		if ($getHistory->num_rows()==0) {
			$data = $this->M_Implementasi->saveValidasiOut($inputNoSPJ, $inputVerifikasiKendaraan, $inputKeteranganKendaraan, $inputKMOut);
		}

		if ($getHistory->num_rows()>=2) {
			$data = $this->db->query("UPDATE SPJ_VALIDASI SET VERIFIKASI_BULAK_BALIK='Y' WHERE NO_SPJ = '$inputNoSPJ'");
		}

		$data = $this->M_Implementasi->saveDataTemp($inputNoSPJ);
		$data = $this->M_Implementasi->saveHistoryInOut($inputNoSPJ, 'OUT', $km);
		echo json_encode($data);

	}
	public function saveValidasiIn()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputVerifikasiKendaraan = $this->input->post("inputVerifikasiKendaraan");
		$inputKeteranganKendaraan = $this->input->post("inputKeteranganKendaraan");
		$inputKMIn = $this->input->post("inputKMIn");
		$inputNoTNKB = $this->input->post("inputNoTNKB");
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$data = $this->M_Implementasi->deleteDataTemp($inputNoSPJ);
		$data = $this->M_Implementasi->saveValidasiIn($inputNoSPJ, $inputVerifikasiKendaraan, $inputKeteranganKendaraan, $inputKMIn);
		$data = $this->M_Implementasi->saveKMKendaraan($inputNoTNKB, $inputKMIn);
		if ($inputGroupTujuan == '4' || $inputGroupTujuan == '10' || $inputGroupTujuan == '11') {
			$this->M_Implementasi->saveHistoryInOut($inputNoSPJ, 'IN',$inputKMIn);
		}
		// $data = true;
		echo json_encode($data);
	}
	public function saveUangTambahan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputJenisId = $this->input->post("inputJenisId");
		$validasi = $this->M_Implementasi->getValidasiSPJ($inputNoSPJ)->row();
		$jam_tambahan = $this->M_Data_Master->getJamTambahan()->result();
		$where = "WHERE ID_JENIS = $inputJenisId";
		$tambahan = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
		$uang_makan = $this->M_Data_Master->getUangMakan()->row();
		$difHari = $validasi->DIF_HARI;
		$difJam = $validasi->DIF_JAM;
		if ($inputGroupTujuan == 4 || $inputGroupTujuan == 10) {
				$uangSaku1 = 0;
				$uangSaku2 = 0;
				$uangMakan = 0;
		}else{
			foreach ($tambahan as $tm) {
		      $biayaUangSaku1 = $tm->QTY1;
		      $biayaUangSaku2 = $tm->QTY2;
		    }
		    if ($difHari==0) {
		    	if ($difJam >= 18 && $difJam <22) {
		    		$uangSaku1 = $biayaUangSaku1;
		    		$uangSaku2 = 0;
		    	}elseif($difJam>=22){
		    		$uangSaku1 = $biayaUangSaku1;
		    		$uangSaku2 = $biayaUangSaku2;
		    	}else{
		    		$uangSaku1 = 0;
		    		$uangSaku2 = 0;
		    	}
		    }else{
		    	if ($difJam>=14 && $difJam<18) {
		    		$uangSaku1 = $biayaUangSaku1;
		    		$uangSaku2 = 0;
		    	}elseif ($difJam>=18) {
		    		$uangSaku1 = $biayaUangSaku1;
		    		$uangSaku2 = $biayaUangSaku2;
		    	}else{
		    		$uangSaku1 = 0;
		    		$uangSaku2 = 0;
		    	}
		    }
		    $jamKeberangkatan = date("H", strtotime($validasi->KEBERANGKATAN));
	    	$jamPulang = date("H");

			if ($inputJenisId == 1) {
				
				if ($difHari ==0) {
					if ($jamKeberangkatan<=11) {
						if ($jamPulang >=19) {
							$uangMakan = $uang_makan->BIAYA2;
						}else{
							$uangMakan = 0;
						}
					}else{
						if ($difJam>=13) {
							$uangMakan = $uang_makan->BIAYA2;
						}else{
							$uangMakan = 0;
						}
					}
					// if ($jamKeberangkatan<=11 && $jamPulang >= 19) {
			    	// 	$uangMakan = $uang_makan->BIAYA2;
			    	// }elseif ($difJam >= 13) {
			    	// 	$uangMakan = $uang_makan->BIAYA2;
			    	// }else{
			    	// 	$uangMakan = 0;
			    	// }
				} else {
					$uangMakan = $uang_makan->BIAYA2;
				}
				
		    	
			    
			}elseif ($inputJenisId == 2) {
				if ($difHari == 0) {
					if ($difJam>=12 && $jamPulang>= date("H:i", strtotime("19:00")) ) {
						$uangMakan = $uang_makan->BIAYA4;
					} else {
						$uangMakan = 0;
					}
				} else {
					$uangMakan = $uang_makan->BIAYA4;
				}
				
				
				
			}else{
				$uangSaku1 = 0;
				$uangSaku2 = 0;
				$uangMakan = 0;
			}
		  		
		}

		


		$data = $this->M_Implementasi->saveUangTambahan($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan);
		
        echo json_encode($data);

	}
	public function step_1()
	{
		$notif = $this->input->get("notif");
		if ($notif == '1') {
			$this->session->set_flashdata('success', 'Data Berhasil Di Simpan'); 
		}
		$data['side'] = 'implementasi-step';
		$data['page'] = 'Implementasi Step 1';
		$data['jenis'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$data['group'] = $this->M_Data_Master->getOnlyGroup('')->result();
		$this->load->view("implementasi/step/s1/index", $data);
	}
	public function getTabelStep1()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$filGroup = $this->input->get("filGroup");
		$filPeriode = $this->input->get("filPeriode");

		$data['data'] = $this->M_Implementasi->getSPJStep1($filTahun, $filBulan, $filJenis, $filGroup, $filSearch)->result();
		// $data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		// $data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		// $data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		
		$this->load->view("implementasi/step/s1/tabel", $data);
	}
	public function step_2($id)
	{
		$data['side'] = 'implementasi-step';
		$data['page'] = 'Implementasi Step 2';
		$getData = $this->db->query("SELECT NO_SPJ, JENIS_ID FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id");
		foreach ($getData->result() as $key) {
			$no_spj = $key->NO_SPJ;
			$jenisId = $key->JENIS_ID;
		}
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id = $id, $adjustment='', '')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, '')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id, '')->result();
		$data['pic'] = $this->M_Monitoring->getPICPengajuanVersi2($no_spj)->result();
		$data['validasi'] = $this->M_Implementasi->getValidasiSPJ($no_spj)->result();
		$data['jam_tambahan'] = $this->M_Data_Master->getJamTambahan()->result();
		$where = "WHERE ID_JENIS = $jenisId";
		$data['tambahan'] = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
		$data['uang_makan'] = $this->M_Data_Master->getUangMakan()->result();
		$data['adjustment'] = $this->M_Implementasi->getDataAdjustment($no_spj)->result();
		$data['realisasi'] = $this->M_Implementasi->realisasiBiayaSPJ($no_spj)->result();
		$data['harga_bbm'] = $this->M_Data_Master->getHargaBBM()->result();
		$getStatusBBM = $this->M_Implementasi->getAksesManualBBM($no_spj);
		if ($getStatusBBM->num_rows()==0) {
			$statusBBM = '';
			$bbm_pengajuan = 0;
		} else {
			$dataStatusBBM = $getStatusBBM->row();
			$statusBBM = $dataStatusBBM->STATUS;
			$bbm_pengajuan = $dataStatusBBM->BBM;
		}
		$data['status_bbm'] = $statusBBM;
		$data['bbm_pengajuan'] = $bbm_pengajuan;
		
		$this->load->view("implementasi/step/s2/index", $data);
	}
	public function adjustment()
	{
		$data['side'] = 'implementasi-adjustment';
		$data['page'] = 'Pengajuan Adjustment';
		$data['jenis'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$data['group'] = $this->M_Data_Master->getOnlyGroup('')->result();
		$this->load->view("implementasi/adjustment/index", $data);
	}
	public function getTabelAdjustment()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$filGroup = $this->input->get("filGroup");
		$filPeriode = $this->input->get("filPeriode");

		// $data['data'] = $this->M_Implementasi->getTabelAdjustment($filTahun, $filBulan, $filJenis, $filSearch, $filGroup, $filPeriode)->result();
		$data['data'] = $this->M_Monitoring->getSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id = '', $adjustment='Y','')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$this->load->view("implementasi/adjustment/tabel", $data);
	}
	public function getBiayaNormal()
	{
		$noSPJ = $this->input->get("noSPJ");
		$getUangMakan = $this->M_Implementasi->getUangMakanNormalAdjustment($noSPJ);
		$getUangJalan = $this->M_Pengajuan->getUangJalanSPJ($noSPJ);
		$getBBM = $this->M_Implementasi->getBBMPengajuan($noSPJ);
		if ($getUangMakan->num_rows()>0) {
			foreach ($getUangMakan->result() as $key) {
				$uangMakan1 = $key->UANG_MAKAN_1;
				$uangMakan2 = $key->UANG_MAKAN_2;
				$ketUangMakan2 = $key->KETERANGAN_UANG_MAKAN_2;
				$uangSaku1 = $key->UANG_SAKU1;
				$uangSaku2 = $key->UANG_SAKU2;
			}	
		} else {
			$uangMakan1 = 0;
			$uangMakan2=0;
			$ketUangMakan2 = '';
			$uangSaku1 = 0;
			$uangSaku2=0;
		}

		if ($getUangJalan->num_rows()>0) {
			foreach ($getUangJalan->result() as $key2) {
				$uangJalan = $key2->BIAYA;
			}
		} else {
			$uangJalan = 0;
		}
		$uangBBM = 0;
		foreach ($getBBM->result() as $bbm) {
			$bbmUang = $bbm->TOTAL_UANG_BBM == null || $bbm->TOTAL_UANG_BBM == '' ? 0 : $bbm->TOTAL_UANG_BBM; 
			$uangBBM += $bbmUang;
		}
		$getManajemen = $this->db->query("SELECT ADJUSTMENT_MANAJEMEN FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'");
		$manajemen = '';
		if ($getManajemen->num_rows()>0) {
			foreach ($getManajemen->result() as $mnj) {
				$manajemen = $mnj->ADJUSTMENT_MANAJEMEN;
			}
		}

		$getAdjustment = $this->M_Implementasi->getDataAdjustment($noSPJ);
		$getAdjustment2 = $this->M_Implementasi->getDataAdjustment2($noSPJ);
		$jmlOpen = 0;
		$uangMakanDiajukan =0;
		$uangMakanAlasan = '';
		$uangMakanKeputusan='';
		$uangMakanKeterangan = '';
		$uangMakanStatus ='';
		$uangJalanDiajukan =0;
		$uangJalanAlasan = '';
		$uangJalanKeputusan='';
		$uangJalanKeterangan = '';
		$uangJalanStatus = '';
		$uangBBMDiajukan =0;
		$uangBBMAlasan = '';
		$uangBBMKeputusan='';
		$uangBBMKeterangan = '';
		$uangBBMStatus = '';

		$uangUS1Diajukan =0;
		$uangUS1Alasan = '';
		$uangUS1Keputusan='';
		$uangUS1Keterangan = '';
		$uangUS1Status = '';

		$uangUS2Diajukan =0;
		$uangUS2Alasan = '';
		$uangUS2Keputusan='';
		$uangUS2Keterangan = '';
		$uangUS2Status = '';


		$uangUMDiajukan =0;
		$uangUMAlasan = '';
		$uangUMKeputusan='';
		$uangUMKeterangan = '';
		$uangUMStatus = '';
		if ($getAdjustment->num_rows()>0) {
			foreach ($getAdjustment->result() as $ad) {
				if ($ad->OBJEK == 'UANG MAKAN') {
					$uangMakanDiajukan = $ad->DIAJUKAN;
					$uangMakanAlasan = $ad->ALASAN;
					$uangMakanKeputusan = $ad->KEPUTUSAN;
					$uangMakanKeterangan = $ad->KETERANGAN;
					$uangMakanStatus = $ad->STATUS;
					if ($ad->STATUS == 'OPEN') {
						$jmlOpen +=1;
					}
				}elseif($ad->OBJEK == 'UANG JALAN'){
					$uangJalanDiajukan = $ad->DIAJUKAN;
					$uangJalanAlasan = $ad->ALASAN;
					$uangJalanKeputusan = $ad->KEPUTUSAN;
					$uangJalanKeterangan = $ad->KETERANGAN;
					$uangJalanStatus = $ad->STATUS;
					if ($ad->STATUS == 'OPEN') {
						$jmlOpen +=1;
					}
				}elseif($ad->OBJEK == 'BBM'){
					$uangBBMDiajukan = $ad->DIAJUKAN;
					$uangBBMAlasan = $ad->ALASAN;
					$uangBBMKeputusan = $ad->KEPUTUSAN;
					$uangBBMKeterangan = $ad->KETERANGAN;
					$uangBBMStatus = $ad->STATUS;
					if ($ad->STATUS == 'OPEN') {
						$jmlOpen +=1;
					}
				}
			}
		}

		if ($getAdjustment2->num_rows()>0) {
			foreach ($getAdjustment2->result() as $ad) {
				if($ad->OBJEK == 'US1'){
					$uangUS1Diajukan = $ad->DIAJUKAN;
					$uangUS1Alasan = $ad->ALASAN;
					$uangUS1Keputusan = $ad->KEPUTUSAN;
					$uangUS1Keterangan = $ad->KETERANGAN;
					$uangUS1Status = $ad->STATUS;
					if ($ad->STATUS == 'OUTSTANDING') {
						$jmlOpen +=1;
					}
				}elseif($ad->OBJEK == 'US2'){
					$uangUS2Diajukan = $ad->DIAJUKAN;
					$uangUS2Alasan = $ad->ALASAN;
					$uangUS2Keputusan = $ad->KEPUTUSAN;
					$uangUS2Keterangan = $ad->KETERANGAN;
					$uangUS2Status = $ad->STATUS;
					if ($ad->STATUS == 'OUTSTANDING') {
						$jmlOpen +=1;
					}
				}elseif($ad->OBJEK == 'UM'){
					$uangUMDiajukan = $ad->DIAJUKAN;
					$uangUMAlasan = $ad->ALASAN;
					$uangUMKeputusan = $ad->KEPUTUSAN;
					$uangUMKeterangan = $ad->KETERANGAN;
					$uangUMStatus = $ad->STATUS;
					if ($ad->STATUS == 'OUTSTANDING') {
						$jmlOpen +=1;
					}
				}
			}
		}
					
		$hasil = array(
						'uangMakan1' =>round($uangMakan1) , 
						'uangMakan2' =>round($uangMakan2),
						'ketUangMakan2' => $ketUangMakan2,
						'uangJalan'=>round($uangJalan),
						'uangMakanDiajukan'=>round($uangMakanDiajukan),
						'uangMakanAlasan'=>$uangMakanAlasan,
						'uangMakanKeputusan'=>$uangMakanKeputusan,
						'uangMakanKeterangan'=>$uangMakanKeterangan,
						'uangMakanStatus'=>$uangMakanStatus,
						'uangJalanDiajukan'=>round($uangJalanDiajukan),
						'uangJalanAlasan'=>$uangJalanAlasan,
						'uangJalanKeputusan'=>$uangJalanKeputusan,
						'uangJalanKeterangan'=>$uangJalanKeterangan,
						'uangJalanStatus'=>$uangJalanStatus,
						'uangBBMDiajukan'=>round($uangBBMDiajukan),
						'uangBBMAlasan'=>$uangBBMAlasan,
						'uangBBMKeputusan'=>$uangBBMKeputusan,
						'uangBBMKeterangan'=>$uangBBMKeterangan,
						'uangBBMStatus'=>$uangBBMStatus,
						'uangSaku1' =>$uangSaku1,
						'uangSaku2' =>$uangSaku2,
						'jmlOpen' =>$jmlOpen,
						'uangBBM' =>$uangBBM,
						'uangUS1Diajukan'=>round($uangUS1Diajukan),
						'uangUS1Alasan'=>$uangUS1Alasan,
						'uangUS1Keputusan'=>$uangUS1Keputusan,
						'uangUS1Keterangan'=>$uangUS1Keterangan,
						'uangUS1Status'=>$uangUS1Status,
						'uangUS2Diajukan'=>round($uangUS2Diajukan),
						'uangUS2Alasan'=>$uangUS2Alasan,
						'uangUS2Keputusan'=>$uangUS2Keputusan,
						'uangUS2Keterangan'=>$uangUS2Keterangan,
						'uangUS2Status'=>$uangUS2Status,
						'uangUMDiajukan'=>round($uangUMDiajukan),
						'uangUMAlasan'=>$uangUMAlasan,
						'uangUMKeputusan'=>$uangUMKeputusan,
						'uangUMKeterangan'=>$uangUMKeterangan,
						'uangUMStatus'=>$uangUMStatus,
						'manajemen'=>$manajemen
					  );

		echo json_encode($hasil);
		
	}
	public function saveAdjustment()
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
		$inputNIKPengaju = $this->input->post("inputNIKPengaju");
		$user = $this->session->userdata("NIK");
		$level = $this->session->userdata("LEVEL");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$tambahan = "UPDATE SPJ_ADJUSTMENT SET TGL_PENGAJU = '$tanggal', PIC_PENGAJU = '$user', STATUS = 'OPEN' WHERE NO_SPJ = '$inputNoSPJ'";
		$jenis='PENGAJU';
		
		$data = $this->M_Implementasi->saveAdjustment($tambahan, $jenis);
		echo json_encode($data);
	}

	public function outstanding()
	{
		$data['side'] = 'implementasi-os';
		$data['page'] = 'Outstanding Otoritas';
		$data['jenis'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['attribut'] = $this->session->userdata("DLV") == 'Y' && $this->session->userdata("NDV") == 'Y' ? '' : 'disabled';
		$data['group'] = $this->M_Data_Master->getOnlyGroup('')->result();
		$this->load->view("implementasi/outstanding/index", $data);
	}
	public function getTabelOutstanding()
	{
		$filTahun = $this->input->get("filTahun");
		$filBulan = $this->input->get("filBulan");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$filGroup = $this->input->get("filGroup");
		$filPeriode = $this->input->get("filPeriode");

		$data['data']= $this->M_Implementasi->getListSPJForOutstanding($filBulan, $filTahun, $filJenis, $filSearch, $filGroup)->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		// $data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$this->load->view("implementasi/outstanding/tabel", $data);
	}
	public function saveKeputusanAdjustment()
	{
		$inputUangMakanDiajukan = $this->input->post("inputUangMakanDiajukan");
  	$inputUangJalanDiajukan = $this->input->post("inputUangJalanDiajukan");
  	$inputBBMDiajukan = $this->input->post("inputBBMDiajukan");
  	$inputUS1Diajukan = $this->input->post("inputUS1Diajukan");
  	$inputUS2Diajukan = $this->input->post("inputUS2Diajukan");
  	$inputUMDiajukan = $this->input->post("inputUMDiajukan");
  	$inputKeputusanBBM = $this->input->post("inputKeputusanBBM");
  	$inputKeputusanUangMakan = $this->input->post("inputKeputusanUangMakan");
  	$inputKeputusanUangJalan = $this->input->post("inputKeputusanUangJalan");
  	$inputKeputusanUS1 = $this->input->post('inputKeputusanUS1');
  	$inputKeputusanUS2 = $this->input->post('inputKeputusanUS2');
  	$inputKeputusanUM = $this->input->post('inputKeputusanUM');
  	$inputUangJalanKeterangan = $this->input->post("inputUangJalanKeterangan");
  	$inputUangMakanKeterangan = $this->input->post("inputUangMakanKeterangan");
  	$inputBBMKeterangan = $this->input->post("inputBBMKeterangan");
  	$inputUS1Keterangan = $this->input->post("inputUS1Keterangan");
  	$inputUS2Keterangan = $this->input->post("inputUS2Keterangan");
  	$inputUMKeterangan = $this->input->post("inputUMKeterangan");
  	$inputNoSPJ = $this->input->post("inputNoSPJ");
  	$inputManajemen = $this->input->post("inputManajemen");
  	$totalBiaya = $this->input->post("totalBiaya");
  	$inputJenisSPJ = $this->input->post("inputJenisSPJ");
  	$inputIdSPJ = $this->input->post("inputIdSPJ");

  	$value = [$inputUangMakanDiajukan, $inputKeputusanUangMakan, $inputUangMakanKeterangan, $inputUangJalanDiajukan, $inputKeputusanUangJalan, $inputUangJalanKeterangan, $inputBBMDiajukan, $inputKeputusanBBM, $inputBBMKeterangan];
  	$value2 = [$inputKeputusanUS1, $inputUS1Keterangan, $inputKeputusanUS2, $inputUS2Keterangan, $inputKeputusanUM, $inputUMKeterangan];
  	if ($inputManajemen == 'Y') {
  		$data = $this->M_Implementasi->saveKeputusanAdjustment($value, $inputNoSPJ);
  	}
  	
  	$data = $this->M_Implementasi->saveKeputusanAdjustment2($value2, $inputNoSPJ);
  	$kasbon = 'Kasbon SPJ '.$inputJenisSPJ;
  	if ($totalBiaya>0) {
  		$this->updateSaldo($inputIdSPJ, $kasbon, $totalBiaya,'BIAYA TAMBAHAN',0);
  	}
  	
  	// $data = $this->M_Implementasi->updateKasbonOtomatis($inputNoSPJ, $inputUangMakanDiajukan, $inputUangJalanDiajukan, $inputBBMDiajukan);
  	echo json_encode($data);
	}
	public function closeSPJ()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ"); 
		$saku = $this->input->post("inputRealisasiUangSaku"); 
		$makan = $this->input->post("inputRealisasiUangMakan"); 
		$jalan = $this->input->post("inputRealisasiUangJalan"); 
		$bbm = $this->input->post("inputRealisasiUangBBM")== '' ? 0 : $this->input->post("inputRealisasiUangBBM"); 
		$tol = $this->input->post("inputRealisasiUangTol");
		$inputId = $this->input->post("inputId");
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputMediaUangTOL = $this->input->post("inputMediaUangTOL");
		$inputMediaUangBBM = $this->input->post("inputMediaUangBBM");
		$inputJenisBBM = $this->input->post("inputJenisBBM");
		$inputHargaBBM = $this->input->post("inputHargaBBM");
		$inputBeforeBBM = $this->input->post("inputBeforeBBM") == '' ? 0 :$this->input->post("inputBeforeBBM");
		$before = $this->input->post("inputBeforeTOL") == '' ? 0 : $this->input->post("inputBeforeTOL");
		$inputGroupId = $this->input->post("inputGroupId");
		$inputBeforeJalan = $this->input->post("inputBeforeJalan") == '' ? 0 : $this->input->post("inputBeforeJalan");
		$data = $this->M_Implementasi->saveCloseSPJ($inputNoSPJ, $saku, $makan, $jalan, $bbm, $tol);
		if ($inputMediaUangTOL == 'Reimburse' && $data == true) {
			$kasbon = "Kasbon TOL ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $tol,'REIMBURSE TOL', $before);
		}

		if ($inputMediaUangBBM == 'Reimburse' && $data == true) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET JENIS_BBM = '$inputJenisBBM', HARGA_BBM='$inputHargaBBM', VOUCHER = 'Y', STATUS_SPJ = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ'");
			$kasbon= "Kasbon BBM ".$inputJenisSPJ;
			$this->updateSaldo($inputId,$kasbon,$bbm,'REIMBURSE BBM',$inputBeforeBBM);
		}
		if ($inputJenisSPJ == 'Non Delivery' && $inputGroupId =='4' || $inputGroupId == '10' && $inputJenisSPJ == 'Non Delivery') {
			$kasbon = "Kasbon SPJ ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $jalan,'REIMBURSE UANG JALAN', $inputBeforeJalan);
		}
		echo json_encode($data);
		
	}

	public function generate()
	{
		$data['side']= 'implementasi-generate_spj';
		$data['page']= 'Generate SPJ';
		$data['jenis'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$this->load->view("implementasi/generate/index", $data);
	}
	public function getInfo()
	{
		$inputJenisSPJ = $this->input->get("filJenis");
		$total = $this->M_Implementasi->getTotalSPJ($inputJenisSPJ)->result();
		$dataBA = $this->M_Implementasi->getTotalBiayaAdmin()->result();
		$noGenerate = $this->M_Implementasi->getNoGenerate($inputJenisSPJ);
		$jumlahSPJ =0;
		$totalRP = 0;
		$totalSPJ = 0;
		$totalBBM = 0;
		$totalTOL = 0;
		$totalReimburse =0;
		$totalKatulistiwa = 0;
		foreach ($total as $key) {
			$jumlahSPJ = $key->JUMLAH_SPJ;
			$totalRP = $key->TOTAL_RP;
			$totalSPJ = $key->TOTAL_SPJ;
			$totalBBM = $key->TOTAL_BBM;
			$totalTOL = $key->TOTAL_TOL;
			$totalReimburse = $key->REIMBURSE_BBM;
			$totalKatulistiwa = $key->TOTAL_BBM_KATULISTIWA;
		}
		$jumlahBA = 0;
		$totalBA = 0;
		foreach ($dataBA as $ba) {
			$jumlahBA = $ba->JML_BIAYA_ADMIN;
			$totalBA = $ba->TOTAL_BIAYA_ADMIN;
		}
		$hasil = array('noGenerate' =>$noGenerate ,'jumlahSPJ'=>round($jumlahSPJ), 'totalRP'=> round($totalRP),'jumlahBA'=>round($jumlahBA), 'totalBA'=>round($totalBA),'totalSPJ'=>round($totalSPJ), 'totalBBM'=>round($totalBBM), 'totalTOL'=>round($totalTOL),'totalBBMKatulistiwa'=>round($totalKatulistiwa),'totalReimburse'=>round($totalReimburse));
		echo json_encode($hasil);
	}
	public function getTabelGenerate()
	{
		$inputJenisSPJ = $this->input->get("filJenis");
		$data['data'] = $this->M_Implementasi->getSPJForGenerate($inputJenisSPJ)->result();
		$data['dataBA'] = $this->M_Implementasi->getDataBiayaAdmin($inputJenisSPJ)->result(); 
		$this->load->view("implementasi/generate/tabel", $data);
	}
	public function saveGenerateSPJ()
	{
		$noSPJ = $this->input->post("noSPJ");
		$inputNoGenerate = $this->input->post("inputNoGenerate");
		$inputJumlahSPJ = $this->input->post("inputJumlahSPJ");
		$inputTotalRP = $this->input->post("inputTotalRP");
		$filJenis = $this->input->post("filJenis");
		$inputJumlahBA = $this->input->post("inputJumlahBA");
		$inputTotalBA = $this->input->post("inputTotalBA");
		$noBA = $this->input->post("noBA");
		$jmlBA = count($noBA);
		$jmlNoSPJ = count($noSPJ);
		$kasbonSPJ = 0;
		$kasbonBBM = 0;
		$kasbonTOL = 0;
		$kasbonVoucherRA = 0;
		$kasbonVoucherKA = 0;
		for ($i=0; $i <$jmlNoSPJ ; $i++) { 
			$getBiaya = $this->M_Implementasi->getBiayaTotalPerNoSPJNEW($noSPJ[$i]);
			foreach ($getBiaya->result() as $key) {
				$kasbonSPJ += $key->KASBON_SPJ;
				$kasbonBBM += $key->REIMBURSE_BBM;
				$kasbonTOL += $key->KASBON_TOL;
				$kasbonVoucherRA += $key->KASBON_BBM;
				$kasbonVoucherKA += $key->KASBON_BBM_KATULISTIWA;
			}
			$this->db->query("UPDATE SPJ_PENGAJUAN SET NO_GENERATE = '$inputNoGenerate' WHERE NO_SPJ = '$noSPJ[$i]'");
		}

		for ($ba=0; $ba <$jmlBA ; $ba++) { 
			$this->db->query("UPDATE SPJ_BIAYA_ADMIN SET NO_GENERATE = '$inputNoGenerate' WHERE NO_BIAYA_ADMIN='$noBA[$ba]'");
		} 
		$totalBiayaRP = $inputTotalRP + $inputTotalBA; 
		$data = $this->M_Implementasi->saveGenerateSPJ($inputNoGenerate, $inputJumlahSPJ, $totalBiayaRP, $filJenis, $jmlBA, $inputTotalBA,0);
		

		// $data = array('KASBON SPJ' =>$kasbonSPJ ,'KASBON BBM' =>$kasbonBBM, 'KASBON TOL' =>$kasbonTOL,'total'=>$kasbonSPJ+$kasbonBBM+$kasbonTOL,'jmlBiayaAdmin'=>$jmlBA, 'totalBiayaAdmin'=>$inputTotalBA );


		$data = $this->M_Implementasi->generatePengajuanKas($inputNoGenerate, $kasbonSPJ, $kasbonBBM, $kasbonTOL, $filJenis, $jmlBA, $inputTotalBA, $kasbonVoucherRA, $kasbonVoucherKA);
		
		echo json_encode($data);
	}
	public function cekSaldo()
	{
		$kasbon = $this->input->get("kasbon");
		$data = $this->M_Cash_Flow->getSaldoPerJenis($kasbon,'SUB KAS');
		$saldoSPJ = 0;
		foreach ($data->result() as $key) {
			$saldoSPJ = $key->SALDO;
		}
		echo json_encode(round($saldoSPJ));
	}
	public function updateSaldo($inputIdSPJ, $kasbon, $totalBiaya, $keterangan, $before)
	{
		$id = $inputIdSPJ;
		$jenis = $kasbon;
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($jenis, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		if ($totalBiaya != $before) {
			$totalSaldo = ($saldo + $before)-$totalBiaya;
			

			$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
			$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalBiaya, 'KASBON', $id,$keterangan);
		}
		
	}
	public function saveHistoryNG()
	{
		$noSPJ = $this->input->post("noSPJ");
		$jenis = $this->input->post("jenis");
		$status = $this->input->post("status");
		$keteranganKendaraan = $this->input->post("keteranganKendaraan");
		$noTNKB = $this->input->post("noTNKB");
		if ($jenis == 'KENDARAAN') {
			$data = $this->M_Implementasi->saveHistoryNG($noSPJ, $jenis, $noTNKB, $keteranganKendaraan, $status);	
		}else{
			if ($status == 'OUT') {
				$fieldSet = 'SET_OUT';
				$fieldKet = 'KETERANGAN_OUT';
			}else{
				$fieldSet = 'SET_IN';
				$fieldKet = 'KETERANGAN_IN';
			}
			$where = " AND $fieldSet ='NG'";
			$getPIC = $this->M_Implementasi->getValidasiPIC($noSPJ, $where)->result();
			foreach ($getPIC as $key) {
				$subjek = $key->PIC;
				$jenisPIC = $key->JENIS_PIC;
				$keterangan = $key->$fieldKet;
				$data = $this->M_Implementasi->saveHistoryNG($noSPJ, $jenisPIC, $subjek, $keterangan, $status);
			}
		}
		
		echo json_encode($data);
	}
	public function spjLokalSelesai()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$data = $this->M_Implementasi->saveLokalSelesai($inputNoSPJ);
		echo json_encode($data);
	}
	public function getTabelAktual()
	{
		$inputScan = $this->input->get("inputScan");
		$getSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE QR_CODE = '$inputScan'")->row();
		$noSPJ = $getSPJ->NO_SPJ;
		$data= $this->M_Implementasi->getTabelAktualSecurityCheck($noSPJ)->result();
		echo json_encode($data);
	}
	public function getPICAktual()
	{
		$cari = $this->input->get("cari");
		$sql = $this->M_Implementasi->getPICAktual($cari);
		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['ID'] , 'text' =>$key['VAL']);
		}
		echo json_encode($data);
	}
	public function saveAktualPIC()
	{
		$inputScan = $this->input->post("inputScan");
		$getSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE QR_CODE = '$inputScan'")->row();
		$noSPJ = $getSPJ->NO_SPJ;
		$inputNIK = $this->input->post("inputNIK");
		$inputNama = $this->input->post("inputNama");
		$inputSebagai = $this->input->post("inputSebagai");
		$data = $this->M_Implementasi->saveAktualPIC($inputNIK, $inputNama, $inputSebagai, $noSPJ);
		echo json_encode($data);
	}
	public function hapusPICAktual()
	{
		$inputScan = $this->input->post("inputScan");
		$getSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE QR_CODE = '$inputScan'")->row();
		$noSPJ = $getSPJ->NO_SPJ;
		$nik = $this->input->post("nik");
		$nama = $this->input->post("nama");
		$sebagai = $this->input->post("sebagai");
		$data = $this->M_Implementasi->hapusPICAktual($noSPJ, $nik, $nama, $sebagai);
		echo json_encode($data);
	}
	public function getKendaraanNotSPJ()
	{
		$scan = $this->input->get("scan");
		$data = $this->M_Implementasi->getKendaraanNotSPJ($scan)->row();
		echo json_encode($data);
	}
	public function scanKendaraanNotSPJ($value='')
	{
		$noTNKB = $this->input->post("noTNKB");
		$status = $this->input->post("status");
		$keterangan = $this->input->post("keterangan");
		$inputKMNonSPJ = $this->input->post("inputKMNonSPJ");
		$cekData = $this->db->query("SELECT
																	ID
																FROM
																	SPJ_TEMP_KENDARAAN
																WHERE
																	NO_SPJ != '-' AND
																	NO_TNKB = '$noTNKB'");
		if ($cekData->num_rows()==0) {
			$data = $this->M_Implementasi->scanKendaraanNotSPJ($noTNKB, $status, $keterangan, $inputKMNonSPJ);
			$response = array('data' =>$data,'status'=>'success');
		}else{
			$response = array('data' =>true,'status'=>'warning');
		}
		echo json_encode($response);
	}
	public function cekStatusPerjalanan()
	{
		$scan = $this->input->get("scan");
		$getPIC = $this->M_Implementasi->cekPICStatusPerjalanan($scan)->result();
	}
	public function cekPICdanKendaraanOut()
	{
		$noSPJ = $this->input->get("inputNoSPJ");
		$data = $this->M_Implementasi->cekPICdanKendaraanOut($noSPJ);
		$getData = $data->row();
		if ($getData->JML_KENDARAAN == 0 && $getData->JML_PIC == 0) {
			$message="success";
			$status = 'success';
		}else{
			
			if ($getData->JML_KENDARAAN>0 && $getData->JML_PIC > 0) {
				$message = "Kendaraan & PIC Delivery Sedang Dalam Perjalanan!";
				$status = 'warning';
			}elseif ($getData->JML_KENDARAAN>0 && $getData->JML_PIC == 0) {
				$message = "Kendaraan Sedang Dalam Perjalanan!";
				$status = 'warning';
			}else{
				$message = "PIC Delivery Sedang Dalam Perjalanan!";
				$status = 'warning';
			}
		}
		$response = array('data' =>true,'message'=>$message,'status'=>$status,'jml_kendaraan'=>$getData->JML_KENDARAAN,'jml_pic'=>$getData->JML_PIC );
		echo json_encode($response);
	}
	public function pengajuanOtoritasBBM()
	{
		$idSPJ = $this->input->get("idSPJ");
		$getNoSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE ID_SPJ = $idSPJ")->row();
		$noSPJ = $getNoSPJ->NO_SPJ;
		$getData = $this->db->query("SELECT ID FROM SPJ_PENGAJUAN_BBM WHERE NO_SPJ = '$noSPJ' AND STATUS = 'OPEN'");
		if ($getData->num_rows()==0) {
			$data = $this->M_Implementasi->savePengajuanOtoritasBBM($noSPJ);
			if ($data == true) {
				$response = array('data' =>$data,'status'=>'success','message'=>'Berhasil Mengajukan Izin Pengisian Ke Otoritas', 'sub_message'=>'Hubungi Otoritas Untuk Dibuka Akses Pengisian Uang BBM Manual','status'=>'success');
			}else{
				$response = array('data' =>false);
			}
		}else{
			$response = array('data' =>true,'status'=>'info','message'=>'SPJ Ini Sudah Mengajukan Akses Pengisian BBM', 'sub_message'=>'Hubungi Otoritas Untuk Dibuka Akses Pengisian Uang BBM Manual');
		}
		
		echo json_encode($response);
	}
	public function cekPengajuanBBM()
	{
		$idSPJ = $this->input->get("idSPJ");
		$getNoSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE ID_SPJ = $idSPJ")->row();
		$noSPJ = $getNoSPJ->NO_SPJ;
		$getData = $this->db->query("SELECT ID FROM SPJ_PENGAJUAN_BBM WHERE NO_SPJ = '$noSPJ' AND STATUS = 'OPEN'");
		$jml = round($getData->num_rows());
		echo json_encode($jml);
	}
	public function pengajuanOtoritasBBM_v2()
	{
		$inputIdSPJ = $this->input->post("inputIdSPJ");
		$inputPengajuanBBM = $this->input->post("inputPengajuanBBM");
		$inputKeteranganBBM = $this->input->post("inputKeteranganBBM");
		$getNoSPJ = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE ID_SPJ = $inputIdSPJ")->row();
		$noSPJ = $getNoSPJ->NO_SPJ;
		$data = $this->M_Implementasi->savePengajuanOtoritasBBM_v2($noSPJ, $inputPengajuanBBM, $inputKeteranganBBM);
		echo json_encode($data);
	}
	public function akses_otoritas()
	{
		$data['side'] = 'akses_otoritas';
		$data['page'] = 'Akses Otoritas';
		$this->load->view("implementasi/akses_otoritas/index", $data);
	}
	public function getAksesOtoritas()
	{
		$filStatus = $this->input->get("filStatus");
		$data['harga'] = $this->M_Implementasi->getHargaBBM('Pertalite')->row();
		$data['data'] = $this->M_Implementasi->getDataAksesOtoritas($filStatus)->result();
		$this->load->view("implementasi/akses_otoritas/tabel", $data);
	}
	public function saveAksesOtoritas()
	{
		$id = $this->input->post("id");
		$status = $this->input->post("status");
		$data = $this->M_Implementasi->saveAksesOtoritas($id, $status);
		echo json_encode($data);
	}
	public function generate_kendaraan($value='')
	{
		$data['side'] = 'implementasi-generate_kendaraan';
		$data['page'] = 'Generate Kendaraan Rental';
		$data['rekanan'] = $this->M_Data_Master->getDataRekanan("")->result();
		$data['noGenerate'] = $this->M_Implementasi->getNoGenerateKendaraanRental();
		$this->load->view("implementasi/generate/kendaraan/index", $data);
	}
	public function getDataGenerateKendaraan()
	{
		$inputJenis = $this->input->get("inputJenis");
		$inputRekanan = $this->input->get("inputRekanan");
		$data['data'] = $this->M_Implementasi->getDataGenerateKendaraan($inputJenis,$inputRekanan)->result();
		$this->load->view("implementasi/generate/kendaraan/tabel", $data);
	}
	public function saveGenerateKendaraan()
	{
		$inputJenis = $this->input->post("inputJenis");
		$inputRekanan = $this->input->post("inputRekanan");
		$getNamaRekanan = $this->db->query("SELECT NAMA FROM SPJ_REKANAN WHERE ID = $inputRekanan")->row();
		$namaRekanan = $getNamaRekanan->NAMA;
		$inputNoGenerate = $this->M_Implementasi->getNoGenerateKendaraanRental();
		$inputSPJ = $this->input->post("inputSPJ");
		$jmlNoSPJ = count($inputSPJ);
		$jmlSPJ =0;
		$sewaKendaraan = 0;
		$potonganPPh = 0;
		$total = 0;
		$pphPercent = $inputRekanan == 1 ? 0.02 : 0.025;
		for ($i=0; $i <$jmlNoSPJ ; $i++) { 
			$jmlSPJ +=1;
			$this->db->query("UPDATE SPJ_PENGAJUAN SET NO_GENERATE_KENDARAAN = '$inputNoGenerate' WHERE NO_SPJ = '$inputSPJ[$i]'");
		}

		$sewaKendaraan = $jmlSPJ*250000;
		$potonganPPh = $sewaKendaraan*$pphPercent;
		$totalBiayaRP = $sewaKendaraan - $potonganPPh;
		$data = $this->M_Implementasi->saveGenerateSPJ($inputNoGenerate, $jmlSPJ, $totalBiayaRP, $inputJenis, 0, 0,$inputRekanan);
		if ($data == true) {
			$data = $this->M_Implementasi->generateKendaraanRental($inputNoGenerate, $sewaKendaraan, $potonganPPh, $inputJenis, $namaRekanan);
		}
		echo json_encode($data);
	}
	public function revisiTotalUangPerPIC()
	{
		$inputNoSPJ= $this->input->post("inputNoSPJ"); 
		$inputNIK= $this->input->post("inputNIK"); 
		$inputUang= $this->input->post("inputUang"); 
		$inputJenis= $this->input->post("inputJenis"); 
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputBeforeUang = $this->input->post("inputBeforeUang");
		$save = $this->M_Implementasi->updateUangPIC($inputNoSPJ, $inputNIK, $inputUang, $inputJenis, $inputJenisSPJ);
		if ($save == true) {
			$kasbon = 'Kasbon SPJ '.$inputJenisSPJ;
			$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($kasbon, 'SUB KAS');
			$saldo = 0;
			foreach ($getSaldo->result() as $key) {
				$saldo  = $key->SALDO;
			}
			if ($inputUang==$inputBeforeUang) {
				$totalSaldo = $saldo;
			}else{
				$totalSaldo = ($saldo + $inputBeforeUang)-$inputUang;
			}
			
			$this->M_Cash_Flow->updateSaldo($kasbon, $totalSaldo, 'SUB KAS');
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Update Uang Makan',$inputUang);
		}
		echo json_encode($save);

	}
	public function revisiKeberangkatan()
	{
		$inputNoSPJ= $this->input->post("inputNoSPJ"); 
		$inputTglKeberangkatan= $this->input->post("inputTglKeberangkatan"); 
		$inputJamKeberangkatan= $this->input->post("inputJamKeberangkatan"); 
		$inputTglKepulangan= $this->input->post("inputTglKepulangan"); 
		$inputJamKepulangan= $this->input->post("inputJamKepulangan"); 
		$inputKmOut= $this->input->post("inputKmOut"); 
		$inputKmIn= $this->input->post("inputKmIn"); 
		$keberangkatan = date("Y-m-d", strtotime($inputTglKeberangkatan)).' '.date("H:i:s", strtotime($inputJamKeberangkatan));
		$kepulangan = date("Y-m-d", strtotime($inputTglKepulangan)).' '.date("H:i:s", strtotime($inputJamKepulangan));
		$data = $this->M_Implementasi->revisiKeberangkatan($inputNoSPJ, $keberangkatan, $kepulangan, $inputKmOut, $inputKmIn);
		// $data = true;
		if ($data == true) {
			$this->M_Implementasi->saveLogImplementasiKeberangkatan($inputNoSPJ, $keberangkatan, $kepulangan, $inputKmOut, $inputKmIn);
			date_default_timezone_set('Asia/Jakarta');
			$getData = $this->db->query("SELECT JENIS_ID, GROUP_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
			$inputGroupTujuan = $getData->GROUP_ID;
			$inputJenisId = $getData->JENIS_ID;
			$validasi = $this->M_Implementasi->getValidasiSPJ($inputNoSPJ)->row();
			$jam_tambahan = $this->M_Data_Master->getJamTambahan()->result();
			$where = "WHERE ID_JENIS = $inputJenisId";
			$tambahan = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
			$uang_makan = $this->M_Data_Master->getUangMakan()->row();
			$difHari = $validasi->DIF_HARI;
			$difJam = $validasi->DIF_JAM;
			$jamKeberangkatan = date("H", strtotime($validasi->KEBERANGKATAN));
	    	$jamPulang = date("H:i", strtotime($validasi->WAKTU_PULANG));
			if ($inputGroupTujuan == 4 || $inputGroupTujuan == 10) {
					$uangSaku1 = 0;
					$uangSaku2 = 0;
					$uangMakan = 0;
			}else{
				foreach ($tambahan as $tm) {
			      $biayaUangSaku1 = $tm->QTY1;
			      $biayaUangSaku2 = $tm->QTY2;
			    }
			    if ($difHari==0) {
			    	if ($difJam >= 18 && $difJam <22) {
			    		$uangSaku1 = $biayaUangSaku1;
			    		$uangSaku2 = 0;
			    	}elseif($difJam>=22){
			    		$uangSaku1 = $biayaUangSaku1;
			    		$uangSaku2 = $biayaUangSaku2;
			    	}else{
			    		$uangSaku1 = 0;
			    		$uangSaku2 = 0;
			    	}
			    }else{
			    	if ($difJam>=14 && $difJam<18) {
			    		$uangSaku1 = $biayaUangSaku1;
			    		$uangSaku2 = 0;
			    	}elseif ($difJam>=18) {
			    		$uangSaku1 = $biayaUangSaku1;
			    		$uangSaku2 = $biayaUangSaku2;
			    	}else{
			    		$uangSaku1 = 0;
			    		$uangSaku2 = 0;
			    	}
			    }
			    

				if ($inputJenisId == 1) {
					
					if ($jamKeberangkatan<=11) {
						if ($jamPulang >=19) {
							$uangMakan = $uang_makan->BIAYA2;
						}else{
							$uangMakan = 0;
						}
					}else{
						if ($difJam>=13) {
							$uangMakan = $uang_makan->BIAYA2;
						}else{
							$uangMakan = 0;
						}
					}
			    	// if ($jamKeberangkatan<=11 && $jamPulang >= date("H:i",strtotime("19:00"))) {
			    	// 	$uangMakan = $uang_makan->BIAYA2;
			    	// }elseif ($difJam >= 13) {
			    	// 	$uangMakan = $uang_makan->BIAYA2;
			    	// }else{
			    	// 	$uangMakan = 0;
			    	// }
				    
				}elseif ($inputJenisId == 2) {
					if ($difJam>=12 && $jamPulang>= date("H:i", strtotime("19:00")) ) {
						$uangMakan = $uang_makan->BIAYA4;
					}elseif ($difHari>0) {
						$uangMakan = $uang_makan->BIAYA4;
					} 
					else {
						$uangMakan = 0;
					}
					
				}else{
					$uangSaku1 = 0;
					$uangSaku2 = 0;
					$uangMakan = 0;
				}
			  		
			}
			$this->M_Implementasi->saveUangTambahan($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan);
		}
		$response = array('data' =>$data ,'uangSaku1'=>$uangSaku1,'uangSaku2'=>$uangSaku2,'uangMakan'=>$uangMakan, 'jampulang'=>$jamPulang, 'difjam'=>$difJam, 'difhari'=>$difHari);
		// $response = array('uangSaku1' =>$uangSaku1 ,'uangSaku2'=>$uangSaku2,'uangMakan'=>$uangMakan);
		echo json_encode($response);
	}
	public function saveBiaya()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ"); 
		$saku = $this->input->post("inputRealisasiUangSaku"); 
		$makan = $this->input->post("inputRealisasiUangMakan"); 
		$jalan = $this->input->post("inputRealisasiUangJalan"); 
		$bbm = $this->input->post("inputRealisasiUangBBM")== '' ? 0 : $this->input->post("inputRealisasiUangBBM"); 
		$tol = $this->input->post("inputRealisasiUangTol");
		$inputId = $this->input->post("inputId");
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputMediaUangTOL = $this->input->post("inputMediaUangTOL");
		$inputMediaUangBBM = $this->input->post("inputMediaUangBBM");
		$inputJenisBBM = $this->input->post("inputJenisBBM");
		$inputHargaBBM = $this->input->post("inputHargaBBM");
		$inputRealisasiBiayaLainnya = $this->input->post("inputRealisasiBiayaLainnya") == '' ? 0 : $this->input->post("inputRealisasiBiayaLainnya");
		$inputKeteranganLainnya = $this->input->post("inputKeteranganLainnya");
		$inputBeforeBBM = $this->input->post("inputBeforeBBM") == '' ? 0 :$this->input->post("inputBeforeBBM");
		$before = $this->input->post("inputBeforeTOL") == '' ? 0 : $this->input->post("inputBeforeTOL");
		$inputGroupId = $this->input->post("inputGroupId");
		$inputBeforeJalan = $this->input->post("inputBeforeJalan") == '' ? 0 : $this->input->post("inputBeforeJalan");
		$inputRealisasiUangKendaraan = $this->input->post("inputRealisasiUangKendaraan") == '' ? 0 : $this->input->post("inputRealisasiUangKendaraan");
		$inputKendaraan = $this->input->post("inputKendaraan");
		$inputbeforeLainnya = $this->input->post("inputbeforeLainnya") == '' ? 0 : $this->input->post("inputbeforeLainnya");
		$data = $this->M_Implementasi->saveSPJ($inputNoSPJ, $saku, $makan, $jalan, $bbm, $tol);
		if ($inputMediaUangTOL == 'Reimburse' && $data == true) {
			$kasbon = "Kasbon TOL ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $tol,'REIMBURSE TOL', $before);
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Reimburse Uang TOL',$tol);
		}

		if ($inputMediaUangBBM == 'Reimburse' && $data == true) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET JENIS_BBM = '$inputJenisBBM', HARGA_BBM='$inputHargaBBM', VOUCHER = 'Y' WHERE NO_SPJ = '$inputNoSPJ'");
			$kasbon= "Kasbon BBM ".$inputJenisSPJ;
			$this->updateSaldo($inputId,$kasbon,$bbm,'REIMBURSE BBM',$inputBeforeBBM);
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Reimburse Uang BBM',$bbm);
		}
		if ($inputJenisSPJ == 'Non Delivery' && $inputGroupId =='4' || $inputGroupId == '10' && $inputJenisSPJ == 'Non Delivery') {
			$kasbon = "Kasbon SPJ ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $jalan,'REIMBURSE UANG JALAN', $inputBeforeJalan);
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Reimburse Uang Jalan',$jalan);
		}

		if ($inputJenisSPJ == 'Non Delivery' && $inputRealisasiBiayaLainnya != $inputbeforeLainnya) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_LAINNYA = '$inputRealisasiBiayaLainnya', KETERANGAN_LAINNYA='$inputKeteranganLainnya' WHERE NO_SPJ = '$inputNoSPJ'");
			$kasbon= "Kasbon SPJ ".$inputJenisSPJ;
			$this->updateSaldo($inputId,$kasbon,$inputRealisasiBiayaLainnya,'BIAYA LAINNYA',$inputbeforeLainnya);
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Reimburser Biaya Lainnya',$bbm);
		}

		if ($inputKendaraan == 'Gojek/Grab') {
			$kasbon = "Kasbon SPJ ".$inputJenisSPJ;
			$save = $this->M_Implementasi->saveBiayaKendaraan($inputNoSPJ, $inputRealisasiUangKendaraan);
			if ($save == true) {
				$dataKasbon = $this->M_Implementasi->getTotalKasbon($inputNoSPJ)->row();
				$totalKasbon = $dataKasbon->KASBON;
				$totalCredit = $dataKasbon->CREDIT;
				$kasbon = 'Kasbon SPJ '.$inputJenisSPJ;
				$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($kasbon, 'SUB KAS');
				$saldo = 0;
				foreach ($getSaldo->result() as $key) {
					$saldo  = $key->SALDO;
				}
				if ($totalKasbon==$totalCredit) {
					$totalSaldo = $saldo;
				}else{
					$totalSaldo = ($saldo + $totalCredit)-$totalKasbon;
				}
				
				$this->updateSaldo($inputId,$kasbon,$totalKasbon,'TRANSAKSI AWAL',$totalCredit);
				$this->M_Implementasi->saveLogImplementasi($inputNoSPJ, 'Update Biaya Kendaraan Gojek/Grab',$totalKasbon);
			}
		}
		
		echo json_encode($data);
	}
	public function closeImplementasi()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$data = $this->M_Implementasi->closeImplementasi($inputNoSPJ);
		if ($data == true) {
			$this->M_Implementasi->saveLogImplementasi($inputNoSPJ,'CLOSE IMPLEMENTASI',0);
		}
		echo json_encode($data);
	}
	public function saveGantiMediaBBM()
	{
		$inputMediaBBM = $this->input->post("inputMediaBBM");
		$id = $this->input->post("id");
		$data = $this->db->query("SELECT MEDIA_UANG_BBM, TOTAL_UANG_BBM FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id")->row();
		$mediaBefore = $data->MEDIA_UANG_BBM;
		$totalBefore = $data->TOTAL_UANG_BBM;
		if ($inputMediaBBM == $mediaBefore) {
			$data = true;
			$message = 'Media Tidak Berubah';
			$sub_message = 'Pilih Media Lain';
			$status = 'warning';
		}else{
			if ($mediaBefore == 'Kasbon' && $totalBefore >0 && $inputMediaBBM != 'Kasbon') {
				$getSaldoKasbon = $this->db->query("SELECT CREDIT FROM SPJ_KAS_SUB WHERE FK_ID = $id AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND JENIS_FK = 'KASBON'");
				if ($getSaldoKasbon->num_rows()>0) {
					$dataSaldoKasbon = $getSaldoKasbon->row();
					$credit = $dataSaldoKasbon->CREDIT;
					$totalKasbon = $credit-$totalBefore;
					$this->db->query("UPDATE SPJ_KAS_SUB SET CREDIT = $totalKasbon WHERE FK_ID = $id AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND JENIS_FK = 'KASBON'");
				}
			}

			if ($mediaBefore == 'Implementasi' && $totalBefore>0) {
				$data = true;
				$message = 'Media BBM Saat ini adalah implementasi dan sudah diisi bbmnya';
				$sub_message = 'Media BBM Tidak Bisa Diubah!';
				$status = 'warning';
			}else{
				$data = $this->db->query("UPDATE SPJ_PENGAJUAN SET MEDIA_UANG_BBM = '$inputMediaBBM', TOTAL_UANG_BBM = 0, VOUCHER = 'Y' WHERE ID_SPJ = $id");
				if ($data == true) {
					$message = 'Berhasil Menyimpan Media BBM';
					$sub_message = '';
					$status = 'success';
				}	
			}	
		}
		

		$response = array('data' =>$data ,'message'=>$message, 'sub_message'=>$sub_message,'status'=>$status);
		
		echo json_encode($response);
	}
}
?>
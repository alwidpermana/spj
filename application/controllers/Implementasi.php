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
		
		echo json_encode($data);
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
		$km = $getHistory->num_rows()==0?$inputKMOut:$inputKMIn;
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
		if ($inputGroupTujuan == '4') {
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
		$validasi = $this->M_Implementasi->getValidasiSPJ($inputNoSPJ)->result();
		$jam_tambahan = $this->M_Data_Master->getJamTambahan()->result();
		$where = "WHERE ID_JENIS = $inputJenisId";
		$tambahan = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
		$uang_makan = $this->M_Data_Master->getUangMakan()->result();
		foreach ($uang_makan as $um) {
			$uangMakan1 = $um->BIAYA2;
			$uangMakan2 = $um->BIAYA4;
		}
		
		if ($inputGroupTujuan == 4 || $inputGroupTujuan == 10) {
			$uangSaku1 = 0;
			$uangSaku2 = 0;
			$uangMakan = 0;
		} else {
			$keberangkatanJ = '';
      $kepulanganJ = '';
      $keberangkatanH = '';
      $kepulanganH = '';
      $jam1 = 0;
      $jam2 = 0;
      $tambahanUangSaku1=0;
      $tambahanUangSaku2 = 0;
      $jamKeberangkatan=0;
      $menitKeberangkatan = 0;
      foreach ($validasi as $vld) {
        $jamPulang = date("H:i");
        $jamKeberangkatan = date("H", strtotime($vld->KEBERANGKATAN));
        $menitKeberangkatan = date("i", strtotime($vld->KEBERANGKATAN));
        $keberangkatanJ = date("Y-m-d H:i", strtotime($vld->KEBERANGKATAN));
        $kepulanganJ = date("Y-m-d H:i");
        $keberangkatanH = date("Y-m-d", strtotime($vld->KEBERANGKATAN));
        $kepulanganH = date("Y-m-d");
        $tengahBerangkat = date("Y-m-d", strtotime($vld->KEBERANGKATAN)). ' 24:00';
        $tengahPulang = date("Y-m-d"). ' 00:00';
      }

      foreach ($jam_tambahan as $jt) {
        $jam1 = $jt->JAM1;
        $jam2 = $jt->JAM2;
      }
      foreach ($tambahan as $tm) {
        $tambahanUangSaku1 = $tm->QTY1;
        $tambahanUangSaku2 = $tm->QTY2;
      }
      $berangkatJ = date_create($keberangkatanJ);
      $pulangJ = date_create($kepulanganJ);
      $selisihJ = date_diff($berangkatJ, $pulangJ);
      $selisihJam = $selisihJ->h;

      $berangkatH = date_create($keberangkatanH);
      $pulangH = date_create($kepulanganH);
      $selisihH = date_diff($berangkatH, $pulangH);
      $selisihHari = $selisihH->d;

      if ($selisihJam >= $jam1 && $selisihHari==0) {
        $jm = $selisihJam - $jam1;
        
        // $uangSaku1 = $tambahanUangSaku1;
        // $uangSaku2 = $tambahanUangSaku2; 
        if ($jm>=0) {
        	// && $jm<=3
          $uangSaku1 = $tambahanUangSaku1;
          // $uangMakan += $uangMakan1;
        }else{
          $uangSaku1 = 0;
          // $uangMakan += 0;
        }

        if ($jm>=4) {
          $uangSaku2 = $tambahanUangSaku2;
        	// $uangMakan += $uangMakan2;
        } else {
          $uangSaku2 = 0;
          // $uangMakan +=0;
        }
        

      }elseif($selisihHari>0){
      	$tengah1 = date_create($tengahBerangkat);
      	$tengah2 = date_create($tengahPulang);
      	$selisih1 = date_diff($berangkatJ, $tengah1);
      	$selisihJamTengah1 = $selisih1->h;

      	$selisih2 = date_diff($pulangJ, $tengah2);
      	$selisihJamTengah2 = $selisih2->h;
      	$selisihTengahFinal = $selisihJamTengah1 + $selisihJamTengah2;
      	$jm = $selisihHari>1?($selisihJam+($selisihHari*24)) - $jam2: ($selisihTengahFinal - $jam2);
        if ($jm>=0) {
          $uangSaku1 = $tambahanUangSaku1;
          // $uangMakan += $uangMakan1;
        }else{
          $uangSaku1 = 0;
          // $uangMakan+=0;
        }

        if ($jm>=4) {
          $uangSaku2 = $tambahanUangSaku2;
          // $uangMakan += $uangMakan2;
        } else {
          $uangSaku2 = 0;
          // $uangMakan +=0;
        }
      }else{
        $uangSaku1 = 0;
        $uangSaku2 = 0;
        // $uangMakan = 0;
      }
      // if ($inputJenisId == 1) {
      // 	$uangMakan = $selisihJam>=13?20000:0;
      // }elseif ($inputJenisId == 2) {
      // 	$uangMakan = $selisihJam>=12?20000:0;
      // }else{
      // 	$uangMakan = 0;
      // }
      

      $jenisId = $inputJenisId ;
      $uangMakan = 0;
      if ($keberangkatanH == $kepulanganH) {
      	if ($jamKeberangkatan<11 && $jamPulang >= date("H:i",strtotime("19:00"))) {
        	$uangMakan = $um->BIAYA2;
	      }elseif($jamKeberangkatan == 11 && $menitKeberangkatan<=15 && $jamPulang >= date("H:i",strtotime("19:00"))){
	        $uangMakan = $um->BIAYA2;
	      }elseif($jamKeberangkatan >=11 && $selisihJam>=13){
	        $uangMakan = $um->BIAYA2;
	      }else{
	        $uangMakan = 0;
	      }
      }else{
      	if ($selisihJam >= 13) {
      		$uangMakan = 20000;
      	}else{
      		$uangMakan = 0;
      	}
      }
      

      // if ($jamPulang >= date("H:i",strtotime("19:00")) && $selisihHari == 0 || $selisihHari>0) {
      //   foreach ($uang_makan as $um) {
      //   	if ($inputGroupTujuan == '4') {
      //   		if ($um->JENIS_GROUP == 'Lokal') {
      //   			if ($jenisId == 1) {
	    //           $uangMakan = $um->BIAYA2;
	    //         }elseif ($jenisId == 2) {
	    //           $uangMakan = $um->BIAYA4;
	    //         }else{
	    //           $uangMakan = 0;
	    //         }
      //   		}
      //   	}else{
      //   		if ($um->JENIS_GROUP == 'Luar Kota') {
      // 				if ($jenisId == 1) {
	    //           $uangMakan = $um->BIAYA2;
	    //         }elseif ($jenisId == 2) {
	    //           $uangMakan = $um->BIAYA4;
	    //         }else{
	    //           $uangMakan = 0;
	    //         }
      //   		}	
      //   	}
      //   }
      // }else{
      //   $uangMakan = 0;
      // }
		}
		
				

        // $getSPJ = $this->db->query("SELECT NO_TNKB FROM SPJ_PENGAJUAN WHERE NO_SPJ='$inputNoSPJ'")->row();
        // $cekKendaraanRental = $this->M_Implementasi->cekKendaraanRental($getSPJ->NO_TNKB)->num_rows();

        // if ($cekKendaraanRental>0) {
        // 	$uangSaku1 = 0;
        // 	$uangSaku2 = 0;
        // }

        $data = $this->M_Implementasi->saveUangTambahan($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan);
        // $test = array('uang saku1' =>$uangSaku1 ,'uang saku 2'=> $uangSaku2, 'uangMakan'=>$uangMakan, 'selisih jam'=>$selisihJam, 'selisih Hari'=>$selisihHari, 'jam 2'=>$jam2, 'jm'=>$jm,'selisih jam tengah 1 '=>$selisihJamTengah1, 'selsiih jam tengah 2'=>$selisihJamTengah2);
        // $this->M_Implementasi->saveAdjustmentUangTambah($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan);
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

		$data['data'] = $this->M_Monitoring->getSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id = '', $adjustment='','Y')->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='', '')->result();
		
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
		$before = $this->input->post("inputBeforeTOL") == '' ? 0 : $this->input->post("inputBeforeTOL");
		$data = $this->M_Implementasi->saveCloseSPJ($inputNoSPJ, $saku, $makan, $jalan, $bbm, $tol);
		if ($inputMediaUangTOL == 'Reimburse') {
			$kasbon = "Kasbon TOL ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $tol,'REIMBURSE TOL', $before);
		}
		echo json_encode($data);
		
	}
	public function generate()
	{
		$data['side']= 'implementasi-generate';
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
		foreach ($total as $key) {
			$jumlahSPJ = $key->JUMLAH_SPJ;
			$totalRP = $key->TOTAL_RP;
			$totalSPJ = $key->TOTAL_SPJ;
			$totalBBM = $key->TOTAL_BBM;
			$totalTOL = $key->TOTAL_TOL;
		}
		$jumlahBA = 0;
		$totalBA = 0;
		foreach ($dataBA as $ba) {
			$jumlahBA = $ba->JML_BIAYA_ADMIN;
			$totalBA = $ba->TOTAL_BIAYA_ADMIN;
		}
		$hasil = array('noGenerate' =>$noGenerate ,'jumlahSPJ'=>round($jumlahSPJ), 'totalRP'=> round($totalRP),'jumlahBA'=>round($jumlahBA), 'totalBA'=>round($totalBA),'totalSPJ'=>round($totalSPJ), 'totalBBM'=>round($totalBBM), 'totalTOL'=>round($totalTOL));
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
		for ($i=0; $i <$jmlNoSPJ ; $i++) { 
			$getBiaya = $this->M_Implementasi->getBiayaTotalPerNoSPJNEW($noSPJ[$i]);
			foreach ($getBiaya->result() as $key) {
				$kasbonSPJ += $key->KASBON_SPJ;
				$kasbonBBM += $key->KASBON_BBM;
				$kasbonTOL += $key->KASBON_TOL;
			}
			$this->db->query("UPDATE SPJ_PENGAJUAN SET NO_GENERATE = '$inputNoGenerate' WHERE NO_SPJ = '$noSPJ[$i]'");
		}

		for ($ba=0; $ba <$jmlBA ; $ba++) { 
			$this->db->query("UPDATE SPJ_BIAYA_ADMIN SET NO_GENERATE = '$inputNoGenerate' WHERE NO_BIAYA_ADMIN='$noBA[$ba]'");
		}
		$totalBiayaRP = $inputTotalRP + $inputTotalBA; 
		$data = $this->M_Implementasi->saveGenerateSPJ($inputNoGenerate, $inputJumlahSPJ, $totalBiayaRP, $filJenis, $jmlBA, $inputTotalBA);
		

		// $data = array('KASBON SPJ' =>$kasbonSPJ ,'KASBON BBM' =>$kasbonBBM, 'KASBON TOL' =>$kasbonTOL,'total'=>$kasbonSPJ+$kasbonBBM+$kasbonTOL,'jmlBiayaAdmin'=>$jmlBA, 'totalBiayaAdmin'=>$inputTotalBA );


		$data = $this->M_Implementasi->generatePengajuanKas($inputNoGenerate, $kasbonSPJ, $kasbonBBM, $kasbonTOL, $filJenis, $jmlBA, $inputTotalBA);
		
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
		$totalSaldo = ($saldo+$before) - $totalBiaya;

		$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
		$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalBiaya, 'KASBON', $id,$keterangan);
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
}
?>
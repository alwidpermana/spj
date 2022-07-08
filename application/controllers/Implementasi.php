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
		if ($status == 'OUT') {
			$data = $this->db->query("DELETE FROM SPJ_VALIDASI_PIC WHERE NO_SPJ = '$noSPJ'");
		} else {
			$data = $this->db->query("UPDATE SPJ_VALIDASI_PIC SET SET_IN = null, KETERANGAN_IN = null WHERE NO_SPJ = '$noSPJ'");
		}
		echo json_encode($data);
		
	}
	public function cekSPJ()
	{
		$scan = $this->input->get("scan");
		$data = $this->db->query("SELECT ID_SPJ, STATUS_PERJALANAN, NO_SPJ FROM SPJ_PENGAJUAN WHERE QR_CODE = '$scan'")->row();
		
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
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['pic2'] = $this->M_Pengajuan->getPengajuanPIC($group, $noSPJ)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['validasiPIC'] = $this->M_Implementasi->getValidasiPIC($noSPJ)->result();
		$data['km'] = $this->M_Implementasi->getKM($noTNKB)->result();
		$data['validasi'] = $this->M_Implementasi->getValidasiSPJ($noSPJ)->result();
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
		$data = $this->M_Implementasi->cekValidasiPICNew($inputNoSPJ, $jenis)->num_rows();
		echo json_encode($data);
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
	public function saveValidasiIn()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputVerifikasiKendaraan = $this->input->post("inputVerifikasiKendaraan");
		$inputKeteranganKendaraan = $this->input->post("inputKeteranganKendaraan");
		$inputKMIn = $this->input->post("inputKMIn");
		$inputNoTNKB = $this->input->post("inputNoTNKB");
		$data = $this->M_Implementasi->deleteDataTemp($inputNoSPJ);
		$data = $this->M_Implementasi->saveValidasiIn($inputNoSPJ, $inputVerifikasiKendaraan, $inputKeteranganKendaraan, $inputKMIn);
		$data = $this->M_Implementasi->saveKMKendaraan($inputNoTNKB, $inputKMIn);
		echo json_encode($data);
	}
	public function saveUangTambahan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputJenisId = $this->input->post("inputJenisId");
		$validasi = $this->M_Implementasi->getValidasiSPJ($inputNoSPJ)->result();
		$jam_tambahan = $this->M_Data_Master->getJamTambahan()->result();
		$where = "WHERE ID_JENIS = $inputJenisId";
		$tambahan = $this->M_Data_Master->viewTambahanUangSaku($where)->result();
		$uang_makan = $this->M_Data_Master->getUangMakan()->result();
		$keberangkatanJ = '';
        $kepulanganJ = '';
        $keberangkatanH = '';
        $kepulanganH = '';
        $jam1 = 0;
        $jam2 = 0;
        $tambahanUangSaku1=0;
        $tambahanUangSaku2 = 0;
        foreach ($validasi as $vld) {
          $jamPulang = date("H:i");
          $keberangkatanJ = date("Y-m-d H:i", strtotime($vld->KEBERANGKATAN));
          $kepulanganJ = date("Y-m-d H:i");
          $keberangkatanH = date("Y-m-d", strtotime($vld->KEBERANGKATAN));
          $kepulanganH = date("Y-m-d");
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
           
          if ($jm>0) {
          	// && $jm<=3
            $uangSaku1 = $tambahanUangSaku1;
          }else{
            $uangSaku1 = 0;
          }

          if ($jm>3) {
            $uangSaku2 = $tambahanUangSaku2;
          } else {
            $uangSaku2 = 0;
          }
          

        }elseif($selisihHari>0){
        	$jm = $selisihHari>1?($selisihJam+($selisihHari*24)) - $jam2: $selisihJam - $jam2;
          if ($jm>0) {
            $uangSaku1 = $tambahanUangSaku1;
          }else{
            $uangSaku1 = 0;
          }

          if ($jm>3) {
            $uangSaku2 = $tambahanUangSaku2;
          } else {
            $uangSaku2 = 0;
          }
        }else{
          $uangSaku1 = 0;
          $uangSaku2 = 0;

        }

        $jenisId = $inputJenisId ;
        $uangMakan = 0;
        
        if ($jamPulang >= date("H:i",strtotime("19:00")) && $selisihHari == 0 || $selisihHari>0) {
          foreach ($uang_makan as $um) {
            if ($jenisId == 1) {
              $uangMakan = $um->BIAYA2;
            }elseif ($jenisId == 2) {
              $uangMakan = $um->BIAYA4;
            }else{
              $uangMakan = 0;
            }
          }
        }else{
          $uangMakan = 0;
        }

        $data = $this->M_Implementasi->saveUangTambahan($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan);
        // $test = array('uang saku1' =>$uangSaku1 ,'uang saku 2'=> $uangSaku2, 'uangMakan'=>$uangMakan, 'selisih jam'=>$selisihJam, 'selisih Hari'=>$selisihHari, 'jam 2'=>$jam2, 'jm'=>$jm);
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
		$data['jenis'] = $this->M_Data_Master->getJenisSPJ()->result();
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
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		
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
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
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
		$data['jenis'] = $this->M_Data_Master->getJenisSPJ()->result();
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
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
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
		$data['jenis'] = $this->M_Data_Master->getJenisSPJ()->result();
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

		$data['data']= $this->M_Monitoring->getSPJ2($filBulan, $filTahun, $filJenis, $filSearch, $filGroup)->result();
		$data['lokasi'] = $this->M_Monitoring->getLokasiByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['pic'] = $this->M_Monitoring->getPICPendampingByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan, $filTahun, $filJenis, $filSearch, $id='')->result();
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
  	$this->updateSaldo($inputIdSPJ, $kasbon, $totalBiaya,'BIAYA TAMBAHAN');
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
		$data = $this->M_Implementasi->saveCloseSPJ($inputNoSPJ, $saku, $makan, $jalan, $bbm, $tol);
		if ($inputMediaUangTOL == 'Reimburse') {
			$kasbon = "Kasbon TOL ".$inputJenisSPJ;
			$this->updateSaldo($inputId, $kasbon, $tol,'REIMBURSE TOL');
		}
		echo json_encode($data);
		
	}
	public function generate()
	{
		$data['side']= 'implementasi-generate';
		$data['page']= 'Generate SPJ';
		$data['jenis'] = $this->M_Data_Master->getJenisSPJ()->result();
		$this->load->view("implementasi/generate/index", $data);
	}
	public function getInfo()
	{
		$inputJenisSPJ = $this->input->get("filJenis");
		$total = $this->M_Implementasi->getTotalSPJ()->result();
		$noGenerate = $this->M_Implementasi->getNoGenerate($inputJenisSPJ);
		$jumlahSPJ =0;
		$totalRP = 0;
		foreach ($total as $key) {
			$jumlahSPJ = $key->JUMLAH_SPJ;
			$totalRP = $key->TOTAL_RP;
		}
		$hasil = array('noGenerate' =>$noGenerate ,'jumlahSPJ'=>round($jumlahSPJ), 'totalRP'=> round($totalRP));
		echo json_encode($hasil);
	}
	public function getTabelGenerate()
	{
		$inputJenisSPJ = $this->input->get("filJenis");
		$data['data'] = $this->M_Implementasi->getSPJForGenerate($inputJenisSPJ)->result();
		$this->load->view("implementasi/generate/tabel", $data);
	}
	public function saveGenerateSPJ()
	{
		$noSPJ = $this->input->post("noSPJ");
		$inputNoGenerate = $this->input->post("inputNoGenerate");
		$inputJumlahSPJ = $this->input->post("inputJumlahSPJ");
		$inputTotalRP = $this->input->post("inputTotalRP");
		$filJenis = $this->input->post("filJenis");
		$jmlNoSPJ = count($noSPJ);
		$kasbonSPJ = 0;
		$kasbonBBM = 0;
		$kasbonTOL = 0;
		for ($i=0; $i <$jmlNoSPJ ; $i++) { 
			$this->db->query("UPDATE SPJ_PENGAJUAN SET NO_GENERATE = '$inputNoGenerate' WHERE NO_SPJ = '$noSPJ[$i]'");
			$getBiaya = $this->M_Implementasi->getBiayaTotalPerNoSPJ($noSPJ[$i])->result();
			foreach ($getBiaya as $key) {
				$kasbonSPJ += $key->KASBON_SPJ;
				$kasbonBBM += $key->KASBON_BBM;
				$kasbonTOL += $key->KASBON_TOL;
			}
		}
		$data = $this->M_Implementasi->saveGenerateSPJ($inputNoGenerate, $inputJumlahSPJ, $inputTotalRP, $filJenis);
		// $data = array('KASBON SPJ' =>$kasbonSPJ ,'KASBON BBM' =>$kasbonBBM, 'KASBON TOL' =>$kasbonTOL,'total'=>$kasbonSPJ+$kasbonBBM+$kasbonTOL );
		$data = $this->M_Implementasi->generatePengajuanKas($inputNoGenerate, $kasbonSPJ, $kasbonBBM, $kasbonTOL, $filJenis);
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
	public function updateSaldo($inputIdSPJ, $kasbon, $totalBiaya, $keterangan)
	{
		$id = $inputIdSPJ;
		$jenis = $kasbon;
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($jenis, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		$totalSaldo = $saldo - $totalBiaya;
		$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
		$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalBiaya, 'KASBON', $id,$keterangan);
	}
}
?>
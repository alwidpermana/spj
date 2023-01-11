<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Auth');
		$this->load->model('M_Data_Master');
		$this->load->model('M_Pengajuan');
		$this->load->model('M_Serlok');
		$this->load->model('M_Cash_Flow');
		$this->load->model('M_Monitoring');
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
	public function form()
	{
		$data['side'] = 'spj-pengajuan';
		$data['page'] = 'Form Pengajuan';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$data['spjOtoritas'] = $this->M_Data_Master->getJenisSPJByOtoritas()->result();
		$data['kendaraan'] = $this->M_Data_Master->getKategoriKendaraan()->result();
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['kota'] = $this->M_Data_Master->getKotaKabDis()->result();
		$this->load->view("pengajuan/form/index2", $data);
	}
	public function form_edit($id)
	{
		$this->load->model('M_Monitoring');
		$data['data']= $this->M_Monitoring->getSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='',$id, $adjustment='','')->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id,'')->result();
		$data['side'] = 'spj-pengajuan';
		$data['page'] = 'Form Pengajuan';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$data['kendaraan'] = $this->M_Data_Master->getKategoriKendaraan()->result();
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['kota'] = $this->M_Data_Master->getKotaKabDis()->result();
		$this->load->view("pengajuan/form/edit", $data);
	}
	public function getNoSPJ()
	{
		$jenis = $this->input->get("jenis");
		$kode = $this->session->userdata("KODE_DEPT") == '' ? '0000': $this->session->userdata("KODE_DEPT");
		$data = $this->M_Pengajuan->getNoSPJ($jenis, $kode);
		echo json_encode($data);
	}
	public function saveTemporaryPengajuan()
	{
		$this->load->library('ciqrcode');
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputTglSPJ = $this->input->post("inputTglSPJ");
		$inputJenisOther = $this->input->post("inputJenisOther");
		$namaFile = str_replace('/', '', $inputNoSPJ);
		$data = $this->M_Pengajuan->saveTemporaryPengajuan($inputJenisSPJ, $inputNoSPJ, $namaFile, $inputTglSPJ, $inputJenisOther);
		$config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/image/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/image/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/image/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$namaFile.'.png'; //buat name dari qr code sesuai dengan namaFile
 
        $params['data'] = $namaFile; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 5;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $aktivitas = "Tambah Baru SPJ Dengan Nomor ".$inputNoSPJ." Untuk SPJ Tanggal ".$inputTglSPJ;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
        
        echo json_encode($data);
	}
	public function viewQrCode()
	{
		$no = $this->input->post("no");
		$namaFile = str_replace("/","",$no);
		$data['nama'] = $namaFile;
		$this->load->view("pengajuan/form/qr_code", $data);
	}
	public function pilihKendaraan()
	{
		$inputKendaraan = $this->input->get("inputKendaraan");
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$searchKendaraan = $this->input->get("searchKendaraan");
		$data['data'] = $this->M_Pengajuan->getListKendaraan($inputJenisKendaraan, $inputKendaraan, $inputTglSPJ, $searchKendaraan)->result();
		$this->load->view("pengajuan/form/listKendaraan", $data);
	}
	public function getViewJalur()
	{
		$id = $this->input->get("id");
		$data = $this->M_Data_Master->getGroupJalur($id)->result();
		echo json_encode($data);
	}
	public function saveCustomerSerlok()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputNoTNKB = $this->input->post("inputNoTNKB");
		$inputTglSPJ = $this->input->post("inputTglSPJ");
		$whereDeparture = $this->input->post("whereDeparture");
		$this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$inputNoSPJ'");
		$getSerlok = $this->M_Serlok->getSPJByOutGoing2($inputNoTNKB, $inputTglSPJ, $whereDeparture);
		$idGroup = 0;
		foreach ($getSerlok->result() as $key) {
			$serlokID = $key->KPS_CUSTOMER_ID;
			$deliveryId = $key->ID;
			$serlokAlamat = $key->PLANT1_CITY;
			$serlokPerusahaan = $key->COMPANY_NAME;
			$serlokKota = $key->nama_kabkota;
			// $serlok = $this->M_Serlok->getCustomerByGroup($query="", $idSerlok)->result();
			// $serlokKota = '';
			// foreach ($serlok as $key2) {
			// 	$serlokID = $key2->id;
			// 	$serlokAlamat = $key2->ALAMAT_LENGKAP_PLANT;
			// 	$serlokPerusahaan = $key2->COMPANY_NAME;
			// 	$serlokKota = $key2->nama_kabkota;
			// }
			$kota = substr($serlokKota, 0, 5) == 'KOTA ' ? substr($serlokKota, 5):$serlokKota;
			$group = $this->M_Pengajuan->findGroupTujuan($kota);
			$data = $this->M_Pengajuan->saveLokasiTujuan($group, 'Customer', $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota, $deliveryId);
			$idGroup = $group>=$idGroup ? $group : $idGroup;
		}

		$aktivitas = "Tambah Data Lokasi Mengambil Data Otomatis Berdasarkan Outgoing Serlok";
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		$this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $idGroup);
		echo json_encode($data);
	}
	public function getCustomerSerlok()
	{
		$query = $this->input->post("query");
		$data = $this->M_Serlok->getCustomerByGroup($query, $id='')->result();
		echo json_encode($data);
	}
	public function findGroupTujuan()
	{
		$inputPerusahaan= $this->input->get("inputPerusahaan");
		$serlok = $this->M_Serlok->getCustomerByGroup($query="", $inputPerusahaan)->result();
		$serlokKota = '';
		foreach ($serlok as $key) {
			$serlokKota = $key->nama2;
		}
		$data = $this->M_Pengajuan->findGroupTujuan($serlokKota);
		echo json_encode($data);
	}
	public function saveLokasiTujuan()
	{
		$inputPerusahaan= $this->input->post("inputPerusahaan");
		$inputGroupTujuan= $this->input->post("inputGroupTujuan");
		$inputObjek= $this->input->post("inputObjek");
		$inputNoSPJ= $this->input->post("inputNoSPJ");
		$objek = $this->input->post("objek");
		if ($objek == 'Lainnya') {
			$serlokID = 0;
			$serlokAlamat = $this->input->post("inputAlamat");
			$serlokPerusahaan = $this->input->post("inputNamaTempat");
			$serlokKota = $this->input->post("inputKotaKabupaten");
		}else if($objek == 'Rekanan'){
			$serlokID = 0;
			$deliveryId = 0;
			$serlokAlamat = $inputPerusahaan;
			$serlokPerusahaan = $inputPerusahaan;
			$serlokKota = 'BANDUNG';
		}else{
			$serlok = $this->M_Serlok->getCustomerByGroup($query='', $inputPerusahaan)->result();
			$serlokID = '';
			$serlokAlamat = '';
			$serlokPerusahaan = '';
			$serlokKota = '';
			foreach ($serlok as $key) {
				$serlokID = $key->KPS_CUSTOMER_ID;
				$deliveryId = $key->id;
				$serlokAlamat = $key->ALAMAT_LENGKAP_PLANT;
				$serlokPerusahaan = $key->COMPANY_NAME;
				$serlokKota = $key->nama_kabkota;
			}	
		}
		

		$data = $this->M_Pengajuan->saveLokasiTujuan($inputGroupTujuan, $inputObjek, $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota, $deliveryId);
		$aktivitas = "Tambah Data Manual Lokasi Ke ".$inputObjek." ".$serlokPerusahaan;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function cekOutGoingSerlok()
	{
		$inputNoTNKB = $this->input->get("inputNoTNKB");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$whereDeparture = $this->input->get("whereDeparture");
		$data = $this->M_Serlok->getSPJByOutGoing2($inputNoTNKB, $inputTglSPJ, $whereDeparture)->result();
		echo json_encode($data);
	}
	public function getDepartureTime()
	{
		$inputNoTNKB = $this->input->get("inputNoTNKB");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$data = $this->M_Serlok->getDeparture($inputNoTNKB, $inputTglSPJ);
		$html = '';
		if ($data->num_rows()>0) {
			foreach ($data->result() as $key) {
				$html .='<option value="'.date("H:i", strtotime($key->departure_time)).'">'.date("H:i", strtotime($key->departure_time)).'</option>';	
			}
		}
		echo json_encode($html);
		
	}
	public function updateGroupTujuan()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$id = $this->M_Pengajuan->updateGroupTujuan($inputNoSPJ);
		$data = $this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $id);
		echo json_encode($data);
	}
	public function getGroupSPJ()
	{
		$noSPJ = $this->input->get("noSPJ");
		$data = $this->M_Pengajuan->getGroupSPJ($noSPJ)->row();
		echo json_encode($data);
	}
	public function cekPengajuanPIC()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$sql = $this->db->query("SELECT ID_PIC FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$inputNoSPJ'");
		$data = $sql->num_rows();
		echo json_encode($data);
	}
	public function updateOtomatisUangSPJ()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputJenisKendaraan = $this->input->post("inputJenisKendaraan");
		$getPIC = $this->db->query("SELECT
										ID_PIC,
										OBJEK,
										CASE 
											WHEN JENIS_PIC = 'Sopir' OR JENIS_PIC = 'Pendamping' THEN JENIS_PIC
											ELSE JABATAN
										END AS JENIS_PIC,
										TGL_SPJ
									FROM
										SPJ_PENGAJUAN_PIC a
									INNER JOIN
										SPJ_PENGAJUAN b ON
									a.NO_PENGAJUAN = b.NO_SPJ
									WHERE
										NO_PENGAJUAN= '$inputNoSPJ'
									AND UANG_SAKU > 0");
		$save = true;
		foreach ($getPIC->result() as $key) {
			$objek = date('l', strtotime($key->TGL_SPJ)) == 'Saturday' ? 'Rental':$key->OBJEK;
			$pic = $key->JENIS_PIC;
			$id = $key->ID_PIC;
			$uang= $this->M_Pengajuan->hitungUangSaku($inputJenisSPJ, $objek, $pic, $inputGroupTujuan, $inputJenisKendaraan);
			foreach ($uang->result() as $key) {
				$biaya = $key->BIAYA;
				$save = $this->M_Pengajuan->saveOtomatisUangSPJ($id, $inputGroupTujuan, $biaya);
			}
		}
		echo json_encode($save);
	}
	public function getLokasi()
	{
		$inputGroupTujuan= $this->input->get("inputGroupTujuan");
		$inputNoSPJ= $this->input->get("inputNoSPJ");
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$data['data'] = $this->M_Pengajuan->getLokasi($inputGroupTujuan, $inputNoSPJ)->result();
		$data['jenis'] = $inputJenisSPJ;
		$this->load->view('pengajuan/form/lokasi', $data);
	}
	public function getPIC()
	{
		$inputNoSPJ= $this->input->get("inputNoSPJ");
		$data['data'] = '';
		$this->load->view("pengajuan/form/pic", $data);
	}
	public function getNIKPic()
	{
		$inputSubjek = $this->input->get("inputSubjek");
		$jabatan = $this->input->get("jabatan");
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$inputNoSPJ= $this->input->get("inputNoSPJ");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$inputKendaraan = $this->input->get("inputKendaraan");
		$inputRekanan = $this->input->get("inputRekanan");
		if ($inputJenisSPJ == '1') {
			if ($jabatan == 'Sopir') {
				$where = " AND OTORITAS_DRIVER = 'Y' ";
				$where2 = '';
			}elseif ($jabatan == 'Pendamping') {
				$where = " AND OTORITAS_PENDAMPING = 'Y' ";
				$where2 = '';
			}else{
				$where = " AND NIK = '-'";
				$where2 = '';
			}
			$whereJenis = " AND SPJ_DLV = 'Y'";		
		}else{
			if ($jabatan == "Sopir") {
				$where = " AND OTORITAS_DRIVER = 'Y' AND JENIS_DATA = 'Internal'";
				$where2 = '';
			}elseif ($jabatan =='Office') {
				$where = " AND OTORITAS_DRIVER IN ('Y','N') AND OTORITAS_ADJUSMENT = 'N' AND JENIS_DATA = 'Internal'";
				$where2 = " WHERE jabatan NOT IN ('Driver','Sopir')";
			}elseif($jabatan == 'Manajemen'){
				$where = " AND OTORITAS_ADJUSMENT = 'Y' AND JENIS_DATA = 'Internal'";
				$where2 = "";
			}else{
				$where = " AND NIK = '-'";
				$where2 = '';
			}
			$whereJenis = " AND SPJ_NDV = 'Y'";
		}
		$whereRekanan='';
		if ($inputKendaraan == 'Rental' && $jabatan == 'Sopir') {
			$whereRekanan = " AND REKANAN = '$inputRekanan'";
		}

		$data = $this->M_Pengajuan->getPIC($inputSubjek, $jabatan, $where, $inputNoSPJ, $where2, $whereJenis, $inputTglSPJ, $whereRekanan)->result();
		echo json_encode($data);
	}
	public function hitungUangSaku()
	{
		$anjing = $this->input->get("inputJenisSPJ"); 
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$inputSubjek = date('l', strtotime($inputTglSPJ)) == 'Saturday' ? 'Rental' : $this->input->get("inputSubjek"); 
		$inputPIC = $this->input->get("jabatanPIC"); 
		$inputGroupTujuan = $this->input->get("inputGroupTujuan"); 
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		$nik = $this->input->get("nik");
		
		$inputTglBerangkat = $this->input->get("inputTglBerangkat");
        $inputJamBerangkat = $this->input->get("inputJamBerangkat");
        $inputTglPulang = $this->input->get("inputTglPulang");
        $inputJamPulang = $this->input->get("inputJamPulang");
        $inputKendaraan = $this->input->get("inputKendaraan");
        $rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
        $waktu_awal  = strtotime($rencanaBerangkat);
        $waktu_akhir = strtotime($rencanaPulang); // waktu sekarang
        $diff    =$waktu_akhir - $waktu_awal;
        $jam    =floor($diff / (60 * 60));
        $jam2 = 0;
        $totalJam = 0;

        if ($inputKendaraan == 'Rental' && $inputPIC == 'Sopir') {
        	$hasil = array('BIAYA' =>0 ,'Menggunakan Kendaraan Rental','tc'=>'warning');
        }else{
        	$cekPIC = $this->M_Pengajuan->cekPICUangSaku($inputTglSPJ, $nik);
        
	        if ($cekPIC->num_rows()>0) {
	        	$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini','tc'=>'danger');
	        } else {
	        	$cekRumsu = $this->M_Pengajuan->cekOtoritasUangRumsum($nik)->row();
	        	if ($cekRumsu->OTORITAS_UANG_SAKU == 'Y') {
	        		$data = $this->M_Pengajuan->hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan);
					
					if ($data->num_rows()>0) {
						foreach ($data->result() as $key) {
							$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'PIC Mendapatkan Uang Saku','tc'=>'success');				
						}
					} else {
						$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
					}
	        	}else{
	        		$hasil = array('BIAYA' =>0 ,'KET'=>'OTORITAS UANG SAKU = N','tc'=>'danger');
	        	}
	        	
	        }
        }
        
        
		
		
		echo json_encode($hasil);
	}
	public function hitungUangMakan()
	{
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$inputGroupTujuan = $this->input->get("inputGroupTujuan"); 
		$jenisTujuan = $inputGroupTujuan == 4?'Lokal':'Luar Kota';
		$inputPIC = $this->input->get("inputPIC");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$inputTglBerangkat = $this->input->get("inputTglBerangkat");
        $inputJamBerangkat = $this->input->get("inputJamBerangkat");
        $inputTglPulang = $this->input->get("inputTglPulang");
        $inputJamPulang = $this->input->get("inputJamPulang");
        $rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
        $waktu_awal  = strtotime($rencanaBerangkat);
        $waktu_akhir = strtotime($rencanaPulang); // waktu sekarang
        $diff    =$waktu_akhir - $waktu_awal;
        $jam    =floor($diff / (60 * 60));
        $jam2 = 0;
        $totalJam = 0;
		$cekPIC = $this->M_Pengajuan->cekPICUangSaku($inputTglSPJ, $inputPIC);
        
        if ($inputGroupTujuan == '10') {
        	$hasil = array('BIAYA' => '20000', 'KET'=>'Tersedia');
        }else{
        	if ($cekPIC->num_rows()>0) {
	        	$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini','tc'=>'danger');
	    //     	foreach ($cekPIC->result() as $pic) {
	    //     		$jam2 += $pic->DIFF_HOUR;	
	    //     	}

	    //     	$totalJam = $jam+$jam2;
	    //     	if ($totalJam<=14) {
	    //     		$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini');
	    //     	}else{
	    //     		$data = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
				
					// if ($data->num_rows()>0) {
					// 	foreach ($data->result() as $key) {
					// 		$hasil = array('BIAYA' => $key->BIAYA,'KET'=>'Tersedia' );				
					// 	}
					// } else {
					// 	$hasil = array('BIAYA' => 0, 'KET'=>'Belum Terdaftar Di Data Master');
					// }
	    //     	}

	        } else {
	        	$cekRumsu = $this->M_Pengajuan->cekOtoritasUangRumsum($inputPIC)->row();
	        	if ($cekRumsu->OTORITAS_UANG_MAKAN == 'Y') {
	        		$data = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
					
					if ($data->num_rows()>0) {
						foreach ($data->result() as $key) {
							$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'PIC Mendapatkan Uang Makan','tc'=>'danger');				
						}
					} else {
						$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
					}
	        	}else{
	        		$hasil = array('BIAYA' =>0 ,'KET'=>'OTORITAS UANG MAKAN = N','tc'=>'danger');
	        	}
	        	
	        }
        }
		echo json_encode($hasil);
	}
	public function getDataInputPIC()
	{
		$nik = $this->input->get("nik");
		
		if (substr($nik, 0, 2) == 'M-') {
			$data= $this->M_Data_Master->getSupirLogistik($filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirLogistik')->row();
		}elseif (substr($nik, 0, 2) == 'S-') {
			$data= $this->M_Data_Master->getSupirLogistik($filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirRental')->row();
		}else{
			$data= $this->M_Data_Master->getKaryawan($filDepartemen='', $filJabatan='', $filSearch='', $nik, $top = 1)->row();
		}
		echo json_encode($data);
	}
	public function savePIC()
	{
		$inputJenisPIC= $this->input->post("inputJenisPIC");
		$inputSubjek= $this->input->post("inputSubjek");
		$inputPIC= $this->input->post("inputPIC");
		$inputUangSaku= $this->input->post("inputUangSaku");
		$inputUangMakan= $this->input->post("inputUangMakan");
		$inputSortir= $this->input->post("inputSortir");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$inputDepartemen = $this->input->post("inputDepartemen");
        $inputSubDepartemen = $this->input->post("inputSubDepartemen");
        $inputJabatan = $this->input->post("inputJabatan");
        $inputNamaPIC = $this->input->post("inputNamaPIC");
		$data= $this->M_Pengajuan->savePIC($inputJenisPIC, $inputSubjek, $inputPIC, $inputUangSaku, $inputUangMakan, $inputSortir, $inputNoSPJ, $inputGroupTujuan, $inputDepartemen, $inputSubDepartemen, $inputJabatan, $inputNamaPIC);
		$aktivitas = "Tambah Data PIC ".$inputSubjek." Dengan NIK= ".$inputPIC." dan Nama= ".$inputNamaPIC;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function getPengajuanPIC()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$data = $this->M_Pengajuan->getPengajuanPIC($inputGroupTujuan, $inputNoSPJ)->result();
		echo json_encode($data);
	}
	public function cekJumlahSupir()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$inputGroupTujuan = $this->input->get("inputGroupTujuan");
		$inputPIC= $this->input->get("inputPIC");
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		$data = $this->M_Pengajuan->cekJumlahSupir($inputNoSPJ, $inputGroupTujuan, $inputPIC, $inputJenisKendaraan)->row();
		echo json_encode($data);
	}
	public function getTotalUangSakuMakan($value='')
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$inputGroupTujuan = $this->input->get("inputGroupTujuan");
		$data = $this->M_Pengajuan->getTotalUangSakuMakan($inputNoSPJ, $inputGroupTujuan)->row();
		echo json_encode($data);
	}
	public function saveKendaraanSPJ()
	{
		$inv = $this->input->post("inv");
		$jenis = $this->input->post("inputJenisKendaraan");
		$noSPJ = $this->input->post("noSPJ");
		$tnkb = $this->input->post("tnkb"); 
		$merk = $this->input->post("merk");
		$tipe = $this->input->post("tipe");
		$kendaraan = $this->input->post("kendaraan");
		$inputRekananKendaraan = $this->input->post("inputRekananKendaraan");
		$inputRekanan = $this->input->post("inputRekanan");
		$data = $this->M_Pengajuan->saveKendaraanSPJ($inv, $jenis, $noSPJ, $tnkb, $merk, $tipe, $kendaraan, $inputRekananKendaraan, $inputRekanan);
		$ketRekanan = $kendaraan =='Rental' ? " Rekanan = ".$inputRekananKendaraan:"";
		$aktivitas = "Tambah Data Kendaraan ".$kendaraan."".$ketRekanan." Dengan No TNKB = ".$tnkb ;
        $this->M_Monitoring->saveSPJLog('New',$noSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function saveGroupTujuanSPJ()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ"); 
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$data = $this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $inputGroupTujuan);
		echo json_encode($data);
	}
	public function getUangJalanSPJ()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$inputKendaraan = $this->input->get("inputKendaraan");
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		
		
		$data = $this->M_Pengajuan->getUangJalanSPJ($inputNoSPJ)->row();
		echo json_encode($data);
	}
	public function cekKelengkapanDataSPJ()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$data = $this->M_Pengajuan->cekKelengkapanDataSPJ($inputNoSPJ);
		if ($data->num_rows()>0) {
			foreach ($data->result() as $key) {
				$hasil = array(
							'SPJ' => 1 ,
							'JML_LOKASI' => $key->JML_LOKASI,
							'JML_PIC' =>$key->JML_PIC 
						  );
			}
		} else {
			$hasil = array('SPJ' => 0 , 'JML_LOKASI' => 0, 'JML_PIC' => 0 );
		}
		
		echo json_encode($hasil);
	}
	public function hapusLokasi()
	{
		$id = $this->input->post("id");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$nama = $this->input->post("nama");
		$data = $this->M_Pengajuan->hapusLokasi($id);
		$aktivitas = "Hapus Data Lokasi ".$nama;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function hapusPIC()
	{
		$id = $this->input->post("id");
		$nama = $this->input->post("nama");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$data = $this->M_Pengajuan->hapusPIC($id);
		$aktivitas = "Hapus Data PIC ".$nama;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function saveSPJ()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$getKasbon = $this->db->query("SELECT
											TOTAL_UANG_SAKU,
											TOTAL_UANG_MAKAN,
											TOTAL_UANG_JALAN,
											TOTAL_UANG_BBM,
											TOTAL_UANG_TOL,
											CASE 
												WHEN TAMBAHAN_UANG_JALAN IS NULL THEN 0
												ELSE TAMBAHAN_UANG_JALAN
											END AS TAMBAHAN_UANG_JALAN
										 
										FROM
											SPJ_PENGAJUAN 
										WHERE
											NO_SPJ = '$inputNoSPJ'");
		foreach ($getKasbon->result() as $kb) {
			$oldKasbon = $kb->TOTAL_UANG_SAKU + $kb->TOTAL_UANG_MAKAN + $kb->TOTAL_UANG_JALAN + $kb->TOTAL_UANG_BBM + $kb->TOTAL_UANG_TOL + $kb->TAMBAHAN_UANG_JALAN;
		}

		$getVoucher = $this->M_Data_Master->getNoVoucherNew()->row();
		$newVoucher = $getVoucher->NO_VOUCHER;
		$data= $this->M_Pengajuan->saveSPJ($newVoucher);
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$cek = $this->db->query("SELECT ID_PIC FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$inputNoSPJ' AND JENIS_PIC = 'Manajemen'");
		if ($cek->num_rows()>0) {
			$this->M_Pengajuan->savePICManajemen($inputNoSPJ);	
		}
		// $this->M_Pengajuan->saveKasbon();
		$this->M_Pengajuan->updateFlagTrip($inputNoSPJ);
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$inputTotalUangSaku = $this->input->post("inputTotalUangSaku");
        $inputTotalUangMakan = $this->input->post("inputTotalUangMakan");
        $inputTotalUangJalan = $this->input->post("inputTotalUangJalan") == '' ?0:$this->input->post("inputTotalUangJalan");
        $inputTambahanUangJalan = $this->input->post("inputTambahanUangJalan");
        $inputBBM = $this->input->post("inputBBM");
        $inputTOL = $this->input->post("inputTOL");
        $inputMediaBBM = $this->input->post("inputMediaBBM");
        $inputMediaTOL = $this->input->post("inputMediaTOL");
        $bbmSPJ = $inputMediaBBM == 'Kasbon' ? $inputBBM : 0;
        $tolSPJ = $inputMediaTOL == 'Kasbon' ? $inputTol : 0;
        $inputAbnormal = $this->input->post("inputAbnormal");
        $totalUangJalan = $inputGroupTujuan == '4'|| $inputAbnormal == 'Y' ? $inputTotalUangJalan + $inputTambahanUangJalan : $inputTotalUangJalan;
        $totalSPJ = $inputTotalUangSaku + $inputTotalUangMakan + $totalUangJalan + $bbmSPJ + $tolSPJ;
        $status = $this->input->post("status");
        if ($totalSPJ > 0) {
        	$this->updateSaldo($inputNoSPJ, $totalSPJ, $oldKasbon, $status);
        }
        $aktivitas = "Saved Data SPJ Dengan Kasbon Sebesar = Rp.".number_format($oldKasbon);
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function cekAdaDriver()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$data = $this->M_Pengajuan->cekAdaDriver($inputNoSPJ)->num_rows();
		echo json_encode($data);
	}
	public function saveRencanaBerangkat()
	{
		$inputNoSPJ= $this->input->post("inputNoSPJ"); 
		$inputTglBerangkat= $this->input->post("inputTglBerangkat"); 
		$inputJamBerangkat= $this->input->post("inputJamBerangkat"); 
		$inputTglPulang= $this->input->post("inputTglPulang"); 
		$inputJamPulang= $this->input->post("inputJamPulang");
		$data= $this->M_Pengajuan->saveRencanaBerangkat($inputNoSPJ, $inputTglBerangkat, $inputJamBerangkat, $inputTglPulang, $inputJamPulang);
		$aktivitas = "Tambah Rencana Keberangkatan Jam ".$inputJamBerangkat." dan Kepulangan Jam ".$inputJamPulang;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function hapusPICDriverCzMarketing()
	{
		$inputNoSPJ= $this->input->post("noSPJ"); 
		$data = $this->M_Pengajuan->hapusPICDriverCzMarketing($inputNoSPJ);
		echo json_encode($data);
	}
	public function getVoucherBBM()
	{
		$cari = $this->input->post("cari");
		$sql = $this->M_Data_Master->getDataVoucher('NOT',$cari,'','','','');
		$item = $sql->result_array();
		$data = array();
		$value = "";
		foreach ($item as $key) {
			$value = $key['NO_VOUCHER'].' - Rp.'.str_replace(',', '.', number_format($key['RP'], 0));
			$data[] = array('id' =>$key['ID'] , 'text' =>$value);
		}
		echo json_encode($data);
	}
	public function getVoucherBBMPerId()
	{
		$id = $this->input->get("id");
		$data = $this->M_Data_Master->getDataVoucher('NOT','',$id,'','','')->row();
		echo json_encode($data);
	}
	public function cekManajemen()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$cek = $this->db->query("SELECT ID_PIC FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$inputNoSPJ' AND JENIS_PIC = 'Manajemen'");
		if ($cek->num_rows()>0) {
			$data = $this->M_Pengajuan->savePICManajemen($inputNoSPJ);	
		}else{
			$data = 'true';
		}
		echo json_encode($data);
	}
	public function getDataAutoCompleteKendaraanRental(){
	    // POST data
	    // $cari = $this->input->get('cari');
	    // $jenis = $this->input->get("jenis");
	    $postData = $this->input->post();
	    // if ($jenis == 'tnkb') {
	    // 	$sql = " AND NO_TNKB LIKE '%$cari'%";
	    // }elseif($jenis == 'merk'){
	    // 	$sql = " AND MERK LIKE '%$cari%'";
	    // }else{
	    // 	$sql = " AND TYPE LIKE '%$cari%'";
	    // }
	    // Get data
	    $data = $this->M_Pengajuan->getKendaraanWithAutoComplete($postData);
	    echo json_encode($data);
	}
	public function cekSaldoSubKas()
	{
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$data = $this->M_Cash_Flow->getAllSaldo('SUB KAS')->result();
		$saldoSPJ = 0;
		$saldoTOL = 0;
		$saldoBBM = 0;
		foreach ($data as $key) {
			if ($inputJenisSPJ == '1' && $key->JENIS_SALDO == 'Kasbon SPJ Delivery') {
				$saldoSPJ = $key->JUMLAH;
			}elseif ($inputJenisSPJ == '2' && $key->JENIS_SALDO == 'Kasbon SPJ Non Delivery') {
				$saldoSPJ = $key->JUMLAH;
			}elseif ($inputJenisSPJ == '1' && $key->JENIS_SALDO == 'Kasbon TOL Delivery') {
				$saldoTOL = $key->JUMLAH;
			}elseif ($inputJenisSPJ == '2' && $key->JENIS_SALDO == 'Kasbon TOL Non Delivery') {
				$saldoTOL = $key->JUMLAH;
			}elseif ($key->JENIS_SALDO == 'Kasbon Voucher BBM') {
				$saldoBBM = $key->JUMLAH;
			}
		}

		$hasil = array('saldoSPJ' =>$saldoSPJ, 'saldoTOL'=>$saldoTOL, 'saldoBBM'=>$saldoBBM);
		echo json_encode($hasil);
	}
	public function updateSaldo($inputNoSPJ, $totalSPJ, $oldKasbon, $status)
	{
		$getSPJ = $this->M_Pengajuan->getIDByNoSPJ($inputNoSPJ)->result();
		$id = 0;
		$jenisSPJ = '';
		foreach ($getSPJ as $key) {
			$id = $key->ID_SPJ;
			$jenisSPJ = $key->NAMA_JENIS;
		}
		$jenis = 'Kasbon SPJ '.$jenisSPJ;
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenis($jenis, 'SUB KAS');
		$saldo = 0;
		foreach ($getSaldo->result() as $key) {
			$saldo  = $key->SALDO;
		}
		if ($status == 'NEW') {
			$totalSaldo = $saldo - $totalSPJ;
			$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
			$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalSPJ, 'KASBON', $id,'TRANSAKSI AWAL');
		} else {
			if ($totalSPJ != $oldKasbon) {
				$totalSaldo = ($saldo + $oldKasbon)-$totalSPJ;	
				$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
				$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $totalSPJ, 'KASBON', $id,'TRANSAKSI AWAL');
			}
		}
		
		
	}
	public function getSaldoPerJenis()
	{
		$jenis = $this->input->get("jenis");
		$jenisSPJ = $jenis == '1'?'Kasbon SPJ Delivery':'Kasbon SPJ Non Delivery';
		$data['data'] = $this->M_Cash_Flow->getSaldoPerJenis($jenisSPJ, 'SUB KAS')->result();
		$data['jenis']= str_replace('Kasbon', 'Saldo', $jenisSPJ);
		$this->load->view("pengajuan/form/saldo", $data);
	}

	public function temporary()
	{
		$data['side'] = 'spj-temporary';
		$data['page'] = 'Pengajuan SPJ (Temporary)';
		$this->load->view("pengajuan/temporary/index", $data);
	}
	public function getTabelTemporary()
	{
		$filSearch = $this->input->get("filSearch");
		$data['data']=$this->M_Pengajuan->getDataTemporary($filSearch)->result();
		$this->load->view("pengajuan/temporary/tabel", $data);
	}
	public function form_temporary($id)
	{
		$this->load->model('M_Monitoring');
		$data['data']= $this->M_Pengajuan->getSPJTemporary($id)->result();
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id,'')->result();
		$data['side'] = 'spj-temporary';
		$data['page'] = 'Form SPJ Temporary';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$data['kendaraan'] = $this->M_Data_Master->getKategoriKendaraan()->result();
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['kota'] = $this->M_Data_Master->getKotaKabDis()->result();
		$this->load->view("pengajuan/form/edit", $data);
	}
	public function hapusPengajuan()
	{
		$noSPJ = $this->input->post("noSPJ");
		$data = $this->M_Pengajuan->hapusPengajuan($noSPJ);
		$aktivitas = "Hapus Data SPJ";
        $this->M_Monitoring->saveSPJLog('New',$noSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function getKotaAPI()
	{
		$cari = $this->input->post("cari");
		$sql = $this->M_Data_Master->getKota2($cari);
		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['KOTA'] , 'text' =>$key['VAL']);
		}
		echo json_encode($data);
	}
	public function getListRekanan()
	{
		$data = $this->M_Data_Master->getDataRekanan('')->result();
		echo json_encode($data);
	}
	public function getKendaraanRekanan()
	{
		$rekananId = $this->input->get("rekananId");
		$data = $this->M_Data_Master->getKendaraanRekanan($rekananId)->result();
		echo json_encode($data);
	}
	public function getKendaraanRentalById()
	{
		$id = $this->input->get("id");
		$data = $this->M_Data_Master->getKendaraanRentalById($id)->row();
		echo json_encode($data);
	}
	public function getUangAbnormalDM()
	{
		$noSPJ = $this->input->get("inputNoSPJ");
		$data = $this->M_Pengajuan->getUangAbnormal($noSPJ)->row();
		$biaya = 0;
		$biaya += $data->BIAYA;
		echo json_encode(round($biaya));
	}
	public function reloadGroupSaldo()
	{
		$noSPJ = $this->input->post("noSPJ");
		$groupId = $this->input->post("groupId");
		$getKasbon = $this->db->query("SELECT SUM(TOTAL_UANG_SAKU + TOTAL_UANG_MAKAN + TOTAL_UANG_JALAN) AS BIAYA, JENIS_KENDARAAN, JENIS_ID, NO_SPJ, TOTAL_UANG_JALAN, ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ' GROUP BY JENIS_KENDARAAN, JENIS_ID, NO_SPJ, TOTAL_UANG_JALAN, ID_SPJ")->row();
		$oldKasbon = $getKasbon->BIAYA;
		$jenisSPJ = $getKasbon->JENIS_ID;
		$jenisKendaraan = $getKasbon->JENIS_KENDARAAN;
		$totalUangJalan = $getKasbon->TOTAL_UANG_JALAN;
		$idSPJ = $getKasbon->ID_SPJ;
		$this->updateOtomatisUangSPJReload($noSPJ, $groupId, $jenisSPJ, $jenisKendaraan, $totalUangJalan, $oldKasbon, $idSPJ);
		$aktivitas = "Reload Data SPJ";
        $this->M_Monitoring->saveSPJLog('New',$noSPJ,$aktivitas);

		// $this->updateSaldo($inputNoSPJ, $totalSPJ, $oldKasbon, $status);
	}
	public function updateOtomatisUangSPJReload($noSPJ, $groupId, $jenisSPJ, $jenisKendaraan, $totalUangJalan, $oldKasbon, $idSPJ)
	{
		$getPIC = $this->db->query("SELECT
										ID_PIC,
										OBJEK,
										CASE 
											WHEN JENIS_PIC = 'Sopir' OR JENIS_PIC = 'Pendamping' THEN JENIS_PIC
											ELSE JABATAN
										END AS JENIS_PIC,
											TGL_SPJ
										FROM
											SPJ_PENGAJUAN_PIC a
										INNER JOIN
											SPJ_PENGAJUAN b ON
										a.NO_PENGAJUAN = b.NO_SPJ
									WHERE
										NO_PENGAJUAN= '$noSPJ'
									AND UANG_SAKU > 0");
		$save = true;
		$totalBiayaRumsum = 0;
		foreach ($getPIC->result() as $key) {
			$objek = date('l', strtotime($key->TGL_SPJ)) == 'Saturday' ? 'Rental' : $key->OBJEK;
			$pic = $key->JENIS_PIC;
			$id = $key->ID_PIC;
			$uang= $this->M_Pengajuan->hitungUangSaku($jenisSPJ, $objek, $pic, $groupId, $jenisKendaraan);
			
			foreach ($uang->result() as $key) {
				$biaya = $key->BIAYA;
				$save = $this->M_Pengajuan->saveOtomatisUangSPJ($id, $groupId, $biaya);
				$totalBiayaRumsum += $biaya;
			}
		}
		
		$getTotal = $this->db->query("SELECT SUM(UANG_SAKU) + SUM(UANG_MAKAN) AS BIAYA FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$noSPJ'")->row();
		$cekKasbon = $this->db->query("SELECT ID FROM SPJ_KAS_SUB WHERE JENIS_FK = 'KASBON' AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND JENIS_KASBON = 'Kasbon SPJ Delivery' AND FK_ID = $idSPJ");
		$status = $cekKasbon->num_rows() == 0 ? 'NEW' : 'UPDATE';
		$totalSPJ = $getTotal->BIAYA + $totalUangJalan;
		$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_SAKU = $totalBiayaRumsum WHERE NO_SPJ = '$noSPJ'");
		$this->updateSaldo($noSPJ, $totalSPJ, $oldKasbon, $status);
	}
	public function pagingDataVoucher()
	{
		$cariVoucher = $this->input->get("cariVoucher");
		$offset = $this->input->get("offset");
		$limit = $this->input->get("limit");
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['data'] = $this->M_Pengajuan->cariDataVoucher($cariVoucher,'')->num_rows();
		$this->load->view("_partial/paging", $data);
	}
	public function cariDataVoucher()
	{
		$cariVoucher = $this->input->get("cariVoucher");
		$offset = $this->input->get("offset")==''?0:$this->input->get("offset")+1;
		$limit = $this->input->get("limit");
		$where = " WHERE NO_URUT >= $offset AND NO_URUT < $offset + $limit";
		$data = $this->M_Pengajuan->cariDataVoucher($cariVoucher,$where);
		$html='';
		if ($data->num_rows()>0) {
			foreach ($data->result() as $key) {
				$html.='<tr class="text-center">
							<td>'.$key->NO_VOUCHER.'</td>
							<td><a href="javascript:;" class="btn bg-orange btn-kps btn-sm pilihVoucher" voucher="'.$key->NO_VOUCHER.'"><i class="fas fa-check-circle"></i></a></td>
						</tr>';
			}
		}else{
			$html.="<tr><td colspan='2' class='text-center'>Data Tidak Tersedia<br>Hubungi PIC Terkait</td></tr>";
		}
		echo json_encode($html);
	}
	public function cekTujuanAbnormal()
	{
		$inputNoSPJ = $this->input->get('inputNoSPJ');
		$data = $this->M_Pengajuan->getJmlLokasiBySPJ($inputNoSPJ)->row();
		if ($data->JML_LOKASI >4) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET ABNORMAL= 'N' WHERE NO_SPJ = '$inputNoSPJ'");
			$response = array('data' =>true,'abnormal'=>false);
		}else{
			$this->db->query("UPDATE SPJ_PENGAJUAN SET ABNORMAL= 'Y' WHERE NO_SPJ = '$inputNoSPJ'");
			$response = array('data' =>true,'abnormal'=>true);
		}
		echo json_encode($response);
	}


}
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
		$data['kota2'] = $this->M_Data_Master->getKotaKabDis()->result();
		$data['kota'] = $this->M_Pengajuan->getKotaByGroup('')->result();
		$data['subcont'] = $this->M_Pengajuan->getListSubcont()->result();
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
		$data['kota2'] = $this->M_Data_Master->getKotaKabDis()->result();
		$data['kota'] = $this->M_Pengajuan->getKotaByGroup('')->result();
		$data['subcont'] = $this->M_Pengajuan->getListSubcont()->result();
		$this->load->view("pengajuan/form/edit", $data);
	}
	public function getNoSPJ()
	{
		$inputTglSPJ = $this->input->get("inputTglSPJ") == '' ? date("Y-m-d"):$this->input->get("inputTglSPJ");
		$jenis = $this->input->get("jenis");
		$kode = $this->session->userdata("KODE_DEPT") == '' ? '0000': $this->session->userdata("KODE_DEPT");
		$data = $this->M_Pengajuan->getNoSPJ($jenis, $kode, $inputTglSPJ);
		echo json_encode($data);
	}

	public function getNoVoucherAuto_V1()
	{
		$data = $this->M_Pengajuan->getNoVoucherAuto_V1();
		echo json_encode($data);
	}
	public function generateVoucherBBM()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$inputTempatSPBU = $this->input->get("inputTempatSPBU");
		$getVoucherSPJ = $this->db->query("SELECT VOUCHER_BBM FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ' AND VOUCHER_BBM IS NOT NULL AND VOUCHER_BBM != '' AND TEMPAT_SPBU = '$inputTempatSPBU'");
		if ($getVoucherSPJ->num_rows()>0) {
			$data = $getVoucherSPJ->row();
			$noVoucher = $data->VOUCHER_BBM;
			$response = array('data' =>true,'no'=>$noVoucher);
		}else{

			$noVoucher = $this->M_Pengajuan->getNoVoucherAuto_V1($inputTempatSPBU);	
			$data = $this->M_Pengajuan->generateVoucherBBM($noVoucher, $inputNoSPJ);
			$response = array('data' =>$data,'no'=>$noVoucher);
		}


		// $getData = $this->db->query("SELECT VOUCHER_BBM FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ' AND VOUCHER_BBM IS NOT NULL AND MEDIA_UANG_BBM = 'Voucher'");
		// if ($getData->num_rows()==0) {
		// 	$data = $this->M_Pengajuan->generateVoucherBBM($noVoucher, $inputNoSPJ);
		// 	$response = array('data' =>$data,'no'=>$noVoucher);
		// }else{
		// 	$data = $getData->row();
		// 	$noVoucher = $data->VOUCHER_BBM;
		// 	$response = array('data' =>true,'no'=>$noVoucher);
			
		// }
		
		echo json_encode($response);
	}

	public function saveTemporaryPengajuan()
	{
		$this->load->library('ciqrcode');
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputTglSPJ = $this->input->post("inputTglSPJ");
		$inputJenisOther = $this->input->post("inputJenisOther");
		$inputTempatKeberangkatan = $this->input->post("inputTempatKeberangkatan");
		$namaFile = str_replace('/', '', $inputNoSPJ);
		$data = $this->M_Pengajuan->saveTemporaryPengajuan($inputJenisSPJ, $inputNoSPJ, $namaFile, $inputTglSPJ, $inputJenisOther, $inputTempatKeberangkatan);
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
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		if ($inputJenisSPJ == '1') {
			$data['data'] = $this->M_Pengajuan->getListKendaraan($inputJenisKendaraan, $inputKendaraan, $inputTglSPJ, $searchKendaraan)->result();
			$this->load->view("pengajuan/form/listKendaraan", $data);
		}else{
			$data['data'] = $this->M_Pengajuan->getListKendaraanNonDelivery($searchKendaraan, $inputKendaraan, $inputJenisKendaraan, $inputTglSPJ)->result();
			$this->load->view("pengajuan/form/listKendaraanNonDelivery", $data);
		}
		
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
			// $serlok = $this->M_Serlok->getCustomerByGroup($query="", $idSerlok, "")->result();
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
		$inputObjek = $this->input->get("inputObjek");
		$cari = $this->input->get("cari");
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		if ($inputObjek == 'Supplier') {
			$sql = $this->M_Pengajuan->getSupplier($cari);
		}else{
			$sql = $this->M_Serlok->getCustomerByGroup('', $id='', $cari);	
		}

		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['id'] , 'text' =>$key['COMPANY_NAME'].' - '.$key['ALAMAT_LENGKAP_PLANT']);
		}
		echo json_encode($data);
	}
	public function findGroupTujuan()
	{
		$inputPerusahaan= $this->input->get("inputPerusahaan");
		$inputObjek = $this->input->get("inputObjek");
		if ($inputObjek == 'Supplier') {
			if ($inputPerusahaan == 'S0790') {
				$data = 10;
			}else{
				$data = $this->M_Pengajuan->findGroupTujuan('-');
			}
		}else{
			$serlok = $this->M_Serlok->getCustomerByGroup($query="", $inputPerusahaan, "")->result();
			$serlokKota = '';
			foreach ($serlok as $key) {
				$serlokKota = $key->nama2;
			}
			$data = $this->M_Pengajuan->findGroupTujuan($serlokKota);	
		}
		
		echo json_encode($data);
	}
	public function saveLokasiTujuan()
	{
		$inputPerusahaan= $this->input->post("inputPerusahaan");
		$inputGroupTujuan= $this->input->post("inputGroupTujuan");
		$inputObjek= $this->input->post("inputObjek");
		$inputNoSPJ= $this->input->post("inputNoSPJ");
		$objek = $this->input->post("objek");
		$inputPilihKota = $this->input->post("inputPilihKota");
		$getJmlLokasi = $this->db->query("SELECT ID_LOKASI FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$inputNoSPJ'")->num_rows();
		if ($objek == 'Lainnya') {
			$serlokID = $getJmlLokasi+1;
			$deliveryId = 0;
			$serlokAlamat = $this->input->post("inputAlamat");
			$serlokPerusahaan = $this->input->post("inputNamaTempat");
			$inputKotaKabupaten = $this->input->post("inputKotaKabupaten");
			$getKota = $this->db->query("SELECT TIPE_KOTA, NAMA_KOTA FROM SPJ_KOTA WHERE ID_KOTA = $inputKotaKabupaten")->row();
			$serlokKota = strtoupper($getKota->TIPE_KOTA.' '.$getKota->NAMA_KOTA);
			// $getGroup = $this->M_Pengajuan->getGroupForLainnya($serlokKota);
			// if ($getGroup->num_rows()>0) {
			// 	$dataGroup = $getGroup->row();
			// 	$inputGroupTujuan = $dataGroup->ID_GROUP;
			// 	$serlokKota = $dataGroup->KOTA;
			// }else{
			// 	$inputGroupTujuan = 0;
			// }
		}else if($objek == 'Rekanan'){
			$serlokID = $getJmlLokasi+1;
			$deliveryId = 0;
			$serlokAlamat = $inputPerusahaan;
			$serlokPerusahaan = $inputPerusahaan;
			$serlokKota = 'BANDUNG';
		}elseif ($objek == 'Supplier') {
			
			$data = $this->M_Pengajuan->getSupplier($inputPerusahaan)->row();
			$serlokID = $getJmlLokasi+1;
			$deliveryId = 0;
			$serlokAlamat = $data->ALAMAT_LENGKAP_PLANT;
			$serlokPerusahaan = $data->COMPANY_NAME;
			$getDataKota = $this->db->query("SELECT NAMA_KOTA FROM SPJ_KOTA WHERE ID_KOTA = $inputPilihKota")->row(); 
			$serlokKota = strtoupper($getDataKota->NAMA_KOTA);
		}else{
			$serlok = $this->M_Serlok->getCustomerByGroup($query='', $inputPerusahaan, "")->result();
			$serlokID = '';
			$serlokAlamat = '';
			$serlokPerusahaan = '';
			$serlokKota = '';
			foreach ($serlok as $key) {
				$serlokID = $key->KPS_CUSTOMER_ID;
				$deliveryId = $key->id;
				$serlokAlamat = $key->ALAMAT_LENGKAP_PLANT;
				$serlokPerusahaan = $key->COMPANY_NAME;
				$kota = $key->nama_kabkota;
			}	
			$getGroup = $this->M_Pengajuan->getGroupForLainnya($inputPilihKota)->row();
			$kotaManual = $getGroup->KOTA;
			$serlokKota = $kota == null || $kota == '' ? $kotaManual : $kota; 
		}

		
		$proses = $this->input->post("proses")=='Edit'?'Edit':'New';
		$data = $this->M_Pengajuan->saveLokasiTujuan($inputGroupTujuan, $objek, $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota, $deliveryId);
		$aktivitas = "Tambah Data Manual Lokasi Ke ".$inputObjek." ".$serlokPerusahaan;
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
        if ($data == true && $proses == 'Edit') {
        	$idGroup = $this->M_Pengajuan->updateGroupTujuan($inputNoSPJ);
			$this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $idGroup);
			$getSPJ = $this->db->query("SELECT JENIS_ID, JENIS_KENDARAAN FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
			$inputJenisSPJ = $getSPJ->JENIS_ID;
			$inputJenisKendaraan = $getSPJ->JENIS_KENDARAAN;
			$this->updateOtomatisUangSPJReload_v2($inputNoSPJ, $idGroup, $inputJenisSPJ, $inputJenisKendaraan);
        }
		echo json_encode($data);
	}
	public function cekOutGoingSerlok()
	{
		$inputNoTNKB = $this->input->get("inputNoTNKB");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$whereDeparture = $this->input->get("whereDeparture");
		$data = $this->M_Serlok->getSPJByOutGoing2($inputNoTNKB, $inputTglSPJ, '')->result();
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
										a.ID_PIC,
										a.OBJEK,
										CASE 
											WHEN a.JENIS_PIC = 'Sopir' OR a.JENIS_PIC = 'Pendamping' THEN a.JENIS_PIC
											ELSE a.JABATAN
										END AS JENIS_PIC,
										b.TGL_SPJ,
										c.Subdepartemen2,
										SORTIR,
										a.NIK,
										b.KENDARAAN,
										b.TGL_SPJ
									FROM
										SPJ_PENGAJUAN_PIC a
									INNER JOIN
										SPJ_PENGAJUAN b ON
									a.NO_PENGAJUAN = b.NO_SPJ
									LEFT JOIN
										dbhrm.dbo.tbPegawai c ON
									a.NIK = c.nik
									WHERE
										a.NO_PENGAJUAN= '$inputNoSPJ'");
		$cekEwindo = $this->db->query("SELECT NO_SPJ AS JML_EWINDO FROM SPJ_PENGAJUAN_LOKASI WHERE DELIVERY_ID IN (497, 68) AND NO_SPJ  = '$inputNoSPJ'")->num_rows();
		$save = true;
		foreach ($getPIC->result() as $key) {
			$cekPIC = $this->M_Pengajuan->cekPICUangSaku($key->TGL_SPJ, $key->NIK);
			if ($cekPIC->num_rows()>0) {
				$biayaUangSaku = 0;
				$biayaMakan = 0;
			}elseif($cekEwindo >0){
				$biayaUangSaku = 0;
				$biayaUangMakan=10000;
			}else{
				$objek = date('l', strtotime($key->TGL_SPJ)) == 'Saturday' ? 'Rental':$key->OBJEK;
				$pic = $key->JENIS_PIC;
				$id = $key->ID_PIC;
				$nik = $key->NIK;
				$subDepartemen = $key->Subdepartemen2;
				if ($subDepartemen == 'Marketing') {
					$biayaUangSaku = 0;
				}elseif($key->SORTIR == 'Y'){
					$biayaUangSaku = 30000;
				}else{
					if ($key->KENDARAAN == 'Rental' && $key->OBJEK == 'Rental' && $pic == 'Sopir' && $inputJenisSPJ == '1') {
						$biayaUangSaku = 0;
					}else{
						$uang= $this->M_Pengajuan->hitungUangSaku($inputJenisSPJ, $objek, $pic, $inputGroupTujuan, $inputJenisKendaraan);
						$biaya = 0;
						foreach ($uang->result() as $key) {
							$biaya = $key->BIAYA;
						}	
						$biayaUangSaku = $biaya == null || $biaya == '' ? 0 : $biaya;	
					}
					
				}
				
				
				if ($nik == '00004' || $nik == '00003' || $nik == '01519' || $nik == '00917' || $nik == '01223') {
					$biayaMakan = 0;
				}elseif ($inputGroupTujuan == '10' && $inputJenisSPJ == '1') {
		        	$biayaMakan = 20000;
		        }elseif($inputGroupTujuan == '10' && $inputJenisSPJ == '2'){
		        	$biayaMakan = 10000;
		        }elseif($inputGroupTujuan == '4' && $inputJenisSPJ == '2'){
		        	$biayaMakan = 20000;
		        }elseif($inputGroupTujuan == '11'){
		        	$biayaMakan = 0;
		        }else{
		        	$jenisTujuan = $inputGroupTujuan == '4' || $inputGroupTujuan == '10' || $inputGroupTujuan == '11' ? 'Lokal':'Luar Kota';
		        	$makan = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
		        	if ($makan->num_rows()>0) {
						foreach ($makan->result() as $key) {
							$biayaMakan= $key->BIAYA;			
						}
					} else {
						$biayaMakan = 0;
					}
		        }
				
				$save = $this->M_Pengajuan->saveOtomatisUangSPJ($id, $inputGroupTujuan, $biayaUangSaku, $biayaMakan);
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

		$data = $this->M_Pengajuan->getPIC($inputSubjek, $jabatan, $where, $inputNoSPJ, $where2, $whereJenis, $whereRekanan, $searchListPIC)->result();
		echo json_encode($data);
	}
	public function getNIKPic_v2()
	{
		$inputJenisPIC = $this->input->get("inputJenisPIC");
		$inputSubjek = $this->input->get("inputSubjek");
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$inputRekanan = $this->input->get("inputRekanan");
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$inputKendaraan = $this->input->get("inputKendaraan");
		$searchListPIC = $this->input->get("searchListPIC");
		if ($inputJenisSPJ == '2' && $inputJenisPIC == 'Office') {
			$data['data'] = $this->M_Pengajuan->getPICOffice($searchListPIC)->result();
		}elseif ($inputJenisPIC == 'Subcont' || $inputSubjek == 'Subcont') {
			$data['data'] = $this->M_Pengajuan->getPICSubcont($searchListPIC)->result();
		}
		else{
			if ($inputJenisSPJ == '1') {
				if ($inputJenisPIC == 'Sopir') {
					$where = " AND OTORITAS_DRIVER = 'Y' ";
					$where2 = '';
				}elseif ($inputJenisPIC == 'Pendamping') {
					$where = " AND OTORITAS_PENDAMPING = 'Y' ";
					$where2 = '';
				}else{
					$where = " AND NIK = '-'";
					$where2 = '';
				}
				$whereJenis = " AND SPJ_DLV = 'Y'";		
			}else{
				if ($inputJenisPIC == "Sopir") {
					$where = " AND OTORITAS_DRIVER = 'Y'";
					$where2 = '';
				}elseif($inputJenisPIC == 'Manajemen'){
					$where = " AND OTORITAS_ADJUSMENT = 'Y' AND JENIS_DATA = 'Internal'";
					$where2 = "";
				}else{
					$where = " AND NIK = '-'";
					$where2 = '';
				}
				$whereJenis = " AND SPJ_NDV = 'Y'";
			}

			$whereRekanan='';
			if ($inputKendaraan == 'Rental' && $inputJenisPIC == 'Sopir' && $inputJenisSPJ == '1' && $inputSubjek == 'Rental') {
				$whereRekanan = " AND REKANAN = '$inputRekanan'";
			}
			$data['jenis'] = $inputJenisSPJ;
			$data['data'] = $this->M_Pengajuan->getPIC($inputSubjek, $inputJenisPIC, $where, $inputNoSPJ, $where2, $whereJenis, $whereRekanan, $searchListPIC)->result();
		}
		$this->load->view("pengajuan/form/listPIC", $data);

	}

	public function hitungUangSaku()
	{
		$anjing = $this->input->get("inputJenisSPJ"); 
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$hari =date('l', strtotime($inputTglSPJ));
		
		
		// if ($anjing == '1') {
			
		// } else {
		// 	$inputSubjek = $this->input->get("inputSubjek");
		// }
		$inputSubjek =  $hari == 'Saturday' || $hari == 'Sunday' ? 'Rental' : $this->input->get("inputSubjek"); 
		$statusWeekend = $hari == 'Saturday' || $hari == 'Sunday' ? 'Weekend' : 'Weekday'; 
		$inputPIC = $this->input->get("jabatanPIC"); 
		$inputGroupTujuan = $this->input->get("inputGroupTujuan"); 
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		$nik = $this->input->get("nik");
		$inputJenisPIC = $this->input->get("inputJenisPIC");
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
        $getSub = $this->db->query("SELECT Subdepartemen2 FROM dbhrm.dbo.tbPegawai WHERE nik = '$nik' AND Subdepartemen2 ='Marketing'");
        $dataMarketing = $getSub->num_rows()>0?1:0;
        $tujuanLokal = $inputGroupTujuan == 4 ||$inputGroupTujuan == 10 || $inputGroupTujuan == 11 ? 'Lokal':'-';
        if ($inputJenisPIC == 'Subcont' || $inputSubjek == 'Subcont') {
        	$hasil = array('BIAYA' => 0,'KET'=>'Subcont Tidak Mendapatkan Uang Saku','tc'=>'danger');
        }elseif ($nik == '00004' || $nik == '00003' || $nik == '01519' || $nik == '00917' || $nik == '01223') {
        	$hasil = array('BIAYA' => 0,'KET'=>'Manajemen Tidak Mendapatkan Uang Saku','tc'=>'danger');
        }elseif ($nik == 'S-331') {
        	$hasil = array('BIAYA' => 0,'KET'=>'Tidak Mendapatkan Uang Saku','tc'=>'danger');
        }
        else{
        	if ($dataMarketing == 1) {
	        	$hasil = array('BIAYA' => 0,'KET'=>'Marketing Tidak Mendapatkan Uang Saku','tc'=>'danger');
	        }else{
	        	if ($inputKendaraan == 'Rental' && $inputJenisPIC == 'Sopir' && $anjing == '1' && $inputSubjek == 'Rental') {
		        	$hasil = array('BIAYA' =>0 ,'KET'=>'Menggunakan Kendaraan Rental','tc'=>'warning');
		        }elseif ($statusWeekend == 'Weekend' && $inputJenisPIC == 'Sopir' && $inputSubjek == 'Internal' && $anjing == '1' && $tujuanLokal == 'Lokal') {
		        	switch ($inputJenisKendaraan) {
		        		case 'Engkel & Double':
		        			$biayaWeekend = 125000;
		        			break;
		        		case 'Wing Box':
		        			$biayaWeekend = 130000;
		        			break;
		        		case 'Minibus':
		        			$biayaWeekend = 120000;
		        			break;
		        		default:
		        			$biayaWeekend = 0;
		        			break;
		        	}
		        	$hasil = array('BIAYA' =>$biayaWeekend ,'KET'=>'Biaya Weekend Lokal Untuk PIC Internal','tc'=>'warning');
		        }
		        else{
		        	$cekPIC = $this->M_Pengajuan->cekPICUangSaku($inputTglSPJ, $nik);
		        
			        if ($cekPIC->num_rows()>0) {
			        	$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini','tc'=>'danger');
			        } else {
			        	$data = $this->M_Pengajuan->hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan);
							
						if ($data->num_rows()>0) {
							foreach ($data->result() as $key) {
								$ketSuccess = $key->BIAYA==null || $key->BIAYA == 0 ? 'PIC Tidak Mendapatkan Uang Saku' : 'PIC Mendapatkan Uang Saku';
								$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>$ketSuccess,'tc'=>'success');				
							}
						} else {
							$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
						}
			        	// $cekRumsu = $this->M_Pengajuan->cekOtoritasUangRumsum($nik)->row();
			        	// $otoritasUangSaku = $inputJenisPIC == 'Office' && ?'Y':$cekRumsu->OTORITAS_UANG_SAKU;
			        	// if ($otoritasUangSaku == 'Y') {
			        	// 	$data = $this->M_Pengajuan->hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan);
							
						// 	if ($data->num_rows()>0) {
						// 		foreach ($data->result() as $key) {
						// 			$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'PIC Mendapatkan Uang Saku','tc'=>'success');				
						// 		}
						// 	} else {
						// 		$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
						// 	}
			        	// }else{
			        	// 	$hasil = array('BIAYA' =>0 ,'KET'=>'OTORITAS UANG SAKU = N','tc'=>'danger');
			        	// }
			        	
			        }
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
        $inputJenisPIC = $this->input->get("inputJenisPIC");
        $inputSubjek = $this->input->get("inputSubjek");
        $inputNoSPJ = $this->input->get("inputNoSPJ");
        $rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
        $waktu_awal  = strtotime($rencanaBerangkat);
        $waktu_akhir = strtotime($rencanaPulang); // waktu sekarang
        $diff    =$waktu_akhir - $waktu_awal;
        $jam    =floor($diff / (60 * 60));
        $jam2 = 0;
        $totalJam = 0;
		$cekPIC = $this->M_Pengajuan->cekPICUangSaku($inputTglSPJ, $inputPIC);
        $cekEwindo = $this->db->query("SELECT NO_SPJ AS JML_EWINDO FROM SPJ_PENGAJUAN_LOKASI WHERE DELIVERY_ID IN (497, 68) AND NO_SPJ  = '$inputNoSPJ'")->num_rows();
        $cekRekanan = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN_LOKASI WHERE SERLOK_COMPANY = 'Plant 2 Dwipapuri' AND OBJEK = 'Rekanan' AND NO_SPJ = '$inputNoSPJ'")->num_rows();

        if ($cekEwindo>0 && $inputJenisSPJ == '2') {
        	$hasil = array('BIAYA' => '10000', 'KET'=>'Tersedia');
        }if ($cekRekanan>0 && $inputJenisSPJ == '2') {
        	$hasil = array('BIAYA' => '10000', 'KET'=>'Tersedia');
        }elseif ($inputGroupTujuan == '10' && $inputJenisSPJ == '1') {
        	$hasil = array('BIAYA' => '20000', 'KET'=>'Tersedia');
        }elseif($inputGroupTujuan == '10' && $inputJenisSPJ == '2'){
        	$hasil = array('BIAYA' => '10000', 'KET'=>'Tersedia');
        }elseif($inputGroupTujuan == '4' && $inputJenisSPJ == '2'){
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

	        }elseif ($inputJenisPIC == 'Office') {
	        	if ($inputPIC == '00004' || $inputPIC == '00003' || $inputPIC == '01519' || $inputPIC == '00917' || $inputPIC == '01223') {
		        	$hasil = array('BIAYA' => 0,'KET'=>'Manajemen Tidak Mendapatkan Uang Makan','tc'=>'danger');
		        }else{
		        	$data = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
		        	if ($data->num_rows()>0) {
						foreach ($data->result() as $key) {
							$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'PIC Mendapatkan Uang Makan','tc'=>'danger');				
						}
					} else {
						$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
					}
		        }
	        }else{
	        	$data = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
					
				if ($data->num_rows()>0) {
					foreach ($data->result() as $key) {
						$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'PIC Mendapatkan Uang Makan','tc'=>'danger');				
					}
				} else {
					$hasil = array('BIAYA' => 0, 'KET'=>'Biaya Belum Terdaftar Di Data Master','tc'=>'danger');
				}
	        }
        }
		echo json_encode($hasil);
	}
	public function getDataInputPIC()
	{
		$nik = $this->input->get("nik");
		
		if (substr($nik, 0, 2) == 'M-') {
			$data= $this->M_Data_Master->getSupirLogistik('Aktif',$filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirLogistik')->row();
		}elseif (substr($nik, 0, 2) == 'S-') {
			$data= $this->M_Data_Master->getSupirLogistik('Aktif',$filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirRental')->row();
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
		if ($inputJenisPIC == 'Subcont' || $inputSubjek == 'Subcont') {
			$inputSortir = 'Y';
		}else{
			$inputSortir= $this->input->post("inputSortir");
		}
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputGroupTujuan = $this->input->post("inputGroupTujuan");
		$inputDepartemen = $this->input->post("inputDepartemen");
        $inputSubDepartemen = $this->input->post("inputSubDepartemen");
        $inputJabatan = $this->input->post("inputJabatan");
        $inputNamaPIC = $this->input->post("inputNamaPIC");
        $inputSubcont = $this->input->post("inputSubcont");
        $getDivisi = $this->db->query("SELECT Subdepartemen2 FROM dbhrm.dbo.tbPegawai WHERE nik = '$inputPIC'");
        if ($getDivisi->num_rows()==0) {
        	$divisi = '';
        }else{
        	$dataDivisi = $getDivisi->row();
        	$divisi = $dataDivisi->Subdepartemen2;	
        }
        $cekJmlSopir = $this->db->query("SELECT ID_PIC FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$inputNoSPJ' AND JENIS_PIC = 'Sopir'")->num_rows();
        $inputJenisPIC = $divisi == 'Marketing' && $inputGroupTujuan != 3 && $cekJmlSopir == 0?'Sopir':$inputJenisPIC;
		$data= $this->M_Pengajuan->savePIC($inputJenisPIC, $inputSubjek, $inputPIC, $inputUangSaku, $inputUangMakan, $inputSortir, $inputNoSPJ, $inputGroupTujuan, $inputDepartemen, $inputSubDepartemen, $inputJabatan, $inputNamaPIC, $inputSubcont);
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
		if ($kendaraan == 'Non Delivery') {
			$getReimburse = $this->db->query("SELECT CASE WHEN Reimburse IS NULL THEN 'N' ELSE Reimburse END AS Reimburse FROM GA.dbo.GA_TKendaraan WHERE NoTNKB = '$tnkb'")->row();
			$reimburse = $getReimburse->Reimburse;
	        $this->M_Monitoring->saveSPJLog('New',$noSPJ,$aktivitas);
		} else {
			$reimburse = 'N';
		}
		
		
		$response = array('data' =>$data ,'reimburse'=>$reimburse);
		echo json_encode($response);
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
		// $getJenis = $this->db->query("SELECT JENIS_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
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
											END AS TAMBAHAN_UANG_JALAN,
										 	CASE 
												WHEN TOTAL_UANG_KENDARAAN IS NULL THEN 0
												ELSE TOTAL_UANG_KENDARAAN
											END AS TOTAL_UANG_KENDARAAN
										FROM
											SPJ_PENGAJUAN 
										WHERE
											NO_SPJ = '$inputNoSPJ'");
		foreach ($getKasbon->result() as $kb) {
			$oldKasbon = $kb->TOTAL_UANG_SAKU + $kb->TOTAL_UANG_MAKAN + $kb->TOTAL_UANG_JALAN + $kb->TOTAL_UANG_BBM + $kb->TOTAL_UANG_TOL + $kb->TAMBAHAN_UANG_JALAN + $kb->TOTAL_UANG_KENDARAAN;
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
        $inputBiayaKendaraan = $this->input->post("inputKendaraan") == 'Gojek/Grab' ?$this->input->post("inputBiayaKendaraan"):0;
        $inputTambahanUangJalan = $this->input->post("inputTambahanUangJalan");
        $inputTempatKeberangkatan = $this->input->post("inputTempatKeberangkatan");
        $inputBBM = $this->input->post("inputBBM");
        $inputTOL = $this->input->post("inputTOL");
        $inputMediaBBM = $this->input->post("inputMediaBBM");
        $inputMediaTOL = $this->input->post("inputMediaTOL");
        $tolSPJ = $inputMediaTOL == 'Kasbon' ? $inputTOL : 0;
        $inputAbnormal = $this->input->post("inputAbnormal");
        $totalUangJalan = $inputGroupTujuan == '4'|| $inputAbnormal == 'Y' ? $inputTotalUangJalan + $inputTambahanUangJalan : $inputTotalUangJalan;
        $totalSPJ = $inputTotalUangSaku + $inputTotalUangMakan + $totalUangJalan + $tolSPJ;
        $status = $this->input->post("status");
        $inputTempatSPBU = $this->input->post("inputTempatSPBU");
        $inputJenisSPJ = $this->input->post("inputJenisSPJ");
        if ($data == true && $totalSPJ > 0 && $inputJenisSPJ == '1') {
        	$this->updateSaldo($inputNoSPJ, $totalSPJ, $oldKasbon, $status);
        	$aktivitas = "Saved Data SPJ Dengan Kasbon Sebesar = Rp.".number_format($oldKasbon);
        }else{
        	$aktivitas = "Saved Draft SPJ";
        }
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function cekAdaDriver()
	{
		$inputNoSPJ = $this->input->get("inputNoSPJ");
		$getKendaraan = $this->db->query("SELECT KENDARAAN FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'")->row();
		$kendaraan = $getKendaraan->KENDARAAN;
		if ($kendaraan == 'Gojek/Grab') {
			$data = 1;
		}else{
			$data = $this->M_Pengajuan->cekAdaDriver($inputNoSPJ)->num_rows();	
		}
		
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
		$mediaBBM = '';
		$totalBBM = 0;
		foreach ($getSPJ as $key) {
			$id = $key->ID_SPJ;
			$jenisSPJ = $key->NAMA_JENIS;
			$mediaBBM = $key->MEDIA_UANG_BBM;
			$totalBBM = $key->TOTAL_UANG_BBM;
		}
		$jenis = 'Kasbon SPJ '.$jenisSPJ;
		$getSaldo = $this->M_Cash_Flow->getSaldoPerJenisSubKas($jenis);
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

		if ($mediaBBM == 'Kasbon') {
			$jenisBBM = 'Kasbon BBM '.$jenisSPJ;
			$getSaldoBBM = $this->M_Cash_Flow->getSaldoPerJenisSubKas($jenisBBM);
			$saldoBBM = 0;
			foreach ($getSaldoBBM as $keyBBM) {
				$saldoBBM = $keyBBM->SALDO;
			}
			if ($status == 'NEW') {
				$totalSaldoBBM = $saldoBBM - $totalBBM;
				$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldoBBM, 'SUB KAS');
			}
			$this->M_Cash_Flow->saveSubKas($jenisBBM,'CREDIT', $totalBBM, 'KASBON', $id,'KASBON BBM');

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
			$data[] = array('id' =>$key['ID_KOTA'] , 'text' =>$key['VAL']);
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
	public function editSPJ_v2()
	{
		$id = $this->input->get("id");
		$noSPJ = $this->input->get("noSPJ");
		$tipe = $this->input->get("tipe");
		$data["noSPJ"] = $noSPJ;
		$data['idSPJ'] = $id;
		$getData = $this->db->query("SELECT JENIS_ID, TGL_SPJ, NO_TNKB, JENIS_KENDARAAN FROM SPJ_PENGAJUAN WHERE ID_SPJ = '$id'")->row();
		$jenisId = $getData->JENIS_ID;
		$data['jenisId'] = $jenisId;
		$data['tglSPJ'] = $getData->TGL_SPJ;
		$data['noTNKB'] = $getData->NO_TNKB;
		$data['jenisKendaraan'] = $getData->JENIS_KENDARAAN;
		if ($tipe == 'kendaraan') {
			$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
			$data['kendaraan'] = $this->M_Data_Master->getKategoriKendaraan()->result();
			$data['data']= $this->M_Monitoring->getSPJ('', '', '', '',$id,'','')->row();
			$data['rekanan'] = $this->M_Data_Master->getDataRekanan('')->result();
			$this->load->view("pengajuan/modal-edit/kendaraan", $data);
		}elseif ($tipe == 'tujuan') {
			$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
			$data['kota'] = $this->M_Data_Master->getKotaKabDis()->result();
			$this->load->view("pengajuan/modal-edit/tujuan", $data);
		}
	}
	public function updateKendaraanSPJ()
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
		if ($data == true) {
			$this->saveAutoTujuan($noSPJ, $tnkb);
		}
		$ketRekanan = $kendaraan =='Rental' ? " Rekanan = ".$inputRekananKendaraan:"";
		$aktivitas = "Update Data Kendaraan ".$kendaraan."".$ketRekanan." Dengan No TNKB = ".$tnkb ;
        $this->M_Monitoring->saveSPJLog('Update',$noSPJ,$aktivitas);
		echo json_encode($data);
	}
	public function saveAutoTujuan($inputNoSPJ, $inputNoTNKB)
	{
		$data = $this->M_Pengajuan->getDataSPJ_test($inputNoSPJ)->row();
		$inputTglSPJ = $data->TGL_SPJ;
		$inputJenisSPJ = $data->JENIS_ID;
		$inputJenisKendaraan = $data->JENIS_KENDARAAN;
		$whereDeparture = "";
		$this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$inputNoSPJ'");
		$getSerlok = $this->M_Serlok->getSPJByOutGoing2($inputNoTNKB, $inputTglSPJ, $whereDeparture);
		$idGroup = 0;
		foreach ($getSerlok->result() as $key) {
			$serlokID = $key->KPS_CUSTOMER_ID;
			$deliveryId = $key->ID;
			$serlokAlamat = $key->PLANT1_CITY;
			$serlokPerusahaan = $key->COMPANY_NAME;
			$serlokKota = $key->nama_kabkota;
			// $serlok = $this->M_Serlok->getCustomerByGroup($query="", $idSerlok, "")->result();
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

		$aktivitas = "Update Data Lokasi Mengambil Data Otomatis Berdasarkan Update Kendaraan No TNKB";
        $this->M_Monitoring->saveSPJLog('New',$inputNoSPJ,$aktivitas);
		$save = $this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $idGroup);
		if ($save == true) {
			$this->updateOtomatisUangSPJReload_v2($inputNoSPJ, $idGroup, $inputJenisSPJ, $inputJenisKendaraan);
		}
	}
	public function updateOtomatisUangSPJReload_v2($inputNoSPJ, $inputGroupTujuan, $inputJenisSPJ, $inputJenisKendaraan)
	{
		$getPIC = $this->db->query("SELECT
										ID_PIC,
										OBJEK,
										CASE 
											WHEN JENIS_PIC = 'Sopir' OR JENIS_PIC = 'Pendamping' THEN JENIS_PIC
											ELSE JABATAN
										END AS JENIS_PIC,
										TGL_SPJ,
										KENDARAAN
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
			$kendaraan = $key->KENDARAAN;
			$uang= $this->M_Pengajuan->hitungUangSaku($inputJenisSPJ, $objek, $pic, $inputGroupTujuan, $inputJenisKendaraan);
			if ($kendaraan == 'Rental' && $pic == 'Sopir' && $objek == 'Rental') {
				$biaya = 0;
			}else{
				foreach ($uang->result() as $key2) {
					$biaya = $key2->BIAYA;
				}
			}
			$save = $this->M_Pengajuan->saveOtomatisUangSPJ($id, $inputGroupTujuan, $biaya);
		}
		$this->updateOtomatisSubKas($inputNoSPJ);
	}
	public function updateOtomatisSubKas($noSPJ)
	{
		$data = $this->db->query("SELECT ID_SPJ, GROUP_ID, ABNORMAL, TAMBAHAN_UANG_JALAN, KENDARAAN, JENIS_KENDARAAN FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'")->row();
		$jmlAbnormal = $this->M_Pengajuan->getJmlLokasiBySPJ($noSPJ)->row();
		$kendaraan = $data->KENDARAAN;
		$jenisKendaraan = $data->JENIS_KENDARAAN;
		$idSPJ = $data->ID_SPJ;
		$getKasSub = $this->db->query("SELECT CREDIT FROM SPJ_KAS_SUB WHERE FK_ID = $idSPJ AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND JENIS_KASBON = 'Kasbon SPJ Delivery'")->row();
		$oldBiaya = $getKasSub->CREDIT;
		if ($jmlAbnormal->JML_LOKASI >4) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET ABNORMAL= 'N' WHERE NO_SPJ = '$noSPJ'");
			if ($kendaraan == 'Non Delivery' && $jenisKendaraan == 'Minibus') {
				$totalUangJalan = 0;	
			}else{
				$dataUangJalan = $this->M_Pengajuan->getUangJalanSPJ($noSPJ)->row();
				$totalUangJalan = $dataUangJalan->BIAYA;
			}
		}else{
			$this->db->query("UPDATE SPJ_PENGAJUAN SET ABNORMAL= 'Y' WHERE NO_SPJ = '$noSPJ'");
			$getBiayaAbnormal = $this->M_Pengajuan->getUangAbnormal($noSPJ)->row();
			$totalUangJalan = 0;
			$biayaAbnormal = $getBiayaAbnormal->BIAYA == null ? 0 : $getBiayaAbnormal->BIAYA;
			// echo $biayaAbnormal;
			$tambahanUangJalan = $data->TAMBAHAN_UANG_JALAN == null ? 0 : $data->TAMBAHAN_UANG_JALAN;
			$totalUangJalan += $biayaAbnormal+$tambahanUangJalan;
		}
		$totalUangSaku = 0;
		$totalUangMakan = 0;
		$getRumsum = $this->M_Pengajuan->getSUMUangRumsum($noSPJ)->row();
		$totalUangSaku += $getRumsum->TOTAL_UANG_SAKU;
		$totalUangMakan += $getRumsum->TOTAL_UANG_MAKAN;
		// echo $oldBiaya.'<br>'.$saldoSubKas.'<br>'.$endSaldo;
		// echo 'Total Uang Saku = '.$totalUangSaku;
		// echo '<br>Total Uang Makan = '.$totalUangMakan;
		// echo '<br>Total Jalan = '.$totalUangJalan;
		$totalBiaya = $totalUangJalan + $totalUangSaku + $totalUangMakan;
		
		// echo '<br>Total Biaya = '.$totalBiaya;
		$this->db->query("UPDATE SPJ_KAS_SUB SET CREDIT=$totalBiaya WHERE FK_ID = $idSPJ AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND JENIS_KASBON = 'Kasbon SPJ Delivery'");
		$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_SAKU = $totalUangSaku, TOTAL_UANG_MAKAN = $totalUangMakan, TOTAL_UANG_JALAN = $totalUangJalan WHERE ID_SPJ = $idSPJ");
		$getSaldo = $this->db->query("SELECT JUMLAH FROM SPJ_SALDO WHERE JENIS_SALDO = 'Kasbon SPJ Delivery' AND JENIS_KAS = 'SUB KAS'")->row();
		$saldoSubKas = $getSaldo->JUMLAH;
		if ($oldBiaya>$totalBiaya) {
			$test = $oldBiaya-$totalBiaya;
			$endSaldo = $saldoSubKas + $test;	
		}elseif ($totalBiaya>$oldBiaya) {
			$test = $totalBiaya-$oldBiaya;
			$endSaldo = $saldoSubKas-$test;
		}else{
			$endSaldo = $saldoSubKas;
			$test = 0;
		}
		

		$this->db->query("UPDATE SPJ_SALDO SET JUMLAH = $endSaldo WHERE ID = 7");
		// echo $oldBiaya.'<br>'.$saldoSubKas.'<br>'.$endSaldo;
		// echo 'Saldo Sub Kas = '.$saldoSubKas;
		// echo '<br>Old Biaya = '.$oldBiaya;
		// echo '<br>Total Biaya = '.$totalBiaya;
		// echo '<br>Test Biaya = '.$test;
		// echo '<br>End Saldo = '.$endSaldo;
	}
	public function saveCustomerSerlokNewPola()
	{
		$idDelivery = $this->input->post("idDelivery");
		$inputNoTNKB = $this->input->post("inputNoTNKB");
		$inputTglSPJ = $this->input->post("inputTglSPJ");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputJenisSPJ = $this->input->post("inputJenisSPJ");
		$inputJenisKendaraan = $this->input->post("inputJenisKendaraan");
		$proses = $this->input->post("proses");
		$where = "AND d.kps_customer_delivery_setup IN (";
		
		for ($i=0; $i <count($idDelivery) ; $i++) { 
			$where .= $i == 0 ? '':", ";
			$where.=$idDelivery[$i];
		}
		$where.=")";

		$getSerlok = $this->M_Serlok->getSPJByOutGoing2($inputNoTNKB, $inputTglSPJ, $where);
		$idGroup = 0;
		$this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$inputNoSPJ'");
		foreach ($getSerlok->result() as $key) {
			$serlokID = $key->KPS_CUSTOMER_ID;
			$deliveryId = $key->ID;
			$serlokAlamat = $key->PLANT1_CITY;
			$serlokPerusahaan = $key->COMPANY_NAME;
			$serlokKota = $key->nama_kabkota;
			$kota = substr($serlokKota, 0, 5) == 'KOTA ' ? substr($serlokKota, 5):$serlokKota;
			$group = $this->M_Pengajuan->findGroupTujuan($kota);
			$data = $this->M_Pengajuan->saveLokasiTujuan($group, 'Customer', $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota, $deliveryId);
			$idGroup = $group>=$idGroup ? $group : $idGroup;
		}
		$save = $this->M_Pengajuan->saveGroupTujuanSPJ($inputNoSPJ, $idGroup);
		$aktivitas = $proses." Data Lokasi Mengambil Data Otomatis Berdasarkan Outgoing Serlok";
        $this->M_Monitoring->saveSPJLog($proses,$inputNoSPJ,$aktivitas);
		
		if ($save == true && $proses == 'Edit') {
			$this->updateOtomatisUangSPJReload_v2($inputNoSPJ, $idGroup, $inputJenisSPJ, $inputJenisKendaraan);
		}
		echo json_encode($data);

	}
	public function draft()
	{
		$data['side'] = 'pengajuan-draft';
		$data['page'] = 'Draft Pengajuan SPJ Non Delivery';
		$this->load->view("pengajuan/draft/index", $data);
	}
	public function getTabelDrafSPJ()
	{
		$filSearch = $this->input->get("filSearch");
		$jenis = "2";
		$level = $this->session->userdata("LEVEL");
		$nik = $this->session->userdata("NIK");
		if ($level >1) {
			$where = " AND a.PIC_INPUT = '$nik'";
		}else{
			$where = '';
		}
		$data['data'] = $this->M_Pengajuan->getPengajuanDraft($filSearch, $jenis, $where)->result();
		$this->load->view("pengajuan/draft/tabel", $data);
	}
	public function approveSPJDraft()
	{
		$noSPJ = $this->input->post("inputNoSPJ");
		$total = $this->input->post("total");
		$id = $this->input->post("id");
		$bbm = $this->input->post("bbm");
		$mediaBBM = $this->input->post("mediaBBM");
		$data = $this->M_Pengajuan->approveSPJDraft($noSPJ);
		if ($data == true) {
			$this->M_Monitoring->saveSPJLog('New',$noSPJ,"Approve SPJ Draft Non Delivery");
			$this->updateKasDraftNonDelivery($id, $total, $bbm, $mediaBBM);
		}
		echo json_encode($data);
	}
	public function updateKasDraftNonDelivery($id, $total, $bbm, $mediaBBM)
	{
		$getSaldo = $this->db->query("SELECT JUMLAH FROM SPJ_SALDO WHERE JENIS_SALDO = 'Kasbon SPJ Non Delivery' AND JENIS_KAS = 'SUB KAS'")->row();
		$saldo = $getSaldo->JUMLAH;
		$jenis = 'Kasbon SPJ Non Delivery';
		$totalSaldo = $saldo - $total;
		$this->M_Cash_Flow->updateSaldo($jenis, $totalSaldo, 'SUB KAS');
		$this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $total, 'KASBON', $id,'TRANSAKSI AWAL');
		if ($mediaBBM == 'Kasbon') {
			$jenisBBM = 'Kasbon BBM Non Delivery';
			$getSaldoBBM = $this->M_Cash_Flow->getSaldoPerJenisSubKas($jenisBBM)->row();
			$saldoBBM = $getSaldoBBM->SALDO;
			$totalSaldoBBM = $saldoBBM - $bbm;
			$this->M_Cash_Flow->updateSaldo($jenisBBM, $totalSaldoBBM, 'SUB KAS');
			$this->M_Cash_Flow->saveSubKas($jenisBBM,'CREDIT', $bbm, 'KASBON', $id,'KASBON BBM');
			// $this->M_Cash_Flow->updateSaldo('Kasbon BBM Non Delivery', $totalSaldo, 'SUB KAS');
			// $this->M_Cash_Flow->saveSubKas($jenis,'CREDIT', $total, 'KASBON', $id,'TRANSAKSI AWAL');
			
		}
	}
	public function findGroupTujuanByIdKota()
	{
		$id = $this->input->get('id');
		$where = " WHERE a.ID_KOTA = $id";
		$data = $this->M_Pengajuan->getKotaByGroup($where)->row();
		$group = $data->ID_GROUP;
		echo json_encode($group);
	}
	public function saveAutoBiayaKendaraan()
	{
		$inputBiayaKendaraan = $this->input->post("inputBiayaKendaraan") == 'NaN' ? 0 :$this->input->post("inputBiayaKendaraan");
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputKendaraan = $this->input->post("inputKendaraan");
		if ($inputKendaraan == 'Gojek/Grab') {
			$biaya = $inputBiayaKendaraan;
		}else{
			$biaya = 0;
		}
		$data = $this->M_Pengajuan->saveAutoBiayaKendaraan($inputNoSPJ, $biaya);
		echo json_encode($data);
	}
	public function cancelSPJ()
	{
		$id = $this->input->post("id");
		$data = $this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = 'CANCEL' WHERE ID_SPJ = $id");
		echo json_encode($data);
	}
}
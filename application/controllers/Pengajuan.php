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
		$data['tujuan'] = $this->M_Monitoring->getTujuanByNoSPJ($filBulan='', $filTahun='', $filJenis='', $filSearch='', $id)->result();
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
		$namaFile = str_replace('/', '', $inputNoSPJ);
		$data = $this->M_Pengajuan->saveTemporaryPengajuan($inputJenisSPJ, $inputNoSPJ, $namaFile, $inputTglSPJ);
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
		$data['data'] = $this->M_Pengajuan->getListKendaraan($inputJenisKendaraan, $inputKendaraan)->result();
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
		$customer = $this->input->post("customer");
		$jmlCustomer = count($customer);
		for ($i=0; $i <$jmlCustomer ; $i++) { 
			$serlok = $this->M_Serlok->getCustomerByGroup($query="", $customer[$i])->result();
			$serlokKota = '';
			foreach ($serlok as $key) {
				$serlokID = $key->id;
				$serlokAlamat = $key->ALAMAT_LENGKAP_PLANT;
				$serlokPerusahaan = $key->COMPANY_NAME;
				$serlokKota = $key->nama_kabkota;
			}
			$kota = substr($serlokKota, 0, 5) == 'KOTA ' ? substr($serlokKota, 5):$serlokKota;
			$group = $this->M_Pengajuan->findGroupTujuan($kota);
			$data = $this->M_Pengajuan->saveLokasiTujuan($group, 'Customer', $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota);
		}
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
			$serlokKota = $key->nama_kabkota;
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

		$serlok = $this->M_Serlok->getCustomerByGroup($query='', $inputPerusahaan)->result();
		$serlokID = '';
		$serlokAlamat = '';
		$serlokPerusahaan = '';
		$serlokKota = '';
		foreach ($serlok as $key) {
			$serlokID = $key->id;
			$serlokAlamat = $key->ALAMAT_LENGKAP_PLANT;
			$serlokPerusahaan = $key->COMPANY_NAME;
			$serlokKota = $key->nama_kabkota;
		}

		$data = $this->M_Pengajuan->saveLokasiTujuan($inputGroupTujuan, $inputObjek, $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota);
		echo json_encode($data);

	}
	public function cekOutGoingSerlok()
	{
		$inputNoTNKB = $this->input->get("inputNoTNKB");
		$inputTglSPJ = $this->input->get("inputTglSPJ");
		$data = $this->M_Serlok->getSPJByOutGoing($inputNoTNKB, $inputTglSPJ)->result();
		echo json_encode($data);
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
										END AS JENIS_PIC
									FROM
										SPJ_PENGAJUAN_PIC
									WHERE
										NO_PENGAJUAN= '$inputNoSPJ'
									AND UANG_SAKU > 0");
		foreach ($getPIC->result() as $key) {
			$objek = $key->OBJEK;
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
		$data['data'] = $this->M_Pengajuan->getLokasi($inputGroupTujuan, $inputNoSPJ)->result();
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

		$data = $this->M_Pengajuan->getPIC($inputSubjek, $jabatan, $where, $inputNoSPJ, $where2, $whereJenis)->result();
		echo json_encode($data);
	}
	public function hitungUangSaku()
	{
		$anjing = $this->input->get("inputJenisSPJ"); 
		$inputSubjek = $this->input->get("inputSubjek"); 
		$inputPIC = $this->input->get("jabatanPIC"); 
		$inputGroupTujuan = $this->input->get("inputGroupTujuan"); 
		$inputJenisKendaraan = $this->input->get("inputJenisKendaraan");
		$nik = $this->input->get("nik");
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
        $cekPIC = $this->M_Pengajuan->cekPICUangSaku($inputTglSPJ, $nik);
        
        if ($cekPIC->num_rows()>0) {
        	$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini');

    //     	foreach ($cekPIC->result() as $pic) {
    //     		$jam2 += $pic->DIFF_HOUR;	
    //     	}

    //     	$totalJam = $jam+$jam2;
    //     	if ($totalJam<=14) {
    //     		$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini');
    //     	}else{
    //     		$data = $this->M_Pengajuan->hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan);
			
				// if ($data->num_rows()>0) {
				// 	foreach ($data->result() as $key) {
				// 		$hasil = array('BIAYA' => $key->BIAYA,'KET'=>'Tersedia' );				
				// 	}
				// } else {
				// 	$hasil = array('BIAYA' => 0, 'KET'=>'Belum Terdaftar Di Data Master');
				// }
    //     	}

        } else {
        	$data = $this->M_Pengajuan->hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan);
			
			if ($data->num_rows()>0) {
				foreach ($data->result() as $key) {
					$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'Tersedia');				
				}
			} else {
				$hasil = array('BIAYA' => 0, 'KET'=>'Belum Terdaftar Di Data Master');
			}
        }
        
		
		
		echo json_encode($hasil);
	}
	public function hitungUangMakan()
	{
		$inputJenisSPJ = $this->input->get("inputJenisSPJ");
		$inputGroupTujuan = $this->input->get("inputGroupTujuan"); 
		$jenisTujuan = $inputGroupTujuan == 4?'Lokal':'Luar Kota';
		$inputPIC = $this->input->post("inputPIC");
		$inputTglSPJ = $this->input->post("inputTglSPJ");
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
        
        if ($cekPIC->num_rows()>0) {
        	$hasil = array('BIAYA' => 0,'KET'=>'PIC Telah Melakukan Perjalanan Dinas Di Hari Ini');
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
        	$data = $this->M_Pengajuan->hitungUangMakan($inputJenisSPJ, $jenisTujuan);
			
			if ($data->num_rows()>0) {
				foreach ($data->result() as $key) {
					$hasil = array('BIAYA' => $key->BIAYA, 'KET'=>'Tersedia');				
				}
			} else {
				$hasil = array('BIAYA' => 0, 'KET'=>'Belum Terdaftar Di Data Master');
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
		$data = $this->M_Pengajuan->saveKendaraanSPJ($inv, $jenis, $noSPJ, $tnkb, $merk, $tipe, $kendaraan);
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
		$data = $this->M_Pengajuan->hapusLokasi($id);
		echo json_encode($data);
	}
	public function hapusPIC()
	{
		$id = $this->input->post("id");
		$data = $this->M_Pengajuan->hapusPIC($id);
		echo json_encode($data);
	}
	public function saveSPJ()
	{
		$data= $this->M_Pengajuan->saveSPJ();
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$cek = $this->db->query("SELECT ID_PIC FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$inputNoSPJ' AND JENIS_PIC = 'Manajemen'");
		if ($cek->num_rows()>0) {
			$this->M_Pengajuan->savePICManajemen($inputNoSPJ);	
		}
		$this->M_Pengajuan->saveKasbon();
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
		$sql = $this->M_Data_Master->getDataVoucher('2',$cari,'');
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
		$data = $this->M_Data_Master->getDataVoucher('2','',$id)->row();
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


}
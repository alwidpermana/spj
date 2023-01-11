<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Master extends CI_Controller {
	function __construct(){
		parent::__construct();
		// $this->load->model('M_Login');
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
	public function User_Login()
	{
		$data['side'] = 'data_master-login';
		$data['page'] = 'Master Data User Login';
		$data['departement'] = $this->M_Data_Master->getDepartement($kode='')->result();
		$data['jabatan'] = $this->M_Data_Master->getJabatan()->result();
		$this->load->view('Data_Master/user_login/index', $data);
	}
	public function getTabelUserLogin()
	{
		$filSearch = $this->input->post("filSearch");
		$data['data'] = $this->M_Data_Master->getDataUserLogin($filSearch)->result();
		$this->load->view('Data_Master/user_login/tabel', $data);
	}
	public function getKaryawanAdmin()
	{
		$cari = $this->input->post("cari");
		$sql = $this->M_Data_Master->getKaryawanAdmin($cari);
		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['nik'] , 'text' =>$key['nik'].' - '.$key['namapeg']);
		}
		echo json_encode($data);
	}
	public function tambahAkun()
	{
		$nik = $this->input->post("nik");
		$data = $this->M_Data_Master->tambahAkun($nik);
		echo json_encode($data);
	}
	public function ubahStatusAkun()
	{
		$nik = $this->input->post("nik");
		$status = $this->input->post("status");
		$data = $this->M_Data_Master->ubahStatusAkun($nik, $status);
		echo json_encode($data);
	}
	public function ubahLevelAkun()
	{
		$nik = $this->input->post("nik");
		$level = $this->input->post("level");
		$data = $this->M_Data_Master->ubahLevelAkun($nik, $level);
		echo json_encode($data);
	}
	public function Karyawan_Internal()
	{
		$data['page'] = 'Master Data - Karyawan';
		$data['side'] = 'data_master-karyawan_internal';
		$data['departemen'] = $this->M_Data_Master->getDepartement($kode='')->result();
		$data['jabatan'] = $this->M_Data_Master->getJabatan()->result();
		$this->load->view("Data_Master/Karyawan/index", $data);
	}
	public function getTabelKaryawan()
	{
		$filDepartemen = $this->input->get("filDepartemen");
		$filJabatan = $this->input->get("filJabatan");
		$filSearch = $this->input->get("filSearch");
		$jenis = $this->input->get("jenis");
		$data['jenis'] = $jenis;
		$top = 100;
		$nik = '';

		$data['data'] = $this->M_Data_Master->getKaryawan($filDepartemen, $filJabatan, $filSearch, $nik, $top)->result();
		$this->load->view("Data_Master/Karyawan/tabel", $data);
	}
	public function Edit_Karyawan($nik, $jenis)
	{
		$data['page'] = 'Form Edit Data Karyawan';
		$data['rekanan'] = $this->M_Data_Master->getDataRekanan('')->result();
		if ($jenis == 'internal') {
			$data['data'] = $this->M_Data_Master->getKaryawan($filDepartemen='', $filJabatan='', $filSearch='', $nik, $top = 1)->result();
			$data['side'] = 'data_master-karyawan_internal';
		}elseif ($jenis == 'logistik') {
			$data['data'] = $this->M_Data_Master->getSupirLogistik($filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirLogistik')->result();
			$data['side'] = 'data_master-karyawan_logistik';
		}else{
			$data['data'] = $this->M_Data_Master->getSupirLogistik($filStatus='', $filSearch='', $nik, $top = 1, $table = 'TrTs_SopirRental')->result();
			$data['side'] = 'data_master-karyawan_rental';
		}
		
		$this->load->view("Data_Master/Karyawan/form_edit", $data);
	}
	public function uploadWajah()
	{
		$nik = $this->input->post("inputNIK");
		$data = $this->input->post("image");
		$field = $this->input->post("field");
 		$folder = $this->input->post("folder");
 		$jenis = $this->input->post("jenis");
         $image_array_1 = explode(";", $data);
 
         $image_array_2 = explode(",", $image_array_1[1]);
 
         $data = base64_decode($image_array_2[1]);
 
         $imageName = time() .'-'.$nik. '.png';
 
         file_put_contents('assets/image/'.$folder.'/'.$imageName, $data);
         $save = $this->M_Data_Master->saveFoto($imageName, $nik, $field, $folder, $jenis);
     	echo json_encode($save);
	}
	public function saveDataOtoritasKaryawan()
	{
		$isi = $this->input->post("isi");
		$field = $this->input->post("field");
		$nik = $this->input->post("nik");
		$jenis = $this->input->post("jenis");
		$data = $this->M_Data_Master->saveDataOtoritasKaryawan($isi, $field, $nik, $jenis);
		echo json_encode($data);
	}
	public function saveDataOtoritasKaryawan2()
	{
		$nik = $this->input->post("nik");
		$jenis = $this->input->post("jenis");
		$isiDriver = $this->input->post("isiDriver");
		$inputSubjek = $this->input->post("inputSubjek");
		$isiPendamping = $this->input->post("isiPendamping"); 
		$isiUangMakan = $this->input->post("isiUangMakan"); 
		$isiUangSaku = $this->input->post("isiUangSaku"); 
		$isiAdj = $this->input->post("isiAdj");
		$data = $this->M_Data_Master->saveDataOtoritasKaryawan2($nik, $jenis, $isiDriver, $inputSubjek, $isiPendamping, $isiUangMakan, $isiUangSaku, $isiAdj);
		echo json_encode($data);
	}
	public function getDataFotoKaryawan()
	{
		$field = $this->input->get("field");
		$nik = $this->input->get("nik");
		$folder = $this->input->get("folder");
		$sql = $this->db->query("SELECT $field FROM SPJ_PEGAWAI_OTORITAS WHERE NIK = '$nik'");
		$gambar = '';
		foreach ($sql->result() as $key) {
			$gambar = $key->$field;
		}
		$data['field'] = $field;
		$data['gambar'] = $gambar;
		$data['folder'] = $folder;
		$this->load->view("Data_Master/Karyawan/gambar.php", $data);
	}
	public function Supir_Logistik()
	{
		$data['side'] = 'data_master-karyawan_logistik';
		$data['page'] = 'Master Data - Logistik Sopir & Kenek';
		$this->load->view("Data_Master/Karyawan/index_supir", $data);
	}
	public function tabelLogistik()
	{
		$filStatus = $this->input->get("filStatus");
		$filSearch = $this->input->get("filSearch");
		$data['data'] = $this->M_Data_Master->getSupirLogistik($filStatus, $filSearch, $nik = '', $top = 1000, $table = 'TrTs_SopirLogistik')->result();
		$jenis = $this->input->get("jenis");
		$data['jenis'] = $jenis;
		$this->load->view("Data_Master/Karyawan/tabel", $data);
	}
	public function Supir_Rental()
	{
		$data['side'] = 'data_master-karyawan_rental';
		$data['page'] = 'Master Data - Rental Sopir & Kenek';
		$this->load->view("Data_Master/Karyawan/index_rental", $data);
	}
	public function tabelRental()
	{
		$filStatus = $this->input->get("filStatus");
		$filSearch = $this->input->get("filSearch");
		$jenis = $this->input->get("jenis");
		$data['jenis'] = $jenis;
		$data['data'] = $this->M_Data_Master->getSupirLogistik($filStatus, $filSearch, $nik = '', $top = 1000, $table = 'TrTs_SopirRental')->result();
		$this->load->view("Data_Master/Karyawan/tabel", $data);
	}
	public function Kendaraan()
	{
		$data['page'] = 'Master Data - Kendaraan';
		$data['side'] = 'data_master-kendaraan-internal';
		$data['jenis'] = $this->M_Data_Master->getFilterJenisKendaraan()->result();
		$data['Merk'] = $this->M_Data_Master->getFilterMerkKendaraan()->result();
		$this->load->view("Data_Master/Kendaraan/index", $data);
	}
	public function getTabelKendaraan()
	{
		$filMerk = $this->input->get("filMerk");
		$filKendaraan = $this->input->get("filKendaraan");
		$filBahan = $this->input->get("filBahan");
		$filJenis = $this->input->get("filJenis");
		$filSearch = $this->input->get("filSearch");
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['data'] = $this->M_Data_Master->getKendaraan($filMerk, $filKendaraan, $filBahan, $filSearch, $filJenis)->result();
		$this->load->view("Data_Master/Kendaraan/tabel", $data);
	}
	public function saveKendaraan()
	{
		$no = $this->input->post("no");
		$isi = $this->input->post("isi");
		$field = $this->input->post("field");
		$data = $this->M_Data_Master->saveKendaraan($no, $isi, $field);
		echo json_encode($data);
	}
	public function Gambar_Kendaraan($no)
	{
		$noTNKB = str_replace('_', ' ', $no);
		$data['side'] = 'data_master-kendaraan';
		$data['page'] = 'Master Data - Gambar Kendaraan';
		$data['data'] = '';
		$this->load->view("Data_Master/Kendaraan/galery", $data);
	}
	public function uploadKendaraan()
	{	
		// $data = $this->input->post("image");
		// $image_array_1 = explode(";", $data);
 
  //        $image_array_2 = explode(",", $image_array_1[1]);
 
  //        $data = base64_decode($image_array_2[1]);
 
  //        $imageName = time() . '.png';
 
  //        file_put_contents('assets/image/foto-kendaraan/'.$imageName, $data);
		$config['upload_path']="./assets/image/foto-kendaraan";
        $config['allowed_types']='gif|jpg|png|jpeg|application/pdf|pdf';
        $config['encrypt_name'] = TRUE;
        $fileName = '';
        $this->load->library('upload',$config);
	    if($this->upload->do_upload("inputFile")){
	        $data = $this->upload->data();

	        //Resize and Compress Image
            // $config['image_library']='gd2';
            $config['source_image']='./assets/image/foto-kendaraan/'.$data['file_name'];
            // $config['create_thumb']= FALSE;
            $config['maintain_ratio']= FALSE;
            // $config['quality']= '60%';
            // $config['width']= 1024;
            $config['max_size']     = '1500';
        		
            // $config['height']= 768;
            // $config['new_image']= './assets/dokumen/kecelakaan-kerja/'.$data['file_name'];
            $this->load->library('image_lib', $config);
            // $this->image_lib->resize();
            $fileName= $data['file_name'];
	    }
        $save = $this->M_Data_Master->saveFotoKendaraan($fileName);
     	echo json_encode($save);
	}
	public function getGaleriKendaraan()
	{
		$noTNKB = $this->input->get("noTNBK");
		$no = str_replace('_', ' ', $noTNKB);
		$data['data'] = $this->M_Data_Master->getGaleriKendaraan($no)->result();
		$this->load->view("Data_Master/Kendaraan/showGaleri", $data);
	}
	public function updateStarKendaraan()
	{
		$id = $this->input->post("id");
		$noTNKB = $this->input->post("noTNBK");
		$no = str_replace('_', ' ', $noTNKB);
		$data= $this->M_Data_Master->updateStarKendaraan($id, $no);
		echo json_encode($data);
	}
	public function hapusGambarKendaraan()
	{
		$id = $this->input->get("id");
		$data = $this->M_Data_Master->hapusGambarKendaraan($id);
		echo json_encode($data);
	}
	public function group_jalur()
	{
		$data['side'] = 'data_master-jalur';
		$data['page'] = 'Master Data Group Jalur';
		$this->load->view('Data_Master/group_jalur/index', $data);
	}
	public function getKotaNoGroupJalur()
	{
		$cari = $this->input->get("filSearch");
		$data['data'] = $this->M_Data_Master->getKotaNonGroup($cari)->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$this->load->view("Data_Master/group_jalur/kota", $data);
	}
	public function getGroupJalur()
	{
		$data['data'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['isi'] = $this->M_Data_Master->getGroupJalur($id=0)->result();
		$this->load->view("Data_Master/group_jalur/group", $data);	
	}
	public function tambahGroupJalur()
	{
		$inputNamaGroup = $this->input->post("inputNamaGroup");
		$data = $this->M_Data_Master->tambahGroupJalur($inputNamaGroup);
		echo json_encode($data);
	}
	public function updateGroupJalur()
	{
		$editNamaJalur = $this->input->post("editNamaJalur");
		$editIdJalur = $this->input->post("editIdJalur");
		$data = $this->M_Data_Master->updateGroupJalur($editNamaJalur, $editIdJalur);
		echo json_encode($data);
	}
	public function gantiGroupJalur()
	{
		$kota = $this->input->post("kota");
		$group = $this->input->post("group");
		$data = $this->M_Data_Master->gantiGroupJalur($kota, $group);
		echo json_encode($data);
	}
	public function getKotaAPI()
	{
		$cari = $this->input->post("cari");
		$sql = $this->M_Data_Master->getKota($cari, $top = 20);
		$item = $sql->result_array();
		$data = array();
		foreach ($item as $key) {
			$data[] = array('id' =>$key['ID_KOTA'] , 'text' =>$key['VAL']);
		}
		echo json_encode($data);
	}
	public function apiJabatan()
	{
		$data = $this->M_Data_Master->getJabatan()->result();
		echo json_encode($data);
	}
	public function Konfigurasi()
	{
		$data['side'] = 'data_master-konfigurasi';
		$data['page'] = 'Konfigurasi';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$data['jabatan'] = $this->M_Data_Master->getJabatan()->result();
		$data['kendaraan'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['provinsi'] = $this->M_Data_Master->getProvinsi()->result();
		$data['tambahan'] = $this->M_Data_Master->viewTambahanUangSaku($where='')->result();
		$data['limit'] = $this->M_Data_Master->getLimitSaldo('')->result();
		$this->load->view("Data_Master/Konfigurasi/index", $data);
	}
	public function getJenisSPJ()
	{
		$this->load->view("Data_Master/Konfigurasi/jenisSPJ");
	}
	public function getJumlahPendamping()
	{

		$data['data'] = $this->M_Data_Master->getJumlahPendamping()->result();
		$this->load->view("Data_Master/Konfigurasi/jumlah_pendamping", $data);
	}
	public function saveJumlahPendamping()
	{
		$inputObjek = $this->input->post("inputObjek");
		$inputJenisKendaraan = $this->input->post("inputJenisKendaraan");
		$inputQtyLokal = $this->input->post("inputQtyLokal") == ''?0:$this->input->post("inputQtyLokal");
		$inputQtyLuarKota = $this->input->post("inputQtyLuarKota")==''?0:$this->input->post("inputQtyLuarKota");
		// $data = $this->M_Data_Master->saveJumlahPendamping($inputObjek, $inputJenisKendaraan, $inputQtyLokal, $inputQtyLuarKota);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiJumlahPendamping($inputObjek, $inputJenisKendaraan, $inputQtyLokal, $inputQtyLuarKota);
		echo json_encode($data);
	}
	public function getUangJalan()
	{
		$data['data'] = $this->M_Data_Master->getUangJalan()->result();
		$this->load->view("Data_Master/Konfigurasi/uang_jalan", $data);
	}
	public function saveUangJalan()
	{
		$inputKategoriJalan = $this->input->post("inputKategoriJalan");
		$inputKotaJalan = $this->input->post("inputKotaJalan");
		$inputBiayaJalan = $this->input->post("inputBiayaJalan");
		// $data = $this->M_Data_Master->saveUangJalan($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiUangJalan($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan);
		echo json_encode($data);
	}
	public function getUangSaku()
	{
		$data['group'] = $this->M_Data_Master->getOnlyGroup($group='')->result();
		$data['data'] = $this->M_Data_Master->getBiayaUangSaku()->result();
		$data['new'] = $this->M_Data_Master->uangSakuDelivery()->result();
		$data['non'] = $this->M_Data_Master->uangSakuNonDelivery()->result();
		$this->load->view("Data_Master/Konfigurasi/uang_saku", $data);
	}
	public function saveUangSaku()
	{
		$inputJenisSPJ = $this->input->post("inputJenisSPJ"); 
		$inputPIC = $this->input->post("inputPIC"); 
		$inputJKendaraan = $inputJenisSPJ == '1'?$this->input->post("inputJKendaraan"):''; 
		$inputGroupTujuan = $this->input->post("inputGroupTujuan"); 
		$inputBiayaRental = $this->input->post("inputBiayaRental"); 
		$inputBiayaInternal = $this->input->post("inputBiayaInternal");
		$value = [$inputJenisSPJ, $inputPIC, $inputJKendaraan, $inputGroupTujuan, $inputBiayaRental, $inputBiayaInternal];
		// $data = $this->M_Data_Master->saveUangSaku($value);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiUangSaku($value);
		echo json_encode($data);
	}
	public function saveUangSakuNew()
	{
		$biaya= $this->input->post("biaya"); 
		$field= $this->input->post("field"); 
		$jenisSPJ= $this->input->post("jenisSPJ"); 
		$pic= $this->input->post("pic"); 
		$jenisKendaraan= $this->input->post("jenisKendaraan"); 
		$idGroup= $this->input->post("idGroup");
		// $data = $this->M_Data_Master->saveUangSakuNew($biaya, $field, $jenisSPJ, $pic, $jenisKendaraan, $idGroup);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiUangSaku($biaya, $field, $jenisSPJ, $pic, $jenisKendaraan, $idGroup);
		echo json_encode($data);
	}
	public function hapusUangSaku()
	{
		$id = $this->input->post("id");
		$data= $this->M_Data_Master->hapusUangSaku($id);
		echo json_encode($data);
	}
	public function getKota()
	{
		$data['data'] = $this->M_Data_Master->getKota($cari='', $top = 1000)->result();
		$this->load->view("Data_Master/Konfigurasi/kota", $data);
	}
	public function saveKota()
	{
		$inputTipeDaerah = $this->input->post("inputTipeDaerah");
		$inputNamaDaerah = $this->input->post("inputNamaDaerah");
		$inputProvinsi = $this->input->post("inputProvinsi");
		$data = $this->M_Data_Master->saveKota($inputTipeDaerah, $inputNamaDaerah, $inputProvinsi);
		echo json_encode($data);
	}
	public function getListGroupJalur()
	{
		$id = $this->input->get("id");
		$data = $this->M_Data_Master->getGroupJalur($id)->result();
		echo json_encode($data);
	}
	public function getUangMakan()
	{
		$data['data'] = $this->M_Data_Master->getUangMakan()->result();
		$this->load->view("Data_Master/Konfigurasi/uang_makan", $data);
	}
	public function saveUangMakan()
	{
		$isi = $this->input->post("isi");
		$jenis = $this->input->post("jenis");
		$grup = $this->input->post("grup");
		$ke = $this->input->post("ke");
		// $data = $this->M_Data_Master->saveUangMakan($isi, $jenis, $grup, $ke);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiUangMakan($isi, $jenis, $grup, $ke);
		echo json_encode($data);
	}
	public function Verifikasi_Karyawan()
	{
		$data['side'] = 'data_master-karyawan_approve';
		$data['page'] = 'Verifikasi Otoritas Karyawan';
		$data['departemen'] = $this->M_Data_Master->getDepartement($kode='')->result();
		$data['jabatan'] = $this->M_Data_Master->getJabatan()->result();
		$this->load->view("Data_Master/Karyawan/Approve/index", $data);
	}
	public function getTabelApproveKaryawan()
	{
		$filDepartemen = $this->input->get("filDepartemen");
		$filJabatan = $this->input->get("filJabatan");
		$filSearch = $this->input->get("filSearch");
		$filStatus = $this->input->get("filStatus");
		if ($filStatus == '') {
			$status = '';
		}elseif($filStatus == 'OUTSTANDING'){
			$status = ' AND STATUS_VERIF IS NULL';
		}else{
			$status = " AND STATUS_VERIF = '$filStatus'";
		}
		$data['data'] = $this->M_Data_Master->getKaryawanOtoritasALL($filDepartemen, $filJabatan, $filSearch, $status)->result();
		$this->load->view("Data_Master/Karyawan/Approve/tabel", $data);
	}
	public function verifKaryawan()
	{
		$nik = $this->input->post("nik");
		$data = $this->input->post("data");
		$save = $this->M_Data_Master->verifKaryawan($nik, $data);
		echo json_encode($save);
	}
	public function getTabelGroup()
	{
		$group = $this->input->get("group");
		$data['data'] = $this->M_Data_Master->getGroupJalur($group)->result();
		$this->load->view("Data_Master/Konfigurasi/tabelGroup", $data);
	}
	public function voucher_bbm()
	{
		$data['side'] = 'data_master-voucher';
		$data['page'] = 'Master Data Voucher BBM';
		$data['romawi']= $this->M_Data_Master->getRomawi()->result();
		$this->load->view("Data_Master/voucher/index", $data);
	}
	public function getTabelVoucherBBM()
	{
		$filStatus = $this->input->get("filStatus");
		$filSearch = $this->input->get("filSearch");
		$filRomawi = $this->input->get("filRomawi");
		$filTahun = $this->input->get("filTahun");
		$offset = $this->input->get("offset")==''?0:$this->input->get("offset")+1;
		$limit = $this->input->get("limit");
		$where = " WHERE NO_URUT >= $offset AND NO_URUT < $offset + $limit";
		$data['data'] = $this->M_Data_Master->getDataVoucher($filStatus, $filSearch, $id='', $filRomawi, $filTahun, $where)->result();
		$this->load->view("Data_Master/voucher/tabel", $data);
	}
	public function getPagingVoucherBBM()
	{
		$filStatus = $this->input->get("filStatus");
		$filSearch = $this->input->get("filSearch");
		$filRomawi = $this->input->get("filRomawi");
		$filTahun = $this->input->get("filTahun");
		$offset = $this->input->get("offset");
		$limit = $this->input->get("limit");
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['data'] = $this->M_Data_Master->getDataVoucher($filStatus, $filSearch, $id='', $filRomawi, $filTahun,'')->num_rows();
		$this->load->view("_partial/paging", $data);
	}
	public function getNoVoucher()
	{
		// $data = $this->M_Data_Master->getNoVoucher();
		$data = $this->M_Data_Master->getNoVoucherNew()->row();
		echo json_encode($data);
	}
	public function saveVoucherBBM()
	{
		$inputKodeRomawi = $this->input->post("inputKodeRomawi");
		$inputDari = $this->input->post("inputDari");
		$inputSampai = $this->input->post("inputSampai");
		$data = $this->M_Data_Master->saveVoucherBBMNew($inputKodeRomawi, $inputDari, $inputSampai);
		echo json_encode($data);
	}
	public function hapusVoucherBBM()
	{
		$no = $this->input->post("noVoucher");
		$voucher_id = $this->input->post("voucher_id");
		$data = $this->M_Data_Master->hapusVoucherBBM($no, $voucher_id);
		echo json_encode($data);
	}
	public function saveTambahanUangSaku()
	{
		$id = $this->input->post("id");
		$qty = $this->input->post("qty");
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $getID = $this->db->query("SELECT TIPE, JENIS_ID FROM SPJ_US_TAMBAHAN WHERE ID = $id");
        foreach ($getID->result() as $key) {
        	$sql = $this->db->query("INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI, TGL_INPUT, PIC_INPUT,JENIS_ID, QTY_1, FIELD_ID)VALUES('SPJ_US_TAMBAHAN','$tanggal','$user','$key->JENIS_ID','$qty','$key->TIPE')");
        }
        
		// $sql = $this->db->query("UPDATE SPJ_US_TAMBAHAN SET QTY = $qty WHERE ID = $id");
		echo json_encode($sql);
	}
	public function getJamTambahan()
	{
		$data['data'] = $this->M_Data_Master->getJamTambahan()->result();
		$this->load->view("Data_Master/Konfigurasi/jam_tambahan", $data);
	}
	public function saveJamTambahan()
	{
		$jam = $this->input->post("jam");
		$field = $this->input->post("field");
		// $data = $this->M_Data_Master->saveJamTambahan($jam, $field);
		$data = $this->M_Data_Master->savePengajuanKonfigurasiJamTambahan($jam, $field);
		echo json_encode($data);
	}
	public function verifikasi_konfigurasi()
	{
		$data['side'] = 'data_master-verif_konfig';
		$data['page'] = 'Verifikasi Konfigurasi';
		$this->load->view("Data_Master/Konfigurasi/Verifikasi/index", $data);
	}
	public function getDataVerifikasiKonfigurasi()
	{
		$filStatus = $this->input->get("filStatus");
		$filJenis = $this->input->get("filJenis");
		$data['data']=$this->M_Data_Master->getVerifikasiKonfigurasi($filJenis, $filStatus)->result();
		$this->load->view("Data_Master/Konfigurasi/Verifikasi/data", $data);
	}
	public function approvedVerifikasiKonfigurasi()
	{
		$id = $this->input->post("id");
		$status = $this->input->post("status");
		if ($status == 'APPROVED') {
			$getData = $this->db->query("SELECT * FROM SPJ_VERIFIKASI_KONFIGURASI WHERE ID = $id")->result();
			foreach ($getData as $key) {
				if ($key->TABEL_KONFIGURASI == 'SPJ_JUMLAH_PENDAMPING') {
					$data = $this->M_Data_Master->saveJumlahPendamping($key->JENIS_ID, $key->JENIS, $key->QTY_1, $key->QTY_2);
				}elseif($key->TABEL_KONFIGURASI == 'SPJ_UANG_JALAN'){
					$data = $this->M_Data_Master->saveUangJalan($key->JENIS_ID, $key->FIELD_ID, $key->QTY_1);
				}elseif ($key->TABEL_KONFIGURASI == 'SPJ_UANG_MAKAN') {
					$data = $this->M_Data_Master->saveUangMakan($key->QTY_1, $key->JENIS_ID, $key->JENIS, $key->FIELD_ID);
				}elseif($key->TABEL_KONFIGURASI == 'SPJ_UANG_SAKU'){
					$biaya = $key->QTY_1 == null ? $key->QTY_2 : $key->QTY_1;
					$field = $key->QTY_1 == null ? 'BIAYA_RENTAL' : 'BIAYA_INTERNAL';
					$data = $this->M_Data_Master->saveUangSakuNew($biaya, $field, $key->JENIS_ID, $key->JENIS, $key->JENIS_2, $key->FIELD_ID);
				}elseif ($key->TABEL_KONFIGURASI == 'SPJ_US_TAMBAHAN') {
					$data = $this->db->query("UPDATE SPJ_US_TAMBAHAN SET QTY = $key->QTY_1 WHERE TIPE = $key->FIELD_ID AND JENIS_ID = $key->JENIS_ID");
				}elseif ($key->TABEL_KONFIGURASI == 'SPJ_JAM_TAMBAHAN') {
					$field = $key->QTY_1 == null?'JAM2':'JAM1';
					$jam = $key->QTY_1 == null?$key->QTY_2:$key->QTY_1;
					$data = $this->M_Data_Master->saveJamTambahan($jam, $field);
				}
			}
		}
		$data = $this->M_Data_Master->verifikasiKonfigurasi($id, $status);
		echo json_encode($data);
	}
	public function karyawan_adjustment()
	{
		$data['side'] = 'data_master-karyawan_adjustment';
		$data['page'] = 'Monitoring Karyawan Adjustment';
		$this->load->view("data_master/karyawan/adjustment/index", $data);
	}
	public function getTabelAdjustmentKaryawan()
	{
		$filSearch = $this->input->get("filSearch");
		$filAdjustment = $this->input->get("filAdjustment");
		$data['data'] = $this->M_Data_Master->getDataAdjustmentKaryawan($filSearch, $filAdjustment)->result();
		$this->load->view("Data_Master/karyawan/adjustment/tabel", $data);
	}
	public function saveOtoritasAdjustment()
	{
		$nik = $this->input->post("nik");
		$adjustment = $this->input->post("adjustment");
		$data = $this->M_Data_Master->saveOtoritasAdjustment($nik, $adjustment);
		echo json_encode($data);
	}
	public function kendaraan_rental()
	{
		$data['side'] = 'data_master-kendaraan-rental';
		$data['page'] = 'Data Master - Kendaraan Rental';
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$this->load->view("Data_Master/kendaraan/rental/index", $data);
	}
	public function getDataRekanan()
	{
		$filSearch = $this->input->get("filSearch");
		$jenis = $this->input->get('jenis');
		$data['jenis'] = $jenis;
		$data['data'] = $this->M_Data_Master->getDataRekanan($filSearch)->result();
		$this->load->view("data_master/kendaraan/rental/tabelRekanan", $data);
	}
	public function setKodeRekanan()
	{
		$data = $this->M_Data_Master->setKodeRekanan();
		echo json_encode($data);
	}
	public function saveRekanan()
	{
		$inputKode = $this->M_Data_Master->setKodeRekanan();
		$inputNama = $this->input->post("inputNama");
		$inputAlamat = $this->input->post("inputAlamat");
		$inputIdRekanan = $this->input->post("inputIdRekanan");
		$inputBerbadanHukum = $this->input->post("inputBerbadanHukum");
		$inputNPWP = $this->input->post("inputNPWP");
		if ($inputIdRekanan == '') {
			$data = $this->M_Data_Master->saveRekanan($inputKode, $inputNama, $inputAlamat, $inputBerbadanHukum, $inputNPWP);
		} else {
			$data = $this->M_Data_Master->updateRekanan($inputNama, $inputAlamat, $inputIdRekanan, $inputBerbadanHukum, $inputNPWP);
		}
		
		
		echo json_encode($data);
	}
	public function updateStatusRekanan()
	{
		$id = $this->input->post("id");
		$status= $this->input->post("status");
		$data = $this->M_Data_Master->updateStatusRekanan($id, $status);
		echo json_encode($data);
	}
	public function getKendaraanRekanan()
	{
		$id = $this->input->get("id");
		$data['data']= $this->M_Data_Master->getKendaraanRekanan($id)->result();
		$this->load->view("Data_Master/Kendaraan/rental/tabelKendaraan", $data);
	}
	public function saveKendaraanRental()
	{
		$inputRekananId= $this->input->post("inputRekananId");
		$inputIdKendaraan= $this->input->post("inputIdKendaraan");
		$inputNoTNKB= $this->input->post("inputNoTNKB");
		$inputMerk= $this->input->post("inputMerk");
		$inputType= $this->input->post("inputType");
		$inputJenis= $this->input->post("inputJenis");
		$inputWarna= $this->input->post("inputWarna");
		$inputBahanBakar= $this->input->post("inputBahanBakar");
		$inputLiter= $this->input->post("inputLiter");
		$inputTahun = $this->input->post("inputTahun");
		if ($inputIdKendaraan == '') {
			$data = $this->M_Data_Master->tambahKendaraanRental($inputRekananId, $inputNoTNKB, $inputMerk, $inputType, $inputJenis, $inputWarna, $inputBahanBakar, $inputLiter, $inputTahun);
		}else{
			$data = $this->M_Data_Master->updateKendaraanRental($inputIdKendaraan, $inputNoTNKB, $inputMerk, $inputType, $inputJenis, $inputWarna, $inputBahanBakar, $inputLiter, $inputTahun);
		}
		echo json_encode($data);
	}
	public function hapusKendaraanRental()
	{
		$id = $this->input->post("id");
		$data = $this->M_Data_Master->hapusKendaraanRental($id);
		echo json_encode($data);
	}
	public function verifikasi_kendaraan()
	{
		$data['side'] = 'data_master-kendaraan-verifikasi';
		$data['page'] = 'Data Master - Verifikasi Kendaraan';
		$data['jenis'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$this->load->view("Data_Master/Kendaraan/verifikasi", $data);
	}
	public function getTabelVerifikasiKendaraan()
	{
		$filSearch = $this->input->get("filSearch");
		$filKendaraan = $this->input->get("filKendaraan");
		$filJenis = $this->input->get("filJenis");
		$filData = $this->input->get("filData");
		$filStatus = $this->input->get("filStatus");
		if ($filStatus == '') {
			$status = '';
		}elseif($filStatus == 'OUTSTANDING'){
			$status = ' AND STATUS IS NULL';
		}else{
			$status = " AND STATUS = '$filStatus'";
		}
		$data['data'] = $this->M_Data_Master->getVerifikasiKendaraan($filSearch, $filKendaraan, $filJenis, $filData, $status)->result();
		$this->load->view("Data_Master/Kendaraan/tabel_verifikasi", $data);
	}
	public function verificationKendaraan()
	{
		$noTNKB = $this->input->post("noTNKB");
		$status = $this->input->post("status");
		$data = $this->M_Data_Master->verificationKendaraan($noTNKB, $status);
		echo json_encode($data);
	}
	public function checkDataKaryawan()
	{
		$isi = $this->input->post("isi");
		$nik = $this->input->post("nik");
		$field = $this->input->post("jenis");
		$data =$this->M_Data_Master->checkDataKaryawan($isi, $nik, $field);
		echo json_encode($data);
	}
	public function rekanan()
	{
		$data['side'] = 'data_master-rekanan';
		$data['page'] = 'Data Master Rekanan';
		$this->load->view("Data_Master/rekanan/index", $data);
	}
	public function tabelRekanan()
	{
		
	}
	public function biaya_abnormal()
	{
		$data['side'] = 'data_master-abnormal';
		$data['page'] = 'Data Master - Biaya Uang Jalan Abnormal';
		$this->load->view("Data_Master/abnormal/index", $data); 
	}
	public function getBiayaAbnormal()
	{
		$filSearch = $this->input->get("filSearch");
		$offset = $this->input->get("offset")==''?0:$this->input->get("offset")+1;
		$limit = $this->input->get("limit");
		$where = " WHERE NO_URUT >= $offset AND NO_URUT < $offset + $limit";
		$data['data'] = $this->M_Data_Master->getBiayaAbnormalNew($filSearch, $where)->result();
		$this->load->view("Data_Master/abnormal/tabel", $data);
	}
	public function getPaggingAbnormal()
	{
		$filSearch = $this->input->get("filSearch");
		$offset = $this->input->get("offset");
		$limit = $this->input->get("limit");
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['data'] = $this->M_Data_Master->getBiayaAbnormalNew($filSearch,'')->num_rows();
		$this->load->view("_partial/paging", $data);
	}
	public function saveBiayaAbnormal()
	{
		$inputBiaya = $this->input->post("inputBiaya");
		$inputSerlokID = $this->input->post("inputSerlokID");
		$inputKodeSerlok = $this->input->post("inputKodeSerlok");
		$inputDeliveryID = $this->input->post("inputDeliveryID");
		$data = $this->M_Data_Master->saveBiayaAbnormal($inputBiaya, $inputSerlokID, $inputKodeSerlok, $inputDeliveryID);
		echo json_encode($data);
	}
	public function saveOtoritasAkunSPJ()
	{
		$isi = $this->input->post("isi");
		$jenis = $this->input->post("jenis");
		$nik = $this->input->post("nik");
		$field = $jenis == 'DLV' ? 'OTORITAS_DLV' : 'OTORITAS_NDV';
		$data = $this->M_Data_Master->saveOtoritasAkunSPJ($isi, $nik, $field);
		echo json_encode($data);
	}
	public function saveLimitSaldo()
	{
		$isi = $this->input->post("isi");
		$jenis = $this->input->post("jenis");
		$field = $this->input->post("field");
		$data = $this->M_Data_Master->saveLimitSaldo($isi, $jenis, $field);
		echo json_encode($data);
	}



}

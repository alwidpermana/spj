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
		$data['departement'] = $this->M_Data_Master->getDepartement()->result();
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
         $image_array_1 = explode(";", $data);
 
         $image_array_2 = explode(",", $image_array_1[1]);
 
         $data = base64_decode($image_array_2[1]);
 
         $imageName = time() .'-'.$nik. '.png';
 
         file_put_contents('assets/image/'.$folder.'/'.$imageName, $data);
         $save = $this->M_Data_Master->saveFoto($imageName, $nik, $field, $folder);
     	echo json_encode($save);
	}
	public function saveDataOtoritasKaryawan()
	{
		$isi = $this->input->post("isi");
		$field = $this->input->post("field");
		$nik = $this->input->post("nik");
		$data = $this->M_Data_Master->saveDataOtoritasKaryawan($isi, $field, $nik);
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
		$data['page'] = 'Master Data - Supir Logistik';
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
		$data['page'] = 'Master Data - Supir Rental';
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
		$data['side'] = 'data_master-kendaraan';
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
		$data['data'] = $this->M_Data_Master->getKendaraan($filMerk, $filKendaraan, $filBahan, $filSearch)->result();
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
		$data = $this->input->post("image");
		$image_array_1 = explode(";", $data);
 
         $image_array_2 = explode(",", $image_array_1[1]);
 
         $data = base64_decode($image_array_2[1]);
 
         $imageName = time() . '.png';
 
         file_put_contents('assets/image/foto-kendaraan/'.$imageName, $data);
         $save = $this->M_Data_Master->saveFotoKendaraan($imageName);
     	echo json_encode($save);
	}
	public function getGaleriKendaraan()
	{
		$noTNKB = $this->input->get("noTNBK");
		$no = str_replace('_', ' ', $noTNKB);
		$data['data'] = $this->M_Data_Master->getGaleriKendaraan($no)->result();
		$this->load->view("Data_Master/Kendaraan/showGaleri", $data);
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
		$data['group'] = $this->M_Data_Master->getOnlyGroup()->result();
		$this->load->view("Data_Master/group_jalur/kota", $data);
	}
	public function getGroupJalur()
	{
		$data['data'] = $this->M_Data_Master->getOnlyGroup()->result();
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
	public function Konfigurasi()
	{
		$data['side'] = 'data_master-konfigurasi';
		$data['page'] = 'Konfigurasi';
		$data['spj'] = $this->M_Data_Master->getJenisSPJ()->result();
		$data['jabatan'] = $this->M_Data_Master->getJabatan()->result();
		$data['kendaraan'] = $this->M_Data_Master->getJenisKendaraan()->result();
		$data['group'] = $this->M_Data_Master->getOnlyGroup()->result();
		$data['provinsi'] = $this->M_Data_Master->getProvinsi()->result();
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
		$data = $this->M_Data_Master->saveJumlahPendamping($inputObjek, $inputJenisKendaraan, $inputQtyLokal, $inputQtyLuarKota);
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
		$data = $this->M_Data_Master->saveUangJalan($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan);
		echo json_encode($data);
	}
	public function getUangSaku()
	{
		$data['group'] = $this->M_Data_Master->getOnlyGroup()->result();
		$data['data'] = $this->M_Data_Master->getBiayaUangSaku()->result();
		$this->load->view("Data_Master/Konfigurasi/uang_saku", $data);
	}
	public function saveUangSaku()
	{
		$inputJenisSPJ = $this->input->post("inputJenisSPJ"); 
		$inputPIC = $this->input->post("inputPIC"); 
		$inputJKendaraan = $this->input->post("inputJKendaraan"); 
		$inputGroupTujuan = $this->input->post("inputGroupTujuan"); 
		$inputBiayaRental = $this->input->post("inputBiayaRental"); 
		$inputBiayaInternal = $this->input->post("inputBiayaInternal");
		$value = [$inputJenisSPJ, $inputPIC, $inputJKendaraan, $inputGroupTujuan, $inputBiayaRental, $inputBiayaInternal];
		$data = $this->M_Data_Master->saveUangSaku($value);
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
		$data = $this->M_Data_Master->saveUangMakan($isi, $jenis, $grup, $ke);
		echo json_encode($data);
	}
}
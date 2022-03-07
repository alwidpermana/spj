<?php
	class M_Data_Master extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
		public function getDepartement()
		{
			$sql = "SELECT nm_dept FROM dbhrm.dbo.tbdepartement";
			return $this->db->query($sql);
		}
		public function getJabatan()
		{
			$sql = "SELECT jabatan FROM dbhrm.dbo.tbjabatan";
			return $this->db->query($sql);
		}
		public function getDataUserLogin($search)
		{
			$sql = "SELECT
						a.*,
						b.namapeg,
						b.departemen,
						b.divisi,
						b.seksi,
						b.jabatan,
						b.jkelamin
					FROM
						SPJ_USER a
					LEFT JOIN 
						dbhrm.dbo.tbPegawai b ON
						SUBSTRING(a.NIK, 5, 10) = b.nik
					WHERE
						[LEVEL] > 0 AND
						namapeg LIKE '%$search%' OR
						a.NIK LIKE '%$search%' AND
						[LEVEL] >0";
			return $this->db->query($sql);
		}
		public function getKaryawanAdmin($cari)
		{
			$sql = "SELECT TOP 20
						Q1.*
					FROM
					(
						SELECT
							nik,
							namapeg
						FROM
							dbhrm.dbo.tbPegawai
						WHERE
							status_aktif = 'AKTIF'
					)Q1 
					LEFT JOIN
					(
						SELECT
							NIK
						FROM
							SPJ_USER
						WHERE
							STATUS = 'AKTIF'
					)Q2 ON Q1.nik = Q2.NIK
					WHERE
						Q2.NIK IS NULL AND
						Q1.nik LIKE '%$cari%'
						OR 
						namapeg LIKE '%$cari%' AND
						Q2.NIK IS NULL";
			return $this->db->query($sql);
		}
		public function tambahAkun($nik)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$getData = $this->db->query("SELECT jabatan, jkelamin FROM dbhrm.dbo.tbPegawai WHERE nik = '$nik'");
			$level = 4;
			$avatar = 'male1.png';
			foreach ($getData->result() as $key) {
				$level = $key->jabatan == 'Kepala Bagian'?3:4;
				$avatar = $key->jkelamin == 'L'?'male1.png':'female1.png';
			}
			$sql = "INSERT INTO SPJ_USER VALUES('SPJ-$nik','123','$level','AKTIF','$avatar','$tanggal','$user')";
			return $this->db->query($sql);
		}
		public function ubahStatusAkun($nik, $status)
		{
			$sql = "UPDATE SPJ_USER SET STATUS = '$status' WHERE NIK = '$nik'";
			$this->db->query($sql);
		}
		public function ubahLevelAkun($nik, $level)
		{
			$sql = "UPDATE SPJ_USER SET LEVEL = '$level' WHERE NIK = '$nik'";
			$this->db->query($sql);
		}
		public function getKaryawan($filDepartemen, $filJabatan, $filSearch, $nik, $top)
		{
			$sql = "SELECT TOP $top
						*
					FROM
					(
						SELECT
							nik,
							namapeg,
							departemen,
							Subdepartemen1,
							Subdepartemen2,
							jabatan,
							no_ktp
						FROM
							dbhrm.dbo.tbPegawai
						WHERE
							status_aktif = 'AKTIF' AND
							departemen LIKE '%$filDepartemen%' AND
							jabatan LIKE '%$filJabatan%' AND
							NIK LIKE '%$nik%'
					)Q1
					LEFT JOIN
					(
						SELECT
							*
						FROM
							SPJ_PEGAWAI_OTORITAS
					)Q2 ON Q1.nik = Q2.NIK
					WHERE
						Q1.nik LIKE '%$filSearch%' OR
						Q1.namapeg LIKE '%$filSearch%'
					ORDER BY
						TGL_INPUT DESC, Q1.NIK ASC";
			return $this->db->query($sql);
		}
		public function getSupirLogistik($status, $search, $nik, $top, $table)
		{
			$sql = "SELECT TOP $top
						*
					FROM
						(
							SELECT
								KdSopir AS nik,
								NamaSopir AS namapeg,
								AlamatSopir,
								NoKTP as no_ktp,
								Status AS jabatan,
								'-' AS departemen,
								'-' AS Subdepartemen1,
								null AS Subdepartemen2
							FROM
								$table
							WHERE
								StatusAktif = 'Aktif' AND
								Status LIKE '%$status%'	AND
								KdSopir LIKE '%$nik%'	
						)Q1
						LEFT JOIN
						(
							SELECT
								*
							FROM
								SPJ_PEGAWAI_OTORITAS
						)Q2 ON Q1.nik = Q2.NIK
						WHERE
							Q1.nik LIKE '%$search%' OR
							namapeg LIKE '%$search%'";
			return $this->db->query($sql);
		}
		public function saveFoto($file, $nik, $field, $folder)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
			$user = $this->session->userdata("NIK");

			$getNIK = $this->db->query("SELECT $field, NIK FROM SPJ_PEGAWAI_OTORITAS WHERE NIK = '$nik'");
			$jmlData = $getNIK->num_rows();
			
			if ($jmlData) {
				foreach ($getNIK->result() as $key) {
					if ($key->$field != null) {
						$link = './assets/image/'.$folder.'/'.$key->$field;
						if(file_exists($link)){
							unlink($link);
						}
					}
				}
				$sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET $field = '$file', TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE NIK = '$nik'";
			}else{
				$sql = "INSERT INTO SPJ_PEGAWAI_OTORITAS(NIK, $field, TGL_INPUT, PIC_INPUT)VALUES('$nik','$file','$tanggal','$user')";	
			}
			
			return $this->db->query($sql);
		}
		public function saveDataOtoritasKaryawan($isi, $field, $nik)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $getNIK = $this->db->query("SELECT NIK FROM SPJ_PEGAWAI_OTORITAS WHERE NIK = '$nik'");
            if ($getNIK->num_rows()>0) {
            	$sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET $field = '$isi', TGL_INPUT = '$tanggal', PIC_INPUT = '$user'  WHERE NIK = '$nik'";
            } else {
            	$sql = "INSERT INTO SPJ_PEGAWAI_OTORITAS(NIK, $field, TGL_INPUT, PIC_INPUT)VALUES('$nik','$isi','$tanggal','$user')";
            }
            return $this->db->query($sql);
		}
		public function getKendaraan($merk, $kendaraan, $bahanBakar, $search)
		{
			$sql = "SELECT
						*
					FROM
					(
						SELECT
							TglInput,
							NoInventaris,
							NoTNKB,
							Merk,
							Type,
							ThnBuat,
							Jenis,
							BahanBakar,
							Pemakai,
							Kategori,
							BBMPerLiter,
							StatusAktif
						FROM
							GA.[dbo].[GA_TKendaraan]
						WHERE
							StatusAktif = 'Aktif' AND
							Merk LIKE '%$merk%' AND
							Jenis LIKE '%$kendaraan%' AND
							BahanBakar LIKE '%$bahanBakar%'
					)Q1
					WHERE
						NoInventaris LIKE '%$search%' OR
						NoTNKB LIKE '%$search%' OR
						Pemakai LIKE '%$search%'
					ORDER BY
							TglInput DESC";
			return $this->db->query($sql);
		}
		public function saveKendaraan($no, $isi, $field)
		{
			$sql = "UPDATE GA.dbo.GA_TKendaraan SET $field = '$isi' WHERE NoTNKB = '$no'";
			return $this->db->query($sql);
		}
		public function saveFotoKendaraan($fileName)
		{
			$inputJenis = $this->input->post("inputJenis");
			$noTNBK = $this->input->post("noTNBK");
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
			$user = $this->session->userdata("NIK");
			$no = str_replace('_', ' ', $noTNBK);
			$sql = "INSERT INTO SPJ_GAMBAR_KENDARAAN VALUES('$no','$inputJenis','$fileName','$tanggal','$user')";
			return $this->db->query($sql);
		}
		public function getGaleriKendaraan($no)
		{
			$sql ="SELECT
						*,
						ROW_NUMBER() over (partition by NO_TNBK order by ID_GK DESC) AS URUT
					FROM
						SPJ_GAMBAR_KENDARAAN
					WHERE
						NO_TNBK = 'Z 1802 AM'";
			return $this->db->query($sql);
		}
		public function hapusGambarKendaraan($id)
		{
			$sql ="DELETE FROM SPJ_GAMBAR_KENDARAAN WHERE ID_GK = $id";
			return $this->db->query($sql);
		}
		public function getJenisSPJ()
		{
			$sql = "SELECT ID_JENIS, NAMA_JENIS FROM SPJ_JENIS";
			return $this->db->query($sql);
		}
		public function getJenisKendaraan()
		{
			$sql = "SELECT * FROM [dbo].[SPJ_JENIS_KENDARAAN]";
			return $this->db->query($sql);
		}
		public function getKota($cari, $top)
		{
			$sql = "SELECT TOP $top
						*,
						TIPE_KOTA + ' '+NAMA_KOTA+' Provinsi '+PROVINSI AS VAL
					FROM
						SPJ_KOTA
					WHERE
						TIPE_KOTA LIKE '%$cari%' OR
						NAMA_KOTA LIKE '%$cari%' OR
						PROVINSI LIKE '%$cari%'
					ORDER BY NAMA_KOTA ASC";
			return $this->db->query($sql);
		}
		public function getProvinsi()
		{
			$sql = "SELECT NAMA_PROVINSI FROM SPJ_PROVINSI ORDER BY NAMA_PROVINSI ASC";
			return $this->db->query($sql);
		}
		public function getJumlahPendamping()
		{
			$sql = "SELECT
						a.*,
						b.NAMA_JENIS
					FROM
						SPJ_JUMLAH_PENDAMPING a
					LEFT JOIN
						SPJ_JENIS b
					ON a.ID_JENIS_SPJ = b.ID_JENIS";
			return $this->db->query($sql);
		}
		public function saveJumlahPendamping($inputObjek, $inputJenisKendaraan, $inputQtyLokal, $inputQtyLuarKota)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
			$user = $this->session->userdata("NIK");
			$sql = $this->db->query("SELECT ID_JP FROM SPJ_JUMLAH_PENDAMPING WHERE ID_JENIS_SPJ = $inputObjek AND JENIS_KENDARAAN = '$inputJenisKendaraan'");
			if ($sql->num_rows()==0) {
				$save = "INSERT INTO SPJ_JUMLAH_PENDAMPING VALUES($inputObjek, '$inputJenisKendaraan','$tanggal','$user',$inputQtyLokal, $inputQtyLuarKota)";
			} else {
				$save = "UPDATE SPJ_JUMLAH_PENDAMPING SET QTY_LOKAL = $inputQtyLokal, QTY_LUAR_KOTA = $inputQtyLuarKota,TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE ID_JENIS_SPJ = $inputObjek AND JENIS_KENDARAAN = '$inputJenisKendaraan'";
			}
			
			return $this->db->query($save);
		}
		public function getUangJalan()
		{
			$sql = "SELECT
						a.*,
						b.NAMA_JENIS,
						c.TIPE_KOTA +'. '+ c.NAMA_KOTA AS NAMA_KOTA
					FROM
						SPJ_UANG_JALAN a
					LEFT JOIN SPJ_JENIS b ON
						a.ID_JENIS_SPJ = b.ID_JENIS
					LEFT JOIN SPJ_KOTA c ON
						a.ID_KOTA = c.ID_KOTA
					ORDER BY ID_UJ DESC";
			return $this->db->query($sql);
		}
		public function saveUangJalan($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $getID = $this->db->query("SELECT ID_UJ FROM SPJ_UANG_JALAN WHERE ID_JENIS_SPJ = $inputKategoriJalan AND ID_KOTA = $inputKotaJalan");
            if ($getID->num_rows()==0) {
            	$sql ="INSERT INTO SPJ_UANG_JALAN VALUES($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan, '$tanggal','$user')";
            } else {
            	$sql ="UPDATE SPJ_UANG_JALAN SET BIAYA = $inputBiayaJalan, TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE ID_JENIS_SPJ = $inputKategoriJalan AND ID_KOTA = $inputKotaJalan";
            }
            return $this->db->query($sql);
            
		}
		public function getKotaNonGroup($cari)
		{
			$sql = "SELECT TOP 20
						*
					FROM
					(
						SELECT
							a.ID_KOTA,
							TIPE_KOTA + ' '+ NAMA_KOTA AS KOTA
						FROM
							SPJ_KOTA a
						LEFT JOIN
							SPJ_GT_DETAIL b
						ON a.ID_KOTA = b.ID_KOTA
						WHERE
							b.ID_KOTA IS NULL
					)Q1
					WHERE
						KOTA LIKE '%$cari%'
					ORDER BY KOTA ASC";
			return $this->db->query($sql);
		}
		public function getOnlyGroup()
		{
			$sql ="SELECT
						ID_GROUP,
						NAMA_GROUP
					FROM
						SPJ_GROUP_TUJUAN
					ORDER BY
						ID_GROUP ASC";
			return $this->db->query($sql);
		}
		public function tambahGroupJalur($nama)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $sql = "INSERT INTO SPJ_GROUP_TUJUAN VALUES('$nama','$tanggal','$user','AKTIF')";
            return $this->db->query($sql);
		}
		public function updateGroupJalur($nama, $id)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $sql = "UPDATE SPJ_GROUP_TUJUAN SET NAMA_GROUP = '$nama', TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE ID_GROUP = '$id'";
            return $this->db->query($sql);
		}
		public function getGroupJalur($id)
		{
			$sql = "SELECT
						ID_GROUP,
						a.ID_KOTA,
						b.TIPE_KOTA,
						b.NAMA_KOTA
					FROM
						SPJ_GT_DETAIL a
					LEFT JOIN SPJ_KOTA b
					ON a.ID_KOTA = b.ID_KOTA";
			if ($id >0) {
				$sql .=" WHERE ID_GROUP = $id";
			}
			$sql .=" ORDER BY ID_GROUP ASC";
			return $this->db->query($sql);
		}
		public function gantiGroupJalur($kota, $group)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$getJalur = $this->db->query("SELECT ID_KOTA FROM SPJ_GT_DETAIL WHERE ID_KOTA = $kota");
			if ($group == 0) {
				$sql = "DELETE FROM SPJ_GT_DETAIL WHERE ID_KOTA = $kota";
			} else {
				if ($getJalur->num_rows()==0) {
					$sql = "INSERT INTO SPJ_GT_DETAIL VALUES($kota, $group, '$tanggal','$user')";
				}else{
					$sql = "UPDATE SPJ_GT_DETAIL SET ID_GROUP = '$group', TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE ID_KOTA = $kota";
				}
			}
			
			
			return $this->db->query($sql);
		}
		public function getBiayaUangSaku()
		{
			$sql = "SELECT
						a.ID_US,
						a.ID_JENIS_SPJ,
						b.NAMA_JENIS,
						a.JENIS_PIC,
						a.JENIS_KENDARAAN,
						a.ID_GROUP,
						c.NAMA_GROUP,
						a.BIAYA_INTERNAL,
						a.BIAYA_RENTAL 
					FROM
						SPJ_UANG_SAKU a
						LEFT JOIN SPJ_JENIS b ON a.ID_JENIS_SPJ = b.ID_JENIS
						LEFT JOIN SPJ_GROUP_TUJUAN c ON a.ID_GROUP = c.ID_GROUP 
					ORDER BY
						b.ID_JENIS ASC,
						a.ID_US ASC";
			return $this->db->query($sql);
		}
		public function saveUangSaku($value)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");

			$getData = $this->db->query("SELECT ID_US FROM SPJ_UANG_SAKU WHERE ID_JENIS_SPJ = '$value[0]' AND JENIS_PIC = '$value[1]' AND JENIS_KENDARAAN = '$value[2]' AND ID_GROUP = '$value[3]'");
			if ($getData->num_rows()==0) {
				$sql = "INSERT INTO SPJ_UANG_SAKU VALUES('$value[0]','$value[1]','$value[2]','$tanggal','$user','$value[3]','$value[5]','$value[4]')";
			} else {
				$sql ="UPDATE SPJ_UANG_SAKU SET TGL_INPUT = '$tanggal', PIC_INPUT = '$user', BIAYA_INTERNAL = '$value[5]', BIAYA_RENTAL ='$value[4]' WHERE ID_JENIS_SPJ = '$value[0]' AND JENIS_PIC = '$value[1]' AND JENIS_KENDARAAN = '$value[2]' AND ID_GROUP = '$value[3]'";
			}
			return $this->db->query($sql);
		}
		public function hapusUangSaku($id)
		{
			$sql ="DELETE FROM SPJ_UANG_SAKU WHERE ID_US = $id";
			return $this->db->query($sql);
		}
		public function saveUangMakan($isi, $jenis, $grup, $ke)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$getData = $this->db->query("SELECT ID_UM FROM SPJ_UANG_MAKAN WHERE ID_JENIS_SPJ = '$jenis' AND JENIS_GROUP = '$grup' AND MAKAN_KE='$ke'");
			if ($getData->num_rows()==0) {
				$sql = "INSERT INTO SPJ_UANG_MAKAN VALUES('$jenis','$grup','$isi','$tanggal','$user','$ke')";
			} else {
				$sql = "UPDATE SPJ_UANG_MAKAN SET BIAYA = '$isi', TGL_INPUT = '$tanggal',PIC_INPUT = '$user' WHERE ID_JENIS_SPJ = '$jenis' AND JENIS_GROUP = '$grup' AND MAKAN_KE='$ke'";
			}
			return $this->db->query($sql);
			
		}
		public function getUangMakan()
		{
			$sql = "SELECT
						Q1.JENIS_GROUP,
						Q2.BIAYA AS BIAYA1,
						Q2.ID_JENIS_SPJ AS ID1,
						Q2.MAKAN_KE AS KE1,
						Q3.BIAYA AS BIAYA2,
						Q3.ID_JENIS_SPJ AS ID2,
						Q3.MAKAN_KE AS KE2,
						Q4.BIAYA AS BIAYA3,
						Q4.ID_JENIS_SPJ AS ID3,
						Q4.MAKAN_KE AS KE3,
						Q5.BIAYA AS BIAYA4,
						Q5.ID_JENIS_SPJ AS ID4,
						Q5.MAKAN_KE AS KE4
					FROM
					(
						SELECT DISTINCT
							CASE 
						WHEN NAMA_GROUP = 'Lokal' THEN 'Lokal'
						ELSE 'Luar Kota'
					END AS JENIS_GROUP
						FROM
							SPJ_GROUP_TUJUAN
					)Q1
					LEFT JOIN
					(
						SELECT
							JENIS_GROUP,
							BIAYA,
							ID_JENIS_SPJ,
							MAKAN_KE
							
						FROM
							SPJ_UANG_MAKAN
						WHERE
							ID_JENIS_SPJ= 1 AND
							MAKAN_KE = 1
					)Q2 ON Q1.JENIS_GROUP = Q2.JENIS_GROUP
					LEFT JOIN
					(
						SELECT
							JENIS_GROUP,
							BIAYA,
							ID_JENIS_SPJ,
							MAKAN_KE

						FROM
							SPJ_UANG_MAKAN
						WHERE
							ID_JENIS_SPJ= 1 AND
							MAKAN_KE = 2
					)Q3 ON Q1.JENIS_GROUP = Q3.JENIS_GROUP
					LEFT JOIN
					(
						SELECT
							JENIS_GROUP,
							BIAYA,
							ID_JENIS_SPJ,
							MAKAN_KE
						FROM
							SPJ_UANG_MAKAN
						WHERE
							ID_JENIS_SPJ= 2 AND
							MAKAN_KE = 1
					)Q4 ON Q1.JENIS_GROUP = Q4.JENIS_GROUP
					LEFT JOIN
					(
						SELECT
							JENIS_GROUP,
							BIAYA,
							ID_JENIS_SPJ,
							MAKAN_KE
						FROM
							SPJ_UANG_MAKAN
						WHERE
							ID_JENIS_SPJ= 2 AND
							MAKAN_KE = 2
					)Q5 ON Q1.JENIS_GROUP = Q5.JENIS_GROUP";
			return $this->db->query($sql);
		}
		public function saveKota($inputTipeDaerah, $inputNamaDaerah, $inputProvinsi)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$sql = "INSERT INTO SPJ_KOTA VALUES('$inputTipeDaerah','$inputNamaDaerah','$inputProvinsi','$tanggal','$user')";
			return $this->db->query($sql);
		}
	}
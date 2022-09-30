<?php
	class M_Data_Master extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
		public function getDepartement($nama)
		{
			$sql = "SELECT kd_dept, nm_dept, KodeRekaman FROM dbhrm.dbo.tbdepartement";
			if ($nama != '') {
				$sql .=" WHERE nm_dept = '$nama'";
			}
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
			$sql = "INSERT INTO SPJ_USER(NIK, PASSWORD, LEVEL,STATUS, AVATAR, TGL_INPUT, PIC_INPUT) VALUES('SPJ-$nik','123','$level','AKTIF','$avatar','$tanggal','$user')";
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
		public function getKaryawanOtoritasALL($departemen, $jabatan, $search)
		{
			$sql = "SELECT
						*
					FROM
					(
						SELECT
							a.*,
							b.namapeg,
							b.jabatan,
							b.departemen,
							CASE 
								WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
								ELSE Subdepartemen1+' ,'+Subdepartemen2
							END AS Subdepartemen
						FROM
							SPJ_PEGAWAI_OTORITAS a
						LEFT JOIN dbhrm.dbo.tbPegawai b ON
						a.nik = b.nik
						WHERE
							JENIS_DATA = 'internal' AND
							STATUS_DATA = 'SAVED'
						UNION
						SELECT
							a.*,
							NamaSopir AS namapeg,
							Status AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							SPJ_PEGAWAI_OTORITAS a
						LEFT JOIN TrTs_SopirLogistik b ON
						a.nik = b.KdSopir
						WHERE
							JENIS_DATA = 'logistik' AND
							STATUS_DATA = 'SAVED'
						UNION
						SELECT
							a.*,
							NamaSopir AS namapeg,
							Status AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							SPJ_PEGAWAI_OTORITAS a
						LEFT JOIN TrTS_SopirRental b ON
						a.nik = b.KdSopir
						WHERE
							JENIS_DATA = 'rental' AND
							STATUS_DATA = 'SAVED'
					)Q1
					WHERE
						departemen LIKE '%$departemen%' AND
						jabatan LIKE '%$jabatan%' AND
						namapeg LIKE '%$search%' OR
						NIK LIKE '%$search%' AND
						departemen LIKE '%$departemen%' AND
						jabatan LIKE '%$jabatan%'
					ORDER BY 
						namapeg ASC";
			return $this->db->query($sql);
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
							no_ktp,
							divisi,
							seksi
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
			$sql = "SELECT TOp $top
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
		public function saveFoto($file, $nik, $field, $folder, $jenis)
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
				$sql = "INSERT INTO SPJ_PEGAWAI_OTORITAS(NIK, $field, TGL_INPUT, PIC_INPUT, JENIS_DATA, OTORITAS_ADJUSMENT)VALUES('$nik','$file','$tanggal','$user','$jenis','N')";	
			}
			
			return $this->db->query($sql);
		}
		public function saveDataOtoritasKaryawan($isi, $field, $nik, $jenis)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $getNIK = $this->db->query("SELECT NIK FROM SPJ_PEGAWAI_OTORITAS WHERE NIK = '$nik'");
            if ($getNIK->num_rows()>0) {
            	$sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET $field = '$isi', TGL_INPUT = '$tanggal', PIC_INPUT = '$user'  WHERE NIK = '$nik'";
            } else {
            	$sql = "INSERT INTO SPJ_PEGAWAI_OTORITAS(NIK, $field, TGL_INPUT, PIC_INPUT, JENIS_DATA, OTORITAS_ADJUSMENT)VALUES('$nik','$isi','$tanggal','$user','$jenis','N')";
            }
            return $this->db->query($sql);
		}
		public function saveDataOtoritasKaryawan2($nik, $jenis, $isiDriver, $inputSubjek, $isiPendamping, $isiUangMakan, $isiUangSaku, $isiAdj)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET STATUS_DATA = 'SAVED', TGL_INPUT = '$tanggal', PIC_INPUT = '$user', OTORITAS_DRIVER = '$isiDriver', OTORITAS_PENDAMPING = '$isiPendamping', OTORITAS_UANG_MAKAN = 'Y', OTORITAS_UANG_SAKU = 'Y', SUBJEK='$inputSubjek' WHERE NIK = '$nik'";
            if ($isiDriver == 'N') {
            	$this->db->query("UPDATE SPJ_PEGAWAI_OTORITAS SET NO_SIM = null, BERLAKU_TERBIT = null, BERLAKU_AKHIR = null WHERE NIK = '$nik'");
            }
            if ($inputSubjek == 'Internal') {
            	$this->db->query("UPDATE SPJ_PEGAWAI_OTORITAS SET REKANAN = null WHERE NIK = '$nik'");
            }
            return $this->db->query($sql);

		}
		public function getKendaraan($merk, $kendaraan, $bahanBakar, $search, $filJenis)
		{
			$whereJenis = $filJenis == '' ? '' : " AND Kategori LIKE '$filJenis%'";
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
							StatusAktif,
							NamaSTNK
						FROM
							GA.[dbo].[GA_TKendaraan]
						WHERE
							StatusAktif = 'Aktif' AND
							Merk LIKE '$merk%' AND
							Jenis LIKE '$kendaraan%' AND
							BahanBakar LIKE '$bahanBakar%'
							$whereJenis
					)Q1
					WHERE
						NoInventaris LIKE '%$search%' OR
						NoTNKB LIKE '%$search%' OR
						Pemakai LIKE '%$search%'
					ORDER BY
							TglInput DESC";
			return $this->db->query($sql);
		}
		public function getFilterJenisKendaraan()
		{
			$sql = "SELECT DISTINCT
						Jenis
					FROM
						GA.[dbo].[GA_TKendaraan]
					ORDER BY Jenis ASC";
			return $this->db->query($sql);
		}
		public function getFilterMerkKendaraan()
		{
			$sql = "SELECT DISTINCT
						Merk
					FROM
						GA.[dbo].[GA_TKendaraan]
					ORDER BY Merk ASC";
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
			$inputNoTNKB = $this->input->post("inputNoTNKB");
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
			$user = $this->session->userdata("NIK");
			$no = str_replace('_', ' ', $inputNoTNKB);
			$sql = "INSERT INTO SPJ_GAMBAR_KENDARAAN VALUES('$no','$inputJenis','$fileName','$tanggal','$user', null)";
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
						NO_TNBK = '$no'";
			return $this->db->query($sql);
		}
		public function updateStarKendaraan($id, $no)
		{
			$this->db->query("UPDATE SPJ_GAMBAR_KENDARAAN SET STAR = null WHERE NO_TNBK = '$no'");
			$sql = "UPDATE SPJ_GAMBAR_KENDARAAN SET STAR = 'Y' WHERE ID_GK = $id";
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
		public function getJenisOther()
		{
			$sql = "SELECT ID, TUJUAN FROM SPJ_OTHER";
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
		public function getKota2($cari)
		{
			$sql = "SELECT TOP 25
						TIPE_KOTA+' '+NAMA_KOTA AS KOTA,
						TIPE_KOTA+' '+NAMA_KOTA+' Provinsi '+PROVINSI AS VAL
					FROM
						SPJ_KOTA
					WHERE
						TIPE_KOTA LIKE '%$cari%' OR
						NAMA_KOTA LIKE '%$cari%' OR
						PROVINSI LIKE '%$cari%'
					ORDER BY NAMA_KOTA ASC";
			return $this->db->query($sql);
		}
		public function getKotaKabDis()
		{
			$sql = "SELECT DISTINCT
						NAMA_KOTA
					FROM
					(
						SELECT
							ID_KOTA,
							NAMA_KOTA
						FROM
							SPJ_KOTA
					)Q1
					INNER JOIN
					(
						SELECT
							ID_KOTA
						FROM
							SPJ_GT_DETAIL
					)Q2 ON Q1.ID_KOTA = Q2.ID_KOTA
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
		public function getOnlyGroup($group)
		{
			$sql ="SELECT
						ID_GROUP,
						NAMA_GROUP
					FROM
						SPJ_GROUP_TUJUAN";
			if ($group != '') {
				$sql .=" WHERE ID_GROUP = $group";
			}
			$sql .=" ORDER BY
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
		public function saveUangSakuNew($biaya, $field, $idJenis, $pic, $jenisKendaraan, $idGroup)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $getData = $this->db->query("SELECT ID_US FROM SPJ_UANG_SAKU WHERE ID_JENIS_SPJ = '$idJenis' AND JENIS_PIC = '$pic' AND JENIS_KENDARAAN = '$jenisKendaraan' AND ID_GROUP = '$idGroup'");
            if ($getData->num_rows()==0) {
            	$sql = "INSERT INTO SPJ_UANG_SAKU($field, ID_JENIS_SPJ, JENIS_PIC, JENIS_KENDARAAN, TGL_INPUT, PIC_INPUT, ID_GROUP)VALUES('$biaya','$idJenis','$pic','$jenisKendaraan','$tanggal','$user','$idGroup')";
            }else{
            	$sql = "UPDATE SPJ_UANG_SAKU SET $field = '$biaya', TGL_INPUT='$tanggal', PIC_INPUT = '$user' WHERE ID_JENIS_SPJ = '$idJenis' AND JENIS_PIC = '$pic' AND JENIS_KENDARAAN = '$jenisKendaraan' AND ID_GROUP = '$idGroup'";
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
		public function verifKaryawan($nik, $val)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET STATUS_VERIF = '$val', PIC_VERIF='$user', TGL_VERIF = '$tanggal' WHERE NIK = '$nik'";
            return $this->db->query($sql);
		}
		public function uangSakuDelivery()
		{
			

			$sql = "SELECT
						*
					FROM
					(
						SELECT
						Status,
						JENIS_KENDARAAN AS KENDARAAN_MASTER
					FROM
					(
						SELECT
							DISTINCT Status,
							'LINK' AS LINK
						FROM
							TrTs_SopirLogistik
					)Q
					LEFT JOIN
					(
						SELECT
							JENIS_KENDARAAN,
							'LINK' AS LINK
						FROM
							SPJ_JENIS_KENDARAAN
					)P ON Q.LINK = P.LINK
					)MASTER";
			$getGroup = $this->db->query("SELECT ID_GROUP,NAMA_GROUP FROM SPJ_GROUP_TUJUAN ORDER BY ID_GROUP ASC");
			foreach ($getGroup->result() as $key) {
				$id = $key->ID_GROUP;
				$sql .=" LEFT JOIN
					(
						SELECT
							JENIS_PIC,
							JENIS_KENDARAAN,
							a.ID_GROUP AS ID_GROUP$id,
							NAMA_GROUP AS NAMA_GROUP$id,
							BIAYA_INTERNAL AS INTERNAL$id,
							BIAYA_RENTAL AS RENTAL$id
						FROM
							SPJ_UANG_SAKU a
						LEFT JOIN SPJ_GROUP_TUJUAN b ON
						a.ID_GROUP = b.ID_GROUP
						WHERE
							a.ID_GROUP = $id AND
							a.ID_JENIS_SPJ = 1
					)Q$id ON MASTER.Status = Q$id.JENIS_PIC AND MASTER.KENDARAAN_MASTER = Q$id.JENIS_KENDARAAN";
			}
			return $this->db->query($sql);
		
		}
		public function uangSakuNonDelivery()
		{

			$sql = "SELECT
						* 
					FROM
					(
						SELECT
							jabatan,
							'Internal' AS TIPE_MASTER
						FROM
							dbhrm.dbo.tbjabatan 
						WHERE
							jabatan IN ( 'Manager', 'Kepala Bagian', 'Kepala Bagian', 'Kepala Seksi', 'Kepala Regu', 'Staff', 'Administrasi', 'Operator', 'Driver' ) 
						UNION ALL
						SELECT
							jabatan,
							'Rental' AS TIPE_MASTER
						FROM
							dbhrm.dbo.tbjabatan 
						WHERE
							jabatan = 'Driver'
					)Q";
			$getGroup = $this->db->query("SELECT ID_GROUP,NAMA_GROUP FROM SPJ_GROUP_TUJUAN ORDER BY ID_GROUP ASC");
			foreach ($getGroup->result() as $key) {
				$id = $key->ID_GROUP;
				$sql .=" LEFT JOIN
						(
							SELECT
								JENIS_PIC,
								JENIS_KENDARAAN,
								a.ID_GROUP AS ID_GROUP$id,
								NAMA_GROUP AS NAMA_GROUP$id,
								BIAYA_INTERNAL AS BIAYA$id,
								'Internal' AS TIPE
							FROM
								SPJ_UANG_SAKU a
							LEFT JOIN SPJ_GROUP_TUJUAN b ON
							a.ID_GROUP = b.ID_GROUP
							WHERE
								a.ID_GROUP = $id AND
								a.ID_JENIS_SPJ = 2
							UNION
							SELECT
								JENIS_PIC,
								JENIS_KENDARAAN,
								a.ID_GROUP AS ID_GROUP$id,
								NAMA_GROUP AS NAMA_GROUP$id,
								BIAYA_RENTAL AS BIAYA$id,
								'Rental' AS TIPE
							FROM
								SPJ_UANG_SAKU a
							LEFT JOIN SPJ_GROUP_TUJUAN b ON
							a.ID_GROUP = b.ID_GROUP
							WHERE
								a.ID_GROUP = $id AND
								a.ID_JENIS_SPJ = 2	
						)Q$id ON Q.jabatan = Q$id.JENIS_PIC AND Q.TIPE_MASTER = Q$id.TIPE";	
			}
		return $this->db->query($sql);
		}
		public function getKategoriKendaraan()
		{
			$sql = "SELECT
						DISTINCT Jenis
					FROM
						GA.[dbo].[GA_TKendaraan]
					WHERE
						JENIS  NOT IN ('Alat Angkut dan Alat Angkat')";
			return $this->db->query($sql);
		}
		public function getNoVoucher()
		{
			$gabung = 'MSM';
			$cekNoDoc=$this->db->query("SELECT MAX
											( RIGHT ( VOUCHER_BBM, 6 ) ) AS SETVOUCHER 
										FROM
											SPJ_PENGAJUAN 
										WHERE
											VOUCHER_BBM LIKE 'MSM%' AND STATUS_DATA = 'SAVED'");
			foreach ($cekNoDoc->result() as $data) {
	            if ($data->SETVOUCHER =="") {
	                $URUTZERO = $gabung."000001";

	                $hasil= array('voucher' => $URUTZERO,);
	            }else{
	                $zero='';
	                $length= 6;
	                $index=$data->SETVOUCHER;

	                for ($i=0; $i <$length-strlen($index+1) ; $i++) { 
	                    $zero = $zero.'0';
	                }
	                $URUTDOCNO = $gabung.$zero.($index+1);
	                
	                $hasil=array(
	                'voucher' => $URUTDOCNO,);    
	            }
	            
	        }
	        return $hasil;
		}
		public function getDataVoucher($status, $search, $id)
		{
			$sql = "SELECT
						*
					FROM
					(
						SELECT
							ID,
							NO_VOUCHER,
							RP,
							STATUS
						FROM
							SPJ_VOUCHER_BBM
						WHERE
							NO_VOUCHER LIKE '$search%' AND
							STATUS != 'DELETED' AND
							ID LIKE '$id%'
					)Q1";
			if ($status != '') {
				$sql .=" WHERE";
				if ($status == '1') {
					$sql.=" STATUS = 'USED'";
				} else {
					$sql.=" STATUS = 'NOT'";
				}
			}
			$sql.=" ORDER BY NO_VOUCHER DESC";
			return $this->db->query($sql);
		}
		public function saveVoucherBBM($no, $rp)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$getVoucher = $this->db->query("SELECT ID FROM SPJ_VOUCHER_BBM WHERE NO_VOUCHER = '$no' AND STATUS != 'DELETED'");
			if ($getVoucher->num_rows()==0) {
				$sql = "INSERT INTO SPJ_VOUCHER_BBM VALUES('$no','$rp','USED','$tanggal','$user')";
			} else {
				$sql ="UPDATE SPJ_VOUCHER_BBM SET RP = '$rp', TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE NO_VOUCHER = '$no'";
			}
			return $this->db->query($sql);
			
		}
		public function hapusVoucherBBM($no, $id)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $sql = "UPDATE SPJ_VOUCHER_BBM SET STATUS = 'DELETED', TGL_INPUT = '$tanggal', PIC_INPUT = '$user' WHERE ID = '$id'";
            return $this->db->query($sql);
		}
		public function viewTambahanUangSaku($where)
		{
			$sql = "SELECT
						Q1.*,
						NAMA_JENIS
					FROM
					(
						SELECT
							Q1.JENIS_ID,
							Q1.ID AS ID1,
							Q1.QTY AS QTY1,
							Q2.ID AS ID2,
							Q2.QTY AS QTY2
						FROM
						(
							SELECT
								ID,
								QTY,
								JENIS_ID
							FROM
								SPJ_US_TAMBAHAN
							WHERE
								TIPE = 1
						)Q1
						INNER JOIN
						(
							SELECT
								ID,
								QTY,
								JENIS_ID
							FROM
								SPJ_US_TAMBAHAN
							WHERE
								TIPE = 2
						)Q2 ON Q1.JENIS_ID = Q2.JENIS_ID
					)Q1
					LEFT JOIN
					(
						SELECT
							ID_JENIS,
							NAMA_JENIS
						FROM
							SPJ_JENIS
					)Q2 ON Q1.JENIS_ID = Q2.ID_JENIS
					$where";
			return $this->db->query($sql);
		}
		public function getJamTambahan()
		{
			$sql = "SELECT JAM1,JAM2 FROM SPJ_JAM_TAMBAHAN";
			return $this->db->query($sql);
		}
		public function saveJamTambahan($jam, $field)
		{
			$sql = "UPDATE SPJ_JAM_TAMBAHAN SET $field = $jam";
			return $this->db->query($sql);
		}
		public function savePengajuanKonfigurasiJumlahPendamping($inputObjek, $inputJenisKendaraan, $inputQtyLokal, $inputQtyLuarKota)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$sql = "INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI, TGL_INPUT, PIC_INPUT, JENIS_ID, QTY_1, QTY_2, JENIS) VALUES('SPJ_JUMLAH_PENDAMPING','$tanggal','$user','$inputObjek','$inputQtyLokal','$inputQtyLuarKota','$inputJenisKendaraan')";
			return $this->db->query($sql);
		}
		public function savePengajuanKonfigurasiUangJalan($inputKategoriJalan, $inputKotaJalan, $inputBiayaJalan)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$sql = "INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI, TGL_INPUT, PIC_INPUT, JENIS_ID, QTY_1, FIELD_ID)VALUES('SPJ_UANG_JALAN','$tanggal','$user','$inputKategoriJalan','$inputBiayaJalan','$inputKotaJalan')";
			return $this->db->query($sql);
		}
		public function savePengajuanKonfigurasiUangSaku($biaya, $field, $jenisSPJ, $pic, $jenisKendaraan, $idGroup)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
            $fi = $field == 'BIAYA_INTERNAL' ? 'QTY_1':'QTY_2';
			$sql = "INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI, TGL_INPUT, PIC_INPUT, JENIS_ID, $fi, JENIS, JENIS_2, FIELD_ID) VALUES('SPJ_UANG_SAKU','$tanggal','$user', '$jenisSPJ', $biaya, '$pic','$jenisKendaraan', '$idGroup')";
			return $this->db->query($sql);
		}
		public function savePengajuanKonfigurasiUangMakan($isi, $jenis, $grup, $ke)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$sql = "INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI, TGL_INPUT, PIC_INPUT, JENIS_ID,QTY_1, JENIS, FIELD_ID)VALUES('SPJ_UANG_MAKAN','$tanggal','$user', '$jenis',$isi,'$grup',$ke )";
			return $this->db->query($sql);
		}
		public function savePengajuanKonfigurasiJamTambahan($jam, $field)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$fi = $field == 'JAM1'?'QTY_1':'QTY_2';
			$sql = "INSERT INTO SPJ_VERIFIKASI_KONFIGURASI(TABEL_KONFIGURASI,TGL_INPUT, PIC_INPUT, $fi)VALUES('SPJ_JAM_TAMBAHAN','$tanggal','$user',$jam)";
			return $this->db->query($sql);
		}
		public function getVerifikasiKonfigurasi($jenis, $status)
		{
			$sql = "SELECT TOP 100
						SUBSTRING(TABEL_KONFIGURASI, 5, 100) AS KONFIGURASI,
						a.*,
						b.namapeg AS NAMA_PENGAJU,
						c.NAMA_JENIS,
						d.NAMA_KOTA,
						e.NAMA_GROUP,
						f.namapeg AS NAMA_APPROVE
					FROM
						SPJ_VERIFIKASI_KONFIGURASI a
					LEFT JOIN
						dbhrm.dbo.tbPegawai b
					ON a.PIC_INPUT = b.nik
					LEFT JOIN
						SPJ_JENIS c 
					ON c.ID_JENIS = a.JENIS_ID
					LEFT JOIN
						SPJ_KOTA d
					ON a.FIELD_ID = d.ID_KOTA
					LEFT JOIN
						SPJ_GROUP_TUJUAN e
					ON a.FIELD_ID = e.ID_GROUP
					LEFT JOIN
						dbhrm.dbo.tbPegawai f
					ON a.PIC_APPROVE = f.nik
					WHERE
						TABEL_KONFIGURASI LIKE '$jenis%' $status
					ORDER BY
						a.TGL_INPUT DESC";
			return $this->db->query($sql);
		}
		public function verifikasiKonfigurasi($id, $status)
		{
			date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d H:i:s');
            $user = $this->session->userdata("NIK");
			$sql = "UPDATE SPJ_VERIFIKASI_KONFIGURASI SET STATUS_APPROVE = '$status', TGL_APPROVE='$tanggal', PIC_APPROVE='$user' WHERE ID=$id";
			return $this->db->query($sql);
		}
		public function getDataAdjustmentKaryawan($search, $adjustment)
		{
			$sql = "SELECT
						*
					FROM
					(
						SELECT
							Q1.NIK,
							namapeg AS NAMA,
							jabatan AS JABATAN,
							departemen AS DEPARTEMEN,
							OTORITAS_ADJUSMENT
						FROM
						(
							SELECT
								NIK,
								OTORITAS_ADJUSMENT
							FROM
								SPJ_PEGAWAI_OTORITAS
						)Q1
						LEFT JOIN
						(
							SELECT
								nik,
								namapeg,
								jabatan,
								departemen
							FROM
								dbhrm.dbo.tbPegawai
							UNION
							SELECT
								KdSopir,
								NamaSopir,
								Status,
								NULL AS departemen
							FROM
								TrTs_SopirLogistik
							UNION
							SELECT
								KdSopir,
								NamaSopir,
								Status,
								NULL AS departemen
							FROM
								TrTs_SopirRental
						)Q2 ON Q1.NIK = Q2.nik
						WHERE OTORITAS_ADJUSMENT LIKE '$adjustment%'
					)Q1
					WHERE
						NIK LIKE '%$search%' OR
						NAMA LIKE '%$search%' OR
						DEPARTEMEN LIKE '%$search%' OR
						JABATAN LIKE '%$search%'
					ORDER BY OTORITAS_ADJUSMENT DESC, NIK ASC";
			return $this->db->query($sql);
		}
		public function saveOtoritasAdjustment($nik, $isi)
		{
			$sql = "UPDATE SPJ_PEGAWAI_OTORITAS SET OTORITAS_ADJUSMENT = '$isi' WHERE NIK = '$nik'";
			return $this->db->query($sql);
		}
	}
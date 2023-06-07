<?php
	class M_Auth extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
		public function login($nik, $password)
		{
			$sql = "SELECT
						Q1.*,
						NAMA,
						JABATAN,
						DEPARTEMEN,
						DIVISI,
						SEKSI,
						JENIS_KELAMIN,
						KODE_DEPT,
						SUB_DEPARTEMEN,
						SubDepartemen2
					FROM
					(
						SELECT
							SUBSTRING(NIK, 5, 10) AS NIK,
							[LEVEL],
							STATUS,
							AVATAR,
							OTORITAS_DLV,
							OTORITAS_NDV
						FROM
							SPJ_USER
						WHERE
							NIK = 'SPJ-$nik' AND
							PASSWORD = '$password' AND
							STATUS = 'AKTIF'
					)Q1
					LEFT JOIN
					(
						SELECT
							nik,
							namapeg AS NAMA,
							jabatan AS JABATAN,
							departemen AS DEPARTEMEN,
							divisi AS DIVISI,
							seksi AS SEKSI,
							jKelamin AS JENIS_KELAMIN,
							SubDepartemen2,
							CASE 
								WHEN Subdepartemen2 IS NULL THEN Subdepartemen1
								WHEN Subdepartemen2 ='' THEN Subdepartemen1
								WHEN Subdepartemen2 ='-' THEN Subdepartemen1
								ELSE Subdepartemen1+', '+Subdepartemen2
							END AS SUB_DEPARTEMEN
						FROM
						dbhrm.dbo.tbPegawai
					)Q2 ON Q1.NIK = Q2.nik
					LEFT JOIN
					(
						SELECT
							kd_dept AS KODE_DEPT,
							nm_dept
						FROM
							dbhrm.dbo.tbdepartement
					)Q3 ON Q2.DEPARTEMEN = Q3.nm_dept";
			return $this->db->query($sql);
		}
		public function getDataAvatar()
		{
			$jk = $this->session->userdata("JENIS_KELAMIN");
			$sql = "SELECT * FROM dbhrm.dbo.HRGA_AVATAR WHERE JENIS_KELAMIN = '$jk'";
			return $this->db->query($sql);
		}
		public function view_akun()
		{
			$nik = 'SPJ-'.$this->session->userdata("NIK");
			$sql = "SELECT
						SUBSTRING(a.NIK, 5, 10) AS NIK,
						a.PASSWORD,
						b.namapeg,
						b.jabatan,
						b.departemen,
					CASE
							WHEN Subdepartemen2 IS NULL 
							OR Subdepartemen2 = '' THEN
								Subdepartemen1 ELSE Subdepartemen1 + ', ' + Subdepartemen2 
								END AS subdepartemen,
							b.divisi,
							b.seksi,
							a.AVATAR,
							c.FOTO 
						FROM
							SPJ_USER a
							LEFT JOIN dbhrm.dbo.tbPegawai b ON SUBSTRING(a.NIK, 5, 10) = b.nik
							LEFT JOIN dbhrm.dbo.HRGA_AVATAR c ON a.avatar = c.avatar 
					WHERE
						a.NIK = '$nik'";
			return $this->db->query($sql);
		}
		public function updateAvatar($inputAvatar)
		{
			$nik = 'SPJ-'.$this->session->userdata("NIK");
			$sql = "UPDATE SPJ_USER SET AVATAR = '$inputAvatar' WHERE NIK='$nik'";
			return $this->db->query($sql);
		}
		public function updatePassword($inputPassword)
		{
			$nik = 'SPJ-'.$this->session->userdata("NIK");
			$sql = "UPDATE SPJ_USER SET PASSWORD = '$inputPassword' WHERE NIK='$nik'";
			return $this->db->query($sql);	
		}
	}
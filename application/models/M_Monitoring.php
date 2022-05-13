<?php
class M_Monitoring extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getSPJ($bulan, $tahun, $jenis, $search, $id, $adjustment)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$byAdjust = $adjustment == ''?'':" AND ADJUSTMENT_MANAJEMEN = 'Y'";
		$sql = "SELECT
					* 
				FROM
				(
					SELECT
						ID_SPJ,
						TGL_INPUT,
						JENIS_ID,
						NO_SPJ,
						TGL_SPJ,
						QR_CODE,
						PIC_INPUT,
						JENIS_KENDARAAN,
						NO_INVENTARIS,
						NO_TNKB,
						MERK,
						TYPE,
						GROUP_ID,
						TOTAL_UANG_SAKU,
						TOTAL_UANG_MAKAN,
						TOTAL_UANG_JALAN,
						TOTAL_UANG_BBM,
						TOTAL_UANG_TOL,
						STATUS_SPJ,
						RENCANA_BERANGKAT,
						RENCANA_PULANG,
						KENDARAAN,
						MEDIA_UANG_SAKU,
						MEDIA_UANG_MAKAN,
						MEDIA_UANG_JALAN,
						MEDIA_UANG_BBM,
						MEDIA_UANG_TOL,
						STATUS_PERJALANAN
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%' AND
						NO_SPJ LIKE '$search%' $byAdjust
				)Q1
				LEFT JOIN
				(
					SELECT
						nik,
						namapeg,
						jabatan,
						departemen,
						CASE 
							WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
							ELSE Subdepartemen1+', '+Subdepartemen2
						END AS Subdepartemen
					FROM
						dbhrm.dbo.tbPegawai
				)Q2 ON Q1.PIC_INPUT = Q2.nik
				LEFT JOIN
				(
					SELECT
						ID_GROUP,
						NAMA_GROUP
					FROM
						SPJ_GROUP_TUJUAN
				)Q3 ON Q1.GROUP_ID = Q3.ID_GROUP
				LEFT JOIN
				(
					SELECT
						ID_JENIS,
						NAMA_JENIS
					FROM
						SPJ_JENIS
				)Q4 ON Q1.JENIS_ID = Q4.ID_JENIS
				LEFT JOIN
				(
					SELECT
						Q1.NIK + ' - ' + namapeg AS PIC_DRIVER,
						NO_PENGAJUAN,
						Q1.NIK AS NIK_DRIVER,
						namapeg AS NAMA_DRIVER,
						jabatan AS JABATAN_DRIVER,
						departemen AS DEPARTEMEN_DRIVER,
						Subdepartemen AS SUB_DEPARTEMEN_DRIVER,
						UANG_SAKU,
						UANG_MAKAN,
						SORTIR,
						OBJEK
					FROM
					(
						SELECT
							NO_PENGAJUAN,
							NIK,
							UANG_SAKU,
							UANG_MAKAN,
							SORTIR,
							OBJEK
						FROM
							SPJ_PENGAJUAN_PIC
						WHERE
							JENIS_PIC ='Sopir'
					)Q1
					LEFT JOIN
					(
						SELECT
							KdSopir AS nik,
							NamaSopir AS namapeg,
							'-' AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							TrTs_SopirLogistik 
						WHERE
							StatusAktif = 'Aktif' 
						UNION
						SELECT
							KdSopir AS nik,
							NamaSopir AS namapeg,
							'-' AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							TrTs_SopirRental 
						WHERE
							StatusAktif = 'Aktif' 
						UNION
						SELECT
							nik,
							namapeg,
							jabatan,
							departemen,
							CASE
								WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
								ELSE Subdepartemen1 + ', ' + Subdepartemen2
							END AS Subdepartemen
						FROM
							dbhrm.dbo.tbPegawai 
						WHERE
							status_aktif = 'AKTIF' 
					)Q2 ON Q1.NIK = Q2.NIK
				)Q5 ON Q1.NO_SPJ = Q5.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NO_TNBK,
						NAMA_FILE
					FROM
						SPJ_GAMBAR_KENDARAAN
					WHERE
						STAR = 'Y'
				)Q6 ON Q1.NO_TNKB = Q6.NO_TNBK
				$byId
				ORDER BY
					TGL_SPJ DESC";
		return $this->db->query($sql);
	}
	public function getSPJ2($bulan, $tahun, $jenis, $search, $group)
	{
		$sql ="SELECT
					Q1.*,
					NIK_DRIVER,
					NAMA_DRIVER,
					PIC_DRIVER,
					JML_US_TAMBAHAN_1,
					JML_US_TAMBAHAN_2,
					JML_MAKAN_TAMBAHAN
				FROM
				(
					SELECT
						ID_SPJ,
						a.TGL_INPUT,
						a.PIC_INPUT,
						namapeg AS NAMA_INPUT,
						jabatan AS JABATAN_INPUT,
						departemen AS DEPARTEMEN_INPUT,
						JENIS_ID,
						NAMA_JENIS,
						NO_SPJ,
						QR_CODE,
						TGL_SPJ,
						GROUP_ID,
						NAMA_GROUP,
						TOTAL_UANG_SAKU,
						TOTAL_UANG_MAKAN,
						TOTAL_UANG_JALAN,
						TOTAL_UANG_BBM,
						TOTAL_UANG_TOL,
						STATUS_SPJ,
						ADJUSTMENT_MANAJEMEN
					FROM
						SPJ_PENGAJUAN a
					LEFT JOIN
						dbhrm.dbo.tbPegawai b ON
					a.PIC_INPUT = b.nik
					INNER JOIN SPJ_JENIS c ON
					a.JENIS_ID = c.ID_JENIS
					INNER JOIN SPJ_GROUP_TUJUAN d ON
					a.GROUP_ID = d.ID_GROUP
					WHERE
						STATUS_PERJALANAN = 'IN' AND
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%' AND
						NO_SPJ LIKE '$search%' AND
						GROUP_ID LIKE '$group%'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						NIK AS NIK_DRIVER,
						NAMA AS NAMA_DRIVER,
						NIK+' - '+NAMA AS PIC_DRIVER
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						JENIS_PIC = 'Sopir'
				)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						COUNT(ID) AS JML_US_TAMBAHAN_1,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						UANG_SAKU1 > 0
					GROUP BY NO_SPJ
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
				LEFT JOIN
				(
					SELECT
						COUNT(ID) AS JML_US_TAMBAHAN_2,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						UANG_SAKU2 > 0
					GROUP BY NO_SPJ
				)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ
				LEFT JOIN
				(
					SELECT
						COUNT(ID) AS JML_MAKAN_TAMBAHAN,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						UANG_MAKAN > 0
					GROUP BY NO_SPJ
				)Q5 ON Q1.NO_SPJ = Q5.NO_SPJ
				ORDER BY
					TGL_SPJ DESC";
		return $this->db->query($sql);
	}
	public function getNoSPJByID($id)
	{
		$sql = $this->db->query("SELECT NO_SPJ FROM SPJ_PENGAJUAN WHERE ID_SPJ = $id");
		$no = '';
		foreach ($sql->result() as $key) {
			$no = $key->NO_SPJ;
		}
		return $no;
	}
	public function getLokasiByNoSPJ($bulan, $tahun, $jenis, $search, $id)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$sql = "SELECT
					Q1.SERLOK_KOTA,
					Q1.NO_SPJ,
					OBJEK,
					SERLOK_COMPANY,
					NAMA_GROUP
				FROM
				(
					SELECT
						SERLOK_KOTA,
						NO_SPJ,
						OBJEK,
						SERLOK_COMPANY,
						NAMA_GROUP
					FROM
						SPJ_PENGAJUAN_LOKASI a
					INNER JOIN SPJ_GROUP_TUJUAN b ON a.GROUP_ID = b.ID_GROUP
				)Q1
				INNER JOIN
				(
					SELECT
						ID_SPJ,
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%'
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				$byId
				ORDER BY SERLOK_KOTA ASC";
		return $this->db->query($sql);
	}
	public function getTujuanByNoSPJ($bulan, $tahun, $jenis, $search, $id)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$sql = "SELECT DISTINCT
					Q1.SERLOK_KOTA,
					Q2.NO_SPJ
				FROM
				(
					SELECT
						SERLOK_KOTA,
						NO_SPJ,
						OBJEK,
						SERLOK_COMPANY,
						NAMA_GROUP
					FROM
						SPJ_PENGAJUAN_LOKASI a
					INNER JOIN SPJ_GROUP_TUJUAN b ON a.GROUP_ID = b.ID_GROUP
				)Q1
				INNER JOIN
				(
					SELECT
						ID_SPJ,
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%'
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				$byId
				ORDER BY SERLOK_KOTA ASC";
		return $this->db->query($sql);
	}
	public function getPICPendampingByNoSPJ($bulan, $tahun, $jenis, $search, $id)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$sql = "SELECT
					Q1.NIK + ' - ' + namapeg AS PIC,
					NO_PENGAJUAN,
					Q1.NIK AS NIK_DRIVER,
					namapeg AS NAMA_DRIVER,
					jabatan AS JABATAN_DRIVER,
					departemen AS DEPARTEMEN_DRIVER,
					Subdepartemen AS SUB_DEPARTEMEN_DRIVER,
					UANG_SAKU,
					UANG_MAKAN,
					SORTIR,
					OBJEK
				FROM
				(
					SELECT
						NO_PENGAJUAN,
						NIK,
						UANG_SAKU,
						UANG_MAKAN,
						SORTIR,
						OBJEK
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						JENIS_PIC !='Sopir'
				)Q1
				LEFT JOIN
				(
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'-' AS jabatan,
						'-' AS departemen,
						'-' AS Subdepartemen
					FROM
						TrTs_SopirLogistik 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'-' AS jabatan,
						'-' AS departemen,
						'-' AS Subdepartemen
					FROM
						TrTs_SopirRental 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						nik,
						namapeg,
						jabatan,
						departemen,
						CASE
							WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
							ELSE Subdepartemen1 + ', ' + Subdepartemen2
						END AS Subdepartemen
					FROM
						dbhrm.dbo.tbPegawai 
					WHERE
						status_aktif = 'AKTIF' 
				)Q2 ON Q1.NIK = Q2.NIK
				INNER JOIN
				(
					SELECT
						ID_SPJ,
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%'
				)Q3 ON Q1.NO_PENGAJUAN = Q3.NO_SPJ
				$byId";
		return $this->db->query($sql);
	}
	public function saveDebit($inputDebit, $inputId, $inputJenis, $inputJenisKasbon)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$this->db->query("Execute SPJ_tambahBiayaKasbon '$inputJenisKasbon','Overbooking','$inputDebit','-','$inputJenis','$user','$tanggal'");
	}
	public function getKasbonSPJ($jenisKasbon, $filJenis, $filBulan, $filTahun)
	{
		$sql = "Execute SPJ_biayaKasbon '$jenisKasbon', '$filJenis', '$filBulan%','$filTahun%'";
		return $this->db->query($sql);
	}
	public function monitoring_voucher()
	{
		$sql = "SELECT TOP 1000
					*
				FROM
				(
					SELECT
						ID,
						NO_VOUCHER,
						RP,
						TGL_INPUT AS TGL_VOUCHER
					FROM
						SPJ_VOUCHER_BBM
					WHERE
						STATUS = 'USED'
				)Q1
				INNER JOIN
				(
					SELECT
						* 
					FROM
					(
						SELECT
							ID_SPJ,
							TGL_INPUT,
							JENIS_ID,
							NO_SPJ,
							TGL_SPJ,
							QR_CODE,
							PIC_INPUT,
							JENIS_KENDARAAN,
							NO_INVENTARIS,
							NO_TNKB,
							MERK,
							TYPE,
							GROUP_ID,
							STATUS_SPJ,
							KENDARAAN,
							VOUCHER_ID
						FROM
							SPJ_PENGAJUAN
						WHERE
							STATUS_DATA = 'SAVED'
					)Q1
					LEFT JOIN
					(
						SELECT
							ID_GROUP,
							NAMA_GROUP
						FROM
							SPJ_GROUP_TUJUAN
					)Q3 ON Q1.GROUP_ID = Q3.ID_GROUP
					LEFT JOIN
					(
						SELECT
							ID_JENIS,
							NAMA_JENIS
						FROM
							SPJ_JENIS
					)Q4 ON Q1.JENIS_ID = Q4.ID_JENIS
					LEFT JOIN
					(
						SELECT
							Q1.NIK + ' - ' + namapeg AS PIC_DRIVER,
							NO_PENGAJUAN,
							Q1.NIK AS NIK_DRIVER,
							namapeg AS NAMA_DRIVER,
							jabatan AS JABATAN_DRIVER,
							departemen AS DEPARTEMEN_DRIVER,
							Subdepartemen AS SUB_DEPARTEMEN_DRIVER,
							UANG_SAKU,
							UANG_MAKAN,
							SORTIR,
							OBJEK
						FROM
						(
							SELECT
								NO_PENGAJUAN,
								NIK,
								UANG_SAKU,
								UANG_MAKAN,
								SORTIR,
								OBJEK
							FROM
								SPJ_PENGAJUAN_PIC
							WHERE
								JENIS_PIC ='Sopir'
						)Q1
						LEFT JOIN
						(
							SELECT
								KdSopir AS nik,
								NamaSopir AS namapeg,
								'-' AS jabatan,
								'-' AS departemen,
								'-' AS Subdepartemen
							FROM
								TrTs_SopirLogistik 
							WHERE
								StatusAktif = 'Aktif' 
							UNION
							SELECT
								KdSopir AS nik,
								NamaSopir AS namapeg,
								'-' AS jabatan,
								'-' AS departemen,
								'-' AS Subdepartemen
							FROM
								TrTs_SopirRental 
							WHERE
								StatusAktif = 'Aktif' 
							UNION
							SELECT
								nik,
								namapeg,
								jabatan,
								departemen,
								CASE
									WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
									ELSE Subdepartemen1 + ', ' + Subdepartemen2
								END AS Subdepartemen
							FROM
								dbhrm.dbo.tbPegawai 
							WHERE
								status_aktif = 'AKTIF' 
						)Q2 ON Q1.NIK = Q2.NIK
					)Q5 ON Q1.NO_SPJ = Q5.NO_PENGAJUAN
				)Q2 ON Q1.ID = Q2.VOUCHER_ID
				ORDER BY
					NO_VOUCHER DESC";
		return $this->db->query($sql);
	}
	public function getPICPengajuanVersi2($noSpj)
	{
		$sql = "SELECT
					Q1.*,
					Q2.SET_OUT,
					Q2.SET_IN,
					Q2.KETERANGAN_OUT,
					Q2.KETERANGAN_IN,
					UANG_SAKU1,
					UANG_SAKU2,
					UANG_MAKAN_TAMBAHAN,
					STATUS_US1,
					STATUS_US2,
					STATUS_MAKAN
				FROM
				(
					SELECT
						Q1.NIK + ' - ' + namapeg AS PIC,
						NO_PENGAJUAN,
						Q1.NIK AS NIK,
						namapeg AS NAMA,
						jabatan AS JABATAN,
						departemen AS DEPARTEMEN,
						Subdepartemen AS SUB_DEPARTEMEN,
						UANG_SAKU,
						UANG_MAKAN,
						SORTIR,
						OBJEK,
						JENIS_PIC
					FROM
					(
						SELECT
							NO_PENGAJUAN,
							NIK,
							UANG_SAKU,
							UANG_MAKAN,
							SORTIR,
							OBJEK,
							JENIS_PIC
						FROM
							SPJ_PENGAJUAN_PIC
						WHERE
							NO_PENGAJUAN = '$noSpj'
					)Q1
					LEFT JOIN
					(
						SELECT
							KdSopir AS nik,
							NamaSopir AS namapeg,
							'-' AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							TrTs_SopirLogistik 
						WHERE
							StatusAktif = 'Aktif' 
						UNION
						SELECT
							KdSopir AS nik,
							NamaSopir AS namapeg,
							'-' AS jabatan,
							'-' AS departemen,
							'-' AS Subdepartemen
						FROM
							TrTs_SopirRental 
						WHERE
							StatusAktif = 'Aktif' 
						UNION
						SELECT
							nik,
							namapeg,
							jabatan,
							departemen,
							CASE
								WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
								ELSE Subdepartemen1 + ', ' + Subdepartemen2
							END AS Subdepartemen
						FROM
							dbhrm.dbo.tbPegawai 
						WHERE
							status_aktif = 'AKTIF' 
					)Q2 ON Q1.NIK = Q2.NIK
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						PIC,
						SET_OUT,
						SET_IN,
						KETERANGAN_OUT,
						KETERANGAN_IN
					FROM
						SPJ_VALIDASI_PIC
				)Q2 ON Q1.NO_PENGAJUAN = Q2.NO_SPJ AND Q1.NIK = Q2.PIC
				LEFT JOIN
				(
					SELECT
						UANG_SAKU1,
						UANG_SAKU2,
						UANG_MAKAN AS UANG_MAKAN_TAMBAHAN,
						STATUS_US1,
						STATUS_US2,
						STATUS_MAKAN,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
				)Q3 ON Q1.NO_PENGAJUAN = Q3.NO_SPJ";
		return $this->db->query($sql);
	}
}
?>
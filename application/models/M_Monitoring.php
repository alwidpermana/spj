<?php
class M_Monitoring extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getSPJ($bulan, $tahun, $jenis, $search, $id, $adjustment, $implementasi)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$byAdjust = $adjustment == ''?'':" AND STATUS_SPJ = 'OPEN' AND ADJUSTMENT_MANAJEMEN = 'Y'";
		$byStep1 = $implementasi == 'Y'?" AND STATUS_PERJALANAN = 'IN'":"";
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
						STATUS_PERJALANAN,
						VOUCHER_BBM
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%' AND
						NO_SPJ LIKE '$search%' $byAdjust $byStep1
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
				LEFT JOIN
				(
					SELECT
						NIK AS NIK_OTORITAS,
						FOTO_WAJAH
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q7 ON Q5.NIK_DRIVER = Q7.NIK_OTORITAS
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
						GROUP_ID LIKE '$group%' AND
						STATUS_SPJ = 'OPEN' 
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
				LEFT JOIN
				(
					SELECT
						COUNT(ID) AS JML_ADJUSTMENT,
						NO_SPJ
					FROM
						SPJ_ADJUSTMENT
					GROUP BY NO_SPJ
				)Q6 ON Q1.NO_SPJ = Q6.NO_SPJ
				WHERE
					JML_ADJUSTMENT > 0
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
					OBJEK,
					FOTO_WAJAH
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
				LEFT JOIN
				(
					SELECT
						NIK AS NIK_OTORITAS,
						FOTO_WAJAH
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q4 ON Q1.NIK = Q4.NIK_OTORITAS
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
							VOUCHER_BBM
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
				)Q2 ON Q1.NO_VOUCHER = Q2.VOUCHER_BBM
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
	public function getGenerateSPJ($bulan, $tahun, $jenisSPJ, $status, $awal, $akhir)
	{
		$sql = "SELECT
					NO_GENERATE,
					TGL_GENERATE,
					JML_SPJ,
					TOTAL_RP,
					TGL_RECEIVE,
					STATUS_RECEIVE,
					PIC_INPUT
				FROM
					SPJ_GENERATE
				WHERE
				DATENAME(MONTH,TGL_GENERATE) LIKE '$bulan%' AND
				YEAR(TGL_GENERATE) LIKE '$tahun%' AND
				JENIS_SPJ LIKE '$jenisSPJ%' AND
				TGL_GENERATE BETWEEN '$awal' AND '$akhir'
				ORDER BY
					NO_GENERATE DESC";
		return $this->db->query($sql);
	}
	public function getMonitoringSPJHarian($bulan, $tahun, $jenis, $hari)
	{
		$sql = "SELECT
					NO_SPJ,
					STATUS_SPJ,
					SUM(
						TOTAL_UANG_SAKU + 
						TOTAL_UANG_MAKAN + 
						TOTAL_UANG_JALAN + 
						TOTAL_UANG_BBM + 
						TOTAL_UANG_TOL) AS RP
				FROM
					SPJ_PENGAJUAN
				WHERE
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun AND
					DAY(TGL_SPJ) = $hari AND
					JENIS_ID = $jenis AND
					STATUS_DATA = 'SAVED'
				GROUP BY 
					NO_SPJ, STATUS_SPJ";
		return $this->db->query($sql);
	}
	public function getSPJByGenerate($noGenerate)
	{
		$sql = "SELECT
					Q1.*,
					PIC_DRIVER,
					NAMA_PENGAJU
				FROM
				(
					SELECT
						ID_SPJ,
						NO_SPJ,
						TGL_SPJ,
						PIC_INPUT,
						KENDARAAN,
						NO_TNKB,
						TOTAL_UANG_SAKU,
						TOTAL_UANG_JALAN,
						TOTAL_UANG_MAKAN,
						TOTAL_UANG_BBM,
						TOTAL_UANG_TOL
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_GENERATE = '$noGenerate'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						NIK+' - '+NAMA AS PIC_DRIVER
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						JENIS_PIC = 'Sopir'
				)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						nik,
						namapeg AS NAMA_PENGAJU
					FROM
						dbhrm.dbo.tbpegawai
				)Q3 ON Q1.PIC_INPUT = Q3.nik";
		return $this->db->query($sql);
	}
	public function getPendampingByNoGenerate($noGenerate)
	{
		$sql = "SELECT
					NO_SPJ,
					NIK +' - '+NAMA AS PIC_PENDAMPING
				FROM
					SPJ_PENGAJUAN a 
				LEFT JOIN SPJ_PENGAJUAN_PIC b ON
				a.NO_SPJ = b.NO_PENGAJUAN
				WHERE
					NO_GENERATE = '$noGenerate'";
		return $this->db->query($sql);
	}
	public function getMonitoringSPJHarian2($bulan, $tahun, $jenis)
	{
		$sql = $this->db->query("Execute SPJ_monitoringHarian $tahun, $bulan, $jenis");
    	return $sql;

	}
	public function getUrutanTerbesar($bulan, $tahun, $jenis)
	{
		$sql = "SELECT
					MAX(NO_URUT) AS URUTAN_TERBESAR
				FROM
				(
					SELECT
						ROW_NUMBER() over (partition by HARI order by HARI asc) AS NO_URUT,
						*
					FROM
					(
						SELECT
							DAY(TGL_SPJ) AS HARI
						FROM
							SPJ_PENGAJUAN
						WHERE
							MONTH(TGL_SPJ) = $bulan AND
							YEAR(TGL_SPJ) = $tahun AND
							JENIS_ID = $jenis AND
							STATUS_DATA = 'SAVED'
						GROUP BY 
							NO_SPJ, TGL_SPJ
					)Q1
				)Q1";
		return $this->db->query($sql);
	}
	public function getInOutKendaraan($bulan, $tahun)
	{
		$view = "";
		$join ="";
		for ($i=1; $i <=31 ; $i++) { 
			$view.=" , Q".$i.".NO_SPJ_$i, Q".$i.".KEBERANGKATAN_".$i;
			$join .=" LEFT JOIN
					(
						SELECT
							NO_SPJ AS NO_SPJ_".$i.",
							KEBERANGKATAN AS KEBERANGKATAN_".$i.",
							KEPULANGAN AS KEPULANGAN_".$i."
						FROM
							SPJ_VALIDASI
						WHERE
							DAY(KEBERANGKATAN) = ".$i."
					)Q".$i." ON QSPJ.NO_SPJ = Q".$i.".NO_SPJ_".$i;
		}
		$sql = "SELECT
					QKendaraan.*
					$view
				FROM
				(
					SELECT DISTINCT
						KENDARAAN,
						JENIS_KENDARAAN,
						NO_INVENTARIS,
						MERK,
						TYPE,
						NO_TNKB
					FROM
						SPJ_PENGAJUAN 
					WHERE
						STATUS_DATA = 'SAVED'
				)QKendaraan
				LEFT JOIN
				(
					SELECT
						NO_TNKB,
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						MONTH(TGL_SPJ) = 5 AND
						YEAR(TGL_SPJ) = 2022
				)QSPJ ON QKendaraan.NO_TNKB = QSPJ.NO_TNKB
				$join";
		return $this->db->query($sql);
	}
	public function getInOutKendaraan2($bulan, $tahun)
	{
		$sql = "SELECT DISTINCT
					KENDARAAN,
					JENIS_KENDARAAN,
					NO_INVENTARIS,
					MERK,
					TYPE,
					NO_TNKB
				FROM
					SPJ_PENGAJUAN
				WHERE
					STATUS_DATA = 'SAVED' AND
					STATUS_PERJALANAN = 'IN' AND
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun
				ORDER BY
					NO_TNKB ASC";
		return $this->db->query($sql);
	}
	public function getInOutKendaraanDetail($bulan, $tahun)
	{
		$sql = "SELECT
					a.NO_SPJ,
					NO_TNKB,
					KEBERANGKATAN,
					KEPULANGAN,
					DAY(KEBERANGKATAN) AS JALAN
				FROM
					SPJ_PENGAJUAN a
				LEFT JOIN SPJ_VALIDASI b ON
				a.NO_SPJ = b.NO_SPJ
				WHERE
					STATUS_DATA = 'SAVED' AND
					STATUS_PERJALANAN = 'IN' AND
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun
				ORDER BY
					NO_TNKB ASC";
		return $this->db->query($sql);
	}
	public function getInOutPIC($bulan, $tahun)
	{
		$sql = "SELECT
					Q1.NIK,
					namapeg,
					departemen,
					Subdepartemen,
					jabatan, 
					SUBJEK,
					REKANAN
				FROM
				(
					SELECT DISTINCT
						NIK
					FROM
						SPJ_PENGAJUAN_PIC a
					INNER JOIN SPJ_PENGAJUAN b
					ON a.NO_PENGAJUAN = b.NO_SPJ
					WHERE
						STATUS_DATA = 'SAVED' AND
						STATUS_PERJALANAN = 'IN' AND
						MONTH(TGL_SPJ) = $bulan AND
						YEAR(TGL_SPJ) = $tahun
				)Q1
				LEFT JOIN
				(
					SELECT
						nik,
						namapeg,
						departemen,
						CASE 
							WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
							ELSE Subdepartemen1+', '+Subdepartemen2
						END AS Subdepartemen,
						jabatan
					FROM
						dbhrm.dbo.tbPegawai
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'',
						'',
						status AS jabatan
					FROM
						TrTs_SopirLogistik 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'',
						'',
						status AS jabatan
					FROM
						TrTs_SopirRental 
					WHERE
						StatusAktif = 'Aktif'
				)Q2 ON Q1.NIK = Q2.nik
				LEFT JOIN
				(
					SELECT
						NIK,
						SUBJEK,
						REKANAN
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q3 ON Q1.NIK = Q3.NIK
				ORDER BY namapeg ASC";
		return $this->db->query($sql);
	}
	public function getInOutPICDetail($bulan, $tahun)
	{
		$sql = "SELECT DISTINCT
					NIK,
					NO_SPJ,
					UANG_SAKU,
					UANG_MAKAN,
					DAY(TGL_SPJ) AS JALAN,
					CASE 
						WHEN JENIS_PIC = 'Sopir' THEN 'Driver'
						ELSE 'Pendamping'
					END AS SEBAGAI
				FROM
					SPJ_PENGAJUAN_PIC a
				INNER JOIN SPJ_PENGAJUAN b
				ON a.NO_PENGAJUAN = b.NO_SPJ
				WHERE
					STATUS_DATA = 'SAVED' AND
					STATUS_PERJALANAN = 'IN' AND
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun";
		return $this->db->query($sql);
	}
	public function getMonitoringKMKendaraan($bulan, $tahun)
	{
		$sql = "SELECT
					a.NO_SPJ,
					NO_TNKB,
					DAY(TGL_SPJ) AS JALAN,
					KM_OUT,
					KM_IN
				FROM
					SPJ_PENGAJUAN a
				LEFT JOIN
					SPJ_VALIDASI b
				ON a.NO_SPJ = b.NO_SPJ
				WHERE
					STATUS_DATA = 'SAVED' AND
					STATUS_PERJALANAN = 'IN' AND
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun";
		return $this->db->query($sql);
	}
	public function getMonitoringKendaraanKe2($bulan, $tahun, $jenis)
	{
		$sql = "Execute SPJ_monitoringKendaraanKe2 $bulan, $tahun, $jenis";
		return $this->db->query($sql);
	}
	public function getMonitoringPICKe2($bulan, $tahun)
	{
		$sql = "SELECT
					Q1.NIK,
					namapeg,
					departemen,
					Subdepartemen,
					jabatan, 
					SUBJEK,
					REKANAN
				FROM
				(
					SELECT DISTINCT
						NIK
					FROM
					(
						SELECT
							a.NO_SPJ
						FROM
							SPJ_PENGAJUAN a
						LEFT JOIN SPJ_BIAYA_TAMBAHAN b
						ON a.NO_SPJ = b.NO_SPJ
						WHERE
							MONTH(TGL_SPJ) = $bulan AND
							YEAR(TGL_SPJ) = $tahun AND
							STATUS_PERJALANAN = 'IN' AND
							UANG_SAKU1>0 AND
							UANG_SAKU2>0 AND
							UANG_MAKAN >0
					)Q1
					LEFT JOIN
					(
						SELECT
							NO_PENGAJUAN,
							NIK
						FROM
							SPJ_PENGAJUAN_PIC
					)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				)Q1
				LEFT JOIN
				(
					SELECT
						nik,
						namapeg,
						departemen,
						CASE 
							WHEN Subdepartemen2 IS NULL OR Subdepartemen2 = '' THEN Subdepartemen1
							ELSE Subdepartemen1+', '+Subdepartemen2
						END AS Subdepartemen,
						jabatan
					FROM
						dbhrm.dbo.tbPegawai
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'',
						'',
						status AS jabatan
					FROM
						TrTs_SopirLogistik 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'',
						'',
						status AS jabatan
					FROM
						TrTs_SopirRental 
					WHERE
						StatusAktif = 'Aktif'
				)Q2 ON Q1.NIK = Q2.nik
				LEFT JOIN
				(
					SELECT
						NIK,
						SUBJEK,
						REKANAN
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q3 ON Q1.NIK = Q3.NIK
				ORDER BY namapeg ASC";
		return $this->db->query($sql);
	}
	public function getMonitoringPICKe2Detail($bulan, $tahun)
	{
		$sql = "SELECT
					a.NO_SPJ,
					NIK,
					DAY(TGL_SPJ) AS TGL
				FROM
					SPJ_PENGAJUAN a
				LEFT JOIN SPJ_PENGAJUAN_PIC b
				ON a.NO_SPJ = b.NO_PENGAJUAN
				LEFT JOIN SPJ_BIAYA_TAMBAHAN c
				ON a.NO_SPJ = c.NO_SPJ
				WHERE
					MONTH(TGL_SPJ) = $bulan AND
					YEAR(TGL_SPJ) = $tahun AND
					STATUS_PERJALANAN = 'IN' AND
					UANG_SAKU1 > 0 AND
					UANG_SAKU2 > 0 AND
					c.UANG_MAKAN > 0";
		return $this->db->query($sql);
	}
}
?>
<?php
class M_Monitoring extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getSPJ($bulan, $tahun, $jenis, $search, $id, $adjustment, $implementasi)
	{
		$filPeriode = $this->input->get("filPeriode");
		$periodeAwal = $this->input->get("periodeAwal");
		$periodeAkhir = $this->input->get("periodeAkhir");
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$byAdjust = $adjustment == ''?'':" AND STATUS_SPJ = 'OPEN' AND ADJUSTMENT_MANAJEMEN = 'Y'";
		$byStep1 = $implementasi == 'Y'?" AND STATUS_PERJALANAN = 'IN' AND STATUS_SPJ = 'OPEN'":"";
		$filStatus = $this->input->get("filStatus");
		if ($filStatus == '') {
			$whereStatus = '';
		}elseif ($filStatus == 'Waiting For Generate') {
			$whereStatus = " AND STATUS_SPJ = 'CLOSE' AND NO_GENERATE IS NULL";
		}elseif($filStatus == 'CLOSE'){
			$whereStatus =" AND STATUS_SPJ = 'CLOSE' AND NO_GENERATE IS NOT NULL";
		}else{
			$whereStatus =" AND STATUS_SPJ = '$filStatus'";
		}

		if ($filPeriode == '') {
			$wherePeriode = "";
			
		}else{
			$wherePeriode = " AND TGL_SPJ BETWEEN '$periodeAwal' AND '$periodeAkhir'";
		}

		$sql = "SELECT
				  *
				FROM
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
							VOUCHER_BBM,
							NO_GENERATE,
							ABNORMAL,
							LOKAL_SELESAI,
							REKANAN_KENDARAAN,
							REKANAN_ID,
							TAMBAHAN_UANG_JALAN,
							VOUCHER,
							IMPLEMENTASI
						FROM
							SPJ_PENGAJUAN
						WHERE
							STATUS_DATA = 'SAVED' AND
							JENIS_ID LIKE '$jenis%' $byAdjust $byStep1 $whereStatus $wherePeriode
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
					LEFT JOIN
					(
						SELECT
							NO_BT,
							UANG_SAKU1 * JML_PIC_SAKU AS US1,
							UANG_SAKU2 * JML_PIC_SAKU AS US2,
							UANG_MAKAN * JML_PIC_MAKAN AS UM,
							STATUS_US1,
							STATUS_US2,
							STATUS_MAKAN,
							KEPUTUSAN_US1,
							KEPUTUSAN_US2,
							KEPUTUSAN_MAKAN
						FROM
						(
							SELECT
								NO_SPJ AS NO_BT,
								UANG_SAKU1,
								UANG_SAKU2,
								UANG_MAKAN,
								STATUS_US1,
								STATUS_US2,
								STATUS_MAKAN,
								KEPUTUSAN_US1,
								KEPUTUSAN_US2,
								KEPUTUSAN_MAKAN
							FROM
								SPJ_BIAYA_TAMBAHAN
						)Q1
						INNER JOIN
						(
							SELECT
								NO_PENGAJUAN,
								SUM(JML_PIC) AS JML_PIC_SAKU,
								COUNT(NIK) AS JML_PIC_MAKAN
							FROM
							(
								SELECT
									NIK,
									NO_PENGAJUAN,
									CASE 
										WHEN Kendaraan = 'Rental' AND JENIS_PIC = 'Sopir' THEN 0
										ELSE 1
									END AS JML_PIC
								FROM
									SPJ_PENGAJUAN_PIC a
								INNER JOIN
									SPJ_PENGAJUAN b
								ON a.NO_PENGAJUAN = b.NO_SPJ
							)Q1
							GROUP BY NO_PENGAJUAN
						)Q2 ON Q1.NO_BT = Q2.NO_PENGAJUAN
					)Q8 ON Q1.NO_SPJ = Q8.NO_BT
					LEFT JOIN
					(
						SELECT
							NO_SPJ AS NO_ADJUSTMENT,
							SUM(DIAJUKAN) AS BIAYA_ADJUSTMENT
						FROM
							SPJ_ADJUSTMENT
						GROUP BY NO_SPJ
					)Q9 ON Q1.NO_SPJ = Q9.NO_ADJUSTMENT
					LEFT JOIN
					(
						SELECT
							Q1.*,
							OK_OUT,
							OK_IN,
							JML_PIC,
							CASE 
								WHEN OK_OUT = JML_PIC THEN 'OK'
								ELSE 'NG'
							END AS VALIDASI_OUT,
							CASE 
								WHEN OK_IN = JML_PIC THEN 'OK'
								ELSE 'NG'
							END AS VALIDASI_IN
						FROM
						(
							SELECT
								NO_SPJ AS NO_VALIDASI,
								KEBERANGKATAN,
								KEPULANGAN,
								KM_OUT,
								KM_IN
							FROM
								SPJ_VALIDASI
						)Q1
						LEFT JOIN
						(
							SELECT
								NO_SPJ, 
								COUNT(NO_SPJ) AS OK_OUT 
							FROM
								SPJ_VALIDASI_PIC
							WHERE
								SET_OUT = 'OK'
							GROUP BY NO_SPJ
						)Q2 ON Q1.NO_VALIDASI = Q2.NO_SPJ
						LEFT JOIN
						(
							SELECT
								NO_SPJ, 
								COUNT(NO_SPJ) AS OK_IN
							FROM
								SPJ_VALIDASI_PIC
							WHERE
								SET_IN = 'OK'
							GROUP BY NO_SPJ
						)Q3 ON Q1.NO_VALIDASI = Q3.NO_SPJ
						INNER JOIN
						(
							SELECT
								COUNT(NO_PENGAJUAN) AS JML_PIC,
								NO_PENGAJUAN
							FROM
								SPJ_PENGAJUAN_PIC
							GROUP BY
								NO_PENGAJUAN
						)Q4 ON Q1.NO_VALIDASI = Q4.NO_PENGAJUAN
					)Q10 ON Q1.NO_SPJ = Q10.NO_VALIDASI
					LEFT JOIN
					(
						SELECT
							NO_PENGAJUAN AS NO_TOTAL,
							SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
							SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
						FROM
							SPJ_PENGAJUAN_PIC
						GROUP BY
							NO_PENGAJUAN		
					)Q11 ON Q1.NO_SPJ = Q11.NO_TOTAL
					LEFT JOIN
					(
						SELECT
							ID AS ID_REKANAN,
							NAMA
						FROM
							SPJ_REKANAN
					)Q12 ON Q1.REKANAN_KENDARAAN = Q12.NAMA

					WHERE 
						NO_SPJ LIKE '%$search%' OR
						QR_CODE LIKE '%$search%'
				)Q1 
				$byId
				ORDER BY
					TGL_SPJ DESC, ID_SPJ DESC";
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
						COUNT(ID) AS JML_TAMBAHAN,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						UANG_SAKU1 > 0 OR
						UANG_SAKU2 > 0 OR
						UANG_MAKAN > 0
					GROUP BY NO_SPJ
				)Q6 ON Q1.NO_SPJ = Q6.NO_SPJ
				WHERE
					JML_TAMBAHAN > 0 OR
					ADJUSTMENT_MANAJEMEN = 'Y'
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
	public function getLokasiByNoSPJ($bulan, $tahun, $jenis, $search, $id, $status)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$whereStatus = $status == '' ? '' : " AND STATUS_SPJ LIKE '$status%'";
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
						JENIS_ID LIKE '$jenis%' $whereStatus
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				$byId
				ORDER BY SERLOK_KOTA ASC";
		return $this->db->query($sql);
	}
	public function getTujuanByNoSPJ($bulan, $tahun, $jenis, $search, $id, $status)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$whereStatus = $status == '' ? '' : " AND STATUS_SPJ LIKE '$status%'";
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
						JENIS_ID LIKE '$jenis%' $whereStatus
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				$byId
				ORDER BY SERLOK_KOTA ASC";
		return $this->db->query($sql);
	}

	public function getPICPendampingByNoSPJ_v2($noSPJ)
	{
		$sql = $this->db->query("SELECT
					'<li>'+b.NIK+' - '+b.NAMA+'</li>' AS PIC_PENDAMPING
				FROM
					SPJ_PENGAJUAN a
				INNER JOIN
					SPJ_PENGAJUAN_PIC b ON
				a.NO_SPJ = b.NO_PENGAJUAN
				WHERE
					a.NO_SPJ = '$noSPJ' AND
					b.JENIS_PIC = 'Pendamping'");
		$html="";
		if ($sql->num_rows()>0) {
			foreach ($sql->result() as $key) {
				$html.=$key->PIC_PENDAMPING;
			}
		}

		return ($html);
	}

	public function getPICPendampingByNoSPJ($bulan, $tahun, $jenis, $search, $id, $status)
	{
		$byId = $id == ''?'':" WHERE ID_SPJ = '$id'";
		$whereStatus = $status == '' ? '' : " AND STATUS_SPJ LIKE '$status%'";
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
						JENIS_ID LIKE '$jenis%' $whereStatus
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
		$sql = "Execute SPJ_biayaKasbon2 '$jenisKasbon', '$filJenis', '$filBulan','$filTahun'";
		return $this->db->query($sql);
	}
	public function monitoring_voucher($filStatus, $filSearch, $filJenis, $where)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						ROW_NUMBER() over (partition by 'SAMA' order by TGL_INPUT DESC) AS NO_URUT,
						*
					FROM
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
								VOUCHER_BBM,
								TOTAL_UANG_BBM,
								NO_GENERATE,
								CASE
									WHEN STATUS_SPJ = 'OPEN' AND STATUS_PERJALANAN = 'IN' THEN 'OPEN'
									WHEN STATUS_SPJ = 'CLOSE' THEN 'CLOSE'
									ELSE '-'
								END AS STATUS_VOUCHER
							FROM
								SPJ_PENGAJUAN
							WHERE
								STATUS_DATA = 'SAVED' AND
								MEDIA_UANG_BBM = 'Voucher' AND
								JENIS_ID LIKE '$filJenis%' AND
								STATUS_PERJALANAN = 'IN' AND
								STATUS_SPJ IN ('OPEN','CLOSE')
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
						WHERE
							STATUS_VOUCHER LIKE '$filStatus%'
					)Q1
					WHERE
						NO_SPJ LIKE '$filSearch%' OR
						VOUCHER_BBM LIKE '$filSearch%'
				)Q1
				$where
				ORDER BY TGL_INPUT DESC";
		return $this->db->query($sql);
	}
	public function monitoring_voucher_v2($filStatus, $filSearch, $filJenis, $offset, $limit, $flag)
	{
		$sql = "Execute spj_monitoringVoucherBBM '$filStatus', '$filJenis', '$filSearch', '$offset','$limit','$flag'";
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
					CASE 
						WHEN KENDARAAN = 'Rental' AND JENIS_PIC = 'Driver' THEN 0
						ELSE UANG_SAKU1
					END AS UANG_SAKU1,
					CASE 
						WHEN KENDARAAN = 'Rental' AND JENIS_PIC = 'Driver' THEN 0
						ELSE UANG_SAKU2
					END AS UANG_SAKU2,
					UANG_MAKAN_TAMBAHAN,
					STATUS_US1,
					STATUS_US2,
					STATUS_MAKAN,
					ADJUSTMENT_UM,
					STATUS_UM,
					PIC_US1,
					PIC_US2,
					PIC_MAKAN,
					TGL_US1,
					TGL_US2,
					TGL_MAKAN,
					TGL_KEPUTUSAN,
					PIC_KEPUTUSAN,
					TGL_KEPUTUSAN_JALAN,
					PIC_KEPUTUSAN_JALAN,
					ADJUSTMENT_JALAN,
					STATUS_JALAN,
					FOTO_WAJAH
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
							CASE JENIS_PIC
								WHEN 'Sopir' THEN 'Driver'
								ELSE JENIS_PIC
							END AS JENIS_PIC
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
						PIC_US1,
						PIC_US2,
						PIC_MAKAN,
						TGL_US1,
						TGL_US2,
						TGL_MAKAN,
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
				)Q3 ON Q1.NO_PENGAJUAN = Q3.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						SUM(DIAJUKAN) AS ADJUSTMENT_UM,
						STATUS AS STATUS_UM,
						TGL_KEPUTUSAN,
						PIC_KEPUTUSAN
					FROM
						SPJ_ADJUSTMENT
					WHERE
						OBJEK = 'UANG MAKAN'
					GROUP BY
						NO_SPJ, STATUS, TGL_KEPUTUSAN, PIC_KEPUTUSAN
				)Q4 ON Q1.NO_PENGAJUAN = Q4.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						SUM(DIAJUKAN) AS ADJUSTMENT_JALAN,
						STATUS AS STATUS_JALAN,
						TGL_KEPUTUSAN AS TGL_KEPUTUSAN_JALAN,
						PIC_KEPUTUSAN AS PIC_KEPUTUSAN_JALAN
					FROM
						SPJ_ADJUSTMENT
					WHERE
						OBJEK = 'UANG JALAN'
					GROUP BY
						NO_SPJ, STATUS, TGL_KEPUTUSAN, PIC_KEPUTUSAN
				)Q5 ON Q1.NO_PENGAJUAN = Q5.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NIK,
						FOTO_WAJAH
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q6 ON Q1.NIK = Q6.NIK
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						KENDARAAN
					FROM
						SPJ_PENGAJUAN
				)Q7 ON Q1.NO_PENGAJUAN = Q7.NO_SPJ";
		return $this->db->query($sql);
	}
	public function getGenerateSPJ($bulan, $tahun, $jenisSPJ, $status, $wherePeiode, $whereID)
	{
		$sql = "SELECT
					Q1.*,
					TOTAL_SPJ,
					TOTAL_BBM,
					TOTAL_TOL
				FROM
				(
					SELECT
						ID,
						NO_GENERATE,
						TGL_GENERATE,
						JML_SPJ,
						TOTAL_RP,
						TGL_RECEIVE,
						STATUS_RECEIVE,
						PIC_INPUT,
						TOTAL_BA
					FROM
						SPJ_GENERATE
					WHERE
					DATENAME(MONTH,TGL_GENERATE) LIKE '$bulan%' AND
					YEAR(TGL_GENERATE) LIKE '$tahun%' AND
					JENIS_SPJ LIKE '$jenisSPJ%' $wherePeiode
				)Q1 
				LEFT JOIN
				(
					SELECT
						JUMLAH AS TOTAL_SPJ,
						DETAIL_TRANSAKSI
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						JENIS_KASBON = 'Kasbon SPJ'
				)Q2 ON Q1.NO_GENERATE = Q2.DETAIL_TRANSAKSI
				LEFT JOIN
				(
					SELECT
						JUMLAH AS TOTAL_BBM,
						DETAIL_TRANSAKSI
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						JENIS_KASBON = 'Kasbon BBM'
				)Q3 ON Q1.NO_GENERATE = Q3.DETAIL_TRANSAKSI
				LEFT JOIN
				(
					SELECT
						JUMLAH AS TOTAL_TOL,
						DETAIL_TRANSAKSI
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						JENIS_KASBON = 'Kasbon TOL'
				)Q4 ON Q1.NO_GENERATE = Q4.DETAIL_TRANSAKSI
				$whereID

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
		$sql = $this->db->query("Execute SPJ_monitoringHarian_v2 $tahun, $bulan, '$jenis'");
    	return $sql;
	}
	public function getMonitoringSPJHarianSummary($bulan, $tahun, $jenis, $where)
	{
		$sql = $this->db->query("Execute SPJ_monitoringHarianSummary_v2 $tahun, $bulan, '$jenis'");
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
	public function getInOutKendaraan2($bulan, $tahun, $where)
	{
		$sql = "SELECT DISTINCT
					*
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
					(
						SELECT
							a.KENDARAAN,
							a.JENIS_KENDARAAN,
							a.NO_INVENTARIS,
							a.MERK,
							a.TYPE,
							a.NO_TNKB,
							KM_IN - KM_OUT AS TOTAL_KM
						FROM
							SPJ_PENGAJUAN a
						INNER JOIN 
							SPJ_VALIDASI b ON
						a.NO_SPJ = b.NO_SPJ
						WHERE
							STATUS_DATA = 'SAVED' 
							AND STATUS_PERJALANAN = 'IN' 
							AND MONTH ( TGL_SPJ ) = $bulan
							AND YEAR ( TGL_SPJ ) = $tahun
					)Q1
					$where
					UNION
					SELECT DISTINCT
						Q2.*
					FROM
					(
						SELECT DISTINCT
							NO_TNKB							
						FROM
						(
							SELECT DISTINCT
								NO_TNKB,
								KM_OUT - KM_IN AS TOTAL_KM
							FROM
								SPJ_SCAN_KENDARAAN
							WHERE
								MONTH(TGL_SCAN) = $bulan AND
								YEAR(TGL_SCAN) = $tahun
						)Q1
						$where
					)Q1
					INNER JOIN
					(
						SELECT
							Kategori AS KENDARAAN,
							jenis AS JENIS_KENDARAAN,
							NoInventaris AS NO_INVENTARIS,
							Merk AS MERK,
							Type AS TYPE,
							NoTNKB AS NO_TNKB
						FROM
							GA.dbo.GA_TKendaraan
						UNION
						SELECT
							Kategori AS KENDARAAN,
							'Rental' AS JENIS_KENDARAAN,
							'-' AS NO_INVENTARIS,
							Merk AS MERK,
							Type AS TYPE,
							NoTNKB AS NO_TNKB
						FROM
							SPJ_KENDARAAN_REKANAN
					)Q2 ON Q1.NO_TNKB = Q2.NO_TNKB
				)Q1
				ORDER BY
						NO_TNKB ASC";
		return $this->db->query($sql);
	}
	public function getInOutKendaraanDetail($bulan, $tahun)
	{
		$sql = "SELECT
					a.ID_SPJ,
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
				UNION
				SELECT
					0 AS ID_SPJ,
					'-' AS NO_SPJ,
					NO_TNKB,
					TGL_SCAN,
					TGL_SCAN_IN,
					DAY(TGL_SCAN) AS JALAN
				FROM
					SPJ_SCAN_KENDARAAN
				WHERE
					MONTH(TGL_SCAN) = $bulan AND
					YEAR(TGL_SCAN) = $tahun
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
					ID_SPJ,
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
	public function getMonitoringKMKendaraan($bulan, $tahun, $where)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						a.NO_SPJ,
						ID_SPJ,
						NO_TNKB,
						DAY(TGL_SPJ) AS JALAN,
						KM_OUT,
						KM_IN,
						KM_IN - KM_OUT AS TOTAL_KM
					FROM
						SPJ_PENGAJUAN a
					LEFT JOIN
						SPJ_VALIDASI b
					ON a.NO_SPJ = b.NO_SPJ
					WHERE
						STATUS_DATA = 'SAVED' AND
						STATUS_PERJALANAN = 'IN' AND
						MONTH(TGL_SPJ) = $bulan AND
						YEAR(TGL_SPJ) = $tahun
				)Q1
				$where
				ORDER BY NO_SPJ DESC";
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
	public function getMonitoringPICKe2_v2($bulan, $tahun, $queryTambahan)
	{
		$sql = "SELECT
					Q2.*
				FROM
				(
					SELECT DISTINCT
						NIK
					FROM
					(
						SELECT
							NO_SPJ,
							KENDARAAN
						FROM
							SPJ_PENGAJUAN
						WHERE
							STATUS_DATA = 'SAVED' AND
							STATUS_PERJALANAN = 'IN' AND
							MONTH(TGL_SPJ) = $bulan AND
							YEAR(TGL_SPJ) = $tahun
					)Q1
					LEFT JOIN
					(
						SELECT
							b.NO_SPJ,
							a.NIK,
							JENIS_PIC
						FROM
							SPJ_PENGAJUAN_PIC a
						INNER JOIN
							SPJ_PENGAJUAN b 
						ON a.NO_PENGAJUAN = b.NO_SPJ
						WHERE
							KENDARAAN != 'Rental' AND
							JENIS_PIC = 'Sopir'
						UNION
						SELECT
							NO_PENGAJUAN,
							NIK,
							JENIS_PIC
						FROM
							SPJ_PENGAJUAN_PIC
						WHERE
							JENIS_PIC = 'Pendamping'
					)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
					LEFT JOIN
					(
						$queryTambahan
					)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ
					WHERE
						UANG_TAMBAHAN > 0 
				)Q1
				LEFT JOIN
				(
					SELECT
						Q1.NIK,
						SUBJEK,
						REKANAN,
						namapeg,
						departemen,
						Subdepartemen,
						jabatan
					FROM
					(
						SELECT
							a.NIK,
							a.SUBJEK,
							b.NAMA AS REKANAN
						FROM
							SPJ_PEGAWAI_OTORITAS a
						LEFT JOIN
							SPJ_REKANAN b ON
						a.REKANAN = b.ID
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
					)Q2 ON Q1.NIK = Q2.NIK
				)Q2 ON Q1.NIK = Q2.NIK";
		return $this->db->query($sql);
	}
	public function getMonitoringPICKe2Detail($bulan, $tahun)
	{
		$sql = "SELECT
					a.NO_SPJ,
					ID_SPJ,
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
	public function getMonitoringPICKe2Detail_v2($bulan, $tahun, $queryTambahan)
	{
		$sql = "SELECT DISTINCT
					ID_SPJ,
					TGL,
					Q1.NO_SPJ,
					NIK
				FROM
				(
					SELECT
						ID_SPJ,
						DAY(TGL_SPJ) AS TGL,
						NO_SPJ,
						KENDARAAN
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						STATUS_PERJALANAN = 'IN' AND
						MONTH(TGL_SPJ) = $bulan AND
						YEAR (TGL_SPJ) = $tahun 
				)Q1
				LEFT JOIN
				(
					SELECT
						b.NO_SPJ,
						a.NIK,
						JENIS_PIC
					FROM
						SPJ_PENGAJUAN_PIC a
					INNER JOIN
						SPJ_PENGAJUAN b 
					ON a.NO_PENGAJUAN = b.NO_SPJ
					WHERE
						KENDARAAN != 'Rental' AND
						JENIS_PIC = 'Sopir'
					UNION
					SELECT
						NO_PENGAJUAN,
						NIK,
						JENIS_PIC
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						JENIS_PIC = 'Pendamping'
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					$queryTambahan
				)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ
				WHERE
					UANG_TAMBAHAN > 0 
				ORDER BY TGL ASC";
		return $this->db->query($sql);
	}
	public function getJmlSPJForDashboard()
	{
		$tahun = date("Y");
		$sql = "SELECT
					MONTH(TGL_SPJ) AS BULAN,
					JENIS_ID,
					COUNT(ID_SPJ) AS JML_SPJ
				FROM
					SPJ_PENGAJUAN
				WHERE
					STATUS_DATA = 'SAVED' AND
					YEAR(TGL_SPJ) = $tahun
				GROUP BY MONTH(TGL_SPJ), JENIS_ID";
		return $this->db->query($sql);
	}
	public function saveNominalVoucherBBM($inputNoSPJ, $inputBiaya)
	{
		$getBiayaTambahan = $this->db->query("SELECT ID FROM SPJ_BIAYA_TAMBAHAN WHERE NO_SPJ = '$inputNoSPJ' AND STATUS_US1 != 'CLOSE' OR NO_SPJ = '$inputNoSPJ' AND STATUS_US2 != 'CLOSE' OR NO_SPJ = '$inputNoSPJ' AND STATUS_MAKAN != 'CLOSE'");
		$getBiayaAdjustmentMakan = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG MAKAN' AND STATUS = 'OPEN'");
		$getBiayaAdjustmentJalan = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG JALAN' AND STATUS = 'OPEN'");
		$getBiayaAdjustmentBBM = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'BBM' AND STATUS = 'OPEN'");
		$getBiayaTOL = $this->db->query("SELECT ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ' AND IMPLEMENTASI IS NULL");
		$tambahan = $getBiayaTambahan->num_rows();
		$adjustmentMakan = $getBiayaAdjustmentMakan->num_rows();
		$adjustmentJalan = $getBiayaAdjustmentJalan->num_rows();
		$adjustmentBBM = $getBiayaAdjustmentBBM->num_rows();
		$tol = $getBiayaTOL->num_rows();
		$total = $tambahan + $adjustmentMakan + $adjustmentJalan + $adjustmentBBM + $tol;
		if ($total == 0) {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ'");
		}
		$sql = "UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_BBM = '$inputBiaya', VOUCHER = 'Y' WHERE NO_SPJ = '$inputNoSPJ'";
		return $this->db->query($sql);
	}
	public function saveVoucherBBM($inputNoVoucher, $inputBiaya)
	{
		$getData = $this->db->query("SELECT ID FROM SPJ_VOUCHER_BBM WHERE NO_VOUCHER = '$inputNoVoucher'");
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		if ($getData->num_rows() == 0) {
			$sql = "INSERT INTO SPJ_VOUCHER_BBM VALUES('$inputNoVoucher', '$inputBiaya','USED','$tanggal','$user', NULL, NULL)";
		}else{
			$sql = "UPDATE SPJ_VOUCHER_BBM SET RP = '$inputBiaya', TGL_INPUT='$tanggal', PIC_INPUT = '$user' WHERE NO_VOUCHER = '$inputNoVoucher'";
		}
		return $this->db->query($sql);
	}
	public function getTempKendaraan()
	{
		$sql = "SELECT
					NO_TNKB,
					NO_SPJ
				FROM
					SPJ_TEMP_KENDARAAN
				ORDER BY
					ID ASC";
		return $this->db->query($sql);
	}
	public function getKasbonCashFlow($filJenis,$filTahun, $filBulan, $namaBulan, $filStatus)
	{
		$sql = "Execute SPJ_monitoringKasbonNew '$filJenis', $filTahun, $filBulan, '$namaBulan%', '$filStatus%'";
		return $this->db->query($sql);
	}
	public function getSPJByIdGenerate($id)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						* 
					FROM
					(
						SELECT
							ID_SPJ,
							a.TGL_INPUT,
							JENIS_ID,
							NO_SPJ,
							TGL_SPJ,
							QR_CODE,
							a.PIC_INPUT,
							JENIS_KENDARAAN,
							NO_INVENTARIS,
							NO_TNKB,
							MERK,
							TYPE,
							GROUP_ID,
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
							VOUCHER_BBM,
							a.NO_GENERATE
						FROM
							SPJ_PENGAJUAN a
						INNER JOIN
							SPJ_GENERATE b ON
						a.NO_GENERATE = b.NO_GENERATE
						WHERE
							STATUS_DATA = 'SAVED' AND
						b.ID = $id
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
					LEFT JOIN
					(
						SELECT
							NO_BT,
							UANG_SAKU1 * JML_PIC AS US1,
							UANG_SAKU2 * JML_PIC AS US2,
							UANG_MAKAN * JML_PIC AS UM
						FROM
						(
							SELECT
								NO_SPJ AS NO_BT,
								UANG_SAKU1,
								UANG_SAKU2,
								UANG_MAKAN
							FROM
								SPJ_BIAYA_TAMBAHAN
						)Q1
						INNER JOIN
						(
							SELECT
								COUNT(NO_PENGAJUAN) AS JML_PIC,
								NO_PENGAJUAN
							FROM
								SPJ_PENGAJUAN_PIC
							GROUP BY
								NO_PENGAJUAN
						)Q2 ON Q1.NO_BT = Q2.NO_PENGAJUAN
					)Q8 ON Q1.NO_SPJ = Q8.NO_BT
					LEFT JOIN
					(
						SELECT
							NO_SPJ AS NO_ADJUSTMENT,
							SUM(DIAJUKAN) AS BIAYA_ADJUSTMENT
						FROM
							SPJ_ADJUSTMENT
						GROUP BY NO_SPJ
					)Q9 ON Q1.NO_SPJ = Q9.NO_ADJUSTMENT
					LEFT JOIN
					(
						SELECT
							Q1.*,
							OK_OUT,
							OK_IN,
							JML_PIC,
							CASE 
								WHEN OK_OUT = JML_PIC THEN 'OK'
								ELSE 'NG'
							END AS VALIDASI_OUT,
							CASE 
								WHEN OK_IN = JML_PIC THEN 'OK'
								ELSE 'NG'
							END AS VALIDASI_IN
						FROM
						(
							SELECT
								NO_SPJ AS NO_VALIDASI,
								KEBERANGKATAN,
								KEPULANGAN,
								KM_OUT,
								KM_IN
							FROM
								SPJ_VALIDASI
						)Q1
						LEFT JOIN
						(
							SELECT
								NO_SPJ, 
								COUNT(NO_SPJ) AS OK_OUT 
							FROM
								SPJ_VALIDASI_PIC
							WHERE
								SET_OUT = 'OK'
							GROUP BY NO_SPJ
						)Q2 ON Q1.NO_VALIDASI = Q2.NO_SPJ
						LEFT JOIN
						(
							SELECT
								NO_SPJ, 
								COUNT(NO_SPJ) AS OK_IN
							FROM
								SPJ_VALIDASI_PIC
							WHERE
								SET_IN = 'OK'
							GROUP BY NO_SPJ
						)Q3 ON Q1.NO_VALIDASI = Q3.NO_SPJ
						INNER JOIN
						(
							SELECT
								COUNT(NO_PENGAJUAN) AS JML_PIC,
								NO_PENGAJUAN
							FROM
								SPJ_PENGAJUAN_PIC
							GROUP BY
								NO_PENGAJUAN
						)Q4 ON Q1.NO_VALIDASI = Q4.NO_PENGAJUAN
					)Q10 ON Q1.NO_SPJ = Q10.NO_VALIDASI
					LEFT JOIN
					(
						SELECT
							NO_PENGAJUAN AS NO_TOTAL,
							SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
							SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
						FROM
							SPJ_PENGAJUAN_PIC
						GROUP BY
							NO_PENGAJUAN		
					)Q11 ON Q1.NO_SPJ = Q11.NO_TOTAL
				)Q1 
				ORDER BY
					TGL_SPJ DESC";
		return $this->db->query($sql);
	}
	public function getPICByIdGenerate($id)
	{
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
						SPJ_PENGAJUAN a
					INNER JOIN SPJ_GENERATE b
					ON a.NO_GENERATE = b.NO_GENERATE
					WHERE
						STATUS_DATA = 'SAVED' AND
						b.ID = $id
				)Q3 ON Q1.NO_PENGAJUAN = Q3.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NIK AS NIK_OTORITAS,
						FOTO_WAJAH
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q4 ON Q1.NIK = Q4.NIK_OTORITAS";
		return $this->db->query($sql);
	}
	public function getTujuanByIdGenerate($id)
	{
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
						SPJ_PENGAJUAN a
					INNER JOIN SPJ_GENERATE b
					ON a.NO_GENERATE = b.NO_GENERATE
					WHERE
						STATUS_DATA = 'SAVED' AND
						b.ID = $id
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				ORDER BY SERLOK_KOTA ASC";
		return $this->db->query($sql);
	}
	public function getDashboardTemporaryKendaraan()
	{
		$sql = "SELECT DISTINCT
					a.NO_TNKB,
					a.NO_SPJ,
					NAMA_GROUP,
					ID_SPJ
				FROM
					SPJ_TEMP_KENDARAAN a
				LEFT JOIN
					SPJ_PENGAJUAN b ON
				a.NO_SPJ = b.NO_SPJ
				LEFT JOIN
					SPJ_GROUP_TUJUAN c ON
				b.GROUP_ID = c.ID_GROUP
				ORDER BY a.NO_SPJ ASC";
		return $this->db->query($sql);
	}
	public function getDashboardTemporaryPIC()
	{
		$sql = "SELECT DISTINCT
					Q1.*,
					namapeg AS NAMA_PIC,
					JenisKelamin
				FROM
				(
					SELECT DISTINCT
						ID_SPJ,
						PIC,
						a.NO_SPJ,
						FOTO_WAJAH
					FROM
						SPJ_TEMP_PIC a
					INNER JOIN
						SPJ_PEGAWAI_OTORITAS b
					ON a.PIC = b.NIK 
					INNER JOIN
						SPJ_PENGAJUAN c ON
					a.NO_SPJ = c.NO_SPJ
				)Q1
				LEFT JOIN
				(
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						'-' AS jabatan,
						'-' AS departemen,
						'-' AS Subdepartemen,
						'-' AS JenisKelamin
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
						'-' AS Subdepartemen,
						'-' AS JenisKelamin
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
						END AS Subdepartemen,
						JKelamin
					FROM
						dbhrm.dbo.tbPegawai 
					WHERE
						status_aktif = 'AKTIF' 
				)Q2 ON Q1.PIC = Q2.nik
				ORDER BY ID_SPJ ASC";
		return $this->db->query($sql);
	}
	public function getDashboardPersentaseJmlGenerate()
	{
		$sql ="SELECT
					ID_SPJ
				FROM
					SPJ_PENGAJUAN
				WHERE
					STATUS_SPJ = 'CLOSE' AND
					NO_GENERATE IS NULL";
		return $this->db->query($sql);
	}
	public function getDashboardOutstanding()
	{
		$sql = "SELECT DISTINCT
					Q1.NO_SPJ
				FROM
				(
					SELECT
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_PERJALANAN = 'IN'
				)Q1
				LEFT JOIN
				(
					SELECT DISTINCT
						NO_SPJ
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						STATUS_US1 = 'OUTSTANDING' OR
						STATUS_US2 = 'OUTSTANDING' OR
						STATUS_MAKAN = 'OUTSTANDING'
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					SELECT DISTINCT
						NO_SPJ
					FROM
						SPJ_ADJUSTMENT
					WHERE
						PIC_KEPUTUSAN IS NULL
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
				WHERE
					Q2.NO_SPJ IS NOT NULL";
		return $this->db->query($sql);
	}
	public function getDashboardJumlahSPJ()
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
		$sql = "SELECT
					NO_SPJ
				FROM
					SPJ_PENGAJUAN
				WHERE
					STATUS_DATA = 'SAVED' AND
					TGL_SPJ = '$tanggal'";
		return $this->db->query($sql);
	}

	public function getLastSaldoMonth($bulan, $tahun, $jenis)
	{
		$sql = "Execute SPJ_lastMonthSaldo '$bulan', '$tahun', '$jenis'";
		return $this->db->query($sql);
	}
	public function getTabelBiayaAdmin($jenis, $tahun, $status)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						a.*,
						b.namapeg AS NAMA_INPUT,
						c.namapeg AS NAMA_APPROVE,
						CASE 
							WHEN STATUS_APPROVE IS NULL THEN 'Waiting For Approve'
							ELSE STATUS_APPROVE
						END AS STATUS,
						NAMA_JENIS
					FROM
						SPJ_BIAYA_ADMIN a
					LEFT JOIN dbhrm.dbo.tbPegawai b ON
					a.PIC_INPUT = b.nik
					LEFT JOIN dbhrm.dbo.tbPegawai c ON
					a.PIC_APPROVE = c.nik
					LEFT JOIN SPJ_JENIS d ON
					a.JENIS_ID = d.ID_JENIS
					WHERE
						YEAR(TGL_BIAYA) LIKE '$tahun%'
				)Q1
				WHERE
					STATUS LIKE '$status%'
				ORDER BY
						TGL_INPUT DESC";
		return $this->db->query($sql);
	}
	public function saveBiayaAdmin($inputTglBiaya, $inputJenis, $inputBiaya, $inputKeterangan, $inputNo)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_BIAYA_ADMIN(TGL_INPUT, PIC_INPUT, BIAYA, KETERANGAN, JENIS_ID, TGL_BIAYA, NO_BIAYA_ADMIN)VALUES('$tanggal','$user','$inputBiaya','$inputKeterangan','$inputJenis','$inputTglBiaya','$inputNo')";
		return $this->db->query($sql);
	}
	public function updateBiayaAdmin($inputTglBiaya, $inputJenis, $inputBiaya, $inputKeterangan, $inputId)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $user = $this->session->userdata("NIK");
        $sql = "UPDATE SPJ_BIAYA_ADMIN SET TGL_INPUT = '$tanggal', PIC_INPUT = '$user', BIAYA = '$inputBiaya', KETERANGAN = '$inputKeterangan', TGL_BIAYA = '$inputTglBiaya', JENIS_ID = '$inputJenis' WHERE ID = $inputId";
        return $this->db->query($sql);
	}
	public function getKodeApprove($inputKode)
	{
		$sql = "SELECT KODE_PIC FROM SPJ_USER WHERE KODE_PIC = '$inputKode'";
		return $this->db->query($sql);
	}
	public function approveBiayaAdmin($inputId, $inputStatus)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $user = $this->session->userdata("NIK");
		$sql = "UPDATE SPJ_BIAYA_ADMIN SET STATUS_APPROVE = '$inputStatus', PIC_APPROVE='$user', TGL_APPROVE='$tanggal' WHERE ID = $inputId";
		return $this->db->query($sql);
	}
	public function hapusBiayaAdmin($id)
	{
		$sql = "DELETE FROM SPJ_BIAYA_ADMIN WHERE ID= $id";
		return $this->db->query($sql);
	}
	public function monitoringNGSecurity($bulan, $tahun, $jenis, $search)
	{
		$sql = "SELECT
					Q1.*,
					JML_NG,
					JML_NO_READ
				FROM
				(
					SELECT
						ID_SPJ,
						NO_SPJ,
						TGL_SPJ,
						a.PIC_INPUT,
						NO_TNKB,
						MERK,
						TYPE,
						GROUP_ID,
						RENCANA_BERANGKAT,
						RENCANA_PULANG,
						JENIS_ID,
						NAMA_JENIS,
						NAMA_GROUP,
						namapeg,
						Departemen,
						jabatan,
						QR_CODE,
						JENIS_KENDARAAN
					FROM
						SPJ_PENGAJUAN a
					INNER JOIN
						SPJ_JENIS b ON
					a.JENIS_ID = b.ID_JENIS
					INNER JOIN
						SPJ_GROUP_TUJUAN c ON
					a.GROUP_ID = c.ID_GROUP
					INNER JOIN
						dbhrm.dbo.tbPegawai d ON
					a.PIC_INPUT = d.nik
					WHERE
						STATUS_DATA = 'SAVED' AND
						DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
						YEAR(TGL_SPJ) LIKE '$tahun%' AND
						JENIS_ID LIKE '$jenis%'
				)Q1
				INNER JOIN
				(
					SELECT
						NO_SPJ,
						COUNT(NO_SPJ) AS JML_NG
					FROM
						SPJ_HISTORY_NG_SECURITY
					GROUP BY
						NO_SPJ
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						COUNT(NO_SPJ) AS JML_NO_READ
					FROM
						SPJ_HISTORY_NG_SECURITY
					WHERE
						STATUS_NOTIF IS NULL
					GROUP BY
						NO_SPJ
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
				WHERE
					Q1.NO_SPJ LIKE '%$search%' OR
					QR_CODE LIKE '%$search%'
				ORDER BY
					TGL_SPJ DESC";
		return $this->db->query($sql);
	}
	public function detailNGSecurity($noSPJ)
	{
		$sql = "SELECT
					a.*,
					CASE 
						WHEN JENIS = 'Sopir' THEN 'PIC Driver'
						WHEN JENIS = 'Pendamping' THEN 'PIC Pendamping'
						ELSE JENIS
					END AS JENIS_DETAIL,
					namapeg
				FROM
					[dbo].[SPJ_HISTORY_NG_SECURITY] a
				LEFT JOIN
				dbhrm.dbo.tbPegawai b ON
				a.PIC_INPUT = b.NIK
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getNotifNGSecurity()
	{
		$sql = "SELECT
					ID
				FROM
					SPJ_HISTORY_NG_SECURITY
				WHERE
					STATUS_NOTIF IS NULL";
		return $this->db->query($sql);
	}
	public function getNoBiayaAdmin()
	{
		$tahun = date('Y');
        $bulan = date('m');
		$gabung = "BA".$tahun."".$bulan;
		$cekNoDoc=$this->db->query("SELECT MAX
											( RIGHT ( NO_BIAYA_ADMIN, 4 ) ) AS SETNODOC
										FROM
											SPJ_BIAYA_ADMIN
										WHERE
											NO_BIAYA_ADMIN LIKE '$gabung%'");
		foreach ($cekNoDoc->result() as $data) {
            if ($data->SETNODOC =="") {
                $URUTZERO = $gabung."0001";

                $hasil= $URUTZERO;
            }else{
                $zero='';
                $length= 4;
                $index=$data->SETNODOC;

                for ($i=0; $i <$length-strlen($index+1) ; $i++) { 
                    $zero = $zero.'0';
                }
                $URUTDOCNO = $gabung.$zero.($index+1);
                
                $hasil=$URUTDOCNO;  
            }
            
        }
        return $hasil;
	}
	public function getTabelMonitoringPemakaianKendaraan($id, $bulan, $tahun)
	{
		$sql = "SELECT
					Q1.*,
					CASE 
						WHEN Q2.JML_SPJ IS NULL THEN 0
						ELSE Q2.JML_SPJ
					END AS JML_SPJ
				FROM
				(
					SELECT
						NoTNKB,
						'Rental' AS Kendaraan,
						Kategori AS JenisKendaraan,
						Merk,
						Type,
						Tahun
					FROM
						SPJ_KENDARAAN_REKANAN
					WHERE
						REKANAN_ID = $id
				)Q1
				LEFT JOIN
				(
					SELECT
						COUNT(NO_TNKB) AS JML_SPJ,
						NO_TNKB
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						MONTH(TGL_SPJ) = $bulan AND
						YEAR(TGL_SPJ) = $tahun
					GROUP BY NO_TNKB
				)Q2 ON Q1.NoTNKB = Q2.NO_TNKB";
		return $this->db->query($sql);
	}
	public function getTabelJumlahPemakaianKendaraanRental($bulan, $tahun)
	{
		$sql = "Execute SPJ_monitoringJumlahPemakaianKendaraanRental $bulan, $tahun";
		return $this->db->query($sql);
	}
	public function getBreakdownKendaraanRental($id, $tglMulai, $tglSelesai, $search)
	{
		if ($tglMulai != '' && $tglSelesai != '') {
			$where = " AND TGL_SPJ >= '$tglMulai' AND TGL_SPJ <='$tglSelesai'";
		}else{
			$where = "";
		}
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						*
					FROM
					(
						SELECT
							TGL_INPUT,
							'Rental' AS Kendaraan,
							Kategori AS JenisKendaraan,
							Merk,
							Type,
							NoTNKB, 
							Tahun
						FROM
							SPJ_KENDARAAN_REKANAN
						WHERE
							REKANAN_ID = $id
					)Q1
					INNER JOIN
					(
						SELECT
							NO_SPJ,
							TGL_SPJ,
							NO_TNKB,
							NAMA_GROUP,
							c.NIK,
							c.NAMA
						FROM
							SPJ_PENGAJUAN a
						INNER JOIN SPJ_GROUP_TUJUAN b ON
						a.GROUP_ID = b.ID_GROUP
						LEFT JOIN
							SPJ_PENGAJUAN_PIC c ON
						a.NO_SPJ = c.NO_PENGAJUAN
						WHERE
							STATUS_DATA = 'SAVED' AND
							STATUS_PERJALANAN IS NOT NULL AND
							JENIS_PIC = 'Sopir' $where
					)Q2 ON Q1.NoTNKB = Q2.NO_TNKB
					LEFT JOIN
					(
						SELECT
							NIK AS NIK_PENDAMPING,
							NO_PENGAJUAN,
							NAMA AS NAMA_PENDAMPING
						FROM
							SPJ_PENGAJUAN_PIC
						WHERE
							JENIS_PIC = 'Pendamping'
					)Q3 ON Q2.NO_SPJ = Q3.NO_PENGAJUAN
				)Q1
				WHERE
					Merk LIKE '%$search%' OR
					NoTNKB LIKE '%$search%' OR
					NO_SPJ LIKE '%$search%'";
		return $this->db->query($sql);
	}
	public function saveHistoryReloadLokasi($noSPJ, $asal, $tujuan)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$this->db->query("INSERT INTO SPJ_HISTORY_RELOAD_LOKASI(PIC_INPUT, TGL_INPUT, NO_SPJ, GROUP_ASAL, GROUP_TUJUAN)VALUES('$user','$tanggal','$noSPJ','$asal','$tujuan')");
	}
	public function getDataPrintSPJ($id)
	{
		$sql = "SELECT
					Q1.*,
					RP_SPJ,
					RP_TOL,
					RP_BBM
				FROM
				(
					SELECT
						NO_GENERATE,
						TGL_GENERATE,
						JML_SPJ,
						TOTAL_RP,
						NAMA_JENIS
					FROM
						[dbo].[SPJ_GENERATE] a
					INNER JOIN 
						SPJ_JENIS b 
					ON a.JENIS_SPJ = b.ID_JENIS
					WHERE
						ID = $id
				)Q1
				LEFT JOIN
				(
					SELECT
						DETAIL_TRANSAKSI,
						JUMLAH AS RP_SPJ
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						TRANSAKSI = 'Generate' AND
						JENIS_KASBON = 'Kasbon SPJ'
				)Q2 ON Q1.NO_GENERATE = Q2.DETAIL_TRANSAKSI
				LEFT JOIN
				(
					SELECT
						DETAIL_TRANSAKSI,
						JUMLAH AS RP_TOL
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						TRANSAKSI = 'Generate' AND
						JENIS_KASBON = 'Kasbon TOL'
				)Q3 ON Q1.NO_GENERATE = Q3.DETAIL_TRANSAKSI
				LEFT JOIN
				(
					SELECT
						DETAIL_TRANSAKSI,
						JUMLAH AS RP_BBM
					FROM
						SPJ_PENGAJUAN_SALDO
					WHERE
						TRANSAKSI = 'Generate' AND
						JENIS_KASBON = 'Kasbon BBM'
				)Q4 ON Q1.NO_GENERATE = Q4.DETAIL_TRANSAKSI";
		return $this->db->query($sql);
	}
	public function dataSPJByGenerate($noGenerate, $where)
	{
		$sql = "SELECT
					ROW_NUMBER() over (partition by 'SAMA' order by TGL_SPJ asc) AS NOMOR,
					*
				FROM
				(
					SELECT
						ROW_NUMBER() over (partition by NO_GENERATE order by TGL_SPJ asc) AS NO_URUT,
						TGL_SPJ,
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_GENERATE = '$noGenerate'
				)Q1
				$where
				ORDER BY TGL_SPJ ASC";
		return $this->db->query($sql);
	}
	public function getTempDataSPJ_BBM($where, $search, $periode)
	{
		$sql = "SELECT
				  *
				FROM
				(
					SELECT
						a.ID_SPJ,
						a.NO_SPJ,
						a.VOUCHER_BBM,
						a.TOTAL_UANG_BBM,
						a.IMPLEMENTASI,
						a.VOUCHER,
						b.RP,
						c.KODE_ROMAWI,
						c.TAHUN 
					FROM
						SPJ_PENGAJUAN a
						LEFT JOIN SPJ_TEMP_BBM b ON a.NO_SPJ  = b.NO_SPJ 
						AND a.VOUCHER_BBM = b.NO_VOUCHER 
						INNER JOIN SPJ_VOUCHER_BBM c ON
						a.VOUCHER_BBM = c.NO_VOUCHER
					WHERE
						STATUS_PERJALANAN = 'IN' 
						AND STATUS_SPJ = 'OPEN' 
						AND STATUS_DATA = 'SAVED'
						AND a.VOUCHER IS NULL 
						$where
						$periode
				)Q1
				WHERE
					NO_SPJ LIKE '%$search%' OR
					VOUCHER_BBM LIKE '%$search%'
				ORDER BY
					KODE_ROMAWI, TAHUN ASC
				";
		return $this->db->query($sql);
	}
	public function saveTempBBM_SPJ($noSPJ, $voucher, $rp)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "UPDATE SPJ_TEMP_BBM SET RP = '$rp', PIC_INPUT = '$user', TGL_INPUT = '$tanggal' WHERE NO_SPJ = '$noSPJ' AND NO_VOUCHER = '$voucher'";
		return $this->db->query($sql);
	}
	public function getTotalTempBBM_SPJ()
	{
		$sql = "SELECT
					SUM(b.RP) AS RP
				FROM
					SPJ_PENGAJUAN a
				LEFT JOIN
					SPJ_TEMP_BBM b
				ON a.NO_SPJ  = b.NO_SPJ AND a.VOUCHER_BBM = b.NO_VOUCHER
				WHERE
					STATUS_PERJALANAN = 'IN' AND
					STATUS_SPJ = 'OPEN' AND RP IS NOT NULL";
		return $this->db->query($sql);
	}
	public function kondisiDBTemp($voucher, $kondisi, $noSPJ, $biaya)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		if ($kondisi == 'tambah') {
			$sql = "INSERT INTO SPJ_TEMP_BBM(NO_SPJ, NO_VOUCHER, RP, PIC_INPUT, TGL_INPUT)VALUES('$noSPJ','$voucher',$biaya, '$user','$tanggal')";
		}else{
			$sql = "DELETE FROM SPJ_TEMP_BBM WHERE NO_SPJ = '$noSPJ' AND NO_VOUCHER = '$voucher'";
		}
		return $this->db->query($sql);
	}
	public function saveSPJLog($jenis, $noSPJ, $aktivitas)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_LOG(PIC_INPUT, TGL_INPUT, JENIS, NO_SPJ, AKTIVITAS)VALUES('$user','$tanggal','$jenis','$noSPJ', '$aktivitas')";
		return $this->db->query($sql);
	}
	public function updateBiaya($id, $after)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_JALAN = $after WHERE ID_SPJ = $id";
		return $this->db->query($sql);
	}
	public function updateSubKas($id, $after)
	{
		$sql = "UPDATE SPJ_KAS_SUB SET CREDIT = $after WHERE FK_ID = $id AND JENIS_FK = 'KASBON' AND DETAIL_KASBON = 'TRANSAKSI AWAL'";
		return $this->db->query($sql);
	}
	public function updateSaldo($id, $after, $before)
	{
		$data = $this->db->query("SELECT JUMLAH FROM SPJ_SALDO WHERE JENIS_SALDO = 'Kasbon SPJ Delivery' AND JENIS_KAS = 'SUB KAS'")->row();
		$saldo = $data->JUMLAH;
		$rekap = $this->db->query("SELECT TOP 1 ID FROM SPJ_REKAP_SALDO ORDER BY TGL_REKAP DESC")->row();
		$idRekap = $rekap->ID;
		$total = ($saldo+$before)-$after;
		$sql = $this->db->query("UPDATE SPJ_SALDO SET JUMLAH = '$total' WHERE JENIS_SALDO = 'Kasbon SPJ Delivery' AND JENIS_KAS = 'SUB KAS'");
		$sql = $this->db->query("UPDATE SPJ_REKAP_SALDO SET SUB_KAS_SPJ_DLV = '$total' WHERE ID= $idRekap");

		return $sql;
	}
	public function getTabelWeekly($mulai, $akhir, $jenis, $status, $search)
	{
		if ($mulai == '' && $akhir == '') {
			$periode = "";
		}else{
			$periode = " AND TGL_SPJ BETWEEN '$mulai' AND '$akhir'";
		}
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						ID_SPJ,
						TGL_SPJ,
						NO_SPJ,
						TGL_INPUT,
						QR_CODE,
						STATUS_SPJ,
						NAMA_GROUP,
						VOUCHER_BBM,
						NO_GENERATE,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN AS TOTAL_KASBON,
						((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM) AS TOTAL_TAMBAHAN_SPJ,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN + ((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM) AS TOTAL_SPJ,
						TOTAL_UANG_TOL AS TOTAL_TOL,
						TOTAL_UANG_BBM AS TOTAL_BBM,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM)+TOTAL_UANG_TOL+TOTAL_UANG_BBM AS TOTAL_RP
					FROM
					(
						SELECT
							Q1.ID_SPJ,
							Q1.TGL_SPJ,
							Q1.TGL_INPUT,
							Q1.QR_CODE,
							Q1.NO_SPJ,
							CASE 
								WHEN Q1.STATUS_SPJ = 'CLOSE' AND NO_GENERATE IS NULL THEN 'Waiting For Generate'
								ELSE Q1.STATUS_SPJ
							END AS STATUS_SPJ,
							Q1.NAMA_GROUP,
							Q1.VOUCHER_BBM,
							Q1.NO_GENERATE,
							TOTAL_UANG_SAKU,
							TOTAL_UANG_MAKAN,
							TOTAL_UANG_JALAN,
							TOTAL_UANG_TOL,
							TOTAL_UANG_BBM,
							JML_PIC AS JML_PIC_UM,
							CASE 
								WHEN UANG_SAKU1 IS NULL THEN 0
								ELSE UANG_SAKU1
							END AS TAMBAHAN_UANG_SAKU1,
							CASE 
								WHEN UANG_SAKU2 IS NULL THEN 0
								ELSE UANG_SAKU2
							END AS TAMBAHAN_UANG_SAKU2,
							CASE 
								WHEN UANG_MAKAN IS NULL THEN 0
								ELSE UANG_MAKAN
							END AS TAMBAHAN_UANG_MAKAN,
							CASE 
								WHEN Q6.NO_SPJ IS NULL THEN JML_PIC
								ELSE JML_PIC - 1
							END AS JML_PIC_US,
							CASE 
								WHEN Q6.NO_SPJ IS NULL THEN 'N'
								ELSE 'Y'
							END AS JML_PIC_RENTAL
						FROM
						(
							SELECT
								a.TGL_SPJ,
								a.TGL_INPUT,
								a.ID_SPJ,
								a.QR_CODE,
								a.NO_SPJ,
								a.STATUS_SPJ,
								b.NAMA_GROUP,
								a.VOUCHER_BBM,
								a.TOTAL_UANG_JALAN,
								a.TOTAL_UANG_BBM,
								a.TOTAL_UANG_TOL,
								a.NO_GENERATE
							FROM
								[dbo].[SPJ_PENGAJUAN] a
							LEFT JOIN SPJ_GROUP_TUJUAN b ON
							a.GROUP_ID = b.ID_GROUP
							WHERE
								STATUS_DATA = 'SAVED' AND
								JENIS_ID LIKE '$jenis%' AND
								STATUS_SPJ NOT IN ('CANCEL')
						)Q1
						INNER JOIN
						(
							SELECT
								NO_PENGAJUAN,
								COUNT(NIK) AS JML_PIC,
								SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
								SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
							FROM 
								SPJ_PENGAJUAN_PIC
							GROUP BY NO_PENGAJUAN	
						)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
						LEFT JOIN
						(
							SELECT
								NO_SPJ,
								UANG_SAKU1
							FROM
								SPJ_BIAYA_TAMBAHAN a
							WHERE
								KEPUTUSAN_US1 = 'OK'
						)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
						LEFT JOIN
						(
							SELECT
								NO_SPJ,
								UANG_SAKU2
							FROM
								SPJ_BIAYA_TAMBAHAN
							WHERE
								KEPUTUSAN_US2 = 'OK'
						)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ
						LEFT JOIN
						(
							SELECT
								NO_SPJ,
								UANG_MAKAN
							FROM
								SPJ_BIAYA_TAMBAHAN
							WHERE
								KEPUTUSAN_MAKAN = 'OK'
						)Q5 ON Q1.NO_SPJ = Q5.NO_SPJ
						LEFT JOIN
						(
							SELECT
								NO_SPJ
							FROM
								SPJ_PENGAJUAN a
							INNER JOIN
								SPJ_PENGAJUAN_PIC b ON
							a.NO_SPJ = b.NO_PENGAJUAN
							WHERE
								KENDARAAN = 'Rental' AND
								OBJEK = 'Rental' AND
								JENIS_PIC = 'Sopir'
						)Q6 ON Q1.NO_SPJ =Q6.NO_SPJ
						WHERE
							STATUS_SPJ LIKE '%$status%' 
							$periode
							
					)Q1
					WHERE
						NO_SPJ LIKE '%$search%' OR
						QR_CODE LIKE '%$search%' OR
						VOUCHER_BBM LIKE '%$search%'
				)Q1
				ORDER BY TGL_SPJ, NO_SPJ ASC";
		return $this->db->query($sql);
	}
	public function getTabelCostReduction($search, $awal, $akhir)
	{
		$sql = "Execute SPJ_monitoringCostReductionDelivery '$awal','$akhir','$search'";
		return $this->db->query($sql);
	}
	public function getTabelTargetCR($jenis, $tipe, $where)
	{
		$sql = "SELECT
					ID,
					CASE 
						WHEN BULAN = 1 THEN 'Januari'
						WHEN BULAN = 2 THEN 'Februari'
						WHEN BULAN = 3 THEN 'Maret'
						WHEN BULAN = 4 THEN 'April'
						WHEN BULAN = 5 THEN 'Mei'
						WHEN BULAN = 6 THEN 'Juni'
						WHEN BULAN = 7 THEN 'Juli'
						WHEN BULAN = 8 THEN 'Agustus'
						WHEN BULAN = 9 THEN 'September'
						WHEN BULAN = 10 THEN 'Oktober'
						WHEN BULAN = 11 THEN 'November'
						ELSE 'Desember'
					END AS NAMA_BULAN,
					BULAN,
					JUMLAH,
					TAHUN
				FROM
					[dbo].[SPJ_TARGET_CR]
				WHERE
					JENIS_ID = $jenis AND
					TIPE_CR = '$tipe' $where
				ORDER BY TAHUN DESC, BULAN ASC";
		return $this->db->query($sql);
	}
	public function saveTargetCRDelivery($bulan, $tahun, $jumlah)
	{
		$sql = "INSERT INTO SPJ_TARGET_CR(BULAN, TAHUN, JUMLAH, JENIS_ID, TIPE_CR)VALUES('$bulan','$tahun','$jumlah','1','UANG JALAN')";
		return $this->db->query($sql);
	}
	public function updateTargetCRDelivery($bulan, $tahun, $jumlah, $id)
	{
		$sql = "UPDATE SPJ_TARGET_CR SET BULAN = $bulan, TAHUN = '$tahun', JUMLAH = '$jumlah' WHERE ID = $id";
		return $this->db->query($sql);
	}
	public function hapusTargetBulananCR($id)
	{
		$sql = "DELETE FROM SPJ_TARGET_CR WHERE ID = $id";
		return $this->db->query($sql);
	}
	public function grapikCRDelivery($tahun)
	{
		$sql = "Execute SPJ_grapikCostReductionDelivery '$tahun'";
		return $this->db->query($sql);
	}
	public function getMonitoringKeberangakatan($jenis, $awal, $akhir, $search, $jamMulai, $jamAkhir, $interval)
	{
		$sql = "Execute SPJ_monitoringKeberangkatan '$jenis','$awal','$akhir','$search','$interval','$jamMulai','$jamAkhir'";
		return $this->db->query($sql);
	}
}
?>
<?php
class M_Implementasi extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getValidasiPIC($noSPJ)
	{
		$sql = "SELECT
					a.*,
					JENIS_PIC
				FROM
					SPJ_VALIDASI_PIC a
				INNER JOIN
					SPJ_PENGAJUAN_PIC b 
				ON a.PIC = b.NIK AND a.NO_SPJ = b.NO_PENGAJUAN
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function saveValidasiPIC($isi, $nik, $noSPJ, $field)
	{
		$getData = $this->db->query("SELECT ID FROM SPJ_VALIDASI_PIC WHERE NO_SPJ = '$noSPJ' AND PIC = '$nik'");
		if ($getData->num_rows()==0) {
			$sql = "INSERT INTO SPJ_VALIDASI_PIC(NO_SPJ, $field, PIC) VALUES('$noSPJ','$isi','$nik')";
		} else {
			$sql ="UPDATE SPJ_VALIDASI_PIC SET $field = '$isi' WHERE NO_SPJ = '$noSPJ' AND PIC = '$nik'";
		}
		
		return $this->db->query($sql);
	}
	public function getKM($noTnkb)
	{
		$sql ="SELECT
					NO_TNKB,
					KM
				FROM
					[dbo].[SPJ_CHECK_KENDARAAN]
				WHERE
					NO_TNKB = '$noTnkb'";
		return $this->db->query($sql);
	}
	public function cekValidasiPICNew($noSPJ, $jenis)
	{
		$where = $jenis == 'Out'?" AND SET_OUT ='OK'":" AND SET_OUT ='OK'";
		$sql = "SELECT
					ID
				FROM
					[dbo].[SPJ_VALIDASI_PIC]
				WHERE
					NO_SPJ = '$noSPJ' $where";
		return $this->db->query($sql);
	}
	public function cekValidasiPIC($n, $jenis)
	{
		if ($jenis == 'Out') {
			$where = ' WHERE SET_OUT IS NOT NULL';
		} else {
			$where = ' WHERE SET_IN IS NOT NULL';
		}
		
		$sql ="SELECT
					NIK
				FROM
				(
					SELECT
						NIK,
						NO_PENGAJUAN
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NO_PENGAJUAN = '$n'
				)Q1
				LEFT JOIN
				(
					SELECT
						PIC,
						NO_SPJ
					FROM
						SPJ_VALIDASI_PIC
				)Q2 ON Q1.NIK = Q2.PIC
				WHERE
					PIC IS NULL";
		return $this->db->query($sql);
	}
	public function saveValidasiOut($noSPJ, $verifKendaraan, $ketKendaraan, $km)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $getData = $this->db->query("SELECT ID FROM SPJ_VALIDASI WHERE NO_SPJ = '$noSPJ'");
        if ($getData->num_rows()==0) {
        	$sql = $this->db->query("INSERT INTO SPJ_VALIDASI( NO_SPJ, KENDARAAN, KETERANGAN_KENDARAAN, KEBERANGKATAN, KM_OUT, PIC_OUT)VALUES('$noSPJ','$verifKendaraan','$ketKendaraan','$tanggal','$km','$user')");
        }
		
		$this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_PERJALANAN = 'OUT' WHERE NO_SPJ = '$noSPJ'");
		$this->db->query("UPDATE SPJ_VALIDASI_PIC SET STATUS_DATA = 'OUT' WHERE NO_SPJ = '$noSPJ'");
		return $sql;
	}
	public function saveValidasiIn($noSPJ, $verifKendaraan, $ketKendaraan, $km)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = $this->db->query("UPDATE SPJ_VALIDASI SET KENDARAAN_IN = '$verifKendaraan', KETERANGAN_KENDARAAN_IN = '$ketKendaraan', KEPULANGAN = '$tanggal', PIC_IN ='$user', KM_IN = '$km' WHERE NO_SPJ = '$noSPJ'");
        $this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_PERJALANAN = 'IN' WHERE NO_SPJ = '$noSPJ'");
		$this->db->query("UPDATE SPJ_VALIDASI_PIC SET STATUS_DATA = 'IN' WHERE NO_SPJ = '$noSPJ'");
		return $sql;
	}
	public function getValidasiSPJ($noSPJ)
	{
		$sql = "SELECT
					*,
					DATEDIFF( dd, KEBERANGKATAN, WAKTU_PULANG ) AS DIF_HARI,
					DATEDIFF( hh, KEBERANGKATAN, WAKTU_PULANG ) AS DIF_JAM 
				FROM
				(
					SELECT
						ID,
						NO_SPJ,
						KENDARAAN,
						KETERANGAN_KENDARAAN,
						KEBERANGKATAN,
						KEPULANGAN,
						KM_OUT,
						KM_IN,
						VERIFIKASI_BULAK_BALIK,
						PIC_OUT,
						PIC_IN,
						REALISASI_UANG_SAKU,
						REALISASI_UANG_MAKAN,
						REALISASI_UANG_BBM,
						REALISASI_UANG_JALAN,
						REALISASI_UANG_TOL,
						KENDARAAN_IN,
						KETERANGAN_KENDARAAN_IN,
						CASE 
							WHEN KEPULANGAN IS NULL THEN GETDATE()
							ELSE KEPULANGAN
						END AS WAKTU_PULANG
					FROM
						[dbo].[SPJ_VALIDASI] 
					WHERE
						NO_SPJ = '$noSPJ'
				)Q1";
		return $this->db->query($sql);
	}
	public function saveDataTemp($noSPJ)
	{
		$getPIC =$this->db->query("SELECT NIK FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$noSPJ'");
		$getKendaraan = $this->db->query("SELECT NO_TNKB FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'");
		foreach ($getPIC->result() as $key) {
			$nik = $key->NIK;
			$sql = $this->db->query("INSERT INTO SPJ_TEMP_PIC VALUES('$nik','$noSPJ')");
		}
		foreach ($getKendaraan->result() as $key2) {
			$no = $key2->NO_TNKB;
			$sql = $this->db->query("INSERT INTO SPJ_TEMP_KENDARAAN VALUES('$no','$noSPJ')");
		}
		return $sql;
	}
	public function deleteDataTemp($noSPJ)
	{
		$sql = $this->db->query("DELETE FROM SPJ_TEMP_PIC WHERE NO_SPJ = '$noSPJ'");
		$sql = $this->db->query("DELETE FROM SPJ_TEMP_KENDARAAN WHERE NO_SPJ = '$noSPJ'");
		return $sql;
	}
	public function saveKMKendaraan($noTNKB, $inputKMIn)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$getData = $this->db->query("SELECT ID FROM SPJ_CHECK_KENDARAAN WHERE NO_TNKB = '$noTNKB'");
		if ($getData->num_rows()==0) {
			$sql ="INSERT INTO SPJ_CHECK_KENDARAAN VALUES('$noTNKB', '$inputKMIn',null,'$user','$tanggal')";
		} else {
			$sql ="UPDATE SPJ_CHECK_KENDARAAN SET KM = '$inputKMIn', PIC_LAST = '$user', TGL_LAST='$tanggal' WHERE NO_TNKB = '$noTNKB'";
		}
		return $this->db->query($sql);
	}
	public function saveUangTambahan($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $statusUS1 = $uangSaku1 >0 ?'OUTSTANDING':'CLOSE';
        $statusUS2 = $uangSaku2 >0 ?'OUTSTANDING':'CLOSE';
        $statusMakan = $uangMakan >0 ?'OUTSTANDING':'CLOSE';
		$getData = $this->db->query("SELECT ID FROM SPJ_BIAYA_TAMBAHAN WHERE NO_SPJ = '$inputNoSPJ'");
		if ($getData->num_rows()==0) {
			$sql = "INSERT INTO SPJ_BIAYA_TAMBAHAN VALUES('$inputNoSPJ','$uangSaku1','$uangSaku2','$uangMakan','$statusUS1','$statusUS2','$statusMakan','SYSTEM','SYSTEM','SYSTEM','$tanggal','$tanggal','$tanggal', null, null, null, null, null, null)";
		} else {
			$sql = "UPDATE SPJ_BIAYA_TAMBAHAN SET UANG_SAKU1 = '$uangSaku1', UANG_SAKU2='$uangSaku2', UANG_MAKAN = '$uangMakan', STATUS_US1='$statusUS1', STATUS_US2='$statusUS2', STATUS_MAKAN = '$statusMakan', PIC_US1='SYSTEM', PIC_US2='SYSTEM', PIC_MAKAN='SYSTEM', TGL_US1='$tanggal', TGL_US2 = '$tanggal', TGL_MAKAN='$tanggal' WHERE NO_SPJ = '$inputNoSPJ'";
		}
		return $this->db->query($sql);
	}
	public function saveAdjustmentUangTambah($inputNoSPJ, $uangSaku1, $uangSaku2, $uangMakan)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $um = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UM'");
        if ($um->num_rows()==0) {
        	$this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS, PIC_PENGAJU, TGL_PENGAJU)VALUES('$inputNoSPJ','UM','$uangMakan','Otomatis','OPEN','System','$tanggal')");
        } else {
        	$this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$uangMakan' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UM'");
        }

        $us1 = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'US1'");
        if ($us1->num_rows()==0) {
        	$this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS, PIC_PENGAJU, TGL_PENGAJU)VALUES('$inputNoSPJ','US1','$uangMakan','Otomatis','OPEN','System','$tanggal')");
        } else {
        	$this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$uangMakan' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'US1'");
        }

        $us2 = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'US2'");
        if ($us2->num_rows()==0) {
        	$this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS, PIC_PENGAJU, TGL_PENGAJU)VALUES('$inputNoSPJ','US2','$uangMakan','Otomatis','OPEN','System','$tanggal')");
        } else {
        	$this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$uangMakan' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'US2'");
        }
		
	}
	public function getUangMakanNormalAdjustment($noSPJ)
	{
		$sql = "SELECT
					SUM(UANG_MAKAN_1) AS UANG_MAKAN_1,
					SUM(UANG_MAKAN_2) AS UANG_MAKAN_2,
					SUM(UANG_SAKU1) AS UANG_SAKU1,
					SUM(UANG_SAKU2) AS UANG_SAKU2,
					CASE 
						WHEN SUM(UANG_MAKAN_2) >0 THEN 'Mendapatkan Uang Makan Ke-2'
						ELSE 'Tidak Mendapatkan Uang makan Ke-2'
					END AS KETERANGAN_UANG_MAKAN_2
				FROM
				(
					SELECT
						Q1.NO_SPJ,
						BIAYA AS UANG_MAKAN_1,
						UANG_MAKAN AS UANG_MAKAN_2,
						JML_PIC * UANG_SAKU1 AS UANG_SAKU1,
						JML_PIC * UANG_SAKU2 AS UANG_SAKU2
					FROM
					(
						SELECT
							*,
							CASE 
								WHEN KENDARAAN = 'Rental' AND JENIS_PIC = 'Sopir' THEN 0
								ELSE 1
							END AS JML_PIC
						FROM
						(
							SELECT
								NO_SPJ,
								NIK,
								JENIS_PIC,
								KENDARAAN,
								CASE 
									WHEN GROUP_TUJUAN_ID = 4 THEN 'LOKAL'
									ELSE 'Luar Kota'
								END AS JENIS_UM,
								GROUP_TUJUAN_ID,
								JENIS_ID
							FROM
								SPJ_PENGAJUAN_PIC a
							INNER JOIN
								SPJ_PENGAJUAN b
							ON a.NO_PENGAJUAN = b.NO_SPJ
							WHERE
								NO_PENGAJUAN = '$noSPJ' AND 
								NIK NOT IN ('00003','00004','01519','00917','01223')
						)Q1
					)Q1
					LEFT JOIN
					(
						SELECT
							BIAYA,
							ID_JENIS_SPJ,
							JENIS_GROUP
						FROM
							SPJ_UANG_MAKAN
						WHERE
							MAKAN_KE = 1
					)Q2 ON Q1.JENIS_UM = Q2.JENIS_GROUP AND Q1.JENIS_ID = Q2.ID_JENIS_SPJ
					LEFT JOIN
					(
						SELECT
							UANG_MAKAN,
							UANG_SAKU1,
							UANG_SAKU2,
							NO_SPJ
						FROM
							SPJ_BIAYA_TAMBAHAN
					)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
				)Q1";
		return $this->db->query($sql);
	}
	public function getDataAdjustment($noSPJ)
	{
		$sql = "SELECT
					NO_SPJ,
					OBJEK,
					DIAJUKAN,
					ALASAN,
					KEPUTUSAN,
					KETERANGAN,
					PIC_PENGAJU,
					PIC_KEPUTUSAN,
					STATUS
				FROM
					SPJ_ADJUSTMENT
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getDataAdjustment2($noSPJ)
	{
		$sql = "SELECT
					NO_SPJ,
					'US1' AS OBJEK,
					UANG_SAKU1 AS DIAJUKAN,
					'Otomatis' AS ALASAN,
					CASE 
						WHEN KEPUTUSAN_US1 = 'NG' THEN 'NG'
						ELSE 'OK'
					END AS KEPUTUSAN,
					KETERANGAN_US1 AS KETERANGAN,
					'System' AS KETERANGAN,
					PIC_US1 AS PIC_PENGAJU,
					STATUS_US1 AS STATUS
				FROM
					SPJ_BIAYA_TAMBAHAN
				WHERE
					NO_SPJ = '$noSPJ'
				UNION
				SELECT
					NO_SPJ,
					'US2',
					UANG_SAKU2,
					'Otomatis',
					CASE 
						WHEN KEPUTUSAN_US2 = 'NG' THEN 'NG'
						ELSE 'OK'
					END AS KEPUTUSAN_US2,
					KETERANGAN_US2,
					'System',
					PIC_US2,
					STATUS_US2
				FROM
					SPJ_BIAYA_TAMBAHAN
				WHERE
					NO_SPJ = '$noSPJ'
				UNION
				SELECT
					NO_SPJ,
					'UM',
					UANG_MAKAN,
					'Otomatis',
					CASE 
						WHEN KEPUTUSAN_MAKAN = 'NG' THEN 'NG'
						ELSE 'OK'
					END AS KEPUTUSAN_MAKAN,
					KETERANGAN_MAKAN,
					'System',
					PIC_MAKAN,
					STATUS_MAKAN
				FROM
					SPJ_BIAYA_TAMBAHAN
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function saveAdjustment($tambahan, $jenis)
	{
		$inputUangMakanDiajukan = $this->input->post("inputUangMakanDiajukan") == '' ? 0 : $this->input->post("inputUangMakanDiajukan");
        $inputUangMakanAlasan = $this->input->post("inputUangMakanAlasan");
        $inputUangMakanKeterangan = $this->input->post("inputUangMakanKeterangan");
        $inputKeputusanUangMakan = $this->input->post("inputKeputusanUangMakan");
        $inputUangJalanDiajukan = $this->input->post("inputUangJalanDiajukan") == '' ? 0 : $this->input->post("inputUangJalanDiajukan");
        $inputUangJalanAlasan = $this->input->post("inputUangJalanAlasan");
        $inputUangJalanKeterangan = $this->input->post("inputUangJalanKeterangan");
        $inputKeputusanUangJalan = $this->input->post("inputKeputusanUangJalan");
        $inputBBMDiajukan = $this->input->post("inputBBMDiajukan") == '' ? 0 : $this->input->post("inputBBMDiajukan");
        $inputBBMAlasan = $this->input->post("inputBBMAlasan");
        $inputBBMKeterangan = $this->input->post("inputBBMKeterangan");
        $inputKeputusanBBM = $this->input->post("inputKeputusanBBM");
        $inputNoSPJ = $this->input->post("inputNoSPJ");
        $inputNIKPengaju = $this->input->post("inputNIKPengaju");
		$cek = $this->db->query("SELECT ID FROM SPJ_ADJUSTMENT WHERE NO_SPJ = '$inputNoSPJ'");
		if ($cek->num_rows()==0) {
			$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','UANG MAKAN','$inputUangMakanDiajukan','$inputUangMakanAlasan','OPEN')");
				$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','UANG JALAN','$inputUangJalanDiajukan','$inputUangJalanAlasan','OPEN')");
				$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','BBM','$inputBBMDiajukan','$inputBBMAlasan','OPEN')");
		} else {
			$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangMakanDiajukan', ALASAN = '$inputUangMakanAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG MAKAN'");
				$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangJalanDiajukan', ALASAN = '$inputUangJalanAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG JALAN'");
				$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputBBMDiajukan', ALASAN = '$inputBBMAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'BBM'");
		}

		$this->db->query($tambahan);
		// if ($jenis == 'ALL' || $jenis=='KEPUTUSAN') {
		// 	$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_MAKAN = '$inputUangMakanDiajukan', TOTAL_UANG_JALAN='$inputUangJalanDiajukan', TOTAL_UANG_BBM = '$inputBBMDiajukan' WHERE NO_SPJ = '$inputNoSPJ'");
		// 	$getKasbonSPJ= $this->db->query("SELECT CREDIT FROM SPJ_KASBON WHERE NO_SPJ = '$inputNoSPJ' AND JENIS_KASBON = 'SPJ'");
		// 	if ($getKasbonSPJ->num_rows()>0) {
		// 		foreach ($getKasbonSPJ->result() as $key) {
		// 			$creditSPJ = $key->CREDIT;
		// 		}
		// 		$totalCreditSPJ = $creditSPJ + $inputUangMakanDiajukan + $inputUangJalanDiajukan + $inputBBMDiajukan;
		// 		$this->db->query("UPDATE SPJ_KASBON SET CREDIT = '$totalCreditSPJ' WHERE NO_SPJ = '$inputNoSPJ' AND JENIS_KASBON = 'SPJ'");
		// 	}

		// }
		
		return $sql;
	}
	public function saveKeputusanAdjustment($value, $inputNoSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");

        $sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$value[0]', KEPUTUSAN = '$value[1]', KETERANGAN = '$value[2]', TGL_KEPUTUSAN = '$tanggal', PIC_KEPUTUSAN = '$user', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG MAKAN'");
        $sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$value[3]', KEPUTUSAN = '$value[4]', KETERANGAN = '$value[5]', TGL_KEPUTUSAN = '$tanggal', PIC_KEPUTUSAN = '$user', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG JALAN'");
        $sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$value[6]', KEPUTUSAN = '$value[7]', KETERANGAN = '$value[8]', TGL_KEPUTUSAN = '$tanggal', PIC_KEPUTUSAN = '$user', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'BBM'");
        return $sql;
	}
	public function saveKeputusanAdjustment2($value, $inputNoSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        // $statusUS1 = $value[0] == 'OK' ? 'CLOSE' : 'OPEN';
        // $statusUS2 = $value[2] == 'OK' ? 'CLOSE' : 'OPEN';
        // $statusUM = $value[4] == 'OK' ? 'CLOSE' : 'OPEN';
        $sql = $this->db->query("UPDATE SPJ_BIAYA_TAMBAHAN SET 
        							STATUS_US1 = 'CLOSE', 
        							STATUS_US2 = 'CLOSE', 
        							STATUS_MAKAN = 'CLOSE', 
        							PIC_US1 = '$user', 
        							PIC_US2 = '$user', 
        							PIC_MAKAN = '$user', 
        							TGL_US1='$tanggal',
        							TGL_US2='$tanggal', 
        							TGL_MAKAN = '$tanggal',
        							KEPUTUSAN_US1 = '$value[0]',
        							KEPUTUSAN_US2 = '$value[2]',
        							KEPUTUSAN_MAKAN = '$value[4]',
        							KETERANGAN_US1 = '$value[1]',
        							KETERANGAN_US2 = '$value[3]',
        							KETERANGAN_MAKAN = '$value[5]'
        						WHERE NO_SPJ = '$inputNoSPJ'");
        return $sql;
	}
	public function updateKasbonOtomatis($inputSPJ, $uangMakan, $uangJalan, $uangBBM)
	{
		$getBiaya = $this->db->query("SELECT
											TOTAL_UANG_SAKU,
											UANG_SAKU_TAMBAHAN,
											UANG_MAKAN_TAMBAHAN
										FROM
										(
											SELECT
												TOTAL_UANG_SAKU,
												VOUCHER_ID,
												NO_SPJ
											FROM
												SPJ_PENGAJUAN
											WHERE
												NO_SPJ = '$inputNoSPJ'
										)Q1
										LEFT JOIN
										(
											SELECT
												NO_SPJ,
												UANG_SAKU1 + UANG_SAKU2 AS UANG_SAKU_TAMBAHAN,
												UANG_MAKAN AS UANG_MAKAN_TAMBAHAN
											FROM
												SPJ_BIAYA_TAMBAHAN
										)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ");
		foreach ($getBiaya->result() as $key) {
			$usSPJ = $key->TOTAL_UANG_SAKU;
			$uangSakuTambahan = $key->UANG_SAKU_TAMBAHAN;
			$uangMakanTambahan = $key->UANG_MAKAN_TAMBAHAN;
		}

		$totalUangSaku = $usSPJ + $uangSakuTambahan;
		$totalUangMakan = $uangMakan + $uangMakanTambahan;
		$totalCreditSPJ = $totalUangSaku;

		$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_MAKAN = '$value[0]', TOTAL_UANG_JALAN='$value[3]', TOTAL_UANG_BBM = '$value[6]' WHERE NO_SPJ = '$inputNoSPJ'");

	}
	public function getBBMPengajuan($noSPJ)
	{
		$sql = "SELECT TOP 1 TOTAL_UANG_BBM FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ' AND STATUS_DATA = 'SAVED'";
		return $this->db->query($sql);
	}

	public function realisasiBiayaSPJ($noSPJ)
	{
		$sql = "SELECT
					Q1.*,
					TOTAL_UANG_SAKU,
					TOTAL_UANG_MAKAN,
					UANG_SAKU1*JML_PIC_US AS US1_TAMBAHAN,
					UANG_SAKU2*JML_PIC_US AS US2_TAMBAHAN,
					UANG_MAKAN*JML_PIC AS UM_TAMBAHAN,
					UM_DIAJUKAN,
					UM_TGL,
					UM_PIC,
					UM_STATUS,
					UJ_DIAJUKAN,
					UJ_TGL,
					UJ_PIC,
					UJ_STATUS,
					BBM_DIAJUKAN,
					BBM_TGL,
					BBM_PIC,
					CASE 
						WHEN ADJUSTMENT_MANAJEMEN = 'Y' THEN BBM_STATUS
						WHEN MEDIA_UANG_BBM = 'Voucher' AND Q7.NO_VOUCHER IS NOT NULL THEN 'CLOSE'
						WHEN MEDIA_UANG_BBM = 'Reimburse' AND TOTAL_UANG_BBM >0 THEN 'CLOSE'
						WHEN MEDIA_UANG_BBM = 'Kasbon' AND TOTAL_UANG_BBM >0 THEN 'CLOSE'
						ELSE 'OPEN'
					END AS BBM_STATUS,
					JML_PIC,
					TOTAL_UANG_SAKU + (UANG_SAKU1*JML_PIC_US) + (UANG_SAKU2*JML_PIC_US) AS REALISASI_UANG_SAKU,
					CASE 
						WHEN ADJUSTMENT_MANAJEMEN = 'Y' THEN (UANG_MAKAN*JML_PIC_UM) + UM_DIAJUKAN
						ELSE TOTAL_UANG_MAKAN + (UANG_MAKAN*JML_PIC_UM)
					END AS REALISASI_UANG_MAKAN,
					CASE 
						WHEN ADJUSTMENT_MANAJEMEN = 'Y' THEN UJ_DIAJUKAN
						ELSE TOTAL_UANG_JALAN
					END AS REALISASI_UANG_JALAN,
					CASE
						WHEN MEDIA_UANG_BBM = 'Voucher' THEN TGL_VOUCHER
						WHEN ADJUSTMENT_MANAJEMEN = 'Y' THEN BBM_TGL
						ELSE TGL_CLOSE
					END AS TGL_BBM,
					CASE
						WHEN MEDIA_UANG_BBM = 'Voucher' THEN PIC_VOUCHER
						WHEN ADJUSTMENT_MANAJEMEN= 'Y' THEN BBM_PIC
						ELSE PIC_CLOSE
					END AS PIC_BBM,
					KEPUTUSAN_US1,
					KEPUTUSAN_US2,
					KEPUTUSAN_MAKAN
				FROM
				(
					SELECT
						NO_SPJ,
						TOTAL_UANG_JALAN,
						TOTAL_UANG_BBM,
						TOTAL_UANG_TOL,
						TOTAL_UANG_KENDARAAN,
						MEDIA_UANG_SAKU,
						MEDIA_UANG_MAKAN,
						MEDIA_UANG_JALAN,
						MEDIA_UANG_BBM,
						MEDIA_UANG_TOL,
						MEDIA_UANG_KENDARAAN,
						ADJUSTMENT_MANAJEMEN,
						VOUCHER_BBM,
						PIC_CLOSE,
						TGL_CLOSE,
						ABNORMAL
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_SPJ = '$noSPJ'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						CASE
							WHEN KEPUTUSAN_US1 = 'NG' THEN 0
							ELSE UANG_SAKU1
						END AS UANG_SAKU1,

						CASE
							WHEN KEPUTUSAN_US2 = 'NG' THEN 0
							ELSE UANG_SAKU2
						END AS UANG_SAKU2,

						CASE
							WHEN KEPUTUSAN_MAKAN = 'NG' THEN 0
							ELSE UANG_MAKAN
						END AS UANG_MAKAN,
						KEPUTUSAN_US1,
						KEPUTUSAN_US2,
						KEPUTUSAN_MAKAN
					FROM
						SPJ_BIAYA_TAMBAHAN
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					SELECT
						'Y' AS ADJUSTMENT,
						NO_SPJ,
						DIAJUKAN AS UM_DIAJUKAN,
						TGL_KEPUTUSAN AS UM_TGL,
						PIC_KEPUTUSAN AS UM_PIC,
						STATUS AS UM_STATUS
					FROM
						SPJ_ADJUSTMENT
					WHERE
						OBJEK = 'UANG MAKAN'
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ AND Q1.ADJUSTMENT_MANAJEMEN = Q3.ADJUSTMENT
				LEFT JOIN
				(
					SELECT
						'Y' AS ADJUSTMENT,
						NO_SPJ,
						DIAJUKAN AS UJ_DIAJUKAN,
						TGL_KEPUTUSAN AS UJ_TGL,
						PIC_KEPUTUSAN AS UJ_PIC,
						STATUS AS UJ_STATUS
					FROM
						SPJ_ADJUSTMENT
					WHERE
						OBJEK = 'UANG JALAN'
				)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ AND Q1.ADJUSTMENT_MANAJEMEN = Q4.ADJUSTMENT
				LEFT JOIN
				(
					SELECT
						'Y' AS ADJUSTMENT,
						NO_SPJ,
						DIAJUKAN AS BBM_DIAJUKAN,
						TGL_KEPUTUSAN AS BBM_TGL,
						PIC_KEPUTUSAN AS BBM_PIC,
						STATUS AS BBM_STATUS
					FROM
						SPJ_ADJUSTMENT
					WHERE
						OBJEK = 'BBM'
				)Q5 ON Q1.NO_SPJ = Q5.NO_SPJ AND Q1.ADJUSTMENT_MANAJEMEN = Q5.ADJUSTMENT
				LEFT JOIN
				(
					SELECT
						COUNT(NO_PENGAJUAN) AS JML_PIC,
						NO_PENGAJUAN,
						SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
						SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NIK NOT IN ('00003','00004','01519','00917','01223')
					GROUP BY NO_PENGAJUAN
				)Q6 ON Q1.NO_SPJ = Q6.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NO_VOUCHER,
						TGL_INPUT AS TGL_VOUCHER,
						PIC_INPUT AS PIC_VOUCHER
					FROM
						SPJ_VOUCHER_BBM
				)Q7 ON Q1.VOUCHER_BBM = Q7.NO_VOUCHER
				INNER JOIN
				(
					SELECT
						NO_PENGAJUAN,
						COUNT(NIK) AS JML_PIC_UM
					FROM 
						SPJ_PENGAJUAN_PIC
					WHERE
						NIK NOT IN ('00003','00004','01519','00917','01223')
					GROUP BY NO_PENGAJUAN	
				)Q9 ON Q1.NO_SPJ = Q9.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						SUM(JML_PIC) AS JML_PIC_US
					FROM
					(
						SELECT
							CASE 
								WHEN Kendaraan = 'Rental' AND JENIS_PIC = 'Sopir' THEN 0
								ELSE 1
							END AS JML_PIC,
							NO_SPJ
						FROM
							SPJ_PENGAJUAN_PIC a
						INNER JOIN
							SPJ_PENGAJUAN b ON
						a.NO_PENGAJUAN = b.NO_SPJ
					)Q1
					GROUP BY NO_SPJ
				)Q8 ON Q1.NO_SPJ = Q8.NO_SPJ";
		return $this->db->query($sql);
	}
	public function saveCloseSPJ($noSPJ, $saku, $makan, $jalan, $bbm, $tol)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $cekVoucher = $this->db->query("SELECT ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ' AND  VOUCHER = 'Y'");
        if ($cekVoucher->num_rows()>0) {
        	$status = 'CLOSE';
        } else {
        	$status = 'OPEN';
        }
        
		$sql = "UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = '$status',PIC_CLOSE= '$user', TGL_CLOSE = '$tanggal', TOTAL_UANG_SAKU=$saku, TOTAL_UANG_MAKAN=$makan, TOTAL_UANG_JALAN = $jalan, TOTAL_UANG_BBM = $bbm, TOTAL_UANG_TOL=$tol, IMPLEMENTASI = 'Y' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getSPJForGenerate($jenis)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						TGL_SPJ,
						NO_SPJ,
						TGL_INPUT,
						QR_CODE,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM) + TOTAL_UANG_KENDARAAN + TOTAL_UANG_LAINNYA AS TOTAL_SPJ,
						TOTAL_UANG_TOL AS TOTAL_TOL,
						TOTAL_UANG_BBM AS TOTAL_BBM,
						REIMBURSE_BBM,
						TOTAL_UANG_BBM_KATULISTIWA AS TOTAL_BBM_KATULISTIWA,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM)+TOTAL_UANG_TOL+TOTAL_UANG_BBM+TOTAL_UANG_BBM_KATULISTIWA+REIMBURSE_BBM + TOTAL_UANG_KENDARAAN + TOTAL_UANG_LAINNYA AS TOTAL_RP
					FROM
					(
						SELECT
							Q1.TGL_SPJ,
							Q1.TGL_INPUT,
							Q1.QR_CODE,
							Q1.NO_SPJ,
							TOTAL_UANG_SAKU,
							TOTAL_UANG_MAKAN,
							TOTAL_UANG_JALAN,
							TOTAL_UANG_TOL,
							TOTAL_UANG_LAINNYA,
							TOTAL_UANG_KENDARAAN,
							CASE 
								WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Rest Area' THEN TOTAL_UANG_BBM
								ELSE 0
							END AS TOTAL_UANG_BBM,
							CASE 
								WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Katulistiwa' THEN TOTAL_UANG_BBM
								ELSE 0
							END AS TOTAL_UANG_BBM_KATULISTIWA,
							CASE 
								WHEN MEDIA_UANG_BBM IN ('Kasbon','Reimburse') THEN TOTAL_UANG_BBM
								ELSE 0
							END AS REIMBURSE_BBM,
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
								TGL_SPJ,
								TGL_INPUT,
								ID_SPJ,
								QR_CODE,
								NO_SPJ,
								TOTAL_UANG_JALAN,
								TOTAL_UANG_BBM,
								TOTAL_UANG_TOL,
								MEDIA_UANG_BBM,
								ISNULL(TOTAL_UANG_LAINNYA, 0) AS TOTAL_UANG_LAINNYA,
								CASE
									WHEN KENDARAAN = 'Gojek/Grab' THEN TOTAL_UANG_KENDARAAN
									ELSE 0
								END AS TOTAL_UANG_KENDARAAN,
								TEMPAT_SPBU
							FROM
								[dbo].[SPJ_PENGAJUAN]
							WHERE
								STATUS_DATA = 'SAVED' AND
								STATUS_PERJALANAN = 'IN' AND
								STATUS_SPJ = 'CLOSE' AND
								NO_GENERATE IS NULL AND
								JENIS_ID = $jenis
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
					)Q1
				)Q1";
		return $this->db->query($sql);
	}
	public function getDataBiayaAdmin($jenisId)
	{
		$sql = "SELECT
					TGL_INPUT,
					NO_BIAYA_ADMIN,
					TGL_APPROVE,
					BIAYA,
					JENIS_ID
				FROM
					SPJ_BIAYA_ADMIN
				WHERE
					STATUS_APPROVE = 'APPROVED' AND
					NO_BIAYA_ADMIN IS NOT NULL AND
					NO_GENERATE IS NULL AND
					JENIS_ID = '$jenisId'";
		return $this->db->query($sql);
	}
	public function getTotalSPJ($jenis)
	{
		$sql = "SELECT
					COUNT(NO_SPJ) AS JUMLAH_SPJ,
					SUM(TOTAL_SPJ) + SUM(TOTAL_UANG_TOL) + SUM(TOTAL_UANG_BBM) + SUM(REIMBURSE_BBM) AS TOTAL_RP,
					SUM(TOTAL_SPJ) AS TOTAL_SPJ,
					SUM(TOTAL_UANG_TOL) AS TOTAL_TOL,
					SUM(TOTAL_UANG_BBM) AS TOTAL_BBM,
					SUM(TOTAL_UANG_BBM_KATULISTIWA) AS TOTAL_BBM_KATULISTIWA,
					SUM(REIMBURSE_BBM) AS REIMBURSE_BBM
				FROM
				(
					SELECT
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+TOTAL_UANG_KENDARAAN+((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM) AS TOTAL_SPJ,
						TOTAL_UANG_TOL,
						CASE 
							WHEN MEDIA_UANG_BBM IN ('Kasbon','Reimburse') THEN TOTAL_UANG_BBM
							ELSE 0
						END AS REIMBURSE_BBM,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Rest Area' THEN TOTAL_UANG_BBM
							ELSE 0
						END AS TOTAL_UANG_BBM,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Katulistiwa' THEN TOTAL_UANG_BBM
							ELSE 0
						END AS TOTAL_UANG_BBM_KATULISTIWA,
						NO_SPJ
					FROM
					(
						SELECT
							Q1.TGL_SPJ,
							Q1.NO_SPJ,
							TOTAL_UANG_SAKU,
							TOTAL_UANG_MAKAN,
							TOTAL_UANG_JALAN,
							TOTAL_UANG_TOL,
							TOTAL_UANG_KENDARAAN,
							MEDIA_UANG_BBM,
							TOTAL_UANG_BBM,
							JML_PIC_UM,
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
							END AS JML_PIC_RENTAL,
							TEMPAT_SPBU
						FROM
						(
							SELECT
								TGL_SPJ,
								NO_SPJ,
								TOTAL_UANG_JALAN,
								TOTAL_UANG_BBM,
								TOTAL_UANG_TOL,
								MEDIA_UANG_BBM,
								CASE
									WHEN KENDARAAN = 'Gojek/Grab' THEN TOTAL_UANG_KENDARAAN
									ELSE 0
								END AS TOTAL_UANG_KENDARAAN,
								TEMPAT_SPBU
							FROM
								[dbo].[SPJ_PENGAJUAN]
							WHERE
								STATUS_DATA = 'SAVED' AND
								STATUS_PERJALANAN = 'IN' AND
								STATUS_SPJ = 'CLOSE' AND
								NO_GENERATE IS NULL AND
								JENIS_ID = $jenis
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
						INNER JOIN
						(
							SELECT
								NO_PENGAJUAN,
								COUNT(NIK) AS JML_PIC_UM
							FROM 
								SPJ_PENGAJUAN_PIC
							WHERE
								NIK NOT IN ('00003','00004','01519','00917','01223')
							GROUP BY NO_PENGAJUAN	
						)Q7 ON Q1.NO_SPJ = Q7.NO_PENGAJUAN
					)Q1
				)Q1";
		return $this->db->query($sql);
	}
	public function getTotalBiayaAdmin()
	{
		$sql = "SELECT
					JML_BIAYA_ADMIN,
					TOTAL_BIAYA_ADMIN
				FROM
				(
					SELECT
						COUNT(ID) AS JML_BIAYA_ADMIN,
						'LINK' AS LINK
					FROM
						SPJ_BIAYA_ADMIN
					WHERE
						STATUS_APPROVE = 'APPROVED' AND
						NO_BIAYA_ADMIN IS NOT NULL AND
						NO_GENERATE IS NULL
				)Q1 
				LEFT JOIN
				(
					SELECT
						SUM(BIAYA) AS TOTAL_BIAYA_ADMIN,
						'LINK' AS LINK
					FROM
						SPJ_BIAYA_ADMIN
					WHERE
						STATUS_APPROVE = 'APPROVED' AND
						NO_BIAYA_ADMIN IS NOT NULL AND
						NO_GENERATE IS NULL		
				)Q2 ON Q1.LINK = Q2.LINK";
		return $this->db->query($sql);
	}
	public function getNoGenerate($jenis)
	{
		$kodeJenis = $jenis == '1'?'DLV':'NDV';
		$tahun = date('Y');
        $bulan = date('m');
		$gabung = "GNR/".$kodeJenis."/".$tahun."/".$bulan."/";
		$cekNoGenerate=$this->db->query("SELECT MAX
										( RIGHT ( NO_GENERATE, 4 ) ) AS SET_URUTAN
									FROM
										SPJ_GENERATE
									WHERE
										NO_GENERATE LIKE '$gabung%' ");
		foreach ($cekNoGenerate->result() as $data) {
            if ($data->SET_URUTAN =="") {
                $noGenerate = $gabung."0001";
            }else{
                $zero='';
                $length= 4;
                $index=$data->SET_URUTAN;

                for ($i=0; $i <$length-strlen($index+1) ; $i++) { 
                    $zero = $zero.'0';
                }
                $noGenerate = $gabung.$zero.($index+1);
                
            }
            
        }
        return $noGenerate;
	}
	public function getNoGenerateKendaraanRental()
	{
		$tahun = date('Y');
        $bulan = date('m');
		$gabung = "GNR/KR/".$tahun."/".$bulan."/";
		$cekNoGenerate=$this->db->query("SELECT MAX
										( RIGHT ( NO_GENERATE, 4 ) ) AS SET_URUTAN
									FROM
										SPJ_GENERATE
									WHERE
										NO_GENERATE LIKE '$gabung%' ");
		foreach ($cekNoGenerate->result() as $data) {
            if ($data->SET_URUTAN =="") {
                $noGenerate = $gabung."0001";
            }else{
                $zero='';
                $length= 4;
                $index=$data->SET_URUTAN;

                for ($i=0; $i <$length-strlen($index+1) ; $i++) { 
                    $zero = $zero.'0';
                }
                $noGenerate = $gabung.$zero.($index+1);
                
            }
            
        }
        return $noGenerate;
	}
	public function saveGenerateSPJ($inputNoGenerate, $inputJumlahSPJ, $inputTotalRP, $filJenis, $jmlBA, $inputTotalBA, $rekananId)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $tanggal2 = date("Y-m-d");
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_GENERATE(NO_GENERATE, TGL_GENERATE, JML_SPJ, TOTAL_RP, PIC_INPUT, JENIS_SPJ, TGL_INPUT, JML_BA, TOTAL_BA, REKANAN_ID) VALUES('$inputNoGenerate','$tanggal2',$inputJumlahSPJ, $inputTotalRP, '$user',$filJenis,'$tanggal',$jmlBA, $inputTotalBA, $rekananId)";
		return $this->db->query($sql);
	}
	public function getBiayaTotalPerNoSPJNEW($noSPJ)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						NO_SPJ,
						TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+((TAMBAHAN_UANG_SAKU1+TAMBAHAN_UANG_SAKU2)*JML_PIC_US)+(TAMBAHAN_UANG_MAKAN*JML_PIC_UM)+TOTAL_UANG_KENDARAAN+TOTAL_UANG_LAINNYA AS KASBON_SPJ,
						TOTAL_UANG_TOL AS KASBON_TOL,
						TOTAL_UANG_BBM AS KASBON_BBM,
						TOTAL_UANG_BBM_KATULISTIWA AS KASBON_BBM_KATULISTIWA,
						REIMBURSE_BBM

					FROM
					(
						SELECT
							Q1.TGL_SPJ,
							Q1.TGL_INPUT,
							Q1.QR_CODE,
							Q1.NO_SPJ,
							TOTAL_UANG_SAKU,
							TOTAL_UANG_MAKAN,
							TOTAL_UANG_JALAN,
							TOTAL_UANG_TOL,
							TOTAL_UANG_LAINNYA,
							TOTAL_UANG_KENDARAAN,
							CASE 
								WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Rest Area' THEN TOTAL_UANG_BBM
								ELSE 0
							END AS TOTAL_UANG_BBM,
							CASE 
								WHEN MEDIA_UANG_BBM = 'Voucher' AND TEMPAT_SPBU = 'Katulistiwa' THEN TOTAL_UANG_BBM
								ELSE 0
							END AS TOTAL_UANG_BBM_KATULISTIWA,
							CASE 
								WHEN MEDIA_UANG_BBM IN ('Kasbon','Reimburse') THEN TOTAL_UANG_BBM
								ELSE 0
							END AS REIMBURSE_BBM,
							JML_PIC_UM,
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
							END AS JML_PIC_RENTAL,
							TEMPAT_SPBU
						FROM
						(
							SELECT
								TGL_SPJ,
								TGL_INPUT,
								ID_SPJ,
								QR_CODE,
								NO_SPJ,
								TOTAL_UANG_JALAN,
								TOTAL_UANG_BBM,
								TOTAL_UANG_TOL,
								MEDIA_UANG_BBM,
								ISNULL(TOTAL_UANG_LAINNYA, 0) AS TOTAL_UANG_LAINNYA,
								CASE
									WHEN KENDARAAN = 'Gojek/Grab' THEN TOTAL_UANG_KENDARAAN
									ELSE 0
								END AS TOTAL_UANG_KENDARAAN,
								TEMPAT_SPBU
							FROM
								[dbo].[SPJ_PENGAJUAN]
							WHERE
								STATUS_DATA = 'SAVED' AND
								STATUS_PERJALANAN = 'IN' AND
								STATUS_SPJ = 'CLOSE' AND
								NO_GENERATE IS NULL AND
								NO_SPJ = '$noSPJ'
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
						INNER JOIN
						(
							SELECT
								NO_PENGAJUAN,
								COUNT(NIK) AS JML_PIC_UM
							FROM 
								SPJ_PENGAJUAN_PIC
							WHERE
								NIK NOT IN ('00003','00004','01519','00917','01223')
							GROUP BY NO_PENGAJUAN	
						)Q7 ON Q1.NO_SPJ = Q7.NO_PENGAJUAN
					)Q1
				)Q1";
		return $this->db->query($sql);
	}
	public function getBiayaTotalPerNoSPJ($noSPJ)
	{
		$sql = "SELECT
					NO_SPJ,
					TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+KASBON_BBM+KASBON_TOL+BIAYA_TAMBAHAN AS KASBON_SPJ,
					TOTAL_UANG_TOL AS KASBON_TOL,
					TOTAL_UANG_BBM AS KASBON_BBM
				FROM
				(
					SELECT
						Q1.NO_SPJ,
						UANG_SAKU AS TOTAL_UANG_SAKU,
						UANG_MAKAN AS TOTAL_UANG_MAKAN,
						TOTAL_UANG_JALAN,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' THEN TOTAL_UANG_BBM
							ELSE 0
						END AS TOTAL_UANG_BBM,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' THEN 0
							ELSE TOTAL_UANG_BBM
						END AS KASBON_BBM,
						CASE 
							WHEN MEDIA_UANG_TOL = 'Reimburse' THEN TOTAL_UANG_TOL
							ELSE 0
						END AS TOTAL_UANG_TOL,
						CASE 
							WHEN MEDIA_UANG_TOL = 'Reimburse' THEN 0
							ELSE TOTAL_UANG_TOL
						END AS KASBON_TOL,
						(UANG_SAKU1*JML_PIC_US)+(UANG_SAKU2*JML_PIC_US)+(UM_TAMBAHAN*JML) AS BIAYA_TAMBAHAN
					FROM
					(
						SELECT
							NO_SPJ,
							MEDIA_UANG_BBM,
							MEDIA_UANG_TOL,
							TOTAL_UANG_TOL,
							TOTAL_UANG_BBM,
							TOTAL_UANG_JALAN
						FROM
							SPJ_PENGAJUAN
						WHERE
							STATUS_DATA = 'SAVED' AND
							NO_SPJ = '$noSPJ'
					)Q1
					LEFT JOIN
					(
						SELECT
							COUNT(NO_PENGAJUAN) AS JML,
							SUM(UANG_SAKU) AS UANG_SAKU,
							SUM(UANG_MAKAN) AS UANG_MAKAN,
							NO_PENGAJUAN
						FROM
							SPJ_PENGAJUAN_PIC
						GROUP BY NO_PENGAJUAN
					)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
					LEFT JOIN
					(
						SELECT
							NO_SPJ,
							UANG_SAKU1,
							UANG_SAKU2,
							UANG_MAKAN AS UM_TAMBAHAN
						FROM
							SPJ_BIAYA_TAMBAHAN
					)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
					LEFT JOIN
					(
						SELECT
							NO_SPJ,
							SUM(JML_PIC) AS JML_PIC_US
						FROM
						(
							SELECT
								NIK,
								NO_SPJ,
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
						GROUP BY NO_SPJ
					)Q4 ON Q1.NO_SPJ = Q4.NO_SPJ
				)Q1";
		return $this->db->query($sql);
	}
	public function generatePengajuanKas($inputNoGenerate, $kasbonSPJ, $kasbonBBM, $kasbonTOL, $jenisID, $jmlBA, $inputTotalBA, $voucherRA, $voucherKA)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        if ($jenisID == '1') {
        	$coa = "6-1101";
        }else{
        	$coa = "6-3106";
        }
		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$kasbonSPJ, 'Kasbon SPJ','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','$coa')");
		if ($kasbonBBM > 0) {
			$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$kasbonBBM, 'Kasbon BBM','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','6-3003')");
		}

		if ($kasbonTOL>0) {
			$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$kasbonTOL, 'Kasbon TOL','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','6-3003')");
		}
		
		if ($voucherRA>0) {
			$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$voucherRA, 'Kasbon Voucher BBM Rest Area','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','6-3003')");
		}
		
		if ($voucherKA>0) {
			$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$voucherKA, 'Kasbon Voucher BBM Katulistiwa','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','6-3003')");
		}
		
		if ($jmlBA>0) {
			$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO, COA)VALUES('$user','$tanggal','Generate',$inputTotalBA, 'Biaya Admin TOL','Kas Induk','$inputNoGenerate',$jenisID,'OPEN','9-1101')");
		}
		
		return $sql;
	}
	public function getHistoryInOutLokal($noSPJ)
	{
		$sql = "SELECT
					Q1.*,
					LAST_KM
				FROM
				(
					SELECT
						TGL_INPUT,
						PIC_INPUT,
						NO_SPJ,
						STATUS,
						KM 
					FROM
						SPJ_HISTORY_IN_OUT 
					WHERE
						NO_SPJ = '$noSPJ'
				)Q1
				LEFT JOIN
				(
					SELECT
						MAX(KM) AS LAST_KM,
						NO_SPJ
					FROM
						SPJ_HISTORY_IN_OUT
					GROUP BY NO_SPJ
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ";
		return $this->db->query($sql);
	}
	public function saveHistoryInOut($noSPJ, $status, $km)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_HISTORY_IN_OUT(TGL_INPUT, PIC_INPUT, NO_SPJ, STATUS, KM)VALUES('$tanggal','$user','$noSPJ','$status', $km)";
		$this->db->query("UPDATE SPJ_PENGAJUAN SET STATUS_PERJALANAN = '$status' WHERE NO_SPJ= '$noSPJ'");
		return $this->db->query($sql);
	}
	public function saveHistoryNG($noSPJ, $jenis, $subjek, $keterangan, $status)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_HISTORY_NG_SECURITY(NO_SPJ, PIC_INPUT, TGL_INPUT, JENIS, SUBJEK, ALASAN, STATUS)VALUES('$noSPJ','$user','$tanggal', '$jenis','$subjek','$keterangan','$status')";
        return $this->db->query($sql);
	}
	public function updateHistoryNG($noSPJ)
	{
		$sql = "UPDATE SPJ_HISTORY_NG_SECURITY SET STATUS_NOTIF = 'READ' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function saveLokalSelesai($noSPJ)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET LOKAL_SELESAI = 'Y' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getTabelAktualSecurityCheck($noSPJ)
	{
		$sql = "SELECT
					ID,
					NIK,
					NAMA,
					SEBAGAI
				FROM
					SPJ_AKTUAL_PIC_SECURITY
				WHERE
					NO_SPJ = '$noSPJ'
				ORDER BY ID DESC";
		return $this->db->query($sql);
	}
	public function getPICAktual($cari)
	{
		$sql = "SELECT TOP 25
					SUBSTRING(nik, 1, 5)+'||'+namapeg AS ID,
					SUBSTRING(nik, 1, 5)+' - '+namapeg AS VAL
				FROM
				(
					SELECT
						nik,
						namapeg
					FROM
						dbhrm.dbo.tbPegawai
					WHERE
						status_aktif = 'AKTIF'
					UNION
					SELECT
						KdSopir,
						NamaSopir
					FROM
						TrTS_SopirRental
					WHERE
						StatusAktif = 'Aktif'
					UNION
					SELECT
						KdSopir,
						NamaSopir
					FROM
						TrTS_SopirLogistik
					WHERE
						StatusAktif = 'Aktif'
				)Q1
				WHERE
					nik LIKE '%$cari%' OR
					namapeg LIKE '%$cari%'";
		return $this->db->query($sql);
	}
	public function saveAktualPIC($nik, $nama, $sebagai, $noSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_AKTUAL_PIC_SECURITY(NO_SPJ, PIC_INPUT, TGL_INPUT, NIK, NAMA, SEBAGAI)VALUES('$noSPJ','$user','$tanggal','$nik','$nama','$sebagai')";
       	return $this->db->query($sql);
	}
	public function hapusPICAktual($noSPJ, $nik, $nama, $sebagai)
	{
		$sql ="DELETE FROM SPJ_AKTUAL_PIC_SECURITY WHERE NO_SPJ= '$noSPJ' AND NIK = '$nik' AND NAMA = '$nama' AND SEBAGAI = '$sebagai'";
		return $this->db->query($sql);
	}
	public function getKendaraanNotSPJ($no)
	{
		$sql = "SELECT
					Q1.*,
					CASE 
						WHEN NAMA_FILE IS NULL THEN 'car.png'
						ELSE 'foto-kendaraan/'+NAMA_FILE
					END AS NAMA_FILE,
					ISNULL(KM, 0) AS KM,
					ISNULL(KM_OUT, 0) AS KM_OUT,
					KETERANGAN
				FROM
				(
					SELECT
						NoTNKB,
						Merk,
						Type,
						Jenis,
						Kategori,
						CASE 
							WHEN NO_TNKB IS NULL THEN 'OUT'
							ELSE 'IN'
						END AS STATUS	
						FROM
						GA.dbo.GA_TKendaraan a
					LEFT JOIN
						SPJ_TEMP_KENDARAAN b
					ON a.NoTNKB = b.NO_TNKB
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_TNBK,
						NAMA_FILE
					FROM
						SPJ_GAMBAR_KENDARAAN
					WHERE
						STAR = 'Y'
				)Q2 ON Q1.NoTNKB = Q2.NO_TNBK
				LEFT JOIN
				(
					SELECT
						NO_TNKB,
						KM
					FROM
						SPJ_CHECK_KENDARAAN
				)Q3 ON Q1.NoTNKB = Q3.NO_TNKB
				LEFT JOIN
				(
					SELECT
						NO_TNKB,
						KM_OUT,
						KETERANGAN
					FROM
						SPJ_SCAN_KENDARAAN
					WHERE
						KM_IN IS NULL
				)Q4 ON Q1.NoTNKB = Q4.NO_TNKB
				WHERE
					NoTNKB = '$no'";
		return $this->db->query($sql);
	}
	public function scanKendaraanNotSPJ($no, $status, $keterangan, $km)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");

		if ($status == 'OUT') {
			$save = $this->db->query("INSERT INTO SPJ_SCAN_KENDARAAN(NO_TNKB, TGL_SCAN, PIC_SCAN, STATUS, KETERANGAN, KM_OUT)VALUES('$no','$tanggal','$user','$status','$keterangan','$km')");
			$this->db->query("INSERT INTO SPJ_TEMP_KENDARAAN(NO_TNKB, NO_SPJ)VALUES('$no','-')");
		}else{
			$save = $this->db->query("UPDATE SPJ_SCAN_KENDARAAN SET KM_IN = $km, STATUS = '$status', TGL_SCAN_IN = '$tanggal', KETERANGAN='$keterangan' WHERE NO_TNKB = '$no' AND KM_IN IS NULL");
			$this->db->query("DELETE FROM SPJ_TEMP_KENDARAAN WHERE NO_TNKB = '$no'");
		}

		if ($save == true) {
			$get = $this->db->query("SELECT ID FROM SPJ_CHECK_KENDARAAN WHERE NO_TNKB = '$no'");
			if ($get->num_rows() == 0) {
				$this->db->query("INSERT INTO SPJ_CHECK_KENDARAAN(NO_TNKB, KM, PIC_LAST, TGL_LAST)VALUES('$no','$km','$user','$tanggal')");
			}else{
				$this->db->query("UPDATE SPJ_CHECK_KENDARAAN SET KM = '$km' WHERE NO_TNKB = '$no'");
			}
		}
		return $save;
		
	}
	public function cekKendaraanRental($noTNKB)
	{
		$sql = "SELECT
					Q1.NO_TNKB
				FROM
				(
					SELECT
						NO_TNKB
					FROM
						[dbo].[SPJ_VERIFIKASI_KENDARAAN]
					WHERE
						NO_TNKB = '$noTNKB'
				)Q1
				INNER JOIN
				(
					SELECT
						NoTNKB
					FROM
						SPJ_KENDARAAN_REKANAN
				)Q2 ON Q1.NO_TNKB = Q2.NoTNKB";
		return $this->db->query($sql);
	}
	public function getListSPJForOutstanding($bulan, $tahun, $jenis, $search, $group)
	{
		$sql = "SELECT
					Q1.*,
					TGL_INPUT,
					PIC_INPUT,
					NAMA_INPUT,
					DEPARTEMEN_INPUT,
					JABATAN_INPUT,
					ID_SPJ,
					STATUS_SPJ,
					NAMA_JENIS,
					TGL_SPJ,
					QR_CODE,
					NAMA_GROUP,
					NIK_DRIVER+' - '+NAMA_DRIVER AS PIC_DRIVER,
					NIK_DRIVER,
					NAMA_DRIVER,
					TOTAL_UANG_SAKU,
					TOTAL_UANG_MAKAN,
					TOTAL_UANG_JALAN,
					TOTAL_UANG_BBM,
					CASE 
						WHEN UANG_SAKU1>0 THEN 'Y'
						ELSE 'N'
					END CHECK_UANG_SAKU1,
					CASE 
						WHEN UANG_SAKU2>0 THEN 'Y'
						ELSE 'N'
					END CHECK_UANG_SAKU2,
					CASE 
						WHEN UANG_MAKAN>0 THEN 'Y'
						ELSE 'N'
					END CHECK_UANG_MAKAN
				FROM
				(
					SELECT
						NO_SPJ,
						UANG_SAKU1,
						UANG_SAKU2,
						UANG_MAKAN
					FROM
						SPJ_BIAYA_TAMBAHAN
					WHERE
						STATUS_US1 = 'OUTSTANDING' OR
						STATUS_US2 = 'OUTSTANDING' OR
						STATUS_MAKAN = 'OUTSTANDING'
				)Q1
				INNER JOIN
				(
					SELECT
						*
					FROM
					(
						SELECT
							a.TGL_INPUT,
							NO_SPJ,
							ID_SPJ,
							NAMA_JENIS,
							TGL_SPJ,
							QR_CODE,
							NAMA_GROUP,
							a.PIC_INPUT,
							e.namapeg AS NAMA_INPUT,
							e.departemen AS DEPARTEMEN_INPUT,
							e.jabatan AS JABATAN_INPUT,
							TOTAL_UANG_JALAN,
							TOTAL_UANG_BBM,
							STATUS_SPJ
						FROM
							SPJ_PENGAJUAN a
						INNER JOIN
							SPJ_JENIS b ON
						a.JENIS_ID = b.ID_JENIS
						INNER JOIN
							SPJ_GROUP_TUJUAN c ON
						a.GROUP_ID = c.ID_GROUP
						LEFT JOIN
							dbhrm.dbo.tbPegawai e ON
						a.PIC_INPUT = e.nik
						WHERE
							YEAR(TGL_SPJ) LIKE '$tahun%' AND
							DATENAME(MONTH,TGL_SPJ) LIKE '$bulan%' AND
							JENIS_ID LIKE '$jenis%' AND
							GROUP_ID LIKE '$group%' AND
							STATUS_SPJ LIKE '%'
					)Q1
					LEFT JOIN 
					(
						SELECT
							NO_PENGAJUAN,
							NIK AS NIK_DRIVER,
							NAMA AS NAMA_DRIVER
						FROM
							SPJ_PENGAJUAN_PIC
						WHERE
							JENIS_PIC = 'Sopir'
					)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
						SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
					FROM
						SPJ_PENGAJUAN_PIC
					GROUP BY NO_PENGAJUAN
				)Q3 ON Q1.NO_SPJ = Q3.NO_PENGAJUAN
				WHERE
					Q1.NO_SPJ LIKE '%$search%'
				ORDER BY Q2.TGL_SPJ DESC";
		return $this->db->query($sql);
	}
	public function cekPICStatusPerjalanan($scan)
	{
		$sql = "SELECT 
					NIK,
					NAMA
				FROM
					SPJ_PENGAJUAN a
				INNER JOIN
					SPJ_PENGAJUAN_PIC b ON
				a.NO_SPJ = b.NO_PENGAJUAN
				INNER JOIN
					SPJ_TEMP_PIC c ON
				b.NIK = c.PIC AND a.NO_SPJ = c.NO_SPJ
				WHERE
					QR_CODE = '$scan'";
		return $this->db->query($sql);
	}
	public function cekPICdanKendaraanOut($noSPJ)
	{
		$sql = "SELECT
					CASE 
						WHEN JML_KENDARAAN IS NULL THEN 0
						ELSE JML_KENDARAAN
					END AS JML_KENDARAAN,
					CASE 
						WHEN JML_PIC IS NULL THEN 0
						ELSE JML_PIC
					END AS JML_PIC
				FROM
				(
					SELECT
						COUNT(a.NO_TNKB) AS JML_KENDARAAN,
						'SATU' AS SATU
					FROM
						[dbo].[SPJ_PENGAJUAN] a
					INNER JOIN
						SPJ_TEMP_KENDARAAN b ON
					a.NO_TNKB = b.NO_TNKB
					WHERE
						a.NO_SPJ = '$noSPJ'
				)Q1
				FULL JOIN
				(
					SELECT
						COUNT(b.NIK) AS JML_PIC,
						'SATU' AS SATU
					FROM
						SPJ_PENGAJUAN a
					INNER JOIN
						SPJ_PENGAJUAN_PIC b ON
					a.NO_SPJ = b.NO_PENGAJUAN
					INNER JOIN
						SPJ_TEMP_PIC c ON
					b.NIK = c.PIC
					WHERE
						a.NO_SPJ = '$noSPJ'
				)Q2 ON Q1.SATU = Q2.SATU";
		return $this->db->query($sql);
	}
	public function savePengajuanOtoritasBBM($noSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_PENGAJUAN_BBM(NO_SPJ, TGL, PIC, STATUS)VALUES('$noSPJ','$tanggal','$user','OPEN')";
        return $this->db->query($sql);
	}
	public function savePengajuanOtoritasBBM_v2($noSPJ, $bbm, $keterangan)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_PENGAJUAN_BBM(NO_SPJ, TGL, PIC, STATUS, BBM, KETERANGAN)VALUES('$noSPJ','$tanggal','$user','OPEN', $bbm, '$keterangan')";
        return $this->db->query($sql);
	}
	public function getAksesManualBBM($noSPJ)
	{
		$sql = "SELECT TOP 1
					STATUS,
					BBM
				FROM
					[dbo].[SPJ_PENGAJUAN_BBM]
				WHERE 
					NO_SPJ = '$noSPJ'
				ORDER BY ID DESC";
		return $this->db->query($sql);
	}
	public function getDataAksesOtoritas($status)
	{
		$sql = "SELECT
					Q1.ID,
					Q1.TGL,
					Q1.PIC,
					Q1.NAMA_PIC,
					Q1.STATUS,
					Q1.BBM,
					Q1.KETERANGAN,
					Q2.*,
					NIK_DRIVER,
					NAMA_DRIVER,
					KEBERANGKATAN,
					KEPULANGAN,
					DIFF_HOUR,
					KM_OUT,
					KM_IN,
					SELISIH_KM,
					NoTNKB,
					BBMPerLiter
				FROM
				(
					SELECT
						a.ID,
						a.NO_SPJ,
						a.TGL,
						a.PIC,
						b.namapeg AS NAMA_PIC,
						a.STATUS,
						a.BBM,
						a.KETERANGAN
					FROM
						[dbo].[SPJ_PENGAJUAN_BBM] a
					LEFT JOIN
						dbhrm.dbo.tbPegawai b ON
					a.PIC = b.NIK
					WHERE
						a.STATUS LIKE '%$status%'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						TGL_SPJ,
						NAMA_JENIS,
						KENDARAAN,
						MERK,
						TYPE,
						JENIS_KENDARAAN,
						NO_TNKB,
						NAMA_GROUP
					FROM
						SPJ_PENGAJUAN a
					INNER JOIN 
						SPJ_JENIS b ON
					a.JENIS_ID = b.ID_JENIS
					INNER JOIN SPJ_GROUP_TUJUAN c ON
					a.GROUP_ID = c.ID_GROUP
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						NIK AS NIK_DRIVER,
						NAMA AS NAMA_DRIVER
					FROM
						SPJ_PENGAJUAN_PIC 
					WHERE
						JENIS_PIC = 'Sopir'
				)Q3 ON Q2.NO_SPJ = Q3.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						KEBERANGKATAN,
						KEPULANGAN,
						DATEDIFF(hh, KEBERANGKATAN, KEPULANGAN) AS DIFF_HOUR,
						KM_OUT,
						KM_IN,
						KM_IN - KM_OUT AS SELISIH_KM
					FROM
						SPJ_VALIDASI
				)Q4 ON Q2.NO_SPJ = Q4.NO_SPJ
				LEFT JOIN
				(
					SELECT
						NoTNKB,
						ISNULL(BBMPerLiter, 0) AS BBMPerLiter
					FROM
						GA.dbo.GA_TKendaraan
					UNION
					SELECT
						NoTNKB,
						ISNULL(BBMPerLiter, 0) AS BBMPerLiter
					FROM
						SPJ_KENDARAAN_REKANAN
				)Q5 ON Q2.NO_TNKB = Q5.NoTNKB
				ORDER BY Q1.ID ASC";
		return $this->db->query($sql);
	}
	public function getHargaBBM($jenis)
	{
		$sql = "SELECT HARGA FROM [dbo].[SPJ_BIAYA_BBM] WHERE JENIS = '$jenis'";
		return $this->db->query($sql);
	}
	public function saveAksesOtoritas($id, $status)
	{
		$sql = "UPDATE SPJ_PENGAJUAN_BBM SET STATUS = '$status' WHERE ID=$id";
		return $this->db->query($sql);
	}
	public function getDataGenerateKendaraan($jenis, $rekanan)
	{
		$sql = "SELECT
					ID_SPJ,
					TGL_INPUT,
					NO_SPJ,
					TGL_SPJ,
					NO_TNKB,
					REKANAN_ID
				FROM
					[dbo].[SPJ_PENGAJUAN]
				WHERE
					STATUS_PERJALANAN = 'IN' AND
					JENIS_ID = $jenis AND
					REKANAN_ID = $rekanan AND
					NO_GENERATE_KENDARAAN IS NULL
				ORDER BY NO_SPJ ASC";
		return $this->db->query($sql);
	}
	public function generateKendaraanRental($inputNoGenerate, $sewaKendaraan, $potonganPPh, $inputJenis, $nama)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $jenisKasbon1 = 'Sewa Kendaraan Rental '.$nama;
        $jenisKasbon2 = 'PPh Sewa Kendaraan Rental '.$nama;
		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, PIC_APPROVE, TGL_APPROVE, STATUS_APPROVE, PIC_RECEIVE, TGL_RECEIVE, STATUS_RECEIVE, STATUS_PENGAJUAN_SALDO, JENIS_ID, COA)VALUES('$user','$tanggal','Generate','$sewaKendaraan','$jenisKasbon1','-','$inputNoGenerate','$user','$tanggal','APPROVED','$user','$tanggal','RECEIVED','CLOSE','$inputJenis','6-3106')");

		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, PIC_APPROVE, TGL_APPROVE, STATUS_APPROVE, PIC_RECEIVE, TGL_RECEIVE, STATUS_RECEIVE, STATUS_PENGAJUAN_SALDO, JENIS_ID, COA)VALUES('$user','$tanggal','Generate','$potonganPPh','$jenisKasbon2','-','$inputNoGenerate','$user','$tanggal','APPROVED','$user','$tanggal','RECEIVED','CLOSE','$inputJenis','2-1301')");
		
		return $sql;
	}
	public function updateUangPIC($noSPJ, $nik, $uang, $jenis, $jenisSPJ)
	{
		if ($jenis == 'Uang Makan') {
			$field = 'UANG_MAKAN';
			$field2 = 'TOTAL_UANG_MAKAN';
		}else{
			$field = 'UANG_SAKU';
			$field2 = 'TOTAL_UANG_SAKU';
		}

		$sql = $this->db->query("UPDATE SPJ_PENGAJUAN_PIC SET $field = $uang WHERE NIK = '$nik' AND NO_PENGAJUAN = '$noSPJ'");
		if ($sql == true && $jenis == 'Uang Makan') {
			$getSum = $this->db->query("SELECT
											Q1.UANG_MAKAN + (Q1.JML_PIC*Q2.UANG_MAKAN) AS UANG_MAKAN,
											ISNULL(Q1.UANG_MAKAN, 0) + ISNULL(UANG_SAKU, 0) + ISNULL(TOTAL_UANG_JALAN, 0) + ISNULL(TOTAL_UANG_BBM, 0) AS TOTAL_KAS,
											Q3.ID_SPJ
										FROM
										(
											SELECT
												SUM(UANG_MAKAN) AS UANG_MAKAN,
												SUM(UANG_SAKU) AS UANG_SAKU,
												COUNT(NO_PENGAJUAN) AS JML_PIC,
												NO_PENGAJUAN
											FROM
												[dbo].[SPJ_PENGAJUAN_PIC]
											WHERE
												NO_PENGAJUAN = '$noSPJ'
											GROUP BY NO_PENGAJUAN
										)Q1
										LEFT JOIN
										(
											SELECT
												NO_SPJ,
												SUM(UANG_MAKAN) AS UANG_MAKAN
											FROM
												SPJ_BIAYA_TAMBAHAN
											WHERE
												NO_SPJ = '$noSPJ'
											GROUP BY NO_SPJ
										)Q2 ON Q1.NO_PENGAJUAN = Q2.NO_SPJ
										LEFT JOIN
										(
											SELECT
												ID_SPJ,
												NO_SPJ,
												TOTAL_UANG_JALAN
											FROM
												SPJ_PENGAJUAN
										)Q3 ON Q1.NO_PENGAJUAN = Q3.NO_SPJ
										LEFT JOIN 
										(
											SELECT
												TOTAL_UANG_BBM,
												NO_SPJ
											FROM
												SPJ_PENGAJUAN
											WHERE
												MEDIA_UANG_BBM = 'Kasbon'
										)Q4 ON Q1.NO_PENGAJUAN = Q4.NO_SPJ")->row();
			$uangMakanSum = $getSum->UANG_MAKAN + $uang;
			$uangKas = round($getSum->TOTAL_KAS);
			$fkId = $getSum->ID_SPJ;
			$kasbon = 'Kasbon SPJ '.$jenisSPJ;
			$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_MAKAN = $uangMakanSum WHERE NO_SPJ = '$noSPJ'");
			$this->db->query("UPDATE SPJ_KAS_SUB SET CREDIT = '$uangKas' WHERE JENIS_FK = 'KASBON' AND JENIS_KASBON = '$kasbon' AND DETAIL_KASBON = 'TRANSAKSI AWAL' AND FK_ID = $fkId");
		}
		return $sql;

	}
	public function revisiKeberangkatan($noSPJ, $keberangkatan, $kepulangan, $kmOut, $kmIn)
	{
		$sql = "UPDATE SPJ_VALIDASI SET KEBERANGKATAN = '$keberangkatan', KEPULANGAN = '$kepulangan', KM_OUT = '$kmOut', KM_IN = '$kmIn' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function saveSPJ($noSPJ, $saku, $makan, $jalan, $bbm, $tol)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "UPDATE SPJ_PENGAJUAN SET PIC_CLOSE= '$user', TGL_CLOSE = '$tanggal', TOTAL_UANG_SAKU=$saku, TOTAL_UANG_MAKAN=$makan, TOTAL_UANG_JALAN = $jalan, TOTAL_UANG_BBM = $bbm, TOTAL_UANG_TOL=$tol WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function closeImplementasi($noSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $cekVoucher = $this->db->query("SELECT ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ' AND  VOUCHER = 'Y'");
        if ($cekVoucher->num_rows()>0) {
        	$status = 'CLOSE';
        } else {
        	$status = 'OPEN';
        }

        $sql = "UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = '$status', IMPLEMENTASI = 'Y' WHERE NO_SPJ = '$noSPJ'";
        return $this->db->query($sql);
	}
	public function getSPJStep1($tahun, $bulan, $jenisSPJ, $group, $search)
	{
		$sql = "SELECT
					ROW_NUMBER() over (partition by 'SAMA' order by TGL_INPUT DESC) AS NO_URUT,
					*
				FROM
				(
					SELECT
						a.ID_SPJ,
						a.TGL_INPUT,
						a.NO_SPJ,
						a.TGL_SPJ,
						a.QR_CODE,
						a.GROUP_ID,
						a.STATUS_SPJ,
						a.TOTAL_UANG_TOL,
						b.NAMA_GROUP,
						a.JENIS_ID
					FROM
						[dbo].[SPJ_PENGAJUAN] a
					INNER JOIN
						SPJ_GROUP_TUJUAN b ON
					a.GROUP_ID = b.ID_GROUP
					WHERE
						STATUS_SPJ = 'OPEN' 
						AND IMPLEMENTASI IS NULL 
						AND STATUS_DATA = 'SAVED'
						AND STATUS_PERJALANAN = 'IN'
						AND JENIS_ID LIKE '$jenisSPJ%' 
						AND NAMA_GROUP LIKE '$group%'
						AND YEAR(TGL_SPJ) LIKE '$tahun%'
						AND DATENAME(MONTH, TGL_SPJ) LIKE '$bulan%'
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
				WHERE
					NO_SPJ LIKE '%$search%' OR
					PIC_DRIVER LIKE '%$search%' OR
					QR_CODE LIKE '%$search%'";
		return $this->db->query($sql);
	}
	public function saveLogImplementasi($noSPJ, $aktivitas, $nominal)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_LOG_IMPLEMENTASI(PIC_INPUT, TGL_INPUT, NO_SPJ, AKTIVITAS, NOMINAL)VALUES('$user','$tanggal','$noSPJ','$aktivitas','$nominal')";
        return $this->db->query($sql);
	}
	public function saveLogImplementasiKeberangkatan($noSPJ, $berangkat, $pulang,$kmOut, $kmIn)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "INSERT INTO SPJ_LOG_IMPLEMENTASI(PIC_INPUT, TGL_INPUT, NO_SPJ, AKTIVITAS, KEBERANGKATAN, KEPULANGAN, KM_OUT, KM_IN)VALUES('$user','$tanggal','$noSPJ','Revisi Keberangkatan','$berangkat','$pulang',$kmOut, $kmIn)";
        return $this->db->query($sql);
	}
	public function saveBiayaKendaraan($noSPJ, $biaya)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_KENDARAAN = $biaya WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getTotalKasbon($noSPJ)
	{
		$sql = $this->db->query("SELECT
									TOTAL_UANG_BBM + TOTAL_UANG_TOL + TOTAL_UANG_KENDARAAN + UANG_SAKU +UANG_MAKAN AS KASBON,
									CREDIT
								FROM
								(
									SELECT
										ID_SPJ,
										NO_SPJ,
										CASE 
											WHEN MEDIA_UANG_BBM = 'Kasbon' THEN TOTAL_UANG_BBM
											ELSE 0
										END AS TOTAL_UANG_BBM,
										CASE 
											WHEN MEDIA_UANG_TOL = 'Kasbon' THEN TOTAL_UANG_TOL
											ELSE 0
										END AS TOTAL_UANG_TOL,
										CASE 
											WHEN KENDARAAN = 'Gojek/Grab' THEN TOTAL_UANG_KENDARAAN
											ELSE 0
										END AS TOTAL_UANG_KENDARAAN
									FROM
										SPJ_PENGAJUAN
									WHERE
										NO_SPJ = '$noSPJ'
								)Q1
								INNER JOIN
								(
									SELECT
										NO_PENGAJUAN,
										SUM(UANG_SAKU) AS UANG_SAKU,
										SUM(UANG_MAKAN) AS UANG_MAKAN
									FROM
										SPJ_PENGAJUAN_PIC
									GROUP BY
										NO_PENGAJUAN
								)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
								LEFT JOIN
								(
									SELECT
										FK_ID,
										CREDIT
									FROM
										SPJ_KAS_SUB
									WHERE
										JENIS_FK = 'KASBON' AND
										JENIS_KASBON ='Kasbon SPJ Non Delivery' AND
										DETAIL_KASBON = 'TRANSAKSI AWAL'
								)Q3 ON Q1.ID_SPJ = Q3.FK_ID");
		return $sql;
	}
	
}
?>
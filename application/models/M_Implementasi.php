<?php
class M_Implementasi extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getValidasiPIC($noSPJ)
	{
		$sql = "SELECT
					*
				FROM
					SPJ_VALIDASI_PIC
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
		$where = $jenis == 'Out'?' AND SET_OUT IS NOT NULL':' AND SET_IN IS NOT NULL';
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
					KETERANGAN_KENDARAAN_IN
				FROM
					[dbo].[SPJ_VALIDASI]
				WHERE
					NO_SPJ = '$noSPJ'";
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
					SUM(BIAYA) AS UANG_MAKAN_1,
					SUM(UANG_MAKAN) AS UANG_MAKAN_2,
					SUM(UANG_SAKU1) AS UANG_SAKU1,
					SUM(UANG_SAKU2) AS UANG_SAKU2,
					CASE 
						WHEN SUM(UANG_MAKAN) >0 THEN 'Mendapatkan Uang Makan Ke-2'
						ELSE 'Tidak Mendapatkan Uang makan Ke-2'
					END AS KETERANGAN_UANG_MAKAN_2
				FROM
				(
					SELECT
						NO_SPJ,
						GROUP_TUJUAN_ID,
						JENIS_ID,
						CASE 
							WHEN GROUP_TUJUAN_ID = 4 THEN 'LOKAL'
							ELSE 'Luar Kota'
						END AS JENIS_UM
					FROM
						SPJ_PENGAJUAN_PIC a
						INNER JOIN 
						SPJ_PENGAJUAN b ON
					a.NO_PENGAJUAN = b.NO_SPJ	
					WHERE
						NO_PENGAJUAN = '$noSPJ'
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
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ";
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
        $statusUS1 = $value[0] == 'OK' ? 'CLOSE' : 'OPEN';
        $statusUS2 = $value[2] == 'OK' ? 'CLOSE' : 'OPEN';
        $statusUM = $value[4] == 'OK' ? 'CLOSE' : 'OPEN';
        $sql = $this->db->query("UPDATE SPJ_BIAYA_TAMBAHAN SET 
        							STATUS_US1 = '$statusUS1', 
        							STATUS_US2 = '$statusUS2', 
        							STATUS_MAKAN = '$statusUM', 
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
					UANG_SAKU1*JML_PIC AS US1_TAMBAHAN,
					UANG_SAKU2*JML_PIC AS US2_TAMBAHAN,
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
					TOTAL_UANG_SAKU + (UANG_SAKU1*JML_PIC) + (UANG_SAKU2*JML_PIC) AS REALISASI_UANG_SAKU,
					CASE 
						WHEN ADJUSTMENT_MANAJEMEN = 'Y' THEN (UANG_MAKAN*JML_PIC) + UM_DIAJUKAN
						ELSE TOTAL_UANG_MAKAN + (UANG_MAKAN*JML_PIC)
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
					END AS PIC_BBM
				FROM
				(
					SELECT
						NO_SPJ,
						TOTAL_UANG_JALAN,
						TOTAL_UANG_BBM,
						TOTAL_UANG_TOL,
						MEDIA_UANG_SAKU,
						MEDIA_UANG_MAKAN,
						MEDIA_UANG_JALAN,
						MEDIA_UANG_BBM,
						MEDIA_UANG_TOL,
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
						UANG_SAKU1,
						UANG_SAKU2,
						UANG_MAKAN
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
				)Q7 ON Q1.VOUCHER_BBM = Q7.NO_VOUCHER";
		return $this->db->query($sql);
	}
	public function saveCloseSPJ($noSPJ, $saku, $makan, $jalan, $bbm, $tol)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $cekVoucher = $this->db->query("SELECT ID_SPJ FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ' AND MEDIA_UANG_BBM = 'Voucher' AND TOTAL_UANG_BBM <=0");
        if ($cekVoucher->num_rows()>0) {
        	$status = 'OPEN';
        } else {
        	$status = 'CLOSE';
        }
        
		$sql = "UPDATE SPJ_PENGAJUAN SET STATUS_SPJ = '$status',PIC_CLOSE= '$user', TGL_CLOSE = '$tanggal', TOTAL_UANG_SAKU=$saku, TOTAL_UANG_MAKAN=$makan, TOTAL_UANG_JALAN = $jalan, TOTAL_UANG_BBM = $bbm, TOTAL_UANG_TOL=$tol  WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getSPJForGenerate($jenis)
	{
		$sql = "SELECT
					TGL_INPUT,
					Q1.NO_SPJ,
					TGL_SPJ,
					QR_CODE,
					TOTAL_UANG_JALAN + TOTAL_UANG_BBM + TOTAL_UANG_TOL+Q2.UANG_SAKU + Q2.UANG_MAKAN + (JML_PIC * (UANG_SAKU1+UANG_SAKU2+Q3.UANG_MAKAN)) AS TOTAL_RP
				FROM
				(
					SELECT
						TGL_INPUT,
						NO_SPJ,
						TGL_SPJ,
						QR_CODE,
						SUM(TOTAL_UANG_JALAN) AS TOTAL_UANG_JALAN,
						SUM(TOTAL_UANG_BBM) AS TOTAL_UANG_BBM,
						SUM(TOTAL_UANG_TOL) AS TOTAL_UANG_TOL
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_SPJ = 'CLOSE' AND
						NO_GENERATE IS NULL AND
						JENIS_ID = $jenis
					GROUP BY TGL_INPUT, NO_SPJ, TGL_SPJ, QR_CODE
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						COUNT(NO_PENGAJUAN) AS JML_PIC,
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
						NO_SPJ,
						UANG_SAKU1,
						UANG_SAKU2,
						UANG_MAKAN
					FROM
						SPJ_BIAYA_TAMBAHAN
				)Q3 ON Q1.NO_SPJ = Q3.NO_SPJ
				ORDER BY TGL_INPUT ASC";
		return $this->db->query($sql);
	}
	public function getTotalSPJ()
	{
		$sql = "SELECT
					JUMLAH_SPJ,
					TOTAL_RP
				FROM
				(
					SELECT
						COUNT(ID_SPJ) AS JUMLAH_SPJ,
						'-' AS LINK
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						STATUS_SPJ = 'CLOSE' AND
						NO_GENERATE IS NULL
				)Q1
				FULL JOIN
				(
					SELECT
						SUM(TOTAL_UANG_SAKU+TOTAL_UANG_MAKAN+TOTAL_UANG_JALAN+TOTAL_UANG_BBM + TOTAL_UANG_TOL) AS TOTAL_RP,
						'-' AS LINK
					FROM
						SPJ_PENGAJUAN
					WHERE
						STATUS_DATA = 'SAVED' AND
						STATUS_SPJ = 'CLOSE' AND
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
	public function saveGenerateSPJ($inputNoGenerate, $inputJumlahSPJ, $inputTotalRP, $filJenis)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $tanggal2 = date("Y-m-d");
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_GENERATE VALUES('$inputNoGenerate','$tanggal2',$inputJumlahSPJ, $inputTotalRP,null,null, '$user',$filJenis,'$tanggal')";
		return $this->db->query($sql);
	}
	public function getBiayaTotalPerNoSPJ($noSPJ)
	{
		$sql = "SELECT
					UANG_SAKU + UANG_MAKAN + UANG_JALAN + SPJ_UANG_BBM + SPJ_TOL+(JML_PIC * (UANG_SAKU1 + UANG_SAKU2+UM_TAMBAHAN)) AS KASBON_SPJ,
					VOUCHER_UANG_BBM AS KASBON_BBM,
					REIMBURSE_TOL AS KASBON_TOL
				FROM
				(
					SELECT
						a.NO_SPJ,
						MEDIA_UANG_BBM,
						MEDIA_UANG_TOL,
						SUM(UANG_SAKU) AS UANG_SAKU,
						SUM(UANG_MAKAN) AS UANG_MAKAN,
						SUM(TOTAL_UANG_JALAN) AS UANG_JALAN,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' THEN SUM(TOTAL_UANG_BBM)
							ELSE 0
						END AS VOUCHER_UANG_BBM,
						CASE 
							WHEN MEDIA_UANG_BBM = 'Voucher' THEN 0
							ELSE SUM(TOTAL_UANG_BBM)
						END AS SPJ_UANG_BBM,
						CASE MEDIA_UANG_TOL
							WHEN 'Reimburse' THEN SUM(TOTAL_UANG_TOL)
							ELSE 0
						END AS REIMBURSE_TOL,
						CASE MEDIA_UANG_TOL
							WHEN 'Reimburse' THEN 0
							ELSE SUM(TOTAL_UANG_TOL)
						END AS SPJ_TOL,
						COUNT(NO_PENGAJUAN) AS JML_PIC
					FROM
						SPJ_PENGAJUAN a
					LEFT JOIN
						SPJ_PENGAJUAN_PIC b
					ON a.NO_SPJ = b.NO_PENGAJUAN
					WHERE
						a.NO_SPJ = '$noSPJ'
					GROUP BY a.NO_SPJ, MEDIA_UANG_BBM, MEDIA_UANG_TOL
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						UANG_SAKU1,
						UANG_SAKU2,
						UANG_MAKAN AS UM_TAMBAHAN
					FROM
						SPJ_BIAYA_TAMBAHAN
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ";
		return $this->db->query($sql);
	}
	public function generatePengajuanKas($inputNoGenerate, $kasbonSPJ, $kasbonBBM, $kasbonTOL, $jenisID)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO)VALUES('$user','$tanggal','Generate',$kasbonSPJ, 'Kasbon SPJ','Kas Induk','$inputNoGenerate',$jenisID,'OPEN')");
		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO)VALUES('$user','$tanggal','Generate',$kasbonBBM, 'Kasbon BBM','Kas Induk','$inputNoGenerate',$jenisID,'OPEN')");
		$sql = $this->db->query("INSERT INTO SPJ_PENGAJUAN_SALDO(PIC_PENGAJU, TGL_PENGAJU, TRANSAKSI, JUMLAH, JENIS_KASBON, TYPE, DETAIL_TRANSAKSI, JENIS_ID, STATUS_PENGAJUAN_SALDO)VALUES('$user','$tanggal','Generate',$kasbonTOL, 'Kasbon TOL','Kas Induk','$inputNoGenerate',$jenisID,'OPEN')");
		return $sql;
	}
}
?>
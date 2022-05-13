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
        $sql = $this->db->query("UPDATE SPJ_VALIDASI SET KENDARAAN = '$verifKendaraan', KETERANGAN_KENDARAAN = '$ketKendaraan', KEPULANGAN = '$tanggal', PIC_IN ='$user', KM_IN = '$km'");
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
					REALISASI_UANG_TOL
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
        $user = $this->session->userdata("NIK");
        $statusUS1 = $uangSaku1 >0 ?'OUTSTANDING':'CLOSE';
        $statusUS2 = $uangSaku2 >0 ?'OUTSTANDING':'CLOSE';
        $statusMakan = $uangMakan >0 ?'OUTSTANDING':'CLOSE';
		$getData = $this->db->query("SELECT ID FROM SPJ_BIAYA_TAMBAHAN WHERE NO_SPJ = '$inputNoSPJ'");
		if ($getData->num_rows()==0) {
			$sql = "INSERT INTO SPJ_BIAYA_TAMBAHAN VALUES('$inputNoSPJ','$uangSaku1','$uangSaku2','$uangMakan','$statusUS1','$statusUS2','$statusMakan','$user','$user','$user','$tanggal','$tanggal','$tanggal')";
		} else {
			$sql = "UPDATE SPJ_BIAYA_TAMBAHAN SET UANG_SAKU1 = '$uangSaku1', UANG_SAKU2='$uangSaku2', UANG_MAKAN = '$uangMakan', STATUS_US1='$statusUS1', STATUS_US2='$statusUS2', STATUS_MAKAN = '$statusMakan', PIC_US1='$user', PIC_US2='$user', PIC_MAKAN='$user', TGL_US1='$tanggal', TGL_US2 = '$tanggal', TGL_MAKAN='$tanggal'";
		}
		return $this->db->query($sql);
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
		if ($jenis=='KEPUTUSAN') {
			$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET KEPUTUSAN = '$inputKeputusanUangMakan', KETERANGAN = '$inputUangMakanKeterangan', STATUS='CLOSE' WHERE OBJEK = 'UANG MAKAN' AND NO_SPJ = '$inputNoSPJ'");
			$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET KEPUTUSAN = '$inputKeputusanUangJalan', KETERANGAN = '$inputUangJalanKeterangan', STATUS='CLOSE' WHERE OBJEK = 'UANG JALAN' AND NO_SPJ = '$inputNoSPJ'");
			$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET KEPUTUSAN = '$inputKeputusanBBM', KETERANGAN = '$inputBBMKeterangan', STATUS='CLOSE' WHERE OBJEK = 'BBM' AND NO_SPJ = '$inputNoSPJ'");
		} else {
			if ($cek->num_rows()==0) {
				if ($jenis == 'ALL') {
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, KEPUTUSAN, KETERANGAN, STATUS)VALUES('$inputNoSPJ','UANG MAKAN','$inputUangMakanDiajukan','$inputUangMakanAlasan','$inputKeputusanUangMakan','$inputUangMakanKeterangan','CLOSE')");
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, KEPUTUSAN, KETERANGAN, STATUS)VALUES('$inputNoSPJ','UANG JALAN','$inputUangJalanDiajukan','$inputUangJalanAlasan','$inputKeputusanUangJalan','$inputUangJalanKeterangan','CLOSE')");
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, KEPUTUSAN, KETERANGAN, STATUS)VALUES('$inputNoSPJ','BBM','$inputBBMDiajukan','$inputBBMAlasan','$inputKeputusanBBM','$inputBBMKeterangan','CLOSE')");
				} else {
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','UANG MAKAN','$inputUangMakanDiajukan','$inputUangMakanAlasan','OPEN')");
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','UANG JALAN','$inputUangJalanDiajukan','$inputUangJalanAlasan','OPEN')");
					$sql = $this->db->query("INSERT INTO SPJ_ADJUSTMENT(NO_SPJ, OBJEK, DIAJUKAN, ALASAN, STATUS)VALUES('$inputNoSPJ','BBM','$inputBBMDiajukan','$inputBBMAlasan','OPEN')");	
				}
			} else {
				if ($jenis == 'ALL') {
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangMakanDiajukan', ALASAN = '$inputUangMakanAlasan', KEPUTUSAN = '$inputKeputusanUangMakan', KETERANGAN = '$inputUangMakanKeterangan', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG MAKAN'");
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangJalanDiajukan', ALASAN = '$inputUangJalanAlasan', KEPUTUSAN = '$inputKeputusanUangJalan', KETERANGAN = '$inputUangJalanKeterangan', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG JALAN'");
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputBBMDiajukan', ALASAN = '$inputBBMAlasan', KEPUTUSAN = '$inputKeputusanBBM', KETERANGAN = '$inputBBMKeterangan', STATUS = 'CLOSE' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'BBM'");
				} else {
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangMakanDiajukan', ALASAN = '$inputUangMakanAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG MAKAN'");
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputUangJalanDiajukan', ALASAN = '$inputUangJalanAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'UANG JALAN'");
					$sql = $this->db->query("UPDATE SPJ_ADJUSTMENT SET DIAJUKAN = '$inputBBMDiajukan', ALASAN = '$inputBBMAlasan', STATUS='OPEN' WHERE NO_SPJ = '$inputNoSPJ' AND OBJEK = 'BBM'");	
				}
			}
		}

		$this->db->query($tambahan);
		if ($jenis == 'ALL' || $jenis=='KEPUTUSAN') {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_MAKAN = '$inputUangMakanDiajukan', TOTAL_UANG_JALAN='$inputUangJalanDiajukan', TOTAL_UANG_BBM = '$inputBBMDiajukan' WHERE NO_SPJ = '$inputNoSPJ'");
			$getKasbonSPJ= $this->db->query("SELECT CREDIT FROM SPJ_KASBON WHERE NO_SPJ = '$inputNoSPJ' AND JENIS_KASBON = 'SPJ'");
			if ($getKasbonSPJ->num_rows()>0) {
				foreach ($getKasbonSPJ->result() as $key) {
					$creditSPJ = $key->CREDIT;
				}
				$totalCreditSPJ = $creditSPJ + $inputUangMakanDiajukan + $inputUangJalanDiajukan + $inputBBMDiajukan;
				$this->db->query("UPDATE SPJ_KASBON SET CREDIT = '$totalCreditSPJ' WHERE NO_SPJ = '$inputNoSPJ' AND JENIS_KASBON = 'SPJ'");
			}

		}
		
		return $sql;
	}

}
?>
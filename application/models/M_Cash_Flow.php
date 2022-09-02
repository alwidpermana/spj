<?php
class M_Cash_Flow extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function kodeApprove($jenis, $inputKodeApprove)
	{
		$sql = "SELECT
					* 
				FROM
					SPJ_KODE_APPROVE
				WHERE
					JENIS = '$jenis' AND
					KODE = '$inputKodeApprove'";
		return $this->db->query($sql);
	}
	public function saveBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputIDPengajuan)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");

		$sql = "INSERT INTO SPJ_KAS(TGL_INPUT, PIC_INPUT, TRANSAKSI, $fieldTujuan, $fieldBiaya, PENGAJUAN_SALDO_ID) VALUES('$tanggal', '$user', '$inputTransaksi', '$inputTujuan', $inputBiaya, $inputIDPengajuan)";
		return $this->db->query($sql);
	}
	public function getAllSaldo($jenis)
	{
		$sql = "SELECT
					Q1.*,
					RP AS RP_OUTSTANDING
				FROM
				(
					SELECT
						ID,
						JENIS_SALDO,
						REPLACE(JENIS_SALDO, 'Kasbon ', '') AS NAMA_SALDO,
						JUMLAH,
						JENIS_KAS
					FROM
						SPJ_SALDO
					WHERE
						ID != 1 AND
						JENIS_KAS LIKE '$jenis'
				)Q1
				LEFT JOIN
				(
					SELECT
						CASE 
							WHEN JENIS_KASBON = 'Kasbon BBM' THEN 'Voucher BBM'
							WHEN JENIS_KASBON = 'Kasbon TOL' THEN 'TOL '+NAMA_JENIS
							WHEN JENIS_KASBON = 'Kasbon TOL (Biaya Admin)' THEN 'TOL '+NAMA_JENIS
							ELSE 'SPJ '+NAMA_JENIS
						END AS JENIS_KASBON,
						'SUB KAS' AS JENIS_KAS,
						SUM(JUMLAH) AS RP
					FROM
						SPJ_PENGAJUAN_SALDO a
					LEFT JOIN
						SPJ_JENIS b
					ON a.JENIS_ID = b.ID_JENIS
					WHERE
						STATUS_APPROVE = 'APPROVED' AND
						STATUS_RECEIVE IS NULL
					GROUP BY
						JENIS_KASBON, NAMA_JENIS
				)Q2 ON Q1.NAMA_SALDO = Q2.JENIS_KASBON AND Q1.JENIS_KAS = Q2.JENIS_KAS
				ORDER BY ID ASC";
		return $this->db->query($sql);
	}
	public function getSaldoPerJenis($jenis, $kas)
	{
		$sql = "SELECT
					SUM(JUMLAH) AS SALDO
				FROM
					[dbo].[SPJ_SALDO]
				WHERE
					JENIS_SALDO = '$jenis' AND 
					JENIS_KAS = '$kas'";
		return $this->db->query($sql);
	}
	public function updateSaldo($jenis, $biaya, $kas)
	{
		$sql = "UPDATE SPJ_SALDO SET JUMLAH = $biaya WHERE JENIS_SALDO = '$jenis' AND JENIS_KAS = '$kas'";
		if ($jenis != 'Modal Awal') {
			$this->rekapSaldo($jenis, $biaya, $kas);
		}
		$this->saveLogSaldo($jenis, $biaya, $kas);
		return $this->db->query($sql);
	}
	public function getAllSaldoKasInduk()
	{
		
	}
	public function getDataBukuKasInternal($filBulan, $filTahun, $bulan)
	{
		$sql = "Execute SPJ_monitoringBukuKasInternal $filBulan, $filTahun, '$bulan%'";
		return $this->db->query($sql);
	}
	public function getTabelPengajuanKasInternal($bulan, $tahun)
	{
		$sql = "SELECT
					ID,
					TGL_INPUT,
					PIC_INPUT,
					TRANSAKSI,
					CASE 
						WHEN TRANSAKSI = 'Modal Awal' THEN DARI
						ELSE KE
					END AS DARI_KE,
					CASE 
						WHEN TRANSAKSI = 'Modal Awal' THEN DEBIT
						ELSE CREDIT
					END AS RP,
					DEBIT,CREDIT,
					DARI, KE,
					PIC_APPROVE,
					TGL_APPROVE,
					STATUS_APPROVE,
					b.namapeg AS NAMA_INPUT,
					c.namapeg AS NAMA_APPROVE
				FROM
					[dbo].[SPJ_KAS] a
				LEFT JOIN
					dbhrm.dbo.tbPegawai b ON
				a.PIC_INPUT = b.nik
				LEFT JOIN
					dbhrm.dbo.tbPegawai c ON
				a.PIC_APPROVE = c.nik
				WHERE
					STATUS_APPROVE IS NULL AND
					YEAR(TGL_INPUT) = '$tahun' AND
					DATENAME(m, TGL_INPUT) LIKE '$bulan%'
				ORDER BY
					TGL_INPUT DESC, TGL_APPROVE ASC";
		return $this->db->query($sql);
	}
	public function approvePengajuanKasInternal($id)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "UPDATE SPJ_KAS SET PIC_APPROVE = '$user', STATUS_APPROVE = 'APPROVED', TGL_APPROVE = '$tanggal' WHERE ID = $id";
		return $this->db->query($sql);
	}
	public function getDataModalAwal($bulan, $tahun)
	{
		$sql = "SELECT
					TGL_INPUT,
					TRANSAKSI,
					DEBIT
				FROM
					SPJ_KAS
				WHERE
					TRANSAKSI = 'Modal Awal'
				ORDER BY TGL_INPUT ASC";
		return $this->db->query($sql);
	}
	public function savePengajuanSaldo($inputJenisKasbon, $inputJenisSPJ, $inputBiaya)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_PENGAJUAN_SALDO(JENIS_KASBON, JENIS_ID, JUMLAH, TRANSAKSI, TYPE, TGL_PENGAJU, PIC_PENGAJU, STATUS_PENGAJUAN_SALDO)VALUES('$inputJenisKasbon', '$inputJenisSPJ','$inputBiaya','Pinbuk','Sub Kas','$tanggal','$user','OPEN')";
		return $this->db->query($sql);
	}
	public function updatePengajuanSaldo($inputJenisKasbon, $inputJenisSPJ, $inputBiaya, $inputID)
	{
		$sql = "UPDATE SPJ_PENGAJUAN_SALDO SET JENIS_KASBON = '$inputJenisKasbon', JENIS_ID = '$inputJenisSPJ', JUMLAH = '$inputBiaya' WHERE ID = $inputID";
		return $this->db->query($sql);
	}
	public function cancelPengajuan($id)
	{
		$sql = "UPDATE SPJ_PENGAJUAN_SALDO SET STATUS_PENGAJUAN_SALDO = 'CANCEL' WHERE ID = $id";
		return $this->db->query($sql);
	}
	public function updateBukuKas($inputTransaksi, $inputTujuan, $inputBiaya, $fieldTujuan, $fieldBiaya, $inputID)
	{
		$sql = "UPDATE SPJ_KAS SET $fieldTujuan = '$inputTujuan', $fieldBiaya = $inputBiaya WHERE ID = $inputID";
		return $this->db->query($sql);
	}
	public function hapusKas($id)
	{
		$sql = "DELETE FROM SPJ_KAS WHERE ID=$id";
		return $this->db->query($sql);
	}
	public function saveKasInduk($jenisKasbon, $fieldBiaya, $biaya, $jenisFK, $fkID)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
		$sql = "INSERT INTO SPJ_KAS_INDUK(JENIS_KASBON, $fieldBiaya, TGL_INPUT, JENIS_FK, FK_ID)VALUES('$jenisKasbon',$biaya, '$tanggal','$jenisFK',$fkID)";
		return $this->db->query($sql);
	}
	public function updateKasInduk($jenisKasbon, $fieldBiaya, $biaya, $jenisFK, $fkID)
	{
        $sql = "UPDATE SPJ_KAS_INDUK SET JENIS_KASBON = '$jenisKasbon', $fieldBiaya = $biaya WHERE JENIS_FK = '$jenisFK' AND FK_ID = $fkID";
        return $this->db->query($sql);
	}
	public function hapusKasInduk($jenisFK, $fkID)
	{
		$sql = "DELETE FROM SPJ_KAS_INDUK WHERE JENIS_FK = '$jenisFK' AND FK_ID = $fkID";
		return $this->db->query($sql);
	}
	public function getPengajuanSaldoByJenisSPJ($jenis, $status, $jenisId)
	{
		$sql = "SELECT
					ID,
					TGL_PENGAJU,
					TRANSAKSI AS DEFAULT_TRANSAKSI,
					CASE 
						WHEN TRANSAKSI = 'Generate' THEN TRANSAKSI+' No. '+DETAIL_TRANSAKSI
						ELSE TRANSAKSI
					END AS TRANSAKSI,
					JENIS_KASBON,
					JENIS_ID,
					NAMA_JENIS,
					DETAIL_TRANSAKSI,
					CASE 
						WHEN JENIS_KASBON = 'Kasbon BBM' THEN JENIS_KASBON
						ELSE JENIS_KASBON+' '+NAMA_JENIS
					END VAL_KASBON,
					PIC_PENGAJU,
					b.namapeg AS NAMA_PENGAJU,
					b.departemen AS DEPARTEMEN_PENGAJU,
					TYPE,
					JUMLAH,
					STATUS_APPROVE,
					PIC_APPROVE,
					c.namapeg AS NAMA_APPROVE,
					TGL_APPROVE,
					PIC_RECEIVE,
					d.namapeg AS NAMA_RECEIVE,
					TGL_RECEIVE,
					STATUS_RECEIVE,
					STATUS_PENGAJUAN_SALDO
				FROM
					SPJ_PENGAJUAN_SALDO a
				LEFT JOIN
					dbhrm.dbo.tbPegawai b ON
				a.PIC_PENGAJU = b.nik 
				LEFT JOIN
					dbhrm.dbo.tbPegawai c ON
				a.PIC_APPROVE= c.nik	
				LEFT JOIN
					dbhrm.dbo.tbPegawai d ON
				a.PIC_RECEIVE = d.nik
				LEFT JOIN
					SPJ_JENIS e ON
				a.JENIS_ID = e.ID_JENIS
				WHERE 
					a.JENIS_KASBON LIKE '$jenis%'
					AND STATUS_PENGAJUAN_SALDO LIKE '$status%' AND
					a.JENIS_ID LIKE '$jenisId%'
				ORDER BY TGL_PENGAJU DESC";
		return $this->db->query($sql);
	}
	public function approvePengajuan($id, $status, $password)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $statusPengajuan = $status == 'APPROVED'?'OPEN':'REJECTED';
		$sql = "UPDATE SPJ_PENGAJUAN_SALDO SET PIC_APPROVE = '$user', TGL_APPROVE = '$tanggal', STATUS_APPROVE='$status', STATUS_PENGAJUAN_SALDO = '$statusPengajuan', PASSWORD_RECEIVE='$password' WHERE ID=$id";
		return $this->db->query($sql);
	}
	public function receivePengajuan($id)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "UPDATE SPJ_PENGAJUAN_SALDO SET PIC_RECEIVE = '$user', TGL_RECEIVE = '$tanggal', STATUS_RECEIVE = 'RECEIVED', STATUS_PENGAJUAN_SALDO='CLOSE' WHERE ID = $id";
        return $this->db->query($sql);
	}
	public function saveSubKas($kasbon,$field, $jumlah, $jenis, $id, $detail)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $getData = $this->db->query("SELECT ID FROM SPJ_KAS_SUB WHERE JENIS_KASBON = '$kasbon' AND JENIS_FK='$jenis' AND FK_ID = $id AND DETAIL_KASBON = '$detail'");
        if ($getData->num_rows()==0) {
        	$sql = "INSERT INTO SPJ_KAS_SUB(JENIS_KASBON, $field, TGL_INPUT, JENIS_FK, FK_ID, DETAIL_KASBON)VALUES('$kasbon',$jumlah,'$tanggal','$jenis',$id,'$detail')";
        } else {
        	$sql = "UPDATE SPJ_KAS_SUB SET $field = $jumlah WHERE JENIS_KASBON = '$kasbon' AND JENIS_FK='$jenis' AND FK_ID = $id AND DETAIL_KASBON = '$detail'";
        }
        
		
		return $this->db->query($sql);
	}
	public function getDataRekapSaldo($field1)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
		$sql = "SELECT
					SUM($field1) AS KAS_REKAP
				FROM
					SPJ_REKAP_SALDO
				WHERE
					TGL_REKAP = '$tanggal'";
		return $this->db->query($sql);
	}
	public function updateRekapSaldo($field, $saldo, $fieldDebit, $debit, $jenis, $field2, $tipe)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $getData = $this->db->query("SELECT ID FROM SPJ_REKAP_SALDO WHERE TGL_REKAP = '$tanggal'");
        if ($getData->num_rows()==0) {
        	$sql = "INSERT INTO SPJ_REKAP_SALDO(TGL_REKAP, $field, $fieldDebit)VALUES('$tanggal','$saldo','$debit')";
        } else {
        	$sql = "UPDATE SPJ_REKAP_SALDO SET $field = $saldo, $fieldDebit = $debit WHERE TGL_REKAP = '$tanggal'";
        }
        $this->db->query($sql);
        $jenis2 = $jenis =='KAS INDUK'?'SUB KAS':'KAS INDUK';
        $getSaldo = $this->getSaldoPerJenis($tipe, $jenis2);
    	if ($getSaldo->num_rows()==0) {
    		$saldoBeda = 0;
    	} else {
    		foreach ($getSaldo->result() as $key) {
	    		$saldoBeda =$key->SALDO; 
	    	}
    	}
    	
    	$this->db->query("UPDATE SPJ_REKAP_SALDO SET $field2 = $saldoBeda WHERE TGL_REKAP = '$tanggal'");
        
	}
	public function rekapSaldo($tujuan, $saldo, $jenis)
	{
		if ($tujuan == 'Kasbon SPJ Delivery' && $jenis == 'KAS INDUK') {
			$field = 'KAS_INDUK_SPJ_DLV';
			$fieldDebit = 'DA_SPJ_DLV';
			$field2 = 'SUB_KAS_SPJ_DLV';
		}elseif ($tujuan == 'Kasbon SPJ Non Delivery' && $jenis == 'KAS INDUK') {
			$field = 'KAS_INDUK_SPJ_NDV';
			$fieldDebit = 'DA_SPJ_NDV';
			$field2 = 'SUB_KAS_SPJ_NDV';
		}elseif ($tujuan == 'Kasbon TOL Delivery' && $jenis == 'KAS INDUK') {
			$field = 'KAS_INDUK_TOL_DLV';
			$fieldDebit = 'DA_TOL_DLV';
			$field2 = 'SUB_KAS_TOL_DLV';
		}elseif ($tujuan == 'Kasbon TOL Non Delivery' && $jenis == 'KAS INDUK') {
			$field = 'KAS_INDUK_TOL_NDV';
			$fieldDebit = 'DA_TOL_NDV';
			$field2 = 'SUB_KAS_TOL_NDV';
		}elseif ($tujuan == 'Kasbon Voucher BBM' && $jenis == 'KAS INDUK') {
			$field = 'KAS_INDUK_BBM';
			$fieldDebit = 'DA_BBM';
			$field2 = 'SUB_KAS_BBM';
		}elseif ($tujuan == 'Kasbon SPJ Delivery' && $jenis == 'SUB KAS') {
			$field = 'SUB_KAS_SPJ_DLV';
			$fieldDebit = 'DA_SPJ_DLV';
			$field2 = 'KAS_INDUK_SPJ_DLV';
		}elseif ($tujuan == 'Kasbon SPJ Non Delivery' && $jenis == 'SUB KAS') {
			$field = 'SUB_KAS_SPJ_NDV';
			$fieldDebit = 'DA_SPJ_NDV';
			$field2 = 'KAS_INDUK_SPJ_NDV';
		}elseif ($tujuan == 'Kasbon TOL Delivery' && $jenis == 'SUB KAS') {
			$field = 'SUB_KAS_TOL_DLV';
			$fieldDebit = 'DA_TOL_DLV';
			$field2 = 'KAS_INDUK_TOL_DLV';
		}elseif ($tujuan == 'Kasbon TOL Non Delivery' && $jenis == 'SUB KAS') {
			$field = 'SUB_KAS_TOL_NDV';
			$fieldDebit = 'DA_TOL_NDV';
			$field2 = 'KAS_INDUK_TOL_NDV';
		}elseif ($tujuan == 'Kasbon Voucher BBM' && $jenis == 'SUB KAS') {
			$field = 'SUB_KAS_BBM';
			$fieldDebit = 'DA_BBM';
			$field2 = 'KAS_INDUK_BBM';
		}else{
			$field = 'KAS_INDUK_TOTAL';
			$fieldDebit = 'SUB_KAS_TOTAL';
			$field2 = 'KAS_INDUK_TOTAL';
		}
		$debit = 0;
		$getDebitAwal = $this->db->query("SELECT
												SUM(CREDIT) AS DEBIT_AWAL
											FROM
												SPJ_KAS
											WHERE
												KE = '$tujuan'");
		foreach ($getDebitAwal->result() as $key) {
			$debit = $key->DEBIT_AWAL == null ? 0 : $key->DEBIT_AWAL;
		}
		$this->updateRekapSaldo($field, $saldo, $fieldDebit, $debit, $jenis, $field2, $tujuan);
	}
	public function getDataMonitoringRekapSaldo($bulan, $tahun)
	{
		$sql = "SELECT
					ID,
					TGL_REKAP,
					KAS_INDUK_SPJ_DLV,
					SUB_KAS_SPJ_DLV,
					KAS_INDUK_SPJ_DLV + SUB_KAS_SPJ_DLV AS TOTAL_SPJ_DLV,
					DA_SPJ_DLV - (KAS_INDUK_SPJ_DLV + SUB_KAS_SPJ_DLV) AS OS_SPJ_DLV,
					KAS_INDUK_SPJ_NDV,
					SUB_KAS_SPJ_NDV,
					KAS_INDUK_SPJ_NDV + SUB_KAS_SPJ_NDV AS TOTAL_SPJ_NDV,
					DA_SPJ_NDV - (KAS_INDUK_SPJ_NDV + SUB_KAS_SPJ_NDV) AS OS_SPJ_NDV,
					KAS_INDUK_TOL_DLV,
					SUB_KAS_TOL_DLV,
					KAS_INDUK_TOL_DLV + SUB_KAS_TOL_DLV AS TOTAL_TOL_DLV,
					DA_TOL_DLV - (KAS_INDUK_TOL_DLV + SUB_KAS_TOL_DLV) AS OS_TOL_DLV,
					KAS_INDUK_TOL_NDV,
					SUB_KAS_TOL_NDV,
					KAS_INDUK_TOL_NDV + SUB_KAS_TOL_NDV AS TOTAL_TOL_NDV,
					DA_TOL_NDV - (KAS_INDUK_TOL_NDV + SUB_KAS_TOL_NDV) AS OS_TOL_NDV,
					KAS_INDUK_BBM,
					SUB_KAS_BBM,
					KAS_INDUK_BBM + SUB_KAS_BBM AS TOTAL_BBM,
					DA_BBM - (KAS_INDUK_BBM + SUB_KAS_BBM) AS OS_BBM
				FROM
					SPJ_REKAP_SALDO
				WHERE
					DATENAME(MONTH,TGL_REKAP) LIKE '$bulan%' AND
					YEAR(TGL_REKAP) = '$tahun'";
		return $this->db->query($sql);
	}
	public function saveLogSaldo($jenis, $biaya, $kas)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$this->db->query("INSERT INTO SPJ_SALDO_LOG(TGL_INPUT, PIC_INPUT, JENIS_SALDO, JENIS_KAS, JUMLAH)VALUES('$tanggal','$user','$jenis', '$kas', $biaya)");
	}
	public function approveGenerate($id, $jenis, $jumlah)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_KAS_INDUK(JENIS_KASBON,DEBIT,CREDIT,TGL_INPUT,JENIS_FK,FK_ID)VALUES('$jenis',$jumlah, $jumlah, '$tanggal','PENGAJUAN SALDO',$id)";
		$this->db->query("UPDATE SPJ_PENGAJUAN_SALDO SET PIC_APPROVE = '$user', TGL_APPROVE = '$tanggal', STATUS_APPROVE = 'APPROVED' WHERE ID=$id");
		return $this->db->query($sql);
	}
	public function outstandingSaldoReceive()
	{
		$sql = "SELECT
					CASE 
						WHEN JENIS_KASBON = 'Kasbon BBM' THEN 'Voucher BBM'
						WHEN JENIS_KASBON = 'Kasbon TOL' THEN 'TOL '+NAMA_JENIS
						ELSE 'SPJ '+NAMA_JENIS
					END AS JENIS_KASBON,
					SUM(JUMLAH) AS RP
				FROM
					SPJ_PENGAJUAN_SALDO a
				LEFT JOIN
					SPJ_JENIS b
				ON a.JENIS_ID = b.ID_JENIS
				WHERE
					STATUS_APPROVE = 'APPROVED' AND
					STATUS_RECEIVE IS NULL
				GROUP BY
					JENIS_KASBON, NAMA_JENIS";
		return $this->db->query($sql);;
	}
}
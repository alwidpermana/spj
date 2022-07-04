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

		$sql = "INSERT INTO SPJ_KAS(TGL_INPUT, PIC_INPUT, TRANSAKSI, $fieldTujuan, $fieldBiaya, PENGAJUAN_SALDO_ID, STATUS_APPROVE, PIC_APPROVE, TGL_APPROVE) VALUES('$tanggal', '$user', '$inputTransaksi', '$inputTujuan', $inputBiaya, $inputIDPengajuan, 'APPROVED', 'KODE','$tanggal')";
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
		return $this->db->query($sql);
	}
	public function getAllSaldoKasInduk()
	{
		
	}
	public function getDataBukuKasInternal($filBulan, $filTahun)
	{
		$sql = "Execute SPJ_monitoringBukuKasInternal $filBulan, $filTahun";
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
	public function getPengajuanSaldoByJenisSPJ($jenis, $status)
	{
		$sql = "SELECT
					ID,
					TGL_PENGAJU,
					CASE 
						WHEN TRANSAKSI = 'Generate' THEN JENIS_KASBON+' No. '+DETAIL_TRANSAKSI
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
					a.JENIS_ID LIKE '$jenis%'
					AND STATUS_PENGAJUAN_SALDO LIKE '$status%'
				ORDER BY TGL_PENGAJU DESC";
		return $this->db->query($sql);
	}
	public function approvePengajuan($id, $status)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $statusPengajuan = $status == 'APPROVED'?'OPEN':'REJECTED';
		$sql = "UPDATE SPJ_PENGAJUAN_SALDO SET PIC_APPROVE = '$user', TGL_APPROVE = '$tanggal', STATUS_APPROVE='$status', STATUS_PENGAJUAN_SALDO = '$statusPengajuan' WHERE ID=$id";
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
	public function saveSubKas($kasbon,$field, $jumlah, $jenis, $id)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
		$sql = "INSERT INTO SPJ_KAS_SUB(JENIS_KASBON, $field, TGL_INPUT, JENIS_FK, FK_ID)VALUES('$kasbon',$jumlah,'$tanggal','$jenis',$id)";
		return $this->db->query($sql);
	}
	public function getDataRekapSaldo($field1, $field2)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
		$sql = "SELECT
					SUM($field1) AS KAS_REKAP,
					SUM($field2) AS KAS_TOTAL
				FROM
					SPJ_REKAP_SALDO
				WHERE
					TGL_REKAP = '$tgl'";
		return $this->db->query($sql);
	}
}
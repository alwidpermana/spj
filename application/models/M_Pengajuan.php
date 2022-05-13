<?php
class M_Pengajuan extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getNoSPJ($jenis, $kode)
	{
		$kodeJenis = $jenis == '1'?'DLV':'NDV';
		$tahun = date('Y');
        $bulan = date('m');
		$gabung = "SPJ/".$kodeJenis."/".$kode."/".$tahun."/".$bulan."/";
		$cekNoDoc=$this->db->query("SELECT MAX
											( RIGHT ( NO_SPJ, 4 ) ) AS SETNODOC
										FROM
											SPJ_PENGAJUAN
										WHERE
											NO_SPJ LIKE '$gabung%' 
											AND STATUS_DATA ='SAVED'");
		foreach ($cekNoDoc->result() as $data) {
            if ($data->SETNODOC =="") {
                $URUTZERO = $gabung."0001";

                $hasil= array('nodoc' => $URUTZERO,

                             );
            }else{
                $zero='';
                $length= 4;
                $index=$data->SETNODOC;

                for ($i=0; $i <$length-strlen($index+1) ; $i++) { 
                    $zero = $zero.'0';
                }
                $URUTDOCNO = $gabung.$zero.($index+1);
                
                $hasil=array(
                'nodoc' => $URUTDOCNO,
                
                );    
            }
            
        }
        return $hasil;
	}

	public function saveTemporaryPengajuan($jenis, $no, $namaFile, $inputTglSPJ)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$no' AND STATUS_DATA = 'TEMPORARY'");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$no'");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$no'");
        
        $link = './assets/image/qrcode/'.$namaFile.'.png';
		if(file_exists($link)){
			unlink($link);
		}
		$sql = "INSERT INTO SPJ_PENGAJUAN(TGL_INPUT, PIC_INPUT, STATUS_DATA, JENIS_ID, NO_SPJ, QR_CODE, TGL_SPJ)VALUES('$tanggal','$user','TEMPORARY','$jenis','$no','$namaFile','$inputTglSPJ')";
		return $this->db->query($sql);
	}

	public function getListKendaraan($jenis, $kategori)
	{
		$sqlDelivery = '';
		if ($kategori == 'Delivery') {
			$sqlDelivery = " AND KATEGORI = '$jenis'";
		}
		$sql = "SELECT
					* 
				FROM
				(
					SELECT
						NoTNKB,
						Merk,
						Type,
						NoInventaris
					FROM
						GA.dbo.GA_Tkendaraan
					WHERE
						Jenis = '$kategori' $sqlDelivery
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
						NO_TNKB
					FROM
						SPJ_TEMP_KENDARAAN
				)Q3 ON Q1.NoTNKB = Q3.NO_TNKB
				WHERE
					Q3.NO_TNKB IS NULL";
		return $this->db->query($sql);
	}
	public function findGroupTujuan($nama)
	{
		$sql = $this->db->query("SELECT DISTINCT TOP 1
					ID_GROUP
				FROM
				(
					SELECT
						ID_KOTA,
						ID_GROUP
					FROM
						SPJ_GT_DETAIL
				)Q1
				INNER JOIN
				(
					SELECT
						ID_KOTA,
						NAMA_KOTA
					FROM
						SPJ_KOTA
					WHERE
						NAMA_KOTA = '$nama'
				)Q2 ON Q1.ID_KOTA = Q2.ID_KOTA");
		$group = 0;
		if ($sql->num_rows()>0) {
			foreach ($sql->result() as $key) {
				$group = $key->ID_GROUP;
			}
		}
		return $group;
	}
	public function saveLokasiTujuan($inputGroupTujuan, $inputObjek, $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
		$sql = "INSERT INTO SPJ_PENGAJUAN_LOKASI VALUES($serlokID, '$serlokAlamat','$serlokPerusahaan','$serlokKota','$inputNoSPJ','$inputGroupTujuan','$inputObjek','$tanggal','$user')";
		return $this->db->query($sql);
	}
	public function updateGroupTujuan($no)
	{
		$sql = $this->db->query("SELECT
					MAX(GROUP_ID) AS ID
				FROM
					[dbo].[SPJ_PENGAJUAN_LOKASI]
				WHERE
					NO_SPJ = '$no'");
		foreach ($sql->result() as $key) {
			$id = $key->ID;
		}
		return $id;

	}
	public function getGroupSPJ($no)
	{
		$sql = "SELECT GROUP_ID FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$no'";
		return $this->db->query($sql);
	}
	public function getLokasi($inputGroupTujuan, $inputNoSPJ)
	{
		$sql = "SELECT
					a.*,
					b.NAMA_GROUP
				FROM
					SPJ_PENGAJUAN_LOKASI a 
				INNER JOIN
					SPJ_GROUP_TUJUAN b
				ON a.GROUP_ID = b.ID_GROUP
				WHERE
					NO_SPJ = '$inputNoSPJ' 
				ORDER BY
					ID_LOKASI ASC";
		return $this->db->query($sql);
	}
	public function getPIC($inputSubjek, $jabatan, $where, $noPengajuan, $where2)
	{
		$sql = "SELECT
				   Q1.*
				FROM
				(
					SELECT
						Q1.NIK,
						Q2.namapeg
					FROM
					(
						SELECT
							*
						FROM
							SPJ_PEGAWAI_OTORITAS
						WHERE
							STATUS_DATA = 'SAVED' AND
							SUBJEK = '$inputSubjek' $where
					)Q1
					LEFT JOIN
					(
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						status AS jabatan
					FROM
						TrTs_SopirLogistik 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						status AS jabatan
					FROM
						TrTs_SopirRental 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						nik,
						namapeg,
						jabatan
					FROM
						dbhrm.dbo.tbPegawai 
					WHERE
						status_aktif = 'AKTIF' 
					) Q2 on q1.NIK = q2.nik
					$where2
				)Q1
				LEFT JOIN
				(
					SELECT
						NIK
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NO_PENGAJUAN = '$noPengajuan'
				)Q2 ON Q1.NIK = Q2.NIK
				LEFT JOIN
				(
					SELECT
						PIC
					FROM
						SPJ_TEMP_PIC
				)Q3 ON Q1.NIK = Q3.PIC
				WHERE
					Q2.NIK IS NULL AND
					Q3.PIC IS NULL";
		return $this->db->query($sql);
	}
	public function saveOtomatisUangSPJ($id, $group, $biaya)
	{
		$sql = "UPDATE SPJ_PENGAJUAN_PIC SET GROUP_TUJUAN_ID = $group, UANG_SAKU = $biaya WHERE ID_PIC = $id";
		return $this->db->query($sql);
	}
	public function hitungUangSaku($anjing, $inputSubjek, $inputPIC, $inputGroupTujuan, $inputJenisKendaraan)
	{
		$field = $inputSubjek == 'Rental'?'BIAYA_RENTAL':'BIAYA_INTERNAL';

		if ($inputSubjek == '') {
			$field = 'BIAYA_UNDEFINED';
		}else{
			if ($inputSubjek == 'Rental') {
				$field == 'BIAYA_RENTAL';
			}else{
				$field == 'BIAYA_INTERNAL';
			}
		}

		$queryPIC = $inputPIC == 'Driver' || $inputPIC == 'Sopir'?" JENIS_PIC IN ('Sopir','Driver')":" JENIS_PIC = '$inputPIC'";
		$sql = "SELECT
					$field AS BIAYA
				FROM
					[dbo].[SPJ_UANG_SAKU]
				WHERE
					ID_JENIS_SPJ = '$anjing' AND
					$queryPIC AND
					ID_GROUP = $inputGroupTujuan";
		if ($anjing =='1') {
			$sql .=" AND JENIS_KENDARAAN = '$inputJenisKendaraan'";
		}
		return $this->db->query($sql);
	}
	public function hitungUangMakan($inputJenisSPJ, $jenisTujuan)
	{
		$sql = "SELECT
					BIAYA
				FROM
					[dbo].[SPJ_UANG_MAKAN]
				WHERE
					ID_JENIS_SPJ = $inputJenisSPJ AND
					JENIS_GROUP = '$jenisTujuan' AND
					MAKAN_KE = 1";
		return $this->db->query($sql);
	}
	public function savePIC($inputJenisPIC, $inputSubjek, $inputPIC, $inputUangSaku, $inputUangMakan, $inputSortir, $inputNoSPJ, $inputGroupTujuan, $inputDepartemen, $inputSubDepartemen, $inputJabatan, $inputNamaPIC)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");

        $sql = "INSERT INTO SPJ_PENGAJUAN_PIC VALUES('$tanggal','$user','$inputNoSPJ','$inputSubjek','$inputPIC','$inputUangSaku','$inputUangMakan','$inputSortir','$inputJenisPIC','$inputGroupTujuan', '$inputDepartemen','$inputSubDepartemen','$inputJabatan', '$inputNamaPIC')";
        return $this->db->query($sql);
	}
	public function getPengajuanPIC($group, $noPengajuan)
	{
		$sql = "SELECT
					ID_PIC,
					NO_PENGAJUAN,
					OBJEK,
					NIK,
					NAMA,
					JABATAN,
					DEPARTEMEN,
					SUB_DEPARTEMEN,
					UANG_SAKU,
					UANG_MAKAN,
					SORTIR,
					CASE 
						WHEN JENIS_PIC = 'Sopir' THEN 'Driver'
						ELSE JENIS_PIC
					END AS JENIS_PIC,
				 GROUP_TUJUAN_ID
				FROM
					SPJ_PENGAJUAN_PIC
				WHERE
					NO_PENGAJUAN = '$noPengajuan' AND
					GROUP_TUJUAN_ID = '$group'";
		return $this->db->query($sql);
	}
	public function cekJumlahSupir($noPengajuan, $group, $pic, $jenisK)
	{
		$sql = "SELECT
				JML_DRIVER,
				JML_PIC,
				JML_PENDAMPING,
				CASE 
					WHEN GROUP_ID = 4 THEN QTY_LOKAL
					WHEN GROUP_ID != 4 THEN QTY_LUAR_KOTA
					WHEN GROUP_ID IS NULL THEN 0
					ELSE 100
				END AS SET_PENDAMPING,
				JML_MARKETING
			FROM
			(
				SELECT
					NO_SPJ,
					JENIS_KENDARAAN,
					JENIS_ID,
					GROUP_ID
				FROM
					SPJ_PENGAJUAN
				WHERE
					NO_SPJ = '$noPengajuan' 
			)Q1
			LEFT JOIN
			(
				SELECT
					CASE 
						WHEN Q1.JML_DRIVER IS NULL THEN 0
						ELSE Q1.JML_DRIVER
					END AS JML_DRIVER,
					CASE 
						WHEN Q2.JML_PIC IS NULL THEN 0
						ELSE Q2.JML_PIC
					END AS JML_PIC,
					CASE 
						WHEN Q2.NO_PENGAJUAN IS NULL THEN Q1.NO_PENGAJUAN
						WHEN Q1.NO_PENGAJUAN IS NULL THEN Q2.NO_PENGAJUAN
						ELSE '-'
					END AS NO_PENGAJUAN
				FROM
				(
					SELECT COUNT
						( NO_PENGAJUAN ) AS JML_DRIVER,
						NO_PENGAJUAN
					FROM
						SPJ_PENGAJUAN_PIC 
					WHERE
						JENIS_PIC IN ( 'Sopir', 'Driver' ) 
						AND GROUP_TUJUAN_ID = $group
					GROUP BY
						NO_PENGAJUAN
				)Q1
				FULL JOIN
				(
					SELECT COUNT
						( NO_PENGAJUAN ) AS JML_PIC,
						NO_PENGAJUAN
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NIK = '$pic' AND
						GROUP_TUJUAN_ID = $group
					GROUP BY NO_PENGAJUAN
				)Q2 ON Q1.NO_PENGAJUAN = Q2.NO_PENGAJUAN
			)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
			LEFT JOIN
			(
				SELECT
					ID_JENIS_SPJ,
					JENIS_KENDARAAN,
					QTY_LOKAL,
					QTY_LUAR_KOTA
				FROM
					SPJ_JUMLAH_PENDAMPING
				WHERE
					JENIS_KENDARAAN = '$jenisK'
			)Q3 ON Q1.JENIS_ID = Q3.ID_JENIS_SPJ
			LEFT JOIN
			(
				SELECT COUNT
					( NO_PENGAJUAN ) AS JML_PENDAMPING,
					NO_PENGAJUAN
				FROM
					SPJ_PENGAJUAN_PIC 
				WHERE
					JENIS_PIC IN ( 'Pendamping' ) 
					AND GROUP_TUJUAN_ID = $group
				GROUP BY
					NO_PENGAJUAN
			)Q4 ON Q1.NO_SPJ = Q4.NO_PENGAJUAN
			LEFT JOIN
			(
				SELECT
					COUNT(a.NIK) AS JML_MARKETING,
					NO_PENGAJUAN
				FROM
					SPJ_PENGAJUAN_PIC a
				INNER JOIN
					dbhrm.dbo.tbPegawai b
				ON a.NIK = b.nik
				WHERE
					divisi = 'Marketing'
				GROUP BY NO_PENGAJUAN
			)Q5 ON Q1.NO_SPJ = Q5.NO_PENGAJUAN";
		return $this->db->query($sql);
	}
	public function getTotalUangSakuMakan($inputNoSPJ, $inputGroupTujuan)
	{
		$sql = "SELECT
					UANG_SAKU,
					UANG_MAKAN
				FROM
				(
					SELECT
						NO_SPJ
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_SPJ = '$inputNoSPJ'
				)Q1
				LEFT JOIN
				(
					SELECT SUM
					( UANG_SAKU ) AS UANG_SAKU,
					SUM ( UANG_MAKAN ) AS UANG_MAKAN,
					NO_PENGAJUAN 
				FROM
					SPJ_PENGAJUAN_PIC 
				WHERE
					GROUP_TUJUAN_ID = $inputGroupTujuan
				GROUP BY
					NO_PENGAJUAN
				)Q2 ON Q1.NO_SPJ= Q2.NO_PENGAJUAN";
		return $this->db->query($sql);
	}
	public function saveKendaraanSPJ($inv, $jenis, $noSPJ, $tnkb, $merk, $tipe, $kendaraan)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET NO_INVENTARIS = '$inv', JENIS_KENDARAAN = '$jenis', NO_TNKB = '$tnkb', MERK = '$merk', TYPE = '$tipe', KENDARAAN = '$kendaraan' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function saveGroupTujuanSPJ($inputNoSPJ, $inputGroupTujuan)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET GROUP_ID ='$inputGroupTujuan' WHERE NO_SPJ = '$inputNoSPJ'";
		return $this->db->query($sql);
	}
	public function getUangJalanSPJ($noSPJ)
	{
		$sql = "SELECT
					MAX(BIAYA) AS BIAYA
				FROM
				(
					SELECT
						JENIS_ID,
						NO_SPJ,
						GROUP_ID
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_SPJ = '$noSPJ'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						GROUP_ID,
						SERLOK_KOTA
					FROM
						SPJ_PENGAJUAN_LOKASI
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ AND Q1.GROUP_ID = Q2.GROUP_ID
				LEFT JOIN
				(
					SELECT
						ID_UJ,
						a.ID_KOTA,
						NAMA_KOTA,
						BIAYA,
						ID_JENIS_SPJ
					FROM
						SPJ_UANG_JALAN a
					LEFT JOIN
						SPJ_KOTA b ON
					a.ID_KOTA = b.ID_KOTA
				)Q3 ON Q2.SERLOK_KOTA = Q3.NAMA_KOTA";
		return $this->db->query($sql);
	}
	public function cekKelengkapanDataSPJ($noSPJ)
	{
		$sql = "SELECT
					Q1.NO_SPJ,
					COUNT(Q2.NO_SPJ) AS JML_LOKASI,
					COUNT(Q3.NO_PENGAJUAN) AS JML_PIC
				FROM
				(
					SELECT
						NO_SPJ,
						NO_INVENTARIS,
						GROUP_ID
					FROM
						SPJ_PENGAJUAN
					WHERE
						NO_SPJ = '$noSPJ' AND
						GROUP_ID IS NOT NULL AND
						NO_INVENTARIS IS NOT NULL
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_SPJ,
						GROUP_ID
					FROM
						SPJ_PENGAJUAN_LOKASI
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ AND Q1.GROUP_ID = Q2.GROUP_ID
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						GROUP_TUJUAN_ID
					FROM
						SPJ_PENGAJUAN_PIC
				)Q3 ON Q1.NO_SPJ = Q3.NO_PENGAJUAN AND Q1.GROUP_ID = Q3.GROUP_TUJUAN_ID
				GROUP BY Q1.NO_SPJ";
		return $this->db->query($sql);
	}
	public function hapusLokasi($id)
	{
		$sql = "DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE ID_LOKASI = $id";
		return $this->db->query($sql);
	}
	public function hapusPIC($id)
	{
		$sql = "DELETE FROM SPJ_PENGAJUAN_PIC WHERE ID_PIC = $id";
		return $this->db->query($sql);
	}
	public function saveSPJ()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
        $inputTglSPJ = $this->input->post("inputTglSPJ");
        $inputJenisKendaraan = $this->input->post("inputJenisKendaraan");
        $inputKendaraan = $this->input->post("inputKendaraan");
        $inputNoInventaris = $this->input->post("inputNoInventaris");
        $inputMerk = $this->input->post("inputMerk");
        $inputType = $this->input->post("inputType");
        $inputNoTNKB = $this->input->post("inputNoTNKB");
        $inputGroupTujuan = $this->input->post("inputGroupTujuan");
        $inputTotalUangSaku = $this->input->post("inputTotalUangSaku");
        $inputTotalUangMakan = $this->input->post("inputTotalUangMakan");
        $inputTotalUangJalan = $this->input->post("inputTotalUangJalan");
        $inputBBM = $this->input->post("inputBBM");
        $inputIdVoucher = $this->input->post("inputIdVoucher");
        $inputTOL = $this->input->post("inputTOL");
        $inputMediaUangSaku = $this->input->post("inputMediaUangSaku");
        $inputMediaUangMakan = $this->input->post("inputMediaUangMakan");
        $inputMediaUangJalan = $this->input->post("inputMediaUangJalan");
        $inputMediaBBM = $this->input->post("inputMediaBBM");
        $inputMediaTOL = $this->input->post("inputMediaTOL");
        $inputTglBerangkat = $this->input->post("inputTglBerangkat");
        $inputJamBerangkat = $this->input->post("inputJamBerangkat");
        $inputTglPulang = $this->input->post("inputTglPulang");
        $inputJamPulang = $this->input->post("inputJamPulang");
        $inputJenisSPJ = $this->input->post("inputJenisSPJ");
        $rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $sql = "UPDATE SPJ_PENGAJUAN SET
        					TGL_INPUT = '$tanggal',
        					PIC_INPUT = '$user',
        					STATUS_DATA = 'SAVED',
        					TGL_SPJ = '$inputTglSPJ',
        					JENIS_KENDARAAN = '$inputJenisKendaraan',
        					NO_INVENTARIS = '$inputNoInventaris',
        					RENCANA_BERANGKAT = '$rencanaBerangkat',
        					RENCANA_PULANG = '$rencanaPulang',
        					NO_TNKB = '$inputNoTNKB',
        					MERK = '$inputMerk',
        					TYPE = '$inputType',
        					TOTAL_UANG_SAKU = '$inputTotalUangSaku',
        					TOTAL_UANG_MAKAN = '$inputTotalUangMakan',
        					TOTAL_UANG_JALAN = '$inputTotalUangJalan',
        					TOTAL_UANG_BBM = '$inputBBM',
        					TOTAL_UANG_TOL = '$inputTOL',
        					MEDIA_UANG_SAKU = '$inputMediaUangSaku',
        					MEDIA_UANG_MAKAN = '$inputMediaUangMakan',
        					MEDIA_UANG_JALAN = '$inputMediaUangJalan',
        					MEDIA_UANG_BBM = '$inputMediaBBM',
        					MEDIA_UANG_TOL = '$inputMediaTOL',
        					VOUCHER_ID = '$inputIdVoucher',
        					STATUS_SPJ = 'OPEN'
        		WHERE
        			NO_SPJ = '$inputNoSPJ'";
        // $biayaBBM = $inputIdVoucher == 0 ? $inputBBM : 0;
        // $kasbonSPJ = $inputTotalUangSaku + $inputTotalUangJalan + $inputTotalUangMakan + $biayaBBM;
        // $jenisSPJ = $inputJenisSPJ == 1 ? 'Delivery' : 'Non Delivery';
        // $detail = $inputJenisSPJ == 1 ? 'PPIC' : 'Finance';
       	// $this->db->query("Execute SPJ_tambahBiayaKasbon 'SPJ','spj','$kasbonSPJ','$inputNoSPJ','$jenisSPJ','$user','$tanggal'");

       	// if ($inputIdVoucher >0) {
       	// 	$this->db->query("Execute SPJ_tambahBiayaKasbon 'BBM','spj','$inputBBM','$inputNoSPJ','-','$user','$tanggal'");
       	// 	$this->db->query("UPDATE SPJ_VOUCHER_BBM SET STATUS = 'USED' WHERE ID = '$inputIdVoucher'");
       	// }

       	// if ($inputTOL>0 || $inputTOL != '') {
       	// 	$this->db->query("Execute SPJ_tambahBiayaKasbon 'TOL','spj','$inputTOL','$inputNoSPJ','$detail','$user','$tanggal'");
       	// }

        return $this->db->query($sql);
	}
	public function saveKasbon()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputBBM = $this->input->post("inputBBM");
        $inputIdVoucher = $this->input->post("inputIdVoucher");
        $inputTOL = $this->input->post("inputTOL");
        $inputJenisSPJ = $this->input->post("inputJenisSPJ");
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $getUangMakanJalan = $this->db->query("SELECT TOTAL_UANG_JALAN, TOTAL_UANG_MAKAN, TOTAL_UANG_SAKU FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'");
        foreach ($getUangMakanJalan->result() as $key) {
        	$inputTotalUangSaku = $key->TOTAL_UANG_SAKU;
	        $inputTotalUangMakan = $key->TOTAL_UANG_MAKAN;
	        $inputTotalUangJalan = $key->TOTAL_UANG_JALAN;	
        }
		$biayaBBM = $inputIdVoucher == 0 ? $inputBBM : 0;
        $kasbonSPJ = $inputTotalUangSaku + $inputTotalUangJalan + $inputTotalUangMakan + $biayaBBM;
        $jenisSPJ = $inputJenisSPJ == 1 ? 'Delivery' : 'Non Delivery';
        $detail = $inputJenisSPJ == 1 ? 'PPIC' : 'Finance';
       	$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'SPJ','spj','$kasbonSPJ','$inputNoSPJ','$jenisSPJ','$user','$tanggal'");

       	if ($inputIdVoucher >0) {
       		$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'BBM','spj','$inputBBM','$inputNoSPJ','-','$user','$tanggal'");
       		$sql = $this->db->query("UPDATE SPJ_VOUCHER_BBM SET STATUS = 'USED' WHERE ID = '$inputIdVoucher'");
       	}

       	if ($inputTOL>0 || $inputTOL != '') {
       		$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'TOL','spj','$inputTOL','$inputNoSPJ','$detail','$user','$tanggal'");
       	}

        return $sql;
	}
	public function cekAdaDriver($noSPJ)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						NIK
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NO_PENGAJUAN= '$noSPJ'
				)Q1
				INNER JOIN
				(
					SELECT
						*
					FROM
						SPJ_PEGAWAI_OTORITAS
					WHERE
						OTORITAS_DRIVER = 'Y'
				)Q2 ON Q1.NIK = Q2.NIK";
		return $this->db->query($sql);
	}
	public function saveRencanaBerangkat($inputNoSPJ, $inputTglBerangkat, $inputJamBerangkat, $inputTglPulang, $inputJamPulang)
	{
		$rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
		$sql = "UPDATE SPJ_PENGAJUAN SET RENCANA_BERANGKAT = '$rencanaBerangkat', RENCANA_PULANG = '$rencanaPulang' WHERE NO_SPJ = '$inputNoSPJ'";
		return $this->db->query($sql);
	}
	public function cekPICUangSaku($inputTglSPJ, $nik)
	{
		$sql = "SELECT
					Q1.NO_SPJ,
					Q1.DIFF_HOUR
				FROM
				(
					SELECT
						NO_SPJ,
						TGL_SPJ,
						RENCANA_BERANGKAT,
						RENCANA_PULANG,
						DATEDIFF(hh, RENCANA_BERANGKAT, RENCANA_PULANG) AS DIFF_HOUR
					FROM
						SPJ_PENGAJUAN
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						NIK 
					FROM
						SPJ_PENGAJUAN_PIC
				)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				WHERE
					TGL_SPJ = '$inputTglSPJ' AND
					NIK = '$nik'";
		return $this->db->query($sql);
	}
	public function hapusPICDriverCzMarketing($noSPJ)
	{
		$sql = "DELETE
				FROM
					SPJ_PENGAJUAN_PIC 
				WHERE
					NO_PENGAJUAN = '$noSPJ' 
					AND JENIS_PIC = 'Sopir'";
		return $this->db->query($sql);
	}
	public function savePICManajemen($noSPJ)
	{
		$sql = $this->db->query("UPDATE SPJ_PENGAJUAN_PIC SET UANG_MAKAN = 0 WHERE NO_PENGAJUAN= '$noSPJ'");
		$sql = $this->db->query("UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_MAKAN = 0, TOTAL_UANG_JALAN = 0, ADJUSTMENT_MANAJEMEN = 'Y' WHERE NO_SPJ = '$noSPJ'");
		return $sql;
	}
}
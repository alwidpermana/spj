<?php
class M_Pengajuan extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getNoSPJ($jenis, $kode, $tanggal)
	{
		if ($jenis == '1') {
			$kodeJenis = 'DLV';
		}elseif ($jenis == '2') {
			$kodeJenis = 'NDV';
		}else{
			$kodeJenis = 'OTR';
		}
		$tahun = date('Y');
        $bulan = date('m', strtotime($tanggal));
		$gabung = "SPJ/".$kodeJenis."/".$tahun."/".$bulan."/";
		$cekNoDoc=$this->db->query("SELECT MAX
											( RIGHT ( NO_SPJ, 4 ) ) AS SETNODOC
										FROM
											SPJ_PENGAJUAN
										WHERE
											NO_SPJ LIKE '$gabung%'");
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
	public function hapusPengajuan($noSPJ)
	{
		$sql = "DELETE FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$noSPJ'";
		$this->db->query("DELETE FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$noSPJ'");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$noSPJ'");
        return $this->db->query($sql);
	}
	public function saveTemporaryPengajuan($jenis, $no, $namaFile, $inputTglSPJ, $inputJenisOther)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$no' AND STATUS_DATA = 'TEMPORARY'");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN_PIC WHERE NO_PENGAJUAN = '$no'");
        $this->db->query("DELETE FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$no'");
        $jenisOther = $jenis == 3 ? $inputJenisOther : "";
        $link = './assets/image/qrcode/'.$namaFile.'.png';
		if(file_exists($link)){
			unlink($link);
		}
		$sql = "INSERT INTO SPJ_PENGAJUAN(TGL_INPUT, PIC_INPUT, STATUS_DATA, JENIS_ID, NO_SPJ, QR_CODE, TGL_SPJ, TUJUAN_OTHER)VALUES('$tanggal','$user','TEMPORARY','$jenis','$no','$namaFile','$inputTglSPJ','$jenisOther')";
		return $this->db->query($sql);
	}

	public function getListKendaraan($jenis, $kategori, $tgl, $search)
	{
		if ($jenis != '') {
			$sqlDelivery = " AND KATEGORI = '$jenis'";
		}else{
			$sqlDelivery = '';
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
				INNER JOIN
				(
					SELECT
						NO_TNKB
					FROM
						SPJ_VERIFIKASI_KENDARAAN
					WHERE
						STATUS = 'VERIFIED'
				)Q4 ON Q1.NoTNKB = Q4.NO_TNKB
				WHERE
					Q1.NoTNKB LIKE '%$search%'";
		return $this->db->query($sql);
	}
	public function getListKendaraanNonDelivery($search, $jenis, $kategori, $tgl)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						NoTNKB,
						Merk,
						Type,
						Jenis,
						Kategori,
						NoInventaris
					FROM
						GA.dbo.GA_Tkendaraan
					WHERE
						Jenis = '$jenis' AND
						Kategori = '$kategori'
				)Q1
				LEFT JOIN
				(
					SELECT
						ID_SPJ,
						NO_TNKB,
						NO_SPJ,
						STATUS_DATA
					FROM
						SPJ_PENGAJUAN
					WHERE
						TGL_SPJ = '$tgl' AND
						STATUS_DATA !='TEMPORARY'
				)Q2 ON Q1.NoTNKB = Q2.NO_TNKB
				LEFT JOIN
				(
					SELECT
						NIK AS NIK_DRIVER,
						NAMA AS NAMA_DRIVER,
						NO_PENGAJUAN
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						JENIS_PIC = 'Sopir'
				)Q3 ON Q2.NO_SPJ = Q3.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NO_TNBK,
						NAMA_FILE
					FROM
						SPJ_GAMBAR_KENDARAAN
					WHERE
						STAR = 'Y'
				)Q4 ON Q1.NoTNKB = Q4.NO_TNBK
				WHERE
					NoTNKB LIKE '%$search%' OR
					Merk LIKE '%$search%' OR
					Type LIKE '%$search%'
				ORDER BY NoTNKB ASC";
		return $this->db->query($sql);
	}
	public function getPendampingOnListKendaraan($noSPJ)
	{
		$sql = "SELECT
					NIK,
					NAMA 
				FROM
					SPJ_PENGAJUAN_PIC
				WHERE
					NO_PENGAJUAN = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getListSubcont()
	{
		$sql = "SELECT
					CompanyName
				FROM
					dbhrm.dbo.PC_TSupplier
				WHERE TypeOfCompany = 'SUBCONT'
				ORDER BY CompanyName ASC";
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
	public function saveLokasiTujuan($inputGroupTujuan, $inputObjek, $inputNoSPJ, $serlokID, $serlokAlamat, $serlokPerusahaan, $serlokKota, $deliveryId)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $getData = $this->db->query("SELECT ID_LOKASI FROM SPJ_PENGAJUAN_LOKASI WHERE NO_SPJ = '$inputNoSPJ' AND SERLOK_ID = $serlokID AND DELIVERY_ID = $deliveryId AND OBJEK = '$inputObjek'");
        if ($getData->num_rows()==0) {
        	$sql = "INSERT INTO SPJ_PENGAJUAN_LOKASI VALUES($serlokID, '$serlokAlamat','$serlokPerusahaan','$serlokKota','$inputNoSPJ','$inputGroupTujuan','$inputObjek','$tanggal','$user',null, $deliveryId)";	
        }else{
        	$sql = "UPDATE SPJ_PENGAJUAN_LOKASI SET SERLOK_ALAMAT = '$serlokAlamat', SERLOK_COMPANY = '$serlokPerusahaan', SERLOK_KOTA = '$serlokKota', GROUP_ID = '$inputGroupTujuan', OBJEK = '$inputObjek', TGL_INPUT = '$tanggal', PIC_INPUT = '$user', DELIVERY_ID = $deliveryId WHERE NO_SPJ = '$inputNoSPJ' AND SERLOK_ID = $serlokID";
        }
		
		return $this->db->query($sql);
	}
	public function updateGroupTujuan($no)
	{
		$sql = $this->db->query("SELECT TOP 1
									CASE 
									WHEN Q1.ID IS NULL OR Q1.ID = 0 THEN Q2.ID
									ELSE Q1.ID
								END AS ID
								FROM
								(
									SELECT
										MAX(GROUP_ID) AS ID,
										NO_SPJ
									FROM
										[dbo].[SPJ_PENGAJUAN_LOKASI]
									WHERE
										NO_SPJ = '$no' AND
										GROUP_ID != 4
									GROUP BY NO_SPJ
								)Q1
								FULL JOIN
								(
									SELECT
										MAX(GROUP_ID) AS ID,
										NO_SPJ
									FROM
										[dbo].[SPJ_PENGAJUAN_LOKASI]
									WHERE
										NO_SPJ = '$no' AND
										GROUP_ID = 4
									GROUP BY NO_SPJ
								)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ");
		$id = 0;
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
				LEFT JOIN
					SPJ_GROUP_TUJUAN b
				ON a.GROUP_ID = b.ID_GROUP
				WHERE
					NO_SPJ = '$inputNoSPJ' 
				ORDER BY
					ID_LOKASI ASC";
		return $this->db->query($sql);
	}
	public function getPIC($inputSubjek, $jabatan, $where, $noPengajuan, $where2, $whereJenis, $whereRekanan, $search)
	{
		$sql = "SELECT
				   Q1.*
				FROM
				(
					SELECT
						Q1.NIK,
						Q1.FOTO_WAJAH,
						Q2.namapeg,
						jabatan,
						departemen,
						Subdepartemen1,
						Subdepartemen2,
						NULL AS subkon
					FROM
					(
						SELECT
							*
						FROM
							SPJ_PEGAWAI_OTORITAS
						WHERE
							STATUS_DATA = 'SAVED' AND
							SUBJEK = '$inputSubjek' AND
							STATUS_VERIF = 'VERIFIED'
							$whereJenis
							$where
							$whereRekanan
					)Q1
					LEFT JOIN
					(
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						status AS jabatan,
						NULL AS departemen,
						NULL AS Subdepartemen1,
						NULL AS Subdepartemen2
					FROM
						TrTs_SopirLogistik 
					WHERE
						StatusAktif = 'Aktif' 
					UNION
					SELECT
						KdSopir AS nik,
						NamaSopir AS namapeg,
						status AS jabatan,
						NULL AS departemen,
						NULL AS Subdepartemen1,
						NULL AS Subdepartemen2
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
						Subdepartemen1,
						Subdepartemen2
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
						NO_PENGAJUAN,
						NIK
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NO_PENGAJUAN = '$noPengajuan'
				)Q2 ON Q1.NIK = Q2.NIK
				WHERE
					Q2.NIK IS NULL AND
					(Q1.NIK LIKE '%$search%' OR Q1.namapeg LIKE '%$search%')";
		// LEFT JOIN
		// (
		// 	SELECT
		// 		NIK
		// 	FROM
		// 		SPJ_PENGAJUAN a
		// 	INNER JOIN
		// 		SPJ_PENGAJUAN_PIC b
		// 	ON a.NO_SPJ = b.NO_PENGAJUAN
		// 	WHERE
		// 		STATUS_DATA = 'SAVED' AND
		// 		TGL_SPJ = '$inputTglSPJ'
		// )Q3 ON Q1.NIK = Q3.NIK
		return $this->db->query($sql);
	}
	public function getPICOffice($search)
	{
		$sql = "SELECT TOP 10
					nik AS NIK,
					namapeg,
					departemen,
					jabatan,
					Subdepartemen1,
					Subdepartemen2,
					CASE 
						WHEN jKelamin = 'P' THEN 'female1.png'
						ELSE 'male3.png'
					END AS FOTO_WAJAH,
					NULL AS subkon
				FROM
					dbhrm.dbo.tbPegawai
				WHERE	
					nik LIKE '%$search%' OR
					namapeg LIKE '%$search%'";
		return $this->db->query($sql);
	}
	public function getPICSubcont($search)
	{
		$sql = "SELECT TOP 10
					nik AS NIK,
					namapeg,
					subkon as departemen,
					jabatan,
					NULL as Subdepartemen1,
					NULL as Subdepartemen2,
					NULL AS FOTO_WAJAH,
					subkon
				FROM
					svrsub.dbSupplier.dbo.tbPegawai_subkon
				WHERE
					namapeg LIKE '%$search%'";
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
	public function savePIC($inputJenisPIC, $inputSubjek, $inputPIC, $inputUangSaku, $inputUangMakan, $inputSortir, $inputNoSPJ, $inputGroupTujuan, $inputDepartemen, $inputSubDepartemen, $inputJabatan, $inputNamaPIC, $inputSubcont)
	{
		date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");

        $sql = "INSERT INTO SPJ_PENGAJUAN_PIC VALUES('$tanggal','$user','$inputNoSPJ','$inputSubjek','$inputPIC','$inputUangSaku','$inputUangMakan','$inputSortir','$inputJenisPIC','$inputGroupTujuan', '$inputDepartemen','$inputSubDepartemen','$inputJabatan', '$inputNamaPIC','$inputSubcont')";
        return $this->db->query($sql);
	}
	public function getPengajuanPIC($group, $noPengajuan)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
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
					 GROUP_TUJUAN_ID,
					 SUBCONT
					FROM
						SPJ_PENGAJUAN_PIC
					WHERE
						NO_PENGAJUAN = '$noPengajuan' AND
						GROUP_TUJUAN_ID = '$group'
				)Q1
				LEFT JOIN
				(
					SELECT
						NIK AS NIK_WAJAH,
						FOTO_WAJAH
					FROM
						SPJ_PEGAWAI_OTORITAS
				)Q2 ON Q1.NIK = Q2.NIK_WAJAH";
		return $this->db->query($sql);
	}
	public function cekJumlahSupir($noPengajuan, $group, $pic, $jenisK)
	{
		$sql = "SELECT
				CASE 
					WHEN JML_DRIVER IS NULL THEN 0
					ELSE JML_DRIVER
				END AS JML_DRIVER,
				CASE 
					WHEN JML_PIC IS NULL THEN 0
					ELSE JML_PIC
				END AS JML_PIC,
				CASE 
					WHEN JML_PENDAMPING IS NULL THEN 0
					ELSE JML_PENDAMPING
				END AS JML_PENDAMPING,
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
						WHEN Q1.NO_PENGAJUAN IS NOT NULL THEN Q1.NO_PENGAJUAN
						WHEN Q2.NO_PENGAJUAN IS NOT NULL THEN Q2.NO_PENGAJUAN
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
						JENIS_PIC IN ( 'Sopir', 'Driver' ) AND
						JABATAN IN ( 'Sopir', 'Driver' ) 
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
					Subdepartemen2 = 'Marketing'
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
	public function saveKendaraanSPJ($inv, $jenis, $noSPJ, $tnkb, $merk, $tipe, $kendaraan, $rental, $rekananId)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET NO_INVENTARIS = '$inv', JENIS_KENDARAAN = '$jenis', NO_TNKB = '$tnkb', MERK = '$merk', TYPE = '$tipe', KENDARAAN = '$kendaraan' WHERE NO_SPJ = '$noSPJ'";
		if ($kendaraan == 'Rental') {
			$this->db->query("UPDATE SPJ_PENGAJUAN SET REKANAN_KENDARAAN = '$rental', REKANAN_ID='$rekananId' WHERE NO_SPJ = '$noSPJ'");
		}
		return $this->db->query($sql);
	}
	public function saveGroupTujuanSPJ($inputNoSPJ, $inputGroupTujuan)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET GROUP_ID ='$inputGroupTujuan' WHERE NO_SPJ = '$inputNoSPJ'";
		$this->db->query("UPDATE SPJ_PENGAJUAN_PIC SET GROUP_TUJUAN_ID = $inputGroupTujuan WHERE NO_PENGAJUAN = '$inputNoSPJ'");
		return $this->db->query($sql);
	}
	public function getUangJalanSPJ($noSPJ)
	{
		$sql = "SELECT TOP 1
					BIAYA
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
						COUNT(SERLOK_KOTA) AS JML_KOTA,
						SERLOK_KOTA,
						NO_SPJ
					FROM
					(
						SELECT
							CASE 
								WHEN SUBSTRING(SERLOK_KOTA, 1, 4) = 'Kota' THEN REPLACE(SERLOK_KOTA, 'KOTA ', '')
								ELSE REPLACE(SERLOK_KOTA, 'Kabupaten ', '') 
							END AS SERLOK_KOTA,
							NO_SPJ
						FROM
							SPJ_PENGAJUAN_LOKASI
					)Q1
					GROUP BY NO_SPJ, SERLOK_KOTA
				)Q2 ON Q1.NO_SPJ = Q2.NO_SPJ
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
				)Q3 ON Q2.SERLOK_KOTA = Q3.NAMA_KOTA AND Q1.JENIS_ID = Q3.ID_JENIS_SPJ
				ORDER BY JML_KOTA DESC";
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
	public function saveSPJ($voucher)
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
        $inputBiayaKendaraan = $this->input->post("inputBiayaKendaraan");
        
        $inputBBM = $this->input->post("inputBBM");
        $inputJenisSPJ = $this->input->post("inputJenisSPJ");
        
        $inputTOL = $this->input->post("inputTOL");
        $inputMediaUangSaku = $this->input->post("inputMediaUangSaku");
        $inputMediaUangMakan = $this->input->post("inputMediaUangMakan");
        $inputMediaUangJalan = $this->input->post("inputMediaUangJalan");
        $inputMediaBBM = $this->input->post("inputMediaBBM");
        $inputMediaTOL = $this->input->post("inputMediaTOL");
        $inputMediaKendaraan = $this->input->post("inputMediaKendaraan");
        $inputTglBerangkat = $this->input->post("inputTglBerangkat");
        $inputJamBerangkat = $this->input->post("inputJamBerangkat");
        $inputTglPulang = $this->input->post("inputTglPulang");
        $inputJamPulang = $this->input->post("inputJamPulang");
        $inputNoVoucher = $inputMediaBBM == 'Voucher'?$this->input->post("inputNoVoucher"):'';
        $rencanaBerangkat = $inputTglBerangkat.' '.$inputJamBerangkat;
        $rencanaPulang = $inputTglPulang.' '.$inputJamPulang;
        $inputTambahanUangJalan = $this->input->post("inputTambahanUangJalan") == '' ? 0 :  $this->input->post("inputTambahanUangJalan");
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $inputAbnormal = $this->input->post("inputAbnormal");
        $inputTotalUangJalan = $inputGroupTujuan == '4'|| $inputAbnormal == 'Y' ? $this->input->post("inputTotalUangJalan")+$this->input->post("inputTambahanUangJalan"): $this->input->post("inputTotalUangJalan");
        if ($inputMediaBBM == 'Voucher') {
        	$user = $this->session->userdata("NIK");
			$bulan = date("m");
			$tahun = date("Y");
       		// $this->db->query("UPDATE SPJ_VOUCHER_BBM SET STATUS = 'USED' WHERE NO_VOUCHER = '$inputNoVoucher'");
       		$getVoucher = $this->db->query("SELECT ID FROM SPJ_VOUCHER_BBM WHERE NO_VOUCHER = '$inputNoVoucher'");
       		if ($getVoucher->num_rows()==0) {
       			$this->db->query("INSERT INTO SPJ_VOUCHER_BBM(NO_VOUCHER, STATUS, TGL_INPUT, PIC_INPUT, KODE_ROMAWI, TAHUN)VALUES('$inputNoVoucher','USED','$tanggal','$user','$bulan','$tahun')");
       		}
       		
       	}else{
       		$voucherAsal='';
       		$getVoucherSPJ = $this->db->query("SELECT VOUCHER_BBM FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'");
       		$JmlVoucherAsal = $getVoucherSPJ->num_rows();
       		if ($JmlVoucherAsal > 0) {
       			$dataVoucherAsal = $getVoucherSPJ->row();
	       		$voucherAsal = $dataVoucherAsal->VOUCHER_BBM;
	       		$this->db->query("UPDATE SPJ_VOUCHER_BBM SET STATUS = 'NOT' WHERE NO_VOUCHER = '$voucherAsal'");
       		
       		}
       		
       		// $this->db->query()
       	}
       	$statusData= $inputJenisSPJ == '1'?'SAVED':'DRAFT';
       	$statusSPJ = $inputJenisSPJ == '1'?'OPEN':'DRAFT';
        $sql = $this->db->query("UPDATE SPJ_PENGAJUAN SET
        					TGL_INPUT = '$tanggal',
        					PIC_INPUT = '$user',
        					STATUS_DATA = '$statusData',
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
        					VOUCHER_BBM = '$inputNoVoucher',
        					STATUS_SPJ = '$statusSPJ',
        					TAMBAHAN_UANG_JALAN = '$inputTambahanUangJalan',
        					TOTAL_UANG_KENDARAAN = '$inputBiayaKendaraan',
        					MEDIA_UANG_KENDARAAN = '$inputMediaKendaraan'
        		WHERE
        			NO_SPJ = '$inputNoSPJ'");
       	if ($inputMediaBBM == 'Tanpa BBM' || $inputMediaBBM == 'Kasbon') {
       		$this->db->query("UPDATE SPJ_PENGAJUAN SET VOUCHER = 'Y' WHERE NO_SPJ = '$inputNoSPJ'");
       	}
       	if ($inputJenisSPJ == '1') {
       		$this->db->query("UPDATE SPJ_PENGAJUAN SET ABNORMAL = '$inputAbnormal' WHERE NO_SPJ = '$inputNoSPJ'");
       	}
       	if ($inputKendaraan == 'Gojek/Grab') {
       		$this->db->query("UPDATE SPJ_PENGAJUAN SET MEDIA_UANG_BBM = 'Tanpa BBM', TOTAL_UANG_BBM = '0', MEDIA_UANG_TOL = 'Tanpa TOL', TOTAL_UANG_TOL = '0' WHERE NO_SPJ = '$inputNoSPJ'");
       	}
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

       	
        return $sql;
	}
	public function saveKasbon()
	{
		$inputNoSPJ = $this->input->post("inputNoSPJ");
		$inputBBM = $this->input->post("inputBBM");
        $inputIdVoucher = $this->input->post("inputIdVoucher");
        $inputTOL = $this->input->post("inputTOL");
        $inputJenisSPJ = $this->input->post("inputJenisSPJ");
        $inputNoVoucher = $this->input->post("inputNoVoucher");
        $inputMediaBBM = $this->input->post("inputMediaBBM");
        $inputMediaTOL = $this->input->post("inputMediaTOL");
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');
        $user = $this->session->userdata("NIK");
        $getUangMakanJalan = $this->db->query("SELECT TOTAL_UANG_JALAN, TOTAL_UANG_MAKAN, TOTAL_UANG_SAKU FROM SPJ_PENGAJUAN WHERE NO_SPJ = '$inputNoSPJ'");
        foreach ($getUangMakanJalan->result() as $key) {
        	$inputTotalUangSaku = $key->TOTAL_UANG_SAKU;
	        $inputTotalUangMakan = $key->TOTAL_UANG_MAKAN;
	        $inputTotalUangJalan = $key->TOTAL_UANG_JALAN;	
        }
        $biayaBBM = $inputMediaBBM == 'Kasbon' ? $inputBBM : 0;
        $biayaTol = $inputMediaTOL == 'Kasbon' ? $inputTOL : 0;
        $kasbonSPJ = $inputTotalUangSaku + $inputTotalUangJalan + $inputTotalUangMakan + $biayaBBM + $biayaTol;
        $jenisSPJ = $inputJenisSPJ == 1 ? 'Delivery' : 'Non Delivery';
        $detail = $inputJenisSPJ == 1 ? 'PPIC' : 'Finance';
       	$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'SPJ','spj','$kasbonSPJ','$inputNoSPJ','$jenisSPJ','$user','$tanggal'");

       	if ($inputMediaBBM =='Voucher') {
       		$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'BBM','spj','$biayaBBM','$inputNoSPJ','-','$user','$tanggal'");
       	}

       	if ($inputMediaTOL == 'Reimburse') {
       		$sql = $this->db->query("Execute SPJ_tambahBiayaKasbon 'TOL','spj','$biayaTol','$inputNoSPJ','$detail','$user','$tanggal'");
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
						NO_PENGAJUAN= '$noSPJ' AND
						JENIS_PIC = 'Sopir'
				)Q1";
				// INNER JOIN
				// (
				// 	SELECT
				// 		*
				// 	FROM
				// 		SPJ_PEGAWAI_OTORITAS
				// 	WHERE
				// 		OTORITAS_DRIVER = 'Y'
				// )Q2 ON Q1.NIK = Q2.NIK
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
					WHERE 
						STATUS_DATA = 'SAVED' AND
						STATUS_SPJ != 'CANCEL' AND
						JENIS_ID != '3'
				)Q1
				LEFT JOIN
				(
					SELECT
						NO_PENGAJUAN,
						NIK 
					FROM
						SPJ_PENGAJUAN_PIC
				)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
				LEFT JOIN
				(
					SELECT
						NIK
					FROM
						SPJ_PEGAWAI_OTORITAS
					WHERE
						OTORITAS_UANG_SAKU = 'Y'
				)Q3 ON Q2.NIK = Q3.NIK
				WHERE
					TGL_SPJ = '$inputTglSPJ' AND
					Q2.NIK = '$nik' AND
					Q3.NIK IS NOT NULL";
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
	public function getKendaraanWithAutoComplete($postData)
	{
		$cari = $postData['search'];
		$sql = $this->db->query("SELECT DISTINCT TOP 10
					NO_TNKB,
					MERK,
					TYPE,
					REKANAN_KENDARAAN
				FROM
					SPJ_PENGAJUAN
				WHERE
					KENDARAAN = 'Pribadi' AND NO_TNKB LIKE '%$cari%'
				ORDER BY NO_TNKB DESC");
		if ($sql->num_rows()>0) {
			foreach ($sql->result() as $key) {
				$response[] = array("merk"=>$key->MERK,"label"=>$key->NO_TNKB,"type"=>$key->TYPE,'rekanan'=>$key->REKANAN_KENDARAAN);			
			}
		}else{
			$response='';
		}
		
		// if ($sql->num_rows()>0) {

		// }else{
		// 	$response[] = array("value"=>$key->ID_SPJ,"label"=>$key->NO_TNKB);
		// }
		return $response;
	}
	public function getIDByNoSPJ($noSPJ)
	{
		$sql = "SELECT
					ID_SPJ,
					NAMA_JENIS 
				FROM
					SPJ_PENGAJUAN a
				INNER JOIN SPJ_JENIS b 
				ON a.JENIS_ID = b.ID_JENIS 
				WHERE
					NO_SPJ = '$noSPJ' AND
					STATUS_DATA = 'SAVED'";
		return $this->db->query($sql);
	}
	public function getDataTemporary($search)
	{
		$user = $this->session->userdata("LEVEL")>1 ? $this->session->userdata("NIK") : '';
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						ID_SPJ,
						a.TGL_INPUT,
						a.PIC_INPUT,
						namapeg AS PIC_NAMA,
						JENIS_ID,
						NAMA_JENIS,
						NO_SPJ,
						TGL_SPJ,
						QR_CODE
					FROM
						SPJ_PENGAJUAN a
					LEFT JOIN dbhrm.dbo.tbPegawai b ON
					a.PIC_INPUT = b.nik
					INNER JOIN SPJ_JENIS c ON
					a.JENIS_ID = c.ID_JENIS
					WHERE
						STATUS_DATA = 'TEMPORARY' AND
						a.PIC_INPUT LIKE '$user%'
				)Q1
				WHERE
					NO_SPJ LIKE '%$search%' OR
					QR_CODE LIKE '%$search%'
				ORDER BY TGL_INPUT DESC";
		return $this->db->query($sql);
	}
	public function getSPJTemporary($id)
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
							REKANAN_KENDARAAN
						FROM
							SPJ_PENGAJUAN
						WHERE
							STATUS_DATA = 'TEMPORARY' AND
							ID_SPJ = $id
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
	public function cekOtoritasUangRumsum($nik)
	{
		$sql ="SELECT
					OTORITAS_UANG_SAKU,
					OTORITAS_UANG_MAKAN
				FROM
					SPJ_PEGAWAI_OTORITAS
				WHERE
					NIK = '$nik'";
		return $this->db->query($sql);
	}
	public function getUangAbnormal($noSPJ)
	{
		$sql = "SELECT
					SUM(BIAYA) AS BIAYA
				FROM
					SPJ_PENGAJUAN_LOKASI a
				INNER JOIN
					SPJ_UANG_ABNORMAL b ON
				a.SERLOK_ID = b.SERLOK_ID AND a.DELIVERY_ID = b.DELIVERY_ID
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function cariDataVoucher($search, $where)
	{
		$sql = "SELECT
					NO_VOUCHER
				FROM
				(
					SELECT
						ROW_NUMBER() over (partition by 'SAMA' order by NO_VOUCHER ASC) AS NO_URUT,
						NO_VOUCHER,
						KODE_ROMAWI,
						TAHUN
					FROM
						[dbo].[SPJ_VOUCHER_BBM]
					WHERE
						STATUS = 'NOT' AND
						NO_VOUCHER LIKE '%$search%'
				)Q1
				$where
				ORDER BY TAHUN, KODE_ROMAWI, NO_VOUCHER ASC";
		return $this->db->query($sql);
	}
	public function updateFlagTrip($noSPJ)
	{
		$flag = 0;
		$getFlag = $this->db->query("SELECT
										MAX(FLAG_TRIP) AS FLAG
									FROM
										SPJ_PENGAJUAN_LOKASI
									WHERE
										NO_SPJ = '$noSPJ'");
		if ($getFlag->num_rows()>0) {
			$data = $getFlag->row();
			$flag = $data->FLAG+1;
		} else {
			$flag = 1;
		}

		$this->db->query("UPDATE SPJ_PENGAJUAN_LOKASI SET FLAG_TRIP = $flag WHERE NO_SPJ = '$noSPJ'");

		
	}
	public function getJmlLokasiBySPJ($noSPJ)
	{
		$sql = "SELECT
					COUNT(ID_LOKASI) AS JML_LOKASI
				FROM
					SPJ_PENGAJUAN_LOKASI 
				WHERE
					NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getSUMUangRumsum($noSPJ)
	{
		$sql = "SELECT
					SUM ( UANG_SAKU ) AS TOTAL_UANG_SAKU,
					SUM ( UANG_MAKAN ) AS TOTAL_UANG_MAKAN 
				FROM
					SPJ_PENGAJUAN_PIC 
				WHERE
					NO_PENGAJUAN = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getDataSPJ_test($noSPJ)
	{
		$sql = "SELECT TGL_SPJ, JENIS_ID, JENIS_KENDARAAN FROM SPJ_PENGAJUAN WHERE NO_SPJ='$noSPJ'";
		return $this->db->query($sql);
	}
	public function getNoVoucherAuto_V1()
	{
		$bulan = date("m");
		$tahun = date("y");
		$getRomawi = $this->db->query("SELECT ROMAWI FROM SPJ_ROMAWI WHERE KODE = '$bulan'")->row();
		$bulanRomawi = $getRomawi->ROMAWI;
		$gabung = "KPSVC-".$bulanRomawi.''.$tahun."-";
		$cekNoDoc=$this->db->query("SELECT MAX
											( RIGHT ( VOUCHER_BBM, 4 ) ) AS SETNODOC
										FROM
											SPJ_PENGAJUAN
										WHERE
											VOUCHER_BBM LIKE '$gabung%'");
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
                $hasil = $URUTDOCNO;
            }   
        }
        return $hasil;
	}
	public function generateVoucherBBM($noVoucher, $noSPJ)
	{
		$save = $this->db->query("UPDATE SPJ_PENGAJUAN SET VOUCHER_BBM = '$noVoucher' WHERE NO_SPJ='$noSPJ'");
		$this->db->query("UPDATE SPJ_PENGAJUAN SET MEDIA_UANG_BBM = 'Voucher' WHERE NO_SPJ = '$noSPJ'");
		return $save;
	}
	public function getGroupForLainnya($id)
	{
		$sql = "SELECT
					ID_GROUP,
					TIPE_KOTA+' '+NAMA_KOTA AS KOTA
				FROM
					[dbo].[SPJ_GT_DETAIL] a
				INNER JOIN
					SPJ_KOTA b ON
				a.ID_KOTA = b.ID_KOTA
				WHERE
					a.ID_KOTA = $id";
		return $this->db->query($sql);
	}
	public function getPengajuanDraft($search, $jenis, $where)
	{
		$sql = "SELECT
					*
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
						a.TOTAL_UANG_KENDARAAN,
						a.NO_GENERATE,
						a.PIC_INPUT,
						c.namapeg AS NAMA_INPUT,
						c.jabatan AS JABATAN_INPUT,
						c.departemen AS DEPARTEMEN_INPUT,
						a.KENDARAAN,
						a.JENIS_ID,
						a.JENIS_KENDARAAN,
						a.MERK,
						a.TYPE,
						a.NO_TNKB,
						a.RENCANA_BERANGKAT,
						a.RENCANA_PULANG,
						MEDIA_UANG_SAKU,
						MEDIA_UANG_MAKAN,
						MEDIA_UANG_JALAN,
						MEDIA_UANG_BBM,
						MEDIA_UANG_TOL,
						MEDIA_UANG_KENDARAAN
					FROM
						[dbo].[SPJ_PENGAJUAN] a
					LEFT JOIN SPJ_GROUP_TUJUAN b ON
					a.GROUP_ID = b.ID_GROUP
					LEFT JOIN
						dbhrm.dbo.tbPegawai c ON
					a.PIC_INPUT = c.nik
					WHERE
						STATUS_DATA = 'DRAFT' AND
						JENIS_ID LIKE '$jenis%'
						$where
				)Q1
				INNER JOIN
				(
					SELECT
						NO_PENGAJUAN,
						SUM(UANG_SAKU) AS TOTAL_UANG_SAKU,
						SUM(UANG_MAKAN) AS TOTAL_UANG_MAKAN
					FROM 
						SPJ_PENGAJUAN_PIC
					GROUP BY NO_PENGAJUAN	
				)Q2 ON Q1.NO_SPJ = Q2.NO_PENGAJUAN
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
				)Q3 ON Q1.NO_SPJ = Q3.NO_PENGAJUAN
				WHERE 
					NO_SPJ LIKE '%$search%' OR
					NIK_DRIVER LIKE '%$search%' OR
					NAMA_DRIVER LIKE '%$search%' OR
					NAMA_INPUT LIKE '%$search%'
				ORDER BY ID_SPJ DESC";
		return $this->db->query($sql);
	}
	public function approveSPJDraft($noSPJ)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET STATUS_DATA = 'SAVED', STATUS_SPJ = 'OPEN' WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
	public function getSupplier($cari)
	{
		$sql = "SELECT TOP 25
					*
				FROM
				(
					SELECT
						NoSupplier AS id,
						CompanyName AS COMPANY_NAME,
						ISNULL(AddressOffice, '') AS ALAMAT_LENGKAP_PLANT 
					FROM
						dbhrm.dbo.PC_TSupplier 
					WHERE
						CompanyName IS NOT NULL 
						AND CompanyName != '-' 
				)Q1
				WHERE 
					COMPANY_NAME LIKE '%$cari%' OR 
					ALAMAT_LENGKAP_PLANT LIKE '%$cari%' OR 
					id LIKE '%$cari%'
				ORDER BY
					COMPANY_NAME ASC";
		return $this->db->query($sql);
	}
	public function getKotaByGroup($where)
	{
		$sql = "SELECT
					a.ID_KOTA,
					b.TIPE_KOTA+' '+b.NAMA_KOTA AS KOTA,
					a.ID_GROUP
				FROM
					[dbo].[SPJ_GT_DETAIL] a
				INNER JOIN
					SPJ_KOTA b
				ON a.ID_KOTA = b.ID_KOTA
				$where
				ORDER BY NAMA_KOTA ASC";
		return $this->db->query($sql);
	}
	public function saveAutoBiayaKendaraan($noSPJ, $biaya)
	{
		$sql = "UPDATE SPJ_PENGAJUAN SET TOTAL_UANG_KENDARAAN = $biaya WHERE NO_SPJ = '$noSPJ'";
		return $this->db->query($sql);
	}
}
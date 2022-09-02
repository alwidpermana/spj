<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_File extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Auth');
		$this->load->model('M_Data_Master');
		$this->load->model('M_Pengajuan');
		$this->load->model('M_Serlok');
		$this->load->model('M_Monitoring');
		$this->load->model('M_Implementasi');
		$this->load->library('pdfgenerator');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function excel_spj()
	{
		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ')
                 ->setLastModifiedBy('SPJ')
                 ->setTitle("SPJ ")
                 ->setSubject("spj")
                 ->setDescription("export Data SPJ")
                 ->setKeywords("spj");
        $style_col = array(
	      'font' => array('bold' => true), // Set font nya jadi bold
	      'alignment' => array(
	        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ),
	      'borders' => array(
	        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	      ),'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'e5e5e5')
	        )
	    );
	    $style_row = array(
	      'alignment' => array(
	        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ),
	      'borders' => array(
	        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	      )
	    );

	    $excel->setActiveSheetIndex(0)->setCellValue('A1', "No");
	    $excel->setActiveSheetIndex(0)->mergeCells('A1:A2');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Tanggal Input");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:B2');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "No SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('C1:C2');
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', "Tanggal SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('D1:D2');
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', "Qr Code");
	    $excel->setActiveSheetIndex(0)->mergeCells('E1:E2');
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', "Pengaju");
	    $excel->setActiveSheetIndex(0)->mergeCells('F1:J1');
	    $excel->setActiveSheetIndex(0)->setCellValue('F2', "NIK");
	    $excel->setActiveSheetIndex(0)->setCellValue('G2', "Nama");
	    $excel->setActiveSheetIndex(0)->setCellValue('H2', "jabatan");
	    $excel->setActiveSheetIndex(0)->setCellValue('I2', "Departemen");
	    $excel->setActiveSheetIndex(0)->setCellValue('J2', "Sub Departemen");

	    $excel->setActiveSheetIndex(0)->setCellValue('K1', "Kendaraan");
	    $excel->setActiveSheetIndex(0)->mergeCells('K1:P1');
	    $excel->setActiveSheetIndex(0)->setCellValue('K2', "Kendaraan");
	    $excel->setActiveSheetIndex(0)->setCellValue('L2', "Jenis");
	    $excel->setActiveSheetIndex(0)->setCellValue('M2', "No Inventaris");
	    $excel->setActiveSheetIndex(0)->setCellValue('N2', "Merk");
	    $excel->setActiveSheetIndex(0)->setCellValue('O2', "Type");
	    $excel->setActiveSheetIndex(0)->setCellValue('P2', "No TNKB");

	    $excel->setActiveSheetIndex(0)->setCellValue('Q1', "Tujuan");
	    $excel->setActiveSheetIndex(0)->mergeCells('Q1:R1');
	    $excel->setActiveSheetIndex(0)->setCellValue('Q2', "Group Tujuan");
	    $excel->setActiveSheetIndex(0)->setCellValue('R2', "Tujuan");

	    $excel->setActiveSheetIndex(0)->setCellValue('S1', "PIC");
	    $excel->setActiveSheetIndex(0)->mergeCells('S1:T1');
	    $excel->setActiveSheetIndex(0)->setCellValue('S2', "Driver");
	    $excel->setActiveSheetIndex(0)->setCellValue('T2', "Pendamping");

	    $excel->setActiveSheetIndex(0)->setCellValue('U1', "Biaya Reguler");
	    $excel->setActiveSheetIndex(0)->mergeCells('U1:Z1');
	    $excel->setActiveSheetIndex(0)->setCellValue('U2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('V2', "uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('W2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('X2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('Y2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('Z2', "Jumlah");

	    $excel->setActiveSheetIndex(0)->setCellValue('AA1', "Biaya Tambahan");
	    $excel->setActiveSheetIndex(0)->mergeCells('AA1:AD1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AA2', "Uang Saku 1-3");
	    $excel->setActiveSheetIndex(0)->setCellValue('AB2', "uang Saku >4");
	    $excel->setActiveSheetIndex(0)->setCellValue('AC2', "Makan Ke-2");
	    $excel->setActiveSheetIndex(0)->setCellValue('AD2', "Jumlah");


	    $excel->setActiveSheetIndex(0)->setCellValue('AE1', "Total Biaya");
	    $excel->setActiveSheetIndex(0)->mergeCells('AE1:AE2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AF1', "Adjustment Biaya");
	    $excel->setActiveSheetIndex(0)->mergeCells('AF1:AF2');

	    $excel->setActiveSheetIndex(0)->setCellValue('AG1', "Validasi");
	    $excel->setActiveSheetIndex(0)->mergeCells('AG1:AH1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AG2', "Out");
	    $excel->setActiveSheetIndex(0)->setCellValue('AH2', "In");

	    $excel->setActiveSheetIndex(0)->setCellValue('AI1', "Rencana Berangkat");
	    $excel->setActiveSheetIndex(0)->mergeCells('AI1:AJ1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AI2', "Tanggal");
	    $excel->setActiveSheetIndex(0)->setCellValue('AJ2', "Jam");

	    $excel->setActiveSheetIndex(0)->setCellValue('AK1', "Aktual Berangkat");
	    $excel->setActiveSheetIndex(0)->mergeCells('AK1:AL1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AK2', "Tanggal");
	    $excel->setActiveSheetIndex(0)->setCellValue('AL2', "Jam");

	    $excel->setActiveSheetIndex(0)->setCellValue('AM1', "Rencana Pulang");
	    $excel->setActiveSheetIndex(0)->mergeCells('AM1:AN1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AM2', "Tanggal");
	    $excel->setActiveSheetIndex(0)->setCellValue('AN2', "Jam");

	    $excel->setActiveSheetIndex(0)->setCellValue('AO1', "Aktual Pulang");
	    $excel->setActiveSheetIndex(0)->mergeCells('AO1:AP1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AO2', "Tanggal");
	    $excel->setActiveSheetIndex(0)->setCellValue('AP2', "Jam");

	    $excel->setActiveSheetIndex(0)->setCellValue('AQ1', "KM");
	    $excel->setActiveSheetIndex(0)->mergeCells('AQ1:AS1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AQ2', "Out");
	    $excel->setActiveSheetIndex(0)->setCellValue('AR2', "In");
	    $excel->setActiveSheetIndex(0)->setCellValue('AS2', "Selisih");

	    $excel->setActiveSheetIndex(0)->setCellValue('AT1', "Konsumsi BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('AT1:AW1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AT2', "KM/Ltr");
	    $excel->setActiveSheetIndex(0)->setCellValue('AU2', "Terpakai(Ltr)");
	    $excel->setActiveSheetIndex(0)->setCellValue('AV2', "Harga/Liter");
	    $excel->setActiveSheetIndex(0)->setCellValue('AW2', "Rp");

	    $excel->setActiveSheetIndex(0)->setCellValue('AX1', "GAP BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('AX1:AX1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AX2', "Ltr");
	    $excel->setActiveSheetIndex(0)->setCellValue('AY2', "Rp.");


	    $excel->setActiveSheetIndex(0)->setCellValue('AZ1', "Status");
	    $excel->setActiveSheetIndex(0)->mergeCells('AZ1:AZ2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BA1', "Generate Status");
	    $excel->setActiveSheetIndex(0)->mergeCells('BA1:BA2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BB1', "No Generate");
	    $excel->setActiveSheetIndex(0)->mergeCells('BB1:BB2');
	    

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z1')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('AA1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AP1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AQ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AR1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AS1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AT1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AU1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AV1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AW1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AX1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AY1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AZ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB2')->applyFromArray($style_col);
		
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z2')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('AA2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AO2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AP2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AQ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AR2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AS2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AT2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AU2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AV2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AW2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AX2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AY2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AZ2')->applyFromArray($style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(35); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

		$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AU')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AV')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AW')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AX')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AY')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BA')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BB')->setWidth(20);

		$data = $this->M_Monitoring->getSPJ('', '', '', '', '', '','')->result();
		$numrow = 3;
		$nomor = 1;
		foreach ($data as $key) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, date('d-m-Y', strtotime($key->TGL_INPUT)));
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->NO_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->TGL_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->QR_CODE);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->PIC_INPUT);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->namapeg);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->jabatan);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->departemen);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $key->Subdepartemen);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $key->KENDARAAN);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->JENIS_KENDARAAN);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->NO_INVENTARIS);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->MERK);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $key->TYPE);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $key->NO_TNKB);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $key->NAMA_GROUP);
			$pic = $this->M_Monitoring->getPICPendampingByNoSPJ('','','', '','');
			$tujuan = $this->M_Monitoring->getTujuanByNoSPJ('','','', '','');
			$jmlPIC = $pic->num_rows();
			$isiPIC = '';
			$noPIC = 1;
			foreach ($pic->result() as $pc) {
				if ($pc->NO_PENGAJUAN == $key->NO_SPJ) {
					$isiPIC .= $pc->PIC;
					if ($noPIC>$jmlPIC) {
						$isiPIC.="\n";
					}
					$noPIC++;
				}
			}
			$jmlTujuan = $tujuan->num_rows();
			$isiTujuan = '';
			$noTujuan = 1;
			foreach ($tujuan->result() as $tj) {
				if ($tj->NO_SPJ == $key->NO_SPJ) {
					$isiTujuan .= $tj->SERLOK_KOTA;
					if ($jmlTujuan>$noTujuan) {
						$isiTujuan.="\n";
					}
					$noTujuan++;
				}
			}
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $isiTujuan);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $key->PIC_DRIVER);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $isiPIC);
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, round($key->TOTAL_UANG_SAKU));
			$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, round($key->TOTAL_UANG_MAKAN));
			$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, round($key->TOTAL_UANG_JALAN));
			$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, round($key->TOTAL_UANG_BBM));
			$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, round($key->TOTAL_UANG_TOL));
			$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_BBM + $key->TOTAL_UANG_TOL;
			$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, round($total));
			$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, round($key->US1));
			$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, round($key->US2));
			$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, round($key->UM));
			$totalTambahan = $key->US1 + $key->US2 + $key->UM;
			$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, round($totalTambahan));
			$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, round($total+$totalTambahan));
			$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, round($key->BIAYA_ADJUSTMENT));
			$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, $key->KEBERANGKATAN == null?'':$key->VALIDASI_OUT);
			$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $key->KEPULANGAN == null?'':$key->VALIDASI_IN);
			$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, date("d-m-Y",strtotime($key->RENCANA_BERANGKAT)));
			$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, date("H:i",strtotime($key->RENCANA_BERANGKAT)));
			$excel->setActiveSheetIndex(0)->setCellValue('AK'.$numrow, $key->KEBERANGKATAN==null?'':date("d-m-Y",strtotime($key->KEBERANGKATAN)));
			$excel->setActiveSheetIndex(0)->setCellValue('AL'.$numrow, $key->KEBERANGKATAN==null?'':date("H:i",strtotime($key->KEBERANGKATAN)));
			$excel->setActiveSheetIndex(0)->setCellValue('AM'.$numrow, date("d-m-Y",strtotime($key->RENCANA_PULANG)));
			$excel->setActiveSheetIndex(0)->setCellValue('AN'.$numrow, date("H:i",strtotime($key->RENCANA_PULANG)));
			$excel->setActiveSheetIndex(0)->setCellValue('AO'.$numrow, $key->KEPULANGAN == null ?'':date("d-m-Y",strtotime($key->KEPULANGAN)));
			$excel->setActiveSheetIndex(0)->setCellValue('AP'.$numrow, $key->KEPULANGAN == null ?'':date("H:i",strtotime($key->KEPULANGAN)));
			$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$numrow, round($key->KM_OUT, 2));
			$excel->setActiveSheetIndex(0)->setCellValue('AR'.$numrow, round($key->KM_IN, 2));
			$excel->setActiveSheetIndex(0)->setCellValue('AS'.$numrow, round($key->KM_IN-$key->KM_OUT, 2));
			$excel->setActiveSheetIndex(0)->setCellValue('AT'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AU'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AV'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AW'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AX'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AY'.$numrow, '');
			$excel->setActiveSheetIndex(0)->setCellValue('AZ'.$numrow, $key->STATUS_SPJ == 'CLOSE' && $key->NO_GENERATE == null ? 'Waiting For Generate':$key->STATUS_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('BA'.$numrow, $key->NO_GENERATE == null ?'OPEN':'CLOSE');
			$excel->setActiveSheetIndex(0)->setCellValue('BB'.$numrow, $key->NO_GENERATE);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
        	$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
        	$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AQ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AR'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AS'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
        	$excel->getActiveSheet()->getStyle('AT'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AU'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AV'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AW'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AX'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AY'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('AZ'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('BA'.$numrow)->applyFromArray($style_row);
        	$excel->getActiveSheet()->getStyle('BB'.$numrow)->applyFromArray($style_row);
			$numrow++;
            $nomor++;
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("SPJ");
	    $excel->setActiveSheetIndex(0);
	    // Proses file excel
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename=Data-SPJ.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');
	}
}
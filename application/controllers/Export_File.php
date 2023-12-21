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
		$jenis = $this->input->get("jenis");
		$search = $this->input->get("search");
		$status = $this->input->get("filStatus");
		$data = $this->M_Monitoring->getSPJ('', '', $jenis, $search, '', '','')->result();
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
			$pic = $this->M_Monitoring->getPICPerSPJ($key->NO_SPJ);
			$tujuan = $this->M_Monitoring->getLokasiPerNoSPJ($key->NO_SPJ);
			$jmlPIC = $pic->num_rows();
			$isiPIC = '';
			$noPIC = 1;
			foreach ($pic->result() as $pc) {
				$isiPIC .= $pc->NIK.' - '.$pc->NAMA;
				if ($noPIC>$jmlPIC) {
					$isiPIC.="\n";
				}
				$noPIC++;
			}
			$jmlTujuan = $tujuan->num_rows();
			$isiTujuan = '';
			$noTujuan = 1;
			foreach ($tujuan->result() as $tj) {
				$isiTujuan .= $tj->SERLOK_KOTA;
				if ($jmlTujuan>$noTujuan) {
					$isiTujuan.="\n";
				}
				$noTujuan++;
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
	public function export_harian_spj($filBulan, $filTahun, $filJenis)
	{
		$jenis = $filJenis == '-'?'':$filJenis;
		$data = $this->M_Monitoring->getMonitoringSPJHarian2($filBulan, $filTahun, $jenis)->result();
		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Harian")
                 ->setSubject("spj Harian")
                 ->setDescription("export Data SPJ Harian")
                 ->setKeywords("spj Harian");
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
	    $excel->setActiveSheetIndex(0)->mergeCells('A1:A3');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Tanggal");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:CP1');
	    $excel->setActiveSheetIndex(0)->setCellValue('B2', "1");
	    $excel->setActiveSheetIndex(0)->mergeCells('B2:D2');
	    $excel->setActiveSheetIndex(0)->setCellValue('E2', "2");
	    $excel->setActiveSheetIndex(0)->mergeCells('E2:G2');
	    $excel->setActiveSheetIndex(0)->setCellValue('H2', "3");
	    $excel->setActiveSheetIndex(0)->mergeCells('H2:J2');
	    $excel->setActiveSheetIndex(0)->setCellValue('K2', "4");
	    $excel->setActiveSheetIndex(0)->mergeCells('K2:M2');
	    $excel->setActiveSheetIndex(0)->setCellValue('N2', "5");
	    $excel->setActiveSheetIndex(0)->mergeCells('N2:P2');
	    $excel->setActiveSheetIndex(0)->setCellValue('Q2', "6");
	    $excel->setActiveSheetIndex(0)->mergeCells('Q2:S2');
	    $excel->setActiveSheetIndex(0)->setCellValue('T2', "7");
	    $excel->setActiveSheetIndex(0)->mergeCells('T2:V2');
	    $excel->setActiveSheetIndex(0)->setCellValue('W2', "8");
	    $excel->setActiveSheetIndex(0)->mergeCells('W2:Y2');
	    $excel->setActiveSheetIndex(0)->setCellValue('Z2', "9");
	    $excel->setActiveSheetIndex(0)->mergeCells('Z2:AB2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AC2', "10");
	    $excel->setActiveSheetIndex(0)->mergeCells('AC2:AE2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AF2', "11");
	    $excel->setActiveSheetIndex(0)->mergeCells('AF2:AH2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AI2', "12");
	    $excel->setActiveSheetIndex(0)->mergeCells('AI2:AK2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AL2', "13");
	    $excel->setActiveSheetIndex(0)->mergeCells('AL2:AN2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AO2', "14");
	    $excel->setActiveSheetIndex(0)->mergeCells('AO2:AQ2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AR2', "15");
	    $excel->setActiveSheetIndex(0)->mergeCells('AR2:AT2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AU2', "16");
	    $excel->setActiveSheetIndex(0)->mergeCells('AU2:AW2');
	    $excel->setActiveSheetIndex(0)->setCellValue('AX2', "17");
	    $excel->setActiveSheetIndex(0)->mergeCells('AX2:AZ2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BA2', "18");
	    $excel->setActiveSheetIndex(0)->mergeCells('BA2:BC2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BD2', "19");
	    $excel->setActiveSheetIndex(0)->mergeCells('BD2:BF2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BG2', "20");
	    $excel->setActiveSheetIndex(0)->mergeCells('BG2:BI2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BJ2', "21");
	    $excel->setActiveSheetIndex(0)->mergeCells('BJ2:BL2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BM2', "22");
	    $excel->setActiveSheetIndex(0)->mergeCells('BM2:BO2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BP2', "23");
	    $excel->setActiveSheetIndex(0)->mergeCells('BP2:BR2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BS2', "24");
	    $excel->setActiveSheetIndex(0)->mergeCells('BS2:BU2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BV2', "25");
	    $excel->setActiveSheetIndex(0)->mergeCells('BV2:BX2');
	    $excel->setActiveSheetIndex(0)->setCellValue('BY2', "26");
	    $excel->setActiveSheetIndex(0)->mergeCells('BY2:CA2');
	    $excel->setActiveSheetIndex(0)->setCellValue('CB2', "27");
	    $excel->setActiveSheetIndex(0)->mergeCells('CB2:CD2');
	    $excel->setActiveSheetIndex(0)->setCellValue('CE2', "28");
	    $excel->setActiveSheetIndex(0)->mergeCells('CE2:CG2');
	    $excel->setActiveSheetIndex(0)->setCellValue('CH2', "29");
	    $excel->setActiveSheetIndex(0)->mergeCells('CH2:CJ2');
	    $excel->setActiveSheetIndex(0)->setCellValue('CK2', "30");
	    $excel->setActiveSheetIndex(0)->mergeCells('CK2:CM2');
	    $excel->setActiveSheetIndex(0)->setCellValue('CN2', "31");
	    $excel->setActiveSheetIndex(0)->mergeCells('CN2:CP2');
	    
	    $excel->setActiveSheetIndex(0)->setCellValue('B3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('C3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('D3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('E3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('F3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('G3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('H3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('I3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('J3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('K3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('L3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('M3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('N3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('O3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('P3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('Q3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('R3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('S3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('T3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('U3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('V3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('W3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('X3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('Y3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('Z3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AA3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AB3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AC3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AD3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AE3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AF3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AG3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AH3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AI3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AJ3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AK3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AL3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AM3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AN3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AO3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AP3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AQ3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AR3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AS3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AT3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AU3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AV3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AW3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('AX3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AY3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('AZ3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BA3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BB3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BC3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BD3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BE3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BF3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BG3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BH3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BI3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BJ3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BK3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BL3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BM3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BN3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BO3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BP3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BQ3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BR3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BS3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BT3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BU3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BV3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BW3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('BX3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('BY3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BZ3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CA3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('CB3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CC3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CD3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('CE3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CF3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CG3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('CH3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CI3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CJ3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('CK3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CL3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CM3', "Status");
	    $excel->setActiveSheetIndex(0)->setCellValue('CN3', "No SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CO3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('CP3', "Status");

	    // $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
		// $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('BC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BR1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BS1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BT1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BU1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BV1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BW1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BX1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BY1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BZ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CA1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CP1')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('BA2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BR2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BS2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BT2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BU2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BV2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BW2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BX2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BY2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BZ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CA2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CO2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CP2')->applyFromArray($style_col);

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AK3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AL3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AM3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AN3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AO3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AP3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AQ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AR3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AS3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AT3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AU3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AV3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AW3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AX3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AY3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('AZ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BB3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BR3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BS3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BT3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BU3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BV3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BW3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BX3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BY3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BZ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CA3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CB3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CC3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CD3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CE3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CF3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CG3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CH3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CI3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CJ3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CK3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CL3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CM3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CN3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CO3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CP3')->applyFromArray($style_col);


		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('W')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AU')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AW')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('AX')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BA')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BC')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BD')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BF')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BG')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BI')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BJ')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BL')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BM')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BO')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BP')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BR')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BS')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BT')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BU')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BV')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BW')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('BX')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('BY')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('BZ')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CA')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('CB')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('CC')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CD')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('CE')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('CF')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CG')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('CH')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('CI')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CJ')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('CK')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('CL')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CM')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('CN')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('CO')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('CP')->setWidth(10);
		

		$numrow = 4;
		$nomor = 1;
		foreach ($data as $key) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->NO_1);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->RP_1);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->STATUS_1);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->NO_2);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->RP_2);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->STATUS_2);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->NO_3);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->RP_3);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $key->STATUS_3);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $key->NO_4);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->RP_4);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->STATUS_4);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->NO_5);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $key->RP_5);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $key->STATUS_5);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $key->NO_6);
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $key->RP_6);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $key->STATUS_6);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $key->NO_7);
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $key->RP_7);
			$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $key->STATUS_7);
			$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $key->NO_8);
			$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $key->RP_8);
			$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $key->STATUS_8);
			$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $key->NO_9);
			$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $key->RP_9);
			$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $key->STATUS_9);
			$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $key->NO_10);
			$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $key->RP_10);
			$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $key->STATUS_10);
			$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, $key->NO_11);
			$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, $key->RP_11);
			$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $key->STATUS_11);
			$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, $key->NO_12);
			$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, $key->RP_12);
			$excel->setActiveSheetIndex(0)->setCellValue('AK'.$numrow, $key->STATUS_12);
			$excel->setActiveSheetIndex(0)->setCellValue('AL'.$numrow, $key->NO_13);
			$excel->setActiveSheetIndex(0)->setCellValue('AM'.$numrow, $key->RP_13);
			$excel->setActiveSheetIndex(0)->setCellValue('AN'.$numrow, $key->STATUS_13);
			$excel->setActiveSheetIndex(0)->setCellValue('AO'.$numrow, $key->NO_14);
			$excel->setActiveSheetIndex(0)->setCellValue('AP'.$numrow, $key->RP_14);
			$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$numrow, $key->STATUS_14);
			$excel->setActiveSheetIndex(0)->setCellValue('AR'.$numrow, $key->NO_15);
			$excel->setActiveSheetIndex(0)->setCellValue('AS'.$numrow, $key->RP_15);
			$excel->setActiveSheetIndex(0)->setCellValue('AT'.$numrow, $key->STATUS_15);
			$excel->setActiveSheetIndex(0)->setCellValue('AU'.$numrow, $key->NO_16);
			$excel->setActiveSheetIndex(0)->setCellValue('AV'.$numrow, $key->RP_16);
			$excel->setActiveSheetIndex(0)->setCellValue('AW'.$numrow, $key->STATUS_16);
			$excel->setActiveSheetIndex(0)->setCellValue('AX'.$numrow, $key->NO_17);
			$excel->setActiveSheetIndex(0)->setCellValue('AY'.$numrow, $key->RP_17);
			$excel->setActiveSheetIndex(0)->setCellValue('AZ'.$numrow, $key->STATUS_17);
			$excel->setActiveSheetIndex(0)->setCellValue('BA'.$numrow, $key->NO_18);
			$excel->setActiveSheetIndex(0)->setCellValue('BB'.$numrow, $key->RP_18);
			$excel->setActiveSheetIndex(0)->setCellValue('BC'.$numrow, $key->STATUS_18);
			$excel->setActiveSheetIndex(0)->setCellValue('BD'.$numrow, $key->NO_19);
			$excel->setActiveSheetIndex(0)->setCellValue('BE'.$numrow, $key->RP_19);
			$excel->setActiveSheetIndex(0)->setCellValue('BF'.$numrow, $key->STATUS_19);
			$excel->setActiveSheetIndex(0)->setCellValue('BG'.$numrow, $key->NO_20);
			$excel->setActiveSheetIndex(0)->setCellValue('BH'.$numrow, $key->RP_20);
			$excel->setActiveSheetIndex(0)->setCellValue('BI'.$numrow, $key->STATUS_20);
			$excel->setActiveSheetIndex(0)->setCellValue('BJ'.$numrow, $key->NO_21);
			$excel->setActiveSheetIndex(0)->setCellValue('BK'.$numrow, $key->RP_21);
			$excel->setActiveSheetIndex(0)->setCellValue('BL'.$numrow, $key->STATUS_21);
			$excel->setActiveSheetIndex(0)->setCellValue('BM'.$numrow, $key->NO_22);
			$excel->setActiveSheetIndex(0)->setCellValue('BN'.$numrow, $key->RP_22);
			$excel->setActiveSheetIndex(0)->setCellValue('BO'.$numrow, $key->STATUS_22);
			$excel->setActiveSheetIndex(0)->setCellValue('BP'.$numrow, $key->NO_23);
			$excel->setActiveSheetIndex(0)->setCellValue('BQ'.$numrow, $key->RP_23);
			$excel->setActiveSheetIndex(0)->setCellValue('BR'.$numrow, $key->STATUS_23);
			$excel->setActiveSheetIndex(0)->setCellValue('BS'.$numrow, $key->NO_24);
			$excel->setActiveSheetIndex(0)->setCellValue('BT'.$numrow, $key->RP_24);
			$excel->setActiveSheetIndex(0)->setCellValue('BU'.$numrow, $key->STATUS_24);
			$excel->setActiveSheetIndex(0)->setCellValue('BV'.$numrow, $key->NO_25);
			$excel->setActiveSheetIndex(0)->setCellValue('BW'.$numrow, $key->RP_25);
			$excel->setActiveSheetIndex(0)->setCellValue('BX'.$numrow, $key->STATUS_25);
			$excel->setActiveSheetIndex(0)->setCellValue('BY'.$numrow, $key->NO_26);
			$excel->setActiveSheetIndex(0)->setCellValue('BZ'.$numrow, $key->RP_26);
			$excel->setActiveSheetIndex(0)->setCellValue('CA'.$numrow, $key->STATUS_26);
			$excel->setActiveSheetIndex(0)->setCellValue('CB'.$numrow, $key->NO_27);
			$excel->setActiveSheetIndex(0)->setCellValue('CC'.$numrow, $key->RP_27);
			$excel->setActiveSheetIndex(0)->setCellValue('CD'.$numrow, $key->STATUS_27);
			$excel->setActiveSheetIndex(0)->setCellValue('CE'.$numrow, $key->NO_28);
			$excel->setActiveSheetIndex(0)->setCellValue('CF'.$numrow, $key->RP_28);
			$excel->setActiveSheetIndex(0)->setCellValue('CG'.$numrow, $key->STATUS_28);
			$excel->setActiveSheetIndex(0)->setCellValue('CH'.$numrow, $key->NO_29);
			$excel->setActiveSheetIndex(0)->setCellValue('CI'.$numrow, $key->RP_29);
			$excel->setActiveSheetIndex(0)->setCellValue('CJ'.$numrow, $key->STATUS_29);
			$excel->setActiveSheetIndex(0)->setCellValue('CK'.$numrow, $key->NO_30);
			$excel->setActiveSheetIndex(0)->setCellValue('CL'.$numrow, $key->RP_30);
			$excel->setActiveSheetIndex(0)->setCellValue('CM'.$numrow, $key->STATUS_30);
			$excel->setActiveSheetIndex(0)->setCellValue('CN'.$numrow, $key->NO_31);
			$excel->setActiveSheetIndex(0)->setCellValue('CO'.$numrow, $key->RP_31);
			$excel->setActiveSheetIndex(0)->setCellValue('CP'.$numrow, $key->STATUS_31);

			// $excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
	    	// $excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
	    	// $excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row); // Set width kolom A
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AQ'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AR'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AS'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AT'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AU'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AV'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AW'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AX'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('AY'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AZ'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BA'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BB'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BC'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BD'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BE'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BF'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BG'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BH'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BI'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BJ'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BK'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BL'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BM'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BN'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BO'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BP'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BQ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BR'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BS'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BT'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BU'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BV'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BW'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BX'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BY'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('BZ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CA'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CB'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CC'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CD'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CE'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CF'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CG'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CH'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CI'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CJ'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CK'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CL'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CM'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CN'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('CO'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CP'.$numrow)->applyFromArray($style_row);

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
	    header('Content-Disposition: attachment; filename=Data-Harian-SPJ.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');
	}

	public function excelHargaSPJ()
	{
		$periodeAwal = date("Y-m-d", strtotime($this->input->get("periodeAwal")));
		$periodeAkhir = date("Y-m-d", strtotime($this->input->get("periodeAkhir")));
		$filJenis = $this->input->get("filJenis");
		$filStatus = $this->input->get("filStatus");
		$filSearch = $this->input->get("filSearch");
		$data= $this->M_Monitoring->getTabelWeekly($periodeAwal, $periodeAkhir, $filJenis, $filStatus, $filSearch)->result();
		
		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Biaya Weekly")
                 ->setSubject("spj Biaya Weekly")
                 ->setDescription("export Data SPJ Biaya Weekly")
                 ->setKeywords("spj Biaya Weekly");
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
	    $excel->setActiveSheetIndex(0)->mergeCells('A1:A3');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Tanggal SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:B3');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "No SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('C1:C3');
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', "QR Code");
	    $excel->setActiveSheetIndex(0)->mergeCells('D1:D3');
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', "Status SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('E1:E3');
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', "Nama Group");
	    $excel->setActiveSheetIndex(0)->mergeCells('F1:F3');
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', "Voucher BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('G1:G3');
	    $excel->setActiveSheetIndex(0)->setCellValue('H1', "No Generate");
	    $excel->setActiveSheetIndex(0)->mergeCells('H1:H3');
	    $excel->setActiveSheetIndex(0)->setCellValue('I1', "Biaya");
	    $excel->setActiveSheetIndex(0)->mergeCells('I1:N1');
	    $excel->setActiveSheetIndex(0)->setCellValue('I2', "SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('I2:K2');
	    $excel->setActiveSheetIndex(0)->setCellValue('I3', "Pengajuan");
	    $excel->setActiveSheetIndex(0)->setCellValue('J3', "Tambahan");
	    $excel->setActiveSheetIndex(0)->setCellValue('K3', "Total");
		$excel->setActiveSheetIndex(0)->setCellValue('L2', "TOL");
	    $excel->setActiveSheetIndex(0)->mergeCells('L2:L3');
		$excel->setActiveSheetIndex(0)->setCellValue('M2', "BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('M2:M3');
		$excel->setActiveSheetIndex(0)->setCellValue('N2', "TOTAL");
	    $excel->setActiveSheetIndex(0)->mergeCells('N2:N3');

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
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
	    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col); // Set width kolom A
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
	    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$numrow = 4;
		$nomor = 1;
		foreach ($data as $key) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->TGL_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->NO_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->QR_CODE);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->STATUS_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->NAMA_GROUP);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->VOUCHER_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->NO_GENERATE);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->TOTAL_KASBON);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $key->TOTAL_TAMBAHAN_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $key->TOTAL_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->TOTAL_RP);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row); // Set width kolom A
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");

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
	    header('Content-Disposition: attachment; filename=Data-Biaya-weekly-SPJ.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');
	}
	public function cost_reduction_delivery()
	{
		$awal = $this->input->get("awal");
		$akhir = $this->input->get("akhir");
		$data = $this->M_Monitoring->getTabelCostReduction('', $awal, $akhir)->result();

		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Cost Reduction Delivery")
                 ->setSubject("spj Cost Reduction Delivery")
                 ->setDescription("export Data SPJ Cost Reduction Delivery")
                 ->setKeywords("spj Cost Reduction Delivery");
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
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Tanggal SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:B2');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "No SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('C1:C2');
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', "Status SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('D1:D2');
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', "Kendaraan");
	    $excel->setActiveSheetIndex(0)->mergeCells('E1:H1');
	    $excel->setActiveSheetIndex(0)->setCellValue('E2', "Kendaraan");
	    $excel->setActiveSheetIndex(0)->setCellValue('F2', "No TNKB");
	    $excel->setActiveSheetIndex(0)->setCellValue('G2', "Merk");
	    $excel->setActiveSheetIndex(0)->setCellValue('H2', "Type");
	    $excel->setActiveSheetIndex(0)->setCellValue('I1', "Group Tujuan");
	    $excel->setActiveSheetIndex(0)->mergeCells('I1:K1');
	    $excel->setActiveSheetIndex(0)->setCellValue('I2', "Nama Group");
	    $excel->setActiveSheetIndex(0)->setCellValue('J2', "Tujuan");
	    $excel->setActiveSheetIndex(0)->setCellValue('L2', "Customer");
	    $excel->setActiveSheetIndex(0)->setCellValue('L1', "PIC");
	    $excel->setActiveSheetIndex(0)->mergeCells('L1:M1');
	    $excel->setActiveSheetIndex(0)->setCellValue('L2', "Driver");
	    $excel->setActiveSheetIndex(0)->setCellValue('M2', "Pendamping");
	    $excel->setActiveSheetIndex(0)->setCellValue('N1', "Abnormal");
	    $excel->setActiveSheetIndex(0)->mergeCells('N1:N2');
	    $excel->setActiveSheetIndex(0)->setCellValue('O1', "Biaya Uang Jalan");
	    $excel->setActiveSheetIndex(0)->mergeCells('O1:Q1');
	    $excel->setActiveSheetIndex(0)->setCellValue('O2', "Normal");
	    $excel->setActiveSheetIndex(0)->setCellValue('P2', "Aktual");
	    $excel->setActiveSheetIndex(0)->setCellValue('Q2', "GAP");

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
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
	    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col); // Set width kolom A
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
	    

	    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(35);
		
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

		$numrow = 3;
		$nomor = 1;
		$lokasi1 = '';
		$lokasi2 = '';
		$lokasi3 = '';
		$lokasi4 = '';
		$lfcr = chr(10).chr(10);
 // Lakukan looping pada variabel siswa
      // $excel->setActiveSheetIndex(1)->setCellValue('A'.$numrow1, $codeitemm.$lfcr.$partname);
      // $excel->getActiveSheet()->getStyle('A'.$numrow1)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
		foreach ($data as $key) {
			$lokasi = str_replace('<br>',', ',$key->LOKASI);
			$customer = str_replace('<br>',', ',$key->CUSTOMER);
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $nomor);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->TGL_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->NO_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->STATUS_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->KENDARAAN);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->NO_TNKB);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->MERK);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->TYPE);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->NAMA_GROUP);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $lokasi);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $customer);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->NIK_DRIVER.'-'.$key->NAMA_DRIVER);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->NIK_PENDAMPING.'-'.$key->NAMA_PENDAMPING);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->ABNORMAL == 'Y' ? 'YES':'NO');
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $key->NORMAL_UANG_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $key->AKTUAL_UANG_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $key->GAP);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row); // Set width kolom A
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row)->getAlignment()->setWrapText(true);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");

			$numrow++;
            $nomor++;
		}
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("Cost Reduction");
	    $excel->setActiveSheetIndex(0);
	    // Proses file excel


	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename=Data-Cost_Reduction_Delivery-SPJ.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');	

	}
	public function exportGrapikCostReduction()
	{
		$awal = date("Y-m-d", strtotime($this->input->get("awal")));
		$akhir = date("Y-m-d", strtotime($this->input->get("akhir")));
		$tahun = $this->input->get("tahun");
		$bulan = date("n", strtotime($awal));
		$data = $this->M_Monitoring->grapikCRDelivery($tahun, $awal, $akhir, $bulan)->result();

		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Cost Reduction Delivery")
                 ->setSubject("spj Cost Reduction Delivery")
                 ->setDescription("export Data SPJ Cost Reduction Delivery")
                 ->setKeywords("spj Cost Reduction Delivery");
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

	    $excel->setActiveSheetIndex(0)->setCellValue('A1', "Bulan");
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Jumlah Target");
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', "Normal");
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', "Aktual");
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', "GAP(Normal-Aktual)");
	    $excel->setActiveSheetIndex(0)->setCellValue('G1', "Status");

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$numrow = 2;
		foreach ($data as $key) {
			if ($key->GAP == null) {
				$statusCR = '';
			}elseif ($key->JUMLAH_TARGET>$key->GAP ) {
				$statusCR = 'Tidak Tercapai';
			}elseif($key->GAP>=$key->JUMLAH_TARGET){
				$statusCR = 'Tercapai';
			}else{
				$statusCR = '';
			}
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key->NAMA_BULAN);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->JUMLAH_TARGET);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->NORMAL);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->AKTUAL);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->GAP);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $statusCR);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			
			$numrow++;
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("Grapik Cost Reduction");
	    $excel->setActiveSheetIndex(0);
	    // Proses file excel


	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename=Grapik-Cost_Reduction_Delivery-SPJ.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');	
	}
	public function export_monitoring_sortir($value='')
	{
		$filSearch = $this->input->get("filSearch");
		$data = $this->M_Monitoring->getMonitoringSortir($filSearch)->result();

		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Monitoring Sortir Delivery")
                 ->setSubject("spj Monitoring Sortir Delivery")
                 ->setDescription("export Data SPJ Monitoring Sortir Delivery")
                 ->setKeywords("spj Monitoring Sortir Delivery");
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
	    $excel->setActiveSheetIndex(0)->mergeCells('A1:A3');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Tanggal");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:B3');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "No SPJ");
	    $excel->setActiveSheetIndex(0)->mergeCells('C1:C3');
	    $excel->setActiveSheetIndex(0)->setCellValue('D1', "Status");
	    $excel->setActiveSheetIndex(0)->mergeCells('D1:D3');
	    $excel->setActiveSheetIndex(0)->setCellValue('E1', "Nama Group");
	    $excel->setActiveSheetIndex(0)->mergeCells('E1:E3');
	    $excel->setActiveSheetIndex(0)->setCellValue('F1', "Voucher BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('F1:F3');
	    $excel->setActiveSheetIndex(0)->setCellValue('G1', "No Generate");
	    $excel->setActiveSheetIndex(0)->mergeCells('G1:G3');
	    $excel->setActiveSheetIndex(0)->setCellValue('H1', "Biaya");
	    $excel->setActiveSheetIndex(0)->mergeCells('H1:X1');
	    $excel->setActiveSheetIndex(0)->setCellValue('H2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	    $excel->setActiveSheetIndex(0)->setCellValue('J2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->mergeCells('J2:K2');
	    $excel->setActiveSheetIndex(0)->setCellValue('L2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->mergeCells('L2:M2');
	    $excel->setActiveSheetIndex(0)->setCellValue('N2', "Uang BBM");
	    $excel->setActiveSheetIndex(0)->mergeCells('N2:O2');
	    $excel->setActiveSheetIndex(0)->setCellValue('P2', "Uang TOL");
	    $excel->setActiveSheetIndex(0)->mergeCells('P2:Q2');
	    $excel->setActiveSheetIndex(0)->setCellValue('R2', "Biaya Tambahan");
	    $excel->setActiveSheetIndex(0)->mergeCells('R2:T2');
	    $excel->setActiveSheetIndex(0)->setCellValue('U2', "Uang Kendaraan");
	    $excel->setActiveSheetIndex(0)->mergeCells('U2:V2');
	    $excel->setActiveSheetIndex(0)->setCellValue('W2', "Uang Lainnya");
	    $excel->setActiveSheetIndex(0)->mergeCells('W2:X2');
	    $excel->setActiveSheetIndex(0)->setCellValue('H3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('I3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('J3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('K3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('L3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('M3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('N3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('O3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('P3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('Q3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('R3', "Uang Saku 1");
	    $excel->setActiveSheetIndex(0)->setCellValue('S3', "Uang Saku 2");
	    $excel->setActiveSheetIndex(0)->setCellValue('T3', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('U3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('V3', "Media");
	    $excel->setActiveSheetIndex(0)->setCellValue('W3', "Rp");
	    $excel->setActiveSheetIndex(0)->setCellValue('X3', "Media");

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
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

	    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col); // Set width kolom A
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

	    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(15); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('X')->setWidth(15);

		$numrow = 4;
		foreach ($data as $key) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key->NO_URUT);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->TGL_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->NO_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->STATUS_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->NAMA_GROUP);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->VOUCHER_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->NO_GENERATE);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->MEDIA_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $key->TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $key->MEDIA_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->TOTAL_UANG_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->MEDIA_UANG_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->TOTAL_UANG_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $key->MEDIA_UANG_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $key->TOTAL_UANG_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $key->MEDIA_UANG_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $key->UANG_SAKU1);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $key->UANG_SAKU2);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $key->UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $key->TOTAL_UANG_KENDARAAN);
			$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $key->MEDIA_UANG_KENDARAAN);
			$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $key->TOTAL_UANG_LAINNYA);
			$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow,'Reimburse');

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
			$numrow++;
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("Monitoring Sortir");
	    $excel->setActiveSheetIndex(0);
	    // Proses file excel


	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename=Monitoring-Sortir.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');	
	}

	public function marketing_monthly()
	{
		$tahun = $this->input->get("tahun") == '' ? date("Y") : $this->input->get("tahun");
		$data = $this->M_Monitoring->getMonthlyMarketing($tahun)->result();

		include APPPATH.'third_party/PHPExcel.php';
     	$excel = new PHPExcel();
     	$excel->getProperties()->setCreator('SPJ By Alwi')
                 ->setLastModifiedBy('SPJ By Alwi')
                 ->setTitle("SPJ Monitoring Monthly Marketing")
                 ->setSubject("spj Monitoring Monthly Marketing")
                 ->setDescription("export Data SPJ Monitoring Monthly Marketing")
                 ->setKeywords("spj Monitoring Monthly Marketing");
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

	    $excel->setActiveSheetIndex(0)->setCellValue('A1', "NIK");
	    $excel->setActiveSheetIndex(0)->mergeCells('A1:A2');
	    $excel->setActiveSheetIndex(0)->setCellValue('B1', "Nama");
	    $excel->setActiveSheetIndex(0)->mergeCells('B1:B2');
	    $excel->setActiveSheetIndex(0)->setCellValue('C1', "JANUARI");
	    $excel->setActiveSheetIndex(0)->mergeCells('C1:K1');
	    $excel->setActiveSheetIndex(0)->setCellValue('L1', "FEBRUARI");
	    $excel->setActiveSheetIndex(0)->mergeCells('L1:T1');
	    $excel->setActiveSheetIndex(0)->setCellValue('U1', "MARET");
	    $excel->setActiveSheetIndex(0)->mergeCells('U1:AC1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AD1', "APRIL");
	    $excel->setActiveSheetIndex(0)->mergeCells('AD1:AL1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AM1', "MEI");
	    $excel->setActiveSheetIndex(0)->mergeCells('AM1:AU1');
	    $excel->setActiveSheetIndex(0)->setCellValue('AV1', "JUNI");
	    $excel->setActiveSheetIndex(0)->mergeCells('AV1:BD1');
	    $excel->setActiveSheetIndex(0)->setCellValue('BE1', "JULI");
	    $excel->setActiveSheetIndex(0)->mergeCells('BE1:BM1');
	    $excel->setActiveSheetIndex(0)->setCellValue('BN1', "AGUSTUS");
	    $excel->setActiveSheetIndex(0)->mergeCells('BN1:BV1');
	    $excel->setActiveSheetIndex(0)->setCellValue('BW1', "SEPTEMBER");
	    $excel->setActiveSheetIndex(0)->mergeCells('BW1:CE1');
	    $excel->setActiveSheetIndex(0)->setCellValue('CF1', "OKTOBER");
	    $excel->setActiveSheetIndex(0)->mergeCells('CF1:CN1');
	    $excel->setActiveSheetIndex(0)->setCellValue('CO1', "NOVEMBER");
	    $excel->setActiveSheetIndex(0)->mergeCells('CO1:CW1');
	    $excel->setActiveSheetIndex(0)->setCellValue('CX1', "DESEMBER");
	    $excel->setActiveSheetIndex(0)->mergeCells('CX1:DF1');
	    $excel->setActiveSheetIndex(0)->setCellValue('DG1', "TOTAL");
	    $excel->setActiveSheetIndex(0)->mergeCells('DG1:DO1');
	    $excel->setActiveSheetIndex(0)->setCellValue('C2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('D2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('E2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('F2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('G2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('H2', "UANG JALAN");
	    $excel->setActiveSheetIndex(0)->setCellValue('I2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('J2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('K2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('L2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('M2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('N2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('O2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('P2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('Q2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('R2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('S2', "Tamabahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('T2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('U2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('V2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('W2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('X2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('Y2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('Z2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AA2', "Tamabahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AB2', "Tambahaan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AC2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AD2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AE2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AF2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AG2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AH2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('AI2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AJ2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AK2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AL2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AM2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AN2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AO2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AP2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AQ2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('AR2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AS2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AT2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AU2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AV2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('AW2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('AX2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('AY2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('AZ2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('BA2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BB2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BC2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BD2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('BE2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BF2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BG2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BH2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('BI2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('BJ2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BK2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BL2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BM2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('BN2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BO2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BP2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BQ2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('BR2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('BS2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BT2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BU2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BV2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('BW2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('BX2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('BY2', "Uang MAkan");
	    $excel->setActiveSheetIndex(0)->setCellValue('BZ2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CA2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('CB2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CC2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CD2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CE2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CF2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CG2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CH2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CI2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CJ2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('CK2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CL2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CM2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CN2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CO2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CP2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CQ2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CR2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CS2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('CT2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CU2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CV2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('CW2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('CX2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('CY2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('CZ2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DA2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('DB2', "TOL");
	    $excel->setActiveSheetIndex(0)->setCellValue('DC2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DD2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('DE2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DF2', "KM");
	    $excel->setActiveSheetIndex(0)->setCellValue('DG2', "Jumlah SPJ");
	    $excel->setActiveSheetIndex(0)->setCellValue('DH2', "Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('DI2', "Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DJ2', "BBM");
	    $excel->setActiveSheetIndex(0)->setCellValue('DK2', "TOL ");
	    $excel->setActiveSheetIndex(0)->setCellValue('DL2', "Uang Jalan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DM2', "Tambahan Uang Saku");
	    $excel->setActiveSheetIndex(0)->setCellValue('DN2', "Tambahan Uang Makan");
	    $excel->setActiveSheetIndex(0)->setCellValue('DO2', "KM");

	    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('AA1')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('AA2')->applyFromArray($style_col); // Set width kolom A
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
		$excel->getActiveSheet()->getStyle('BA1')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('BB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BR1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BS1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BT1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BU1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BV1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BW1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BX1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BY1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BZ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BA2')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('BB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BO2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BP2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BQ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BR2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BS2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BT2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BU2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BV2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BW2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BX2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BY2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('BZ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CA1')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('CB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CP1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CQ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CR1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CS1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CT1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CU1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CV1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CW1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CX1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CY1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CZ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CA2')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('CB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CO2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CP2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CQ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CR2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CS2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CT2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CU2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CV2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CW2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CX2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CY2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('CZ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DA1')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('DB1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DC1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DD1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DE1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DF1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DG1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DH1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DI1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DJ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DK1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DL1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DM1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DN1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DO1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DZ1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DA2')->applyFromArray($style_col); // Set width kolom A
		$excel->getActiveSheet()->getStyle('DB2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DC2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DD2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DE2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DF2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DG2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DH2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DI2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DJ2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DK2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DL2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DM2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DN2')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('DO2')->applyFromArray($style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CK')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CL')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CM')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CN')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CO')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CP')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CQ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CR')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CS')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CT')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CU')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CV')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CW')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CX')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CY')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('CZ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DA')->setWidth(20); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('DB')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DC')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DD')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DE')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DF')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DG')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DH')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DI')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DJ')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DK')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DL')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DM')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DN')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('DO')->setWidth(20);


		$numrow = 3;
		foreach ($data as $key) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $key->NIK);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $key->NAMA);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $key->JANUARI_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $key->JANUARI_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $key->JANUARI_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $key->JANUARI_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $key->JANUARI_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $key->JANUARI_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $key->JANUARI_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $key->JANUARI_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $key->JANUARI_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $key->FEBRUARI_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $key->FEBRUARI_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $key->FEBRUARI_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $key->FEBRUARI_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $key->FEBRUARI_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $key->FEBRUARI_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $key->FEBRUARI_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $key->FEBRUARI_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $key->FEBRUARI_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $key->MARET_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $key->MARET_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $key->MARET_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, $key->MARET_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $key->MARET_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $key->MARET_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AA'.$numrow, $key->MARET_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, $key->MARET_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, $key->MARET_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, $key->APRIL_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, $key->APRIL_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, $key->APRIL_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, $key->APRIL_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $key->APRIL_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, $key->APRIL_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$numrow, $key->APRIL_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AK'.$numrow, $key->APRIL_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AL'.$numrow, $key->APRIL_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('AM'.$numrow, $key->MEI_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('AN'.$numrow, $key->MEI_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AO'.$numrow, $key->MEI_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AP'.$numrow, $key->MEI_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$numrow, $key->MEI_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('AR'.$numrow, $key->MEI_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AS'.$numrow, $key->MEI_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AT'.$numrow, $key->MEI_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AU'.$numrow, $key->MEI_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('AV'.$numrow, $key->JUNI_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('AW'.$numrow, $key->JUNI_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('AX'.$numrow, $key->JUNI_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('AY'.$numrow, $key->JUNI_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('AZ'.$numrow, $key->JUNI_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('BA'.$numrow, $key->JUNI_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BB'.$numrow, $key->JUNI_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BC'.$numrow, $key->JUNI_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BD'.$numrow, $key->JUNI_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('BE'.$numrow, $key->JULI_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('BF'.$numrow, $key->JULI_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BG'.$numrow, $key->JULI_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BH'.$numrow, $key->JULI_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('BI'.$numrow, $key->JULI_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('BJ'.$numrow, $key->JULI_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BK'.$numrow, $key->JULI_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BL'.$numrow, $key->JULI_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BM'.$numrow, $key->JULI_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('BN'.$numrow, $key->AGUSTUS_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('BO'.$numrow, $key->AGUSTUS_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BP'.$numrow, $key->AGUSTUS_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BQ'.$numrow, $key->AGUSTUS_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('BR'.$numrow, $key->AGUSTUS_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('BS'.$numrow, $key->AGUSTUS_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BT'.$numrow, $key->AGUSTUS_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BU'.$numrow, $key->AGUSTUS_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BV'.$numrow, $key->AGUSTUS_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('BW'.$numrow, $key->SEPTEMBER_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('BX'.$numrow, $key->SEPTEMBER_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('BY'.$numrow, $key->SEPTEMBER_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('BZ'.$numrow, $key->SEPTEMBER_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('CA'.$numrow, $key->SEPTEMBER_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('CB'.$numrow, $key->SEPTEMBER_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CC'.$numrow, $key->SEPTEMBER_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CD'.$numrow, $key->SEPTEMBER_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CE'.$numrow, $key->SEPTEMBER_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('CF'.$numrow, $key->OKTOBER_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('CG'.$numrow, $key->OKTOBER_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CH'.$numrow, $key->OKTOBER_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CI'.$numrow, $key->OKTOBER_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('CJ'.$numrow, $key->OKTOBER_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('CK'.$numrow, $key->OKTOBER_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CL'.$numrow, $key->OKTOBER_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CM'.$numrow, $key->OKTOBER_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CN'.$numrow, $key->OKTOBER_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('CO'.$numrow, $key->NOVEMBER_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('CP'.$numrow, $key->NOVEMBER_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CQ'.$numrow, $key->NOVEMBER_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CR'.$numrow, $key->NOVEMBER_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('CS'.$numrow, $key->NOVEMBER_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('CT'.$numrow, $key->NOVEMBER_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CU'.$numrow, $key->NOVEMBER_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CV'.$numrow, $key->NOVEMBER_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('CW'.$numrow, $key->NOVEMBER_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('CX'.$numrow, $key->DESEMBER_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('CY'.$numrow, $key->DESEMBER_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('CZ'.$numrow, $key->DESEMBER_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DA'.$numrow, $key->DESEMBER_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('DB'.$numrow, $key->DESEMBER_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('DC'.$numrow, $key->DESEMBER_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DD'.$numrow, $key->DESEMBER_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('DE'.$numrow, $key->DESEMBER_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DF'.$numrow, $key->DESEMBER_KM);
			$excel->setActiveSheetIndex(0)->setCellValue('DG'.$numrow, $key->TOTAL_JML_SPJ);
			$excel->setActiveSheetIndex(0)->setCellValue('DH'.$numrow, $key->TOTAL_TOTAL_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('DI'.$numrow, $key->TOTAL_TOTAL_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DJ'.$numrow, $key->TOTAL_TOTAL_BBM);
			$excel->setActiveSheetIndex(0)->setCellValue('DK'.$numrow, $key->TOTAL_TOTAL_TOL);
			$excel->setActiveSheetIndex(0)->setCellValue('DL'.$numrow, $key->TOTAL_TOTAL_JALAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DM'.$numrow, $key->TOTAL_TAMBAHAN_UANG_SAKU);
			$excel->setActiveSheetIndex(0)->setCellValue('DN'.$numrow, $key->TOTAL_TAMBAHAN_UANG_MAKAN);
			$excel->setActiveSheetIndex(0)->setCellValue('DO'.$numrow, $key->TOTAL_KM);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
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
			$excel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AQ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AR'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AS'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AT'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AU'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AV'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AW'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AX'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AY'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('AZ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BA'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BB'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BC'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BD'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BE'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BF'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BG'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BH'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BI'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BJ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BK'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BL'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BM'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BN'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BO'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BP'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BQ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BR'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BS'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BT'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BU'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BV'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BW'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BX'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BY'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('BZ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CA'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CB'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CC'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CD'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CE'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CF'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CG'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CH'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CI'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CJ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CK'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CL'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CM'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CN'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CO'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CP'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CQ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CR'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CS'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CT'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CU'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CV'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CW'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CX'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CY'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('CZ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DA'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DB'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DC'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DD'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DE'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DF'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DG'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DH'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DI'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DJ'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DK'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DL'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DM'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DN'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$excel->getActiveSheet()->getStyle('DO'.$numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode("#,##0");
			$numrow++;
		}


		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("Monitoring Monthly Marketing");
	    $excel->setActiveSheetIndex(0);
	    // Proses file excel


	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename=Monitoring-monthly-marketing.xlsx'); // Set nama file excel nya
	    header('Cache-Control: max-age=0');
	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    $write->save('php://output');
	}
	public function getDetailTujuanMarketing()
	{
		$tahun = $this->input->get("tahun");
		$data['data'] = $this->M_Monitoring->getMonitoringTujuanMarketingMonthly($tahun)->result();
		$this->load->view("monitoring/detail_tujuan_marketing/export", $data);
	}

}
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPJ</title>
	<style type="text/css">
        .judulPDF{
                text-align: center;
                font-size: 14px;

                border-color: black;
                border-bottom: solid;
                border-top: none;
                border-right: none;
                border-left: none;
                
        }
        .judulSeksi{
            font-family: sans-serif;
            color: #232323;
            border-collapse: collapse;
            /*padding: 1px 1px 1px 1px; */ 
            margin-top: 0px; 
            font-size: 11px; 
            width: 100%;
            text-align: center;
            font-weight: bold;
        }
        .table {
	            font-family: sans-serif;
	            color: #232323;
	            border-collapse: collapse;
	            /*padding: 1px 1px 1px 1px; */ 
	            margin-top: 0px; 
	           	font-size: 9px; 
	            border: 0.5px;
	            border-style: solid;
	            /*page-break-inside: avoid;*/
	            /*page-break-after: always;*/
	        }                 
        .table th td {
            border: 1px solid black;
            padding: 2px 3px 2px 3px;
        }
        .table-isi{
            font-family: sans-serif;
            color: #232323;
            /*padding: 1px 1px 1px 1px; */ 
            margin-top: 0px; 
            font-size: 9px; 
            width: 100%;
            border-color: white;
            border-collapse: collapse;
        }
        .judulIsi{
           width: 24%;
        }
        .titiDua{
           width: 1%;
        }
        .isiTabel{
           width: 75%;
        }
        .isiTabel2{
           width: 37.5%;
        }
        .break{
          page-break-inside: avoid;
          page-break-after: auto;
          /*text-align: center;*/
        }
        .text-center{
                text-align: center;
        }
        .roShit {
          display: -ms-flexbox;
          display: flex;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          margin-right: -7.5px;
          margin-left: -7.5px;
          padding-bottom: 0px;
        }
	</style>
</head>
<body>
	<div style="text-align: left; font-size: 11px">
	    <b>PT. Karya Putra Sangkuriang</b>
	</div>
	<div class="roShit" style="padding-bottom: -70px;">
		<table class="table" border="0" width="74%" style="border: 1px solid white">
			<tr>
				<td class="text-center" width="75%" style="font-size: 14px"><b>SURAT PERINTAH PERJALANAN DINAS (SPPD)</b></td>
				<td class="text-center" width="25%" style="padding:0px; text-align: right;">
					<?php if (file_exists('./assets/image/qrcode/'.$nama.'.png')): ?>
						<img src="<?=base_url()?>assets/image/qrcode/<?=$nama?>.png" style="width: 90px; height: 90px;">
					<?php endif ?>
				</td>
			</tr>
		</table>
		<table class="table text-center" width="100%" border="1" style="padding-left: 75%; padding-top: 5px;">
			<tr>
				<td>Validasi Cap</td>
			</tr>
			<tr>
				<td style="height: 50px;"></td>
			</tr>
			<tr>
				<td>Pengaju</td>
			</tr>
		</table>
	</div>
	<?php foreach ($data as $key): ?>
		<table class="table-isi" border="0" width="100%">
			<tr>
				<td width="12%" style="font-weight: bold;">Jenis SPJ</td>
				<td width="1%" style="font-weight: bold;">:</td>
				<td width="20.3333%"><?=$key->NAMA_JENIS?></td>
				<td width="12%" style="font-weight: bold;">Tanggal SPJ</td>
				<td width="1%" style="font-weight: bold;">:</td>
				<td width="20.3333%"><?=$key->TGL_SPJ?></td>
				<td width="12%" style="font-weight: bold;">No SPJ</td>
				<td width="1%" style="font-weight: bold;">:</td>
				<td width="20.3333%"><?=$key->NO_SPJ?></td>
			</tr>
			<tr>
				<td style="font-weight: bold;">Kendaraan</td>
				<td>:</td>
				<td><?=$key->KENDARAAN?></td>
				<td style="font-weight: bold;">Jenis Kendaraan</td>
				<td>:</td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td style="font-weight: bold;">No Inventaris</td>
				<td>:</td>
				<td><?=$key->NO_INVENTARIS?></td>
			</tr>
			<tr>
				<td style="font-weight: bold;">Merk</td>
				<td>:</td>
				<td><?=$key->MERK?></td>
				<td style="font-weight: bold;">Type</td>
				<td>:</td>
				<td><?=$key->TYPE?></td>
				<td style="font-weight: bold;">No TNKB</td>
				<td>:</td>
				<td><?=$key->NO_TNKB?></td>
			</tr>
		</table>
		<br>
		<table class="table-isi" border="0" width="100%">
			<tr>
				<td width="12%" style="font-weight: bold;">Tujuan</td>
				<td width="1%" style="font-weight: bold;">:</td>
				<td width="87%">
					<?php 
					$noLokasi = 1;
					$totalLokasi = count($tujuan);
					foreach ($tujuan as $lok): ?>
						<?=$lok->SERLOK_KOTA?>
						<?php if ($noLokasi < $totalLokasi): ?>
							<?=', '?>
						<?php endif ?>

					<?php $noLokasi++; endforeach ?>
				</td>
			</tr>
		</table>

	<?php endforeach ?>
	<div class="roShit" style="background-color: red">
		<table class="table" border="1" width="64%">
			<tr class="text-center">
				<th>Objek</th>
				<th>Nama/Perusahaan</th>
				<th>Kota/Kabupaten</th>
				<th>Group Tujuan</th>
			</tr>
			<?php foreach ($lokasi as $lok2): ?>
				<tr>
					<td><?=$lok2->OBJEK?></td>
					<td><?=$lok2->SERLOK_COMPANY?></td>
					<td><?=$lok2->SERLOK_KOTA?></td>
					<td><?=$lok2->NAMA_GROUP?></td>
				</tr>
			<?php endforeach ?>
		</table>
		<table class="table-isi" width="99%" border="0" style="padding-left: 65%;">
			<tr class="text-center">
				<td></td>
				<td style="border: 1px solid black;">Rp.</td>
				<td style="border: 1px solid black;">Media</td>
			</tr>
			<tr>
				<td>Uang Saku</td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
				<td class="text-center"><?=$key->MEDIA_UANG_SAKU?></td>
			</tr>
			<tr>
				<td>Uang Makan</td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
				<td class="text-center"><?=$key->MEDIA_UANG_MAKAN?></td>
			</tr>
			<tr>
				<td>Uang Jalan</td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
				<td class="text-center"><?=$key->MEDIA_UANG_JALAN?></td>
			</tr>
			<tr>
				<td>Uang BBM</td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
				<td class="text-center"><?=$key->MEDIA_UANG_BBM?></td>
			</tr>
			<tr>
				<td>Uang TOL</td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
				<td class="text-center"><?=$key->MEDIA_UANG_TOL?></td>
			</tr>
			<?php if ($key->STATUS_PERJALANAN == 'IN'): ?>
				<tr>
					<td>Uang Saku Ke-2</td>
					<td class="text-center"><?=str_replace(',', '.', number_format($key->US1+$key->US2, 0))?></td>
					<td class="text-center"></td>
				</tr>
				<tr>
					<td>Uang Makan Ke-2</td>
					<td class="text-center"><?=str_replace(',', '.', number_format($key->UM, 0))?></td>
					<td class="text-center"></td>
				</tr>
			<?php endif ?>
			<tr>
				<td><b>Jumlah</b></td>
				<td class="text-center" style="border-top: 1px solid black;"><b><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL+$key->TOTAL_UANG_SAKU+$key->TOTAL_UANG_MAKAN+$key->TOTAL_UANG_JALAN+$key->TOTAL_UANG_BBM, 0))?></b></td>

			</tr>
			<tr>
				<td><b>Aktual</b><span style="font-size: 11px; color: white">i</span></td>
				<td style="border: 1px solid black;" colspan="2"></td>
			</tr>
		</table>
	</div>
	<table class="table" width="100%" border="1">
		<tr class="text-center">
			<td>PIC</td>
			<td>Subjek</td>
			<td>NIK</td>
			<td>Nama</td>
			<td>Departemen</td>
			<td>Sub Departemen</td>
			<td>Jabatan</td>
			<td>Tujuan</td>
			<td>Uang Saku</td>
			<td>Uang Makan</td>
		</tr>
		<tr class="text-center">
	        <td>Driver</td>
	        <td><?=$key->OBJEK?></td>
	        <td><?=$key->NIK_DRIVER?></td>
	        <td><?=$key->NAMA_DRIVER?></td>
	        <td><?=$key->DEPARTEMEN_DRIVER?></td>
	        <td><?=$key->SUB_DEPARTEMEN_DRIVER?></td>
	        <td><?=$key->JABATAN_DRIVER?></td>
	        <td>Reguler</td>
	        <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_SAKU, 0))?></td>
	        <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_MAKAN, 0))?></td>
	    </tr>
		<?php foreach ($pic as $pc): ?>
	        <tr class="text-center">
	          <td>Pendamping</td>
	          <td><?=$pc->OBJEK?></td>
	          <td><?=$pc->NIK_DRIVER?></td>
	          <td><?=$pc->NAMA_DRIVER?></td>
	          <td><?=$pc->DEPARTEMEN_DRIVER?></td>
	          <td><?=$pc->SUB_DEPARTEMEN_DRIVER?></td>
	          <td><?=$pc->JABATAN_DRIVER?></td>
	          <td><?=$pc->SORTIR == 'Y'?'Sortir':'Reguler'?></td>
	          <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU, 0))?></td>
	          <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?></td>
	        </tr>
	    <?php endforeach ?>
	    <tr style="font-weight: bold;">
	    	<td colspan="8" style="text-align: right; font-weight: bold;">Total:</td>
	    	<td class="text-center">Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
	    	<td class="text-center">Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
	    </tr>
	</table>
	<br>
	<table class="table" border="1" width="100%">
		<tr class="text-center">
			<td rowspan="2" width="10%" style="border: 1px solid white"></td>
			<td rowspan="2" width="1%" style="border: 1px solid white"></td>
			<td colspan="2" width="20%" height="15px">Rencana</td>
			<td colspan="2" width="20%">Aktual</td>
			<td rowspan="2" width="9%">KM</td>
			<td rowspan="4" width="20%" style="border: 1px solid white"></td>
			<td colspan="2" width="20%">Validasi & Cap Security</td>
		</tr>
		<tr class="text-center">
			<td height="15px">Tanggal</td>
			<td>Jam</td>
			<td>Tanggal</td>
			<td>Jam</td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>
		<tr>
			<td style="border: 1px solid white">Keberangkatan</td>
			<td style="border: 1px solid white">:</td>
			<td class="text-center" height="15px"><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
			<td class="text-center"><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
		</tr>
		<tr>
			<td style="border: 1px solid white">Kepulangan</td>
			<td style="border: 1px solid white">:</td>
			<td class="text-center" height="15px"><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
			<td class="text-center"><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
			<td class="text-center"></td>
			<td class="text-center">Out</td>
			<td class="text-center">In</td>
		</tr>
	</table>
</body>
</html>
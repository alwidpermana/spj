<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pegawai.xls");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Export Detail Tujuan Marketing</title>
</head>
<body>
	<table border="1">
		<tr class="text-center bg-gray">
			<th rowspan="3">No</th>
			<th rowspan="3">NIK</th>
			<th rowspan="3">Nama</th>
			<th colspan="3">Januari</th>
			<th colspan="3">Februari</th>
			<th colspan="3">Maret</th>
			<th colspan="3">April</th>
			<th colspan="3">Mei</th>
			<th colspan="3">Juni</th>
			<th colspan="3">Juli</th>
			<th colspan="3">Agustus</th>
			<th colspan="3">September</th>
			<th colspan="3">Oktober</th>
			<th colspan="3">November</th>
			<th colspan="3">Desember</th>
		</tr>
		<tr class="text-center bg-gray">
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr class="text-center bg-gray">
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
		</tr>
		<?php 
		$noMarketing = '';
		foreach ($data as $key): ?>
			<tr>
				<?php if ($noMarketing != $key->NO_MARKETING): ?>
					<td><?=$key->NO_MARKETING?></td>
					<td><?=$key->NIK?></td>
					<td><?=str_replace(' ', '&nbsp;', $key->NAMA)?></td>
				<?php else: ?>
					<td></td>
					<td></td>
					<td></td>	
				<?php endif ?>
				<td><?=$key->JANUARI_COMPANY?></td>
				<td><?=$key->JANUARI_KOTA?></td>
				<td><?=$key->JANUARI_JML?></td>
				<td><?=$key->FEBRUARI_COMPANY?></td>
				<td><?=$key->FEBRUARI_KOTA?></td>
				<td><?=$key->FEBRUARI_JML?></td>
				<td><?=$key->MARET_COMPANY?></td>
				<td><?=$key->MARET_KOTA?></td>
				<td><?=$key->MARET_JML?></td>
				<td><?=$key->APRIL_COMPANY?></td>
				<td><?=$key->APRIL_KOTA?></td>
				<td><?=$key->APRIL_JML?></td>
				<td><?=$key->MEI_COMPANY?></td>
				<td><?=$key->MEI_KOTA?></td>
				<td><?=$key->MEI_JML?></td>
				<td><?=$key->JUNI_COMPANY?></td>
				<td><?=$key->JUNI_KOTA?></td>
				<td><?=$key->JUNI_JML?></td>
				<td><?=$key->JULI_COMPANY?></td>
				<td><?=$key->JULI_KOTA?></td>
				<td><?=$key->JULI_JML?></td>
				<td><?=$key->AGUSTUS_COMPANY?></td>
				<td><?=$key->AGUSTUS_KOTA?></td>
				<td><?=$key->AGUSTUS_JML?></td>
				<td><?=$key->SEPTEMBER_COMPANY?></td>
				<td><?=$key->SEPTEMBER_KOTA?></td>
				<td><?=$key->SEPTEMBER_JML?></td>
				<td><?=$key->OKTOBER_COMPANY?></td>
				<td><?=$key->OKTOBER_KOTA?></td>
				<td><?=$key->OKTOBER_JML?></td>
				<td><?=$key->NOVEMBER_COMPANY?></td>
				<td><?=$key->NOVEMBER_KOTA?></td>
				<td><?=$key->NOVEMBER_JML?></td>
				<td><?=$key->DESEMBER_COMPANY?></td>
				<td><?=$key->DESEMBER_KOTA?></td>
				<td><?=$key->DESEMBER_JML?></td>
			</tr>
		<?php $noMarketing = $key->NO_MARKETING; endforeach ?>
	</table>
</body>
</html>
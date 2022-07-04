<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Tanggal Input</th>
			<th rowspan="2">No SPJ</th>
			<th rowspan="2">Tanggal SPJ</th>
			<th rowspan="2">No Barcode</th>
			<th rowspan="2">No Voucher BBM</th>
			<th colspan="2">Tujuan</th>
			<th colspan="2">PIC</th>
			<th colspan="6">Kendaraan</th>
			<th rowspan="2">Rp</th>
			<th rowspan="2">Status</th>
		</tr>
		<tr>
			<th>Group Tujuan</th>
			<th>Tujuan</th>
			<th>Driver</th>
			<th>Pendamping</th>
			<th>Kendaraan</th>
			<th>Jenis</th>
			<th>No Inventaris</th>
			<th>Merk</th>
			<th>Type</th>
			<th>No TNKB</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$key->TGL_INPUT?></td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->QR_CODE?></td>
				<td><?=$key->VOUCHER_BBM?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td>
					<ul style="padding-left: 10px">
					<?php foreach ($tujuan as $lok): ?>
						<?php if ($lok->NO_SPJ == $key->NO_SPJ): ?>
							<li><?=$lok->SERLOK_KOTA?></li>
						<?php endif ?>
					<?php endforeach ?>
					</ul>
				</td>
				<td><?=$key->PIC_DRIVER?></td>
				<td>
					<ul style="padding-left: 10px">
					<?php foreach ($pic as $pc): ?>
						<?php if ($pc->NO_PENGAJUAN == $key->NO_SPJ): ?>
							<li><?=$pc->PIC?></li>
						<?php endif ?>
					<?php endforeach ?>
					</ul>
				</td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td><?=$key->NO_INVENTARIS?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NO_TNKB?></td>
				<td>
					<a 
						href="javascript:;"
						noVoucher = "<?=$key->VOUCHER_BBM?>"
						noSPJ = "<?=$key->NO_SPJ?>"
						idSPJ = "<?=$key->ID_SPJ?>"
						credit = "<?=round($key->TOTAL_UANG_BBM)?>"
						style="display: block; text-decoration: none;"
						class="text-kps text-warning text-center getVoucher">
						<?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?>
					</a>		
				</td>
				<td><?=$key->STATUS_SPJ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': false,
            order: [[0, 'asc']],
            info: false, 
            
          } ); 
	});
</script>
<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="bg-gray text-center">
		<tr>
			<td rowspan="2">No</td>
			<td rowspan="2">Tanggal Input</td>
			<td rowspan="2">No SPJ</td>
			<td rowspan="2">Tanggal SPJ</td>
			<td rowspan="2">No Barcode</td>
			<td rowspan="2">Transaksi</td>
			<?php if ($jenis == 'BBM'): ?>
				<td rowspan="2">No Voucher BBM</td>	
			<?php endif ?>
			<td colspan="2">Tujuan</td>
			<td colspan="2">PIC</td>
			<td colspan="6">Kendaraan</td>
			<td colspan="3">Kasbon</td>
			<td rowspan="2">Status</td>
		</tr>
		<tr>
			<td>Group Tujuan</td>
			<td>Tujuan</td>
			<td>Driver</td>
			<td>Pendamping</td>
			<td>Kendaraan</td>
			<td>Jenis</td>
			<td>No Inventaris</td>
			<td>Merk</td>
			<td>Type</td>
			<td>No TNKB</td>
			<td>Debit</td>
			<td>Credit</td>
			<td>Saldo</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$i++?></td>
				<td><?=date('Y-m-d', strtotime($key->TGL_TRANSAKSI))?></td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=$key->JENIS_TRANSAKSI == 'SPJ'?date('Y-m-d', strtotime($key->TGL_SPJ)):''?></td>
				<td><?=$key->QR_CODE?></td>
				<td><?=$key->JENIS_TRANSAKSI?></td>
				<?php if ($jenis == 'BBM'): ?>
					<td><?=$key->VOUCHER_BBM?></td>
				<?php endif ?>
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
				<td><?=str_replace(',', '.', number_format($key->DEBIT, 0))?></td>
				<td>
					<?=str_replace(',', '.', number_format($key->CREDIT, 0))?>
						
				</td>
				<td><?=str_replace(',', '.', number_format($key->SALDO, 0))?></td>
				<td><?=$key->STATUS?></td>
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
            'ordering': false,
            order: [[0, 'asc']],
            info: false, 
            
          } ); 
	});
</script>
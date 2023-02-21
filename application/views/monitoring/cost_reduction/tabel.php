<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Tanggal SPJ</th>
			<th rowspan="2">No SPJ</th>
			<th rowspan="2">Status SPJ</th>
			<th colspan="4">Kendaraan</th>
			<th colspan="2">Group Tujuan</th>
			<th colspan="2">PIC</th>
			<th rowspan="2">Abnormal</th>
			<th colspan="3">Biaya Uang Jalan</th>
		</tr>
		<tr>
			<th>Kendaraan</th>
			<th>No TNKB</th>
			<th>Merk</th>
			<th>Type</th>
			<th>Nama Group</th>
			<th>Tujuan</th>
			<th>Driver</th>
			<th>Pendamping</th>
			<th>Normal</th>
			<th>Aktual</th>
			<th>GAP</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		$aktual = 0;
		$normal = 0;
		$gap = 0;
		foreach ($data as $key): 
			$aktual += $key->AKTUAL_UANG_JALAN;
			$normal += $key->NORMAL_UANG_JALAN;
			$gap += $key->GAP;
		?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=$key->STATUS_SPJ?></td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->NO_TNKB?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td><?=$key->LOKASI?></td>
				<td><?=$key->NIK_DRIVER.'<br>'.$key->NAMA_DRIVER?></td>
				<td><?=$key->NIK_PENDAMPING.'<br>'.$key->NAMA_PENDAMPING?></td>
				<td class="text-center">
					<?php if ($key->ABNORMAL == 'Y'): ?>
						<span class="badge bg-danger">Yes</span>
					<?php endif ?>
				</td>
				<td><?=number_format($key->NORMAL_UANG_JALAN)?></td>
				<td><?=number_format($key->AKTUAL_UANG_JALAN)?></td>
				<td><?=number_format($key->GAP)?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="13" class="text-right">Total:</th>
			<th><?=number_format($aktual)?></th>
			<th><?=number_format($normal)?></th>
			<th><?=number_format($gap)?></th>
		</tr>
	</tfoot>
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
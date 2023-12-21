<table class="table table-hover table-bordered table-striped " id="datatable">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Tanggal Input</th>
			<th rowspan="2">No SPJ</th>
			<th rowspan="2">Tanggal SPJ</th>
			<th rowspan="2">QR Code</th>
			<th rowspan="2">Abnormal</th>
			<th colspan="6">Kendaraan</th>
			<th rowspan="2">Group Tujuan</th>
			<th rowspan="2">Driver</th>
			<th colspan="7">Biaya Reguler</th>
			<th colspan="4">Biaya Tambahan</th>
			<th rowspan="2">Total Biaya</th>
			<th colspan="2">Aktual Berangkat</th>
			<th colspan="2">Aktual Pulang</th>
			<th rowspan="2">Status</th>
		</tr>
		<tr>
			<th>Kendaraan</th>
			<th>Jenis</th>
			<th>No Inventaris</th>
			<th>Merk</th>
			<th>Type</th>
			<th>No TNKB</th>
			<th>Uang Saku</th>
			<th>Uang Makan</th>
			<th>Uang Jalan</th>
			<th>BBM</th>
			<th>TOL</th>
			<th>Kendaraan</th>
			<th>Jumlah</th>
			<th>Uang Saku 1 - 3</th>
			<th>Uang Saku 1 &ge; 4</th>
			<th>Makan Ke 2</th>
			<th>Jumlah</th>
			<th>Tanggal</th>
			<th>jam</th>
			<th>Tanggal</th>
			<th>Jam</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_URUT?></td>
				<td><?=date("d-m-Y", strtotime($key->TGL_INPUT))?></td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->QR_CODE?></td>
				<td><?=$key->ABNORMAL == 'Y'?'<span class="badge bg-danger">Yes</span>':''?></td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td><?=$key->NO_INVENTARIS?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NO_TNKB?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td><?=$key->NIK_DRIVER.' '.$key->NAMA_DRIVER?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_KENDARAAN, 0))?></td>
				<td>
					<?php
						$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_BBM + $key->TOTAL_UANG_TOL+$key->TOTAL_UANG_KENDARAAN;
						echo str_replace(',','.', number_format($total));
					?>
				</td>
				<td><?=$key->KEPUTUSAN_US1 == 'OK'?str_replace(',', '.', number_format($key->US1, 0)):''?></td>
				<td><?=$key->KEPUTUSAN_US2 == 'OK'?str_replace(',', '.', number_format($key->US2, 0)):''?></td>
				<td><?=$key->KEPUTUSAN_MAKAN == 'OK'?str_replace(',', '.', number_format($key->UM, 0)):''?></td>
				<td>
					<?php
						$us1 = $key->KEPUTUSAN_US1 == 'OK'? $key->US1:0;
						$us2 = $key->KEPUTUSAN_US2 == 'OK'?$key->US2:0;
						$um= $key->KEPUTUSAN_MAKAN == 'OK'?$key->UM:0;
						$totalTambahan = $us1 + $us2 + $um;
						echo str_replace(',', '.', number_format($totalTambahan, 0));
					?>
				</td>
				<td><?=str_replace(',', '.', number_format($total+$totalTambahan, 0))?></td>
				<?php if ($key->KEBERANGKATAN == null): ?>
					<td></td>
					<td></td>
				<?php else: ?>
					<td><?=date("d-m-Y",strtotime($key->KEBERANGKATAN))?></td>
					<td><?=date("H:i",strtotime($key->KEBERANGKATAN))?></td>
				<?php endif ?>
				<?php if ($key->KEPULANGAN == null): ?>
					<td></td>
					<td></td>
				<?php else: ?>
					<td><?=date("d-m-Y",strtotime($key->KEPULANGAN))?></td>
					<td><?=date("H:i",strtotime($key->KEPULANGAN))?></td>
				<?php endif ?>
				<td class="text-center">
					<?=$key->STATUS_SPJ == 'CLOSE' && $key->NO_GENERATE == null ? 'Waiting&nbsp;For&nbsp;Generate':$key->STATUS_SPJ?>
				</td>
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
            info: false
            
          } );	
		 
	});
</script>
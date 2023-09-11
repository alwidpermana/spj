<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="3">No</th>
			<th rowspan="3">Tanggal</th>
			<th rowspan="3">No SPJ</th>
			<th rowspan="3">Status SPJ</th>
			<th rowspan="3">Nama Group</th>
			<th rowspan="3">Voucher BBM</th>
			<th rowspan="3">No Generate</th>
			<th colspan="17">Biaya</th>
		</tr>
		<tr>
			<th colspan="2">Uang Saku</th>
			<th colspan="2">Uang Makan</th>
			<th colspan="2">Uang Jalan</th>
			<th colspan="2">Uang BBM</th>
			<th colspan="2">Uang TOL</th>
			<th colspan="3">Biaya Tambahan</th>
			<th colspan="2">Uang Kendaraan</th>
			<th colspan="2">Uang Lainnya</th>
		</tr>
		<tr>
			<th>RP</th>
			<th>Media</th>
			<th>RP</th>
			<th>Media</th>
			<th>RP</th>
			<th>Media</th>
			<th>RP</th>
			<th>Media</th>
			<th>RP</th>
			<th>Media</th>
			<th>Uang Saku 1</th>
			<th>Uang Saku 2</th>
			<th>Uang Makan</th>
			<th>RP</th>
			<th>Media</th>
			<th>RP</th>
			<th>Media</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_URUT?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><a href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>" class="text-kps" target="_blank"><?=$key->NO_SPJ?></a></td>
				<td><?=$key->STATUS_SPJ?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td><?=$key->VOUCHER_BBM?></td>
				<td><?=$key->NO_GENERATE?></td>
				<td><?=number_format($key->TOTAL_UANG_SAKU)?></td>
				<td><?=$key->MEDIA_UANG_SAKU?></td>
				<td><?=number_format($key->TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->MEDIA_UANG_MAKAN?></td>
				<td><?=number_format($key->TOTAL_UANG_JALAN)?></td>
				<td><?=$key->MEDIA_UANG_JALAN?></td>
				<td><?=number_format($key->TOTAL_UANG_BBM)?></td>
				<td><?=$key->MEDIA_UANG_BBM?></td>
				<td><?=number_format($key->TOTAL_UANG_TOL)?></td>
				<td><?=$key->MEDIA_UANG_TOL?></td>
				<td><?=number_format($key->UANG_SAKU1)?></td>
				<td><?=number_format($key->UANG_SAKU2)?></td>
				<td><?=number_format($key->UANG_MAKAN)?></td>
				<td><?=number_format($key->TOTAL_UANG_KENDARAAN)?></td>
				<td><?=$key->MEDIA_UANG_KENDARAAN?></td>
				<td><?=number_format($key->TOTAL_UANG_LAINNYA)?></td>
				<td>Reimburse</td>
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
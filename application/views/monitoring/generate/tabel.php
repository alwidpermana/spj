<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="bg-gray text-center">
		<tr>
			<th rowspan="2">No</th>
			<th colspan="2">Generate</th>
			<th rowspan="2">Jumlah SPJ</th>
			<th rowspan="2">Total Rp.</th>
			<th colspan="2">Receive / Approve Finance</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>Tanggal</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=date("Y-m-d", strtotime($key->TGL_GENERATE))?></td>
				<td><?=$key->NO_GENERATE?></td>
				<td><?=$key->JML_SPJ?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_RP))?></td>
				<td><?=$key->TGL_RECEIVE?></td>
				<td><?=$key->STATUS_RECEIVE?></td>
				<td class="text-center">
					<a href="<?=base_url()?>monitoring/detail_generate/<?=$key->ID?>" class="btn btn-orange btn-kps btn-sm">
						<i class="fas fa-ellipsis-h"></i>
					</a>
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
            paging:         true,
            'searching': false,
            'ordering': true,
            order: [[0, 'asc']],
            info: true, 	            
          } ); 
	});
</script>
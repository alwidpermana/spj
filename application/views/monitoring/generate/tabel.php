<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="bg-gray text-center">
		<tr>
			<th rowspan="2">No</th>
			<th colspan="2">Generate</th>
			<th rowspan="2">Jumlah SPJ</th>
			<th rowspan="2">Total Rp.</th>
			<th colspan="3">Rincian</th>
			<th colspan="2">Receive / Approve Finance</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th>Tanggal</th>
			<th>No</th>
			<th>SPJ</th>
			<th>BBM</th>
			<th>TOL</th>
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
				<td class="text-center"><?=$key->JML_SPJ?></td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_RP))?></td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_SPJ))?></td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_BBM))?></td>
				<td class="text-center"><?=str_replace(',', '.', number_format($key->TOTAL_TOL))?></td>
				<td><?=$key->TGL_RECEIVE?></td>
				<td><?=$key->STATUS_RECEIVE?></td>
				<td class="text-center">
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/detail_generate/<?=$key->ID?>">Detail</a>
	                    	<?php if ($key->STATUS_RECEIVE == null): ?>
	                    		<a href="<?=base_url()?>monitoring/print_generate/<?=$key->ID?>" class="dropdown-item dropButton">Print</a>	
	                    	<?php endif ?>
	                    </div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml == 1) {
			var table = $('#datatable').DataTable( {
	            paging:         true,
	            'searching': false,
	            'ordering': true,
	            order: [[0, 'asc']],
	            info: true, 	            
	          } );
		}else{
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
		}
		 
	});
</script>
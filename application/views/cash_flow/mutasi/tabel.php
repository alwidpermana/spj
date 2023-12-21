<table class="table table-hover table-bordered table-striped w-100" width="100%" id="datatable">
	<thead>
		<tr>
			<th>No</th>
			<th>No Mutasi</th>
			<th>Tanggal</th>
			<th>Dari</th>
			<th>Ke</th>
			<th>Rp</th>
			<th>PIC Mutasi</th>
			<th>Tanggal Approve</th>
			<th>PIC Approve</th>
		</tr>
	</thead>
	<tbody>
		<?php 
	$no = 1;
	foreach ($data as $key): ?>
		<tr>
			<td><?=$no++?></td>
			<td><?=$key->NO_MUTASI?></td>
			<td><?=date("Y-m-d", strtotime($key->TGL_MUTASI))?></td>
			<td><?=$key->DARI?></td>
			<td><?=$key->KE?></td>
			<td><?=number_format($key->RP)?></td>
			<td><?=$key->nama_mutasi?></td>
			<?php if ($key->TGL_APPROVE == null && $key->TGL_MUTASI != NULL): ?>
				<td>
					<button type="button" class="btn bg-orange btn-kps btn-block btn-sm approve" data="<?=$key->ID?>">Approved</button>
				</td>
				<td></td>
			<?php else: ?>
				<td><?=$key->TGL_APPROVE == null ? '' : date("Y-m-d", strtotime($key->TGL_APPROVE))?></td>
				<td><?=$key->nama_approve?></td>	
			<?php endif ?>
			
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
                'searching': true,
                'ordering': true,
                "autoWidth": true,
                order: [[0, 'asc']],
                
              } );   
	})
</script>
<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th>No Voucher</th>
			<th>Rp.</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_VOUCHER?></td>
				<td>Rp. <?=str_replace(',', '.', number_format($key->RP, 0))?></td>
				<td class="text-center">
					<?php if ($key->STATUS == 'USED'): ?>
						<span class="badge bg-kps">Telah Digunakan</span>
					<?php elseif($key->STATUS == 'NOT'):?>
						<span class="badge bg-kps-success">Belum Digunakan</span>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php if ($key->STATUS == 'NOT'): ?>
						<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton edit" href="javascript:;" noVoucher= "<?=$key->NO_VOUCHER?>" voucher_id="<?=$key->ID?>" rp="<?=$key->RP?>">Edit</a>
	                    	<a class="dropdown-item dropButton hapus" href="javascript:;" noVoucher= "<?=$key->NO_VOUCHER?>" voucher_id="<?=$key->ID?>">Hapus</a>
	                    </div>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml>1) {
			var table = $('#datatable').DataTable( {
	            scrollY:        "350px",
	            scrollX:        true,
	            scrollCollapse: true,
	            paging:         false,
	            'searching': false,
	            order: [[0, 'desc']],
	            info: true,  
	            
	            
	          } );
		} else {

		}
		 
	});
</script>
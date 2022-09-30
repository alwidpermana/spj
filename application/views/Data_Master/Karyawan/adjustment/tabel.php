<table class="table table-striped table-bordered table-hover" id="datatable" width="100%">
	<thead>
		<tr>
			<th>NIK</th>
			<th>Nama</th>
			<th>Jabatan</th>
			<th>Departemen</th>
			<th>Adjustment?</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NIK?></td>
				<td><?=$key->NAMA?></td>
				<td><?=$key->JABATAN?></td>
				<td><?=$key->DEPARTEMEN?></td>
				<td>
					<select class="select2 form-control select2-orange inputAdjustment" data-dropdown-css-class="select2-orange" nik="<?=$key->NIK?>">
						<option value="Y" <?=$key->OTORITAS_ADJUSMENT=='Y'?'selected':''?>>Ya</option>
						<option value="N" <?=$key->OTORITAS_ADJUSMENT=='N'?'selected':''?>>Tidak</option>
					</select>
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
            order: [[0, 'asc']],
            info: false,  
          } ); 
	});
</script>
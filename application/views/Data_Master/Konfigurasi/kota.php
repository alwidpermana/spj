<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
	<thead>
		<tr>
			<td>Tipe</td>
			<td>Nama Daerah</td>
			<td>Provinsi</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->TIPE_KOTA?></td>
				<td><?=$key->NAMA_KOTA?></td>
				<td><?=$key->PROVINSI?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            order: [[1, 'asc']],
          } ); 
	});
</script>
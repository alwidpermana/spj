<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Kepemilikan Kendaraan / Rekanan</th>
			<th colspan="31">Tanggal</th>
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr>
			<?php
				for ($i=1; $i <=31 ; $i++) { 
					echo "<td>".$i."</td>";
				}
			?>
		</tr>
	</thead>
	<tbody class="text-center">
		<?php 
		$no = 1;
		$total = 0;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$key->NAMA?></td>
				<?php
					for ($j=1; $j <= 31; $j++) { 
						$field = 'TGL_'.$j;
						$total += $key->$field;
						echo '<td>'.$key->$field.'</td>';
					}
				?>
				<td><?=$total?></td>
			</tr>
		<?php 
		$total = 0;
		endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	var table = $('#datatable').DataTable( {
	    scrollY:        "350px",
	    scrollX:        true,
	    scrollCollapse: true,
	    paging:         false,
	    'searching': true,
	    order: [[0, 'asc']],
	    info: true, 
	  } );
</script>
<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="3">No</th>
			<th colspan="93">Tanggal</th>
		</tr>
		<tr>
			<?php
				for ($i=1; $i <= 31; $i++) { 
					echo '<th colspan="3">'.$i.'</th>';
				}
			?>
		</tr>
		<tr>
			<?php
				for ($i=1; $i <= 31; $i++) { 
					echo '<th>No SPJ</th>';
					echo '<th>No TNKB</th>';
					echo '<th>Kendaraan</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_URUT?></td>
				<?php
					for ($i=1; $i <= 31; $i++) {
						$fieldSPJ = 'SPJ_'.$i;
						$fieldTNKB = 'NO_TNKB_'.$i;
						$fieldKendaraan = 'KENDARAAN_'.$i; 
						echo '<td><a href="javascript:;" class="text-dark viewSPJ" noSPJ = "'.$key->$fieldSPJ.'">'.$key->$fieldSPJ.'</a></td>';
						echo '<td>'.$key->$fieldTNKB.'</td>';
						echo '<td>'.$key->$fieldKendaraan.'</td>';
					}
				?>
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
            order: [[0, 'asc']],
            info: true, 	            
          } ); 
	});
</script>
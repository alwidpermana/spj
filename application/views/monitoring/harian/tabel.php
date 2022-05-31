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
					echo '<th>Rp.</th>';
					echo '<th>Status</th>';
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
						$fieldNo = 'NO_'.$i;
						$fieldRp = 'RP_'.$i;
						$fieldStatus = 'STATUS_'.$i; 
						echo '<td><a href="javascript:;" class="text-dark viewSPJ" noSPJ = "'.$key->$fieldNo.'">'.$key->$fieldNo.'</a></td>';
						if ($key->$fieldRp == null) {
							echo '<td></td>';
						} else {
							echo '<td>'.str_replace(',', '.', number_format($key->$fieldRp)).'</td>';
						}
						echo '<td>'.$key->$fieldStatus.'</td>';
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
            paging:         true,
            'searching': false,
            'ordering': true,
            order: [[0, 'asc']],
            info: true, 	            
          } ); 
	});
</script>

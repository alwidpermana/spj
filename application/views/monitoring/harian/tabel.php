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
		<?php
		$ok1 = 0;
		$ok2 = 0;
		$ok3 = 0;
		$ok4 = 0;
		$ok5 = 0;
		$ok6 = 0;
		$ok7 = 0;
		$ok8 = 0;
		$ok9 = 0;
		$ok10 = 0;
		$ok11 = 0;
		$ok12 = 0;
		$ok13 = 0;
		$ok14 = 0;
		$ok15 = 0;
		$ok16 = 0;
		$ok17 = 0;
		$ok18 = 0;
		$ok19 = 0;
		$ok20 = 0;
		$ok21 = 0;
		$ok22 = 0;
		$ok23 = 0;
		$ok24 = 0;
		$ok25 = 0;
		$ok26 = 0;
		$ok27 = 0;
		$ok28 = 0;
		$ok29 = 0;
		$ok30 = 0;
		$ok31 = 0;

		foreach ($data as $key): ?>
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

<table class="table table-hover table-bordered table-striped" id="datatable"  width="100%" style="font-size: 9px">
	<thead class="text-center bg-gray">
		<tr class="bg-gray">
			<th rowspan="2">No</th>
			<th colspan="6">Kendaraan</th>
			<th colspan="62">Tanggal</th>
		</tr>
		<tr class="bg-gray">
			<th>Kendaraan</th>
			<th>Jenis</th>
			<th>No Inventaris</th>
			<th>Merk</th>
			<th>Type</th>
			<th>No TNKB</th>
			<?php
				for ($i=1; $i <= 31; $i++) { 
					echo '<th>'.$i.'</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		$noSPJ = '';
		$jam = '';
		foreach ($data as $key): ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td><?=$key->NO_INVENTARIS?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NO_TNKB?></td>
				<?php
					for ($i=1; $i <= 31; $i++) {
						$noSPJ .='<ul style="padding-left: 10px">'; 
						
						foreach ($tgl as $t) {
							if ($i == $t->JALAN && $key->NO_TNKB == $t->NO_TNKB) {
								$keberangkatan = date("Y-m-d H:i:s", strtotime($t->KEBERANGKATAN));
								$kepulangan = date("Y-m-d H:i:s", strtotime($t->KEPULANGAN));
								$start = date_create($keberangkatan);
								$end = date_create($kepulangan);
								$gap = date_diff($start, $end);

								$noSPJ .= '<li style="padding-top: 5px">';
								$noSPJ.=$t->NO_SPJ;
								$noSPJ .="<br>";
								$noSPJ .=date("H:i", strtotime($t->KEBERANGKATAN)).' - '.date("H:i", strtotime($t->KEPULANGAN));
								$noSPJ .="<br>";
								$noSPJ .=' ('.$gap->h.' Jam '.$gap->i.' Menit)';
								
							}
						}
						echo "<td class='text-center'>".$noSPJ."</td>";
						$noSPJ .="</ul>";
						$noSPJ = '';
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
            fixedColumns:   {
                leftColumns: 7
            },
            info: true, 	            
          } ); 
	});
</script>
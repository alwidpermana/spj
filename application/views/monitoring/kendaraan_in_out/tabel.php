<table class="table table-hover table-bordered table-striped" id="datatable"  width="100%" style="font-size: 11px">
	<thead class="text-center bg-gray">
		<tr class="bg-gray">
			<th rowspan="2">No</th>
			<th colspan="6">Kendaraan</th>
			<th colspan="31">Tanggal</th>
			<th rowspan="2">Jumlah</th>
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
		foreach ($data as $key): 
			$jumlahSPJ = 0;
		?>
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
// '<a href="'.base_url().'monitoring/view_spj/'.$t->NO_SPJ.'" class="btn text-dark>'.$t->NO_SPJ.'</a>'
								$noSPJ .= '<li style="padding-top: 5px">';
								if ($t->ID_SPJ==0) {
									
									$noSPJ .="Tanpa SPJ";
								}else{
									$noSPJ.='<a href="'.base_url().'monitoring/view_spj/'.$t->ID_SPJ.'" class="text-dark" style="font-size:12px" target="_blank">'.$t->NO_SPJ.'</a>';
								}
								$noSPJ .="<br>";
								$noSPJ .=date("H:i", strtotime($t->KEBERANGKATAN)).'&nbsp;-&nbsp;'.date("H:i", strtotime($t->KEPULANGAN));
								$noSPJ .="<br>";
								$noSPJ .='&nbsp;('.$gap->h.'&nbsp;Jam&nbsp;'.$gap->i.'&nbsp;Menit)';
								$jumlahSPJ += 1;
							}
						}
						echo "<td class='text-center'>".$noSPJ."</td>";
						$noSPJ .="</ul>";
						$noSPJ = '';
					}
				?>
				<td><?=$jumlahSPJ?></td>
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
            fixedColumns:   {
                leftColumns: 7
            },
            info: true, 	            
          } ); 
	});
</script>
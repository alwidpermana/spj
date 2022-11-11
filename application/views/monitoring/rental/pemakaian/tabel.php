<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
					<thead class="bg-gray text-center">
						<tr>
							<th>No</th>
							<th>Kendaraan</th>
							<th>Jenis Kendaraan</th>
							<th>Merk</th>
							<th>Type</th>
							<th>No TNKB</th>
							<th>Tahun</th>
							<th>Jumlah Sewa</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						$totalSPJ = 0;
						foreach ($data as $key): 
							$totalSPJ +=$key->JML_SPJ;
						?>
							<tr>
								<td class="text-center"><?=$no++?></td>
								<td><?=$key->Kendaraan?></td>
								<td><?=$key->JenisKendaraan?></td>
								<td><?=$key->Merk?></td>
								<td><?=$key->Type?></td>
								<td><?=$key->NoTNKB?></td>
								<td><?=$key->Tahun?></td>
								<td class="text-center"><?=$key->JML_SPJ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="7" class="text-right">Total:</th>
							<th class="text-center"><?=$totalSPJ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
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
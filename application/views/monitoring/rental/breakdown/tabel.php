<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Tanggal</th>
			<th rowspan="2">Kendaraan</th>
			<th rowspan="2">Jenis Kendaraan</th>
			<th rowspan="2">Merk</th>
			<th rowspan="2">Type</th>
			<th rowspan="2">No TNKB</th>
			<th rowspan="2">Tahun</th>
			<th colspan="2">SPJ</th>
			<th colspan="2">Tujuan</th>
			<th colspan="2">Sopir</th>
			<th colspan="2">Kenek</th>
		</tr>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Group</th>
			<th>Tujuan</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>NIK</th>
			<th>Nama</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=date("d-m-Y", strtotime($key->TGL_SPJ))?></td>
				<td><?=$key->Kendaraan?></td>
				<td><?=$key->JenisKendaraan?></td>
				<td><?=$key->Merk?></td>
				<td><?=$key->Type?></td>
				<td><?=$key->NoTNKB?></td>
				<td><?=$key->Tahun?></td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=date("d-m-Y", strtotime($key->TGL_SPJ))?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td></td>
				<td><?=$key->NIK?></td>
				<td><?=$key->NAMA?></td>
				<td><?=$key->NIK_PENDAMPING?></td>
				<td><?=$key->NAMA_PENDAMPING?></td>
			</tr>
		<?php endforeach ?>
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
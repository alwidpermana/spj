<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th></th>
			<th>No TNKB</th>
			<th>Merk</th>
			<th>Type</th>
			<th>Kendaraan</th>
			<th>Rekanan</th>
			<th>Jenis</th>
			<th>Bahan Bakar</th>
			<th>BBM Per Liter</th>
			<th>Jenis Data</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td class="text-center">
					<?php if ($key->STATUS == 'VERIFIED'): ?>
						<a href="javascript:;" class="btn btn-danger btn-sm btnVerif" noTNKB = "<?=$key->NoTNKB?>" status="CANCEL" data="<?=$key->JenisData?>" style="font-size: 11px !important;">
							CANCEL
						</a>
					<?php else: ?>
						<a href="javascript:;" class="btn btn-kps bg-orange btn-sm btnVerif" noTNKB = "<?=$key->NoTNKB?>" status="VERIFIED" data="<?=$key->JenisData?>" style="font-size: 11px !important;">
							VERIFICATION
						</a>
					<?php endif ?>
				</td>
				<td><?=$key->NoTNKB?></td>
				<td><?=$key->Merk?></td>
				<td><?=$key->Type?></td>
				<td><?=$key->Jenis?></td>
				<td><?=$key->Rekanan?></td>
				<td><?=$key->Kategori?></td>
				<td><?=$key->BahanBakar?></td>
				<td><?=$key->BBMPerLiter?></td>
				<td class="text-center"><?=$key->JenisData?></td>
				<td class="text-center">
					<?php if ($key->STATUS == 'VERIFIED'): ?>
						<span class="badge bg-success">Verified</span>
					<?php elseif($key->STATUS == 'CANCEL'):?>
						<span class="badge bg-danger">Cancel</span>
					<?php else: ?>
						<span class="badge bg-orange" style="color: white !important;">Outstanding</span>
					<?php endif ?>
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
            paging:         false,
            'searching': false,
            order: [[0, 'asc']],
            info: true,  
          } ); 
	});
</script>
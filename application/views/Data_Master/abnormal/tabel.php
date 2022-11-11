<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th>No</th>
			<th>Nama Customer</th>
			<th>Alamat</th>
			<th>Biaya Abnormal</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td class="text-center"><?=$key->NO_URUT?></td>
				<td><?=$key->NamaSerlok?></td>
				<td><?=$key->Alamat?></td>
				<td id="<?=$key->KodeSerlok?>" class="text-center">
					<a href="javascript:;" class="btn text-dark pilihCustomer" kodeSerlok = "<?=$key->KodeSerlok?>" serlokID = "<?=$key->SERLOK_ID?>" nama = "<?=$key->NamaSerlok?>" biaya="<?=round($key->BIAYA)?>">
						<?=number_format($key->BIAYA)?>
					</a>
				</td>
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
        'searching': false,
        'ordering' : false,
        info: false, 
      } );
</script>
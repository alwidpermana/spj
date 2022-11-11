<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th>No TNKB</th>
			<th>Merk</th>
			<th>Type</th>
			<th>Jenis</th>
			<th>Warna</th>
			<th>Bahan Bakar</th>
			<th>BBM Per Liter</th>
			<th>Tahun</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NoTNKB?></td>
				<td><?=$key->Merk?></td>
				<td><?=$key->Type?></td>
				<td><?=$key->Kategori?></td>
				<td><?=$key->Warna?></td>
				<td><?=$key->BahanBakar?></td>
				<td><?=number_format($key->BBMPerLiter, 2)?></td>
				<td><?=$key->Tahun?></td>
				<td>
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
                   		<span class="sr-only">Toggle Dropdown</span>
                  	</button>
                  	<div class="dropdown-menu" role="menu">
                    	<a 
                    		class="dropdown-item dropButton editKendaraan" 
                    		data="<?=$key->ID?>"
                    		merk = "<?=$key->Merk?>"
                    		type="<?=$key->Type?>"
                    		jenis="<?=$key->Kategori?>"
                    		warna="<?=$key->Warna?>"
                    		bbm="<?=$key->BahanBakar?>"
                    		liter="<?=$key->BBMPerLiter?>" 
                    		noTNKB ="<?=$key->NoTNKB?>"
                    		tahun = "<?=$key->Tahun?>"
                    		href="javascript:;">
                    		Edit
                    	</a>
                    	<a 
                    		class="dropdown-item dropButton hapusKendaraan" 
                    		data="<?=$key->ID?>" 
                    		rekanan="<?=$key->REKANAN_ID?>"
                    		href="javascript:;">
                    		Hapus
                    	</a>
                    	
                  	</div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml == 1) {
			$('#datatable').DataTable({
		        "paging": true,
		        "lengthChange": true,
		        "searching": false,
		        "ordering": true,
		        "info": true,
		        "autoWidth": true,
		        scrollCollapse: true,
		      });
		}else{
			var table = $('#datatable').DataTable( {
	            scrollY:        "350px",
	            scrollX:        true,
	            scrollCollapse: true,
	            paging:         false,
	            'searching': false,
	            order: [[0, 'asc']],
	            info: false, 
	          } );	
		}
		 

	});
</script>
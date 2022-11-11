<table class="table table-hover table-bordered table-striped datatable" width="100%">
	<thead class="text-center bg-gray"> 
		<tr>
			<th>Kode Rekanan</th>
			<th>Nama Rekanan</th>
			<th>Alamat Rekanan</th>
			<th>Status</th>
			<th>Berbadan Hukum</th>
			<th>NPWP/NIK</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->KODE?></td>
				<td><?=$key->NAMA?></td>
				<td><?=$key->ALAMAT?></td>
				<td>
					<select id="inputStatus" data="<?=$key->ID?>" class="form-control">
						<option value="AKTIF" <?=$key->STATUS == 'AKTIF'?'selected':''?>>AKTIF</option>
						<option value="TIDAK AKTIF" <?=$key->STATUS == 'TIDAK AKTIF'?'selected':''?>>TIDAK AKTIF</option>
					</select>
				</td>
				<td class="text-center"><span class="badge <?=$key->BERBADAN_HUKUM == 'Y'?'bg-kps':'bg-danger'?>"><?=$key->BERBADAN_HUKUM == 'Y'?'Ya':'Tidak'?></span></td>
				<td><?=$key->NPWP_NIK?></td>
				<td class="text-center">
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
                   		<span class="sr-only">Toggle Dropdown</span>
                  	</button>
                  	<div class="dropdown-menu" role="menu">
                    	<?php if ($jenis == 'master'): ?>
                    		<a 
	                    		class="dropdown-item dropButton editRekanan" 
	                    		data="<?=$key->ID?>"
	                    		kode = "<?=$key->KODE?>"
	                    		nama="<?=$key->NAMA?>"
	                    		alamat="<?=$key->ALAMAT?>" 
	                    		hukum="<?=$key->BERBADAN_HUKUM?>"
	                    		npwp = "<?=$key->NPWP_NIK?>"
	                    		href="javascript:;">
	                    		Edit
	                    	</a>
                    	<?php endif ?>
                    	<?php if ($jenis == 'kendaraan'): ?>
                    		<a 
	                    		class="dropdown-item dropButton dataKendaraan" 
	                    		data="<?=$key->ID?>" 
	                    		nama="<?=$key->NAMA?>"
	                    		href="javascript:;">
	                    		Data Kendaraan
	                    	</a>
                    	<?php endif ?>
                    	
                  	</div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('.datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': false,
            order: [[0, 'asc']],
            info: false, 
          } ); 
	});
</script>
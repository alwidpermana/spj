<table class="table table-horvered table-striped table-bordered" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<td>NIK</td>
			<td>Nama</td>
			<td>Jenis Kelamin</td>
			<td>Jabatan</td>
			<td>Departemen</td>
			<td>Divisi</td>
			<td>Seksi</td>
			<td>Status</td>
			<td>Otoritas SPJ Delivery</td>
			<td>Otoritas Non Delivery</td>
			<?php if ($this->session->userdata("LEVEL") == 0): ?>
				<td>Level</td>
			<?php endif ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=substr($key->NIK, 4)?></td>
				<td><?=$key->namapeg?></td>
				<td><?=$key->jkelamin?></td>
				<td><?=$key->jabatan?></td>
				<td><?=$key->departemen?></td>
				<td><?=$key->divisi?></td>
				<td><?=$key->seksi?></td>
				<td>
					<select class="form-control" id="editStatusAktif" nik = "<?=$key->NIK?>">
                        <option value="AKTIF" <?=$key->STATUS=='AKTIF'?'selected':''?>>Aktif</option>
                        <option value="TIDAK AKTIF" <?=$key->STATUS=='TIDAK AKTIF'?'selected':''?>>Tidak Aktif</option>
                    </select>
				</td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="dlv<?=$key->NIK?>"
	                      class="checkOtoritas"
	                      jenis="DLV"
	                      nik="<?=substr($key->NIK, 4)?>"
	                      value="Y" <?=$key->OTORITAS_DLV=='Y'?'checked':''?>>
	                    <label for="dlv<?=$key->NIK?>"></label>
                  	</div>
				</td>
				<td>
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="ndv<?=$key->NIK?>"
	                      class="checkOtoritas"
	                      jenis="NDV"
	                      nik="<?=substr($key->NIK, 4)?>"
	                      value="Y" <?=$key->OTORITAS_NDV=='Y'?'checked':''?>>
	                    <label for="ndv<?=$key->NIK?>"></label>
                  	</div>
				</td>
				<?php if ($this->session->userdata("LEVEL") == 0): ?>
					<td>
						<select class="form-control" id="editLevel" nik="<?=$key->NIK?>">
							<option value="1" <?=$key->LEVEL == 1?'selected':''?>>1</option>
							<option value="2" <?=$key->LEVEL == 2?'selected':''?>>2</option>
							<option value="3" <?=$key->LEVEL == 3?'selected':''?>>3</option>
							<option value="4" <?=$key->LEVEL == 4?'selected':''?>>4</option>
							<option value="5" <?=$key->LEVEL == 5?'selected':''?>>5</option>
						</select>
					</td>
				<?php endif ?>
				
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         true,
            'searching': false,
            columnDefs: [
                { orderable: false, targets: 7 }
            ],
            order: [[1, 'asc']]  
              
          } ); 
	});
</script>
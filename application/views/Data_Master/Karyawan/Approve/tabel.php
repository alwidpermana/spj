<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
	<thead class="text-center">
		<tr class="bg-gray">
			<td rowspan="2"></td>
			<td rowspan="2">No</td>
			<td rowspan="2">Tanggal Input</td>
			<td rowspan="2">Rekanan</td>
			<td rowspan="2">NIK</td>
			<td rowspan="2">Nama</td>
			<td rowspan="2">Departemen</td>
			<td rowspan="2">Sub Departemen</td>
			<td rowspan="2">jabatan</td>
			<td colspan="5">Otoritas</td>
			<td colspan="3">SIM</td>
			<td rowspan="2">Status</td>
			<td rowspan="2">Foto</td>
		</tr>
		<tr class="bg-gray">
			<td>Driver</td>
			<td>Pendamping</td>
			<td>Uang Saku</td>
			<td>Uang Makan</td>
			<td>Adj</td>
			<td>No</td>
			<td>Terbit</td>
			<td>Akhir</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		foreach ($data as $key): ?>
			<tr>
				<td>
					<?php if ($key->STATUS_VERIF == 'VERIFIED'): ?>
						<a href="javascript:;" class="btn btn-danger btn-kps btnVerif" nik="<?=$key->NIK?>" data="CANCEL" style="font-size: 11px !important;">
							CANCEL
						</a>
					<?php else: ?>
						<a href="javascript:;" class="btn btn-success btn-kps-success btnVerif" nik="<?=$key->NIK?>" data="VERIFIED" style="font-size: 11px !important;">
							VERIFICATION
						</a>
					<?php endif ?>
				</td>
				<td><?=$i++?></td>
				<td><?=$key->TGL_INPUT?></td>
				<td><?=$key->NAMA_REKANAN?></td>
				<td><?=$key->NIK?></td>
				<td><?=$key->namapeg?></td>
				<td><?=$key->departemen?></td>
				<td><?=$key->Subdepartemen?></td>
				<td><?=$key->jabatan?></td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="cekDriver<?=$key->NIK?>" 
	                      name="inputDriver<?=$key->NIK?>"
	                      class="checkData"
	                      jenis="OTORITAS_DRIVER"
	                      nik="<?=$key->NIK?>"
	                      value="Y" <?=$key->OTORITAS_DRIVER=='Y'?'checked':''?>>
	                    <label for="cekDriver<?=$key->NIK?>"></label>
                  </div>
					<!-- <?php if ($key->OTORITAS_DRIVER == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	 -->
				</td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="cekPendamping<?=$key->NIK?>" 
	                      name="inputPendamping<?=$key->NIK?>"
	                      class="checkData"
	                      jenis="OTORITAS_PENDAMPING"
	                      nik="<?=$key->NIK?>"
	                      value="Y" <?=$key->OTORITAS_PENDAMPING=='Y'?'checked':''?>>
	                    <label for="cekPendamping<?=$key->NIK?>"></label>
                  	</div>
					<!-- <?php if ($key->OTORITAS_PENDAMPING == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?> -->	
				</td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="cekUangSaku<?=$key->NIK?>" 
	                      name="inputUangSaku<?=$key->NIK?>"
	                      class="checkData"
	                      jenis="OTORITAS_UANG_SAKU"
	                      nik="<?=$key->NIK?>"
	                      value="Y" <?=$key->OTORITAS_UANG_SAKU=='Y'?'checked':''?> disabled>
	                    <label for="cekUangSaku<?=$key->NIK?>"></label>
                  	</div>
					<!-- <?php if ($key->OTORITAS_UANG_SAKU == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?> -->	
				</td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="cekUangMakan<?=$key->NIK?>" 
	                      name="inputUangMakan<?=$key->NIK?>"
	                      class="checkData"
	                      jenis="OTORITAS_UANG_MAKAN"
	                      nik="<?=$key->NIK?>"
	                      value="Y" <?=$key->OTORITAS_UANG_MAKAN=='Y'?'checked':''?> disabled>
	                    <label for="cekUangMakan<?=$key->NIK?>"></label>
                  	</div>
					<!-- <?php if ($key->OTORITAS_UANG_MAKAN == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?> -->	
				</td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	                    <input 
	                      type="checkbox" 
	                      id="cekAdjustment<?=$key->NIK?>" 
	                      name="inputAdjustment<?=$key->NIK?>"
	                      class="checkData"
	                      jenis="OTORITAS_ADJUSMENT"
	                      nik="<?=$key->NIK?>"
	                      value="Y" <?=$key->OTORITAS_ADJUSMENT=='Y'?'checked':''?>>
	                    <label for="cekAdjustment<?=$key->NIK?>"></label>
                  	</div>
					<!-- <?php if ($key->OTORITAS_ADJUSMENT == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?> -->	
				</td>
				<td><?=$key->NO_SIM?></td>
				<td><?=$key->BERLAKU_TERBIT?></td>
				<td><?=$key->BERLAKU_AKHIR?></td>
				<td class="text-center">
					<?php if ($key->STATUS_VERIF == 'VERIFIED'): ?>
						<span class="badge bg-kps-success text-center"><?=$key->STATUS_VERIF?></span>
					<?php elseif($key->STATUS_VERIF == 'CANCEL'): ?>
						<span class="badge bg-kps2"><?=$key->STATUS_VERIF?></span>
					<?php else: ?>
						<?=$key->STATUS_VERIF?>
					<?php endif ?>

				</td>
				<td>
					<?php if ($key->FOTO_WAJAH != null || $key->FOTO_WAJAH != ''): ?>
						<a 
							href="javascript:;" 
							style="width: 100%; display: block;" 
							class="getGambar" 
							data="<?=$key->FOTO_WAJAH?>"
							nik = "<?=$key->NIK?>"
							nama="<?=$key->namapeg?>">
							<img src="<?=base_url()?>assets/image/foto-wajah/<?=$key->FOTO_WAJAH?>" class="img-thumbnail rounded mx-auto d-block">
						</a>
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
            paging:         true,
            'searching': false,
            order: [[1, 'asc']],
            info: false,  
            columnDefs: [
	            { orderable: false, targets: 0 }
	        ],
          } ); 

		
	});
</script>
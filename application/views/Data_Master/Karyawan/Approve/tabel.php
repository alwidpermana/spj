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
						<a href="javascript:;" class="btn btn-danger btn-kps btnVerif" nik="<?=$key->NIK?>" data="CANCEL">
							CANCEL
						</a>
					<?php else: ?>
						<a href="javascript:;" class="btn btn-success btn-kps-success btnVerif" nik="<?=$key->NIK?>" data="VERIFIED">
							VERIFICATION
						</a>
					<?php endif ?>
				</td>
				<td><?=$i++?></td>
				<td><?=$key->TGL_INPUT?></td>
				<td><?=$key->REKANAN?></td>
				<td><?=$key->NIK?></td>
				<td><?=$key->namapeg?></td>
				<td><?=$key->departemen?></td>
				<td><?=$key->Subdepartemen?></td>
				<td><?=$key->jabatan?></td>
				<td class="text-center">
					<?php if ($key->OTORITAS_DRIVER == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	
				</td>
				<td class="text-center">
					<?php if ($key->OTORITAS_PENDAMPING == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	
				</td>
				<td class="text-center">
					<?php if ($key->OTORITAS_UANG_SAKU == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	
				</td>
				<td class="text-center">
					<?php if ($key->OTORITAS_UANG_MAKAN == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	
				</td>
				<td class="text-center">
					<?php if ($key->OTORITAS_ADJUSMENT == 'Y'): ?>
						<span class="badge bg-kps-success text-center"><center><i class="fas fa-check"></i></center></span>
					<?php else: ?>
						<span class="badge bg-kps text-center"><center><i class="fas fa-times"></i></center></span>
					<?php endif ?>	
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
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         true,
            'searching': false,
            order: [[1, 'asc']],
            info: false,  
            columnDefs: [
	            { orderable: false, targets: 0 }
	        ],
            fixedColumns:   {
	         	left: 1
	        }
          } ); 

		
	});
</script>
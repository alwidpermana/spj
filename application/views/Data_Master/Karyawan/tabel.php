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
					<a href="<?=base_url()?>Data_Master/Edit_Karyawan/<?=$key->nik?>/<?=$jenis?>" class="btn bg-orange btn-kps btn-sm btn-block">
						<i class="fas fa-user-pen"></i>
					</a>
				</td>
				<td><?=$i++?></td>
				<td><?=$key->TGL_INPUT?></td>
				<td><?=$key->REKANAN?></td>
				<td><?=$key->nik?></td>
				<td><?=$key->namapeg?></td>
				<td><?=$key->departemen?></td>
				<td><?=$key->Subdepartemen1?><?=$key->Subdepartemen2 == null?'':', '.$key->Subdepartemen2?></td>
				<td><?=$key->jabatan?></td>
				<td><?=$key->OTORITAS_DRIVER == null?'N':$key->OTORITAS_DRIVER?></td>
				<td><?=$key->OTORITAS_PENDAMPING == null?'N':$key->OTORITAS_PENDAMPING?></td>
				<td><?=$key->OTORITAS_UANG_SAKU == null?'N':$key->OTORITAS_UANG_SAKU?></td>
				<td><?=$key->OTORITAS_UANG_MAKAN == null?'N':$key->OTORITAS_UANG_MAKAN?></td>
				<td><?=$key->OTORITAS_ADJUSMENT == null?'N':$key->OTORITAS_ADJUSMENT?></td>
				<td><?=$key->NO_SIM?></td>
				<td><?=$key->BERLAKU_TERBIT?></td>
				<td><?=$key->BERLAKU_AKHIR?></td>
				<td><?=$key->STATUS_VERIF?></td>
				<td>
					<?php if ($key->FOTO_WAJAH != null || $key->FOTO_WAJAH != ''): ?>
						<a href="javascript:;" data="<?=$key->FOTO_WAJAH?>" class="getGambar">
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
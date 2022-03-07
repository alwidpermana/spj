<div class="table-responsive">
	<table class="table table-hover table-valign-middle table-striped">
		<thead class="text-center">
			<tr>
				<th>Jenis SPJ</th>
				<th>PIC</th>
				<th>Jenis Kendaraan</th>
				<th>Group Tujuan</th>
				<th>Biaya Internal</th>
				<th>Biaya Rental</th>
				<th></th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php foreach ($data as $data): ?>
				<tr>
					<td><?=$data->NAMA_JENIS?></td>
					<td><?=$data->JENIS_PIC?></td>
					<td><?=$data->JENIS_KENDARAAN?></td>
					<td>
						<a href="javascript:;" class="text-dark groupJalur" data="<?=$data->ID_GROUP?>">
							<?=$data->NAMA_GROUP?>	
						</a>
						
							
					</td>
					<td><?=number_format($data->BIAYA_INTERNAL)?></td>
					<td><?=number_format($data->BIAYA_RENTAL)?></td>
					<td>
						<a 
							href="javascript:;" 
							class="btn text-warning text-kps2 editUangSaku"
							jenisSPJ = '<?=$data->ID_JENIS_SPJ?>'
							pic = '<?=$data->JENIS_PIC?>'
							jenisKendaraan = '<?=$data->JENIS_KENDARAAN?>'
							groupTujuan = '<?=$data->ID_GROUP?>'
							internal = '<?=$data->BIAYA_INTERNAL?>'
							rental = '<?=$data->BIAYA_RENTAL?>'>
							<i class="fas fa-edit"></i>
						</a>
						<a href="javascript:;" class="btn text-danger text-kps hapusUangSaku" data="<?=$data->ID_US?>">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
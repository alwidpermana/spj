
<div class="table-responsive">
	<table class="table table-hover table-valign-middle text-center" width="100%">
		<thead>
			<tr>
				<th>NIK</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Departement</th>
				<th>Sub Departement</th>
				<th>Foto</th>
				<th>Pilih</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $key): ?>
				<tr>
					<td><?=$key->NIK?></td>
					<td><?=$key->namapeg?></td>
					<td><?=$key->jabatan?></td>
					<td><?=$key->departemen?></td>
					<td><?=$key->Subdepartemen2 == null || $key->Subdepartemen2 =='' || $key->Subdepartemen2 == '-' ? $key->Subdepartemen1 : $key->Subdepartemen1.', '.$key->Subdepartemen2?></td>
					<td>
						<?php if ($key->FOTO_WAJAH != null || $key->FOTO_WAJAH != ''): ?>
							<?php if (file_exists($key->FOTO_WAJAH)): ?>
								<img src="<?=base_url()?>assets/image/foto-wajah/<?=$key->FOTO_WAJAH?>" class="img-thumbnail fotoWajah">
							<?php endif ?>
						<?php endif ?>
					</td>
					<td>
						<a 
							href="javascript:;" 
							class="btn btn-kps bg-orange btn-block btn-sm pilihPICByNIK" 
							nik="<?=$key->NIK?>"
							nama="<?=$key->namapeg?>"
							jabatan="<?=$key->jabatan?>"
							departemen = "<?=$key->departemen?>"
							subdepartemen1 = "<?=$key->Subdepartemen1?>"
							subdepartemen2 = "<?=$key->Subdepartemen2?>"
							subcon = "<?=$key->subkon?>">
							<i class="fas fa-check"></i>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
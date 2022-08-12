<table class="table table-hover table-valign-middle">
	<thead>
		<tr>
			<td>No</td>
			<td>Objek</td>
			<td>Nama/Perusahaan</td>
			<td>Kota / Kabupaten</td>
			<td>Group Tujuan</td>
			<!-- <?php if ($jenis>1): ?> -->
				<td></td>
			<!-- <?php endif ?> -->
		</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach ($data as $key): ?>
		<tr>
			<td><?=$i++?></td>
			<td><?=$key->OBJEK?></td>
			<td><?=$key->SERLOK_COMPANY?></td>
			<td><?=$key->SERLOK_KOTA?></td>
			<td><?=$key->NAMA_GROUP?></td>
			<!-- <?php if ($jenis>1): ?> -->
				<td>
					<a href="javascript:;" class="btn text-kps text-warning hapusLokasi" data="<?=$key->ID_LOKASI?>">
						<i class="fas fa-trash-alt"></i>
					</a>
				</td>
			<!-- <?php endif ?> -->
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
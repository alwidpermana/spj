<table class="table table-valign-middle table-striped" width="100%">
	<thead>
		<tr>
			<th>PIC Check</th>
			<th>Tanggal Check</th>
			<th>Jenis</th>
			<th>Subjek</th>
			<th>Keterangan</th>
			<th>Status Check</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->PIC_INPUT.'<br>'.$key->namapeg?></td>
				<td>
					<?=date("d F Y", strtotime($key->TGL_INPUT))?>
					<br>
					<?=date("H:i", strtotime($key->TGL_INPUT))?>
				</td>
				<td><?=$key->JENIS_DETAIL?></td>
				<td><?=$key->SUBJEK?></td>
				<td><?=$key->ALASAN?></td>
				<td class="text-center"><?=$key->STATUS?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
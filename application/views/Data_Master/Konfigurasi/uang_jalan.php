<table class="table table-striped table-hover table-valign-middle">
	<thead class="text-center">
		<tr>
			<th>Kategori</th>
			<th>Kota</th>
			<th>Biaya</th>
		</tr>
	</thead>
	<tbody class="text-center">
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NAMA_JENIS?></td>
				<td><?=$key->NAMA_KOTA?></td>
				<td><?=number_format($key->BIAYA)?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
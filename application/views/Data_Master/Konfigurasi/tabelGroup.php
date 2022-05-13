<table class="table table-hover table-bordered table-striped text-center" width="100%">
	<thead class="bg-gray">
		<tr>
			<th>Nama Daerah</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->TIPE_KOTA.' '.$key->NAMA_KOTA?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
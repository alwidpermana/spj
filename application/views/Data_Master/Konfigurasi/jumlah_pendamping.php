<div class="row">
	<div class="col-md-12">
		<table class="table table-hover table-valign-middle table-striped">
			<thead class="text-center">
				<tr>
					<th>Objek</th>
					<th>Jenis Kendaraan</th>
					<th>Luar Kota</th>
					<th>Lokal</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php foreach ($data as $key): ?>
					<tr>
						<td><?=$key->NAMA_JENIS?></td>
						<td><?=$key->JENIS_KENDARAAN?></td>
						<td><?=$key->QTY_LUAR_KOTA?></td>
						<td><?=$key->QTY_LOKAL?></td>
					</tr>	
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

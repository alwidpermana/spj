<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped" width="100%">
		<thead>
			<tr>
				<th>Kategory</th>
				<?php foreach ($data as $key): ?>
					<th><?=$key->NAMA_KOTA?></th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th><?=$jenis?></th>
				<?php foreach ($data as $key): ?>
					<td><?=number_format($key->BIAYA)?></td>
				<?php endforeach ?>
			</tr>
		</tbody>
	</table>
</div>
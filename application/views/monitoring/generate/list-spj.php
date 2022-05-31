<table class="table table-hover table-striped table-bordered" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2">No SPJ</th>
			<th rowspan="2">Tanggal SPJ</th>
			<th rowspan="2">Pengaju</th>
			<th rowspan="2">Kendaraan</th>
			<th colspan="2">PIC</th>
			<th colspan="5">Biaya</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th>Driver</th>
			<th>Pendamping</th>
			<th>Uang Saku</th>
			<th>Uang Makan</th>
			<th>Uang Jalan</th>
			<th>Uang BBM</th>
			<th>Uang Tol</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_SPJ?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->PIC_INPUT.' - '.$key->NAMA_PENGAJU?></td>
				<td><?=$key->KENDARAAN.' ('.$key->NO_TNKB.')'?></td>
				<td><?=$key->PIC_DRIVER?></td>
				<td>
					<ul style="padding-left: 10px">
					<?php foreach ($pic as $pc): ?>
						<?php if ($pc->NO_SPJ == $key->NO_SPJ): ?>
							<li><?=$pc->PIC_PENDAMPING?></li>
						<?php endif ?>
					<?php endforeach ?>
					</ul>
				</td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL))?></td>
				<td>
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu" role="menu">
          	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>">Lihat Data</a>
          	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/export_spj/<?=$key->ID_SPJ?>" target="_blank">Export PDF</a>
          </div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
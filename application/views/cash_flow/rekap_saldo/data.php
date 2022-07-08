<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="3">Tanggal</th>
			<th colspan="8">SPJ Delivery</th>
			<th colspan="8">SPJ Non Delivery</th>
			<th colspan="4" rowspan="2">BBM</th>
			<th colspan="4" rowspan="2">Total Saldo</th>
		</tr>
		<tr>
			<th colspan="4">Kasbon SPJ</th>
			<th colspan="4">Kasbon TOL</th>
			<th colspan="4">Kasbon SPJ</th>
			<th colspan="4">Kasbon TOL</th>
		</tr>
		<tr>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
			<th>Kas Induk</th>
			<th>Sub Kas</th>
			<th>Jumlah</th>
			<th>OS</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=date("Y-m-d", strtotime($key->TGL_REKAP))?></td>
				<td><?=str_replace(',', '.', number_format($key->KAS_INDUK_SPJ_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->SUB_KAS_SPJ_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_SPJ_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->OS_SPJ_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->KAS_INDUK_TOL_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->SUB_KAS_TOL_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_TOL_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->OS_TOL_DLV))?></td>
				<td><?=str_replace(',', '.', number_format($key->KAS_INDUK_SPJ_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->SUB_KAS_SPJ_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_SPJ_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->OS_SPJ_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->KAS_INDUK_TOL_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->SUB_KAS_TOL_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_TOL_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->OS_TOL_NDV))?></td>
				<td><?=str_replace(',', '.', number_format($key->KAS_INDUK_BBM))?></td>
				<td><?=str_replace(',', '.', number_format($key->SUB_KAS_BBM))?></td>
				<td><?=str_replace(',', '.', number_format($key->TOTAL_BBM))?></td>
				<td><?=str_replace(',', '.', number_format($key->OS_BBM))?></td>
				<td>
					<?php
						$kasInduk = $key->KAS_INDUK_SPJ_DLV + $key->KAS_INDUK_SPJ_NDV + $key->KAS_INDUK_TOL_DLV + $key->KAS_INDUK_TOL_NDV + $key->KAS_INDUK_BBM;
						$subKas = $key->SUB_KAS_SPJ_DLV + $key->SUB_KAS_SPJ_NDV + $key->SUB_KAS_TOL_DLV + $key->SUB_KAS_TOL_NDV + $key->SUB_KAS_BBM;
						$total = $kasInduk + $subKas;
						$os = $key->OS_SPJ_DLV + $key->OS_SPJ_NDV + $key->OS_TOL_DLV + $key->OS_TOL_NDV + $key->OS_BBM;
						echo str_replace(',', '.', number_format($kasInduk));
					?>
				</td>
				<td><?=str_replace(',', '.', number_format($subKas))?></td>
				<td><?=str_replace(',', '.', number_format($total))?></td>
				<td><?=str_replace(',', '.', number_format($os))?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': false,
            order: [[0, 'asc']],
            info: false, 
          } );
		 
	});
</script>
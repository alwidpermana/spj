<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="3">No</th>
			<th rowspan="3">Tanggal SPJ</th>
			<th rowspan="3">NO SPJ</th>
			<th rowspan="3">QR Code</th>
			<th rowspan="3">Status SPJ</th>
			<th rowspan="3">Nama Group</th>
			<th rowspan="3">Voucher BBM</th>
			<th rowspan="3">No Generate</th>
			<th colspan="6">Biaya</th>
		</tr>
		<tr>
			<th colspan="3">SPJ</th>
			<th rowspan="2">TOL</th>
			<th rowspan="2">BBM</th>
			<th rowspan="2">TOTAL</th>
		</tr>
		<tr>
			<th>Pengajuan</th>
			<th>Tambahan</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		$kasbonSPJ = 0;
		$tambahanSPJ = 0;
		$totalSPJ = 0;
		$totalTOL= 0;
		$totalBBM = 0;
		$totalRP = 0;

		foreach ($data as $key): 
			$kasbonSPJ += $key->TOTAL_KASBON;
			$tambahanSPJ += $key->TOTAL_TAMBAHAN_SPJ;
			$totalSPJ += $key->TOTAL_SPJ;
			$totalTOL += $key->TOTAL_TOL;
			$totalBBM += $key->TOTAL_BBM;
			$totalRP += $key->TOTAL_RP;
		?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$key->TGL_SPJ?></td>
				<td>
					<a href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>" class="btn text-kps" target="_blank">
						<?=$key->NO_SPJ?></td>	
					</a>
					
				<td><?=$key->QR_CODE?></td>
				<td><?=$key->STATUS_SPJ?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td><?=$key->VOUCHER_BBM?></td>
				<td><?=$key->NO_GENERATE?></td>
				<td><?=number_format($key->TOTAL_KASBON)?></td>
				<td><?=number_format($key->TOTAL_TAMBAHAN_SPJ)?></td>
				<td><?=number_format($key->TOTAL_SPJ)?></td>
				<td><?=number_format($key->TOTAL_TOL)?></td>
				<td><?=number_format($key->TOTAL_BBM)?></td>
				<td><?=number_format($key->TOTAL_RP)?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="8" class="text-right">TOTAL:</th>
			<th><?=number_format($kasbonSPJ)?></th>
			<th><?=number_format($tambahanSPJ)?></th>
			<th><?=number_format($totalSPJ)?></th>
			<th><?=number_format($totalTOL)?></th>
			<th><?=number_format($totalBBM)?></th>
			<th><?=number_format($totalRP)?></th>
		</tr>
	</tfoot>
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
<?php
	$jmlData = count($data);
?>
<table class="table table-hover table-striped table-bordered" id="datatable" width="100%" style="font-size: 9px;">
	<thead class="text-center bg-gray">
		<tr>
			<th></th>
			<th>Tanggal</th>
			<th>Transaksi</th>
			<th>Dari</th>
			<th>Ke</th>
			<th>D</th>
			<th>C</th>
			<th>Saldo</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		foreach ($data as $key): ?>
			<tr>
				<td class="text-center">
					<?php if ($key->PENGAJUAN_SALDO_ID == 0): ?>
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" <?=$jmlData == $i  ?'':'disabled'?>>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>	
					<?php else: ?>
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" disabled>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>	
					<?php endif ?>
					
                    <div class="dropdown-menu" role="menu">
                    	<a 
                			class="dropdown-item dropButton btnUpdate" 
                			href="javascript:;" 
                			data="<?=$key->ID?>"
                			tujuan="<?=$key->TRANSAKSI=='Modal Awal'?$key->DARI:$key->KE?>"
                			transaksi="<?=$key->TRANSAKSI?>"
                			biaya="<?=$key->TRANSAKSI=='Modal Awal'?$key->DEBIT:$key->CREDIT?>">Ubah
                		</a>
                    	<a 
                    		class="dropdown-item dropButton btnHapus" 
                    		href="javascript:;" 
                    		data="<?=$key->ID?>" 
                    		tujuan="<?=$key->TRANSAKSI=='Modal Awal'?$key->DARI:$key->KE?>"
                			transaksi="<?=$key->TRANSAKSI?>"
                			biaya="<?=$key->TRANSAKSI=='Modal Awal'?$key->DEBIT:$key->CREDIT?>">Hapus</a>
                    </div>
				</td>
				<td><?=date("d F Y", strtotime($key->TGL_KAS))?></td>
				<td><?=$key->TRANSAKSI?></td>
				<td><?=$key->DARI?></td>
				<td><?=$key->KE?></td>
				<td><?=$key->DEBIT==0?'':str_replace(',', '.', number_format($key->DEBIT))?></td>
				<td><?=$key->CREDIT==0?'':str_replace(',', '.', number_format($key->CREDIT))?></td>
				<td><?=str_replace(',', '.', number_format($key->SALDO))?></td>
			</tr>
		<?php $i++; endforeach ?>
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
                'ordering': false,
                "autoWidth": true,
                order: [[0, 'asc']],
                
              } );   
	})
</script>
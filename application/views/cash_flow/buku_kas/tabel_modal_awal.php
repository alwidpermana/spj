<table class="table table-hover table-bordered table-striped" id="datatable2" width="100%" style="font-size: 9px;">
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Transaksi</th>
			<th>Rp.</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		$total=0;
		foreach ($data as $key): ?>
			<tr>
				<td><?=date("Y-m-d", strtotime($key->TGL_INPUT))?></td>
				<td><?=$key->TRANSAKSI?></td>
				<td><?=$key->DEBIT==0?'':str_replace(',', '.', number_format($key->DEBIT))?></td>
			</tr>
		<?php 
		$total+=$key->DEBIT;
		endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" class="text-right">Total</th>
			<th><?=str_replace(',', '.', number_format($total))?></th>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table2 = $('#datatable2').DataTable( {
                scrollY:        "350px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                'searching': false,
                'ordering': true,
                "autoWidth": true,
                order: [[0, 'asc']],
                
              } );   
	})
</script>
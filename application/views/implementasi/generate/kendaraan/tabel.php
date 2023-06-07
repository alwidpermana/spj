<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center">
		<tr>
			<th>Tanggal Input</th>
			<th>No SPJ</th>
			<th>Tanggal SPJ</th>
			<th>No TNKB</th>
			<th>
				<div class="icheck-orange icheck-kps d-inline">
          <input 
            type="checkbox" 
            id="allData" 
            name="inputAllData"
            value="ALL">
          <label for="allData">
            ALL
          </label>
        </div>
			</th>
		</tr>
	</thead>
	<tbody class="inputData text-center">
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->TGL_INPUT?></td>
				<td><a href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>" class="text-kps" target="_blank"><?=$key->NO_SPJ?></a></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->NO_TNKB?></td>
				<td class="text-center">
					<div class="icheck-orange icheck-kps d-inline">
	          <input 
	            type="checkbox" 
	            id="<?=$key->NO_SPJ?>" 
	            name="inputCheckSPJ"
	            class="checkSPJ"
	            value="<?=$key->NO_SPJ?>">
	          <label for="<?=$key->NO_SPJ?>">
	            
	          </label>
	        </div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
      scrollY:        "400px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      'searching': false,
      'ordering': true,
      order: [[0, 'asc']],
      
    } ); 
	});
</script>
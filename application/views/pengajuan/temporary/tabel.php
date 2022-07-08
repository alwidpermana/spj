<div class="<?=count($data)==1?'table-responsive':''?>">
	<table class="table table-striped table-hover table-bordered" id="datatable" width="100%">
		<thead class="text-center bg-gray">
			<tr>
				<th></th>
				<th>No</th>
				<th>Tanggal Input</th>
				<th>PIC Input</th>
				<th>Jenis SPJ</th>
				<th>No SPJ</th>
				<th>Tanggal SPJ</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 1;
			foreach ($data as $key): ?>
				<tr>
					<td class="text-center">
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a 
		        				class="dropdown-item dropButton" 
		        				href="<?=base_url()?>pengajuan/form_temporary/<?=$key->ID_SPJ?>" 
		        				data="<?=$key->ID_SPJ?>">
		        				Edit SPJ
		        			</a>
		        			<a 
		        				class="dropdown-item dropButton hapusSPJ" 
		        				href="javascript:;" 
		        				data="<?=$key->NO_SPJ?>">
		        				Hapus SPJ
		        			</a>
	                    	
	                    </div>
					</td>
					<td><?=$i++?></td>
					<td><?=date("Y-m-d", strtotime($key->TGL_INPUT))?></td>
					<td><?=$key->PIC_INPUT.'<br>'.$key->PIC_NAMA?></td>
					<td><?=$key->NAMA_JENIS?></td>
					<td><?=$key->NO_SPJ?></td>
					<td><?=date("Y-m-d", strtotime($key->TGL_SPJ))?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml==1) {
			var table = $('#datatable').DataTable( {
	           
	            paging:         false,
	            'searching': false,
	            order: [[1, 'asc']],
	            info: false,  
	            columnDefs: [
		            { orderable: false, targets: 0 }
		        ],
	            
	          } );
		} else {
			var table = $('#datatable').DataTable( {
	            scrollY:        "350px",
	            scrollX:        true,
	            scrollCollapse: true,
	            paging:         false,
	            'searching': false,
	            order: [[1, 'asc']],
	            info: false,  
	            columnDefs: [
		            { orderable: false, targets: 0 }
		        ],
	            
	          } );	
		}
		 
	});
</script>
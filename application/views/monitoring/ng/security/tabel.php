<div class="<?=count($data)<=1?'table-responsive':''?>">
	<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
		<thead class="text-center bg-gray">
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">No</th>
				<th rowspan="2">Tanggal SPJ</th>
				<th rowspan="2">No SPJ</th>
				<th rowspan="2">QR Code</th>
				<th rowspan="2">Jenis SPJ</th>
				<th colspan="4">Pengaju</th>
				<th colspan="4">Kendaraan</th>
				<th colspan="2">Rencana Berangkat</th>
				<th colspan="2">Rencana Pulang</th>
			</tr>
			<tr>
				<th>NIK</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Departemen</th>
				<th>Jenis Kendaraan</th>
				<th>Merk</th>
				<th>Type</th>
				<th>No TNKB</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Tanggal</th>
				<th>Jam</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 1;
			foreach ($data as $key): ?>
				<tr class="<?=$key->JML_NO_READ>0?'bg-light-danger':''?>">
					<td>
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton detail" href="javascript:;" noSPJ="<?=$key->NO_SPJ?>">Detail <sup><span class="badge bg-danger"><?=$key->JML_NO_READ?></span></sup></a>
	                    	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>">Lihat SPJ</a>
	                    </div>
					</td>
					<td><?=$i++?></td>
					<td><?=$key->TGL_SPJ?></td>
					<td><?=$key->NO_SPJ?></td>
					<td><?=$key->QR_CODE?></td>
					<td><?=$key->NAMA_JENIS?></td>
					<td><?=$key->PIC_INPUT?></td>
					<td><?=$key->namapeg?></td>
					<td><?=$key->jabatan?></td>
					<td><?=$key->Departemen?></td>
					<td><?=$key->JENIS_KENDARAAN?></td>
					<td><?=$key->MERK?></td>
					<td><?=$key->TYPE?></td>
					<td><?=$key->NO_TNKB?></td>
					<td><?=date("Y-m-d", strtotime($key->RENCANA_BERANGKAT))?></td>
					<td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
					<td><?=date("Y-m-d", strtotime($key->RENCANA_PULANG))?></td>
					<td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml<=1) {
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
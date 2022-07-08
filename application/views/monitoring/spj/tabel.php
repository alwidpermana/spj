<div class="<?=count($data)==1?'table-responsive':''?>">
	<table class="table table-hover table-bordered table-striped " id="datatable">
		<thead class="text-center bg-gray">
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">No</th>
				<th rowspan="2">Tanggal Input</th>
				<th rowspan="2">No SPJ</th>
				<th rowspan="2">Tanggal SPJ</th>
				<th rowspan="2">No Barcode</th>
				<th colspan="5">Pengaju</th>
				<th colspan="6">Kendaraan</th>
				<th colspan="2">Tujuan</th>
				<th colspan="2">PIC</th>
				<th colspan="6">Biaya Reguler</th>
				<th colspan="4">Biaya Tambahan</th>
				<th rowspan="2">Total Biaya</th>
				<th rowspan="2">Adjst Biaya</th>
				<th colspan="2">Validasi</th>
				<th colspan="2">Rencana Berangkat</th>
				<th colspan="2">Aktual Berangkat</th>
				<th colspan="2">Rencana Pulang</th>
				<th colspan="2">Aktual Pulang</th>
				<th colspan="3">KM</th>
				<th colspan="4">Konsumsi BBM</th>
				<th colspan="2">GAP BBM</th>
				<th rowspan="2">Status</th>
				<th rowspan="2">Generate Status</th>
				<th rowspan="2">No Generate</th>
			</tr>
			<tr>
				<th>NIK</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Departemen</th>
				<th>Sub Departemen</th>
				<th>Kendaraan</th>
				<th>Jenis</th>
				<th>No Inventaris</th>
				<th>Merk</th>
				<th>Type</th>
				<th>No TNKB</th>
				<th>Group Tujuan</th>
				<th>Tujuan</th>
				<th>Driver</th>
				<th>Pendamping</th>
				<th>Uang Saku</th>
				<th>Uang Makan</th>
				<th>Uang Jalan</th>
				<th>BBM</th>
				<th>TOL</th>
				<th>Jumlah</th>
				<th>Uang Saku 1 - 3</th>
				<th>Uang Saku 1 &ge; 4</th>
				<th>Makan Ke 2</th>
				<th>Jumlah</th>
				<th>Out</th>
				<th>In</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Tanggal</th>
				<th>jam</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Out</th>
				<th>In</th>
				<th>Selisih</th>
				<th>KM/Ltr</th>
				<th>Terpakai (Ltr)</th>
				<th>Harga / Liter</th>
				<th>Rp.</th>
				<th>Ltr</th>
				<th>Rp.</th>

			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 1;
			foreach ($data as $key): ?>
				<tr>
					<td>
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>">Lihat Data</a>
	                    	<a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/export_spj/<?=$key->ID_SPJ?>" target="_blank">Export PDF</a>
	                    	<?php if ($key->STATUS_PERJALANAN == null): ?>
	                    		<?php if ($key->STATUS_SPJ == 'OPEN'): ?>
	                    			<a 
	                    				class="dropdown-item dropButton btnCancel" 
	                    				href="javascript:;" 
	                    				data="<?=$key->ID_SPJ?>" 
	                    				status = 'CANCEL'>
	                    				Cancel SPJ
	                    			</a>
	                    			<a 
	                    				class="dropdown-item dropButton" 
	                    				href="<?=base_url()?>pengajuan/form_edit/<?=$key->ID_SPJ?>" 
	                    				data="<?=$key->ID_SPJ?>">
	                    				Edit SPJ
	                    			</a>			
	                			<?php else: ?>
	                				<a 
	                    				class="dropdown-item dropButton btnCancel" 
	                    				href="javascript:;" 
	                    				data="<?=$key->ID_SPJ?>" 
	                    				status = 'OPEN'>
	                    				Open SPJ
	                    			</a>
	                			<?php endif ?>	
	                    	<?php endif ?>
	                    	
	                    </div>
					</td>
					<td><?=$i++?></td>
					<td><?=date("d-m-Y", strtotime($key->TGL_INPUT))?></td>
					<td><?=$key->NO_SPJ?></td>
					<td><?=$key->TGL_SPJ?></td>
					<td><?=$key->QR_CODE?></td>
					<td><?=$key->PIC_INPUT?></td>
					<td><?=$key->namapeg?></td>
					<td><?=$key->jabatan?></td>
					<td><?=$key->departemen?></td>
					<td><?=$key->Subdepartemen?></td>
					<td><?=$key->KENDARAAN?></td>
					<td><?=$key->JENIS_KENDARAAN?></td>
					<td><?=$key->NO_INVENTARIS?></td>
					<td><?=$key->MERK?></td>
					<td><?=$key->TYPE?></td>
					<td><?=$key->NO_TNKB?></td>
					<td><?=$key->NAMA_GROUP?></td>
					<td>
						<ul style="padding-left: 10px">
						<?php foreach ($tujuan as $lok): ?>
							<?php if ($lok->NO_SPJ == $key->NO_SPJ): ?>
								<li><?=$lok->SERLOK_KOTA?></li>
							<?php endif ?>
						<?php endforeach ?>
						</ul>
					</td>
					<td><?=$key->PIC_DRIVER?></td>
					<td>
						<ul style="padding-left: 10px">
						<?php foreach ($pic as $pc): ?>
							<?php if ($pc->NO_PENGAJUAN == $key->NO_SPJ): ?>
								<li><?=$pc->PIC?></li>
							<?php endif ?>
						<?php endforeach ?>
						</ul>
					</td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
					<td>
						<?php
							$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_BBM + $key->TOTAL_UANG_TOL;
							echo str_replace(',','.', number_format($total));
						?>
					</td>
					<td><?=str_replace(',', '.', number_format($key->US1, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->US2, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->UM, 0))?></td>
					<td>
						<?php
							$totalTambahan = $key->US1 + $key->US2 + $key->UM;
							echo str_replace(',', '.', number_format($totalTambahan, 0));
						?>
					</td>
					<td><?=str_replace(',', '.', number_format($total+$totalTambahan, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->BIAYA_ADJUSTMENT, 0))?></td>
					<td><?=$key->KEBERANGKATAN == null?'':$key->VALIDASI_OUT?></td>
					<td><?=$key->KEPULANGAN == null?'':$key->VALIDASI_IN?></td>
					<td><?=date("d-m-Y",strtotime($key->RENCANA_BERANGKAT))?></td>
					<td><?=date("H:i",strtotime($key->RENCANA_BERANGKAT))?></td>
					<?php if ($key->KEBERANGKATAN == null): ?>
						<td></td>
						<td></td>
					<?php else: ?>
						<td><?=date("d-m-Y",strtotime($key->KEBERANGKATAN))?></td>
						<td><?=date("H:i",strtotime($key->KEBERANGKATAN))?></td>
					<?php endif ?>
					<td><?=date("d-m-Y",strtotime($key->RENCANA_PULANG))?></td>
					<td><?=date("H:i",strtotime($key->RENCANA_PULANG))?></td>
					<?php if ($key->KEPULANGAN == null): ?>
						<td></td>
						<td></td>
					<?php else: ?>
						<td><?=date("d-m-Y",strtotime($key->KEPULANGAN))?></td>
						<td><?=date("H:i",strtotime($key->KEPULANGAN))?></td>
					<?php endif ?>
					<td><?=str_replace(',', '.', number_format($key->KM_OUT, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->KM_IN, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->KM_IN-$key->KM_OUT, 0))?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=$key->STATUS_SPJ?></td>
					<td></td>
					<td><?=$key->NO_GENERATE?></td>
					
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
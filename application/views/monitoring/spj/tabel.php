<div class="<?=count($data)<=2?'table-responsive':''?>">
	<table class="table table-hover table-bordered table-striped " id="datatable">
		<thead class="text-center bg-gray">
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">No</th>
				<th rowspan="2">Tanggal Input</th>
				<th rowspan="2">No SPJ</th>
				<th rowspan="2">Tanggal SPJ</th>
				<th rowspan="2">QR Code</th>
				<th rowspan="2">Abnormal</th>
				<th colspan="5">Pengaju</th>
				<th colspan="6">Kendaraan</th>
				<th colspan="2">Tujuan</th>
				<th colspan="2">PIC</th>
				<th colspan="7">Biaya Reguler</th>
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
				<th>Kendaraan</th>
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
	                    	<?php if ($key->STATUS_SPJ != 'CANCEL'): ?>
	                    		<!-- <a class="dropdown-item dropButton printSPJ printVoucher" href="javascript:;" data="<?=$key->ID_SPJ?>">Print</a> -->
	                    		<button type="button" class="dropdown-item dropButton" onclick="printSPJ(<?=$key->ID_SPJ?>, '<?=$key->MEDIA_UANG_BBM?>')">Print</button>
	                    		<!-- <a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/export_spj/<?=$key->ID_SPJ?>" target="_blank">Export PDF</a> -->
	                    	<?php endif ?>
	                    	<?php if ($key->STATUS_PERJALANAN == null && $this->session->userdata("LEVEL")<=4): ?>
	                    		<?php if ($key->STATUS_SPJ == 'OPEN'): ?>
	                    			<?php if ($key->JENIS_ID == '1'): ?>
	                    				
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
	                    				<?php if ($this->session->userdata("NIK") != $key->PIC_INPUT || $this->session->userdata("LEVEL")==0): ?>
	                    					<!-- <button type="button" class="dropdown-item dropButton" onclick="printSPJ(<?=$key->ID_SPJ?>, '<?=$key->MEDIA_UANG_BBM?>')">Print</button> -->
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
	                    				<?php endif ?>
	                    			<?php endif ?>
	                    			
	                    			<a 
	                    				class="dropdown-item dropButton btnEdit" 
	                    				href="javascript:;" 
	                    				data="<?=$key->ID_SPJ?>"
	                    				noSPJ = "<?=$key->NO_SPJ?>">
	                    				Edit SPJ 2
	                    			</a>
	                    			<!-- <a 
	                    				class="dropdown-item dropButton" 
	                    				href="javascript:;" 
	                    				data="<?=$key->ID_SPJ?>"
	                    				voucher="<?=$key->VOUCHER_BBM?>">
	                    				Voucher NG
	                    			</a> -->
	                    			<?php if ($key->JENIS_ID == '1'): ?>
	        							<a 
		                    				class="dropdown-item dropButton reloadTujuan" 
		                    				href="javascript:;" 
		                    				noSPJ="<?=$key->NO_SPJ?>"
		                    				noTNKB = "<?=$key->NO_TNKB?>"
		                    				tglSPJ = "<?=$key->TGL_SPJ?>"
		                    				groupId = "<?=$key->GROUP_ID?>">
		                    				Reload Tujuan
		                    			</a>
	        						<?php endif ?>			
	                			<?php else: ?>
	                				<?php if ($this->session->userdata("LEVEL")<2): ?>
	                					<a 
		                    				class="dropdown-item dropButton btnCancel" 
		                    				href="javascript:;" 
		                    				data="<?=$key->ID_SPJ?>" 
		                    				status = 'OPEN'>
		                    				Open SPJ
		                    			</a>
	                				<?php endif ?>
	                			<?php endif ?>	
	                    	<?php endif ?>
	                    	
	                    </div>
					</td>
					<td><?=$i++?></td>
					<td><?=date("d-m-Y", strtotime($key->TGL_INPUT))?></td>
					<td><?=$key->NO_SPJ?></td>
					<td><?=$key->TGL_SPJ?></td>
					<td><?=$key->QR_CODE?></td>
					<td><?=$key->ABNORMAL == 'Y'?'<span class="badge bg-danger">Yes</span>':''?></td>
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
							<?php
								$lokasi = $this->M_Monitoring->getLokasiPerNoSPJ_v2($key->NO_SPJ);
								echo $lokasi;
							?>
						</ul>
					</td>
					<td><?=$key->PIC_DRIVER?></td>
					<td>
						<ul style="padding-left: 10px">
							<?php
								$pic = $this->M_Monitoring->getPICPerSPJ_v2($key->NO_SPJ);
								echo $pic;
							?>
						</ul>
					</td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
					<td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_KENDARAAN, 0))?></td>
					<td>
						<?php
							$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_BBM + $key->TOTAL_UANG_TOL+$key->TOTAL_UANG_KENDARAAN;
							echo str_replace(',','.', number_format($total));
						?>
					</td>
					<td><?=$key->KEPUTUSAN_US1 == 'OK'?str_replace(',', '.', number_format($key->US1, 0)):''?></td>
					<td><?=$key->KEPUTUSAN_US2 == 'OK'?str_replace(',', '.', number_format($key->US2, 0)):''?></td>
					<td><?=$key->KEPUTUSAN_MAKAN == 'OK'?str_replace(',', '.', number_format($key->UM, 0)):''?></td>
					<td>
						<?php
							$us1 = $key->KEPUTUSAN_US1 == 'OK'? $key->US1:0;
							$us2 = $key->KEPUTUSAN_US2 == 'OK'?$key->US2:0;
							$um= $key->KEPUTUSAN_MAKAN == 'OK'?$key->UM:0;
							$totalTambahan = $us1 + $us2 + $um;
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
					<td><?=$key->STATUS_PERJALANAN=='IN'?str_replace(',', '.', number_format($key->KM_IN-$key->KM_OUT, 0)):''?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-center">
						<?=$key->STATUS_SPJ == 'CLOSE' && $key->NO_GENERATE == null ? 'Waiting&nbsp;For&nbsp;Generate':$key->STATUS_SPJ?>
					</td>
					<?php if ($key->STATUS_SPJ == 'CANCEL'): ?>
						<td class="text-center"><?=$key->STATUS_SPJ?></td>
					<?php else: ?>
						<td class="text-center"><?=$key->NO_GENERATE == null ?'OPEN':'CLOSE'?></td>	
					<?php endif ?>
					<td><?=$key->NO_GENERATE?></td>
					
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml<=2) {
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
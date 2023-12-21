<div class="<?=count($data) == 1 || count($data) == 2 ? 'table-responsive':''?>">
	<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
		<thead>
			<tr class="bg-gray text-center">
				<th rowspan="3"></th>
				<th rowspan="3">No</th>
				<th rowspan="3">Tanggal Input</th>
				<th rowspan="3">No SPJ</th>
				<th rowspan="3">Tanggal SPJ</th>
				<th rowspan="3">QR Code</th>
				<th colspan="4">Pengaju</th>
				<th colspan="5">Kendaraan</th>
				<th colspan="2">Tujaun</th>
				<th colspan="2">PIC</th>
				<th colspan="4">Rencana</th>
				<th colspan="7">Biaya Kasbon</th>
				<th colspan="5">Media Pembayaran</th>
			</tr>
			<tr class="bg-gray text-center">
				<th rowspan="2">NIK</th>
				<th rowspan="2">Nama</th>
				<th rowspan="2">Jabatan</th>
				<th rowspan="2">Departemen</th>
				<th rowspan="2">Kendaraan</th>
				<th rowspan="2">Jenis Kendaraan</th>
				<th rowspan="2">Merk</th>
				<th rowspan="2">Type</th>
				<th rowspan="2">No TNKB</th>
				<th rowspan="2">Nama Group</th>
				<th rowspan="2">Tujuan</th>
				<th rowspan="2">Driver</th>
				<th rowspan="2">Pendamping</th>
				<th colspan="2">Keberangkatan</th>
				<th colspan="2">Kepulangan</th>
				<th rowspan="2">Uang Saku</th>
				<th rowspan="2">Uang Makan</th>
				<th rowspan="2">Uang Jalan</th>
				<th rowspan="2">Uang BBM</th>
				<th rowspan="2">Uang TOL</th>
				<th rowspan="2">Uang Kendaraan</th>
				<th rowspan="2">Totak Kasbon</th>
				<th rowspan="2">Media Uang Saku</th>
				<th rowspan="2">Media Uang Makan</th>
				<th rowspan="2">Media Uang Jalan</th>
				<th rowspan="2">Media Uang BBM</th>
				<th rowspan="2">Media Uang TOL</th>
			</tr>
			<tr class="bg-gray text-center">
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Tanggal</th>
				<th>Jam</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			$level = $this->session->userdata("LEVEL");
			$departemen = $this->session->userdata("DEPARTEMEN");
			foreach ($data as $key): 
			$total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_TOL+$key->TOTAL_UANG_KENDARAAN;?>
				<tr>
					<td>
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<?php if ($this->session->userdata("NIK") == $key->PIC_INPUT || $this->session->userdata("LEVEL") == '0'): ?>
	                    		<a 
		            				class="dropdown-item dropButton" 
		            				href="<?=base_url()?>pengajuan/form_edit/<?=$key->ID_SPJ?>?filStatus=DRAFT" 
		            				data="<?=$key->ID_SPJ?>">
		            				Edit SPJ
		            			</a>
		            			<button type="button" class="dropdown-item dropButton" onclick="printSPJ(<?=$key->ID_SPJ?>, '<?=$key->MEDIA_UANG_BBM?>')">Print</button>	
	                    	<?php endif ?>
	                    	
	            			<!-- <button type="button" class="dropdown-item dropButton" onclick="printSPJ(<?=$key->ID_SPJ?>, '<?=$key->MEDIA_UANG_BBM?>')">Print</button> -->
	            			<?php if ($level == '0' || strtoupper($departemen) == 'FINANCE & ACCOUNTING - TAX'): ?>
								<a 
		            				class="dropdown-item dropButton approve" 
		            				href="javascript:;" 
		            				noSPJ="<?=$key->NO_SPJ?>"
		            				total = "<?=$total?>"
		            				data="<?=$key->ID_SPJ?>"
		            				bbm = "<?=$key->TOTAL_UANG_BBM?>"
		            				mediaBBM = "<?=$key->MEDIA_UANG_BBM?>"
		            				kendaraan = "<?=$key->KENDARAAN?>"
		            				jenisId = "<?=$key->JENIS_ID?>">
		            				Approve SPJ
		            			</a>            				
	            			<?php endif ?>
	            			<a 
		        				class="dropdown-item dropButton btnCancel" 
		        				href="javascript:;" 
		        				data="<?=$key->ID_SPJ?>" 
		        				status = 'CANCEL'>
		        				Cancel SPJ
		        			</a>
	                    </div>
					</td>
					<td><?=$no++?></td>
					<td><?=date("Y-m-d", strtotime($key->TGL_INPUT))?></td>
					<td><?=$key->NO_SPJ?></td>
					<td><?=date("Y-m-d", strtotime($key->TGL_SPJ))?></td>
					<td><?=$key->QR_CODE?></td>
					<td><?=$key->PIC_INPUT?></td>
					<td><?=$key->NAMA_INPUT?></td>
					<td><?=$key->JABATAN_INPUT?></td>
					<td><?=$key->DEPARTEMEN_INPUT?></td>
					<td><?=$key->KENDARAAN?></td>
					<td><?=$key->JENIS_KENDARAAN?></td>
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
					<td><?=$key->NIK_DRIVER.'&nbsp;-&nbsp;'.$key->NAMA_DRIVER?></td>
					<td>
						<ul>
							<?php
								$pic = $this->M_Monitoring->getPICPerSPJ_v2($key->NO_SPJ);
								echo $pic;
							?>
						</ul>
						
					</td>
					<td><?=date("Y-m-d", strtotime($key->RENCANA_BERANGKAT))?></td>
					<td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
					<td><?=date("Y-m-d", strtotime($key->RENCANA_PULANG))?></td>
					<td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
					<td><?=number_format($key->TOTAL_UANG_SAKU)?></td>
					<td><?=number_format($key->TOTAL_UANG_MAKAN)?></td>
					<td><?=number_format($key->TOTAL_UANG_JALAN)?></td>
					<td><?=number_format($key->TOTAL_UANG_BBM)?></td>
					<td><?=number_format($key->TOTAL_UANG_TOL)?></td>
					<td><?=number_format($key->TOTAL_UANG_KENDARAAN)?></td>
					<td>
						<?php
							
							echo number_format($total);
						?>
					</td>
					<td><?=$key->MEDIA_UANG_SAKU?></td>
					<td><?=$key->MEDIA_UANG_MAKAN?></td>
					<td><?=$key->MEDIA_UANG_JALAN?></td>
					<td><?=$key->MEDIA_UANG_BBM?></td>
					<td><?=$key->MEDIA_UANG_TOL?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var jml = '<?=count($data)?>';
		if (jml==1 || jml == 2) {
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
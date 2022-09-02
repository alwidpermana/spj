<br>
<div class="table-responsive">
	<table class="table table-valign-middle table-striped" width="100%">
		<thead class="text-center">
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">No Biaya Admin</th>
				<th colspan="2">Pengajuan</th>
				<th colspan="4">Biaya Admin</th>
				<th colspan="2">Approval</th>
				<th rowspan="2">Status</th>
			</tr>
			<tr>
				<th>Tanggal</th>
				<th>PIC</th>
				<th>Tanggal Biaya</th>
				<th>Jenis SPJ</th>
				<th>Biaya</th>
				<th>Keterangan</th>
				<th>Tanggal</th>
				<th>PIC</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $key): ?>
				<tr class="text-center">
					<td>
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" <?=$key->STATUS_APPROVE == null?'':'disabled'?>>
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
						
	                    <div class="dropdown-menu" role="menu">
	                    	<a 
	                			class="dropdown-item dropButton btnUpdate" 
	                			href="javascript:;" 
	                			tgl ="<?=date("Y-m-d", strtotime($key->TGL_BIAYA))?>"
	                			jenis ="<?=$key->JENIS_ID?>"
	                			biaya = "<?=$key->BIAYA?>"
	                			keterangan = "<?=$key->KETERANGAN?>"
	                			data="<?=$key->ID?>">Ubah
	                		</a>
	                    	<a 
	                    		class="dropdown-item dropButton btnHapus" 
	                    		href="javascript:;" 
	                    		data="<?=$key->ID?>">Hapus</a>

	                    </div>
					</td>
					<td><?=$key->NO_BIAYA_ADMIN?></td>
					<td><?=date("d F Y", strtotime($key->TGL_INPUT))?></td>
					<td><?=$key->PIC_INPUT.'-'.$key->NAMA_INPUT?></td>
					<td><?=date("d F Y", strtotime($key->TGL_BIAYA))?></td>
					<td><?=$key->NAMA_JENIS?></td>
					<td><?=str_replace(',', '.', number_format($key->BIAYA))?></td>
					<td><?=$key->KETERANGAN?></td>
					<?php if ($key->STATUS_APPROVE == null): ?>
						<td colspan="2">
							<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" style="width:100%">
		                      <span class="sr-only">Toggle Dropdown</span>
		                      <span>Approve</span>
		                    </button>
							
		                    <div class="dropdown-menu" role="menu">
		                    	<a 
		                			class="dropdown-item dropButton btnApprove" 
		                			href="javascript:;" 
		                			status="APPROVED"
		                			jenis ="<?=$key->JENIS_ID?>"
		                			biaya="<?=$key->BIAYA?>"
		                			data="<?=$key->ID?>">Approved
		                		</a>
		                    	<a 
		                    		class="dropdown-item dropButton btnApprove" 
		                    		href="javascript:;" 
		                    		status="REJECTED"
		                    		jenis = "<?=$key->JENIS_ID?>"
		                    		data="<?=$key->ID?>">Reject</a>

		                    </div>
						</td>	
					<?php else: ?>
						<td><?=$key->TGL_APPROVE==null?'':date("d F Y", strtotime($key->TGL_APPROVE))?></td>
						<td><?=$key->PIC_APPROVE.'<br>'.$key->NAMA_APPROVE?></td>	
					<?php endif ?>
					
					<td>
						<?php if ($key->STATUS == 'Waiting For Approve'): ?>
							<span class="badge bg-kps">Waiting For Approve</span>
						<?php else: ?>
							<span class="badge <?=$key->STATUS=='APPROVED'?'bg-success':'bg-danger'?>"><?=$key->STATUS?></span>
						<?php endif ?>
							
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
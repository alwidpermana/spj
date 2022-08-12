<table class="table table-hover table-striped table-bordered" width="100%" style="font-size: 9px;">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2"></th>
			<th colspan="2">Pengajuan</th>
			<th rowspan="2">Transaksi</th>
			<th rowspan="2">Dari/Ke</th>
			<th rowspan="2">Rp</th>
			<th colspan="2">Approve</th>
		</tr>
		<tr>
			<th>Tanggal</th>
			<th>PIC</th>
			<th>Tanggal</th>
			<th>PIC</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td class="text-center">
					<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" <?=$key->STATUS_APPROVE == 'APPROVED'?'disabled':''?>>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
					
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
				<td><?=date("d F Y", strtotime($key->TGL_INPUT))?></td>
				<td><?=$key->PIC_INPUT?><br><?=$key->NAMA_INPUT?></td>
				<td><?=$key->TRANSAKSI?></td>
				<td><?=$key->DARI_KE?></td>
				<td><?=str_replace(',', '.', number_format($key->RP))?></td>
				<?php if ($key->STATUS_APPROVE == null AND $this->session->userdata("LEVEL") <=1): ?>
					<td colspan="2" class="text-center">
						<button 
							type="button" 
							class="btn bg-orange btn-kps btn-sm" 
							id="approvePengajuan" 
							data="<?=$key->ID?>"
							tujuan="<?=$key->TRANSAKSI =='Modal Awal'?$key->DARI:$key->KE?>"
							transaksi="<?=$key->TRANSAKSI?>"
                			biaya="<?=$key->TRANSAKSI=='Modal Awal'?$key->DEBIT:$key->CREDIT?>">
							Approve
						</button>
					</td>
				<?php else: ?>
					<td><?=$key->TGL_APPROVE == null ? '' :date("d F Y", strtotime($key->TGL_APPROVE))?></td>
					<td><?=$key->PIC_APPROVE?><br><?=$key->NAMA_APPROVE?></td>	
				<?php endif ?>
				
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
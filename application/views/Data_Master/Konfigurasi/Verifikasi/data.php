<table class="table table-valign-middle table-striped" width="100%">
	<thead class="text-center">
		<tr>
			<th rowspan="2">Konfigurasi</th>
			<th colspan="2">Pengajuan</th>
			<th rowspan="2">Perihal</th>
			<th colspan="3">Persetujuan</th>
		</tr>
		<tr>
			<td>PIC</td>
			<td>Tanggal</td>
			<td>Status</td>
			<td>PIC</td>
			<td>Tanggal</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td style="text-transform: uppercase;"><?=str_replace('_', ' ', substr($key->KONFIGURASI, 0, 2) == 'US'?'Uang Saku '.substr($key->KONFIGURASI, 3):$key->KONFIGURASI)?></td>
				<td>
					<?=$key->PIC_INPUT.' - '.$key->NAMA_PENGAJU?>
							
				</td>
				<td><?=date("d F Y", strtotime($key->TGL_INPUT))?></td>
				<td>
					<?php
						if ($key->KONFIGURASI == 'JUMLAH_PENDAMPING') {
							echo 'Mengajukan Jumlah Pendamping SPJ '.$key->NAMA_JENIS.' Dengan Jenis Kendaraan '.$key->JENIS.' Sebanyak '.$key->QTY_1.' Orang Untuk Lokal dan '.$key->QTY_2.' Orang Untuk Luar Kota';
						}elseif ($key->KONFIGURASI=='UANG_JALAN') {
							echo 'Mengajukan Biaya Uang Jalan SPJ '.$key->NAMA_JENIS.' Dengan Tujuan '.$key->NAMA_KOTA.' Sebesar Rp. '.str_replace(',', '.', number_format($key->QTY_1));
						}elseif($key->KONFIGURASI == 'UANG_SAKU'){
							$jenis = $key->QTY_1 == null ?'Rental':'Internal';
							$biaya = $key->QTY_1 == null ? $key->QTY_2:$key->QTY_1;
							echo 'Mengajukan Biaya Uang Saku SPJ '.$key->NAMA_JENIS.' Untuk '.$key->JENIS.' '.$jenis.' Dengan Kendaraan '.$key->JENIS_2.' Tujuan '.$key->NAMA_GROUP.' Sebesar Rp. '.str_replace(',', '.', number_format($biaya));
						}elseif($key->KONFIGURASI == 'UANG_MAKAN'){
							$tipe = $key->FIELD_ID == 1?'Pertama':'Kedua';
							echo 'Mengajukan Biaya Uang Makan '.$tipe.' SPJ '.$key->NAMA_JENIS.' '.$key->JENIS.' Sebesar Rp. '.str_replace(',', '.', number_format($key->QTY_1));
						}elseif ($key->KONFIGURASI == 'JAM_TAMBAHAN') {
							if ($key->QTY_1 != null) {
								$text = 'Mengajukan Perubahan Jam Untuk Mendapatkan Uang Saku dan Uang Makan Ke 2 Menjadi '.$key->QTY_1.' Jam';
							}else{
								$text = 'Mengajukan Perubahan Jam Untuk Mendapatkan Uang Saku dan Uang Makan Ke 2 (Dengan Lewat Pukul 24.00) Menjadi '.$key->QTY_2.' Jam';
							}
							echo $text;
						}elseif($key->KONFIGURASI == 'US_TAMBAHAN'){
							$jamKe = $key->FIELD_ID == 1?'Jam Ke 1-3':'Jam Ke &ge; 4';
							echo "Mengajukan Biaya Tambahan Untuk Uang Saku SPJ ".$key->NAMA_JENIS." Untuk ".$jamKe." Sebesar Rp. ".str_replace(',', '.', number_format($key->QTY_1));
						}
					?>
				</td>
				<td class="text-center">
				 	<?php if ($key->STATUS_APPROVE == null): ?>
				 		<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton btnApproved" href="javascript:;" data="<?=$key->ID?>" status="APPROVED">Approve</a>
	                    	<a class="dropdown-item dropButton btnApproved" href="javascript:;" data="<?=$key->ID?>" status="REJECT">Reject</a>
	                    </div>
				 	<?php else: ?>
				 		<?=$key->STATUS_APPROVE?>
				 	<?php endif ?>
				</td>
				<td><?=$key->PIC_APPROVE.' - '.$key->NAMA_APPROVE?></td>
				<td><?=$key->TGL_APPROVE == null ? '' : date("d F Y", strtotime($key->TGL_APPROVE))?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
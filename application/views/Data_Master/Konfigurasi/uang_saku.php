<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead class="text-center">
					<tr>
						<td rowspan="2" style="width: 50px !important">PIC</td>
						<td rowspan="2" style="width: 50px !important">Jenis Kendaraan</td>
						<?php foreach ($group as $gp ): ?>
							<td colspan="2" style="width: 500px !important"><?=$gp->NAMA_GROUP?></td>
						<?php endforeach ?>
					</tr>
					<tr>
						<?php foreach ($group as $gp ): ?>
							<td>Internal</td>
							<td>Rental</td>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($new as $nw): ?>
						<tr>
							<td><?=$nw->Status?></td>
							<td><?=$nw->KENDARAAN_MASTER?></td>
							<?php foreach ($group as $key): 
								$no = $key->ID_GROUP;
								$fieldInternal = 'INTERNAL'.$no;
								$fieldRental = 'RENTAL'.$no;
								$fieldGroup = 'ID_GROUP'.$no;
							?>

								<td>
									<a 
										href="javascript:;"
										class="btn text-kps text-dark biayaUangSaku"
										biaya = "<?=$nw->$fieldInternal == null ? 0:$nw->$fieldInternal?>"
										ID_JENIS_SPJ='1'
										PIC = '<?=$nw->Status?>'
										JENIS_KENDARAAN = '<?=$nw->KENDARAAN_MASTER?>'
										ID_GROUP = '<?=$no?>'
										FIELD='BIAYA_INTERNAL'>
										<?=$nw->$fieldInternal == null ? 0:str_replace(',', '.', number_format($nw->$fieldInternal))?>
									</a>
								</td>
								<td>
									<a 
										href="javascript:;"
										class="btn text-kps text-dark biayaUangSaku"
										biaya = "<?=$nw->$fieldRental == null ? 0:$nw->$fieldRental?>"
										ID_JENIS_SPJ='1'
										PIC = '<?=$nw->Status?>'
										JENIS_KENDARAAN = '<?=$nw->KENDARAAN_MASTER?>'
										ID_GROUP = '<?=$no?>'
										FIELD='BIAYA_RENTAL'>
										<?=$nw->$fieldRental == null ? 0:str_replace(',', '.', number_format($nw->$fieldRental))?>
									</a>
									
								</td>
							<?php endforeach ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<!-- <table class="table table-hover table-valign-middle table-striped">
				<thead class="text-center">
					<tr>
						<th>Jenis SPJ</th>
						<th>PIC</th>
						<th>Jenis Kendaraan</th>
						<th>Group Tujuan</th>
						<th>Biaya Internal</th>
						<th>Biaya Rental</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php foreach ($data as $data): ?>
						<tr>
							<td><?=$data->NAMA_JENIS?></td>
							<td><?=$data->JENIS_PIC?></td>
							<td><?=$data->JENIS_KENDARAAN?></td>
							<td>
								<a href="javascript:;" class="text-dark groupJalur" data="<?=$data->ID_GROUP?>">
									<?=$data->NAMA_GROUP?>	
								</a>
								
									
							</td>
							<td><?=number_format($data->BIAYA_INTERNAL)?></td>
							<td><?=number_format($data->BIAYA_RENTAL)?></td>
							<td>
								<a 
									href="javascript:;" 
									class="btn text-warning text-kps2 editUangSaku"
									jenisSPJ = '<?=$data->ID_JENIS_SPJ?>'
									pic = '<?=$data->JENIS_PIC?>'
									jenisKendaraan = '<?=$data->JENIS_KENDARAAN?>'
									groupTujuan = '<?=$data->ID_GROUP?>'
									internal = '<?=$data->BIAYA_INTERNAL?>'
									rental = '<?=$data->BIAYA_RENTAL?>'>
									<i class="fas fa-edit"></i>
								</a>
								<a href="javascript:;" class="btn text-danger text-kps hapusUangSaku" data="<?=$data->ID_US?>">
									<i class="fas fa-trash-alt"></i>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table> -->
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
				<thead class="text-center">
					<tr>
						<td>Jabatan</td>
						<?php foreach ($group as $gp ): ?>
							<td><?=$gp->NAMA_GROUP?></td>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($non as $nn): ?>
						<tr>
							<td><?=$nn->jabatan?> ( <?=$nn->TIPE_MASTER?> )</td>
							<?php foreach ($group as $key2): 
								$no = $key2->ID_GROUP;
								$fieldBiaya = 'BIAYA'.$no;
							?>
								<td>
									<a 
										href="javascript:;"
										class="btn text-kps text-dark biayaUangSaku"
										biaya = "<?=$nn->$fieldBiaya == null ? 0:$nn->$fieldBiaya?>"
										ID_JENIS_SPJ='2'
										PIC = '<?=$nn->jabatan?>'
										JENIS_KENDARAAN = '-'
										ID_GROUP = '<?=$no?>'
										FIELD='BIAYA_INTERNAL'>
										<?=$nn->$fieldBiaya == null ? 0:str_replace(',', '.', number_format($nn->$fieldBiaya))?>
									</a>
								</td>
								
							<?php endforeach ?>
						</tr>
						
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
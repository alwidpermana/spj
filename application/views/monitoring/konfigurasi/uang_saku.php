<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
	<?php if ($jenis == '1'): ?>
		<thead class="text-center bg-gray">
			<tr>
				<td rowspan="3" style="width: 50px !important">PIC</td>
				<td rowspan="3" style="width: 50px !important">Jenis Kendaraan</td>
				<?php foreach ($group as $gp ): ?>
					<td colspan="2" style="width: 500px !important"><?=$gp->NAMA_GROUP?></td>
				<?php endforeach ?>
			</tr>
			<tr>
				<?php foreach ($group as $gp ): ?>
					<td colspan="2" style="width: 500px !important">
						<?php
							if ($gp->ID_GROUP == 10) {
								echo "Solokan Jeruk, Pandawa 5";
							}
							$listKota = $this->M_Monitoring->listKotaGroup($gp->ID_GROUP);
							$komaKota = "";
							$kota = "";
							foreach ($listKota->result() as $lk) {
								$kota.= $komaKota.''.$lk->NAMA_KOTA;
								$komaKota=", ";
							}
							echo $kota;
						?>
					</td>
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

						<td class="text-center">
							<?=number_format($nw->$fieldInternal)?>
						</td>
						<td class="text-center">
							<?=number_format($nw->$fieldRental)?>
						</td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	<?php else: ?>
		<thead class="text-center bg-gray">
			<tr>
				<td rowspan="3" style="width: 50px !important">PIC</td>
				<td rowspan="3" style="width: 50px !important">Jabatan</td>
				<?php foreach ($group as $gp ): ?>
					<td colspan="2" style="width: 500px !important"><?=$gp->NAMA_GROUP?></td>
				<?php endforeach ?>
			</tr>
			<tr>
				<?php foreach ($group as $gp ): ?>
					<td colspan="2" style="width: 500px !important">
						<?php
							if ($gp->ID_GROUP == 10) {
								echo "Solokan Jeruk, Pandawa 5";
							}
							$listKota = $this->M_Monitoring->listKotaGroup($gp->ID_GROUP);
							$komaKota = "";
							$kota = "";
							foreach ($listKota->result() as $lk) {
								$kota.= $komaKota.''.$lk->NAMA_KOTA;
								$komaKota=", ";
							}
							echo $kota;
						?>
					</td>
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
			<?php foreach ($non as $n): ?>
				<tr>
					<td><?=$n->PIC?></td>
					<td><?=$n->JENIS_PIC?></td>
					<?php
						foreach ($group as $gp) {
							$biayaNon = $this->M_Monitoring->uangSakuNonDelivery($gp->ID_GROUP, $n->JENIS_PIC);
							if ($biayaNon->num_rows()==0) {
								echo "<td>0</td>";
								echo "<td>0</td>";
							}else{
								foreach ($biayaNon->result() as $bn) {
									echo "<td>".number_format($bn->BIAYA_INTERNAL)."</td>";
									echo "<td>".number_format($bn->BIAYA_RENTAL)."</td>";
								}	
							}
							
						}
					?>
				</tr>
			<?php endforeach ?>
		</tbody>
	<?php endif ?>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': true,
            'ordering': false,
            order: [[0, 'desc']],
            info: true, 	            
          } ); 
	});
</script>
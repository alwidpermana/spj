<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead>
		<tr class="bg-gray text-center">
			<td rowspan="3">No</td>
			<td rowspan="3">Tanggal Input</td>
			<td rowspan="3">No SPJ</td>
			<td rowspan="3">Tanggal SPJ</td>
			<td rowspan="3">QR Code</td>
			<td rowspan="3">Abnormal</td>
			<td colspan="4">Pengaju</td>
			<td colspan="5">Kendaraan</td>
			<td colspan="2">Tujaun</td>
			<td colspan="2">PIC</td>
			<td colspan="4">Rencana</td>
			<td colspan="5">Aktual</td>
			<td rowspan="3">Status</td>
		</tr>
		<tr class="bg-gray text-center">
			<td rowspan="2">NIK</td>
			<td rowspan="2">Nama</td>
			<td rowspan="2">Jabatan</td>
			<td rowspan="2">Departemen</td>
			<td rowspan="2">Kendaraan</td>
			<td rowspan="2">Jenis Kendaraan</td>
			<td rowspan="2">Merk</td>
			<td rowspan="2">Type</td>
			<td rowspan="2">No TNKB</td>
			<td rowspan="2">Nama Group</td>
			<td rowspan="2">Tujuan</td>
			<td rowspan="2">Driver</td>
			<td rowspan="2">Pendamping</td>
			<td colspan="2">Keberangkatan</td>
			<td colspan="2">Kepulangan</td>
			<td colspan="2">Keberangkatan</td>
			<td colspan="2">Kepulangan</td>
			<td rowspan="2">Lama Perjalanan</td>
		</tr>
		<tr class="bg-gray text-center">
			<td>Tanggal</td>
			<td>Jam</td>
			<td>Tanggal</td>
			<td>Jam</td>
			<td>Tanggal</td>
			<td>Jam</td>
			<td>Tanggal</td>
			<td>Jam</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NO_URUT?></td>
				<td><?=date("Y-m-d", strtotime($key->TGL_INPUT))?></td>
				<td><a href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>" class="text-dark" target="_blank"><?=$key->NO_SPJ?></a></td>
				<td><?=$key->TGL_SPJ?></td>
				<td><?=$key->QR_CODE?></td>
				<td>
					<?php if ($key->ABNORMAL == 'Y'): ?>
						<span class="badge bg-success">Yes</span>
					<?php endif ?>
				</td>
				<td><?=$key->PIC_INPUT?></td>
				<td><?=$key->namapeg?></td>
				<td><?=$key->jabatan?></td>
				<td><?=$key->departemen?></td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NO_TNKB?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td><?=$key->LOKASI?></td>
				<td><?=$key->NIK_DRIVER.' - '.$key->NAMA_DRIVER?></td>
				<td><?=$key->PENDAMPING?></td>
				<td><?=date("Y-m-d", strtotime($key->RENCANA_BERANGKAT))?></td>
				<td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
				<td><?=date("Y-m-d", strtotime($key->RENCANA_PULANG))?></td>
				<td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
				<td><?=$key->KEBERANGKATAN == null ? '' : date("Y-m-d", strtotime($key->KEBERANGKATAN))?></td>
				<td><?=$key->KEBERANGKATAN == null ? '' : date("H:i", strtotime($key->KEBERANGKATAN))?></td>
				<?php if ($key->STATUS_PERJALANAN == 'IN'): ?>
					<td><?=date("Y-m-d", strtotime($key->KEPULANGAN))?></td>
					<td><?=date("H:i", strtotime($key->KEPULANGAN))?></td>
					<!-- <td>
						<?php
							$aktualKeberangkatan = date("Y-m-d H:i", strtotime($key->KEBERANGKATAN));
                          	$aktualKepulangan = date("Y-m-d H:i", strtotime($key->KEPULANGAN));
							$dcBerangkat = date_create($aktualKeberangkatan);
                            $dcPulang = date_create($aktualKepulangan);
                            $dcGap = date_diff($dcBerangkat, $dcPulang);
                            $tampilGapAktual = '';
                            if ($dcGap->d>0) {
                              $tampilGapAktual .= $dcGap->d.'&nbsp;Hari&nbsp;';
                            }
                            if ($dcGap->h>0) {
                              $tampilGapAktual .= $dcGap->h.'&nbsp;Jam&nbsp;';
                            }

                            if ($dcGap->i>0) {
                              $tampilGapAktual .= $dcGap->i.'&nbsp;Menit&nbsp;';
                            }
                            
                            echo '<span class="">'.$tampilGapAktual.'</span>';
						?>
					</td> -->
					<td><?=$key->INTERVAL_JAM?> Jam</td>
				<?php else: ?>
					<td></td>
					<td></td>
					<td></td>
				<?php endif ?>
				
				<td><?=$key->STATUS_SPJ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': false,
            order: [[0, 'asc']],
            info: false, 
            fixedColumns:   {
                leftColumns: 3
            },
          } ); 
	});
</script>
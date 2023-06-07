<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr>
			<th rowspan="2"></th>
			<th colspan="3">SPJ</th>
			<th colspan="5">Kendaraan</th>
			<th colspan="2">Tujuan</th>
			<th colspan="2">PIC</th>
			<th colspan="2">Keberangkatan</th>
			<th colspan="2">Kepulangan</th>
			<th colspan="3">KM</th>
			<th rowspan="2">Km Per Liter</th>
			<th rowspan="2">Terpakai (Liter)</th>
			<th colspan="4">Harga BBM</th>
			<th colspan="2">Pengaju Akses</th>
			<th rowspan="2">Status</th>
		</tr>
		<tr>
			<th>No SPJ</th>
			<th>Tanggal SPJ</th>
			<th>Jenis SPJ</th>
			<th>Kendaraan</th>
			<th>Jenis</th>
			<th>Merk</th>
			<th>Type</th>
			<th>No TNKB</th>
			<th>Group Tujuan</th>
			<th>Tujuan</th>
			<th>Driver</th>
			<th>Pendamping</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>Out</th>
			<th>In</th>
			<th>Selisih</th>
			<th>PerLiter </th>
			<th>Berdasarkan Rumus</th>
			<th>Pengajuan</th>
			<th>Selisih</th>
			<th>Tanggal</th>
			<th>PIC</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td>
					<?php if ($key->STATUS == 'OPEN'): ?>
						<button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
	                      <span class="sr-only">Toggle Dropdown</span>
	                    </button>
	                    <div class="dropdown-menu" role="menu">
	                    	<a class="dropdown-item dropButton approvePengajuan" href="javascript:;" data="<?=$key->ID?>" status="APPROVED">Approve</a>
	                    	<a class="dropdown-item dropButton approvePengajuan" href="javascript:;" data="<?=$key->ID?>" status="REJECTED">Reject</a>
	                    </div>
					<?php endif ?>
				</td>
				<td><?=$key->NO_SPJ?></td>
				<td><?=date("Y-m-d", strtotime($key->TGL_SPJ))?></td>
				<td><?=$key->NAMA_JENIS?></td>
				<td><?=$key->KENDARAAN?></td>
				<td><?=$key->JENIS_KENDARAAN?></td>
				<td><?=$key->MERK?></td>
				<td><?=$key->TYPE?></td>
				<td><?=$key->NO_TNKB?></td>
				<td><?=$key->NAMA_GROUP?></td>
				<td></td>
				<td><?=$key->NIK_DRIVER?></td>
				<td><?=$key->NAMA_DRIVER?></td>
				<td><?=date("Y-m-d", strtotime($key->KEBERANGKATAN))?></td>
				<td><?=date("H:i", strtotime($key->KEBERANGKATAN))?></td>
				<td><?=date("Y-m-d", strtotime($key->KEPULANGAN))?></td>
				<td><?=date("H:i", strtotime($key->KEPULANGAN))?></td>
				<td><?=$key->KM_OUT?></td>
				<td><?=$key->KM_IN?></td>
				<td><?=$key->SELISIH_KM?></td>
				<td><?=$key->BBMPerLiter?></td>
				<td>
					<?php
						$gapKM2 = $key->SELISIH_KM;
						$bbmPerLiter = $key->BBMPerLiter;
                   		$jmlLiter =$bbmPerLiter == 0 ? 0 : $gapKM2/$bbmPerLiter;
                        $florLiter = floor($jmlLiter);
                        $gapLiter = $jmlLiter-$florLiter;
                        if ($gapLiter>0.2) {
                        	$hasilLiter = $florLiter+1;
                        }else{
                        	$hasilLiter = $florLiter;
                        }
                        $total = $hasilLiter * $harga->HARGA;
                        echo $hasilLiter;
					?>
				</td>
				<td><?=number_format($harga->HARGA);?></td>
				<td><?=number_format($total);?></td>
				<td><?=number_format($key->BBM)?></td>
				<td><?=$total>$key->BBM?number_format($total-$key->BBM):number_format($key->BBM-$total)?></td>
				<td><?=date("Y-m-d", strtotime($key->TGL))?></td>
				<td><?=$key->PIC.' - '.$key->NAMA_PIC?></td>
				<td><span class="badge <?=$key->STATUS == 'APPROVED'?'bg-success':'bg-danger'?>"><?=$key->STATUS?></span></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
      scrollY:        "400px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      'searching': false,
      'ordering': true,
      order: [[0, 'asc']],
      
    } ); 
	});
</script>
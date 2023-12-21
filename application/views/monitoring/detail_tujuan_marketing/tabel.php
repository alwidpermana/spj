<table class="table table-bordered" width="100%" id="datatable">
	<thead>
		<tr class="text-center bg-gray">
			<th rowspan="3">No</th>
			<th rowspan="3">NIK</th>
			<th rowspan="3">Nama</th>
			<th colspan="3">Januari</th>
			<th colspan="3">Februari</th>
			<th colspan="3">Maret</th>
			<th colspan="3">April</th>
			<th colspan="3">Mei</th>
			<th colspan="3">Juni</th>
			<th colspan="3">Juli</th>
			<th colspan="3">Agustus</th>
			<th colspan="3">September</th>
			<th colspan="3">Oktober</th>
			<th colspan="3">November</th>
			<th colspan="3">Desember</th>
		</tr>
		<tr class="text-center bg-gray">
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
			<th colspan="2">Tujuan</th>
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr class="text-center bg-gray">
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
			<th>Company</th>
			<th>Kota</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$noMarketing = '';
		foreach ($data as $key): ?>
			<tr>
				<?php if ($noMarketing != $key->NO_MARKETING): ?>
					<td><?=$key->NO_MARKETING?></td>
					<td><?=$key->NIK?></td>
					<td><?=str_replace(' ', '&nbsp;', $key->NAMA)?></td>
				<?php else: ?>
					<td></td>
					<td></td>
					<td></td>	
				<?php endif ?>
				<td><?=$key->JANUARI_COMPANY?></td>
				<td><?=$key->JANUARI_KOTA?></td>
				<td><?=$key->JANUARI_JML?></td>
				<td><?=$key->FEBRUARI_COMPANY?></td>
				<td><?=$key->FEBRUARI_KOTA?></td>
				<td><?=$key->FEBRUARI_JML?></td>
				<td><?=$key->MARET_COMPANY?></td>
				<td><?=$key->MARET_KOTA?></td>
				<td><?=$key->MARET_JML?></td>
				<td><?=$key->APRIL_COMPANY?></td>
				<td><?=$key->APRIL_KOTA?></td>
				<td><?=$key->APRIL_JML?></td>
				<td><?=$key->MEI_COMPANY?></td>
				<td><?=$key->MEI_KOTA?></td>
				<td><?=$key->MEI_JML?></td>
				<td><?=$key->JUNI_COMPANY?></td>
				<td><?=$key->JUNI_KOTA?></td>
				<td><?=$key->JUNI_JML?></td>
				<td><?=$key->JULI_COMPANY?></td>
				<td><?=$key->JULI_KOTA?></td>
				<td><?=$key->JULI_JML?></td>
				<td><?=$key->AGUSTUS_COMPANY?></td>
				<td><?=$key->AGUSTUS_KOTA?></td>
				<td><?=$key->AGUSTUS_JML?></td>
				<td><?=$key->SEPTEMBER_COMPANY?></td>
				<td><?=$key->SEPTEMBER_KOTA?></td>
				<td><?=$key->SEPTEMBER_JML?></td>
				<td><?=$key->OKTOBER_COMPANY?></td>
				<td><?=$key->OKTOBER_KOTA?></td>
				<td><?=$key->OKTOBER_JML?></td>
				<td><?=$key->NOVEMBER_COMPANY?></td>
				<td><?=$key->NOVEMBER_KOTA?></td>
				<td><?=$key->NOVEMBER_JML?></td>
				<td><?=$key->DESEMBER_COMPANY?></td>
				<td><?=$key->DESEMBER_KOTA?></td>
				<td><?=$key->DESEMBER_JML?></td>
			</tr>
		<?php $noMarketing = $key->NO_MARKETING; endforeach ?>
		<!-- <?php
	        $i=0;
	        foreach ($data as $key) {
	          $row[$i] = $key;
	          $i++;
	        }
	        foreach ($row as $cell) {
	                if (isset($total[$cell->NIK]['jml'])) {
	                    $total[$cell->NIK]['jml']++;
	                } else{
	                    $total[$cell->NIK]['jml']=1;
	                }
	            }
	            $n=count($row);
	            $cekID="";
	            $no = 1;
	            for ($i=0; $i <$n ; $i++) { 
	              $cell=$row[$i];
	              $bg = $cell->NIK == "00010" ? "bedaBG" : "";
	              echo '<tr class="text-center '.$bg.'">';
	              if($cekID!=$cell->NIK){
	                echo '<td' .($total[$cell->NIK]['jml']>1?' rowspan="' .($total[$cell->NIK]['jml']).'">':'>') .$no++.'</td>';
	                echo '<td' .($total[$cell->NIK]['jml']>1?' rowspan="' .($total[$cell->NIK]['jml']).'">':'>') .$cell->NIK.'</td>';
	                echo '<td' .($total[$cell->NIK]['jml']>1?' rowspan="' .($total[$cell->NIK]['jml']).'">':'>') .$cell->NAMA.'</td>';
	                $cekID=$cell->NIK;
	              }
	              echo "<td>".$cell->JANUARI_COMPANY."</td>";
	              echo "<td>".$cell->JANUARI_KOTA."</td>";
	              echo "<td>".$cell->JANUARI_JML."</td>";
	              echo "<td>".$cell->FEBRUARI_COMPANY."</td>";
	              echo "<td>".$cell->FEBRUARI_KOTA."</td>";
	              echo "<td>".$cell->FEBRUARI_JML."</td>";
	              echo "<td>".$cell->MARET_COMPANY."</td>";
	              echo "<td>".$cell->MARET_KOTA."</td>";
	              echo "<td>".$cell->MARET_JML."</td>";
	              echo "<td>".$cell->APRIL_COMPANY."</td>";
	              echo "<td>".$cell->APRIL_KOTA."</td>";
	              echo "<td>".$cell->APRIL_JML."</td>";
	              echo "<td>".$cell->MEI_COMPANY."</td>";
	              echo "<td>".$cell->MEI_KOTA."</td>";
	              echo "<td>".$cell->MEI_JML."</td>";
	              echo "<td>".$cell->JUNI_COMPANY."</td>";
	              echo "<td>".$cell->JUNI_KOTA."</td>";
	              echo "<td>".$cell->JUNI_JML."</td>";
	              echo "<td>".$cell->JULI_COMPANY."</td>";
	              echo "<td>".$cell->JULI_KOTA."</td>";
	              echo "<td>".$cell->JULI_JML."</td>";
	              echo "<td>".$cell->AGUSTUS_COMPANY."</td>";
	              echo "<td>".$cell->AGUSTUS_KOTA."</td>";
	              echo "<td>".$cell->AGUSTUS_JML."</td>";
	              echo "<td>".$cell->SEPTEMBER_COMPANY."</td>";
	              echo "<td>".$cell->SEPTEMBER_KOTA."</td>";
	              echo "<td>".$cell->SEPTEMBER_JML."</td>";
	              echo "<td>".$cell->OKTOBER_COMPANY."</td>";
	              echo "<td>".$cell->OKTOBER_KOTA."</td>";
	              echo "<td>".$cell->OKTOBER_JML."</td>";
	              echo "<td>".$cell->NOVEMBER_COMPANY."</td>";
	              echo "<td>".$cell->NOVEMBER_KOTA."</td>";
	              echo "<td>".$cell->NOVEMBER_JML."</td>";
	              echo "<td>".$cell->DESEMBER_COMPANY."</td>";
	              echo "<td>".$cell->DESEMBER_KOTA."</td>";
	              echo "<td>".$cell->DESEMBER_JML."</td>";
                  echo '</tr>';
	            }
	      ?> -->
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
            'ordering':false,
            info: true, 
            fixedColumns:   {
            	leftColumns: 3
            },
          } ); 
	});
</script>

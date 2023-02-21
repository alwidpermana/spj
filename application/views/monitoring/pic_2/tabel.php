<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
	<thead class="text-center bg-gray">
		<tr class="bg-gray">
            <th rowspan="2">No</th>
            <th colspan="7">PIC</th>
            <th colspan="31">Tanggal</th>
            <th rowspan="2">Total</th>
        </tr>
        <tr class="bg-gray">
            <th>Subjek</th>
            <th>Rekanan</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Sub Departemen</th>
            <th>Jabatan</th>
            <?php
                for ($i=1; $i <= 31; $i++) { 
                    echo '<th>'.$i.'</th>';
                }
            ?>
        </tr>
	</thead>
	<tbody>
		<?php 
		$no = 1;
		$spj = '';
        $totalPerPIC = 0;
		foreach ($data as $key): ?>
			<tr>
				<td><?=$no++?></td>
                <td><?=$key->SUBJEK?></td>
                <td><?=$key->REKANAN?></td>
                <td><?=$key->NIK?></td>
                <td><?=$key->namapeg?></td>
                <td><?=$key->departemen?></td>
                <td><?=$key->Subdepartemen?></td>
                <td><?=$key->jabatan?></td>
                <?php
                for ($i=1; $i <= 31; $i++) {
                	$spj .='<ul style="padding-left: 10px">'; 
                    foreach ($pic as $pc) {
                    	if ($i == $pc->TGL && $key->NIK == $pc->NIK) {
                            if ($pc->NO_SPJ != NULL) {
                                $totalPerPIC += 1;
                            }
                    		$spj .='<li><a href="'.base_url().'monitoring/view_spj/'.$pc->ID_SPJ.'" class="text-dark" style="font-size:12px" target="_blank">'.$pc->NO_SPJ.'</a></li>';
                    	}
                    }
                    $spj.="</ul>";
                    echo "<td>".$spj."</td>";
                    $spj = '';
                }
                echo "<td class='text-center'>".$totalPerPIC."</td>";
            ?>

			</tr>
		<?php 
            $totalPerPIC = 0;
        endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable( {
            scrollY:        "350px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            'searching': true,
            'ordering': true,
            order: [[0, 'asc']],
            fixedColumns:   {
                leftColumns: 8
            },
            info: true, 	            
          } ); 
	});
</script>
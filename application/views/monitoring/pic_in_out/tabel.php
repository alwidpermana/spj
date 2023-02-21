<table class="table table-hover table-bordered table-striped" id="datatable" width="100%" style="font-size: 11px;">
    <thead class="text-center bg-gray">
        <tr class="bg-gray">
            <th rowspan="2">No</th>
            <th colspan="7">PIC</th>
            <th colspan="31">Tanggal</th>
            <th colspan="2">Total</th>
            <th rowspan="2">Total RP</th>
            <th rowspan="2">Jumlah SPJ</th>
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
            <th>Uang Saku</th>
            <th>Uang Makan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $noSPJ = '';
        foreach ($data as $key): 
            $totalUangMakan = 0;
            $totalUangSaku = 0;
            $jmlSPJ = 0;
        ?>
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
                        $noSPJ .='<ul style="padding-left: 10px">'; 
                        
                        foreach ($tgl as $t) {
                            if ($i == $t->JALAN && $key->NIK == $t->NIK) {
                                $noSPJ .= '<li style="padding-top: 5px">';
                                $noSPJ.='<a href="'.base_url().'monitoring/view_spj/'.$t->ID_SPJ.'" class="text-dark" style="font-size:12px" target="_blank">'.$t->NO_SPJ.'</a>';
                                $noSPJ .="<br>";
                                $noSPJ .='US=&nbsp;Rp.&nbsp;'.str_replace(',', '.', number_format($t->UANG_SAKU));
                                $noSPJ .="<br>";
                                $noSPJ .='UM=&nbsp;Rp.&nbsp;'.str_replace(',', '.', number_format($t->UANG_MAKAN));
                                $noSPJ .="<br>";
                                $noSPJ .="<b>".$t->SEBAGAI."</b>";
                                $totalUangSaku += $t->UANG_SAKU;
                                $totalUangMakan += $t->UANG_MAKAN;
                                $jmlSPJ+=1;
                            }
                        }
                        echo "<td>".$noSPJ."</td>";
                        $noSPJ .="</ul>";
                        $noSPJ = '';

                    }
                ?>
                <td><?=number_format($totalUangSaku)?></td>
                <td><?=number_format($totalUangMakan)?></td>
                <td><?=number_format($totalUangSaku + $totalUangMakan)?></td>
                <td><?=$jmlSPJ?></td>
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
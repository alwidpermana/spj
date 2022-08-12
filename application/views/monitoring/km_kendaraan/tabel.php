<table class="table table-hover table-bordered table-striped" id="datatable"  width="100%" style="font-size: 11px">
    <thead class="text-center bg-gray">
        <tr class="bg-gray">
            <th rowspan="2">No</th>
            <th colspan="6">Kendaraan</th>
            <th colspan="62">Tanggal</th>
        </tr>
        <tr class="bg-gray">
            <th>Kendaraan</th>
            <th>Jenis</th>
            <th>No Inventaris</th>
            <th>Merk</th>
            <th>Type</th>
            <th>No TNKB</th>
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
        $km = '';
        foreach ($data as $key): ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$key->KENDARAAN?></td>
                <td><?=$key->JENIS_KENDARAAN?></td>
                <td><?=$key->NO_INVENTARIS?></td>
                <td><?=$key->MERK?></td>
                <td><?=$key->TYPE?></td>
                <td><?=$key->NO_TNKB?></td>
                <?php
                    for ($i=1; $i <= 31; $i++) {
                        $km .='<ul style="padding-left: 10px">'; 
                        
                        foreach ($tgl as $t) {
                            if ($i == $t->JALAN && $key->NO_TNKB == $t->NO_TNKB) {
                                $km .= '<li style="padding-top: 5px">';
                                $km.='<a href="'.base_url().'monitoring/view_spj/'.$t->ID_SPJ.'" class="text-dark" style="font-size:12px">'.$t->NO_SPJ.'</a>';
                                $km .="<br>";
                                $km .='KM&nbsp;Out= '.str_replace(',', '.', number_format($t->KM_OUT));
                                $km .="<br>";
                                $km .='KM&nbsp;In= '.str_replace(',', '.', number_format($t->KM_IN));
                                $km .="<br>";
                                $km .="<b>Selisih&nbsp;=&nbsp;".str_replace(',', '.', number_format($t->KM_IN - $t->KM_OUT))."&nbsp;KM</b>";
                            }
                        }
                        echo "<td>".$km."</td>";
                        $km .="</ul>";
                        $km = '';
                    }
                ?>
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
            paging:         true,
            'searching': false,
            'ordering': true,
            order: [[0, 'asc']],
            fixedColumns:   {
                leftColumns: 7
            },
            info: true, 	            
          } ); 
	});
</script>
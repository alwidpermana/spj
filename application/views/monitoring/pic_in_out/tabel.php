<table class="table table-hover table-bordered table-striped" id="datatable" width="100%" style="font-size: 9px;">
    <thead class="text-center bg-gray">
        <tr class="bg-gray">
            <th rowspan="2">No</th>
            <th colspan="7">PIC</th>
            <th colspan="31">Tanggal</th>
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
        $noSPJ = '';
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
                        $noSPJ .='<ul style="padding-left: 10px">'; 
                        
                        foreach ($tgl as $t) {
                            if ($i == $t->JALAN && $key->NIK == $t->NIK) {
                                $noSPJ .= '<li style="padding-top: 5px">';
                                $noSPJ.=$t->NO_SPJ;
                                $noSPJ .="<br>";
                                $noSPJ .='Uang Saku= Rp. '.str_replace(',', '.', number_format($t->UANG_SAKU));
                                $noSPJ .="<br>";
                                $noSPJ .='Uang Makan= Rp. '.str_replace(',', '.', number_format($t->UANG_MAKAN));
                                $noSPJ .="<br>";
                                $noSPJ .="<b>".$t->SEBAGAI."</b>";
                            }
                        }
                        echo "<td>".$noSPJ."</td>";
                        $noSPJ .="</ul>";
                        $noSPJ = '';
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
                leftColumns: 8
            },
            info: true, 	            
          } ); 
	});
</script>
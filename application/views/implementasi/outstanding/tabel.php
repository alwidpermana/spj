<div class="<?=count($data)==1?'table-responsive':''?>">
    <table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
        <thead class="text-center bg-gray">
            <tr>
                <th rowspan="2"></th>
                <th rowspan="2">No</th>
                <th rowspan="2">Tanggal Input</th>
                <th rowspan="2">Jenis SPJ</th>
                <th rowspan="2">No SPJ</th>
                <th rowspan="2">Tanggal SPJ</th>
                <th rowspan="2">No Barcode</th>
                <th colspan="2">Tujuan</th>
                <th colspan="2">PIC</th>
                <th colspan="4">Pengaju</th>
                <th rowspan="2">Uang Makan</th>
                <th rowspan="2">Uang Jalan</th>
                <th rowspan="2">BBM</th>
                <th colspan="2">Uang Saku 2</th>
                <th rowspan="2">Makan Ke 2</th>
                <th colspan="3">Tanggal Closing</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                <th>Group Tujuan</th>
                <th>Tujuan</th>
                <th>Driver</th>
                <th>Pendamping</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Jabatan</th>
                <th>Jam Ke 1 - 3</th>
                <th>Jam Ke > 4</th>
                <th>Pengajuan</th>
                <th>Keputusan</th>
                <th>GAP</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($data as $key): ?>
                <tr>
                    <td>
                        <button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>">Lihat SPJ</a>
                            <a class="dropdown-item dropButton btnKeputusan" href="javascript:;" no_spj = "<?=$key->NO_SPJ?>" nik = "<?=$key->PIC_INPUT?>" jenisSPJ = "<?=$key->NAMA_JENIS?>" idSPJ = "<?=$key->ID_SPJ?>">Keputusan Otoritas</a>
                        </div>
                    </td>
                    <td><?=$no++?></td>
                    <td><?=$key->TGL_INPUT?></td>
                    <td><?=$key->NAMA_JENIS?></td>
                    <td><?=$key->NO_SPJ?></td>
                    <td><?=$key->TGL_SPJ?></td>
                    <td><?=$key->QR_CODE?></td>
                    <td><?=$key->NAMA_GROUP?></td>
                    <td>
                        <ul style="padding-left: 10px">
                        <?php foreach ($tujuan as $lok): ?>
                            <?php if ($lok->NO_SPJ == $key->NO_SPJ): ?>
                                <li><?=$lok->SERLOK_KOTA?></li>
                            <?php endif ?>
                        <?php endforeach ?>
                        </ul>
                    </td>
                    <td><?=$key->PIC_DRIVER?></td>
                    <td>
                        <ul style="padding-left: 10px">
                        <?php
                            $picPendamping = $this->M_Monitoring->getPICPendampingByNoSPJ_v2($key->NO_SPJ);
                            echo $picPendamping;
                        ?>
                        </ul>
                    </td>
                    <td><?=$key->PIC_INPUT?></td>
                    <td><?=$key->NAMA_INPUT?></td>
                    <td><?=$key->DEPARTEMEN_INPUT?></td>
                    <td><?=$key->JABATAN_INPUT?></td>
                    <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN))?></td>
                    <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN))?></td>
                    <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM))?></td>
                    <td class="text-center"><?=$key->CHECK_UANG_SAKU1 =='Y'?'<i class="fas fa-check"></i>':''?></td>
                    <td class="text-center"><?=$key->CHECK_UANG_SAKU2 =='Y'?'<i class="fas fa-check"></i>':''?></td>
                    <td class="text-center"><?=$key->CHECK_UANG_MAKAN=='Y'?'<i class="fas fa-check"></i>':''?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=$key->STATUS_SPJ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>    
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var jmlData= '<?=count($data)?>';
        if (jmlData == '1') {
            var table = $('#datatable').DataTable( {
                paging:         false,
                'searching': false,
                'ordering': true,
                order: [[0, 'asc']],
                
              } ); 
        }else{
            var table = $('#datatable').DataTable( {
                scrollY:        "350px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                'searching': false,
                'ordering': true,
                order: [[0, 'asc']],
                
              } );     
        }
        
	});
</script>
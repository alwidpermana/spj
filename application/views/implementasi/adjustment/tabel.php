<table class="table table-hover table-bordered table-striped" id="datatable" width="100%">
    <thead class="text-center bg-gray">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tanggal Input</th>
            <th rowspan="2">No SPJ</th>
            <th rowspan="2">Tanggal SPJ</th>
            <th rowspan="2">No Barcode</th>
            <th colspan="2">Tujuan</th>
            <th colspan="2">PIC</th>
            <th rowspan="2">Status</th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th>Group Tujuan</th>
            <th>Tujuan</th>
            <th>Driver</th>
            <th>Pendamping</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach ($data as $key): ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$key->TGL_INPUT?></td>
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
                <td>
                    <?=$key->PIC_DRIVER?>
                </td>
                <td>
                    <ul style="padding-left: 10px">
                    <?php foreach ($pic as $pc): ?>
                        <?php if ($pc->NO_PENGAJUAN == $key->NO_SPJ): ?>
                            <li><?=$pc->PIC?></li>
                        <?php endif ?>
                    <?php endforeach ?>
                    </ul>
                </td>
                <td><?=$key->STATUS_SPJ?></td>
                <td>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item dropButton" href="<?=base_url()?>monitoring/view_spj/<?=$key->ID_SPJ?>">Lihat SPJ</a>
                        <a class="dropdown-item dropButton btnPengajuan" href="javascript:;" no_spj = "<?=$key->NO_SPJ?>" nik = "<?=$key->PIC_INPUT?>">Pengajuan Adjustment</a>
                    </div>
                </td>
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
            'ordering': true,
            order: [[0, 'asc']],
            
          } ); 
	});
</script>
<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
    <thead class="bg-gray text-center">
        <tr>
            <td>No</td>
            <td>Tanggal Input</td>
            <td>Kendaraan</td>
            <td>Kepemilikan</td>
            <td>Jenis Kendaraan</td>
            <td>No Inventaris</td>
            <td>Merk</td>
            <td>Type</td>
            <td>No TNKB</td>
            <td>Tahun Kendaraan</td>
            <td>Jenis BBM</td>
            <td>Konsumsi BBM</td>
            <td>Status</td>
            <td>Foto Kendaraan</td>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        foreach ($data as $key):?>
            <tr>
                <td><?=$i++?></td>
                <td><?=date("Y-m-d", strtotime($key->TglInput))?></td>
                <td><?=$key->Jenis?></td>
                <td><?=$key->Pemakai?></td>
                <td>
                    <select class="select2 form-control inputJenisKendaraan" style="font-size: 12px;" data = '<?=$key->NoTNKB?>'>
                            <option value="">No Data</option>
                        <?php foreach ($jenis as $key2): ?>
                            <option value="<?=$key2->JENIS_KENDARAAN?>" <?=$key->Kategori == $key2->JENIS_KENDARAAN?'selected':''?>><?=$key2->JENIS_KENDARAAN?></option>
                        <?php endforeach ?>    
                    </select>
                    
                    
                    
                </td>
                <td><?=$key->NoInventaris?></td>
                <td><?=$key->Merk?></td>
                <td><?=$key->Type?></td>
                <td><?=$key->NoTNKB?></td>
                <td><?=$key->ThnBuat?></td>
                <td><?=$key->BahanBakar?></td>
                <td>
                    <input type="number" class="form-control form-control-sm inputBBMPerLiter" value="<?=$key->BBMPerLiter?>" step=".01" data="<?=$key->NoTNKB?>">
                </td>
                <td><?=$key->StatusAktif?></td>
                <td class="text-center">
                    <a 
                      href="<?=base_url()?>Data_Master/Gambar_Kendaraan/<?=str_replace(' ','_',$key->NoTNKB)?>"
                      class="btn btn-danger btn-kps btn-sm">
                        <i class="fas fa-image"></i>
                    </a>
                </td>
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
            paging:         true,
            'searching': false,
            order: [[0, 'asc']],
            info: true,  
          } ); 
	});
</script>
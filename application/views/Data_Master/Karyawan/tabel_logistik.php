<table class="table table-hover table-striped table-bordered" id="datatable" width="100%">
    <thead class="text-center bg-gray">
        <tr>
            <td></td>
            <td>Kode Supir</td>
            <td>Nama Supir</td>
            <td>Alamat</td>
            <td>No KTP</td>
            <td>Jabatan</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key): ?>
            <tr>
                <td>
                    <a href="<?=base_url()?>Data_Master/Edit_Karyawan/<?=$key->nik?>/logistik" class="btn btn-danger btn-kps btn-sm btn-block">
                        <i class="fas fa-user-pen"></i>
                    </a>
                </td>
                <td><?=$key->nik?></td>
                <td><?=$key->namapeg?></td>
                <td><?=$key->AlamatSopir?></td>
                <td><?=$key->no_ktp?></td>
                <td><?=$key->jabatan?></td>
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
            order: [[1, 'asc']],
            info: false,  
            columnDefs: [
	            { orderable: false, targets: 0 }
	        ],
          } ); 
	});
</script>
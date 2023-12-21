<table class="table table-hover table-bordered" id="datatable" width="100%">
	<thead class="bg-gray text-center">
		<tr class="bg-gray">
			<th rowspan="2">NIK</th>
			<th rowspan="2">Nama</th>
			<th colspan="9">Januari</th>
			<th colspan="9">Februari</th>
			<th colspan="9">Maret</th>
			<th colspan="9">April</th>
			<th colspan="9">Mei</th>
			<th colspan="9">Juni</th>
			<th colspan="9">Juli</th>
			<th colspan="9">Agustus</th>
			<th colspan="9">September</th>
			<th colspan="9">Oktober</th>
			<th colspan="9">November</th>
			<th colspan="9">Desember</th>
			<th colspan="9">Total</th>
		</tr>
		<tr class="bg-gray">
			<?php
				for ($i=0; $i <13 ; $i++) { 
					echo '<th>Jumlah SPJ</th>
							<th>Uang Saku</th>
							<th>Uang Makan</th>
							<th>BBM</th>
							<th>TOL</th>
							<th>Uang Jalan</th>
							<th>Tambahan Uang Saku</th>
							<th>Tambahan Uang Makan</th>
							<th>KM</th>';		
				}
			?>
			
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $key): ?>
			<tr>
				<td><?=$key->NIK?></td>
				<td><?=$key->NAMA?></td>
				<td><?=$key->JANUARI_JML_SPJ == NULL ? '' : number_format($key->JANUARI_JML_SPJ)?></td>
				<td><?=$key->JANUARI_TOTAL_UANG_SAKU == null ? '' : number_format($key->JANUARI_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->JANUARI_TOTAL_UANG_MAKAN == null ? '' : number_format($key->JANUARI_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->JANUARI_TOTAL_BBM == null ? '' : number_format($key->JANUARI_TOTAL_BBM)?></td>
				<td><?=$key->JANUARI_TOTAL_TOL == null ? '' : number_format($key->JANUARI_TOTAL_TOL)?></td>
				<td><?=$key->JANUARI_TOTAL_JALAN == null ? '' : number_format($key->JANUARI_TOTAL_JALAN)?></td>
				<td><?=$key->JANUARI_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->JANUARI_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->JANUARI_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->JANUARI_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->JANUARI_KM == null ? '' : number_format($key->JANUARI_KM)?></td>
				<td><?=$key->FEBRUARI_JML_SPJ == NULL ? '' : number_format($key->FEBRUARI_JML_SPJ)?></td>
				<td><?=$key->FEBRUARI_TOTAL_UANG_SAKU == null ? '' : number_format($key->FEBRUARI_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->FEBRUARI_TOTAL_UANG_MAKAN == null ? '' : number_format($key->FEBRUARI_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->FEBRUARI_TOTAL_BBM == null ? '' : number_format($key->FEBRUARI_TOTAL_BBM)?></td>
				<td><?=$key->FEBRUARI_TOTAL_TOL == null ? '' : number_format($key->FEBRUARI_TOTAL_TOL)?></td>
				<td><?=$key->FEBRUARI_TOTAL_JALAN == null ? '' : number_format($key->FEBRUARI_TOTAL_JALAN)?></td>
				<td><?=$key->FEBRUARI_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->FEBRUARI_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->FEBRUARI_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->FEBRUARI_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->FEBRUARI_KM == null ? '' : number_format($key->FEBRUARI_KM)?></td>
				<td><?=$key->MARET_JML_SPJ == NULL ? '' : number_format($key->MARET_JML_SPJ)?></td>
				<td><?=$key->MARET_TOTAL_UANG_SAKU == null ? '' : number_format($key->MARET_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->MARET_TOTAL_UANG_MAKAN == null ? '' : number_format($key->MARET_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->MARET_TOTAL_BBM == null ? '' : number_format($key->MARET_TOTAL_BBM)?></td>
				<td><?=$key->MARET_TOTAL_TOL == null ? '' : number_format($key->MARET_TOTAL_TOL)?></td>
				<td><?=$key->MARET_TOTAL_JALAN == null ? '' : number_format($key->MARET_TOTAL_JALAN)?></td>
				<td><?=$key->MARET_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->MARET_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->MARET_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->MARET_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->MARET_KM == null ? '' : number_format($key->MARET_KM)?></td>
				<td><?=$key->APRIL_JML_SPJ == NULL ? '' : number_format($key->APRIL_JML_SPJ)?></td>
				<td><?=$key->APRIL_TOTAL_UANG_SAKU == null ? '' : number_format($key->APRIL_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->APRIL_TOTAL_UANG_MAKAN == null ? '' : number_format($key->APRIL_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->APRIL_TOTAL_BBM == null ? '' : number_format($key->APRIL_TOTAL_BBM)?></td>
				<td><?=$key->APRIL_TOTAL_TOL == null ? '' : number_format($key->APRIL_TOTAL_TOL)?></td>
				<td><?=$key->APRIL_TOTAL_JALAN == null ? '' : number_format($key->APRIL_TOTAL_JALAN)?></td>
				<td><?=$key->APRIL_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->APRIL_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->APRIL_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->APRIL_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->APRIL_KM == null ? '' : number_format($key->APRIL_KM)?></td>
				<td><?=$key->MEI_JML_SPJ == NULL ? '' : number_format($key->MEI_JML_SPJ)?></td>
				<td><?=$key->MEI_TOTAL_UANG_SAKU == null ? '' : number_format($key->MEI_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->MEI_TOTAL_UANG_MAKAN == null ? '' : number_format($key->MEI_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->MEI_TOTAL_BBM == null ? '' : number_format($key->MEI_TOTAL_BBM)?></td>
				<td><?=$key->MEI_TOTAL_TOL == null ? '' : number_format($key->MEI_TOTAL_TOL)?></td>
				<td><?=$key->MEI_TOTAL_JALAN == null ? '' : number_format($key->MEI_TOTAL_JALAN)?></td>
				<td><?=$key->MEI_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->MEI_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->MEI_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->MEI_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->MEI_KM == null ? '' : number_format($key->MEI_KM)?></td>
				<td><?=$key->JUNI_JML_SPJ == NULL ? '' : number_format($key->JUNI_JML_SPJ)?></td>
				<td><?=$key->JUNI_TOTAL_UANG_SAKU == null ? '' : number_format($key->JUNI_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->JUNI_TOTAL_UANG_MAKAN == null ? '' : number_format($key->JUNI_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->JUNI_TOTAL_BBM == null ? '' : number_format($key->JUNI_TOTAL_BBM)?></td>
				<td><?=$key->JUNI_TOTAL_TOL == null ? '' : number_format($key->JUNI_TOTAL_TOL)?></td>
				<td><?=$key->JUNI_TOTAL_JALAN == null ? '' : number_format($key->JUNI_TOTAL_JALAN)?></td>
				<td><?=$key->JUNI_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->JUNI_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->JUNI_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->JUNI_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->JUNI_KM == null ? '' : number_format($key->JUNI_KM)?></td>
				<td><?=$key->JULI_JML_SPJ == NULL ? '' : number_format($key->JULI_JML_SPJ)?></td>
				<td><?=$key->JULI_TOTAL_UANG_SAKU == null ? '' : number_format($key->JULI_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->JULI_TOTAL_UANG_MAKAN == null ? '' : number_format($key->JULI_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->JULI_TOTAL_BBM == null ? '' : number_format($key->JULI_TOTAL_BBM)?></td>
				<td><?=$key->JULI_TOTAL_TOL == null ? '' : number_format($key->JULI_TOTAL_TOL)?></td>
				<td><?=$key->JULI_TOTAL_JALAN == null ? '' : number_format($key->JULI_TOTAL_JALAN)?></td>
				<td><?=$key->JULI_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->JULI_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->JULI_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->JULI_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->JULI_KM == null ? '' : number_format($key->JULI_KM)?></td>
				<td><?=$key->AGUSTUS_JML_SPJ == NULL ? '' : number_format($key->AGUSTUS_JML_SPJ)?></td>
				<td><?=$key->AGUSTUS_TOTAL_UANG_SAKU == null ? '' : number_format($key->AGUSTUS_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->AGUSTUS_TOTAL_UANG_MAKAN == null ? '' : number_format($key->AGUSTUS_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->AGUSTUS_TOTAL_BBM == null ? '' : number_format($key->AGUSTUS_TOTAL_BBM)?></td>
				<td><?=$key->AGUSTUS_TOTAL_TOL == null ? '' : number_format($key->AGUSTUS_TOTAL_TOL)?></td>
				<td><?=$key->AGUSTUS_TOTAL_JALAN == null ? '' : number_format($key->AGUSTUS_TOTAL_JALAN)?></td>
				<td><?=$key->AGUSTUS_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->AGUSTUS_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->AGUSTUS_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->AGUSTUS_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->AGUSTUS_KM == null ? '' : number_format($key->AGUSTUS_KM)?></td>
				<td><?=$key->SEPTEMBER_JML_SPJ == NULL ? '' : number_format($key->SEPTEMBER_JML_SPJ)?></td>
				<td><?=$key->SEPTEMBER_TOTAL_UANG_SAKU == null ? '' : number_format($key->SEPTEMBER_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->SEPTEMBER_TOTAL_UANG_MAKAN == null ? '' : number_format($key->SEPTEMBER_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->SEPTEMBER_TOTAL_BBM == null ? '' : number_format($key->SEPTEMBER_TOTAL_BBM)?></td>
				<td><?=$key->SEPTEMBER_TOTAL_TOL == null ? '' : number_format($key->SEPTEMBER_TOTAL_TOL)?></td>
				<td><?=$key->SEPTEMBER_TOTAL_JALAN == null ? '' : number_format($key->SEPTEMBER_TOTAL_JALAN)?></td>
				<td><?=$key->SEPTEMBER_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->SEPTEMBER_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->SEPTEMBER_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->SEPTEMBER_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->SEPTEMBER_KM == null ? '' : number_format($key->SEPTEMBER_KM)?></td>
				<td><?=$key->OKTOBER_JML_SPJ == NULL ? '' : number_format($key->OKTOBER_JML_SPJ)?></td>
				<td><?=$key->OKTOBER_TOTAL_UANG_SAKU == null ? '' : number_format($key->OKTOBER_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->OKTOBER_TOTAL_UANG_MAKAN == null ? '' : number_format($key->OKTOBER_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->OKTOBER_TOTAL_BBM == null ? '' : number_format($key->OKTOBER_TOTAL_BBM)?></td>
				<td><?=$key->OKTOBER_TOTAL_TOL == null ? '' : number_format($key->OKTOBER_TOTAL_TOL)?></td>
				<td><?=$key->OKTOBER_TOTAL_JALAN == null ? '' : number_format($key->OKTOBER_TOTAL_JALAN)?></td>
				<td><?=$key->OKTOBER_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->OKTOBER_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->OKTOBER_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->OKTOBER_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->OKTOBER_KM == null ? '' : number_format($key->OKTOBER_KM)?></td>
				<td><?=$key->NOVEMBER_JML_SPJ == NULL ? '' : number_format($key->NOVEMBER_JML_SPJ)?></td>
				<td><?=$key->NOVEMBER_TOTAL_UANG_SAKU == null ? '' : number_format($key->NOVEMBER_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->NOVEMBER_TOTAL_UANG_MAKAN == null ? '' : number_format($key->NOVEMBER_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->NOVEMBER_TOTAL_BBM == null ? '' : number_format($key->NOVEMBER_TOTAL_BBM)?></td>
				<td><?=$key->NOVEMBER_TOTAL_TOL == null ? '' : number_format($key->NOVEMBER_TOTAL_TOL)?></td>
				<td><?=$key->NOVEMBER_TOTAL_JALAN == null ? '' : number_format($key->NOVEMBER_TOTAL_JALAN)?></td>
				<td><?=$key->NOVEMBER_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->NOVEMBER_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->NOVEMBER_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->NOVEMBER_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->NOVEMBER_KM == null ? '' : number_format($key->NOVEMBER_KM)?></td>
				<td><?=$key->DESEMBER_JML_SPJ == NULL ? '' : number_format($key->DESEMBER_JML_SPJ)?></td>
				<td><?=$key->DESEMBER_TOTAL_UANG_SAKU == null ? '' : number_format($key->DESEMBER_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->DESEMBER_TOTAL_UANG_MAKAN == null ? '' : number_format($key->DESEMBER_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->DESEMBER_TOTAL_BBM == null ? '' : number_format($key->DESEMBER_TOTAL_BBM)?></td>
				<td><?=$key->DESEMBER_TOTAL_TOL == null ? '' : number_format($key->DESEMBER_TOTAL_TOL)?></td>
				<td><?=$key->DESEMBER_TOTAL_JALAN == null ? '' : number_format($key->DESEMBER_TOTAL_JALAN)?></td>
				<td><?=$key->DESEMBER_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->DESEMBER_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->DESEMBER_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->DESEMBER_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->DESEMBER_KM == null ? '' : number_format($key->DESEMBER_KM)?></td>
				<td><?=$key->TOTAL_JML_SPJ == NULL ? '' : number_format($key->TOTAL_JML_SPJ)?></td>
				<td><?=$key->TOTAL_TOTAL_UANG_SAKU == null ? '' : number_format($key->TOTAL_TOTAL_UANG_SAKU)?></td>
				<td><?=$key->TOTAL_TOTAL_UANG_MAKAN == null ? '' : number_format($key->TOTAL_TOTAL_UANG_MAKAN)?></td>
				<td><?=$key->TOTAL_TOTAL_BBM == null ? '' : number_format($key->TOTAL_TOTAL_BBM)?></td>
				<td><?=$key->TOTAL_TOTAL_TOL == null ? '' : number_format($key->TOTAL_TOTAL_TOL)?></td>
				<td><?=$key->TOTAL_TOTAL_JALAN == null ? '' : number_format($key->TOTAL_TOTAL_JALAN)?></td>
				<td><?=$key->TOTAL_TAMBAHAN_UANG_SAKU == null ? '' : number_format($key->TOTAL_TAMBAHAN_UANG_SAKU)?></td>
				<td><?=$key->TOTAL_TAMBAHAN_UANG_MAKAN == null ? '' : number_format($key->TOTAL_TAMBAHAN_UANG_MAKAN)?></td>
				<td><?=$key->TOTAL_KM == null ? '' : number_format($key->TOTAL_KM)?></td>
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
            order: [[0, 'asc']],
            info: true, 
            fixedColumns:   {
            	leftColumns: 2
            },
          } ); 
	});
</script>
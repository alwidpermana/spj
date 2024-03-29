<div class="row">
  <div class="col-md-12">
    <table class="table table-hover table-bordered table-striped" id="datatable" width="100%" style="font-size: 12px">
      <thead>
        <tr class="text-center bg-gray">
          <th rowspan="2">No</th>
          <th rowspan="2">Tanggal Input</th>
          <th rowspan="2">No SPJ / No Generate</th>
          <th rowspan="2">Tanggal SPJ</th>
          <th rowspan="2">No Barcode</th>
          <th rowspan="2">Transaksi</th>
          <th colspan="2">Tujuan</th>
          <th colspan="2">PIC</th>
          <th colspan="6">Kendaraan</th>
          <th rowspan="2">Status</th>
          <?php if ($status == ''): ?>
            <th colspan="3">Kas Induk</th>
            <th colspan="3">Sub Kas</th>
            <th rowspan="2">Jumlah Saldo</th>
            <th rowspan="2">Outstanding</th>  
          <?php else: ?>
            <th colspan="2">Sub Kas</th>
          <?php endif ?>
          
        </tr>
        <tr class="text-center bg-gray">
          <th>Group Tujuan</th>
          <th>Tujuan</th>
          <th>Driver</th>
          <th>Pendamping</th>
          <th>Kendaraan</th>
          <th>Jenis</th>
          <th>No Inventaris</th>
          <th>Merk</th>
          <th>Type</th>
          <th>No TNKB</th>
          <?php if ($status == ''): ?>
            <th>D</th>
            <th>C</th>
            <th>Saldo</th>
            <th>D</th>
            <th>C</th>
            <th>Saldo</th>
          <?php else: ?>
            <th>D</th>
            <th>C</th>
          <?php endif ?>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i = 1;
        foreach ($data as $key): ?>
          <tr class="<?=$key->DETAIL_KASBON == 'BIAYA TAMBAHAN'?'text-kps':''?>" style="font-size: 9px;">
            <td><?=$key->NO_URUT?></td>
            <td><?=date("d F Y", strtotime($key->TGL_INPUT))?></td>
            <td>
              <?php
              $url = $key->JENIS_FK == 'KASBON'?'monitoring/view_spj/'.$key->FK_ID:'monitoring/generate_spj';
              ?>
              <a href="<?=base_url()?><?=$url?>" class="btn <?=$key->DETAIL_KASBON == 'BIAYA TAMBAHAN'?'text-kps':''?>" style="font-size: 9px;">
                <?=$key->NO_SPJ==null?$key->NO_GENERATE:$key->NO_SPJ?>
              </a>
              
                
            </td>
            <td><?=$key->TGL_SPJ == null ? '' :date("d F Y", strtotime($key->TGL_SPJ))?></td>
            <td><?=$key->QR_CODE?></td>
            <td><?=$key->JENIS_KASBON?></td>
            <td><?=$key->NAMA_GROUP?></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?=$key->KENDARAAN?></td>
            <td><?=$key->JENIS_KENDARAAN?></td>
            <td><?=$key->NO_INVENTARIS?></td>
            <td><?=$key->MERK?></td>
            <td><?=$key->TYPE?></td>
            <td><?=$key->NO_TNKB?></td>
            <td><?=$key->STATUS_SPJ?></td>
            <?php if ($status == ''): ?>
              <td class="<?=$key->JENIS_FK == 'KAS INTERNAL'?'text-kps':''?>" style="font-size: 9px;">
                <?=$key->DEBIT_INDUK==0?'':str_replace(',', '.', number_format($key->DEBIT_INDUK))?>
              </td>
              <td><?=$key->CREDIT_INDUK==0?'':str_replace(',', '.', number_format($key->CREDIT_INDUK))?></td>
              <td><?=str_replace(',', '.', number_format($key->SALDO_INDUK))?></td>
              <td><?=$key->DEBIT_SUB==0?'':str_replace(',', '.', number_format($key->DEBIT_SUB))?></td>
              <td class="<?=$key->JENIS_FK=='BIAYA ADMIN'?'text-kps':''?>" style="font-size: 9px;">
                <?=$key->CREDIT_SUB==0?'':str_replace(',', '.', number_format($key->CREDIT_SUB))?>
              </td>
              <td><?=str_replace(',', '.', number_format($key->SALDO_SUB))?></td>
              <td><?=str_replace(',', '.', number_format($key->TOTAL_SALDO))?></td>
              <td><?=str_replace(',', '.', number_format($key->OUTSTANDING_SALDO))?></td>  
            <?php else: ?>
              <td><?=$key->DEBIT_SUB==0?'':str_replace(',', '.', number_format($key->DEBIT_SUB))?></td>
              <td class="<?=$key->JENIS_FK=='BIAYA ADMIN'?'text-kps':''?>" style="font-size: 9px;">
                <?=$key->CREDIT_SUB==0?'':str_replace(',', '.', number_format($key->CREDIT_SUB))?>
              </td>
            <?php endif ?>
            
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
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
      info: false, 
    } ); 
	});
</script>
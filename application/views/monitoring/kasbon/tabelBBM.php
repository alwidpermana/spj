<div class="row">
  <div class="col-md-12">
    <table class="table table-hover table-bordered table-striped" id="datatable" width="100%" style="font-size: 9px">
      <thead class="text-center bg-gray">
        <tr>
          <th rowspan="2">No</th>
          <th rowspan="2">Tanggal Input</th>
          <th rowspan="2">No SPJ</th>
          <th rowspan="2">Tanggal SPJ</th>
          <th rowspan="2">No Barcode</th>
          <th rowspan="2">Jenis SPJ</th>
          <th rowspan="2">Transaksis</th>
          <th rowspan="2">No Voucher BBM</th>
          <th rowspan="2">Status</th>
          <th colspan="3">Kas Induk</th>
          <th colspan="3">SPBU / Sub Kas</th>
          <th rowspan="2">Jumlah Saldo</th>
          <th rowspan="2">Outstanding</th>
        </tr>
        <tr>
          <th>D</th>
          <th>C</th>
          <th>Saldo</th>
          <th>D</th>
          <th>C</th>
          <th>Saldo</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i = 1;
        foreach ($data as $key): ?>
          <tr>
            <td><?=$i++?></td>
            <td><?=date("d F Y", strtotime($key->TGL_INPUT))?></td>
            <td><?=$key->NO_SPJ?></td>
            <td><?=$key->TGL_SPJ == null ? '' :date("d F Y", strtotime($key->TGL_SPJ))?></td>
            <td><?=$key->QR_CODE?></td>
            <td><?=$key->NAMA_JENIS?></td>
            <td><?=$key->JENIS_KASBON?></td>
            <td><?=$key->VOUCHER_BBM?></td>
            <td><?=$key->STATUS_SPJ?></td>
            <td class="<?=$key->JENIS_FK == 'KAS INTERNAL'?'text-kps':''?>" style="font-size: 9px;">
              <?=$key->DEBIT_INDUK==0?'':str_replace(',', '.', number_format($key->DEBIT_INDUK))?>
            </td>
            <td><?=$key->CREDIT_INDUK==0?'':str_replace(',', '.', number_format($key->CREDIT_INDUK))?></td>
            <td><?=str_replace(',', '.', number_format($key->SALDO_INDUK))?></td>
            <td><?=$key->DEBIT_SUB==0?'':str_replace(',', '.', number_format($key->DEBIT_SUB))?></td>
            <td><?=$key->CREDIT_SUB==0?'':str_replace(',', '.', number_format($key->CREDIT_SUB))?></td>
            <td><?=str_replace(',', '.', number_format($key->SALDO_SUB))?></td>
            <td><?=str_replace(',', '.', number_format($key->TOTAL_SALDO))?></td>
            <td><?=str_replace(',', '.', number_format($key->OUTSTANDING_SALDO))?></td>
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
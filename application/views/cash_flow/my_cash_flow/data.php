<style type="text/css">
  ::-webkit-scrollbar {
    width: 18px;
  }
  ::-webkit-scrollbar-track {
    background-color: transparent;
  }
  ::-webkit-scrollbar-thumb {
    background-color: #d6dee1;
  }
  ::-webkit-scrollbar-thumb {
    background-color: #d6dee1;
    border-radius: 18px;
  }
  ::-webkit-scrollbar-thumb {
    background-color: #d6dee1;
    border-radius: 18px;
    border: 6px solid transparent;
    background-clip: content-box;
  }
  tbody{
    background-color: white;
  }
  table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
  }
  table tr th,
  table tr td {
    border-right: 1px solid #dee2e6 !important;
    border-bottom: 1px solid #dee2e6 !important;
  }
  table tr th:first-child,
  table tr td:first-child {
    border-left: 1px solid #dee2e6 !important;
  }
  table tr th {
    border-top: 1px solid #dee2e6 !important;
  }

  table tr:first-child th:first-child {
    border-top-left-radius: 0.25rem !important;
  }

  table tr:first-child th:last-child {
    border-top-right-radius: 0.25rem !important;
  }

  table tr:last-child td:first-child {
    border-bottom-left-radius: 0.25rem !important;
  }

  table tr:last-child td:last-child {
    border-bottom-right-radius: 0.25rem !important;
  }
</style>
<div class="">
  <div class="">
    <div class="row">
      <div class="col-md-12 table-responsive">
        <table class="table table-centered table-hover table-bordered table-nowrap mb-0 mt-0" id="datatable" width="100%">
          <thead class="text-center bg-gray thead-fixed">
            <tr>
              <th rowspan="2">No</th>
              <th colspan="7">Pengajuan</th>
              <th colspan="5">Approve</th>
              <th colspan="4">Receive</th>
              <th rowspan="2">Status Pengajuan</th>
            </tr>
            <tr>
              
              <th>Tanggal</th>
              <th>Transaksi</th>
              <th>Jenis SPJ</th>
              <th>Jenis Kasbon</th>
              <th>Type</th>
              <th>PIC</th>
              <th>RP</th>
              <th>Tanggal</th>
              <th>Type</th>
              <th>PIC</th>
              <th>Delay</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>PIC</th>
              <th>Delay</th>
              <th>Status</th>
              
            </tr>
          </thead>
          <tbody class="tbody-fixed">
            <?php 
            $i = 1;
            foreach ($data as $key): ?>
              <tr>
                <td><?=$i++?></td>
                <td><?=date("d F Y", strtotime($key->TGL_PENGAJU))?></td>
                <td><?=$key->TRANSAKSI?></td>
                <td><?=$key->NAMA_JENIS?></td>
                <td><?=$key->JENIS_KASBON?></td>
                <td><?=$key->TYPE?></td>
                <td>
                  <?=$key->PIC_PENGAJU?>
                  <br>
                  <?=$key->NAMA_PENGAJU?>
                </td>
                <td><?=str_replace(',', '.', number_format($key->JUMLAH))?></td>
                <?php if ($key->STATUS_PENGAJUAN_SALDO == 'OPEN' && $key->STATUS_APPROVE == null): ?>
                  <td colspan="5" class="text-center">
                    <button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown">
                        Approve Pengajuan
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a 
                          class="dropdown-item dropButton approvePengajuan" 
                          data="<?=$key->ID?>" 
                          status="APPROVED" 
                          href="javascript:;"
                          jenisKasbon = "<?=$key->JENIS_KASBON?>"
                          jenisSPJ = "<?=$key->NAMA_JENIS?>"
                          jumlah="<?=$key->JUMLAH?>">Approve</a>
                        <a class="dropdown-item dropButton approvePengajuan" data="<?=$key->ID?>" status="REJECTED" href="javascript:;">Reject</a>
                      </div>
                    
                  </td>
                  <td style="display: none"></td>
                  <td style="display: none"></td>
                  <td style="display: none"></td>
                  <td style="display: none"></td>
                <?php else: ?>
                  <td><?=$key->TGL_APPROVE==null?'':date("d F Y", strtotime($key->TGL_APPROVE))?></td>
                  <td><?=$key->PIC_APPROVE?><br><?=$key->NAMA_APPROVE?></td>
                  <td><?=$key->TRANSAKSI == 'Pinbuk'?'Kas Induk':'Treasury'?></td>
                  <td>
                    <?php
                      $tglPengajuan = date("Y-m-d", strtotime($key->TGL_PENGAJU));
                      $tglApprove = $key->TGL_APPROVE == null?date("Y-m-d"):date("Y-m-d", strtotime($key->TGL_APPROVE));

                      $createPengajuan = date_create($tglPengajuan);
                      $createApprove = date_create($tglApprove);
                      $gapApprove = date_diff($createPengajuan, $createApprove);
                      if ($gapApprove->d>0) {
                        echo '<span class="text-danger">'.$gapApprove->d.' Hari</span>';
                      } else {
                        echo $gapApprove.' Hari';
                      }
                      
                      
                    ?>
                  </td>
                  <td><?=$key->STATUS_APPROVE?></td>  
                <?php endif ?>
                
                <td><?=$key->TGL_RECEIVE==null?'':date("d F Y", strtotime($key->TGL_RECEIVE))?></td>
                <td>
                  <?=$key->PIC_RECEIVE?><br>
                  <?=$key->NAMA_RECEIVE?>
                </td>
                <td>
                  <?php
                    if ($key->STATUS_RECEIVE == 'RECEIVED') {
                      $tglReceive = $key->TGL_RECEIVE == null?date("Y-m-d"):date("Y-m-d", strtotime($key->TGL_RECEIVE));
                      $createReceive = date_create($tglReceive);
                      $gapReceive = date_diff($createApprove, $createReceive);
                      
                      if ($gapReceive->d > 0) {
                        echo '<span class="text-danger">'.$gapReceive->d.' Hari</span>';
                      }else{
                        echo $gapReceive->d.' Hari';
                      }
                    }
                  ?>
                </td>
                <td><?=$key->STATUS_RECEIVE?></td>
                <td class="text-center">
                  <?php if ($key->STATUS_PENGAJUAN_SALDO == 'CLOSE'): ?>
                    <span class="badge bg-success">CLOSE</span>
                  <?php elseif($key->STATUS_PENGAJUAN_SALDO == 'REJECTED'):?>
                    <span class="badge bg-danger">REJECTED</span>
                  <?php elseif($key->STATUS_PENGAJUAN_SALDO == 'OPEN' && $key->STATUS_APPROVE == null):?>
                    <span class="badge bg-kps">Waiting For Approve</span>
                  <?php elseif($key->STATUS_PENGAJUAN_SALDO == 'OPEN' && $key->STATUS_APPROVE == 'APPROVED'):?>
                    <span class="badge bg-kps">Waiting For Receive</span>
                  <?php else: ?>
                    <span class="badge bg-warning">OPEN</span>
                  <?php endif ?>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
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
                'ordering': false,
                "autoWidth": false,
                "info": false,
                order: [[0, 'asc']],
                
              } );   
  })
</script>
<div class="table-responsive">
    <table class="table table-centered table-hover table-valign-middle table-nowrap mb-0" width="100%">
        <thead class="text-center">
            <tr>
                <th>Tanggal</th>
                <th>Jenis Kasbon</th>
                <th>PIC Pengaju</th>
                <th>Jumlah</th>
                <th>Status Approve</th>
                <th>PIC Approve</th>
                <th>Tanggal Approve</th>
                <th>PIC Receive</th>
                <th>Tanggal Receive</th>
                <th>Status Pengajuan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($data as $key): ?>
               <tr class="text-center">
                   <td><?=date("d F Y", strtotime($key->TGL_PENGAJU))?></td>
                   <td><?=$key->VAL_KASBON?></td>
                   <td><?=$key->PIC_PENGAJU.' - '.$key->NAMA_PENGAJU?></td>
                   <td><?=str_replace(',', '.', number_format($key->JUMLAH))?></td>
                   <td><?=$key->STATUS_APPROVE?></td>
                   <td><?=$key->PIC_APPROVE != null ?$key->PIC_APPROVE.' - '.$key->NAMA_APPROVE:''?></td>
                   <td><?=$key->TGL_APPROVE == null ? '' :date("d F Y", strtotime($key->TGL_APPROVE))?></td>
                   <?php if ($key->PIC_RECEIVE == null && $key->STATUS_APPROVE == 'APPROVED'): ?>
                        <td colspan="2" class="text-center">
                           <button type="button" class="btn bg-orange btn-kps btn-sm receivePengajuan" data="<?=$key->ID?>" jumlah="<?=$key->JUMLAH?>" jenisSPJ = '<?=$key->NAMA_JENIS?>' jenisKasbon = '<?=$key->JENIS_KASBON?>'>
                               Receive Pengajuan Saldo
                           </button>
                       </td>   
                   <?php else: ?>
                        <td><?=$key->PIC_RECEIVE != null ?$key->PIC_RECEIVE.' - '.$key->NAMA_RECEIVE:''?></td>
                        <td><?=$key->TGL_RECEIVE == null ? '' :date("d F Y", strtotime($key->TGL_RECEIVE))?></td>
                   <?php endif ?>
                   <td>
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
                   <td>
                        <?php if ($key->STATUS_PENGAJUAN_SALDO == 'OPEN' && $key->STATUS_APPROVE != 'APPROVED'): ?>
                            <button type="button" class="btn bg-orange dropdown-toggle dropdown-icon btn-kps btn-sm" data-toggle="dropdown" <?=$key->STATUS_APPROVE == 'APPROVED'?'disabled':''?>>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a 
                                    class="dropdown-item dropButton btnUpdate" 
                                    href="javascript:;" 
                                    data="<?=$key->ID?>"
                                    jenisKasbon ="<?=$key->JENIS_KASBON?>"
                                    jenisSPJ = "<?=$key->JENIS_ID?>"
                                    jumlah="<?=$key->JUMLAH?>">Ubah
                                </a>
                                <a 
                                    class="dropdown-item dropButton btnCancel" 
                                    href="javascript:;" 
                                    data="<?=$key->ID?>">Cancel</a>
                            </div>
                        <?php endif ?>
                   </td>
               </tr>
           <?php endforeach ?>
        </tbody>
    </table>
</div>
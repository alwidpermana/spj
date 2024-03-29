
<?php 
date_default_timezone_set('Asia/Jakarta');
foreach ($data as $key): ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label class="labJudul">Tanggal Input</label>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=date("d F Y", strtotime($key->TGL_INPUT))?></label>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label class="labJudul">Jenis SPJ</label>    
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12" id="afterNext">
                    :&nbsp;<label><?=$key->NAMA_JENIS?></label>
                    <input type="hidden" id="inputJenisId" value="<?=$key->JENIS_ID?>">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label class="labJudul">No SPJ</label>    
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->NO_SPJ?></label>
                    <input type="hidden" id="inputNoSPJ" value="<?=$key->NO_SPJ?>">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <label class="labJudul">Tanggal SPJ</label>    
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=date("d F Y", strtotime($key->TGL_SPJ))?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div id="getQrCode"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">1. Pengaju</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>NIK</label>  
              </div>
            </div>
            
          </div>
          <div class="col-md-8">
            :&nbsp;<label><?=$key->PIC_INPUT?></label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Nama</label>  
              </div>
            </div>
          </div>
          <div class="col-md-8">
            :&nbsp;<label><?=$key->namapeg?></label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Jabatan</label>  
              </div>
            </div>
          </div>
          <div class="col-md-8">
            :&nbsp;<label><?=$key->jabatan?></label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Departemen</label>  
              </div>
            </div>
          </div>
          <div class="col-md-8">
            :&nbsp;<label><?=$key->departemen?></label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Sub Departemen</label>  
              </div>
            </div>
          </div>
          <div class="col-md-8">
            :&nbsp;<label><?=$key->Subdepartemen?></label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card" id="kartuKendaraan">
      <div class="card-header">
        <div class="card-title">2. Kendaraan</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>Kendaraan</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->KENDARAAN?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>Jenis Kendaraan</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->JENIS_KENDARAAN?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>No Inventaris</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->NO_INVENTARIS?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>Merk</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->MERK?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>Type</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->TYPE?></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12"> 
                    <label>No TNKB</label>  
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    :&nbsp;<label><?=$key->NO_TNKB?></label>
                    <input type="hidden" id="inputNoTNKB" value="<?=$key->NO_TNKB?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="row">
              <div class="col-md-12 text-center">
                <img 
                  src="<?=base_url()?>assets/image/<?=$key->NAMA_FILE == null || $key->NAMA_FILE == 'N'?'car.png':'/foto-kendaraan/'.$key->NAMA_FILE?>" 
                  class="img-thumbnail rounded" 
                  width="75%" 
                  height="75%">
              </div>
            </div>
            <?php if ($key->NAMA_FILE == null || $key->NAMA_FILE == 'N'): ?>
              <div class="row">
                <div class="col-md-12 text-center">
                  <label class="text-kps">NO IMAGE</label>
                </div>
              </div>  
            <?php endif ?>
          </div>
          <?php
            $kendaraan = '';
            $ketKendaraan = '';
            $berangkat='';
            $pulang='';
            foreach ($validasi as $vld) {
              if ($key->STATUS_PERJALANAN == null) {
                $kendaraan = $vld->KENDARAAN;
                $ketKendaraan = $vld->KETERANGAN_KENDARAAN;
                
              }else{
                $kendaraan = $vld->KENDARAAN_IN;
                $ketKendaraan = $vld->KETERANGAN_KENDARAAN_IN;
              }
              $berangkat = $vld->KEBERANGKATAN;
              $pulang = $vld->KEPULANGAN;
              
            }
          ?>
          <div class="col-md-4 <?=$kendaraan=='OK' || $kendaraan == 'NG'?'':'fokusKendaraan'?>" id="kolomKendaraan">
            <div class="form-group clearfix">
              <label>Verifikasi Kendaraan </label>
              <div class="row">
                <div class="col-md-4">
                  <div class="icheck-orange icheck-kps d-inline">
                    <input 
                      type="radio" 
                      id="cekKendaraan1" 
                      name="inputVerifikasiKendaraan"
                      value="OK" <?=$kendaraan=='OK'?'checked':''?>
                      <?=$berangkat != null && $pulang != null?'disabled':''?>>
                    <label for="cekKendaraan1">
                      OK
                    </label>
                  </div> 
                </div>
                <div class="col-md-4">
                  <div class="icheck-orange icheck-kps d-inline">
                    <input 
                      type="radio" 
                      id="cekKendaraan2" 
                      name="inputVerifikasiKendaraan"
                      value="NG" <?=$kendaraan=='NG'?'checked':''?>
                      <?=$berangkat != null && $pulang != null?'disabled':''?>>
                    <label for="cekKendaraan2">
                      NG
                    </label>
                  </div> 
                </div>
              </div>
              <input type="hidden" id="inputVerifKendaraan" value="<?=$kendaraan?>">
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan Verifikasi Kendaraan</label>
                  <textarea class="form-control" rows="5" id="inputKeteranganKendaraan" <?=$berangkat != null && $pulang != null?'readonly':''?>><?=$ketKendaraan?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">3. Tujuan</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Tujuan</label>  
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-12">
                :&nbsp;
                <label>
                  <?php 
                    $noLokasi = 1;
                    $totalLokasi = count($tujuan);
                    foreach ($tujuan as $lok): ?>
                      <?=$lok->SERLOK_KOTA?>
                      <?php if ($noLokasi < $totalLokasi): ?>
                        <?=', '?>
                      <?php endif ?>

                    <?php $noLokasi++; endforeach ?>
                  
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12"> 
                <label>Lokasi</label>  
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-hover table-valign-middle text-center">
                    <thead>
                      <tr>
                        <th>Objek</th>
                        <th>Nama / Perusahaan</th>
                        <th>Kota / Kabupaten</th>
                        <th>Group Tujuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($lokasi as $lok2): ?>
                        <tr>
                          <td><?=$lok2->OBJEK?></td>
                          <td><?=$lok2->SERLOK_COMPANY?></td>
                          <td><?=$lok2->SERLOK_KOTA?></td>
                          <td><?=$lok2->NAMA_GROUP?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">4. PIC</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-hover table-valign-middle text-center" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">Subjek</th>
                    <td rowspan="2"></td>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Departemen</th>
                    <th rowspan="2">Sub Departemen</th>
                    <th rowspan="2">Jabatan</th>
                    <th colspan="4">Validasi</th>
                  </tr>
                  <tr>
                    <th>Out</th>
                    <th>In</th>
                    <th>Ket Out</th>
                    <th>Ket In</th>
                  </tr>
                </thead>
                <tbody>
                  <input type="hidden" id="inputVerifCountPIC" value="<?=count($pic2)?>">
                  <input type="hidden" id="inputVerifAfterChoice">
                  <?php foreach ($pic2 as $pc2): ?>
                    <input type="hidden" id="verifPIC<?=$pc2->NIK?>">
                    <tr class="<?=$key->STATUS_PERJALANAN == 'IN' ? '' : 'fokusKendaraan'?>" id="<?=$pc2->NIK?>">
                      <td><?=$pc2->JENIS_PIC?></td>
                      <td><?=$pc2->OBJEK?></td>
                      <td>
                        <?php if ($pc2->FOTO_WAJAH != null || $pc2->FOTO_WAJAH !=''): ?>
                          <a href="javascript:;" class="getFotoWajah" foto="<?=$pc2->FOTO_WAJAH?>">
                            <img src="<?=base_url()?>assets/image/foto-wajah/<?=$pc2->FOTO_WAJAH?>" class="img-thumbnail fotoWajah">
                          </a>
                        <?php endif ?>
                      </td>
                      <td><?=$pc2->NIK?></td>
                      <td><?=$pc2->NAMA?></td>
                      <td><?=$pc2->DEPARTEMEN?></td>
                      <td><?=$pc2->SUB_DEPARTEMEN?></td>
                      <td><?=$pc2->JABATAN?></td>
                      <td>
                        <?php if ($key->STATUS_PERJALANAN == null): ?>
                          <div class="form-group clearfix">
                            <div class="icheck-orange icheck-kps d-inline">
                              <input 
                                type="radio" 
                                id="OK<?=$pc2->NIK?>" 
                                name="<?=$pc2->NIK?>" 
                                nik="<?=$pc2->NIK?>" 
                                noSPJ = '<?=$key->NO_SPJ?>'
                                value="OK" 
                                class="validasiPIC"
                                field="SET_OUT">
                              <label for="OK<?=$pc2->NIK?>">
                                OK
                              </label>
                            </div>
                            <br>
                            <br>
                            <div class="icheck-orange icheck-kps d-inline">
                              <input 
                                type="radio" 
                                id="NG<?=$pc2->NIK?>" 
                                name="<?=$pc2->NIK?>" 
                                nik="<?=$pc2->NIK?>" 
                                noSPJ = '<?=$key->NO_SPJ?>'
                                value="NG" 
                                class="validasiPIC"
                                field="SET_OUT">
                              <label for="NG<?=$pc2->NIK?>">
                                NG
                              </label>
                            </div>
                          </div>
                        <?php else: ?>
                          <?php foreach ($validasiPIC as $vPIC): ?>
                            <?php if ($vPIC->PIC == $pc2->NIK): ?>
                              <?=$vPIC->SET_OUT?>    
                            <?php endif ?>
                          <?php endforeach ?>
                        <?php endif ?>
                      </td>
                      <td>
                        <?php foreach ($validasiPIC as $vPIC): ?>
                          <?php if ($vPIC->PIC == $pc2->NIK): ?>
                            <?php if ($key->STATUS_PERJALANAN == 'OUT' && $vPIC->STATUS_DATA == 'OUT'): ?>
                              <div class="form-group clearfix">
                                <div class="icheck-orange icheck-kps d-inline">
                                  <input 
                                    type="radio" 
                                    id="OK<?=$pc2->NIK?>" 
                                    name="<?=$pc2->NIK?>" 
                                    nik="<?=$pc2->NIK?>" 
                                    noSPJ = '<?=$key->NO_SPJ?>'
                                    value="OK" 
                                    class="validasiPIC"
                                    field="SET_IN">
                                  <label for="OK<?=$pc2->NIK?>">
                                    OK
                                  </label>
                                </div>
                                <br>
                                <br>
                                <div class="icheck-orange icheck-kps d-inline">
                                  <input 
                                    type="radio" 
                                    id="NG<?=$pc2->NIK?>" 
                                    name="<?=$pc2->NIK?>" 
                                    nik="<?=$pc2->NIK?>" 
                                    noSPJ = '<?=$key->NO_SPJ?>'
                                    value="NG" 
                                    class="validasiPIC"
                                    field="SET_IN">
                                  <label for="NG<?=$pc2->NIK?>">
                                    NG
                                  </label>
                                </div>
                              </div>
                            <?php else: ?>
                              <?php foreach ($validasiPIC as $vPIC): ?>
                                <?php if ($vPIC->PIC == $pc2->NIK): ?>
                                  <?=$vPIC->SET_IN?> 
                                <?php endif ?>
                              <?php endforeach ?>
                            <?php endif ?>
                          <?php endif ?>
                        <?php endforeach ?>
                      </td>
                      <td>
                        <?php if ($key->STATUS_PERJALANAN == null): ?>
                          <textarea 
                            class="form-control form-control-sm validasiKeteranganPIC" 
                            rows="3" 
                            style="font-size: 11px" 
                            noSPJ = '<?=$key->NO_SPJ?>'
                            nik = "<?=$pc2->NIK?>"
                            field="KETERANGAN_OUT"
                            id="keterangan<?=$pc2->NIK?>"
                            ></textarea>
                        <?php else: ?>
                          <?php foreach ($validasiPIC as $vPIC): ?>
                            <?php if ($vPIC->PIC == $pc2->NIK): ?>
                              <?=$vPIC->KETERANGAN_OUT?>
                            <?php endif ?>
                          <?php endforeach ?>
                        <?php endif ?>
                      </td>
                      <td>
                        <?php foreach ($validasiPIC as $vPIC): ?>
                          <?php if ($key->STATUS_PERJALANAN == 'OUT' && $vPIC->STATUS_DATA == 'OUT'): ?>
                            <?php if ($vPIC->PIC == $pc2->NIK): ?>
                              <textarea 
                                class="form-control form-control-sm validasiKeteranganPIC" 
                                rows="3" 
                                style="font-size: 11px" 
                                noSPJ = '<?=$key->NO_SPJ?>'
                                nik = "<?=$pc2->NIK?>"
                                field="KETERANGAN_IN"
                                id="keteranganIn<?=$pc2->NIK?>"
                                ></textarea>
                            <?php endif ?>
                          <?php else: ?>
                            <?php if ($vPIC->PIC == $pc2->NIK): ?>
                              <?=$vPIC->KETERANGAN_IN?>
                            <?php endif ?>
                          <?php endif ?>
                        <?php endforeach ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">6. KEBERANGKATAN</div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <div class="table-responsive">
              <table class="table table-hover table-valign-middle text-center">
                <thead>
                  <tr>
                    <th rowspan="2"></th>
                    <th colspan="2">Rencana</th>
                    <th colspan="2">Aktual</th>
                    <th rowspan="2">GAP</th>
                    <th rowspan="2" width="100px">KM</th>
                  </tr>
                  <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-left">Keberangkatan</td>
                    <td><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
                    <td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
                    <?php
                      $aktualBerangkat = date("Y-m-d");
                      $aktualBerangkatJam = date("H:i");
                      $showBerangkat = date("Y-m-d H:i");
                      foreach ($validasi as $vld) {
                        $aktualBerangkat = date("Y-m-d", strtotime($vld->KEBERANGKATAN));
                        $aktualBerangkatJam = date("H:i", strtotime($vld->KEBERANGKATAN));
                        $showBerangkat= $vld->KEBERANGKATAN;
                      }
                    ?>
                    <td><?=date("d F Y", strtotime($showBerangkat))?></td>
                    <td><?=date("H:i", strtotime($showBerangkat))?></td>
                    
                    <td>
                      <?php
                        $rencanaBerangkat = date("Y-m-d", strtotime($key->RENCANA_BERANGKAT));
                        $rencanaBerangkat2 = date('H:i', strtotime($key->RENCANA_BERANGKAT));
                        $rBerJam = date_create($rencanaBerangkat2);
                        $aBerJam = date_create($aktualBerangkatJam);
                        $gapBerangkatJam = date_diff($rBerJam, $aBerJam);

                        $rBer = date_create($rencanaBerangkat);
                        $aBer = date_create($aktualBerangkat);
                        $gapBerangkat = date_diff($rBer, $aBer);
                        if ($aktualBerangkat == $rencanaBerangkat) {
                          
                          echo $gapBerangkatJam->h.' Jam '.$gapBerangkatJam->i.' Menit';
                        } else {
                          
                           
                          echo $gapBerangkat->d.' Hari '.$gapBerangkatJam->h.' Jam '.$gapBerangkatJam->i.' Menit';
                        }
                        
                      ?>
                    </td>
                    <td>
                      <?php
                        $kmOut = 0;
                        $kmIn = 0;

                        if ($key->STATUS_PERJALANAN == null) {
                          foreach ($km as $km) {
                            $kmOut = $km->KM;
                          }
                        } else {
                          foreach ($validasi as $vld) {
                              $kmOut = $vld->KM_OUT;
                            }
                        }

                        if ($key->STATUS_PERJALANAN == 'IN') {
                          foreach ($validasi as $vld) {
                            $kmIn = $vld->KM_IN;
                          }
                        }
                      ?>
                      <center>
                        <?php if ($key->STATUS_PERJALANAN == null): ?>
                          <input type="number" id="inputKMOut" class="form-control form-control-sm" value="<?=$kmOut?>" style="width: 200px;" <?=$key->STATUS_PERJALANAN == null?'':'disabled'?>> 
                        <?php else: ?>
                          <!-- <?=number_format($kmOut)?> -->
                          <input type="number" id="inputKMOut" class="form-control form-control-sm" value="<?=$kmOut?>" style="width: 200px;">
                        <?php endif ?>
                        
                      </center>
                    </td>
                  </tr>
                  <tr class="<?=$key->STATUS_PERJALANAN == 'OUT' ? 'fokusKendaraan':''?>" id="rowkepulangan">
                    <td class="text-left">Kepulangan</td>
                    <td><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
                    <td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
                    <?php if ($key->STATUS_PERJALANAN == null): ?>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    <?php else: ?>
                      <?php
                        $aktualPulang = date("Y-m-d");
                        $aktualPulangJam = date("H:i");
                        $plg1 = date("Y-m-d H:i");
                        foreach ($validasi as $vld) {
                          $aktualPulang = $vld->KEPULANGAN == null?date("Y-m-d"):date("Y-m-d", strtotime($vld->KEPULANGAN));
                          $aktualPulangJam = $vld->KEPULANGAN == null?date("H:i"):date("H:i", strtotime($vld->KEPULANGAN));
                          $plg= $vld->KEPULANGAN;
                        }
                        $showPulang = $plg == null ? $plg1 : $plg;
                      ?>
                      <td><?=date("d F Y", strtotime($showPulang)).'-'?></td>
                      <td><?=date("H:i", strtotime($showPulang))?></td>
                      
                      <td>
                        <?php
                          if ($key->STATUS_PERJALANAN != null) {
                            $rencanaPulang = date("Y-m-d", strtotime($key->RENCANA_PULANG));
                            $rencanaPulang2 = date('H:i', strtotime($key->RENCANA_PULANG));
                            $rBerJam = date_create($rencanaPulang2);
                            $aBerJam = date_create($aktualPulangJam);
                            $gapPulangJam = date_diff($rBerJam, $aBerJam);

                            $rBer = date_create($rencanaPulang);
                            $aBer = date_create($aktualPulang);
                            $gapPulang = date_diff($rBer, $aBer);
                            if ($aktualPulang == $rencanaPulang) {
                              
                              echo $gapPulangJam->h.' Jam '.$gapPulangJam->i.' Menit';
                            } else {
                              
                               
                              echo $gapPulang->d.' Hari '.$gapPulangJam->h.' Jam '.$gapPulangJam->i.' Menit';
                            }
                          }
                          
                        ?>
                      </td>
                      <td class="text-center">
                        <center>
                          <?php if ($key->STATUS_PERJALANAN == 'OUT'): ?>
                            <input type="number" id="inputKMIn" class="form-control form-control-sm" value="<?=$kmIn?>" style="width: 200px;" <?=$key->STATUS_PERJALANAN == 'OUT'?'':'readonly'?>> 
                          <?php else: ?>
                            <?=number_format($kmIn)?>
                          <?php endif ?>
                          
                        </center>
                      </td>
                    <?php endif ?>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <?php if (count($history)>0): ?>
                  <table class="table table-hover table-striped table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>KM</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($history as $hs): ?>
                        <tr>
                          <td><?=$hs->STATUS?></td>
                          <td><?=date("d F Y", strtotime($hs->TGL_INPUT))?></td>
                          <td><?=date("H:i", strtotime($hs->TGL_INPUT))?></td>
                          <td><?=$hs->KM?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
  <input type="hidden" id="inputGroupTujuan" value="<?=$key->GROUP_ID?>">
  <div class="col-md-8 offset-md-2">
    <?php if ($key->GROUP_ID == '4' || $key->GROUP_ID == '10'|| $key->GROUP_ID == '11'): ?>
      <?php if ($key->STATUS_SPJ == 'OPEN'): ?>
        <?php if ($key->STATUS_PERJALANAN == null || $key->STATUS_PERJALANAN == 'IN'): ?>
          <?php if ($key->LOKAL_SELESAI == null): ?>
            <button type="button" class="btn bg-orange btn-kps btn-block saveCheckOut ladda-button" data-style="zoom-in" id="btnCheckOut">
              Check Out
            </button>    
          <?php endif ?>
        <?php elseif($key->STATUS_PERJALANAN == 'OUT'): ?>
          <button type="button" class="btn bg-orange btn-kps btn-block saveCheckIn ladda-button" data-style="zoom-in" id="btnCheckIn">
            Check In
          </button>
        <?php endif ?>
      <?php endif ?>
    <?php else: ?>
      <?php if ($key->STATUS_PERJALANAN == null): ?>
        <button type="button" class="btn bg-orange btn-kps btn-block saveCheckOut ladda-button" data-style="zoom-in" id="btnCheckOut">
          Check Out
        </button>
      <?php elseif($key->STATUS_PERJALANAN == 'OUT'): ?>
        <button type="button" class="btn bg-orange btn-kps btn-block saveCheckIn ladda-button" data-style="zoom-in" id="btnCheckIn">
          Check In
        </button>
      <?php endif ?>
    <?php endif ?>
  </div>
</div>
<br>
<div class="modal fade" id="modal-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-end">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-md-12">
            <center><div id="getFoto"></div></center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-bulak_balik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-secondary btn-block btnLanjut">
              Melanjutkan Perjalan
            </button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-kps bg-orange btn-block btnSelesai">
              Perjalanan Selesai
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach ?>
<script type="text/javascript">
  $(document).ready(function(){
    // $('html, body').animate({
    //     scrollTop: $("#kartuKendaraan").offset().top
    // }, 1000);
    $('.validasiPIC').on('click', function(){
      var isi = $(this).val();
      var nik = $(this).attr("nik");
      var noSPJ = $(this).attr("noSPJ");
      var field = $(this).attr("field");
      var isiKeterangan = '';
      var fieldKeterangan = field=='SET_OUT'?'KETERANGAN_OUT':'KETERANGAN_IN';
      if (isi == 'OK') {
        isiKeterangan = field=='SET_OUT'?"PIC Sudah Sesuai Dengan SPJ":'PIC Kembali Sesuai SPJ';
      }else if(isi=='NG'){
        isiKeterangan = field =='SET_OUT'?"PIC Tidak Sesuai Dengan SPJ":"PIC Tidak Kembali";
      }else{
        isiKeterangan = "";
      }

      if (field == 'SET_OUT') {
        $('.validasiKeteranganPIC#keterangan'+nik).val(isiKeterangan);
      }else{
        $('.validasiKeteranganPIC#keteranganIn'+nik).val(isiKeterangan);
      }
      $('#'+nik).removeClass("fokusKendaraan")
      saveValidasiPIC(isi, nik, noSPJ, field);
      saveValidasiPIC(isiKeterangan, nik, noSPJ, fieldKeterangan);
    })
    $('.validasiKeteranganPIC').on('change', function(){
      var isi = $(this).val();
      var nik = $(this).attr("nik");
      var noSPJ = $(this).attr("noSPJ");
      var field = $(this).attr("field");
      saveValidasiPIC(isi, nik, noSPJ, field);
    });
    $('[name="inputVerifikasiKendaraan"]').on('click', function(){
      var isi = $(this).val();
      $('#inputVerifKendaraan').val(isi);
      if (isi == 'OK') {
        $('#inputKeteranganKendaraan').val("Kendaraan Sudah Sesuai Dengan SPJ")
      }else if(isi == 'NG'){
        $('#inputKeteranganKendaraan').val("Kendaraan Tidak Sesuai Dengan SPJ")
      }else{
        $('#inputKeteranganKendaraan').val("");
      }
      $('#kolomKendaraan').removeClass("fokusKendaraan");
    });
    var saveCheckOut = $('.saveCheckOut').ladda();
      saveCheckOut.click(function () {
      // Start loading
      saveCheckOut.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        
        var inputNoSPJ = $('#inputNoSPJ').val();
        var jenis = 'Out';
        var inputVerifCountPIC = $('#inputVerifCountPIC').val()
        
        $.ajax({
          type:'get',
          data:{inputNoSPJ, jenis},
          cache: false,
          async: true,
          url:url+'/Implementasi/cekValidasiPIC',
          dataType:'json',
          beforeSend: function(data){
            $('.preloader-no-bg').show();
          },
          success: function(data){
            if (parseInt(inputVerifCountPIC)==parseInt(data.jumlah)) {
              cekPICdanKendaraanOut()
            } else {
              if (data.jenis_spj == '2') {
                $('#modal-aktualPIC').modal("show")
                getTabelAktual();
              }else{
                Swal.fire("Verifikasi PIC Harus OK Terlebih Dahulu","Jika Data Tidak Sesuai, Hubungi PIC Pembuat SPJ","warning")
                saveHistoryNG(inputNoSPJ, 'PIC', 'OUT', '', '');  
              }
              
            }
            // if (parseInt(data) == 0) {
            //   // if (jenis == 'Out') {

                
            //   // } else {
            //   //   saveValidasiIn()
            //   // }
            //   console.log(jenis)
            // } else {
            //   Swal.fire('Verifikasi PIC Terlebih Dahulu!',"","warning")
            // }
          },
          complete: function(data){
            $('.preloader-no-bg').fadeOut("slow");
          },
          error: function(data){
            Swal.fire("Terjadi Error Pada Program!","Hubungi Segera Staff IT","error");
          }
        });
        saveCheckOut.ladda('stop');
        
        return false;
          
      }, 1000)
    });
    var saveCheckIn = $('.saveCheckIn').ladda();
      saveCheckIn.click(function () {
      // Start loading
      saveCheckIn.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputKMIn = parseInt($('#inputKMIn').val());
        var inputVerifCountPIC = $('#inputVerifCountPIC').val()
        // console.log("kontol")
        var jenis = 'In';
        $.ajax({
          type:'get',
          data:{inputNoSPJ, jenis},
          cache: false,
          async: true,
          url:url+'/Implementasi/cekValidasiPIC',
          dataType:'json',
          beforeSend: function(data){
            $('.preloader-no-bg').show();
          },
          success: function(data){
            if (parseInt(inputVerifCountPIC)==parseInt(data.jumlah)) {
              saveValidasiIn()
            } else {
              if (data.jenis_spj == '2') {
                saveValidasiIn()
                saveHistoryNG(inputNoSPJ, 'PIC', 'IN', '', '');
              }else{
                Swal.fire("Verifikasi PIC Terlebih Dahulu","","warning")
                saveHistoryNG(inputNoSPJ, 'PIC', 'IN', '', '');
              }
              
            }
            // if (parseInt(data) == 0) {
            //   // if (jenis == 'Out') {
            //   //   saveValidasiOut()
            //   // } else {
            //     saveValidasiIn()
            //   // }
            //     // saveUangTambahan();
            //   console.log(jenis)
            // } else {
            //   Swal.fire('Verifikasi PIC Terlebih Dahulu!',"","warning")
            // }
          },
          complete: function(data){
            $('.preloader-no-bg').fadeOut('slow');
          },
          error: function(data){
            Swal.fire("Terjadi Error Pada Program!","Hubungi Segera Staff IT","error");
          }
        });
        
        
        saveCheckIn.ladda('stop');
        // $('.saveCheckIn').attr("disabled","disabled");
        return false;
          
      }, 1000)
    });

    $('.getFotoWajah').on('click', function(){
      var foto = $(this).attr("foto");
      var ngambilFoto = url+'/assets/image/foto-wajah/'+foto;
      $('#getFoto').html('<img src="'+ngambilFoto+'" class="rounded mx-auto d-block" width="75%">');
      $('#modal-foto').modal("show");
    });
    $('#inputKMIn').on('keyup', function(){
      $('#rowkepulangan').removeClass("fokusKendaraan")
    })
    $('.btnLanjut').on('click', function(){
      location.reload();
    })
    $('.btnSelesai').on('click', function(){
      var inputNoSPJ = $('#inputNoSPJ').val();
      $.ajax({
        type:'post',
        data:{inputNoSPJ},
        dataType:'json',
        url:url+'/implementasi/spjLokalSelesai',
        cache: false,
        async: true,
        success: function(data){
          berhasil();
          location.reload();
        },
        error: function(data){
          Swal.fire("gagal Menyimpan Data!","Hubungi Staff IT",'error');
          location.reload();
        }
      })
    })
    

  });
  function saveValidasiPIC(isi, nik, noSPJ, field) {
    $.ajax({
      type:'post',
      data:{isi, nik, noSPJ, field},
      dataType:'json',
      cache: false,
      async: true,
      url:url+'/Implementasi/saveValidasiPIC',
      success: function(data){
        // berhasil()
      },
      error: function(data){
        Swal.fire("Terdapat Gangguan Pada Jaringan!","Reload Terlebih Dahulu Halaman Ini, atau Hubungi Staff IT","error");
      }
    });
  }
  function saveValidasiOut() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputVerifikasiKendaraan = $('#inputVerifKendaraan').val();
    var inputKeteranganKendaraan = $('#inputKeteranganKendaraan').val();
    var inputKMOut = $('#inputKMOut').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var urlTujuan = inputGroupTujuan == '4' || inputGroupTujuan == '10' || inputGroupTujuan == '11'?'saveValidasiOutLokal' :'saveValidasiOut';
    var inputKMIn = $('#inputKMIn').val();
    var inputNoTNKB = $('#inputNoTNKB').val();
    if (inputVerifikasiKendaraan == '') {
      Swal.fire("Verifikasi Kendaraan Terlebih Dahulu!","","warning")
    }else if(inputVerifikasiKendaraan == 'NG'){
      Swal.fire("Verifikasi Kendaraan Harus OK Sebelum Check Out!","Jika Data Tidak Sesuai, Hubungi PIC Pembuat SPJ","warning");
      saveHistoryNG(inputNoSPJ, 'KENDARAAN', 'OUT', inputKeteranganKendaraan, inputNoTNKB);
    }else {
      $('.saveCheckOut').attr("disabled","disabled");
      $.ajax({
        type:'post',
        data:{inputNoSPJ, inputVerifikasiKendaraan, inputKeteranganKendaraan, inputKMOut, inputKMIn},
        dataType: 'json',
        url: url+'/Implementasi/'+urlTujuan,
        cache: false,
        async: true,
        success: function(data){
          berhasil();
          location.reload();
          
        },
        error: function(data){
          gagal();
        }
      });
    }
  }
  function saveValidasiIn() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputVerifikasiKendaraan = $('#inputVerifKendaraan').val();
    var inputKeteranganKendaraan = $('#inputKeteranganKendaraan').val();
    var inputKMIn = $('#inputKMIn').val();
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputKMOut = $('#inputKMOut').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    if (inputVerifikasiKendaraan == 'NG') {
      saveHistoryNG(inputNoSPJ, 'PIC', 'IN', inputKeteranganKendaraan, inputNoTNKB);
    }
    if (inputVerifikasiKendaraan == '') {
      Swal.fire("Verifikasi Kendaraan Terlebih Dahulu!","","warning")
    }else if(parseInt(inputKMOut) > parseInt(inputKMIn)){
      Swal.fire("KM Out Tidak Boleh Lebih Besar Dibandingkan KM In","","warning")
    }else {
      $('.saveCheckOut').attr("disabled","disabled");
      $.ajax({
        type:'post',
        data:{inputNoSPJ, inputVerifikasiKendaraan, inputKeteranganKendaraan, inputKMIn, inputNoTNKB, inputGroupTujuan},
        dataType: 'json',
        url: url+'/Implementasi/saveValidasiIn',
        cache: false,
        async: true,
        success: function(data){
          saveUangTambahan();
        },
        error: function(data){
          gagal();
        }
      });
    }
  }
  function saveUangTambahan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputJenisId = $('#inputJenisId').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type:'post',
      data:{inputNoSPJ,inputJenisId, inputGroupTujuan},
      dataType:'json',
      url:url+'/Implementasi/saveUangTambahan',
      cache: false,
      async: true,
      success: function(data){
        berhasil();
        if (inputGroupTujuan == '4' || inputGroupTujuan == '10' || inputGroupTujuan == '11') {
          $('#modal-bulak_balik').modal("show");
        }else{
          location.reload();  
        }
        
      },
      error: function(data){
        gagal();
      }
    });
  }
  function saveHistoryNG(noSPJ, jenis, status, keteranganKendaraan, noTNKB ) {
    $.ajax({
      type:'post',
      data:{noSPJ, jenis, status, keteranganKendaraan, noTNKB},
      url:url+'/Implementasi/saveHistoryNG',
      dataType:'json',
      cache: false,
      async: true,
      success: function(data){
        console.log("berhasil menyimpan history NG")
      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program","Hubungi Segera Staff IT", "error");
      }
    })
  }
  function cekPICdanKendaraanOut() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'get',
      data:{inputNoSPJ},
      dataType:'json',
      cache:false,
      async:true,
      url:url+'/implementasi/cekPICdanKendaraanOut',
      success:function(data){
        // if (data.status == 'warning') {
          // Swal.fire(data.message,'Hubungi PIC Delivery',data.status);
        // }else{
          saveValidasiOut()
        // }
      },
      error:function(data){
        Swal.fire("Terjadi Error Pada Program","Hubungi Segera Staff IT", "error");
      }
    })
  }
</script>
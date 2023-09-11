<!DOCTYPE html>
<?php
  date_default_timezone_set('Asia/Jakarta');
?>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
  
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed">
<div class="preloader">
  <div class="loader">
      <div class="spinner"></div>
      <div class="spinner-2"></div>
  </div>
</div>
<div class="wrapper">
    <?php $this->load->view('_partial/navbar');?>
    <?php $this->load->view('_partial/sidebar');?>
    <div class="content-wrapper">
      <?php $this->load->view('_partial/content-header');?>
      <div class="content">
        <div class="container-fluid">
          <?php foreach ($data as $key): 
            $mediaUangJalan = $key->MEDIA_UANG_JALAN;
            $groupId = $key->GROUP_ID;
            $jenisId = $key->JENIS_ID;
            ?>
            <input type="hidden" id="inputId" value="<?=$this->uri->segment("3")?>">
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
                                <input type="hidden" id="inputJenisSPJ" value="<?=$key->NAMA_JENIS?>">
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
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">2. Kendaraan</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
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
                                <input type="hidden" id="inputKendaraan" value="<?=$key->KENDARAAN?>">
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
                      <div class="col-md-6">
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
                <div class="card" id="divPIC">
                  <div class="card-header">
                    <div class="card-title">4. PIC</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-hover table-valign-middle text-center">
                            <thead>
                              <tr>
                                <th rowspan="2"></th>
                                <th rowspan="2">Subjek</th>
                                <th rowspan="2">NIK</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Departemen</th>
                                <th rowspan="2">Sub Departemen</th>
                                <th rowspan="2">Jabatan</th>
                                <th rowspan="2">Tujuan</th>
                                <th rowspan="2">Uang Saku</th>
                                <th rowspan="2">Uang Makan</th>
                                <th colspan="2">Uang Saku Ke 2</th>
                                <th rowspan="2">Makan Ke 2</th>
                                <th colspan="4">Validasi</th>
                              </tr>
                              <tr>
                                <th>Jam Ke 1-3</th>
                                <th>Jam Ke &ge;4</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Keterangan Out</th>
                                <th>Keterangan In</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $totalUangSaku1 = 0;
                              $totalUangSaku2 = 0;
                              $totalUangMakan=0;
                              foreach ($pic as $pc): ?>
                                <tr>
                                  <td><?=$pc->JENIS_PIC?></td>
                                  <td><?=$pc->OBJEK?></td>
                                  <td><?=$pc->NIK?></td>
                                  <td><?=$pc->NAMA?></td>
                                  <td><?=$pc->DEPARTEMEN?></td>
                                  <td><?=$pc->SUB_DEPARTEMEN?></td>
                                  <td><?=$pc->JABATAN?></td>
                                  <td><?=$pc->SORTIR == 'Y'?'Sortir':'Reguler'?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU, 0))?></td>
                                  <td>
                                    <?php 
                                    $userLogin = $this->session->userdata("NIK");
                                    if ($userLogin == '00003' || $userLogin == '00004' || $userLogin == '04035' || $userLogin =='05100' || $userLogin == '04022'): ?>
                                      <a href="javascript:;" class="text-kps btnEditUangMakanKasbon" nik="<?=$pc->NIK?>" uang="<?=round($pc->UANG_MAKAN)?>" nama="<?=$pc->NAMA?>" jenis="Uang Makan">Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?></a>
                                    <?php else: ?>
                                      Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?>
                                    <?php endif ?>
                                    
                                  </td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU1, 0))?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU2, 0))?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN_TAMBAHAN, 0))?></td>
                                  <td><?=$pc->SET_OUT?></td>
                                  <td><?=$pc->SET_IN?></td>
                                  <td><?=$pc->KETERANGAN_OUT?></td>
                                  <td><?=$pc->KETERANGAN_IN?></td>
                                </tr>
                              <?php 
                                $totalUangSaku1 += $pc->UANG_SAKU1;
                                $totalUangSaku2 += $pc->UANG_SAKU2;
                                $totalUangMakan += $pc->UANG_MAKAN_TAMBAHAN;
                                $statusUS1 = $pc->STATUS_US1;
                                $statusUS2 = $pc->STATUS_US2;
                                $statusMakan = $pc->STATUS_MAKAN;
                                $picUS1 = $pc->PIC_US1;
                                $picUS2 = $pc->PIC_US2;
                                $picMakan = $pc->PIC_MAKAN;
                                $tglUS1 = $pc->TGL_US1;
                                $tglUS2 = $pc->TGL_US2;
                                $tglMakan = $pc->TGL_MAKAN;
                                $statusAdjMakan = $pc->STATUS_UM == null? 'CLOSE' : $pc->STATUS_UM;
                                $picAdjMakan = $pc->PIC_KEPUTUSAN;
                                $tglAdjMakan = $pc->TGL_KEPUTUSAN;
                                $statusAdjJalan = $pc->STATUS_JALAN == null? 'CLOSE':$pc->STATUS_JALAN;
                                $picAdjJalan = $pc->STATUS_JALAN ==null?'SYSTEM':$pc->PIC_KEPUTUSAN_JALAN;
                                $tglAdjJalan = $pc->STATUS_JALAN == null?date("d-m-Y"): $pc->TGL_KEPUTUSAN_JALAN;
                              endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="8" class="text-right">Status</th>
                                <th>CLOSE</th>
                                <th>
                                  <?=$statusAdjMakan?>
                                  <input type="hidden" id="inputStatusAdjMakan" value="<?=$statusAdjMakan?>">    
                                </th>
                                <th>
                                  <?=$statusUS1?>
                                  <input type="hidden" id="inputStatusUS1" value="<?=$statusUS1?>">
                                </th>
                                <th>
                                  <?=$statusUS2?>
                                  <input type="hidden" id="inputStatusUS2" value="<?=$statusUS2?>">
                                </th>
                                <th>
                                  <?=$statusMakan?>
                                  <input type="hidden" id="inputStatusUM" value="<?=$statusMakan?>">    
                                </th>
                                <th colspan="4"></th>
                              </tr>
                              <tr>
                                <th colspan="8" class="text-right">Total</th>
                                <th>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></th>
                                <th>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></th>
                                <th>Rp.<?=str_replace(',', '.', number_format($totalUangSaku1, 0))?></th>
                                <th>Rp.<?=str_replace(',', '.', number_format($totalUangSaku2, 0))?></th>
                                <th>Rp.<?=str_replace(',', '.', number_format($totalUangMakan, 0))?></th>
                                <th colspan="4"></th>
                              </tr>
                              <input type="hidden" id="inputTotalUangSaku1" value="<?=$totalUangSaku1?>">
                              <input type="hidden" id="inputTotalUangSaku2" value="<?=$totalUangSaku2?>">
                              <input type="hidden" id="inputTotalUangMakan" value="<?=$totalUangMakan?>">
                            </tfoot>
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
                <div class="card" id="divBiaya">
                  <div class="card-header">
                    <div class="card-title">5. Biaya</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-hover table-valign-middle text-center">
                            <thead>
                              <tr>
                                <th rowspan="2"></th>
                                <th colspan="2">Kasbon</th>
                                <th>Realisasi</th>
                                <th>Kurang/Lebih</th>
                                <th colspan="2">Close</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Info</th>
                              </tr>
                              <tr>
                                <th>Rp.</th>
                                <th>Media</th>
                                <th>Rp</th>
                                <th>Rp</th>
                                <th>Tanggal</th>
                                <th>PIC</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($realisasi as $rl): 
                                $realisasiUangSaku = $rl->REALISASI_UANG_SAKU == null ? $rl->TOTAL_UANG_SAKU : $rl->REALISASI_UANG_SAKU;
                                $realisasiUangMakan = $rl->REALISASI_UANG_MAKAN == null ? $rl->TOTAL_UANG_MAKAN : $rl->REALISASI_UANG_MAKAN;
                                if ($rl->TOTAL_UANG_JALAN == 0) {
                                  $realisasiUangJalan = $jenisId == 2 && $groupId == 4 || $groupId == 10 && $jenisId == 2 ? 0 : $rl->REALISASI_UANG_JALAN == null ? $rl->TOTAL_UANG_JALAN : $rl->REALISASI_UANG_JALAN;
                                }else{
                                  $realisasiUangJalan = $rl->REALISASI_UANG_JALAN == null ? $rl->TOTAL_UANG_JALAN : $rl->REALISASI_UANG_JALAN;
                                }

                                if ($jenisId == 2 && $groupId == 4 || $groupId == 10 && $jenisId == 2) {
                                  $kasbonJalan = 0;
                                }else{
                                  $kasbonJalan = $key->TOTAL_UANG_JALAN;
                                }
                                
                              ?>
                                <tr>
                                  <td>Uang Saku</td>
                                  <td><?=str_replace(',', '.', number_format($rl->TOTAL_UANG_SAKU, 0))?></td>
                                  <td><?=$rl->MEDIA_UANG_SAKU?></td>
                                  <td>
                                    <?=str_replace(',', '.', number_format($realisasiUangSaku, 0))?>
                                    <input type="hidden" id="inputRealisasiUangSaku" value="<?=$realisasiUangSaku?>">    
                                  </td>
                                  <td><?=str_replace(',', '.', number_format($realisasiUangSaku - $rl->TOTAL_UANG_SAKU, 0))?></td>
                                  <td>
                                    <?=date("d-m-Y", strtotime($tglUS1))?>
                                  </td>
                                  <td><?=$picUS1?></td>
                                  <td><?=$statusUS1?></td>
                                  <td><?=$rl->US1_TAMBAHAN>0 || $rl->US2_TAMBAHAN>0 ? 'Mendapatkan Uang Saku Ke 2':''?></td>
                                </tr>
                                <tr>
                                  <td>Uang Makan</td>
                                  <td><?=str_replace(',', '.', number_format($rl->TOTAL_UANG_MAKAN, 0))?></td>
                                  <td><?=$rl->MEDIA_UANG_MAKAN?></td>
                                  <td>
                                    <?=str_replace(',', '.', number_format($realisasiUangMakan, 0))?>
                                    <input type="hidden" id="inputRealisasiUangMakan" value="<?=$realisasiUangMakan?>">    
                                  </td>
                                  <td><?=str_replace(',', '.', number_format($realisasiUangMakan - $rl->TOTAL_UANG_MAKAN, 0))?></td>
                                  <?php if ($rl->ADJUSTMENT_MANAJEMEN == 'Y'): ?>
                                    <td><?=$rl->UM_DIAJUKAN == null?'':date("d-m-Y", strtotime($rl->UM_TGL))?></td>
                                    <td><?=$rl->UM_DIAJUKAN == null?'':$rl->UM_PIC?></td>
                                    <td><?=$statusAdjMakan?></td>
                                  <?php else: ?>
                                    <td>
                                     <?=date("d-m-Y", strtotime($tglMakan))?>
                                    </td>
                                    <td><?=$picMakan?></td>
                                    <td><?=$statusMakan?></td>   
                                  <?php endif ?>
                                  
                                  <td><?=$rl->UM_TAMBAHAN>0  ? 'Mendapatkan Uang Makan Ke 2':''?></td>
                                </tr>
                                <tr>
                                  <td>Uang Jalan</td>
                                  <td>
                                    <?php if ($jenisId == 2 && $key->GROUP_ID == '4' || $key->GROUP_ID =='10' && $jenisId == 2): ?>
                                      0
                                      <input type="hidden" id="inputAwalUangJalan" value="0">  
                                    <?php else: ?>
                                      <?=str_replace(',', '.', number_format($rl->TOTAL_UANG_JALAN, 0))?>
                                      <input type="hidden" id="inputAwalUangJalan" value="<?=$rl->TOTAL_UANG_JALAN?>"> 
                                    <?php endif ?>
                                     
                                  </td>
                                  <td><?=$rl->MEDIA_UANG_JALAN?></td>
                                  <td class="text-center">
                                    <input type="hidden" id="inputGroupId" value="<?=$groupId?>">
                                    <input type="hidden" id="inputBeforeJalan" value="<?=$realisasiUangJalan?>">
                                    <?php if ($jenisId == 2 && $groupId == 4 || $groupId == 10 && $jenisId == 2): ?>
                                      <center>
                                        <input type="number" id="inputRealisasiUangJalan" class="form-control" value="<?=round($realisasiUangJalan)?>" style="width: 120px">
                                      </center>
                                    <?php else: ?>
                                      <?=str_replace(',', '.', number_format($realisasiUangJalan, 0))?>
                                      <input type="hidden" id="inputRealisasiUangJalan" value="<?=$realisasiUangJalan?>">  
                                    <?php endif ?>  
                                  </td>
                                  <td>
                                    <?php if ( $jenisId == 2 && $groupId == 4 || $groupId == 10 && $jenisId == 2): ?>
                                      <span id="kbJalan"><?=number_format($realisasiUangJalan - $kasbonJalan)?></span>
                                    <?php else: ?>
                                      <?=str_replace(',', '.', number_format($realisasiUangJalan - $rl->TOTAL_UANG_JALAN, 0))?>
                                    <?php endif ?>
                                    <input type="hidden" id="inputKbJalan" value="<?=str_replace(',', '.', number_format($realisasiUangJalan - $rl->TOTAL_UANG_JALAN, 0))?>">
                                  </td>
                                  <td><?=date("d-m-Y", strtotime($tglAdjJalan))?></td>
                                  <td><?=$picAdjJalan?></td>
                                  <td><?=$statusAdjJalan?></td>
                                  <td><?=$rl->ABNORMAL == 'Y'?'SPJ Abnormal':''?></td>
                                </tr>
                                <tr>
                                  <?php
                                    $kasbonBBM = $key->MEDIA_UANG_BBM == 'Kasbon' ? round($key->TOTAL_UANG_BBM):0;
                                    $kasbonTOL = $key->MEDIA_UANG_TOL == 'Kasbon' ? round($key->TOTAL_UANG_TOL) : 0;
                                  ?>
                                  <td>Uang BBM</td>
                                  <td>
                                    <?=$rl->MEDIA_UANG_BBM == 'Kasbon'?str_replace(',', '.', number_format($rl->TOTAL_UANG_BBM, 0)):''?>
                                    <input type="hidden" id="inputKasbonBBM" value="<?=$kasbonBBM?>">
                                    <input type="hidden" id="inputKasbonTOL" value="<?=$kasbonTOL?>">    
                                  </td>
                                  <td>
                                    <?php if ($key->JENIS_ID = '2'): ?>
                                      <select class="select2 form-control" id="inputMediaBBM">
                                        <option value="Reimburse" <?=$rl->MEDIA_UANG_BBM == 'Reimburse' ? 'selected':''?>>Reimburse</option>
                                        <option value="Tanpa BBM" <?=$rl->MEDIA_UANG_BBM == 'Tanpa BBM' ? 'selected':''?>>Tanpa BBM</option>
                                      </select>
                                    <?php else: ?>
                                      <?=$rl->MEDIA_UANG_BBM?><?=$key->VOUCHER_BBM != ''?'<br>'.$key->VOUCHER_BBM:''?>  
                                    <?php endif ?>
                                    
                                      
                                  </td>
                                  <?php 
                                  $valUangBBM = round($key->TOTAL_UANG_BBM);
                                  $valUangTOL = round($key->TOTAL_UANG_TOL);
                                  
                                  if ($rl->ADJUSTMENT_MANAJEMEN == 'Y'): ?>
                                    <td>

                                      <?=str_replace(',', '.', number_format($rl->BBM_DIAJUKAN, 0))?>
                                      <input type="hidden" id="inputRealisasiUangBBM" value="<?=$rl->BBM_DIAJUKAN?>" awal="<?=$rl->TOTAL_UANG_BBM?>">
                                    </td>
                                    <td><?=str_replace(',', '.', number_format($rl->BBM_DIAJUKAN - $rl->TOTAL_UANG_BBM, 0))?></td>
                                  <?php else: ?>
                                    <td>
                                      <?php
                                        if ($key->MEDIA_UANG_BBM == 'Reimburse') {
                                          $bbmPerLiter = $key->BBMPerLiter;
                                          foreach ($validasi as $vld2) {
                                            $kmOut2 = $vld2->KM_OUT;
                                            $kmIn2 = $vld2->KM_IN;
                                          }
                                          $gapKM2 = $kmIn2 -$kmOut2;
                                          $jmlLiter =$bbmPerLiter == null ? 0 : $gapKM2/$bbmPerLiter;
                                          $florLiter = floor($jmlLiter);
                                          $gapLiter = $jmlLiter-$florLiter;
                                          if ($gapLiter>0.2) {
                                            $hasilLiter = $florLiter+1;
                                          }else{
                                            $hasilLiter = $florLiter;
                                          }
                                          // echo $hasilLiter;

                                        }
                                      ?>
                                      <?php if ($key->MEDIA_UANG_BBM == 'Reimburse'): ?>
                                        <input type="hidden" id="inputJmlLiter" value="<?=$hasilLiter?>">
                                        <input type="hidden" id="inputJenisBBM">
                                        <input type="hidden" id="inputHargaBBM">
                                        <input type="hidden" id="inputBeforeBBM" value="<?=$rl->TOTAL_UANG_BBM?>">
                                        <div class="form-group <?=$status_bbm == 'OPEN' || $status_bbm == 'APPROVED' ? 'd-none':''?>">
                                          <label>Jenis BBM</label>
                                          <select class="select2 form-control" id="pilihJenisBBM" style="width: 120px">
                                            <?php foreach ($harga_bbm as $hb): ?>
                                              <option value="<?=$hb->JENIS.'|'.$hb->HARGA?>"><?=$hb->JENIS?></option>
                                            <?php endforeach ?>
                                          </select>
                                          <br>
                                          <p id="keteranganHargaReimburse" class="text-kps"></p>
                                        </div>
                                        <br>
                                        <?php if ($status_bbm == '' || $status_bbm == 'REJECTED'): ?>
                                          <!-- <button type="button" class="btn btn-kps bg-orange btn-block btn-sm ladda-button" id="btnPengajuan" data-style="zoom-in">Ajukan Biaya Ke Otoritas </button>   -->
                                          <button type="button" class="btn btn-kps bg-orange btn-block btn-sm" id="btnModalPengajuan">
                                            Ajukan Biaya BBM Ke Otoritas
                                          </button>
                                        <?php endif ?>
                                        
                                        <?php
                                          switch ($status_bbm) {
                                            case 'OPEN':
                                              $keteranganBBM = 'Menunggu Otoritas Untuk Approve Pengajuan Uang BBM Manual Sebesar Rp. '.number_format($bbm_pengajuan);
                                              $hiddenBBM = 'd-none';   
                                              break;
                                            case 'APPROVED':
                                              $keteranganBBM = 'Pengajuan BBM Sebesar Rp. '.number_format($bbm_pengajuan). ' Telah Di Approve Oleh Otoritas';
                                              $hiddenBBM = 'd-none';   
                                            break;
                                            case 'REJECTED':
                                              $keteranganBBM = 'Pengajuan Pengisian Uang BBM Sebesar Rp. '.number_format($bbm_pengajuan).' Ditolak!';
                                              $hiddenBBM = 'd-none';   
                                            break;
                                            default:
                                              $keteranganBBM = '';
                                              $hiddenBBM = 'd-none';
                                            break;
                                          }
                                        ?>

                                        <p class="text-kps"><?=$keteranganBBM?></p>
                                        <div id="ajukanBiaya" class="<?=$hiddenBBM?>">
                                          <center>
                                            <input type="number" id="inputRealisasiUangBBM" class="form-control form-control-sm" style="width: 120px" awal="<?=$key->STATUS_SPJ == 'CLOSE' ?0: $key->TOTAL_UANG_BBM?>" readonly value="<?=$status_bbm == 'APPROVED'?$bbm_pengajuan:$valUangBBM?>">
                                          </center>  
                                        </div>

                                      <?php elseif($key->MEDIA_UANG_BBM == 'Kasbon'):?>
                                        <center>
                                          <?=number_format($key->TOTAL_UANG_BBM)?>
                                          <input type="hidden" id="inputRealisasiUangBBM" class="form-control form-control-sm" style="width: 120px" awal="<?=$key->STATUS_SPJ == 'CLOSE' ?0: $key->TOTAL_UANG_BBM?>" <?=$key->MEDIA_UANG_BBM == 'Reimburse'?'':'readonly'?> value="<?=$valUangBBM?>">
                                        </center>  
                                      <?php else: ?>
                                        <center>
                                          <input type="number" id="inputRealisasiUangBBM" class="form-control form-control-sm" style="width: 120px" awal="<?=$key->STATUS_SPJ == 'CLOSE' ?0: $key->TOTAL_UANG_BBM?>" <?=$key->MEDIA_UANG_BBM == 'Reimburse'?'':'readonly'?> value="<?=$valUangBBM?>">
                                        </center>  
                                      <?php endif ?>
                                      
                                      <input type="hidden" id="inputMediaUangBBM" value="<?=$key->MEDIA_UANG_BBM?>">
                                    </td>
                                    <td>
                                      <span id="kbBBm"></span>
                                        
                                    </td>
                                  <?php endif ?>
                                  <input type="hidden" id="inputKbBBM" class="form-control form-control-sm" style="width: 120px" readonly>
                                  <input type="hidden" id="totalUangTambahan" value="<?=$realisasiUangSaku+$realisasiUangMakan?>">
                                  <input type="hidden" id="totalKBTambahan" value="<?=($realisasiUangSaku - $rl->TOTAL_UANG_SAKU)+($realisasiUangMakan - $rl->TOTAL_UANG_MAKAN)+($realisasiUangJalan - $kasbonJalan)?>">
                                  <td><?=$rl->TGL_BBM == null ? '' : date("d-m-Y", strtotime($rl->TGL_BBM))?></td>
                                  <td><?=$rl->PIC_BBM?></td>
                                  <td><?=$rl->BBM_STATUS == null ? 'OPEN':$rl->BBM_STATUS?></td>
                                  <td><?='Uang BBM Menggunakan Media '.$rl->MEDIA_UANG_BBM?></td>
                                </tr>
                                <tr>
                                  <td>Uang Tol</td>
                                  <td>
                                    <?php if ($rl->MEDIA_UANG_TOL == 'Kasbon'):?>
                                      <?=str_replace(',', '.', number_format($rl->TOTAL_UANG_TOL, 0))?>
                                    <?php else: ?>
                                      <?=$kasbonTOL?>  
                                    <?php endif ?>
                                    
                                  </td>
                                  <td><?=$rl->MEDIA_UANG_TOL?></td>
                                  <td>
                                    <center>
                                      <?php if ($key->MEDIA_UANG_TOL == 'Reimburse'):?>
                                          <input type="hidden" id="inputBeforeTOL" value="<?=$rl->TOTAL_UANG_TOL?>">
                                          <input type="number" id="inputRealisasiUangTol" class="form-control form-control-sm" style="width: 120px" value="<?=round($rl->TOTAL_UANG_TOL)?>" awal="<?=$key->STATUS_SPJ == 'CLOSE'?0:$key->TOTAL_UANG_TOL?>" <?=$key->STATUS_SPJ == 'CLOSE'?'readonly':''?>>
                                      <?php else: ?>
                                          <input type="number" id="inputRealisasiUangTol" class="form-control form-control-sm" style="width: 120px" value="<?=round($rl->TOTAL_UANG_TOL)?>" awal="<?=$key->STATUS_SPJ == 'CLOSE'?0:$key->TOTAL_UANG_TOL?>" readonly>
                                      <?php endif ?>
                                      <input type="hidden" id="inputMediaUangTOL" value="<?=$key->MEDIA_UANG_TOL?>">
                                    </center>
                                  </td>
                                  <td>
                                    <span id="kbTOL"><?=number_format($rl->TOTAL_UANG_TOL-$kasbonTOL)?></span>
                                    <input type="hidden" id="inputKbTOL" class="form-control form-control-sm" style="width: 120px" readonly>
                                  </td>
                                  <td><?=$rl->TGL_CLOSE == null ? '' :date("d-m-Y", strtotime($rl->TGL_CLOSE))?></td>
                                  <td><?=$rl->PIC_CLOSE?></td>
                                  <td><?=$rl->PIC_CLOSE == null ? 'OPEN':'CLOSE'?></td>
                                  <td><?='Uang TOL Menggunakan Media '.$rl->MEDIA_UANG_TOL?></td>
                                </tr>
                                <?php if ($key->KENDARAAN == 'Gojek/Grab'): ?>
                                  <tr>
                                    <td>Uang Kendaraan</td>
                                    <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_KENDARAAN, 0))?></td>
                                    <td><?=$key->MEDIA_UANG_KENDARAAN?></td>
                                    <td>
                                      <center>
                                        <?php if ($key->KENDARAAN == 'Gojek/Grab'): ?>
                                           <input type="number" id="inputRealisasiUangKendaraan" class="form-control form-control-sm" style="width: 120px" value="<?=round($rl->TOTAL_UANG_KENDARAAN)?>" awal="<?=$key->STATUS_SPJ == 'CLOSE'?0:$key->TOTAL_UANG_KENDARAAN?>">
                                        <?php else: ?>
                                          <?=str_replace(',', '.', number_format($key->TOTAL_UANG_KENDARAAN, 0))?>
                                        <?php endif ?>
                                      </center>
                                    </td>
                                    <td>0</td>
                                    <td><?=date("Y-m-d", strtotime($key->TGL_SPJ))?></td>
                                    <td><?=$key->namapeg?></td>
                                    <td>CLOSE</td>
                                    <td>SPJ Menggunakan Gojek/Grab</td>
                                  </tr>
                                <?php endif ?>
                              <?php endforeach ?>
                              <?php if ($key->JENIS_ID == 2): ?>
                                <tr>
                                  <td>Biaya Lainnya</td>
                                  <td>0</td>
                                  <td>Reimburse</td>
                                  <td>
                                    <center>
                                      <input type="hidden" id="inputbeforeLainnya" value="<?=round($key->TOTAL_UANG_LAINNYA)?>">
                                      <input type="number" id="inputRealisasiBiayaLainnya" class="form-control form-control-sm" style="width: 120px" value="<?=round($key->TOTAL_UANG_LAINNYA)?>">
                                    </center>
                                  </td>
                                  <td>
                                    <span id="kbLainnya"><?=number_format($key->TOTAL_UANG_LAINNYA)?></span>
                                      <input type="hidden" id="inputKbLainnya" class="form-control form-control-sm" style="width: 120px" readonly>
                                  </td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td><textarea class="form-control" id="inputKeteranganLainnya" rows="3"><?=$key->KETERANGAN_LAINNYA?></textarea></td>
                                </tr> 
                              <?php endif ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>TOTAL:</th>
                                <th>Rp. <?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU+$key->TOTAL_UANG_MAKAN+$kasbonJalan+$kasbonBBM+$kasbonTOL+$key->TOTAL_UANG_KENDARAAN, 0))?></th>
                                <th></th>
                                <th><span id="totalRealisasi">Rp. <?=str_replace(',', '.', number_format($realisasiUangSaku+$realisasiUangMakan+$realisasiUangJalan+$valUangBBM+$valUangTOL+$key->TOTAL_UANG_KENDARAAN+$key->TOTAL_UANG_LAINNYA, 0))?></span></th>
                                <th><span id="totalKB"></span></th>
                                <th colspan="4"></th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <button type="button" class="btn btn-secondary btn-block saveBiaya ladda-button" data-style="zoom-in" id="saveBiaya">Save Biaya</button>
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
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table table-hover table-valign-middle text-center">
                            <thead>
                              <tr>
                                <th rowspan="2"></th>
                                <th colspan="2">Rencana</th>
                                <th colspan="2">Aktual</th>
                                <th rowspan="2">GAP</th>
                                <th rowspan="2">KM</th>
                              </tr>
                              <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($validasi as $vld): 
                                $kmOut = $vld->KM_OUT;
                                $kmIn = $vld->KM_IN;
                              ?>
                                <tr>
                                  <td class="text-left">Keberangkatan</td>
                                  <td><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
                                  <td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
                                  <td>
                                    <!-- <?=date("d F Y", strtotime($vld->KEBERANGKATAN))?> -->
                                    <input type="date" class="form-control" id="inputTglKeberangkatan" value="<?=date("Y-m-d", strtotime($vld->KEBERANGKATAN))?>">
                                  </td>
                                  <td>
                                    <!-- <?=date("H:i", strtotime($vld->KEBERANGKATAN))?> -->
                                    <input type="time" class="form-control" id="inputJamKeberangkatan" value="<?=date("H:i", strtotime($vld->KEBERANGKATAN))?>">
                                  </td>
                                  <td>
                                    <?php
                                      $aktualBerangkat = date("Y-m-d", strtotime($vld->KEBERANGKATAN));
                                      $aktualBerangkatJam = date("H:i", strtotime($vld->KEBERANGKATAN));
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
                                    <!-- <?=number_format($vld->KM_OUT)?> -->
                                    <input type="number" id="inputKmOut" value="<?=$vld->KM_OUT?>" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="text-left">Kepulangan</td>
                                  <td><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
                                  <td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
                                  <td>
                                    <!-- <?=date("d F Y", strtotime($vld->KEPULANGAN))?> -->
                                    <input type="date" class="form-control" id="inputTglKepulangan" value="<?=date("Y-m-d", strtotime($vld->KEPULANGAN))?>">
                                  </td>
                                  <td>
                                    <!-- <?=date("H:i", strtotime($vld->KEPULANGAN))?> -->
                                    <input type="time" class="form-control" id="inputJamKepulangan" value="<?=date("H:i", strtotime($vld->KEPULANGAN))?>">
                                  </td>
                                  <td>
                                    <?php
                                        $aktualPulang = $vld->KEPULANGAN == null?date("Y-m-d"):date("Y-m-d", strtotime($vld->KEPULANGAN));
                                        $aktualPulangJam = $vld->KEPULANGAN == null?date("H:i"):date("H:i", strtotime($vld->KEPULANGAN));
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
                                      
                                    ?>
                                  </td>
                                  <td>
                                  <!-- <?=number_format($vld->KM_IN)?> -->
                                    <input type="number" id="inputKmIn" value="<?=$vld->KM_IN?>" class="form-control">
                                  </td>
                                </tr>    
                              <?php endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="6" class="text-right">Selisih KM</th>
                                <th>
                                  <?php
                                    $gapKM = $kmIn - $kmOut;
                                    echo str_replace(',', '.', number_format($gapKM, 0))
                                  ?>
                                </th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <button type="button" class="btn btn-secondary btn-block saveKeberangkatan ladda-button" data-style="zoom-in" id="saveKeberangkatan">Save Keberangkatan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if ($key->STATUS_SPJ != 'CLOSE'): ?>
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <button type="button" class="btn bg-orange btn-kps btn-block saveClose ladda-button" data-style="zoom-in" id="saveClose">
                    Close Realisasi
                  </button>
                </div>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-pengajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" id="inputIdSPJ" value="<?=$this->uri->segment('3') ?>">
                <div class="form-group">
                  <label>Jumlah Pengajuan BBM</label>
                  <input type="number" id="inputPengajuanBBM" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" id="inputKeteranganBBM"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-orange btn-kps ladda-button savePengajuanBBM" id="savePengajuanBBM" data-style="expand-right">Save</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-uangKasbon" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-6"><label>PIC</label></div>
              <div class="col-md-8 col-sm-6">: <span id="viewPIC"></span></div>
              <input type="hidden" id="inputNIK">
              <input type="hidden" id="inputJenis">
              <input type="hidden" id="inputBeforeUang">
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Total Uang</label>
                  <input type="number" id="inputUang" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-orange btn-kps ladda-button saveTotalUang" id="saveTotalUang" data-style="expand-right">Save</button>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view('_partial/footer');?>
</div>
<?php $this->load->view("_partial/js");?>
<script src="<?= base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url()?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/spin.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/ladda.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/ladda.jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $('.select2').select2({
        'width': '100%',
    });
    hitungKBBBm();
    hitungKBTOL();
    totalBiaya();
    hitungKBUangJalan();
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('#inputRealisasiUangBBM').on('keyup', function(){
      hitungKBBBm();
      totalBiaya();
    });
    $('#inputRealisasiUangTol').on('keyup', function(){
      hitungKBTOL();
      totalBiaya();
    });

    $('#inputRealisasiUangJalan').on('keyup', function(){
      hitungKBUangJalan();
      totalBiaya();
    });
    $('#inputRealisasiBiayaLainnya').on('keyup', function(){
      hitungKBLainnya();
      totalBiaya();
    })
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    var saveClose = $('.saveClose').ladda();
      saveClose.click(function () {
      // Start loading
      saveClose.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var status_bbm = '<?=$status_bbm?>';
        if (status_bbm == 'OPEN') {
          Swal.fire("Pengajuan Isian BBM Belum Close","Hubungi Otoritas","warning")

        }else{
          saveImplementasi()
          
        } 
        saveClose.ladda('stop');
        return false;  
      }, 1000)
    });

    var saveBiaya = $('.saveBiaya').ladda();
      saveBiaya.click(function () {
      // Start loading
      saveBiaya.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var status_bbm = '<?=$status_bbm?>';
        if (status_bbm == 'OPEN') {
          Swal.fire("Pengajuan Isian BBM Belum Close","Hubungi Otoritas","warning")

        }else{
          cekSaldo();
          
        } 
        saveBiaya.ladda('stop');
        return false;  
      }, 1000)
    });
    var btnPengajuan = $('#btnPengajuan').ladda();
    btnPengajuan.click(function () {
      // Start loading
      btnPengajuan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var idSPJ = '<?=$this->uri->segment("3")?>';
        console.log(idSPJ)
        $.ajax({
          type:'get',
          data:{idSPJ},
          dataType:'json',
          url:url+'/implementasi/pengajuanOtoritasBBM',
          cache:false,
          async:true,
          beforeSend:function(data){
            $('#btnPengajuan').attr("disabled","disabled");
          },
          success:function(data){
            Swal.fire(data.message,data.sub_message,data.status)
          },
          complete:function(data){
            btnPengajuan.ladda('stop');
          },
          error:function(data){
            Swal.fire("Gagal Mengajukan","Hubungi Staff IT","error")
          }

        })
        return false;
          
      }, 1000)
    });
    $('#pilihJenisBBM').on('change', function(){
      hitungBBMReimburse();
    })
    hitungBBMReimburse();
    $('#btnModalPengajuan').on('click', function(){
      var idSPJ = '<?=$this->uri->segment("3")?>';
      $.ajax({
        type:'get',
        url:url+'/implementasi/cekPengajuanBBM',
        dataType:'json',
        cache:false,
        async:true,
        data:{idSPJ},
        success:function(data){
          if (data == '0') {
           $('#modal-pengajuan').modal("show") 
          }else{
            Swal.fire("SPJ Ini Sedang Diajukan BBM ke Otoritas","Hubungi Otoritas Agar Proses Implementasi Selesai","warning");
          }
        },
        error:function(data){
          Swal.fire("Gagal Mengajukan BBM","Hubungi Staff IT","error")
        }
      })
      
    })
    var savePengajuanBBM = $('#savePengajuanBBM').ladda();
    savePengajuanBBM.click(function () {
      // Start loading
      savePengajuanBBM.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputIdSPJ = $('#inputIdSPJ').val();
        var inputPengajuanBBM = $('#inputPengajuanBBM').val();
        var inputKeteranganBBM = $('#inputKeteranganBBM').val();
        if (inputPengajuanBBM == '' || parseInt(inputPengajuanBBM)<=0 || inputKeteranganBBM =='') {
          Swal.fire("Pengajuan BBM Tidak Boleh kurang dari 0","","warning")
          savePengajuanBBM.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            data:{inputIdSPJ, inputPengajuanBBM, inputKeteranganBBM},
            dataType:'json',
            url:url+'/implementasi/pengajuanOtoritasBBM_v2',
            cache:false,
            async:true,
            beforeSend:function(data){
              $('#savePengajuanBBM').attr("disabled", true)
            },
            success:function(data){
              $('#btnModalPengajuan').attr("disabled",true)
              Swal.fire("Berhasil Mengajukan BBM","Hubungi Otoritas Agar Proses Implementasi Cepat Selesai","success")
            },
            complete:function(data){
              $('#savePengajuanBBM').removeAttr("disabled",false)
              savePengajuanBBM.ladda('stop');
            },
            error:function(data){
              Swal.fire("Gagal Mengajukan BBM","Hubungi Staff IT","error")
            }
          }) 
        }
        
        
        return false;
          
      }, 1000)
    });
    $('.btnEditUangMakanKasbon').on('click',function(){
      var nik = $(this).attr("nik")
      var uang = $(this).attr("uang")
      var nama = $(this).attr("nama")
      var jenis = $(this).attr("jenis")
      $('#inputNIK').val(nik)
      $('#inputUang').val(uang)
      $('#inputJenis').val(jenis)
      $('#inputBeforeUang').val(uang)
      $('#viewPIC').html(nik+' - '+nama)
      $('#modal-uangKasbon').modal("show")
    })

    var saveTotalUang = $('#saveTotalUang').ladda();
    saveTotalUang.click(function () {
      // Start loading
      saveTotalUang.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputNIK = $('#inputNIK').val();
        var inputUang = $('#inputUang').val();
        var inputBeforeUang = $('#inputBeforeUang').val();
        var inputJenis = $('#inputJenis').val();
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        $.ajax({
          type:'post',
          data:{inputNoSPJ, inputNIK, inputUang, inputJenis, inputJenisSPJ, inputBeforeUang},
          dataType:'json',
          cache:false,
          async:true,
          url:url+'/implementasi/revisiTotalUangPerPIC',
          beforeSend:function(data){
            $('#saveTotalUang').attr("disabled", true)
          },
          success:function(data){
            Swal.fire("Berhasil Merevisi "+inputJenis,"","success")
            location.reload();
          },
          complete:function(data){
            saveTotalUang.ladda('stop');
            $('#saveTotalUang').attr("disabled", false)
          },
          error:function(data){
            Swal.fire("Gagal Merevisi "+inputJenis,"Hubungi Staff IT","error")
          }
        })  
        
        
        return false;
          
      }, 1000)
    });
    var saveKeberangkatan = $('#saveKeberangkatan').ladda();
    saveKeberangkatan.click(function () {
      // Start loading
      saveKeberangkatan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputTglKeberangkatan = $('#inputTglKeberangkatan').val();
        var inputJamKeberangkatan = $('#inputJamKeberangkatan').val();
        var inputKmOut = $('#inputKmOut').val();
        var inputKmIn = $('#inputKmIn').val();
        var inputTglKepulangan = $('#inputTglKepulangan').val();
        var inputJamKepulangan = $('#inputJamKepulangan').val();
        var inputJenis = $('#inputJenis').val();
        $.ajax({
          type:'post',
          data:{inputNoSPJ, inputTglKeberangkatan, inputJamKeberangkatan, inputTglKepulangan, inputJamKepulangan, inputKmOut, inputKmIn},
          dataType:'json',
          cache:false,
          async:true,
          url:url+'/implementasi/revisiKeberangkatan',
          beforeSend:function(data){
            $('#saveKeberangkatan').attr("disabled", true)
          },
          success:function(data){
            Swal.fire("Berhasil Merevisi Keberangkatan","","success")
            // location.reload();
          },
          complete:function(data){
            saveKeberangkatan.ladda('stop');
            $('#saveKeberangkatan').attr("disabled", false)
          },
          error:function(data){
            Swal.fire("Gagal Merevisi Keberangkatan","Hubungi Staff IT","error")
          }
        })  
        
        
        return false;
          
      }, 1000)
    });
  })
  function hitungBBMReimburse() {
    var inputMediaUangBBM = $('#inputMediaUangBBM').val();
    var status_bbm = '<?=$status_bbm?>';
    var bbm_pengajuan = '<?=round($bbm_pengajuan)?>';
    if (inputMediaUangBBM == 'Reimburse') {
      var inputJmlLiter = parseFloat($('#inputJmlLiter').val());
      var pilihJenisBBM = $('#pilihJenisBBM').val();
      var pisahHarga = pilihJenisBBM.split('|');
      var jenis = pisahHarga[0];
      var harga = parseFloat(pisahHarga[1]);
      var totalHargaBBM = status_bbm == 'APPROVED' ? bbm_pengajuan:inputJmlLiter * harga;
      $('#inputRealisasiUangBBM').val(totalHargaBBM)  
      $('#inputJenisBBM').val(jenis);
      $('#inputHargaBBM').val(harga)
      hitungKBBBm();
      totalBiaya();
      $('#keteranganHargaReimburse').html("Harga Reimburse Berdasarkan Rumus : "+formatRupiah(Number(totalHargaBBM).toFixed(0), ''));
    }
    console.log("total BBM "+totalHargaBBM)
    
  }
  function hitungKBBBm() {
    var tambahan = $('#inputRealisasiUangBBM').val();
    var awal = $('#inputRealisasiUangBBM').attr("awal");
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbBBM').val(kb);
    $('#kbBBm').html(formatRupiah(Number(kb).toFixed(0), ''));
  }
  function hitungKBTOL() {
    var tambahan = $('#inputRealisasiUangTol').val();
    var awal = '<?=$kasbonTOL?>';
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbTOL').val(kb);
    $('#kbTOL').html(formatRupiah(Number(kb).toFixed(0), ''));
    console.log(kb)
  }
  function hitungKBLainnya() {
    var tambahan = $('#inputRealisasiBiayaLainnya').val();
    var awal = 0;
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbLainnya').val(kb);
    $('#kbLainnya').html(formatRupiah(Number(kb).toFixed(0), ''));
    console.log(kb)
  }
  function hitungKBUangJalan() {
    var tambahan = $('#inputRealisasiUangJalan').val();
    var awal = $('#inputAwalUangJalan').val();
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbJalan').val(kb)
    $('#kbJalan').html(formatRupiah(Number(kb).toFixed(0), ''))
  }

  function totalBiaya() {
    var totalUangTambahan = $('#totalUangTambahan').val() == '' ? 0 : $('#totalUangTambahan').val();
    var totalKBTambahan = $('#totalKBTambahan').val() == '' ? 0 : $('#totalKBTambahan').val();
    var tambahanBBM = $('#inputRealisasiUangBBM').val() == '' ? 0 : $('#inputRealisasiUangBBM').val();
    var tambahanTOL = $('#inputRealisasiUangTol').val() == '' ? 0 : $('#inputRealisasiUangTol').val();
    var tambahanJalan = $('#inputRealisasiUangJalan').val() == '' ? 0 : $('#inputRealisasiUangJalan').val();
    var inputKbBBM = $('#inputKbBBM').val() == 'NaN' || $('#inputKbBBM').val() == ''? 0 : $('#inputKbBBM').val();
    var inputKbTOL = $('#inputKbTOL').val() == 'NaN' || $('#inputKbTOL').val() == ''? 0 : $('#inputKbTOL').val();
    var inputKbJalan = $('#inputKbJalan').val() == 'NaN' || $('#inputKbJalan').val() == ''? 0 : $('#inputKbJalan').val();
    var kendaraan = $('#inputRealisasiUangKendaraan').val() == '' ? 0 :$('#inputRealisasiUangKendaraan').val();
    var lainnya = $('#inputRealisasiBiayaLainnya').val()==''? 0 : $('#inputRealisasiBiayaLainnya').val();
    var inputKbLainnya = $('#inputKbLainnya').val() == '' ? 0 : $('#inputKbLainnya').val();
    var totalRealisasi = parseInt(totalUangTambahan) + parseInt(tambahanBBM) + parseInt(tambahanTOL) + parseInt(tambahanJalan) + parseInt(kendaraan) + parseInt(lainnya)
    console.log(inputKbLainnya);
    var totalKB = parseInt(totalKBTambahan) + parseInt(inputKbBBM) + parseInt(inputKbTOL) + parseInt(inputKbJalan) + parseInt(inputKbLainnya)
    $('#totalRealisasi').html(formatRupiah(Number(totalRealisasi).toFixed(0), 'Rp. '))
    $('#totalKB').html(formatRupiah(Number(totalKB).toFixed(0), 'Rp. '))
    console.log(inputKbLainnya)
    console.log(totalRealisasi)
    console.log(totalKB)
  }

  function cekSaldo() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputMediaUangTOL = $('#inputMediaUangTOL').val();
    var inputRealisasiUangTol = $('#inputRealisasiUangTol').val();
    var kasbon = "Kasbon TOL "+inputJenisSPJ;
    if (inputRealisasiUangTol != '') {
      $.ajax({
        type:'get',
        data:{kasbon},
        dataType: 'json',
        url:url+'/Implementasi/cekSaldo',
        cache: false,
        async: true,
        success: function(data){
          if (inputRealisasiUangTol>data && inputMediaUangTOL == 'Reimburse') {
            Swal.fire("Saldo Tidak Mencukupi!","Hubungi PIC Terkait","warning")
          }else{
            saveBiaya(inputJenisSPJ)
          }
          
        },
        error: function(data){

        }
      }); 
    }else{
      Swal.fire("Isi Terlebih Dahulu Uang TOL","","warning")
    }
    
  }
  function saveBiaya(inputJenisSPJ) {
    var inputRealisasiUangSaku = $('#inputRealisasiUangSaku').val();
    var inputRealisasiUangMakan = $('#inputRealisasiUangMakan').val();
    var inputRealisasiUangJalan = $('#inputRealisasiUangJalan').val();
    var inputRealisasiUangBBM = $('#inputRealisasiUangBBM').val();
    var inputRealisasiUangTol = $('#inputRealisasiUangTol').val();
    var inputMediaUangBBM = $('#inputMediaUangBBM').val();
    var inputMediaUangTOL = $('#inputMediaUangTOL').val();
    var inputNoSPJ = $('#inputNoSPJ').val(); 
    var inputId = $('#inputId').val();
    var inputJenisBBM = $('#inputJenisBBM').val();
    var inputHargaBBM = $('#inputHargaBBM').val();
    var inputBeforeTOL = $('#inputBeforeTOL').val();  
    var inputBeforeBBM = $('#inputBeforeBBM').val();  
    var inputGroupId = $('#inputGroupId').val();
    var inputBeforeJalan = $('#inputBeforeJalan').val();
    var inputRealisasiUangKendaraan = $('#inputRealisasiUangKendaraan').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputRealisasiBiayaLainnya = $('#inputRealisasiBiayaLainnya').val();
    var inputKeteranganLainnya = $('#inputKeteranganLainnya').val();
    var inputbeforeLainnya = $('#inputbeforeLainnya').val();
    if(inputRealisasiUangBBM == '' && inputMediaUangBBM == 'Reimburse'){
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'warning',
        title: 'Isi Terlebih Dahulu Biaya BBM!',
        showConfirmButton: false,
        timer: 2500
      })
      document.getElementById("inputRealisasiUangBBM").focus();
      $('html, body').animate({
          scrollTop: $("#divBiaya").offset().top
      }, 500);
    }else if(inputRealisasiUangTol == '' && inputMediaUangTOL == 'Reimburse'){
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'warning',
        title: 'Isi Terlebih Dahulu Biaya TOL!',
        showConfirmButton: false,
        timer: 2500
      })
      document.getElementById("inputRealisasiUangTol").focus();
      $('html, body').animate({
          scrollTop: $("#divBiaya").offset().top
      }, 500);
    }else{
      $.ajax({
        type:'post',
        data:{inputNoSPJ, inputRealisasiUangSaku, inputRealisasiUangMakan, inputRealisasiUangJalan, inputRealisasiUangBBM, inputRealisasiUangTol, inputJenisSPJ, inputId, inputMediaUangTOL, inputBeforeTOL, inputJenisBBM, inputHargaBBM, inputMediaUangBBM, inputBeforeBBM, inputGroupId, inputBeforeJalan, inputRealisasiUangKendaraan, inputKendaraan, inputRealisasiBiayaLainnya, inputKeteranganLainnya, inputbeforeLainnya},
        url:url+'/implementasi/saveBiaya',
        cache: false,
        async: true,
        beforeSend:function(data){
          $('.saveBiaya').attr("disabled","disabled");
        },
        success: function(data){
          Swal.fire("Berhasil Menyimpan Data Biaya","","success");
        },
        complete: function(data){
          $('.saveBiaya').removeAttr("disabled","disabled");
        },
        error: function(data){
          Swal.fire("Gagal Menyimpan Data!","Reload Terlebih Dahulu Halaman Ini atau Hubungi Staff IT","error")
        }
      });
    }
  }
  function saveImplementasi() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputStatusUS1 = $('#inputStatusUS1').val();
    var inputStatusUS2 = $('#inputStatusUS2').val();
    var inputStatusUM = $('#inputStatusUM').val();
    var inputStatusAdjMakan = $('#inputStatusAdjMakan').val();
    var inputRealisasiUangBBM = $('#inputRealisasiUangBBM').val();
    var inputRealisasiUangTol = $('#inputRealisasiUangTol').val();
    var inputMediaUangBBM = $('#inputMediaUangBBM').val();
    var inputMediaUangTOL = $('#inputMediaUangTOL').val();
    var inputNoSPJ = $('#inputNoSPJ').val(); 
    if (inputStatusUS1 != 'CLOSE') {
      Swal.fire("Status Uang Saku Ke 2 Masih Belum Close!","Hubungi PIC Terkait","warning")
      $('html, body').animate({
          scrollTop: $("#divPIC").offset().top
      }, 500);
    }else if(inputStatusUS2 != 'CLOSE'){
      Swal.fire("Status Uang Saku Ke 2 Masih Belum Close!","Hubungi PIC Terkait","warning")
      $('html, body').animate({
          scrollTop: $("#divPIC").offset().top
      }, 500);
    }else if(inputStatusUM!= 'CLOSE'){
      Swal.fire("Status Uang Makan Ke 2 Masih Belum Close!","Hubungi PIC Terkait","warning")
      $('html, body').animate({
          scrollTop: $("#divPIC").offset().top
      }, 500);
    }else if(inputStatusAdjMakan!= 'CLOSE'){
      Swal.fire("Status Uang Makan Adjustment Masih Belum Close!","Hubungi PIC Terkait","warning")
      $('html, body').animate({
          scrollTop: $("#divPIC").offset().top
      }, 500);
    }else if(inputRealisasiUangBBM == '' && inputMediaUangBBM == 'Reimburse'){
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'warning',
        title: 'Isi Terlebih Dahulu Biaya BBM!',
        showConfirmButton: false,
        timer: 2500
      })
      document.getElementById("inputRealisasiUangBBM").focus();
      $('html, body').animate({
          scrollTop: $("#divBiaya").offset().top
      }, 500);
    }else if(inputRealisasiUangTol == '' && inputMediaUangTOL == 'Reimburse'){
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'warning',
        title: 'Isi Terlebih Dahulu Biaya TOL!',
        showConfirmButton: false,
        timer: 2500
      })
      document.getElementById("inputRealisasiUangTol").focus();
      $('html, body').animate({
          scrollTop: $("#divBiaya").offset().top
      }, 500);
    }else{
      $.ajax({
        type:'post',
        data:{inputNoSPJ},
        dataType:'json',
        cache:false,
        async:true,
        url:url+'/implementasi/closeImplementasi',
        beforeSend:function(data){
          $('.saveClose').attr("disabled","disabled");
        },
        success: function(data){
          Swal.fire("Berhasil Menyimpan Data Biaya","","success");
          window.location.href=url+'/implementasi/step_1'
        },
        complete: function(data){
          $('.saveClose').removeAttr("disabled","disabled");
        },
        error: function(data){
          Swal.fire("Gagal Menyimpan Data!","Reload Terlebih Dahulu Halaman Ini atau Hubungi Staff IT","error")
        }
      })
    }
  }
  
  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split       = number_string.split(','),
    sisa        = split[0].length % 3,
    rupiah        = split[0].substr(0, sisa),
    ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

</script>
<!-- FootJS -->
</body>
</html>

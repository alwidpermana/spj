<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .fotoWajah{
      max-width: 75px;
      width: auto;
      height: auto;

    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed">
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
          <?php foreach ($data as $key): ?>
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
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                : <label><?=date("d F Y", strtotime($key->TGL_INPUT))?></label>
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
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12" id="afterNext">
                                : <label><?=$key->NAMA_JENIS?></label>
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
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                : <label><?=$key->NO_SPJ?></label>
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
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                : <label><?=date("d F Y", strtotime($key->TGL_SPJ))?></label>
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
                          <div class="col-md-11"> 
                            <label>NIK</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        : <label><?=$key->PIC_INPUT?></label>
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
                      <div class="col-md-4">
                        : <label><?=$key->namapeg?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Jabatan</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        : <label><?=$key->jabatan?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Departemen</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        : <label><?=$key->departemen?></label>
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
                      <div class="col-md-4">
                        : <label><?=$key->Subdepartemen?></label>
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
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>Kendaraan</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->KENDARAAN?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>Jenis Kendaraan</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->JENIS_KENDARAAN?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>No Inventaris</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->NO_INVENTARIS?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>Merk</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->MERK?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>Type</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->TYPE?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12"> 
                            <label>No TNKB</label>  
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            : <label><?=$key->NO_TNKB?></label>
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
                            : <label>
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
                          <table class="table table-hover table-valign-middle text-center">
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
                                  <td>Pendamping</td>
                                  <td><?=$pc->OBJEK?></td>
                                  <td>
                                    <?php if ($pc->FOTO_WAJAH != null || $pc->FOTO_WAJAH !=''): ?>
                                      <a href="javascript:;" class="getFotoWajah" foto="<?=$pc->FOTO_WAJAH?>">
                                        <img src="<?=base_url()?>assets/image/foto-wajah/<?=$pc->FOTO_WAJAH?>" class="img-thumbnail fotoWajah">
                                      </a>
                                    <?php endif ?>
                                  </td>
                                  <td><?=$pc->NIK?></td>
                                  <td><?=$pc->NAMA?></td>
                                  <td><?=$pc->DEPARTEMEN?></td>
                                  <td><?=$pc->SUB_DEPARTEMEN?></td>
                                  <td><?=$pc->JABATAN?></td>
                                  <td><?=$pc->SORTIR == 'Y'?'Sortir':'Reguler'?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU, 0))?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?></td>
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
                                $picAdjJalan = $pc->PIC_KEPUTUSAN_JALAN ==null?'SYSTEM':$pc->PIC_KEPUTUSAN_JALAN;
                                $tglAdjJalan = $pc->TGL_KEPUTUSAN_JALAN == null?date("d-m-Y"): $pc->TGL_KEPUTUSAN_JALAN;
                              endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="9" class="text-right">Status</th>
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
                                <th colspan="9" class="text-right">Total</th>
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
                <div class="card">
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
                                $kasbonUangSaku = $rl->TOTAL_UANG_SAKU;
                                $realisasiUangSaku = $rl->REALISASI_UANG_SAKU;
                                $kasbonUangMakan = $rl->TOTAL_UANG_MAKAN;
                                $realisasiUangMakan = $rl->REALISASI_UANG_MAKAN;
                                $kasbonUangJalan = $rl->TOTAL_UANG_JALAN;
                                $realisasiUangJalan = $rl->REALISASI_UANG_JALAN;
                                $realisasiTOL = $rl->TOTAL_UANG_TOL;
                              ?>
                                <tr>
                                  <td>Uang Saku</td>
                                  <td><?=str_replace(',', '.', number_format($rl->TOTAL_UANG_SAKU, 0))?></td>
                                  <td><?=$rl->MEDIA_UANG_SAKU?></td>
                                  <td>
                                    <?=str_replace(',', '.', number_format($rl->REALISASI_UANG_SAKU, 0))?>
                                    <input type="hidden" id="inputRealisasiUangSaku" value="<?=$rl->REALISASI_UANG_SAKU?>">    
                                  </td>
                                  <td><?=str_replace(',', '.', number_format($rl->REALISASI_UANG_SAKU - $rl->TOTAL_UANG_SAKU, 0))?></td>
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
                                    <?=str_replace(',', '.', number_format($rl->REALISASI_UANG_MAKAN, 0))?>
                                    <input type="hidden" id="inputRealisasiUangMakan" value="<?=$rl->REALISASI_UANG_MAKAN?>">    
                                  </td>
                                  <td><?=str_replace(',', '.', number_format($rl->REALISASI_UANG_MAKAN - $rl->TOTAL_UANG_MAKAN, 0))?></td>
                                  <?php if ($rl->ADJUSTMENT_MANAJEMEN == 'Y'): ?>
                                    <td><?=$statusAdjMakan?></td>
                                    <td><?=$tglAdjMakan?></td>
                                    <td><?=$picAdjMakan?></td>
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
                                  <td><?=str_replace(',', '.', number_format($rl->TOTAL_UANG_JALAN, 0))?></td>
                                  <td><?=$rl->MEDIA_UANG_JALAN?></td>
                                  <td>
                                    <?=str_replace(',', '.', number_format($rl->REALISASI_UANG_JALAN, 0))?>
                                    <input type="hidden" id="inputRealisasiUangJalan" value="<?=$rl->REALISASI_UANG_JALAN?>">    
                                  </td>
                                  <td><?=str_replace(',', '.', number_format($rl->REALISASI_UANG_JALAN - $rl->TOTAL_UANG_JALAN, 0))?></td>
                                  <td><?=$tglAdjJalan?></td>
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
                                       
                                  </td>
                                  <td><?=$rl->MEDIA_UANG_BBM?><?=$key->VOUCHER_BBM != ''?'<br>'.$key->VOUCHER_BBM:''?></td>
                                  <?php 
                                  $valUangBBM = $key->MEDIA_UANG_BBM == 'Kasbon' ? 0 : round($key->TOTAL_UANG_BBM);
                                  $valUangTOL = $key->MEDIA_UANG_TOL == 'Kasbon' ? 0 : round($key->TOTAL_UANG_TOL);
                                  
                                  if ($rl->ADJUSTMENT_MANAJEMEN == 'Y'): ?>
                                    <td>
                                      <?=str_replace(',', '.', number_format($rl->BBM_DIAJUKAN, 0))?>  
                                    </td>
                                    <td><?=str_replace(',', '.', number_format($rl->BBM_DIAJUKAN - $rl->TOTAL_UANG_BBM, 0))?></td>
                                  <?php else: ?>
                                    <td>
                                      
                                      <center>
                                        <?=str_replace(',', '.', number_format($valUangBBM, 0))?>
                                      </center>
                                      <input type="hidden" id="inputMediaUangBBM" value="<?=$key->MEDIA_UANG_BBM?>">
                                    </td>
                                    <td>
                                      <?=str_replace(',', '.', number_format($valUangBBM-$kasbonBBM, 0))?>
                                      
                                    </td>
                                  <?php endif ?>
                                  <td><?=$rl->TGL_BBM == null ? '' :date("d-m-Y", strtotime($rl->TGL_BBM))?></td>
                                  <td><?=$rl->PIC_BBM?></td>
                                  <td><?=$rl->PIC_BBM == null ? 'OPEN':'CLOSE'?></td>
                                  <td><?='Uang BBM Menggunakan Media '.$rl->MEDIA_UANG_BBM?></td>
                                </tr>
                                <tr>
                                  <td>Uang Tol</td>
                                  <td><?=$rl->MEDIA_UANG_TOL == 'Kasbon'?str_replace(',', '.', number_format($rl->TOTAL_UANG_TOL, 0)):'0'?></td>
                                  <td><?=$rl->MEDIA_UANG_TOL?></td>
                                  <td>
                                    <center>
                                      <?=str_replace(',', '.', number_format($rl->TOTAL_UANG_TOL))?>
                                    </center>
                                  </td>
                                  <td>
                                    <?=str_replace(',', '.', number_format($rl->TOTAL_UANG_TOL - $kasbonTOL))?>
                                    <input type="hidden" id="inputKbTOL" class="form-control form-control-sm" style="width: 120px" readonly>
                                  </td>
                                  <td><?=$rl->TGL_CLOSE == null ? '' :date("d-m-Y", strtotime($rl->TGL_CLOSE))?></td>
                                  <td><?=$rl->PIC_CLOSE?></td>
                                  <td><?=$rl->PIC_CLOSE == null ? 'OPEN':'CLOSE'?></td>
                                  <td><?='Uang TOL Menggunakan Media '.$rl->MEDIA_UANG_TOL?></td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>TOTAL:</th>
                                <th>Rp. <?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU+$key->TOTAL_UANG_MAKAN+$key->TOTAL_UANG_JALAN+$kasbonBBM+$kasbonTOL, 0))?></th>
                                <th></th>
                                <th>Rp. 
                                  <?php
                                    $totalRealisasi = $realisasiUangSaku + $realisasiUangMakan + $realisasiUangJalan + $valUangBBM + $realisasiTOL;
                                    echo str_replace(',', '.', number_format($totalRealisasi));
                                  ?>
                                    
                                </th>
                                <th>Rp. 
                                  <?php
                                    $totalKB = ($realisasiUangSaku - $kasbonUangSaku) + ($realisasiUangMakan - $kasbonUangMakan) + ($realisasiUangJalan - $kasbonUangJalan)+($valUangBBM-$kasbonBBM)+($realisasiTOL-$kasbonTOL);
                                    echo str_replace(',', '.', number_format($totalKB));
                                  ?>
                                </th>
                                <th colspan="4"></th>
                              </tr>
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
                              <?php 
                              $kmOut = 0 ;
                              $kmIn = 0;
                              foreach ($validasi as $vld): 
                                $kmOut = $vld->KM_OUT;
                                $kmIn = $vld->KM_IN;
                              ?>
                                <tr>
                                  <td class="text-left">Keberangkatan</td>
                                  <td><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
                                  <td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
                                  <td><?=date("d F Y", strtotime($vld->KEBERANGKATAN))?></td>
                                  <td><?=date("H:i", strtotime($vld->KEBERANGKATAN))?></td>
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
                                  <td><?=str_replace(',', '.', number_format($vld->KM_OUT, 0))?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Kepulangan</td>
                                  <td><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
                                  <td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
                                  <td><?=date("d F Y", strtotime($vld->KEPULANGAN))?></td>
                                  <td><?=date("H:i", strtotime($vld->KEPULANGAN))?></td>
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
                                  <td><?=str_replace(',', '.', number_format($vld->KM_IN, 0))?></td>
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
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
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
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getQrCode();
    $('.getFotoWajah').on('click', function(){
      var foto = $(this).attr("foto");
      var ngambilFoto = url+'/assets/image/foto-wajah/'+foto;
      $('#getFoto').html('<img src="'+ngambilFoto+'" class="rounded mx-auto d-block" width="75%">');
      $('#modal-foto').modal("show");
    });
  })

  function getQrCode() {
    var id = '<?=$this->uri->segment("3")?>';
    $.ajax({
      type: 'get',
      data:{id},
      url: '/spj/Monitoring/getQrCode',
      cache: false,
      async: true,
      success: function(data){
        $('#getQrCode').html(data);
      },
      error: function(data){
        Swal.fire("Tidak Bisa Meng-Generate Qr Code","Refresh Halaman Ini Atau Hubungi Staff IT", "error");
      }
    })
  }


</script>
<!-- FootJS -->
</body>
</html>

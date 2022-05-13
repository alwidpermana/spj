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
                              endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="8" class="text-right">Status</th>
                                <th>CLOSE</th>
                                <th>CLOSE</th>
                                <th><?=$statusUS1?></th>
                                <th><?=$statusUS2?></th>
                                <th><?=$statusMakan?></th>
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
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">5. Biaya</div>
                  </div>
                  <div class="card-body">
                    <?php
                      foreach ($validasi as $vld) {
                        $realisasiUangBBM = $vld->REALISASI_UANG_BBM == null ? round($key->TOTAL_UANG_BBM) : round($vld->REALISASI_UANG_BBM);
                        $realisasiUangTOL = $vld->REALISASI_UANG_TOL == null ? round($key->TOTAL_UANG_TOL) : round($vld->REALISASI_UANG_TOL);

                      }
                    ?>
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
                              <?php
                                $realisasiUangSaku = $key->TOTAL_UANG_SAKU + $totalUangSaku1 + $totalUangSaku2;
                                $realisasiUangMakan = $key->TOTAL_UANG_MAKAN + $totalUangMakan;
                                $kbUS = $realisasiUangSaku - $key->TOTAL_UANG_SAKU;
                                $kbMakan = $realisasiUangMakan - $key->TOTAL_UANG_MAKAN;
                                $kbJalan = $key->TOTAL_UANG_JALAN - $key->TOTAL_UANG_JALAN;
                              ?>
                              <tr>
                                <td class="text-left">Uang Saku</td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
                                <td><?=$key->MEDIA_UANG_SAKU?></td>
                                <td><?=str_replace(',', '.', number_format($realisasiUangSaku, 0))?></td>
                                <td><?=str_replace(',', '.', number_format($kbUS, 0))?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang Makan</td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
                                <td><?=$key->MEDIA_UANG_MAKAN?></td>
                                <td><?=str_replace(',', '.', number_format($realisasiUangMakan, 0))?></td>
                                <td><?=str_replace(',', '.', number_format($kbMakan, 0))?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang Jalan</td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
                                <td><?=$key->MEDIA_UANG_JALAN?></td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
                                <td><?=str_replace(',', '.', number_format($kbJalan, 0))?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang BBM</td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
                                <td><?=$key->MEDIA_UANG_BBM?></td>
                                <td>
                                  <input type="hidden" id="totalUangTambahan" value="<?=$realisasiUangSaku+$realisasiUangMakan+$key->TOTAL_UANG_JALAN?>">
                                  <input type="hidden" id="totalKBTambahan" value="<?=$kbUS+$kbMakan+$kbJalan?>">
                                  <center>
                                    <input type="number" id="inputTambahanUangBBM" class="form-control form-control-sm" style="width: 120px" value="<?=$realisasiUangBBM?>" awal="<?=$key->TOTAL_UANG_BBM?>">
                                  </center>
                                </td>
                                <td>
                                  <span id="kbBBm"></span>
                                  <input type="hidden" id="inputKbBBM" class="form-control form-control-sm" style="width: 120px" readonly>    
                                </td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang TOL</td>
                                <td><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
                                <td><?=$key->MEDIA_UANG_TOL?></td>
                                <td>
                                  <center>
                                    <input type="number" id="inputTambahanUangTOL" class="form-control form-control-sm" style="width: 120px" value="<?=$realisasiUangTOL?>" awal="<?=$key->TOTAL_UANG_TOL?>">
                                  </center>
                                </td>
                                <td>
                                  <span id="kbTOL"></span>
                                  <input type="hidden" id="inputKbTOL" class="form-control form-control-sm" style="width: 120px" readonly>    
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>TOTAL:</th>
                                <th>Rp. <?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU+$key->TOTAL_UANG_MAKAN+$key->TOTAL_UANG_JALAN+$key->TOTAL_UANG_BBM+$key->TOTAL_UANG_TOL, 0))?></th>
                                <th></th>
                                <th><span id="totalRealisasi"></span></th>
                                <th><span id="totalKB"></span></th>
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
                      <div class="col-md-4">
                        <div class="table-responsive">
                          <table class="table table-hover table-valign-middle text-center">
                            <thead>
                              <tr>
                                <th rowspan="2"></th>
                                <th colspan="2">Rencana</th>
                              </tr>
                              <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="text-left">Keberangkatan</td>
                                <td><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
                                <td><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Kepulangan</td>
                                <td><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
                                <td><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
                              </tr>
                            </tbody>
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
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('#inputTambahanUangBBM').on('keyup', function(){
      hitungKBBBm();
      totalBiaya();
    });
    $('#inputTambahanUangTOL').on('keyup', function(){
      hitungKBTOL();
      totalBiaya();
    });
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   

  })
  function hitungKBBBm() {
    var tambahan = $('#inputTambahanUangBBM').val();
    var awal = $('#inputTambahanUangBBM').attr("awal");
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbBBM').val(kb);
    $('#kbBBm').html(formatRupiah(Number(kb).toFixed(0), ''));
    console.log(kb)
  }
  function hitungKBTOL() {
    var tambahan = $('#inputTambahanUangTOL').val();
    var awal = $('#inputTambahanUangTOL').attr("awal");
    var kb = parseInt(tambahan) - parseInt(awal)
    $('#inputKbTOL').val(kb);
    $('#kbTOL').html(formatRupiah(Number(kb).toFixed(0), ''));
  }

  function totalBiaya() {
    var totalUangTambahan = $('#totalUangTambahan').val();
    var totalKBTambahan = $('#totalKBTambahan').val();
    var tambahanBBM = $('#inputTambahanUangBBM').val();
    var tambahanTOL = $('#inputTambahanUangTOL').val();
    var inputKbBBM = $('#inputKbBBM').val();
    var inputKbTOL = $('#inputKbTOL').val();
    var totalRealisasi = parseInt(totalUangTambahan) + parseInt(tambahanBBM) + parseInt(tambahanTOL)
    var totalKB = parseInt(totalKBTambahan) + parseInt(inputKbBBM) + parseInt(inputKbTOL);
    
    $('#totalRealisasi').html(formatRupiah(Number(totalRealisasi).toFixed(0), 'Rp. '))
    $('#totalKB').html(formatRupiah(Number(totalKB).toFixed(0), 'Rp. '))
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

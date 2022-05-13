<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
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
                              <div class="col-md-11">
                                <label class="labJudul">Tanggal Input</label>    
                              </div>
                              <div class="col-md-1">
                                :
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-12">
                                <label><?=date("d F Y", strtotime($key->TGL_INPUT))?></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-11">
                                <label class="labJudul">Jenis SPJ</label>    
                              </div>
                              <div class="col-md-1">
                                :
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-12" id="afterNext">
                                <label><?=$key->NAMA_JENIS?></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-11">
                                <label class="labJudul">No SPJ</label>    
                              </div>
                              <div class="col-md-1">
                                :
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-12">
                                <label><?=$key->NO_SPJ?></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-11">
                                <label class="labJudul">Tanggal SPJ</label>    
                              </div>
                              <div class="col-md-1">
                                :
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-md-12">
                                <label><?=date("d F Y", strtotime($key->TGL_SPJ))?></label>
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
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-2">
                        <label><?=$key->PIC_INPUT?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Nama</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label><?=$key->namapeg?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Jabatan</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label><?=$key->jabatan?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Departemen</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label><?=$key->departemen?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Sub Departemen</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label><?=$key->Subdepartemen?></label>
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
                          <div class="col-md-11"> 
                            <label>Kendaraan</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->KENDARAAN?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Jenis Kendaraan</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->JENIS_KENDARAAN?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>No Inventaris</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->NO_INVENTARIS?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Merk</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->MERK?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>Type</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->TYPE?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-11"> 
                            <label>No TNKB</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <label><?=$key->NO_TNKB?></label>
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
                          <div class="col-md-11"> 
                            <label>Tujuan</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="col-md-12">
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
                          <div class="col-md-11"> 
                            <label>Lokasi</label>  
                          </div>
                          <div class="col-md-1">
                            <label>:</label>
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
                                <th></th>
                                <th>Subjek</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Jabatan</th>
                                <th>Tujuan</th>
                                <th>Uang Saku</th>
                                <th>Uang Makan</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Driver</td>
                                <td><?=$key->OBJEK?></td>
                                <td><?=$key->NIK_DRIVER?></td>
                                <td><?=$key->NAMA_DRIVER?></td>
                                <td><?=$key->DEPARTEMEN_DRIVER?></td>
                                <td><?=$key->SUB_DEPARTEMEN_DRIVER?></td>
                                <td><?=$key->JABATAN_DRIVER?></td>
                                <td>Reguler</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_SAKU, 0))?></td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_MAKAN, 0))?></td>
                              </tr>
                              <?php foreach ($pic as $pc): ?>
                                <tr>
                                  <td>Pendamping</td>
                                  <td><?=$pc->OBJEK?></td>
                                  <td><?=$pc->NIK_DRIVER?></td>
                                  <td><?=$pc->NAMA_DRIVER?></td>
                                  <td><?=$pc->DEPARTEMEN_DRIVER?></td>
                                  <td><?=$pc->SUB_DEPARTEMEN_DRIVER?></td>
                                  <td><?=$pc->JABATAN_DRIVER?></td>
                                  <td><?=$pc->SORTIR == 'Y'?'Sortir':'Reguler'?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU, 0))?></td>
                                  <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?></td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="8" class="text-right">Total</th>
                                <th>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></th>
                                <th>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></th>
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
                    <div class="card-title">5. Biaya</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="table-responsive">
                          <table class="table table-hover table-valign-middle text-center">
                            <thead>
                              <tr>
                                <th rowspan="2"></th>
                                <th colspan="2">Kasbon</th>
                              </tr>
                              <tr>
                                <th>Rp.</th>
                                <th>Media</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class="text-left">Uang Saku</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
                                <td><?=$key->MEDIA_UANG_SAKU?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang Makan</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
                                <td><?=$key->MEDIA_UANG_MAKAN?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang Jalan</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></td>
                                <td><?=$key->MEDIA_UANG_JALAN?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang BBM</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></td>
                                <td><?=$key->MEDIA_UANG_BBM?></td>
                              </tr>
                              <tr>
                                <td class="text-left">Uang TOL</td>
                                <td>Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></td>
                                <td><?=$key->MEDIA_UANG_TOL?></td>
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
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getQrCode();
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

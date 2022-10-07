<?php
  date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .labJudul{
      padding-top: 7px;
    }
    .form-control{
      font-size: 12px !important;
    }
    .tengah{
      position: fixed;
      height: 350px;
      width: 500px;
      margin:auto;
      left:0;
      right:0;
      top:0;
      bottom:0;
    }
    .cardGalery{
      background: #FFFFFF;
      box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.15);
      border-radius: 20px;
      margin: 10px;
    }
    .btnTambahMini{
      width: 15px;
      font-size: 11px;
      height:  15px;
    }
    .label-container{
      position:fixed;
      bottom:90px;
      right:105px;
      display:table;
      visibility: hidden;
      z-index: 9999;
    }

    .label-text{
      color:#FFF;
      background:rgba(51,51,51,0.5);
      display:table-cell;
      vertical-align:middle;
      padding:10px;
      border-radius:3px;
    }

    .label-arrow{
      display:table-cell;
      vertical-align:middle;
      color:#333;
      opacity:0.5;
    }

    .float{
      position:fixed;
      width:60px;
      height:60px;
      bottom:80px;
      right:40px;
      background-color:rgb(178, 58, 72);
      color:#FFF;
      border-radius:50px;
      text-align:center;
      box-shadow: 2px 2px 3px #999;
      z-index: 9999;
    }

    .my-float{
      font-size:24px;
      margin-top:18px;
      color: #fff;
    }
    a.float + div.label-container {
      visibility: hidden;
      opacity: 0;
      transition: visibility 0s, opacity 0.5s ease;

    }

    a.float:hover + div.label-container{
      visibility: visible;
      opacity: 1;

    }
    .bs-stepper-circle{
      font-size: 13px;
    }
    .bs-stepper-label{
      font-size: 13px;
    }
    .step-trigger{
      color: white !important;
    }
    .bs-stepper-circle{
      color: white !important;
      background-color: rgb(204, 88, 3) !important;
    }
    .bs-stepper-label{
      color:  black !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed">
<div class="preloader">
  <div class="loader">
      <div class="spinner"></div>
      <div class="spinner-2"></div>
  </div>
</div>
<div class="preloader-no-bg">
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
          
          <div class="label-container">
          <div class="label-text">Save SPJ</div>
          <i class="fa fa-play label-arrow"></i>
          </div>
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
                          <input type="text" id="inputTglInput" class="form-control form-control-sm" value="<?=date("d F Y")?>" readonly>
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
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-12" id="beforeNext">
                          <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisSPJ">
                            <option value="">Pilih SPJ</option>
                            <?php foreach ($spj as $spj): ?>
                              <option value="<?=$spj->ID_JENIS?>"><?=$spj->NAMA_JENIS?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="col-md-12" id="afterNext">
                          <input type="text" id="inputJenisSPJ" class="form-control" readonly="">
                        </div>
                      </div>
                      <br>
                      <div class="row otherTujuan d-none">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Tujuan</label>
                            <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisOther">
                              <option value="Bengkel">Bengkel</option>
                              <option value="Pengurusan Pajak Kendaraan">Pengurusan Pajak Kendaraan</option>
                              <option value="KIR/BOM">KIR/BOM</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12 text-right">
                          <div class="form-group clearfix">
                            <div class="icheck-orange d-inline">
                              <input type="checkbox" id="inputAbnormal" name="inputAbnormal" disabled>
                              <label for="inputAbnormal"> Abnormal?
                              </label>
                            </div>
                          </div>
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
                          <input type="text" id="inputNoSPJ" class="form-control form-control-sm" value="" readonly>
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
                          <input type="date" id="inputTglSPJ" class="form-control form-control-sm" value="<?=date("Y-m-d")?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <div class="row" id="getNext">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                          <button type="button" class="btn bg-orange btn-kps btn-sm btn-block ladda-button btnNext" id="btnNext" data-style="zoom-in">NEXT &nbsp;<i class="fas fa-arrow-up-right-from-square"></i></button> 
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="getQrCode"></div>
                </div>
                <div class="col-md-2">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getSaldo"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="isiPengajuan" class="d-none">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <!-- STEPPER -->
                    <div class="bs-stepper table-responsive">
                      <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#stepPengaju">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepPengaju" id="stepPengaju-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-user"></i></span>
                            <span class="bs-stepper-label">Pengaju</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepKendaraan">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepKendaraan" id="stepKendaraan-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-car"></i></span>
                            <span class="bs-stepper-label">Kendaraan</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepTujuan">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepTujuan" id="stepTujuan-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-map-location-dot"></i></span>
                            <span class="bs-stepper-label">Tujuan</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepPIC">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepPIC" id="stepPIC-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-users"></i></span>
                            <span class="bs-stepper-label">PIC</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepBiaya">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepBiaya" id="stepBiaya-trigger">
                            <span class="bs-stepper-circle">Rp</span>
                            <span class="bs-stepper-label">Biaya</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepRencana">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepRencana" id="stepRencana-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-clock"></i></span>
                            <span class="bs-stepper-label">Rencana</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#stepSave">
                          <button type="button" class="step-trigger" role="tab" aria-controls="stepSave" id="stepSave-trigger">
                            <span class="bs-stepper-circle"><i class="fas fa-file"></i></span>
                            <span class="bs-stepper-label">Save Data</span>
                          </button>
                        </div>
                      </div>
                      <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="stepPengaju" class="content" role="tabpanel" aria-labelledby="stepPengaju-trigger">
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="row">
                                <div class="col-sm-12"> 
                                  <label>NIK</label>  
                                </div>
                              </div>
                              
                            </div>
                            <div class="col-sm-4">
                              <label>: <?=$this->session->userdata("NIK")?></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="row">
                                <div class="col-sm-12"> 
                                  <label>Nama</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label>: <?=$this->session->userdata("NAMA")?></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="row">
                                <div class="col-sm-12"> 
                                  <label>Jabatan</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label>: <?=$this->session->userdata("JABATAN")?></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="row">
                                <div class="col-sm-12"> 
                                  <label>Departemen</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label>: <?=$this->session->userdata("DEPARTEMEN")?></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-2">
                              <div class="row">
                                <div class="col-sm-12"> 
                                  <label>Sub Departemen</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <label>: <?=$this->session->userdata("SUB_DEPARTEMEN")?></label>
                            </div>
                          </div>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-sm-4">
                              <button class="btn btn-secondary btnStepNext" onclick="stepper.next()">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepKendaraan" class="content" role="tabpanel" aria-labelledby="stepKendaraan-trigger">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Kendaraan</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKendaraan">
                                    <?php foreach ($kendaraan as $ken): ?>
                                      <option value="<?=$ken->Jenis?>"><?=$ken->Jenis?></option>
                                    <?php endforeach ?>
                                    <option value="Rental">Rental</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row rekanan d-none">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <label>Rekanan</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputRekanan">
                                
                              </select>
                            </div>
                          </div>
                          <br>
                          <div class="row rekanan d-none">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <label>Kendaraan</label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKendaraanRekanan"></select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Jenis Kendaraan</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisKendaraan">
                                      <option value="">-</option>
                                    <?php foreach ($jenis as $jen): ?>
                                      <option value="<?=$jen->JENIS_KENDARAAN?>"><?=$jen->JENIS_KENDARAAN?></option>
                                    <?php endforeach ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-4">
                              <center>
                                <button type="button" id="pilihKendaraan" class="btn bg-orange btn-kps btn-sm">
                                  <i class="fas fa-car-side"></i>&nbsp;
                                  Pilih Kendaraan
                                </button>
                              </center>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>No Inventaris</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="text" id="inputNoInventaris" class="form-control form-control-sm" readonly>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>No TNKB</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="text" id="inputNoTNKB" class="form-control form-control-sm inputan">
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Merk</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="text" id="inputMerk" class="form-control form-control-sm inputan">
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Type</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="text" id="inputType" class="form-control form-control-sm inputan">
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row rekanan d-none">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Rekanan</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="text" id="inputRekananKendaraan" class="form-control form-control-sm inputan" value="" readonly>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row" style="padding-top: 25px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                              <button class="btn btn-secondary btnStepNext" id="btnNextKendaraan">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepTujuan" class="content" role="tabpanel" aria-labelledby="stepTujuan-trigger">
                          <input type="hidden" id="inputGroupTujuan">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Tujuan</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="select2-orange">
                                    <select class="select2" id="inputKota" multiple="multiple" data-placeholder="Pilih Kota/Kabupaten" data-dropdown-css-class="select2-orange" style="width: 100%;color: white !important;">
                                      <?php foreach ($kota as $kot): ?>
                                        <option><?=$kot->NAMA_KOTA?></option>
                                      <?php endforeach ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-2">
                              <div class="row">
                                <div class="col-md-12"> 
                                  <label>Lokasi</label>  
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row"> 
                                <div class="col-md-12">
                                  <div id="getLokasi"></div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <button type="button" class="btn btn-xs btn-kps bg-orange" data-toggle="modal" data-target="#modal-lokasi" id="tambahLokasi">
                                    <i class="fas fa-plus"></i>
                                  </button>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                              <br>
                              <button type="button" class="btn btn-kps bg-orange btn-block" id="btnCekProgramSerlok">
                                Cek Data Program Serlok
                              </button>
                            </div>
                          </div>
                          <br>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                              <button class="btn btn-secondary" id="btnNextTujuan">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepPIC" class="content" role="tabpanel" aria-labelledby="stepPIC-trigger">
                          <div class="row">
                            <div class="col-md-2">
                              <button type="button" class="btn bg-orange btn-kps btn-sm" id="btnTambahPIC">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah PIC
                              </button>
                              <input type="hidden" id="setJumlahPIC">
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-hover table-valign-middle table-striped">
                                <thead class="text-center">
                                  <tr>
                                    <td></td>
                                    <td>Subjek</td>
                                    <td>NIK</td>
                                    <td>Nama</td>
                                    <td>Departemen</td>
                                    <td>Sub Departemen</td>
                                    <td>Jabatan</td>
                                    <td>Uang Saku</td>
                                    <td>Uang Makan</td>
                                    <td></td>
                                  </tr>
                                </thead>
                                <tbody id="getPIC" class="text-center">
                                  
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                              <button class="btn btn-secondary btnStepNext" id="btnNextPIC">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepBiaya" class="content" role="tabpanel" aria-labelledby="stepBiaya-trigger">
                          <div class="row">
                            <div class="col-md-7">
                              <input type="hidden" id="inputTotalUangMakan">
                              <input type="hidden" id="inputTotalUangSaku">
                              <input type="hidden" id="inputTotalUangJalan">
                              <table class="table table-hover table-valign-middle" width="100%">
                                <thead>
                                  <tr>
                                    <td width="30%"></td>
                                    <td class="text-center" width="40%">Jumlah Rp.</td>
                                    <td class="text-center" width="30%">Media</td>
                                  </tr>
                                </thead>
                                <tbody class="text-center">
                                  <tr>
                                    <td>Uang Saku</td>
                                    <td><span id="tampilTotalUangSaku"></span></td>
                                    <td>
                                      <!-- <input type="text" id="inputMediaUangSaku" class="form-control form-control-sm" value="Kasbon"> -->
                                      <select class="select2 form-control select2-orange" id="inputMediaUangSaku" data-dropdown-css-class="select2-orange">
                                        <option value="Kasbon" selected>Kasbon</option>
                                        <option value="Voucher" disabled="disabled">Voucher</option>
                                        <option value="Reimburse" disabled="disabled">Reimburse</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Uang Makan</td>
                                    <td><span id="tampilTotalUangMakan"></span></td>
                                    <td>
                                      <!-- <input type="text" id="inputMediaUangMakan" class="form-control form-control-sm" value="Kasbon"> -->
                                      <select class="select2 form-control select2-orange" id="inputMediaUangMakan" data-dropdown-css-class="select2-orange">
                                        <option value="Kasbon" selected>Kasbon</option>
                                        <option value="Voucher" disabled="disabled">Voucher</option>
                                        <option value="Reimburse" disabled="disabled">Reimburse</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Uang Jalan</td>
                                    <td>
                                      <span id="tampilTotalUangJalan"></span>
                                      <div id="manualUangJalan">
                                        <input type="number" id="inputManualUangJalan" class="form-control form-control-sm">
                                      </div>
                                    </td>
                                    <td>
                                      <!-- <input type="text" id="inputMediaUangJalan" class="form-control form-control-sm" value="Kasbon"> -->
                                      <select class="select2 form-control select2-orange" id="inputMediaUangJalan" data-dropdown-css-class="select2-orange">
                                        <option value="Kasbon" selected>Kasbon</option>
                                        <option value="Voucher" disabled="disabled">Voucher</option>
                                        <option value="Reimburse" disabled="disabled">Reimburse</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      BBM
                                      <br>
                                      <span class="text-right text-kps" style="font-size: 9px">*Boleh Tidak Diisi</span>
                                    </td>
                                    <td>
                                      <!-- <div id="voucherBBM">
                                        <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputBBMVoucher" style="width: 100%">
                                          <option value="">Pilih Voucher</option>
                                        </select>
                                        <input type="hidden" id="inputIdVoucher">
                                        <input type="hidden" id="inputBBMOtomatis">
                                      </div>
                                      <div id="manualBBM">
                                        <div class="form-group">
                                          <label>&nbsp;</label>
                                          <span class="form-control-icon">Rp</span>
                                          <input type="number" class="form-control form-control-search" id="inputBBMManual">
                                        </div>
                                      </div>
                                      <br>
                                      <div class="custom-control custom-checkbox text-right">
                                        <input class="custom-control-input custom-control-input-danger" type="checkbox" id="cekVoucher">
                                        <label for="cekVoucher" class="custom-control-label">Tanpa Voucher?</label>
                                      </div> -->
                                      <div id="voucherBBM">
                                        <input type="text" id="inputNoVoucher" class="form-control form-control-sm" readonly>
                                      </div>
                                      <div id="manualBBM">
                                        <div class="form-group">
                                          <label>&nbsp;</label>
                                          <span class="form-control-icon">Rp</span>
                                          <input type="number" class="form-control form-control-search" id="inputBBMManual">
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <!-- <input type="text" id="inputMediaBBM" class="form-control form-control-sm" value="Reimburse"> -->
                                      <select class="select2 form-control select2-orange" id="inputMediaBBM" data-dropdown-css-class="select2-orange">
                                        <option value="Kasbon">Kasbon</option>
                                        <option value="Voucher" selected>Voucher</option>
                                        <option value="Reimburse">Reimburse</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      Tol
                                      <br>
                                      <span class="text-right text-kps" style="font-size: 9px">*Boleh Tidak Diisi</span>
                                    </td>
                                    <td>
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <span class="form-control-icon">Rp</span>
                                        <input type="number" class="form-control form-control-search" id="inputTOL" readonly>
                                      </div>
                                    </td>
                                    <td>
                                      <!-- <input type="text" id="inputMediaTol" class="form-control form-control-sm" value="Reimburse"> -->
                                      <select class="select2 form-control select2-orange" id="inputMediaTol" data-dropdown-css-class="select2-orange">
                                        <option value="Kasbon">Kasbon</option>
                                        <option value="Voucher" disabled>Voucher</option>
                                        <option value="Reimburse" selected>Reimburse</option>
                                      </select>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                              <button class="btn btn-secondary btnStepNext nextBiaya">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepRencana" class="content" role="tabpanel" aria-labelledby="stepRencana-trigger">
                          <div class="row">
                            <div class="col-md-4">
                              <table class="table table-hover table-valign-middle text-center">
                                <thead class="font-weight-bold">
                                  <tr>
                                    <td rowspan="2"></td>
                                    <td colspan="2">Rencana</td>
                                  </tr>
                                  <tr>
                                    <td>Tanggal</td>
                                    <td>Jam</td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="font-weight-bold">Keberangkatan</td>
                                    <td><input type="date" id="inputTglBerangkat" class="form-control saveRencana"></td>
                                    <td><input type="time" id="inputJamBerangkat" class="form-control saveRencana" value="<?=date('H:i')?>"></td>
                                  </tr>
                                  <tr>
                                    <td class="font-weight-bold">Kepulangan</td>
                                    <td><input type="date" id="inputTglPulang" class="form-control saveRencana"></td>
                                    <td><input type="time" id="inputJamPulang" class="form-control saveRencana" value="<?=date('H:i')?>"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                              <button class="btn btn-secondary" id="btnNextRencana">Next</button> 
                            </div>
                          </div>
                        </div>
                        <div id="stepSave" class="content" role="tabpanel" aria-labelledby="stepSave-trigger">
                          <center>
                            <div class="row">
                              <div class="col-md-12">
                                <h2 class="text-orange">Perhatikan!</h2>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8" style="font-size: 16px">
                                <p>Sebelum Menyimpan Data, Pastikan Data Sudah Terisi Dengan Benar. Segera hubungi Staff IT Jika Ada Kejanggalan Pada Biaya Uang Saku, Uang Makan, Uang Jalan, atau Data Lainnya.</p>
                              </div>
                            </div>
                          </center>
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="d-flex justify-content-center">
                                <button type="button" id="btnSaveSPJ" class="btn bg-orange btn-kps" status="NEW">Save Data</button>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="row" style="padding-top: 50px">
                            <div class="col-md-4">
                              <button class="btn btn-secondary btnStepPrevios">Previous</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- STEPPER -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <span class="fa fa-search form-control-icon"></span>
                  <input type="search" class="form-control form-control-search" id="searchKendaraan" placeholder="Cari Berdasarkan No SPJ">
                </div>
              </div>
            </div>
            <br>
            <br>
            <div id="getKendaraan"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-lokasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Objek</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputObjek">
                    <option value="Customer" selected>Customer</option>
                    <option value="Supplier">Supplier</option>
                    <option value="Rekanan">Rekanan</option>
                    <option value="Lainnya">Lainnya...</option>
                  </select>
                  <br>
                </div>
              </div>
            </div>
            <div class="objekLainnya d-none">
              <div class="row">
                <div class="col-md-12">
                  <input type="text" id="inputObjekLainnya" class="form-control" placeholder="Isi Objek Lainnya" readonly>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Kota/Kabupaten</label>
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKotaKabupaten" style="width:100%">
                      
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Nama Tempat</label>
                    <input type="text" id="inputNamaTempat" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" id="inputAlamat" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="objekNormal">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Perusahaan</label>
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputPerusahaan">
                      
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Group Tujuan</label>
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputGroupPerusahaan">
                      <option value="">Pilih Group</option>
                      <?php foreach ($group as $gr): ?>
                        <option value="<?=$gr->ID_GROUP?>"><?=$gr->NAMA_GROUP?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div> 
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveLokasi ladda-button" data-style="expand-right">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Jenis PIC</label>
                          <select class="select2 form-control select2-orange pilihPIC" data-dropdown-css-class="select2-orange" id="inputJenisPIC">
                            <option value="">Pilih Sebagai</option>
                            <option value="Sopir">Driver</option>
                            <option value="Pendamping">Pendamping</option>
                            <option value="Office">Office</option>
                            <option value="Manajemen">Manajemen</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Subjek</label>
                          <select class="select2 form-control select2-orange pilihPIC" data-dropdown-css-class="select2-orange" id="inputSubjek">
                            <option value="">Pilih Subjek</option>
                            <option value="Internal">Internal</option>
                            <option value="Rental">Rental</option>
                          </select>
                        </div>
                      </div>
                    </div> 
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>PIC</label>
                          <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputPIC">
                            <option value="">Pilih Jenis PIC dan Subjek Terlebih Dahulu!</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input custom-control-input-orange" type="checkbox" id="inputSortir">
                            <label for="inputSortir" class="custom-control-label">Sortir?</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="setNamaPIC">
                <input type="hidden" id="setDivisiPIC">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Departemen</label>
                          <input type="text" id="setDepartemenPIC" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Sub Departemen</label>
                          <input type="text" id="setSubDepartemenPIC" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Jabatan</label>
                          <input type="text" id="setJabatanPIC" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Uang Saku</label>
                          <input type="hidden" id="inputUangSaku" class="form-control" readonly>
                          <input type="text" id="showUangSaku" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Uang Makan</label>
                          <input type="hidden" id="inputUangMakan" class="form-control" readonly>
                          <input type="text" id="showUangMakan" class="form-control" readonly>
                        </div>
                      </div>
                    </div>    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps savePIC ladda-button" data-style="expand-right">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-serlok" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header border-0">
            <div class="modal-title">
              <label>Program SPJ Menemukan Data Outgoing dari Program Serlok. Kendaraan Dengan No TNKB <span id="titleTNKB"></span> Berangkat Ke Customer Berikut:</label>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 table-responsive p-0">
                <table class="table table-hover table-valign-middle table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Company Name</th>
                      <th>Plant City</th>
                    </tr>
                  </thead>
                  <tbody id="getSerlok">
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveCustomerSerlok ladda-button" data-style="expand-right">Tambah Tujuan</button>
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
<script src="<?= base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?= base_url()?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<?php $this->load->view("pengajuan/form/js");?>
<!-- FootJS -->
</body>
</html>

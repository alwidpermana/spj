<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
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
          <a href="javascript:;" class="float d-none" id="btnSaveSPJ">
          <i class="fa fa-save my-float"></i>
          </a>
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
                        <div class="col-md-1">
                          :
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row">
                        <div class="col-md-12" id="beforeNext">
                          <select class="select2 form-control" id="inputJenisSPJ">
                            <option value="">Pilih SPJ</option>
                            <?php foreach ($spj as $spj): ?>
                              <option value="<?=$spj->ID_JENIS?>"><?=$spj->NAMA_JENIS?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="col-md-11" id="afterNext">
                          <input type="text" id="inputJenisSPJ" class="form-control" readonly="">
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
                          <input type="text" id="inputNoSPJ" class="form-control form-control-sm" value="" readonly>
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
                          <input type="date" id="inputTglSPJ" class="form-control form-control-sm">
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
                          <button type="button" class="btn btn-danger btn-kps btn-sm btn-block ladda-button btnNext" id="btnNext" data-style="zoom-in">NEXT &nbsp;<i class="fas fa-arrow-up-right-from-square"></i></button> 
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
          <div id="isiPengajuan" class="d-none">
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
                    <label><?=$this->session->userdata("NIK")?></label>
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
                    <label><?=$this->session->userdata("NAMA")?></label>
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
                    <label><?=$this->session->userdata("JABATAN")?></label>
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
                    <label><?=$this->session->userdata("DEPARTEMEN")?></label>
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
                    <label><?=$this->session->userdata("SUB_DEPARTEMEN")?></label>
                  </div>
                </div>
              </div>
            </div>
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
                        <select class="select2 form-control" id="inputKendaraan">
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
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col-md-12">
                        <select class="select2 form-control" id="inputJenisKendaraan">
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
                      <button type="button" id="pilihKendaraan" class="btn btn-danger btn-kps btn-sm">
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
                      <div class="col-md-11"> 
                        <label>No Inventaris</label>  
                      </div>
                      <div class="col-md-1">
                        <label>:</label>
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
                      <div class="col-md-11"> 
                        <label>Merk</label>  
                      </div>
                      <div class="col-md-1">
                        <label>:</label>
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
                      <div class="col-md-11"> 
                        <label>Type</label>  
                      </div>
                      <div class="col-md-1">
                        <label>:</label>
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
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col-md-12">
                        <input type="text" id="inputNoTNKB" class="form-control form-control-sm inputan">
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <div class="card-title">3. TUJUAN</div>
              </div>
              <div class="card-body">
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col-md-11"> 
                        <label>Group Tujuan</label>  
                      </div>
                      <div class="col-md-1">
                        <label>:</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row">
                      <div class="col-md-12">
                        <select class="select2 form-control" id="inputGroupTujuan" style="height: 10px">
                          <option value="">Pilih Group Tujuan</option>
                          <?php foreach ($group as $group): ?>
                            <option value="<?=$group->ID_GROUP?>"><?=$group->NAMA_GROUP?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
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
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-12">
                        <span id="viewTujuan"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
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
                  <div class="col-md-6">
                    <div class="row"> 
                      <div class="col-md-12">
                        <div id="getLokasi"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="btn btn-xs btn-kps btn-danger" data-toggle="modal" data-target="#modal-lokasi">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <div class="card-title">
                  4. PIC
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-kps btn-sm" id="btnTambahPIC">
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
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <div class="card-title">
                  5. Biaya
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-5">
                    <input type="hidden" id="inputTotalUangMakan">
                    <input type="hidden" id="inputTotalUangSaku">
                    <input type="hidden" id="inputTotalUangJalan">
                    <table class="table table-hover table-valign-middle">
                      <thead>
                        <tr>
                          <td></td>
                          <td class="text-center">Jumlah Rp.</td>
                          <td class="text-center">Media</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Uang Saku</td>
                          <td><span id="tampilTotalUangSaku"></span></td>
                          <td>
                            <input type="text" id="inputMediaUangSaku" class="form-control form-control-sm" value="Kasbon">
                          </td>
                        </tr>
                        <tr>
                          <td>Uang Makan</td>
                          <td><span id="tampilTotalUangMakan"></span></td>
                          <td>
                            <input type="text" id="inputMediaUangMakan" class="form-control form-control-sm" value="Kasbon">
                          </td>
                        </tr>
                        <tr>
                          <td>Uang Jalan</td>
                          <td><span id="tampilTotalUangJalan"></span></td>
                          <td>
                            <input type="text" id="inputMediaUangJalan" class="form-control form-control-sm" value="Kasbon">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            BBM
                            <br>
                            <span class="text-right text-kps" style="font-size: 9px">*Boleh Tidak Diisi</span>
                          </td>
                          <td>
                            <div id="voucherBBM">
                              <select class="select2 form-control" id="inputBBM">
                                <option value="">Pilih Voucher</option>
                              </select>
                            </div>
                            <div id="manualBBM">
                              <div class="form-group">
                                <label>&nbsp;</label>
                                <span class="form-control-icon">Rp</span>
                                <input type="number" class="form-control form-control-search" id="inputBBM">
                              </div>
                            </div>
                            <br>
                            <div class="custom-control custom-checkbox text-right">
                              <input class="custom-control-input custom-control-input-danger" type="checkbox" id="cekVoucher">
                              <label for="cekVoucher" class="custom-control-label">Tanpa Voucher?</label>
                            </div>
                          </td>
                          <td>
                            <input type="text" id="inputMediaBBM" class="form-control form-control-sm" value="Reimburse">
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
                              <input type="number" class="form-control form-control-search" id="inputTOL">
                            </div>
                          </td>
                          <td>
                            <input type="text" id="inputMediaTol" class="form-control form-control-sm" value="Reimburse">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

           <div class="card">
            <div class="card-header">
              <div class="card-title">
                6. Keberangkatan
              </div>
            </div>
             <div class="card-body">
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
                         <td><input type="time" id="inputJamBerangkat" class="form-control saveRencana"></td>
                       </tr>
                       <tr>
                         <td class="font-weight-bold">Kepulangan</td>
                         <td><input type="date" id="inputTglPulang" class="form-control saveRencana"></td>
                         <td><input type="time" id="inputJamPulang" class="form-control saveRencana"></td>
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
    </div>
    <div class="modal fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
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
                  <select class="select2 form-control" id="inputObjek">
                    <option value="">Pilih Objek</option>
                    <option value="Customer">Customer</option>
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
                  <input type="text" id="inputObjekLainnya" class="form-control" placeholder="Isi Objek Lainnya">
                </div>
              </div>
              <br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Perusahaan</label>
                  <select class="select2 form-control" id="inputPerusahaan">
                    
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-kps saveLokasi ladda-button" data-style="expand-right">Save</button>
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
                          <select class="select2 form-control pilihPIC" id="inputJenisPIC">
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
                          <select class="select2 form-control pilihPIC" id="inputSubjek">
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
                          <select class="select2 form-control" id="inputPIC">
                            <option value="">Pilih Jenis PIC dan Subjek Terlebih Dahulu!</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input custom-control-input-danger" type="checkbox" id="inputSortir">
                            <label for="inputSortir" class="custom-control-label">Sortir?</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="setNamaPIC">
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
                          <input type="text" id="inputUangSaku" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Uang Makan</label>
                          <input type="text" id="inputUangMakan" class="form-control" readonly>
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
            <button type="button" class="btn btn-danger btn-kps savePIC ladda-button" data-style="expand-right">Save</button>
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
<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    $('.preloader').fadeOut('slow');
    $('.preloader-no-bg').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    kondisiKendaraan()
    pengaturanSortir();
    cekVoucher()
    // make_skeleton().fadeOut();
    $('#afterNext').addClass("d-none");
    $('#beforeNext').removeClass("d-none");
    $('#inputJenisSPJ').on('change', function(){
      var jenis = $(this).val();
      if (jenis !='') {
        getNoSPJ(jenis);
        disVoucher()
      }else{
        $('#inputNoSPJ').val('');
        
      }
    })
    $('#btnNext').on('click', function(data){
      var jenis= $('#inputJenisSPJ').val();
      
      getNoSPJ(jenis);
    });
    var btnNext = $('.btnNext').ladda();
      btnNext.click(function () {
      // Start loading
      btnNext.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        var jenisSPJ = '';
        var inputTglSPJ = $('#inputTglSPJ').val();
        if (inputJenisSPJ == '1') {
          jenisSPJ = 'Delivery';
        }else{
          jenisSPJ = 'Non Delivery';
        }
        var inputNoSPJ = $('#inputNoSPJ').val();
        if (inputJenisSPJ == '') {
          Swal.fire("Pilih Terlebih Dahulu Jenis SPJ!","","warning");
        }else if(inputTglSPJ == ''){
          Swal.fire("Pilih Tanggal SPJ nya terlebih Dahulu!","","warning")
        }else{
          $.ajax({
            type:'post',
            dataType: 'json',
            data:{inputJenisSPJ, inputNoSPJ, inputTglSPJ},
            url: 'saveTemporaryPengajuan',
            cache: false,
            async: true,
            beforeSend: function(data){
              $('.preloader-no-bg').show();
            },
            success: function(data){
              berhasil();
              getQrCode();
              disVoucher();
              // getPIC();
              $('#isiPengajuan').removeClass("d-none");
              $('#afterNext').removeClass("d-none");
              $('#beforeNext').addClass("d-none");
              $('#getNext').addClass("d-none");
              $('input[id="inputJenisSPJ"]').val(jenisSPJ);
              $('#btnSaveSPJ').removeClass("d-none");
              $('#inputTglSPJ').attr("readonly","readonly")
              $('#inputTglBerangkat').val(inputTglSPJ);
            },
            complete: function(data){
              $('.preloader-no-bg').fadeOut('slow');
            },
            error: function(data){
              gagal();
            }
          });
        }
        
        btnNext.ladda('stop');
        return false;
          
      }, 1000)
    });
    $('#inputKendaraan').on('change', function(){
      kondisiKendaraan()
    });
    $('#pilihKendaraan').on('click', function(){
      var inputKendaraan = $('#inputKendaraan').val();
      var inputJenisKendaraan = $('#inputJenisKendaraan').val();
      $.ajax({
        type:'get',
        data:{inputKendaraan, inputJenisKendaraan},
        url:'pilihKendaraan',
        cache: false,
        async: true,
        success: function(data){
          $('#modal-kendaraan').modal("show");
          $('#getKendaraan').html(data);
        },
        error: function(data){
          Swal.fire("Gagal Mengambil Data!","Hubungi Staff IT","error");
        }
      });
    })
    $('#getKendaraan').on('click', '.pilihKendaraan', function(){
      var tnkb = $(this).attr('tnkb');
      var merk = $(this).attr("merk");
      var tipe = $(this).attr("tipe");
      var inv = $(this).attr("inv");
      var inputJenisKendaraan = $('#inputJenisKendaraan').val();
      var noSPJ = $('#inputNoSPJ').val();
      $('#inputNoInventaris').val(inv);
      $('#inputMerk').val(merk);
      $('#inputType').val(tipe);
      $('#inputNoTNKB').val(tnkb);
      $('#modal-kendaraan').modal("hide");
      $.ajax({
        type: 'post',
        data: {inv, inputJenisKendaraan, noSPJ, tnkb, merk, tipe},
        dataType: 'json',
        url: 'saveKendaraanSPJ',
        cache: false,
        async: true,
        success: function(data){
          console.log(data);
        },
        error: function(data){
          console.log("error");
        }
      })
    });

    $('#inputGroupTujuan').on('change', function(){
      var id = $(this).val();
      if (id == '') {
        $('#viewTujuan').html('');
        $('#inputPerusahaan').html("");
      }else{
        $.ajax({
          type: 'get',
          data: {id},
          dataType: 'json',
          url: 'getViewJalur',
          async: true,
          cache: false,
          beforeSend: function(data){
            $('.preloader-no-bg').show();
          },
          success: function(data){
            saveGroupTujuan();
            getCustomerSerlok(data);
            getLokasi()
            getPIC()
            getTotalUangSakuMakan()
            getUangJalan();
            var tujuan = '';
            var kota= '';
            var koma='';
            for (var i = 0; i < data.length; i++) {
              if (i>0) {
                koma = ', ';
              }
              kota +=data[i].TIPE_KOTA+' '+data[i].NAMA_KOTA;

              tujuan +=koma+kota;
              kota = '';
            }
            $('#viewTujuan').html(tujuan);
          },
          complete: function(data){
            $('.preloader-no-bg').fadeOut('slow');
          },
          error: function(data){
            $('#viewTujuan').html();
          }
        });
      }

    })

    $('#inputObjek').on('change', function(){
      var objek = $(this).val();
      if (objek == 'Lainnya') {
        $('.objekLainnya').removeClass("d-none")
      } else {
        $('.objekLainnya').addClass("d-none");
      }
    });
    $('#inputJenisSPJ').on('change', function(){
      disJenisPIC();
    })

    var saveLokasi = $('.saveLokasi').ladda();
      saveLokasi.click(function () {
      // Start loading
      saveLokasi.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var objek = $('#inputObjek').val();
        var objekLainnya = $('#inputObjekLainnya').val();
        var inputPerusahaan = $('#inputPerusahaan').val();
        var inputGroupTujuan = $('#inputGroupTujuan').val();
        var inputObjek = objek == 'Lainnya'?objekLainnya:objek;
        var inputNoSPJ = $('#inputNoSPJ').val();
        if (objek == '' || inputPerusahaan == '') {
          Swal.fire("Lengkapi Dulu Datanya!","","warning");
        }else{
          $.ajax({
            type:'post',
            dataType:'json',
            data:{inputPerusahaan, inputGroupTujuan, inputObjek, inputNoSPJ},
            url: 'saveLokasiTujuan',
            cache: false,
            async: true,
            success: function(data){
              $('#modal-lokasi').modal('hide');
              berhasil();
              getLokasi();
              getUangJalan();
            },
            error: function(data){
              gagal()
            },
          });
        }
        saveLokasi.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('.pilihPIC').on('change', function(){
      getNIK();
      hitungUangSaku();
      hitungUangMakan();
    })

    $('#btnTambahPIC').on('click', function(){
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      if (inputGroupTujuan == '') {
        Swal.fire("Pilih Terlebih Dahulu Group Tujuannya!","","warning");
      }else{
        $('#modal-pic').modal("show")
      }
    });
    $('#inputPIC').on('change', function(){
      var nik = $(this).val();
      $.ajax({
        type: 'get',
        data:{nik},
        dataType: 'json',
        url: 'getDataInputPIC',
        async: true,
        cache: false,
        success: function(data){
          console.log(data.departemen)
          $('#setDepartemenPIC').val(data.departemen);
          $('#setSubDepartemenPIC').val(data.Subdepartemen1);
          $('#setJabatanPIC').val(data.jabatan);
          $('#setNamaPIC').val(data.namapeg);
          pengaturanSortir();
          hitungUangSaku();

        },
        error: function(data){

        }
      });
    });
     $('#inputSortir').on('change', function(){
      
      hitungUangSaku()
      
    });

    var savePIC = $('.savePIC').ladda();
      savePIC.click(function () {
      // Start loading
      savePIC.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisPIC = $('#inputJenisPIC').val();
        var inputSubjek = $('#inputSubjek').val();
        var inputPIC = $('#inputPIC').val();
        var inputGroupTujuan = $('#inputGroupTujuan').val();
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputJenisKendaraan = $('#inputJenisKendaraan').val();
        
        if (inputJenisPIC == '' || inputSubjek == '' || inputPIC == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Pastikan Pilihan PIC dan Subjek nya terisi","warning")
        }else{
          $.ajax({
            type: 'get',
            dataType: 'json',
            data:{inputNoSPJ, inputGroupTujuan, inputPIC, inputJenisKendaraan},
            url:'cekJumlahSupir',
            async: true,
            cache: false,
            success: function(data){
              if (parseInt(data.JML_DRIVER) >0 && inputJenisPIC == 'Sopir') {
                Swal.fire("Driver Sudah di Daftarkan!","Dalam 1 SPJ Tidak Boleh Lebih dari 1 Driver","warning");
              }else if(parseInt(data.JML_PIC) >0){
                Swal.fire("PIC Yang Dipilih Sudah Terdaftar Pada SPJ Ini!","","warning")
              }else if(parseInt(data.SET_PENDAMPING) <= parseInt(data.JML_PENDAMPING) && inputJenisPIC == 'Pendamping' ){
                Swal.fire("Jumlah Pendamping Sudah Memenuhi Ketentuan Jumlah Pendamping!","Tidak Bisa Menambah Kembali Pendamping","warning")
              }else{
                savePICPengajuan();
              }

              console.log(data)
            },
            error: function(data){

            }
          });
          
        }
        savePIC.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('.saveRencana').on('change', function(){
      var isi = $(this).val();
      console.log(isi)
    })

    $('#btnSaveSPJ').on('click', function(){
      var inputNoSPJ = $('#inputNoSPJ').val();

      $.ajax({
        type: 'get',
        data:{inputNoSPJ},
        dataType: 'json',
        url:'cekKelengkapanDataSPJ',
        async: true,
        cache: false,
        success: function(data){
          if (data.SPJ <=0) {
            Swal.fire("Lengkapi Terlebih Dahulu Datanya!","","warning")
          }else if(data.JML_LOKASI <= 0){
            Swal.fire("Data Lokasi Tujuan Masih Kosong!","Mohon Untuk Menambahkan Data Lokasi Tujuan","warning")
          }else if(data.JML_PIC <= 0){
            Swal.fire("Data PIC Masih Kosong!","Mohon Untuk Menambahkan Data PIC","warning")
          }else{
            cekAdaDriver();
          }
        },
        error: function(data){

        }
      });
    });

    $('#cekVoucher').on('change', function(){
      cekVoucher();

    });

    $('#getLokasi').on('click', '.hapusLokasi', function(){
      var id = $(this).attr("data");
      $.ajax({
        type:'post',
        data:{id},
        dataType: 'json',
        url: 'hapusLokasi',
        success: function(data){
          berhasil();
          getLokasi();
        },
        error: function(data){
          gagal()
        }
      })
    });
    $('#getPIC').on('click', '.hapusPIC', function(){
      var id = $(this).attr("data");
      $.ajax({
        type:'post',
        data:{id},
        dataType: 'json',
        url: 'hapusPIC',
        cache: false,
        async: true,
        success: function(data){
          berhasil()
          getPIC();
        },
        error: function(data){
          gagal();
        }
      });
    });

  })
  function getNoSPJ(jenis) {
    
    $.ajax({
      type:'get',
      dataType: 'json',
      data:{jenis},
      url:'getNoSPJ',
      cache: false,
      async: true,
      success: function(data){
        $('#inputNoSPJ').val(data.nodoc);
      },
      error: function(){
        Swal.fire("Oppssss...","Terjadi Error Pada Program! Hubungi Staff IT","error");
      }
    });
  }

  function getQrCode() {
    var no = $('#inputNoSPJ').val();
    $.ajax({
      type: 'post',
      data:{no},
      url: 'viewQrCode',
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

  function kondisiKendaraan() {
    var kendaraan = $('#inputKendaraan').val();
      if (kendaraan == 'Rental') {
        $('#pilihKendaraan').attr("disabled","disabled");
        $('.inputan').removeAttr("readonly","readonly");
        $('#inputNoInventaris').val("-")
        $('#inputMerk').val("");
        $('#inputType').val("");
        $('#inputNoTNKB').val("");
      }else{
        $('#pilihKendaraan').removeAttr("disabled","disabled");
        $('.inputan').attr("readonly","readonly");
        $('#inputNoInventaris').val("")
      }
  }

  function getCustomerSerlok(data) {
    var end = data.length-1;
    var query = '';
    for (var i = 0; i < data.length; i++) {
      if (i == 0) {
        query += "WHERE ";
      }
      query +=" nama_kabkota = '"+data[i].NAMA_KOTA+"' ";
      if (i<end) {
        query+= " OR ";
      }
    }
    $.ajax({
      type:'post',
      data:{query},
      url:'getCustomerSerlok',
      cache: false,
      async: true,
      dataType: 'json',
      success: function(data){
        var html = '';
        html +='<option value="">Pilih Perusahaan</option>';
        for (var i = 0; i < data.length; i++) {
          html+='<option value="'+data[i].id+'"><b>'+data[i].COMPANY_NAME+'</b> - '+data[i].ALAMAT_LENGKAP_PLANT+'</option>';
        }

        $('#inputPerusahaan').html(html);
      },
      error: function(data){
        $('#inputPerusahaan').html("");
      }
    });
  }
  function getLokasi() {
      var inputNoSPJ = $('#inputNoSPJ').val();
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      $.ajax({
        type:'get',
        data:{inputNoSPJ, inputGroupTujuan},
        url: 'getLokasi',
        cache: false,
        async: true,
        success: function(data){
          $('#getLokasi').html(data);
        },
        error: function(data){
          $('#getLokasi').html("");
        }
      });
  }
  function getPIC() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'post',
      data:{inputNoSPJ, inputGroupTujuan},
      dataType: 'json',
      url: 'getPengajuanPIC',
      cache: false,
      async: true,
      success: function(data){
        var html='';
        console.log(data)
        var uangSaku = 0;
        var uangMakan = 0;
        for (var i = 0; i < data.length; i++) {
          uangSaku = data[i].UANG_SAKU;
          uangMakan = data[i].UANG_MAKAN;
          html+="<tr>";
         
          html+="<td>"+data[i].JENIS_PIC+"</td>";
          html+="<td>"+data[i].OBJEK+"</td>";
          html+="<td>"+data[i].NIK+"</td>";
          html+="<td>"+data[i].NAMA+"</td>";
          html+="<td>"+data[i].DEPARTEMEN+"</td>";
          html+="<td>"+data[i].SUB_DEPARTEMEN+"</td>";
          html+="<td>"+data[i].JABATAN+"</td>";
          html+="<td>"+formatRupiah(Number(uangSaku).toFixed(0), 'Rp. ') +"</td>";
          html+="<td>"+formatRupiah(Number(uangMakan).toFixed(0), 'Rp. ')+"</td>";
           html+="<td><a href='javascript:;' class='btn text-kps text-danger hapusPIC' data='"+data[i].ID_PIC+"'><i class='fas fa-trash-alt'></i></a></td>";
          html+="<tr>";

        }

        $('#getPIC').html(html);
      },
      error: function(data){
        $('#getPIC').html('error');
      }
    });
  }

   function getNIK() {
    var inputSubjek = $('#inputSubjek').val();
    var jabatan = $('#inputJenisPIC').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    if (inputSubjek == '' && jabatan == '') {

    }else{
      $.ajax({
        type:'get',
        dataType:'json',
        data:{inputSubjek, jabatan, inputJenisSPJ, inputNoSPJ},
        url:'getNIKPic',
        cache: false,
        async: true,
        success: function(data){
          var html = '';
          html+= '<option value="">Pilih PIC</option>';
          for (var i = 0; i < data.length; i++) {
            html +='<option value="'+data[i].NIK+'">'+data[i].NIK+' - '+data[i].namapeg+'</option>';
          }
          $('#inputPIC').html(html);

        },
        error: function(data){

        }
      });
    }
  }

   function getNIK_D() {
    var inputSubjek = $('#inputSubjekD').val();
    var jabatan = 'Sopir';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputSubjek, jabatan},
      url:'getNIKPic',
      cache: false,
      async: true,
      success: function(data){
        var html = '';
        html+= '<option value="">Pilih Supir</option>';
        for (var i = 0; i < data.length; i++) {
          html +='<option value="'+data[i].nik+'">'+data[i].nik+' - '+data[i].namapeg+'</option>';
        }
        $('#inputNIKD').html(html);

      },
      error: function(data){

      }
    });
  }
  function getNIK_P() {
    var inputSubjek = $('#inputSubjekP').val();
    var jabatan = 'Pendamping';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputSubjek, jabatan},
      url:'getNIKPic',
      cache: false,
      async: true,
      success: function(data){
        var html = '';
        html+= '<option value="">Pilih Pendamping Supir</option>';
        for (var i = 0; i < data.length; i++) {
          html +='<option value="'+data[i].nik+'">'+data[i].nik+' - '+data[i].namapeg+'</option>';
        }
        $('#inputNIKP').html(html);
      },
      error: function(data){

      }
    });
  }

  function disJenisPIC() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();

    if (inputJenisSPJ == "1") {
      document.querySelectorAll("#inputJenisPIC option").forEach(opt => {
          if (opt.value == "Office" || opt.value == 'Manajemen') {
              opt.disabled = true;
          }else{
            opt.disabled = false;
          }
      });  
    }else{
      document.querySelectorAll("#inputJenisPIC option").forEach(opt => {
        if (opt.value == "Pendamping") {
            opt.disabled = true;
        }else{
          opt.disabled = false;
        }
    });
    }
    
  }

  function hitungUangSaku() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputPIC = $('#inputJenisPIC').val();
    var jabatanPIC = '';
    var setJabatanPIC = $('#setJabatanPIC').val();
    var setDepartemenPIC = $('#setDepartemenPIC').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var nik = $('#inputPIC').val();
    if (inputPIC == 'Sopir' || inputPIC == 'Pendamping') {
      jabatanPIC = inputPIC;
    }else{
      jabatanPIC = setJabatanPIC;
    }
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputSortir = document.getElementById('inputSortir');
    if (inputSortir.checked == true) {
      if (setDepartemenPIC.toLowerCase() == 'quality') {
        $('#inputUangSaku').val("40000");
      }else if(setDepartemenPIC.toLowerCase() == 'produksi'){
        $('#inputUangSaku').val("30000");
      }else{
        $('#inputUangSaku').val("0");  
      }
      
      
    }else{
        $.ajax({
          type: 'get',
          dataType: 'json',
          url: 'hitungUangSaku',
          data:{inputJenisSPJ, inputSubjek, jabatanPIC, inputGroupTujuan, inputJenisKendaraan, nik, inputTglSPJ},
          cache: false,
          async: true,
          success: function(data){
            if (data.BIAYA == null) {
              $('#inputUangSaku').val("0");
            }else{
              $('#inputUangSaku').val(data.BIAYA);  
            }
            
          },
          error: function(data){
            $('#inputUangSaku').val("0");
          }
        })
    }
    
  }
  function hitungUangMakan() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'get',
      dataType:'json',
      data:{inputJenisSPJ, inputGroupTujuan},
      url: 'hitungUangMakan',
      cache: false,
      async: true,
      success: function(data){
        $('#inputUangMakan').val(data.BIAYA);
      },
      error: function(data){
        $('#inputUangMakan').val("0");
      }
    });
  }

  function pengaturanSortir() {
    var inputPIC = $('#inputPIC').val();
    var setDepartemenPIC = $('#setDepartemenPIC').val();
    var departemen = setDepartemenPIC.toLowerCase();
    if (inputPIC == '') {
      $('#inputSortir').attr("disabled","disabled");
      document.getElementById("inputSortir").checked = false;
    }else{
      if (departemen == 'quality' || departemen == 'produksi') {
        $('#inputSortir').removeAttr("disabled","disabled");
      }else{
        $('#inputSortir').attr("disabled","disabled");
        document.getElementById("inputSortir").checked = false;    
      }
    }
  }

  function savePICPengajuan() {
    var inputJenisPIC = $('#inputJenisPIC').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputPIC = $('#inputPIC').val();
    var inputUangSaku = $('#inputUangSaku').val();
    var inputUangMakan = $('#inputUangMakan').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputDepartemen = $('#setDepartemenPIC').val();
    var inputSubDepartemen = $('#setSubDepartemenPIC').val();
    var inputJabatan = $('#setJabatanPIC').val();
    var inputNamaPIC = $('#setNamaPIC').val();
    var sortir = document.getElementById('inputSortir');
    var inputSortir = 'N';
    if (sortir.checked == true) {
      inputSortir = 'Y'
    }
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{
            inputJenisPIC, 
            inputSubjek, 
            inputPIC, 
            inputUangSaku, 
            inputUangMakan, 
            inputSortir, 
            inputNoSPJ, 
            inputGroupTujuan,
            inputDepartemen,
            inputSubDepartemen,
            inputJabatan,
            inputNamaPIC
          },
      url: 'savePIC',
      cache: false,
      async: true,
      success: function(data){
        berhasil();
        $('#modal-pic').modal('hide');
        getPIC();
        getTotalUangSakuMakan();
        $("select#inputJenisPIC option[value='']").prop("selected","selected");
        $("select#inputJenisPIC").trigger("change");
        $("select#inputSubjek option[value='']").prop("selected","selected");
        $("select#inputSubjek").trigger("change");
        $("select#inputPIC option[value='']").prop("selected","selected");
        $("select#inputPIC").trigger("change");
      },
      error: function(data){
        gagal();
      }
    })

  }
  function getTotalUangSakuMakan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'get',
      dataType: 'json',
      data:{inputNoSPJ, inputGroupTujuan},
      url:'getTotalUangSakuMakan',
      cache: false,
      asyncCallback: true,
      success: function(data){
        var uangSaku = Number(data.UANG_SAKU).toFixed(0);
        var uangMakan = Number(data.UANG_MAKAN).toFixed(0);
        $('#tampilTotalUangMakan').html(formatRupiah(uangMakan, 'Rp.'))
        $('#tampilTotalUangSaku').html(formatRupiah(uangSaku, 'Rp.'))
        $('#inputTotalUangSaku').val(uangSaku);
        $('#inputTotalUangMakan').val(uangMakan);
      },
      error: function(data){

      }
    });
  }
  function saveGroupTujuan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'post',
      dataType: 'json',
      data:{inputNoSPJ, inputGroupTujuan},
      url: 'saveGroupTujuanSPJ',
      async: true,
      cache: false,
      success: function(data){
        console.log(data)
      },
      error: function(data){
        console.log(data)
      }
    })
  }
  function getUangJalan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type: 'get',
      data: {inputNoSPJ},
      dataType: 'json',
      url: 'getUangJalanSPJ',
      cache: false,
      async: true,
      success: function(data){
        var uangJalan = Number(data.BIAYA).toFixed(0);
        
        $('#tampilTotalUangJalan').html(formatRupiah(uangJalan, 'Rp.'));
      },
      error: function(data){

      }
    });
  }

  function saveSPJ() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputNoInventaris = $('#inputNoInventaris').val();
    var inputMerk = $('#inputMerk').val();
    var inputType = $('#inputType').val();
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputTotalUangSaku = $('#inputTotalUangSaku').val();
    var inputTotalUangMakan = $('#inputTotalUangMakan').val();
    var inputTotalUangJalan = $('#inputTotalUangJalan').val();
    var inputBBM = $('#inputBBM').val();
    var inputTOL = $('#inputTOL').val();
    var inputMediaUangSaku = $('#inputMediaUangSaku').val();
    var inputMediaUangMakan = $('#inputMediaUangMakan').val();
    var inputMediaUangJalan = $('#inputMediaUangJalan').val();
    var inputMediaBBM = $('#inputMediaBBM').val();
    var inputMediaTOL = $('#inputMediaTol').val();
    var inputTglBerangkat = $('#inputTglBerangkat').val();
    var inputJamBerangkat = $('#inputJamBerangkat').val();
    var inputTglPulang = $('#inputTglPulang').val();
    var inputJamPulang = $('#inputJamPulang').val();
    var inputAneh = 'Aneh';
    
    if (inputNoTNKB == '') {
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","No TNKB Kendaraan Masing Kosong!", "warning")
    }else if(inputGroupTujuan == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Anda Belum Memilih Group Tujuan!", "warning")
    }else if(inputTglBerangkat == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Tanggal berangkat!", "warning")
    }else if(inputJamBerangkat == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Jam Berangkat!", "warning")
    }else if(inputTglPulang == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Tanggal Pulang!", "warning")
    }else if(inputJamPulang == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Jam Pulan", "warning")
    }else{
      $.ajax({
        type:'post',
        data:{
            inputAneh,
            inputMediaTOL,
            inputNoSPJ,
            inputTglSPJ,
            inputJenisKendaraan,
            inputKendaraan,
            inputNoInventaris,
            inputMerk,
            inputType,
            inputNoTNKB,
            inputGroupTujuan,
            inputTotalUangSaku,
            inputTotalUangMakan,
            inputTotalUangJalan,
            inputBBM,
            inputTOL,
            inputMediaUangSaku,
            inputMediaUangMakan,
            inputMediaUangJalan,
            inputMediaBBM,
            inputTglBerangkat,
            inputJamBerangkat,
            inputTglPulang,
            inputJamPulang
          },
        dataType: 'json',
        url: 'saveSPJ',
        async: true,
        cache: false,
        success: function(data){
          berhasil();
        },
        error: function(darta){
          gagal();
        }
      })
    }

  }

  function cekAdaDriver() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputNoSPJ},
      url: 'cekAdaDriver',
      async: true,
      cache: false,
      success: function(data){
        if (parseInt(data)>0) {
          saveSPJ();
        } else {
          Swal.fire("Tidak Terdapat Driver Pada SPJ Ini!","PIC yang di daftarkan Tidak ada yang memiliki otoritas Driver!","warning")
        }
      },
      error: function(data){

      }
    })
  }


  function disVoucher() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    if (inputJenisSPJ == 2) {
      $('#cekVoucher').removeAttr("disabled","disabled")
    }else{
      $('#cekVoucher').attr("disabled","disabled");
    }
  }
  function cekVoucher() {
    var inputSortir = document.getElementById('cekVoucher');
      if (inputSortir.checked == true) {
        $('#voucherBBM').addClass("d-none");
        $('#manualBBM').removeClass("d-none");
      }else{
        $('#voucherBBM').removeClass("d-none");
        $('#manualBBM').addClass("d-none");
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

  function berhasil() {
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'success',
        title: 'Berhasil Menyimpan Data!',
        showConfirmButton: false,
        timer: 3000
      })
    }

  function gagal() {
    Swal.fire({
      position: 'top-end',
      toast : true,
      icon: 'error',
      title: 'Gagal Menyimpan Data! Hubungi Staff IT',
      showConfirmButton: false,
      timer: 3000
    })
  }
</script>
<!-- FootJS -->
</body>
</html>

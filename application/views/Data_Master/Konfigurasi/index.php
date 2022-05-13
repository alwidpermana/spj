<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .cek{
      color:  rgb(178, 58, 72);
    }
    .cek: hover{
      color:  rgb(237, 169, 22);
    }
    .labJudul{
      padding-top: 7px;
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
<div class="wrapper">
    <?php $this->load->view('_partial/navbar');?>
    <?php $this->load->view('_partial/sidebar');?>
    <div class="content-wrapper">
      <?php $this->load->view('_partial/content-header');?>
      <div class="content">
        <div class="container-fluid">
          <!-- /.row -->
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-4 col-sm-2">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <!-- <a class="cek nav-link active jenisSPJ" id="vert-tabs-jenisSPJ-tab" data-toggle="pill" href="#vert-tabs-jenisSPJ" role="tab" aria-controls="vert-tabs-jenisSPJ" aria-selected="true">Jenis SPJ</a> -->
                  <a class="cek nav-link active jumlahPendamping" id="vert-tabs-jumlahPendamping-tab" data-toggle="pill" href="#vert-tabs-jumlahPendamping" role="tab" aria-controls="vert-tabs-jumlahPendamping" aria-selected="false">Jumlah Pendamping</a>
                  <a class="cek nav-link uangJalan" id="vert-tabs-uangJalan-tab" data-toggle="pill" href="#vert-tabs-uangJalan" role="tab" aria-controls="vert-tabs-uangJalan" aria-selected="false">Uang Jalan</a>
                  <a class="cek nav-link uangSaku" id="vert-tabs-uangSaku-tab" data-toggle="pill" href="#vert-tabs-uangSaku" role="tab" aria-controls="vert-tabs-uangSaku" aria-selected="false">Uang Saku</a>
                  <a class="cek nav-link uangMakan" id="vert-tabs-uangMakan-tab" data-toggle="pill" href="#vert-tabs-uangMakan" role="tab" aria-controls="vert-tabs-uangMakan" aria-selected="false">Uang Makan</a>
                  <a class="cek nav-link uangTambahan" id="vert-tabs-uangTambahan-tab" data-toggle="pill" href="#vert-tabs-uangTambahan" role="tab" aria-controls="vert-tabs-uangTambahan" aria-selected="false">Uang Tambahan</a>
                  <a class="cek nav-link kota" id="vert-tabs-kota-tab" data-toggle="pill" href="#vert-tabs-kota" role="tab" aria-controls="vert-tabs-kota" aria-selected="false">Kota</a>
                </div>
              </div>
              <div class="col-8 col-sm-10">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <!-- <div class="tab-pane text-left fade show active" id="vert-tabs-jenisSPJ" role="tabpanel" aria-labelledby="vert-tabs-jenisSPJ-tab">
                    <div id="getJenisSPJ"></div>
                  </div> -->
                  <div class="tab-pane text-left fade show active" id="vert-tabs-jumlahPendamping" role="tabpanel" aria-labelledby="vert-tabs-jumlahPendamping-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-danger btn-kps btn-sm" data-toggle="modal" data-target="#modal-pendamping">
                            <i class="fas fa-plus"></i>
                            Tambah
                          </button> 
                        </div>
                      </div>
                    </div>
                    <br>
                    <div id="getJumlahPendamping"></div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-uangJalan" role="tabpanel" aria-labelledby="vert-tabs-uangJalan-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-danger btn-kps btn-sm" data-toggle="modal" data-target="#modal-uangJalan">
                            <i class="fas fa-plus"></i>
                            Tambah
                          </button> 
                        </div>
                      </div>
                    </div>
                    <br>
                    <div id="getUangJalan"></div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-uangSaku" role="tabpanel" aria-labelledby="vert-tabs-uangSaku-tab">
                     <div class="row">
                      <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-danger btn-kps btn-sm" data-toggle="modal" data-target="#modal-uangSaku">
                            <i class="fas fa-plus"></i>
                            Tambah
                          </button> 
                        </div>
                      </div>
                    </div>
                    <br>
                     <div id="getUangSaku"></div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-uangMakan" role="tabpanel" aria-labelledby="vert-tabs-uangMakan-tab">
                    <div id="getUangMakan"></div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-uangTambahan" role="tabpanel" aria-labelledby="vert-tabs-uangTambahan-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <div id="getViewJamTambahan"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <table class="table table-hover table-valign-middle table-striped text-center">
                          <thead>
                            <th>Jenis</th>
                            <th>Jam Ke 1 - 3</th>
                            <th>Jam Ke  &ge; 4</th>
                          </thead>
                          <tbody>
                            <?php foreach ($tambahan as $tm): ?>
                              <tr>
                                <td><?=$tm->NAMA_JENIS?></td>
                                <td>
                                  <input type="number" id="inputTambahanUangSaku1" class="form-control saveTambahanUangSaku" value="<?=$tm->QTY1?>" data="<?=$tm->ID1?>">
                                </td>
                                <td>
                                  <input type="number" id="inputTambahanUangSaku2" class="form-control saveTambahanUangSaku" value="<?=$tm->QTY2?>" data="<?=$tm->ID2?>">
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-kota" role="tabpanel" aria-labelledby="vert-tabs-kota-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="preloader2">
                          <div class="loader">
                              <div class="spinner"></div>
                              <div class="spinner-2"></div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-danger btn-kps btn-sm" data-toggle="modal" data-target="#modal-kota">
                            <i class="fas fa-plus"></i>
                            Tambah
                          </button> 
                        </div>
                      </div>
                    </div>
                    <br>
                     <div id="getKota"></div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- /.card -->
        </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-pendamping" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Objek</label>
                      <select class="select2 form-control" id="inputObjek">
                        <?php foreach ($spj as $key): ?>
                          <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Jenis Kendaraan</label>
                      <select class="select2 form-control" id="inputJenisKendaraan">
                        <?php foreach ($kendaraan as $key2): ?>
                          <option value="<?=$key2->JENIS_KENDARAAN?>"><?=$key2->JENIS_KENDARAAN?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label>Qty Lokal</label>
                    <input type="number" id="inputQtyLokal" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label>Qty Luar Kota</label>
                    <input type="number" id="inputQtyLuarKota" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps ladda-button saveJumlahPendamping" data-style="zoom-in" id="saveJumlahPendamping">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="modal-uangJalan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Kategori</label>
                      <select class="select2 form-control" id="inputKategoriJalan">
                        <?php foreach ($spj as $key): ?>
                          <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Kota</label>
                      <select class="select2 form-control" id="inputKotaJalan" style="width:100%;">
                        <option value="">Pilih Kota</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label>Biaya</label>
                    <input type="number" id="inputBiayaJalan" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps ladda-button saveUangJalan" data-style="zoom-in" id="saveUangJalan">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- UANG JALAN -->
    <div class="modal fade" id="modal-kota" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-2">
                <label class="labJudul">Tipe</label>
              </div>
              <div class="col-md-3">
                <select class="select2 form-control" id="inputTipeDaerah">
                  <option value="Kota">Kota</option>
                  <option value="Kabupaten">Kabupaten</option>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-2">
                <label class="labJudul">Nama Daerah</label>
              </div>
              <div class="col-md-4">
                <input type="text" id="inputNamaDaerah" class="form-control form-control-sm">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-2">
                <label class="labJudul">Provinsi</label>
              </div>
              <div class="col-md-3">
                <select class="select2 form-control" id="inputProvinsi">
                  <?php foreach ($provinsi as $prov): ?>
                    <option value="<?=$prov->NAMA_PROVINSI?>"><?=$prov->NAMA_PROVINSI?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps ladda-button saveKota" data-style="zoom-in" id="saveKota">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- UANG SAKU -->
    <div class="modal fade" id="modal-uangSaku" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-3">
                    <label class="labJudul">Jenis SPJ</label>
                  </div>
                  <div class="col-md-5">
                    <select class="select2 form-control" id="inputJenisSPJ">
                      <?php foreach ($spj as $key): ?>
                        <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-3">
                    <label class="labJudul">PIC</label>
                  </div>
                  <div class="col-md-5">
                    <select class="select2 form-control" id="inputPIC">
                      <option value="">Pilih Jabatan</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="showJenisKendaraan">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="labJudul">Jenis Kendaraan</label>
                    </div>
                    <div class="col-md-5">
                      <select class="select2 form-control" id="inputJKendaraan">
                        <?php foreach ($kendaraan as $ken): ?>
                          <option value="<?=$ken->JENIS_KENDARAAN?>"><?=$ken->JENIS_KENDARAAN?></option>  
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-3">
                    <label class="labJudul">Group Tujuan</label>
                  </div>
                  <div class="col-md-5">
                    <select class="select2" id="inputGroupTujuan">
                      <?php foreach ($group as $group): ?>
                        <option value="<?=$group->ID_GROUP?>"><?=$group->NAMA_GROUP?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="col-md-1">
                    <a href="javascript:;" class="btn text-danger text-kps lihatGroup"><i class="far fa-eye"></i></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-3">
                    <label class="labJudul">Biaya Internal</label>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <span class="form-control-icon">Rp.</span>
                      <input type="number" class="form-control form-control-search" id="inputBiayaInternal">
                    </div>
                  </div>
                </div>
                <div class="confUangSakuRental">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="labJudul">Biaya Rental</label>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <span class="form-control-icon">Rp.</span>
                        <input type="number" class="form-control form-control-search" id="inputBiayaRental">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div id="getGroupTabel"></div>  
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps ladda-button saveTarget" data-style="expand-right" id="saveTarget">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-getGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <div id="getListGroup"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-editNilaiUangSaku" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <form id="saveValueUangSaku">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row text-left">
              <div class="col-md-5">
                <label>Jenis Kendaraan</label>
              </div>
              <div class="col-md-7">
                : <span id="textJenisKendaraan"></span>
              </div>
            </div>
            <div class="row text-left">
              <div class="col-md-5">
                <label>PIC</label>
              </div>
              <div class="col-md-7">
                : <span id="textPIC"></span>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-5">
                <label class="labJudul">Uang Saku</label>
              </div>
              <div class="col-md-7">
                <input type="hidden" id="inputValueJenisSPJ">
                <input type="hidden" id="inputValuePIC">
                <input type="hidden" id="inputValueField">
                <input type="hidden" id="inputValueJenisKendaraan">
                <input type="hidden" id="inputvalueGroup">
                <input type="number" id="inputValueUangSaku" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-danger btn-kps saveUS" id="saveUS">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-getJamTambahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <input type="hidden" id="inputFieldJamTambahan">
                <div class="form-group">
                  <label>Jam Kerja <span id="tambahanJamKerja"></span></label>
                  <input type="number" id="inputJamTambahan" class="form-control form-control-sm">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-kps ladda-button saveJamTambahan" id="saveJamTambahan" data-style="expand-right">Save</button>
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
    $('.preloader2').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    getJumlahPendamping();
    confJenisSPJUangSaku(jenis=1);
    confUangSakuRental();
    getJamTambahan();
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    // getJenisSPJ()
   // $('.jenisSPJ').on('click', function(){
   //  getJenisSPJ();
   // });

   $('.kota').on('click', function(){
    getKota();
   });
   $('.jumlahPendamping').on('click', function(){
    getJumlahPendamping();
   });
   $('.uangJalan').on('click', function(){
    getUangJalan();
   });
   $('.uangSaku').on('click', function(){
    getUangSaku();
   });
   $('.uangMakan').on('click', function(){
    getUangMakan();
   });

   var saveJumlahPendamping = $('.saveJumlahPendamping').ladda();
      saveJumlahPendamping.click(function () {
      // Start loading
      saveJumlahPendamping.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputObjek = $('#inputObjek').val();
        var inputJenisKendaraan = $('#inputJenisKendaraan').val();
        var inputQtyLokal = $("#inputQtyLokal").val();
        var inputQtyLuarKota = $("#inputQtyLuarKota").val();
        
        $.ajax({
          type:'post',
          dataType: 'json',
          data:{inputObjek, inputJenisKendaraan, inputQtyLokal, inputQtyLuarKota},
          url: 'saveJumlahPendamping',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            getJumlahPendamping();
            $('#modal-pendamping').modal("hide");
          },
          error: function(data){
            gagal();
          }
        })
        
        saveJumlahPendamping.ladda('stop');
        return false;
          
      }, 1000)
    });

    $("#inputKotaJalan").select2({
        ajax: { 
           url: 'getKotaAPI',
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
              return {
                cari: params.term // search term
              };
           },
           processResults: function (response) {
              return {
                 results: response
              };
              console.log(response)

           },
           cache: true
        }
    });
    var saveUangJalan = $('.saveUangJalan').ladda();
      saveUangJalan.click(function () {
      // Start loading
      saveUangJalan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputKategoriJalan = $('#inputKategoriJalan').val();
        var inputKotaJalan = $('#inputKotaJalan').val();
        var inputBiayaJalan = $("#inputBiayaJalan").val();
        
        if (inputKategoriJalan == '') {
          Swal.fire("Pilih Terlebih Dahulu Kota nya!","","warning")
        }else{
          $.ajax({
            type:'post',
            dataType: 'json',
            data:{inputKategoriJalan, inputKotaJalan, inputBiayaJalan},
            url: 'saveUangJalan',
            cache: false,
            async: true,
            success: function(data){
              berhasil();
              getUangJalan();
              $('#modal-uangJalan').modal("hide");
            },
            error: function(data){
              gagal();
            }
          })  
        }
        
        
        saveUangJalan.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('#getUangSaku').on('click','.groupJalur', function(){
      var id = $(this).attr("data");
      var html = '';
      $.ajax({
        type:'get',
        dataType:'json',
        data:{id},
        url: 'getListGroupJalur',
        cache: false,
        async: true,
        success:function(data){
          html+= '<ul class="list-group list-group-flush">';
          for (var i = 0; i < data.length; i++) {
            html +='<li class="list-group-item">'+data[i].TIPE_KOTA+' '+data[i].NAMA_KOTA+'</li>';
          }
          html += '</ul>';
          $('#getListGroup').html(html);
          $('#modal-getGroup').modal("show");
        },
        error: function(data){
          Swal.fire("Gagal Mengambil Data!","Hubungi Staff IT!","error");
        }
      })
    })
    $('#inputPIC').on('change', function(){
      confUangSakuRental();
    });
    $('#inputJenisSPJ').on('change', function(){
      var jenis = $(this).val();
      confJenisSPJUangSaku(jenis);
      confUangSakuRental()
      
    });
    $('#getUangSaku').on('click','.biayaUangSaku', function(){
       var biaya = $(this).attr("biaya");
        var field = $(this).attr("FIELD");
        var jenisSPJ = $(this).attr("ID_JENIS_SPJ");
        var pic = $(this).attr("PIC");
        var jenisKendaraan = $(this).attr("JENIS_KENDARAAN");
        var idGroup = $(this).attr("ID_GROUP");
        var isiBiaya = biaya == 0?'':biaya;
        document.getElementById("inputValueUangSaku").focus();
        $('#modal-editNilaiUangSaku').modal("show")
        $('#textJenisKendaraan').html(jenisKendaraan);
        $('#textPIC').html(pic);
        $('#inputValueUangSaku').val(isiBiaya);
        $('#inputValueJenisSPJ').val(jenisSPJ);
        $('#inputValuePIC').val(pic);
        $('#inputValueField').val(field);
        $('#inputValueJenisKendaraan').val(jenisKendaraan);
        $('#inputvalueGroup').val(idGroup);

    });
    $('#saveValueUangSaku').submit(function(e){
      e.preventDefault();
      var biaya = $('#inputValueUangSaku').val() == ''?0:parseInt($('#inputValueUangSaku').val());
      if (biaya>0) {
        saveNilaiUangSaku();
      } else {
        Swal.fire("Isi Uang Saku Lebih dari 1 !","","warning")
      }
      

    })

    var saveUangSaku = $('.saveUangSaku').ladda();
      saveUangSaku.click(function () {
      // Start loading
      saveUangSaku.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        var inputPIC = $('#inputPIC').val();
        var inputJKendaraan = $("#inputJKendaraan").val();
        var inputGroupTujuan = $("#inputGroupTujuan").val();
        var inputBiayaInternal = $("#inputBiayaInternal").val();
        var inputBiayaRental = $("#inputBiayaRental").val();
        if (inputPIC == '') {
          Swal.fire("Pilih PIC Terlebih Dahulu!","","warning")
        }
        else if (inputBiayaInternal == '' && inputBiayaRental == '') {
          Swal.fire("Isi Salah Satu Biaya!","","warning")
        }else{
          $.ajax({
            type:'post',
            dataType: 'json',
            data:{inputJenisSPJ, inputPIC, inputJKendaraan, inputGroupTujuan, inputBiayaRental, inputBiayaInternal},
            url: 'saveUangSaku',
            cache: false,
            async: true,
            success: function(data){
              berhasil();
              getUangSaku();
              $('#modal-uangSaku').modal("hide");
            },
            error: function(data){
              gagal();
            }
          })  
        }
        
        
        saveUangSaku.ladda('stop');
        return false;
          
      }, 1000)
    });

    var saveKota = $('.saveKota').ladda();
      saveKota.click(function () {
      // Start loading
      saveKota.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputTipeDaerah = $('#inputTipeDaerah').val();
        var inputNamaDaerah = $('#inputNamaDaerah').val();
        var inputProvinsi = $("#inputProvinsi").val();
        var inputGroupTujuan = $("#inputGroupTujuan").val();
        var inputBiayaInternal = $("#inputBiayaInternal").val();
        var inputBiayaRental = $("#inputBiayaRental").val();
        
        if (inputNamaDaerah == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
        }else{
          $.ajax({
            type:'post',
            dataType: 'json',
            data:{inputTipeDaerah, inputNamaDaerah, inputProvinsi},
            url: 'saveKota',
            cache: false,
            async: true,
            success: function(data){
              berhasil();
              getKota();
              $('#modal-kota').modal("hide");
            },
            error: function(data){
              gagal();
            }
          })  
        }
        
        
        saveKota.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('#getUangSaku').on('click','.editUangSaku', function(){
      var jenisSPJ = $(this).attr("jenisSPJ");
      var pic = $(this).attr("pic");
      var jenisKendaraan = $(this).attr("jenisKendaraan");
      var groupTujuan = $(this).attr("groupTujuan");
      var internal = $(this).attr("internal");
      var rental = $(this).attr("rental");
      $('#modal-uangSaku').modal("show");
      $("select#inputJenisSPJ option[value='"+jenisSPJ+"']").prop("selected","selected");
      $("select#inputJenisSPJ").trigger("change");
      $("select#inputPIC option[value='"+pic+"']").prop("selected","selected");
      $("select#inputPIC").trigger("change");
      $("select#inputJKendaraan option[value='"+jenisKendaraan+"']").prop("selected","selected");
      $("select#inputJKendaraan").trigger("change");
      $("select#inputGroupTujuan option[value='"+groupTujuan+"']").prop("selected","selected");
      $("select#inputGroupTujuan").trigger("change");
      $("#inputBiayaInternal").val(internal);
      $("#inputBiayaRental").val(rental);
    });
    $('#getUangSaku').on('click','.hapusUangSaku', function(){
      var id = $(this).attr("data");
      Swal.fire({
        title: 'Apakah Kamu Yakin?',
        text: "Data Uang Saku Yang Terhapus Akan Mempengaruhi Form Pengisian SPJ!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Hapus Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
                type : "POST",
                url  : "hapusUangSaku",
                data :{id},
                async : false,
                cache: false,
                dataType: "JSON",
                success: function(data){
                  berhasil()
                  getUangSaku()
                },
                error: function(data){
                  gagal();
                }
            });

          
        }
      })
    })
    $('#getUangMakan').on('change','.inputMakan', function(){
      var isi = $(this).val();
      var jenis= $(this).attr('jenis'); 
      var grup = $(this).attr('grup');
      var ke= $(this).attr('ke');
      
      $.ajax({
        type: 'post',
        dataType: 'json',
        data:{isi, jenis, grup,ke},
        url: 'saveUangMakan',
        cache: false,
        async: true,
        success: function(data){
          berhasil()
        },
        error: function(data){
          gagal()
        },
      });
    });
    $('.lihatGroup').on('click', function(){
      
      var group = $('#inputGroupTujuan').val();
      $.ajax({
        type: 'get',
        data:{group},
        url: 'getTabelGroup',
        cache: false,
        async: true,
        success: function(data){
          $('#getGroupTabel').html(data);
        },
        error: function(data){
          $('#getGroupTabel').html("Gagal Meload Data....");
        }
      });
    })
    $('.saveTambahanUangSaku').on('change', function(){
      var id = $(this).attr("data");
      var qty = $(this).val();
      if (parseInt(qty) == 0 || qty == '') {
        Swal.fire("Biaya Tidak Boleh Kosong!","","warning")
      } else {
        $.ajax({
          type:'post',
          dataType: 'json',
          data:{id, qty},
          url:'saveTambahanUangSaku',
          cache: false,
          async: true,
          success: function(data){
            berhasil()
          },
          error: function(data){
            gagal();
          }
        }); 
      }
      
    })
    $('#getViewJamTambahan').on('click','.setJamTambahan', function(){
      var jam = $(this).attr("data");
      var field = $(this).attr("field");
      $('#inputJamTambahan').val(jam)
      $('#inputFieldJamTambahan').val(field);
      if (field=='JAM2') {
        $('#tambahanJamKerja').html("(Lewat Pukul 24:00)");
      } else {
        $('#tambahanJamKerja').html("");

      }
      $('#modal-getJamTambahan').modal("show");
    });
    var saveJamTambahan = $('.saveJamTambahan').ladda();
      saveJamTambahan.click(function () {
      // Start loading
      saveJamTambahan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var jam = $('#inputJamTambahan').val();
        var field = $('#inputFieldJamTambahan').val();
        $.ajax({
          type:'post',
          dataType:'json',
          data:{jam, field},
          url:'saveJamTambahan',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            $('#modal-getJamTambahan').modal("hide");
            getJamTambahan();
          },
          error: function(data){
            gagal();
          }
        })
        
        saveJamTambahan.ladda('stop');
        return false;
          
      }, 1000)
    });

  })
  function confUangSakuRental() {
    var jenisSPJ = $('#inputJenisSPJ').val();
    var inputPIC = $('#inputPIC').val();
    if (jenisSPJ == '2' && inputPIC != 'Driver') {
      $('.confUangSakuRental').addClass("d-none");
      $('#inputBiayaRental').val("");
    }else{
      $('.confUangSakuRental').removeClass("d-none");
    }
  }
  function confJenisSPJUangSaku(jenis) {
    console.log(jenis)
    if (jenis == '1') {
      var html = '';
      html +='<option value="Sopir">Sopir</option>';
      html +='<option value="Pendamping">Pendamping</option>';
      $('#inputPIC').html(html);
      $('.showJenisKendaraan').removeClass("d-none");
    }else{
      $.ajax({
        type: 'get',
        dataType: 'json',
        url:'apiJabatan',
        cache: false,
        async: true,
        success: function(data){
          var html='';
          html +='<option value="">Pilih Jabatan</option>';
          for (var i = 0; i < data.length; i++) {
            html+= '<option value="'+data[i].jabatan+'">'+data[i].jabatan+'</option>';
            
          }
          $('#inputPIC').html(html);
        },
        error: function(data){
          Swal.fire("Terjadi Error Pada Program","Mohon Refresh Halaman Ini atau Hubungi Staff IT!","error");
        }
      }); 
      $('.showJenisKendaraan').addClass("d-none");
    }
  }
  function getJumlahPendamping() {
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type:'get',
      url:"getJumlahPendamping",
      cache: false,
      async: true,
      success: function(data){
        $('#getJumlahPendamping').html(data);
      },
      error: function(data){
        $('#getJumlahPendamping').html(gagal)
      }
    })
  }
  function getUangJalan() {
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type:'get',
      url:"getUangJalan",
      cache: false,
      async: true,
      success: function(data){
        $('#getUangJalan').html(data);
      },
      error: function(data){
        $('#getUangJalan').html(gagal)
      }
    })
  }
  function getUangSaku() {
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type:'get',
      url:"getUangSaku",
      cache: false,
      async: true,
      success: function(data){
        $('#getUangSaku').html(data);
      },
      error: function(data){
        $('#getUangSaku').html(gagal)
      }
    })
  }
  function getUangMakan() {
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type:'get',
      url:"getUangMakan",
      cache: false,
      async: true,
      success: function(data){
        $('#getUangMakan').html(data);
      },
      error: function(data){
        $('#getUangMakan').html(gagal)
      }
    })
  }
  function getKota() {
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type:'get',
      url:"getKota",
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader2').show();
      },
      success: function(data){
        $('#getKota').html(data);
      },
      complete: function(data){
        $('.preloader2').fadeOut("slow");
      },
      error: function(data){
        $('#getKota').html(gagal)
      }
    })
  }

  function saveNilaiUangSaku() {
    var biaya = $('#inputValueUangSaku').val();
    var field = $('#inputValueField').val();
    var jenisSPJ = $('#inputValueJenisSPJ').val();
    var pic = $('#inputValuePIC').val();
    var jenisKendaraan = $('#inputValueJenisKendaraan').val();
    var idGroup = $('#inputvalueGroup').val();
    console.log(idGroup)
    $.ajax({
      type:'post',
      dataType:'json',
      data:{biaya, field, jenisSPJ, pic, jenisKendaraan, idGroup},
      url:'saveUangSakuNew',
      cache: false,
      async: true,
      success: function(data){
        berhasil();
        $('#modal-editNilaiUangSaku').modal("hide");
        getUangSaku();

      },
      error: function(data){
        gagal();
      }
    });
  }
  function getJamTambahan() {
    $.ajax({
      type:'get',
      url:'getJamTambahan',
      cache: false,
      async: true,
      success: function(data){
        $('#getViewJamTambahan').html(data);
      },
      error:function(data){
        
      }
    })
  }
  // function getJenisSPJ() {
  //   var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
  //       gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
  //       gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
  //       gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
  //       gagal +='</div>';
  //   $.ajax({
  //     type:'get',
  //     url:"getJenisSPJ",
  //     cache: false,
  //     async: true,
  //     success: function(data){
  //       $('#getJenisSPJ').html(data);
  //     },
  //     error: function(data){
  //       $('#getJenisSPJ').html(gagal)
  //     }
  //   })
  // }
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

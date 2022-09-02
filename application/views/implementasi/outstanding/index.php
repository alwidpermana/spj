<?php
  $bulan = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
  $tanggal = date("Y-m-d");
  $i = 1;
  $kurang = 10;
  $tahun = [];
  for ($i=0; $i <$kurang ; $i++) { 
    $penguranTahun = date('Y', strtotime('-'.$i.' year', strtotime( $tanggal )));
    array_push($tahun, $penguranTahun); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <?php $this->load->view("_partial/head")?>
  
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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Tahun</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                          <?php foreach ($tahun as $value): ?>
                            <option value="<?=$value?>"><?=$value?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Bulan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filBulan">
                          <?php foreach ($bulan as $angka => $bulan): ?>
                            <option value="<?=$bulan?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Periode</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filPeriode">
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis SPJ</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                            <option value="">ALL</option>
                          <?php foreach ($jenis as $key): ?>
                            <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                          <option value="">ALL</option>
                          <option value="OPEN">OPEN</option>
                          <option value="CLOSE">CLOSE</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Group Tujuan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filGroup">
                          <option value="">ALL</option>
                          <?php foreach ($group as $key): ?>
                            <option value="<?=$key->ID_GROUP?>"><?=$key->NAMA_GROUP?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 offset-md-6">
                      <form id="search">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabel"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal-otoritas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" id="inputNoSPJ">
                <input type="hidden" id="inputNIKPengaju">
                <table class="table table-valign-middle" width="100%">
                  <thead class="text-center">
                    <tr>
                      <th rowspan="2">Objek</th>
                      <th colspan="3">Pengajuan Adjustment</th>
                      <th colspan="2">Otoritas</th>
                    </tr>
                    <tr>
                      <th>Normal</th>
                      <th>Diajukan</th>
                      <th>Alasan</th>
                      <th>Keputusan</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <tr>
                      <td class="text-left">Uang Makan</td>
                      <td>
                        <span id="inputUangMakanNormal"></span>
                        <br>
                        <span id="ketUangMakan"></span>
                      </td>
                      <td>
                        <span id="viewUangMakanDiajukan"></span>
                        <center><input type="number" id="inputUangMakanDiajukan" class="form-control form-control-sm hitungAwal kondisiUangMakan" style="width: 100px;" jenis="uangMakan"></center>
                        <input type="hidden" id="awalUangMakan">
                        <div id="validasiUangMakan" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Uang Makan Tidak Boleh Lebih Dari Pengajuan Uang Makan!</span>
                        </div>
                      </td>
                      <td><span id="inputUangMakanAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UMOK" 
                              name="uangMakan" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiUangMakan2">
                            <label for="UMOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UMNG" 
                              name="uangMakan" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiUangMakan2">
                            <label for="UMNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUangMakan">
                      </td>
                      <td><textarea class="form-control otoritas kondisiUangMakan" id="inputUangMakanKeterangan" rows="2" ></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Jalan</td>
                      <td><span id="inputUangJalanNormal"></span></td>
                      <td>
                        <span id="viewUangJalanDiajukan"></span>
                        <center><input type="number" id="inputUangJalanDiajukan" class="form-control form-control-sm hitungAwal kondisiUangJalan" jenis="uangJalan" style="width: 100px;"></center>
                        <input type="hidden" id="awalUangJalan">
                        <div id="validasiUangJalan" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Biaya Uang Jalan Tidak Boleh Lebih Dari Pengajuan Uang Jalan!</span>
                        </div>
                      </td>
                      <td><span id="inputUangJalanAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UJOK" 
                              name="uangJalan" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiUangJalan2">
                            <label for="UJOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UJNG" 
                              name="uangJalan" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiUangJalan2">
                            <label for="UJNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUangJalan">
                      </td>
                      <td><textarea class="form-control otoritas kondisiUangJalan" id="inputUangJalanKeterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">BBM</td>
                      <td><span id="inputBBMNormal"></span></td>
                      <td>
                        <span id="viewBBMDiajukan"></span>
                        <center><input type="number" id="inputBBMDiajukan" class="form-control form-control-sm hitungAwal kondisiBBM" jenis="bbm" style="width: 100px;"></center>
                        <input type="hidden" id="awalBBM">
                        <div id="validasiBBM" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Biaya BBM Tidak Boleh Lebih Dari Pengajuan BBM!</span>
                        </div>
                      </td>
                      <td><span id="inputBBMAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="BBMOK" 
                              name="BBM" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiBBM2">
                            <label for="BBMOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="BBMNG" 
                              name="BBM" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiBBM2">
                            <label for="BBMNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanBBM">
                      </td>
                      <td><textarea class="form-control otoritas kondisiBBM" id="inputBBMKeterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Saku Jam Ke 1 - 3</td>
                      <td>
                        <span id="viewUS1Normal"></span>
                        <input type="hidden" id="inputUS1Normal">
                      </td>
                      <td>
                        <span id="viewUS1Diajukan"></span>
                        <input type="hidden" id="inputUS1Diajukan">
                      </td>
                      <td><span id="inputUS1Alasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US1OK" 
                              name="US1" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiUS1" checked>
                            <label for="US1OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US1NG" 
                              name="US1" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiUS1">
                            <label for="US1NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUS1" value="OK">
                      </td>
                      <td><textarea class="form-control otoritas kondisiUS1" id="inputUS1Keterangan" rows="2">Otomatis</textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Saku Jam Ke > 4</td>
                      <td>
                        <span id="viewUS2Normal"></span>
                        <input type="hidden" id="inputUS2Normal">
                      </td>
                      <td>
                        <span id="viewUS2Diajukan"></span>
                        <input type="hidden" id="inputUS2Diajukan">
                      </td>
                      <td><span id="inputUS2Alasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US2OK" 
                              name="US2" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiUS2" checked>
                            <label for="US2OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US2NG" 
                              name="US2" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiUS2">
                            <label for="US2NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUS2" value="OK">
                      </td>
                      <td><textarea class="form-control otoritas kondisiUS2" id="inputUS2Keterangan" rows="2">Otomatis</textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Makan Ke 2</td>
                      <td>
                        <span id="viewUMNormal"></span>
                        <input type="hidden" id="inputUMNormal">
                      </td>
                      <td>
                        <span id="viewUMDiajukan"></span>
                        <input type="hidden" id="inputUMDiajukan">
                      </td>
                      <td><span id="inputUMAlasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UM2OK" 
                              name="UM" 
                              value="OK" 
                              class="inputKeputusan otoritas kondisiUM" checked>
                            <label for="UM2OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UM2NG" 
                              name="UM" 
                              value="NG" 
                              class="inputKeputusan otoritas kondisiUM">
                            <label for="UM2NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUM" value="OK">
                      </td>
                      <td><textarea class="form-control otoritas kondisiUM" id="inputUMKeterangan" rows="2">Otomatis</textarea></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th class="text-right">TOTAL</th>
                      <th class="text-center"><span class="totalNormal"></span></th>
                      <th class="text-center"><span class="totalDiajukan"></span></th>
                      <th colspan="3"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <input type="hidden" id="inputManajemen">
            <input type="hidden" id="inputJenisSPJ">
            <input type="hidden" id="inputIdSPJ">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveOtoritas ladda-button" data-style="expand-right">Save</button>
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
    
    // make_skeleton().fadeOut();
   getTabel();
   $('.validasiBiaya').addClass("d-none")
   $('.filter').on('change', function(){
      getTabel();
   })
   $('#search').submit(function(e){
    e.preventDefault();
    getTabel();
   });

   $('#getTabel').on('click', '.btnKeputusan', function(){
    var noSPJ = $(this).attr("no_spj");
    var pic = $(this).attr("nik");
    var jenisSPJ = $(this).attr("jenisSPJ");
    var idSPJ = $(this).attr("idSPJ")
    $('#inputNoSPJ').val(noSPJ);
    $('#inputJenisSPJ').val(jenisSPJ);
    $('#inputIdSPJ').val(idSPJ);
    $.ajax({
      dataType:'json',
      data:{noSPJ},
      url:url+'/Implementasi/getBiayaNormal',
      type:'get',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        $('#modal-otoritas').modal("show")
        ngUangMakan();
        ngUangJalan();
        ngBBM();
        $('#inputBBMNormal').html(formatRupiah(String(data.uangBBM),'Rp. '));
        $('#inputUangMakanNormal').html(formatRupiah(String(data.uangMakan1),'Rp. '));
        $('#inputUMNormal').val(data.uangMakan2);
        $('#viewUMNormal').html(formatRupiah(String(data.uangMakan2),'Rp. '));
        $('#viewUMDiajukan').html(formatRupiah(String(data.uangMakan2),'Rp. '));
        $('#inputUangJalanNormal').html(formatRupiah(String(data.uangJalan),'Rp. '));
        $('#viewUangMakanDiajukan').html(formatRupiah(String(data.uangMakanDiajukan),'Rp. '));
        $('#viewUangJalanDiajukan').html(formatRupiah(String(data.uangJalanDiajukan),'Rp. '));
        $('#viewBBMDiajukan').html(formatRupiah(String(data.uangBBMDiajukan),'Rp. '));
        $('#inputUS1Normal').val(data.uangSaku1);
        $('#viewUS1Normal').html(formatRupiah(String(data.uangSaku1), 'Rp. '));
        $('#viewUS2Normal').html(formatRupiah(String(data.uangSaku2), 'Rp. '));
        $('#inputUS2Normal').val(data.uangSaku2)
        $('#viewUS1Diajukan').html(formatRupiah(String(data.uangSaku1), 'Rp. '));
        $('#viewUS2Diajukan').html(formatRupiah(String(data.uangSaku2), 'Rp. '));
        $('#inputUangMakanDiajukan').val(data.uangMakanDiajukan);
        $('#awalUangMakan').val(data.uangMakanDiajukan);
        $('#inputUangJalanDiajukan').val(data.uangJalanDiajukan);
        $('#inputBBMDiajukan').val(data.uangBBMDiajukan);
        $('#awalUangJalan').val(data.uangJalanDiajukan);
        $('#awalBBM').val(data.uangBBMDiajukan);
        $('#inputUangMakanAlasan').html(data.uangMakanAlasan);
        $('#inputUangJalanAlasan').html(data.uangJalanAlasan);
        $('#inputBBMAlasan').html(data.uangBBMAlasan);
        $('#inputKeputusanBBM').val(data.uangBBMKeputusan);
        $('#inputUS1Diajukan').val(data.uangSaku1);
        $('#inputUS2Diajukan').val(data.uangSaku2);
        $('#inputUMDiajukan').val(data.uangMakan2);
        $('#inputUMKeterangan').val(data.uangUMKeterangan);
        $('#inputUS1Keterangan').val(data.uangUS1Keterangan);
        $('#inputUS2Keterangan').val(data.uangUS2Keterangan)
        $('#inputManajemen').val(data.manajemen);
        var uangAdjustmentNormal = data.manajemen == 'Y' ? parseInt(data.uangMakan1) + parseInt(data.uangBBM) + parseInt(data.uangJalan) : 0;
        var uangAdjustmentDiajukan = data.manajemen == 'Y' ? parseInt(data.uangMakanDiajukan) + parseInt(data.uangBBMDiajukan) + parseInt(data.uangJalanDiajukan) : 0;
        var totalNormal = parseInt(data.uangSaku1) + parseInt(data.uangSaku2) + parseInt(data.uangMakan2) + uangAdjustmentNormal;
        var totalDiajukan = parseInt(data.uangSaku1) + parseInt(data.uangSaku2) + parseInt(data.uangMakan2) + uangAdjustmentDiajukan;
        $('.totalNormal').html(formatRupiah(String(totalNormal), 'Rp. '));
        $('.totalDiajukan').html(formatRupiah(String(totalDiajukan), 'Rp. '));
        
        if (data.uangUS1Keputusan == 'OK') {
          $('[name="US1"]#USOK').attr("checked","checked");
          $('#inputKeputusanUS1').val("OK")
        }else if(data.uangUS1Keputusan == 'NG'){
          $('[name="US1"]#USNG').attr("checked","checked")
          $('#inputKeputusanUS1').val("NG")
        }else{
          $('[name="US1"]#USOK').attr("checked","checked")
          $('[name="US1"]#USNG').removeAttr("checked","checked")
          $('#inputKeputusanUS1').val("OK")
        }

        if (data.uangUS2Keputusan == 'OK') {
          $('[name="US2"]#US2OK').attr("checked","checked");
          $('#inputKeputusanUS2').val("OK")
        }else if(data.uangUS2Keputusan == 'NG'){
          $('[name="US2"]#US2NG').attr("checked","checked")
          $('#inputKeputusanUS2').val("NG")
        }else{
          $('[name="US2"]#US2OK').attr("checked","checked")
          $('[name="US2"]#US2NG').removeAttr("checked","checked")
          $('#inputKeputusanUS2').val("OK")
        }

        if (data.uangUMKeputusan == 'OK') {
          $('[name="UM"]#UM2OK').attr("checked","checked");
          $('#inputKeputusanUM').val("OK")
        }else if(data.uangUMKeputusan == 'NG'){
          $('[name="UM"]#UM2NG').attr("checked","checked")
          $('#inputKeputusanUM').val("NG")
        }else{
          $('[name="UM"]#UM2OK').attr("checked","checked")
          $('[name="UM"]#UM2NG').removeAttr("checked","checked")
          $('#inputKeputusanUM').val("OK")
        }

        if (data.uangBBMKeputusan == 'OK') {
          $('[name="BBM"]#BBMOK').attr("checked","checked");
        }else if(data.uangBBMKeputusan == 'NG'){
          $('[name="BBM"]#BBMNG').attr("checked","checked")
        }else{
          $('[name="BBM"]#BBMOK').removeAttr("checked","checked")
          $('[name="BBM"]#BBMNG').removeAttr("checked","checked")
        }
        $('#inputBBMKeterangan').val(data.uangBBMKeterangan);

        $('#inputKeputusanUangMakan').val(data.uangMakanKeputusan);
        if (data.uangMakanKeputusan == 'OK') {
          $('[name="uangMakan"]#UMOK').attr("checked","checked");
        }else if(data.uangMakanKeputusan == 'NG'){
          $('[name="uangMakan"]#UMNG').attr("checked","checked")
        }else{
          $('[name="uangMakan"]#UMOK').removeAttr("checked","checked")
          $('[name="uangMakan"]#UMNG').removeAttr("checked","checked")
        }
        $('#inputUangMakanKeterangan').val(data.uangMakanKeterangan);

        $('#inputKeputusanUangJalan').val(data.uangJalanKeputusan);
        if (data.uangJalanKeputusan == 'OK') {
          $('[name="uangJalan"]#UJOK').attr("checked","checked");
        }else if(data.uangJalanKeputusan == 'NG'){
          $('[name="uangJalan"]#UJNG').attr("checked","checked")
        }else{
          $('[name="uangJalan"]#UJOK').removeAttr("checked","checked")
          $('[name="uangJalan"]#UJNG').removeAttr("checked","checked")
        }
        $('#inputUangJalanKeterangan').val(data.uangJalanKeterangan);
        
        if (data.manajemen == 'Y') {
          if (data.uangMakanStatus == 'CLOSE') {
            $('.kondisiUangMakan').attr("readonly","readonly");
            $('.kondisiUangMakan2').attr("disabled","disabled");
          }else{
            $('.kondisiUangMakan').removeAttr("readonly","readonly");
            $('.kondisiUangMakan2').removeAttr("disabled","disabled");
          }

          if (data.uangJalanStatus == 'CLOSE') {
            $('.kondisiUangJalan').attr("readonly","readonly");
            $('.kondisiUangJalan2').attr("disabled","disabled");
          }else{
            $('.kondisiUangJalan').removeAttr("readonly","readonly");
            $('.kondisiUangJalan2').removeAttr("disabled","disabled");
          }

          if (data.uangBBMStatus == 'CLOSE') {
            $('.kondisiBBM').attr("readonly","readonly");
            $('.kondisiBBM2').attr("disabled","disabled");
          }else{
            $('.kondisiBBM').removeAttr("readonly","readonly");
            $('.kondisiBBM2').removeAttr("disabled","disabled");
          }
        }else{
          $('.kondisiUangMakan').attr("readonly","readonly");
          $('.kondisiUangMakan2').attr("disabled","disabled");
          $('.kondisiUangJalan').attr("readonly","readonly");
          $('.kondisiUangJalan2').attr("disabled","disabled");
          $('.kondisiBBM').attr("readonly","readonly");
          $('.kondisiBBM2').attr("disabled","disabled");
        }
        

        if (data.uangUS1Status == 'CLOSE') {
          $('.kondisiUS1').attr("disabled","disabled");
        }else{
          $('.kondisiUS1').removeAttr("disabled","disabled");
        }

        if (data.uangUS2Status == 'CLOSE') {
          $('.kondisiUS2').attr("disabled","disabled");
        }else{
          $('.kondisiUS2').removeAttr("disabled","disabled");
        }

        if (data.uangUMStatus == 'CLOSE') {
          $('.kondisiUM').attr("disabled","disabled");
        }else{
          $('.kondisiUM').removeAttr("disabled","disabled");
        }

        // if (data.manajemen == 'Y') {
        //   if (data.jmlOpen>0) {
        //     $('.saveOtoritas').removeAttr("disabled","disabled")
        //   }else{
        //     $('.saveOtoritas').attr("disabled","disabled")
        //   } 
        // }else{
        //   $('.saveOtoritas').removeAttr("disabled","disabled")
        // }
        if (data.jmlOpen>0) {
          $('.saveOtoritas').removeAttr("disabled","disabled")
        }else{
          $('.saveOtoritas').attr("disabled","disabled")
        }
        

      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program","Mohon Hubungi Staff IT!","error")
      }
    })
    
   });
   $('[name="uangMakan"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUangMakan').val(isi);
    ngUangMakan(isi);
   })
   $('[name="uangJalan"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUangJalan').val(isi);
    ngUangJalan(isi);
   })
   $('[name="BBM"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanBBM').val(isi);
    ngBBM(isi);
   })
   $('[name="US1"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUS1').val(isi);
   });
   $('[name="US2"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUS2').val(isi);
   });
   $('[name="UM"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUM').val(isi);
   })

   $('.hitungAwal').on('keyup', function(){
    var isi = $(this).val();
    var jenis = $(this).attr("jenis");
    hitungAwal(isi, jenis)
    
   })
   $('.hitungAwal').on('change', function(){
    var isi = $(this).val();
    var jenis = $(this).attr("jenis");
    hitungAwal(isi, jenis)
    
   })
   var saveOtoritas = $('.saveOtoritas').ladda();
      saveOtoritas.click(function () {
      // Start loading
      saveOtoritas.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputUangMakanDiajukan = $('#inputUangMakanDiajukan').val();
        var awalUangMakan = $('#awalUangMakan').val();
        var inputUangJalanDiajukan = $('#inputUangJalanDiajukan').val();
        var awalUangJalan = $('#awalUangJalan').val();
        var inputBBMDiajukan = $('#inputBBMDiajukan').val();
        var awalBBM = $('#awalBBM').val();
        var inputManajemen = $('#inputManajemen').val();

        if (inputUangMakanDiajukan > awalUangMakan) {
          Swal.fire("Jumlah Uang Makan Melebihi Pengajuan!","Uang Makan Yang Di Revisi Tidak Boleh Lebih Dari Pengajuan","warning");
        }else if(inputUangJalanDiajukan > awalUangJalan){
          Swal.fire("Jumlah Uang Jalan Melebihi Pengajuan!","Uang Jalan Yang Di Revisi Tidak Boleh Lebih Dari Pengajuan","warning");
        }else if(inputBBMDiajukan > awalBBM){
          Swal.fire("Jumlah Uang BBM Melebihi Pengajuan!","Uang BBM Yang Di Revisi Tidak Boleh Lebih Dari Pengajuan","warning");
        }else{
          cekSaldo(inputManajemen)
        }

        saveOtoritas.ladda('stop');
        $('.saveOtoritas').attr("disabled","disabled")
        return false;
          
      }, 1000)
    });

  })
  function hitungAwal(isi, jenis) {
    if (jenis == 'uangMakan') {
      var awal = $('#awalUangMakan').val();
      if (isi>awal) {
        $('#validasiUangMakan').removeClass("d-none");
      }else{
        $('#validasiUangMakan').addClass("d-none");
      }
    }else if(jenis == 'uangJalan'){
      var awal = $('#awalUangJalan').val();
      if (isi>awal) {
        $('#validasiUangJalan').removeClass("d-none");
      }else{
        $('#validasiUangJalan').addClass("d-none");
      }
    }else{
      var awal = $('#awalBBM').val();
      if (isi>awal) {
        $('#validasiBBM').removeClass("d-none");
      }else{
        $('#validasiBBM').addClass("d-none");
      }
    }

    validasiBTNSave();
  }
  function getTabel() {
    var filBulan = $('#filBulan').val();
    var filTahun = $('#filTahun').val();
    var filPeriode = $('#filPeriode').val();
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();
    var filGroup = $('#filGroup').val();
    $.ajax({
      type:'get',
      data:{filBulan, filTahun, filPeriode, filJenis, filStatus, filGroup},
      url:url+'/Implementasi/getTabelOutstanding',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getTabel').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error: function(data){
        $('#getTabel').html("");
      }
    })
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

  function ngUangMakan() {
    var uangMakan = $('#inputKeputusanUangMakan').val();
    console.log(uangMakan)
    if (uangMakan == 'NG') {
      $('#inputUangMakanDiajukan').removeClass("d-none")
      $('#viewUangMakanDiajukan').addClass("d-none")
    }else{
      $('#inputUangMakanDiajukan').addClass("d-none")
      $('#viewUangMakanDiajukan').removeClass("d-none")
    }
  }
  function ngUangJalan() {
    var uangJalan = $('#inputKeputusanUangJalan').val();
    console.log(uangJalan)
    if (uangJalan == 'NG') {
      $('#inputUangJalanDiajukan').removeClass("d-none")
      $('#viewUangJalanDiajukan').addClass("d-none")
    }else{
      $('#inputUangJalanDiajukan').addClass("d-none")
      $('#viewUangJalanDiajukan').removeClass("d-none")
    }
  }
  function ngBBM() {
    var nbBBM = $('#inputKeputusanBBM').val();
    console.log(nbBBM)
    if (nbBBM == 'NG') {
      $('#inputBBMDiajukan').removeClass("d-none")
      $('#viewBBMDiajukan').addClass("d-none")
    }else{
      $('#inputBBMDiajukan').addClass("d-none")
      $('#viewBBMDiajukan').removeClass("d-none")
    }
  }

  function validasiBTNSave() {
    var awal1 = $('#awalUangMakan').val()
    var biaya1 = $('#inputUangMakanDiajukan').val();
    var awal2 = $('#awalUangJalan').val();
    var biaya2 = $('#inputUangJalanDiajukan').val();
    var awal3 = $('#awalBBM').val();
    var biaya3 = $('#inputBBMDiajukan').val();

    if (biaya1>awal1 || biaya2>awal2 || biaya3>awal3) {
      $('.saveOtoritas').attr("disabled","disabled")
    }else{
      $('.saveOtoritas').removeAttr("disabled","disabled")
    }
  }

  function cekSaldo(inputManajemen) {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var kasbon = "Kasbon SPJ "+inputJenisSPJ;
    
    var inputKeputusanUS1 = $('#inputKeputusanUS1').val();
    var inputKeputusanUS2 = $('#inputKeputusanUS2').val();
    var inputKeputusanUM = $('#inputKeputusanUM').val();
    
    if (inputManajemen == '') {
      var inputUangMakanDiajukan = 0;
      var inputUangJalanDiajukan = 0;
      var inputBBMDiajukan = 0;
    }else{
      var inputKeputusanBBM = $('#inputKeputusanBBM').val();
      var inputKeputusanUangMakan = $('#inputKeputusanUangMakan').val();
      var inputKeputusanUangJalan = $('#inputKeputusanUangJalan').val();
      var inputUangMakanDiajukan = inputKeputusanUangMakan == 'OK' ? parseInt($('#inputUangMakanDiajukan').val()):0 ;
      var inputUangJalanDiajukan = inputKeputusanUangJalan == 'OK' ? parseInt($('#inputUangJalanDiajukan').val()):0 ;
      var inputBBMDiajukan = inputKeputusanBBM == 'OK' ? parseInt($('#inputBBMDiajukan').val()): 0;
    }
    
    var inputUS1Diajukan = inputKeputusanUS1 == 'OK'?parseInt($('#inputUS1Diajukan').val()):0;
    var inputUS2Diajukan = inputKeputusanUS2 == 'OK'?parseInt($('#inputUS2Diajukan').val()):0;
    var inputUMDiajukan = inputKeputusanUM == 'OK' ? parseInt($('#inputUMDiajukan').val()):0;
    var total = inputUangMakanDiajukan+inputUangJalanDiajukan+inputUS1Diajukan+inputUS2Diajukan+inputUMDiajukan+inputBBMDiajukan;
    $.ajax({
      type:'get',
      data:{kasbon},
      dataType: 'json',
      url:url+'/Implementasi/cekSaldo',
      cache: false,
      async: true,
      success: function(data){
        if (total>data) {
          Swal.fire("Saldo Tidak Mencukupi!","Hubungi PIC Terkait","warning")
        }else{
          saveKeputusan(inputManajemen, total)
          console.log(total)
        }
        
      },
      error: function(data){

      }
    });
  }

  function saveKeputusan(inputManajemen, totalBiaya) {
    var inputUangMakanDiajukan = $('#inputUangMakanDiajukan').val();
    var inputUangJalanDiajukan = $('#inputUangJalanDiajukan').val();
    var inputBBMDiajukan = $('#inputBBMDiajukan').val();
    var inputUS1Diajukan = $('#inputUS1Diajukan').val();
    var inputUS2Diajukan = $('#inputUS2Diajukan').val();
    var inputUMDiajukan = $('#inputUMDiajukan').val();
    var inputKeputusanBBM = inputManajemen == '' ? '-': $('#inputKeputusanBBM').val();
    var inputKeputusanUS1 = $('#inputKeputusanUS1').val();
    var inputKeputusanUS2 = $('#inputKeputusanUS2').val();
    var inputKeputusanUM = $('#inputKeputusanUM').val();
    var inputKeputusanUangMakan = inputManajemen == '' ? '-': $('#inputKeputusanUangMakan').val();
    var inputKeputusanUangJalan = inputManajemen == '' ? '-': $('#inputKeputusanUangJalan').val();
    var inputUangJalanKeterangan = inputManajemen == '' ? '-': $('#inputUangJalanKeterangan').val();
    var inputUangMakanKeterangan = inputManajemen == '' ? '-': $('#inputUangMakanKeterangan').val();
    var inputUS1Keterangan = $('#inputUS1Keterangan').val();
    var inputUS2Keterangan = $('#inputUS2Keterangan').val();
    var inputUMKeterangan = $('#inputUMKeterangan').val();
    var inputBBMKeterangan = inputManajemen == '' ? '-': $('#inputBBMKeterangan').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputIdSPJ = $('#inputIdSPJ').val();
    // console.log("keputusan BBM ="+inputKeputusanBBM)
    // console.log("keputusan Uang Jalan ="+inputKeputusanUangJalan)
    // console.log("keputusan BBM ="+inputKeputusanUangMakan)
    // console.log("keputusan BBM ="+inputUangJalanKeterangan)
    // console.log("keputusan BBM ="+inputUangMakanKeterangan)
    // console.log("keputusan BBM ="+inputBBMKeterangan)
    // console.log("keputusan BBM ="+inputKeputusanUS1)
    // console.log("keputusan BBM ="+inputKeputusanUS2)
    // console.log("keputusan BBM ="+inputKeputusanUM)
    // console.log("keputusan BBM ="+inputUS1Keterangan)
    // console.log("keputusan BBM ="+inputUS2Keterangan)
    // console.log("keputusan BBM ="+inputUMKeterangan)
    if (inputKeputusanBBM == '' || inputKeputusanUangJalan == ''|| inputKeputusanUangMakan == '' || inputUangMakanKeterangan == '' || inputUangJalanKeterangan == '' || inputBBMKeterangan == '') {
      Swal.fire("Mohon untuk Melengkapi Datanya Terlebih Dahulu","","warning")

    }else if(inputKeputusanUS1 == '' || inputKeputusanUS2 == '' || inputKeputusanUM == '' || inputUS1Keterangan == '' || inputUS2Keterangan == '' || inputUMKeterangan == ''){
      Swal.fire("Mohon untuk Melengkapi Datanya Terlebih Dahulu","","warning")
    }else{
      $.ajax({
        type:'post',
        data:{
          inputUangMakanDiajukan,
          inputUangJalanDiajukan,
          inputBBMDiajukan,
          inputUS1Diajukan,
          inputUS2Diajukan,
          inputUMDiajukan,
          inputKeputusanBBM,
          inputKeputusanUangMakan,
          inputKeputusanUangJalan,
          inputKeputusanUS1,
          inputKeputusanUS2,
          inputKeputusanUM,
          inputUangJalanKeterangan,
          inputUangMakanKeterangan,
          inputBBMKeterangan,
          inputUS1Keterangan,
          inputUS2Keterangan,
          inputUMKeterangan,
          inputNoSPJ,
          inputManajemen,
          totalBiaya,
          inputJenisSPJ,
          inputIdSPJ
        },
        dataType:'json',
        url:url+'/Implementasi/saveKeputusanAdjustment',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.preloader-no-bg').show();
        },
        success: function(data){
          berhasil()
          getTabel();
          $('#modal-otoritas').modal('hide');
        },
        complete: function(data){
          $('.preloader-no-bg').fadeOut("slow");
        },
        error: function(data){
          gagal();
        }
      })
    }
    
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

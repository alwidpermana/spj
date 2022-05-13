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
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filTahun">
                          <?php foreach ($tahun as $value): ?>
                            <option value="<?=$value?>"><?=$value?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Bulan</label>
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filBulan">
                          <?php foreach ($bulan as $angka => $bulan): ?>
                            <option value="<?=$bulan?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Periode</label>
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filPeriode">
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis SPJ</label>
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filJenis">
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
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filStatus">
                          <option value="">ALL</option>
                          <option value="OPEN">OPEN</option>
                          <option value="CLOSE">CLOSE</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Group Tujuan</label>
                        <select class="select2 form-control filter select2-danger" data-dropdown-css-class="select2-danger" id="filGroup">
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
                        <center><input type="number" id="inputUangMakanDiajukan" class="form-control form-control-sm hitungAwal" style="width: 100px;" jenis="uangMakan"></center>
                        <input type="hidden" id="awalUangMakan">
                        <div id="validasiUangMakan" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Uang Makan Tidak Boleh Lebih Dari Pengajuan Uang Makan!</span>
                        </div>
                      </td>
                      <td><span id="inputUangMakanAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UMOK" 
                              name="uangMakan" 
                              value="OK" 
                              class="inputKeputusan otoritas">
                            <label for="UMOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UMNG" 
                              name="uangMakan" 
                              value="NG" 
                              class="inputKeputusan otoritas">
                            <label for="UMNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUangMakan">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputUangMakanKeterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Jalan</td>
                      <td><span id="inputUangJalanNormal"></span></td>
                      <td>
                        <span id="viewUangJalanDiajukan"></span>
                        <center><input type="number" id="inputUangJalanDiajukan" class="form-control form-control-sm hitungAwal" jenis="uangJalan" style="width: 100px;"></center>
                        <input type="hidden" id="awalUangJalan">
                        <div id="validasiUangJalan" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Biaya Uang Jalan Tidak Boleh Lebih Dari Pengajuan Uang Jalan!</span>
                        </div>
                      </td>
                      <td><span id="inputUangJalanAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UJOK" 
                              name="uangJalan" 
                              value="OK" 
                              class="inputKeputusan otoritas">
                            <label for="UJOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UJNG" 
                              name="uangJalan" 
                              value="NG" 
                              class="inputKeputusan otoritas">
                            <label for="UJNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUangJalan">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputUangJalanKeterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">BBM</td>
                      <td><span id="inputBBMNormal"></span></td>
                      <td>
                        <span id="viewBBMDiajukan"></span>
                        <center><input type="number" id="inputBBMDiajukan" class="form-control form-control-sm hitungAwal" jenis="bbm" style="width: 100px;"></center>
                        <input type="hidden" id="awalBBM">
                        <div id="validasiBBM" class="validasiBiaya">
                          <br>
                          <span class="text-kps">Jumlah Biaya BBM Tidak Boleh Lebih Dari Pengajuan BBM!</span>
                        </div>
                      </td>
                      <td><span id="inputBBMAlasan"></span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="BBMOK" 
                              name="BBM" 
                              value="OK" 
                              class="inputKeputusan otoritas">
                            <label for="BBMOK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="BBMNG" 
                              name="BBM" 
                              value="NG" 
                              class="inputKeputusan otoritas">
                            <label for="BBMNG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanBBM">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputBBMKeterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Saku Jam Ke 1 - 3</td>
                      <td><span id="inputUS1Normal"></span></td>
                      <td><span id="inputUS1Diajukan"></span></td>
                      <td><span id="inputUS1Alasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US1OK" 
                              name="US1" 
                              value="OK" 
                              class="inputKeputusan otoritas" checked disabled>
                            <label for="US1OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US1NG" 
                              name="US1" 
                              value="NG" 
                              class="inputKeputusan otoritas" disabled>
                            <label for="US1NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUS1" value="OK">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputUS1Keterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Saku Jam Ke > 4</td>
                      <td><span id="inputUS2Nromal"></span></td>
                      <td><span id="inputUS2Diajukan"></span></td>
                      <td><span id="inputUS2Alasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US2OK" 
                              name="US2" 
                              value="OK" 
                              class="inputKeputusan otoritas" checked disabled>
                            <label for="US2OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="US2NG" 
                              name="US2" 
                              value="NG" 
                              class="inputKeputusan otoritas" disabled>
                            <label for="US2NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUS1" value="OK">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputUS2Keterangan" rows="2"></textarea></td>
                    </tr>
                    <tr>
                      <td class="text-left">Uang Makan Ke 2</td>
                      <td><span id="inputUMNormal"></span></td>
                      <td><span id="inputUMDiajukan"></span></td>
                      <td><span id="inputUMAlasan">Otomatis</span></td>
                      <td>
                        <div class="form-group clearfix">
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UM2OK" 
                              name="UM" 
                              value="OK" 
                              class="inputKeputusan otoritas" checked disabled>
                            <label for="UM2OK">
                              OK
                            </label>
                          </div>
                          <br>
                          <br>
                          <div class="icheck-danger icheck-kps d-inline">
                            <input 
                              type="radio" 
                              id="UM2NG" 
                              name="UM" 
                              value="NG" 
                              class="inputKeputusan otoritas" disabled>
                            <label for="UM2NG">
                              NG
                            </label>
                          </div>
                        </div>
                        <input type="hidden" id="inputKeputusanUM">
                      </td>
                      <td><textarea class="form-control otoritas" id="inputUMKeterangan" rows="2"></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-kps saveOtoritas ladda-button" data-style="expand-right">Save</button>
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
    $.ajax({
      dataType:'json',
      data:{noSPJ},
      url:'getBiayaNormal',
      type:'get',
      cache: false,
      async: true,
      success: function(data){
        $('#modal-otoritas').modal("show")
        ngUangMakan();
        ngUangJalan();
        ngBBM();
        $('#inputUangMakanNormal').html(formatRupiah(String(data.uangMakan1),'Rp. '));
        $('#inputUMNormal').html(formatRupiah(String(data.uangMakan2),'Rp. '));
        $('#inputUMDiajukan').html(formatRupiah(String(data.uangMakan2),'Rp. '));
        $('#inputUangJalanNormal').html(formatRupiah(String(data.uangJalan),'Rp. '));
        $('#viewUangMakanDiajukan').html(formatRupiah(String(data.uangMakanDiajukan),'Rp. '));
        $('#viewUangJalanDiajukan').html(formatRupiah(String(data.uangJalanDiajukan),'Rp. '));
        $('#viewBBMDiajukan').html(formatRupiah(String(data.uangBBMDiajukan),'Rp. '));
        $('#inputUS1Normal').html(formatRupiah(String(data.uangSaku1), 'Rp. '));
        $('#inputUS2Nromal').html(formatRupiah(String(data.uangSaku2), 'Rp. '));
        $('#inputUS1Diajukan').html(formatRupiah(String(data.uangSaku1), 'Rp. '));
        $('#inputUS2Diajukan').html(formatRupiah(String(data.uangSaku2), 'Rp. '));
        $('#inputUangMakanDiajukan').val(data.uangMakanDiajukan);
        $('#awalUangMakan').val(data.uangMakanDiajukan);
        $('#inputUangJalanDiajukan').val(data.uangJalanDiajukan);
        $('#inputBBMDiajukan').val(data.uangBBMDiajukan);
        $('#awalUangJalan').val(data.uangJalanDiajukan);
        $('#awalBBM').val(data.uangBBMDiajukan);
        $('#inputUangMakanAlasan').html(data.uangMakanAlasan);
        $('#inputUangJalanAlasan').html(data.uangJalanAlasan);
        $('#inputBBMAlasan').html(data.uangBBMAlasan);
        
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
   $('.hitungAwal').on('keyup', function(){
    var isi = $(this).val();
    var jenis = $(this).attr("jenis");

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
   })

  })
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
      url:'getTabelOutstanding',
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

</script>
<!-- FootJS -->
</body>
</html>

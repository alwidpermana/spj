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
                            <option value="" <?=$attribut?>>ALL</option>
                          <?php foreach ($jenis as $key): ?>
                            <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
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
                  <div id="getTabel"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-pengajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    </tr>
                    <tr>
                      <th>Normal</th>
                      <th>Diajukan</th>
                      <th>Alasan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Uang Makan</td>
                      <td>
                        <input type="number" id="inputUangMakanNormal" class="form-control form-control-sm" readonly>
                        <br>
                        <span id="ketUangMakan"></span>
                      </td>
                      <td><input type="number" id="inputUangMakanDiajukan" class="form-control form-control-sm pengaju inputUangMakan"></td>
                      <td><textarea class="form-control pengaju inputUangMakan" id="inputUangMakanAlasan" rows="3"></textarea></td>
                      <!-- <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
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
                          <div class="icheck-orange icheck-kps d-inline">
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
                      <td><textarea class="form-control otoritas" id="inputUangMakanKeterangan" rows="3"></textarea></td> -->
                    </tr>
                    <tr>
                      <td>Uang Jalan</td>
                      <td><input type="number" id="inputUangJalanNormal" class="form-control form-control-sm" readonly></td>
                      <td><input type="number" id="inputUangJalanDiajukan" class="form-control form-control-sm pengaju inputUangJalan"></td>
                      <td><textarea class="form-control pengaju inputUangJalan" id="inputUangJalanAlasan" rows="3"></textarea></td>
                      <!-- <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
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
                          <div class="icheck-orange icheck-kps d-inline">
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
                      <td><textarea class="form-control otoritas" id="inputUangJalanKeterangan" rows="3"></textarea></td> -->
                    </tr>
                    <tr>
                      <td>BBM</td>
                      <td><input type="number" id="inputBBMNormal" class="form-control form-control-sm" readonly></td>
                      <td><input type="number" id="inputBBMDiajukan" class="form-control form-control-sm pengaju inputBBM"></td>
                      <td><textarea class="form-control pengaju inputBBM" id="inputBBMAlasan" rows="3"></textarea></td>
                      <!-- <td>
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
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
                          <div class="icheck-orange icheck-kps d-inline">
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
                      <td><textarea class="form-control otoritas" id="inputBBMKeterangan" rows="3"></textarea></td> -->
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveAdjustment ladda-button" data-style="expand-right">Save</button>
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
   $('.filter').on('change', function(){
    getTabel();
   });
   $('#search').submit(function(e){
    e.preventDefault();
    getTabel();
   })

   $('#getTabel').on('click', '.btnPengajuan', function(){
    var noSPJ = $(this).attr("no_spj");
    var nik = $(this).attr("nik");
    $('#inputNoSPJ').val(noSPJ);
    $('#inputNIKPengaju').val(nik);
    var user = '<?=$this->session->userdata("NIK")?>';
    var level = '<?=$this->session->userdata("LEVEL")?>';
    if(nik == user && level <=1){
      $('.pengaju').removeAttr("readonly","readonly");
      $('.otoritas').removeAttr("disabled","disabled");
      $('.saveAdjustment').removeAttr("disabled","disabled");
    }else if (nik == user) {
      $('.pengaju').removeAttr("readonly","readonly");
      $('.otoritas').attr("disabled","disabled");
      $('.saveAdjustment').removeAttr("disabled","disabled");
    }else if(level<= 1){
      $('.pengaju').attr("readonly","readonly");
      $('.otoritas').removeAttr("readonly","readonly");
      $('.saveAdjustment').removeAttr("disabled","disabled");
    }else{
      $('.pengaju').attr("readonly","readonly");
      $('.otoritas').attr("disabled","disabled");
      $('.saveAdjustment').attr("disabled","disabled");
    }
    $.ajax({
      dataType:'json',
      data:{noSPJ},
      url:url+'/Implementasi/getBiayaNormal',
      type:'get',
      cache: false,
      async: true,
      success: function(data){
        $('#modal-pengajuan').modal("show")
        console.log(data.ketUangMakan2);
        $('#inputUangMakanNormal').val(parseInt(data.uangMakan1)+parseInt(data.uangMakan2));
        $('#ketUangMakan').html(data.ketUangMakan2).addClass("text-kps");
        $('#inputUangJalanNormal').val(parseInt(data.uangJalan));
        $('#inputUangMakanDiajukan').val(parseInt(data.uangMakanDiajukan));
        $('#inputUangMakanAlasan').val(data.uangMakanAlasan);
        $('#inputUangMakanKeterangan').val(data.uangMakanKeterangan);
        if (data.uangMakanKeputusan == 'OK') {
          $('[name="uangMakan"]#UMOK').attr("checked","checked");
        }else if(data.uangMakanKeputusan == 'NG'){
          $('[name="uangMakan"]#UMNG').attr("checked","checked");
        }

        if (data.uangMakanStatus == 'CLOSE' && nik == user) {
          $('.inputUangMakan').attr("readonly","readonly");
        }else if(data.uangMakanStatus == 'OPEN' && nik == user){
          $('.inputUangMakan').removeAttr("readonly","readonly")
        }

        $('#inputUangJalanDiajukan').val(parseInt(data.uangJalanDiajukan));
        $('#inputUangJalanAlasan').val(data.uangJalanAlasan);
        $('#inputUangJalanKeterangan').val(data.uangJalanKeterangan);
        if (data.uangJalanKeputusan == 'OK') {
          $('[name="uangJalan"]#UJOK').attr("checked","checked");
        }else if(data.uangJalanKeputusan == 'NG'){
          $('[name="uangJalan"]#UJNG').attr("checked","checked");
        }
        if (data.uangJalanStatus == 'CLOSE' && nik == user) {
          $('.inputUangJalan').attr("readonly","readonly");
        }else if(data.uangJalanStatus == 'OPEN' && nik == user){
          $('.inputUangJalan').removeAttr("readonly","readonly")
        }

        $('#inputBBMDiajukan').val(parseInt(data.uangBBMDiajukan));
        $('#inputBBMAlasan').val(data.uangBBMAlasan);
        $('#inputBBMKeterangan').val(data.uangBBMKeterangan);
        if (data.uangBBMKeputusan == 'OK') {
          $('[name="BBM"]#BBMOK').attr("checked","checked");
        }else if(data.uangBBMKeputusan == 'NG'){
          $('[name="BBM"]#BBMNG').attr("checked","checked");
        }

        if (data.uangBBMStatus == 'CLOSE' && nik == user) {
          $('.inputBBM').attr("readonly","readonly");
        }else if(data.uangBBMStatus == 'OPEN' && nik == user){
          $('.inputBBM').removeAttr("readonly","readonly")
        }

        $('#inputBBMNormal').val(parseInt(data.uangBBM));
        if (data.uangMakanStatus == 'CLOSE' && data.uangJalanStatus == 'CLOSE' && data.uangBBMStatus == 'CLOSE') {
          $('.saveAdjustment').attr("disabled","disabled")
        }else{
          $('.saveAdjustment').removeAttr("disabled","disabled")
        }
      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program","Mohon Hubungi Staff IT!","error");
      }
    })
    
   });
   $('[name="uangMakan"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUangMakan').val(isi)
   })

   $('[name="uangJalan"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanUangJalan').val(isi)
   })

   $('[name="BBM"]').on('click', function(){
    var isi = $(this).val();
    $('#inputKeputusanBBM').val(isi)
   })

   var saveAdjustment = $('.saveAdjustment').ladda();
      saveAdjustment.click(function () {
      // Start loading
      saveAdjustment.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputUangMakanDiajukan = $('#inputUangMakanDiajukan').val();
        var inputUangMakanAlasan = $('#inputUangMakanAlasan').val();
        var inputUangMakanKeterangan = $('#inputUangMakanKeterangan').val();
        var inputUangJalanDiajukan = $('#inputUangJalanDiajukan').val();
        var inputUangJalanAlasan = $('#inputUangJalanAlasan').val();
        var inputUangJalanKeterangan = $('#inputUangJalanKeterangan').val();
        var inputBBMDiajukan = $('#inputBBMDiajukan').val();
        var inputBBMAlasan = $('#inputBBMAlasan').val();
        var inputBBMKeterangan = $('#inputBBMKeterangan').val();
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputNIKPengaju = $('#inputNIKPengaju').val();
        var user = '<?=$this->session->userdata("NIK")?>';
        var level = '<?=$this->session->userdata("LEVEL")?>';
        var inputKeputusanUangMakan = $('#inputKeputusanUangMakan').val();
        var inputKeputusanUangJalan = $('#inputKeputusanUangJalan').val();
        var inputKeputusanBBM = $('#inputKeputusanBBM').val();
        if (inputUangMakanDiajukan == '' || inputUangMakanAlasan == '') {
          Swal.fire("Mohon untuk Melengkapi Datanya Terlebih Dahulu!","Objek Uang Makan Masih Ada Yang Belum Terisi!","warning")
        }else if(inputUangJalanDiajukan == '' || inputUangJalanAlasan == ''){
          Swal.fire("Mohon untuk Melengkapi Datanya Terlebih Dahulu!","Objek Uang Jalan Masih Ada Yang Belum Terisi!","warning")
        }else if(inputBBMDiajukan==''||inputBBMAlasan==''){
          Swal.fire("Mohon untuk Melengkapi Datanya Terlebih Dahulu!","Objek Uang BBM Masih Ada Yang Belum Terisi!","warning")
        }else{
          saveAdjustments();
        }
        saveAdjustment.ladda('stop');
        return false;
          
      }, 1000)
    });

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
      url:url+'/Implementasi/getTabelAdjustment',
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
  function saveAdjustments() {
    var inputUangMakanDiajukan = $('#inputUangMakanDiajukan').val();
    var inputUangMakanAlasan = $('#inputUangMakanAlasan').val();
    var inputUangMakanKeterangan = $('#inputUangMakanKeterangan').val();
    var inputUangJalanDiajukan = $('#inputUangJalanDiajukan').val();
    var inputUangJalanAlasan = $('#inputUangJalanAlasan').val();
    var inputUangJalanKeterangan = $('#inputUangJalanKeterangan').val();
    var inputBBMDiajukan = $('#inputBBMDiajukan').val();
    var inputBBMAlasan = $('#inputBBMAlasan').val();
    var inputBBMKeterangan = $('#inputBBMKeterangan').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputNIKPengaju = $('#inputNIKPengaju').val();
    var inputKeputusanUangMakan = $('#inputKeputusanUangMakan').val();
    var inputKeputusanUangJalan = $('#inputKeputusanUangJalan').val();
    var inputKeputusanBBM = $('#inputKeputusanBBM').val();
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{
        inputUangMakanDiajukan,
        inputUangMakanAlasan,
        inputUangMakanKeterangan,
        inputKeputusanUangMakan,
        inputUangJalanDiajukan,
        inputUangJalanAlasan,
        inputUangJalanKeterangan,
        inputKeputusanUangJalan,
        inputBBMDiajukan,
        inputBBMAlasan,
        inputBBMKeterangan,
        inputKeputusanBBM,
        inputNoSPJ,
        inputNIKPengaju
      },
      url:url+'/Implementasi/saveAdjustment',
      cache: false,
      async: true,
      success: function(data){
        getTabel();
        berhasil();
        $('#modal-pengajuan').modal('hide')
      },
      error: function(data){
        gagal();
      }
    })
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

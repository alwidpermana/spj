
<!DOCTYPE html>
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
                        <label>Transaksi</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTransaksi">
                          <option value="">ALL</option>
                          <option value="Pinbuk">Pinbuk</option>
                          <option value="Generate">Generate</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis Pengajuan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenisKasbon">
                          <option value="">ALL</option>
                          <option value="Kasbon SPJ">Kasbon SPJ</option>
                          <option value="Kasbon TOL">Kasbon TOL</option>
                          <option value="Kasbon BBM">Kasbon BBM</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis SPJ</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenisSPJ">
                          <option value="">ALL</option>
                          <?php foreach ($spj as $key): ?>
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
                          <option value="Waiting For Approve">Waiting For Approve</option>
                          <option value="Waiting For Receive">Waiting For Receive</option>
                          <option value="Close">Close</option>
                          <option value="REJECTED">Rejected</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="">
                <div class="">
                  <div id="getSaldo"></div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="">
                <div id="getTabel"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="id">
            <input type="hidden" id="status">
            <input type="hidden" id="jenisKasbon">
            <input type="hidden" id="jenisSPJ">
            <input type="hidden" id="jumlah">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><p>Masukan Kode Approve Bebas Untuk Diberikan Kepada PIC Receive/PIC Penerima Uang Top Up Saldo Sub Kas</p></label><br>
                  <label>Kode Approve</label>
                  <input type="text" id="inputPassword" class="form-control form-control-sm">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveApprove ladda-button" data-style="expand-right" step="1">Save & Approve</button>
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
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('.preloader-no-bg').fadeOut('slow');
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel()
   getDataSaldo();
   $('#getTabel').on('click','.approvePengajuan', function(){
    var id = $(this).attr("data");
    var status = $(this).attr("status");
    var jenisKasbon = $(this).attr("jenisKasbon");
    var jenisSPJ = $(this).attr("jenisSPJ");
    var jumlah = $(this).attr("jumlah");
    $('#id').val(id)
    $('#status').val(status)
    $('#jenisKasbon').val(jenisKasbon)
    $('#jenisSPJ').val(jenisSPJ)
    $('#jumlah').val(jumlah)
    $('#modal-approve').modal('show')
    // if (status == 'APPROVED') {
    //   cekSaldo(jenisKasbon, jenisSPJ, jumlah, id, status)  
    // }else{
    //   approvePengajuan('', '', id, status, '')
    // }
   })
   var saveApprove = $('.saveApprove').ladda();
      saveApprove.click(function () {
      // Start loading
      saveApprove.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var id = $('#id').val()
        var status = $('#status').val()
        var jenisKasbon = $('#jenisKasbon').val()
        var jenisSPJ = $('#jenisSPJ').val()
        var jumlah = $('#jumlah').val()
        var inputPassword = $('#inputPassword').val()
        if (status == 'APPROVED') {
          cekSaldo(jenisKasbon, jenisSPJ, jumlah, id, status, inputPassword)  
        }else{
          approvePengajuan('', '', id, status, '')
        }
        saveApprove.ladda('stop');
        
        return false;
          
      }, 1000)
    });
   $('#getTabel').on('click','.approveGenerate', function(){
    var id = $(this).attr("data");
    var jenisKasbon = $(this).attr("jenisKasbon");
    var jenisSPJ = $(this).attr("jenisSPJ");
    var jumlah = $(this).attr("jumlah");
    $.ajax({
      type:'post',
      dataType:'json',
      data:{id, jenisKasbon, jenisSPJ, jumlah},
      url:'approveGenerate',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        berhasil();
        getTabel();
        getDataSaldo();
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut('slow');
      },
      error: function(data){
        gagal();
      }
    });
   })
   $('#getTabel').on('click','.receiveGenerate', function(){
    var id = $(this).attr("data");
    var jenisKasbon = $(this).attr("jenisKasbon");
    var jenisSPJ = $(this).attr("jenisSPJ");
    var jumlah = $(this).attr("jumlah");
    $.ajax({
      type:'post',
      dataType:'json',
      data:{id, jenisKasbon, jenisSPJ, jumlah},
      url:'receiveGenerate',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        berhasil();
        getTabel();
        getDataSaldo();
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut('slow');
      },
      error: function(data){
        gagal();
      }
    });
   });

  })
  
  function getTabel() {
    var filTransaksi = $('#filTransaksi').val();
    var filJenisKasbon = $('#filJenisKasbon').val();
    var filJenisSPJ = $('#filJenisSPJ').val();
    var filStatus = $('#filStatus').val();
    $.ajax({
      type:'get',
      data:{filTransaksi, filJenisKasbon, filJenisSPJ, filStatus},
      url:'getDataMyCashFlow',
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

      }
    });
  }
  function getDataSaldo() {
    $.ajax({
      type:'get',
      url:'getAllSaldo',
      cache:false,
      async: true,
      success: function(data){
        $('#getSaldo').html(data);
      },
      error: function(data){

      }
    });
  }

  function cekSaldo(inputJenisKasbon, inputJenisSPJ, inputBiaya, id, status, password) {
    var jenis = inputJenisKasbon == 'Kasbon BBM'?'Kasbon Voucher BBM':inputJenisKasbon+' '+inputJenisSPJ;
    $.ajax({
      type:'get',
      dataType:'json',
      data:{jenis},
      url:'cekSaldoAwal',
      cache: false,
      async: true,
      success: function(data){
        var saldo = parseInt(data.SALDO);
        if (saldo>=inputBiaya) {
          approvePengajuan(jenis, inputBiaya, id, status, saldo, password)
        }else{
          Swal.fire("Saldo Kas Induk "+jenis+" Tidak Mencukupi!","Mohon Hubungi PIC Terkait","info")
        }
      },
      error: function(data){
        gagal()
      }
    })
  }
  function approvePengajuan(kasbon, jumlah, id, status, saldo, password) {
    $.ajax({
      type:'post',
      data:{id, status, kasbon, jumlah, saldo, password},
      dataType:'json',
      url:'approvePengajuan',
      cache: false,
      async:true,
      beforeSend:function(data){
        $('.saveApprove').attr("disabled","disabled");
      },
      success: function(data){
        berhasil();
        getTabel();
        getDataSaldo();
        $('#modal-approve').modal('hide')
      },
      complete: function(data){
        $('.saveApprove').removeAttr("disabled","disabled");
      },
      error: function(data){
        gagal()
      }
    });
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

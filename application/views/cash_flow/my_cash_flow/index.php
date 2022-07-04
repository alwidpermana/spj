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
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel()
   $('#getTabel').on('click','.approvePengajuan', function(){
    var id = $(this).attr("data");
    var status = $(this).attr("status");
    var jenisKasbon = $(this).attr("jenisKasbon");
    var jenisSPJ = $(this).attr("jenisSPJ");
    var jumlah = $(this).attr("jumlah");
    if (status == 'APPROVED') {
      cekSaldo(jenisKasbon, jenisSPJ, jumlah, id, status)  
    }else{
      approvePengajuan('', '', id, status, '')
    }
    
    
   })

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

  function cekSaldo(inputJenisKasbon, inputJenisSPJ, inputBiaya, id, status) {
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
          approvePengajuan(jenis, inputBiaya, id, status, saldo)
        }else{
          Swal.fire("Saldo Kas Induk "+jenis+" Tidak Mencukupi!","Mohon Hubungi PIC Terkait","info")
        }
      },
      error: function(data){
        gagal()
      }
    })
  }
  function approvePengajuan(kasbon, jumlah, id, status, saldo) {
    $.ajax({
      type:'post',
      data:{id, status, kasbon, jumlah, saldo},
      dataType:'json',
      url:'approvePengajuan',
      cache: false,
      async:true,
      success: function(data){
        berhasil();
        getTabel();
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

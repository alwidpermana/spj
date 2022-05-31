<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .fotoWajah{
      max-width: 50px;
      width: auto;
      height: auto;

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
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <div class="form-group">
                <label>&nbsp;</label>
                <span class="fa fa-qrcode form-control-icon"></span>
                <input type="search" class="form-control form-control-search" id="inputScan" placeholder="Scan Qr Code">
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="preloader-no-bg">
                <div class="loader">
                    <div class="spinner"></div>
                    <div class="spinner-2"></div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div id="getSPJ"></div>
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
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('.preloader-no-bg').fadeOut("slow");
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   $('#inputScan').val("").focus();

   $('#inputScan').on('keyup', function(){
    var scan = $(this).val();
    cekSPJ(scan);
   })
  })
  
  function cekSPJ(scan) {
    $.ajax({
      type:'get',
      data:{scan},
      dataType:'json',
      url:'cekSPJ',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        if (data==0) {
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'info',
            title: 'Tidak Ditemukan SPJ dengan QrCode Tersebut!',
            showConfirmButton: false,
            timer: 3000
          })
        } else {
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'success',
            title: 'Berhasil Mengambil Data SPJ',
            showConfirmButton: false,
            timer: 3000
          })
          getSPJ(scan)
        }
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        Swal.fire({
          position: 'top-end',
          toast : true,
          icon: 'error',
          title: 'Gagal Meng-Scan QrCode!',
          showConfirmButton: false,
          timer: 3000
        })
        
      }
    });
  }

  function getSPJ(scan) {
    $.ajax({
      type:'get',
      data:{scan},
      url:'getSPJ',
      cache:false,
      async: true,
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getSPJ').html(data)
        $('#inputScan').attr("disabled","disabled");
        document.getElementById('inputScan').blur()
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        Swal.fire("Gagal Mengambil SPJ!","Reload Halaman Ini atau Hubungi Staff IT","error")
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

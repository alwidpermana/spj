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
                        <label>Adjustment</label>
                        <select class="select2 form-control select2-orange filter" data-dropdown-css-class="select2-orange" id="filAdjustment">
                          <option value="">ALL</option>
                          <option value="Y">Ya</option>
                          <option value="N">Tidak</option>  
                        </select>
                        
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                      <form id="search">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan NIK atau Nama Karyawan">
                        </div>
                      </form>
                    </div>
                  </div>
                  <br>
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
    getTabel()
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    })
    $('.filter').on('change', function(){
      getTabel();
    })
    $('#getTabel').on('change','.inputAdjustment', function(){
      var nik = $(this).attr("nik");
      var adjustment = $(this).val();
      $.ajax({
        type:'post',
        data:{nik, adjustment},
        url:url+'/data_master/saveOtoritasAdjustment',
        dataType:'json',
        cache: false,
        async: true,
        success: function(data){
          berhasil();
        },
        error: function(data){
          gagal();
        }
      })
    })
  })

  function getTabel() {
    var filSearch = $('#filSearch').val();
    var filAdjustment = $('#filAdjustment').val();
    $.ajax({
      type:'get',
      data:{filSearch, filAdjustment},
      url:url+'/data_master/getTabelAdjustmentKaryawan',
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
        $('#getTabel').html("Gagal Meload Data");
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

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
            <div class="col-md-2 col-sm-4">
              <div class="form-group">
                <label>Jenis SPJ</label>
                <select class="select2 form-control select2-orange filter" id="filJenisSPJ" data-dropdown-css-class="select2-orange">
                  <option value="1">Delivery</option>
                  <option value="2">Non Delivery</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Uang Saku</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getUangSaku"></div>
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getUangTambahan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Uang Jalan</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getUangJalan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Uang Makan</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getUangMakan"></div>
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
    
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('.select2').select2({
      'width': '100%',
    });
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getUangSaku();
   getUangJalan();
   getUangMakan();
   getUangTambahan();
   $('.filter').on('change', function(){
    getUangSaku();
    getUangJalan();
    getUangMakan();
    getUangTambahan();
   })

  })
  function getUangSaku() {
    var filJenisSPJ = $('#filJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{filJenisSPJ},
      url:'konfigUangSaku',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getUangSaku').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut("slow");
      },
      error:function(data){
        $('#getUangSaku').html("Gagal Mengambil Data");
      }
    })
  }
  function getUangJalan() {
    var filJenisSPJ = $('#filJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{filJenisSPJ},
      url:'konfigUangJalan',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getUangJalan').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut("slow");
      },
      error:function(data){
        $('#getUangJalan').html("Gagal Mengambil Data");
      }
    })
  }
  function getUangMakan() {
    var filJenisSPJ = $('#filJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{filJenisSPJ},
      url:'konfigUangMakan',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getUangMakan').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut("slow");
      },
      error:function(data){
        $('#getUangMakan').html("Gagal Mengambil Data");
      }
    })
  }
  function getUangTambahan() {
    var filJenisSPJ = $('#filJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{filJenisSPJ},
      url:'konfigUangTambahan',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getUangTambahan').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut("slow");
      },
      error:function(data){
        $('#getUangTambahan').html("Gagal Mengambil Data");
      }
    })
  }
  
  

</script>
<!-- FootJS -->
</body>
</html>

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
            <div class="col-md-2">
              <div class="form-group">
                <label>Kendaraan</label>
                <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filKendaraan">
                  <option value="">ALL</option>
                  <option value="Delivery">Delivery</option>
                  <option value="Non Delivery">Non Delivery</option>
                  <option value="Rental">Rental</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Jenis Kendaraan</label>
                <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                  <option value="">ALL</option>
                  <?php foreach ($jenis as $key2): ?>
                    <option value="<?=$key2->JENIS_KENDARAAN?>"><?=$key2->JENIS_KENDARAAN?></option>
                  <?php endforeach ?> 
                  <option value="No Data">No Data</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Jenis Data</label>
                <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filData">
                  <option value="">ALL</option>
                  <option value="Internal">Internal</option>
                  <option value="Rental">Rental</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status</label>
                <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                  <option value="">ALL</option>
                  <option value="VERIFIED">VERIFIED</option>
                  <option value="CANCEL">CANCEL</option>
                  <option value="OUTSTANDING">OUTSTANDING</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                      <form id="search">
                        <div class="form-group">
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No TNKB atau Merk atau Type Kendaraan">
                        </div>
                      </form>
                    </div>
                  </div>
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
    $('.preloader-no-bg').fadeOut("slow")
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getTabel()
    $('.filter').on('change', function(){
      getTabel()
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel()
    })
    $('#getTabel').on('click', '.btnVerif', function(){
      var noTNKB = $(this).attr("noTNKB")
      var status = $(this).attr("status")
      var data = $(this).attr("data")
      $.ajax({
        type:'post',
        data:{noTNKB, status, data},
        url:'verificationKendaraan',
        dataType:'json',
        cache: false,
        async:true,
        beforeSend: function(data){
          $('.preloader-no-bg').show()
        },
        success: function(data){
          berhasil()
          getTabel();
        },
        complete: function(data){
          $('.preloader-no-bg').fadeOut("slow")
        },
        error:function(data){
          gagal()
        }
      })
    })

  })
  function getTabel() {
    var filKendaraan = $('#filKendaraan').val();
    var filJenis = $('#filJenis').val();
    var filSearch = $('#filSearch').val();
    var filData = $('#filData').val();
    var filStatus = $('#filStatus').val();
    $.ajax({
      type:'get',
      data:{filKendaraan, filJenis, filSearch, filData, filStatus},
      url:'getTabelVerifikasiKendaraan',
      cache:false,
      async:true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getTabel').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut("slow")
      },
      error:function(data){
        $('#getTabel').html("Gagal Meload Data")
      }
    })
  }

  function berhasil() {
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'success',
        title: 'Berhasil Memverifikasi Kendaraan!',
        showConfirmButton: false,
        timer: 3000
      })
    }

  function gagal() {
    Swal.fire({
      position: 'top-end',
      toast : true,
      icon: 'error',
      title: 'Gagal Memverifikasi Kendaraan! Hubungi Staff IT',
      showConfirmButton: false,
      timer: 3000
    })
  }
  

</script>
<!-- FootJS -->
</body>
</html>

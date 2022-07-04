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
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status Approve</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="1">Approved</option>
                      <option value="2">Reject</option>
                      <option value="3">Not Yet Approved</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jenis Konfigurasi</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <option value="">ALL</option>
                      <option value="SPJ_JUMLAH_PENDAMPING">Jumlah Pendamping</option>
                      <option value="SPJ_UANG_JALAN">Uang Jalan</option>
                      <option value="SPJ_UANG_SAKU">Uang Saku</option>
                      <option value="SPJ_UANG_MAKAN">Uang Makan</option>
                      <option value="SPJ_JAM_TAMBAHAN">Jam Tambahan</option>
                      <option value="SPJ_US_TAMBAHAN">Uang Saku Tambahan</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-body table-responsive p-0">
                  <div class="getData"></div>
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
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getData();
   $('.filter').on('change', function(){
    getData();
   });
   $('.getData').on('click', '.btnApproved', function(){
    var id = $(this).attr("data");
    var status = $(this).attr("status");
    $.ajax({
      type:'post',
      data:{id,status},
      cache: false,
      async: true,
      dataType: 'json',
      url:'approvedVerifikasiKonfigurasi',
      success: function(data){
        getData();
        Swal.fire({
          position: 'top-end',
          toast : true,
          icon: 'success',
          title: 'Berhasil Menyimpan Data!',
          showConfirmButton: false,
          timer: 3000
        })
      },
      error: function(data){
        Swal.fire({
          position: 'top-end',
          toast : true,
          icon: 'error',
          title: 'Gagal Menyimpan Data! Hubungi Staff IT',
          showConfirmButton: false,
          timer: 3000
        })
      }
    });
   });

  })
  
  function getData() {
    var filStatus = $('#filStatus').val();
    var filJenis = $('#filJenis').val();
    $.ajax({
      type:'get',
      data:{filStatus, filJenis},
      url:'getDataVerifikasiKonfigurasi',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('.getData').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut("slow")
      },
      error: function(data){

      }
    });
  }

</script>
<!-- FootJS -->
</body>
</html>

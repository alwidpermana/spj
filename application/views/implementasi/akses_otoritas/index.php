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
              <div id="card">
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
    
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getTabel();
    $('#getTabel').on('click','.approvePengajuan', function(){
      var id = $(this).attr("data");
      var status = $(this).attr("status");
      $.ajax({
        type:'post',
        data:{id,status},
        dataType:'json',
        url:'saveAksesOtoritas',
        cache:false,
        async:true,
        success:function(data){
          Swal.fire("Berhasil Melakukan "+status,"","success")
          getTabel();
        },
        error:function(data){
          Swal.fire("Gagal Melakukan "+status,"Hubungi Staff IT","error")
        }
      })
    })
  })

  function getTabel() {
    $.ajax({
      type:'get',
      url:'getAksesOtoritas',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getTabel').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        Swal.fire("Gagal Meload Data","Hubungi Staff IT","error")
      }
    })
  }
  
  

</script>
<!-- FootJS -->
</body>
</html>

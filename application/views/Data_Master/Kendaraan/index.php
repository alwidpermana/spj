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
                <div class="col-md-1">
                  <div class="form-group">
                    <label>Merk</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filMerk">
                      <option value="">ALL</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Kendaraan</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filKendaraan">
                      <option value="">ALL</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label>Bahan Bakar</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filBahan">
                      <option value="">ALL</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <option value="">ALL</option>
                      <option value="Engkel & Double">Engkel & Double</option>
                      <option value="Wing Box">Wing Box</option>
                      <option value="Minibus">Minibus</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No Inventaris, No TNKB atau Kepemilikan">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    getTabel();
    $('.filter').on('change', function(){
      getTabel();
    });
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    });
    $('#getTabel').on('change','.inputJenisKendaraan', function(){
      var no = $(this).attr("data");
      var isi = $(this).val();
      var field = 'Kategori';
      saveKendaraan(no, isi, field);
    });
    $('#getTabel').on('change','.inputBBMPerLiter', function(){
      var no = $(this).attr("data");
      var isi = $(this).val();
      var field = 'BBMPerLiter';
      saveKendaraan(no, isi, field);
    });
  

  })
  function getTabel(argument) {
    var filMerk = $('#filMerk').val();
    var filKendaraan = $('#filKendaraan').val();
    var filBahan = $('#filBahan').val();
    var filJenis = $('#filJenis').val();
    var filSearch = $('#filSearch').val();
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type: 'get',
      data: {filMerk, filKendaraan, filBahan, filJenis, filSearch},
      url:'getTabelKendaraan',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },  
      success: function(data){
        $('#getTabel').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut("slow");
      },
      error: function(data){
        $('#getTabel').html(gagal);
      }
    })
  }
  function saveKendaraan(no, isi, field) {
    // console.log(no)
    // console.log(isi)
    // console.log(field)
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{no,isi,field},
      url:'saveKendaraan',
      cache: false,
      async: true,
      success: function(data){
        berhasil()
      },
      error: function(data){
        gagal()
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

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
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
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Departemen</label>
                    <select class="select2 form-control filter" id="filDepartemen">
                      <option value="">ALL</option>
                      <?php foreach ($departemen as $dep): ?>
                        <option value="<?=$dep->nm_dept?>"><?=$dep->nm_dept?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jabatan</label>
                    <select class="select2 form-control filter" id="filJabatan">
                      <option value="">ALL</option>
                      <?php foreach ($jabatan as $jab): ?>
                        <option value="<?=$jab->jabatan?>"><?=$jab->jabatan?></option>
                      <?php endforeach ?>
                      <option value="Sopir">Sopir</option>
                      <option value="Pendamping">Pendamping</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-1"></div>
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
            </div>
          </div>
          <div class="card card-outline card-gray">
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
    <div class="modal fade" id="modal-gambar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle"><span id="keteranganGambar"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <br>
            <div class="row">
              <div class="col-md-12">
                <div id="tampilGambar"></div>
              </div>
            </div>
            <br>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    $('.preloader').fadeOut('slow');
    getTabel();
    $('.filter').on('change', function(){
      getTabel();
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    })
    $('#getTabel').on('click','.getGambar', function(){
      
      var link = $(this).attr("data");
      var nama = $(this).attr("nama");
      var nik = $(this).attr("nik");
      
      Swal.fire({
        imageUrl: '<?=base_url()?>assets/image/foto-wajah/'+link,
        imageHeight: 300,
        imageAlt: nik+' - '+nama
      })
      
    });
    $('#getTabel').on('click','.btnVerif', function(){
      var nik = $(this).attr("nik");
      var data = $(this).attr("data");
      $.ajax({
        type:'post',
        data:{nik,data},
        dataType: 'json',
        url: 'verifKaryawan',
        cache: false,
        async: true,
        success: function(data){
          getTabel();
          berhasil();
        },
        error: function(data){
          gagal();
        }
      }); 
    });

  })
  function getTabel() {
    var filDepartemen = $('#filDepartemen').val();
    var filJabatan = $('#filJabatan').val();
    var filSearch = $('#filSearch').val();
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    $.ajax({
      type: 'get',
      data: {filDepartemen, filJabatan, filSearch},
      url:'getTabelApproveKaryawan',
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

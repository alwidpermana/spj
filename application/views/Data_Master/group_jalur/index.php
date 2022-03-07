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
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 pb-3">
                          <div id="form-group">
                            <input type="text" id="inputNamaGroup" class="form-control form-control-sm" placeholder="Masukkan Nama Jalur">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-danger btn-kps btn-sm btn-block btnTambahGroup ladda-button" id="btnTambahGroup" data-style="zoom-in">
                            <i class="fas fa-plus"></i> &nbsp; Tambah Group Jalur
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 kanban">
                  <div id="getGroup"></div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <form id="search">
                        <div class="form-group">
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Kota" style="font-size: 10px">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div id="loading">
                    Loading . . . . 
                  </div>
                  <br>
                  <br>
                  
                  <div id="getKota"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-jalur" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit Group Jalur</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" id="editIdJalur">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Jalur</label>
                  <input type="text" id="editNamaJalur" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps ladda-button updateJalur" data-style="zoom-in" id="updateJalur">Update</button>
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
    getKota();
    getGroup();
    $('#filSearch').on('keyup', function(){
      getKota();
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getKota();
    });
    var btnTambahGroup = $('.btnTambahGroup').ladda();
      btnTambahGroup.click(function () {
      // Start loading
      btnTambahGroup.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
      var inputNamaGroup = $('#inputNamaGroup').val();
      if (inputNamaGroup == '') {
        Swal.fire("Isi Terlebih Dahulu Nama Group Nya!", "Contoh: Group 1","warning");
      } else {
        $.ajax({
          type: 'post',
          dataType: 'json',
          data:{inputNamaGroup},
          url: 'tambahGroupJalur',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            getGroup();
            getKota();
          },
          error: function(data){
            gagal();
          }
        })
      }
        
        
      btnTambahGroup.ladda('stop');
      return false;
          
      }, 1000)
    });

    $('#getGroup').on('click','.editGroup', function(){
      var id = $(this).attr("data");
      var nama = $(this).attr("nama");
      $('#editIdJalur').val(id);
      $('#editNamaJalur').val(nama);
      $('#modal-jalur').modal("show")
    })
    var updateJalur = $('.updateJalur').ladda();
      updateJalur.click(function () {
      // Start loading
      updateJalur.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
      var editNamaJalur = $('#editNamaJalur').val();
      var editIdJalur = $('#editIdJalur').val();
      if (editNamaJalur == '') {
        Swal.fire("Isi Terlebih Dahulu Nama Group Nya!", "Contoh: Group 1","warning");
      } else {
        $.ajax({
          type: 'post',
          dataType: 'json',
          data:{editNamaJalur, editIdJalur},
          url: 'updateGroupJalur',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            getGroup();
            $('#modal-jalur').modal("hide")
          },
          error: function(data){
            gagal();
          }
        })
      }
      updateJalur.ladda('stop');
      return false;
          
      }, 1000)
    });

    $('#getKota').on('click', '.gantiGroupJalur', function(){
      var idKota = $(this).attr("kota");
      var group = $(this).attr("data");
      gantiJalur(idKota, group);
    })
    $('#getGroup').on('click','.gantiGroupJalur', function(){
      var idKota = $(this).attr("kota");
      var group = $(this).attr("data");
      gantiJalur(idKota, group);
    });

  })
  function getKota() {
    var filSearch = $("#filSearch").val();
    $.ajax({
      type: 'get',
      data:{filSearch},
      url:'getKotaNoGroupJalur',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('#loading').show();
      },
      success: function(data){
        $('#getKota').html(data);
      },
      complete: function(data){
        $('#loading').fadeOut("slow")
      },
      error: function(data){
        $('#getKota').html("error");
      }
    });
  }
  function getGroup() {
    $.ajax({
      type: 'get',
      url:'getGroupJalur',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getGroup').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut("slow");
      },
      error: function(data){
        $('#getGroup').html("");
      }
    })
  }
  
  function gantiJalur(kota, group) {
    $.ajax({
      type:'post',
      dataType:'json',
      data:{kota, group},
      url:'gantiGroupJalur',
      cache: false,
      async: true,
      success: function(data){
        berhasil()
        getKota()
        getGroup()
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

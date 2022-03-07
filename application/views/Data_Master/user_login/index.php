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
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-kps btn-block btn-sm" id="btnTambahAkun" data-toggle="modal" data-target="#modal-tambahAkun">
                          <i class="fas fa-user-plus"></i>
                          &nbsp;&nbsp;Tambah Akun
                        </button>
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
     <!-- Modal -->
    <div class="modal fade" id="modal-tambahAkun" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Akun</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Karyawan</label>
                  <select class="select2 form-control" id="inputNIK" style="width: 100%">
                    <option value="">Cari Karyawan</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer getDataKaryawan">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-kps ladda-button saveAkun" data-style="expand-right" id="btnSaveAkun">Tambah Akun</button>
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
    $("#inputNIK").select2({
      ajax: { 
        url: 'getKaryawanAdmin',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
              cari: params.term // search term
            };
        },
        processResults: function (response) {
            return {
               results: response
            };
            console.log(response)

        },
        cache: true
      }
    });

    var saveAkun = $('.saveAkun').ladda();

    saveAkun.click(function () {
        // Start loading
        saveAkun.ladda('start');

        // Timeout example
        // Do something in backend and then stop ladda
        setTimeout(function () {
            var nik = $('#inputNIK').val();
            if (nik == '') {
              Swal.fire("Pilih Terlebih Dahulu Karyawan nya!","Data Tidak Bisa di Save Saat Karyawan Belum Dipilih","warning")
              saveAkun.ladda('stop');
            }else{
              $.ajax({
                type:"POST",
                data:{nik},
                url: 'tambahAkun',
                dataType: "JSON",
                cache: false,
                async: false,
                success: function(data){
                  saveAkun.ladda('stop');
                  Swal.fire("Berhasil Menambah Akun","Password untuk Login adalah default yaitu 123","success")
                  $('#modal-tambahAkun').modal('hide');
                  getTabel();
                },
                error: function(data){
                  Swal.fire("Gagal Menyimpan Data!",'Hubungi Staff IT!','error');
                  saveAkun.ladda('stop');
                }
              }) 
            }
            
            return false;
            // 
        }, 1000)
    });

    $('#getTabel').on('change','#editStatusAktif', function(){
      var nik = $(this).attr('nik');
      var status = $(this).val();
      $.ajax({
        type:"POST",
        data:{nik,status},
        dataType:'JSON',
        url:"ubahStatusAkun",
        cache: false,
        async: true,
        success: function(){
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'success',
            title: 'Status Berhasil Diubah',
            showConfirmButton: false,
            timer: 1500
          })
        },
        error: function(){
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'error',
            title: 'Status Gagal Diubah! Hubungi Staff IT',
            showConfirmButton: false,
            timer: 1500
          })
        }
      })
    });
    $('#getTabel').on('change', '#editLevel', function(){
      var nik = $(this).attr('nik');
      var level = $(this).val();
      $.ajax({
        type:"POST",
        data:{nik,level},
        dataType:'JSON',
        url:"ubahLevelAkun",
        cache: false,
        async: true,
        success: function(){
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'success',
            title: 'Level Berhasil Diubah',
            showConfirmButton: false,
            timer: 1500
          })
        },
        error: function(){
          Swal.fire({
            position: 'top-end',
            toast : true,
            icon: 'error',
            title: 'Level Gagal Diubah! Hubungi Staff IT',
            showConfirmButton: false,
            timer: 1500
          })
        }
      })
    });

  })
  
  function getTabel() {
    var gagal = '<div class="alert alert-danger alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    var filSearch = $('#filSearch').val();
    $.ajax({
      type:'post',
      data: {filSearch},
      url: 'getTabelUserLogin',
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
    });
  }
  

</script>
<!-- FootJS -->
</body>
</html>

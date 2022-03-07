

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .labelProfile{
      padding-top: 6px;
      font-size: 16px;
    }
    .lingkaran{
      width: 150px;
      height: 150px;
      border-radius: 100%;
      padding-top: 5px;
      padding-left: 5px;
      padding-bottom: 50px;
      padding-right: 50px;
    }
    .fotoLingkaran{
      width: 140px;
      height: 140px;
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
        <?php foreach ($data as $key): ?>
          <div class="row">
            <div class="col-md-3">
              <div class="card shadow-lg">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <img src="<?=base_url()?>assets/image/avatar/<?=$key->FOTO?>" class="img-circle elevation-2" alt="User Image" width="150px" height="150px">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <button type="button" class="btn btn-danger btn-kps btn-sm" id="btnEditFoto">
                        Edit Avatar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card shadow-lg">
                <div class="card-header">
                  <div class="card-title">Pengaturan Profile</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">NIK</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputNik" class="form-control" readonly value="<?=$key->NIK?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Nama Karyawan</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputNama" class="form-control" readonly value="<?=$key->namapeg?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Jabatan</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputJabatan" class="form-control" readonly value="<?=$key->jabatan?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Departemen</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputDepartemen" class="form-control" readonly value="<?=$key->departemen?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Sub Departemen</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputSubDepartemen" class="form-control" readonly value="<?=$key->subdepartemen?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Divisi</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputDivisi" class="form-control" readonly value="<?=$key->divisi?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Seksie</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" id="inputSeksi" class="form-control" readonly value="<?=$key->seksi?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label class="labelProfile">Password</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <input type="password" id="inputPassword" class="form-control" value="<?=$key->PASSWORD?>">
                      </div>
                    </div>
                  </div>
                  <div class="row verifikasi">
                    <div class="col-md-4">
                      <label class="labelProfile">Verifikasi Password</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <input type="password" id="inputVerifikasi" class="form-control">
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <button type="button" class="btn btn-danger btn-kps btn-block ladda-button" id="btnSavePassword" data-style="zoom-in">Save</button>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-editFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Avatar Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="inputAvatar">
            <div class="row">
              <div class="col-md-3"></div>
              <?php foreach ($avatar as $ava): ?>
                <?php if ($ava->ID == '1' || $ava->ID == '2'): ?>
                  <div class="col-md-3 text-center">
                    <div id="<?=$ava->ID?>" class="text-center lingkaran">
                      <a href="javascript:;" class="btnLingkaran" data="<?=$ava->ID?>" avatar="<?=$ava->AVATAR?>">
                        <img src="<?=base_url()?>assets/image/avatar/<?=$ava->FOTO?>" class="img-circle elevation-2 fotoLingkaran" alt="User Image">
                      </a>
                    </div>
                  </div>    
                <?php endif ?>
              <?php endforeach ?>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3"></div>
              <?php foreach ($avatar as $ava): ?>
                <?php if ($ava->ID == '3' || $ava->ID == '4'): ?>
                  <div class="col-md-3 text-center">
                    <div id="<?=$ava->ID?>" class="text-center lingkaran">
                      <a href="javascript:;" class="btnLingkaran" data="<?=$ava->ID?>" avatar="<?=$ava->AVATAR?>">
                        <img src="<?=base_url()?>assets/image/avatar/<?=$ava->FOTO?>" class="img-circle elevation-2 fotoLingkaran" alt="User Image">
                      </a>
                    </div>
                  </div>    
                <?php endif ?>
              <?php endforeach ?>
            </div>
          </div>
          <div class="modal-footer getDataKaryawan">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-kps ladda-button btnSaveAvatar" data-style="expand-right" id="btnSaveAvatar">Save</button>
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
    $('.load-modal').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();

   $('#btnEditFoto').on('click', function(){
    $('#modal-editFoto').modal('show');
   });
   $('.btnLingkaran').on('click', function(){
    var id = $(this).attr("data");
    var avatar = $(this).attr("avatar");
    $('#inputAvatar').val(avatar);
    if (id=='1') {
      $('#1').addClass('bg-kps');
      $('#2').removeClass('bg-kps');
      $('#3').removeClass('bg-kps');
      $('#4').removeClass('bg-kps');
    }else if(id=='2'){
      $('#1').removeClass('bg-kps');
      $('#2').addClass('bg-kps');
      $('#3').removeClass('bg-kps');
      $('#4').removeClass('bg-kps');
    }else if(id=='3'){
      $('#1').removeClass('bg-kps');
      $('#2').removeClass('bg-kps');
      $('#3').addClass('bg-kps');
      $('#4').removeClass('bg-kps');
    }else{
      $('#1').removeClass('bg-kps');
      $('#2').removeClass('bg-kps');
      $('#3').removeClass('bg-kps');
      $('#4').addClass('bg-kps');
    }
   })

   var btnSaveAvatar = $('.btnSaveAvatar').ladda();
      btnSaveAvatar.click(function () {
      // Start loading
      btnSaveAvatar.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
          var inputAvatar = $('#inputAvatar').val();
          if (inputAvatar == '') {
            Swal.fire("Pilih Avatar Terlebih Dulu!","","warning")
          } else {
            $.ajax({
              type: 'post',
              dataType: 'json',
              data:{inputAvatar},
              url:'updateAvatar',
              cache:true,
              async: true,
              success: function(data){
                berhasil()
                $('#modal-editFoto').modal('hide');
              },
              error: function(){
                gagal();
              }
            })
          }
          btnSaveAvatar.ladda('stop');
          return false;
          
      }, 1000)
    });
    $('.verifikasi').addClass('d-none');
    $('#inputPassword').on('keyup', function(){
      $('.verifikasi').removeClass('d-none');
      cekPassword();
    });
    $('#inputVerifikasi').on('keyup', function(){
      cekPassword();
    })

    var btnSavePassword = $('#btnSavePassword').ladda();
      btnSavePassword.click(function () {
      // Start loading
      btnSavePassword.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
          var inputPassword = $('#inputPassword').val();
          if (inputPassword == '') {
            Swal.fire("Isi Passwordnya Terlebih Dahulu!","","warning")
          } else {
            $.ajax({
              type: 'post',
              dataType: 'json',
              data:{inputPassword},
              url:'updatePassword',
              cache:true,
              async: true,
              success: function(data){
                $('.verifikasi').addClass('d-none');
                $('#inputVerifikasi').val("");
                berhasil()
              },
              error: function(){
                gagal();
              }
            })
          }
          btnSavePassword.ladda('stop');
          return false;
          
      }, 1000)
    });


  })
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

    function cekPassword() {
      var password = $('#inputPassword').val();
      var verifikasi = $('#inputVerifikasi').val();
      if (password == '') {
        $('#inputVerifikasi').addClass("is-invalid");
        $('#inputPassword').addClass("is-invalid");
        $('#btnSavePassword').attr("disabled","disabled");
      }else{
        $('#inputPassword').removeClass("is-invalid");
        if (password != verifikasi) {
          $('#inputVerifikasi').addClass("is-invalid");
          $('#inputVerifikasi').removeClass("is-valid");
          $('#btnSavePassword').attr("disabled","disabled");
          
        } else {
          $('#inputVerifikasi').removeClass("is-invalid");
          $('#inputVerifikasi').addClass("is-valid");
          $('#btnSavePassword').removeAttr("disabled","disabled");
        }
      }
    }
  

</script>
<!-- FootJS -->
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/Croppie-master/croppie.css" />
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .cardGalery{
      background: #FFFFFF;
      box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.15);
      border-radius: 20px;
    }
    .toolKPS:hover{
      color: rgb(178, 58, 72);

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
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-danger btn-kps" id="btnUpload" data-toggle="modal" data-target="#modal-foto">
              <i class="fas fa-file-upload"></i> Upload Gambar Kendaraan
            </button>
          </div>
          <br>
          <br>
          <div id="getGambar"></div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Upload Foto Kendaraan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="submitFoto">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <select class="select2 form-control cekKosong" id="inputJenis">
                        <option value="Depan">Depan</option>
                        <option value="Belakang">Belakang</option>
                        <option value="Kiri">Kiri</option>
                        <option value="Kanan">Kanan</option>
                        <option value="Interior">Interior</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input form-control-sm cekKosong" id="fileKTP" name="fileKTP" accept=".png, .jpg, .jpeg">
                        <label class="custom-file-label" for="fileKTP">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="uploadImageFotoKartu" class="d-none">
                        <div id="image_demo2"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger btn-kps saveFoto" id="saveFoto">Tambah Foto</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php $this->load->view('_partial/footer');?>
</div>
<?php $this->load->view("_partial/js");?>
<script src="<?= base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url()?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.js"></script>
<script src="<?= base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/Croppie-master/croppie.js"></script>
<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    getGambar();
    cekKosong()
    $('.preloader').fadeOut('slow');
    $image_crop2 = $('#image_demo2').croppie({
      enableExif: true,
      viewport: {
        width:320,
        height:200,
        type:'square' //circle
      },
      boundary:{
        width:350,
        height:300
      }
    });

    $('.cekKosong').on('change', function(){
      cekKosong();
    })

    $('#fileKTP').on('change', function(){
      var reader = new FileReader();
      reader.onload = function (event) {
        $image_crop2.croppie('bind', {
          url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(this.files[0]);
      $('#uploadImageFotoKartu').removeClass("d-none");
      cekKosong();
    });
    $('#submitFoto').submit(function(e){
      e.preventDefault();
      var file = $('#fileKTP')[0];
      var info_file = file.files[0];
      var nama = info_file.name;
      var size = info_file.size;
      var type = info_file.type;
      if (size > 1000000) {
          Swal.fire("Ukuran Terlalu Besar!","Upload File Dengan Ukuran Kurang Dari 1 Mb",'error')
        }else if(nama.length>255){
          Swal.fire("Nama File Terlalu Panjang!","Re-name terlebih dahulu nama file",'error')
        }else if(type != 'application/pdf' && type != 'image/png' && type != 'image/jpeg' && type != 'image/jpg'){
          Swal.fire("Format File Tidak Valid","Masukan file dengan format .png, .jpg, atau .jpeg",'error')
        }else{
          $image_crop2.croppie('result', {
              type: 'canvas',
              size: 'viewport'
          }).then(function(response) {
              uploadGambar(response)
          });
           
        }
    });
    $('#getGambar').on('click', '.btnHapus', function(){
      var id = $(this).attr("data");
      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Menghapus Gambar Kendaraan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Hapus Gambar Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
                type : "get",
                url  : url+"/Data_Master/hapusGambarKendaraan",
                data :{id:id},
                async : false,
                dataType: "JSON",
                
                success: function(data){
                       berhasil();
                       getGambar();
                        // $('#prosesEditTooling').modal('show');

                        // alert('berhasil');
                },
                error: function(data){
                        gagal();
                }
            });

          
        }
      })
    });

  })
  function cekKosong() {
    var inputJenis = $('#inputJenis').val();
    var gambar = $('#fileKTP').val();
    if (inputJenis == '' || gambar == '') {
      $('#saveFoto').attr("disabled","disabled");
    }else{
      $('#saveFoto').removeAttr("disabled","");
    }
  }
  function getGambar() {
    var noTNBK = '<?=$this->uri->segment("3")?>';
    $.ajax({
      type:'get',
      data:{noTNBK},
      url:url+'/Data_Master/getGaleriKendaraan',
      cache: false,
      async: true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getGambar').html(data);

      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error: function(data){
        
      }
    })
  }
  function uploadGambar(response) {
    var noTNBK = '<?=$this->uri->segment("3")?>';
    var inputJenis = $('#inputJenis').val();
    $.ajax({
        url: url+"/Data_Master/uploadKendaraan",
        type: 'POST',
        dataType: 'json',
        data: {
            "image": response,
            noTNBK,
            inputJenis
        },
        success: function(data) {
            berhasil();
            $('#saveFoto').attr("disabled","disabled");
            $('#uploadImageFotoKartu').addClass("d-none");
            $('#modal-foto').modal("hide");
            getGambar();
        },
        error: function(data){
            gagal();
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
        timer: 1500
      })
    }

    function gagal() {
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'error',
        title: 'Gagal Menyimpan Data! Hubungi Staff IT',
        showConfirmButton: false,
        timer: 1500
      })
    }
  

</script>
<!-- FootJS -->
</body>
</html>

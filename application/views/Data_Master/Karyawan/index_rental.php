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
                    <label>Jabatan</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="Sopir">Sopir</option>
                      <option value="Pendamping">Pendamping</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="select2 filter form-control select2-orange" data-dropdown-css-class="select2-orange" id="filAktif">
                      <option value="">ALL</option>
                      <option value="Aktif">Aktif</option>
                      <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2"></div>
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
                <div class="col-md-2 col-sm-4">
                  <a href="javascript:;" class="btn bg-orange btn-kps btn-block btnTambah" id="btnTambah">
                    <i class="fas fa-plus"></i> &nbsp; Tambah PIC
                  </a>
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

    <div class="modal fade" id="modal-foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="fotoWajah"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIK</label>
                  <input type="text" id="inputNIK" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" id="inputNama" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" id="inputAlamat" rows="1"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No Telepon</label>
                  <input type="text" id="inputTlp" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>No KTP</label>
                  <input type="text" id="inputKTP" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jabatan</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJabatan">
                    <option value="Sopir">Sopir</option>
                    <option value="Pendamping">Pendamping</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-orange btn-kps ladda-button saveData" id="saveData" data-style="expand-right">Save</button>
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
    getTabel();
    $('.filter').on('change', function(){
      getTabel();
    });
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    });
    $('#getTabel').on('click', '.getGambar', function(){
      var foto = $(this).attr("data");
      var html="";
      html+='<img src="<?=base_url()?>assets/image/foto-wajah/'+foto+'" class="img-thumbnail rounded mx-auto d-block">';
      $('#fotoWajah').html(html);
      console.log(html)
      $('#modal-foto').modal("show");
    });
    $('#btnTambah').on('click', function(){
      $('#modal-tambah').modal("show")
      getNIK();
    })
    var saveData = $('.saveData').ladda();
      saveData.click(function () {
      // Start loading
      saveData.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNIK = $('#inputNIK').val();
        var inputNama = $('#inputNama').val();
        var inputAlamat = $('#inputAlamat').val();
        var inputTlp = $('#inputTlp').val();
        var inputKTP = $('#inputKTP').val();
        var inputJabatan = $('#inputJabatan').val();
        if (inputNIK == '') {
          Swal.fire("NIK Tidak Diketahui","Mohon Hubungi Staff IT","warning");
          saveData.ladda('stop');
        }else if(inputNama == ''){
          Swal.fire("Mohon Lengkapi Datanya terlebih dahulu","Nama masih kosong","info")
          saveData.ladda('stop');
        }else if(inputAlamat == ''){
          Swal.fire("Mohon Lengkapi Datanya terlebih dahulu","Alamat masih kosong","info")
          saveData.ladda('stop');
        }else if(inputTlp == ''){
          Swal.fire("Mohon Lengkapi Datanya terlebih dahulu","Nomor Telepon masih kosong","info")
          saveData.ladda('stop');
        }else if (inputKTP == '') {
          Swal.fire("Mohon Lengkapi Datanya terlebih dahulu","KTP masih kosong","info")
          saveData.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            data:{inputNama, inputAlamat, inputTlp, inputKTP, inputJabatan},
            dataType:'json',
            url:url+'/index.php/Data_Master/savePIC_Rental',
            cache:false,
            async:true,
            beforeSend:function(data){
              $('.saveData').attr("disabled","disabled")
            },
            success:function(data){
              window.location = url+'/'+data.url;
            },
            complete:function(data){
              $('.saveData').removeAttr("disabled","disabled")
              saveData.ladda('stop');
            },
            error:function(data){
              Swal.fire("Gagal Menyimpan Data","Hubungi Staff IT","error");
            }
          })
        }
        return false;
      }, 500)
    });

  })
  function getTabel() {
    var filStatus = $('#filStatus').val();
    var filSearch = $('#filSearch').val();
    var filAktif = $('#filAktif').val();
    var gagal = '<div class="alert alert-danger bg-kps alert-dismissible">';
        gagal +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        gagal +='<h5><i class="icon fas fa-ban"></i>Gagal Meload Data!</h5>';
        gagal +='Lakukan Refresh pada Halaman Ini! Jika Masih Error Mohon Untuk Hubungi Staff IT!';
        gagal +='</div>';
    var jenis = 'rental';
    $.ajax({
      type: 'get',
      data: {filStatus, filSearch, jenis, filAktif},
      url:'tabelRental',
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
  function getNIK() {
    $.ajax({
      type:'get',
      dataType:'json',
      url:url+'/data_master/getNIK_Rental',
      cache:false,
      async:true,
      success:function(data){
        $('#inputNIK').val(data);
      },
      error:function(data){
        $('#inputNIK').val("")
      }
    })
  }
  

</script>
<!-- FootJS -->
</body>
</html>

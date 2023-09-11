<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
                    <div class="col-md-2 col-sm-4">
                      <button type="button" class="btn btn-kps bg-orange btn-block" id="btnTambahRekanan">
                        Tambah Rekanan
                      </button>
                    </div>
                    <div class="col-md-4 col-sm-2"></div>
                    <div class="col-6">
                      <form id="search">
                        <div class="form-group">
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No Inventaris, No TNKB atau Kepemilikan">
                        </div>
                      </form>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabelRekanan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-rekanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputIdRekanan">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Rekanan</label>
                  <input type="text" id="inputKode" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" id="inputNama" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" id="inputAlamat" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group clearfix">
                  <label>Berbadan Hukum?</label><br>
                  <div class="icheck-orange d-inline">
                    <input type="radio" id="hukumY" name="radioHukum" value="Y" checked>
                    <label for="hukumY"> Ya
                    </label>
                  </div>
                  <br>
                  <br>
                  <div class="icheck-orange d-inline">
                    <input type="radio" id="hukumN" name="radioHukum" value="N">
                    <label for="hukumN">
                      Tidak
                    </label>
                  </div>
                </div>
                <input type="hidden" id="inputBerbadanHukum" value="Y">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>NPWP/NIK</label>
                  <input type="text" id="inputNPWP" class="form-control form-control-sm">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveRekanan ladda-button" data-style="expand-right" step="1">Save</button>
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
    
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getTabelRekanan();
    $('#btnTambahRekanan').on('click', function(){
      $('#modal-rekanan').modal("show")
      $('#inputIdRekanan').val("");
      setKodeRekanan();
    });
    var saveRekanan = $('.saveRekanan').ladda();
      saveRekanan.click(function () {
      // Start loading
      saveRekanan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNama = $('#inputNama').val();
        var inputAlamat = $('#inputAlamat').val();
        var inputIdRekanan = $('#inputIdRekanan').val();
        var inputBerbadanHukum = $('#inputBerbadanHukum').val();
        var inputNPWP = $('#inputNPWP').val();
        if (inputNama == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Nama Masih Kosong","warning");
          saveRekanan.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            data:{inputNama, inputAlamat, inputIdRekanan, inputBerbadanHukum, inputNPWP},
            dataType:'json',
            cache:false,
            async:true,
            url:url+'/data_master/saveRekanan',
            beforeSend:function(data){

            },
            success:function(data){
              berhasil()
              getTabelRekanan();
              $('#modal-rekanan').modal("hide")
              $('#inputNama').val("");
              $('#inputAlamat').val("");
            },
            complete:function(data){
              saveRekanan.ladda('stop');
            },
            error:function(data){
              gagal()
            }
          }); 
        }
        
        
        
        return false;
      }, 1000)
    });
    $('#getTabelRekanan').on('click','.editRekanan', function(){
      var id = $(this).attr("data");
      var kode = $(this).attr("kode")
      var nama = $(this).attr("nama")
      var alamat = $(this).attr("alamat")
      var hukum = $(this).attr("hukum")
      var npwp = $(this).attr('npwp')
      $('#inputKode').val(kode)
      $('#inputNama').val(nama)
      $('#inputAlamat').val(alamat)
      $('#inputIdRekanan').val(id)
      $('#inputBerbadanHukum').val(hukum);
      $('#inputNPWP').val(npwp);
      if (hukum == 'Y') {
        $('[name="radioHukum"]#hukumY').attr("checked","checked");
        $('[name="radioHukum"]#hukumN').removeAttr("checked","checked");
        
      }else{
        $('[name="radioHukum"]#hukumY').removeAttr("checked","checked");
        $('[name="radioHukum"]#hukumN').attr("checked","checked");
      }
      
      $('#modal-rekanan').modal("show")
    })
    $('#getTabelRekanan').on('change','#inputStatus', function(){
      var id = $(this).attr("data");
      var status = $(this).val();
      $.ajax({
        type:'post',
        data:{id,status},
        dataType:'json',
        url:url+'/data_master/updateStatusRekanan',
        cache: false,
        async:true,
        success: function(data){
          berhasil()
        },
        error:function(data){
          gagal()
        }
      })
    })
    $('[name="radioHukum"]').on('click', function(){
      var isi = $(this).val();
      $('#inputBerbadanHukum').val(isi)
    });

  })
  function getTabelRekanan() {
    var filSearch = $('#filSearch').val();
    var jenis = 'master';
    $.ajax({
      type:'get',
      url:url+'/data_master/getDataRekanan',
      data:{jenis},
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getTabelRekanan').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        $('#getTabelRekanan').html("Gagal Meload Data");
      }
    })
  }
  function setKodeRekanan() {
    $.ajax({
      type:'get',
      url:url+'/data_master/setKodeRekanan',
      cache:false,
      async:true,
      dataType:'json',
      success:function(data){
        $('#inputKode').val(data);
      },
      error:function(data){
        $('#inputKode').val("error")
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

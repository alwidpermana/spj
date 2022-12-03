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
                <div class="col-1">
                  <div class="form-group">
                    <label>Tampil</label>
                    <select class="form-control select2 filter" id="filLimit">
                      <option value="10">10</option>
                      <option value="100">100</option>
                      <option value="250">250</option>
                      <option value="500">500</option>
                      <option value="750">750</option>
                      <option value="1000">1000</option>
                    </select>
                  </div>
                </div>
                <div class="col-5"></div>
                <div class="col-6">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan Nama Customer">
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="preloader-no-bg">
                    <div class="loader">
                        <div class="spinner"></div>
                        <div class="spinner-2"></div>
                    </div>
                  </div>
                  <div id="getTabel"></div>
                </div>
              </div>
              <br>
              <div class="row">
                <input type="hidden" id="inputOffset">
                <div class="col-md-12 d-flex justify-content-end">
                  <div id="paging"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-abnormal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <input type="hidden" id="inputSerlokID">
            <input type="hidden" id="inputKodeSerlok">
            <input type="hidden" id="inputDeliveryID">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Customer</label>
                  <input type="text" id="inputNama" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Biaya Abnormal</label>
                  <input type="number" id="inputBiaya" class="form-control form-control-sm">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-orange btn-kps ladda-button saveAbnormal" data-style="expand-right" id="saveAbnormal">Save</button>
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
    paging(1);
    $('#paging').on('click','.paging', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      paging(offset)
      $('#inputOffset').val(offset);
    });
    $('.filter').on('change', function(){
      paging(1);
    });
    $('#search').submit(function(e){
      e.preventDefault();
      paging(1);
    })
    $('#paging').on('click','.btnStep', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      paging(offset)
      $('#inputOffset').val(offset);
    })
    $('#getTabel').on('click','.pilihCustomer', function(){
      var nama = $(this).attr("nama");
      var biaya = $(this).attr("biaya");
      var serlokID = $(this).attr("serlokID");
      var kodeSerlok = $(this).attr("kodeSerlok")
      var deliveryId = $(this).attr("deliveryId");
      $('#inputNama').val(nama)
      $('#inputBiaya').val(biaya)
      $('#inputSerlokID').val(serlokID)
      $('#inputKodeSerlok').val(kodeSerlok)
      $('#inputDeliveryID').val(deliveryId)
      $('#modal-abnormal').modal("show");
    });
    var saveAbnormal = $('.saveAbnormal').ladda();
      saveAbnormal.click(function () {
      // Start loading
      saveAbnormal.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputSerlokID = $('#inputSerlokID').val();
        var inputKodeSerlok = $('#inputKodeSerlok').val();
        var inputBiaya = $('#inputBiaya').val();
        var inputDeliveryID = $('#inputDeliveryID').val();
        var inputOffset = $('#inputOffset').val();
        $.ajax({
          type:'post',
          data:{inputSerlokID, inputKodeSerlok, inputBiaya, inputDeliveryID},
          dataType:'json',
          cache:false,
          async:true,
          url:url+'/data_master/saveBiayaAbnormal',
          beforeSend:function(data){
            $('.saveAbnormal').attr("disabled","disabled")
          },
          success:function(data){
            berhasil();
            paging(inputOffset)
            $('#modal-abnormal').modal("hide")
          },
          complete:function(data){
            $('.saveAbnormal').removeAttr("disabled","disabled")
            saveAbnormal.ladda('stop');
          },
          error:function(data){
            gagal()
          }
        })
        
        
        return false;
          
      }, 1000)
    });

  })
  
  function getTabel(offset, limit, filSearch) {
    $.ajax({
      type:'get',
      data:{offset, limit, filSearch},
      url:url+'/data_master/getBiayaAbnormal',
      cache:false,
      async:true,
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getTabel').html(data)
      },
      complete:function(data){
        $('.preloader-no-bg').fadeOut('slow');
      },
      error:function(data){
        $('#getTabel').html("Gagal Mengambil Data")
      }
    })
  }
  function paging(offset) {
    var filSearch = $('#filSearch').val();
    var limit = $('#filLimit').val();
    $.ajax({
      type:'get',
      data:{filSearch, limit, offset},
      url:'getPaggingAbnormal',
      cache:false,
      async:true,
      success: function(data){
        $('#paging').html(data);
        var endOffset = offset == ''?0:(offset-1)*limit;
        getTabel(endOffset, limit, filSearch)
      },
      error: function(data){

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

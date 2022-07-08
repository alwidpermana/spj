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
                <div class="col-md-12">
                  <div id="getTabel"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-credit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>No SPJ</label>
                  <input type="text" id="inputNoSPJ" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>No Voucher</label>
                  <input type="text" id="inputNoVoucher" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Biaya</label>
                  <input type="number" id="inputBiaya" class="form-control form-control-sm">
                  <input type="hidden" id="inputBiayaAwal">
                </div>
              </div>
            </div>
            <input type="hidden" id="inputId">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-orange btn-kps ladda-button saveDebit" data-style="expand-right" id="saveDebit">Save</button>
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

    // $('.preloader').fadeOut('slow');
    getTabel();
    $('#getTabel').on('click', '.getVoucher', function(){
      var noVoucher = $(this).attr("noVoucher");
      var noSPJ = $(this).attr("noSPJ");
      var idSPJ = $(this).attr("idSPJ");
      var credit = $(this).attr("credit");
      var uangBBM = $(this).attr("uangBBM");
      $('#inputId').val(idSPJ);
      $('#inputNoSPJ').val(noSPJ);
      $('#inputNoVoucher').val(noVoucher);
      $('#inputBiaya').val(credit)
      $('#inputBiayaAwal').val(uangBBM);
      document.getElementById("inputBiaya").focus()
      $('#modal-credit').modal("show")
      
    });
    var saveDebit = $('.saveDebit').ladda();
      saveDebit.click(function () {
      // Start loading
      saveDebit.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNoSPJ= $('#inputNoSPJ').val();
        var inputBiaya = $('#inputBiaya').val();
        var inputNoVoucher =$('#inputNoVoucher').val();
        var inputId = $('#inputId').val();
        var inputBiayaAwal = $('#inputBiayaAwal').val();
        if (parseInt(inputBiaya)>0) {
          $.ajax({
            type:'post',
            data:{inputNoSPJ, inputBiaya, inputNoVoucher, inputId, inputBiayaAwal},
            cache: false,
            async: true,
            dataType:'json',
            url:'saveNominalVoucherBBM',
            success: function(data){
              berhasil()
              getTabel();
              $('#modal-credit').modal("hide")
            },
            error: function(data){
              gagal();
            }
          });
        }else{
          Swal.fire('Masukan Jumlah Biaya Voucher BBM Lebih dari Rp. 0!','','warning');
        }
        saveDebit.ladda('stop');
        return false;
          
      }, 1000)
    });


  })
    function getTabel() {
      $.ajax({
        type: 'get',
        url:'getMonVoucherBBM',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.preloader').show();
        },
        success: function(data){
          $('#getTabel').html(data);
        },
        complete: function(data){
          $('.preloader').fadeOut('slow');
        },
        error: function(data){
          $('#getTabel').html(data);
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

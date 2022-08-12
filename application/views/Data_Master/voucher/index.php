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
                    <label>Status</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="1">Telah Digunakan</option>
                      <option value="2">Belum Digunakan</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No Voucher">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <!-- <div class="row">
                <div class="col-md-2">
                  <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnTambah">
                    <i class="fas fa-plus"></i>&nbsp; Voucher BBM
                  </button>
                </div>
              </div> -->
              <!-- <br> -->
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
    <div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <input type="hidden" id="inputId">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>No Voucher</label>
                      <input type="text" id="inputVoucher" class="form-control form-control-sm" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Rp.</label>
                      <input type="number" id="inputRp" class="form-control form-control-sm" step="1">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-orange btn-kps ladda-button saveVoucher" data-style="expand-right" id="saveVoucher">Save</button>
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
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel();
   $('.filter').on('change', function(){
    getTabel();
   });
   $('#search').submit(function(e){
    e.preventDefault();
    getTabel();
   });
   $('#btnTambah').on('click', function(){
      $.ajax({
        url:'getNoVoucher',
        type:'get',
        dataType: 'json',
        async: true,
        cache: false,
        success: function(data){
          $('#inputVoucher').val(data.voucher);
          $('#inputRp').val("");
          $('#modal-voucher').modal("show");
        },
        error: function(data){
          Swal.fire("Gagal Mengambil Nomor Voucher","Reload Halaman Ini Terlebih Dahulu atau Hubungi Staff IT","error");
          $('#modal-voucher').modal("hide");
        }
      })
   });

   var saveVoucher = $('.saveVoucher').ladda();
      saveVoucher.click(function () {
      // Start loading
      saveVoucher.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputVoucher = $('#inputVoucher').val();
        var inputRp = $('#inputRp').val();
        var inputId = $('#inputId').val();
        $.ajax({
          type:'post',
          dataType: 'json',
          data: {inputVoucher, inputRp, inputId},
          cache: false,
          async: true,
          url:'saveVoucherBBM',
          success: function(data){
            berhasil();
            getTabel();
            $('#modal-voucher').modal('hide')
            $('#inputId').val("");
          },
          error: function(data){
            gagal();
          }
        });
        saveVoucher.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('#getTabel').on('click','.edit', function(){
      var noVoucher = $(this).attr("noVoucher");
      var voucher_id = $(this).attr("voucher_id");
      var rp = $(this).attr("rp");
      $('#inputId').val(voucher_id);
      $('#inputVoucher').val(noVoucher);
      $('#inputRp').val(rp);
      $('#modal-voucher').modal("show")
    });
    $('#getTabel').on('click','.hapus', function(){
      var noVoucher = $(this).attr("noVoucher");
      var voucher_id = $(this).attr("voucher_id");
      Swal.fire({
        title: 'Apakah Kamu Yakin Menghapus Voucher ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Hapus Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
                type : "POST",
                url  : "hapusVoucherBBM",
                data :{noVoucher, voucher_id},
                async : false,
                cache: false,
                dataType: "JSON",
                success: function(data){
                  berhasil()
                  getTabel()
                },
                error: function(data){
                  gagal();
                }
            });

          
        }
      })
    });

  })
  function getTabel() {
    var filStatus = $('#filStatus').val();
    var filSearch = $('#filSearch').val();
    $.ajax({
      type:'get',
      data:{filStatus,filSearch},
      url:'getTabelVoucherBBM',
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
        $('#getTabel').html("error");
      }
    });
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

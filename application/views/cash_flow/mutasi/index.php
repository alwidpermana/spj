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
                  <button type="button" class="btn bg-orange btn-kps btn-block" id="btnMutasi">
                    Mutasi Sub Kas
                  </button>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                    <div id="getTabel"></div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-mutasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputID" name="inputID">
            <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <label>Dari Sub Kas</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputDari">
                    <option value="Kasbon SPJ Delivery">Kasbon SPJ Delivery</option>
                    <option value="Kasbon SPJ Non Delivery">Kasbon SPJ Non Delivery</option>
                    <option value="Kasbon TOL Delivery">Kasbon TOL Delivery</option>
                    <option value="Kasbon TOL Non Delivery">Kasbon TOL Non Delivery</option>
                    <option value="Kasbon Voucher BBM">Kasbon Voucher BBM Rest Area</option>
                    <option value="Kasbon Voucher BBM Katulistiwa">Kasbon Voucher BBM Katulistiwa</option>
                    <option value="Kasbon BBM Delivery">Kasbon BBM Delivery</option>
                    <option value="Kasbon BBM Non Delivery">Kasbon BBM Non Delivery</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <label>Ke Sub Kas</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKe" name="inputKe">
                    <option value="Kasbon SPJ Delivery">Kasbon SPJ Delivery</option>
                    <option value="Kasbon SPJ Non Delivery">Kasbon SPJ Non Delivery</option>
                    <option value="Kasbon TOL Delivery">Kasbon TOL Delivery</option>
                    <option value="Kasbon TOL Non Delivery">Kasbon TOL Non Delivery</option>
                    <option value="Kasbon Voucher BBM">Kasbon Voucher BBM Rest Area</option>
                    <option value="Kasbon Voucher BBM Katulistiwa">Kasbon Voucher BBM Katulistiwa</option>
                    <option value="Kasbon BBM Delivery">Kasbon BBM Delivery</option>
                    <option value="Kasbon BBM Non Delivery">Kasbon BBM Non Delivery</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Rp.</label>
                  <input type="number" id="inputRP" name="inputRP" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps ladda-button" data-style="expand-right" id="btnSaveMutasi">Save</button>
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
    $('#btnMutasi').on('click', function(){
      $('#modal-mutasi').modal("show")
      $('#inputID').val("")
    })
    $('#btnSaveMutasi').on('click', function(){
      var inputID = $('#inputID').val();
      var inputDari = $('#inputDari').val();
      var inputKe = $('#inputKe').val();
      var inputRP = $('#inputRP').val();
      $.ajax({
        type:'post',
        data:{inputID, inputDari, inputKe, inputRP},
        dataType:'json',
        cache:false,
        async:true,
        url:'saveMutasi',
        beforeSend:function(data){
          $('#btnSaveMutasi').attr("disabled",true)
        },
        success:function(data){
          if (data.status == 'success') {
            getTabel()
            $('#inputRP').val("")
            $('#inputID').val("")
            $('#modal-mutasi').modal("hide")
          }
          Swal.fire(data.message,data.sub_message,data.status)
        },
        complete:function(data){
          $('#btnSaveMutasi').attr("disabled",false);
        },
        error:function(data){
          Swal.fire("gagal menyimpan data","hubungi staff it","error")
        }
      })
    })
    $('#getTabel').on('click','.approve', function(){
      var id = $(this).attr("data");
      $.ajax({
        type:'post',
        data:{id},
        dataType:'json',
        cache:false,
        async:true,
        url:'approveMutasi',
        success:function(data){
          if (data.status == 'success') {
            getTabel();  
          }

          Swal.fire(data.message,data.sub_message,data.status);
          
        },
        erorr:function(data){
          Swal.fire("gagal approve data","hubungi staff it","error")
        }
      })
    })

  })
  
  function getTabel() {
    $.ajax({
      type:'get',
      url:url+'/cash_flow/dataMutasi',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getTabel').html(data)
      },
      complete:function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        Swal.fire("gagal menyimpan data","Hubung Staff IT","error")
      }
    })
  }
  

</script>
<!-- FootJS -->
</body>
</html>

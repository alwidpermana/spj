<?php
  $dlv = $this->session->userdata("DLV");
  $ndv = $this->session->userdata("NDV");
  $akhirPeriode = date('m-d-Y');
  $tglAkhir = date("Y-m-d");
  $mulaiPeriode = date('m-d-Y', strtotime('-7 days', strtotime($tglAkhir)));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
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
            <div class="col-md-3 col-sm-4">
              <div class="form-group">
                <label>Periode</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right filter" id="filPeriode">
                </div>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="form-group">
                <label>Status</label>
                <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                 <option value="">ALL</option>
                 <option value="OPEN" selected>OPEN</option>
                 <option value="CLOSE">CLOSE</option>
                 <option value="Waiting For Generate">Waiting For Generate</option>
                 <option value="CANCEL">CANCEL</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="form-group">
                <label>Jenis SPJ</label>
                <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                  <option value="" <?=$dlv == 'Y' && $ndv == 'Y' ? '' : 'disabled'?>>ALL</option>
                  <?php foreach ($spj as $key): ?>
                  <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-5 col-sm-12">
              <form id="search">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <span class="fa fa-search form-control-icon"></span>
                  <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ, QR Code, atau No Voucher BBM">
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <!-- <?=$mulaiPeriode.'||'.$akhirPeriode?> -->
                  <div class="row">
                    <div class="col-md-10 col-sm-8"></div>
                    <div class="col-md-2 col-sm-4">
                      <button type="button" class="btn bg-success btn-sm btn-block" id="exportExcel">
                        <i class="fas fa-file-excel"></i> &nbsp; Export Data
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
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
    
    <?php $this->load->view('_partial/footer');?>
</div>
<?php $this->load->view("_partial/js");?>
<script src="<?= base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url()?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/spin.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/ladda.min.js"></script>
<script src="<?= base_url()?>assets/plugins/ladda-buttons/js/ladda.jquery.min.js"></script>
<script src="<?= base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    var mulaiPeriode = '<?=$mulaiPeriode?>';
    var akhirPeriode = '<?=$akhirPeriode?>';
    $('#filPeriode').val(mulaiPeriode+" - "+akhirPeriode)
    $('#filPeriode').daterangepicker()
    console.log(mulaiPeriode)
    console.log(akhirPeriode)
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    $('.filter').on('change', function(){
      getTabel()
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    })
    // make_skeleton().fadeOut();
   getTabel();
   $('#exportExcel').on('click', function(){
    var filPeriode = $('#filPeriode').val();
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();
    var filSearch = $('#filSearch').val();
    var periode = filPeriode.split(' - ');
    var periodeAwal = periode[0]
    var periodeAkhir = periode[1]
    window.location.href = url+'/export_file/excelHargaSPJ?periodeAwal='+periodeAwal+'&periodeAkhir='+periodeAkhir+'&filJenis='+filJenis+'&filStatus='+filStatus+'&filSearch='+filSearch;
   })
  
  })
  
  function getTabel() {
    var filPeriode = $('#filPeriode').val();
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();
    var filSearch = $('#filSearch').val();
    var periode = filPeriode.split(' - ');
    var periodeAwal = periode[0]
    var periodeAkhir = periode[1]
    $.ajax({
      type:'get',
      data:{periodeAwal,periodeAkhir, filJenis, filStatus, filSearch},
      url:url+'/monitoring/getTabelWeekly',
      cache:false,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getTabel').html(data);
      },
      complete:function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        $('#getTabel').html("Gagal Meload Data!");
      }
    })
  }
  

</script>
<!-- FootJS -->
</body>
</html>

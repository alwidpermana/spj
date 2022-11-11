<?php
  $bulan = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
  $tanggal = date("Y-m-d");
  $i = 1;
  $kurang = 10;
  $tahun = [];
  for ($i=0; $i <$kurang ; $i++) { 
    $penguranTahun = date('Y', strtotime('-'.$i.' year', strtotime( $tanggal )));
    array_push($tahun, $penguranTahun); 
  }
?>
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
                  <?php if ($this->session->flashdata('success')): ?>
                  <div class="row" id="flashNotif">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                      <div class="alert alert-success alert-dismissible">
                        <h5><i class="icon fas fa-check"></i> Success!</h5>
                        Data Berhasil Disimpan!
                      </div>
                    </div>
                  </div>  
                  <?php endif ?>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Tahun</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                          <?php foreach ($tahun as $value): ?>
                            <option value="<?=$value?>"><?=$value?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Bulan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filBulan">
                          <?php foreach ($bulan as $angka => $bulan): ?>
                            <option value="<?=$bulan?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Periode</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filPeriode">
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis SPJ</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                            <option value="" <?=$attribut?>>ALL</option>
                          <?php foreach ($jenis as $key): ?>
                            <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                          <option value="">ALL</option>
                          <option value="OPEN">OPEN</option>
                          <option value="Waiting For Generate">Waiting For Generate</option>
                          <option value="CLOSE">CLOSE</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Group Tujuan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filGroup">
                          <option value="">ALL</option>
                          <?php foreach ($group as $key): ?>
                            <option value="<?=$key->ID_GROUP?>"><?=$key->NAMA_GROUP?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 offset-md-6">
                      <form id="search">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
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
    window.setTimeout(function() {  
       $("#flashNotif").fadeTo(1000, 0).slideUp(500, function() {  
         $(this).remove();  
       });  
     }, 1000);
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
   })

  })
  function getTabel() {
    var filBulan = $('#filBulan').val();
    var filTahun = $('#filTahun').val();
    var filPeriode = $('#filPeriode').val();
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();
    var filGroup = $('#filGroup').val();
    var filSearch = $('#filSearch').val();
    $.ajax({
      type:'get',
      data:{filBulan, filTahun, filPeriode, filJenis, filStatus, filGroup, filSearch},
      url:'getTabelStep1',
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
        $('#getTabel').html("");
      }
    });
  }
  

</script>
<!-- FootJS -->
</body>
</html>

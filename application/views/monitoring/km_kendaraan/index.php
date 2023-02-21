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
          <div class="card">
            <div class="card-body">
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
                        <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Filter KM</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filPengaturan">
                      <option value="">ALL</option>
                      <option value="filter">Filter</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 filterPengaturanKM">
                  <div class="row">
                    <div class="col-md-3">
                      <label style="padding-top: 30px">Total KM</label>
                    </div>
                    <!-- <div class="col-md-2">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filAritmatika">
                          <option value=">">&#62;</option>
                          <option value="<">&#60;</option>
                          <option value=">=">&#8805;</option>
                          <option value="<=">&#8804;</option>
                        </select>
                      </div>
                    </div> -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="number" id="inputKMAwal" class="form-control filter" value="0">
                      </div>
                    </div>
                    <div class="col-md-1 text-center">
                      <div class="form-group">
                        <label style="padding-top: 30px">s/d</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="number" id="inputKMAkhir" class="form-control filter" value="1000">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>  
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
    $('.ladda-button').ladda('bind', {timeout: 1000});
    getTabel()
    $('.filter').on('change', function(){
      getTabel();
    });
    pengaturanFilterKM();
    $('#filPengaturan').on('change', function(){
      pengaturanFilterKM();
    })
  })

  function getTabel() {
    var filTahun = $('#filTahun').val();
    var filBulan = $('#filBulan').val();
    var filPengaturan = $('#filPengaturan').val();
    var filAritmatika = $('#filAritmatika').val();
    var inputKMAwal = $('#inputKMAwal').val();
    var inputKMAkhir = $('#inputKMAkhir').val();
    $.ajax({
      type:'get',
      data:{filTahun, filBulan, filAritmatika, filPengaturan, inputKMAwal, inputKMAkhir},
      url:'getTabelKmKendaraan',
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
  function pengaturanFilterKM() {
    var filPengaturan = $('#filPengaturan').val();
    if (filPengaturan == '') {
      $('.filterPengaturanKM').addClass("d-none");
    }else{
      $('.filterPengaturanKM').removeClass("d-none");
    }
  }

</script>
<!-- FootJS -->
</body>
</html>

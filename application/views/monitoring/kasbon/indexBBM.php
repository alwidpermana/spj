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
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tahun</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                      <?php foreach ($tahun as $value): ?>
                        <option value="<?=$value?>"><?=$value?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Bulan</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filBulan">
                        <option value="">ALL</option>
                      <?php foreach ($bulan as $angka => $bulan): ?>
                        <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="select2 filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="OPEN">Open</option>
                      <option value="Waiting">Waiting For Generate</option>
                      <option value="CLOSE">Close</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                  <div class="row">
                    <div class="col-md-6 col-sm-2">
                      <div class="p-2 border border-dashed border-start-0 bg-white">
                          <h6 class="mb-1" id="showSaldoKasInduk"></h6>
                          <p class="text-muted mb-0">Saldo Kas Induk Bulan Sebelumnya</p>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-2">
                      <div class="p-2 border border-dashed border-start-0 bg-white">
                          <h6 class="mb-1" id="showSaldoSubKas"></h6>
                          <p class="text-muted mb-0">Saldo Sub Kas Bulan Sebelumnya</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="getTabel"></div>
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
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel();
   $('.filter').on('change', function(){
    getTabel()
    getLatestMonthKasbon();
   })
   getLatestMonthKasbon();
  })
  function getTabel() {
    var filBulan = $("#filBulan").val();
    var filTahun = $('#filTahun').val();
    var filStatus = $('#filStatus').val();

    $.ajax({
      type:'get',
      data:{filBulan, filTahun, filStatus},
      url:'getMonitoringKasbonBBM',
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
      errors: function(data){

      }      
    })
  }

  function getLatestMonthKasbon() {
    var filBulan = $("#filBulan").val();
    var filTahun = $('#filTahun').val();
    var filJenis = 'Kasbon Voucher BBM';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{filBulan,filTahun, filJenis},
      cache: false,
      async: true,
      url:'getLatestMonthKasbon',
      success: function(data){
        console.log(data.SALDO_INDUK);
        $('#showSaldoKasInduk').html(formatRupiah(Number(data.SALDO_INDUK).toFixed(0), 'Rp. '))
        $('#showSaldoSubKas').html(formatRupiah(Number(data.SALDO_SUB).toFixed(0), 'Rp. '))
        // 
      },
      error: function(data){

      }
    })
  }
  
  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split       = number_string.split(','),
    sisa        = split[0].length % 3,
    rupiah        = split[0].substr(0, sisa),
    ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
  

</script>
<!-- FootJS -->
</body>
</html>

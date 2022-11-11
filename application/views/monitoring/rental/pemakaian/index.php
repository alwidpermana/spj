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
<div class="preloader-no-bg">
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
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Bulan</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filBulan">
                          <?php foreach ($bulan as $angka => $bulan): ?>
                            <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>Tahun</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                          <?php foreach ($tahun as $value): ?>
                            <option value="<?=$value?>"><?=$value?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>Rekanan</label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filRekanan" style="width:100%">
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
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
    $('.preloader').fadeOut('slow');
    $('.preloader-no-bg').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $("#filRekanan").select2({
      ajax: { 
        url: url+'/monitoring/listDataRekanan',
        type: "get",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
              cari: params.term // search term
            };
        },
        processResults: function (response) {
            return {
               results: response
            };
            console.log(response)

        },
        cache: true
      }
    });
    $('.filter').on('change', function(){
      getTabel()
    })
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   

  })
  function getTabel() {
    var filRekanan = $('#filRekanan').val();
    var filBulan = $('#filBulan').val();
    var filTahun = $('#filTahun').val();
    console.log(filRekanan)
    if (filRekanan != null) {
      $.ajax({
        type:'get',
        data:{filRekanan, filBulan, filTahun},
        url:url+'/monitoring/getTabelMonitoringPemakaianKendaraan',
        cache:false,
        async:true,
        beforeSend:function(data){
          $('.preloader-no-bg').show();
        },
        success:function(data){
          $('#getTabel').html(data);
        },
        complete:function(data){
          $('.preloader-no-bg').fadeOut('slow');
        },
        error:function(data){
          $('#getTabel').html("Gagal Mengambil Data!");
        }
      })
    }
  }
  

</script>
<!-- FootJS -->
</body>
</html>

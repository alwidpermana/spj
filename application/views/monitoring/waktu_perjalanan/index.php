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
  $dlv = $this->session->userdata("DLV");
  $ndv = $this->session->userdata("NDV");
  $tglAkhir = date("Y-m-d");
  $akhirPeriode = date('m-d-Y', strtotime('+1 days', strtotime($tglAkhir)));
  $mulaiPeriode = date('m-d-Y', strtotime('-7 days', strtotime($tglAkhir)));
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
            <div class="col-md-1">
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
                  <option value="">ALL</option>
                  <?php foreach ($bulan as $angka => $bulan): ?>
                    <option value="<?=$bulan?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>Jenis</label>
                <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                  <option value="">ALL</option>
                  <option value="1">Delivery</option>
                  <option value="2">Non Delivery</option>
                </select>
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>Group</label>
                <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filGroup">
                  <option value="">ALL</option>
                  <option value="1">Group 1</option>
                  <option value="2">Group 2</option>
                  <option value="3">Group 3</option>
                  <option value="4">Lokal</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status</label>
                <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                  <option value="1">0-1 Jam</option>
                  <option value="2">1-2 Jam</option>
                  <option value="3">2-3 Jam</option>
                  <option value="4">> 3 Jam</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-1 col-sm-2">
                      <div class="form-group">
                        <label>Tampil</label>
                        <select class="select2 form-control filter" id="filLimit">
                          <option value="10" selected>10</option>
                          <option value="100">100</option>
                          <option value="250">250</option>
                          <option value="500">500</option>
                          <option value="750">750</option>
                          <option value="1000">1000</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-6">
                      <form id="search">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <span class="fa fa-search form-control-icon"></span>
                          <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabel"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 d-flex justify-content-start">
                      <p id="showInfo"></p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                      <input type="hidden" id="inputOffset">
                      <div id="paging"></div>
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
    $('.select2').select2({
        'width': '100%',
    });
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
      $('#inputOffset').val(offset)
    });
    $('.filter').on('change', function(){
        paging(1);
    })
    $('#search').submit(function(e){
      e.preventDefault();
      paging(1);
    })
    $('#paging').on('click','.btnStep', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      paging(offset)
      $('#inputOffset').val(offset)
    })

  })
  
  function paging(offset) {
    var filJenis = $('#filJenis').val();
    var filGroup = $('#filGroup').val();
    var filBulan = $('#filBulan').val();
    var filTahun = $('#filTahun').val();
    var filSearch = $('#filSearch').val();
    var limit = $('#filLimit').val();
    var filStatus = $('#filStatus').val();
    $.ajax({
      type:'get',
      data:{filJenis, filGroup, filBulan, filTahun, filSearch, filStatus, limit,offset},
      url:'getPagingMonitoringWaktuPerjalanan',
      cache:false,
      async:true,
      beforeSend:function(data){
          $('.preloader').show();
      },
      success:function(data){
          $('#paging').html(data);
          var endOffset = offset == ''?0:(offset-1)*limit;
          getKontol(endOffset, limit, filJenis, filGroup, filBulan, filTahun, filSearch, filStatus)
          // getInfoTabel(endOffset, limit, filSearch, filJenis, filSanksi, filDepartemen)
      },
      error:function(data){

      }
    })
  }
  // function getInfoTabel(offset, limit, filSearch, filJenis, filSanksi, filDepartemen) {
  //   $.ajax({
  //     type:'get',
  //     data:{offset, limit, filSearch, filJenis, filSanksi, filDepartemen},
  //     cache:false,
  //     async:true,
  //     dataType:'json',
  //     url:'getInfoOutstandingKonfirmasi',
  //     success:function(data){
  //         var info = data.start + ' - '+data.end+' (Filtered By '+data.jml+' Total Data)';
  //         $('#showInfo').html(info);
  //     },
  //     error:function(data){
  //         Swal.fire("Gagal Meload Data","Hubungi Staff IT","error");
  //     }
  //   })
  // }

  function getKontol(offset, limit, filJenis, filGroup, filBulan, filTahun, filSearch, filStatus) {
    $.ajax({
      type:'get',
      data:{offset, limit, filJenis, filGroup, filBulan, filTahun, filSearch, filStatus},
      url:'getDataMonitoringWaktuPerjalanan',
      cache:false,
      async:true,
      success:function(data){
        $('#getTabel').html(data)
      },
      complete:function(data){
        $('.preloader').fadeOut("slow")
      },
      error:function(data){
        Swal.fire("Gagal Mengambil Data","","error")          
      }
    })
  }
  

</script>
<!-- FootJS -->
</body>
</html>

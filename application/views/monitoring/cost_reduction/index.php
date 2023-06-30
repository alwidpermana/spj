<!DOCTYPE html>
<?php
  $dlv = $this->session->userdata("DLV");
  $ndv = $this->session->userdata("NDV");
  $akhirPeriode = date('m-d-Y');
  $tanggal = date("Y-m-d");
  $tglAkhir = date("Y-m-d");
  $mulaiPeriode = date('m-d-Y', strtotime('-7 days', strtotime($tglAkhir)));
  $bulan = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
  $i = 1;
  $kurang = 10;
  $tahun = [];
  for ($i=0; $i <$kurang ; $i++) { 
    $penguranTahun = date('Y', strtotime('-'.$i.' year', strtotime( $tanggal )));
    array_push($tahun, $penguranTahun); 
  }
?>
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
            <div class="col-md-3"></div>
            <div class="col-md-6 col-sm-8">
              <form id="search">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <span class="fa fa-search form-control-icon"></span>
                  <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ atau PIC">
                </div>
              </form>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2 col-sm-4">
                  <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnTambah">
                    Target Cost Reduction
                  </button> 
                </div>
                <div class="col-md-8 col-sm-4"></div>
                <div class="col-md-2 col-sm-4">
                  <a href="javascript:;" class="btn btn-success btn-sm btn-block" id="btnExport">
                    <i class="fas fa-file-excel"></i> &nbsp; Export Data
                  </a>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <div id="getTabel"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="preloader-no-bg">
                <div class="loader">
                  <div class="spinner"></div>
                  <div class="spinner-2"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-4">
                  <div class="form-group">
                    <label>Tahun</label>
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="filTahunGrapik">
                      <?php foreach ($tahun as $value): ?>
                        <option value="<?=$value?>"><?=$value?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-8 col-sm-4"></div>
                <div class="col-md-2 col-sm-4">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <a href="javascript:;" class="btn btn-success btn-sm btn-block" id="btnExportGrapik">
                      <i class="fas fa-file-excel"></i> &nbsp; Export Data Grapik
                    </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <canvas id="grafikCR" height="300"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="card d-none" id="formTarget">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2 col-sm-4">
                  <button type="button" class="btn bg-orange btn-kps btn-sm btn-block">
                    Tambah Target Bulanan
                  </button>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-target" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <!-- <div class="modal-header border-0">
            <div class="modal-title">
              <label>Program SPJ Menemukan Data Outgoing dari Program Serlok. Kendaraan Dengan No TNKB <span id="titleTNKB"></span> Berangkat Ke Customer Berikut:</label>
            </div>
          </div> -->
          <div class="modal-body">
            <div class="row">
              <div class="col-md-2 col-sm-4">
                <button type="button" class="btn btn-kps bg-orange btn-sm btn-block" id="btnTambahDataTarget">
                  Tambah Data Target
                </button>
              </div>
            </div>
            <br>
            <div id="formTarget" class="d-none">
              <input type="hidden" id="inputId">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Bulan</label>
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputBulan">
                      <?php foreach ($bulan as $angka => $bulan): ?>
                        <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Tahun</label>
                    <input type="text" class="form-control" id="inputTahun">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" id="inputJumlah" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2 text-right">
                  <button type="button" class="btn bg-orange btn-kps btn-block ladda-button saveDataTarget" data-style="expand-left">Save Data</button>
                </div> 
              </div>
              <br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover table-striped table-valign-middle text-center" width="100%">
                  <thead>
                    <tr>
                      <th>Bulan</th>
                      <th>Tahun</th>
                      <th>Jumlah</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="getTabelTargetBulanan">
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveTarget ladda-button" data-style="expand-right">Tambah Target</button>
          </div> -->
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
<script src="<?= base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var mulaiPeriode = '<?=$mulaiPeriode?>';
    var akhirPeriode = '<?=$akhirPeriode?>';
    $('#filPeriode').val(mulaiPeriode+" - "+akhirPeriode)
    $('#filPeriode').daterangepicker()
    $('.select2').select2({
        'width': '100%',
    });
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('.filter').on('change', function(){
      getTabel()
      
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    })
    $('.preloader-no-bg').fadeOut("slow")
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel();
   $('#btnTambah').on('click', function(){
    // $('html, body').animate({
    //   scrollTop: $("#formTarget").offset().top
    // }, 750);
    // $('#formTarget').removeClass("d-none")
    $('#modal-target').modal("show")
    getTabelTargetBulanan();
   })
   $('#btnTambahDataTarget').on('click', function(){
    $('#formTarget').removeClass("d-none")
    $('#inputId').val("");
   })
   var saveDataTarget = $('.saveDataTarget').ladda();
      saveDataTarget.click(function () {
      // Start loading
      saveDataTarget.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputTahun = $('#inputTahun').val();
        var inputBulan = $('#inputBulan').val();
        var inputJumlah= $('#inputJumlah').val();
        var inputId = $('#inputId').val();
        var link = inputId == ''?'saveTargetCRDelivery':'updateTargetCRDelivery';
        if (inputTahun == '') {
          Swal.fire("Data Belum Lengkap!","Lengkapi Data Tahun","info");
          saveDataTarget.ladda('stop');
        } else if(inputJumlah == ''){
          Swal.fire("Data Belum Lengkap!","Lengkapi Data Jumlah","info");
          saveDataTarget.ladda('stop');
        }else {
          $.ajax({
            type:'post',
            data:{inputBulan, inputTahun, inputJumlah, inputId},
            dataType:'json',
            cache:false,
            async:true,
            url:link,
            beforeSend:function(data){
              $('.saveDataTarget').attr("disabled","disabled");
            },
            success:function(data){
              if (data.status == 'success') {
                berhasil()
                $('#getTabelTargetBulanan').append(data.hasil);
                $('#formTarget').addClass("d-none");
                $('#inputTahun').val("");
                $('#inputJumlah').val("");  
              }else{
                Swal.fire(data.message,'','warning')
              }
              
            },
            complete:function(data){
              $('.saveDataTarget').removeAttr("disabled","disabled");
              saveDataTarget.ladda('stop');
            },
            error:function(data){
              gagal()
            }
          })
        }
        
        return false;
          
      }, 1000)
    });
    $('#getTabelTargetBulanan').on('click','.btnEdit', function(){
      var id = $(this).attr("data");
      var bulan = $(this).attr("bulan")
      var tahun = $(this).attr("tahun")
      var jumlah = $(this).attr("jumlah")
      console.log(bulan)
      $('#inputId').val(id);
      $('#inputTahun').val(tahun)
      $('#inputJumlah').val(jumlah)
      $("select#inputBulan option[value='"+bulan+"']").prop("selected","selected");
      $("select#inputBulan").trigger("change")
      $('#formTarget').removeClass("d-none")
    });
    $('#getTabelTargetBulanan').on('click','.btnHapus', function(){
      var id = $(this).attr("data");
      Swal.fire({
        title: 'Menghapus Data Target',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Hapus Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type:'post',
            data:{id},
            dataType:'json',
            cache:false,
            async:true,
            url:'hapusTargetBulananCR',
            success:function(data){
              getTabelTargetBulanan();
              Swal.fire("Berhasil Menghapus Data","","success");
            },
            error:function(data){
              Swal.fire("Gagal Menghapus Data","","error");
            }
          })
        }
      })
    })
    $('#filTahunGrapik').on('change', function(){
      getGrapik();  
    })
    $('#btnExport').on('click', function(){
      var filPeriode = $('#filPeriode').val();
      var filSearch = $('#filSearch').val();
      var periode = filPeriode.split(' - ');
      var periodeAwal = periode[0]
      var periodeAkhir = periode[1]
      window.location.href=url+'/export_file/cost_reduction_delivery?awal='+periodeAwal+'&akhir='+periodeAkhir;
      
    })
    $('#btnExportGrapik').on('click', function(){
      var filPeriode = $('#filPeriode').val();
      var filSearch = $('#filSearch').val();
      var filTahunGrapik = $('#filTahunGrapik').val();
      var periode = filPeriode.split(' - ');
      var periodeAwal = periode[0]
      var periodeAkhir = periode[1]
      window.location.href=url+'/export_file/exportGrapikCostReduction?awal='+periodeAwal+'&akhir='+periodeAkhir+'&tahun='+filTahunGrapik;
    })
  })
  
  function getTabel() {
    var filPeriode = $('#filPeriode').val();
    var filSearch = $('#filSearch').val();
    var periode = filPeriode.split(' - ');
    var periodeAwal = periode[0]
    var periodeAkhir = periode[1]
    $.ajax({
      type:'get',
      data:{filSearch, periodeAwal, periodeAkhir},
      url:url+'/monitoring/getTabelCostReduction',
      cache:false,
      async:true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success:function(data){
        $('#getTabel').html(data);
        getGrapik();
      },
      complete:function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        $('#getTabel').html("Gagal Mengambil Data!");
      }
    })
  }
  function getTabelTargetBulanan() {
    $.ajax({
      type:'get',
      dataType:'json',
      cache:false,
      async:true,
      url:'getTabelTargetCRDelivery_UangJalan',
      success:function(data){
        $('#getTabelTargetBulanan').html(data)
      },
      error:function(data){

      }
    })
  }
  function getGrapik() {
    var filTahunGrapik = $('#filTahunGrapik').val();
    var bulan = [];
    var aktual = [];
    var normal = [];
    var target = [];
    var filPeriode = $('#filPeriode').val();
    var periode = filPeriode.split(' - ');
    var periodeAwal = periode[0]
    var periodeAkhir = periode[1]
    $.ajax({
      type:'get',
      data:{filTahunGrapik, periodeAwal, periodeAkhir},
      dataType:'json',
      url:'grapikCRDelivery',
      cache:true,
      async:true,
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        for (var i = 0; i < data.length; i++) {
          bulan.push(data[i].NAMA_BULAN);
          aktual.push(data[i].AKTUAL);
          normal.push(data[i].NORMAL);
          target.push(data[i].JUMLAH_TARGET);  
        }
        setGrafik(bulan, aktual, normal, target);
      },
      complete:function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error:function(data){

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
  function setGrafik(bulan, aktual, normal, target) {
    console.log(bulan)
    console.log(aktual)
    console.log(normal)
    var areaChartData = {
                    
    labels  : bulan,
    datasets: [
      {
        label               : 'Jumlah Uang Jalan Aktual',
        backgroundColor     : 'rgba(154, 3, 30,0.9)',
        borderColor         : 'rgba(154, 3, 30,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(154, 3, 30,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(154, 3, 30,1)',
        data                : aktual
      },
      {
        label               : 'Jumlah Uang Jalan Normal',
        backgroundColor     : 'rgba(251, 139, 36, 1)',
        borderColor         : 'rgba(251, 139, 36, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(251, 139, 36, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(251, 139, 36,1)',
        data                : normal
      },
      {
        label               : 'Jumlah Target',
        backgroundColor     : 'rgba(108, 117, 125, 1)',
        borderColor         : 'rgba(108, 117, 125, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(108, 117, 125, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(108, 117, 125,1)',
        data                : target
      },
    ]
  }
      var mode = 'index'
      var intersect = true
      var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }

  var barChartCanvas = $('#grafikCR').get(0).getContext('2d')
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  var temp1 = areaChartData.datasets[1]
  barChartData.datasets[0] = temp1
  barChartData.datasets[1] = temp0

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false,
    tooltips: {
      mode: mode,
      intersect: intersect,
      callbacks: {
          label: function(tooltipItem, data) {
              return "Rp." + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                  return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
              });
          }
      }
    },
     hover: {
      mode: mode,
      intersect: intersect
    },
    legend: {
      display: true
    },
    scales: {
    yAxes: [
      {
        ticks: {
         callback: function (value, index, values) {
            return addCommas(value); //! panggil function addComas tadi disini
          }
        }
      }
     ],
  },
  }

  var barChart = new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })
  }

  function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    let rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

</script>
<!-- FootJS -->
</body>
</html>

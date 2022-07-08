<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .scrollable{
      overflow-y: hidden;
      max-height: 165px;
    }
    .scrollable:hover{
      overflow-y: auto;
      scrollbar-width: thin;
    }
    ::-webkit-scrollbar {
      width: 18px;
    }
    ::-webkit-scrollbar-track {
      background-color: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #d6dee1;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #d6dee1;
      border-radius: 1px;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #d6dee1;
      border-radius: 1px;
      border: 6px solid transparent;
      background-clip: content-box;
    }
  </style>
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
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header border-0">
                      <div class="card-title">
                        Jumlah SPJ
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4 col-12 ">
                  <div class="info-box bg-kps shadow-lg">
                    <span class="info-box-icon"><i class="fas fa-envelope-open-text"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">SPJ</span>
                      <span class="progress-description" style="font-size:13px"><?=$jml_spj?>&nbsp;&nbsp;&nbsp; Pengajuan Hari Ini</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-12 ">
                  <div class="info-box bg-kps shadow-lg">
                    <span class="info-box-icon"><i class="fas fa-upload"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Generate</span>
                      <span class="progress-description" style="font-size:13px"><?=$jmlGenerate?>&nbsp;&nbsp;&nbsp; SPJ</span>
                      <!-- <span class="progress-description">
                        SPJ Perlu Dilakukan Generate
                      </span> -->
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-12 ">
                  <div class="info-box bg-kps shadow-lg">
                    <span class="info-box-icon"><i class="fas fa-hourglass-half"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Outstanding</span>
                      <span class="progress-description" style="font-size:13px"><?=$outstanding?>&nbsp;&nbsp;&nbsp; SPJ</span>
                      <!-- <span class="progress-description">
                        Perlu Dilakukan Approve Outstanding
                      </span> -->
                    </div>
                  </div>
                </div>
              </div>
              

            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">Kendaraan Out</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-striped table-valign-middle datatable" width="100%">
                        <thead class="text-center">
                          <th>No</th>
                          <th>No TNKB</th>
                          <th>Group Tujuan</th>
                          <th>No SPJ</th>
                        </thead>
                        <tbody class="text-center">
                          <?php 
                            $i= 1;
                            foreach ($tempKendaraan as $tk): ?>
                              <tr>
                                <td><?=$i++?></td>
                                <td><?=$tk->NO_TNKB?></td>
                                <td><?=$tk->NAMA_GROUP?></td>
                                <td>
                                  <a href="<?=base_url()?>monitoring/view_spj/<?=$tk->ID_SPJ?>" class="btn text-kps">
                                    <?=$tk->NO_SPJ?>    
                                  </a>
                                </td>
                              </tr>
                            <?php endforeach ?>


                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header border-0">
                      <h3 class="card-title">PIC Out</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-striped table-valign-middle datatable" width="100%">
                        <thead class="text-center">
                          <th></th>
                          <th>PIC</th>
                          <th>No SPJ</th>
                        </thead>
                        <tbody class="text-center">
                          <?php foreach ($tempPIC as $tp): ?>
                            <tr>
                              <td>
                                <?php if ($tp->FOTO_WAJAH == null || $tp->FOTO_WAJAH == ''): 
                                  $fotoUn = $tp->JenisKelamin == 'P'?'female1.png':'male3.png';
                                ?>
                                  <img class="direct-chat-img" src="<?=base_url()?>assets/image/avatar/<?=$fotoUn?>" alt="message user image">
                                <?php else:?>
                                  <img class="direct-chat-img" src="<?=base_url()?>assets/image/foto-wajah/<?=$tp->FOTO_WAJAH?>" alt="message user image">  
                                <?php endif ?>
                                
                              </td>
                              <td><?=$tp->PIC.'<br>'.$tp->NAMA_PIC?></td>
                              <td>
                                <a href="<?=base_url()?>monitoring/view_spj/<?=$tp->ID_SPJ?>" class="btn text-kps">
                                  <?=$tp->NO_SPJ?>    
                                </a>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
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
<!-- ChartJS -->
<script src="<?= base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
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
    getDiagramJmlDelivery();
    var table = $('.datatable').DataTable( {
      scrollY:        "200px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      'searching': false,
      'ordering': false,
      'info': false,
      order: [[0, 'asc']],
    } ); 
  })
  function getDiagramJmlDelivery() {
    var delivery = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var nonDelivery =[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var jml = 0;
    var no = 1;
    $.ajax({
      type:'get',
      dataType:'json',
      data:{jenis:'1'},
      url:url+'/Dashboard/getJmlSPJForDashboard',
      cache: false,
      async: true,
      success: function(data){

        for (var i = 0; i < data.length; i++) {
          no = parseInt(data[i].BULAN) - 1;
          const newArr = delivery.map((element, index)=>{
            if (data[i].JENIS_ID == 1) {
              delivery[no] = parseInt(data[i].JML_SPJ);
            }else{
              nonDelivery[no] = parseInt(data[i].JML_SPJ);
            }
          })
        }

        buildGrafikJmlSPJ(delivery, nonDelivery);
      },
      error: function(data){

      }
    });
  }

  function buildGrafikJmlSPJ(delivery, nonDelivery) {
    'use strict'

     // Sales graph chart
    var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');
    var salesGraphChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    datasets: [
      {
        label: 'Delivery',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#CC5803',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#CC5803',
        pointBackgroundColor: '#CC5803',
        data: delivery
      },
      {
        label: 'Non Delivery',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#525152',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#525152',
        pointBackgroundColor: '#525152',
        data: nonDelivery
      }
    ]
  }
  var mode = 'index'
  var intersect = true
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }
  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    tooltips: {
      mode: mode,
      intersect: intersect
    },
    hover: {
      mode: mode,
      intersect: intersect
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#37323e'
        },
        gridLines: {
          display: false,
          color: '#37323e',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          fontColor: '#37323e'
        },
        gridLines: {
          display: true,
          color: '#37323e',
          drawBorder: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesGraphChartCanvas, {
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  })
  }
  

</script>
<!-- FootJS -->
<script type="text/javascript">
  $(function () {
    
  });
</script>
</body>
</html>

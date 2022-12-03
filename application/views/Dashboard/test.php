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
          <button type="button" class="btn btn-kps bg-orange btn-block" id="addDelivery">
            Add Delivery Setup
          </button>
          <div class="row">
            <div class="col-md-4">
              <select class="select2" id="inputDepartureTime" multiple="multiple" data-placeholder="Pilih Departure Time Dari Program Serlok" data-dropdown-css-class="select2-orange" style="width: 100%;color: white !important;">
                
              </select>
              <br>
              <!-- <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="test">
                TEST
              </button>
              JANGAN DIHAPUS!!!
               -->


            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <?php
                $keberangkatanH = '2022-01-01';
                $kepulanganH = '2022-01-02';
                $berangkatH = date_create($keberangkatanH);
                $pulangH = date_create($kepulanganH);
                $selisihH = date_diff($berangkatH, $pulangH);
                $selisihHari = $selisihH->d;
                echo $selisihHari;
              ?>
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
<script src="<?= base_url()?>assets/plugins/require.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    test()
    $('#addDelivery').on('click', function(){
      $.ajax({
        type:'get',
        dataType:'json',
        cache:false,
        async:true,
        url:url+'/Dashboard/saveDeliverySetup',
        success:function(data){
          Swal.fire("Berhasil","","success")
        },
        error:function(data){
          Swal.fire("Gagal","","error")
        }
      })
    })
    $('#test').on('click', function(){
      var data = $('#inputDepartureTime').val();
      if (data.length >0) {
        var whereDeparture = " AND b.departure_time  IN ("
        var jml = data.length-1;
        for (var i = 0; i < data.length; i++) {
          whereDeparture+="'"+data[i]+"'";
          if (i<jml) {
            whereDeparture+=",";
          }else{
            whereDeparture+=")";
          }
        }
      }else{
        var whereDeparture = '';
      }
      console.log(whereDeparture);
    })

    getDepartureTime()
    function getDepartureTime() {
      var inputNoTNKB = 'Z 8945 AF';
      var inputTglSPJ = '2022-11-25'
      $.ajax({
        type:'get',
        data:{inputNoTNKB, inputTglSPJ},
        dataType:'json',
        cache:false,
        async:true,
        url:url+'/pengajuan/getDepartureTime',
        success:function(data){
          $('#inputDepartureTime').html(data);
        },
        error:function(data){

        }
      })
    }
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    // const Header = require('postman-collection').Header;
    // const url = require('url');
    // const hmac_username ='EtQ6cQqwz5Zt28h3';
    // const hmac_secret = 'b92gFlPSHfhBjb2hYhBJOxPFr1WTg2fb';
    // const requestUrl = url.parse(request['url']);
    // const requestLine = pm.request.method + ' ' + requestUrl.path + ' HTTP/1.1';
    // const dateString = new Date().toUTCString();
    // const digest = CryptoJS.HmacSHA256(['date: ' + dateString, requestLine].join('\n'), hmac_secret);
    // const signature = CryptoJS.enc.Base64.stringify(digest);
    // const hmac_header = 'hmac username="' + hmac_username + '", algorithm="hmac-sha256", headers="date request-line", signature="' + signature + '"'
    // // pm.request.headers.add(new Header("Authorization: " + hmac_header));
    // // pm.request.headers.add(new Header("Date: " + dateString));
    // var settings = {
    //   "url": "https://api.mekari.com/v2/talenta/v2/employee?limit=20&employment_status=1&show_ess=1",
    //   "method": "GET",
    //   "timeout": 0,
    //   "headers": {
    //     "Authorization": "{{hmac_signature}}",
    //     "Date": "{{authentication_date}}"
    // },
    // };

    // $.ajax(settings).done(function (response) {
    //   console.log(response);
    // });
  })

  function test() {
    // const Header = require([postman-collection]).Header;
    // const url = require('https://api.mekari.com/v2/talenta/v2/employee?limit=20&employment_status=1&show_ess=1');
    // const hmac_username ='EtQ6cQqwz5Zt28h3';
    // const hmac_secret = 'b92gFlPSHfhBjb2hYhBJOxPFr1WTg2fb';
    // const requestUrl = url.parse(request['url']);
    // const requestLine = pm.request.method + ' ' + requestUrl.path + ' HTTP/1.1';
    // const dateString = new Date().toUTCString();
    // const digest = CryptoJS.HmacSHA256(['date: ' + dateString, requestLine].join('\n'), hmac_secret);
    // const signature = CryptoJS.enc.Base64.stringify(digest);
    // const hmac_header = 'hmac username="' + hmac_username + '", algorithm="hmac-sha256", headers="date request-line", signature="' + signature + '"'
    $.ajax({
      type:'get',
      dataType:'json',
      url:'testAPI',
      cache: false,
      success: function(data){
        console.log(data)
      },
      error: function(data){

      }
    });
    
  }
  
  

</script>
<!-- FootJS -->
</body>
</html>

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
          <?php
            $tglAwal = date("H", strtotime('2022-08-15 08:13'));
            $tglAkhir = date("H", strtotime('2022-08-16 07:53'));

            if ($tglAwal>$tglAkhir) {
              echo 'kurang';
            }else{
              echo 'tambah';
            }
          ?>
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

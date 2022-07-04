<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
                    <label>Jenis SPJ</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <?php foreach ($jenis as $key): ?>
                        <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2"><label>Jumlah SPJ</label></div>
                <div class="col-md-4">: <span id="showJumlahSPJ"></span></div>
                <input type="hidden" id="inputJumlahSPJ">
              </div>
              <div class="row">
                <div class="col-md-2"><label>Total Rp.</label></div>
                <div class="col-md-4">: <span id="showTotalRP"></span></div>
                <input type="hidden" id="inputTotalRP" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>No Generate Req</label></div>
                <div class="col-md-4">: <span id="showNoGenerate"></span></div>
                <input type="hidden" id="inputNoGenerate" value="">
              </div>
              <br>
              <hr>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <div id="getTabel"></div>
                  <input type="hidden" id="ketAll">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <button type="button" class="btn bg-orange btn-kps btn-block ladda-button" data-style="zoom-in" id="btnGenerate">Generate SPJ</button>
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
    
    $('.ladda-button').ladda('bind', {timeout: 1000});
    getInfo()
    getTabel()
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    $('#filJenis').on('change', function(){
      getInfo();
      getTabel();
    });
    $('#getTabel').on('click','[name="inputAllData"]', function(){
      var cekAll = $(this)[0].checked;
      if (cekAll == true) {
        $('[name="inputCheckSPJ"]').attr("checked","checked");
      } else {
        $('[name="inputCheckSPJ"]').removeAttr("checked","checked");
      }
      var totalRP = 0;
      var jmlSPJ = 0;
      var noSPJ = [];
      $.each($('[name="inputCheckSPJ"]:checked'), function(){
        totalRP +=parseInt($(this).attr("rp"))
        noSPJ.push($(this).val());
      })
      $('#inputJumlahSPJ').val(noSPJ.length);
      $('#inputTotalRP').val(totalRP);
      $('#showJumlahSPJ').html(noSPJ.length);
      $('#showTotalRP').html(totalRP);
      console.log(noSPJ);
    });
    $('#getTabel').on('click','[name="inputCheckSPJ"]', function(){
      var totalRP = 0;
      var jmlSPJ = 0;
      var noSPJ = [];
      $.each($('[name="inputCheckSPJ"]:checked'), function(){
        totalRP +=parseInt($(this).attr("rp"))
        noSPJ.push($(this).val());
      })
      $('#inputJumlahSPJ').val(noSPJ.length);
      $('#inputTotalRP').val(totalRP);
      $('#showJumlahSPJ').html(noSPJ.length);
      $('#showTotalRP').html(totalRP);
    })
    

    var btnGenerate = $('#btnGenerate').ladda();
      btnGenerate.click(function () {
      // Start loading
      btnGenerate.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJumlahSPJ = 0;
        var inputTotalRP = 0
        var inputNoGenerate = $('#inputNoGenerate').val();
        var filJenis = $('#filJenis').val();
        var noSPJ=[];
        var totalRP=0;
        $.each($('[name="inputCheckSPJ"]:checked'), function(){
          noSPJ.push($(this).val());
          inputTotalRP +=parseInt($(this).attr("rp"))
        })
        inputJumlahSPJ = noSPJ.length;
        console.log(totalRP)
        if (noSPJ.length >0) {
          $.ajax({
            type:'post',
            data:{noSPJ,inputNoGenerate,inputJumlahSPJ,inputTotalRP, filJenis},
            dataType:'json',
            url:url+'/Implementasi/saveGenerateSPJ',
            cache: false,
            async: true,
            success: function(data){
              Swal.fire({
                position: 'top-end',
                toast : true,
                icon: 'success',
                title: 'Berhasil Menyimpan Data!',
                showConfirmButton: false,
                timer: 3000
              })
              getTabel();
              getInfo();
            },
            error: function(data){
              Swal.fire({
                position: 'top-end',
                toast : true,
                icon: 'error',
                title: 'Gagal Menyimpan Data! Hubungi Staff IT',
                showConfirmButton: false,
                timer: 3000
              })
            }
          });
        } else {
          Swal.fire("Pilih SPJ nya Terlebih Dahulu!","","warning")
        }
        
        
        btnGenerate.ladda('stop');
        return false;
          
      }, 1000)
    });

  })
  function getInfo() {
    var filJenis = $('#filJenis').val();
    $.ajax({
      type:'get',
      data:{filJenis},
      url:url+'/Implementasi/getInfo',
      dataType:'json',
      cache: false,
      async: true,
      success: function(data){
        console.log(data.jumlahSPJ)
        $('#inputJumlahSPJ').val(data.jumlahSPJ);
        $('#inputNoGenerate').val(data.noGenerate);
        $('#inputTotalRP').val(data.totalRP);
        $('#showJumlahSPJ').html(data.jumlahSPJ);
        $('#showNoGenerate').html(data.noGenerate);
        $('#showTotalRP').html(data.totalRP);
      },
      error: function(data){

      }
    });
  }
  function getTabel() {
    var filJenis = $('#filJenis').val();
    $.ajax({
      type:'get',
      data:{filJenis},
      url:url+'/Implementasi/getTabelGenerate',
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

      }
    })
  }
</script>
<!-- FootJS -->
</body>
</html>

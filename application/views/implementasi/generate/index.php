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
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jenis SPJ</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <?php foreach ($jenis as $key): ?>
                        <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
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
                <div class="col-md-2"><label>SPJ Rp.</label></div>
                <div class="col-md-4">: <span id="showSPJRP"></span></div>
                <input type="hidden" id="inputSPJRP" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>BBM (Kasbon/Reimburse) Rp.</label></div>
                <div class="col-md-4">: <span id="showBBMRP"></span></div>
                <input type="hidden" id="inputBBMRP" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>TOL Rp.</label></div>
                <div class="col-md-4">: <span id="showTOLRP"></span></div>
                <input type="hidden" id="inputTOLRP" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>Voucher Rest Area Rp.</label></div>
                <div class="col-md-4">: <span id="showVoucherRA"></span></div>
                <input type="hidden" id="inputVoucherRA" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>Voucher Katulistiwa Rp.</label></div>
                <div class="col-md-4">: <span id="showVoucherKA"></span></div>
                <input type="hidden" id="inputVoucherKA" value="">
              </div>
              <div class="row">
                <div class="col-md-2"><label>Jumlah Biaya Admin</label></div>
                <div class="col-md-4">: <span id="showJumlahBiayaAdmin"></span></div>
                <input type="hidden" id="inputJumlahBiayaAdmin">
              </div>
              <div class="row">
                <div class="col-md-2"><label>Total Biaya Admin Rp.</label></div>
                <div class="col-md-4">: <span id="showTotalBiayaAdmin"></span></div>
                <input type="hidden" id="inputTotalBiayaAdmin" value="">
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
    $('.preloader-no-bg').fadeOut('slow');
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
        $('[name="inputCheckBiayaAdmin"]').attr("checked","checked");
      } else {
        $('[name="inputCheckSPJ"]').removeAttr("checked","checked");
        $('[name="inputCheckBiayaAdmin"]').removeAttr("checked","checked");
      }

      var totalRP = 0;
      var jmlSPJ = 0;
      var noSPJ = [];
      var totalSPJ = 0;
      var totalBBM = 0;
      var totalTOL = 0;
      var totalReimburse = 0;
      var totalKatulistiwa = 0
      $.each($('[name="inputCheckSPJ"]:checked'), function(){
        totalRP +=parseInt($(this).attr("rp"))
        noSPJ.push($(this).val());
        totalSPJ +=parseInt($(this).attr("spj"))
        totalBBM +=parseInt($(this).attr("bbm"))
        totalTOL +=parseInt($(this).attr("tol"))
        totalReimburse +=parseInt($(this).attr("reimburse"))
        totalKatulistiwa +=parseInt($(this).attr("katulistiwa"))
      })
      $('#inputJumlahSPJ').val(noSPJ.length);
      $('#inputTotalRP').val(totalRP);
      $('#showJumlahSPJ').html(noSPJ.length);
      $('#showTotalRP').html(formatRupiah(Number(totalRP).toFixed(0), 'Rp. '));
      $('#inputSPJRP').val(totalSPJ);
      $('#showSPJRP').html(formatRupiah(Number(totalSPJ).toFixed(0), 'Rp. '))
      $('#inputBBMRP').val(totalReimburse);
      $('#showBBMRP').html(formatRupiah(Number(totalReimburse).toFixed(0), 'Rp. '))
      $('#inputTOLRP').val(totalTOL);
      $('#showTOLRP').html(formatRupiah(Number(totalTOL).toFixed(0), 'Rp. '))
      $('#inputVoucherRA').val(totalBBM);
      $('#showVoucherRA').html(formatRupiah(Number(totalBBM).toFixed(0), 'Rp. '))
      $('#inputVoucherKA').val(totalKatulistiwa);
      $('#showVoucherKA').html(formatRupiah(Number(totalKatulistiwa).toFixed(0), 'Rp. '))
      console.log(noSPJ);

      var totalBA =0;
      var jmlBA = 0;
      var noBA = [];
      $.each($('[name="inputCheckBiayaAdmin"]:checked'), function(){
        totalBA +=parseInt($(this).attr("rp"))
        noBA.push($(this).val());
      })
      $('#inputJumlahBiayaAdmin').val(noBA.length);
      $('#inputTotalBiayaAdmin').val(totalBA);
      $('#showJumlahBiayaAdmin').html(noBA.length);
      $('#showTotalBiayaAdmin').html(formatRupiah(Number(totalBA).toFixed(0), 'Rp. '));
      console.log(noBA)
    });
    $('#getTabel').on('click','[name="inputCheckSPJ"]', function(){
      var totalRP = 0;
      var jmlSPJ = 0;
      var noSPJ = [];
      var totalSPJ = 0;
      var totalBBM = 0;
      var totalTOL = 0;
      var totalReimburse = 0;
      var totalKatulistiwa = 0
      $.each($('[name="inputCheckSPJ"]:checked'), function(){
        totalRP +=parseInt($(this).attr("rp"))
        noSPJ.push($(this).val());
        totalSPJ +=parseInt($(this).attr("spj"))
        totalBBM +=parseInt($(this).attr("bbm"))
        totalTOL +=parseInt($(this).attr("tol"))
        totalReimburse +=parseInt($(this).attr("reimburse"))
        totalKatulistiwa +=parseInt($(this).attr("katulistiwa"))
      })
      $('#inputJumlahSPJ').val(noSPJ.length);
      $('#inputTotalRP').val(totalRP);
      $('#showJumlahSPJ').html(noSPJ.length);
      $('#showTotalRP').html(formatRupiah(Number(totalRP).toFixed(0), 'Rp. '));
      $('#inputSPJRP').val(totalSPJ);
      $('#showSPJRP').html(formatRupiah(Number(totalSPJ).toFixed(0), 'Rp. '))
      $('#inputBBMRP').val(totalReimburse);
      $('#showBBMRP').html(formatRupiah(Number(totalReimburse).toFixed(0), 'Rp. '))
      $('#inputTOLRP').val(totalTOL);
      $('#showTOLRP').html(formatRupiah(Number(totalTOL).toFixed(0), 'Rp. '))
      $('#inputVoucherRA').val(totalBBM);
      $('#showVoucherRA').html(formatRupiah(Number(totalBBM).toFixed(0), 'Rp. '))
      $('#inputVoucherKA').val(totalKatulistiwa);
      $('#showVoucherKA').html(formatRupiah(Number(totalKatulistiwa).toFixed(0), 'Rp. '))
      console.log(totalRP)
      console.log(totalSPJ)
      console.log(totalBBM)
      console.log(totalTOL)
    })
    $('#getTabel').on('click','[name="inputCheckBiayaAdmin"]', function(){
      var totalRP = 0;
      var jmlSPJ = 0;
      var noSPJ = [];
      $.each($('[name="inputCheckBiayaAdmin"]:checked'), function(){
        totalRP +=parseInt($(this).attr("rp"))
        noSPJ.push($(this).val());
      })
      $('#inputJumlahBiayaAdmin').val(noSPJ.length);
      $('#inputTotalBiayaAdmin').val(totalRP);
      $('#showJumlahBiayaAdmin').html(noSPJ.length);
      $('#showTotalBiayaAdmin').html(formatRupiah(Number(totalRP).toFixed(0), 'Rp. '));
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
        var noBA=[];
        var totalBA=0;
        var inputJumlahBA=0;
        var inputTotalBA = 0;
        $.each($('[name="inputCheckSPJ"]:checked'), function(){
          noSPJ.push($(this).val());
          inputTotalRP +=parseInt($(this).attr("rp"))
        })
        inputJumlahSPJ = noSPJ.length;
        console.log(totalRP)
        
        $.each($('[name="inputCheckBiayaAdmin"]:checked'), function(){
          noBA.push($(this).val());
          inputTotalBA +=parseInt($(this).attr("rp"))
        })
        inputJumlahBA = noBA.length;
        console.log(inputJumlahBA);

        if (noSPJ.length >0) {
          $.ajax({
            type:'post',
            data:{noSPJ,inputNoGenerate,inputJumlahSPJ,inputTotalRP, filJenis, inputJumlahBA, inputTotalBA, noBA},
            dataType:'json',
            url:url+'/Implementasi/saveGenerateSPJ',
            cache: false,
            async: true,
            beforeSend: function(data){
              $('.preloader-no-bg').show();
            },
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
            complete: function(data){
              $('.preloader-no-bg').fadeOut('slow');
              btnGenerate.ladda('stop');
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
          btnGenerate.ladda('stop');
        }
        
        
        
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
        $('#inputBBMRP').val(data.totalReimburse);
        $('#inputVoucherRA').val(data.totalBBM);
        $('#inputVoucherKA').val(data.totalKatulistiwa);
        $('#inputSPJRP').val(data.totalSPJ);
        $('#inputTOLRP').val(data.totalTOL);
        $('#inputTotalBiayaAdmin').val(data.totalBA)
        $('#inputJumlahBiayaAdmin').val(data.jumlahBA)
        $('#showJumlahSPJ').html(data.jumlahSPJ);
        $('#showNoGenerate').html(data.noGenerate);
        $('#showJumlahBiayaAdmin').html(data.jumlahBA);
        $('#showTotalRP').html(formatRupiah(Number(data.totalRP).toFixed(0), 'Rp. '));
        $('#showBBMRP').html(formatRupiah(Number(data.totalReimburse).toFixed(0), 'Rp. '));
        $('#showSPJRP').html(formatRupiah(Number(data.totalSPJ).toFixed(0), 'Rp. '));
        $('#showTOLRP').html(formatRupiah(Number(data.totalTOL).toFixed(0), 'Rp. '));
        $('#showVoucherKA').html(formatRupiah(Number(data.totalKatulistiwa).toFixed(0), 'Rp. '));
        $('#showVoucherRA').html(formatRupiah(Number(data.totalBBM).toFixed(0), 'Rp. '));
        $('#showTotalBiayaAdmin').html(formatRupiah(Number(data.totalBA).toFixed(0), 'Rp. '));
        
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

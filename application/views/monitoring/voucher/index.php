<?php
  $dlv = $this->session->userdata("DLV");
  $ndv = $this->session->userdata("NDV");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status Pengisian</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="OPEN">OPEN</option>
                      <option value="CLOSE">CLOSE</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jenis SPJ</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <option value="" <?=$dlv == 'Y' && $ndv == 'Y'?'':'disabled'?>>ALL</option>
                      <?php foreach ($spj as $key): ?>
                      <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-5">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ atau Voucher BBM">
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnIsiVoucher">
                    Isi Voucher
                  </button>
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
      </div>
    </div>
    <div class="modal fade" id="modal-credit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>No SPJ</label>
                  <input type="text" id="inputNoSPJ" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>No Voucher</label>
                  <input type="text" id="inputNoVoucher" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Biaya</label>
                  <input type="number" id="inputBiaya" class="form-control form-control-sm">
                  <input type="hidden" id="inputBiayaAwal">
                </div>
              </div>
            </div>
            <input type="hidden" id="inputId">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-orange btn-kps ladda-button saveDebit" data-style="expand-right" id="saveDebit">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-isi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputTotalBiaya">
            <input type="hidden" id="inputTotalSPJ">
            <div class="row">
              <div class="col-1"></div>
              <div class="col-10">
                <form id="searchVoucher">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <span class="fa fa-search form-control-icon"></span>
                    <input type="search" class="form-control form-control-search" id="filSearchVoucher" placeholder="Cari Berdasarkan No SPJ atau Voucher BBM">
                  </div>
                </form>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="filPeriode">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-valign-middle table-striped table-hover" width="100%">
                    <thead class="text-center">
                      <tr>
                        <th></th>
                        <th>No SPJ</th>
                        <th>No Voucher BBM</th>
                        <th>Rp</th>
                      </tr>
                    </thead>
                    <tbody class="text-center" id="getDataTempBBM">
                      
                    </tbody>
                    <!-- <tfoot>
                      <tr>
                        <th colspan="3" class="text-right">Total Biaya:</th>
                        <th><span id="showTotalBBM"></span></th>
                      </tr>
                      <tr>
                        <th colspan="3" class="text-right">Total SPJ:</th>
                        <th><span id="showTotalSPJ"></span></th>
                      </tr>
                    </tfoot> -->
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="row" style="text-align:left !important;">
                <div class="col-md-12">
                  <table border="0" width="100%">
                    <tr>
                      <th>Total Biaya</th>
                      <th>: <span id="showTotalBBM"></span></th>
                    </tr>
                    <tr>
                      <th>Total SPJ</th>
                      <th>: <span id="showTotalSPJ"></span></th>
                    </tr>
                  </table>
                </div>
              </div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-orange btn-kps ladda-button saveVoucherBBM" data-style="expand-right" id="saveVoucherBBM">Save</button>
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
<script src="<?= base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    var mulaiPeriode = '<?=date('m/01/Y')?>';
    var akhirPeriode = '<?=date('m/t/Y')?>';
    $('#filPeriode').val(mulaiPeriode+" - "+akhirPeriode)
    $('#filPeriode').daterangepicker()
    // $('.preloader').fadeOut('slow');
    getTabel();
    $('.filter').on('change', function(){
      getTabel();
    });
    $('#search').submit(function(e){
      e.preventDefault()
      getTabel()
    });
    $('#searchVoucher').submit(function(e){
      e.preventDefault()
      getTabel()
    });
    $('#getTabel').on('click', '.getVoucher', function(){
      var noVoucher = $(this).attr("noVoucher");
      var noSPJ = $(this).attr("noSPJ");
      var idSPJ = $(this).attr("idSPJ");
      var credit = $(this).attr("credit");
      var uangBBM = $(this).attr("uangBBM");
      $('#inputId').val(idSPJ);
      $('#inputNoSPJ').val(noSPJ);
      $('#inputNoVoucher').val(noVoucher);
      $('#inputBiaya').val(credit)
      $('#inputBiayaAwal').val(uangBBM);
      document.getElementById("inputBiaya").focus()
      $('#modal-credit').modal("show")
      
    });

    var saveDebit = $('.saveDebit').ladda();
      saveDebit.click(function () {
      // Start loading
      saveDebit.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputBiaya = $('#inputBiaya').val();
        if (parseInt(inputBiaya)>0) {
          var kasbon = 'Kasbon Voucher BBM';
          $.ajax({
            type:'get',
            data:{kasbon},
            dataType: 'json',
            url:url+'/Implementasi/cekSaldo',
            cache: false,
            async: true,
            success: function(data){
              if (inputBiaya>data) {
                Swal.fire("Saldo Tidak Mencukupi!","Hubungi PIC Terkait","warning")
              }else{
                saveVoucher()
              }
              
            },
            error: function(data){

            }
          });
          
        }else{
          Swal.fire('Masukan Jumlah Biaya Voucher BBM Lebih dari Rp. 0!','','warning');
        }
        saveDebit.ladda('stop');
        return false;
          
      }, 1000)
    });
    $('#getDataTempBBM').on('click','[name="checkVoucher"]', function(){
      var voucher = $(this).attr("voucher");
      var rp = $('.inputTempVoucher#'+voucher).val();
      var noSPJ = $(this).attr("noSPJ");
      var kondisi;
      if ($('[name="checkVoucher"]#'+voucher).is(":checked")) {
        var biaya = rp;
        $('.inputTempVoucher#'+voucher).removeAttr("readonly","readonly");
        console.log("yes")
        kondisi = 'tambah';
      }else{
        var biaya = 0;
        $('.inputTempVoucher#'+voucher).attr("readonly","readonly");
        $('.inputTempVoucher#'+voucher).val("0");
        console.log("no")
        kondisi = 'hapus'
      }
      kondisiDBTemp(voucher, kondisi, noSPJ, biaya)

      console.log(biaya)
    })
    $('#btnIsiVoucher').on('click', function(){
      $.ajax({
        type:'get',
        dataType:'json',
        cache:false,
        async:true,
        url:url+'/monitoring/deleteTempBBM',
        success:function(data){
          getTempVoucher()
        },
        error:function(data){

        }
      })
    })
    $('#getDataTempBBM').on('keyup', '.inputTempVoucher', function(){
      var noSPJ = $(this).attr("noSPJ");
      var voucher = $(this).attr("voucher");
      var rp = $(this).val();
      saveTempBBM_SPJ(noSPJ, voucher, rp);
      
    })
    $('#getDataTempBBM').on('change', '.inputTempVoucher', function(){
      var noSPJ = $(this).attr("noSPJ");
      var voucher = $(this).attr("voucher");
      var rp = $(this).val();
      saveTempBBM_SPJ(noSPJ, voucher, rp);
      
    })
    var saveVoucherBBM = $('.saveVoucherBBM').ladda();
      saveVoucherBBM.click(function () {
      // Start loading
      saveVoucherBBM.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputTotalSPJ = $('#inputTotalSPJ').val();
        if (inputTotalSPJ == '0') {
          Swal.fire("Pilih SPJ nya Terlebih Dahulu","","info")
          saveVoucherBBM.ladda('stop');
        }else{
          $.ajax({
            type:'get',
            dataType:'json',
            cache:false,
            async:true,
            url:url+'/monitoring/getTotalAndSaldoBBM',
            success:function(data){
              if (parseInt(data.kasbon) > parseInt(data.saldo)) {
                Swal.fire("Saldo Sub Kas Tidak Cukup!","Isi Saldo Sub Kas BBM Terlebih Dahulu","warning")
              }else{
                saveAllVoucherBBM();
              }
            },
            complete:function(data){
              saveVoucherBBM.ladda('stop');
            },
            error:function(data){
              gagal()
            }
          })  
        }
        
        
        return false;
          
      }, 1000)
    });
    $('#filSearchVoucher').on('keyup', function(){
      getTempVoucher();
    })
    $('#filPeriode').on('change', function(){
      getTempVoucher();
    })

  })
    function getTabel() {
      var filStatus = $('#filStatus').val();
      var filJenis = $('#filJenis').val();
      var filSearch = $('#filSearch').val();
      $.ajax({
        type: 'get',
        url:'getMonVoucherBBM',
        data:{filStatus, filJenis, filSearch},
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
          $('#getTabel').html(data);
        }
      })
    }
    function getTempVoucher() {
      var filSearch = $('#filSearchVoucher').val();
      var filPeriode = $('#filPeriode').val();
      var periode = filPeriode.split(' - ');
      var periodeAwal = periode[0]
      var periodeAkhir = periode[1]
      $.ajax({
        type:'get',
        dataType:'json',
        data:{filSearch, periodeAwal, periodeAkhir},
        url:url+'/monitoring/getTempBBM_SPJ',
        cache:false,
        async:true,
        success:function(data){
          if (data.jml == '0') {
            $('#saveVoucherBBM').attr("disabled","disabled")
            $('#getDataTempBBM').html(data.kosong);
          }else{
            $('#getDataTempBBM').html(data.tabel);  
            $('#saveVoucherBBM').removeAttr("disabled","disabled")
            getTotalTempVoucherBBM();
          }
          $('#modal-isi').modal("show")
        },
        error:function(data){
          $('#getDataTempBBM').html("Gagal Mengambil Data")
        }
      })
    }
    function saveVoucher() {
      var inputNoSPJ= $('#inputNoSPJ').val();
      var inputBiaya = $('#inputBiaya').val();
      var inputNoVoucher =$('#inputNoVoucher').val();
      var inputId = $('#inputId').val();
      var inputBiayaAwal = $('#inputBiayaAwal').val();
      $.ajax({
        type:'post',
        data:{inputNoSPJ, inputBiaya, inputNoVoucher, inputId, inputBiayaAwal},
        cache: false,
        async: true,
        dataType:'json',
        url:'saveNominalVoucherBBM',
        success: function(data){
          berhasil()
          getTabel();
          $('#modal-credit').modal("hide")
        },
        error: function(data){
          gagal();
        }
      });
    }

    function saveAllVoucherBBM() {
      $.ajax({
        type:'post',
        dataType:'json',
        cache:false,
        async:true,
        url: url+'/monitoring/saveAllVoucherBBM',
        beforeSend:function(data){
          $('#saveVoucherBBM').attr("disabled","disabled");
        },
        success:function(data){
          berhasil()
          getTabel();
          $('#modal-isi').modal("hide")
        },
        complete:function(data){
          $('#saveVoucherBBM').removeAttr("disabled","disabled");
        },
        error:function(data){
          gagal();
        }
      })
    }
    function getTotalTempVoucherBBM() {
      $.ajax({
        type:'get',
        dataType:'json',
        cache:false,
        async:true,
        url: url+'/monitoring/getTotalTempVoucherBBM',
        success:function(data){
          $('#showTotalBBM').html(formatRupiah(String(data.total), 'Rp. '));
          $('#showTotalSPJ').html(data.jml);
          $('#inputTotalBiaya').val(data.total)
          $('#inputTotalSPJ').val(data.jml)
        },
        error:function(data){
          $('#showTotalBBM').html('Rp. 0');
          $('#showTotalSPJ').html('Rp. 0');
        }
      })
    }
    function kondisiDBTemp(voucher, kondisi, noSPJ, biaya) {
      $.ajax({
        type:'post',
        data:{voucher, kondisi, noSPJ, biaya},
        dataType:'json',
        url:url+'/monitoring/kondisiDBTemp',
        cache:false,
        async:true,
        success:function(data){
          getTotalTempVoucherBBM();
        },
        error:function(data){
           $('.inputTempVoucher#'+voucher).attr("readonly","readonly");
           Swal.fire("Inputan Biaya Tidak Bisa Diisi","Mohon Hubungi Staff IT","error")
        }
      })
    }
    function saveTempBBM_SPJ(noSPJ, voucher, rp) {
      $.ajax({
        type:'post',
        data:{noSPJ, voucher, rp},
        cache:false,
        async:true,
        url:url+'/monitoring/saveTempBBM_SPJ',
        success:function(data){
          getTotalTempVoucherBBM();
        },
        error:function(data){

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
</script>
<!-- FootJS -->
</body>
</html>

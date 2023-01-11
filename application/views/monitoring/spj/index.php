<!DOCTYPE html>

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
          <div class="card">
            <div class="card-body">
              <div class="row">
                <!-- <div class="col-md-1">
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
                      <?php foreach ($bulan as $angka => $bulan): ?>
                        <option value="<?=$bulan?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div> -->
                <div class="col-md-3">
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
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                     <option value="">ALL</option>
                     <option value="OPEN" selected>OPEN</option>
                     <option value="CLOSE">CLOSE</option>
                     <option value="Waiting For Generate">Waiting For Generate</option>
                     <option value="CANCEL">CANCEL</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Jenis SPJ</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <option value="" <?=$dlv == 'Y' && $ndv == 'Y' ? '' : 'disabled'?>>ALL</option>
                      <?php foreach ($spj as $key): ?>
                      <option value="<?=$key->ID_JENIS?>" <?=$key->ATTRIBUT?>><?=$key->NAMA_JENIS?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header border-0">
              <h5 class="card-title font-weight-bold"></h5>
              <div class="card-tools">
                <div class="btn-group">
                  <button type="button" class="btn btn-tool" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-h"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <!-- <a href="#" class="dropdown-item dropButton">Export To PDF</a> -->
                    <a href="<?=base_url()?>export_file/excel_spj" class="dropdown-item dropButton">Export To Excel</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
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

    <div class="modal fade" id="modal-serlok" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header border-0">
            <div class="modal-title">
              <label>Program SPJ Menemukan Data Outgoing dari Program Serlok. Kendaraan Dengan No TNKB <span id="titleTNKB"></span> Berangkat Ke Customer Berikut:</label>
            </div>
          </div>
          <div class="modal-body">
            <input type="hidden" id="inputNoSPJ">
            <input type="hidden" id="inputNoTNKB">
            <input type="hidden" id="inputTglSPJ">
            <input type="hidden" id="groupId">
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Departure Time</label>
                  <select class="select2" id="inputDepartureTime" multiple="multiple" data-placeholder="Pilih Departure Time Dari Program Serlok" data-dropdown-css-class="select2-orange" style="width: 100%;color: white !important;">
                    
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 table-responsive p-0">
                <table class="table table-hover table-valign-middle table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Company Name</th>
                      <th>Plant City</th>
                      <th>Departure Time</th>
                    </tr>
                  </thead>
                  <tbody id="getSerlok">
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveCustomerSerlok ladda-button" data-style="expand-right">Tambah Tujuan</button>
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
    var mulaiPeriode = '<?=$mulaiPeriode?>';
    var akhirPeriode = '<?=$akhirPeriode?>';
    console.log(akhirPeriode)
    $('#filPeriode').val(mulaiPeriode+" - "+akhirPeriode)
    $('#filPeriode').daterangepicker()
    $('.ladda-button').ladda('bind', {timeout: 1000});
    getTabel();
    var status = '<?=$status?>';
    if (status == 'berhasil') {
      berhasil();
    }

    $('.filter').on('change', function(){
      getTabel();
    })
    $('#search').submit(function(e){
      e.preventDefault();
      getTabel();
    })
    $('#getTabel').on('click','.btnCancel', function(){
      var id = $(this).attr("data");
      var status = $(this).attr("status");
      $.ajax({
        type:'post',
        dataType:'json',
        data:{id, status},
        url:'cancelSPJ',
        cache: false,
        async:true,
        success: function(data){
          berhasil();
          getTabel();
        },
        error: function(data){
          gagal()
        }
      });
    });
     $('#inputDepartureTime').on('change', function(){
      cekOutGoingSerlok();
      $('#modal-serlok').modal('show')
      
    })
    $('#getTabel').on('click','.reloadTujuan', function(){
      var inputNoSPJ = $(this).attr("noSPJ");
      var inputNoTNKB = $(this).attr("noTNKB");
      var inputTglSPJ = $(this).attr("tglSPJ")
      var groupId = $(this).attr("groupID")
      $('#inputNoSPJ').val(inputNoSPJ);
      $('#inputNoTNKB').val(inputNoTNKB);
      $('#inputTglSPJ').val(inputTglSPJ);
      $('#groupId').val(groupId);
      $('#modal-serlok').modal('show')
      getDepartureTime()
      cekOutGoingSerlok()
    })
    var saveCustomerSerlok = $('.saveCustomerSerlok').ladda();
      saveCustomerSerlok.click(function () {
      // Start loading
      saveCustomerSerlok.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputTglSPJ = $('#inputTglSPJ').val();
        var inputNoTNKB = $('#inputNoTNKB').val();
        var groupId = $('#groupId').val();
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
        $.ajax({
          type:'post',
          dataType:'json',
          data:{inputNoSPJ, inputTglSPJ, inputNoTNKB, whereDeparture},
          url:url+'/pengajuan/saveCustomerSerlok',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            $('#modal-serlok').modal("hide");
            cekGroupTujuanBaru(groupId, inputNoSPJ)
          },
          error:function(data){
            gagal()
          }
        });

        saveCustomerSerlok.ladda('stop');
        return false;
          
      }, 1000)
    });
  })

  function getTabel() {
    var filTahun = $('#filTahun').val();
    var filBulan = $('#filBulan').val();
    var filStatus = $('#filStatus').val();
    var filJenis = $('#filJenis').val();
    var filSearch = $('#filSearch').val();
    var filPeriode = $('#filPeriode').val();
    var periode = filPeriode.split(' - ');
    var periodeAwal = periode[0]
    var periodeAkhir = periode[1]
    $.ajax({
      type:'get',
      data:{filTahun, filBulan, filStatus, filJenis, filSearch, filPeriode, periodeAwal, periodeAkhir},
      url:'getTabelSPJ',
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
    });
  }
  function cekGroupTujuanBaru(groupId, inputNoSPJ) {
    $.ajax({
      type:'get',
      data:{inputNoSPJ, groupId},
      cache:false,
      async:true,
      dataType:'json',
      url:'getGroupTujuan',
      success:function(data){
        if (parseInt(groupId) != parseInt(data)) {
          updateSaldo(inputNoSPJ, groupId);
        }
      },
      error:function(data){
        gagal();
      }
    })
  }
  function updateSaldo(noSPJ, groupId) {
    $.ajax({
      type:'post',
      data:{noSPJ, groupId},
      dataType:'json',
      cache:false,
      async:true,
      url:url+'/pengajuan/reloadGroupSaldo',
      success:function(data){

      },
      error:function(data){

      }
    })
  }

  function cekOutGoingSerlok() {
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
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
    $.ajax({
      type:'get',
      data:{inputNoTNKB, inputTglSPJ, whereDeparture},
      dataType:'json',
      url:url+'/pengajuan/cekOutGoingSerlok',
      cache: false,
      async: true,
      success: function(data){
        var jmlData = data.length;
        var html='';
        if (jmlData>0) {
          for (var i = 0; i < data.length; i++) {
            html+='<tr>';
            html+='<td>'+data[i].COMPANY_NAME+'</td>';
            html+='<td>'+data[i].PLANT1_CITY+'</td>';
            html+='<td>'+data[i].departure_time+'</td>';
            html+='</tr>';
          }
          $('#getSerlok').html(html);
          $('#titleTNKB').html(inputNoTNKB);
          
        }else{
          Swal.fire(
            "Data Outgoing di Program Serlok Untuk Kendaraan Dengan No TNKB "+inputNoTNKB+" Pada Tanggal "+inputTglSPJ+" Tidak Ditemukan",
            "Hubungi PIC Terkait atau Masukan Data Secara Manual",
            "info")
        }
        

      },
      error: function(data){

      }
    })
  }

  function getDepartureTime() {
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
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

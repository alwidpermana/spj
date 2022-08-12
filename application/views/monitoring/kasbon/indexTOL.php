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
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Tahun</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                      <?php foreach ($tahun as $value): ?>
                        <option value="<?=$value?>"><?=$value?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Bulan</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filBulan">
                        <option value="">ALL</option>
                      <?php foreach ($bulan as $angka => $bulan): ?>
                        <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Jenis Kasbon</label>
                    <select class="select2 filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                      <option value="Kasbon TOL Delivery">TOL Delivery</option>
                      <option value="Kasbon TOL Non Delivery">TOL Non Delivery</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="select2 filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="Open">Open</option>
                      <option value="Waiting For Generate">Waiting For Generate</option>
                      <option value="Close">Close</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active text-kps" id="custom-content-below-kas_internal-tab" data-toggle="pill" href="#custom-content-below-kas_internal" role="tab" aria-controls="custom-content-below-kas_internal" aria-selected="true">Monitoring Kasbon</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-kps pengajuan" id="custom-content-below-pengajuan-tab" data-toggle="pill" href="#custom-content-below-pengajuan" role="tab" aria-controls="custom-content-below-pengajuan" aria-selected="false">Biaya Admin <sup><span class="badge bg-kps" id="jumlahNotif"></span></sup></a>
                    </li>
                  </ul>
                  <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-kas_internal" role="tabpanel" aria-labelledby="custom-content-below-kas_internal-tab">
                      <br>
                      <div class="row">
                        <div class="col-md-7"></div>
                        <div class="col-md-5">
                          <div class="row">
                            <div class="col-md-6 col-sm-2">
                              <div class="p-2 border border-dashed border-start-0 bg-white">
                                  <h6 class="mb-1" id="showSaldoKasInduk"></h6>
                                  <p class="text-muted mb-0">Saldo Kas Induk Bulan Sebelumnya</p>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-2">
                              <div class="p-2 border border-dashed border-start-0 bg-white">
                                  <h6 class="mb-1" id="showSaldoSubKas"></h6>
                                  <p class="text-muted mb-0">Saldo Sub Kas Bulan Sebelumnya</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="getTabel"></div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-pengajuan" role="tabpanel" aria-labelledby="custom-content-below-pengajuan-tab">
                      <br>
                      <div class="row">
                        <div class="col-md-2 col-sm-4">
                          <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnBiayaAdmin">
                            Tambah Biaya Admin
                          </button>                          
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="loader-card">
                            <div class="loader-card">
                                <div class="spinner"></div>
                                <div class="spinner-2"></div>
                            </div>
                          </div>
                          <div id="getBiayaAdmin"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-biaya_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputID">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tanggal Biaya Admin</label>
                  <input type="date" id="inputTglBiaya" class="form-control form-control-sm input" value="<?=date("Y-m-d")?>">
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jenis SPJ</label>
                  <select class="select2 form-control select2-orange input" data-dropdown-css-class="select2-orange" id="inputJenis">
                    <?php foreach ($spj as $key): ?>
                      <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Biaya</label>
                  <input type="number" id="inputBiaya" class="form-control form-control-sm input">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control input" id="inputKeterangan" rows="2"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveBiayaAdmin ladda-button" data-style="expand-right">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-validasi_approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="loader-card2">
                  <div class="loader-card2">
                      <div class="spinner"></div>
                      <div class="spinner-2"></div>
                  </div>
                </div>
                <form id="submit">
                  <div class="form-group">
                    <label>Masukan Kode</label>
                    <input type="hidden" id="inputIdApprove">
                    <input type="hidden" id="inputStatusApprove">
                    <input type="hidden" id="inputJenisApprove">
                    <input type="hidden" id="inputBiayaApprove">
                    <input type="password" class="form-control form-control-sm" id="inputKode">
                  </div>
                </form>
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
    $('.loader-card').fadeOut('slow');
    $('.loader-card2').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    getTabel();
    $('.filter').on('change', function(){
      getTabel()
      getLatestMonthKasbon()
    })
    getLatestMonthKasbon();
    $('.pengajuan').on('click', function(){
      getBiayaAdmin();
    });
    $('#btnBiayaAdmin').on('click', function(){
      $('#modal-biaya_admin').modal("show");
      $('#inputID').val("");
      validasiData();
    });
    $('.input').on('change', function(){
      validasiData();
    })
    $('.input').on('keyup', function(){
      validasiData();
    })
    var saveBiayaAdmin = $('.saveBiayaAdmin').ladda();
      saveBiayaAdmin.click(function () {
      // Start loading
      saveBiayaAdmin.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputTglBiaya = $('#inputTglBiaya').val();
        var inputJenis = $('#inputJenis').val();
        var inputBiaya = $('#inputBiaya').val();
        var inputKeterangan = $('#inputKeterangan').val();
        var inputID = $('#inputID').val();
        console.log(inputID)
        $.ajax({
          type:'post',
          dataType:'json',
          data:{inputTglBiaya, inputJenis, inputBiaya, inputKeterangan, inputID},
          url:'saveBiayaAdmin',
          cache: false,
          async: true,
          beforeSend: function(data){
            $('.loader-card').show();
            $('.saveBiayaAdmin').attr("disable","disable")
          },
          success: function(data){
            berhasil();
            getBiayaAdmin();
            $('#modal-biaya_admin').modal("hide");
            $('#inputId').val("");
            $('#inputKeterangan').val("");
            $('#inputBiaya').val("");
            $('.saveBiayaAdmin').removeAttr("disable","disable")
          },
          complete: function(data){
            $('.loader-card').fadeOut('slow');
            
          },
          error: function(data){
            gagal();
            $('.saveBiayaAdmin').removeAttr("disable","disable")
          }
        })
        saveBiayaAdmin.ladda('stop');
        return false;
          
      }, 1000)
    });
    $('#getBiayaAdmin').on('click','.btnApprove', function(){
      var id = $(this).attr("data");
      var status = $(this).attr("status");
      var jenis = $(this).attr("jenis");
      var biaya = $(this).attr("biaya");
      $('#inputIdApprove').val(id)
      $('#inputStatusApprove').val(status)
      $('#inputJenisApprove').val(jenis)
      $('#inputBiayaApprove').val(biaya)
      $('#modal-validasi_approve').modal("show")
    });

    $('#submit').submit(function(e){
      e.preventDefault();
      var inputKode = $('#inputKode').val();
      var inputIdApprove = $('#inputIdApprove').val()
      var inputStatusApprove = $('#inputStatusApprove').val()
      var inputJenisApprove = $('#inputJenisApprove').val()
      var inputBiayaApprove = $('#inputBiayaApprove').val()
      $.ajax({
        type:'get',
        data:{inputKode},
        dataType: 'json',
        url:'getKodeApprove',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.loader-card2').show();
        },
        success: function(data){

          if (data==1) {
            if (inputStatusApprove == 'APPROVED') {
              cekSaldo(inputIdApprove,inputStatusApprove,inputJenisApprove, inputBiayaApprove);
              // console.log("ke saldo")
            } else {
              approveBiayaAdmin(inputJenisApprove,inputBiayaApprove)  
            }
            
          } else {
            Swal.fire("Kode Tidak Ditemukan!","","warning")
          }

        },
        complete: function(data){
          $('.loader-card2').fadeOut("slow");
          $('#inputKode').val("");
        },
        error:function(data){
          Swal.fire("Gagal Mengambil Data","Hubungi Staff IT","error")
        }
      })
    })

    $('#getBiayaAdmin').on('click','.btnUpdate', function(){
      var id = $(this).attr("data");
      var tgl = $(this).attr("tgl");
      var jenis = $(this).attr("jenis");
      var biaya = $(this).attr("biaya");
      var keterangan = $(this).attr("keterangan");
      $('#modal-biaya_admin').modal("show")
      $('#inputTglBiaya').val(tgl);
      $('#inputBiaya').val(biaya);
      $('#inputKeterangan').val(keterangan);
      $("select#inputJenis option[value='"+jenis+"']").prop("selected","selected");
      $("select#inputJenis").trigger("change")
      $('#inputID').val(id);
    });
    $('#getBiayaAdmin').on('click', '.btnHapus', function(){
      var id = $(this).attr("data")
      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Menghapus Data Biaya Admin",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Hapus Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            dataType: "JSON",
            url: 'hapusBiayaAdmin',
            data:{id},
            cache: false,
            async: false,
            success: function(data){
              berhasil();
              getBiayaAdmin();

            },
            error: function(data){
              gagal();
            }
          })
        }
      })
    });


  })
  function getTabel() {
    var filBulan = $("#filBulan").val();
    var filTahun = $('#filTahun').val();
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();

    $.ajax({
      type:'get',
      data:{filBulan, filTahun, filJenis, filStatus},
      url:'getMonitoringKasbon',
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
      errors: function(data){

      }      
    })
  }

  function getLatestMonthKasbon() {
    var filBulan = $("#filBulan").val();
    var filTahun = $('#filTahun').val();
    var filJenis = $('#filJenis').val();
    $.ajax({
      type:'get',
      dataType:'json',
      data:{filBulan,filTahun, filJenis},
      cache: false,
      async: true,
      url:'getLatestMonthKasbon',
      success: function(data){
        console.log(data.SALDO_INDUK);
        $('#showSaldoKasInduk').html(formatRupiah(Number(data.SALDO_INDUK).toFixed(0), 'Rp. '))
        $('#showSaldoSubKas').html(formatRupiah(Number(data.SALDO_SUB).toFixed(0), 'Rp. '))
        // 
      },
      error: function(data){

      }
    })
  }

  function getBiayaAdmin() {
    var filJenis = $('#filJenis').val();
    var filTahun = $('#filTahun').val();
    $.ajax({
      type:'get',
      data:{filJenis, filTahun},
      url:'getBiayaAdmin',
      cache: false,
      async: true,
      beforeSend: function(data){
         $('.loader-card').show();
      },
      success: function(data){
        $('#getBiayaAdmin').html(data);
      },
      complete: function(data){
         $('.loader-card').fadeOut("slow");
      },
      error: function(data){

      }
    });
  }

  function validasiData() {
    var inputTglBiaya = $('#inputTglBiaya').val();
    var inputJenis = $('#inputJenis').val();
    var inputBiaya = $('#inputBiaya').val();
    var inputKeterangan = $('#inputKeterangan').val();
    if (inputTglBiaya == '' || inputJenis == '' || inputBiaya == '' || inputKeterangan == '') {
      $('.saveBiayaAdmin').attr("disabled","disabled");
    }else{
      $('.saveBiayaAdmin').removeAttr("disabled","disabled");
    }
  }

  function approveBiayaAdmin(kasbon, biaya, totalBiaya) {
    var inputId = $('#inputIdApprove').val()
    var inputStatus = $('#inputStatusApprove').val()
    $.ajax({
      type:'post',
      data:{inputId, inputStatus, kasbon, biaya, totalBiaya},
      dataType:'json',
      url:'approveBiayaAdmin',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.loader-card2').show();
      },
      success: function(data){
        berhasil()
        $('#modal-validasi_approve').modal("hide");
        $('#inputIdApprove').val("")
        $('#inputStatusApprove').val("")
        getBiayaAdmin();
      },
      complete: function(data){
        $('.loader-card2').fadeOut("slow");
      },
      error: function(data){
        gagal();
      }
    })
  }

  function cekSaldo(id,status,jenis, biaya) {
    var kasbon = jenis == '1'?'Kasbon TOL Delivery':'Kasbon TOL Non Delivery';
    $.ajax({
      type:'get',
      data:{kasbon},
      dataType: 'json',
      url:url+'/Implementasi/cekSaldo',
      cache: false,
      async: true,
      success: function(data){
        if (biaya>data) {
          Swal.fire("Saldo Tidak Mencukupi!","Hubungi PIC Terkait","warning")
        }else{
          approveBiayaAdmin(kasbon,biaya, data)
          // console.log("berhasil")
        }
      },
      error: function(data){

      }
    });
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

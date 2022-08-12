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
                <div class="col-md-2">
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
                        <option value="<?=$angka?>" <?=$angka == date("n")?'selected':''?>><?=$bulan?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Saldo</label>
                    <input type="text" id="inputSaldo" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active text-kps" id="custom-content-below-kas_internal-tab" data-toggle="pill" href="#custom-content-below-kas_internal" role="tab" aria-controls="custom-content-below-kas_internal" aria-selected="true">Kas Internal</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link text-kps pengajuan" id="custom-content-below-pengajuan-tab" data-toggle="pill" href="#custom-content-below-pengajuan" role="tab" aria-controls="custom-content-below-pengajuan" aria-selected="false">Pengajuan <sup><span class="badge bg-kps" id="jumlahNotif"></span></sup></a>
                        </li>
                      </ul>
                      <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="custom-content-below-kas_internal" role="tabpanel" aria-labelledby="custom-content-below-kas_internal-tab">
                          <br> 
                          <div id="getTabelKas"></div>
                        </div>
                        <div class="tab-pane fade" id="custom-content-below-pengajuan" role="tabpanel" aria-labelledby="custom-content-below-pengajuan-tab">
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn bg-orange btn-kps btn-sm" id="btnTambahKas">
                                Ajukan Kas
                              </button>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="loader-card">
                                <div class="loader-card">
                                    <div class="spinner"></div>
                                    <div class="spinner-2"></div>
                                </div>
                              </div>
                              <div id="getTabelPengajuan"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header border-0">
                  <div class="card-title">Modal Awal</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabelModalAwal"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-kas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputID">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Transaksi</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputTransaksi">
                    <option value="">Pilih Transaksi</option>
                    <option value="Modal Awal">Modal Awal</option>
                    <option value="Pinbuk">Pinbuk</option>
                  </select>
                  <input type="hidden" id="inputTransaksiAwal">
                </div>
              </div>
            </div>
            <div class="row afterTransaksi d-none" > 
              <div class="col-md-12">
                <div class="form-group">
                  <label><span id="textTujuan"></span></label>
                  <div class="modalAwal">
                    <input type="text" id="inputDari" class="form-control" value="Internal">
                  </div>
                  <div class="pinbuk">
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKe">
                      <option value="Kasbon SPJ Delivery">Kasbon SPJ Delivery</option>
                      <option value="Kasbon SPJ Non Delivery">Kasbon SPJ Non Delivery</option>
                      <option value="Kasbon TOL Delivery">Kasbon TOL Delivery</option>
                      <option value="Kasbon TOL Non Delivery">Kasbon TOL Non Delivery</option>
                      <option value="Kasbon Voucher BBM">Kasbon Voucher BBM</option>
                    </select>
                  </div>
                  <input type="hidden" id="inputTujuanAwal">
                </div>
              </div>
            </div>
            <div class="row afterTransaksi d-none">
              <div class="col-md-12">
                <div class="form-group">
                  <label><span id="textBiaya"></span></label>
                  <input type="number" id="inputBiaya" class="form-control">
                  <input type="hidden" id="inputBiayaAwal">
                </div>
              </div>
            </div>
            <!-- <div class="row afterTransaksi d-none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Kode Approve</label>
                  <input type="password" id="inputKodeApprove" class="form-control">
                </div>
              </div>
            </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveTransaksi ladda-button" data-style="expand-right" id="tambahKas" disabled>Save</button>
            <button type="button" class="btn bg-orange btn-kps updateTransaksi ladda-button" data-style="expand-right" id="updateKas">Save</button>
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
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    $('.filter').on('change', function(){
      getTabelKas()
    })
   getTabelKas()
   getTabelModalAwal();
   getSaldoKasInduk();
   $('#btnTambahKas').on('click', function(){
    $('#modal-kas').modal("show")
    $('#tambahKas').removeClass("d-none");
    $('#updateKas').addClass("d-none");
    $('#inputKodeApprove').val("");
    $("select#inputTransaksi option[value='Modal Awal']").prop("disabled","");
    $("select#inputTransaksi option[value='Pinbuk']").prop("disabled","");
    $("select#inputTransaksi option[value='']").prop("disabled","");
    $("select#inputTransaksi option[value='']").prop("selected","selected");
    $('.afterTransaksi').addClass("d-none");
   })
   $('#inputTransaksi').on('change', function(){
    var transaksi = $(this).val();
    if (transaksi == 'Modal Awal') {
      $('.afterTransaksi').removeClass("d-none");
      $('.modalAwal').removeClass("d-none");
      $('.pinbuk').addClass("d-none");
      $('#textTujuan').html("Dari");
      $('#textBiaya').html("Debit");
      $('.saveTransaksi').removeAttr("disabled","disabled");
    }else if(transaksi == 'Pinbuk'){
      $('.afterTransaksi').removeClass("d-none");
      $('.modalAwal').addClass("d-none");
      $('.pinbuk').removeClass("d-none");
      $('#textTujuan').html("Ke");
      $('#textBiaya').html("Credit");
      $('.saveTransaksi').removeAttr("disabled","disabled");
    }else{
      $('.afterTransaksi').addClass("d-none");
      $('.saveTransaksi').attr("disabled","disabled");
    }
   })

   var saveTransaksi = $('.saveTransaksi').ladda();
      saveTransaksi.click(function () {
      // Start loading
      saveTransaksi.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputTransaksi = $('#inputTransaksi').val();
        var inputDari = $('#inputDari').val();
        var inputKe = $('#inputKe').val();
        var inputBiaya = $('#inputBiaya').val();
        var inputTujuan = inputTransaksi == 'Modal Awal'?inputDari:inputKe;
        if (inputBiaya == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
        } else {
          saveBukuKas(inputTransaksi, inputTujuan, inputBiaya);  
        }
        
        saveTransaksi.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('#getTabelPengajuan').on('click','.btnUpdate', function(){
      $('#inputKodeApprove').val("");
      $('#modal-kas').modal("show")
      $('#tambahKas').addClass("d-none");
      $('#updateKas').removeClass("d-none");
      $('.afterTransaksi').removeClass("d-none");
      var tujuan = $(this).attr("tujuan");
      var transaksi = $(this).attr("transaksi")
      var biaya = $(this).attr("biaya")
      var id = $(this).attr("data")
      $("select#inputTransaksi option[value='"+transaksi+"']").prop("selected","selected");
      $("select#inputTransaksi").trigger("change");
      $("select#inputTransaksi option[value='']").prop("disabled","disabled");
      $('#inputBiaya').val(biaya);
      $('#inputID').val(id);
      $('#inputTujuanAwal').val(tujuan);
      $('#inputBiayaAwal').val(biaya);
      if (transaksi == 'Modal Awal') {
        $('#inputDari').val(tujuan);
        $("select#inputTransaksi option[value='Pinbuk']").prop("disabled","disabled");
        $("select#inputTransaksi option[value='Modal Awal']").prop("disabled","");
        $('.afterTransaksi').removeClass("d-none");
        $('.modalAwal').removeClass("d-none");
        $('.pinbuk').addClass("d-none");
        $('#textTujuan').html("Dari");
        $('#textBiaya').html("Debit");
      } else {
        $("select#inputKe option[value='"+tujuan+"']").prop("selected","selected");
        $("select#inputKe").trigger("change");
        $("select#inputTransaksi option[value='Modal Awal']").prop("disabled","disabled");
        $("select#inputTransaksi option[value='Pinbuk']").prop("disabled","");
        $('.afterTransaksi').removeClass("d-none");
        $('.modalAwal').addClass("d-none");
        $('.pinbuk').removeClass("d-none");
        $('#textTujuan').html("Ke");
        $('#textBiaya').html("Credit");
      }

     })

    var updateTransaksi = $('.updateTransaksi').ladda();
      updateTransaksi.click(function () {
      // Start loading
      updateTransaksi.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var jenis = "UPDATE KAS";
        var inputKodeApprove = $('#inputKodeApprove').val();
        // console.log(inputKodeApprove);
        $.ajax({
          type:'get',
          data:{jenis, inputKodeApprove},
          dataType: 'json',
          url:'getKodeApprove',
          cache: false,
          async: true,
          success: function(data){
            var inputTransaksi = $('#inputTransaksi').val();
            var inputDari = $('#inputDari').val();
            var inputKe = $('#inputKe').val();
            var inputBiaya = $('#inputBiaya').val();
            var inputTujuan = inputTransaksi == 'Modal Awal'?inputDari:inputKe;
            updateBukuKas(inputTransaksi, inputTujuan, inputBiaya)
            // if (inputTransaksi == '' || inputBiaya == '' || inputTujuan == '') {
            //   Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
            // }else{
            //   if (parseInt(data)==1) {
            //     cekBukuKas(inputTransaksi, inputTujuan, inputBiaya, 'update')  
            //   }else{
            //     Swal.fire("Kode Approve Yang Anda Masukan Salah!","","error");
            //   }
            // }
          },
          error: function(data){
            gagal()
          }
        })
        $('#inputKodeApprove').val("");
        updateTransaksi.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('#getTabelPengajuan').on('click', '.btnHapus', function(){
      var tujuan = $(this).attr("tujuan");
      var transaksi = $(this).attr("transaksi")
      var biaya = $(this).attr("biaya")
      var id = $(this).attr("data")
      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Menghapus Data Buku Kas Akan Mempengaruhi Seluruh Data Saldo, Untuk Menghindari terjadinya Ketidaksesuaian Data, Mohon Hubungi PIC Terkait",
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
            url: 'hapusKasPengajuan',
            data:{id, transaksi, tujuan, biaya},
            cache: false,
            async: false,
            success: function(data){
              berhasil();
              getTabelPengajuan();

            },
            error: function(data){
              gagal();
            }
          })
        }
      })
    });
    $('.pengajuan').on('click', function(){
      getTabelPengajuan();
    });

    $('#getTabelPengajuan').on('click','#approvePengajuan', function(){
      var inputTujuan = $(this).attr("tujuan");
      var inputTransaksi = $(this).attr("transaksi")
      var inputBiaya = $(this).attr("biaya")
      var id = $(this).attr("data")
      cekBukuKas(id,inputTransaksi, inputTujuan, inputBiaya, 'Modal Awal')
    })

  })
  
  function getTabelKas() {
    var filTahun = $('#filTahun').val();
    var filBulan = $('#filBulan').val();
    $.ajax({
      type:'get',
      data:{filTahun, filBulan},
      url:'getTabelKas',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getTabelKas').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error: function(data){

      }
    })
  }
  function getTabelPengajuan() {
    var filTahun = $('#filTahun').val();
    var filBulan = $('#filBulan').val();
    $.ajax({
      type:'get',
      data:{filTahun, filBulan},
      url:'getTabelPengajuanKasInternal',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.loader-card').show();
      },
      success: function(data){
        $('#getTabelPengajuan').html(data);
      },
      complete: function(data){
        $('.loader-card').fadeOut('slow');
      },
      error: function(data){

      }
    })
  }
  function getTabelModalAwal() {
    var filTahun = $('#filTahun').val();
    var filBulan = $('#filBulan').val();

    $.ajax({
      type:'get',
      data:{filTahun, filBulan},
      url:'getTabelModalAwal',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getTabelModalAwal').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error: function(data){

      }
    });
  }
  function saveBukuKas(inputTransaksi, inputTujuan, inputBiaya, saldo) {
    $.ajax({
      type:'post',
      dataType:'json',
      data:{inputTransaksi, inputTujuan, inputBiaya, saldo},
      url:'saveBukuKas2',
      cache: false,
      async: true,
      success:function(data){
        berhasil();
        $('#modal-kas').modal('hide');
        getTabelPengajuan();
        if (inputTransaksi == 'Modal Awal') {
          getTabelModalAwal();
        }
        getSaldoKasInduk();
      },
      error:function(data){
        gagal();
      }
    })
  }
  function updateBukuKas(inputTransaksi, inputTujuan, inputBiaya) {
    var inputTujuanAwal = $('#inputTujuanAwal').val();
    var inputBiayaAwal = $('#inputBiayaAwal').val();
    var inputID = $('#inputID').val();
    $.ajax({
      type:'post',
      dataType:'json',
      data:{inputTransaksi, inputTujuan, inputBiaya, inputTujuanAwal, inputBiayaAwal, inputID},
      url:'updateBukuKasPengajuan',
      cache: false,
      async: true,
      success:function(data){
        berhasil();
        getTabelPengajuan();
        $('#modal-kas').modal('hide');
        getSaldoKasInduk()
        // if (inputTransaksi == 'Modal Awal') {
        //   getTabelModalAwal();
        // }
      },
      error:function(data){
        gagal();
      }
    })
  }
  function cekBukuKas(id,inputTransaksi, inputTujuan, inputBiaya, jenis) {
    var jenisKasbon = 'Modal Awal';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{jenis:jenisKasbon},
      url:'cekSaldoAwal',
      cache: false,
      async: true,
      success: function(data){
        var saldo = parseInt(data.SALDO);
        var totalSaldo = 0;
        var inputBiayaAwal = $('#inputBiayaAwal').val();
        if (saldo < parseInt(inputBiaya) && inputTransaksi == 'Pinbuk') {
          Swal.fire("Saldo Modal Awal Tidak Cukup!","","warning")
        }else{
          approvePengajuan(id, inputTujuan, inputTransaksi, inputBiaya, saldo)
        }

        

        // if (inputTransaksi == 'Modal Awal') {
        //   saveBukuKas(inputTransaksi, inputTujuan, inputBiaya, saldo);
        // }else{
           
        // }
        
        console.log(data)
      },
      error: function(data){
        gagal()
      }
    })
  }
  function approvePengajuan(id, inputTujuan, inputTransaksi, inputBiaya, saldo) {
    $.ajax({
      type:'post',
      data:{id, inputTujuan, inputTransaksi, inputBiaya, saldo},
      dataType: 'json',
      cache: false,
      async: true,
      url:'approvePengajuanKasInternal',
      success: function(data){
        berhasil()
        getTabelKas()
        getTabelPengajuan()
        getSaldoKasInduk()
      }, 
      error: function(data){
        gagal()
      }
    });
  }
  function getSaldoKasInduk() {
    $.ajax({
      dataType:'json',
      url:'getSaldoBukuKasInternal',
      cache: false,
      async: true,
      success: function(data){
        var saldo = formatRupiah(Number(data).toFixed(0), 'Rp. ');
        $('#inputSaldo').val(saldo);
      },
      error: function(data){
        $('#inputSaldo').val("0");
      }
    });
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

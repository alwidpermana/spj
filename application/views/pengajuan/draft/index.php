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
          <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
              <form id="search">
                <div class="form-group">
                  <span class="fa fa-search form-control-icon"></span>
                  <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No SPJ">
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
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
    
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   $('#search').submit(function(e){
    e.preventDefault();
    getTabel();
   })
   getTabel();
   $('#getTabel').on('click', '.approve', function(){
    var inputNoSPJ = $(this).attr("noSPJ");
    var id = $(this).attr("data");
    var total = $(this).attr("total");
    var kendaraan = $(this).attr("kendaraan");
    var jenisId = $(this).attr("jenisId");
    var bbm = $(this).attr("bbm")
    var mediaBBM = $(this).attr("mediaBBM");
    Swal.fire({
        title: 'Apakah Anda Yakin Approve SPJ Ini?',
        text: "Pastikan Biaya Kasbon dan Data lainnya Sudah Sesuai",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Approve Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          
          $.ajax({
            type: 'get',
            data:{inputNoSPJ},
            dataType: 'json',
            url:url+'/pengajuan/cekKelengkapanDataSPJ',
            async: true,
            cache: false,
            success: function(data){
              if (data.SPJ <=0) {
                Swal.fire("Lengkapi Terlebih Dahulu Datanya!","","warning")
              }else if(data.JML_LOKASI <= 0){
                Swal.fire("Data Lokasi Tujuan Masih Kosong!","Mohon Untuk Menambahkan Data Lokasi Tujuan","warning")
              }else if(data.JML_PIC <= 0){
                Swal.fire("Data PIC Masih Kosong!","Mohon Untuk Menambahkan Data PIC","warning")
              }else{
                cekAdaDriver(inputNoSPJ, id, total, kendaraan, jenisId, bbm, mediaBBM);
              }
            },
            error: function(data){

            }
          });
        }
      })
   })
   $('#getTabel').on('click','.btnCancel', function(){
    var id = $(this).attr("data");
    $.ajax({
      type:'post',
      dataType:'json',
      data:{id, status},
      url:url+'/pengajuan/cancelSPJ',
      cache: false,
      async:true,
      success: function(data){
        Swal.fire("Berhasil Meembatalkan SPJ","","success");
        getTabel();
      },
      error: function(data){
        Swal.fire("gagal Meembatalkan SPJ","Hubungi Staff IT","error")
      }
    });
  });

  })
  function getTabel() {
    var filSearch = $('#filSearch').val();
    $.ajax({
      type:'get',
      data:{filSearch},
      cache:true,
      async:true,
      url:'getTabelDrafSPJ',
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getTabel').html(data);
      },
      complete:function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error:function(data){
       Swal.fire("Gagal Mengambil Data","Hubungi Staff IT","error") 
      }
    })
  }

  function cekAdaDriver(inputNoSPJ, id, total, kendaraan, jenisId, bbm, mediaBBM) {
    console.log(inputNoSPJ)
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputNoSPJ},
      url: url+'/pengajuan/cekAdaDriver',
      async: true,
      cache: false,
      success: function(data){
        // if (inputKendaraan == 'Rental') {
        //   cekSaldo(status);
        // } else {
            
        // }
        if (parseInt(data)>0) {
          cekSaldo(inputNoSPJ, id, total, kendaraan, jenisId, bbm, mediaBBM);
        } else {
          Swal.fire("Tidak Terdapat Driver Pada SPJ Ini!","PIC yang di daftarkan Tidak ada yang memiliki otoritas Driver!","warning")
        }
        
      },
      error: function(data){

      }
    })
  }
  function cekSaldo(inputNoSPJ, id, total, kendaraan, inputJenisSPJ, bbm, mediaBBM) {
    

    var kasbonSPJ =total;

    $.ajax({
      type:'get',
      data:{inputJenisSPJ},
      dataType:'json',
      cache: false,
      async: true,
      url:url+'/pengajuan/cekSaldoSubKas',
      success: function(data){
        // getNoVoucher();
        // kondisiBBM()
        console.log(kasbonSPJ)
        console.log(data.saldoSPJ)
        if (inputJenisSPJ == '3') {
          approveSPJ(inputNoSPJ, id, total, kendaraan, inputJenisSPJ, bbm, mediaBBM)
        }else{
          if (parseInt(kasbonSPJ) >= parseInt(data.saldoSPJ)) {
            Swal.fire("Kasbon SPJ Melebihi Jumlah Saldo Sub Kas!","Hubungi PIC Terkait","warning")
          }else{
            approveSPJ(inputNoSPJ, id, total, kendaraan, inputJenisSPJ, bbm, mediaBBM);
          }  
        }
        
      },
      error: function(data){

      }
    })
  }
  function approveSPJ(inputNoSPJ, id, total, kendaraan, inputJenisSPJ, bbm, mediaBBM) {
    $.ajax({
      type:'post',
      data:{inputNoSPJ, id, total, bbm, mediaBBM},
      dataType:'json',
      url:'approveSPJDraft',
      cache:false,
      async:true,
      success:function(data){
        Swal.fire("Berhasil Approve Data","","success");
        window.location.href = '<?=base_url()?>monitoring/spj';
      },
      error:function(data){
        Swal.fire("Gagal Approve Data","Hubungi Staff IT", "error");
      }
    })
  }
  function printSPJ(id, media) {
    var url2 = url+"/monitoring/print_spj/"+id+"?filStatus=DRAFT";
    window.open(url2,'_blank');
    if (media == 'Voucher') {
      var url1 = url+"/monitoring/print_voucher/"+id+"?filStatus=DRAFT";
      window.open(url1,'_blank');  
    }
    
    
    console.log(url2)
    console.log(url1)
  }
  

</script>
<!-- FootJS -->
</body>
</html>

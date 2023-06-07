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
                    <select class="select2 form-control select2-orange filter" data-dropdown-css-class="select2-orange" id="inputJenis">
                      <option value="1">Delivery</option>
                      <option value="2" selected>Non Delivery</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Rekanan</label>
                    <select class="select2 form-control select2-orange filter" data-dropdown-css-class="select2-orange" id="inputRekanan">
                      <?php foreach ($rekanan as $rn): ?>
                        <option value="<?=$rn->ID?>"><?=$rn->NAMA?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label>Jumlah SPJ</label>
                </div>
                <div class="col-md-10 col-sm-9">
                  : <span id="viewJumlahSPJ"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label>Sewa Kendaraan</label>
                </div>
                <div class="col-md-10 col-sm-9">
                  : <span id="viewSewaKendaraan"></span>

                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label>Potongan PPh</label>
                </div>
                <div class="col-md-10 col-sm-9">
                  : <span id="viewPotonganPPh"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label>Total Pembayaran</label>
                </div>
                <div class="col-md-10 col-sm-9">
                  : <span id="viewTotalPembayaran"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2 col-sm-3">
                  <label>No Generate</label>
                </div>
                <div class="col-md-10 col-sm-9">
                  : <?=$noGenerate?>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="getTabel"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-sm-4"></div>
                <div class="col-md-4 col-sm-4">
                  <button type="button" class="btn btn-kps bg-orange btn-block" id="btnGenerate">Generate</button>
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
    $('.preloader').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabel();
   $('.filter').on('change', function(){
    getTabel();
   })
   $('#getTabel').on('click','[name="inputAllData"]', function(){
      var cekAll = $(this)[0].checked;
      if (cekAll == true) {
        $('.checkSPJ').attr("checked","checked");
      } else {
        $('.checkSPJ').removeAttr("checked","checked");
      }
      getCheckData();
      
      // $('#viewSewaKendaraan').val(sewaKendaraan)

    });
   $('#getTabel').on('click','[name="inputCheckSPJ"]', function(){
      getCheckData();
    })
   $('#btnGenerate').on('click', function(){
    var inputSPJ = [];
    var jmlSpj = 0;
    $.each($('[name="inputCheckSPJ"]:checked'), function(){
      inputSPJ.push($(this).val());
      jmlSpj+=1;
    })
    var inputJenis = $('#inputJenis').val();
    var inputRekanan = $('#inputRekanan').val();
    if (jmlSpj == 0) {
      Swal.fire("Pilih Dulu SPJ nya!","","warning")
    }else{
      $.ajax({
        type:'post',
        data:{inputSPJ, inputJenis, inputRekanan},
        dataType:'json',
        cache:false,
        async:true,
        url:'saveGenerateKendaraan',
        beforeSend:function(data){
          $('#btnGenerate').attr("disabled",true)
          $('.preloader-no-bg').show();
        },
        success:function(data){
          Swal.fire("Berhasil Generate Data Kendaraan Rental","","success")
          getTabel();
          $('#viewJumlahSPJ').html(0)
          $('#viewSewaKendaraan').html(formatRupiah(Number(0).toFixed(0), 'Rp. '))
          $('#viewPotonganPPh').html(formatRupiah(Number(0).toFixed(0), 'Rp. '))
          $('#viewTotalPembayaran').html(formatRupiah(Number(0).toFixed(0), 'Rp. '))
        },
        complete:function(data){
          $('#btnGenerate').attr("disabled",false)
          $('.preloader-no-bg').fadeOut("slow")
        },
        error:function(data){
          Swal.fire("Gagal Generate Data Kendaraan Rental","Hubungi Staff IT","error")
        }
      })
    }
   })

  })
  function getTabel() {
    var inputJenis = $('#inputJenis').val();
    var inputRekanan = $('#inputRekanan').val();
    $.ajax({
      type:'get',
      data:{inputJenis, inputRekanan},
      cache:false,
      async:true,
      url:'getDataGenerateKendaraan',
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getTabel').html(data)
      },
      complete:function(data){
        $('.preloader-no-bg').fadeOut("slow")
      },
      error:function(data){
        $('#getTabel').html("Data Gagal Diambil")
      }
    })
  }
  function getCheckData() {
    var noSPJ = [];
    var jml = 0;
    $.each($('[name="inputCheckSPJ"]:checked'), function(){
      noSPJ.push($(this).val());
      jml +=1;
    })
    var sewaKendaraan = jml * 250000;
    var potonganPPh = sewaKendaraan*0.25;
    var total = sewaKendaraan - potonganPPh;
    $('#viewJumlahSPJ').html(jml)
    $('#viewSewaKendaraan').html(formatRupiah(Number(sewaKendaraan).toFixed(0), 'Rp. '))
    $('#viewPotonganPPh').html(formatRupiah(Number(potonganPPh).toFixed(0), 'Rp. '))
    $('#viewTotalPembayaran').html(formatRupiah(Number(total).toFixed(0), 'Rp. '))
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

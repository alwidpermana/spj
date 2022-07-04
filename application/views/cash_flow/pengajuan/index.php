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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Jenis Pengajuan</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filJenis">
                          <option value="">ALL</option>
                          <option value="Kasbon SPJ">Kasbon SPJ</option>
                          <option value="Kasbon TOL">Kasbon TOL</option>
                          <option value="Kasbon BBM">Kasbon BBM</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                          
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn bg-orange btn-kps btn-block" id="btnPengajuan">
                          <i class="fas fa-plus"></i> &nbsp; &nbsp;Ajukan Saldo Sub Kas
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header border-0">
                  <h5 class="card-title font-weight-bold"></h5>
                  <div class="card-tools">
                    <div class="btn-group">
                      <button type="button" class="btn btn-tool" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="#" class="dropdown-item dropButton">Export To PDF</a>
                        <a href="#" class="dropdown-item dropButton">Export To Excel</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getPengajuan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="modal-pengajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputID">
            <input type="hidden" id="inputJenisData">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jenis Kasbon</label>
                  <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisKasbon">
                    <option value="Kasbon SPJ">Kasbon SPJ</option>
                    <option value="Kasbon TOL">Kasbon TOL</option>
                    <option value="Kasbon BBM">Kasbon BBM</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jenis SPJ</label>
                  <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisSPJ">
                    <?php foreach ($spj as $key): ?>
                      <option value="<?=$key->ID_JENIS?>"><?=$key->NAMA_JENIS?></option>
                    <?php endforeach ?>
                      <option value="0">-</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jumlah Biaya</label>
                  <span class="form-control-icon">Rp</span>
                  <input type="number" class="form-control form-control-search" id="inputBiaya">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps savePengajuan ladda-button" data-style="expand-right" step="1">Save</button>
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
    $('#btnPengajuan').on('click', function(){
      $('#modal-pengajuan').modal("show")
      $('#inputJenisData').val("tambah");
      $('#inputID').val("");
      $('#inputBiaya').val("");
    });
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();

    $('#inputJenisKasbon').on('change', function(){
      kondisiPilihanJenisSPJ()
    });
    getPengajuan()
    kondisiPilihanJenisSPJ();
    var savePengajuan = $('.savePengajuan').ladda();
      savePengajuan.click(function () {
      // Start loading
      savePengajuan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisKasbon = $('#inputJenisKasbon').val();
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        var inputBiaya = parseInt($('#inputBiaya').val());
        if (inputBiaya>0) {
          cekSaldo(inputJenisKasbon, inputJenisSPJ, inputBiaya);
        }else{
          Swal.fire("Masukan Jumlah Biaya Lebih dari 0!","","warning");
        }
        savePengajuan.ladda('stop');
        return false;
          
      }, 1000)
    });
    $('#getPengajuan').on('click','.btnUpdate', function(){
      var id = $(this).attr("data");
      var jenisKasbon = $(this).attr("jenisKasbon");
      var jenisSPJ = $(this).attr("jenisSPJ");
      var jumlah = $(this).attr("jumlah");
      $('#inputID').val(id)
      $('#inputBiaya').val(jumlah)
      $('#modal-pengajuan').modal("show")
      $("select#inputJenisKasbon option[value='"+jenisKasbon+"']").prop("selected","selected");
      $("select#inputJenisKasbon").trigger("change");
      $("select#inputJenisSPJ option[value='"+jenisSPJ+"']").prop("selected","selected");
      $("select#inputJenisSPJ").trigger("change");
      $('#inputJenisData').val("update");
    })
    $('#getPengajuan').on('click', '.btnCancel', function(){
      var id = $(this).attr("data");
      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Membatalkan Pengajuan Saldo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Cancel Pengajuan Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            dataType: "JSON",
            url: 'cancelPengajuan',
            data:{id},
            cache: false,
            async: false,
            success: function(data){
              berhasil();
              getPengajuan();

            },
            error: function(data){
              gagal();
            }
          })
        }
      })
    });
    $('#getPengajuan').on('click','.receivePengajuan', function(){
      var id = $(this).attr("data");
      var jumlah = $(this).attr("jumlah");
      var jenisSPJ = $(this).attr("jenisSPJ");
      var jenisKasbon = $(this).attr("jenisKasbon");
      var kasbon = inputJenisKasbon == 'Kasbon BBM'?'Kasbon Voucher BBM':jenisKasbon+' '+jenisSPJ;
      $.ajax({
        type:'post',
        data:{id,jumlah, kasbon},
        dataType:'json',
        url:'receivePengajuan',
        cache: false,
        async: true,
        success: function(data){
          berhasil();
          getPengajuan();
        },
        error: function(data){
          gagal()
        }
      });
    });

  })
  
  function getPengajuan() {
    var filJenis = $('#filJenis').val();
    var filStatus = $('#filStatus').val();
    $.ajax({
      type:'get',
      data:{filJenis, filStatus},
      url:'getDataPengajuan',
      cache: false,
      async: true,
      beforeSend:function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getPengajuan').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error: function(data){

      }
    });
  }
  function cekSaldo(inputJenisKasbon, inputJenisSPJ, inputBiaya) {
    var jenisSPJ = inputJenisSPJ == '1' ? 'Delivery' : 'Non Delivery';
    var jenis = inputJenisKasbon == 'Kasbon BBM'?'Kasbon Voucher BBM':inputJenisKasbon+' '+jenisSPJ;
    $.ajax({
      type:'get',
      dataType:'json',
      data:{jenis},
      url:'cekSaldoAwal',
      cache: false,
      async: true,
      success: function(data){
        var saldo = parseInt(data.SALDO);
        if (saldo>=inputBiaya) {
          savePengajuan(inputJenisKasbon, inputJenisSPJ, inputBiaya)
        }else{
          Swal.fire("Saldo Kas Induk "+jenis+" Tidak Mencukupi!","Mohon Hubungi PIC Terkait","info")
        }
      },
      error: function(data){
        gagal()
      }
    })
  }
  function savePengajuan(inputJenisKasbon, inputJenisSPJ, inputBiaya) {
    var inputJenisData = $('#inputJenisData').val();
    var inputID = $('#inputID').val();
    $.ajax({
      type:'post',
      data:{inputJenisKasbon, inputJenisSPJ, inputBiaya, inputJenisData, inputID},
      url:'savePengajuanSaldo',
      dataType: 'json',
      cache: false,
      async: true,
      success: function(data){
        berhasil()
        $('#modal-pengajuan').modal("hide")
        getPengajuan()
      },
      error: function(data){
        gagal()
      }
    })
  }
  function kondisiPilihanJenisSPJ() {
    var inputJenisKasbon = $('#inputJenisKasbon').val();
    var opsi1 = true;
    var opsi2 = true;
    var opsi3 = true;
    var level = '<?=$this->session->userdata("LEVEL")?>';
    var departemen = '<?=$this->session->userdata("DEPARTEMEN")?>';


    if (parseInt(level)==2 && departemen == 'PPIC' && inputJenisKasbon != 'Kasbon BBM') {
      opsi1 = true;
      opsi2 = false;
      opsi3 = false;
      $("select#inputJenisSPJ option[value='1']").prop("selected","selected");
      $("select#inputJenisSPJ").trigger("change")  
    }else{
      if (inputJenisKasbon == 'Kasbon BBM') {
        opsi1 = true;
        opsi2 = true;
        opsi3 = false;
        $("select#inputJenisSPJ option[value='']").prop("selected","selected");
        $("select#inputJenisSPJ").trigger("change")  
      }else{
        opsi1 = false;
        opsi2 = false;
        opsi3 = true;
        $("select#inputJenisSPJ option[value='1']").prop("selected","selected");
        $("select#inputJenisSPJ").trigger("change")
      } 
    }


    document.querySelectorAll("#inputJenisSPJ option").forEach(opt => {
        if (opt.value == "1") {
          opt.disabled = opsi1;
        }else if(opt.value == '2'){
          opt.disabled = opsi2;
        }else{
          opt.disabled = opsi3;
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

</script>
<!-- FootJS -->
</body>
</html>

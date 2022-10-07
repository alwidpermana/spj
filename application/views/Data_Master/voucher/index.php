<!DOCTYPE html>

<?php
  $tanggal = date("Y-m-d");
  $i = 1;
  $kurang = 10;
  $tahun = [];

  $tanggal2 = date('Y-m-d', strtotime('+5 year', strtotime( $tanggal )));
  $kurang2 = 5;
  for ($i=0; $i <$kurang2 ; $i++) { 
    $penguranTahun2 = date('Y', strtotime('-'.$i.' year', strtotime( $tanggal2 )));
    array_push($tahun, $penguranTahun2); 
  }

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
                <div class="col-md-1">
                  <div class="form-group">
                    <label>Tampil</label>
                    <select class="form-control filter" id="filLimit">
                      <option value="10" selected>10</option>
                      <option value="100">100</option>
                      <option value="250">250</option>
                      <option value="500">500</option>
                      <option value="750">750</option>
                      <option value="1000">1000</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filStatus">
                      <option value="">ALL</option>
                      <option value="USED">Telah Digunakan</option>
                      <option value="NOT">Belum Digunakan</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Kode Romawi</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filRomawi">
                      <?php foreach ($romawi as $rm): ?>
                        <option value="<?=$rm->KODE?>" <?=$rm->KODE == date("m")?'selected':''?>><?=$rm->ROMAWI?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Tahun</label>
                    <select class="select2 form-control filter select2-orange" data-dropdown-css-class="select2-orange" id="filTahun">
                      <?php foreach ($tahun as $value): ?>
                        <option value="<?=$value?>" <?=$value == date("Y")?'selected':''?>><?=$value?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                  <form id="search">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <span class="fa fa-search form-control-icon"></span>
                      <input type="search" class="form-control form-control-search" id="filSearch" placeholder="Cari Berdasarkan No Voucher">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                  <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnTambah">
                    <i class="fas fa-plus"></i>&nbsp; Voucher BBM
                  </button>
                </div>
              </div>
              <!-- <br> -->
              <div class="row">
                <div class="col-md-12">
                  <div class="preloader-no-bg">
                    <div class="loader">
                        <div class="spinner"></div>
                        <div class="spinner-2"></div>
                    </div>
                  </div>
                  <div id="getTabel"></div>
                </div>
              </div>
              <br>
              <div class="row">
                <input type="hidden" id="inputOffset">
                <div class="col-md-12 d-flex justify-content-end">
                  <div id="paging"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="d-flex justify-content-end">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <input type="hidden" id="inputId">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>No Voucher</label>
                          
                        </div> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div id="form-group">
                          <input type="text" id="inputKodePertama" class="form-control form-control-sm" readonly value="SPJ-VCH-">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div id="form-group">
                          <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKodeRomawi">
                            <?php foreach ($romawi as $rm): ?>
                              <option value="<?=$rm->KODE?>"><?=$rm->ROMAWI?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" id="inputKodeTahun" class="form-control form-control-sm" value="<?=date('y')?>" readonly>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Dari Nomor</label>
                      <input type="number" id="inputDari" class="form-control form-control-sm" step="1" value="1">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Sampai Nomor</label>
                      <input type="number" id="inputSampai" class="form-control form-control-sm" step="1" value="1000">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-orange btn-kps ladda-button saveVoucher" data-style="expand-right" id="saveVoucher">Save</button>
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
    paging(1);
    $('#paging').on('click','.paging', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      paging(offset)
      $('#inputOffset').val(offset);
    });
    $('.filter').on('change', function(){
      paging(1);
    });
    $('#search').submit(function(e){
      e.preventDefault();
      paging(1);
    })
    $('#paging').on('click','.btnStep', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      paging(offset)
      $('#inputOffset').val(offset);
    })
   $('#btnTambah').on('click', function(){
      $('#modal-voucher').modal("show");
   });

   var saveVoucher = $('.saveVoucher').ladda();
      saveVoucher.click(function () {
      // Start loading
      saveVoucher.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputKodeRomawi = $('#inputKodeRomawi').val();
        var inputDari = parseInt($('#inputDari').val());
        var inputSampai = parseInt($('#inputSampai').val());
        var inputOffset = $('#inputOffset').val();
        console.log(inputSampai)
        console.log(inputDari)
        
        if (inputDari == '' || inputSampai == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
          saveVoucher.ladda('stop');
        }else if(inputDari >= inputSampai){
          Swal.fire("Isian Sampai Nomor Harus Lebih Besar Dibandingkan Dari Nomor","","info")
          saveVoucher.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            dataType: 'json',
            data: {inputKodeRomawi, inputDari, inputSampai},
            cache: false,
            async: true,
            url:'saveVoucherBBM',
            success: function(data){
              berhasil();
              paging(inputOffset)
              $('#modal-voucher').modal('hide')
              $('#inputDari').val("");
              $('#inputSampai').val("");
            },
            complete: function(data){
              saveVoucher.ladda('stop');
            },
            error: function(data){
              gagal();
            }
          });  
        }
        
        
        return false;
          
      }, 1000)
    });

    $('#getTabel').on('click','.edit', function(){
      var noVoucher = $(this).attr("noVoucher");
      var voucher_id = $(this).attr("voucher_id");
      var rp = $(this).attr("rp");
      $('#inputId').val(voucher_id);
      $('#inputVoucher').val(noVoucher);
      $('#inputRp').val(rp);
      $('#modal-voucher').modal("show")
    });
    $('#getTabel').on('click','.hapus', function(){
      var noVoucher = $(this).attr("noVoucher");
      var voucher_id = $(this).attr("voucher_id");
      Swal.fire({
        title: 'Apakah Kamu Yakin Menghapus Voucher ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B22222',
        cancelButtonColor: '#CD5C5C',
        confirmButtonText: 'Ya, Hapus Data Ini!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
                type : "POST",
                url  : "hapusVoucherBBM",
                data :{noVoucher, voucher_id},
                async : false,
                cache: false,
                dataType: "JSON",
                success: function(data){
                  berhasil()
                  getTabel()
                },
                error: function(data){
                  gagal();
                }
            });

          
        }
      })
    });

  })
  function getTabel(offset, limit, filStatus, filSearch, filRomawi, filTahun) {
    $.ajax({
      type:'get',
      data:{filStatus,filSearch, filRomawi, filTahun, offset, limit},
      url:'getTabelVoucherBBM',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        $('#getTabel').html(data);
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut('slow');
      },
      error: function(data){
        $('#getTabel').html("error");
      }
    });
  }
  function paging(offset) {
    var filStatus = $('#filStatus').val();
    var filSearch = $('#filSearch').val();
    var filRomawi = $('#filRomawi').val();
    var filTahun = $('#filTahun').val();
    var limit = $('#filLimit').val();
    $.ajax({
      type:'get',
      data:{filStatus, filSearch, filRomawi, filTahun, limit, offset},
      url:'getPagingVoucherBBM',
      cache:false,
      async:true,
      success: function(data){
        $('#paging').html(data);
        var endOffset = offset == ''?0:(offset-1)*limit;
        getTabel(endOffset, limit, filStatus, filSearch, filRomawi, filTahun)
      },
      error: function(data){

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

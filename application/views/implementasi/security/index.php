<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ladda-buttons/css/ladda-themeless.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .fotoWajah{
      max-width: 50px;
      width: auto;
      height: auto;

    }
    .fokusKendaraan{
      border-style: solid !important;
      border-color: #f4a261 !important;
      border-radius: 7px;
      border-width: 2.5px;
    }
  </style>
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
            <div class="col-md-4 offset-md-4">
              <div class="form-group">
                <label>&nbsp;</label>
                <span class="fa fa-qrcode form-control-icon"></span>
                <input type="search" class="form-control form-control-search" id="inputScan" placeholder="Scan Qr Code">
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="preloader-no-bg">
                <div class="loader">
                    <div class="spinner"></div>
                    <div class="spinner-2"></div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <br>
          <div class="row">
            <div class="col-md-12">
              <center><h3><span id="keteranganSecurity" class="text-kps" style="font-size: 28px; font-weight: bold;"></span></h3></center>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div id="getSPJ"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-aktualPIC" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <label><h4>Terdapat PIC yang Tidak OK! Isi Data Aktual PIC yang CheckOut!</h4></label>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <div class="icheck-orange icheck-kps d-inline">
                    <input 
                      type="checkbox" 
                      id="inputCentang" 
                      field="Y">
                    <label for="inputCentang">
                      Isi Manual
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="getDB">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>PIC</label>
                    <select class="select2 form-control select2-orange" id="inputPIC" data-dropdown-css-class="select2-orange" style="width:100%">
                      
                    </select>
                  </div>
                  <input type="hidden" id="inputHiddenNIK">
                  <input type="hidden" id="inputHiddenNama">
                  
                </div>
                <div class="col-md-4">
                  <label>Sebagai</label>
                  <select class="select2 form-control select2-orange" id="inputSebagai" data-dropdown-css-class="select2-orange" style="width:100%">
                    <option value="Driver">Driver</option>
                    <option value="Pendamping">Pendamping</option>
                  </select>
                </div>
              </div>  
            </div>
            <div class="manual d-none">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>NIK</label>
                    <input type="text" id="inputNIK" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" id="inputNama" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <label>Sebagai</label>
                  <select class="select2 form-control select2-orange" id="inputSebagai2" data-dropdown-css-class="select2-orange" style="width:100%">
                    <option value="Driver">Driver</option>
                    <option value="Pendamping">Pendamping</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-end">
                <button type="button" class="btn bg-orange btn-kps ladda-button" data-style="expand-right" id="btnSaveAktual">
                  Save
                </button>
              </div>
            </div>
            <hr style="border-width: 5px;">
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-valign-middle table-striped" width="100%">
                    <thead>
                      <tr>
                        <th width="65%">PIC</th>
                        <th width="25">Sebagai</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tbody id="getTabelAktual">
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps checkOutAktual ladda-button" data-style="expand-right">Check Out Dengan Data Aktual</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <label>Scan Kendaraan Tanpa SPJ</label>
            </div>
          </div>
          <div class="modal-body">
            <input type="hidden" id="scanStatusKendaraan">
            <input type="hidden" id="scanKMOutNoSPJ">
            <div class="row">
              <div class="col-md-12">
                <div id="setImage"></div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8 font-weight-bold">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    No TNKB
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div id="scanNoTNKB"></div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    Merk Mobil
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div id="scanMerk"></div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    Type Mobil
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div id="scanType"></div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    Kendaraan
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div id="scanKendaraan"></div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                    Jenis Kendaraan
                  </div>
                  <div class="col-md-8 col-sm-8">
                    <div id="scanJenis"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" id="inputKeteranganScanKendaraan" rows="2"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <div class="form-group">
                  <label id="textKMNonSPJ"></label>
                  <input type="number" class="form-control" id="inputKMNonSPJ">
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps scanKendaraan ladda-button" data-style="expand-right">Scan</button>
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
<script src="<?= base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    $('.preloader').fadeOut('slow');
    $('.preloader-no-bg').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    $('.preloader-no-bg').fadeOut("slow");
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   $('#inputScan').val("").focus();

   $('#inputScan').on('keyup', function(){
    var scan = $(this).val();
    var jenis = scan.substring(0, 3);
    
    if (jenis != '') {
      if (jenis == 'SPJ') {
        cekSPJ(scan);
      }else{
        cekKendaraan(scan)
      }  
    }
    
    

   })
   $('#inputCentang').on('change', function(){
    var inputCentang = document.getElementById('inputCentang');
    if (inputCentang.checked == true) {
      $('.getDB').addClass("d-none");
      $('.manual').removeClass("d-none");
    }else{
      $('.getDB').removeClass("d-none");
      $('.manual').addClass("d-none");
    }
   })
    $("#inputPIC").select2({
      ajax: { 
        url: url+'/Implementasi/getPICAktual',
        type: "get",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
              cari: params.term // search term
            };
        },
        processResults: function (response) {
            return {
               results: response
            };
            console.log(response)

        },
        cache: true
      }
    });
    $('#inputPIC').on('change', function(){
      var isi = $(this).val();
      var data = isi.split("||");
      var nik = data[0]
      var nama = data[1]
      $('#inputHiddenNIK').val(nik)
      $('#inputHiddenNama').val(nama)
    });
   $('#btnSaveAktual').on('click', function(){
    
    
   })
    var btnSaveAktual = $('#btnSaveAktual').ladda();
      btnSaveAktual.click(function () {
      // Start loading
      btnSaveAktual.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputCentang = document.getElementById('inputCentang');
        var inputNIK = inputCentang.checked == true ?$('#inputNIK').val():$('#inputHiddenNIK').val();
        var inputNama = inputCentang.checked == true ? $('#inputNama').val():$('#inputHiddenNama').val();
        var inputSebagai = inputCentang.checked == true ? $('#inputSebagai2').val():$('#inputSebagai').val();
        
        if (inputNIK == '' || inputNama == '' || inputSebagai == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
        }else{
          saveAktual(inputNIK, inputNama, inputSebagai)
        }
        btnSaveAktual.ladda('stop');
        return false;
          
      }, 500)
    });
    $('#getTabelAktual').on('click','.aktualHapus', function(){
      var nik = $(this).attr("nik");
      var nama = $(this).attr("nama");
      var sebagai= $(this).attr("sebagai");
      var inputScan = $("#inputScan").val()
      Swal.fire({
          title: 'Apakah Anda Yakin?',
          text: "Anda Akan Menghapus Data Aktual PIC",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#B22222',
          cancelButtonColor: '#CD5C5C',
          confirmButtonText: 'Ya, Hapus Data Ini!'
      }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type:'post',
              data:{nik, nama, sebagai, inputScan},
              dataType:'json',
              cache: false,
              async: true,
              url:url+'/implementasi/hapusPICAktual',
              success: function(data){
                Swal.fire(
                  'Berhasil!',
                  'Data Telah Dihapus',
                  'success'
                )
                getTabelAktual()
              },
              error: function(data){
                gagal("Gagal Menghapus Data! Hubungi Staff IT!");
              }
            })
              
          }
      })
    });
    var checkOutAktual = $('.checkOutAktual').ladda();
      checkOutAktual.click(function () {
      // Start loading
      checkOutAktual.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        saveValidasiOut();
        checkOutAktual.ladda('stop');
        return false;
          
      }, 500)
    });
    var scanKendaraan = $('.scanKendaraan').ladda();
      scanKendaraan.click(function () {
      // Start loading
      scanKendaraan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var noTNKB = $('#inputScan').val();
        var status = $('#scanStatusKendaraan').val();
        var keterangan = $('#inputKeteranganScanKendaraan').val();
        var inputKMNonSPJ = $('#inputKMNonSPJ').val();
        var scanKMOutNoSPJ = $('#scanKMOutNoSPJ').val();
        if (keterangan == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Keterangan Belum Diisi","info")
          scanKendaraan.ladda('stop');   
        }else if(inputKMNonSPJ == ''){
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","KM Belum Diisi","info");
          scanKendaraan.ladda('stop');
        }else if(parseInt(scanKMOutNoSPJ)>parseInt(inputKMNonSPJ)){
          Swal.fire("Km IN Lebih Kecil dibanding KM Out!","","warning");
          scanKendaraan.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            data:{noTNKB, status, keterangan, inputKMNonSPJ},
            dataType:'json',
            cache: false,
            async: true,
            url:url+'/Implementasi/scanKendaraanNotSPJ',
            beforeSend: function(data){
              $('.scanKendaraan').attr("disabled","disabled")
            },
            success: function(data){
              if (data.status == 'warning') {
                Swal.fire("Kendaraan Masih diluar KPS!","Mohon Check In Terlebih Dahulu!","warning");
              }
              berhasil();
              $('#modal-kendaraan').modal("hide")
            },
            complete: function(data){
              
              $('.scanKendaraan').removeAttr("disabled","disabled")
              scanKendaraan.ladda('stop');    
            },
            error: function(data){
              gagal();
            }
          }) 
        }
        
        
        return false;
          
      }, 500)
    });
  })
  
  function cekStatusPerjalanan(scan) {
    $.ajax({
      type:'get',
      data:{scan},
      dataType:'json',
      url:url+'/implementasi/cekStatusPerjalanan',
      cache:false,
      async:true,
      success:function(data){
        
      },
      error:function(data){

      }
    })
  }

  function cekSPJ(scan) {
    $.ajax({
      type:'get',
      data:{scan},
      dataType:'json',
      url:url+'/Implementasi/cekSPJ',
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        
        if (data!=null ) {
          // if (data.STATUS_PERJALANAN == null) {
          //   hapusVerifikasiPICOut(scan)
          // }else{
          //   updateVerfikasiPICIn(scan)
          // }
          // var statusPerjalan = data.STATUS_PERJALANAN == null ? 'OUT':'IN';
          if (data.STATUS_SPJ == 'CANCEL') {
            Swal.fire("SPJ Sudah Di Cancel!","Tidak Bisa Scan Qr Code","warning");
          } else if(data.STATUS_SPJ == 'DRAFT' && data.STATUS_PERJALANAN == null && data.kerja==true){
            Swal.fire("SPJ Masih Draft!","Lengkapi Datanya Terlebih dahulu dan kordinasi dengan bagian Finance untuk melakukan approve","warning");
          }else {
            var statusPerjalan = '';
            if (data.STATUS_PERJALANAN == null) {
              statusPerjalan = 'OUT';
            }else if(data.STATUS_PERJALANAN == 'OUT'){
              statusPerjalan = 'IN';
            }else{
              statusPerjalan = '-';
            }
            // console.log(data.STATUS_PERJALANAN);
            // console.log(statusPerjalan)

            var noSPJ = data.NO_SPJ;
            verfikasiDataPICOutIn(scan, statusPerjalan, noSPJ, data.STATUS_SPJ)
          }
          
          
        }
        // if (data==0) {
        //   // Swal.fire({
        //   //   position: 'top-end',
        //   //   toast : true,
        //   //   icon: 'info',
        //   //   title: 'Tidak Ditemukan SPJ dengan QrCode Tersebut!',
        //   //   showConfirmButton: false,
        //   //   timer: 3000
        //   // })
        // } else {
        //   Swal.fire({
        //     position: 'top-end',
        //     toast : true,
        //     icon: 'success',
        //     title: 'Berhasil Mengambil Data SPJ',
        //     showConfirmButton: false,
        //     timer: 3000
        //   })
          
        //   getSPJ(scan)
        // }
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        gagalScan()
        
      }
    });
  }
  function cekKendaraan(scan) {
    $.ajax({
      type:'get',
      data:{scan},
      dataType:'json',
      cache: false,
      async: true,
      url:url+'/Implementasi/getKendaraanNotSPJ',
      beforeSend: function(data){
        $('.preloader-no-bg').show();
      },
      success: function(data){
        if (data == null) {
          $('#modal-kendaraan').modal("hide");

        }else{
          $('#modal-kendaraan').modal("show");
          $('#setImage').html('<img src="'+url+'/assets/image/'+data.NAMA_FILE+'" class="img-thumbnail rounded mx-auto d-block" width="400px"></img>');
          $('#scanNoTNKB').html(': '+data.NoTNKB)
          $('#scanMerk').html(': '+data.Merk)
          $('#scanType').html(': '+data.Type)
          $('#scanKendaraan').html(': '+data.Jenis)
          $('#scanJenis').html(': '+data.Kategori)
          $('#scanStatusKendaraan').val(data.STATUS)
          $('#scanKMOutNoSPJ').val(data.KM_OUT);
          $('#inputKeteranganScanKendaraan').val(data.KETERANGAN)
          if (data.STATUS == 'OUT') {
            var textKM = 'KM OUT';
            $('#inputKMNonSPJ').attr("readonly","readonly");
            $('#inputKMNonSPJ').val(data.KM);
          }else{
            var textKM = 'KM IN';
            $('#inputKMNonSPJ').removeAttr("readonly","readonly");
            $('#inputKMNonSPJ').val(data.KM_OUT);
          }
          $('#textKMNonSPJ').html(textKM)
        }
        
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        gagalScan()
      }
    })
  }

  function getSPJ(scan, filStatus) {
    $.ajax({
      type:'get',
      data:{scan, filStatus},
      url:url+'/Implementasi/getSPJ',
      cache:false,
      async: true,
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getSPJ').html(data)
        $('#inputScan').attr("disabled","disabled");
        document.getElementById('inputScan').blur()
        $('.saveCheckOut').removeAttr("disabled","disabled");
        $('.saveCheckIn').removeAttr("disabled","disabled");
      },
      complete: function(data){
        $('.preloader-no-bg').fadeOut("slow");
      },
      error: function(data){
        Swal.fire("Gagal Mengambil SPJ!","Reload Halaman Ini atau Hubungi Staff IT","error")
      }
    })
  }
  function verfikasiDataPICOutIn(scan, status, noSPJ, statusSPJ) {
    if (status == '-') {
      getSPJ(scan, statusSPJ)
    }else{
      $.ajax({
        type:'post',
        data:{noSPJ, status},
        dataType:'json',
        url:url+'/Implementasi/verifikasiDataPICOutIn',
        cache: false,
        async: true,
        success: function(data){
          getSPJ(scan, statusSPJ)
          if (status == 'OUT') {
            $('#keteranganSecurity').html("CHECK OUT KENDARAAN")
          } else if(status == 'IN') {

            $('#keteranganSecurity').html("CHECK IN KENDARAAN")
          }else{
            $('#keteranganSecurity').html("")
          }
        },
        error: function(data){

        }
      })  
      // console.log(status)
    }
  }
  function getTabelAktual() {
    var inputScan = $('#inputScan').val();
    $.ajax({
      type:'get',
      data:{inputScan},
      dataType:'json',
      url:url+'/Implementasi/getTabelAktual',
      cache: false,
      async: true,
      success: function(data){
        var html="";
        var jml = data.length;
        for (var i = 0; i < jml; i++) {
          html+='<tr>';
          html+='<td>'+data[i].NIK+' - '+data[i].NAMA+'</td>';
          html+='<td>'+data[i].SEBAGAI+'</td>';
          html+='<td><a href="javascript:;" class="btn text-kps text-orange aktualEdit"><i class="fas fa-edit"></i></a></td>';
          html+='<td><a href="javascript:;" class="btn text-kps text-orange aktualHapus" nik="'+data[i].NIK+'" nama="'+data[i].NAMA+'" sebagai="'+data[i].SEBAGAI+'"><i class="fas fa-trash-alt"></i></a></td>';
          html+='</tr>';
        }
        $('#getTabelAktual').html(html);
      },
      error: function(data){
        $('#getTabelAktual').html("");
      }
    });
  }
  function saveAktual(inputNIK, inputNama, inputSebagai) {
    var inputScan = $('#inputScan').val();
    $.ajax({
      type:'post',
      data:{inputNIK, inputNama, inputSebagai, inputScan},
      dataType:'json',
      cache:false,
      async: true,
      url:url+'/Implementasi/saveAktualPIC',
      beforeSend: function(data){
        $('#btnSaveAktual').attr("disabled","disabled")
      },
      success: function(data){
        berhasil()
        var html="";
        html+='<tr>';
        html+='<td>'+inputNIK+' - '+inputNama+'</td>';
        html+='<td>'+inputSebagai+'</td>';
        html+='<td><a href="javascript:;" class="btn text-kps text-orange aktualEdit"><i class="fas fa-edit"></i></a></td>';
        html+='<td><a href="javascript:;" class="btn text-kps text-orange aktualHapus" nik="'+inputNIK+'" nama="'+inputNama+'" sebagai="'+inputSebagai+'"><i class="fas fa-trash-alt"></i></a></td>';
        html+='</tr>';
        $("#getTabelAktual").prepend(html);
        $('#inputNIK').val("");
        $('#inputNama').val("");
      },
      complete: function(data){
        $('#btnSaveAktual').removeAttr("disabled","disabled")
      },
      error: function(data){
        gagal()
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
  function gagalScan() {
    Swal.fire({
      position: 'top-end',
      toast : true,
      icon: 'error',
      title: 'Gagal Meng-Scan QrCode!',
      showConfirmButton: false,
      timer: 3000
    })
  }
  
</script>
<!-- FootJS -->
</body>
</html>

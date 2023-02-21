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
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <!-- <div class="row">
                    <div class="col-md-2 col-sm-4">
                      <button type="button" class="btn btn-kps bg-orange btn-block" id="btnTambahRekanan">
                        Tambah Rekanan
                      </button>
                    </div>
                  </div> -->
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabelRekanan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row d-none" id="formKendaraan">
            <div class="col-md-12">
              <br>
              <div class="card card-orange card-outline">
                <div class="card-header">
                  <div class="card-title">Data Kendaraan Rental Rekanan: <span id="viewRekanan"></span></div>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" id="btnRemoveCardKendaraan">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnTambahKendaraan">
                        Tambah Kendaraan
                      </button>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div id="getTabelKendaraan"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-rekanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputIdRekanan">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Rekanan</label>
                  <input type="text" id="inputKode" class="form-control form-control-sm" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" id="inputNama" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" id="inputAlamat" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveRekanan ladda-button" data-style="expand-right" step="1">Save</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <input type="hidden" id="inputIdKendaraan">
            <input type="hidden" id="inputRekananId">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>No TNKB</label>
                  <input type="text" id="inputNoTNKB" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Merk</label>
                  <input type="text" id="inputMerk" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Type</label>
                  <input type="text" id="inputType" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jenis Kendaraan</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJenis">
                    <option value="">Pilih Jenis Kendaraan</option>
                    <?php foreach ($jenis as $key2): ?>
                      <option value="<?=$key2->JENIS_KENDARAAN?>"><?=$key2->JENIS_KENDARAAN?></option>
                    <?php endforeach ?> 
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Warna</label>
                  <input type="text" id="inputWarna" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tahun</label>
                  <input type="text" id="inputTahun" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Bahan Bakar</label>
                  <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputBahanBakar">
                    <option value="Bensin">Bensin</option>
                    <option value="Solar">Solar</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>BBM Per Liter</label>
                  <input type="number" id="inputLiter" class="form-control form-control-sm" step="0.01">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn bg-orange btn-kps saveKendaraan ladda-button" data-style="expand-right" step="1">Save</button>
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
    $('.preloader-no-bg').fadeOut("slow");
    $('.ladda-button').ladda('bind', {timeout: 1000});
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   getTabelRekanan();
   $('#btnTambahRekanan').on('click', function(){
    $('#modal-rekanan').modal("show")
    $('#inputIdRekanan').val();
    setKodeRekanan();
   });
   var saveRekanan = $('.saveRekanan').ladda();
      saveRekanan.click(function () {
      // Start loading
      saveRekanan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputNama = $('#inputNama').val();
        var inputAlamat = $('#inputAlamat').val();
        var inputIdRekanan = $('#inputIdRekanan').val();
        if (inputNama == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Nama Masih Kosong","warning");
          saveRekanan.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            data:{inputNama, inputAlamat, inputIdRekanan},
            dataType:'json',
            cache:false,
            async:true,
            url:url+'/data_master/saveRekanan',
            beforeSend:function(data){

            },
            success:function(data){
              berhasil()
              getTabelRekanan();
              $('#modal-rekanan').modal("hide")
              $('#inputNama').val("");
              $('#inputAlamat').val("");
            },
            complete:function(data){
              saveRekanan.ladda('stop');
            },
            error:function(data){
              gagal()
            }
          }); 
        }
        
        
        
        return false;
          
      }, 1000)
    });
    $('#getTabelRekanan').on('click','.editRekanan', function(){
      var id = $(this).attr("data");
      var kode = $(this).attr("kode")
      var nama = $(this).attr("nama")
      var alamat = $(this).attr("alamat")
      $('#inputKode').val(kode)
      $('#inputNama').val(nama)
      $('#inputAlamat').val(alamat)
      $('#inputIdRekanan').val(id)
      $('#modal-rekanan').modal("show")
    })
    $('#getTabelRekanan').on('change','#inputStatus', function(){
      var id = $(this).attr("data");
      var status = $(this).val();
      $.ajax({
        type:'post',
        data:{id,status},
        dataType:'json',
        url:url+'/data_master/updateStatusRekanan',
        cache: false,
        async:true,
        success: function(data){
          berhasil()
        },
        error:function(data){
          gagal()
        }
      })
    })
    $('#getTabelRekanan').on('click','.dataKendaraan', function(){
      var id = $(this).attr("data")
      var nama = $(this).attr("nama")
      getTabelKendaraan(id, nama);
      $('#formKendaraan').show()
    })
    $('#btnRemoveCardKendaraan').on('click', function(){
      $('#formKendaraan').fadeOut("slow")
    })
    $('#btnTambahKendaraan').on('click', function(){
      $('#modal-kendaraan').modal("show");
      $('#inputIdKendaraan').val("");
    });
    var saveKendaraan = $('.saveKendaraan').ladda();
    saveKendaraan.click(function () {
      // Start loading
      saveKendaraan.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputRekananId = $('#inputRekananId').val();
        var inputIdKendaraan = $('#inputIdKendaraan').val();
        var inputNoTNKB = $('#inputNoTNKB').val();
        var inputMerk = $('#inputMerk').val();
        var inputType = $('#inputType').val();
        var inputJenis = $('#inputJenis').val();
        var inputWarna = $('#inputWarna').val();
        var inputBahanBakar = $('#inputBahanBakar').val();
        var inputLiter = $('#inputLiter').val();
        var inputTahun = $('#inputTahun').val();
        if (inputNoTNKB == '' || inputMerk == '' || inputType == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu","No TNKB, Merk, dan Type Kendaraan Tidak Boleh Kosong","warning")
          saveKendaraan.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            dataType:'json',
            data:{inputRekananId, inputIdKendaraan, inputNoTNKB, inputMerk, inputType, inputJenis, inputWarna, inputBahanBakar, inputLiter, inputTahun},
            url:url+'/data_master/saveKendaraanRental',
            cache:false,
            async:true,
            success:function(data){
              berhasil()
              $('#modal-kendaraan').modal("hide");
              getTabelKendaraan(inputRekananId);
              $('#inputIdKendaraan').val("")
              $('#inputNoTNKB').val("")
              $('#inputMerk').val("")
              $('#inputType').val("")
              $('#inputWarna').val("")
              $('#inputLiter').val("")
              $('#inputTahun').val("");
            },
            complete: function(data){
              saveKendaraan.ladda('stop');
            },
            error:function(data){
              gagal()
            }
          })
        }
        return false;
      }, 1000)
    });
    $('#getTabelKendaraan').on('click','.editKendaraan', function(){
      var id = $(this).attr("data");
      var merk = $(this).attr("merk");
      var type = $(this).attr("type");
      var noTNKB = $(this).attr("noTNKB");
      var jenis = $(this).attr("jenis");
      var warna = $(this).attr("warna");
      var bbm = $(this).attr("bbm");
      var liter = $(this).attr("liter");
      var tahun = $(this).attr("tahun");
      $('#inputIdKendaraan').val(id);
      $('#inputMerk').val(merk)
      $('#inputType').val(type)
      $('#inputNoTNKB').val(noTNKB)
      $('#inputWarna').val(warna)
      $('#inputLiter').val(liter);
      $('#inputTahun').val(tahun);
      $("select#inputJenis option[value='" + jenis + "']").prop("selected","selected");
      $("select#inputJenis").trigger("change");
      $("select#inputBahanBakar option[value='" + bbm + "']").prop("selected","selected");
      $("select#inputBahanBakar").trigger("change");
      $('#modal-kendaraan').modal("show")
    })
    $('#getTabelKendaraan').on('click', '.hapusKendaraan', function(){
      var id = $(this).attr("data");
      var rekanan = $(this).attr("rekanan");
      Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Menghapus Data Kendaraan Rental",
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
            url: url+'/data_master/hapusKendaraanRental',
            data:{id},
            cache: false,
            async: false,
            success: function(data){
              berhasil();
              getTabelKendaraan(rekanan);

            },
            error: function(data){
              gagal();
            }
          })
        }
      })
    })
  })
  function getTabelRekanan() {
    var jenis = 'kendaraan';
    $.ajax({
      type:'get',
      url:url+'/data_master/getDataRekanan',
      data:{jenis},
      cache: false,
      async: true,
      beforeSend: function(data){
        $('.preloader').show();
      },
      success: function(data){
        $('#getTabelRekanan').html(data);
      },
      complete: function(data){
        $('.preloader').fadeOut('slow');
      },
      error:function(data){
        $('#getTabelRekanan').html("Gagal Meload Data");
      }
    })
  }

  function setKodeRekanan() {
    $.ajax({
      type:'get',
      url:url+'/data_master/setKodeRekanan',
      cache:false,
      async:true,
      dataType:'json',
      success:function(data){
        $('#inputKode').val(data);
      },
      error:function(data){
        $('#inputKode').val("error")
      }
    })
  }
  function getTabelKendaraan(id, nama) {
    $.ajax({
      type:'get',
      data:{id},
      url: url+'/Data_Master/getKendaraanRekanan',
      cache:false,
      async:true,
      beforeSend: function(data){
        $('#preloader-no-bg').show()
      },
      success: function(data){
        $('#viewRekanan').html(nama)
        $('#formKendaraan').removeClass("d-none")
        $('html, body').animate({
            scrollTop: $("#formKendaraan").offset().top
        }, 750);
        $('#inputRekananId').val(id)
        $('#getTabelKendaraan').html(data);
      },
      complete: function(data){
        $('#preloader-no-bg').fadeOut("slow")
      },
      error: function(data){
        $('#getTabelKendaraan').html("Gagal Meload Data");
        Swal.fire("Gagal Mengambil Data!","Hubungi Staff IT","error")
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

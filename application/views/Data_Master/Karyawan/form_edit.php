<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.css">  
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/Croppie-master/croppie.css" />
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .labJudul{
      padding-top: 7px;
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
<div class="wrapper">
    <?php $this->load->view('_partial/navbar');?>
    <?php $this->load->view('_partial/sidebar');?>
    <div class="content-wrapper">
      <?php $this->load->view('_partial/content-header');?>
      <div class="content">
        <div class="container-fluid">
          <?php foreach ($data as $key): ?>
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">NIK</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputNIK" class="form-control form-control-sm" readonly value="<?=$this->uri->segment("3")?>">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">No KTP</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputKTP" class="form-control form-control-sm" value="<?=$key->no_ktp?>">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">Sub Departemen</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputSubDepartemen" class="form-control form-control-sm" readonly value="<?=$key->Subdepartemen1?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">Nama</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputNama" class="form-control form-control-sm" readonly value="<?=$key->namapeg?>">
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">Departemen</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputDepartemen" class="form-control form-control-sm" readonly value="<?=$key->departemen?>">
                          </div>
                        </div>
                        
                        <br>
                        <div class="row">
                          <div class="col-md-4">
                            <label class="text-left labJudul">Jabatan</label>
                          </div>
                          <div class="col-md-7">
                            <input type="text" id="inputJabatan" class="form-control form-control-sm" readonly value="<?=$key->jabatan?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-outline card-gray">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-left labJudul">SPJ</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="checkbox" 
                              id="inputSpjDlv" 
                              class="saveSPJ" 
                              field="SPJ_DLV" 
                              <?=$key->SPJ_DLV == 'Y'?'checked':''?>>
                            <label for="inputSpjDlv">
                              Delivery
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                          <div class="icheck-orange icheck-kps d-inline">
                            <input 
                              type="checkbox" 
                              id="inputSpjNdv" 
                              class="saveSPJ" 
                              field="SPJ_NDV" 
                              <?=$key->SPJ_NDV == 'Y'?'checked':''?>>
                            <label for="inputSpjNdv">
                              Non Delivery
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-left labJudul">Subjek</label>
                  </div>
                  <div class="col-md-4">
                    <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputSubjek">
                      <option value="">Pilih Subjek</option>
                      <option value="Internal" <?=$key->SUBJEK == 'Internal'?'selected':''?>>Internal</option>
                      <option value="Rental" <?=$key->SUBJEK == 'Rental'?'selected':''?>>Rental</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="rental">
                  <div class="row">
                    <div class="col-md-2">
                      <label class="labJudul">Rekanan</label>
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="inputRekanan" class="form-control" value="<?=$key->REKANAN?>">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-left labJudul">Otoritas</label>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                        <div class="icheck-orange icheck-kps d-inline">
                          <input 
                            type="checkbox" 
                            id="inputOtoritasDriver" 
                            class="saveOtoritas" 
                            field="OTORITAS_DRIVER" 
                            <?=$key->OTORITAS_DRIVER == 'Y'?'checked':''?>>
                          <label for="inputOtoritasDriver">
                            Driver
                          </label>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                        <div class="icheck-orange icheck-kps d-inline">
                          <input 
                            type="checkbox" 
                            id="inputOtoritasPendamping" 
                            class="saveOtoritas" 
                            field="OTORITAS_PENDAMPING"
                            <?=$key->OTORITAS_PENDAMPING == 'Y'?'checked':''?>>
                          <label for="inputOtoritasPendamping">
                            Pendamping
                          </label>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                        <div class="icheck-orange icheck-kps d-inline">
                          <input 
                            type="checkbox" 
                            id="inputUangMakan" 
                            class="saveOtoritas" 
                            field="OTORITAS_UANG_MAKAN"
                            <?=$key->OTORITAS_UANG_MAKAN == 'Y'?'checked':''?>>
                          <label for="inputUangMakan">
                            Uang Makan <?=$key->OTORITAS_UANG_MAKAN?>
                          </label>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                        <div class="icheck-orange icheck-kps d-inline">
                          <input 
                            type="checkbox" 
                            id="inputUangSaku" 
                            class="saveOtoritas" 
                            field="OTORITAS_UANG_SAKU"
                            <?=$key->OTORITAS_UANG_SAKU == 'Y'?'checked':''?>>
                          <label for="inputUangSaku">
                            Uang Saku
                          </label>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                        <div class="icheck-orange icheck-kps d-inline">
                          <input 
                            type="checkbox" 
                            id="inputAdj" 
                            class="saveOtoritas" 
                            field="OTORITAS_ADJUSMENT"
                            <?=$key->OTORITAS_ADJUSMENT == 'Y'?'checked':''?>>
                          <label for="inputAdj">
                            Adjusment
                          </label>
                          <sub>(Khusus SPJ Manajemen)</sub>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                
                <div id="otoritasDriver">
                  <div class="row">
                    <div class="col-md-2">
                      <label class="text-left labJudul">No Sim</label>
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="inputSIM" class="form-control" value="<?=$key->NO_SIM?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-2">
                      <label class="text-left labJudul">Berlaku</label>
                    </div>
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-2">
                          <label class="text-left labJudul">Terbit:</label>
                        </div>
                        <div class="col-md-10">
                          <input type="date" id="inputTerbit" class="form-control" value="<?=$key->BERLAKU_TERBIT?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="row" id="tglSD">
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                          <label class="text-left labJudul">S/d</label>
                        </div>
                        <div class="col-md-10">
                          <input type="date" id="inputSd" class="form-control" value="<?=$key->BERLAKU_AKHIR?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
                <div class="row">
                  <input type="hidden" id="fileTipe">
                  <div class="col-md-2">
                    <label class="text-left labJudul">Upload Foto Wajah</label>
                  </div>
                  <div class="col-md-2">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control-sm" id="fileWajah" name="fileWajah" accept=".png, .jpg, .jpeg">
                      <label class="custom-file-label" for="fileWajah">Choose file</label>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <!-- <div id="uploaded_image"></div> -->
                    <div id="getImageWajah">
                      
                    </div>
                  </div>
                </div>
                <br>
                <hr>
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-left labJudul">Upload Foto KTP</label>
                  </div>
                  <div class="col-md-2">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control-sm" id="fileKTP" name="fileKTP" accept=".png, .jpg, .jpeg">
                      <label class="custom-file-label" for="fileKTP">Choose file</label>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <!-- <div id="uploaded_image"></div> -->
                    <div id="getImageKTP">
                      
                    </div>
                  </div>
                </div>
                <br>
                <hr>
                <div class="row">
                  <div class="col-md-2">
                    <label class="text-left labJudul">Upload Foto SIM</label>
                  </div>
                  <div class="col-md-2">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control-sm" id="fileSIM" name="fileSIM" accept=".png, .jpg, .jpeg">
                      <label class="custom-file-label" for="fileSIM">Choose file</label>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <!-- <div id="uploaded_image"></div> -->
                    <div id="getImageSIM">
                      
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <input type="hidden" id="textFotoWajah" value="<?=$key->FOTO_WAJAH?>">
            <input type="hidden" id="textFotoKTP" value="<?=$key->FOTO_KTP?>">
            <input type="hidden" id="textFotoSIM" value="<?=$key->FOTO_SIM?>">
            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnSave">
                  <i class="fas fa-save"></i>&nbsp;&nbsp;Save Data
                </button>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
    <div id="uploadImageFotoWajah" class="modal" role="dialog">
       <div class="modal-dialog">
          <div class="modal-content">
             <form class="uploadFotoWajah">
             <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Crop &amp; Upload Gambar</h4>
                <button type="button" class="close" data-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
             </div>
             <div class="modal-body">
                <div class="row">
                  
                   <div class="col-md-12 text-center">
                      <div id="image_demo"></div>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button class="btn btn-success crop_wajah">Crop &amp; Upload</button>
             </div>
            </form>
          </div>
       </div>
    </div>
    <div id="uploadImageFotoKartu" class="modal" role="dialog">
       <div class="modal-dialog">
          <div class="modal-content">
             <form class="uploadFotoWajah">
             <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Crop &amp; Upload Gambar</h4>
                <button type="button" class="close" data-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
             </div>
             <div class="modal-body">
                <div class="row">
                  
                   <div class="col-md-12 text-center">
                      <div id="image_demo2"></div>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button class="btn btn-success crop_wajah">Crop &amp; Upload</button>
             </div>
            </form>
          </div>
       </div>
    </div>
    
    <?php $this->load->view('_partial/footer');?>
</div>
<?php $this->load->view("_partial/js");?>
<script src="<?= base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url()?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url()?>assets/plugins/sweetalert2_ori/dist/sweetalert2.min.js"></script>
<script src="<?= base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/Croppie-master/croppie.js"></script>
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
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
    // setBerlaku();
    getImageWajah();
    getImageKTP();
    getImageSIM();
    setSIM();
    rental()
    
    $('#inputSubjek').on('change', function(data){
      var isi = $(this).val();
      var field = 'SUBJEK';
      saveData(isi, field);
      rental();
    })
    $('#inputRekanan').on('change', function(data){
      var isi = $(this).val();
      var field = 'REKANAN';
      saveData(isi, field);
    })
    $('#inputSIM').on('change', function(data){
      var isi = $(this).val();
      var field = 'NO_SIM';
      saveData(isi, field);
    })
    $('#inputSpjDlv').on('change', function(){
      var inputSpjDlv = document.getElementById('inputSpjDlv');
      if (inputSpjDlv.checked == true) {
        var isi = 'Y';
      }else{
        var isi = 'N';
      }

      var field = $(this).attr("field");
      saveData(isi, field);
    })
    $('#inputSpjNdv').on('change', function(){
      var inputSpjNdv = document.getElementById('inputSpjNdv');
      if (inputSpjNdv.checked == true) {
        var isi = 'Y';
      }else{
        var isi = 'N';
      }

      var field = $(this).attr("field");
      saveData(isi, field);
    })
    $('#inputOtoritasDriver').on('change', function(){
      var inputOtoritasDriver = document.getElementById('inputOtoritasDriver');
      if (inputOtoritasDriver.checked == true) {
        var isi = 'Y';
       
      }else{
        var isi = 'N'
       
      }
      setSIM();
      var field = $(this).attr('field');
      saveData(isi, field)
    });
    $('#inputOtoritasPendamping').on('change', function(){
      var inputOtoritasPendamping = document.getElementById('inputOtoritasPendamping');
      if (inputOtoritasPendamping.checked == true) {
        var isi = 'Y'
      }else{
        var isi = 'N'
      }
      var field = $(this).attr('field');
      saveData(isi, field)
    });
    $('#inputUangMakan').on('change', function(){
      var inputUangMakan = document.getElementById('inputUangMakan');
      if (inputUangMakan.checked == true) {
        var isi = 'Y'
      }else{
        var isi = 'N'
      }
      var field = $(this).attr('field');
      saveData(isi, field)
    })
    $('#inputUangSaku').on('change', function(){
      var inputUangSaku = document.getElementById('inputUangSaku');
      if (inputUangSaku.checked == true) {
        var isi = 'Y'
      }else{
        var isi = 'N'
      }
      var field = $(this).attr('field');
      saveData(isi, field)
    })
    $('#inputAdj').on('change', function(){
      var inputAdj = document.getElementById('inputAdj');
      if (inputAdj.checked == true) {
        var isi = 'Y'
      }else{
        var isi = 'N'
      }
      var field = $(this).attr('field');
      saveData(isi, field)
    })
    $('#inputTerbit').on('change', function(){
      var isi = $(this).val();
      var field='BERLAKU_TERBIT';
      saveData(isi, field)
    })
    $('#inputSd').on('change', function(){
      var isi = $(this).val();
      var field='BERLAKU_AKHIR';
      saveData(isi, field)
    })
    $('#btnSave').on('click', function(){
      var inputOtoritasDriver = document.getElementById('inputOtoritasDriver');
      var inputOtoritasPendamping = document.getElementById('inputOtoritasPendamping');
      var inputUangMakan = document.getElementById('inputUangMakan');
      var inputUangSaku = document.getElementById('inputUangSaku');
      var inputAdj = document.getElementById('inputAdj');
      var inputSpjDlv = document.getElementById('inputSpjDlv');
      var inputSpjNdv = document.getElementById('inputSpjNdv');
      var inputSIM = $('#inputSIM').val();
      var inputTerbit = $('#inputTerbit').val();
      var inputSd = $('#inputSd').val();
      var textFotoWajah = $('#textFotoWajah').val();
      var textFotoKTP = $('#textFotoKTP').val();
      var textFotoSIM = $('#textFotoSIM').val();
      var isiDriver = inputOtoritasDriver.checked == true ? 'Y' : 'N';
      var isiPendamping = inputOtoritasPendamping.checked == true ? 'Y' : 'N';
      var isiUangMakan = inputUangMakan.checked == true ? 'Y' : 'N';
      var isiUangSaku = inputUangSaku.checked == true ? 'Y' : 'N';
      var isiSpjDlv = inputSpjDlv.checked == true ? 'Y' : 'N';
      var isiSpjNdv = inputSpjNdv.checked == true ? 'Y' : 'N';
      var isiAdj = inputAdj.checked == true ? 'Y' : 'N';
      var isi = '';
      console.log(isiSpjDlv)
      if (isiDriver == 'Y' || isiPendamping == 'Y' || isiUangMakan == 'Y' || isiUangSaku == '' || isiAdj == '') {
        if (isiDriver == 'Y') {
          if (inputSIM == '') {
            pemberitahuan(isi = 'Anda Belum Mengisi No SIM!')
          }else if(inputTerbit == '' || inputSd==''){
            pemberitahuan(isi = 'Anda Belum Mengisi Tanggal Berlaku SIM!')
          }else if(textFotoWajah == ''){
            pemberitahuan(isi = 'Anda Belum Upload Wajah!')
          }else if(textFotoKTP == ''){
            pemberitahuan(isi='Anda Belum Upload KTP!')
          }else if(textFotoSIM == ''){
            pemberitahuan(isi='Anda Belum Upload SIM!')
          }else{
            saveDataOtoritas();
          }
        }else{
          if(textFotoWajah == ''){
            pemberitahuan(isi = 'Anda Belum Upload Wajah!')
          }else if(textFotoKTP == ''){
            pemberitahuan(isi='Anda Belum Upload KTP!')
          }else{
            saveDataOtoritas();
          }
        }
      }else{
        var isi = 'Anda Belum Memilih Otoritas!'
        pemberitahuan(isi);
      }

      // alert(isiDriver);
    });

  })

  function pemberitahuan(isi) {
    Swal.fire("Mohon Untuk Melengkapi Datanya Terlebih Dahulu",isi,'warning');
  }
  function rental() {
    var inputSubjek = $('#inputSubjek').val();
    if (inputSubjek == 'Rental') {
      $('.rental').removeClass("d-none")
    } else {
      $('.rental').addClass("d-none")

    }
  }
  function berhasil() {
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'success',
        title: 'Berhasil Menyimpan Data!',
        showConfirmButton: false,
        timer: 1500
      })
    }

    function gagal() {
      Swal.fire({
        position: 'top-end',
        toast : true,
        icon: 'error',
        title: 'Gagal Menyimpan Data! Hubungi Staff IT',
        showConfirmButton: false,
        timer: 1500
      })
    }
    function setSIM() {
      var inputOtoritasDriver = document.getElementById('inputOtoritasDriver');
      if (inputOtoritasDriver.checked == true) {
        var isi = 'Y';
        $('#otoritasDriver').removeClass("d-none");
      }else{
        var isi = 'N'
        $('#otoritasDriver').addClass("d-none");
      }
    }
    function saveData(isi, field) {
      var nik = $('#inputNIK').val();
      var jenis = '<?=$this->uri->segment("4")?>';
      $.ajax({
        type: 'post',
        dataType: 'json',
        data:{isi, field, nik, jenis},
        url: url+'/Data_Master/saveDataOtoritasKaryawan',
        cache: false,
        async: true,
        success: function(data){
          // berhasil();
        },
        error: function(data){
          Swal.fire("Terjadi Error Pada Program","Mohon Untuk Refresh Halaman Ini Terlebih Dahulu", 'error');
        }
      })
    }
    function saveDataOtoritas(isiDriver) {
      var nik = $('#inputNIK').val();
      var jenis = '<?=$this->uri->segment("4")?>';
      var isiDriver = inputOtoritasDriver.checked == true ? 'Y' : 'N';
      var isiPendamping = inputOtoritasPendamping.checked == true ? 'Y' : 'N';
      var isiUangMakan = inputUangMakan.checked == true ? 'Y' : 'N';
      var isiUangSaku = inputUangSaku.checked == true ? 'Y' : 'N';
      var isiAdj = inputAdj.checked == true ? 'Y' : 'N';

      var inputSubjek = $('#inputSubjek').val();
      $.ajax({
        type: 'post',
        dataType: 'json',
        data:{nik, jenis, inputSubjek, isiDriver, isiPendamping, isiUangMakan, isiUangSaku, isiAdj},
        url: url+'/Data_Master/saveDataOtoritasKaryawan2',
        cache: false,
        async: true,
        success: function(data){
          berhasil();
          location.reload();
        },
        error: function(data){
          gagal()
        }
      })
    }
    function getImageWajah() {
      var field = 'FOTO_WAJAH';
      var nik = $('#inputNIK').val();
      var folder = 'foto-wajah';
      $.ajax({
        type:'get',
        data:{field, nik, folder},
        url: url+'/Data_Master/getDataFotoKaryawan',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.preloader').show();
        },
        success: function(data){
          $('#getImageWajah').html(data);
        },
        complete: function(data){
          $('.preloader').fadeOut("slow");
        },
        error: function(data){
          $('#getImageWajah').html("");
        }
      });
    }
    function getImageKTP() {
      var field = 'FOTO_KTP';
      var nik = $('#inputNIK').val();
      var folder = 'foto-ktp';
      $.ajax({
        type:'get',
        data:{field, nik, folder},
        url: url+'/Data_Master/getDataFotoKaryawan',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.preloader').show();
        },
        success: function(data){
          $('#getImageKTP').html(data);
        },
        complete: function(data){
          $('.preloader').fadeOut("slow");
        },
        error: function(data){
          $('#getImageKTP').html("");
        }
      });
    }
    function getImageSIM() {
      var field = 'FOTO_SIM';
      var nik = $('#inputNIK').val();
      var folder = 'foto-sim';
      $.ajax({
        type:'get',
        data:{field, nik, folder},
        url: url+'/Data_Master/getDataFotoKaryawan',
        cache: false,
        async: true,
        beforeSend: function(data){
          $('.preloader').show();
        },
        success: function(data){
          $('#getImageSIM').html(data);
        },
        complete: function(data){
          $('.preloader').fadeOut("slow");
        },
        error: function(data){
          $('#getImageSIM').html("");
        }
      });
    }
    function getImage(field, nik, folder) {
      
      
    }
  

</script>
<script>  
$(document).ready(function(){
  
  $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:250,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:350
    }
  });
  $image_crop2 = $('#image_demo2').croppie({
    enableExif: true,
    viewport: {
      width:320,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:350,
      height:300
    }
  });
  var inputNIK = $('#inputNIK').val();
  $('#fileWajah').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
        console.log(inputNIK)
        $('#fileTipe').val("wajah");
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadImageFotoWajah').modal('show');
  });
  $('#fileKTP').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop2.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
        console.log(inputNIK)
        $('#fileTipe').val("ktp");
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadImageFotoKartu').modal('show');
  });
  $('#fileSIM').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop2.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
        console.log(inputNIK)
        $('#fileTipe').val("sim");
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadImageFotoKartu').modal('show');
  });
  $('.uploadFotoWajah').submit(function(e){
    e.preventDefault();
      var tipe = $('#fileTipe').val();
      var valid = 0;
      var field = '';
      var folder = '';
      if (tipe == 'wajah') {
        var file = $('#fileWajah')[0];
        valid = 1;  
        field = 'FOTO_WAJAH';
        folder = 'foto-wajah';
      }else if(tipe == 'ktp'){
        var file = $('#fileKTP')[0];
        valid = 1;
        field = 'FOTO_KTP';
        folder = 'foto-ktp';
      }else if(tipe == 'sim'){
        var file = $('#fileSIM')[0];
        valid = 1;
        field = 'FOTO_SIM';
        folder = 'foto-sim';
      }else{
        Swal.fire("Oopssss....","Terjadi Error Program! Hubungi Staff IT!","error");
        valid = 0;
        field = '';
        folder = '';
      }
      
      if (valid>0) {
        var info_file = file.files[0];

        var nama = info_file.name;
        var size = info_file.size;
        var type = info_file.type;

        if (size > 1000000) {
          Swal.fire("Ukuran Terlalu Besar!","Upload File Dengan Ukuran Kurang Dari 1 Mb",'error')
        }else if(nama.length>255){
          Swal.fire("Nama File Terlalu Panjang!","Re-name terlebih dahulu nama file",'error')
        }else if(type != 'application/pdf' && type != 'image/png' && type != 'image/jpeg' && type != 'image/jpg'){
          Swal.fire("Format File Tidak Valid","Masukan file dengan format .png, .jpg, atau .jpeg",'error')
        }else{
          if (tipe == 'wajah') {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                uploadGambar(response, inputNIK, field, folder)
            });
          } else {
            $image_crop2.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                uploadGambar(response, inputNIK, field, folder)
            });
          }
        }
      }
    
  })
  function uploadGambar(response, inputNIK, field, folder) {
    var jenis = '<?=$this->uri->segment("4")?>';
    $.ajax({
        url: url+"/Data_Master/uploadWajah",
        type: 'POST',
        dataType: 'json',
        data: {
            "image": response,
            inputNIK,
            field,
            folder,
            jenis
        },
        success: function(data) {
            $('#uploadImageFotoWajah').modal('hide');
            $('#uploadImageFotoKartu').modal("hide");
            berhasil();
            if (field == 'FOTO_WAJAH') {
              getImageWajah();
              $('#textFotoWajah').val("isi");
            }else if(field == 'FOTO_KTP'){
              getImageKTP();
              $('#textFotoKTP').val("isi");
            }else if(field == 'FOTO_SIM'){
              getImageSIM();
              $('#textFotoSIM').val("isi");
            }else{
              getImageWajah();
              getImageKTP();
              getImageSIM();
            }

        },
        error: function(data){
            gagal();
        }
    })
  }
});  
</script>
<!-- FootJS -->
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    kondisiBBM();
    $('.preloader').fadeOut('slow');
    $('.preloader-no-bg').fadeOut('slow');
    $('.ladda-button').ladda('bind', {timeout: 1000});
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    $('#tambahLokasi').on('click', function(){
      getCustomerSerlok();
    })
    $('.btnStepNext').on('click', function(){
      // stepper.next()

     })
     $('.btnStepPrevios').on('click', function(){
      stepper.previous()
     });
     $('#btnNextKendaraan').on('click', function(){
      var inputJenisKendaraan = $('#inputJenisKendaraan').val();
      var inputJenisSPJ = $('#inputJenisSPJ').val();
      var inputNoTNKB = $('#inputNoTNKB').val();
      if (inputJenisKendaraan =='' && inputJenisSPJ == '1') {
        Swal.fire("Jenis Kendaraan Tidak Boleh Kosong!","","warning")
      }
      else if(inputNoTNKB == ''){
        Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
      }else{
        saveKendaraan()
        
      }
      // stepper.next()

     })
     $('#btnNextTujuan').on('click', function(){
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      var inputNoSPJ = $('#inputNoSPJ').val(); 
      // settingUangJalanLokal();
      var inputJenisSPJ = $('#inputJenisSPJ').val();
      settingManualJalan();
      
      if (inputGroupTujuan == '') {
        Swal.fire("Pilih Terlebih dahulu Lokasi Tujuan","","warning")
      }else if(inputJenisSPJ == '2' && $('#inputKeteranganTujuan').val() == ''){
        Swal.fire("Isi Keterangan Tujuan Terlebih Dahulu!","","warning")
      }else{
        cekPengajuanPIC();
        if (inputJenisSPJ == '1') {
          cekTujuanAbnormal();
        }
      }
      
      
     });
      $('#btnNextRencana').on('click', function(){
        var inputTglBerangkat = $('#inputTglBerangkat').val();
        var inputJamBerangkat = $('#inputJamBerangkat').val();
        var inputTglPulang = $('#inputTglPulang').val();
        var inputJamPulang = $('#inputJamPulangm').val();
        if (inputTglBerangkat == '' || inputTglPulang == '' || inputJamBerangkat == '' || inputJamPulang == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu","","warning")
        } else {
          saveRencanaBerangkat();
          
        }
      })
    kondisiKendaraan()
    pengaturanSortir();
    cekVoucher()
    kondisiTombolLokasi();

    // make_skeleton().fadeOut();
    $('#afterNext').addClass("d-none");
    $('#beforeNext').removeClass("d-none");
    $('#inputJenisSPJ').on('change', function(){
      var jenis = $(this).val();
      getSaldoPerJenis(jenis);
      console.log(jenis)
      if (jenis !='') {
        getNoSPJ(jenis);
        disVoucher()
        kondisiTombolLokasi();
        if (jenis == '1') {
          $('[name="inputAbnormal"]').removeAttr("disabled","disabled");
          
        }else{
          $('[name="inputAbnormal"]').attr("disabled","disabled");
          document.getElementById("inputAbnormal").checked = false;
          
        }
      }else{
        $('#inputNoSPJ').val('');
      }

      if (jenis == '3') {
        $('.otherTujuan').removeClass("d-none");
      }else{
        $('.otherTujuan').addClass("d-none");
      }

      if (jenis == '2') {
        $('#tampilTotalUangJalan').addClass("d-none");
        $('#manualUangJalan').removeClass("d-none");
        $('#btnCekProgramSerlok').attr("disabled","disabled")
        $('.lokalUangJalan').addClass("d-none");
      }else{
        $('#tampilTotalUangJalan').removeClass("d-none");
        $('#manualUangJalan').addClass("d-none");
        $('.lokalUangJalan').addClass("d-none");
        $('#btnCekProgramSerlok').removeAttr("disabled","disabled")
      }
    })
    $('#btnNext').on('click', function(data){
      var jenis= $('#inputJenisSPJ').val();
      
      getNoSPJ(jenis);
    });
    $('#inputJenisOther').on('change', function(){
      var isi = $(this).val()
    });
    var btnNext = $('.btnNext').ladda();
      btnNext.click(function () {
      // Start loading
      btnNext.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        var jenisSPJ = '';
        var tglSekarang = '<?=date("Y-m-d")?>';
        var inputTglSPJ = $('#inputTglSPJ').val();
        var inputSaldoHidden = $('#inputSaldoHidden').val();
        var inputJenisOther = $('#inputJenisOther').val();
        var inputTempatKeberangkatan = $('#inputTempatKeberangkatan').val();
        if (inputJenisSPJ == '1') {
          jenisSPJ = 'Delivery';
        }else if (inputJenisSPJ == '2'){
          jenisSPJ = 'Non Delivery';
          $('#inputObjekLainnya').removeAttr("disabled","disabled");
          document.querySelectorAll("#inputObjek option").forEach(opt => {
              opt.disabled = false;
          });
          $("select#inputObjek option[value='Customer']").prop("selected","selected");
          $("select#inputObjek").trigger("change")
        }else{
          jenisSPJ ='Other';
          $('#inputObjekLainnya').val(inputJenisOther)
          $("select#inputObjek option[value='Lainnya']").prop("selected","selected");
          $("select#inputObjek").trigger("change")
          // $('#')
          document.querySelectorAll("#inputObjek option").forEach(opt => {
              if (opt.value == "Customer" || opt.value == 'Supplier' || opt.value == 'Rekanan') {
                  opt.disabled = true;
              }else{
                opt.disabled = false;
              }
          });
        }
        var inputNoSPJ = $('#inputNoSPJ').val();
        if (inputJenisSPJ == '') {
          Swal.fire("Pilih Terlebih Dahulu Jenis SPJ!","","warning");
        }else if(inputTglSPJ == ''){
          Swal.fire("Pilih Tanggal SPJ nya terlebih Dahulu!","","warning")
        }else if(inputNoSPJ == ''){
          Swal.fire("No SPJ Gagal Di Buat!","Mohon Untuk Reload Terlebih Dahulu Pada Halaman Ini","warning");
        }else if(parseInt(inputSaldoHidden)<1 && inputJenisSPJ != '3'){
          Swal.fire("Saldo Masih 0!","Hubungi PIC Terkait","warning")
        }else{
          if (tglSekarang>inputTglSPJ) {
            Swal.fire("Tanggal SPJ Hanya Diperbolehkan Diisi Minimal Tanggal Hari Ini!","","warning")
          } else {
            $.ajax({
              type:'post',
              dataType: 'json',
              data:{inputJenisSPJ, inputNoSPJ, inputTglSPJ, inputJenisOther, inputTempatKeberangkatan},
              url: url+'/pengajuan/saveTemporaryPengajuan',
              cache: false,
              async: true,
              beforeSend: function(data){
                $('.preloader-no-bg').show();
              },
              success: function(data){
                berhasil();
                getQrCode();
                disVoucher();
                // getPIC();
                $('#isiPengajuan').removeClass("d-none");
                $('#afterNext').removeClass("d-none");
                $('#beforeNext').addClass("d-none");
                $('#getNext').addClass("d-none");
                $('input[id="inputJenisSPJ"]').val(jenisSPJ);
                $('#inputAbnormal').attr("disabled","disabled")
                // $('#btnSaveSPJ').removeClass("d-none");
                $('#inputTglSPJ').attr("readonly","readonly")
                var jenisData = '<?=$this->uri->segment("2")?>';
                if (jenisData != 'form_temporary') {
                  $('#inputTglBerangkat').val(inputTglSPJ);
                  $('#inputTglPulang').val(inputTglSPJ);  
                }

                if (inputJenisSPJ ==2) {
                  $('.formKeteranganTujuan').removeClass("d-none")
                }
                

              },
              complete: function(data){
                $('.preloader-no-bg').fadeOut('slow');
              },
              error: function(data){
                gagal();
              }
            });
          }
          
        }
        
        btnNext.ladda('stop');
        return false;
          
      }, 1000)
    });
    $('#inputKendaraan').on('change', function(){
      kondisiKendaraan()
      var kendaraan = $(this).val();
      if (kendaraan == 'Rental') {
        $('.rekanan').removeClass("d-none");
        getListRekanan();
      }else{
        $('#inputRekananKendaraan').val("")
        $('.rekanan').addClass("d-none")
      }
      if (kendaraan == 'Rental' || kendaraan == 'Pribadi' || kendaraan == 'Gojek/Grab') {
        $('#inputNoInventaris').val("-")
        $('#inputMerk').val("");
        $('#inputType').val("");
        $('#inputNoTNKB').val("");
        
      }else{
        $('#inputNoInventaris').val("")
        
      }
      if (kendaraan == 'Gojek/Grab') {
        $('.biayaKendaraanRental').removeClass("d-none")
        saveAutoBiayaKendaraan();
      }else{
        $('.biayaKendaraanRental').addClass("d-none")
      }
    });
    $('#inputJenisKendaraan').on('change', function(){
      var jenis = $(this).val()
      if (jenis == 'Sepeda Motor') {
        kondisiBBM();
        $("select#inputMediaBBM option[value='Kasbon']").prop("selected","selected");
        $("select#inputMediaBBM").trigger("change")
        document.querySelectorAll("#inputMediaBBM option").forEach(opt => {
          if (opt.value != 'Kasbon') {
              opt.disabled = true;
          }else{
            opt.disabled = false;
          }
        });
      } else {
        $("select#inputMediaBBM option[value='Voucher']").prop("selected","selected");
        $("select#inputMediaBBM").trigger("change")
        document.querySelectorAll("#inputMediaBBM option").forEach(opt => {
          opt.disabled = false;
        });
      }
    })
    $('#pilihKendaraan').on('click', function(){
      searchKendaraan();
      $('#modal-kendaraan').modal("show");
    })
    $('#searchKendaraan').on('keyup', function(){
      searchKendaraan();
    })
    $('#getKendaraan').on('click', '.pilihKendaraan', function(){
      var tnkb = $(this).attr('tnkb');
      var merk = $(this).attr("merk");
      var tipe = $(this).attr("tipe");
      var inv = $(this).attr("inv");
      var inputJenisKendaraan = $('#inputJenisKendaraan').val();
      var noSPJ = $('#inputNoSPJ').val();
      var kendaraan = $('#inputKendaraan').val();

      $('#inputNoInventaris').val(inv);
      $('#inputMerk').val(merk);
      $('#inputType').val(tipe);
      $('#inputNoTNKB').val(tnkb);
      $('#modal-kendaraan').modal("hide");
      $.ajax({
        type: 'post',
        data: {inv, inputJenisKendaraan, noSPJ, tnkb, merk, tipe, kendaraan},
        dataType: 'json',
        url: url+'/pengajuan/saveKendaraanSPJ',
        cache: false,
        async: true,
        success: function(data){
          console.log(data);
        },
        error: function(data){
          console.log("error");
        }
      })
    });
    getLokasi();
    $('#inputGroupTujuan').on('change', function(){
      var id = $(this).val();
      if (id == '') {
        $('#viewTujuan').html('');
        $('#inputPerusahaan').html("");
      }else{
        $.ajax({
          type: 'get',
          data: {id},
          dataType: 'json',
          url: url+'/pengajuan/getViewJalur',
          async: true,
          cache: false,
          beforeSend: function(data){
            $('.preloader-no-bg').show();
          },
          success: function(data){
            saveGroupTujuan();
            getCustomerSerlok();
            getLokasi()
            getPIC()
            getTotalUangSakuMakan()
            getUangJalan();
            var tujuan = '';
            var kota= '';
            var koma='';
            for (var i = 0; i < data.length; i++) {
              if (i>0) {
                koma = ', ';
              }
              kota +=data[i].TIPE_KOTA+' '+data[i].NAMA_KOTA;

              tujuan +=koma+kota;
              kota = '';
            }
            $('#viewTujuan').html(tujuan);
          },
          complete: function(data){
            $('.preloader-no-bg').fadeOut('slow');
          },
          error: function(data){
            $('#viewTujuan').html();
          }
        });
      }

    })

    $('#inputObjek').on('change', function(){
      var objek = $(this).val();
      var inputJenisSPJ = $('#inputJenisSPJ').val();
      if (objek == 'Lainnya' && inputJenisSPJ == 3) {
        $('.objekLainnya').removeClass("d-none")
        $('.objekNormal').addClass("d-none");
        $('#btnCekProgramSerlok').attr("disabled","disabled")
        $('#inputKota').attr("disabled","disabled")
        $('.objekRekanan').addClass("d-none");
      }else if(objek =='Lainnya' && inputJenisSPJ ==2){
        $('#inputObjekLainnya').removeAttr("readonly","readonly");
        $('.objekLainnya').removeClass("d-none")
        $('.objekNormal').addClass("d-none");
        $('.objekRekanan').addClass("d-none");
      }else if(objek == 'Rekanan'){
        $('.objekLainnya').addClass("d-none");
        $('.objekNormal').addClass("d-none");
        $('.objekRekanan').removeClass("d-none");
      } else {
        $('.objekLainnya').addClass("d-none");
        $('.objekNormal').removeClass("d-none");
        $('.objekRekanan').addClass("d-none");
        getCustomerSerlok();
        
      }
      configGroupTujuanByObjek()
    });
    configGroupTujuanByObjek()
    $('#inputJenisSPJ').on('change', function(){
      disJenisPIC();
    })
    $("#inputKotaKabupaten").select2({
      ajax: { 
        url: url+'/pengajuan/getKotaAPI',
        type: "post",
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
    $('#inputKotaKabupaten').on('change', function(){
      var id = $(this).val();
      $.ajax({
        type:'get',
        data:{id},
        dataType:'json',
        url:url+'/pengajuan/findGroupTujuanByIdKota',
        cache:false,
        async:true,
        success:function(data){
          $("select#inputGroupPerusahaan3 option[value='"+data+"']").prop("selected","selected");
          $("select#inputGroupPerusahaan3").trigger("change")
          document.querySelectorAll("#inputGroupPerusahaan3 option").forEach(opt => {
            if (opt.value == data || opt.value == '11') {
                opt.disabled = false;
            }else{
              opt.disabled = true;
            }
          });
        },
        error:function(data){
          Swal.fire("Gagal Mengambil Data","Hubungi Staff IT","error")
        }
      })
    });
    $("#inputPerusahaan").select2({
      ajax: { 
        url: url+'/pengajuan/getCustomerSerlok',
        type: "get",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            var inputObjek = $('#inputObjek').val();
            var inputJenisSPJ = $('#inputJenisSPJ').val();
            return {
              cari: params.term,
              inputObjek:inputObjek, inputJenisSPJ:inputJenisSPJ // search term
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

    $('#inputPerusahaan').on('change', function(){
      var inputPerusahaan = $('#inputPerusahaan').val();
      var inputObjek = $('#inputObjek').val();
      $.ajax({
        type:'get',
        data: {inputPerusahaan, inputObjek},
        dataType:'json',
        async: true,
        cache: false,
        url:url+'/pengajuan/findGroupTujuan',
        success: function(data){
          if (parseInt(data)>0) {
            $('.objekPilihKota').addClass("d-none")
            $("select#inputGroupPerusahaan option[value='"+data+"']").prop("selected","selected");
            $("select#inputGroupPerusahaan").trigger("change")
            document.querySelectorAll("#inputGroupPerusahaan option").forEach(opt => {
              if (opt.value != data) {
                  opt.disabled = true;
              }else{
                opt.disabled = false;
              }
            });
          }else{
            $('.objekPilihKota').removeClass("d-none")
            Swal.fire("Sistem Tidak Bisa Membaca Kota Tujuan Perusahaan Tersebut","Mohon Untuk Pilih Kota Tujuan Manual","info")
            document.querySelectorAll("#inputGroupPerusahaan option").forEach(opt => {
              opt.disabled = false;
            });
            pilihKota();
          }
        },
        error: function(data){
          Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error");
        }
      });
    });
    $('#inputPilihKota').on('change', function(){
      pilihKota();
    })


    var saveLokasi = $('.saveLokasi').ladda();
      saveLokasi.click(function () {
      // Start loading
      saveLokasi.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var objek = $('#inputObjek').val();
        var objekLainnya = $('#inputObjekLainnya').val();
        if (objek == 'Lainnya') {
          var inputPerusahaan = '-'
          var inputGroupTujuan = '0'
          var inputGroupTujuan = $('#inputGroupPerusahaan3').val();
        }else if(objek == 'Rekanan'){
          var inputPerusahaan = $('#inputPerusahaan2').val()
          var inputGroupTujuan = $('#inputGroupPerusahaan2').val()  
        }else{
          var inputPerusahaan = $('#inputPerusahaan').val();
          var inputGroupTujuan = $('#inputGroupPerusahaan').val();
        } 

        var inputObjek = objek == 'Lainnya'?objekLainnya:objek;
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputKotaKabupaten = $('#inputKotaKabupaten').val();
        var inputNamaTempat = $('#inputNamaTempat').val();
        var inputAlamat = $('#inputAlamat').val();
        var inputJenisSPJ = $('#inputJenisSPJ').val();
        var inputPilihKota = $('#inputPilihKota').val();
        if (objek == '' || inputPerusahaan == '' || inputGroupTujuan == '') {
          Swal.fire("Lengkapi Dulu Datanya!","","warning");
          saveLokasi.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            dataType:'json',
            data:{inputPerusahaan, inputGroupTujuan, inputObjek, inputNoSPJ, objek, inputKotaKabupaten, inputNamaTempat, inputAlamat, inputPilihKota},
            url:url+'/pengajuan/saveLokasiTujuan',
            cache: false,
            async: true,
            success: function(data){
              $('#modal-lokasi').modal('hide');
              berhasil();
              getLokasi();
              getUangJalan();
              updateGroupTujuan();
              if (inputJenisSPJ == '1') {
               var inputAbnormal = document.getElementById("inputAbnormal");
                if (inputAbnormal.checked == true) {
                  getUangAbnormalDM();
                } 
              }
              
            },
            complete: function(data){
              saveLokasi.ladda('stop');
            },
            error: function(data){
              gagal()
            },
          });
        }
        return false;
          
      }, 1000)
    });

    $('.pilihPIC').on('change', function(){
      var inputJenisPIC = $('#inputJenisPIC').val();
      var inputSubjek = $('#inputSubjek').val();
    })

    $('#inputJenisPIC').on('change', function(){
      var jenis = $(this).val();
      if (jenis == 'Office' || jenis == 'Manajemen') {
        document.querySelectorAll("#inputSubjek option").forEach(opt => {
            if (opt.value == "Rental") {
                opt.disabled = true;
            }else{
              opt.disabled = false;
            }
        });
        $("select#inputSubjek option[value='Internal']").prop("selected","selected");
        $("select#inputSubjek").trigger("change")  
        $("select#inputSubcont option[value='']").prop("selected","selected");
        $("select#inputSubcont").trigger("change")  
      }else if(jenis == 'Subcont'){
        document.querySelectorAll("#inputSubjek option").forEach(opt => {
            if (opt.value == "Rental" || opt.value == 'Internal') {
                opt.disabled = true;
            }else{
              opt.disabled = false;
            }
        });
        $("select#inputSubjek option[value='Subcont']").prop("selected","selected");
        $("select#inputSubjek").trigger("change")
      }else{
        document.querySelectorAll("#inputSubjek option").forEach(opt => {
          if (opt.value == "Subcont") {
                opt.disabled = true;
            }else{
              opt.disabled = false;
            }
        });
        $("select#inputSubcont option[value='Internal']").prop("selected","selected");
        $("select#inputSubcont").trigger("change")
      }
      var subjek = $('#inputSubjek').val();
      if (jenis == 'Subcont') {
        $('.formSubcont').removeClass("d-none")
      }else{
        $('.formSubcont').addClass("d-none")
        $("select#inputSubcont option[value='']").prop("selected","selected");
        $("select#inputSubcont").trigger("change")
      }
      // if (jenis == 'Subcont') {
      //   $('#btnPilihPIC').attr("disabled","disabled")
      //   $('.inputanPIC').removeAttr("readonly","readonly")
      //   $('.formSubcont').removeClass("d-none")
      //   // $('#setNIK_PIC').val("-")
      //   $('#setNIK_PIC').attr("readonly","readonly")
      //   $('#setNamaPIC').val("-")
      //   $('#setDivisiPIC').val("-")
      //   $('#setDepartemenPIC').val("-")
      //   $('#setSubDepartemenPIC').val("-")
      //   $('#setJabatanPIC').val("-")
      //   $('#inputUangSaku').val("0")
      //   $('#showUangSaku').val("0");
      //   $('#inputPIC').val("-")
      // }else if(jenis == 'Sopir' && subjek == 'Subcont'){
      //   $('#btnPilihPIC').attr("disabled","disabled")
      //   $('.inputanPIC').removeAttr("readonly","readonly")
      //   // $('#setNIK_PIC').val("-")
      //   $('#setNIK_PIC').attr("readonly","readonly")
      //   $('#setNamaPIC').val("-")
      //   $('#setDivisiPIC').val("-")
      //   $('#setDepartemenPIC').val("-")
      //   $('#setSubDepartemenPIC').val("-")
      //   $('#setJabatanPIC').val("-")
      //   $('#inputUangSaku').val("0")
      //   $('#showUangSaku').val("0");
      //   $('#inputPIC').val("-")
      //   $('.formSubcont').removeClass("d-none")
      // }else{
      //   $('#btnPilihPIC').removeAttr("disabled","disabled")
      //   $('.inputanPIC').attr("readonly","readonly")
      //   $('.formSubcont').addClass("d-none")
      //   $("select#inputSubcont option[value='']").prop("selected","selected");
      //   $("select#inputSubcont").trigger("change")
      // }

    });
    $('#inputSubjek').on('change', function(){
      var pic = $(this).val();
      var jenis = $('#inputJenisPIC').val()
      console.log("pengaturan subjek baru")
      if (pic == 'Subcont') {
        $('.formSubcont').removeClass("d-none")
      }else{
        $('.formSubcont').addClass("d-none")
        $("select#inputSubcont option[value='']").prop("selected","selected");
        $("select#inputSubcont").trigger("change")
      }
      // if (jenis =='Sopir' && pic == 'Subcont') {
      //   $('#btnPilihPIC').attr("disabled","disabled")
      //   $('.inputanPIC').removeAttr("readonly","readonly")
      //   $('.formSubcont').removeClass("d-none")
      //   $('#inputUangSaku').val("0")
      //   $('#showUangSaku').val("0");
      //   // $('#setNIK_PIC').val("-")
      //   $('#setNIK_PIC').attr("readonly","readonly")
      //   $('#setNamaPIC').val("-")
      //   $('#setDivisiPIC').val("-")
      //   $('#setDepartemenPIC').val("-")
      //   $('#setSubDepartemenPIC').val("-")
      //   $('#setJabatanPIC').val("-")
      //   $('#inputPIC').val("-")
      // }else if(pic == 'Subcont'){
      //   $('#btnPilihPIC').attr("disabled","disabled")
      //   $('.inputanPIC').removeAttr("readonly","readonly")
      //   $('.formSubcont').removeClass("d-none")
      //   $('#inputUangSaku').val("0")
      //   $('#showUangSaku').val("0");
      //   // $('#setNIK_PIC').val("-")
      //   $('#setNIK_PIC').attr("readonly","readonly")
      //   $('#setNamaPIC').val("-")
      //   $('#setDivisiPIC').val("-")
      //   $('#setDepartemenPIC').val("-")
      //   $('#setSubDepartemenPIC').val("-")
      //   $('#setJabatanPIC').val("-")
      //   $('#inputPIC').val("-")
      // }else{
      //   $('#btnPilihPIC').removeAttr("disabled","disabled")
      //   $('.inputanPIC').attr("readonly","readonly")
      //   $('.formSubcont').addClass("d-none")
      //   $("select#inputSubcont option[value='']").prop("selected","selected");
      //   $("select#inputSubcont").trigger("change")
      // }
    })

    $('#btnTambahPIC').on('click', function(){
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      hitungUangSaku();
      hitungUangMakan();
      getNIK();
      if (inputGroupTujuan == '') {
        Swal.fire("Pilih Terlebih Dahulu Group Tujuannya!","","warning");
      }else{
        $('#modal-pic').modal("show")
      }
    });
    $('#inputPIC').on('change', function(){
      var nik = $(this).val();
      $.ajax({
        type: 'get',
        data:{nik},
        dataType: 'json',
        url:url+'/pengajuan/getDataInputPIC',
        async: true,
        cache: false,
        success: function(data){
          // console.log(data.departemen)
          $('#setDepartemenPIC').val(data.departemen);
          $('#setSubDepartemenPIC').val(data.Subdepartemen1);
          $('#setJabatanPIC').val(data.jabatan);
          $('#setNamaPIC').val(data.namapeg);
          $('#setDivisiPIC').val(data.divisi);
          pengaturanSortir();
          hitungUangSaku();
          hitungUangMakan();
        },
        error: function(data){

        }
      });
    });
    $('#getListPIC').on('click','.pilihPICByNIK', function(){
      var nik = $(this).attr("nik")
      var nama = $(this).attr("nama")
      var departemen = $(this).attr("departemen")
      var jabatan = $(this).attr("jabatan")
      var subdepartemen1 = $(this).attr("subdepartemen1")
      var subdepartemen2 = $(this).attr("subdepartemen2")
      $('#setDepartemenPIC').val(departemen);
      $('#setSubDepartemenPIC').val(subdepartemen1);
      $('#setJabatanPIC').val(jabatan);
      $('#setNamaPIC').val(nama);
      $('#setNama_PIC').val(nama);
      $('#setDivisiPIC').val(subdepartemen2);
      $('#setNIK_PIC').val(nik);
      $('#inputPIC').val(nik)
      $('#modal-pilihPIC').modal("hide");
      if (departemen == 'Quality' || departemen == 'Produksi') {
        $('#inputSortir').removeAttr("disabled","disabled")
      } else {
        $('#inputSortir').attr("disabled","disabled")
        document.getElementById("inputSortir").checked = false;  
      }
      hitungUangSaku();
      hitungUangMakan();
    })
     $('#inputSortir').on('change', function(){
      
      hitungUangSaku()
      hitungUangMakan();
    });

    var savePIC = $('.savePIC').ladda();
      savePIC.click(function () {
      // Start loading
      savePIC.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var inputJenisPIC = $('#inputJenisPIC').val();
        var inputSubjek = $('#inputSubjek').val();
        var inputPIC = $('#inputPIC').val();
        var inputGroupTujuan = $('#inputGroupTujuan').val();
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputJenisKendaraan = $('#inputJenisKendaraan').val();
        var setDivisiPIC = $('#setDivisiPIC').val();
        console.log(inputJenisPIC)
        console.log(inputSubjek)
        console.log(inputPIC)
        if (inputJenisPIC == '' || inputSubjek == '' || inputPIC == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Pastikan Pilihan PIC dan Subjek nya terisi","warning")
          savePIC.ladda('stop');
        }else{
          $.ajax({
            type: 'get',
            dataType: 'json',
            data:{inputNoSPJ, inputGroupTujuan, inputPIC, inputJenisKendaraan},
            url:url+'/pengajuan/cekJumlahSupir',
            async: true,
            cache: false,
            beforeSend: function(data){

            },
            success: function(data){
              if (inputJenisPIC == 'Subcont' || inputSubjek == 'Subcont') {
                savePICPengajuan();
              }else if (parseInt(data.JML_DRIVER) >0 && inputJenisPIC == 'Sopir') {
                Swal.fire("Driver Sudah di Daftarkan!","Dalam 1 SPJ Tidak Boleh Lebih dari 1 Driver","warning");
              }else if(parseInt(data.JML_PIC) >0){
                Swal.fire("PIC Dengan NIK tersebut Sudah Terdaftar Pada SPJ Ini!","","warning")
              }else if(parseInt(data.SET_PENDAMPING) <= parseInt(data.JML_PENDAMPING) && inputJenisPIC == 'Pendamping' ){
                Swal.fire("Jumlah Pendamping Sudah Memenuhi Ketentuan Jumlah Pendamping!","Tidak Bisa Menambah Kembali Pendamping","warning")
              }else if(parseInt(data.JML_MARKETING)> 0 && parseInt(inputGroupTujuan)!=3 && inputJenisPIC == 'Sopir'){
                Swal.fire("Marketing Tidak Diperbolehkan Menggunakan Supir Dari KPS","Kecuali Tujuan Tanggerang, Semarang, dan Surabaya","warning")
              }else if(setDivisiPIC == 'Marketing' && parseInt(inputGroupTujuan)!=3 && parseInt(data.JML_DRIVER) >0){
                Swal.fire({
                  title: 'Anda Menambahkan PIC Marketing',
                  text: "Didalam Aturan, Marketing Tidak Diperbolehkan Menggunakan Supir Kecuali Dengan Tujuan Tanggerang, Semarang, dan Surabaya. Jika Sudah Terlanjur Terdapat PIC Supir, Maka Data PIC Supir Akan Terhapus Secara Otomatis",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#B22222',
                  cancelButtonColor: '#CD5C5C',
                  confirmButtonText: 'Tambahkan PIC Marketing!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    hapusPICDriverCzMarketing();
                  }
                })
                console.log("marketing")
              }else{
                savePICPengajuan();
                // console.log(parseInt(data.JML_PENDAMPING))
                // console.log(parseInt(data.SET_PENDAMPING))
              }

              // console.log(data)
            },
            complete: function(data){
              savePIC.ladda('stop');
            },
            error: function(data){
              Swal.fire("Gagal Menyimpan Data","","error")
            }
          });
          
        }
        
        return false;
          
      }, 1000)
    });

    $('#setNIK_PIC').on('keyup', function(){
      var inputJenisPIC = $('#inputJenisPIC').val()
      var isi = $(this).val();
      $('#inputPIC').val(isi)
    })

    $('#setNama_PIC').on('keyup', function(){
      var inputJenisPIC = $('#inputJenisPIC').val();
      var isi = $(this).val();
      $('#setNamaPIC').val(isi)
    })

    $('.saveRencana').on('change', function(){
      var isi = $(this).val();
      // console.log(isi)
    })

    $('#btnSaveSPJ').on('click', function(){
      var inputNoSPJ = $('#inputNoSPJ').val();
      var status = $(this).attr("status");
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
            cekAdaDriver(status);
          }
        },
        error: function(data){

        }
      });
    });

    $('#cekVoucher').on('change', function(){
      cekVoucher();

    });

    $('#getLokasi').on('click', '.hapusLokasi', function(){
      var id = $(this).attr("data");
      var inputNoSPJ = $('#inputNoSPJ').val();
      var nama = $(this).attr("nama");
      $.ajax({
        type:'post',
        data:{id, inputNoSPJ, nama},
        dataType: 'json',
        url:url+'/pengajuan/hapusLokasi',
        success: function(data){
          berhasil();
          getLokasi();
          updateGroupTujuan();
        },
        error: function(data){
          gagal()
        }
      })
    });
    $('#getPIC').on('click', '.hapusPIC', function(){
      var id = $(this).attr("data");
      var nama = $(this).attr("nama");
      var inputNoSPJ = $('#inputNoSPJ').val();
      $.ajax({
        type:'post',
        data:{id, nama, inputNoSPJ},
        dataType: 'json',
        url:url+'/pengajuan/hapusPIC',
        cache: false,
        async: true,
        success: function(data){
          berhasil()
          getPIC();
        },
        error: function(data){
          gagal();
        }
      });
    });

    $('#inputKota').on('change', function(){
      getCustomerSerlok();
    });

    // $("#inputBBMVoucher").select2({
    //   ajax: { 
    //     url: 'getVoucherBBM',
    //     type: "post",
    //     dataType: 'json',
    //     delay: 250,
    //     data: function (params) {
    //         return {
    //           cari: params.term // search term
    //         };
    //     },
    //     processResults: function (response) {
    //         return {
    //            results: response
    //         };
    //         console.log(response)

    //     },
    //     cache: true
    //   }
    // });
    // $('#inputBBMVoucher').on('change', function(){
    //   var id = $(this).val();
    //   $.ajax({
    //     type: 'get',
    //     data:{id},
    //     dataType: 'json',
    //     url: 'getVoucherBBMPerId',
    //     cache: false,
    //     async: true,
    //     success: function(data){
    //       $('#inputIdVoucher').val(id);
    //       $('#inputBBMOtomatis').val(data.RP);
    //     },
    //     error: function(data){

    //     }
    //   });
    // })
    $('#btnNextPIC').on('click', function(){
      stepper.next()
      // getNoVoucher()
      var inputAbnormal = document.getElementById("inputAbnormal");
      if (inputAbnormal.checked == true) {
        getUangAbnormalDM();
      }
      getPilihanUangJalan();
    })
    $('#inputMediaBBM').on('change', function(){
      kondisiBBM();
    });
    $('#inputMediaTol').on('change', function(){
      var isi = $(this).val();
      if (isi == 'Kasbon') {
        $('#inputTOL').removeAttr("readonly","readonly");
      } else {
        $('#inputTOL').val("");
        $('#inputTOL').attr("readonly","readonly");
      }
    });
    settingManualJalan();
    $('#inputAbnormal').on('click', function(){
      settingManualJalan();
      var inputAbnormal = document.getElementById("inputAbnormal");
      if (inputAbnormal.checked == true) {
        getUangAbnormalDM();
      }
    });

    $('#inputManualUangJalan').on('keyup', function(){
      var isi = $(this).val();
      $('#inputTotalUangJalan').val(isi)
    });
    $('.nextBiaya').on('click', function(){
      var inputAbnormal = document.getElementById("inputAbnormal");
      var inputManualUangJalan = $('#inputManualUangJalan').val();
      if (inputAbnormal.checked == true && inputManualUangJalan == '') {
        Swal.fire("Lengkapi Datanya Terlebih Dahulu!","","warning")
      }else{
        console.log(inputAbnormal)
        stepper.next()
      }
    })

    var saveCustomerSerlok = $('.saveCustomerSerlok').ladda();
      saveCustomerSerlok.click(function () {
      // Start loading
      saveCustomerSerlok.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var idDelivery=[];
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputTglSPJ = $('#inputTglSPJ').val();
        var inputNoTNKB = $('#inputNoTNKB').val();
        var data = $('#inputDepartureTime').val();
        var proses = 'New';
        $.each($('[name="pilihCustomer"]:checked'), function(){
          idDelivery.push($(this).val());
        })
        
        $.ajax({
          type:'post',
          dataType:'json',
          data:{idDelivery, inputNoSPJ, inputTglSPJ, inputNoTNKB, proses},
          url:url+'/pengajuan/saveCustomerSerlokNewPola',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            $('#modal-serlok').modal("hide");
            getLokasi();
            updateGroupTujuan()
            var inputAbnormal = document.getElementById("inputAbnormal");
            if (inputAbnormal.checked == true) {
              getUangAbnormalDM();
            }
          },
          error:function(data){
            gagal()
          }
        });

        saveCustomerSerlok.ladda('stop');
        return false;
          
      }, 1000)
    });

      $('#btnCekProgramSerlok').on('click', function(){
        $('#modal-serlok').modal('show')
        // getDepartureTime()
        cekOutGoingSerlok()
      })

      $( "#inputNoTNKB" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: url+"/pengajuan/getDataAutoCompleteKendaraanRental",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      select: function (event, ui) {
        // Set selection
        $('#inputNoTNKB').val(ui.item.label); // display the selected text
        $('#inputMerk').val(ui.item.merk);
        $('#inputType').val(ui.item.type); // save selected id to input
        $('#inputRekananKendaraan').val(ui.item.rekanan);
        return false;
      }
    });

    $('#pilihRekanan').on('change', function(){
      var rekananId = $(this).val();
      var inputRekanan = $('#inputRekanan').val(rekananId);
      $.ajax({
        type:'get',
        data:{rekananId},
        dataType:'json',
        cache:false,
        async:true,
        url:url+'/pengajuan/getKendaraanRekanan',
        success:function(data){
          var html="";
          html+='<option value="">Pilih Kendaraan</option>';
          for (var i = 0; i < data.length; i++) {
            html+='<option value="'+data[i].ID+'">'+data[i].NoTNKB+' - '+data[i].Merk+' '+data[i].Type+'</option>';
          }
          $('#inputKendaraanRekanan').html(html)
        },
        error:function(data){

        }
      });
    })

    $('#inputKendaraanRekanan').on('change', function(){
      var id = $(this).val();
      $.ajax({
        type:'get',
        data:{id},
        dataType:'json',
        url:url+'/pengajuan/getKendaraanRentalById',
        cache:false,
        async:true,
        success:function(data){
          $('#inputMerk').val(data.Merk);
          $('#inputType').val(data.Type);
          $('#inputNoTNKB').val(data.NoTNKB);
          $("select#inputJenisKendaraan option[value='"+data.Kategori+"']").prop("selected","selected");
          $("select#inputJenisKendaraan").trigger("change") 
          $('#inputRekananKendaraan').val(data.NAMA)
        },
        error:function(data){

        }
      })
    })

    $('#inputLokalUangJalan').on('change', function(){
      var inputLokalUangJalan = $('#inputLokalUangJalan').val();
      $('#inputTotalUangJalan').val(inputLokalUangJalan);
    });
    $('#pilihNoVoucher').on('click', function(){
      $('#modal-voucher').modal("show");
      pagingVoucher(1);
    });
    $('#getDataVoucher').on('click','.pilihVoucher', function(){
      var voucher = $(this).attr("voucher");
      $('#inputNoVoucher').val(voucher);
      $('#modal-voucher').modal("hide");
    })
    $('#paging').on('click','.paging', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      pagingVoucher(offset)
      $('#inputOffset').val(offset);
    });
    $('.filter').on('change', function(){
      pagingVoucher(1);
    });
    $('#searchVoucher').submit(function(e){
      e.preventDefault();
      pagingVoucher(1);
    })
    $('#cariVoucher').on('keyup', function(){
      pagingVoucher(1);
    })
    $('#paging').on('click','.btnStep', function(){
      var offset = $(this).attr("offset");
      console.log(offset)
      pagingVoucher(offset)
      $('#inputOffset').val(offset);
    })
    $('#inputDepartureTime').on('change', function(){
      cekOutGoingSerlok();
      $('#modal-serlok').modal('show')
      
    })
    $('#btnGenerateVoucher').on('click', function(){
      var inputNoSPJ = $('#inputNoSPJ').val();
      var inputTempatSPBU = $('#inputTempatSPBU').val();
      $.ajax({
        type:'get',
        dataType:'json',
        data:{inputNoSPJ, inputTempatSPBU},
        url:url+'/pengajuan/generateVoucherBBM',
        cache:false,
        async:true,
        success:function(data){
          $('#inputNoVoucher').val(data.no);
        },
        error:function(data){
          Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error");
        }
      })
    })
    $('#btnPilihPIC').on('click', function(){
      $('#modal-pilihPIC').modal('show');
      getListPIC();
    })
    $('#searchListPIC').on('keyup', function(){
      getListPIC();
    })
    $('#inputTglSPJ').on('change', function(){
      var inputJenisSPJ = $('#inputJenisSPJ').val()
      getNoSPJ(inputJenisSPJ);
    })
    
  })
  function getListPIC() {
    var inputJenisPIC = $('#inputJenisPIC').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputRekanan = $('#inputRekanan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var searchListPIC = $('#searchListPIC').val();
    $.ajax({
      type:'get',
      data:{inputJenisPIC, inputSubjek, inputNoSPJ, inputRekanan, inputJenisSPJ, inputKendaraan, searchListPIC},
      url:url+'/pengajuan/getNIKPic_v2',
      cache:true,
      async:false,
      beforeSend:function(data){
        $('.preloader-no-bg').show();
      },
      success:function(data){
        $('#getListPIC').html(data);
      },
      complete:function(data){
        $('.preloader-no-bg').fadeOut("slow")
      },
      error:function(data){
        Swal.fire("Gagal Mengambil Data!","Hubungi Staff IT!","error");
      }
    })
  }
  function pagingVoucher(offset) {
    var cariVoucher = $('#cariVoucher').val();
    var limit = 20;
    $.ajax({
      type: 'get',
      cache:false,
      async:true,
      data:{cariVoucher, offset, limit},
      url:url+'/pengajuan/pagingDataVoucher',
      success:function(data){
        $('#paging').html(data);
        var endOffset = offset == ''?0:(offset-1)*limit;
        cariDataVoucher(cariVoucher, endOffset, limit);
      },
      error:function(data){
        Swal.fire("gagal mengambil data Voucher","Hubungi Staff IT","error")
      }
    })
  }
  function cariDataVoucher(cariVoucher, offset, limit) {
    
    $.ajax({
      type: 'get',
      dataType:'json',
      cache:false,
      async:true,
      data:{cariVoucher, offset, limit},
      url:url+'/pengajuan/cariDataVoucher',
      success:function(data){
        $('#getDataVoucher').html(data);
      },
      error:function(data){
        Swal.fire("gagal mengambil data Voucher","Hubungi Staff IT","error")
      }
    })
  }
  function getNoSPJ(jenis) {
    var inputTglSPJ = $('#inputTglSPJ').val();
    $.ajax({
      type:'get',
      dataType: 'json',
      data:{jenis, inputTglSPJ},
      url:url+'/pengajuan/getNoSPJ',
      cache: false,
      async: true,
      success: function(data){
        $('#inputNoSPJ').val(data.nodoc);
      },
      error: function(){
        Swal.fire("Oppssss...","Terjadi Error Pada Program! Hubungi Staff IT","error");
      }
    });
  }

  function getQrCode() {
    var no = $('#inputNoSPJ').val();
    $.ajax({
      type: 'post',
      data:{no},
      url: url+'/pengajuan/viewQrCode',
      cache: false,
      async: true,
      success: function(data){
        $('#getQrCode').html(data);
      },
      error: function(data){
        Swal.fire("Tidak Bisa Meng-Generate Qr Code","Refresh Halaman Ini Atau Hubungi Staff IT", "error");
      }
    })
  }

  function kondisiKendaraan() {
    var kendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var jenis = "";
      if (kendaraan == 'Pribadi' || kendaraan =='Gojek/Grab') {
        $('#pilihKendaraan').attr("disabled","disabled");
        $('.inputan').removeAttr("readonly","readonly");
        jenis = 'Minibus';
      }else if(kendaraan == 'Rental'){
        $('#pilihKendaraan').attr("disabled","disabled");
        $('.inputan').attr("readonly","readonly"); 
        jenis = 'Engkel & Double';
      }else if(kendaraan == 'Delivery'){
        if (inputJenisKendaraan == '') {
          $('#pilihKendaraan').attr("disabled","disabled");
          $('.inputan').attr("readonly","readonly");
        }else{
          $('#pilihKendaraan').removeAttr("disabled","disabled");
          $('.inputan').attr("readonly","readonly");  

        }
        jenis = 'Engkel & Double';
      }else if(kendaraan == 'Non Delivery'){
        $('#pilihKendaraan').removeAttr("disabled","disabled");
        $('.inputan').attr("readonly","readonly");  
        jenis = 'Minibus';
      }else if(kendaraan == 'Motor Operasional'){
        $('#pilihKendaraan').removeAttr("disabled","disabled");
        $('.inputan').attr("readonly","readonly");  
        jenis = 'Sepeda Motor';
      }else{
        $('#pilihKendaraan').removeAttr("disabled","disabled");
        $('.inputan').attr("readonly","readonly"); 
        jenis = ""; 
      }

      $("select#inputJenisKendaraan option[value='"+jenis+"']").prop("selected","selected");
      $("select#inputJenisKendaraan").trigger("change") 
      console.log(jenis)
      console.log(kendaraan)
      console.log(inputJenisKendaraan)
  }

  function getCustomerSerlok() {
    // var data = $('#inputKota').val();
    // var inputObjek = $('#inputObjek').val();
    // var end = data.length-1;
    // var query = '';
    // for (var i = 0; i < data.length; i++) {
    //   if (i == 0) {
    //     query += "WHERE ";
    //   }
    //   query +=" nama_kabkota LIKE '%"+data[i]+"%' ";
    //   if (i<end) {
    //     query+= " OR ";
    //   }
    // }
    // $.ajax({
    //   type:'post',
    //   data:{query, inputObjek},
    //   url:url+'/pengajuan/getCustomerSerlok',
    //   cache: false,
    //   async: true,
    //   dataType: 'json',
    //   beforeSend:function(data){
    //     $('.preloader-no-bg').show();
    //   },
    //   success: function(data){
    //     // var html = '';
    //     // html +='<option value="">Pilih Perusahaan</option>';
    //     // for (var i = 0; i < data.length; i++) {
    //     //   html+='<option value="'+data[i].id+'"><b>'+data[i].COMPANY_NAME+'</b> - '+data[i].ALAMAT_LENGKAP_PLANT+'</option>';
    //     // }

    //     $('#inputPerusahaan').html(data);
    //   },
    //   complete:function(data){
    //     $('.preloader-no-bg').fadeOut("slow");
    //   },
    //   error: function(data){
    //     $('#inputPerusahaan').html("");
    //   }
    // });
    console.log("reset");
  }
  function getLokasi() {
      var inputNoSPJ = $('#inputNoSPJ').val();
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      var inputJenisSPJ = $('#inputJenisSPJ').val();
      $.ajax({
        type:'get',
        data:{inputNoSPJ, inputGroupTujuan, inputJenisSPJ},
        url: url+'/pengajuan/getLokasi',
        cache: false,
        async: true,
        success: function(data){
          $('#getLokasi').html(data);
        },
        error: function(data){
          $('#getLokasi').html("");
        }
      });
  }
  function getPIC() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'post',
      data:{inputNoSPJ, inputGroupTujuan},
      dataType: 'json',
      url: url+'/pengajuan/getPengajuanPIC',
      cache: false,
      async: true,
      success: function(data){
        var html='';
        // console.log(data)
        var uangSaku = 0;
        var uangMakan = 0;
        var subcont = '';
        for (var i = 0; i < data.length; i++) {
          uangSaku = data[i].UANG_SAKU;
          uangMakan = data[i].UANG_MAKAN;
          subcont = data[i].SUBCONT == '' ? '' : "<br><b>Subcont: </b>"+data[i].SUBCONT;
          html+="<tr>";
         
          html+="<td>"+data[i].JENIS_PIC+"</td>";
          html+="<td>"+data[i].OBJEK+"</td>";
          html+="<td>"+data[i].NIK+"</td>";
          html+="<td>"+data[i].NAMA+"</td>";
          html+="<td>"+data[i].DEPARTEMEN+""+subcont+"</b></td>";
          html+="<td>"+data[i].SUB_DEPARTEMEN+"</td>";
          html+="<td>"+data[i].JABATAN+"</td>";
          html+="<td>"+formatRupiah(Number(uangSaku).toFixed(0), 'Rp. ') +"</td>";
          html+="<td>"+formatRupiah(Number(uangMakan).toFixed(0), 'Rp. ')+"</td>";
           html+="<td><a href='javascript:;' class='btn text-kps text-danger hapusPIC' data='"+data[i].ID_PIC+"' nama='"+data[i].NAMA+"'><i class='fas fa-trash-alt'></i></a></td>";
          html+="<tr>";

        }

        $('#getPIC').html(html);
      },
      error: function(data){
        $('#getPIC').html('error');
      }
    });
  }

   function getNIK() {
    var inputSubjek = $('#inputSubjek').val();
    var jabatan = $('#inputJenisPIC').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputRekanan = $('#inputRekanan').val();
    if (inputSubjek == '' && jabatan == '') {

    }else{
      $.ajax({
        type:'get',
        dataType:'json',
        data:{inputSubjek, jabatan, inputJenisSPJ, inputNoSPJ, inputTglSPJ, inputKendaraan, inputRekanan},
        url:url+'/pengajuan/getNIKPic',
        cache: false,
        async: true,
        success: function(data){
          var html = '';
          html+= '<option value="">Pilih PIC</option>';
          for (var i = 0; i < data.length; i++) {
            html +='<option value="'+data[i].NIK+'">'+data[i].NIK+' - '+data[i].namapeg+'</option>';
          }
          console.log(html)
          $('#inputPIC').html(html);

        },
        error: function(data){

        }
      });
    }
  }

   function getNIK_D() {
    var inputSubjek = $('#inputSubjekD').val();
    var jabatan = 'Sopir';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputSubjek, jabatan},
      url:url+'/pengajuan/getNIKPic',
      cache: false,
      async: true,
      success: function(data){
        var html = '';
        html+= '<option value="">Pilih Supir</option>';
        for (var i = 0; i < data.length; i++) {
          html +='<option value="'+data[i].nik+'">'+data[i].nik+' - '+data[i].namapeg+'</option>';
        }
        $('#inputNIKD').html(html);

      },
      error: function(data){

      }
    });
  }
  function getNIK_P() {
    var inputSubjek = $('#inputSubjekP').val();
    var jabatan = 'Pendamping';
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputSubjek, jabatan},
      url:url+'/pengajuan/getNIKPic',
      cache: false,
      async: true,
      success: function(data){
        var html = '';
        html+= '<option value="">Pilih Pendamping Supir</option>';
        for (var i = 0; i < data.length; i++) {
          html +='<option value="'+data[i].nik+'">'+data[i].nik+' - '+data[i].namapeg+'</option>';
        }
        $('#inputNIKP').html(html);
      },
      error: function(data){

      }
    });
  }

  function disJenisPIC() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();

    if (inputJenisSPJ == "1") {
      document.querySelectorAll("#inputJenisPIC option").forEach(opt => {
          if (opt.value == "Office" || opt.value == 'Manajemen' || opt.value == 'Subcont') {
              opt.disabled = true;
          }else{
            opt.disabled = false;
          }
      });

      // document.querySelectorAll("#inputKendaraan option").forEach(opt => {
      //     if (opt.value == "Motor Operasional" || opt.value == 'Non Delivery') {
      //         opt.disabled = true;
      //     }else{
      //       opt.disabled = false;
      //     }
      // });  
      $("select#inputKendaraan option[value='Delivery']").prop("selected","selected");
      $("select#inputKendaraan").trigger("change") 

    }else{
      document.querySelectorAll("#inputJenisPIC option").forEach(opt => {
          if (opt.value == "Pendamping") {
              opt.disabled = true;
          }else{
            opt.disabled = false;
          }
      });

      // document.querySelectorAll("#inputKendaraan option").forEach(opt => {
      //     if (opt.value == "Delivery") {
      //         opt.disabled = true;
      //     }else{
      //       opt.disabled = false;
      //     }
      // });

      $("select#inputKendaraan option[value='Non Delivery']").prop("selected","selected");
      $("select#inputKendaraan").trigger("change")  

    }
    
  }

  function hitungUangSaku() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputPIC = $('#inputJenisPIC').val();
    var inputJenisPIC = $('#inputJenisPIC').val();
    var jabatanPIC = '';
    var setJabatanPIC = $('#setJabatanPIC').val();
    var setDepartemenPIC = $('#setDepartemenPIC').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var inputTglBerangkat = $('#inputTglBerangkat').val();
    var inputJamBerangkat = $('#inputJamBerangkat').val();
    var inputTglPulang = $('#inputTglPulang').val();
    var inputJamPulang = $('#inputJamPulang').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var nik = $('#inputPIC').val();
    if (inputPIC == 'Sopir' || inputPIC == 'Pendamping') {
      jabatanPIC = inputPIC;
    }else{
      jabatanPIC = setJabatanPIC;
    }
    var inputGroupTujuan = $('#inputGroupTujuan').val() == '10' ? '4': $('#inputGroupTujuan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputSortir = document.getElementById('inputSortir');
    if (inputSortir.checked == true) {
      if (inputGroupTujuan == '4') {
        $('#inputUangSaku').val("0");  
        $('#showUangSaku').val(formatRupiah(Number('0').toFixed(0), 'Rp. '));
      } else {
        if (setDepartemenPIC.toLowerCase() == 'quality') {
          $('#inputUangSaku').val("40000");
          $('#showUangSaku').val(formatRupiah(Number('40000').toFixed(0), 'Rp. '));
        }else if(setDepartemenPIC.toLowerCase() == 'produksi'){
          $('#inputUangSaku').val("30000");
          $('#showUangSaku').val(formatRupiah(Number('30000').toFixed(0), 'Rp. '));
        }else{
          $('#inputUangSaku').val("0");  
          $('#showUangSaku').val(formatRupiah(Number('0').toFixed(0), 'Rp. '));
        }
      }      
    }else if(inputGroupTujuan == 11){
      $('#inputUangSaku').val("0");  
      $('#showUangSaku').val(formatRupiah(Number('0').toFixed(0), 'Rp. '));
    }else{
        $.ajax({
          type: 'get',
          dataType: 'json',
          url:url+'/pengajuan/hitungUangSaku',
          data:{
            inputJenisSPJ, 
            inputSubjek, 
            jabatanPIC, 
            inputGroupTujuan, 
            inputJenisKendaraan, 
            nik, 
            inputTglSPJ, 
            inputTglBerangkat,
            inputJamBerangkat,
            inputTglPulang,
            inputJamPulang,
            inputKendaraan,
            inputJenisPIC
                },
          cache: false,
          async: true,
          success: function(data){
            if (data.BIAYA == null) {
              $('#inputUangSaku').val("0");
              $('#showUangSaku').val(formatRupiah(Number('0').toFixed(0), 'Rp. '));
            }else{
              $('#inputUangSaku').val(data.BIAYA);  
              $('#showUangSaku').val(formatRupiah(Number(data.BIAYA).toFixed(0), 'Rp. '));

            }

            $('#keteranganUS').html(data.KET);
            
            
          },
          error: function(data){
            $('#inputUangSaku').val("0");
            $('#showUangSaku').val(formatRupiah(Number('0').toFixed(0), 'Rp. '));
          }
        })
    }
    
  }
  function hitungUangMakan() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputPIC = $('#inputPIC').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var inputJenisPIC = $('#inputJenisPIC').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    if (inputGroupTujuan == '11') {
      $('#inputUangMakan').val(10000);
      $('#showUangMakan').val(formatRupiah(Number(10000).toFixed(0), 'Rp. '));
      $('#keteranganUM').html("");
    } else {
      $.ajax({
        type: 'get',
        dataType:'json',
        data:{inputJenisSPJ, inputGroupTujuan, inputPIC, inputTglSPJ, inputJenisPIC, inputSubjek, inputNoSPJ},
        url: url+'/pengajuan/hitungUangMakan',
        cache: false,
        async: true,
        success: function(data){
          $('#inputUangMakan').val(data.BIAYA);
          $('#showUangMakan').val(formatRupiah(Number(data.BIAYA).toFixed(0), 'Rp. '));
          $('#keteranganUM').html(data.KET);
        },
        error: function(data){
          $('#inputUangMakan').val("0");
          $('#showUangMakan').val(formatRupiah(Number("0").toFixed(0), 'Rp. '));
        }
      });  
    }
    
  }

  function pengaturanSortir() {
    var inputPIC = $('#inputPIC').val();
    var setDepartemenPIC = $('#setDepartemenPIC').val();
    var departemen = setDepartemenPIC.toLowerCase();
    if (inputPIC == '') {
      $('#inputSortir').attr("disabled","disabled");
      document.getElementById("inputSortir").checked = false;
    }else{
      if (departemen == 'quality' || departemen == 'produksi') {
        $('#inputSortir').removeAttr("disabled","disabled");
      }else{
        $('#inputSortir').attr("disabled","disabled");
        document.getElementById("inputSortir").checked = false;    
      }
    }
  }

  function savePICMarketing() {
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisPIC = inputGroupTujuan == '3'?'Pendamping':'Sopir';
    var inputSubjek = 'Internal';
    var inputPIC = '<?=$this->session->userdata("NIK")?>';
    var inputUangSaku = 0;
    if (inputGroupTujuan == 4) {
      var inputUangMakan = 20000;  
    }else if(inputGroupTujuan == 10){
      var inputUangMakan = 10000;
    }else if(inputGroupTujuan == 11){
      var inputUangMakan = 0;
    }else{
      var inputUangMakan = 30000;
    }
    
    var inputJenisSPJ = '2';
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputDepartemen = '<?=$this->session->userdata("DEPARTEMEN")?>'
    var inputSubDepartemen = '<?=$this->session->userdata("SUB_DEPARTEMEN")?>';
    var inputJabatan = '<?=$this->session->userdata("JABATAN")?>';
    var inputNamaPIC = '<?=$this->session->userdata("NAMA")?>';
    var inputSubcont = '';
    var inputSortir = 'N';
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{
            inputJenisPIC, 
            inputSubjek, 
            inputPIC, 
            inputUangSaku, 
            inputUangMakan, 
            inputSortir, 
            inputNoSPJ, 
            inputGroupTujuan,
            inputDepartemen,
            inputSubDepartemen,
            inputJabatan,
            inputNamaPIC,
            inputSubcont
          },
      url: url+'/pengajuan/savePIC',
      cache: false,
      async: true,
      success: function(data){
        getTotalUangSakuMakan();
        getPIC()
      },
      error: function(data){
        
      }
    })
  }

  function savePICPengajuan() {
    var inputJenisPIC = $('#inputJenisPIC').val();
    var inputSubjek = $('#inputSubjek').val();
    var inputPIC = $('#inputPIC').val();
    var inputUangSaku = $('#inputUangSaku').val();
    var inputUangMakan = $('#inputUangMakan').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputDepartemen = $('#setDepartemenPIC').val();
    var inputSubDepartemen = $('#setSubDepartemenPIC').val();
    var inputJabatan = $('#setJabatanPIC').val();
    var inputNamaPIC = $('#setNamaPIC').val();
    var sortir = document.getElementById('inputSortir');
    var inputSubcont = $('#inputSubcont').val();
    var inputSortir = 'N';
    if (sortir.checked == true) {
      inputSortir = 'Y'
    }
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{
            inputJenisPIC, 
            inputSubjek, 
            inputPIC, 
            inputUangSaku, 
            inputUangMakan, 
            inputSortir, 
            inputNoSPJ, 
            inputGroupTujuan,
            inputDepartemen,
            inputSubDepartemen,
            inputJabatan,
            inputNamaPIC,
            inputSubcont
          },
      url: url+'/pengajuan/savePIC',
      cache: false,
      async: true,
      success: function(data){
        berhasil();
        $('#modal-pic').modal('hide');
        getPIC();
        getTotalUangSakuMakan();
        // $("select#inputJenisPIC option[value='']").prop("selected","selected");
        // $("select#inputJenisPIC").trigger("change");
        // $("select#inputSubjek option[value='']").prop("selected","selected");
        // $("select#inputSubjek").trigger("change");
        // $("select#inputPIC option[value='']").prop("selected","selected");
        // $("select#inputPIC").trigger("change");
      },
      error: function(data){
        gagal();
      }
    })

  }
  function getTotalUangSakuMakan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'get',
      dataType: 'json',
      data:{inputNoSPJ, inputGroupTujuan},
      url:url+'/pengajuan/getTotalUangSakuMakan',
      cache: false,
      asyncCallback: true,
      success: function(data){
        var uangSaku = Number(data.UANG_SAKU).toFixed(0);
        var uangMakan = Number(data.UANG_MAKAN).toFixed(0);
        $('#tampilTotalUangMakan').html(formatRupiah(uangMakan, 'Rp.'))
        $('#tampilTotalUangSaku').html(formatRupiah(uangSaku, 'Rp.'))
        $('#inputTotalUangSaku').val(uangSaku);
        $('#inputTotalUangMakan').val(uangMakan);
      },
      error: function(data){

      }
    });
  }
  function saveGroupTujuan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    $.ajax({
      type: 'post',
      dataType: 'json',
      data:{inputNoSPJ, inputGroupTujuan},
      url: url+'/pengajuan/saveGroupTujuanSPJ',
      async: true,
      cache: false,
      success: function(data){
        console.log(data)
      },
      error: function(data){
        console.log(data)
      }
    })
  }
  function getUangJalan() {

    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    if (inputKendaraan == 'Non Delivery' && inputJenisKendaraan == 'Minibus' && inputJenisSPJ == '1') {
      $('#tampilTotalUangJalan').html(formatRupiah('0', 'Rp.'));
      $('#inputTotalUangJalan').val('0');
    }else{
       $.ajax({
          type: 'get',
          data: {inputNoSPJ, inputKendaraan, inputJenisKendaraan},
          dataType: 'json',
          url:url+'/pengajuan/getUangJalanSPJ',
          cache: false,
          async: true,
          success: function(data){
            var uangJalan = Number(data.BIAYA).toFixed(0);
            
            $('#tampilTotalUangJalan').html(formatRupiah(uangJalan, 'Rp.'));
            $('#inputTotalUangJalan').val(uangJalan);
            console.log("anjing "+uangJalan)
          },
          error: function(data){

          }
        }); 
    }
   
  }

  function saveSPJ(status) {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputNoInventaris = $('#inputNoInventaris').val();
    var inputMerk = $('#inputMerk').val();
    var inputType = $('#inputType').val();
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputTotalUangSaku = $('#inputTotalUangSaku').val();
    var inputTotalUangMakan = $('#inputTotalUangMakan').val();
    var inputTotalUangJalan = $('#inputTotalUangJalan').val();
    var inputNoVoucher = $('#inputNoVoucher').val();
    var inputBBM = $('#inputBBMManual').val()
    var inputTOL = $('#inputTOL').val();
    var inputMediaUangSaku = $('#inputMediaUangSaku').val();
    var inputMediaUangMakan = $('#inputMediaUangMakan').val();
    var inputMediaUangJalan = $('#inputMediaUangJalan').val();
    var inputMediaBBM = $('#inputMediaBBM').val();
    var inputMediaTOL = $('#inputMediaTol').val();
    var inputTglBerangkat = $('#inputTglBerangkat').val();
    var inputJamBerangkat = $('#inputJamBerangkat').val();
    var inputTglPulang = $('#inputTglPulang').val();
    var inputJamPulang = $('#inputJamPulang').val();
    var inputAneh = 'Aneh';
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var abnormal = document.getElementById("inputAbnormal");
    var inputTambahanUangJalan = $('#inputTambahanUangJalan').val();
    var inputAbnormal = abnormal.checked == true ? 'Y' : 'N';
    var inputBiayaKendaraan = $('#inputBiayaKendaraan').val();
    var inputMediaKendaraan = $('#inputMediaKendaraan').val();
    var inputKeteranganTujuan = $('#inputKeteranganTujuan').val();
    var inputTempatKeberangkatan = $('#inputTempatKeberangkatan').val();
    var inputTempatSPBU = $('#inputTempatSPBU').val();
    console.log(parseInt(inputTambahanUangJalan))
    if (inputNoTNKB == '') {
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","No TNKB Kendaraan Masing Kosong!", "warning")
    }else if(inputGroupTujuan == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Anda Belum Memilih Group Tujuan!", "warning")
    }else if(inputTglBerangkat == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Tanggal berangkat!", "warning")
    }else if(inputJamBerangkat == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Jam Berangkat!", "warning")
    }else if(inputTglPulang == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Tanggal Pulang!", "warning")
    }else if(inputJamPulang == ''){
      Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Tentukan Rencana Jam Pulan", "warning")
    }else if(inputNoVoucher == '' && inputMediaBBM == 'Voucher'){
      Swal.fire("Pilih Terlebih Dahulu No Voucher!","Pilihan No Voucher Ada di Proses Biaya","warning")
    }else if(parseInt(inputTambahanUangJalan)>15000 ){
      Swal.fire("Tambahan Uang Jalan Lokal Tidak Boleh Lebih Dari Rp. 15,000","Kembali Ke Pengisian Biaya","warning")
    }else{

      $.ajax({
        type:'post',
        data:{
            inputAneh,
            inputMediaTOL,
            inputNoSPJ,
            inputTglSPJ,
            inputJenisKendaraan,
            inputKendaraan,
            inputNoInventaris,
            inputMerk,
            inputType,
            inputNoTNKB,
            inputGroupTujuan,
            inputTotalUangSaku,
            inputTotalUangMakan,
            inputTotalUangJalan,
            inputBBM,
            inputTOL,
            inputMediaUangSaku,
            inputMediaUangMakan,
            inputMediaUangJalan,
            inputMediaBBM,
            inputTglBerangkat,
            inputJamBerangkat,
            inputTglPulang,
            inputJamPulang,
            inputNoVoucher,
            inputJenisSPJ,
            inputAbnormal,
            status,
            inputTambahanUangJalan,
            inputBiayaKendaraan,
            inputMediaKendaraan,
            inputTempatKeberangkatan,
            inputKeteranganTujuan,
            inputTempatSPBU
          },
        dataType: 'json',
        url:url+'/pengajuan/saveSPJ',
        async: true,
        cache: false,
        beforeSend: function(data){
          $('.preloader-no-bg').show();
          $('#btnSaveSPJ').attr("disabled","disabled");
        },
        success: function(data){
          berhasil();
          if (inputJenisSPJ == '2') {
            window.location.href = '<?=base_url()?>pengajuan/draft';
          } else {
            window.location.href = '<?=base_url()?>monitoring/spj';  
          }
          
        },
        complete: function(data){
          $('.preloader-no-bg').fadeOut('slow');
          $('#btnSaveSPJ').removeAttr("disabled","disabled");
        },
        error: function(darta){
          gagal();
        }
      })
    }

  }

  function cekAdaDriver(status) {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputKendaraan = $('#inputKendaraan').val();

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
          cekSaldo(status);
        } else {
          Swal.fire("Tidak Terdapat Driver Pada SPJ Ini!","PIC yang di daftarkan Tidak ada yang memiliki otoritas Driver!","warning")
        }
        
      },
      error: function(data){

      }
    })
  }
  function cekSaldo(status) {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputMediaBBM = $('#inputMediaBBM').val();
    var inputMediaTOL = $('#inputMediaTol').val();
    var inputTotalUangSaku = parseInt($('#inputTotalUangSaku').val());
    var inputTotalUangMakan = parseInt($('#inputTotalUangMakan').val());
    var inputTotalUangJalan = parseInt($('#inputTotalUangJalan').val());
    var inputBBM = parseInt($('#inputBBMManual').val());
    var inputTOL = parseInt($('#inputTOL').val());
    var bbmSPJ = inputMediaBBM == 'Kasbon' ? inputBBM : 0;
    var tolSPJ = inputMediaTOL == 'Kasbon' ? inputTOL:0;

    var kasbonSPJ = inputTotalUangSaku + inputTotalUangMakan + inputTotalUangJalan + bbmSPJ + tolSPJ;

    $.ajax({
      type:'get',
      data:{inputJenisSPJ},
      dataType:'json',
      cache: false,
      async: true,
      url:url+'/pengajuan/cekSaldoSubKas',
      success: function(data){
        // getNoVoucher();
        kondisiBBM()
        if (inputJenisSPJ == '3') {
          saveSPJ(status);
        }else{
          if (kasbonSPJ >= data.saldoSPJ) {
            Swal.fire("Kasbon SPJ Melebihi Jumlah Saldo Sub Kas!","Hubungi PIC Terkait","warning")
          }else{
            saveSPJ(status);
          }  
        }
        
      },
      error: function(data){

      }
    })
  }
  function cekManajemen() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'get',
      dataType: 'json',
      data:{inputNoSPJ},
      url:url+'/pengajuan/cekManajemen',
      cache: false,
      async: true,
      success: function(data){
        saveSPJ();
      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program!","Hubungi Segera Staff IT!","error");
      }
    });
  }

  function saveRencanaBerangkat() {
    var inputTglBerangkat = $('#inputTglBerangkat').val();
    var inputJamBerangkat = $('#inputJamBerangkat').val();
    var inputTglPulang = $('#inputTglPulang').val();
    var inputJamPulang = $('#inputJamPulang').val();
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'post',
      dataType:'json',
      data:{inputNoSPJ, inputTglBerangkat, inputJamBerangkat, inputTglPulang, inputJamPulang},
      url:url+'/pengajuan/saveRencanaBerangkat',
      cache: false,
      async: true,
      success: function(){
        stepper.next();
      },
      error: function(){
        Swal.fire("Terjadi Error Pada Program Atau Jaringan","Hubungi Staff IT!","error");
      }
    });
  }

  function saveKendaraan() {
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var noSPJ = $('#inputNoSPJ').val();
    var inv = $('#inputNoInventaris').val();
    var merk = $('#inputMerk').val();
    var tipe = $('#inputType').val();
    var tnkb= $('#inputNoTNKB').val();
    var kendaraan = $('#inputKendaraan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputRekananKendaraan = $('#inputRekananKendaraan').val();
    var inputRekanan = $('#inputRekanan').val();
    $.ajax({
      type: 'post',
      data: {inv, inputJenisKendaraan, noSPJ, tnkb, merk, tipe, kendaraan, inputRekananKendaraan, inputRekanan, inputJenisSPJ},
      dataType: 'json',
      url: url+'/pengajuan/saveKendaraanSPJ',
      cache: false,
      async: true,
      success: function(data){
        console.log(data);
        stepper.next()
        if (inputJenisSPJ == 1) {
          cekOutGoingSerlok();  
          $('#modal-serlok').modal('show')
          getDepartureTime()
        }else{
          setMediaMarketing(data.reimburse);
        }
        
      },
      error: function(data){
        console.log("error");
      }
    })

  }
  function hapusPICDriverCzMarketing() {
    var noSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'post',
      dataType:'json',
      data:{noSPJ},
      url:url+'/pengajuan/hapusPICDriverCzMarketing',
      cache: false,
      async: true,
      success: function(data){
        savePICPengajuan();
      },
      error: function(data){
        gagal()
      }
    })
  }

  function updateGroupTujuan(argument) {
    var inputNoSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'post',
      dataType: 'json',
      data:{inputNoSPJ},
      url:url+'/pengajuan/updateGroupTujuan',
      cache: false,
      async: true,
      success: function(data){
        getGroupSPJ();
        
      },
      error: function(data){
        Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error")
      }
    })
  }

  function getGroupSPJ() {
    var noSPJ = $('#inputNoSPJ').val();
    $.ajax({
      type:'get',
      data:{noSPJ},
      dataType: 'json',
      url: url+'/pengajuan/getGroupSPJ',
      cache: false,
      async: true,
      success: function(data){
        $('#inputGroupTujuan').val(data.GROUP_ID);
        
      },
      error: function(data){
        Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error")
      },
    });
  }

  function cekPengajuanPIC() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var subDepartemen = '<?=$this->session->userdata("marketing")?>';
    console.log("WOII LAHH "+subDepartemen)
    $.ajax({
      type:'get',
      dataType:'json',
      data:{inputNoSPJ},
      url:url+'/pengajuan/cekPengajuanPIC',
      cache: false,
      async: true,
      success: function(data){
        if (parseInt(data)>0) {
          updateOtomatisUangSPJ();
        }else{
          if (subDepartemen == 'Marketing') {
            savePICMarketing();
          } else {
            getPIC()
            getTotalUangSakuMakan()
          }
          
          stepper.next()
          
        }

      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program","Mohon Hubungi Staff IT","error")
      }
    });
  }
  function cekTujuanAbnormal() {
    var inputNoSPJ = $('#inputNoSPJ').val()
    var inputGroupTujuan = $('#inputGroupTujuan').val()
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var biayaTambahanUangJalan = $('#biayaTambahanUangJalan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{inputNoSPJ},
      dataType:'json',
      cache:false,
      async:true,
      url:url+'/pengajuan/cekTujuanAbnormal',
      success:function(data){
        if(inputKendaraan == 'Non Delivery' && inputJenisKendaraan == 'Minibus' && inputJenisSPJ == '1'){
          settingManualJalan()
          $('#inputTotalUangJalan').val("0")
          $('#tampilTotalUangJalan').html("0")
          $('#inputManualUangJalan').val("0")
          $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
          console.log("a")
        }
        else if (inputGroupTujuan == '4' || inputGroupTujuan == '10' || inputGroupTujuan == '11') {
          settingManualJalan()
          console.log("b")
        }else if(data.abnormal == true && inputJenisSPJ == '1') {
          $('#inputAbnormal').attr("checked","checked");
          $('#inputManualUangJalan').attr("readonly","readonly");
          getUangAbnormalDM()
          console.log("c")
          $('#tampilTotalUangJalan').removeClass("d-none");
          $('.lokalUangJalan').addClass("d-none");
          $('#manualUangJalan').addClass("d-none");
          $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
          $('.tambahUangJalanAbnormal').removeClass("d-none")
        }else{
          console.log("d")
          $('#inputAbnormal').removeAttr("checked","checked");
          getUangJalan()
        }
      },
      error:function(data){

      }
    })
  }

  function updateOtomatisUangSPJ() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    $.ajax({
      type:'post',
      data:{inputNoSPJ, inputGroupTujuan, inputJenisSPJ, inputJenisKendaraan},
      dataType:'json',
      url:url+'/pengajuan/updateOtomatisUangSPJ',
      success: function(data){
        berhasil();
        stepper.next()
        getPIC()
        getTotalUangSakuMakan()
        getUangJalan();
      },
      error:function(data){
        Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error")
      }
    })
  }

  function kondisiBBM() {
    var inputMediaBBM = $('#inputMediaBBM').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    if (inputMediaBBM == 'Voucher') {
      $('#voucherBBM').removeClass("d-none")
      $('#manualBBM').addClass("d-none");
      // getNoVoucher()
      $('#inputBBMManual').val("0");
    }else{
      $('#voucherBBM').addClass("d-none");
      $('#manualBBM').removeClass("d-none");
      var anjing = '<?=$this->uri->segment("2")?>';
      if (anjing == 'form_edit') {
        
      }else{
        $('#inputNoVoucher').val("");  
      }
      
      if (inputMediaBBM == 'Kasbon') {
        console.log(inputJenisKendaraan)
        if (inputJenisKendaraan == 'Sepeda Motor') {
          $('#inputBBMManual').attr("readonly","readonly");
          $('#inputBBMManual').val("20000")
        } else {
          $('#inputBBMManual').removeAttr("readonly","readonly");  
          // $('#inputBBMManual').val("0")
          // console.log("bangsat ah didieu paingan")
        }
        
      }else{
        $('#inputBBMManual').attr("readonly","readonly");
        $('#inputBBMManual').val("0");
      }
    }
  }
  function getNoVoucher() {
    $.ajax({
      url:url+'/Data_Master/getNoVoucher',
      type:'get',
      dataType: 'json',
      async: true,
      cache: false,
      success: function(data){
        $('#inputNoVoucher').val(data.NO_VOUCHER);
      },
      error: function(data){
        
      }
    })
  }

  function cekOutGoingSerlok() {
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var data = $('#inputDepartureTime').val();
      // if (data.length >0) {
      //   var whereDeparture = " AND b.departure_time  IN ("
      //   var jml = data.length-1;
      //   for (var i = 0; i < data.length; i++) {
      //     whereDeparture+="'"+data[i]+"'";
      //     if (i<jml) {
      //       whereDeparture+=",";
      //     }else{
      //       whereDeparture+=")";
      //     }
      //   }
      // }else{
        
      // }
      var whereDeparture = '';
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
        var check = 'checked';
        if (jmlData>0) {
          for (var i = 0; i < data.length; i++) {
            html+='<tr>';
            html+='<td>'+data[i].COMPANY_NAME+'</td>';
            html+='<td>'+data[i].PLANT1_CITY+'</td>';
            html+='<td><div class="icheck-orange icheck-kps d-inline"><input type="checkbox" id="'+data[i].ID+'" name="pilihCustomer" value="'+data[i].ID+'" '+check+'><label for="'+data[i].ID+'"></label></div></td>';
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

  function kondisiTombolLokasi() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    console.log(inputJenisSPJ)
    if (inputJenisSPJ == '1') {
      // $('#inputKota').attr("disabled","disabled");
      // // $('#btnCekProgramSerlok').attr("disabled","disabled");
      $('#btnCekProgramSerlok').removeAttr("disabled","disabled");
      // $('#tambahLokasi').attr("disabled","disabled");
    }else if(inputJenisSPJ == '2'){
      $('#inputKota').removeAttr("disabled","disabled");
      $('#btnCekProgramSerlok').attr("disabled","disabled");
      // $('#btnCekProgramSerlok').removeAttr("disabled","disabled");
      $('#tambahLokasi').removeAttr("disabled","disabled");
    } else {
      $('#inputKota').removeAttr("disabled","disabled");
      // $('#btnCekProgramSerlok').attr("disabled","disabled");
      $('#btnCekProgramSerlok').removeAttr("disabled","disabled");
      $('#tambahLokasi').removeAttr("disabled","disabled"); 
    }
    

    
  }



  function kondisiJenisSPJKendaraan() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    if (inputJenisSPJ == '') {

    }else{

    }
  }

  function getSaldoPerJenis(jenis) {
    $.ajax({
      type:'get',
      data:{jenis},
      url:url+'/pengajuan/getSaldoPerJenis',
      cache: false,
      async: true,
      success: function(data){
        if (jenis =='') {
          $('#getSaldo').html(""); 
        }else{
          $('#getSaldo').html(data);
        }
        
        console.log($('#inputSaldoHidden').val());
      },
      error: function(data){

      }
    })
  }
  function searchKendaraan() {
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    var searchKendaraan = $('#searchKendaraan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    $.ajax({
      type:'get',
      data:{inputKendaraan, inputJenisKendaraan, inputTglSPJ, searchKendaraan, inputJenisSPJ},
      url:url+'/Pengajuan/pilihKendaraan',
      cache: false,
      async: true,
      success: function(data){
        $('#getKendaraan').html(data);

      },
      error: function(data){
        Swal.fire("Gagal Mengambil Data!","Hubungi Staff IT","error");
      }
    });
  }
  function disVoucher() {
    // var inputJenisSPJ = $('#inputJenisSPJ').val();
    // if (inputJenisSPJ == 2) {
    //   $('#cekVoucher').removeAttr("disabled","disabled")
    // }else{
    //   $('#cekVoucher').attr("disabled","disabled");
    // }
  }
  function cekVoucher() {
    // var inputSortir = document.getElementById('cekVoucher');
    //   if (inputSortir.checked == true) {
    //     $('#voucherBBM').addClass("d-none");
    //     $('#manualBBM').removeClass("d-none");
    //     $('#inputMediaBBM').val("Reimburse");
    //   }else{
    //     $('#voucherBBM').removeClass("d-none");
    //     $('#manualBBM').addClass("d-none");
    //     $('#inputMediaBBM').val("Voucher");
    //   }
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

  function settingManualJalan() {
    var inputAbnormal = document.getElementById("inputAbnormal");
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var biayaTambahanUangJalan = $('#biayaTambahanUangJalan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    if (inputJenisSPJ == '1') {
      if (inputAbnormal.checked == true) {
        $('#tampilTotalUangJalan').addClass("d-none");
        $('.lokalUangJalan').addClass("d-none");
        $('#manualUangJalan').removeClass("d-none");
        $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
        $('.tambahUangJalanAbnormal').removeClass("d-none")
      }else if(inputAbnormal.checked == false && inputGroupTujuan == '4' || inputGroupTujuan == '10' && inputAbnormal.checked == false){
        $('#tampilTotalUangJalan').addClass("d-none");
        $('.lokalUangJalan').removeClass("d-none");
        $('#manualUangJalan').addClass("d-none");
        $('.tambahUangJalanAbnormal').removeClass("d-none")
        $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
      }else if(inputAbnormal.checked == false && inputGroupTujuan == '11'){
        $('#tampilTotalUangJalan').addClass("d-none");
        $('.lokalUangJalan').removeClass("d-none");
        $('#manualUangJalan').addClass("d-none");
        $('.tambahUangJalanAbnormal').removeClass("d-none")
        $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
      }else{
        $('#tampilTotalUangJalan').removeClass("d-none");
        $('.lokalUangJalan').addClass("d-none");
        $('#manualUangJalan').addClass("d-none");
        $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
        $('.tambahUangJalanAbnormal').addClass("d-none")
      }  
    }else{
      $('#tampilTotalUangJalan').removeClass("d-none");
      $('.lokalUangJalan').addClass("d-none");
      $('#manualUangJalan').addClass("d-none");
      $('#inputTambahanUangJalan').val('0');
      $('.tambahUangJalanAbnormal').addClass("d-none")
      console.log("didie bre")
    }
    
    console.log(biayaTambahanUangJalan)

  }
  function settingUangJalanLokal() {
    var inputAbnormal = document.getElementById("inputAbnormal");
    var inputGroupTujuan = $('#inputGroupTujuan').val();

    if (inputAbnormal.checked == false && inputGroupTujuan == '4') {
      $('#tampilTotalUangJalan').addClass("d-none");
      $('.lokalUangJalan').removeClass("d-none");
      $('#manualUangJalan').addClass("d-none");
    }else if (inputAbnormal.checked == true) {
       $('#tampilTotalUangJalan').addClass("d-none");
      $('.lokalUangJalan').addClass("d-none");
      $('#manualUangJalan').removeClass("d-none");
    }else{
      $('#tampilTotalUangJalan').removeClass("d-none");
      $('.lokalUangJalan').addClass("d-none");
      $('#manualUangJalan').addClass("d-none");
    }
  }

  function getListRekanan() {
    $.ajax({
      type:'get',
      dataType:'json',
      url:url+'/pengajuan/getListRekanan',
      cache:false,
      async:true,
      success:function(data){
        var html ='';
        html+='<option value="">Pilih Rekanan</option>';
        for (var i = 0; i < data.length; i++) {
          html+='<option value="'+data[i].ID+'">'+data[i].NAMA+'</option>';
        }
        $('#pilihRekanan').html(html);
      },
      error:function(data){

      }
    })
  }
  function getUangAbnormalDM() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    var biayaTambahanUangJalan = $('#biayaTambahanUangJalan').val();
    $.ajax({
      type:'get',
      data:{inputNoSPJ},
      dataType:'json',
      url:url+'/pengajuan/getUangAbnormalDM',
      cache:false,
      async:true,
      success:function(data){
        $('#inputManualUangJalan').val(data)
        $('#inputTotalUangJalan').val(data);
        $('#tampilTotalUangJalan').html(formatRupiah(Number(data).toFixed(0), 'Rp. '));
        $('#inputTambahanUangJalan').val(biayaTambahanUangJalan);
      },
      error:function(data){
        $('#inputManualUangJalan').val(0)
      }
    })
  }
  function getPilihanUangJalan() {
    var inputNoSPJ = $('#inputNoSPJ').val();
    // $.ajax({
    //   type:'get',
    //   dataType:'json',
    //   cache:false,
    //   async:true,
    //   url:url+'/pengajuan/getPilihanUangJalan',
    //   success:function(data){

    //   },
    //   error:function(data){

    //   }
    // })
  }
  function getNoVoucherAuto_V1() {
    $.ajax({
      type:'get',
      dataType:'json',
      url:url+'/pengajuan/getNoVoucherAuto_V1',
      success:function(data){
        $('#inputNoVoucher').html(data);
      },
      error:function(data){
        Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error")
      }
    })
  }
  function pilihKota() {
    var id = $('#inputPilihKota').val();
    $.ajax({
      type:'get',
      data:{id},
      dataType:'json',
      url:url+'/pengajuan/findGroupTujuanByIdKota',
      cache:false,
      async:true,
      success:function(data){
        $("select#inputGroupPerusahaan option[value='"+data+"']").prop("selected","selected");
        $("select#inputGroupPerusahaan").trigger("change")
        document.querySelectorAll("#inputGroupPerusahaan option").forEach(opt => {
          if (opt.value != data) {
              opt.disabled = true;
          }else{
            opt.disabled = false;
          }
        });
      },
      error:function(data){
        Swal.fire("Gagal Mengambil Data","Hubungi Staff IT","error")
      }
    })
  }
  function configGroupTujuanByObjek() {
    var objek = $('#inputObjek').val();
    if (objek == 'Rekanan') {
      $("select#inputGroupPerusahaan2 option[value='10']").prop("selected","selected");
      $("select#inputGroupPerusahaan2").trigger("change")
      document.querySelectorAll("#inputGroupPerusahaan2 option").forEach(opt => {
        if (opt.value == '10' || opt.value=='11') {
            opt.disabled = false;
        }else{
          opt.disabled = true;
        }
      });
      console.log("naha")
    }else{
      $("select#inputGroupPerusahaan option[value='']").prop("selected","selected");
      $("select#inputGroupPerusahaan").trigger("change")
      document.querySelectorAll("#inputGroupPerusahaan option").forEach(opt => {
        opt.disabled = false;
      });
      console.log("shih")
    }
  }
  function setMediaMarketing(reimburse) {
    if (reimburse == 'Y') {
      $("select#inputMediaBBM option[value='Reimburse']").prop("selected","selected");
      $("select#inputMediaBBM").trigger("change")
      document.querySelectorAll("#inputMediaBBM option").forEach(opt => {
        if (opt.value == 'Kasbon') {
            opt.disabled = true;
        }else{
          opt.disabled = false;
        }
      });

      $("select#inputMediaTol option[value='Reimburse']").prop("selected","selected");
      $("select#inputMediaTol").trigger("change")
      document.querySelectorAll("#inputMediaTol option").forEach(opt => {
        if (opt.value == 'Kasbon' || opt.value == 'Voucher') {
            opt.disabled = true;
        }else{
          opt.disabled = false;
        }
      });
      console.log("YESSS SUREE")
    } else {
      var inputMediaBBM = $('#inputMediaBBM').val();
      $("select#inputMediaBBM option[value='"+inputMediaBBM+"']").prop("selected","selected");
      $("select#inputMediaBBM").trigger("change")
      document.querySelectorAll("#inputMediaBBM option").forEach(opt => {
        opt.disabled = false;
      });
      document.querySelectorAll("#inputMediaTol option").forEach(opt => {
        if (opt.value == 'Kasbon' || opt.value == 'Reimburse') {
            opt.disabled = false;
        }else{
          opt.disabled = true;
        }
      });
      console.log("NO SUREE")
    }
  }
  function saveAutoBiayaKendaraan() {
    var inputBiayaKendaraan = parseInt($('#inputBiayaKendaraan').val());
    var inputDBBiayaKendaraan = parseInt($('#inputDBBiayaKendaraan').val());
    var inputNoSPJ = $('#inputNoSPJ').val();
    var inputKendaraan = $('#inputKendaraan').val();
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    $.ajax({
      type:'post',
      data:{inputBiayaKendaraan, inputDBBiayaKendaraan, inputNoSPJ, inputKendaraan},
      cache:false,
      async:true,
      url:url+'/pengajuan/saveAutoBiayaKendaraan',
      success:function(data){
        console.log('Berhasil Menyimpan Auto Biaya Kendaraan');
      },
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
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  });
</script>
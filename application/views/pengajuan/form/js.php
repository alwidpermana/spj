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
      if (inputGroupTujuan == '') {
        Swal.fire("Pilih Terlebih dahulu Lokasi Tujuan","","warning")
      }else{
        cekPengajuanPIC();
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
      }else{
        $('#tampilTotalUangJalan').removeClass("d-none");
        $('#manualUangJalan').addClass("d-none");
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
        if (inputJenisSPJ == '1') {
          jenisSPJ = 'Delivery';
        }else if (inputJenisSPJ == '2'){
          jenisSPJ = 'Non Delivery';
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
              data:{inputJenisSPJ, inputNoSPJ, inputTglSPJ, inputJenisOther},
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
                // $('#btnSaveSPJ').removeClass("d-none");
                $('#inputTglSPJ').attr("readonly","readonly")
                var jenisData = '<?=$this->uri->segment("2")?>';
                if (jenisData != 'form_temporary') {
                  $('#inputTglBerangkat').val(inputTglSPJ);
                  $('#inputTglPulang').val(inputTglSPJ);  
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
      }else{
        $('#inputRekananKendaraan').val("")
        $('.rekanan').addClass("d-none")
      }
      if (kendaraan == 'Rental' || kendaraan == 'Pribadi') {
        $('#inputNoInventaris').val("-")
        $('#inputMerk').val("");
        $('#inputType').val("");
        $('#inputNoTNKB').val("");
        
      }else{
        $('#inputNoInventaris').val("")
        
      }
    });
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
      if (objek == 'Lainnya') {
        $('.objekLainnya').removeClass("d-none")
        $('.objekNormal').addClass("d-none");
        $('#btnCekProgramSerlok').attr("disabled","disabled")
        $('#inputKota').attr("disabled","disabled")
      } else {
        $('.objekLainnya').addClass("d-none");
        $('.objekNormal').removeClass("d-none");
      }
    });
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

    $('#inputPerusahaan').on('change', function(){
      var inputPerusahaan = $('#inputPerusahaan').val();
      $.ajax({
        type:'get',
        data: {inputPerusahaan},
        dataType:'json',
        async: true,
        cache: false,
        url:url+'/pengajuan/findGroupTujuan',
        success: function(data){
          if (parseInt(data)>0) {
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
            Swal.fire("Sistem Tidak Bisa Membaca Group Tujuan Perusahaan Tersebut","Mohon Untuk Pilih Group Tujuan Manual","info")
          }
        },
        error: function(data){
          Swal.fire("Terdapat Error Pada Program","Mohon Hubungi Staff IT","error");
        }
      });
    });


    var saveLokasi = $('.saveLokasi').ladda();
      saveLokasi.click(function () {
      // Start loading
      saveLokasi.ladda('start');
      // Timeout example
      // Do something in backend and then stop ladda
      setTimeout(function () {
        var objek = $('#inputObjek').val();
        var objekLainnya = $('#inputObjekLainnya').val();
        var inputPerusahaan = objek == 'Lainnya'?'-':$('#inputPerusahaan').val();
        var inputGroupTujuan = objek == 'Lainnya'?'0':$('#inputGroupPerusahaan').val();
        var inputObjek = objek == 'Lainnya'?objekLainnya:objek;
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputKotaKabupaten = $('#inputKotaKabupaten').val();
        var inputNamaTempat = $('#inputNamaTempat').val();
        var inputAlamat = $('#inputAlamat').val();
        if (objek == '' || inputPerusahaan == '' || inputGroupTujuan == '') {
          Swal.fire("Lengkapi Dulu Datanya!","","warning");
        }else{
          $.ajax({
            type:'post',
            dataType:'json',
            data:{inputPerusahaan, inputGroupTujuan, inputObjek, inputNoSPJ, objek, inputKotaKabupaten, inputNamaTempat, inputAlamat},
            url:url+'/pengajuan/saveLokasiTujuan',
            cache: false,
            async: true,
            success: function(data){
              $('#modal-lokasi').modal('hide');
              berhasil();
              getLokasi();
              getUangJalan();
              updateGroupTujuan();
            },
            error: function(data){
              gagal()
            },
          });
        }
        saveLokasi.ladda('stop');
        return false;
          
      }, 1000)
    });

    $('.pilihPIC').on('change', function(){
      getNIK();
      hitungUangSaku();
      hitungUangMakan();
    })
    $('#inputJenisPIC').on('change', function(){
      var jenis = $(this).val();
      if (jenis == 'Office') {
        $("select#inputSubjek option[value='Internal']").prop("selected","selected");
        $("select#inputSubjek").trigger("change")  
      }
    });

    $('#btnTambahPIC').on('click', function(){
      var inputGroupTujuan = $('#inputGroupTujuan').val();
      hitungUangSaku();
      hitungUangMakan();
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
        if (inputJenisPIC == '' || inputSubjek == '' || inputPIC == '') {
          Swal.fire("Lengkapi Datanya Terlebih Dahulu!","Pastikan Pilihan PIC dan Subjek nya terisi","warning")
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
              if (parseInt(data.JML_DRIVER) >0 && inputJenisPIC == 'Sopir') {
                Swal.fire("Driver Sudah di Daftarkan!","Dalam 1 SPJ Tidak Boleh Lebih dari 1 Driver","warning");
              }else if(parseInt(data.JML_PIC) >0){
                Swal.fire("PIC Yang Dipilih Sudah Terdaftar Pada SPJ Ini!","","warning")
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

            }
          });
          
        }
        
        return false;
          
      }, 1000)
    });

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
      $.ajax({
        type:'post',
        data:{id},
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
      $.ajax({
        type:'post',
        data:{id},
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
      getNoVoucher()
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
        console.log("kontol")
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
        var inputNoSPJ = $('#inputNoSPJ').val();
        var inputTglSPJ = $('#inputTglSPJ').val();
        var inputNoTNKB = $('#inputNoTNKB').val();

        $.ajax({
          type:'post',
          dataType:'json',
          data:{inputNoSPJ, inputTglSPJ, inputNoTNKB},
          url:url+'/pengajuan/saveCustomerSerlok',
          cache: false,
          async: true,
          success: function(data){
            berhasil();
            $('#modal-serlok').modal("hide");
            getLokasi();
            updateGroupTujuan()
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


  })
  function getNoSPJ(jenis) {
    
    $.ajax({
      type:'get',
      dataType: 'json',
      data:{jenis},
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
      if (kendaraan == 'Rental' || kendaraan == 'Pribadi') {
        $('#pilihKendaraan').attr("disabled","disabled");
        $('.inputan').removeAttr("readonly","readonly");
        
      }else{
        $('#pilihKendaraan').removeAttr("disabled","disabled");
        $('.inputan').attr("readonly","readonly");
      }
  }

  function getCustomerSerlok() {
    var data = $('#inputKota').val();
    var end = data.length-1;
    var query = '';
    for (var i = 0; i < data.length; i++) {
      if (i == 0) {
        query += "WHERE ";
      }
      query +=" nama_kabkota LIKE '%"+data[i]+"%' ";
      if (i<end) {
        query+= " OR ";
      }
    }
    $.ajax({
      type:'post',
      data:{query},
      url:url+'/pengajuan/getCustomerSerlok',
      cache: false,
      async: true,
      dataType: 'json',
      success: function(data){
        var html = '';
        html +='<option value="">Pilih Perusahaan</option>';
        for (var i = 0; i < data.length; i++) {
          html+='<option value="'+data[i].id+'"><b>'+data[i].COMPANY_NAME+'</b> - '+data[i].ALAMAT_LENGKAP_PLANT+'</option>';
        }

        $('#inputPerusahaan').html(html);
      },
      error: function(data){
        $('#inputPerusahaan').html("");
      }
    });
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
        for (var i = 0; i < data.length; i++) {
          uangSaku = data[i].UANG_SAKU;
          uangMakan = data[i].UANG_MAKAN;
          html+="<tr>";
         
          html+="<td>"+data[i].JENIS_PIC+"</td>";
          html+="<td>"+data[i].OBJEK+"</td>";
          html+="<td>"+data[i].NIK+"</td>";
          html+="<td>"+data[i].NAMA+"</td>";
          html+="<td>"+data[i].DEPARTEMEN+"</td>";
          html+="<td>"+data[i].SUB_DEPARTEMEN+"</td>";
          html+="<td>"+data[i].JABATAN+"</td>";
          html+="<td>"+formatRupiah(Number(uangSaku).toFixed(0), 'Rp. ') +"</td>";
          html+="<td>"+formatRupiah(Number(uangMakan).toFixed(0), 'Rp. ')+"</td>";
           html+="<td><a href='javascript:;' class='btn text-kps text-danger hapusPIC' data='"+data[i].ID_PIC+"'><i class='fas fa-trash-alt'></i></a></td>";
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
    if (inputSubjek == '' && jabatan == '') {

    }else{
      $.ajax({
        type:'get',
        dataType:'json',
        data:{inputSubjek, jabatan, inputJenisSPJ, inputNoSPJ, inputTglSPJ},
        url:url+'/pengajuan/getNIKPic',
        cache: false,
        async: true,
        success: function(data){
          var html = '';
          html+= '<option value="">Pilih PIC</option>';
          for (var i = 0; i < data.length; i++) {
            html +='<option value="'+data[i].NIK+'">'+data[i].NIK+' - '+data[i].namapeg+'</option>';
          }
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
          if (opt.value == "Office" || opt.value == 'Manajemen') {
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
    var inputGroupTujuan = $('#inputGroupTujuan').val();
    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
    var inputSortir = document.getElementById('inputSortir');
    if (inputSortir.checked == true) {
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
            inputKendaraan 
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
    $.ajax({
      type: 'get',
      dataType:'json',
      data:{inputJenisSPJ, inputGroupTujuan, inputPIC, inputTglSPJ},
      url: url+'/pengajuan/hitungUangMakan',
      cache: false,
      async: true,
      success: function(data){
        $('#inputUangMakan').val(data.BIAYA);
        $('#showUangMakan').val(formatRupiah(Number(data.BIAYA).toFixed(0), 'Rp. '));
      },
      error: function(data){
        $('#inputUangMakan').val("0");
        $('#showUangMakan').val(formatRupiah(Number("0").toFixed(0), 'Rp. '));
      }
    });
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
            inputNamaPIC
          },
      url: url+'/pengajuan/savePIC',
      cache: false,
      async: true,
      success: function(data){
        berhasil();
        $('#modal-pic').modal('hide');
        getPIC();
        getTotalUangSakuMakan();
        $("select#inputJenisPIC option[value='']").prop("selected","selected");
        $("select#inputJenisPIC").trigger("change");
        $("select#inputSubjek option[value='']").prop("selected","selected");
        $("select#inputSubjek").trigger("change");
        $("select#inputPIC option[value='']").prop("selected","selected");
        $("select#inputPIC").trigger("change");
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
    $.ajax({
      type: 'get',
      data: {inputNoSPJ},
      dataType: 'json',
      url:url+'/pengajuan/getUangJalanSPJ',
      cache: false,
      async: true,
      success: function(data){
        var uangJalan = Number(data.BIAYA).toFixed(0);
        
        $('#tampilTotalUangJalan').html(formatRupiah(uangJalan, 'Rp.'));
        $('#inputTotalUangJalan').val(uangJalan);
      },
      error: function(data){

      }
    });
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
    var inputAbnormal = abnormal.checked == true ? 'Y' : 'N';
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
            status
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
          window.location.href = '<?=base_url()?>monitoring/spj';
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
        if (inputKendaraan == 'Rental') {
          cekSaldo(status);
        } else {
          if (parseInt(data)>0) {
            cekSaldo(status);
          } else {
            Swal.fire("Tidak Terdapat Driver Pada SPJ Ini!","PIC yang di daftarkan Tidak ada yang memiliki otoritas Driver!","warning")
          }  
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
    var bbmSPJ = inputMediaBBM == 'Voucher' ? 0 : inputBBM;
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
    $.ajax({
      type: 'post',
      data: {inv, inputJenisKendaraan, noSPJ, tnkb, merk, tipe, kendaraan, inputRekananKendaraan},
      dataType: 'json',
      url: url+'/pengajuan/saveKendaraanSPJ',
      cache: false,
      async: true,
      success: function(data){
        console.log(data);
        stepper.next()
        if (inputJenisSPJ == 1) {
          cekOutGoingSerlok();  
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
          stepper.next()
          getPIC()
          getTotalUangSakuMakan()
          getUangJalan();
        }

      },
      error: function(data){
        Swal.fire("Terjadi Error Pada Program","Mohon Hubungi Staff IT","error")
      }
    });
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
    if (inputMediaBBM == 'Voucher') {
      $('#voucherBBM').removeClass("d-none")
      $('#manualBBM').addClass("d-none");
      getNoVoucher()
      $('#inputBBMManual').val("");
    }else{
      $('#voucherBBM').addClass("d-none");
      $('#manualBBM').removeClass("d-none");
      $('#inputNoVoucher').val("");
      if (inputMediaBBM == 'Kasbon') {
        $('#inputBBMManual').removeAttr("readonly","readonly");
      }else{
        $('#inputBBMManual').attr("readonly","readonly");
        $('#inputBBMManual').val("");
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
        $('#inputNoVoucher').val(data.voucher);
      },
      error: function(data){
        
      }
    })
  }

  function cekOutGoingSerlok() {
    var inputNoTNKB = $('#inputNoTNKB').val();
    var inputTglSPJ = $('#inputTglSPJ').val();
    $.ajax({
      type:'get',
      data:{inputNoTNKB, inputTglSPJ},
      dataType:'json',
      url:url+'/pengajuan/cekOutGoingSerlok',
      cache: false,
      async: true,
      success: function(data){
        var jmlData = data.length;
        var html='';
        if (jmlData>0) {
          for (var i = 0; i < data.length; i++) {
            html+='<tr>';
            html+='<td>'+data[i].COMPANY_NAME+'</td>';
            html+='<td>'+data[i].PLANT1_CITY+'</td>';
            html+='</tr>';
          }
          $('#getSerlok').html(html);
          $('#modal-serlok').modal('show')
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

  function kondisiTombolLokasi() {
    var inputJenisSPJ = $('#inputJenisSPJ').val();
    console.log(inputJenisSPJ)
    if (inputJenisSPJ == '1') {
      // $('#inputKota').attr("disabled","disabled");
      // // $('#btnCekProgramSerlok').attr("disabled","disabled");
      $('#btnCekProgramSerlok').removeAttr("disabled","disabled");
      // $('#tambahLokasi').attr("disabled","disabled");
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
    $.ajax({
      type:'get',
      data:{inputKendaraan, inputJenisKendaraan, inputTglSPJ, searchKendaraan},
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
    
    if (inputAbnormal.checked == true) {
      $('#tampilTotalUangJalan').addClass("d-none");
      $('#manualUangJalan').removeClass("d-none");
    }else{
      $('#tampilTotalUangJalan').removeClass("d-none");
      $('#manualUangJalan').addClass("d-none");
    }
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
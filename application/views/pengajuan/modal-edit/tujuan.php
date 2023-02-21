<div class="row">
	<div class="col-md-2 col-sm-4">
		<button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnTambahLokasi">
			Tambah Data
		</button>
	</div>
	<div class="col-md-2 col-sm-4">
		<button type="button" class="btn bg-orange btn-kps btn-sm btn-block" id="btnCekProgramSerlok">
			Cek Outgoing Serlok
		</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<!-- <table class="table table-hover table-striped table-valign-middle" width="100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Objek</th>
					<th>Nama/Perusahaan</th>
					<th>Kota/Kabupaten</th>
					<th>Group Tujuan</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="getLokasi">
				
			</tbody>
		</table> -->
		<div id="getLokasi"></div>
	</div>
</div>

<div class="modal fade" id="modal-lokasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-12">
      			<div class="form-group">
      				<label>Kota/Kabupaten</label>
      				<select class="select2" id="inputKota" multiple="multiple" data-placeholder="Pilih Kota/Kabupaten" data-dropdown-css-class="select2-orange" style="width: 100%;color: white !important;">
                      <?php foreach ($kota as $kot): ?>
                        <option><?=$kot->NAMA_KOTA?></option>
                      <?php endforeach ?>
                    </select>
      			</div>
      		</div>
      	</div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Objek</label>
              <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputObjek">
                <option value="Customer" selected>Customer</option>
                <option value="Supplier">Supplier</option>
                <option value="Rekanan">Rekanan</option>
                <option value="Lainnya">Lainnya...</option>
              </select>
              <br>
            </div>
          </div>
        </div>
        <div class="objekLainnya d-none">
          <div class="row">
            <div class="col-md-12">
              <input type="text" id="inputObjekLainnya" class="form-control" placeholder="Isi Objek Lainnya" readonly>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKotaKabupaten" style="width:100%">
                  
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Tempat</label>
                <input type="text" id="inputNamaTempat" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" id="inputAlamat" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="objekRekanan d-none">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tujuan Rekanan</label>
                <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputPerusahaan2">
                  <option value="Solokan Jeruk">Solokan Jeruk</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Group Tujuan</label>
                <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputGroupPerusahaan2">
                  <option value="">Pilih Group</option>
                  <?php foreach ($group as $gr): ?>
                    <option value="<?=$gr->ID_GROUP?>"><?=$gr->NAMA_GROUP?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div> 
        </div>
        <div class="objekNormal">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Perusahaan</label>
                <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputPerusahaan">
                  
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Group Tujuan</label>
                <select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputGroupPerusahaan">
                  <option value="">Pilih Group</option>
                  <?php foreach ($group as $gr): ?>
                    <option value="<?=$gr->ID_GROUP?>"><?=$gr->NAMA_GROUP?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div> 
        </div>
        
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn bg-orange btn-kps saveLokasi ladda-button" data-style="expand-right">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-kontol" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <div class="modal-title">
          <label>Program SPJ Menemukan Data Outgoing dari Program Serlok. Kendaraan Dengan No TNKB <?=$noTNKB?> Berangkat Ke Customer Berikut:</label>
        </div>
      </div>
      <div class="modal-body">
       	<!-- <div class="row">
          <div class="col-md-4 col-sm-6">
            <div class="form-group">
              <label>Departure Time</label>
              <select class="select2" id="inputDepartureTime" multiple="multiple" data-placeholder="Pilih Departure Time Dari Program Serlok" data-dropdown-css-class="select2-orange" style="width: 100%;color: white !important;">
                
              </select>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-md-12 table-responsive p-0">
            <table class="table table-hover table-valign-middle table-striped" width="100%">
              <thead>
                <tr>
                  <th>Company Name</th>
                  <th>Plant City</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="getSerlokTujuan">
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn bg-orange btn-kps saveLokasiSerlok ladda-button" data-style="expand-right">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2({
	        'width': '100%',
	    });
		getLokasi();
		$('#btnCekProgramSerlok').on('click', function(){
			$('#modal-kontol').modal("show");
			cekOutGoingSerlok()
			// getCustomerSerlok();
		})
		$('#inputKota').on('change', function(){
			getCustomerSerlok();
		})
		$('#inputObjek').on('change', function(){
	      var objek = $(this).val();
	      if (objek == 'Lainnya') {
	        $('.objekLainnya').removeClass("d-none")
	        $('.objekNormal').addClass("d-none");
	        $('#btnCekProgramSerlok').attr("disabled","disabled")
	        $('#inputKota').attr("disabled","disabled")
	        $('.objekRekanan').addClass("d-none");
	      }else if(objek == 'Rekanan'){
	        $('.objekLainnya').addClass("d-none");
	        $('.objekNormal').addClass("d-none");
	        $('.objekRekanan').removeClass("d-none");
	        $('#inputKota').removeAttr("disabled","disabled")
	      } else {
	        $('.objekLainnya').addClass("d-none");
	        $('.objekNormal').removeClass("d-none");
	        $('.objekRekanan').addClass("d-none");
	      	$('#inputKota').removeAttr("disabled","disabled")
	      }
	    });
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
	    $('#btnTambahLokasi').on('click', function(){
        // $('#modal-kontol').modal('show')
        // getDepartureTime()
        // cekOutGoingSerlok()
        $('#modal-lokasi').modal("show");
				getCustomerSerlok();
      })
      var saveLokasiSerlok = $('.saveLokasiSerlok').ladda();
      saveLokasiSerlok.click(function () {
	      // Start loading
	      saveLokasiSerlok.ladda('start');
	      // Timeout example
	      // Do something in backend and then stop ladda
	      setTimeout(function () {
	       	var idDelivery=[];
	       	var inputNoTNKB = '<?=$noTNKB?>';
    			var inputTglSPJ = '<?=$tglSPJ?>';
    			var inputNoSPJ = '<?=$noSPJ?>';
    			var inputJenisSPJ = '<?=$jenisId?>';
    			var inputJenisKendaraan = '<?=$jenisKendaraan?>';
    			var proses = 'Edit';
	        $.each($('[name="pilihCustomer"]:checked'), function(){
	          idDelivery.push($(this).val());
	        })
	        $.ajax({
	        	type:'post',
	        	data:{idDelivery, inputNoTNKB, inputTglSPJ, inputNoSPJ, inputJenisSPJ, inputJenisKendaraan, proses},
	        	dataType:'json',
	        	url:url+'/pengajuan/saveCustomerSerlokNewPola',
	        	cache:false,
	        	async:true,
	        	beforeSend:function(data){
	        		$('.saveLokasiSerlok').attr("disabled","disabled")
	        	},
	        	success:function(data){
	        		berhasil();
	        		getLokasi();
	        		$('#modal-kontol').modal("hide");
	        	},
	        	complete:function(data){
	        		saveLokasiSerlok.ladda('stop');
	        		$('.saveLokasiSerlok').removeAttr("disabled","disabled")
	        	},
	        	error:function(data){
	        		gagal();
	        	}
	        })
	        
	        return false;
	          
	      }, 1000)
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
        if (objek == 'Lainnya') {
          var inputPerusahaan = '-'
          var inputGroupTujuan = '0'
        }else if(objek == 'Rekanan'){
          var inputPerusahaan = $('#inputPerusahaan2').val()
          var inputGroupTujuan = $('#inputGroupPerusahaan2').val()  
        }else{
          var inputPerusahaan = $('#inputPerusahaan').val();
          var inputGroupTujuan = $('#inputGroupPerusahaan').val();
        } 

        var inputObjek = objek == 'Lainnya'?objekLainnya:objek;
        var inputNoSPJ = '<?=$noSPJ?>';
        var inputKotaKabupaten = $('#inputKotaKabupaten').val();
        var inputNamaTempat = $('#inputNamaTempat').val();
        var inputAlamat = $('#inputAlamat').val();
        var proses = 'Edit';
        if (objek == '' || inputPerusahaan == '' || inputGroupTujuan == '') {
          Swal.fire("Lengkapi Dulu Datanya!","","warning");
          saveLokasi.ladda('stop');
        }else{
          $.ajax({
            type:'post',
            dataType:'json',
            data:{inputPerusahaan, inputGroupTujuan, inputObjek, inputNoSPJ, objek, inputKotaKabupaten, inputNamaTempat, inputAlamat, proses},
            url:url+'/pengajuan/saveLokasiTujuan',
            cache: false,
            async: true,
            success: function(data){
              $('#modal-lokasi').modal('hide');
              berhasil();
              getLokasi();
              getUangJalan();
              updateGroupTujuan();
              var inputAbnormal = document.getElementById("inputAbnormal");
              if (inputAbnormal.checked == true) {
                getUangAbnormalDM();
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

	})
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
	  	var inputNoSPJ = '<?=$noSPJ?>';
	  	var inputJenisSPJ = '<?=$jenisId?>';
	  	$.ajax({
	  		type:'get',
	  		data:{inputNoSPJ, inputJenisSPJ},
	  		cache:false,
	  		async:true,
	  		url:url+'/pengajuan/getLokasi',
	  		success:function(data){
	  			$('#getLokasi').html(data)
	  		},
	  		error:function(data){
	  			$('#getLokasi').html("Gagal Mengambil Data")
	  		}
	  	})
	  }
	  function cekOutGoingSerlok() {
    var inputNoTNKB = '<?=$noTNKB?>';
    var inputTglSPJ = '<?=$tglSPJ?>';
    console.log(inputNoTNKB)
    // var data = $('#inputDepartureTime').val();
    //   if (data.length >0) {
    //     var whereDeparture = " AND b.departure_time  IN ("
    //     var jml = data.length-1;
    //     for (var i = 0; i < data.length; i++) {
    //       whereDeparture+="'"+data[i]+"'";
    //       if (i<jml) {
    //         whereDeparture+=",";
    //       }else{
    //         whereDeparture+=")";
    //       }
    //     }
    //   }else{
        
    //   }
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
          	check = data[i].ID == null ? 'disabled':'checked';
            html+='<tr>';
            html+='<td>'+data[i].COMPANY_NAME+'</td>';
            html+='<td>'+data[i].PLANT1_CITY+'</td>';
            html+='<td><div class="icheck-orange icheck-kps d-inline"><input type="checkbox" id="'+data[i].ID+'" name="pilihCustomer" value="'+data[i].ID+'" '+check+'><label for="'+data[i].ID+'"></label></div></td>';
            html+='</tr>';
          }
          $('#getSerlokTujuan').html(html);
          $('#titleTNKB').html(inputNoTNKB);
          console.log(html)
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
</script>
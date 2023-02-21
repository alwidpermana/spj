<input type="hidden" id="inputDataNoSPJ" value="<?=$noSPJ?>">
<input type="hidden" id="inputIdSPJ" value="<?=$idSPJ?>">
<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Kendaraan</label>
					<select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKendaraan">
	                    <?php foreach ($kendaraan as $ken): ?>
	                      <option value="<?=$ken->Jenis?>" <?=$data->KENDARAAN == $ken->Jenis?'selected':''?>><?=$ken->Jenis?></option>
	                    <?php endforeach ?>
	                    <option value="Rental">Rental</option>
	                 </select>
				</div>
			</div>
		</div>
		<input type="hidden" id="kendaraanRekanan">
		<div class="row rekanan d-none">
            <div class="col-md-12">
              	<label>Rekanan</label>
              	<select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="pilihRekanan">
                		<option value="">ALL</option>
                		<?php foreach ($rekanan as $rn): ?>
                			<option value="<?=$rn->ID?>" <?=$data->REKANAN_ID == $rn->ID ? 'selected':''?>><?=$rn->NAMA?></option>
                		<?php endforeach ?>
              	</select>
              	<input type="hidden" id="inputRekanan" value="<?=$data->NO_TNKB?>">
            </div>
      	</div>
      	<div class="row rekanan d-none">
      		<div class="col-md-12">
      			<label>Kendaraan</label>
      			<select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputKendaraanRekanan"></select>
      			<span id="kontol"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-md-12">
      			<label>Jenis Kendaraan</label>
      			<select class="select2 form-control select2-orange" data-dropdown-css-class="select2-orange" id="inputJenisKendaraan">
                  	<option value="">-</option>
                	<?php foreach ($jenis as $jen): ?>
                  		<option 
                  			value="<?=$jen->JENIS_KENDARAAN?>" 
                  			<?=$data->JENIS_KENDARAAN == $jen->JENIS_KENDARAAN ?'selected':''?>>
                  			<?=$jen->JENIS_KENDARAAN?>
                  				
                  			</option>
                	<?php endforeach ?>
              	</select>
      		</div>
      	</div>
      	<br>
      	<div class="row internal">
      		<div class="col-md-6"></div>
      		<div class="col-md-6 text-right">
			<button type="button" id="pilihKendaraan" class="btn btn-secondary btn-sm">
	                  <i class="fas fa-car-side"></i>&nbsp;
	                  Pilih Kendaraan
                	</button>
      		</div>
      	</div>
      	<br>
      	<div class="row">
      		<div class="col-md-12 text-right">
      			<button type="button" class="btn bg-orange btn-kps btn-sm ladda-button" data-style="zoom-in" id="saveKendaraan">
      				 <i class="fas fa-save"></i>&nbsp; Simpan Data Kendaraan
      			</button>
      		</div>
      	</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>No Inventaris</label>
					<input type="text" id="inputNoInventaris" class="form-control form-control-sm" value="<?=$data->NO_INVENTARIS?>" readonly>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>No TNKB</label>
					<input type="text" id="inputDataNoTNKB" class="form-control form-control-sm" value="<?=$data->NO_TNKB?>" readonly>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Merk</label>
					<input type="text" id="inputMerk" class="form-control form-control-sm" value="<?=$data->MERK?>" readonly>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Type</label>
					<input type="text" id="inputType" class="form-control form-control-sm" value="<?=$data->TYPE?>" readonly>
				</div>
			</div>
		</div>
		<div class="row rekanan">
			<div class="col-md-12">
				<div class="form-group">
					<label>Rekanan</label>
					<input type="text" id="inputRekananKendaraan" class="form-control form-control-sm" value="<?=$data->NAMA?>" readonly>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2({
	        'width': '100%',
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
	      var noSPJ = $('#inputDataNoSPJ').val();
	      var kendaraan = $('#inputKendaraan').val();
	      console.log(noSPJ)
	      $('#inputNoInventaris').val(inv);
	      $('#inputMerk').val(merk);
	      $('#inputType').val(tipe);
	      $('#inputDataNoTNKB').val(tnkb);
	      $('#modal-kendaraan').modal("hide");
	    });

	    $('#inputKendaraan').on('change', function(){
	    	settingKendaraan();
	    })
	    settingKendaraan();
	    $('#pilihRekanan').on('change',function(){
	    	var kendaraanRekanan = $('#kendaraanRekanan').val();
	    	var rekananId = $(this).val();
	    	$('#inputRekanan').val(rekananId);
	    	getKendaraanRekanan(rekananId, kendaraanRekanan);
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
	          $('#inputDataNoTNKB').val(data.NoTNKB);
	          $('#inputNoInventaris').val("-");
	          $("select#inputJenisKendaraan option[value='"+data.Kategori+"']").prop("selected","selected");
	          $("select#inputJenisKendaraan").trigger("change") 
	          $('#inputRekananKendaraan').val(data.NAMA)
	        },
	        error:function(data){

	        }
	      })
	    })
	    	var saveKendaraan = $('#saveKendaraan').ladda();
	      saveKendaraan.click(function () {
	      	// Start loading
		      saveKendaraan.ladda('start');
		      // Timeout example
		      // Do something in backend and then stop ladda
		      setTimeout(function () {
		    	    var inputJenisKendaraan = $('#inputJenisKendaraan').val();
			    var noSPJ = $('#inputDataNoSPJ').val();
			    var inv = $('#inputNoInventaris').val();
			    var merk = $('#inputMerk').val();
			    var tipe = $('#inputType').val();
			    var tnkb= $('#inputDataNoTNKB').val();
			    var kendaraan = $('#inputKendaraan').val();
			    var inputRekananKendaraan = $('#inputRekananKendaraan').val();
			    var inputRekanan = $('#inputRekanan').val();
			    $.ajax({
			      type: 'post',
			      data: {inv, inputJenisKendaraan, noSPJ, tnkb, merk, tipe, kendaraan, inputRekananKendaraan, inputRekanan},
			      dataType: 'json',
			      url: url+'/pengajuan/updateKendaraanSPJ',
			      cache: false,
			      async: true,
			      beforeSend:function(data){
			      	$('#saveKendaraan').attr("disabled","disabled");
			      },
			      success: function(data){
			       Swal.fire("Berhasil Menyimpan Data","","success");
			       location.reload();
        			 $('#modal-form-edit').modal("hide");
			      },
			      complete:function(data){
			      	saveKendaraan.ladda('stop');
			      	$('#saveKendaraan').attr("disabled","disabled");
			      },
			      error: function(data){
			        Swal.fire("Gagal Menyimpan Data","","error")
			      }
			    })

	        	
	        	return false;
		          
		      }, 500)
	    	});
	})
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
  	function settingKendaraan() {
  		var inputKendaraan = $('#inputKendaraan').val();
  		if (inputKendaraan == 'Rental') {
  			$('.rekanan').removeClass("d-none")
  			$('.internal').addClass("d-none")
  		}else{
  			$('.rekanan').addClass("d-none")
  			$('.internal').removeClass("d-none")
  		}
  	}
  	function getKendaraanRekanan(rekananId, kendaraan) {
  		var where = '';
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
	            where = kendaraan==data[i].NoTNKB?"selected":"";
	            html+='<option value="'+data[i].ID+'" '+where+'>'+data[i].NoTNKB+' - '+data[i].Merk+' '+data[i].Type+'</option>';
	          	where = '';
	          }
	          $('#inputKendaraanRekanan').html(html)
	          console.log(kendaraan)
	        },
	        error:function(data){

	        }
	      });
  	}
  	// function saveAutoTujuan() {
  	// 	$.ajax({
	//           type:'post',
	//           dataType:'json',
	//           data:{inputDataNoSPJ, inputTglSPJ, inputNoTNKB, whereDeparture},
	//           url:url+'/pengajuan/saveCustomerSerlok',
	//           cache: false,
	//           async: true,
	//           success: function(data){
	//             berhasil();
	//             $('#modal-serlok').modal("hide");
	//             cekGroupTujuanBaru(groupId, inputDataNoSPJ)
	//           },
	//           error:function(data){
	//             gagal()
	//           }
      //   	});
  	// }
</script>
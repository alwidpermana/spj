<style type="text/css">
	[type=radio] {
	  position: absolute;
	  opacity: 0;
	}
	[type=radio]+img {
	  cursor: pointer;
	  margin-right: 0.5rem;
	}
	[type=radio]:checked + img{
	  outline: 2px solid rgb(178, 58, 72);
	  border-radius: 5px;
	}
	a {
	  color: white;
	}
	img{
		width: 100%;
	}
</style>
<?php $ajg = count($data);?>
<div class="row">
	<?php if ($ajg>0): ?>
		<?php foreach ($data as $key): ?>
			<div class="col-md-3">
				<div class="card" class="kartuEuy">
				  
				  <label>
				    <input 
				    	type="radio" 
				    	name="pilihKendaraan" 
				    	class="pilihKendaraan" 
				    	tnkb = "<?=$key->NoTNKB?>"
				    	merk = '<?=$key->Merk?>'
				    	tipe = '<?=$key->Type?>'
				    	inv = '<?=$key->NoInventaris?>'>
				    <img 
				    	src="<?=base_url()?>assets/image/<?=$key->NAMA_FILE == null || $key->NAMA_FILE == 'N'?'car.png':'/foto-kendaraan/'.$key->NAMA_FILE?>" 
				    	class="card-img-top">
				  </label>
				  
				  <div class="card-body">
				    <p class="card-text text-center">
				    	<label><?=$key->NoTNKB?></label><br>
				    	<?=$key->Merk?>&nbsp;<?=$key->Type?>
				    </p>
				  </div>
				</div>
			</div>
		<?php endforeach ?>
	<?php else: ?>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<center>
						<img src="<?=base_url()?>assets/image/no-data-min.png" class="rounded" style="width: 500px;">
					</center>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<span class="text-kps" style="font-size:32px">Maaf, Tidak Ada Data Kendaraan Yang Tersedia</span>
				</div>
			</div>
		</div>

	<?php endif ?>

	
</div>
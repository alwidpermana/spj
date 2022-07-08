<div class="row">
	<div class="col-sm-1"></div>
	<?php foreach ($induk as $key): ?>
		<div class="col-6 col-sm-2">
		    <div class="p-2 border border-dashed border-start-0 bg-white">
		        <h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key->JUMLAH))?></h6>
		        <p class="text-muted mb-0">Kas Induk <?=$key->NAMA_SALDO?></p>
		    </div>
		</div>
	<?php endforeach ?>
</div>
<div class="row pt-2">
	<div class="col-sm-1"></div>
	<?php foreach ($sub as $key2): ?>
		<div class="col-6 col-sm-2">
		    <div class="p-2 border border-dashed border-start-0 bg-white">
		        <h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key2->JUMLAH))?></h6>
		        <p class="text-muted mb-0">Sub Kas <?=$key2->NAMA_SALDO?></p>
		    </div>
		</div>
	<?php endforeach ?>
</div>
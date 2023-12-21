<div class="row">
	<?php foreach ($induk as $key): ?>
		<div class="col-6 col-sm-2 mt-2">
		    <div class="p-2 border border-dashed border-start-0 bg-white">
		    	<h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key->JUMLAH))?></h6>
		    	<p class="text-muted mb-0">Kas Induk <?=$key->NAMA_SALDO?></p>	
		    </div>
		</div>
	<?php endforeach ?>
</div>
<hr>
<div class="row">
	<?php foreach ($sub as $key2): ?>
		<div class="col-6 col-sm-2 mt-2">
		    <div class="p-2 border border-dashed border-start-0 bg-white">
		    	<?php if ($this->session->userdata("NIK") == '04035'): ?>
		    		<a href="javascript:;" class="ubahSaldo" jenis="<?=$key2->NAMA_SALDO?>" rp="<?=round($key2->JUMLAH)?>" kas="SUB KAS"><h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key2->JUMLAH))?></h6></a>
		    	<?php else: ?>
		    		<h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key2->JUMLAH))?></h6>
		        	
		    	<?php endif ?>
		        <!-- <h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key2->JUMLAH))?></h6> -->
		        <p class="text-muted mb-0">Sub Kas <?=$key2->NAMA_SALDO?></p>
		        <p class="text-muted mb-0 text-kps"><?=$key2->RP_OUTSTANDING == null?'&nbsp;':'-'.str_replace(',', '.', number_format($key2->RP_OUTSTANDING))?></p>
		    </div>
		</div>
	<?php endforeach ?>
</div>
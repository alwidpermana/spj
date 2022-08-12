<?php foreach ($data as $key): ?>
	<div class="p-2 border border-dashed border-start-0 bg-white">
        <h6 class="mb-1">Rp <?=str_replace(',', '.', number_format($key->SALDO))?></h6>
        <p class="text-muted mb-0"><?=$jenis?></p>
    </div>
    <input type="hidden" id="inputSaldoHidden" value="<?=$key->SALDO?>">
<?php endforeach ?>
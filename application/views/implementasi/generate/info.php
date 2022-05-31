<?php
	$jumlahSPJ =0;
	$totalRP = 0;
	foreach ($total as $key) {
		$jumlahSPJ = $key->JUMLAH_SPJ;
		$totalRP = $key->TOTAL_RP;
	}
?>
<div class="row">
	<div class="col-md-2"><label>Jumlah SPJ</label></div>
	<div class="col-md-4">: <?=$jumlahSPJ?></div>
	<input type="hidden" id="inputJumlahSPJ" value="<?=$jumlahSPJ?>">
</div>
<div class="row">
	<div class="col-md-2"><label>Total Rp.</label></div>
	<div class="col-md-4">: <?=str_replace(',', '.', number_format($totalRP))?></div>
	<input type="hidden" id="inputTotalRP" value="<?=round($totalRP)?>">
</div>
<div class="row">
	<div class="col-md-2"><label>No Generate Req</label></div>
	<div class="col-md-4">: <?=$noGenerate?></div>
	<input type="hidden" id="inputNoGenerate" value="<?=$noGenerate?>">
</div>
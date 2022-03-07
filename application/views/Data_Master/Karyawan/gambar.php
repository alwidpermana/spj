<?php if ($gambar != ''): ?>
	<center>
		<label>
			<?php if ($field == 'FOTO_WAJAH'): ?>
				Foto Wajah
			<?php elseif($field == 'FOTO_KTP'):?>
				Foto KTP
			<?php elseif($field == 'FOTO_SIM'):?>
				Foto SIM
			<?php else: ?>
				
			<?php endif ?>
		</label>
	</center>
	<img src="<?=base_url()?>assets/image/<?=$folder?>/<?=$gambar?>" class="rounded mx-auto d-block">
<?php endif ?>
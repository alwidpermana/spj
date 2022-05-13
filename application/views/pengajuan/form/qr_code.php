<?php if (file_exists('./assets/image/qrcode/'.$nama.'.png')): ?>
	<center>
		<img src="<?=base_url()?>assets/image/qrcode/<?=$nama?>.png" class="img-thumbnail" style="width: 150px; height:150px"> 
		<br>
		<label><?=$nama?></label>
	</center>
	
<?php endif ?>
<br>


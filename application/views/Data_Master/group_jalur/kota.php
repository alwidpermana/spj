<?php foreach ($data as $key): ?>
  <div class="row">
    <div class="col-md-12">
      <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon btn-kps_gray btn-block btn-sm" data-toggle="dropdown" style="font-size: 10px;color:white !important;">
        <?=$key->KOTA?>
        <span class="sr-only"></span>
      </button>
      <div class="dropdown-menu" role="menu" style="font-size: 10px">
        <?php foreach ($group as $key2): ?>
          <a class="dropdown-item dropButton gantiGroupJalur" href="javascript:;" data="<?=$key2->ID_GROUP?>" kota = "<?=$key->ID_KOTA?>"><?=$key2->NAMA_GROUP?></a>
        <?php endforeach ?>
        
      </div>
    </div>
  </div>
  <br>
<?php endforeach ?>
<div class="row">
 <div class="col-md-6">
  <?php foreach ($data as $ganjil): ?>
    <?php if ($ganjil->URUT %2 != 0): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card cardGalery ">
            <div class="card-header border-0">
              <div class="card-title"><?=$ganjil->JENIS_GAMBAR?></div>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toolKPS btnHapus" data="<?=$ganjil->ID_GK?>">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <img src="<?=base_url()?>assets/image/foto-kendaraan/<?=$ganjil->NAMA_FILE?>" class="img-thumbnail" alt="Kendaraan" width="100%">

            </div>
          </div>
        </div>
      </div>
      <br>
    <?php endif ?>
  <?php endforeach ?>
    
  </div>
  <div class="col-md-6">
    <?php foreach ($data as $genap): ?>
    <?php if ($genap->URUT %2 == 0): ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card cardGalery ">
            <div class="card-header border-0">
              <div class="card-title"><?=$genap->JENIS_GAMBAR?></div>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toolKPS btnHapus" data="<?=$genap->ID_GK?>">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <img src="<?=base_url()?>assets/image/foto-kendaraan/<?=$genap->NAMA_FILE?>" class="img-thumbnail" alt="Kendaraan" width="100%">
            </div>
          </div>
        </div>
      </div>
      <br>
    <?php endif ?>
  <?php endforeach ?>
  </div>
</div>  
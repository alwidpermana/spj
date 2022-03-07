<div class="table-responsive">
	<div class="row">
		<?php foreach ($data as $key): ?>
			<div class="col-md-3">
				<div class="card card-outline card-gray">
					<div class="card-header border-0">
						<div class="card-title">
							<?=$key->NAMA_GROUP?>
						</div>
						<div class="card-tools">
		                  	<a href="javascript:;" class="btn btn-tool btn-sm editGroup" data="<?=$key->ID_GROUP?>" nama= "<?=$key->NAMA_GROUP?>">
		                    	<i class="fas fa-edit"></i>
		                  	</a>
		                  	<!-- <a href="javascript:;" class="btn btn-tool btn-sm hapusGroup" data="<?=$key->ID_GROUP?>">
		                    	<i class="fas fa-trash-alt"></i>
		                  	</a> -->
		                </div>
					</div>
					<div class="card-body">
						<?php foreach ($isi as $key2): ?>
							<?php if ($key->ID_GROUP == $key2->ID_GROUP): ?>
								<div class="row">
									<div class="col-md-12">
										<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-kps btn-block btn-sm" data-toggle="dropdown" style="font-size: 10px">
									        <?=$key2->TIPE_KOTA.' '.$key2->NAMA_KOTA?>
									        <span class="sr-only"></span>
									    </button>
									    <div class="dropdown-menu" role="menu" style="font-size: 10px">
									        <?php foreach ($data as $key3): ?>
									          <a class="dropdown-item dropButton gantiGroupJalur" href="javascript:;" data="<?=$key3->ID_GROUP?>" kota="<?=$key2->ID_KOTA?>"><?=$key3->NAMA_GROUP?></a>
									        <?php endforeach ?>
									        <a class="dropdown-item dropButton gantiGroupJalur" href="javascript:;" data="0" kota="<?=$key2->ID_KOTA?>">Batal</a>
									    </div>
									</div>
								</div>
								<br>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>

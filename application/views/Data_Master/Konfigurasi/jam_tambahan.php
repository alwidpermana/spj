<?php
  $jam1=0;
  $jam2=0;
  foreach ($data as $jt) {
    $jam1 = $jt->JAM1;
    $jam2 = $jt->JAM2;
  }

?>
<p>
  <b>Apabila perjalanan dinas luar kota dimana jam kerja melebihi <a href="javascript:;" class="text-warning text-kps setJamTambahan" field="JAM1" data="<?=$jam1?>"><?=$jam1?></a> jam (dari keberangkatan) atau perjalanan melebihi <a href="javascript:;" class="text-warning text-kps setJamTambahan" field="JAM2" data="<?=$jam2?>"><?=$jam2?></a> jam dengan lewat pukul 24.00, maka mendapat uang saku tambahan sebagai berikut:</b>
</p>
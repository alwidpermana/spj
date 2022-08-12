
<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    .tableTest{
      border: 1px solid black;
      color: #232323;
      border-collapse: collapse;
      font-size: 12px;
    }
    .tableTest th td {
        padding: 2px 3px 2px 3px;
    }
    .invoice-info{
      font-size: 14px !important;
    }
    .border-trp{
      border-top-color: white !important;
      border-left-color: white !important;
      border-bottom-color: white !important;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-8">
        <div class="row">
          <div class="col-md-12">
            <h6 class="page-header">
              PT. Karya Putra Sangkuriang
              <!-- <small class="float-right">Date: 2/10/2014</small> -->
            </h6>
          </div>    
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <H3 class="page-header" style="padding: 25px 0;">SURAT PERINTAH PERJALANAN DINAS (SPPD)</H3>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="row">
          <div class="col-md-6 text-right">
            <img src="<?=base_url()?>assets/image/qrcode/<?=$nama?>.png" style="width: 130px; height:130px;">
          </div>
          <div class="col-md-6">
            <table class="tableTest text-center" width="100%" border="1">
              <tr>
                <th>Validasi & Cap</th>
              </tr>
              <tr>
                <td height="75px"></td>
              </tr>
              <tr>
                <td>Pengaju</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <br>
    <?php foreach ($data as $key): ?>
      <div class="row invoice-info">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-4">Jenis SPJ</div>
            <div class="col-sm-8">: <?=$key->NAMA_JENIS?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">Kendaraan</div>
            <div class="col-sm-8">: <?=$key->KENDARAAN?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">Merk</div>
            <div class="col-sm-8">: <?=$key->MERK?></div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-4">Tanggal SPJ</div>
            <div class="col-sm-8">: <?=date("d F Y", strtotime($key->TGL_SPJ))?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">Jenis Kendaraan</div>
            <div class="col-sm-8">: <?=$key->JENIS_KENDARAAN?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">Type</div>
            <div class="col-sm-8">: <?=$key->TYPE?></div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-4">No SPJ</div>
            <div class="col-sm-8">: <?=$key->NO_SPJ?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">No Inventaris</div>
            <div class="col-sm-8">: <?=$key->NO_INVENTARIS?></div>
          </div>
          <div class="row">
            <div class="col-sm-4">No TNKB</div>
            <div class="col-sm-8">: <?=$key->NO_TNKB?></div>
          </div>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-4">No TNKB</div>
            <div class="col-sm-8">
              : <?php 
                $noLokasi = 1;
                $totalLokasi = count($tujuan);
                foreach ($tujuan as $lok): ?>
                  <?=$lok->SERLOK_KOTA?>
                  <?php if ($noLokasi < $totalLokasi): ?>
                    <?=', '?>
                  <?php endif ?>

                <?php $noLokasi++; endforeach ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-8">
          <table class="tableTest" border="1" width="100%">
            <tr class="text-center">
              <th>Objek</th>
              <th>Nama/Perusahaan</th>
              <th>Kota/Kabupaten</th>
              <th>Group Tujuan</th>
            </tr>
            <?php foreach ($lokasi as $lok2): ?>
            <tr>
              <td class="text-center"><?=$lok2->OBJEK?></td>
              <td><?=$lok2->SERLOK_COMPANY?></td>
              <td class="text-center"><?=$lok2->SERLOK_KOTA?></td>
              <td class="text-center"><?=$lok2->NAMA_GROUP?></td>
            </tr>
          <?php endforeach ?>
          </table>
        </div>
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-3 text-center" style="border-bottom: 1px solid black;">
              Rp.
            </div>
            <div class="col-sm-3 text-center" style="border-bottom: 1px solid black; padding-left: -5px;">
              Media
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Uang Saku
            </div>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></div>
            <div class="col-sm-3 text-center"><?=$key->MEDIA_UANG_SAKU?></div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Uang Makan
            </div>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></div>
            <div class="col-sm-3 text-center"><?=$key->MEDIA_UANG_MAKAN?></div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Uang Jalan
            </div>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_JALAN, 0))?></div>
            <div class="col-sm-3 text-center"><?=$key->MEDIA_UANG_JALAN?></div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Uang BBM
            </div>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_BBM, 0))?></div>
            <div class="col-sm-3 text-center"><?=$key->MEDIA_UANG_BBM?></div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Uang TOL
            </div>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->TOTAL_UANG_TOL, 0))?></div>
            <div class="col-sm-3 text-center"><?=$key->MEDIA_UANG_TOL?></div>
          </div>
          <?php if ($key->STATUS_PERJALANAN == 'IN'): ?>
            <div class="row">
              <div class="col-sm-6">
                Uang Saku Tambahan
              </div>
              <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->US1+$key->US2, 0))?></div>
              <div class="col-sm-3 text-center"></div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                Uang Makan Tambahan
              </div>
              <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($key->UM, 0))?></div>
              <div class="col-sm-3 text-center"></div>
            </div>
          <?php endif ?>
          <div class="row">
            <div class="col-sm-6 text-right">
              <strong>Total</strong>
            </div>
            <?php
              $total = $key->TOTAL_UANG_SAKU + $key->TOTAL_UANG_MAKAN + $key->TOTAL_UANG_JALAN + $key->TOTAL_UANG_BBM + $key->TOTAL_UANG_TOL;
              $totalTambahan = $key->US1 + $key->US2 + $key->UM;
              $totalAll = $total+$totalTambahan;
            ?>
            <div class="col-sm-3 text-center"><?=str_replace(',', '.', number_format($totalAll, 0))?></div>
            <div class="col-sm-3 text-center"></div>
          </div>
        </div>
      </div>
      <div class="row invoice-info" style="padding-top: 10px;">
        <div class="col-12">
          <table class="tableTest" width="100%" border="1">
            <tr class="text-center">
              <td>PIC</td>
              <td>Subjek</td>
              <td>NIK</td>
              <td>Nama</td>
              <td>Departemen</td>
              <td>Sub Departemen</td>
              <td>Jabatan</td>
              <td>Tujuan</td>
              <td>Uang Saku</td>
              <td>Uang Makan</td>
            </tr>
            <tr class="text-center">
              <td>Driver</td>
              <td><?=$key->OBJEK?></td>
              <td><?=$key->NIK_DRIVER?></td>
              <td><?=$key->NAMA_DRIVER?></td>
              <td><?=$key->DEPARTEMEN_DRIVER?></td>
              <td><?=$key->SUB_DEPARTEMEN_DRIVER?></td>
              <td><?=$key->JABATAN_DRIVER?></td>
              <td>Reguler</td>
              <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_SAKU, 0))?></td>
              <td>Rp.<?=str_replace(',', '.', number_format($key->UANG_MAKAN, 0))?></td>
            </tr>
            <?php foreach ($pic as $pc): ?>
              <tr class="text-center">
                <td>Pendamping</td>
                <td><?=$pc->OBJEK?></td>
                <td><?=$pc->NIK_DRIVER?></td>
                <td><?=$pc->NAMA_DRIVER?></td>
                <td><?=$pc->DEPARTEMEN_DRIVER?></td>
                <td><?=$pc->SUB_DEPARTEMEN_DRIVER?></td>
                <td><?=$pc->JABATAN_DRIVER?></td>
                <td><?=$pc->SORTIR == 'Y'?'Sortir':'Reguler'?></td>
                <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_SAKU, 0))?></td>
                <td>Rp.<?=str_replace(',', '.', number_format($pc->UANG_MAKAN, 0))?></td>
              </tr>
              <?php endforeach ?>
              <tr style="font-weight: bold;">
                <td colspan="8" style="text-align: right; font-weight: bold;">Total:</td>
                <td class="text-center">Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_SAKU, 0))?></td>
                <td class="text-center">Rp.<?=str_replace(',', '.', number_format($key->TOTAL_UANG_MAKAN, 0))?></td>
              </tr>
          </table>
        </div>
      </div>
      <div class="row invoice-info" style="padding-top: 10px;">
        <div class="col-6">
          <table class="tableTest" border="1" width="100%">
            <tr class="text-center">
              <td rowspan="2" width="10%" style="border: 1px solid; border: 1px solid; border-top-color: white; border-bottom-color: white; border-left-color: white;"></td>
             
              <td colspan="2" width="20%" height="15px">Rencana</td>
              <td colspan="2" width="20%">Aktual</td>
            </tr>
            <tr class="text-center">
              <td>Tanggal</td>
              <td>Jam</td>
              <td>Tanggal</td>
              <td>Jam</td>
            </tr>
            <tr>
              <td style="border: 1px solid; border: 1px solid; border-top-color: white; border-bottom-color: white; border-left-color: white;">Keberangkatan</td>
              <td class="text-center" height="15px" style="border-left-color: black;"><?=date("d F Y", strtotime($key->RENCANA_BERANGKAT))?></td>
              <td class="text-center"><?=date("H:i", strtotime($key->RENCANA_BERANGKAT))?></td>
              <td class="text-center"><?=$key->KEBERANGKATAN == null ?'':date("d F Y",strtotime($key->KEBERANGKATAN))?></td>
              <td class="text-center"><?=$key->KEBERANGKATAN == null ?'':date("H:i",strtotime($key->KEBERANGKATAN))?></td>
            </tr>
            <tr>
              <td style="border: 1px solid; border: 1px solid; border-top-color: white; border-bottom-color: white; border-left-color: white;">Kepulangan</td>
              <td class="text-center" height="15px"><?=date("d F Y", strtotime($key->RENCANA_PULANG))?></td>
              <td class="text-center"><?=date("H:i", strtotime($key->RENCANA_PULANG))?></td>
              <td class="text-center"><?=$key->KEPULANGAN == null ?'':date("d F Y",strtotime($key->KEPULANGAN))?></td>
              <td class="text-center"><?=$key->KEPULANGAN == null ?'':date("H:i",strtotime($key->KEPULANGAN))?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-4"></div>
        <div class="col-sm-2">
          <table class="tableTest text-center" width="100%" border="1">
            <tr>
              <th colspan="2">Validasi & Cap Security</th>
            </tr>
            <tr>
              <td height="50px" width="50%"></td>
              <td></td>
            </tr>
            <tr>
              <th>Out</th>
              <th>In</th>
            </tr>
          </table>
        </div>
      </div>
    <?php endforeach ?>
    <!-- /.row -->

    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<?php $this->load->view("_partial/js");?>
<script type="text/javascript">
  $(document).ready(function(){
    window.print();
  })
  
</script>
<script>
  
</script>
</body>
</html>

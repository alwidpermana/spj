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
    .tableTest tbody,th,td {
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
    .tabel-voucher{
      width: 100%;
      font-size: 11pt;
      text-align: left;
      font-family: arial;
    }
    .tabelUtama{
      border: 1px black dashed;
      width: 100%;
      border-collapse: collapse;
    }
  </style>
</head>
<body onload="printOut()">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <div class="row">
      <div class="col-12">
        <table class="" width="100%">
          <tr>
            <td style="padding-right: 10px;padding-left: 10px;">
              <table border="0" class="tabel-voucher">
                <tr>
                  <td>PT. Karya Putra Sangkuriang</td>
                </tr>
                <tr>
                  <td>BON PERMINTAAN<td>
                </tr>
                <tr>
                  <td>BOM SPBU <?=$data->TEMPAT_SPBU == 'Katulistiwa'?'34-45310':'33-40201'?></td>
                </tr>
              </table>
              <br>
              <table border="0" class="tabel-voucher">
                <tr>
                  <th colspan="4" style="font-size: 16px">No. <?=$data->VOUCHER_BBM?></th>
                </tr>
                <tr>
                  <td width="35%">No SPJ</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->NO_SPJ?></td>
                </tr>
                <tr>
                  <td width="35%">Tanggal</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->TGL_SPJ?></td>
                </tr>
                <tr>
                  <td width="35%">No Mobil</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->NO_TNKB?></td>
                </tr>
                <tr>
                  <td width="35%">Sopir</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->PIC_DRIVER?></td>
                </tr>
                <tr>
                  <td width="35%">KM</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2" style="border-bottom: thin dotted;"></td>
                </tr>
                <tr>
                  <td width="35%">Banyaknya</td>
                  <td width="5%">:</td>
                  <td width="50%" style="border-bottom: thin dotted;"></td>
                  <td width="10%">Liter</td>
                </tr>
                <tr>
                  <td colspan="3" height="20px"></td>
                </tr>
                <tr>
                  <td width="35%">RP</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2" style="border-bottom: thin dotted;"></td>
                </tr>
                <tr>
                  <td width="35%">Jenis BBM</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2">
                    <table border="0" class="tabel-voucher">
                      <tr>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Pertalite</td>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Solar</td>
                      </tr>
                      <tr>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Pertamax</td>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Dexlite</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="35%">Jenis Mobil</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->JENIS_KENDARAAN?></td>
                </tr>
              </table>
              <br>
              <table border="0" class="tabel-voucher">
                <tr>
                  <td width="50%" style="text-align: center;" colspan="3">TTD SPBU</td>
                  <td width="50%" style="text-align: center;" colspan="3">Disetujui</td>
                </tr>
                <tr>
                  <td colspan="3" height="50px"></td>
                  <td colspan="3" height="50px"></td>
                </tr>
                <tr>
                  <td style="text-align: left;" width="5%">(</td>
                  <td width="40%"></td>
                  <td style="text-align: right;" width="5%">)</td>
                  <td style="text-align: left;" width="5%">(</td>
                  <td width="40%"></td>
                  <td style="text-align: right;" width="5%">)</td>
                </tr>
              </table>  
            </td>
            <td style="padding-left: 10px; padding-right:10px; border-left: 1px black dashed">
              <table border="0" class="tabel-voucher">
                <tr>
                  <td>PT. Karya Putra Sangkuriang</td>
                </tr>
                <tr>
                  <td>BON PERMINTAAN<td>
                </tr>
                <tr>
                  <td>BOM SPBU 33-40201</td>
                </tr>
              </table>
              <br>
              <table border="0" class="tabel-voucher">
                <tr>
                  <th colspan="4" style="font-size: 16px">No. <?=$data->VOUCHER_BBM?></th>
                </tr>
                <tr>
                  <td width="35%">No SPJ</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->NO_SPJ?></td>
                </tr>
                <tr>
                  <td width="35%">Tanggal</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->TGL_SPJ?></td>
                </tr>
                <tr>
                  <td width="35%">No Mobil</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->NO_TNKB?></td>
                </tr>
                <tr>
                  <td width="35%">Sopir</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->PIC_DRIVER?></td>
                </tr>
                <tr>
                  <td width="35%">KM</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2" style="border-bottom: thin dotted;"></td>
                </tr>
                <tr>
                  <td width="35%">Banyaknya</td>
                  <td width="5%">:</td>
                  <td width="50%" style="border-bottom: thin dotted;"></td>
                  <td width="10%">Liter</td>
                </tr>
                <tr>
                  <td colspan="3" height="20px"></td>
                </tr>
                <tr>
                  <td width="35%">RP</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2" style="border-bottom: thin dotted;"></td>
                </tr>
                <tr>
                  <td width="35%">Jenis BBM</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2">
                    <table border="0" class="tabel-voucher">
                      <tr>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Pertalite</td>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Solar</td>
                      </tr>
                      <tr>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Pertamax</td>
                        <td style="border: thin solid;" width="10%"></td>
                        <td width="40%">Dexlite</td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="35%">Jenis Mobil</td>
                  <td width="5%">:</td>
                  <td width="60%" colspan="2"><?=$data->JENIS_KENDARAAN?></td>
                </tr>
              </table>
              <br>
              <table border="0" class="tabel-voucher">
                <tr>
                  <td width="50%" style="text-align: center;" colspan="3">TTD SPBU</td>
                  <td width="50%" style="text-align: center;" colspan="3">Disetujui</td>
                </tr>
                <tr>
                  <td colspan="3" height="50px"></td>
                  <td colspan="3" height="50px"></td>
                </tr>
                <tr>
                  <td style="text-align: left;" width="5%">(</td>
                  <td width="40%"></td>
                  <td style="text-align: right;" width="5%">)</td>
                  <td style="text-align: left;" width="5%">(</td>
                  <td width="40%"></td>
                  <td style="text-align: right;" width="5%">)</td>
                </tr>
              </table>  
            </td>
          </tr>
        </table>
      </div>
    </div>
  </section>
</div>
<?php $this->load->view("_partial/js");?>
<script type="text/javascript">
  $(document).ready(function(){
    window.print();
  })
  var lama = 500;
  t = null;
  function printOut(){
      window.print();
      t = setTimeout("self.close()",lama);
      // setTimeout(printVoucher(), 1000)
  }
  function printVoucher() {
    var id = '<?=$this->uri->segment("3")?>'
    var url1 = url+"/monitoring/print_voucher/"+id;
    window.open(url1,'_blank');
  }
  
</script>
</body>
</html>
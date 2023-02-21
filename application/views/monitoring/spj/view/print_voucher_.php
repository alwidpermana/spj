
<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    @page { margin: 0 }
    body { margin: 0; font-size:10px;font-family: monospace;}
    td { font-size:10px; }
    .sheet {
      margin: 0;
      overflow: hidden;
      position: relative;
      box-sizing: border-box;
      page-break-after: always;
    }

    /** Paper sizes **/
    body.struk        .sheet { width: 58mm; }
    body.struk .sheet        { padding: 2mm; }

    .txt-left { text-align: left;}
    .txt-center { text-align: center;}
    .txt-right { text-align: right;}

    /** For screen preview **/
    @media screen {
      body { background: #e0e0e0;font-family: monospace; }
      .sheet {
        background: white;
        box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
        margin: 5mm;
      }
    }

    /** Fix for Chrome issue #273306 **/
    @media print {
        body { font-family: monospace; }
        body.struk                 { width: 7cm; height: 11cm; text-align: left;}
        body.struk .sheet          { padding: 2mm; }
        .txt-left { text-align: left;}
        .txt-center { text-align: center;}
        .txt-right { text-align: right;}
    }
  </style>
</head>
<body class="struk" onload="printOut()">
<div class="wrapper sheet">
  <!-- Main content -->

  <section class="invoice">
    <div class="text-left">
      <div style="padding-left: 5px; padding-right: 5px;">
        <div class="row">
          <div class="col-12">
            <span>PT. Karya Putra Sangkuriang</span><br>
            <span>BON PERMINTAAN</span><br>
            BOM SPBU 34. ..
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            No. <label><?=$data->VOUCHER_BBM?></label>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            No SPJ
          </div>
          <div class="col-1">:</div>
          <div class="col-7"><label><?=$data->NO_SPJ?></label></div>
        </div>
        <div class="row">
          <div class="col-4">
            Tanggal
          </div>
          <div class="col-1">:</div>
          <div class="col-7"><label><?=$data->TGL_SPJ?></label></div>
        </div>
        <div class="row">
          <div class="col-4">
            No. Mobil
          </div>
          <div class="col-1">:</div>
          <div class="col-7"><label><?=$data->NO_TNKB?></label></div>
        </div>
        <div class="row">
          <div class="col-4">
            Sopir
          </div>
          <div class="col-1">:</div>
          <div class="col-7"><label><?=$data->PIC_DRIVER?></label></div>
        </div>
        <div class="row">
          <div class="col-4">
            KM
          </div>
          <div class="col-1">:</div>
          <div class="col-6" style="border-bottom: thin dotted;"></div>
        </div>
        <div class="row">
          <div class="col-4">
            Banyaknya
          </div>
          <div class="col-1">:</div>
          <div class="col-5" style="border-bottom: thin dotted;"></div>
          <div class="col-2 text-left">Liter</div>
        </div>
        <div class="row">
          <div class="col-4">
            Jenis BBM
          </div>
          <div class="col-1">:</div>
          <div class="col-6" style="border-bottom: thin dotted;"></div>
        </div>
        <br>
        <div class="row">
          <div class="col-4 text-center">
            <div class="row">
              <div class="col-12">
                Sopir
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-6 text-left">(</div>
              <div class="col-6 text-right">)</div>
            </div>
          </div>
          <div class="col-4 text-center">
            <div class="row">
              <div class="col-12">
                TTD SPBU
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-6 text-left">(</div>
              <div class="col-6 text-right">)</div>
            </div>
          </div>
          <div class="col-4 text-center">
            <div class="row">
              <div class="col-12">
                Diketahui
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-6 text-left">(</div>
              <div class="col-6 text-right">)</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
    window.print();
  })
  var lama = 1000;
  t = null;
  function printOut(){
      window.print();
      t = setTimeout("self.close()",lama);
  }
  
</script>
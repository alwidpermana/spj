
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
    body{
      font-size: 16px !important
    }
  </style>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
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
            <H3 class="page-header" style="padding: 25px 0;">GENERATE SURAT PERINTAH PERJALANAN DINAS (SPPD)</H3>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="row">
          <div class="col-md-6 text-right">
            
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
                <th>Keuangan</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="row">
      <div class="col-6">
        <div class="row invoice-info">
          <div class="col-3">
            <label>Jenis SPJ</label>
          </div>
          <div class="col-9">
            : <?=$master->NAMA_JENIS?>
          </div>
        </div>
        <div class="row invoice-info">
          <div class="col-3">
            <label>Jumlah SPJ</label>
          </div>
          <div class="col-9">
            : <?=$master->JML_SPJ?>
          </div>
        </div>
        
        <div class="row invoice-info">
          <div class="col-3">
            <label>No Generate</label>
          </div>
          <div class="col-9">
            : <?=$master->NO_GENERATE?>
          </div>
        </div> 
        <div class="row invoice-info">
          <div class="col-3">
            <label>Tanggal Generate</label>
          </div>
          <div class="col-9">
            : <?=date("d F Y", strtotime($master->TGL_GENERATE))?>
          </div>
        </div> 
      </div>
      <div class="col-6">
        <div class="row invoice-info">
          <div class="col-3">
            <label>Total Rp</label>
          </div>
          <div class="col-9">
            : <?=number_format($master->TOTAL_RP)?>
          </div>
        </div>
        <div class="row invoice-info">
          <div class="col-3">
            <label>SPJ</label>
          </div>
          <div class="col-9">
            : <?=number_format($master->RP_SPJ)?>
          </div>
        </div>
        <div class="row invoice-info">
          <div class="col-3">
            <label>BBM</label>
          </div>
          <div class="col-9">
            : <?=number_format($master->RP_BBM)?>
          </div>
        </div>
        <div class="row invoice-info">
          <div class="col-3">
            <label>TOL</label>
          </div>
          <div class="col-9">
            : <?=number_format($master->RP_TOL)?>
          </div>
        </div>  
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-6">
        <?php if (count($ganjil)>0): ?>
          <table class="tableTest" border="1" width="100%">
            <thead class="text-center">
              <tr>
                <th>No</th>
                <th>Tanggal SPJ</th>
                <th>No SPJ</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php foreach ($ganjil as $gj): ?>
                <tr>
                  <td><?=$gj->NO_URUT?></td>
                  <td><?=date("d F Y", strtotime($gj->TGL_SPJ))?></td>
                  <td><?=$gj->NO_SPJ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>    
        <?php endif ?>
      </div>
      <div class="col-6">
        <?php if (count($genap)>0): ?>
          <table class="tableTest" border="1" width="100%">
            <thead class="text-center">
              <tr>
                <th>No</th>
                <th>Tanggal SPJ</th>
                <th>No SPJ</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php foreach ($genap as $gp): ?>
                <tr>
                  <td><?=$gp->NO_URUT?></td>
                  <td><?=date("d F Y", strtotime($gp->TGL_SPJ))?></td>
                  <td><?=$gp->NO_SPJ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>    
        <?php endif ?>
      </div>
    </div>
    
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

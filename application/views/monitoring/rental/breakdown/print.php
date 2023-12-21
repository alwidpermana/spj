
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
  </style>
</head>
<body onload="printOut()">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
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
        <H3 class="page-header">Breakdown Pemakaian Kendaraan Rental</H3>
      </div>
    </div>
    <br>
    <div class="row mt-5 invoice-info">
      <div class="col-md-2">Rekanan</div>
      <div class="col-md-7">: <?=$rekanan?></div>
    </div>
    <div class="row invoice-info">
      <div class="col-md-2">Periode</div>
      <div class="col-md-7">: <?=$mulai?> s/d <?=$selesai?></div>
    </div>
    <div class="row mt-5">
      <div class="col-12">
        <table class="tableTest text-center" width="100%" border="1">
          <thead class="text-center">
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">Tanggal</th>
              <th rowspan="2">Kendaraan</th>
              <th rowspan="2">Jenis Kendaraan</th>
              <th rowspan="2">Merk</th>
              <th rowspan="2">Type</th>
              <th rowspan="2">No TNKB</th>
              <th rowspan="2">Tahun</th>
              <th colspan="2">SPJ</th>
              <th colspan="2">Tujuan</th>
              <th colspan="2">Sopir</th>
              <th colspan="2">Kenek</th>
            </tr>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Group</th>
              <th>Tujuan</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>NIK</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            foreach ($data as $key): ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=date("d-m-Y", strtotime($key->TGL_SPJ))?></td>
                <td><?=$key->Kendaraan?></td>
                <td><?=$key->JenisKendaraan?></td>
                <td><?=$key->Merk?></td>
                <td><?=$key->Type?></td>
                <td><?=$key->NoTNKB?></td>
                <td><?=$key->Tahun?></td>
                <td><?=$key->NO_SPJ?></td>
                <td><?=date("d-m-Y", strtotime($key->TGL_SPJ))?></td>
                <td><?=$key->NAMA_GROUP?></td>
                <td></td>
                <td><?=$key->NIK?></td>
                <td><?=$key->NAMA?></td>
                <td><?=$key->NIK_PENDAMPING?></td>
                <td><?=$key->NAMA_PENDAMPING?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
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

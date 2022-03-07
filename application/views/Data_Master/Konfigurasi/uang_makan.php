<div class="row">
  <div class="col-md-12">
    <table class="table table-hover table-striped table-bordered">
      <thead class="text-center">
        <tr>
          <th rowspan="3">Tujuan</th>
          <th colspan="2">Delivery</th>
          <th colspan="2">Non Delivery</th>
        </tr>
        <tr>
          <th>Uang Makan</th>
          <th>Makan Ke 2</th>
          <th>Uang Makan</th>
          <th>Makan Ke 2</th>
        </tr>
        <tr>
          <td>Jam 11.00-13.00</td>
          <td>Jam 19.00-21.00</td>
          <td>Jam 11.00-13.00</td>
          <td>Jam 19.00-21.00</td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key): ?>
          <tr>
            <td><?=$key->JENIS_GROUP?></td>
            <td><input type="number" class="form-control form-control-sm inputMakan" step="1" jenis="<?=$key->ID1?>" grup = '<?=$key->JENIS_GROUP?>' ke="<?=$key->KE1?>" value="<?=$key->BIAYA1?>"></td>
            <td><input type="number" class="form-control form-control-sm inputMakan" step="1" jenis="<?=$key->ID2?>" grup = '<?=$key->JENIS_GROUP?>' ke="<?=$key->KE2?>" value="<?=$key->BIAYA2?>"></td>
            <td><input type="number" class="form-control form-control-sm inputMakan" step="1" jenis="<?=$key->ID3?>" grup = '<?=$key->JENIS_GROUP?>' ke="<?=$key->KE3?>" value="<?=$key->BIAYA3?>"></td>
            <td><input type="number" class="form-control form-control-sm inputMakan" step="1" jenis="<?=$key->ID4?>" grup = '<?=$key->JENIS_GROUP?>' ke="<?=$key->KE4?>" value="<?=$key->BIAYA4?>"></td>
          </tr>
        <?php endforeach ?>
        
      </tbody>
    </table>
  </div>
</div>
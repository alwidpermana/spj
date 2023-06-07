<table class="table table-hover table-striped table-bordered">
  <thead class="text-center">
    <tr>
      <th rowspan="3">Tujuan</th>
      <th colspan="2"><?=$jenis?></th>
    </tr>
    <tr>
      <th>Uang Makan</th>
      <th>Makan Ke 2</th>
    </tr>
    <tr>
      <td>Jam 11.00-13.00</td>
      <td>Jam 19.00-21.00</td>
    </tr>
  </thead>
  <tbody class="text-center">
    <?php if ($jenis == 'Non Delivery'): ?>
      <tr>
        <td>Lokal</td>
        <td>20,000</td>
        <td></td>
      </tr>
      <tr>
        <td>Lokal (Solokan Jeruk & Pandawa 5)</td>
        <td>10,000</td>
        <td></td>
      </tr>
    <?php endif ?>
    <?php foreach ($data as $key): ?>
      <tr>
        <td><?=$key->JENIS_GROUP?></td>
        <?php if ($jenis == 'Delivery'): ?>
          <td><?=number_format($key->BIAYA1)?></td>
          <td><?=number_format($key->BIAYA2)?></td>
        <?php else: ?>
          <td><?=number_format($key->BIAYA3)?></td>
          <td><?=number_format($key->BIAYA4)?></td>
        <?php endif ?>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
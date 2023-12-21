
<!DOCTYPE html>
<html lang="en">
<head>
  <style type="text/css">
   @media print {
	  @page {
	    /* For different margins – use the standard CSS margin property: north, east, south, west, here it is one value */
	    margin: 0px 15px 0px 15px;
	    /* Browser default, customisable by the user if using the print dialogue. */
	    size: auto;

	    /* Default, In my instance of Edge, this is a vertical or horizontal A4 format, but you might find something different depending on your locale. */
	    size: portrait;
	  }
	  body { margin: 10px; }
	}
    .tabel-voucher{
    	width: 100%;
    	font-size: 11pt;
    	text-align: left;
    	font-family: arial;
    }
  </style>
</head>
<body onload="printOut()">
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
</body>
</html>
<script type="text/javascript">
  window.print();
  $(document).ready(function(){
    window.print();
  })
  var lama = 1000;
  t = null;
  function printOut(){
      window.print();
      t = setTimeout('self.close()',lama);
  }
  
</script>
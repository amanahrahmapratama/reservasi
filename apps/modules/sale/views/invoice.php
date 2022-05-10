<html>
<head>
	<title>APPLICATION</title>
	<style rel="stylesheet" type="text/css">
		.satu {
			padding-top: 50px;
		}
		.satu table, th, td {
			border-collapse: collapse;
		}
		.satu th, td {
			padding: 0px 15px 15px;
		}
		.dua td {
			border: none;
		}
	</style>
</head>
<body>
	<img src="<?php echo base_url('media/image/header_invoice.png') ?>" width="100%">
	<div class="satu">
		<table style="width:60%">
			<tr>
				<td>No. Invoice</td>
				<td>:</td>		
				<td><?php echo $master['sale_inv_num']; ?></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>		
				<td><?php echo pretty_date($master['sale_date']); ?></td>
			</tr>
		</table>
	</div>
	<hr>
	<div class="dua">
		<table style="width:100%">
			<tr style="background-color:#f7f7f9; padding:50px 0px 10px;">
				<td>NO</td>
				<td>NAMA BARANG</td>
				<td>JUMLAH</td>
				<td>HARGA SATUAN</td>
				<td>TOTAL</td>
			</tr>
			<?php $total = 0 ?>
			<?php $i=1; foreach ($item as $row): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['catalog_name']; ?></td>
				<td><?php echo $row['sale_count']; ?></td>
				<td><?php echo $row['sale_price']; ?></td>
				<td><?php echo ($row['sale_count'] * $row['sale_price']); ?></td>
			</tr>
			<?php $total += $row['sale_total_price'] ?>
			<?php $i++; endforeach; ?>
			<tr style="border-top: 1px solid #000;">
				<td></td>
				<td></td>
				<td></td>
				<td><b>Total:</b></td>
				<td><b><?php echo $total; ?></b></td>
			</tr>
		</table>
	</div>
	<div class="satu">
		<table style="width:60%">
			<tr>
				<td>Kurir</td>
				<td>:</td>		
				<td><?php echo $master['sale_courier']; ?></td>
			</tr>
			<tr>
				<td>Layanan</td>
				<td>:</td>		
				<td><?php echo $master['sale_courier_service']; ?></td>
			</tr>
			<tr>
				<td>Ongkos Kirim</td>
				<td>:</td>		
				<td><?php echo $master['sale_ongkir']; ?></td>
			</tr>
			<tr>
				<td><strong>Total</strong></td>
				<td>:</td>		
				<td><strong><?php echo $master['sale_ongkir'] + $total ; ?></strong></td>
			</tr>
		</table>
	</div>
	<div class="satu">
		<table style="width:60%">
			<tr>
				<td>Alamat Tujuan</td>
				<td>:</td>		
				<td>
					<?php echo $master['sale_recipient_name']; ?>
					<br>
					<?php echo $master['sale_shipping_address']; ?>

				</td>
			</tr>
		</table>
	</div>
</body>
</html>
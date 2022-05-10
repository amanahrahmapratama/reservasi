Halo <?php echo $nama ?>
<br>
<p>
	Kami informasikan kepada anda bahwa anda baru saja melakukan reservasi ruangan dengan data sebagai berikut :
</p>
<table width="100%">
	<tr>
		<td width="20%">Nama Pemesan</td>
		<td>: <?php echo $nama ?></td>
	</tr>
	<tr>
		<td width="20%">Nama Ruangan</td>
		<td>: <?php echo $nama_ruangan ?></td>
	</tr>
	<tr>
		<td width="20%">Tanggal</td>
		<td>: <?php echo pretty_date($date_start, 'd F Y', false) . ' s.d ' . pretty_date($date_end, 'd F Y', false) ?></td>
	</tr>
	<tr>
		<td width="20%">Jenis Kegiatan</td>
		<td>: <?php echo $type ?></td>
	</tr>
	<tr>
		<td width="20%">Estimasi Peserta</td>
		<td>: <?php echo $estimasi_peserta . ' Orang' ?></td>
	</tr>
</table>

<p>
	Permintaan anda sedang kami proses. Terima kasih.
</p>

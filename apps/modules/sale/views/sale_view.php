<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">

			<div class="grid-body no-border">
				<h3 class="page-header">
					<?php echo $title; ?>
					<span class=" pull-right">
						<a href="<?php echo site_url('admin/sale') ?>" class="btn btn-info"><span class="ion-arrow-left-a"></span>&nbsp; Kembali</a> 
						<a target="_blank" href="<?php echo site_url('admin/sale/invoice/' . $sale['sale_id']) ?>" class="btn btn-primary"><span class="ion-printer"></span>&nbsp; Invoice</a> 
						<?php 
						$arr_status = array(STATUS_NEW, STATUS_WAITING_PAYMENT, STATUS_WAITING_PAYMENT_CONFIRMATION);
						if (in_array($sale['sale_status_sale_status_id'], $arr_status)): 
							?>
							<button class="btn btn-success" data-toggle="modal" data-target="#myForm"><span class="ion-pricetags"></span>&nbsp; Form</button> 
							<a href="<?php echo site_url('admin/sale/edit/' . $sale['sale_id']) ?>" class="btn btn-warning"><span class="ion-edit"></span>&nbsp; Edit</a> 
						<?php endif ?>
						<?php if ($sale['sale_status_sale_status_id'] == 3): ?>
							<button  class="btn btn-danger" id="confirm">Konfirmasi</button>
						<?php endif ?>
						<?php if ($sale['sale_status_sale_status_id'] == STATUS_PAYMENT_CONFIRMED): ?>
							<button  class="btn btn-success" id="tracking_id">Kirim Tracking ID</button>
						<?php endif ?>
					</span>
				</h3>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td>invoice</td>
										<td>:</td>
										<td><?php echo $sale['sale_inv_num']; ?></td>
									</tr>
									<tr>
										<td>Tanggal Penjualan</td>
										<td>:</td>
										<td><?php echo pretty_date($sale['sale_date'], 'l, d/m/Y', FALSE); ?></td>
									</tr>
									<tr>
										<td>Status</td>
										<td>:</td>
										<td><?php echo $sale['sale_status_name'] ?></td>
									</tr>
									<tr>
										<td>Pelanggan</td>
										<td>:</td>
										<td><?php echo $sale['customer_full_name'] . '('.$sale['customer_email'].')' ?></td>
									</tr>
									<tr>
										<td>Metode Pengiriman</td>
										<td>:</td>
										<td><?php echo $sale['sale_courier'] ?></td>
									</tr>
									<tr>
										<td>Jenis Layanan</td>
										<td>:</td>
										<td><?php echo $sale['sale_courier_service'] ?></td>
									</tr>
									<tr>
										<td>Ongkos Kirim</td>
										<td>:</td>
										<td>
											<?php if ($sale['sale_ongkir'] == NULL): ?>
												<?php echo form_open(current_url()) ?>
												<div class="form-group <?php echo validation_errors() ? 'has-error' : '' ?>">
													<input type="hidden" name="setOngkir" value="1">
													<input type="hidden" name="sale_id" value="<?php echo $sale['sale_id'] ?>">
													<input type="text" name="sale_ongkir" class="form-control" placeholder="Input ongkos kirim" required>
													<span class="help-block">Angka harus desimal. Contoh: 5000 > input 5000.0</span>
													<span class="help-block">
														<?php echo form_error('sale_ongkir') ?>
													</span>
												</div>
												<button type="submit" class="btn btn-primary">Submit</button>
											<?php else: ?>
												<?php echo idr_format($sale['sale_ongkir']) ?>
											<?php endif ?>	
										</td>
									</tr>
									<tr>
										<td>Provinsi</td>
										<td>:</td>
										<td><?php echo $sale['sale_province'] ?></td>
									</tr>
									<tr>
										<td>Kabupaten</td>
										<td>:</td>
										<td><?php echo $sale['sale_kabupaten'] ?></td>
									</tr>
									<tr>
										<td>Alamat Lengkap</td>
										<td>:</td>
										<td><?php echo $sale['sale_shipping_address'] ?></td>
									</tr>
									<tr>
										<td>Kode Pos</td>
										<td>:</td>
										<td><?php echo $sale['sale_postal_code'] ?></td>
									</tr>
									<?php if ($sale['sale_status_sale_status_id'] == STATUS_WAITING_PAYMENT_CONFIRMATION OR $sale['sale_status_sale_status_id'] == STATUS_SHIPPED): ?>
										<tr>
											<td>Nama Pemilik Rekening</td>
											<td>:</td>
											<td>
												<?php echo $sale['sale_transfer_name'] ?>
											</td>
										</tr>
										<tr>
											<td>Tanggal Transfer</td>
											<td>:</td>
											<td>
												<?php echo pretty_date($sale['sale_transfer_date']) ?>
											</td>
										</tr>
										<tr>
											<td>Bukti Transfer</td>
											<td>:</td>
											<td>
												<a target="_blank" href="<?php echo upload_url($sale['sale_transfer_image']) ?>"><?php echo $sale['sale_transfer_image'] ?></a>
											</td>
										</tr>
									<?php endif ?>
									<tr>
										<td>Tanggal input</td>
										<td>:</td>
										<td><?php echo pretty_date($sale['sale_created_date']) ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<?php if (isset($item)): ?>
							<a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#detailSale" aria-expanded="false" aria-controls="detailSale">
								<i class="ion-arrow-down-a"></i> Lihat Detail Penjualan
							</a>    
							<hr>
							<div class="row collapse" id="detailSale" >
								<div class="col-md-12">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>NO</th>
												<th>NAMA BARANG</th>
												<th>JUMLAH</th>
												<th>HARGA SATUAN</th>
												<th>TOTAL</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$weight = 0;
											$i = 1;
											foreach ($item as $row):
												?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $row['catalog_name']; ?></td>
													<td><?php echo $row['sale_count']; ?></td>
													<td><?php echo idr_format($row['sale_price']); ?></td>
													<td><?php echo idr_format($row['sale_total_price']); ?></td>
												</tr>
												<?php
												$i++;
												$weight += ($row['catalog_weight'] * $row['sale_count']);
											endforeach;
											?>
											<tr style="border-top: 1px solid #000;">
												<td></td>
												<td></td>
												<td></td>
												<td><b>Total:</b></td>
												<td><b><?php echo idr_format($sale['sale_total_price']); ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<br>
							<?php if ($sale['sale_courier'] == '' OR $sale['sale_shipping_address'] == ''): ?>
								<div class="panel panel-default clearfix">
									<div class="panel-heading">
										<h3 class="panel-title roboto">Data Pengiriman</h3>
									</div>
									<div class="panel-body">
										<?php echo validation_errors() ?>
										<?php echo form_open(current_url()); ?>
										<input type="hidden" name="checkout" value="1">
										<div class="row grid-divider">
											<div class="col-sm-8">
												<div class="col-padding">
													<div class="row">
														<div class="col-xs-12">
															<address>
																<div class="row">
																	<input type="hidden" name="checkout" value="1">
																	<div class="panel">
																		<div class="panel-body">
																			<div class="row">
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="rut">Nama Penerima<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<input class="form-control" name="inputName" type="text" oninvalid="this.setCustomValidity('Nama Penerima Wajib Diisi')" oninput="setCustomValidity('')" class="form-control rut" id="rut" name="rut" value="<?php echo set_value('inputName') ?>" placeholder="Nama Penerima" required="required">
																						<p></p>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="rut">No HP Penerima<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<input type="text" oninvalid="this.setCustomValidity('No HP Wajib Diisi')" oninput="setCustomValidity('')" class="form-control rut" id="rut" name="inputPhone" value="<?php echo set_value('inputPhone') ?>" placeholder="Nomor Handphone" required="required"><p></p>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="textinput">Provinsi<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<div id="showProv">
																							<select name="inputProvince" id="showProv" class="form-control"></select>
																						</div>
																						<p></p>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="textinput">Kabupaten<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<select name="inputKabupaten" class="form-control" name="inputKabupaten" id="showKab">
																							<option value="">Pilih Kabupaten</option>
																						</select>
																						<p></p>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="name">Alamat<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<textarea class="form-control" name="inputAddress" oninvalid="this.setCustomValidity('Input No Alamat Wajib Diisi')" oninput="setCustomValidity('')" required="" placeholder="Alamat"><?php echo set_value('inputName') ?></textarea>
																						<p></p>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-4 control-label" for="textinput">Kode Pos<span class="requerido"> *</span></label>
																					<div class="col-md-8">
																						<input type="text" oninvalid="this.setCustomValidity('Input Code Pos')" oninput="setCustomValidity('')" class="form-control rut" id="rut" name="inputPostCode" value="<?php echo set_value('inputPostCode') ?>" placeholder="Kode Pos" required="required"><p></p>
																					</div>
																				</div>

																			</div>
																		</div>
																	</div>
																</div>
															</address>
														</div>
													</div>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="col-padding">
													<div class="col-xs-12">
														<address>
															<strong class="text-success"><h4>Pilih Pengiriman</h4></strong>
															<select id="courier" name="inputCourier" onchange="getOngkir(this.value)" class="form-control">
																<option value="">Pilih Kurir</option>
																<option value="jne">JNE</option>
																<option value="tiki">TIKI</option>
																<option value="pos">POS</option>
															</select>
														</address>

														<address class="hide" id="showCourierType">
															<strong class="text-success"><h4>Pilih Jenis Layanan</h4></strong>
															<select id="courierType" name="inputService" class="form-control">
																<option value="">Pilih Jenis Layanan</option>
															</select>
														</address>
														<address>
															<input type="hidden" name="inputOngkir" id="inputOngkir" class="form-control">
															<input type="hidden" name="inputService" id="inputService" class="form-control">
															<strong class="text-success"><h4>Ongkos Kirim</h4></strong>
															<div class="alert alert-info">
																<p><span id="ongkir">Rp 0</span></p>
															</div>
														</address>
														<hr>
														<address>
															<strong class="text-success"><h4>Subtotal</h4></strong>
															<div class="alert alert-warning">
																<p><span id="subtotal"></span></p>
															</div>
														</address>
														<button class="btn btn-success btn-block" id="checkout"><i class="glyphicon glyphicon-check"></i> Simpan</button>
													</div>
												</div>
											</div>
										</div>
										<?php echo form_close(); ?>
									</div>
								</div>
							<?php endif ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Form Penjualan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12" id="form">
						<div class="row">
							<div class="col-md-12">
								<?php echo form_open('admin/sale/form/' . $sale['sale_id']) ?>
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-3">
												<label>Nama Barang</label>
												<input type="text" id="namaBarang" class="form-control">
												<input type="hidden" id="idBarang" class="form-control">
											</div>
											<div class="col-md-3">
												<div class="row">
													<div class="col-md-8">
														<label>Jumlah</label>
														<input type="text" id="jmlBarang" class="form-control">
													</div>
													<div class="col-md-4">
														<label>Stock</label>
														<input type="text" id="stockBarang" class="form-control" disabled>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label>Harga Barang</label>
												<input type="text" id="hargaBarang" class="form-control">
											</div>
											<div class="col-md-3">
												<label>Total</label>
												<input type="text" id="totalBarang" readonly="true" class="form-control">
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<br>
												<table class="table table-condensed">
													<thead>
														<th class="head">Nama Barang</th>
														<th class="head">Jumlah</th>
														<th class="head">Harga</th>
														<th class="head">Total</th>
														<th class="head">Hapus</th>
													</thead>
													<tbody id="showResult">
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<br>
												<span class="btn btn-primary pull-right" id="btnSimpan">Simpan</button>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-12">
													<div class="col-md-6 pull-right">
														<div class="row">
															<div class="col-md-4">
																<label>Total</label>
															</div>
															<div class="col-md-8 pull-right">
																<input type="text" id="totalPrice" readonly name="total_price" class="form-control">
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div><br>

									<div class="row">
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-4 pull-right" >
														<input type="submit" class="col-md-12 btn btn-primary" value="Simpan">
													</div>
													<div class="col-md-2" >
														<button class="col-md-12 btn btn-info" id="batal" data-dismiss="modal"><i class="ion-arrow-left-a"></i> Batal</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="conf_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<?php echo form_open(current_url()); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Konfirmasi Pembayaran</h4>
				</div>
				<div class="modal-body">
					<div id="showAlert"></div>
					<input type="hidden" name="confirming" value="1" class="form-control">
					<label>Masukkan password anda</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>

	<?php if ($show_modal_confirmation): ?>
		<script type="text/javascript">
			$(document).ready(function() {
				showModal();

				function showModal(){
					$("#conf_modal").modal('show');

					var alertError = "<div class='alert alert-danger'>Password Salah</div>";
					$("#showAlert").html(alertError);
				}

			});
		</script>
	<?php endif ?>


	<div class="modal fade" id="tracking_id_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<?php echo form_open(current_url()); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Kirim Tracking ID</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="tracking" value="1" class="form-control">
					<label>Tracking ID</label>
					<input type="text" name="tracking_id" class="form-control">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>


	<script>

		var ONGKIRURL = "<?php echo $this->config->item('ongkir_url') ?>";
		var subtotal = <?php echo $sale['sale_total_price']; ?>

		$(document).bind("change propertychange keyup keydown", function(){
			var hargaBarang = $("#hargaBarang").val();
			var jmlBarang = $("#jmlBarang").val();

			$("#totalBarang").val(hargaBarang * jmlBarang);
		});

		$("#namaBarang").autocomplete({
			source: 
			function(req, add){  
				$.ajax({  
					url: "<?php echo site_url('admin/catalog/getCatalogJson') ?>",  
					dataType: 'json',  
					type: 'POST',  
					data: {
						"<?php echo $this->security->get_csrf_token_name() ?>" : "<?php echo $this->security->get_csrf_hash() ?>",
						term: req
					},  
					success:      
					function(data) {
						add(data);
					},  
				});  
			},  
			minLength: 1,
			appendTo: "#myForm",
			select: function( event, ui ) {
				var hargaBarangAc = ui.item.catalog_buying_price;

				$("#hargaBarang").val(ui.item.catalog_buying_price);
				$("#jmlBarang").val(1);
				$("#stockBarang").val(ui.item.catalog_virtual_stock);
				$("#idBarang").val(ui.item.id);
				$("#totalBarang").val(hargaBarangAc);
			},

		}); 

		var arrBarang = [];

		$("#btnSimpan").click(function(){

			pushArray();

			$("#namaBarang").val('');
			$("#hargaBarang").val('');
			$("#jmlBarang").val('');
			$("#idBarang").val('');
			$("#totalBarang").val('');            
		});

		function pushArray(){

			var namaBarang = $("#namaBarang").val();
			var idBarang = $("#idBarang").val();
			var jmlBarang = $("#jmlBarang").val();
			var hargaBarang = $("#hargaBarang").val();
			var totalBarang = $("#totalBarang").val();

			if (idBarang != '' && jmlBarang != '' && totalBarang != '') {

				var newArr = {
					'namaBarang' : namaBarang, 
					'id_barang' : idBarang, 
					'jmlBarang' : jmlBarang,
					'hargaBarang' : hargaBarang,
					'totalBarang' : totalBarang
				};

				arrBarang.push(newArr);
				result(arrBarang);
			};
		};

		function result(arrBarang) {
			var totalPrice = 0;
			var html = "";
			for (var i = 0; i < arrBarang.length; i++) {
				html += "<tr>";
				html += "<td>"+ arrBarang[i]['namaBarang'] +"</td>";
				html += "<td>"+ arrBarang[i]['jmlBarang'] +"</td>";
				html += "<td>"+ arrBarang[i]['hargaBarang'] +"</td>";
				html += "<td>"+ arrBarang[i]['totalBarang'] +"</td>";
				html += "<td>";
				html += "<button onclick='removeNode("+i+")'>x</button>"
				html += "<input type='hidden' name='catalog_id[]' value='"+ arrBarang[i]['id_barang'] +"'> ";
				html += "<input type='hidden' name='qty[]' value='"+ arrBarang[i]['jmlBarang'] +"'> ";
				html += "<input type='hidden' name='item_price[]' value='"+ arrBarang[i]['hargaBarang'] +"'> ";
				html += "<input type='hidden' name='price[]' value='"+ arrBarang[i]['totalBarang'] +"'> ";
				html += "</td>";
				html += "</tr>";

				var parsetInteger = parseInt(arrBarang[i]['totalBarang']);
				totalPrice = totalPrice + parsetInteger;
			};
			
			$("#totalPrice").val(totalPrice);
			$("#showResult").html(html);
		};

		function removeNode(arrIndex){
			arrBarang.splice(arrIndex, 1);
			result(arrBarang);
		}


		$("#price1, #qty1").keyup(function() {
			var value = $("#price1").val() * $("#qty1").val();

			$("#total1").val(value);
		})
		.keyup();

		$(function() {
			var scntDiv = $('#p_scents');
			var scntAdd = $('#form');
			var i = $('#p_scents tr').size() + 1;

			$("#addScnt").click(function() {
				$('<tr><td width="6%"><input class="form-control" readonly value="' + i + '" type="text" name="number"></td><td><select name="catalog_id[]" class="form-control"><option>-- Pilih Barang --</option><?php foreach ($catalog as $row): ?><option value="<?php echo $row['catalog_id'] ?>" ><?php echo $row['catalog_name'] ?></option><?php endforeach; ?></select></td><td><input class="form-control" type="text" id="qty' + i + '" name="qty[]"></td><td><input class="form-control" type="text" id="price' + i + '" name="item_price[]"></td><td><input class="form-control jml" type="text" id="total' + i + '" name="price[]" value="" readonly></td><td><a href="#" class="remScnt"><span class="ion-minus-circled"></span></a></td></tr>').appendTo(scntDiv),
				$('<script>$("#price' + i + ', #qty' + i + '").keyup(function () { \n\
					var value = $("#price' + i + '").val() * $("#qty' + i + '").val();\n\
					$("#total' + i + '").val(value);\n\
				}).keyup(); </' + 'script>').appendTo(scntAdd);
				i++;
				return false;
			});

			$(document).on("click", ".remScnt", function() {
				if (i > 2) {
					$(this).parents('tr').remove();
					i--;
				}
				return false;
			});

			$(document).bind("change keyup focus input propertychange", function() {
				var sum = 0;
				$(".jml").each(function() {
					sum += +$(this).val();
				});
				var change = $("#cash").val() - $("#total").val();


				var total = sum
				$("#total").val(total);
				$("#change").val(change);
			});

		});

		$("#confirm").click(function(){
			$("#conf_modal").modal('show');
		})

		$("#tracking_id").click(function(){
			$("#tracking_id_modal").modal('show');
		})

		$("#jmlBarang").bind('propertychange keydown keypress keyup', function(){
			var newQty = $(this);
			var lastStock = $("#stockBarang").val();
			
			if (parseInt(newQty.val()) > lastStock) {
				newQty.val(lastStock);
			}

			if (parseInt(newQty.val()) === 0) {
				newQty.val(1);
			}
		});


		$(document).ready(function(){
			showAllProv();
			$("#subtotal").text(subtotal)
		});


		function showAllProv(){
			$.ajax({
				url: ONGKIRURL + '/wilayah/province/get' ,
				type: 'GET'
			})
			.done(function(data) {
				data = $.parseJSON(data)

				var res_html = '';
				var obj = data['rajaongkir']['results'];

				res_html += '<select class="form-control" name="inputProvince" onchange="getKab(this.value)">';
				res_html += '<option value="">Pilih Provinsi</option>';
				for (var key in obj){
					res_html += '<option value="' + obj[key]['province_id'] + '-' + obj[key]['province'] + '">' + obj[key]['province'] + '</option>';
				}
				res_html +=	'</select>';

				$("#showProv").html(res_html);
			});
		}

		function getKab(provId){

			var res = provId.split(' ');
			provId = res[0];

			$.ajax({
				url: ONGKIRURL + "/wilayah/kabupaten/get",
				method: "POST",
				data: {
					province: provId
				},
				success: function(data){

					data = $.parseJSON(data)

					var obj = data['rajaongkir']['results'];

					var html = "<select class='form-control' name='inputKabupaten' id='showKab'>";
					html += "<option value=''>Pilih Kabupaten</option>";
					jQuery.each(obj, function(index, value){
						html += "<option value='" + value['city_id'] + '-' + value['city_name'] + "'>" + value['city_name'] + "</option>";

					})
					html += "</select>";

					$("#showKab").html(html)
				}

			})
		}

		function getOngkir(kurir){


			var destination = $("#showKab").val();
			var weight = <?php echo $weight ?>;
			var origin = 153;

			if (destination == '' || kurir == '') {
				showNotify('Anda harus pilih kurir dan tujuan pengiriman');
				return false;
			};

			$.ajax({
				url: ONGKIRURL + '/costs/',
				type: 'POST',
				data: {
					origin : origin,
					destination: destination,
					weight: weight,
					courier: kurir
				},
			})
			.done(function(data) {
				$("#showCourierType").removeClass('hide');
				data = $.parseJSON(data);
				var res_html = '';
				var obj = data['rajaongkir']['results'][0]['costs'];

				SERVICE = obj;

				res_html += '<select class="form-control" name="" onchange="showOngkir(this.value)">';
				res_html += '<option value="">Pilih Jenis Layanan</option>';
				for (var key in obj){
					res_html += '<option value="'+ key + '-' +  obj[key]['service'] +'">' + obj[key]['description'] + ' (' + obj[key]['service'] + ')' + '</option>';
				}
				res_html +=	'</select>';

				$("#ongkir").html(0);
				$("#showCourierType").html(res_html);
			});

		}

		function showOngkir(index){
			var res = index.split("-");
			$("#ongkir").html(SERVICE[res[0]]['cost'][0]['value']);
			$("#subtotal").text(SERVICE[res[0]]['cost'][0]['value'] + subtotal);
			$("#inputOngkir").val(SERVICE[res[0]]['cost'][0]['value']);
			$("#inputService").val(res[1]);
		}

	</script>

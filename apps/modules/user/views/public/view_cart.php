<div class="container">
	<ul class="breadcrumbs">
		<li class="breadcrumbs__item">
			<a href="<?php echo site_url() ?>" class="breadcrumbs__url">Home</a>
		</li>
		<li class="breadcrumbs__item breadcrumbs__item--current">
			<?php echo $title; ?>
		</li>
	</ul>
</div>

<div class="main-container container" id="main-container">
	<div class="blog__content mb-72">
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->load->view('templates/groot/sidebar') ?>
			</div>
			<div class="col-md-9">
				<h3 class="page-title"><?php echo $title; ?></h3>
				<?php echo form_open(current_url()); ?>
				<div class="table-responsive">
					<table class="table">
						<thead class="thead-light">
							<tr>
								<th>Qty</th>
								<th>Nama Barang</th>
								<th>Stok</th>
								<th>Berat</th>
								<th>Harga</th>
								<th>Subtotal</th>
								<th>Hapus</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1; 
							$weight = 0;
							?>
							<?php foreach ($this->cart->contents() as $items): ?>
								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
								<tr>
									<td data-th="Qty">
										<?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'min' => '1', 'class' => 'form-control', 'type' => 'number', 'max' => $items['options']['stock'])); ?>
									</td>
									<td data-th="Nama Barang"><?php echo $items['name']; ?></td>
									<td><?php echo $items['options']['stock']; ?> </td>
									<td><?php echo $items['options']['weight']; ?> gr</td>
									<td>Rp <?php echo $this->cart->format_number($items['price']); ?></td>
									<td>Rp <?php echo $this->cart->format_number($items['price'] * $items['qty'])  ; ?></td>
									<td>
										<a class="btn btn-sm btn-dark" href="?id=<?php echo $items['rowid'] ?>&count=0" type="reset"><span>x</span></a>
									</td>
								</tr>

								<?php 
								$i++;
								$weight_per_item = $items['options']['weight'];
								$weight += ($weight_per_item * $items['qty']);
								$weight_in_kg = ceil($weight/1000);
								?>

							<?php endforeach; ?>
							<?php if ($this->cart->total_items() == 0): ?>
								<tr>
									<td colspan="7" class="success">Keranjang belanja kosong</td>
								</tr>
							<?php endif ?>
							<?php if ($this->cart->total_items() > 0): ?>
								<tr>
									<td colspan="5"><h4><strong class="text-primary">Total</strong></h4></td>
									<td colspan="2"><h4><strong class="text-danger"><?php echo idr_format($this->cart->total()); ?></strong></h4></td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-md-3">
						<a href="<?php echo site_url('catalog') ?>" class="btn btn-lg btn-color">
							<span>Lanjutkan belanja</span>
							<i class="ui-arrow-right"></i>
						</a>
					</div>
					<?php if ($this->cart->total_items() > 0): ?>
						<div class="col-md-6"></div>
						<div class="col-md-3">
							<?php echo form_submit('update_cart', 'Update your Cart', 'class="btn btn-lg btn-dark"'); ?>
						</div>
					<?php endif ?>
				</div>

				<?php echo form_close(); ?>

				<?php if ($this->cart->total_items() > 0): ?>
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Data Pengiriman</h4>
							<hr class="mt-0">
							<?php echo validation_errors() ?>
							<?php echo form_open(current_url()); ?>
							<div class="row">
								<div class="col-md-8">
									<input type="hidden" name="checkout" value="1">
									<div class="form-group">
										<label for="inputName" class="control-label">Nama Penerima *</label>
										<input type="text" name="inputName" id="inputName" placeholder="Nama Penerima" oninvalid="this.setCustomValidity('Nama Penerima Wajib Diisi')" oninput="setCustomValidity('')" value="<?php echo set_value('inputName') ?>" required="required">
									</div>
									<div class="form-group">
										<label for="inputPhone" class="control-label">No HP Penerima *</label>
										<input type="text" name="inputPhone" id="inputPhone" placeholder="No Handphone" oninvalid="this.setCustomValidity('No HP Wajib Diisi')" oninput="setCustomValidity('')" value="<?php echo set_value('inputPhone') ?>" required="required">
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Provinsi *</label>
												<div id="showProv">
													<select name="inputProvince" id="showProv" required></select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Kabupaten *</label>
												<select name="inputKabupaten" id="showKab" required>
													<option value="">Pilih Kabupaten</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Alamat *</label>
												<textarea name="inputAddress" rows="5" oninvalid="this.setCustomValidity('Input No Alamat Wajib Diisi')" oninput="setCustomValidity('')" required="" placeholder="Alamat"><?php echo set_value('inputAddress') ?></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Kode Pos *</label>
												<input type="text" name="inputPostCode" oninvalid="this.setCustomValidity('Input Code Pos')" oninput="setCustomValidity('')" value="<?php echo set_value('inputPostCode') ?>" placeholder="Kode Pos" required="required">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Pilih Pengiriman *</label>
										<select id="courier" name="inputCourier" onchange="getOngkir(this.value)" class="form-control" required>
											<option value="">Pilih Kurir</option>
											<option value="jne">JNE</option>
											<option value="tiki">TIKI</option>
											<option value="pos">POS</option>
										</select>
									</div>
									<div class="form-group" id="showCourierType">
										<label class="control-label">Pilih Jenis Layanan *</label>
										<select id="courierType" name="inputService" class="form-control" required>
											<option value="">Pilih Jenis Layanan</option>
										</select>
									</div>
									<input type="hidden" name="inputService" id="inputService" class="form-control">
									<!-- <div class="form-group">
										<label class="control-label">Ongkos Kirim</label>
										<input type="hidden" name="inputOngkir" id="inputOngkir" class="form-control">
										<input type="hidden" name="inputService" id="inputService" class="form-control">
										<div class="alert alert-info" role="alert">
											<span id="ongkir">Rp 0</span>
										</div>
									</div> -->
									<div class="form-group">
										<label class="control-label">Subtotal</label>
										<div class="alert alert-warning" role="alert">
											<span id="subtotal"></span>
										</div>
									</div>
									<button class="btn btn-lg btn-color" id="checkout"><span>Checkout</span></button>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="registerLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Register</h4>
			</div>
			<div class="modal-body">
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#login">Login</a></li>
					<li><a data-toggle="tab" href="#register">Register</a></li>
				</ul>

				<div class="tab-content">
					<div id="register" class="tab-pane fade in">
						<?php echo form_open(site_url('auth/login'), array('role'=>'form', 'id'=>'login-recordar')) ?>
						<fieldset>
							<input type="hidden" name="register" value="1">
							<div class="form-group">
								<label for="inputEmail" class="control-label">Email</label>
								<input type="text" name="inputEmail" class="form-control" value="<?php echo set_value('inputEmail'); ?>" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="inputPassword" class="control-label">Password</label>
								<input type="password" name="inputPassword" class="form-control" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="inputPasswordConf" class="control-label">Konfirmasi Password</label>
								<input type="password" name="inputPasswordConf" class="form-control" placeholder="Konfirmasi Password">
							</div>
							<input type="hidden" name="location" value="<?php echo current_url() ?>">
							
							<div class="card-action clearfix">
								<div class="pull-left">
									<button type="submit" class="btn btn-success" id="btn-collapse">Daftar</button>
								</div>
							</div>
						</fieldset>
						<?php echo form_close(); ?>
					</div>
					<div id="login" class="tab-pane fade in active">
						<h3>Login</h3>
						<?php echo form_open(site_url('auth/login')); ?>
						<input type="hidden" name="login" value="1">
						<div class="form-group">
							<label for="inputEmail" class="control-label">Email</label>
							<input type="text" class="form-control" name="inputEmail" required autofocus />
						</div>
						<div class="form-group">
							<label for="inputPassword" class="control-label">Password</label>
							<input type="password" class="form-control" name="inputPassword" required />
						</div>
						<input type="hidden" class="form-control" name="location" value="<?php echo current_url() ?>">

						<button class="btn btn-lg btn-block btn-fb" type="submit">Sign in</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var subtotal = <?php echo $this->cart->total(); ?>;
	var SERVICE = [];
	var SITEURL = "<?php echo site_url() ?>";
	var ONGKIRURL = "<?php echo $this->config->item('ongkir_url') ?>";

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

			res_html += '<label class="control-label">Pilih Jenis Layanan *</label>';
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
		// $("#subtotal").text(SERVICE[res[0]]['cost'][0]['value'] + subtotal);
		$("#inputOngkir").val(SERVICE[res[0]]['cost'][0]['value']);
		$("#inputService").val(res[1]);
	}

	$(document).on('click', '.input-group div', function () {    
		var btn = $(this),
		oldValue = btn.closest('.input-group').find('input').val().trim(),
		newVal = 0;
		var vs = parseInt(btn.attr('data-virso'));

		if (btn.attr('data-dir') == 'up') {
			if (oldValue < vs) {
				newVal = parseInt(oldValue) + 1;
			}else{
				newVal = vs;
			}
		} else {
			if (oldValue > 1) {
				newVal = parseInt(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		btn.closest('.input-group').find('input').val(newVal);
	});

	$(".bind-click-up-i").click(function(){
		var btn_up = $(this);
		var vs = btn_up.attr('data-virso');
	});

	$("#checkout").click(function(e){
		if ("<?php echo $this->session->userdata('logged_customer') ?>" == false) {
			// openDropdownLogin();
			showNotify('Anda harus login untuk melakukan checkout')
			e.preventDefault();
			return false;
		}else{

		};
	});


	function openDropdownLogin(){
		showRegisterForm()
	}

	function showRegisterForm(){
		$("#registerLogin").modal('show');
	}

	function closeDropdownLogin(){
		$("#openDropdownLogin").removeClass('open');
	}

	function showNotify(message){
		$.notify(message, 
		{
			className: 'success',
			globalPosition: 'top center',
		}
		);
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

</script>






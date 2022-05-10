<section class="contact-page-area section-gap">
	<div class="container">
		<div class="row contact-wrap">
			<div class="col-lg-4 d-flex flex-column address-wrap">
				<div class="single-contact-address d-flex flex-row">
					<div class="icon">
						<span class="lnr lnr-home"></span>
					</div>
					<div class="contact-details">
						<h5>Jl. Abdul Rachman Saleh No. 26</h5>
						<p>
							RT.4/RW.5, Senen, Kota Jakarta Pusat
						</p>
					</div>
				</div>
				<div class="single-contact-address d-flex flex-row">
					<div class="icon">
						<span class="lnr lnr-phone-handset"></span>
					</div>
					<div class="contact-details">
						<h5>(021) 3847975</h5>
						<p>Office Hours</p>
					</div>
				</div>
				<div class="single-contact-address d-flex flex-row">
					<div class="icon">
						<span class="lnr lnr-envelope"></span>
					</div>
					<div class="contact-details">
						<h5>support@email.com</h5>
						<p>Send us your query</p>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				
				<?php if ($this->session->flashdata('send_success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<?php echo $this->session->flashdata('send_success') ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif ?>

				<?php echo form_open(current_url(), array('class' => 'form-area contact-form text-right')) ?>
				<?php echo validation_errors() ?>
				<div class="row">
					<div class="col-lg-6">
						<input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
						class="common-input mb-20 form-control" name="contact_name" required="" type="text">

						<input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''"
						onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" name="contact_email" type="email">
						<input name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'"
						class="common-input mb-20 form-control" name="contact_subject" required="" type="text">
					</div>
					<div class="col-lg-6">
						<textarea class="common-textarea form-control" name="message" placeholder="Enter Messege" onfocus="this.placeholder = ''"
						onblur="this.placeholder = 'Enter Messege'" required="" name="contact_message"></textarea>
					</div>
					<div class="col-lg-12 mt-30">
						<div class="alert-msg" style="text-align: left;"></div>
						<button type="submit" class="primary-btn primary" style="float: right;">Send Message</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
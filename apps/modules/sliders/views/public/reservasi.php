<section class="contact-page-area section-gap">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="main-title text-center">
          <h1>Reservasi Ruangan</h1>
        </div>
      </div>
    </div>
    <div class="row mb-10">
      <div class="col-md-6">
        <div class="single-post row">
          <div class="col-lg-12">
            <div class="feature-img">
              <?php if ($catalog['catalog_image'] != ''): ?>
                <img src="<?php echo upload_url($catalog['catalog_image']); ?>" alt="" class="img-thumbnail">
                <?php else: ?>
                  <img src="<?php echo media_url('templates/groot/img/content/single/single_post_featured_img.jpg') ?>" alt="" class="img-thumbnail">
                <?php endif ?>
              </div>
            </div>
            <div class="col-lg-9 col-md-9">
              <h3 class="mt-3"><?php echo $catalog['catalog_name']; ?></h3>
            </div>
            <div class="col-lg-12">
              <div class="">
                MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money
                on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has
                the willpower to actually sit through a self-imposed MCSE training.
              </div>
              
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?php echo validation_errors() ?>
          <?php echo form_open_multipart(current_url(), array('class' => "form-area contact-form text-right")); ?>

          <?php 
          $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
          );
          ?>
          <input type="text" name="inputJenis" class="form-control common-input mb-20" placeholder="Jenis Acara *" value="<?php echo set_value('inputJenis') ?>" required>
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="inputDateStart" class="form-control common-input mb-20 date" placeholder="Dari Tanggal *"  value="<?php echo set_value('inputDateStart') ?>" required readonly>
            </div>
            <div class="col-md-6">
              <input type="text" name="inputDateEnd" class="form-control common-input mb-20 date" placeholder="Sampai Tanggal *"  value="<?php echo set_value('inputDateEnd') ?>" required readonly>
            </div>
          </div>
          <input type="number" name="inputAttendance" class="form-control common-input mb-20" placeholder="Estimasi Peserta & Panitia *"  value="<?php echo set_value('inputAttendance') ?>" required>
          <textarea name="inputOtherRequest" placeholder="Kebutuhan Lainnya" class="form-control common-input mb-20"><?php echo set_value('inputOtherRequest') ?></textarea>
          <label class="float-left">Scan Surat Permohonan *</label>
          <input type="file" name="inputFile" class="form-control common-input mb-20" required>
          <label class="float-left">Scan Proposal *</label>
          <input type="file" name="inputProposal" class="form-control common-input mb-20" required>
          <button type="submit" class="primary-btn primary float-left">Submit</button>
          <?php echo form_close(); ?>
        </div>
      </div>
    </section>
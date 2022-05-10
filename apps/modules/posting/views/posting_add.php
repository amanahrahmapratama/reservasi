<script type="text/javascript">
    var token_name = "<?php echo $this->security->get_csrf_token_name() ?>";
    var csrf_hash = "<?php echo $this->security->get_csrf_hash() ?>";
</script>

<?php echo $this->load->view('posting/add_js') ?>

<?php
if (isset($posting)) {
    $inputJudulValue = $posting['posting_title'];
    $inputRingkasanValue = $posting['posting_desc'];
    $inputShortDescValue = $posting['posting_short_desc'];
    $inputCategory = $posting['posting_category_posting_category_id'];
} else {
    $inputJudulValue = set_value('posting_title');
    $inputRingkasanValue = set_value('posting_desc');
    $inputShortDescValue = set_value('posting_short_desc');
    $inputCategory = set_value('posting_category_posting_category_id');
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header"><?php echo $title; ?></h3>

                <?php if (!isset($posting)) echo validation_errors(); ?>
                <?php echo form_open_multipart(current_url()); ?>

                <?php if ($this->session->flashdata('error_upload')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error_upload'); ?>
                    </div>
                <?php endif ?>

                <div class="row">
                    <div class="col-sm-9 col-md-9">
                        <?php if (isset($posting)): ?>
                            <input type="hidden" name="posting_id" value="<?php echo $posting['posting_id']; ?>" />
                        <?php endif; ?>
                        <label >Judul *</label>
                        <input name="posting_title" placeholder="Judul Ulasan" type="text" class="form-control" value="<?php echo $inputJudulValue; ?>"><br>
                        <label >Konten *</label>
                        <textarea name="posting_desc" class="tinymce-init" rows="15"><?php echo $inputRingkasanValue; ?></textarea>
                        <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                        <?php if (isset($posting) && $posting['posting_image'] != NULL): ?>
                            <img src="<?php echo base_url('uploads/'.$posting['posting_image']) ?>" width="280">
                        <?php endif ?>
                        <div class="form-group">
                            <!-- <div class="box4">
                                <label for="image">Unggah File Gambar</label>
                                <a name="action" id="openmm"type="submit" value="save" class="btn btn-info"><i class="icon-ok icon-white"></i> Upload</a>
                                <div style="display: none;" ><a href="" id="opentiny">Open</a></div>
                                <input type="hidden" name="inputGambarExisting">
                                <input type="hidden" name="inputGambarExistingId">

                                <?php if (isset($posting) AND !empty($posting['posting_image'])): ?>
                                    <div class="thumbnail mt10">
                                        <img class="previewTarget" src="<?php echo $posting['posting_image']; ?>" style="width: 280px !important" >
                                    </div>
                                    <input type="hidden" name="inputGambarCurrent" value="<?php echo $posting['posting_image']; ?>">
                                <?php endif; ?>
                            </div> -->
                            <label>Unggah File Gambar</label>
                            <input type="file" name="inputGambar">
                        </div>
                    </div>
                    <div class="col-sm-9 col-md-3">
                        <div class="form-group" ng-app="myApp" ng-controller="categoriesCtrl">
                            <label>Kategori</label>
                            <!-- <select name="category_id" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($categories as $key): ?>
                                    <option value="<?php echo $key['posting_category_id'] ?>" <?php echo isset($posting) && $key['posting_category_id'] == $inputCategory ? 'selected' : '' ?>><?php echo $key['posting_category_name'] ?></option>
                                <?php endforeach ?>
                            </select> -->

                            <div class=" input-group">
                                <select name="category_id" class="form-control" id="selectCat">
                                    <option ng-repeat="category in categories" ng-selected="category_data.index == category.posting_category_id" value="{{category.posting_category_id}}">{{category.posting_category_name}}</option>
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#category" aria-expanded="false">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="collapse" id="category">
                                <div class="input-group">
                                    <input class="form-control" placeholder="Tambah Baru" id="appendedInputButton" type="text" ng-model="categoryText">
                                    <div class="input-group-btn">
                                        <span class="btn btn-default simpan" ng-click="addCategory()" ng-disabled="!(!!categoryText)">Simpan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label>
                                    <input type="radio" name="posting_is_published" value="0"/ <?php echo (isset($posting) && $posting['posting_publish_status'] == 0) ? 'checked' : null ?>> Status Draft
                                </label>
                                <label>
                                    <input type="radio" name="posting_is_published" value="1"/ <?php echo (isset($posting) && $posting['posting_publish_status'] == 1) ? 'checked' : null ?>> Status Publish
                                </label>
                        </div>
                        <div class="form-group">
                            <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
                            <a href="<?php echo site_url('admin/posting'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
                            <?php if (isset($posting)): ?>
                                <a href="#confirm-del" data-toggle="modal" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($posting)): ?>
    <!-- Delete Confirmation -->
    <div class="modal fade" id="confirm-del">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><b>Konfirmasi Penghapusan</b></h4>
                </div>
                <div class="modal-body">
                    <p>Data yang dipilih akan dihapus&hellip;</p>
                </div>
                <?php echo form_open('admin/posting/delete/' . $posting['posting_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $posting['posting_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $posting['posting_title'] ?>" />
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php if ($this->session->flashdata('delete')) { ?>
    <script type="text/javascript">
        $(window).load(function() {
            $('#confirm-del').modal('show');
        });
    </script>
    <?php }
    ?>
<?php endif; ?>

ec
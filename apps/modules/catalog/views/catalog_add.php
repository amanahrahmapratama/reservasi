<link rel="stylesheet" type="text/css" href="<?php echo media_url('css/angular-multi-select.css') ?>">
<script src="<?php echo media_url('js/angular.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo media_url('js/angular-multi-select.js') ?>"></script>

<?php
if (isset($catalog)) {
    $inputName = $catalog['catalog_name'];
    $inputDesc = $catalog['catalog_desc'];
} else {
    $inputName = set_value('catalog_name');
    $inputDesc = set_value('catalog_desc');
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3>
                    <?php echo $title; ?>
                </h3>

                <?php if (!isset($catalog)) echo validation_errors(); ?>
                <?php echo form_open_multipart(current_url()); ?>

                <?php if ($this->session->flashdata('error_upload')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error_upload'); ?>
                    </div>
                <?php endif ?>

                <div class="row">
                    <div class="col-sm-9 col-md-9">
                        <?php if (isset($catalog)): ?>
                            <input type="hidden" name="catalog_id" value="<?php echo $catalog['catalog_id']; ?>" />
                        <?php endif; ?>
                        <label >Nama Ruangan *</label>
                        <input name="catalog_name" placeholder="Nama Ruangan" type="text" class="form-control" value="<?php echo $inputName; ?>"><br>

                        <label >Deskripsi *</label>
                        <textarea name="catalog_desc" class="tinymce-init" rows="15"><?php echo $inputDesc; ?></textarea>
                        <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
                        <div class="form-group">
                            <div class="box4">
                                <!-- <label for="image">Unggah File Gambar</label> -->
                                <!--<input id="image" type="file" name="inputGambar">-->
                <!-- <a name="action" id="openmm"type="submit" value="save" class="btn btn-info"><i class="icon-ok icon-white"></i> Upload</a>
                <div style="display: none;" ><a href="" id="opentiny">Open</a></div>
                <input type="hidden" name="inputGambarExisting">
                <input type="hidden" name="inputGambarExistingId"> -->

                <?php if (isset($catalog) AND !empty($catalog['catalog_image'])): ?>
<!--                     <div class="thumbnail mt10">
                        <img class="previewTarget" src="<?php echo $catalog['catalog_image']; ?>" style="width: 280px !important" >
                    </div>
                    <input type="hidden" name="inputGambarCurrent" value="<?php echo $catalog['catalog_image']; ?>"> -->
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-9 col-md-3">
        <div class="form-group">
            <?php if (isset($catalog)): ?>
                <?php foreach ($image as $key): ?>
                    <a target="_blank" href="<?php echo upload_url($key['catalog_image_path']) ?>"><?php echo $key['catalog_image_path'] ?></a>
                    <br>
                <?php endforeach ?>

            <?php endif ?>
            <hr>
            <label>Upload File</label>
            <div id="p_upload">
                <input type="file" class="form-control" name="catalogImage[]">
                <br>
            </div>
            <a href="#" id="addUpload"><i class="glyphicon glyphicon-plus-sign"></i><b>  Tambah file lainnya</b></a>
        </div>
        <button name="action" type="submit" value="save" class="btn btn-success"><i class="ion-checkmark"></i> Simpan</button>
        <a href="<?php echo site_url('admin/catalog'); ?>" class="btn btn-info"><i class="ion-arrow-left-a"></i> Batal</a>
        <?php if (isset($catalog)): ?>
            <a href="#confirm-del" data-toggle="modal" class="btn btn-danger" ><i class="ion-trash-a"></i> Hapus</a>
        <?php endif; ?>
    </div>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>

<?php if (isset($catalog)): ?>
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
                <?php echo form_open('admin/catalog/delete/' . $catalog['catalog_id']); ?>
                <div class="modal-footer">
                    <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                    <input type="hidden" name="del_id" value="<?php echo $catalog['catalog_id'] ?>" />
                    <input type="hidden" name="del_name" value="<?php echo $catalog['catalog_name'] ?>" />
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

<script type="text/javascript">
    var myApp = angular.module('myApp', ['multi-select']);

    myApp.controller('categoryCtrl' , function($scope, $http) {
        $scope.categoryOutput = [];
        $scope.category = <?php echo $category?>;
    });

    $(function() {
        var divUpload = $('#p_upload');
        var i = $('#p_upload p').size() + 1;

        $("#addUpload").click(function() {
            $('<p>' +
                '<input type="file" class="form-control" name="catalogImage[]" multiple="">' +
                '<a href="#" class="remUpload">Hapus</a>' +
                '<br>' +
                '</p>').appendTo(divUpload);

            i++;
            return false;
        });

        $(document).on("click", ".remUpload", function() {
            if (i > 2) {
                $(this).parents('p').remove();
                i--;
            }
            return false;
        });
    });
</script>
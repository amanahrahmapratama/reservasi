<link rel="stylesheet" type="text/css" href="<?php echo media_url('css/angular-multi-select.css') ?>">
<script src="<?php echo media_url('js/angular.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo media_url('js/angular-multi-select.js') ?>"></script>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <div class="pull-right">
                        <a href="<?php echo site_url('admin/catalog'); ?>" class="btn btn-success">Kembali</a>
                        <a href="<?php echo site_url('admin/catalog/edit/'.$catalog['catalog_id']); ?>" class="btn btn-warning">Edit</a>
                    </div>
                </h3>

                <div class="collapse" id="collapseStock">
                    <?php echo form_open(current_url(), array('class' => 'form-inline')) ?>
                    <div class="form-group">
                        <input type="hidden" name="stockUpdate" value="1">
                        <input type="number" name="stock" placeholder="input stok" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php echo form_close() ?>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4">
                        <?php if ($catalog['catalog_image'] != NULL): ?>
                            <img src="<?php echo upload_url($catalog['catalog_image']) ?>" class="img-thumbnail">
                        <?php else: ?>
                            <img src="<?php echo template_media_url('img/content/single/single_post_img_1.jpg') ?>" class="img-thumbnail">    
                        <?php endif ?>
                    </div>
                    <div class="col-md-8">
                        <table class="table no-more-tables">
                            <tbody>
                                <tr>
                                    <td>Nama Barang</td>
                                    <td>:</td>
                                    <td><?php echo $catalog['catalog_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi Barang</td>
                                    <td>:</td>
                                    <td><?php echo $catalog['catalog_desc'] ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal input</td>
                                    <td>:</td>
                                    <td><?php echo pretty_date($catalog['catalog_created_date']) ?></td>
                                </tr>
                                <tr>
                                    <td>Penulis</td>
                                    <td>:</td>
                                    <td><?php echo $catalog['user_name']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid-footer">
                    <h4 class="page-header">Foto</h4>
                    <div class="superbox">
                        <?php foreach ($image as $key): ?>
                            <div class="superbox-list">
                                <img src="<?php echo upload_url($key['catalog_image_path']) ?>" data-img="<?php echo upload_url($key['catalog_image_path']) ?>" alt="<?php echo upload_url($key['catalog_image_path']) ?>" class="superbox-img">
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <p></p>
            </div>
            <div class="modal-body img_centre">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var myApp = angular.module('myApp', [ 'multi-select' ]);

    myApp.controller( 'categoryCtrl' , function($scope, $http) {
        $scope.categoryOutput = [];
        $scope.category = <?php echo $category?>;
    });

</script>
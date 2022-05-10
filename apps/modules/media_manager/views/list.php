<link href="<?php echo media_url('mediamanager/css/mediamanager.css'); ?>" rel="stylesheet">
<script src="<?php echo media_url('mediamanager/js/mediamanager.js'); ?>"></script>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    MEDIA MANAGER (<?php echo $total_images ?> files)
                </h3>

                <?php echo form_open_multipart('admin/media_manager' . '/upload', array('enctype' => 'multipart/form-data')) ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger" >
                                <?php echo $this->session->flashdata('error') ?>
                            </div>          
                        <?php endif ?>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Label..." name="img_label" />
                        </div>
                        <div class="form-group">
                            <input type="file" name="fn" class="form-control" required accept="image/*">        
                        </div>

                        <?php if (!isset($id)): ?>
                            <div class="form-group">
                                <select name="album_id" class="form-control">
                                    <option value="0">-- Select Album --</option>
                                    <?php if ($albums['count'] > 0): ?>
                                        <?php foreach ($albums['data'] as $album): ?>
                                            <option value="<?php echo $album['id'] ?>"><?php echo $album['label'] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="album_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php endif ?>

                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
                <?php echo form_close() ?>

                <br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row-fluid">
                            <?php if (count($images) > 0): ?>
                                <?php $loop = 1 ?>
                                <?php foreach ($images as $image): ?>
                                    <?php
                                    if ($image['info'] != '0') {
                                        $info = unserialize($image['info']);
                                    }
                                    $label = strlen($image['label']) > 0 ? $image['label'] : $info['file_name'];
                                    $imageView = upload_url($image['name']) . '?' . uniqid();
                                    if ($image['type'] != '') {
                                        $type_ex = explode("/", $image['type']);
                                        $type = $type_ex[0];
                                    } else
                                    $type = 'image';

                                    if ($type != '' && $type != 'image') {
                                        switch ($type_ex[1]) {
                                            case 'pdf':
                                            $imageView = media_url('img/icon_pdf.png');
                                            break;
                                            case 'msword':
                                            case 'doc':
                                            $imageView = media_url('img/icon_word.png');
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-3 imgs">
                                        <?php if ($image['info'] != '0'): ?>
                                            <div class="<?php if ($type == 'image'): ?>crop<?php endif; ?> img-holder">
                                                <?php if (is_file($info['full_path'])): ?>
                                                    <a href="<?php echo 'index.php' . site_url('/admin/media_manager/edit/' . $image['id']) ?>">
                                                        <img src="<?php echo $imageView ?>" >
                                                        <div class="info"></div>
                                                    </a>
                                                <?php else: ?>
                                                    <div class="crop img-polaroid" style="min-height:67px;text-align:center">
                                                        <h3>Image not found</h3>
                                                        <br/>
                                                        <br/>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="img-album">
                                                <a href="<?php echo site_url('/admin/media_manager/album/' . $image['id']) ?>">
                                                    <img src="<?php echo media_url('image/icon-album.png') . '?' . uniqid() ?>" width="128px" >
                                                    <div class="info_album">
                                                        <div class="info_name"><?php echo $image['label'] ?></div>
                                                        <div><?php echo $image['count'] ?> images</div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($image['info'] != '0'): ?>
                                            <div class="img-info">
                                                <p><a class="info-news" href=""><?php echo $label ?></a></p>
                                                <div class="imgaction">
                                                    <?php if ($type == 'image'): ?>
                                                        <a href="#myModal" data-toggle="modal" class="zoomin"><i class="glyphicon glyphicon-zoom-in icon-white" title="zoom in"></i><input type="hidden" value="<?php echo upload_url($image['name']) . '?' . uniqid() ?>" /></a>
                                                    <?php else : ?>
                                                        <a href="javascript:window.open('<?php echo site_url('/admin/media_manager/viewapp/' . $image['id']) ?>','<?php echo $image['label'] ?>','width=600,height=550');"><i class="glyphicon glyphicon-zoom-in icon-white" title="zoom in"></i></a>
                                                    <?php endif; ?>
                                                    <!--<a href="<?php echo site_url('/admin/media_manager/edit/' . $image['id']) ?>"><i class="glyphicon glyphicon-edit icon-white" title="edit"></i></a>-->
                                                    <a href="<?php echo site_url('/admin/media_manager/delete/' . $image['id']) ?>"><i class="glyphicon glyphicon-remove icon-white" title="delete"></i></a>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <?php if ($loop++ == 4): $loop = 1; ?>
                                    </div>
                                    <div class="row-fluid">
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php else: ?>
                                <p>There are no images in gallery.</p>
                            <?php endif ?>
                        </div>
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
                <h3 id="img_title">Modal header</h3>
            </div>
            <div class="modal-body img_centre">

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
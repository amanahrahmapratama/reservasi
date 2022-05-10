<link href="<?php echo media_url('mediamanager/css/mediamanager.css'); ?>" rel="stylesheet">
<script src="<?php echo media_url('mediamanager/js/mediamanager.js'); ?>"></script>

<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    ALBUM (<?php echo $total_albums ?> albums)
                </h3>

                <?php echo form_open_multipart('media_manager/media_album_admin/create') ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo validation_errors(); ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <input type="text" class="form-control " placeholder="Nama album ..." name="album_name">
                        </div>
                        <button class="btn do-upload btn-primary" type="submit">Tambah Album</button>
                    </div>
                </div>
                <?php echo form_close() ?>

                <br>

                <div class="row">
                    <?php if (count($albums) > 0): ?>
                        <?php $loop = 1 ?>
                        <?php foreach ($albums as $album): ?>
                            <div class="col-md-3">
                                <div class="img-album">
                                    <a href="<?php echo site_url('admin/media_manager/album/' . $album['id']) ?>">
                                        <img src="<?php echo media_url('img/icon-album.png') . '?' . uniqid() ?>" width="128px" >
                                        <div class="info_album">
                                            <div class="info_name"><?php echo $album['label'] ?></div>
                                            <div><?php echo $album['count'] ?> images</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php if ($loop++ == 4): $loop = 1; ?>

                            <?php endif ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <p>There are no albums.</p>
                    <?php endif ?>
                </div>

                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
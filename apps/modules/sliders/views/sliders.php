<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/sliders/add'); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">NAMA FILE</th>
                            <th class="controls" align="center">CAPTION</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($sliders)) {
                        foreach ($sliders as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td ><?php echo $row['slider_photo']; ?></td>
                                    <td ><?php echo $row['slider_caption']; ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/sliders/view/' . $row['slider_id']); ?>" ><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/sliders/edit/' . $row['slider_id']); ?>" ><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="6" align="center">Data Kosong</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>   
                </table>

                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
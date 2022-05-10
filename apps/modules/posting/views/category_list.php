<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                    <a href="<?php echo site_url('admin/posting/add_category'); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </h3>

                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th align="center" class="controls" >Nama Kategori</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($categories)) {
                        foreach ($categories as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <?php
                                    if ($row['posting_category_id'] == 1) {
                                        ;
                                        ?>
                                        <td align="center"><b><p style="float: left;" ><?php echo $row['posting_category_name']; ?></p></b></td>
                                        <?php } else { ?>
                                        <td align="center"><b><a style="float: left;" href="<?php echo site_url('admin/posting/category/edit/' . $row['posting_category_id']); ?>" ><?php echo $row['posting_category_name']; ?></a></b></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                                <?php
                            }
                        } else {
                            ?>
                            <tbody>
                                <tr id="row">
                                    <td >Data Kosong</td>
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
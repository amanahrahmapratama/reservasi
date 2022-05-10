<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $title; ?>
                </h3>
                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th class="controls" align="center">NAMA HALAMAN</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($pages)) {
                        foreach ($pages as $row) {
                            ?>
                            <tbody>
                                <tr>
                                    <td ><b><a style="float: left;" href="<?php echo site_url('admin/page/edit/' . $row['page_id']); ?>" ><?php echo $row['page_name']; ?></a></b></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/page/view/' . $row['page_id']); ?>" ><span class="fa fa-eye"></span></a>
                                        <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/page/edit/' . $row['page_id']); ?>" ><span class="fa fa-pencil"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }
                    } else {
                        ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="3" align="center">Data Kosong</td>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>   
                </table>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>

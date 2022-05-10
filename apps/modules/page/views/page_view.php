<div class="row">
    <div class="col-md-12">
        <div class="grid simple ">
            <div class="grid-body no-border">
                <h3 class="page-header">
                    <?php echo $pages['page_name'] ?>
                    <a href="<?php echo site_url('admin/page/edit/'.$pages['page_id']); ?>" class="btn btn-success pull-right">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </h3>

                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>Judul</td>
                            <td><?php echo $pages['page_name'] ?></td>
                        </tr>
                        <tr>
                            <td>Konten</td>
                            <td><?php echo $pages['page_content'] ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


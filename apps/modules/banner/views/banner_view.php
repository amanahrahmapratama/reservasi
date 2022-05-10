<div class="col-sm-9 col-md-10 main">
    <div class="row">
        <div class="col-md-8">
            <h3 class="page-header">
                Detail Banner
            </h3>
        </div>
        <div class="col-md-4">
            <span class=" pull-right">
                <a href="<?php echo site_url('admin/banner') ?>" class="btn btn-info"><span class="ion-arrow-left-a"></span>&nbsp; Kembali</a> 
            <a href="<?php echo site_url('admin/banner/edit/'.$banner['banner_id']) ?>" class="btn btn-warning"><span class="ion-edit"></span>&nbsp; Edit</a> 
            </span>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-2">
            <?php if(!empty($banner['banner_image'])){ ?>
            <img src="<?php echo upload_url($banner['banner_image']) ?>" class="img-responsive avatar">
            <?php }else{ ?>
            <img src="<?php echo base_url('media/image/missing-image.png') ?>" class="img-responsive avatar">
            <?php } ?>
        </div>
        <div class="col-md-10">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Judul Banner</td>
                        <td>:</td>
                        <td><?php echo $banner['banner_title'] ?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi Banner</td>
                        <td>:</td>
                        <td><?php echo $banner['banner_desc'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal input</td>
                        <td>:</td>
                        <td><?php echo pretty_date($banner['banner_created_date']) ?></td>
                    </tr>
                    <tr>
                        <td>Penulis</td>
                        <td>:</td>
                        <td><?php echo $banner['user_name']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
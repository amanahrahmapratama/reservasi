<?php echo form_open(current_url()); ?>
<div class="container">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
            <a href="<?php echo site_url() ?>" class="breadcrumbs__url">Home</a>
        </li>
        <li class="breadcrumbs__item breadcrumbs__item--current">
            <?php echo $title; ?>
        </li>
    </ul>
</div>

<div class="main-container container" id="main-container">
    <div class="blog__content mb-72">
        <h1 class="page-title"><?php echo $title; ?></h1>

        <div class="row">
            <div class="col-md-4">
                <?php echo $this->load->view('templates/groot/sidebar') ?>
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php $i = 1; ?>
                            <?php foreach ($this->cart->contents() as $items): ?>

                                <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
                                <tr>
                                    <td><?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                                    <td><?php echo $items['name']; ?></td>
                                    <td><?php echo $this->cart->format_number($items['price']); ?></td>
                                    <td>
                                        <a class="btn" href="?id=<?php echo $items['rowid'] ?>&count=0" type="reset">x</a>
                                    </td>
                                </tr>

                                <?php $i++; ?>

                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2">Total</td>
                                <td colspan="2"><?php echo $this->cart->total(); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <p><?php echo form_submit('update_cart', 'Update your Cart'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
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
                            <th class="controls" align="center">INVOICE</th>
                            <th class="controls" align="center">TANGGAL PENJUALAN</th>
                            <th class="controls" align="center">PELANGGAN</th>
                            <th class="controls" align="center">STATUS</th>
                            <th class="controls" align="center">AKSI</th>
                        </tr>
                    </thead>
                    <?php if (!empty($expired)): ?>
                        <?php foreach ($expired as $key): ?>
                            <?php $curDate = date('Y-m-d H:i:s'); ?>
                            <?php if ($curDate > $key['sale_last_update']): ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $key['sale_inv_num'] ?></td>
                                        <td><?php echo pretty_date($key['sale_date'], 'd-m-Y', FALSE) ?></td>
                                        <td><?php echo $key['customer_full_name'] . ' (' . $key['customer_email'] .')' ?></td>
                                        <td><?php echo $key['sale_status_name'] ?></td>
                                        <td>
                                            <a href="#delModal" data-toggle="modal" onclick="removeExpiredTransaction(<?php echo $key['sale_id'] ?>)" class="btn btn-danger">Batalkan</a>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tbody>
                            <tr id="row">
                                <td colspan="5" align="center">Data Kosong</td>
                            </tr>
                        </tbody>
                    <?php endif ?>
                </table>

                <div >
                    <?php echo $this->pagination->create_links(); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <br>
                <h4 id="myModalLabel" class="semi-bold">Konfirmasi Penghapusan</h4>
            </div>
            <?php echo form_open(site_url('admin/sale/delExpiredTransaction')) ?>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini?</p>
                <input type="hidden" name="id" id="getId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Hapus</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
    function removeExpiredTransaction($id) {
        $('#getId').val($id);
    }
</script>

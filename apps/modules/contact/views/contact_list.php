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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contact)): ?>
                            <?php foreach ($contact as $row): ?>
                                <tr>
                                    <td><?php echo $row['contact_name'] ?></td>
                                    <td><?php echo $row['contact_email'] ?></td>
                                    <td><?php echo $row['contact_subject'] ?></td>
                                    <td><?php echo $row['contact_created_at'] ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/contact/view/'.$row['contact_id']) ?>" class="btn btn-success btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#delModal" data-toggle="modal" onclick="removeContact(<?php echo $row['contact_id'] ?>)" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Data kosong</td>
                            </tr>
                        <?php endif ?>
                    </tbody>  
                </table>

                <div>
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
            <?php echo form_open(site_url('admin/contact/delete')) ?>
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
    function removeContact($id) {
        $('#getId').val($id);
    }
</script>
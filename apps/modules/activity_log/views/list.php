<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
		
		<div class="grid-body no-border">
            <h3 class="page-header">
                Daftar Log Aktivitas
            </h3>

        <table class="table no-more-tables">
            <thead>
            <tr>
                <th class="controls" id="nama" align="center" style="width: 230px;">Tanggal</th>
                <th class="controls" id="alamat" align="center">Penulis</th>
                <th class="controls" id="foto" align="center">Modul</th>
                <th class="controls" id="foto" align="center">Aksi</th>
                <th class="controls" id="foto" align="center">Info</th>
            </tr>
            </thead>
            <?php
            if (!empty($data)) {
                foreach ($data as $row) {
                    ?>
            <tbody>
                    <tr class="isi">
                        <td ><?php echo pretty_date($row['log_date']); ?></td>
                        <td ><?php 
                            foreach ($user as $key){
                        echo ($row['user_id'] == $key['user_id'])? $key['user_name'] : NULL;
                            }; ?></td>
                        <td ><?php echo $row['log_module']; ?></td>
                        <td ><?php echo $row['log_action']; ?></td>
                        <td ><?php echo $row['log_info']; ?></td>
                    </tr>
            </tbody>
                    <?php
                }
            } else {
                ?>
            <tbody>
                <tr id="row">
                    <td colspan="5" align="center">Data Kosong</td>
                </tr>
            </tbody>
                <?php
                }
                ?>   
            </table>

            <div >
                <?php echo $this->pagination->create_links(); ?>
            </div>

		</div>
		</div>
	</div>
</div>

<div class="col-sm-9 col-md-10 main">
    <div class="row">
        <div class="col-md-8">
            <h3 class="page-header">
                Detail Pembelian
            </h3>
        </div>
        <div class="col-md-4">
            <span class=" pull-right">
                <a href="<?php echo site_url('admin/purchase') ?>" class="btn btn-info"><span class="ion-arrow-left-a"></span>&nbsp; Kembali</a> 
                <a href="<?php echo site_url('admin/purchase/edit/' . $purchase['purchase_id']) ?>" class="btn btn-warning"><span class="ion-edit"></span>&nbsp; Edit</a> 
                <button class="btn btn-success" data-toggle="modal" data-target="#myForm"><span class="ion-pricetags"></span>&nbsp; Form</button> 
            </span>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Tanggal Pembelian</td>
                        <td>:</td>
                        <td><?php echo pretty_date($purchase['purchase_date'], 'l, d/m/Y', FALSE); ?></td>
                    </tr>
                    <tr>
                        <td>Supplier</td>
                        <td>:</td>
                        <td><?php echo $purchase['supplier_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal input</td>
                        <td>:</td>
                        <td><?php echo pretty_date($purchase['purchase_created_date']) ?></td>
                    </tr>
                    <tr>
                        <td>Penulis</td>
                        <td>:</td>
                        <td><?php echo $purchase['user_name']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (isset($item)): ?>
        <a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#detailSale" aria-expanded="false" aria-controls="detailSale">
            <i class="ion-arrow-down-a"></i> Lihat Pembelian Detail
        </a>    
        <hr>
        <div class="row collapse" id="detailSale" >
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA BARANG</th>
                            <th>JUMLAH</th>
                            <th>HARGA SATUAN</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($item as $row):
                            ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['catalog_name']; ?></td>
                            <td><?php echo $row['item_count']; ?></td>
                            <td><?php echo $row['item_price']; ?></td>
                            <td><?php echo $row['item_total_price']; ?></td>
                        </tr>
                        <?php
                        $i++;
                        endforeach;
                        ?>
                        <tr style="border-top: 1px solid #000;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Total:</b></td>
                            <td><b><?php echo $purchase['purchase_total_price']; ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>
<!-- Modal -->
<div class="modal fade" id="myForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Pembelian</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('admin/purchase/form/' . $purchase['purchase_id']) ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Nama Barang</label>
                                                <input type="text" id="namaBarang" class="form-control">
                                                <input type="hidden" id="idBarang" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Jumlah</label>
                                                <input type="text" id="jmlBarang" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Harga Barang</label>
                                                <input type="text" id="hargaBarang" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Total</label>
                                                <input type="text" id="totalBarang" readonly="true" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <br>
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <th class="head">Nama Barang</th>
                                                        <th class="head">Jumlah</th>
                                                        <th class="head">Harga</th>
                                                        <th class="head">Total</th>
                                                        <th class="head">Hapus</th>
                                                    </thead>
                                                    <tbody id="showResult">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <br>
                                                <span class="btn btn-primary pull-right" id="btnSimpan">Simpan</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-6 pull-right">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Total</label>
                                                            </div>
                                                            <div class="col-md-8 pull-right">
                                                                <input type="text" id="totalPrice" readonly name="total_price" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div><br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4 pull-right" >
                                                        <input type="submit" class="col-md-12 btn btn-primary" value="Simpan">
                                                    </div>
                                                    <div class="col-md-2" >
                                                        <button class="col-md-12 btn btn-info" id="batal" data-dismiss="modal"><i class="ion-arrow-left-a"></i> Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).bind("change propertychange keyup keydown", function(){
            var hargaBarang = $("#hargaBarang").val();
            var jmlBarang = $("#jmlBarang").val();

            $("#totalBarang").val(hargaBarang * jmlBarang);
        });

        $("#namaBarang").autocomplete({
            source: 
            function(req, add){  
                $.ajax({  
                    url:  "<?php echo site_url('admin/catalog/getCatalogJson') ?>",  
                    dataType: 'json',  
                    type: 'POST',  
                    data: req,  
                    success:      
                    function(data){  
                        add(data);                 },  
                    });  
            },  
            minLength: 1,
            appendTo: "#myForm",
            select: function( event, ui ) {
                var hargaBarangAc = ui.item.catalog_buying_price;

                $("#hargaBarang").val(ui.item.catalog_buying_price);
                $("#jmlBarang").val(1);
                $("#idBarang").val(ui.item.id);
                $("#totalBarang").val(hargaBarangAc);
            },

        }); 

        var arrBarang = [];

        $("#btnSimpan").click(function(){

            pushArray();

            $("#namaBarang").val('');
            $("#hargaBarang").val('');
            $("#jmlBarang").val('');
            $("#idBarang").val('');
            $("#totalBarang").val('');            
        });

        function pushArray(){

            var namaBarang = $("#namaBarang").val();
            var idBarang = $("#idBarang").val();
            var jmlBarang = $("#jmlBarang").val();
            var hargaBarang = $("#hargaBarang").val();
            var totalBarang = $("#totalBarang").val();

            if (idBarang != '' && jmlBarang != '' && totalBarang != '') {

                var newArr = {
                    'namaBarang' : namaBarang, 
                    'id_barang' : idBarang, 
                    'jmlBarang' : jmlBarang,
                    'hargaBarang' : hargaBarang,
                    'totalBarang' : totalBarang
                };

                arrBarang.push(newArr);
                result(arrBarang);
            };
        };

        function result(arrBarang) {
            var totalPrice = 0;
            var html = "";
            for (var i = 0; i < arrBarang.length; i++) {
                html += "<tr>";
                html += "<td>"+ arrBarang[i]['namaBarang'] +"</td>";
                html += "<td>"+ arrBarang[i]['jmlBarang'] +"</td>";
                html += "<td>"+ arrBarang[i]['hargaBarang'] +"</td>";
                html += "<td>"+ arrBarang[i]['totalBarang'] +"</td>";
                html += "<td>";
                html += "<button onclick='removeNode("+i+")'>x</button>"
                html += "<input type='hidden' name='catalog_id[]' value='"+ arrBarang[i]['id_barang'] +"'> ";
                html += "<input type='hidden' name='qty[]' value='"+ arrBarang[i]['jmlBarang'] +"'> ";
                html += "<input type='hidden' name='item_price[]' value='"+ arrBarang[i]['hargaBarang'] +"'> ";
                html += "<input type='hidden' name='price[]' value='"+ arrBarang[i]['totalBarang'] +"'> ";
                html += "</td>";
                html += "</tr>";

                var parsetInteger = parseInt(arrBarang[i]['totalBarang']);
                totalPrice = totalPrice + parsetInteger;
            };
            
            $("#totalPrice").val(totalPrice);
            $("#showResult").html(html);
        };

        function removeNode(arrIndex){
            arrBarang.splice(arrIndex, 1);
            result(arrBarang);
        }

        $("#batal").click(function(){
           $("#totalPrice").val('');
           $("#showResult").html('');
       })


        $("#price1, #qty1").keyup(function() {
            var value = $("#price1").val() * $("#qty1").val();

            $("#total1").val(value);
        })
        .keyup();
    </script>

    <script>
        $(function() {
            var scntDiv = $('#p_scents');
            var scntAdd = $('#form');
            var i = $('#p_scents tr').size() + 1;

            $("#addScnt").click(function() {
                $('<tr><td width="6%"><input class="form-control" readonly value="' + i + '" type="text" name="number"></td><td><select name="catalog_id[]" class="form-control"><option>-- Pilih Barang --</option><?php foreach ($catalog as $row): ?><option value="<?php echo $row['catalog_id'] ?>" ><?php echo $row['catalog_name'] ?></option><?php endforeach; ?></select></td><td><input class="form-control" type="text" id="qty' + i + '" name="qty[]"></td><td><input class="form-control" type="text" id="price' + i + '" name="item_price[]"></td><td><input class="form-control jml" type="text" id="total' + i + '" name="price[]" value="" readonly></td><td><a href="#" class="remScnt"><span class="ion-minus-circled"></span></a></td></tr>').appendTo(scntDiv),
                $('<script>$("#price' + i + ', #qty' + i + '").keyup(function () { \n\
                    var value = $("#price' + i + '").val() * $("#qty' + i + '").val();\n\
                    $("#total' + i + '").val(value);\n\
                }).keyup(); </' + 'script>').appendTo(scntAdd);
                i++;
                return false;
            });

$(document).on("click", ".remScnt", function() {
    if (i > 2) {
        $(this).parents('tr').remove();
        i--;
    }
    return false;
});

$(document).bind("change keyup focus input propertychange", function() {
    var sum = 0;
    $(".jml").each(function() {
        sum += +$(this).val();
    });
    var change = $("#cash").val() - $("#total").val();


    var total = sum
    $("#total").val(total);
    $("#change").val(change);
});

});
</script>

<style>
    .ui-autocomplete-loading {
        background: white url( "<?php echo base_url('media/image')?>/ui-anim_basic_16x16.gif") right center no-repeat;
    }
</style>
<div class="content-wrapper animated bounceInDown ">

    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card  " style="min-height: 500px;">
                <div class="card-body">
                    <div class=" card-title text-center row">
                        <h4>SETTING UJIAN BARU</h4>
                        <input type="text" class="form-control kodeujian" name="kodeujian" id="kodeujian" style="font-size: 24px; font-weight:800; text-align:center" value="<?= $kode ?>" readonly required>
                        <input type="hidden" name="idujian" class="idujian" id="idujian" value="<?= $ids ?>" required>

                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-5 mb-2 ">
                                <div class="form-group mb-1 ">
                                    <label for="kunci">Nama Ujian</label>
                                    <select class="form-control form-control-sm" id="kunci" name="kunci">
                                        <option value="">Pilih Nama Ujian</option>
                                        <?php foreach ($modul as $val) : ?>
                                            <option value="<?= $val->id ?>"><?= $val->modul ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                                <div class="form-group mb-1 ">
                                    <label for="jenis">Jenis Soal</label>
                                    <select class="form-control form-control-sm" id="jenis" name="jenis">
                                        <option value="random">Random</option>
                                        <option value="urut">Urut</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">

                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="waktu">Waktu Pengerjaan</label>
                                <div class="input-group mb-1">
                                    <input type="number" name="waktu" id="waktu" class="form-control form-control-sm">
                                    <div>
                                        <span class="input-group-text form-control-sm" id="search">
                                            Menit
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1 ">
                                            <label for="start">Tanggal Mulai</label>
                                            <input type="date" name="start" id="start" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1 ">
                                            <label for="end">Tanggal Berakhir</label>
                                            <input type="date" name="end" id="end" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5" style=" border:1px solid #c9c9c9; background-color:#f9fdff">
                                <div class="row">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                            <span class="input-group-text form-control-sm" id="search">
                                                <i class="icon-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="cariSoal" name="soal" placeholder="Masukkan Kategori Soal" aria-label="search" aria-describedby="search">
                                    </div>
                                </div>
                                <div class="table-responsive" style="max-height: 400px;">
                                    <table id="TableUjian" class="table table-sm table-striped table-bordered table-fit ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>SOAL UJIAN </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="BTNTAKE" style="text-align: right;">
                                    <button id="button" class="btn btn-sm btn-block btn-primary rounded-0 mt-1">Jadikan Soal Ujian</button>
                                </div>
                            </div>
                            <div class="col m-3">

                            </div>
                            <div class="col-md-6" style=" border:1px solid #c9c9c9; background-color:#f1f1f8">
                                <h3 class="text-center" style="margin-top: 5px;">HASIL SOAL PILIHAN</h3>
                                <div class="table-responsive" style="max-height: 400px;">
                                    <table id="ShowUjian" class="table table-sm table-stripe table-bordered table-hover table-fit ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Soal ujian yang sudah dipilih</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <button id="Batals" class="btn btn-md btn-secondary rounded-0  mt-1">BATALKAN SOAL</button>
                                    <button id="Simpans" class="btn btn-md btn-primary rounded-0  mt-1">PROSES SOAL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal animated bounceIn " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <strong class="M-tittle mt-3" style="text-align: center;"></strong>
                <div class="M-body text-center"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var showujian = $('#ShowUjian').DataTable({
            "paging": false,
            "searching": false,
            "retrieve": true,
            "ordering": false,
            "autoFill": {
                columns: ':not(:first-child)'
            },
        });

        $(".BTNTAKE").hide();
        var myTable = $('#TableUjian').DataTable({
            "paging": false,
            "searching": false,
            "retrieve": true,
            "ordering": false,
            "autoFill": {
                columns: ':not(:first-child)'
            },
            "select": {
                style: 'multi'
            },
            dom: 'Blfrtip',
            buttons: [{
                    extend: 'selectAll',
                    text: '<i class="ti-check"> </i> All',
                    className: ' btn-sm rounded-0 '
                },
                {
                    extend: 'selectNone',
                    text: '<i class="ti-close"> </i> All',
                    className: ' btn-sm rounded-0 '
                },

            ],
            language: {
                buttons: {
                    selectAll: "Select all items",
                    selectNone: "Select none"
                }
            }
        });

        $.ajax({
            //url: "<!?= base_url('ujian/allujianbytoken') ?>",
            url: "<?= base_url('ujian/get_autocomplete') ?>",
            method: "POST",
            data: {
                code: '',
                token: $(".kodeujian").val()
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader").show(0).delay(600).hide(0);
            },
            error: function() {
                alert($(this).html() + " Error!");
            },
            success: function(data) {
                // console.log(data)
                // showujian.clear().rows.add(data).draw();
                myTable.clear().rows.add(data.data).draw();
                if (data.data.length > 0) {
                    $(".BTNTAKE").show()
                } else {
                    $(".BTNTAKE").hide()
                }
                $.ajax({
                    url: "<?= base_url('ujian/viewallujianbytoken') ?>",
                    method: "POST",
                    data: {
                        token: $(".kodeujian").val()
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").show(0).delay(600).hide(0);
                    },
                    error: function() {
                        alert($(this).html() + " Error!");
                    },
                    success: function(data) {
                        // console.log(data)
                        showujian.clear().rows.add(data).draw();

                    }
                });
            }
        });

        $('#cariSoal').keyup(function() {
            var query = $(this).val();
            if (query !== '') {
                $.ajax({
                    url: "<?= base_url('ujian/get_autocomplete') ?>",
                    method: "POST",
                    data: {
                        code: $(this).val(),
                        token: $(".kodeujian").val()
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").show(0).delay(600).hide(0);
                    },
                    error: function() {
                        alert($(this).html() + " Error!");
                    },
                    success: function(data) {
                        //console.log(data)
                        myTable.clear().rows.add(data.data).draw();
                        if (data.data.length > 0) {
                            $(".BTNTAKE").show()
                        } else {
                            $(".BTNTAKE").hide()
                        }
                    }
                });
            }
        });

        $('#button').click(function() {
            var rowdata = myTable.rows('.selected').data();
            var msg = '';
            // var dataset = [];
            for (var i = 0; i < rowdata.length; i++) {
                msg += rowdata[i][0] + ',';
                //dataset = [rowdata[i][0], rowdata[i][1]];
            }
            if (msg !== '' && msg !== ',') {
                $.ajax({
                    url: "<?= base_url('ujian/set_data') ?>",
                    method: "POST",
                    data: {
                        data: msg,
                        idu: $(".idujian").val(),
                        kode: $(".kodeujian").val(),
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").show(0).delay(600).hide(0);
                    },
                    error: function() {
                        alert($(this).html() + " Error!");
                    },
                    success: function(data) {
                        //console.log(data)
                        showujian.clear().rows.add(data).draw();
                    }
                });
            }
            // dataset.push(rowdata)
            // console.log(rowdata)
            //showujian.rows.add(rowdata).draw();
            myTable.rows('.selected').remove().draw(false);
        });
        $('#cariSoal').keydown(function() {
            myTable.clear().draw();
        });

        $("#Simpans").click(function() {
            if ($("#kunci").val() === "") {
                $(".M-tittle").html("WARNING..!")
                $(".M-body").html("Nama Ujian Harus Dipilih!")
                $(".modal").modal('show');
            } else if ($("#waktu").val() === "") {
                $(".M-tittle").html("WARNING..!")
                $(".M-body").html("Waktu Pengerjaan Harus Terisi!")
                $(".modal").modal('show');
            } else if ($("#start").val() === "" && $("#end").val() === "") {
                $(".M-tittle").html("WARNING..!")
                $(".M-body").html("Tanggal Harus ditentukan!")
                $(".modal").modal('show');
            } else {
                $.ajax({
                    url: "<?= base_url('ujian/prosesujiantoken') ?>",
                    method: "POST",
                    data: {
                        modul: $("#kunci").val(),
                        id: $("#idujian").val(),
                        token: $("#kodeujian").val(),
                        jenis: $("#jenis").val(),
                        waktu: $("#waktu").val(),
                        start: $("#start").val(),
                        end: $("#end").val(),
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").show(0).delay(600).hide(0);
                    },
                    error: function() {
                        alert($(this).html() + " Error!");
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $(".M-tittle").html("<div> <span style = 'width:50px;width:50px;padding:20px; border-radius:50%; background-color:#00b300'> <span class = 'ti-check' style= 'font-size:24px; color:#ffffff' ></span></span ></div><br>");
                            $(".M-body").html("SUCCESS!");

                            $(".modal").modal('show');
                            setInterval(function() {
                                window.location = "<?= base_url('ujian/setujian') ?>";
                            }, 600)
                        }
                    }
                });
            }

        });


        $('button#alertshow').on('click', function() {
            var msg_type = $("#msgtype").val();
        });



    });
</script>
<style>
    td {
        white-space: normal !important;
        word-wrap: break-word;
        text-align: justify;
    }
</style>

<div class="content-wrapper animated bounceInDown">
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card ">
                <div class="card-body">
                    <h3 class="card-title">BANK SOAL STIDKI AR-RAHMAH</h3>
                    <p class="card-description">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" onclick="newsoal()">
                            <i class="ti-plus">&nbsp;</i> Soal Baru
                        </button>

                        <button type="button" onclick="reload()" class="btn btn-secondary btn-sm rounded-0"><i class="ti-reload">&nbsp;</i> Refresh</button>
                    </p>
                    <div class="table-responsive">
                        <table id="Table1" class="table table-sm table-bordered table-striped " style="width:100%">
                            <thead style="background-color: #7580ff; color:#fff">
                                <tr>
                                    <th> User</th>
                                    <th> Soal</th>
                                    <th> Jawaban</th>
                                    <th> Kunci</th>
                                    <th> Bobot</th>
                                    <th> Tampil</th>
                                    <th> Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($soal as $val) :
                                    if ($val->tipesoal == 'uraian') {
                                        $jawaban = "URAIAN";
                                        $kunci = "URAIAN";
                                        $bobot = "URAIAN";
                                    } else {
                                        $jawaban = '   <ol type="A" style="min-width: 180px; ">
                                        <li style="line-height: 1.2;">' . $val->a . '</li>
                                        <li style="line-height: 1.2;">' . $val->b . '</li>
                                        <li style="line-height: 1.2;">' . $val->c . '</li>
                                        <li style="line-height: 1.2;">' . $val->d . '</li>
                                    </ol>';
                                        $kunci = $val->kunci;
                                        $bobot = $val->bobot;
                                    }

                                ?>
                                    <tr id="ID<?= $val->id ?>">
                                        <td>
                                            <?= $val->nama_asli ?>
                                        </td>
                                        <td>
                                            <div class="p-1 mb-2 bg-gradient-primary rounded text-white" style="font-size:10px"> Kategori: <?= strtoupper($val->kategori_soal) ?> </div>
                                            <div style="min-width: 220px; line-height: 1.8;">
                                                <?= $val->soal ?>
                                            </div>
                                        </td>
                                        <td style="text-align: left;">
                                            <?= $jawaban ?>
                                        </td>
                                        <td style="text-align: center;"><?= $kunci ?></td>
                                        <td style="text-align: center;"><?= $bobot ?></td>
                                        <td style="text-align: center;"><?= $val->active ?></td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn  btn-success edit" data-id="<?= $val->id ?>"> <i class="ti-pencil-alt"></i></button>
                                            <button type="button" class="btn  btn-danger hapussoal" data-id="<?= $val->id ?>"> <i class="ti-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal animated bounceInDown" id="modalsoal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header " style=" background-color: #7580ff; color:#fff">
                <h3 class="text-center">SOAL CBT BARU</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <input type="hidden" name="ids" id="ids" val="">
                <div class="form-group">
                    <label class="control-label">Pengajar <span class="text-danger"> * </span></label><br>
                    <select name="pengajar" class="form-control" id="pengajar">
                        <?php foreach ($pengajar as $val) : ?>
                            <option value="<?= $val->id_user ?>"><?= $val->nama_asli ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group ">
                    <label class="control-label">Tipe Soal</label><br>
                    <div id="radioBtnsoal" class="btn-group">
                        <a class="btn btn-primary btn-sm active" data-toggle="tipesoal" data-title="pilihan">Pilihan Ganda </a>
                        <a class="btn btn-primary btn-sm notActive" data-toggle="tipesoal" data-title="uraian">Uraian </a>
                        <input type="hidden" name="tipesoal" id="tipesoal" value="pilihan">
                    </div>
                </div>

                <div class="form-group ">
                    <div for="kategorisoal">Kategori Soal</div>
                    <input id="kategorisoal" type="text" class=" form-control kategorisoal" name="kategori" placeholder="Input kategori">
                    <div class="autocompleteSoal"></div>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Soal Test</label>
                    <textarea class="form-control " id="soal" name="soal" rows="3"></textarea>
                </div>

                <div class=" row" id="jawabanganda">

                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="exampleInputCity1">Jawaban A</label>
                            <input type="text" class="form-control " id="jawabana" name="a">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="exampleInputCity1">Jawaban B</label>
                            <input type="text" class="form-control " id="jawabanb" name="b">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="exampleInputCity1">Jawaban C</label>
                            <input type="text" class="form-control " id="jawabanc" name="c">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="exampleInputCity1">Jawaban D</label>
                            <input type="text" class="form-control " id="jawaband" name="d">
                        </div>
                    </div>
                    <div class="col-md-2 ">

                        <div class="form-group">
                            <label for="kunci">Kunci Jawaban</label>
                            <select class="form-control" id="kunci" name="kunci">
                                <option value="">Pilih Kunci Jawaban</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="form-group">
                            <label for="exampleInputCity1">Bobot</label>
                            <input type="number" class="form-control" name="bobot" id="bobot">
                        </div>
                    </div>
                    <div class="col-md-4 ">

                        <div class="form-group">
                            <label for="kunci">Tampilkan Soal</label>
                            <select class="form-control" id="active" name="active">
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary prosessoal">simpan</button>
            </div>
        </div>
    </div>

</div>

<script>
    function newsoal() {
        $('#jawabanganda').show();
        $("#soal").val("");
        $("#kategorisoal").val("");
        $("#kunci").html("");
        $("#active").html("");
        $("#jawabana").val("");
        $("#jawabanb").val("");
        $("#jawabanc").val("");
        $("#jawaband").val("");
        $("#bobot").val("");
        $(".prosessoal").html("simpan");
        $('#modalsoal').modal('show')
    }
    $(document).ready(function() {

        $('#kategorisoal').keyup(function() {
            var query = $(this).val();
            if (query !== '') {
                $.ajax({
                    url: "<?= base_url('soal/get_autocomplete') ?>",
                    method: "POST",
                    data: {
                        code: $(this).val(),
                    },
                    error: function() {
                        alert($(this).html() + " Error!");
                    },
                    success: function(data) {
                        $('.autocompleteSoal').fadeIn();
                        $('.autocompleteSoal').html(data);

                    }
                });
            }
        });
        $("#kategorisoal").keydown(function() {
            $('.autocompleteSoal').fadeOut();
        })
        $("#kategorisoal").keypress(function() {
            $('.autocompleteSoal').fadeOut();
        })
        $("#kategorisoal").change(function() {
            $('.autocompleteSoal').fadeOut();
        })
        $(document).on('click', 'li', function() {
            $('#kategorisoal').val($(this).text());
            $('.autocompleteSoal').fadeOut();
        });
    });

    $(".prosessoal").click(function() {
        if ($(this).html() === 'simpan') {
            var pengajar = $("#pengajar").val();
            var tipesoal = $("#tipesoal").val();
            var kategori = $("#kategorisoal").val();
            var soal = $("#soal").val();
            var a = $("#jawabana").val();
            var b = $("#jawabanb").val();
            var c = $("#jawabanc").val();
            var d = $("#jawaband").val();
            var kunci = $("#kunci").val();
            var bobot = $("#bobot").val();
            var active = $("#active").val();
            $.ajax({
                url: "<?= base_url('soal/prosesdata') ?>",
                method: "POST",
                data: {
                    pengajar: pengajar,
                    tipesoal: tipesoal,
                    kategori: kategori,
                    soal: soal,
                    a: a,
                    b: b,
                    c: c,
                    d: d,
                    kunci: kunci,
                    bobot: bobot,
                    active: active,
                },
                beforeSend: function() {
                    $(".loader").show(0).delay(1000).hide(0);
                },
                error: function() {
                    alert($(this).html() + " Error!");
                },
                success: function(data) {
                    $('#jawabanganda').show();
                    $("#soal").val("");
                    $("#kategorisoal").val("");
                    $("#kunci").html("");
                    $("#active").html("");
                    $("#jawabana").val("");
                    $("#jawabanb").val("");
                    $("#jawabanc").val("");
                    $("#jawaband").val("");
                    $("#bobot").val("");
                    $(".prosessoal").html("simpan");
                    $("#modalsoal").modal('hide');
                    $('table tbody').html(data);
                }
            });
        } else if ($(this).html() === 'edit') {
            var id = $("#ids").val();
            var pengajar = $("#pengajar").val();
            var tipesoal = $("#tipesoal").val();
            var kategori = $("#kategorisoal").val();
            var soal = $("#soal").val();
            var a = $("#jawabana").val();
            var b = $("#jawabanb").val();
            var c = $("#jawabanc").val();
            var d = $("#jawaband").val();
            var kunci = $("#kunci").val();
            var bobot = $("#bobot").val();
            var active = $("#active").val();
            $.ajax({
                url: "<?= base_url('soal/prosesdata') ?>",
                method: "POST",
                data: {
                    id: id,
                    pengajar: pengajar,
                    tipesoal: tipesoal,
                    kategori: kategori,
                    soal: soal,
                    a: a,
                    b: b,
                    c: c,
                    d: d,
                    kunci: kunci,
                    bobot: bobot,
                    active: active,
                },
                beforeSend: function() {
                    $(".loader").show(0).delay(1000).hide(0);
                },
                error: function() {
                    alert($(this).html() + " Error!");
                },
                success: function(data) {
                    $('#jawabanganda').show();
                    // console.log(data)
                    $("#ids").val("");
                    $("#kategorisoal").val("");
                    $("#soal").val("");
                    $("#jawabana").val("");
                    $("#jawabanb").val("");
                    $("#jawabanc").val("");
                    $("#jawaband").val("");
                    $(".prosessoal").html("simpan");
                    $("#modalsoal").modal('hide');
                    $('table tbody').html(data);
                }
            });
        }
    })

    $('table tbody').on('click', '.edit', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "<?= base_url('soal/viewdata') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function() {
                $(".loader").show(0).delay(1000).hide(0);
            },
            error: function() {
                alert($(this).html() + " Error!");
            },
            success: function(data) {
                $("#ids").val(data.id);
                $("#radioBtnsoal").html(data.tipe);
                $("#soal").val(data.soal);
                $("#kategorisoal").val(data.kategori_soal);
                $("#pengajar").html(data.modul);
                $("#kunci").html(data.kunci);
                $("#active").html(data.active);
                $("#jawabana").val(data.a);
                $("#jawabanb").val(data.b);
                $("#jawabanc").val(data.c);
                $("#jawaband").val(data.d);
                $("#bobot").val(data.bobot);
                $(".prosessoal").html("edit");
                $("#modalsoal").modal("show")
            }
        });
    })
    $('#radioBtnsoal a').on('click', function() {
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#' + tog).prop('value', sel);

        $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');

        if (sel == 'pilihan') {
            $('#jawabanganda').show();
        } else {
            $('#jawabanganda').hide();
        }

    });
    $('table tbody').on('click', '.hapussoal', function() {
        var id = $(this).data('id');

        $(".alert_msg .modal-body .M-tittle").html("HAPUS SOAL UJIAN")
        $(".alert_msg .modal-body .M-body").html("Anda yakin ingin menghapus soal ujian?")
        $(".alert_msg .modal-body .M-action").html("<br><button type='button' class='btn btn-secondary rounded-0 m-1' data-dismiss='modal'>Tidak</button><button id='Hapus' class='btn btn-primary rounded-0 m-1' data-id='" + id + "'> HAPUS</button>")
        $(".alert_msg").modal("show");

    });
    $(".alert_msg .modal-body span").on('click', '#Hapus', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "<?= base_url('soal/hapussoal') ?>",
            method: "POST",
            data: {
                id: id,
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader").show(0).delay(600).hide(0);
            },
            error: function() {
                alert($(this).html() + " Error!");
            },
            success: function(data) {
                $(".alert_msg .modal-body .M-tittle").html("<div><span > <span class = 'ti-trash' style= 'font-size:32px; color:#ff0000' ></span></span></div><br>");
                $(".alert_msg .modal-body .M-body").html("SOAL UJIAN")
                $(".alert_msg .modal-body .M-action").html("Berhasil di hapus!");
                $(".alert_msg").modal("show");
                $("#ID" + id).remove();
                //console.log(data);
            }
        });
    })
</script>
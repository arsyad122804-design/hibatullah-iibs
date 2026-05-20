<style>
    #radioBtn .notActive {
        color: #3276b1;
        background-color: #fff;
    }
</style>
<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="min-height-200px">
            <div class="row align-items-center mb-20">
                <div class="col-sm-7">
                    <h4> <span class="fa fa-address-book-o"></span> Profile User</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
                <div class="col-sm-5 text-right">
                    <a id="BackBTN" href="#" class="btn  btn-info backdata btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>

            <div class="wizard-content">

                <form action="<?= base_url() ?>pmb_api/pendaftar/update_data" method="POST" enctype="multipart/form-data">
                    <section>
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" class="idPelajar form-control-sm" name="idPelajar">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Lengkap </label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control form-control-sm Nama_lengkap" name="Nama_lengkap" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control form-control-sm  jns_kelamin" name="jns_kelamin">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kota Kelahiran</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control cs1 KotaLahir" name="KotaLahir" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm dateset-control-page Tlahir" autocomplete="off" placeholder="input tanggal" type="text" name="Tlahir" data-date-end-date="0d">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Alamat Rumah</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control form-control-sm Alamat_rumah" name="Alamat_rumah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Ayah/Ibu</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm Nama_Wali" type="text" autocomplete="off" name="Nama_Wali">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Telepon</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm  Telepon_Wali" type="text" autocomplete="off" name="Telepon_Wali">
                                    </div>
                                </div>

                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn btn-md btn-primary" value="Proses Data">
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var url = '<?= base_url() ?>';

    function clearDta() {
        // $(".tab-wizard").steps("reset");
        $('form .Nama_lengkap').val("");
        $('form .Nama_Panggilan').val("");
        $('form .NIK').val("");
        $('form .NIS').val("");
        $('form .Tlahir').val("");

        $('form .Alamat_rumah').val("");
        $('form .Nama_Wali').val("");
        $('form .Telepon_Wali').val("");

        $('#chekwali').prop('value', "N");

        $('a[data-toggle="chekwali"]').not('[data-title="N"]').removeClass('active').addClass('notActive');

        $('a[data-toggle="chekwali"][data-title="N"]').removeClass('notActive').addClass('active');
        $(".Nama_Wali").prop('required', false);
        $(".NIK_Wali").prop('required', false);
        $(".Telepon_Wali").prop('required', false);
        $(".Pekerjaan_Wali").prop('required', false);
        $(".Penghasilan_Wali").prop('required', false);
        $(".CRWALI").show();


        $('form .Tdaftar').val("");
        $('form .Jabatan').val("");
        $('form .Kontak').val("");

        var jb = '<option value="">-pilih jalur-</option><option value="1">Reguler</option><option value="2">Beasiswa</option>';
        $('form #JalurDaftar').html(jb);

        $(".BS_daftar").css("display", "none");
        $('form .jns_kelamin').html(
            '<option option value="0" > -Pilih Jenis -</option > ' +
            '<option value="1">Laki - Laki</option>' +
            '<option value="2">Perempuan</option>');
        $('form .file').val("");
        $('form .Image').val("null");
        $(".picture-src").attr("src", url + "img_pelajar/default.png");
    }


    $(function() {
        ////////////////////////////////////
        ////////////////////////////////////
        $('form').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $(".loader").show(0);
                    // $('.FormOpenPelajar').modal("hide");
                },
                error: function(x) {
                    console.log(x.responseText);
                    alert("error!");
                },
                success: function(data) {
                    console.log(data);
                    $(".loader").fadeOut(1000);
                    // table.ajax.reload();
                    $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
                    $('.event-title').html(data.event.title);
                    $('.event-body').html(data.event.description);
                    $('.event-footer').html(data.event.footer);
                    $('#Msg-Notification').modal('show');
                    setTimeout(function() {
                        $(".loader").show(0).fadeOut(1000);
                        window.location.href = '<?= base_url() ?>';
                    }, time);
                }
            });
        });
        var id = '<?= $idus ?>';
        var V_lembaga;
        $.ajax({
            url: url + 'pmb_api/pendaftar/get_data_by_id',
            method: "POST",
            data: {
                id: id,
            },
            dataType: "json",
            beforeSend: function() {

                $(".loader").show(0);
                clearDta()
            },
            error: function(x) {
                alert("error!");
                console.log(x.responseText);
            },
            success: function(data) {
                // console.log($("a#BackBTN").attr('href', ''));
                $("a#BackBTN").attr("href", url + "pmb/datadiri/" + data.token)
                $(".loader").fadeOut(1000);
                V_lembaga = '<option value="' + data.dt1.cabang_id + '">' + data.dt1.nama_cabang + '</option>';
                $.each(data.cabang, function(i, row) {
                    if (data.dt1.cabang_id === row.id) {} else {
                        V_lembaga += '<option value="' + row.id + '">' + row.nama_cabang + '</option>';
                    }
                });
                var V_Kota = '<option value="' + data.dt1.id_kota + '">' + data.dt1.kota_lahir + '</option>'
                $.each(data.kota, function(i, row) {
                    if (data.dt1.id_kota === row.id) {} else {
                        V_Kota += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var iddesa = data.dt1.id_kelurahan;
                var iddset1, iddset2;
                if (iddesa > 0) {
                    iddset1 = iddesa.substring(0, 4);
                    iddset2 = iddesa.substring(0, 7);
                } else {
                    iddset1 = '';
                    iddset2 = '';
                }
                var V_Kota2 = '<option value="' + iddset1 + '">' + data.dt1.kota + '</option>'
                $.each(data.kota, function(i, row) {
                    if (iddset1 === row.id) {} else {
                        V_Kota2 += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                $('.jns_kelamin option[value=' + data.dt1.jns_kelamin + ']').attr('selected', 'selected');

                var T_lahir = formarDate(data.dt1.tgl_lahir);
                var T_Aktif = formarDate(data.dt1.tgl_pendaftaran);
                $('form .Nama_lengkap').val(data.dt1.nama_lengkap);
                $('form .Nama_Panggilan').val(data.dt1.nama_panggilan);
                $('form .Tlahir').val(T_lahir);
                $('form .Alamat_rumah').val(data.dt1.alamat);
                $('form .KotaLahir').html(V_Kota);
                $('form .Nama_Wali').val(data.dt1.wali_peserta);
                $('form .Telepon_Wali').val(data.dt1.phone);
                $('form #ST_ANAK').val(data.dt1.st_anak);
                var gamb = 'default.png';
                if (data.dt1.gambar) {
                    gamb = data.dt1.gambar;
                }
                $(".picture-src").attr("src", url + "img_pelajar/" + gamb);
                $(".Image").val(data.dt1.gambar);

                //console.log(data.dt1.gambar);
                var pic = '<img src="' + url + 'assets/img_pelajar/' + gamb + '" style="width:140px">';
                $('form .Data_photo').html(pic);
                $('form .File_Old').val(data.dt1.gambar);
                // $('.options').html('<i class="fa fa-plus-circle"></i> ' + opt);
                $('form .idPelajar').val(id);
                // $('.FormOpenPelajar').modal();
            }
        });




    })

    function formarDate(e) {
        var date = new Date(e);
        var month = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ][date.getMonth()];
        var day = date.getDate();
        var FullDate = day + ' ' + month + ' ' + date.getFullYear();
        return FullDate;
    };
</script>
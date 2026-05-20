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
                    <h4> <span class="fa fa-file-o"></span> Formulir PPDB</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
                <div class="col-sm-5 text-right">
                    <a id="BackBTN" href="<?= base_url("pmb/pendaftar") ?>" class="btn  btn-info backdata btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>

            <div class="wizard-content">

                <form action="<?= base_url() ?>pmb_api/pendaftar/new_data" method="POST" enctype="multipart/form-data">
                    <section>
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" class="idPelajar form-control-sm" name="idPelajar">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Unit / Cabang </label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control  Cabang" name="Cabang" style="width: 100%;" required>
                                            <?= $cabang; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Periode Pendaftaran </label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control  Periode" name="Periode" style="width: 100%;" required>
                                            <option value="">- Pilih -</option>
                                            <?php foreach ($periode as $pr): ?>
                                                <option value="<?= $pr->tahun_akademik ?>" data-nominal="<?= $pr->nominal ?>"><?= $pr->tahun_akademik; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" class="form-control Nominal" name="Nominal" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Lengkap </label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control form-control-sm Nama_lengkap" name="Nama_lengkap" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control form-control-sm  jns_kelamin" name="jns_kelamin" required>
                                            <option value="">- Pilih - </option>
                                            <option value="1">Laki-Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kota Kelahiran</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control cs1 KotaLahir" name="KotaLahir" style="width: 100%;" required>
                                            <option value=""> -Pilih -</option>
                                            <?php foreach ($kota as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->kota; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm dateset-control-page Tlahir" autocomplete="off" placeholder="input tanggal" type="text" name="Tlahir" data-date-end-date="0d" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Sekolah Asal</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control form-control-sm Sekolah_asal" name="Sekolah_asal" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Ayah/Ibu</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm Nama_Wali" type="text" autocomplete="off" name="Nama_Wali" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Alamat Domisili</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control form-control-sm Alamat_rumah" name="Alamat_rumah" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kota </label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control cs1 KotaAlamat" name="KotaAlamat" style="width: 100%;" required>
                                            <option value=""> -Pilih -</option>
                                            <?php foreach ($kota as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->kota; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kecamatan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control cs1 KecAlamat" name="KecAlamat" style="width: 100%;" required>
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kelurahan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 form-control cs1 KelAlamat" name="KelAlamat" style="width: 100%;" required>
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">WhatsApp Orang Tua</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm  Telepon_Wali" type="text" autocomplete="off" name="Telepon_Wali" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm  EmailWali" type="email" autocomplete="off" name="EmailWali" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm  BuktiFile" type="file" autocomplete="off" name="BuktiFile" required>
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
        $("select.Periode").change(function() {
            var nom = $(this).find(':selected').data('nominal');
            $(".Nominal").val(nom);
            console.log(nom);
        })
        $(".Cabang").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: url + "/get_periodeset",
                data: {
                    id: id
                },
                success: function(data) {}
            });

        })
        ////////////////////////////////////
        ////////////////////////////////////
        $('form').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // Ambil URL dari atribut 'action' form
                method: "POST", // Metode POST untuk pengiriman data
                data: formData, // Data dari form
                dataType: "json", // Harapkan data kembali dalam format JSON

                // Opsi penting untuk pengiriman file
                contentType: false, // Harus false untuk menghindari pengaturan content-type yang salah
                processData: false, // Harus false untuk mencegah data diubah menjadi string

                beforeSend: function() {
                    $(".loader").show(0); // Tampilkan loader saat proses upload dimulai
                },
                error: function(xhr, status, error) {
                    // Tampilkan kesalahan di console untuk debugging
                    console.log("Error: " + xhr.responseText);
                    alert("Error occurred!");
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
                        window.location.href = '<?= base_url("/pmb/pendaftar") ?>';
                    }, time);
                }
            });
        });

        $(".KotaAlamat").change(function() {
            var id = $(this).val();
            var V_kec;
            $.ajax({
                url: url + 'data_api/wilayah/get_kecamatan',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                error: function() {
                    alert("ERROR");
                },
                success: function(data) {
                    if (data.kec.length > 0) {
                        V_kec = '<option value=""> -Pilih Kecamatan -</option>'
                        $.each(data.kec, function(i, row) {
                            V_kec += '<option value="' + row.id + '">' + row.kecamatan + '</option>';
                        });
                    } else {
                        V_kec = '<option value=""> No Result Data</option>'
                    };
                    $('.KecAlamat').html(V_kec);
                }
            })
        })
        $(".KecAlamat").change(function() {
            var id = $(this).val();
            var V_kel;
            $.ajax({
                url: url + 'data_api/wilayah/get_kelurahan',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                error: function() {
                    alert("ERROR");
                },
                success: function(data) {
                    if (data.kel.length > 0) {
                        V_kel = '<option value=""> -Pilih Kelurahan -</option>'
                        $.each(data.kel, function(i, row) {
                            V_kel += '<option value="' + row.id + '">' + row.kelurahan + '</option>';
                        });
                    } else {
                        V_kel = '<option value=""> No Result Data</option>'
                    };
                    $('.KelAlamat').html(V_kel);
                }
            })
        })

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
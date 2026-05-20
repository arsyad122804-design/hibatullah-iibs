<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">

        <div class="rounded">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100 d-flex flex-column justify-content-center p-2">
                        <?php if (!empty($periode->error != 1)) : ?>
                            <h1 class="mb-4 text-center">Formulir Pendaftaran</h1>
                            <?= form_open(base_url() . "formulir/register", array('id' => 'periodik')); ?>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <!-- <1?= json_encode($program); ?> -->
                                    <input type="hidden" name="token" value="<?= $token ?>">
                                    <input type="hidden" name="aff_token" value="<?= $this->session->userdata('aff_token_setting'); ?>">
                                    <div class="form-group">
                                        <label for="gProgram">Jenjang</label>
                                        <select name="program" id="gProgram" class="form-control bg-white" required>
                                            <option value="">- Pilih Jenjang -</option>
                                            <?php foreach ($program->data as $pr): ?>
                                                <option value="<?= $pr->id ?>" data-name="<?= $pr->nama_cabang ?>"><?= $pr->nama_cabang ?></option>
                                            <?php endforeach; ?>
                                            <!-- <option value="sd">SD Hibatullah</option>
                                            <option value="smp">SMP Hibatullah</option> -->
                                        </select>
                                        <input type="hidden" class="form-control Tingkat" name="Tingkat" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gPeriode">Tahun Ajaran</label>
                                        <select name="periode" id="gPeriode" class="form-control bg-white" required>
                                            <?php if (count($periode->data) > 1) : ?>
                                                <option value="">- Tahun Ajaran -</option>
                                            <?php endif; ?>
                                            <?php foreach ($periode->data as $prg) : ?>
                                                <option value="<?= $prg->tahun_akademik ?>" data-nominal="<?= $prg->nominal ?>"><?= $prg->tahun_akademik ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" class="form-control Nominal" name="Nominal" value="">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="gNama">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nm_lengkap" id="gNama" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gProgram">Tempat Lahir</label>
                                        <select name="kota_lahir" id="gKota_lahir" class="custom-select2 form-control  " required>
                                            <option value="">- Kabupaten/Kota -</option>
                                            <?php if (count($kota->data) > 1) : ?>
                                            <?php endif; ?>
                                            <?php foreach ($kota->data as $ktl) : ?>
                                                <option value="<?= $ktl->id ?>"><?= $ktl->kota ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gTgl">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tgl_lahir" id="gTgl" required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gNama">Jenis Kelamin</label>
                                        <select name="gender" class="form-control bg-white" id="gender" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="1">Laki-Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gSKA">Sekolah Asal</label>
                                        <input type="text" class="form-control" name="sekolah_asal" id="gSekolah" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="cAyah">Nama Ayah/Ibu</label>
                                        <input type="text" class="form-control" id="cAyah" name="wali" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="gAlamat">Alamat Domisili</label>
                                        <textarea class="form-control" id="gAlamat" name="alamat" style="height: 100px" required /></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="gAlamat">Kota</label>
                                        <select name="Kota" id="gKota" class="custom-select2 form-control " required>
                                            <option value="">- Kabupaten/Kota -</option>
                                            <?php if (count($kota->data) > 1) : ?>
                                            <?php endif; ?>
                                            <?php foreach ($kota->data as $ktl) : ?>
                                                <option value="<?= $ktl->id ?>"><?= $ktl->kota ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="gAlamat">Kecamatan</label>
                                        <select class="custom-select2 form-control cs3 kecamatan" style="width: 100%;" name="kecamatan" id="gKecamatan" required>
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="gAlamat">Kelurahan</label>
                                        <select class="custom-select2  form-control cs4 Kelurahan" name="Kelurahan" id="gKelurahan" required style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phon">WhatsApp Orang Tua</label>
                                        <input type="text" class="form-control" id="phon" name="telepon" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gmail">Email Aktif</label>
                                        <input type="email" class="form-control" name="email" id="gmail" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        <?php else : ?>
                            <h1 class="mb-4">Mohon maaf, pendaftaran peserta didik baru belum di buka</h1>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="<?= base_url('assets/') ?>img/appointment1.jpg" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->
<script>
    var url = '<?= base_url() ?>';
    $("select#gPeriode").change(function() {
        var nom = $(this).find(':selected').data('nominal');
        $(".Nominal").val(nom);
    });

    $("form").submit(function() {
        $('#spinner').addClass('show');
    })
    $("#gKota").change(function() {
        var id = $(this).val();
        var V_kec;
        $.ajax({
            url: url + 'formulir/get_kecamatan',
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
                $('form .kecamatan').html(V_kec);
            }
        })
    })
    $(".kecamatan").change(function() {
        var id = $(this).val();
        var V_kel;
        $.ajax({
            url: url + 'formulir/get_kelurahan',
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
                $('form .Kelurahan').html(V_kel);
            }
        })
    })
</script>
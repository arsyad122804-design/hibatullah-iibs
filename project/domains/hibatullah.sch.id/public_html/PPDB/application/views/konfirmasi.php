<!-- Appointment Start -->
<?php if ($data->data->status > 0) : ?>
    <!-- Appointment Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                        <div class="h-100 d-flex flex-column justify-content-center p-4 ">
                            <div class="col-md-12 text-center">
                                <h1 class="mb-4 text-center">Terimakasih</h1>
                                <p>Registrasi dan aktifasi akun anda sedang kami proses.</p>
                                <p>Kami akan mengirimkan <b>AKUN PPDB</b> anda melalui email <b><?= $data->data->email ?></b> </p>
                                <p>Jika dalam waktu 1-2 hari kerja belum ada notifikasi di email, silahkan hubungi kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php
    $gender = '-';
    if ($data->data->jns_kelamin == 1) {
        $gender = 'Laki-Laki';
    } elseif ($data->data->jns_kelamin == 2) {
        $gender = 'Perempuan';
    } ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                        <div class="h-100 d-flex flex-column justify-content-center p-2 py-3 ">
                            <div class="col-md-12">
                                <h1 class="mb-4 text-center">Konfirmasi Pembayaran</h1>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6 ">
                                    <div style="background-color: #f7d917; padding:4px 10px">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="text-align:left;font-weight:900">No. Registrasi</td>
                                                <td style="text-align:right;font-weight:900; font-size:14pt">#<?= $data->data->nomor_registrasi ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
                                        <div class="col">
                                            <div style="margin-top:1%">
                                                <div style="padding:4px 10px">
                                                    <div style="font-weight:500; font-size:14pt; margin-bottom:6px;text-align:left">Data Calon Peserta Didik Baru :</div>
                                                    <table style="width:100%;text-align:left">
                                                        <tr>
                                                            <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:110px"><b>Nama Lengkap</b></td>
                                                            <td style="width:10px">: </td>
                                                            <td><?= strtoupper($data->data->nama_lengkap) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:110px"><b>Panggilan</b></td>
                                                            <td style="width:6px">: </td>
                                                            <td><?= strtoupper($data->data->nama_panggilan) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:110px"><b>Jenis Kelamin</b></td>
                                                            <td style="width:6px">: </td>
                                                            <td><?= strtoupper($gender) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
                                                            <td>: </td>
                                                            <td><?= $data->data->phone ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
                                                            <td>: </td>
                                                            <td><?= $data->data->email ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px; padding:10px; border-radius:10px; background-color:#f7d917">
                                        <table style="width:100%">
                                            <thead>
                                                <th style="text-align: left;font-weight:500; font-size:14pt; ">Pembayaran</th>
                                                <th style="text-align:right;font-weight:500; font-size:14pt; ">Nominal</th>
                                            </thead>
                                            <tr>
                                                <td style="text-align: left; font-size:14pt;;font-weight:700">Formulir Registrasi</td>
                                                <td style="text-align:right; font-size:32px; font-weight:800">
                                                    Rp. <?= number_format($data->data->nominal) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>
                                    <p>Pastikan nominal pembayaran sesuai dengan yang di atas, agar proses validasi lebih mudah. </p>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_open(base_url() . "pmb/rekonfirmasi", array('id' => 'rekonfirmasi')); ?>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <input type="hidden" name="token" value="<?= $token ?>" />
                                            <input type="hidden" name="noregister" value="<?= $data->data->nomor_registrasi ?>" />
                                            <input type="hidden" name="jns" value="<?= $data->data->jns ?>" />
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="rekpengirim" id="gNama" placeholder="No. Rekening Pengirim" required />
                                                <label for="gNama">No. Rek Pengirim</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0" name="atasnama" id="gAtasNama" placeholder="Atas Nama" required />
                                                <label for="gAtasNama">Atas Nama</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div for="imgf5">Upload Bukti Pembayaran</div>
                                                <input type="file" class="form-control form-control-file border-0 imgf" name="panggilan" data-row="5" id="imgf5" required />
                                            </div>
                                            <input type="hidden" class="text5 Image" name="nota" value="null">
                                            <div class="Spins table-responsive" style="max-height: 200px;">
                                                <img src="/img_karyawan/default.png" class="picture-src " style="width: 100%;" id="imgv5" title="" />
                                            </div>
                                        </div>
                                        <div class="col-12 BTN_SET" style="display: none;">
                                            <button class="btn btn-primary w-100 py-3" type="submit">Proses Data</button>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<script>
    $(".imgf").change(function() {
        var id = $(this).data("row");
        var fd = new FormData();
        var files = $('#imgf' + id)[0].files;
        if (files.length > 0) {
            fd.append('file', files[0]);
            // console.log(fd);
            $.ajax({
                url: '<?= base_url() ?>pmb/uploads_img',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $(".BTN_SET").css('display', 'none');
                    // $("#spinner").show(0);
                    $("#imgv" + id).attr("src", '<?= base_url() ?>assets/img/spin.svg');
                    $("#imgv" + id).show();
                },
                onerror: function(x) {
                    console.log(x.responseText);
                },
                success: function(response) {
                    // $("#spinner").fadeOut(1000);
                    // console.log(response)
                    if (response != 0) {
                        $(".text" + id).val(response.nimg);
                        $("#imgv" + id).attr("src", '<?= base_url() ?>' + response.img);
                        $("#imgv" + id).show();
                        $(".BTN_SET").css('display', 'block');
                    } else {
                        $(".BTN_SET").css('display', 'none');
                        alert('file not uploaded');
                    }
                },
            });
        } else {
            alert("Please select a file.");
        }
    });
</script>
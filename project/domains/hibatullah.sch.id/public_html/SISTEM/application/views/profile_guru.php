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
                    <h4> <span class="fa fa-address-book-o"> </span> Edit Profile User</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
                <div class="col-sm-5 text-right">
                    <a href="<?= base_url('profile') ?>" class="btn btn-md btn-info"> <i class="fa fa-arrow-left"> </i> Batal Edit</a>
                </div>
            </div>

            <div class="wizard-content">
                <form action="<?= base_url() ?>data_api/asatidzah/new_data" method="POST" enctype="multipart/form-data" class="tab-wizard wizard-circle wizard">
                    <h5>Data Diri</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Data Diri</h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" class="idAsatidzah form-control" name="idAsatidzah">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label ">Nama Lembaga</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select form-control-sm Lembaga" name="Lembaga" required>
                                            <?= $cabang; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">NIK</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="number" class="form-control NIK" name="NIK" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Lengkap </label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control Nama_lengkap" name="Nama_lengkap" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Nama Panggilan </label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control Nama_Panggilan" name="Nama_Panggilan" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control  jns_kelamin" name="jns_kelamin">
                                            <option value=""> -Pilih Jenis -</option>
                                            <option value="1">Laki - Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kota Kelahiran</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 cs1 KotaLahir" name="KotaLahir" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control dateset-control-page Tlahir" autocomplete="off" placeholder="input tanggal" type="text" name="Tlahir" data-date-end-date="0d">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Status Pernikahan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control  StatusMenikah" name="StatusMenikah">
                                            <option value=""> -Pilih Status -</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Duda">Duda</option>
                                            <option value="Janda">Janda</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Alamat </h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Alamat </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Alamat Rumah</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control Alamat_rumah" name="Alamat_rumah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kota Alamat</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 cs2 Kota_alamat" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2  col-form-label">Kecamatan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2 cs3 kecamatan" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Kelurahan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="custom-select2  cs4 Kelurahan" name="Kelurahan" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Hafalan</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Hafalan Al-Qur'an</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Jumlah Hafalan</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" class="form-control Hafalan" name="Hafalan" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Sanad Al-Qur'an</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group">
                                            <div id="radioBtn" class="btn-group">
                                                <a class="btn btn-primary radioBtnChk btn-sm active" data-toggle="Sanad" data-title="BERSANAD">BERSANAD</a>
                                                <a class="btn btn-primary radioBtnChk btn-sm notActive" data-toggle="Sanad" data-title="TIDAK">TIDAK</a>
                                            </div>
                                            <input type="hidden" name="Sanad" id="Sanad" value="BERSANAD">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Pendidikan</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Riwayat Pendidikan</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">TK/PAUD</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control TK" name="TK" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THTK" name="THTK" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">SD/MI</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control SD" name="SD" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THSD" name="THSD" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">SMP/MTs</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control SMP" name="SMP" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THSMP" name="THSMP" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">SMA/MA</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control SMA" name="SMA" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THSMA" name="THSMA" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">S1</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control S1" name="S1" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THS1" name="THS1" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">S2</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control S2" name="S2" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THS2" name="THS2" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">S3</label>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control S3" name="S3" autocomplete="off" style="max-width:280px">
                                            <input type="text" class="form-control THS3" name="THS3" placeholder="Lulus Tahun" style="max-width:100px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Kompetensi</h5>
                    <section>
                        <div>
                            <div class="card INU" style="display: block; width:100%">
                                <div class="card INS" style="display: block;">
                                    <div class="card-header">
                                        <span style="font-weight: 800;">Data Kompetensi</span>
                                    </div>
                                    <div id="cart" class=" x_panel bookmark-height-well well well-sm table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead style="font-size: 10px;">
                                                <th>Tanggal </th>
                                                <th>Jenis </th>
                                                <th>Tingkat</th>
                                                <th>Keterangan</th>
                                                <th>Bukti</th>
                                                <th>Opsi</th>
                                            </thead>
                                            <tbody class="cartBodyK"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header mt-3">
                                    <span style="font-weight: 800;">Input Kompetensi Baru</span>
                                </div>
                                <div class="card-body">
                                    <div class="col-sm-12 row">
                                        <div class="col-md-3 BarangBox">
                                            <input type="hidden" id="Iddtl" class="Iddtl" value="newdtl">
                                            <label class="col-form-label">Tanggal</label>
                                            <input class="form-control dateset-control-page K1" autocomplete="off" placeholder="input tanggal" type="text" data-date-end-date="0d">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label">Jenis Kompetensi</label>
                                            <input type="text" class="form-control col-12 K2" style="width: 100%;" id="JenisKompetensi">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label">Tingkat</label>
                                            <select class="form-control K3">
                                                <option value="">--Pilih Tingkat--</option>
                                                <option value="Kelurahan">Kelurahan</option>
                                                <option value="Kecamatan">Kecamatan</option>
                                                <option value="Kabupaten/kota">Kabupaten/kota</option>
                                                <option value="Provinsi">Provinsi</option>
                                                <option value="Nasional">Nasional</option>
                                                <option value="Internasional">Internasional</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label">Keterangan</label>
                                            <input type="text" class="form-control K4" />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label">Bukti</label>
                                            <div>
                                                <div class="Spins">
                                                    <img src="/img_karyawan/default.png" class="picture-src1 " style="width: 100px;" id="imgv1" title="" />
                                                </div>
                                                <input type="file" class="file imgf" data-show-preview="false" data-row="1" id="imgf1" />
                                            </div>
                                            <input type="hidden" class="text1 Image K5" value="null">
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <div class="col-form-label">&nbsp;</div>
                                            <button type="button" class="add btn btn-success Btn_add"><i class="fa fa-plus-circle" aria-hidden="true"></i> OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Aktifasi</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Aktifasi </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Tanggal Aktif</label>
                                    <div class="col-sm-12 col-md-9">
                                        <input class="form-control dateset-control-page Taktif" autocomplete="off" placeholder="input tanggal" type="text" name="Taktif" data-date-end-date="0d" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-12 col-md-9">
                                        <input class="form-control Jabatan" type="text" autocomplete="off" name="Jabatan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Nomor Kontak</label>
                                    <div class="col-sm-12 col-md-9">
                                        <input class="form-control Kontak" type="text" autocomplete="off" name="Kontak">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Status</label>
                                    <div class="col-sm-12 col-md-9">
                                        <select name="Status" id="Status" class="form-control datapicker Status" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 bg-light ">
                                        <div class="btn btn-block btn-mdb-color btn-rounded float-left">
                                            <label style="color: #0a0a0a; ">Photo Img</label><br>
                                            <div class="Spins">
                                                <img src="/img_karyawan/default.png" class="picture-src " style="width: 100px;" id="imgv5" title="" />
                                            </div>
                                            <input type="file" class="file imgf" data-show-preview="false" data-row="5" id="imgf5" />
                                        </div>
                                        <input type="hidden" class="text5 Image" name="Image" value="null">
                                    </div>
                                    <div class="col-md-6  bg-light ">
                                        <div class="btn btn-block btn-mdb-color btn-rounded float-left">
                                            <label style="color: #0a0a0a; ">Tanda Tangan</label><br>
                                            <div class="Spins">
                                                <img src="/img_karyawan/default.png" class="picture-src " style="width: 100px;" id="imgv6" title="" />
                                            </div>
                                            <input type="file" class="file imgf" data-show-preview="false" data-row="6" id="imgf6" />
                                        </div>
                                        <input type="hidden" class="text6 Ttd" name="Ttd" value="null">
                                    </div>
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
    function clearDta() {
        // $(".tab-wizard").steps("reset");
        $('form .Nama_lengkap').val("");
        $('form .Nama_Panggilan').val("");
        $('form .Tlahir').val("");
        $('form .Alamat_rumah').val("");
        $('form .kecamatan').html("");
        $('form .Kelurahan').html("");
        $('form .Hafalan').val("");
        $('form .TK').val("");
        $('form .SD').val("");
        $('form .SMP').val("");
        $('form .SMA').val("");
        $('form .S1').val("");
        $('form .S2').val("");
        $('form .S3').val("");
        $('form .NIK').val("");
        $('form .THTK').val("");
        $('form .THSD').val("");
        $('form .THSMP').val("");
        $('form .THSMA').val("");
        $('form .THS1').val("");
        $('form .THS2').val("");
        $('form .THS3').val("");
        $('form .Taktif').val("");
        $('form .Jabatan').val("");
        $('form .Kontak').val("");
        $('form .Data_photo').html("");
        $('form .file').val("");
        $('form .Image').val("null");
        $('form .StatusMenikah').html(
            '<option value=""> -Pilih Status -</option>' +
            '<option value="Belum Menikah">Belum Menikah</option>' +
            '<option value="Menikah">Menikah</option>' +
            '<option value="Duda">Duda</option>' +
            '<option value="Janda">Janda</option>'
        );
        $(".picture-src").attr("src", url + "img_karyawan/default.png");
        $(".picture-src1").attr("src", url + "img_karyawan/berkas.png");

        var sanads = '<a class="btn btn-primary radioBtnChk btn-sm active" data-toggle="Sanad" data-title="BERSANAD">BERSANAD</a>' +
            '<a class="btn btn-primary radioBtnChk btn-sm notActive" data-toggle="Sanad" data-title="TIDAK">TIDAK</a>'
        $('form #radioBtn').html(sanads);
    }
    $(function() {

        ////////////////////////////////////
        // mengambil data button ketika button dengan class add di click
        $('.Btn_add').click(function() {
            var tgl = $(".K1").val();
            var nm = $(".K2").val();
            var tnk = $(".K3").val();
            var ket = $(".K4").val();
            var img = $(".K5").val();
            // alert("OK")
            addToCart(tgl, nm, tnk, ket, img);
            $(".K1").val("");
            $(".K2").val("");
            $(".K4").val("");
            $(".K5").val("");
            $(".picture-src1").attr("src", url + "img_karyawan/berkas.png");
        })

        $('.cartBodyK').on('click', '.deleteItem', function() {
            var index = $(this).data('id');
            mycart.splice(index, 1);
            showCart();
            saveCart();
        })




        var mycart = [];
        $(function() {
            if (localStorage.mycart) {
                mycart = JSON.parse(localStorage.mycart);
                showCart();
            }
        });

        function addToCart(tgl, nm, tnk, ket, img) {

            var item = {
                tgl: tgl,
                nm: nm,
                tnk: tnk,
                ket: ket,
                img: img,
            };
            mycart.push(item);
            saveCart();
            showCart();
        }


        function saveCart() {
            if (window.localStorage) {
                localStorage.mycart = JSON.stringify(mycart);
            }
        }

        function showCart() {
            $(".cartBodyK").empty();
            for (var i in mycart) {
                var item = mycart[i];
                var row = '<tr>' +
                    '<td><input type="hidden" name="tglK[]" value="' + item.tgl + '" >' + item.tgl + '</td>' +
                    '<td>' + item.nm + '<input type="hidden" name="nmK[]" value="' + item.nm + '" /></td>' +
                    '<td>' + item.tnk + '<input type="hidden" name="tnK[]" value="' + item.tnk + '" /></td>' +
                    '<td>' + item.ket + '<input type="hidden" name="ketK[]" value="' + item.ket + '" /></td>' +
                    '<td><img src="' + url + "img_karyawan/" + item.img + '" style="width:40px"><input type="hidden" name="imgK[]" value="' + item.img + '" /></td>' +
                    '<td><button type="button" class="badge badge-danger deleteItem" data-id="' + i + '">' +
                    '&times;</button></td>' +
                    '</tr>';

                $(".cartBodyK").append(row); //append ul dengan id cartbody
            }
        }

        function clearArray(array) {
            while (array.length) {
                array.pop();
            }
        }
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
                    setTimeout(function() {
                        $(".loader").show(0).fadeOut(1000);
                    }, time);
                    $('.FormOpenAsatidzah').modal('hide');
                },
                error: function() {
                    alert("error!");
                },
                success: function(data) {
                    //console.log();
                    $(".cartBodyK").empty();
                    clearArray(mycart)
                    // table.ajax.reload();
                    $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
                    $('.event-title').html(data.event.title);
                    $('.event-body').html(data.event.description);
                    $('.event-footer').html(data.event.footer);
                    $('#Msg-Notification').modal('show');
                    setTimeout(function() {
                        $(".loader").show(0).fadeOut(1000);
                        window.location.href = '<?= base_url('profile') ?>';
                    }, time);
                }
            });

        });

        function formarDate(e) {
            var date = new Date(e);
            var month = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ][date.getMonth()];
            var day = date.getDate();
            var FullDate = day + ' ' + month + ' ' + date.getFullYear();
            return FullDate;
        }
        var id = '<?= $idus ?>';
        $.ajax({
            url: '<?= base_url("data_api/asatidzah/get_data_by") ?>',
            method: "POST",
            data: {
                id: id,
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader").show(0);
                // clearDta();
                localStorage.clear();
                clearArray(mycart)
                $(".cartBodyK").empty();
            },
            error: function() {
                alert("error!");
            },
            success: function(data) {
                $(".loader").fadeOut(1000);
                console.log(data);
                V_lembaga = '<option value="' + data.dt1.cabang_id + '">' + data.dt1.nama_cabang + '</option>';
                $.each(data.cabang, function(i, row) {
                    if (data.dt1.cabang_id === row.id) {} else {
                        V_lembaga += '<option value="' + row.id + '">' + row.nama_cabang + '</option>';
                    }
                });

                var V_Kota = '<option selected="' + data.dt1.id_kota + '">' + data.dt1.kota_lahir + '</option>'
                $.each(data.kota, function(i, row) {
                    if (data.dt1.id_kota === row.id) {} else {
                        V_Kota += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var iddesa = data.dt1.id_kelurahan;
                var sel1, sel2;
                if (iddesa > 0) {
                    sel1 = iddesa.substring(0, 4);
                    sel2 = iddesa.substring(0, 7);
                } else {
                    sel1 = '';
                    sel2 = '';
                }
                var V_Kota2 = '<option selected="' + sel1 + '">' + data.dt1.kota + '</option>'
                $.each(data.kota, function(i, row) {
                    if (sel1 === row.id) {} else {
                        V_Kota2 += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var V_kec = '<option selected="' + sel2 + '">' + data.dt1.kecamatan + '</option>'
                $.each(data.kec, function(i, row) {
                    if (sel2 === row.id) {} else {
                        V_kec += '<option value="' + row.id + '">' + row.kecamatan + '</option>';
                    }
                });
                var V_kel = '<option selected="' + iddesa + '">' + data.dt1.kelurahan + '</option>'
                $.each(data.kel, function(i, row) {
                    if (iddesa === row.id) {} else {
                        V_kel += '<option value="' + row.id + '">' + row.kelurahan + '</option>';
                    }
                });
                if (data.kompetensi.length > 0) {
                    $.each(data.kompetensi, function(r, i) {
                        addToCart(formarDate(i.tgl_kompetensi), i.nama_kompetensi, i.tingkat, i.ket_kompetensi, i.file);
                    });
                }
                var jns;
                if (data.dt1.jns_kelamin == 1) {
                    jns = ' <option value="1">Laki - Laki</option>' +
                        '<option value="2">Perempuan</option>'
                } else {
                    jns = ' <option value="2">Perempuan</option>' +
                        '<option value="1">Laki - Laki</option>'
                }
                var aktiff;
                if (data.dt1.status_pengajar == 1) {
                    aktiff = ' <option value="1">Aktif</option>' +
                        '<option value="0">Non-Aktif</option>'
                } else {
                    aktiff = ' <option value="0">Non-Aktif</option>' +
                        '<option value="1">Aktif</option>'
                }
                var st_nikah = '<option value="' + data.dt1.status_nikah + '">' + data.dt1.status_nikah + '</option>' +
                    '<option value="Belum Menikah">Belum Menikah</option>' +
                    '<option value="Menikah">Menikah</option>' +
                    '<option value="Duda">Duda</option>' +
                    '<option value="Janda">Janda</option>';
                var btn1, btn2;
                if (data.dt1.sanad === 'BERSANAD') {
                    btn1 = "active";
                    btn2 = "notActive";
                } else {
                    btn1 = "notActive";
                    btn2 = "active";
                }
                var sanads = '<a class="btn btn-primary radioBtnChk btn-sm ' + btn1 + ' " data-toggle="Sanad" data-title="BERSANAD">BERSANAD</a>' +
                    '<a class="btn btn-primary radioBtnChk btn-sm ' + btn2 + '" data-toggle="Sanad" data-title="TIDAK">TIDAK</a>'


                $('form #radioBtn').html(sanads);
                $('form #Sanad').val(data.dt1.sanad);

                var T_lahir = formarDate(data.dt1.tgl_lahir);
                var T_Aktif = formarDate(data.dt1.tgl_aktif);
                $('form .Nama_lengkap').val(data.dt1.nama_lengkap);
                $('form .Nama_Panggilan').val(data.dt1.nama_panggilan);
                $('form .jns_kelamin').html(jns);
                $('form .StatusMenikah').html(st_nikah);
                $('form .NIK').val(data.dt1.nik);
                $('form .Tlahir').val(T_lahir);
                $('form .Alamat_rumah').val(data.dt1.alamat);
                $('form .Lembaga').html(V_lembaga);
                $('form .KotaLahir').html(V_Kota);
                $('form .Kota_alamat').html(V_Kota2);
                $('form .kecamatan').html(V_kec);
                $('form .Kelurahan').html(V_kel);
                $('form .Hafalan').val(data.dt1.hafal);
                $('form .TK').val(data.dt1.tk);
                $('form .THTK').val(data.dt1.thtk);
                $('form .SD').val(data.dt1.sd);
                $('form .THSD').val(data.dt1.thsd);
                $('form .SMP').val(data.dt1.smp);
                $('form .THSMP').val(data.dt1.thsmp);
                $('form .SMA').val(data.dt1.sma);
                $('form .THSMA').val(data.dt1.thsma);
                $('form .S1').val(data.dt1.sarjana);
                $('form .THS1').val(data.dt1.ths1);
                $('form .S2').val(data.dt1.pascasarjana);
                $('form .THS2').val(data.dt1.ths2);
                $('form .S3').val(data.dt1.doktoral);
                $('form .THS3').val(data.dt1.ths3);
                $('form .Taktif').val(T_Aktif);
                $('form .Jabatan').val(data.dt1.jabatan);
                $('form .Kontak').val(data.dt1.nomor_hp);
                $('.Image').val(data.dt1.gambar);
                $(".picture-src").attr("src", url + "img_karyawan/" + data.dt1.gambar);

                $("#imgv6").attr("src", url + "img_karyawan/" + data.dt1.ttd);
                $(".Ttd").val(data.dt1.ttd);
                $('form .Status').html(aktiff);
                $('#new_Asatidzah_p').val("Simpan")
                // $('.options').html('<i class="fa fa-plus-circle"></i> ' + opt);
                $('form .idAsatidzah').val(id);
            }
        });
        $(".imgf").change(function() {
            var id = $(this).data("row");
            var fd = new FormData();
            var files = $('#imgf' + id)[0].files;
            if (files.length > 0) {
                fd.append('file', files[0]);
                $.ajax({
                    url: url + 'data_api/asatidzah/uploads_img',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        setTimeout(function() {
                            $(".loader").show(0).fadeOut(1000);
                        }, time);
                        $("#imgv" + id).attr("src", url + "assets/images/spin.svg");
                        $("#imgv" + id).show();
                    },

                    dataType: "json",
                    success: function(response) {
                        if (response != 0) {
                            $(".text" + id).val(response.nimg);
                            $("#imgv" + id).attr("src", url + response.img);
                            $("#imgv" + id).show();
                            //console.log(response)
                        } else {
                            alert('file not uploaded');
                        }

                    },

                });

            } else {

                alert("Please select a file.");

            }

        });

        $('div#radioBtn ').on('click', '.radioBtnChk', function() {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);
            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
        })
    });
</script>
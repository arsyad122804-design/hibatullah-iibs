<?php $levl = $this->session->userdata("idlevel"); ?>
<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="dw dw-user"></span> No. Reg <?= $data->nomor_registrasi; ?></h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-lg-right">
                <a href="<?= base_url("pmb/pendaftar") ?>" class="btn  btn-info  btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                <a href="<?= base_url("pmb/datadiri/" . $this->secure->encrypt_url($data->nomor_registrasi)) ?>" class="btn  btn-primary  btn-m "> <i class="dw dw-filet"></i> Lihat Data</a>
            </div>
        </div>

        <div style="background-color:#e9e9e9; padding:5px 10px; border-radius:6px; margin-bottom:10px SortirDataInput ">
            <table style="width: fit-content;">
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">Nama Lengkap</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= strtoupper($data->nama_lengkap); ?></td>
                </tr>
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">Alamat</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= strtoupper($data->alamat_set); ?></td>
                </tr>
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">No. Telepon</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= ($data->phone); ?></td>
                </tr>
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">Email</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= ($data->email_set); ?></td>
                </tr>
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">Jenjang</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= ($data->nama_cabang); ?></td>
                </tr>
                <tr>
                    <td style="width: 140px; font-weight:bold; vertical-align:top">Periode Daftar</td>
                    <td style="font-weight:bold; vertical-align:top; width:10px; text-align:center">:</td>
                    <td style="vertical-align:top"><?= ($data->tahun_akademik); ?></td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-sm border">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Jenis transaksi</th>
                        <th>Tgl. Transaksi</th>
                        <th>Tgl. Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($detail as $dt) :
                        $jenis = "-";
                        $stat = "Proses";
                        $tbtn = "Proses";
                        $bgclr = "btn-primary";
                        $tgl_bayar = "-";
                        $st = "<b>" . $dt->transaction_status . "</b>";
                        if ($dt->transaction_status == 'settlement') {
                            $st = "<b class='text-success'>TERBAYAR</b>";
                            $tgl_bayar = date("d/m/Y  -  H:i", strtotime($dt->tgl_bayar));
                        }
                        if ($dt->jns == 1) {
                            $jenis = "FORMULIR PENDAFTARAN ";
                        } elseif ($dt->jns == 2) {
                            $jenis = "<div>TES SELEKSI: </div><ol>";
                            $dparams = $dt->pembayaran;
                            $dtpr = explode(",", $dparams);
                            for ($i = 0; $i < count($dtpr); $i++) {
                                $ids = $dtpr[$i];
                                $getdata_sel = $this->db->get_where("master_pmb_pembayaran_seleksi", ['id_pembayaran_seleksi' => $ids]);
                                if ($getdata_sel->num_rows() > 0) {
                                    $dtset = $getdata_sel->row_object();
                                    $noms = number_format($dtset->nominal);
                                    $jenis .= "<li>$dtset->jenis ($noms)</li>";
                                }
                            }

                            $jenis .= "</ol>";
                        }
                        $nota = "-";
                        if (file_exists($dt->nota) || $dt->nota != "") {
                            $nota = '<button class="btn-sm btn-info OpenNota" data-img="' . $dt->nota . '"><i class="dw dw-file"></i> lihat</button>';
                        }
                        $notaset = "-";
                        if ($dt->payment_type == 'OffLine') {
                            $notaset = '<a href="' . base_url("nota/" . $dt->bank) . '" target="_blank" class="btn btn-sm btn-info">Lihat Nota</a>';
                        }
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $jenis; ?></td>
                            <td>Rp. <?= number_format($dt->nominal); ?></td>
                            <td><?= "<div>$dt->payment_type</div><div> $notaset</div>" ?></td>
                            <td><?= date("d/m/Y  -  H:i", strtotime($dt->created_at)); ?></td>
                            <td><?= $tgl_bayar; ?></td>
                            <td><?= $st; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade FormOpenNota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true">&times;</button>
                    <img id="ImgNota" src="" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade FormOpenValidasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true">&times;</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $(".OpenNota").click(function() {
                var img = $(this).data('img');
                $("#ImgNota").attr("src", img);
                $(".FormOpenNota").modal("show");
            })


            $(".Validasi").click(function() {
                var img = $(this).data("img");
                var id = $(this).data("id");
                var idr = $(this).data("idr");
                var rek = $(this).data('rek');
                var jns = $(this).data("jns");
                console.log(jns);
                $(".event-icon").html(
                    img);
                $(".event-title").html(rek);
                $(".event-body").html("Apakah Data Ini Valid?");
                $(".event-footer").html(
                    "<button class='btn btn-primary btn-sm Validasi' data-id='" +
                    id +
                    "'  data-idr='" +
                    idr +
                    "' data-jns='" +
                    jns +
                    "'  data-nm='valid' data-val='2'>Valid</button> " +
                    "<button class='btn btn-danger btn-sm Validasi' data-id='" +
                    id +
                    "' data-idr='" +
                    idr +
                    "' data-jns='" +
                    jns +
                    "'   data-nm='Tidak Valid' data-val='3'>Tidak</button> " +
                    '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">Batal</button>'
                );
                $("#Msg-Notification").modal();
            });

            $("#Msg-Notification").on("click", ".Validasi", function() {
                var id = $(this).data("id");
                var idr = $(this).data("idr");
                var nm = $(this).data("nm");
                var val = $(this).data("val");
                var jns = $(this).data("jns");
                console.log(jns);
                $.ajax({
                    url: "<?= base_url() ?>pmb_api/pendaftar/validasi_data",
                    method: "POST",
                    data: {
                        id: id,
                        idr: idr,
                        val: val,
                        jns: jns,
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader").show(0);
                    },
                    error: function(x) {
                        console.log(x.responseText);
                        alert("error!");
                    },
                    success: function(data) {
                        $(".loader").fadeOut(1000);
                        // console.log(data);
                        $(".event-icon").html(
                            "<i class='fa fa-thumbs-up'  style='color:#a4cc00'></i>"
                        );
                        $(".event-title").html(nm);
                        $(".event-body").html("Update Data Berhasil");
                        $(".event-footer").html(
                            '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                        );
                        $("#Msg-Notification").modal("show");

                        setTimeout(function() {
                            location.reload();
                        }, 100);
                    },
                });

            })
        })
    </script>
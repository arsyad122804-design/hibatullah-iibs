<?php $levl = $this->session->userdata("idlevel");
$jnk = "-";
if ($data->jns_kelamin == 1) {
    $jnk = "Laki-Laki";
} elseif ($data->jns_kelamin == 2) {
    $jnk = "Perempuan";
}
?>

<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-Yorva26_vsOUEv5L"></script>
<!-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-UE0MZLr5Nrrk0Dz2"></script> -->

<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="dw dw-user"></span> Data Biaya Tes Seleksi </h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-lg-right">
                <a href="<?= base_url() ?>" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <!-- <!?php if () {
            # code...
        } print_r($data) ?> -->

        <div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
            <div class="col">
                <div style="margin-top:1%">
                    <?php if ($data->status_pelajar == 4) : ?>
                        <div class="col-md-12">
                            <div class="col-md-12 text-center">
                                <p>Terimakasih Ayah/Bunda <b><?= ($data->nama_lengkap); ?></b> Pembayaran untuk tes seleksi</p>
                                <p>Status pembayaran</p>
                                <h1>BERHASIL</h1>
                            </div>
                            <div style="font-weight:600; font-size:12pt;">Detail Biaya</div>
                            <table style="width:100%" class="table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;font-weight:700; font-size:12pt; ">No.</th>
                                        <th style="text-align:left;font-weight:700; font-size:12pt; ">Jenis Biaya</th>
                                        <th style="text-align:right;font-weight:700; font-size:12pt; ">Nominal</th>
                                    </tr>
                                </thead>
                                <?php
                                $no = 1;
                                $gran_total = 0;
                                $dataset = [];
                                foreach ($detail as $dtl) :
                                    $gran_total += $dtl->nominal;
                                    $dataset[] = [
                                        'id' => $dtl->id_pembayaran_seleksi,
                                        'jenis' => $dtl->jenis,
                                        'nominal' => $dtl->nominal
                                    ];

                                ?>
                                    <tr>
                                        <td style="text-align: center; font-size:12pt;font-weight:500"><?= $no++ ?></td>
                                        <td style="text-align: left; font-size:12pt;font-weight:500"><?= $dtl->jenis; ?></td>
                                        <td style="text-align: right; font-size:12pt;font-weight:500"><?= number_format($dtl->nominal); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tfoot>
                                    <tr>
                                        <!-- <th class="bg-primary color-white" colspan="2" style="text-align: right; padding-right:10px; font-size:12pt;font-weight:700">Total Pembayaran</th> -->
                                        <th colspan="3" style="text-align: right; font-size:18pt;font-weight:700">
                                            <div style="font-size:10pt;font-weight:700">Total Biaya:</div><?= number_format($gran_total); ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else : ?><div class="row">
                            <div class="col-md-6 mb-3">
                                <div style="font-weight:600; font-size:12pt; margin-bottom:6px">Data Calon Peserta Didik Baru :</div>
                                <table style="width:100%;text-align:left">
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px;vertical-align:top"><b>No. Registrasi</b></td>
                                        <td style="width:10px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= $data->nomor_registrasi; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px;vertical-align:top"><b>Nama Lengkap</b></td>
                                        <td style="width:10px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= strtoupper($data->nama_lengkap); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px;vertical-align:top"><b>Tempat Lahir</b></td>
                                        <td style="width:6px;vertical-align:top">: </td>
                                        <td><?= strtoupper($data->kota); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px;vertical-align:top"><b>Tanggal Lahir</b></td>
                                        <td style="width:6px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= date("d-m-Y", strtotime($data->tgl_lahir)); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px;vertical-align:top"><b>Jenis Kelamin</b></td>
                                        <td style="width:6px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= strtoupper($jnk); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px;vertical-align:top"><b>Alamat</b></td>
                                        <td style="width:6px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= ($data->alamat_set); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px;vertical-align:top"><b>Nama Ayah/Ibu</b></td>
                                        <td style="width:6px;vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= strtoupper($data->wali_peserta); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px;vertical-align:top"><b>No. Telepon</b></td>
                                        <td style="vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= $data->phone; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:900; font-size:11pt; margin-bottom:6px;vertical-align:top"><b>Email</b></td>
                                        <td style="vertical-align:top">: </td>
                                        <td style="vertical-align:top"><?= $data->email_set; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">

                                <div style="font-weight:600; font-size:12pt;">Detail Biaya</div>
                                <table style="width:100%" class="table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;font-weight:700; font-size:12pt; ">No.</th>
                                            <th style="text-align:left;font-weight:700; font-size:12pt; ">Jenis Biaya</th>
                                            <th style="text-align:right;font-weight:700; font-size:12pt; ">Nominal</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $no = 1;
                                    $gran_total = 0;
                                    $dataset = [];
                                    foreach ($detail as $dtl) :
                                        $gran_total += $dtl->nominal;
                                        $dataset[] = [
                                            'id' => $dtl->id_pembayaran_seleksi,
                                            'jenis' => $dtl->jenis,
                                            'nominal' => $dtl->nominal
                                        ];

                                    ?>
                                        <tr>
                                            <td style="text-align: center; font-size:12pt;font-weight:500"><?= $no++ ?></td>
                                            <td style="text-align: left; font-size:12pt;font-weight:500"><?= $dtl->jenis; ?></td>
                                            <td style="text-align: right; font-size:12pt;font-weight:500"><?= number_format($dtl->nominal); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tfoot>
                                        <tr>
                                            <!-- <th class="bg-primary color-white" colspan="2" style="text-align: right; padding-right:10px; font-size:12pt;font-weight:700">Total Pembayaran</th> -->
                                            <th colspan="3" style="text-align: right; font-size:18pt;font-weight:700">
                                                <div style="font-size:10pt;font-weight:700">Total Biaya:</div><?= number_format($gran_total); ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <form id="payment-form" method="post" action="">
                                    <input type="hidden" name="result_type" id="result-type" value="">
                                    <input type="hidden" name="result_data" id="result-data" value="">
                                </form>
                                <div class="page-customer mb-2 wow slideInUp" data-wow-delay="0.1s">
                                    <input type="hidden" value="<?= $data->nomor_registrasi; ?>" id="noregis">
                                    <input type="hidden" value="BIAYA TES SELEKSI" id="pembayaran">
                                    <input type="hidden" value="<?= $this->secure->encrypt_url(json_encode($dataset)) ?>" id="tokenset">
                                    <input type="hidden" value="2" id="Jns">
                                    <input type="hidden" class="Total" value="<?= $gran_total ?>" id="nominal">
                                    <input type="hidden" value="<?= strtoupper($data->nama_lengkap) ?>" id="nama">
                                    <input type="hidden" value="<?= $data->email_set ?>" id="email">
                                    <input type="hidden" class="form-control valids " value="<?= $data->phone; ?>" id="wa" required />
                                </div>
                                <div class="Proses">
                                    <div>
                                        <span>Metode Pembayaran</span>
                                        <select id="MethodeBayar" class="MethodeBayar form-control valids" style="width: 100%;font-weight:700" required />
                                        <option></option>
                                        <optgroup label="E-WALLET">
                                            <option value="em-gopay">GOPAY</option>
                                        </optgroup>

                                        <optgroup label="VIRTUAL ACCOUNT">
                                            <option value="VA-BNI">Bank Negara Indonesia (BNI)</option>
                                            <option value="VA-MANDIRI">Bank Mandiri</option>
                                            <option value="VA-PERMATA">Bank Permata</option>
                                            <option value="VA-BRI">Bank BRI</option>
                                            <!--option value="VA-BSS"> Bank Sahabat Sampoerna</!--option-->
                                        </optgroup>
                                        </select>
                                    </div>
                                    <div class=" py-2 mt-2 ">
                                        <div class="text-center load-proses" style="display: none;">
                                            <img src="<?= base_url(" assets/images/spin3.svg") ?>" alt="spin" width="80px">
                                            <div>Mohon Menunggu...</div>
                                        </div>
                                        <button id="pay-button" class="btn btn-primary py-3 px-5 my-2 mt-3  wow zoomIn" style="width:100%; display:block;" data-wow-delay="0.8s">
                                            <strong>PROSES PEMBAYARAN </strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><img src="<?= base_url() ?>assets/pay/' + state.element.value.toLowerCase() + '.png" class="img-flag" style="width:80px" /> ' + state.text + '</span>'
            );
            return $state;
        };
        $("#MethodeBayar").select2({
            templateResult: formatState,
            minimumResultsForSearch: Infinity,
            placeholder: "-- Pilih Metode Pembayaran --",
            allowClear: true
        });
    });

    $('#pay-button').click(function(event) {

        var noreg = $("#noregis").val();
        var pembayaran = $("#pembayaran").val();
        var nominal = $("#nominal").val();
        var nama = $("#nama").val();
        var email = $("#email").val();
        var wa = $("#wa").val();
        var jns = $("#Jns").val();
        var tokenset = $("#tokenset").val();

        var MethodeBayar = $("#MethodeBayar").val();
        event.preventDefault();
        $(this).attr("disabled", "disabled");
        $.ajax({
            method: 'POST',
            url: '<?= base_url('payment/token') ?>',
            data: {
                noreg: noreg,
                pembayaran: pembayaran,
                nominal: nominal,
                nama: nama,
                email: email,
                wa: wa,
                jns: jns,
                MethodeBayar: MethodeBayar,
                tokenset: tokenset,
            },
            cache: false,
            beforeSend: function() {
                // $(".loader").show(0);
                $(".load-proses").css('display', 'block');
            },
            error: function(x) {
                console.log(x.responseText);
            },
            success: function(data) {

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function(result) {
                        changeResult('success', result);
                        // console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        // console.log(result.status_message);
                        $("#payment-form").submit();
                    },
                    onError: function(result) {
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });

                // $(".loader").fadeOut(1000);
                $(".load-proses").css('display', 'none');
            }
        });
    });
</script>
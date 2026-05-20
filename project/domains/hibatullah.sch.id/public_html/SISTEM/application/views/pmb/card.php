<style>
    .kartu-peserta-seleksi {
        padding: 10px;
        width: 412px;
        border: 1px solid black;
    }

    .kartu-peserta-seleksi p {
        font-size: 8pt;
    }

    .kartu-peserta-seleksi td,
    .kartu-peserta-seleksi .footer-wrapper p {
        font-size: 10pt;
    }

    .kartu-peserta-seleksi .head-wrapper {
        display: flex;
        padding: 5px;
        flex-direction: row;
        margin: -10px -10px 0;
        align-items: center;
        justify-content: center;
        border-bottom: 2px solid black;
    }

    .kartu-peserta-seleksi .head-wrapper .sec {
        width: 60px;
        text-align: center;
    }

    .kartu-peserta-seleksi .head-wrapper .sec:nth-child(2) {
        flex: 1;
    }

    .kartu-peserta-seleksi .head-wrapper img {
        height: 50px;
    }

    .kartu-peserta-seleksi .head-wrapper {
        /* .sec:last-child  */
        font-weight: 900;
    }

    .kartu-peserta-seleksi .head-wrapper .sec:nth-child(-1n+3) p {
        margin-bottom: 0;
    }

    /* .kartu-peserta-seleksi .head-wrapper .sec:nth-child(2) p:nth-child(-n+3) {
        font-weight: bold
    } */

    .kartu-peserta-seleksi .content-wrapper {
        padding: auto;
    }


    /* .kartu-peserta-seleksi .content-wrapper tr:nth-last-child(-n+2) td:last-child {
        color: blue;
    } */

    .kartu-peserta-seleksi .content-wrapper tr td:nth-child(2) {
        width: 15px;
        text-align: center;
    }

    .kartu-peserta-seleksi .footer-wrapper {
        text-align: right;
    }

    .kartu-peserta-seleksi .footer-wrapper p {
        margin-bottom: 0
    }

    .flex-container {
        display: flex;
    }

    .flex-container>div {
        margin: 04px;
        padding: 10px 0;
    }

    table>tbody>tr>td {
        vertical-align: top;
        line-height: 12pt;
        /* font-weight: 600; */
    }
</style>

<div class="row">
    <div class="card-box mb-30 my-auto mx-auto">
        <div class="min-height-100px">

            <div class="kartu-peserta-seleksi-wrapper">
                <div class="kartu-peserta-seleksi">
                    <div class="head-wrapper">
                        <div class="sec"><img class="img-wraper" src="/assets/images/apple-touch-icon.png" alt="Ponpes Modern Hibatullah"></div>
                        <div class="sec">
                            <p>KARTU PESERTA</p>
                            <p>TEST SELEKSI PPDB</p>
                            <p>PONPES MODERN HIBATULLAH</p>
                        </div>
                        <div class="sec">
                            <p>PESERTA</p>
                        </div>
                    </div>

                    <div class="flex-container">

                        <div style="
            object-fit: cover;
            object-position: 10% ;
            border-radius: 10px;
            overflow: hidden;
          ">
                            <img src="<?= base_url('berkas/') . $data->gambar ?>" style="width: 80px" />
                        </div>
                        <div class="content-wrapper">
                            <table style="font-size: 10pt;">
                                <tbody>
                                    <tr>
                                        <td style="min-width: 90px;">No. Registrasi</td>
                                        <td>:</td>
                                        <td><?= $data->nomor_registrasi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Peserta</td>
                                        <td>:</td>
                                        <td><?= $data->nama_lengkap; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kota Kelahiran</td>
                                        <td>:</td>
                                        <td><?= $data->kota_lahir; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Lahir</td>
                                        <td>:</td>
                                        <td><?= date("d M Y", strtotime($data->tgl_lahir)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?= $data->alamat; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="footer-wrapper">
                        <p style="font-size: 8pt;">Bojonegoro, <?= date("d M Y", strtotime($data->date_create)); ?></p>
                        <p style="font-size: 8pt;">Kepala Pesantren</p>
                        <br>
                        <p style="font-size: 8pt;"><strong>
                                <?= $data->pengurus; ?>
                            </strong></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!---///////////////////////////////-->
<!---///////////////////////////////-->
<!---///////////////////////////////-->
<!---///////////////////////////////-->
<?php
// if ($this->session->userdata("idlevel") >= 20) :
$thisurl = base_url('pmb/profile');
// else :
//     $thisurl = base_url('data_api/asatidzah/profile');
// endif;
?>
<script>
    var id = '<?= $idus ?>'
    var urls = '<?= $thisurl ?>'
    var url = '<?= base_url() ?>'
</script>
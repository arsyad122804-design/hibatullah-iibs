<?php $levl = $this->session->userdata("idlevel"); ?>
<style>
    .hero-widget {
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .hero-widget .icon {
        display: block;
        font-size: 96px;
        line-height: 96px;
        margin-bottom: 10px;
        text-align: center;
    }

    .hero-widget var {
        display: block;
        height: 64px;
        font-size: 64px;
        line-height: 64px;
        font-style: normal;
    }

    .hero-widget label {
        font-size: 17px;
    }

    .hero-widget .options {
        margin-top: 10px;
    }
</style>

<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="dw dw-user"></span> Rekap PPDB</h4>
                <div class="cabang-top">Seluruh Program / Cabang</div>
            </div>
        </div>
    </div>

    <!--/*///////////////////*/ -->
    <div class="row ">
        <div class="col-xl-4 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-row  align-items-center ">
                    <div class=" col-8 weight-700 font-14   ">Jumlah Pendaftar</div>
                    <div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
                        <span><?= $pendaftar->jumlah; ?><i class="fa fa-user" style="font-size: 14pt;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class=" col-8 weight-600 font-14  col-lg-pull-0">Pendaftar Lunas Daftar Ulang</div>
                    <div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
                        <span><?= $valid->jumlah; ?><i class="fa fa-user" style="font-size: 14pt;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class=" col-8 weight-600 font-14  col-lg-pull-0">Pendaftar Diterima (Sudah Migrasi Data)</div>
                    <div class="col-4 text-center  align-items-center  row" style="font-size:46pt;font-weight:bold">
                        <span><?= $migrasi->jumlah; ?><i class="fa fa-user" style="font-size: 14pt;"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
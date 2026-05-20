<?php $levl = $this->session->userdata("idlevel"); ?>
<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="ti-bookmark-alt"></span> Data Tes Seleksi</h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-lg-right">
                <button type="button" class="btn  btn-primary openform btn-m" data-id="new" data-option="New"> <i class="fa fa-plus-circle"></i> Baru</button>
                <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
            </div>
        </div>

        <div style="background-color:#e9e9e9; padding:5px 10px; border-radius:6px; margin-bottom:10px SortirDataInput ">
            <b>Sortir Data </b>
            <!-- <?php if ($levl == 1 || $levl >= 100) : ?> -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="width: 160px;">Nama Cabang </span>
                </div>
                <div class="col-sm-6">
                    <?php $dtcabang = $this->db->get("data_kantor_cabang")->result(); ?>
                    <select name="NmCabang" id="NmCabang_set" class="form-control">
                        <option value="">-Pilih Cabang-</option>
                        <?php foreach ($dtcabang as $dc) : ?>
                            <option value="<?= $dc->id ?>"><?= $dc->nama_cabang ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- <?php endif;  ?> -->
            <!-- <?php if ($levl <= 7) : ?> -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="width: 160px;">Periode Pendaftaran </span>
                </div>
                <div class="col-sm-6">
                    <?php $dt_periode = $this->db->query("SELECT * FROM master_pmb_tahun_akademik ORDER BY id_tahun DESC")->result(); ?>
                    <select name="Periode_Chek" id="Periode_Chek" class="form-control">
                        <!-- <option value="">-Pilih Periode-</option> -->
                        <?php foreach ($dt_periode as $dp) : ?>
                            <option value="<?= $dp->id_tahun ?>"><?= $dp->tahun_akademik ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- <?php endif;  ?> -->
            <div class="row align-items-center">
                <div class="col-lg-12 table-responsive">
                    <table id="Table1set" class="table table-sm stripe hover w-100 ">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 20px;">No.</th>
                                <th>Nama Lengkap</th>
                                <th>Gender</th>
                                <th>Periode</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Opsi</th>
                                <th>sp</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade FormOpenAkademik" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 style="color: aliceblue;"><span class="options"></span> </h5>
                    <button type="button" class="close " data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <?= form_open("pmb_api/tahun_pmb/newdata", array('id' => 'periodik')); ?>
                    <input type="hidden" class="idAkademik form-control" name="idAkademik" value="new">

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Periode Angkatan</label>
                        <div class="col-sm-12 col-md-10">
                            <select name="Periode" id="Periode" class="custom-select2 Periode " style="width: 100%;" required>
                                <option value=""> - Pilih Periode Angkatan -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Harga Formulir</label>
                        <div class="col-sm-12 col-md-10">
                            <input type="hidden" class="form-control Nominal N2" name="Nominal" required>
                            <input type="text" class="form-control NumFormat NS2" data-id="2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-10">
                            <select name="Aktif" id="Aktif" class="form-control Aktif " required>
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12" style=" text-align:right ">
                                <button type="button" class="btn btn-secondary btn-lg  mr-3" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-close"></i> Batal</button>
                                <input type="submit" class="btn btn-primary btn-lg " id="new_Akademik_p" value="">
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
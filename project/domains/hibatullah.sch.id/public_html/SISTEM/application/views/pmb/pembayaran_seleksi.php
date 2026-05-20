<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="dw dw-money-1"></span> Biaya Tes Seleksi</h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-lg-right">
                <?php if ($this->session->userdata("idlevel") <= 2 || $this->session->userdata("idlevel") == 4) : ?>
                    <button type="button" class="btn  btn-primary openform btn-m" data-id="new" data-option="New"> <i class="fa fa-plus-circle"></i> Baru</button>
                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
                <?php else : ?>
                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
                <?php endif ?>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend col-md-12">
                <span class="input-group-text" id="basic-addon1" style="width: 160px;">Periode Pendaftaran </span>
            </div>
            <div class="col-sm-6">
                <?php $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object(); ?>
                <?php $dt_periode = $this->db->query("SELECT * FROM master_pmb_tahun_akademik ORDER BY id_tahun DESC")->result(); ?>
                <select name="Periode_Chek" id="Periode_Chek" class="form-control">
                    <option value="">-Pilih Periode-</option>

                    <?php foreach ($dt_periode as $dp) : ?>
                        <?php ($periodesctiv->id_tahun == $dp->id_tahun) ? $aktif = 'selected' : $aktif = "" ?>
                        <option value="<?= $dp->id_tahun ?>" <?= $aktif ?>><?= $dp->tahun_akademik ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12 table-responsive">
                <table id="Table1set" class="table table-sm stripe hover w-100 ">
                    <thead>
                        <tr>
                            <th style="width: 20px;">No.</th>
                            <th>Nama Pembayaran</th>
                            <th>Nominal</th>
                            <th>Tahun Angkatan</th>
                            <th>Status</th>
                            <th>Action</th>
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
                <?= form_open("pmb_api/pembayaran_seleksi/newdata", array('id' => 'periodik')); ?>
                <input type="hidden" class="idTes form-control" name="idTes" value="new">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Tingkat/Cabang</label>
                    <div class="col-sm-12 col-md-10">
                        <select name="Tingkat" id="Tingkat" class="custom-select2 form-control Tingkat " style="width: 100%;" required>
                            <option value=""> - Pilih Tingkat/Cabang -</option>
                            <?php $getLembaga = $this->db->get("data_kantor_cabang")->result(); ?>
                            <?php foreach ($getLembaga as $dtc): ?>
                                <option value="<?= $dtc->id ?>"><?= $dtc->nama_cabang; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Tahun Angkatan</label>
                    <div class="col-sm-12 col-md-10">
                        <select name="Periode" id="Periode" class="custom-select2 Periode " style="width: 100%;" required>
                            <option value=""> - Pilih Tahun Angkatan -</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nama Pembayaran</label>
                    <div class="col-sm-12 col-md-10">
                        <input type="text" class="form-control Jenis" name="Jenis" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nominal</label>
                    <div class="col-sm-12 col-md-10">
                        <input type="hidden" class="form-control Nominal N3" name="Nominal" required>
                        <input type="text" class="form-control NumFormat NS3" data-id="3">
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
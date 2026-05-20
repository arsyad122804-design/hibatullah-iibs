<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="ti-bookmark-alt"></span> Master Tahun PPDB</h4>
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

        <div class="row align-items-center">
            <div class="col-lg-12 table-responsive">
                <table id="Table1set" class="table table-sm stripe hover w-100 ">
                    <thead>
                        <tr>
                            <th style="width: 20px;">No.</th>
                            <th>Tingkat/Cabang</th>
                            <th>Tahun Akademik</th>
                            <th>Harga Formulir</th>
                            <th>Nominal Fee</th>
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
                <?= form_open("pmb_api/tahun_pmb/newdata", array('id' => 'periodik')); ?>
                <input type="hidden" class="idAkademik form-control" name="idAkademik" value="new">
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
                    <label class="col-sm-12 col-md-2 col-form-label">Periode Angkatan</label>
                    <div class="col-sm-12 col-md-10">
                        <select name="Periode" id="Periode" class="custom-select2 form-control Periode " style="width: 100%;" required>
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
                    <label class="col-sm-12 col-md-2 col-form-label">Nominal Fee</label>
                    <div class="col-sm-12 col-md-10">
                        <input type="hidden" class="form-control Nominal2 N3" name="Nominal2" required>
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
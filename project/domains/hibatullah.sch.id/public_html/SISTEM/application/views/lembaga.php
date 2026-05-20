<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="ti-flag-alt"></span> Data Lembaga</h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-right">
                <?php if ($this->session->userdata("idlevel") > 1) : ?>
                    <button type="button" class="btn  btn-info ReloadData btn-m"> <i class="fa fa-refresh"></i> Refresh</button>
                <?php else : ?>
                    <button type="button" class="btn  btn-primary openform btn-m" data-id="new" data-option="New"> <i class="fa fa-plus-circle"></i> Lembaga</button>
                    <button type="button" class="btn  btn-info ReloadData btn-m"> <i class="fa fa-refresh"></i> Refresh</button>
                <?php endif ?>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12 table-responsive">
                <table id="Table1set" class="table table-sm stripe hover w-100 ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lambaga</th>
                            <th>Jumlah Santri</th>
                            <th>Nama Pimpinan</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade FormOpenLembaga" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 style="color: aliceblue;"><span class="options"></span> Lembaga </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <?= form_open("lembaga/newlembaga", array('id' => 'lembaga')); ?>
                <input type="hidden" class="idlembaga form-control" name="idlembaga">
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nama Lembaga</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control lembaga" type="text" name="lembaga">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nama Pimpinan</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control pimpinan" type="text" name="pimpinan">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Alamat</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control alamat" type="text" name="alamat">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Kota</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control kota" type="text" name="kota">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control telepon" type="tel" name="telepon">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control email" type="text" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Website</label>
                    <div class="col-sm-12 col-md-10">
                        <input class="form-control website" type="text" name="website">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12" style=" text-align:right ">
                            <button type="button" class="btn btn-secondary btn-lg text-left mr-3" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-close"></i> Batal</button>
                            <input type="submit" class="btn btn-primary btn-lg text-left" id="new_lembaga_p" value="">
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-7">
                <h4> <span class="fa fa-address-book-o"></span> Data Customer</h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
            <div class="col-sm-5 text-lg-right"><?php if ($this->session->userdata("idlevel") == 1) : ?>
                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
                <?php else : ?>
                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
                <?php endif ?>
            </div>
        </div>
        <?php if ($this->session->userdata('idlevel') == 1) : ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend col-md-12">
                    <span class="input-group-text" id="basic-addon1" style="width: 160px;">Affiliator </span>
                </div>
                <div class="col-sm-6">
                    <?php
                    $dt_aff = $this->db->query("SELECT * FROM sys_user Where id_level ='22'")->result(); ?>
                    <select id="Affliator" class="form-control">
                        <option value="all">-Semua Affiliator-</option>
                        <?php
                        foreach ($dt_aff as $aff) : ?>
                            <option value="<?= $aff->id_user ?>"><?= $aff->nama_asli ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        <div class="row align-items-center">
            <div class="col-lg-12 table-responsive">
                <table id="Table1set" class="table table-sm stripe hover w-100 ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Customer</th>
                            <th>Asal</th>
                            <th>Telepon</th>
                            <th>Affiliator</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
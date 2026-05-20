<div class="main-container">

    <div class="card-box pd-20 height-100-p mb-30">

        <div class="row align-items-center mb-20">

            <div class="col-sm-7">

                <h4> <span class="fa fa-address-book-o"></span> Data User</h4>

                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>

            </div>

            <div class="col-sm-5 text-lg-right"><?php if ($this->session->userdata("idlevel") <= 4) : ?>

                    <button type="button" class="btn  btn-primary openform btn-m" data-id="new" data-option="New"> <i class="fa fa-plus-circle"></i> Baru</button>

                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>

                <?php else : ?>

                    <button type="button" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-refresh"></i> Refresh</button>
                <?php endif ?>

            </div>

        </div>

        <?php if ($this->session->userdata("idlevel") == 1 || $this->session->userdata("idlevel") >= 100) : ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="width: 160px;">Lembaga/Cabang </span>
                </div>
                <div class="col-sm-6">
                    <?php $dtcabang = $this->db->get("data_kantor_cabang")->result(); ?>
                    <select name="NmCabang" id="NmCabang_set" class="form-control">
                        <option value="">-Pilih Lembaga / Cabang-</option>
                        <?php foreach ($dtcabang as $dc) : ?>
                            <option value="<?= $dc->id ?>"><?= $dc->nama_cabang ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php endif;  ?>
        <div class="row align-items-center">

            <div class="col-lg-12 table-responsive">

                <table id="Table1set" class="table table-sm stripe hover w-100 ">

                    <thead>

                        <tr>

                            <th>No.</th>

                            <th>Cabang</th>

                            <th>Nama User</th>

                            <th>Username</th>

                            <th>Password</th>

                            <th>Level User</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>



<div class="modal fade FormOpenUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header bg-primary">

                <h5 class="text-white"><span class="options"></span> </h5>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>

            <div class="modal-body">

                <form action="<?= base_url('user/newUser') ?>" method="POST" id="User">

                    <input type="hidden" class="idUser form-control" name="idUser">

                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Nama Lembaga</label>

                        <div class="col-sm-12 col-md-10">

                            <select class="custom-select form-control col-md-12 Lembaga w-100" name="Lembaga" style="width: 100%;" required>

                                <option value=""> -Pilih -</option>

                            </select>

                        </div>

                    </div>

                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Username</label>

                        <div class="col-sm-12 col-md-10">

                            <input type="text" name="Username" id="Username" class="form-control Username" required>

                            <div id="UserInfo"></div>

                        </div>

                    </div>

                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Password</label>

                        <div class="col-sm-12 col-md-10">

                            <input class="form-control Password1" type="password" name="Password1">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Ulangi Password</label>

                        <div class="col-sm-12 col-md-10">

                            <input class="form-control  Password2" type="password" name="Password2">

                        </div>

                    </div>



                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Level User</label>

                        <div class="col-sm-12 col-md-10 Level_box">

                            <select name="Level" id="Level" class="custom-select2 form-control Level" style="width: 100%;" required>

                                <option value=""> - Pilih Level -</option>

                            </select>

                        </div>

                    </div>

                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Keterangan</label>

                        <div class="col-sm-12 col-md-10 KeteranganData Ket_box">

                            <select name="Relation_id" id="Relation_id" class="custom-select2 form-control Ket" style="width: 100%;" required>

                            </select>

                        </div>

                    </div>



                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Nama Lengkap</label>

                        <div class="col-sm-12 col-md-10">

                            <input class="form-control Nama" type="text" name="Nama" required>

                        </div>

                    </div>



                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Email </label>

                        <div class="col-sm-12 col-md-10">

                            <input class="form-control Email" type="email" name="Email">

                        </div>

                    </div>



                    <div class="form-group row">

                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>

                        <div class="col-sm-12 col-md-10">

                            <select name="Aktif" id="Aktif" class="form-control Aktif ">

                                <option value="T">Tidak Aktif</option>

                                <option value="Y">Aktif</option>

                            </select>

                        </div>

                    </div>



                    <div class="row">

                        <div class="col-sm-12">

                            <div class="input-group mb-0 ProsesData">

                                <button type="button" class="btn btn-primary btn-lg btn-block Btn-ProsesData">Proses Data</button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
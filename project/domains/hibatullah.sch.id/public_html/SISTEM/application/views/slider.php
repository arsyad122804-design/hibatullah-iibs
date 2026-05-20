<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center mb-20">
            <div class="col-sm-12">
                <h4> <span class="dw dw-image"></span> Pengaturan Slide Gambar</h4>
                <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12 table-responsive">
                <table id="Table1set" class="table table-sm stripe hover w-100 text-center ">
                    <thead>
                        <tr>
                            <!-- <th>No.</th> -->
                            <th>Image</th>
                            <th>Link Url</th>
                            <th>Open Link</th>
                            <!-- <th>Pertema</th> -->
                            <th>Aktif</th>
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
                <form action="<?= base_url('slider/new_data') ?>" method="POST" id="User">
                    <input type="hidden" class="idUser form-control" name="idUser">


                    <!-- <div class="form-group col row" style="display: none;">
                        <label class="col-sm-12 ">Pertama</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="input-group" style="width: 100%">
                                <input type="checkbox" class="switch-btn Set_Current" data-size="small" data-color="#ff8000" value="1" name="Current" style="max-width:40px">
                                <span class="switch-lable">Aktif</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="btn btn-block btn-mdb-color btn-rounded float-left">
                        <label style="color: #0a0a0a; ">Gambar Slide</label><br>
                        <div class="Spins">
                            <img src="/img_pelajar/default.png" class="picture-src " style="width: auto;background-color:#dddddd" id="imgv1" title="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div>Gambar Baru</div>
                        <input type="file" class="file imgf form-control form-control-sm form-control-file" data-show-preview="false" data-row="1" id="imgf1" />
                    </div>
                    <input type="hidden" class="text1 Image" name="Image" value="null">
                    <div class="row  mt-3">
                        <div class="form-group col-6 m-0 row">
                            <label class="col-sm-12 ">Open Link</label>
                            <div class="col-sm-12">
                                <div class="input-group" style="width: 100%">
                                    <input type="checkbox" class="switch-btn Set_Link" data-size="small" data-color="#ff8000" value="1" name="Link" style="max-width:40px">
                                    <span class="switch-lable">Aktif</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6 m-0 row">
                            <label class="col-sm-12 ">Status</label>
                            <div class="col-sm-12">
                                <div class="input-group" style="width: 100%">
                                    <input type="checkbox" class="switch-btn Set_Active" data-size="small" data-color="#ff8000" value="1" name="Active" style="max-width:40px">
                                    <span class="switch-lable">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row Link_set" style="display: none;">
                            <label class="col-sm-12 ">Link Url</label>
                            <div class="col-sm-12">
                                <input type="url" name="Url" id="Url" class="form-control Url">
                                <div id="UserInfo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-2" style=" text-align:right ">
                            <button type="submit" class="btn btn-primary btn-lg  Btn-ProsesData">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
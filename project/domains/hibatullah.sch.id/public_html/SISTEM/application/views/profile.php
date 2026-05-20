<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="min-height-200px">
            <div class="row align-items-center mb-20">
                <div class="col-sm-7">
                    <h4> <span class="fa fa-address-book-o"></span> Profile User</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
            </div>
            <div class="card-header">
                <div class="row no-gutters">
                    <div class="col-2">
                        <div style="
width: 60px; 
height: 60px; 
object-fit: cover;
object-position: 20% 10%; 
border-radius:10px;
overflow: hidden; margin:5px">
                            <?php if ($profile->icon != "") {
                                $icprop = $profile->icon;
                            } else {
                                $icprop = 'pavicon.png';
                            } ?>
                            <img src="<?= base_url("img_profile/" . $icprop) ?>" style="width: 60px">
                        </div>
                        <div style="text-align:left">
                            <a href="modal" data-toggle="modal" data-target="#modalIcon" class="edit-avatar badge badge-primary p-1"><i class="fa fa-pencil"></i> <span style="font-size: 10px">Ganti Icon</span></a>
                        </div>
                        <div class="modal fade" id="modalIcon" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body pd-5">
                                        <div class="img-container">
                                            <div class="btn btn-block btn-mdb-color btn-rounded float-left">
                                                <label style="color: #fff; ">Photo Img</label><br>
                                                <div class="Spins">
                                                    <img src="<?= base_url("img_profile/" . $profile->icon) ?>" alt="" class="Picture picture-src" id="imgv5">
                                                </div>
                                                <input type="file" class="file imgf" data-show-preview="false" data-row="5" id="imgf5" />
                                            </div>
                                            <input type="hidden" class="text5 Image" name="Image" value="null">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <span class="ProsesIcon">
                                            <div class="btn btn-secondary btn-lg btn-block Btn-ProsesData">Update</div>
                                        </span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalpass" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5>Ganti Password</h5>
                                    </div>
                                    <form action="<?= base_url("profile/updatepass") ?>" method="POST" id="UpdatePass">
                                        <div class="modal-body pd-5">
                                            <br>
                                            <input type="hidden" name="idu" value="<?= $profile->id_user ?>">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-md-2 col-form-label">Password Baru</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input class="form-control Password1" type="password" name="Password1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-md-2 col-form-label">Ulangin Password</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input class="form-control  Password2" type="password" name="Password2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <span class="ProsesData">
                                                <div class="btn btn-secondary btn-lg btn-block Btn-ProsesData">Update</div>
                                            </span>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <div class="blog-caption ml-2 mt-2">
                            <h5>Akun <?= $profile->level ?></h5>
                            <div style="font-size:10px"> <b>Username :
                                    <?= $profile->username ?></b>
                                <div style="color:#ff8040; font-size:16px; font-weight:800; margin-top:4px"><?= $profile->nama_asli ?></div>
                            </div>
                            <div>
                                <a href="modal" data-toggle="modal" data-target="#modalpass" class="edit-avatar badge badge-primary p-1"><i class="fa fa-pencil"></i> <span style="font-size: 10px">Ganti Password</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <b>Data Lengkap :</b>
            </div>
            <div class="profile-tab height-100-p">
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
$thisurl = base_url('profile/profile');
// else :
//     $thisurl = base_url('data_api/asatidzah/profile');
// endif;
?>
<script>
    var id = '<?= $idus ?>'
    var urls = '<?= $thisurl ?>'
    var url = '<?= base_url() ?>'
</script>
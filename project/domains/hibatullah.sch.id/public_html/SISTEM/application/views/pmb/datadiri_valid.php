<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="min-height-200px">
            <div class="row align-items-center mb-20">
                <div class="col-sm-7">
                    <h4> <span class="fa fa-address-book-o"></span>Calon Peserta Didik Baru</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>

                <div class="col-sm-5 text-right">
                    <?php if ($this->session->userdata("idlevel") == 50) : ?>
                        <a href="<?= base_url() ?>" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                    <?php else : ?>
                        <a href="<?= base_url('pmb/getdata_valid/' . $token) ?>" class="btn  btn-info ReloadData btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                    <?php endif; ?>
                </div>
            </div>


            <div class="profile-tab height-100-p">
                <?= $data; ?>
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
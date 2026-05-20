<div class="content-wrapper animated bounceInDown">

    <div class="row">

        <div class="col-lg-12 stretch-card">
            <div class="card ">
                <div class="card-body">
                    <div>
                        <h3 class="card-title">DATA UJIAN STIDKI AR-RAHMAH</h3>
                        <p class="card-description">
                            <a href="<?= base_url('ujian/setting_soal/') . $encrypturl . '?SoS=' . urlencode(($tokens_ujian)) ?>" class="btn btn-primary btn-sm rounded-0">
                                <i class="ti-plus">&nbsp;</i> Ujian Baru
                            </a>
                            <button type="button" onclick="reload()" class="btn btn-secondary btn-sm rounded-0"><i class="ti-reload">&nbsp;</i> Refresh</button>
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table id="Table1" class="table table-md table-bordered table-striped " style="width:100%">
                            <thead style="background-color: #7580ff; color:#fff">
                                <tr>
                                    <th> No</th>
                                    <th> Nama Ujian</th>
                                    <th> User</th>
                                    <th> Soal</th>
                                    <th> Jenis</th>
                                    <th> Tanggal</th>
                                    <th> Token</th>
                                    <th> Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($ujian as $val) : ?>
                                    <tr id="ID<?= $val->token ?>">
                                        <td style="text-align: center;"><?= $no++ ?></td>
                                        <td><?= $val->modul ?></td>
                                        <td><?= $val->nama_asli ?></td>
                                        <td><?= $val->jumlah_soal ?> <small>soal</small></td>
                                        <td><?= $val->jenis ?></td>
                                        <td><?= date("d M, Y - h:i", strtotime($val->datecreate)) ?></td>
                                        <td><?= $val->token ?></td>
                                        <td>
                                            <button type="button" class=" btn-primary rounded-0 p-2 ViewData" data-id="<?= $val->id ?>" data-token="<?= $val->token ?>" data-judul="<?= $val->modul ?>" title="Tampil">
                                                <i class="ti-layers">&nbsp;</i>
                                            </button>
                                            <button type="button" class=" btn-danger rounded-0 p-2 HapusData" data-id="<?= $val->id ?>" data-token="<?= $val->token ?>" data-judul="<?= $val->modul ?>" title="Hapus">
                                                <i class="ti-trash">&nbsp;</i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal View -->
<div class="modal animated bounceInDown" id="ModalUjian" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content ">
            <div class="modal-header " style=" background-color: #7580ff; color:#fff">
                <div>
                    <h3 class=" JudulUjian"></h3>
                    <div> <small>token: </small><span class="TokenUjian"></span></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <table class="table table-sm table-hover  w-100" style="max-width: 800px; margin-left:auto; margin-right:auto">
                    <thead style="display: none;">
                        <tr>
                            <td>No</td>
                            <td>Soal Ujian</td>
                        </tr>
                    </thead>
                    <tbody class="showdataujian"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $("table tbody").on('click', '.ViewData', function() {
            var modul = $(this).data("judul");
            var token = $(this).data("token");
            $.ajax({
                url: "<?= base_url('ujian/viewallujianbytoken') ?>",
                method: "POST",
                data: {
                    token: token,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".loader").show(0).delay(600).hide(0);
                },
                error: function() {
                    alert($(this).html() + " Error!");
                },
                success: function(data) {
                    console.log(data)
                    $(".showdataujian").html(data);
                    $(".TokenUjian").html(token);
                    $(".JudulUjian").html(modul);
                    $("#ModalUjian").modal("show");
                }
            });
        });

        $("table tbody").on('click', '.HapusData', function() {
            var id = $(this).data("id");
            var modul = $(this).data("judul");
            var token = $(this).data("token");
            $(".alert_msg .modal-body .M-tittle").html(modul)
            $(".alert_msg .modal-body .M-body").html("Anda yakin ingin menghapus soal ini?")
            $(".alert_msg .modal-body .M-action").html("<br><button type='button' class='btn btn-secondary rounded-0 m-1' data-dismiss='modal'>Tidak</button><button id='Hapus' class='btn btn-primary rounded-0 m-1' data-token='" + token + "' ' data-modul='" + modul + "'' data-id='" + id + "'> HAPUS</button>")
            $(".alert_msg").modal("show");
        });
        $(".alert_msg .modal-body span").on('click', '#Hapus', function() {
            var token = $(this).data("token");
            var modul = $(this).data("modul");
            var id = $(this).data("id");
            $(".alert_msg").modal("hide");
            $.ajax({
                url: "<?= base_url('ujian/hapusdataujian') ?>",
                method: "POST",
                data: {
                    id: id,
                    token: token,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".loader").show(0).delay(600).hide(0);
                },
                error: function() {
                    alert($(this).html() + " Error!");
                },
                success: function(data) {
                    $(".alert_msg .modal-body .M-tittle").html("<div><span > <span class = 'ti-trash' style= 'font-size:32px; color:#ff0000' ></span></span></div><br>");
                    $(".alert_msg .modal-body .M-body").html(modul)
                    $(".alert_msg .modal-body .M-action").html("Berhasil di hapus");
                    $(".alert_msg").modal("show");
                    $("#ID" + token).remove();
                    console.log(data);
                }
            });
        })
    })
</script>
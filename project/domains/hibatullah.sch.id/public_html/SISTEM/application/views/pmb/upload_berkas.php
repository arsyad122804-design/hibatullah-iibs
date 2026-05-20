<style>
    #radioBtn .notActive {
        color: #3276b1;
        background-color: #fff;
    }
</style>
<div class="main-container">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="min-height-200px">
            <div class="row align-items-center mb-20">
                <div class="col-sm-7">
                    <h4> <span class="fa fa-address-book-o"></span> Upload Berkas</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
                <div class="col-sm-5 text-right">
                    <a id="BackBTN" href="#" class="btn  btn-info backdata btn-m "> <i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>

            <form action="<?= base_url() ?>pmb_api/berkas/upload_berkas" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" class="idPelajar form-control-sm" name="idPelajar">
                        <div class="form-group row">
                            <div class="Spins d-flex  justify-content-start">
                                <img src="/img_pelajar/default.png" class="picture-src " style="width: 100px;" id="imgv5" title="" />
                            </div>
                            <label class="col-sm-12 col-md-2 col-form-label">Photo Calon Santri *(JPG/JPEG/PNG)</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="file" class="file imgf" data-show-preview="false" data-row="5" id="imgf5" />
                                <input type="hidden" class="text5 Image" name="Photo" value="null">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Akte Kelahiran *(PDF)</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="file" class="file-control file fileBerkas" data-row="1" id="fileBerkas1" data-show-preview="false" name="file" required />
                                <input type="hidden" class="filename1" data-show-preview="false" name="FileAkte" required />
                                <div class="progress" style="display:block;">
                                    <div class="progress-bar progs1 progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Kartu Keluarga *(PDF)</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="file" class="file-control file fileBerkas" data-row="2" id="fileBerkas2" data-show-preview="false" name="file" required />
                                <input type="hidden" class="filename2" data-show-preview="false" name="FileKK" required />
                                <div class="progress" style="display:block;">
                                    <div class="progress-bar progs2 progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Nilai Raport 3 Semester Terakkhir *(PDF)</label>
                            <div class="col-sm-12 col-md-10">
                                <input type="file" class="file-control file fileBerkas" data-row="3" id="fileBerkas3" data-show-preview="false" name="file" required />
                                <input type="hidden" class="filename3" data-show-preview="false" name="FileRaport" required />
                                <div class="progress" style="display:block;">
                                    <div class="progress-bar progs3 progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-right">
                            <input type="submit" class="btn btn-md btn-primary" value="Proses Data">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(".progress-bar").width(0 + "%");
        $(".progress-bar").html(0 + "%");
    })
    var id = '<?= $idus ?>';
    var V_lembaga;
    $.ajax({
        url: '<?= base_url() ?>pmb_api/berkas/get_data_by_id',
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        beforeSend: function() {
            $(".loader").show(0);
        },
        error: function(x) {
            alert("error!");
            console.log(x.responseText);
        },
        success: function(data) {
            $(".loader").fadeOut(1000);
            // console.log($("a#BackBTN").attr('href', ''));
            $("a#BackBTN").attr("href", "<?= base_url() ?>pmb/datadiri/" + data.token)
            $('form .idPelajar').val(id);
        }
    });


    $(".fileBerkas").change(function() {
        var id = $(this).data("row");
        var fd = new FormData();
        var files = $(this)[0].files;
        $(".progs" + id).width(0 + "%");
        $(".progs" + id).html(0 + "%");
        if (files.length > 0) {
            fd.append("file", files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener(
                        "progress",
                        function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $(".progs" + id).width(percentComplete + "%");
                                $(".progs" + id).html(percentComplete + "%");
                            }
                        },
                        false
                    );
                    return xhr;
                },
                url: "<?= base_url() ?>pmb_api/berkas/upload_file",
                type: "post",
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                dataType: "json",
                success: function(response) {
                    if (response != 0) {
                        $(".filename" + id).val(response.file);
                    } else {
                        alert("file not uploaded");
                        $(".progs" + id).width(0 + "%");
                        $(".progs" + id).html(0 + "%");
                    }
                },
            });
        } else {
            alert("Please select a file.");
        }
    });
    $(".imgf").change(function() {
        var id = $(this).data("row");
        var fd = new FormData();
        var files = $('#imgf' + id)[0].files;
        if (files.length > 0) {
            fd.append('file', files[0]);
            $.ajax({
                url: '<?= base_url() ?>pmb_api/berkas/uploads_img',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {

                    $(".loader").show(0);
                    $("#imgv" + id).attr("src", "<?= base_url() ?>assets/images/spin.svg");
                    $("#imgv" + id).show();
                },
                dataType: "json",
                success: function(response) {
                    $(".loader").fadeOut(1000);
                    if (response != 0) {
                        $(".text" + id).val(response.nimg);
                        $("#imgv" + id).attr("src", response.img);
                        $("#imgv" + id).show();
                        //console.log(response)
                    } else {
                        alert('file not uploaded');
                    }

                },
            });
        } else {
            alert("Please select a file.");
        }
    });
</script>
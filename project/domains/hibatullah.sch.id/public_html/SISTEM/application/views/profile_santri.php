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
                    <h4> <span class="fa fa-address-book-o"></span> Profile User</h4>
                    <div class="cabang-top"><?= $this->session->userdata("nama_cabang") ?></div>
                </div>
            </div>

            <div class="wizard-content">

                <form action="<?= base_url() ?>data_api/pelajar/new_data" method="POST" enctype="multipart/form-data" class="tab-wizard wizard-circle wizard">
                    <h5>Data Diri</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Data Diri</h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" class="idPelajar form-control-sm" name="idPelajar">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label ">Nama Lembaga</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="custom-select2 form-control form-control-sm-sm Lembaga" name="Lembaga">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Nama Lengkap </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control form-control-sm Nama_lengkap" name="Nama_lengkap" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Nama Panggilan </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control form-control-sm Nama_Panggilan" name="Nama_Panggilan" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">NIK</label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="number" class="form-control form-control-sm NIK" name="NIK" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">NIS Santri</label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control form-control-sm NIS" name="NIS" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="form-control form-control-sm  jns_kelamin" name="jns_kelamin">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Kota Kelahiran</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="custom-select2 form-control cs1 KotaLahir" name="KotaLahir" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-12 col-md-8">
                                        <input class="form-control form-control-sm dateset-control-page Tlahir" autocomplete="off" placeholder="input tanggal" type="text" name="Tlahir" data-date-end-date="0d">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Alamat</h5>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h6>Alamat</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label ">Anak Ke </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="number" class="form-control form-control-sm Anak_ke" name="Anak_ke" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label ">Dari </label>
                                    <div class="col-sm-12 col-md-4">
                                        <input type="number" class="form-control form-control-sm Dari_saudara" name="Dari_saudara" autocomplete="off">
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        Bersaudara
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Status Anak</label>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="input-group">
                                            <div id="radioBtn" class="btn-group">
                                                <a class="btn btn-primary radioBtnChk btn-sm active" data-toggle="ST_ANAK" data-title="KANDUNG">KANDUNG</a>
                                                <a class="btn btn-primary radioBtnChk btn-sm notActive" data-toggle="ST_ANAK" data-title="ANGKAT">ANGKAT</a>
                                            </div>
                                            <input type="hidden" name="ST_ANAK" id="ST_ANAK" value="KANDUNG">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Alamat Rumah</label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control form-control-sm Alamat_rumah" name="Alamat_rumah" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Kota Alamat</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="custom-select2 form-control cs2 Kota_alamat" style="width: 100%;" name="Kota_alamat">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4  col-form-label">Kecamatan</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="custom-select2 form-control cs3 kecamatan" style="width: 100%;" name="kecamatan">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">Kelurahan</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select class="custom-select2  form-control cs4 Kelurahan" name="Kelurahan" style="width: 100%;">
                                            <option value=""> -Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Pendidikan</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Sekolah Asal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nama Sekolah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm Sekolah" name="Sekolah" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Alamat Sekolah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm Alamat_Sekolah" name="Alamat_Sekolah" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">NISN</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="number" class="form-control form-control-sm Kelas_Sekolah" name="Kelas_Sekolah" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Hafalan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Hafal</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm Hafal" name="Hafal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Lancar</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm Lacar" name="Lacar" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Baca Al-Qur'an (Jilid)</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm Jilid" name="Jilid" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Orang Tua</h5>
                    <section>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Data Ayah</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nama Ayah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm Nama_Ayah" type="text" autocomplete="off" name="Nama_Ayah">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Tempat, Tgl. lahir </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm TLAyah" name="TLAyah" autocomplete="off"> <input class="form-control form-control-sm dateset-control-page TlahirAyah" autocomplete="off" placeholder="input tanggal" type="text" name="TlahirAyah" data-date-end-date="0d">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">NIK</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm NIK_Ayah" type="number" autocomplete="off" name="NIK_Ayah">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Telepon Ayah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Telepon_Ayah" type="text" autocomplete="off" name="Telepon_Ayah">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pekerjaan Ayah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pekerjaan_Ayah" type="text" autocomplete="off" name="Pekerjaan_Ayah">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Penghasilan</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select form-control form-control-sm-sm Penghasilan_Ayah" name="Penghasilan_Ayah">
                                                    <option value=""> -Pilih -</option>
                                                    <option value="Rp.0 - Rp.1,000,000">Rp.0 - Rp.1,000,000</option>
                                                    <option value="Rp.1,000,000 - Rp.2,000,000">Rp.1,000,000 - Rp.2,000,000</option>
                                                    <option value="Rp.2,000,000 - Rp.3,000,000">Rp.2,000,000 - Rp.3,000,000</option>
                                                    <option value="Rp.3,000,000-5,000,000">Rp.3,000,000-5,000,000</option>
                                                    <option value="> Rp.5,000,000"> > Rp.5,000,000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pendidikan Ayah</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pendidikan_Ayah" type="text" autocomplete="off" name="Pendidikan_Ayah">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Data Ibu</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nama Ibu</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm Nama_Ibu" type="text" autocomplete="off" name="Nama_Ibu">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Tempat, Tgl. lahir </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm TLIbu" name="TLIbu" autocomplete="off"> <input class="form-control form-control-sm dateset-control-page TlahirIbu" autocomplete="off" placeholder="input tanggal" type="text" name="TlahirIbu" data-date-end-date="0d">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">NIK</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm NIK_Ibu" type="number" autocomplete="off" name="NIK_Ibu">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Telepon Ibu</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Telepon_Ibu" type="text" autocomplete="off" name="Telepon_Ibu">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pekerjaan Ibu</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pekerjaan_Ibu" type="text" autocomplete="off" name="Pekerjaan_Ibu">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Penghasilan</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select form-control form-control-sm-sm Penghasilan_Ibu" name="Penghasilan_Ibu">
                                                    <option value=""> -Pilih -</option>
                                                    <option value="Rp.0 - Rp.1,000,000">Rp.0 - Rp.1,000,000</option>
                                                    <option value="Rp.1,000,000 - Rp.2,000,000">Rp.1,000,000 - Rp.2,000,000</option>
                                                    <option value="Rp.2,000,000 - Rp.3,000,000">Rp.2,000,000 - Rp.3,000,000</option>
                                                    <option value="Rp.3,000,000-5,000,000">Rp.3,000,000-5,000,000</option>
                                                    <option value="> Rp.5,000,000"> > Rp.5,000,000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pendidikan Ibu</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pendidikan_Ibu" type="text" autocomplete="off" name="Pendidikan_Ibu">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Data Wali
                                        </h6>
                                    </div>
                                    <div class="input-group label-floating">
                                        <div id="BtnWali" class="btn-group">
                                            <a class="btn btn-primary btn-sm notActive" data-toggle="chekwali" data-title="A">AYAH</a>
                                            <a class="btn btn-primary btn-sm notActive" data-toggle="chekwali" data-title="I">IBU</a>
                                            <a class="btn btn-primary btn-sm active" data-toggle="chekwali" data-title="N">LAINNYA</a>
                                        </div>
                                        <input type="hidden" name="chekwali" id="chekwali" value="N">
                                    </div>
                                    <div class="card-body CRWALI">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Nama Wali</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm Nama_Wali" type="text" autocomplete="off" name="Nama_Wali">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Tempat, Tgl. lahir </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control form-control-sm TLWali" name="TLWali" autocomplete="off"> <input class="form-control form-control-sm dateset-control-page TlahirWali" autocomplete="off" placeholder="input tanggal" type="text" name="TlahirWali" data-date-end-date="0d">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">NIK</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm NIK_Wali" type="number" autocomplete="off" name="NIK_Wali">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Telepon Wali</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Telepon_Wali" type="text" autocomplete="off" name="Telepon_Wali">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pekerjaan Wali</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pekerjaan_Wali" type="text" autocomplete="off" name="Pekerjaan_Wali">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label ">Penghasilan</label>
                                            <div class="col-sm-12 col-md-8">
                                                <select class="custom-select form-control form-control-sm-sm Penghasilan_Wali" name="Penghasilan_Wali">
                                                    <option value=""> -Pilih -</option>
                                                    <option value="Rp.0 - Rp.1,000,000">Rp.0 - Rp.1,000,000</option>
                                                    <option value="Rp.1,000,000 - Rp.2,000,000">Rp.1,000,000 - Rp.2,000,000</option>
                                                    <option value="Rp.2,000,000 - Rp.3,000,000">Rp.2,000,000 - Rp.3,000,000</option>
                                                    <option value="Rp.3,000,000-5,000,000">Rp.3,000,000-5,000,000</option>
                                                    <option value="> Rp.5,000,000"> > Rp.5,000,000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-4 col-form-label">Pendidikan Wali</label>
                                            <div class="col-sm-12 col-md-8">
                                                <input class="form-control form-control-sm  Pendidikan_Wali" type="text" autocomplete="off" name="Pendidikan_Wali">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h5>Finish</h5>
                    <section>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Tanggal Daftar</label>
                                    <div class="col-sm-12 col-md-9">
                                        <input class="form-control form-control-sm dateset-control-page Tdaftar" autocomplete="off" placeholder="input tanggal" type="text" name="Tdaftar" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Status</label>
                                    <div class="col-sm-12 col-md-9">
                                        <select name="Status" id="Status" class="form-control form-control-sm datapicker Status" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-3 col-form-label">Jalur Pendaftaran</label>
                                    <div class="col-sm-12 col-md-9">
                                        <select name="JalurDaftar" id="JalurDaftar" class="form-control form-control-sm  JalurDaftar" required>
                                            <option value="">-Pilih Jalur-</option>
                                            <option value="1">Reguler</option>
                                            <option value="2">Beasiswa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class=" BS_daftar " style="display:none">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-3 col-form-label">Jenis Beasiswa</label>
                                        <div class="col-sm-12 col-md-9">
                                            <select name="JenisBeasiswa" id="JenisBeasiswa" class="form-control form-control-sm  JenisBeasiswa" required="">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn btn-block btn-mdb-color btn-rounded float-left">
                                    <label style="color: #fff; ">Photo Img</label><br>
                                    <div class="Spins">
                                        <img src="/img_pelajar/default.png" class="picture-src " style="width: 100px;" id="imgv5" title="" />
                                    </div>
                                    <input type="file" class="file imgf" data-show-preview="false" data-row="5" id="imgf5" />
                                </div>
                                <input type="hidden" class="text5 Image" name="Image" value="null">
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        $("form .Kota_alamat").change(function() {
            var id = $(this).val();
            var V_kec;
            // alert("OK");
            $.ajax({
                url: url + 'data_api/wilayah/get_kecamatan',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                error: function() {
                    alert("ERROR");
                },
                success: function(data) {
                    if (data.kec.length > 0) {
                        V_kec = '<option value=""> -Pilih Kecamatan -</option>'
                        $.each(data.kec, function(i, row) {
                            V_kec += '<option value="' + row.id + '">' + row.kecamatan + '</option>';
                        });
                    } else {
                        V_kec = '<option value=""> No Result Data</option>'
                    };

                    $('form .kecamatan').html(V_kec);
                }
            })
        })
        $("form .kecamatan").change(function() {
            var id = $(this).val();
            var V_kel;
            $.ajax({
                url: url + 'data_api/wilayah/get_kelurahan',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                error: function() {
                    alert("ERROR");
                },
                success: function(data) {
                    if (data.kel.length > 0) {
                        V_kel = '<option value=""> -Pilih Kelurahan -</option>'
                        $.each(data.kel, function(i, row) {
                            V_kel += '<option value="' + row.id + '">' + row.kelurahan + '</option>';
                        });
                    } else {
                        V_kel = '<option value=""> No Result Data</option>'
                    };

                    $('form .Kelurahan').html(V_kel);
                }
            })
        })
    });

    function clearDta() {
        // $(".tab-wizard").steps("reset");
        $('form .Nama_lengkap').val("");
        $('form .Nama_Panggilan').val("");
        $('form .NIK').val("");
        $('form .NIS').val("");
        $('form .Tlahir').val("");

        $('form .Alamat_rumah').val("");
        $('form .kecamatan').html("");
        $('form .Kelurahan').html("");
        $('form .Hafalan').val("");

        $('form .Anak_ke').val("");
        $('form .Dari_saudara').val("");
        $('form .Hafal').val("");
        $('form .Lacar').val("");
        $('form .Jilid').val("");
        $('form .Sekolah').val("");
        $('form .Alamat_Sekolah').val("");
        $('form .Kelas_Sekolah').val("");


        $('form .Nama_Ayah').val("");
        $('form .Telepon_Ayah').val("");
        $('form .Pendidikan_Ayah').val("");
        $('form .Pekerjaan_Ayah').val("");
        $('form .NIK_Ayah').val("");
        $('form .TLAyah').val("");
        $('form .TlahirAyah').val("");
        $('form .Penghasilan_Ayah').html(PenghasilanSet());

        $('form .Nama_Ibu').val("");
        $('form .Telepon_Ibu').val("");
        $('form .Pendidikan_Ibu').val("");
        $('form .Pekerjaan_Ibu').val("");
        $('form .NIK_Ibu').val("");
        $('form .TLIbu').val("");
        $('form .TlahirIbu').val("");
        $('form .Penghasilan_Ibu').html(PenghasilanSet());

        $('form .Nama_Wali').val("");
        $('form .Telepon_Wali').val("");
        $('form .Pendidikan_Wali').val("");
        $('form .Pekerjaan_Wali').val("");
        $('form .NIK_Wali').val("");
        $('form .TLWali').val("");
        $('form .TlahirWali').val("");
        $('form .Penghasilan_Wali').html(PenghasilanSet());


        $('#chekwali').prop('value', "N");

        $('a[data-toggle="chekwali"]').not('[data-title="N"]').removeClass('active').addClass('notActive');

        $('a[data-toggle="chekwali"][data-title="N"]').removeClass('notActive').addClass('active');
        $(".Nama_Wali").prop('required', false);
        $(".NIK_Wali").prop('required', false);
        $(".Telepon_Wali").prop('required', false);
        $(".Pekerjaan_Wali").prop('required', false);
        $(".Penghasilan_Wali").prop('required', false);
        $(".CRWALI").show();


        $('form .Tdaftar').val("");
        $('form .Jabatan').val("");
        $('form .Kontak').val("");

        var jb = '<option value="">-pilih jalur-</option><option value="1">Reguler</option><option value="2">Beasiswa</option>';
        $('form #JalurDaftar').html(jb);

        $(".BS_daftar").css("display", "none");
        $.ajax({
            url: url + 'data_api/pelajar/get_status',
            dataType: "json",
            beforeSend: function() {

                $(".loader").show(0);
            },
            error: function() {
                alert("error ambil status!");
            },
            success: function(data) {
                var sts = '<option value=""> -Pilih Status -</option>';
                $.each(data, function(i, r) {
                    sts += '<option value="' + r.id + '">' + r.set_active + '</option>';
                })
                $('form .Status').html(sts);
                $(".loader").fadeOut(1000);
            }
        });
        $('form .jns_kelamin').html(
            '<option option value="0" > -Pilih Jenis -</option > ' +
            '<option value="1">Laki - Laki</option>' +
            '<option value="2">Perempuan</option>');
        $('form .file').val("");
        $('form .Image').val("null");
        $(".picture-src").attr("src", url + "img_pelajar/default.png");
    }

    function PenghasilanSet() {
        var Result = '<option value="">- pilih -</option>' +
            ' <option value="Rp.0 - Rp.1,000,000">Rp.0 - Rp.1,000,000</option>' +
            '<option value="Rp.1,000,000 - Rp.2,000,000">Rp.1,000,000 - Rp.2,000,000</option>' +
            '<option value="Rp.2,000,000 - Rp.3,000,000">Rp.2,000,000 - Rp.3,000,000</option>' +
            '<option value="Rp.3,000,000-5,000,000">Rp.3,000,000-5,000,000</option>' +
            '<option value="> Rp.5,000,000"> > Rp.5,000,000</option>';
        return Result;
    }

    $(function() {
        ////////////////////////////////////
        ////////////////////////////////////
        $('form').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $(".loader").show(0);
                    // $('.FormOpenPelajar').modal("hide");
                },
                error: function() {
                    alert("error!");
                },
                success: function(data) {
                    console.log(data);
                    $(".loader").fadeOut(1000);
                    // table.ajax.reload();
                    $('.event-icon').html("<i class='fa fa-" + data.event.icon + "'  style='color:" + data.event.color + "'></i>");
                    $('.event-title').html(data.event.title);
                    $('.event-body').html(data.event.description);
                    $('.event-footer').html(data.event.footer);
                    $('#Msg-Notification').modal('show');
                    setTimeout(function() {
                        $(".loader").show(0).fadeOut(1000);
                        window.location.href = '<?= base_url('profile') ?>';
                    }, time);
                }
            });
        });
        var id = '<?= $idus ?>';
        var V_lembaga;
        $.ajax({
            url: url + 'data_api/pelajar/get_data_by',
            method: "POST",
            data: {
                id: id,
            },
            dataType: "json",
            beforeSend: function() {

                $(".loader").show(0);
                clearDta()
            },
            error: function() {
                alert("error!");
            },
            success: function(data) {
                console.log(data);

                $(".loader").fadeOut(1000);
                V_lembaga = '<option value="' + data.dt1.cabang_id + '">' + data.dt1.nama_cabang + '</option>';
                $.each(data.cabang, function(i, row) {
                    if (data.dt1.cabang_id === row.id) {} else {
                        V_lembaga += '<option value="' + row.id + '">' + row.nama_cabang + '</option>';
                    }
                });
                var V_Kota = '<option value="' + data.dt1.id_kota + '">' + data.dt1.kota_lahir + '</option>'
                $.each(data.kota, function(i, row) {
                    if (data.dt1.id_kota === row.id) {} else {
                        V_Kota += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var iddesa = data.dt1.id_kelurahan;
                var iddset1, iddset2;
                if (iddesa > 0) {
                    iddset1 = iddesa.substring(0, 4);
                    iddset2 = iddesa.substring(0, 7);
                } else {
                    iddset1 = '';
                    iddset2 = '';
                }
                var V_Kota2 = '<option value="' + iddset1 + '">' + data.dt1.kota + '</option>'
                $.each(data.kota, function(i, row) {
                    if (iddset1 === row.id) {} else {
                        V_Kota2 += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var V_kec = '<option value="' + iddset2 + '">' + data.dt1.kecamatan + '</option>'
                $.each(data.kota, function(i, row) {
                    if (iddset2 === row.id) {} else {
                        V_kec += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var V_kel = '<option value="' + iddesa + '">' + data.dt1.kelurahan + '</option>'
                $.each(data.kota, function(i, row) {
                    if (iddesa === row.id) {} else {
                        V_kel += '<option value="' + row.id + '">' + row.kota + '</option>';
                    }
                });
                var V_bl = '<option value="' + data.dt1.infaq_bulanan + '">' + data.dt1.bulanan + '</option>'
                $.each(data.bulanan, function(i, row) {
                    if (data.dt1.infaq_bulanan === row.id_nominal) {} else {
                        V_bl += '<option value="' + row.id_nominal + '">' + row.infaq_bulanan + '</option>';
                    }
                });
                var V_th = '<option value="' + data.dt1.infaq_tahunan + '">' + data.dt1.tahunan + '</option>'
                $.each(data.tahunan, function(i, row) {
                    if (data.dt1.infaq_tahunan === row.id_nominal) {} else {
                        V_th += '<option value="' + row.id_nominal + '">' + row.infaq_tahunan + '</option>';
                    }
                });
                var V_gr = '<option value="' + data.dt1.managenent + '">' + data.dt1.nama_guru + '</option>'
                $.each(data.guru, function(i, row) {
                    if (data.dt1.managenent === row.id_karyawan) {} else {
                        V_gr += '<option value="' + row.id_karyawan + '">' + row.nama_lengkap + '</option>';
                    }
                });

                $('.jns_kelamin option[value=' + data.dt1.jns_kelamin + ']').attr('selected', 'selected');

                var T_lahir = formarDate(data.dt1.tgl_lahir);
                var T_Aktif = formarDate(data.dt1.tgl_pendaftaran);
                $('form .Nama_lengkap').val(data.dt1.nama_lengkap);
                $('form .Nama_Panggilan').val(data.dt1.nama_panggilan);
                $('form .NIK').val(data.dt1.nik_santri);
                $('form .NIS').val(data.dt1.nis);
                $('form .Tlahir').val(T_lahir);
                $('form .Alamat_rumah').val(data.dt1.alamat);
                $('form .Lembaga').html(V_lembaga);
                $('form .KotaLahir').html(V_Kota);
                $('form .Kota_alamat').html(V_Kota2);
                $('form .kecamatan').html(V_kec);
                $('form .Kelurahan').html(V_kel);
                $('form .Nama_Guru').html(V_gr);

                $('form .Anak_ke').val(data.dt1.anak_ke);
                $('form .Dari_saudara').val(data.dt1.dari);
                $('form .Hafal').val(data.dt1.hafal);
                $('form .Lacar').val(data.dt1.lancar);
                $('form .Jilid').val(data.dt1.baca);
                $('form .Sekolah').val(data.dt1.nama_sekolah);
                $('form .Alamat_Sekolah').val(data.dt1.alamat_sekolah);
                $('form .Kelas_Sekolah').val(data.dt1.kelas);

                $('form .Nama_Ayah').val(data.dt1.nama_ayah);
                $('form .Telepon_Ayah').val(data.dt1.nomor_hp_ayah);
                $('form .Pendidikan_Ayah').val(data.dt1.pendidikan_ayah);
                $('form .Pekerjaan_Ayah').val(data.dt1.pekerjaan_ayah);
                $('form .NIK_Ayah').val(data.dt1.nik_ayah);
                $('form .TLAyah').val(data.dt1.tempat_lahir_ayah);
                $('form .TlahirAyah').val(data.dt1.tgl_lahir_ayah);
                var ph_AYAH = '<option value="' + data.dt1.penghasilan_ayah + '">' + data.dt1.penghasilan_ayah + '</option>';
                $('form .Penghasilan_Ayah').val(data.dt1.penghasilan_ayah);
                $('form .Nama_Ibu').val(data.dt1.nama_ibu);
                $('form .Telepon_Ibu').val(data.dt1.nomor_hp_ibu);
                $('form .Pendidikan_Ibu').val(data.dt1.pendidikan_ibu);
                $('form .Pekerjaan_Ibu').val(data.dt1.pekerjaan_ibu);
                $('form .NIK_Ibu').val(data.dt1.nik_ibu);
                $('form .TLIbu').val(data.dt1.tempat_lahir_ibu);
                $('form .TlahirIbu').val(data.dt1.tgl_lahir_ibu);
                var ph_IBU = '<option value="' + data.dt1.penghasilan_ibu + '">' + data.dt1.penghasilan_ibu + '</option>';
                $('form .Penghasilan_Ibu').val(data.dt1.penghasilan_ibu);
                $('form .Nama_Wali').val(data.dt1.wali_peserta);
                $('form .Telepon_Wali').val(data.dt1.kontak_wali);
                $('form .Pendidikan_Wali').val(data.dt1.pendidikan_wali);
                $('form .Pekerjaan_Wali').val(data.dt1.pekerjaan_wali);
                $('form .NIK_Wali').val(data.dt1.nik_wali);
                $('form .TLWali').val(data.dt1.tempat_lahir_wali);
                $('form .TlahirWali').val(data.dt1.tgl_lahir_wali);
                var ph_Wali = '<option value="' + data.dt1.penghasilan_wali + '">' + data.dt1.penghasilan_wali + '</option>';
                $('form .Penghasilan_Wali').val(data.dt1.penghasilan_wali);
                if (data.dt1.st_anak === 'KANDUNG') {
                    btn1 = "active";
                    btn2 = "notActive";
                } else {
                    btn1 = "notActive";
                    btn2 = "active";
                }
                $('form #ST_ANAK').val(data.dt1.st_anak);
                var ANAK_ST = '<a class="btn btn-primary radioBtnChk btn-sm ' + btn1 + ' " data-toggle="ST_ANAK" data-title="KANDUNG">KANDUNG</a>' +
                    '<a class="btn btn-primary radioBtnChk btn-sm ' + btn2 + '" data-toggle="ST_ANAK" data-title="ANGKAT">ANGKAT</a>'
                $('form #radioBtn').html(ANAK_ST);
                $(".picture-src").attr("src", url + "img_pelajar/" + data.dt1.gambar);
                $(".Image").val(data.dt1.gambar);
                $('form .Tdaftar').val(T_Aktif);

                $('form #Status option[value=' + data.dt1.status_pelajar + ']').attr('selected', 'selected');
                $('form #JalurDaftar option[value=' + data.dt1.jalur_daftar + ']').attr('selected', 'selected')
                $('form #JenisBeasiswa option[value=' + data.dt1.beasiswa + ']').attr('selected', 'selected');
                $("#JenisBeasiswa").attr("required", false);
                if (data.dt1.jalur_daftar == 2) {
                    $(".BS_daftar").css("display", 'block');
                    $("#JenisBeasiswa").attr("required", true);
                }
                var pic = '<img src="' + url + 'assets/img_pelajar/' + data.dt1.gambar + '" style="width:140px">';
                $('form .Data_photo').html(pic);
                $('form .File_Old').val(data.dt1.gambar);
                // $('.options').html('<i class="fa fa-plus-circle"></i> ' + opt);
                $('form .idPelajar').val(id);
                // $('.FormOpenPelajar').modal();
            }
        });

        ///////////////////////
        $("form #JalurDaftar").change(function() {
            var jalur = $(this).val();
            if (jalur > 1) {
                var jbs = '<option value="0">-pilih Jenis Beasiswa-</option>' +
                    '<option value="1">Prestasi</option><option value="2">Yatim Dhuafa</option><option value="3">Dhuafa</option>';
                $('form #JenisBeasiswa').html(jbs);
                $(".BS_daftar").css("display", "block");
                $("#JenisBeasiswa").attr("required", true);
            } else {
                $(".BS_daftar").css("display", "none");
                var jbs = '<option value="0">-pilih Jenis Beasiswa-</option>';
                $('form #JenisBeasiswa').html(jbs);
                $("#JenisBeasiswa").attr("required", false);
            }
        });
        $('div#radioBtn ').on('click', '.radioBtnChk', function() {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);
            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
        })
        $('#BtnWali a').on('click', function() {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);
            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
            if (sel == 'N') {
                $(".Nama_Wali").prop('required', true);
                $(".NIK_Wali").prop('required', true);
                $(".Telepon_Wali").prop('required', true);
                $(".Pekerjaan_Wali").prop('required', true);
                $(".Penghasilan_Wali").prop('required', true);
                $(".CRWALI").show();
            } else {
                $(".Nama_Wali").prop('required', false);
                $(".NIK_Wali").prop('required', false);
                $(".Telepon_Wali").prop('required', false);
                $(".Pekerjaan_Wali").prop('required', false);
                $(".Penghasilan_Wali").prop('required', false);
                $(".Nama_Wali").removeAttr('required');
                $(".NIK_Wali").removeAttr('required');
                $(".Telepon_Wali").removeAttr('required');
                $(".Pekerjaan_Wali").removeAttr('required');
                $(".Penghasilan_Wali").removeAttr('required');
                $(".CRWALI").hide();
            }
        });

        $(".imgf").change(function() {
            var id = $(this).data("row");
            var fd = new FormData();
            var files = $('#imgf' + id)[0].files;
            if (files.length > 0) {
                fd.append('file', files[0]);
                $.ajax({
                    url: url + 'data_api/pelajar/uploads_img',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {

                        $(".loader").show(0);
                        $("#imgv" + id).attr("src", url + "assets/images/spin.svg");
                        $("#imgv" + id).show();
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response != 0) {
                            $(".text" + id).val(response.nimg);
                            $("#imgv" + id).attr("src", response.img);
                            $("#imgv" + id).show();
                            //console.log(response)
                        } else {
                            alert('file not uploaded');
                        }

                        $(".loader").fadeOut(1000);
                    },
                });
            } else {
                alert("Please select a file.");
            }
        });


    })

    function formarDate(e) {
        var date = new Date(e);
        var month = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ][date.getMonth()];
        var day = date.getDate();
        var FullDate = day + ' ' + month + ' ' + date.getFullYear();
        return FullDate;
    };
</script>
<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Datasantri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['encryption', 'secure']);
        $this->load->library('session');
        $this->load->model(['m_dashboard', 'm_data_pelajar']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    function get($id = null)
    {
        $viwedata = '';
        if ($id != null) {
            $dtshow = $this->secure->decrypt_url($id);
            if ($dtshow == 'alldata') {
            } else {
                $ids = json_decode($dtshow);
                // $jmid  = count($ids);
                // for ($i = 0; $i < $jmid; $i++) {
                //     $viwedata .= $this->profile($ids['id_santri'][$i]);
                // }
                $viwedata = $this->profile($ids->id_santri);
            }
            $data['TitelPage'] = 'SIAR - Data Profile Santri';
            $data['data_plug'] = 'datatable';
            $data['action'] = 'pelajar_prfile_v3.2';
            $data['profile'] = $viwedata;
            $this->load->view('template/head', $data);
            $this->load->view('template/loader');
            $this->load->view('template/header');
            $this->load->view('template/right_bar');
            $this->load->view('template/left_bar');
            $this->load->view('data/datapelajar');
            $this->load->view('template/footer');
        }
    }
    function profile($id)
    {
        $pelajar = $this->m_data_pelajar->GetDataPelajarBy($id)->row_object();
        $btnEdit = '';
        $lvl = $this->session->userdata("idlevel");
        if ($lvl >= 30) {
            $btnEdit = '
            <div class="col-md-12 text-right">
        <button class="btn btn-sm btn-primary formopen " data-opt="Edit Data" data-id="' . $pelajar->id_pelajar . '" style=" pdding:5px"> <i clas="fa fa-edit"></i> Edit Data
        </button></div>';
        }
        $data = '
                    <div class="card-header">
                            <div class="row no-gutters" >
                                <div style="
                                    width: 80px; 
                                    height: 90px; 
                                    object-fit: cover;
                                    object-position: 20% 10%; 
                                    border-radius:10px;
                                    overflow: hidden; margin:5px">
                                        <img src="' . base_url("img_pelajar/") . $pelajar->gambar . '" style="width: 80px">
                                    </div>
                                <div class="col">
                                    <div class="blog-caption ml-2 mt-2">
                                        <h5>' . $pelajar->nama_lengkap . '</h5>
                                        <div style="font-size:10px"> <b>Panggilan : ' . $pelajar->nama_panggilan . '</b>
                                        <div style="color:#ff8040; font-size:16px; font-weight:800; margin-top:4px">
                                        ' . $pelajar->nis . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ' . $btnEdit . '
                    </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                                    <div class="pd-20 card-box height-100-p mt-3">
                                        <div class="profile-info">
                                            <ul>
                                                <li>
                                                    <span>NIS:</span>
                                                    ' . $pelajar->cabang_kode . '' . $pelajar->nis . '
                                                </li>
                                                <li>
                                                    <span>Nama Lembaga:</span>
                                                    ' . $pelajar->nama_cabang . '
                                                </li>
                                                <li>
                                                    <span>Tanggal Pendaftaran:</span>
                                                    ' . $pelajar->tgl_pendaftaran . '
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="profile-info">
                                            <ul>
                                                <li><span>Nama Lengkap:</span>' . $pelajar->nama_lengkap . '</li>
                                                <li><span>Nama Lengkap:</span>' . $pelajar->nama_panggilan . '</li>
                                                <li><span>Kota Kelahiran:</span>' . $pelajar->kota_lahir . '</li>
                                                <li><span>Tanggal Lahir:</span>' . $pelajar->tgl_lahir . '</li>
                                                <li><span>Alamat :</span>' . strtoupper($pelajar->alamat) . '</li>
                                                <li><span>Kelurahan :</span>' . $pelajar->kelurahan . '</li>
                                                <li><span>Kecamatan :</span>' . $pelajar->kecamatan . '</li>
                                                <li> <span>Kota :</span>' . $pelajar->kota . '</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30 mt-3">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Data Sekolah</h6>
                                                    <div class="profile-info">
                                                        <ul>
                                                            <li>
                                                                <span>Nama Sekolah:</span>
                                                                ' . $pelajar->nama_sekolah . '
                                                            </li>
                                                            <li>
                                                                <span>Alamat Sekolah:</span>
                                                                ' . $pelajar->alamat_sekolah . '
                                                            </li>
                                                            <li>
                                                                <span>Kelas:</span>
                                                                ' . $pelajar->kelas . '
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Data Orang Tua</h6>
                                                    <div class="profile-info">
                                                        <ul>
                                                            <li>
                                                                <span>Nama Ayah:</span>
                                                                ' . $pelajar->nama_ayah . '
                                                            </li>
                                                            <li>
                                                                <span>Pendidikan Ayah:</span>
                                                                ' . $pelajar->pendidikan_ayah . '
                                                            </li>
                                                            <li>
                                                                <span>Pekerjaan Ayah:</span>
                                                                ' . $pelajar->pekerjaan_ayah . '
                                                            </li>
                                                            <li>
                                                                <span>Telepon Ayah:</span>
                                                                ' . $pelajar->nomor_hp_ayah . '
                                                            </li>
                                                            <li>
                                                                <hr>
                                                            </li>
                                                            <li>
                                                                <span>Nama Ibu:</span>
                                                                ' . $pelajar->nama_ibu . '
                                                            </li>
                                                            <li>
                                                                <span>Pendidikan Ibu:</span>
                                                                ' . $pelajar->pendidikan_ibu . '
                                                            </li>
                                                            <li>
                                                                <span>Pekerjaan Ibu:</span>
                                                                ' . $pelajar->pekerjaan_ibu . '
                                                            </li>
                                                            <li>
                                                                <span>Telepon Ibu:</span>
                                                                ' . $pelajar->nomor_hp_ayah . '
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 ">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Hafalan Al-Qur' . "'" . 'an (Saat Daftar)</h6>
                                                    <div class="profile-info">
                                                        <ul>
                                                            <li>
                                                                <span>Hafal:</span>
                                                                ' . $pelajar->hafal . ' Juz
                                                            </li>
                                                            <li>
                                                                <span>Lancar:</span>
                                                                ' . $pelajar->lancar . ' Juz
                                                            </li>
                                                            <li>
                                                                <span>Baca Al-qur' . "'" . 'an (jilid):</span>
                                                                ' . $pelajar->baca . ' Juz
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="profile-info">
                                                        <ul>
                                                            <li>
                                                                <span>Nama Wali:</span>
                                                                ' . ($pelajar->wali_peserta) . '
                                                            </li>
                                                            <li>
                                                                <span>Kontak Wali:</span>
                                                                ' . ($pelajar->kontak_wali) . '
                                                            </li>
                                                            <li>
                                                                <span>Manajemen:</span>
                                                                ' . ($pelajar->nama_guru) . '
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        ';
        return $data;
    }
}

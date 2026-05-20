<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['encryption', 'secure', 'user_agent']);
        $this->load->library('session');
        $this->load->model(['m_dashboard', 'm_data_pelajar', 'm_data_asatidzah', 'm_data_donatur', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        $this->load->library('upload');
        is_auth_chek();
    }
    function index()
    {
        $id = $this->session->userdata("id_user");
        $this->db->select("a.*,b.level, (SELECT nama_cabang from data_kantor_cabang where id = a.fid_cabang) as nama_cabang");
        $this->db->join("sys_level b", "b.id_level=a.id_level");
        $datauser = $this->db->get_where('sys_user a', ['a.id_user' => $id])->row_object();
        $data['TitelPage'] = 'Data Profile';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'profile_v3.2';
        $data['profile'] = $datauser;
        $data['idus'] = $datauser->fid_keterangan;
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('profile');
        $this->load->view('template/footer');
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function updatepass()
    {
        $id = $this->input->post("idu");
        $Password1 = $this->input->post("Password1");
        $Password2 = $this->input->post("Password2");
        $SetPass = md5($Password2 . "!@#$%^&*()_+ >> b(^_^)v");
        $this->db->set(['password' => $SetPass]);
        $this->db->where("id_user", $id);
        $this->db->update("sys_user");
        $info = [
            'icon' => 'thumbs-up',
            'title' => ' Success!',
            'description' => 'Update Password Berhasil <br> <b>Silahkan Login Kembali..!</b>',
            'color' => '#a4cc00',
            'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
        ];
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
    function updateicon()
    {
        $id = $this->session->userdata("id_user");
        $img = $this->input->post("img");
        $this->db->set(['icon' => $img]);
        $this->db->where("id_user", $id);
        $this->db->update("sys_user");
        $info = [
            'icon' => 'thumbs-up',
            'title' => ' Success!',
            'description' => 'Update Icon Berhasil</b>',
            'color' => '#a4cc00',
            'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
        ];
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
    function uploads_img()
    {
        $config['upload_path'] = './img_profile/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['source_image'] = './img_profile/' . $gbr['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = '50%';
                $config['new_image'] = './img_profile/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $photomhs = $gbr['file_name'];
                $response = [
                    "img" => substr($config['new_image'], 1),
                    "nimg" => $photomhs,
                ];
                echo json_encode($response);
                exit;
            }
        } else {
            echo 0;
        }
    }
    function profile()
    {
        $id = $this->input->post("id");
        // $id = $this->session->userdata("fid_keterangan");
        $level = $this->session->userdata("idlevel");
        $data =  $this->get_guru($id);
        if ($level >= 30) {
            $pelajar = $this->m_data_pelajar->GetDataPelajarByNis($id);
            if ($pelajar->num_rows() > 0) {
                $pelajar = $pelajar->row_object();
                $data  = $this->get_data_pelajar($pelajar);
            } else {
                $data = '
                <div class="col-12">
                    <div class="mb-30 align-item-center" >
                            <div class="d-block" style="background-image: url(' . "'" . base_url("assets/images/noresult.webp") . "')" . '; background-color: #cccccc; /* Used if the image is unavailable */
                            min-height: 400px;
                            max-width: 300px;
                            margin-left: auto;
                            margin-right: auto;
                            background-position: center; 
                            background-repeat: no-repeat;
                            background-size: cover; " >
                            </div>
                    </div>
                    </div>
                    ';
            }
        }
        echo  $data;
    }
    function get_data_pelajar($dt)
    {
        $data = '<div class="col-md-12 text-right">
        <a href="' . base_url('profile/santri/' . $this->secure->encrypt_url($dt->id_pelajar)) . '" class="badge badge-primary " data-option="Edit"><i class="dw dw-edit2"></i> Edit Data</a></div>
        <div class="row">
        
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p" style=" text-align:center">
<div class="row">
                        <div  style="
width: 80px; 
height: 90px; 
object-fit: cover;
object-position: 20% 10%; 
border-radius:10px;
overflow: hidden; margin:5px auto;">
                            <img src="' . base_url('img_pelajar/') . $dt->gambar . '"style="width: 80px">
            </div>
</div>
            <h5 class="text-center h5 mb-0">' . $dt->nama_lengkap . '</h5>
            <div class="profile-info">
                <ul>
                <li>
                    <span>NIS:</span>
                    ' . $dt->cabang_kode . '' . $dt->nis . '
                </li>
                    <li>
                        <span>Nama Lembaga:</span>
                        ' . $dt->nama_cabang . '
                    </li>
                    <li>
                        <span>Tanggal Pendaftaran:</span>
                        ' . $dt->tgl_pendaftaran . '
                    </li>
                </ul>
            </div>
            <div class="profile-info">
            <ul>
            <li>
                <span>Nama Lengkap:</span>
                ' . $dt->nama_lengkap . '
            </li>
            <li>
                <span>Nama Lengkap:</span>
                ' . $dt->nama_panggilan . '
            </li>
                <li>
                    <span>Kota Kelahiran:</span>
                    ' . $dt->kota_lahir . '
                </li>
                <li>
                    <span>Tanggal Lahir:</span>
                    ' . $dt->tgl_lahir . '
                </li>
                <li>
                    <span>Alamat :</span>
                    ' . strtoupper($dt->alamat) . '
                </li>
                <li>
                    <span>Kelurahan :</span>
                    ' . $dt->kelurahan . '
                </li>
                <li>
                    <span>Kecamatan :</span>
                    ' . $dt->kecamatan . '
                </li>
                <li>
                    <span>Kota :</span>
                    ' . $dt->kota . '
                </li>
            </ul>
            </div>
        </div>
    </div>
    
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
    <div class="card-box height-100-p overflow-hidden">
        <div class="profile-tab height-100-p">
            <div class="tab height-100-p">
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 ">
                            <div class="card">
                                <div class="card-body">
                                <h6>Data Sekolah</h6>
                                    <div class="profile-info">
                                        <ul>
                                        <li>
                                            <span>Nama Sekolah:</span>
                                            ' . $dt->nama_sekolah . '
                                        </li>
                                        <li>
                                            <span>Alamat Sekolah:</span>
                                            ' . $dt->alamat_sekolah . '
                                        </li>
                                            <li>
                                                <span>Kelas:</span>
                                                ' . $dt->kelas . '
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
                                            ' . $dt->nama_ayah . '
                                        </li>
                                        <li>
                                            <span>Pendidikan Ayah:</span>
                                            ' . $dt->pendidikan_ayah . '
                                        </li>
                                        <li>
                                            <span>Pekerjaan Ayah:</span>
                                            ' . $dt->pekerjaan_ayah . '
                                        </li>
                                        <li>
                                            <span>Telepon Ayah:</span>
                                            ' . $dt->nomor_hp_ayah . '
                                        </li>
                                        <li><hr></li>
                                        <li>
                                            <span>Nama Ibu:</span>
                                            ' . $dt->nama_ibu . '
                                        </li>
                                        <li>
                                            <span>Pendidikan Ibu:</span>
                                            ' . $dt->pendidikan_ibu . '
                                        </li>
                                        <li>
                                            <span>Pekerjaan Ibu:</span>
                                            ' . $dt->pekerjaan_ibu . '
                                        </li>
                                        <li>
                                            <span>Telepon Ibu:</span>
                                            ' . $dt->nomor_hp_ayah . '
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6 col-sm-12 ">
                        <div class="card">
                        <div class="card-body">
                        <h6>Hafalan Al-quran (Saat Daftar)</h6>
                            <div class="profile-info">
                                <ul>
                                <li>
                                    <span>Hafal:</span>
                                    ' . $dt->hafal . ' Juz
                                </li>
                                <li>
                                    <span>Lancar:</span>
                                    ' . $dt->lancar . ' Juz
                                </li>
                                    <li>
                                        <span>Baca Al-qur' . "'" . 'an (jilid):</span>
                                        ' . $dt->baca . ' Juz
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
                                    <span>Nama Wali s:</span>
                                    ' . ($dt->wali_peserta) . ' 
                                </li>
                                <li>
                                    <span>Kontak Wali :</span>
                                    ' . ($dt->kontak_wali) . ' 
                                </li>
                                <li>
                                    <span>Manajemen:</span>
                                    ' . ($dt->nama_guru) . ' 
                                </li>
                                <li>
                                    <span>Infaq Daftar Ulang (Tahunan):</span>
                                    Rp.' . number_format($dt->tahunan) . ' 
                                </li>
                                <li>
                                    <span>Infaq Bulanan:</span>
                                    Rp.' . number_format($dt->bulanan) . ' 
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
    </div>
</div></div>
        ';
        return $data;
    }


    function get_guru($id)
    {
        $datakaryuawa = $this->m_data_asatidzah->GetDataAsatidBy($id);
        $data = "";
        if ($datakaryuawa->num_rows() > 0) {
            $dt = $datakaryuawa->row_object();
            $DataKomp = $this->db->query("SELECT * FROM data_karyawan_kompetensi where karyawan_id='$id'")->result();
            $rkomp = '';
            if ($dt->jns_kelamin == 1) {
                $stkel = "Laki-Laki";
            } else {
                $stkel = "Perempuan";
            }
            foreach ($DataKomp as $rk) {
                $rkomp .= '<li><table><tr>
                <td colspan="3"><b>' . $rk->nama_kompetensi  . '</b> (' . date("d M, Y", strtotime($rk->tgl_kompetensi)) . ')</td> 
                </tr>
                <tr>
                    <td>Tingkat</td>
                    <td>&nbsp; : &nbsp;</td>
                    <td> ' . $rk->tingkat . '</td>
                </tr>
                <tr>
                    <td>Ket </td>
                    <td>&nbsp; : &nbsp; </td>
                    <td>' . $rk->ket_kompetensi . '</td>
                </tr></table></li>
                            ';
            }


            $data = '<div class="col-md-12 text-right">
        <a href="' . base_url('profile/karyawan/' . $this->secure->encrypt_url($dt->id_karyawan)) . '" class="badge badge-primary"><i class="dw dw-edit2"></i> Edit Data</a></div>
        <div class="row">
        
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p" style=" text-align:center">
<div class="row">
                        <div  style="
width: 80px; 
height: 90px; 
object-fit: cover;
object-position: 20% 10%; 
border-radius:10px;
overflow: hidden; margin:5px auto;">
                            <img src="' . base_url('img_karyawan/') . $dt->gambar . '"style="width: 80px">
            </div>
</div>
            <h5 class="text-center h5 mb-0">' . $dt->nama_lengkap . '</h5>
            <div class="profile-info">
                <ul>
                <li>
                    <span>NIK:</span>
                    ' . $dt->nik . '
                </li>
                    <li>
                        <span>Nama Lembaga:</span>
                        ' . $dt->nama_cabang . '
                    </li>
                    <li>
                        <span>Tanggal Pendaftaran:</span>
                        '  . date("d/m/Y", strtotime($dt->tgl_aktif)) . '
                    </li>
                </ul>
            </div>
            <div class="profile-info">
            <ul>
            <li>
                <span>Nama Lengkap:</span>
                ' . $dt->nama_lengkap . '
            </li>
            <li>
                <span>Status Menikah:</span>
                ' . $dt->status_nikah . '
            </li>
                <li>
                    <span>Kota Kelahiran:</span>
                    ' . $dt->kota_lahir . '
                </li>
                <li>
                    <span>Tanggal Lahir:</span>
                    ' . $dt->tgl_lahir . '
                </li>
                <li>
                    <span>Alamat :</span>
                    ' . strtoupper($dt->alamat) . '
                </li>
                <li>
                    <span>Kelurahan :</span>
                    ' . $dt->kelurahan . '
                </li>
                <li>
                    <span>Kecamatan :</span>
                    ' . $dt->kecamatan . '
                </li>
                <li>
                    <span>Kota :</span>
                    ' . $dt->kota . '
                </li>
            </ul>
            </div>
        </div>
    </div>
    
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
    <div class="card-box height-100-p overflow-hidden">
        <div class="profile-tab height-100-p">
            <div class="tab height-100-p">
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 ">
                            <div class="card">
                                <div class="card-body">
                                <h6>Data Sekolah</h6>
                                    <div class="profile-info">
                                        <ul>
                                        <li>
                                            <span>TK:</span>
                                            ' . $dt->tk . '
                                            <div>' . ' (' . $dt->thtk . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>SD:</span>
                                            ' . $dt->sd . '
                                            <div>' . ' (' . $dt->thsd . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>SMP:</span>
                                            ' . $dt->smp . '
                                            <div>' . ' (' . $dt->thsmp . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>SMA:</span>
                                            ' . $dt->sma . '
                                            <div>' . ' (' . $dt->thsma . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>S1:</span>
                                            ' . $dt->sarjana . '
                                            <div>' . ' (' . $dt->ths1 . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>S2:</span>
                                            ' . $dt->pascasarjana . '
                                            <div>' . ' (' . $dt->ths2 . ')' . '</div>
                                        </li>
                                        <li>
                                            <span>S3:</span>
                                            ' . $dt->doktoral . '
                                            <div>' . ' (' . $dt->ths3 . ')' . '</div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                <h6>Menjadi Karyawan Sejak</h6>
                                    <div class="profile-info">
                                        <ul>
                                        <li>
                                            <span>Tgl.Aktif :</span>
                                            ' . date("d-m-Y", strtotime($dt->tgl_aktif)) . '
                                        </li>
                                        <li>
                                            <span>Jabatan :</span>
                                            ' . $dt->jabatan . '
                                        </li>
                                        <li>
                                            <span>Email:</span>
                                            ' . $dt->email . '
                                        </li>
                                        <li>
                                            <span>No. Telepon :</span>
                                            ' . $dt->nomor_hp . '
                                        </li>
                                        <li><hr></li>
                                        <li>
                                            <span>Status Karyawan :</span>
                                            ' . $dt->set_active . '
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6 col-sm-12 ">
                        <div class="card">
                        <div class="card-body">
                        <h6>Hafalan Al-quran (Saat Daftar)</h6>
                            <div class="profile-info">
                                <ul>
                                <li>
                                    <span> Jumlah Hafalan :</span>
                                    ' . $dt->hafal . ' Juz
                                </li> 
                                    <li>
                                        <span> Sanad Al-Qur' . "'" . 'an :</span>
                                        ' . $dt->sanad . '
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        <div class="card">
                        <div class="card-body">
                            <div class="profile-info">
                                <ul> ' . $rkomp . '
                                </ul>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></div>';
        } else {
            $data = '
            <div class="col-12">
                <div class="mb-30 align-item-center" >
						<div class="d-block" style="background-image: url(' . "'" . base_url("assets/images/noresult.webp") . "')" . '; background-color: #cccccc; /* Used if the image is unavailable */
                        min-height: 400px;
                        max-width: 300px;
                        margin-left: auto;
                        margin-right: auto;
                        background-position: center; 
                        background-repeat: no-repeat;
                        background-size: cover; " >
						</div>
                </div>
                </div>
                ';
        }
        return  $data;
    }

    function karyawan($params)
    {

        $cabang = $this->session->userdata("fid_cabang");
        if ($cabang > 0) {
            $Getdata = $this->m_lembaga->GetAllDataLembagaById($cabang);
        } else {
            $Getdata = $this->m_lembaga->GetAllDataLembaga();
        }
        if ($Getdata->num_rows() > 0) {
            $data = $Getdata->result();
        }

        $id = $this->secure->decrypt_url($params);
        $kota = $this->db->get("master_wilayah_kota")->result();
        $kecamatan = $this->db->get("master_wilayah_kecamatan")->result();
        $kelurahan = $this->db->get("master_wilayah_kelurahan")->result();
        $kompetensi = $this->db->query("SELECT * FROM `data_karyawan_kompetensi` WHERE `karyawan_id`='$id'")->result();
        // echo json_encode(['dt1' => $Asatid,  'dt2' => $data, 'kota' => $kota, 'kec' => $kecamatan, 'kel' => $kelurahan, 'kompetensi' => $kompetensi], true);
        $cabang = '<option value=""> -Pilih -</option>';

        foreach ($data  as $dc) {
            $cabang .= '<option value="' . $dc->id . '"> ' . $dc->nama_cabang . '</option>';
        }
        $data['TitelPage'] = 'Data Profile';
        $data['data_plug'] = 'null';
        $data['action'] = 'profile_v3.2';
        $data['cabang'] = $cabang;
        $data['kota'] = $kota;
        $data['kec'] =  $kecamatan;
        $data['kel'] =  $kelurahan;
        $data['kompetensi'] =  $kompetensi;
        $data['idus'] = $id;
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('profile_guru');
        $this->load->view('template/footer');
    }

    function santri($params)
    {
        $cabang = $this->session->userdata("fid_cabang");
        if ($cabang > 0) {
            $Getdata = $this->m_lembaga->GetAllDataLembagaById($cabang);
        } else {
            $Getdata = $this->m_lembaga->GetAllDataLembaga();
        }
        if ($Getdata->num_rows() > 0) {
            $data = $Getdata->result();
        }
        $cabang = '<option value=""> -Pilih -</option>';

        foreach ($data  as $dc) {
            $cabang .= '<option value="' . $dc->id . '"> ' . $dc->nama_cabang . '</option>';
        }
        $id = $this->secure->decrypt_url($params);
        $kota = $this->db->get("master_wilayah_kota")->result();
        $kecamatan = $this->db->get("master_wilayah_kecamatan")->result();
        $kelurahan = $this->db->get("master_wilayah_kelurahan")->result();

        $data['TitelPage'] = 'Data Profile';
        $data['data_plug'] = 'null';
        $data['action'] = 'profile_v3.2';
        $data['cabang'] = $cabang;
        $data['kota'] = $kota;
        $data['kec'] =  $kecamatan;
        $data['kel'] =  $kelurahan;
        $data['idus'] = $id;
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('profile_santri');
        $this->load->view('template/footer');
    }
}

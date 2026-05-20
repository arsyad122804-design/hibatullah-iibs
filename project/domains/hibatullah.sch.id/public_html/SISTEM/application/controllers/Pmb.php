<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pmb extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library(['form_validation', 'session', 'secure', 'upload']);
    $this->load->helper(['url', 'language', 'auth_helper']);
    is_auth_chek();
    $this->load->model(['m_periodik', 'm_lembaga', 'pmb/m_pendaftar', 'pmb/m_pendaftar_valid']);
  }
  public function index($token = null)
  {
    // $this->load->view('pmb');
  }

  function rekap($cb_set = null, $pr_set = null)
  {
    $lvid = $this->session->userdata('idlevel');
    $cb = $this->session->userdata('fid_cabang');
    // AND cabang_id='$cb'
    if ($lvid == 1) {
      $dt1 = date("Y");
      $dt2 = $dt1 + 1;
      $dateset = $dt1 . '-' . $dt2;
      $ppdb_daftar = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' ")->row_object();
      $ppdb_valid = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' AND (status_pelajar=5 OR status_pelajar=6);")->row_object();
      $ppdb_migrasi = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset'  AND status_pelajar=6;")->row_object();

      $data['pendaftar'] = $ppdb_daftar;
      $data['valid'] = $ppdb_valid;
      $data['migrasi'] = $ppdb_migrasi;

      $data['TitelPage'] = 'Rekap PPDB';
      $data['data_plug'] = '';
      $data['action'] = '';
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/rekap_pmb');
      $this->load->view('template/footer');
    } else {
      redirect(base_url());
    }
  }
  function tahun_pmb()
  {
    $data['TitelPage'] = 'Master Periode PPDB';
    $data['data_plug'] = 'datatable';
    $data['action'] = 'pmb/pmb_v1.1';
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/tahun_pmb');
    $this->load->view('template/footer');
  }
  function pembayaran_seleksi()
  {
    $data['TitelPage'] = 'Master Pembayaran Seleksi';
    $data['data_plug'] = 'datatable';
    $data['action'] = 'pmb/pembayaran_seleksi_v2';
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/pembayaran_seleksi');
    $this->load->view('template/footer');
  }
  function pendaftar()
  {
    $data['TitelPage'] = 'Data Pendaftar PPDB';
    $data['data_plug'] = 'datatable';
    $data['action'] = 'pmb/pendaftar_v1';
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/pendaftar');
    $this->load->view('template/footer');
  }

  function seleksi()
  {
    $data['TitelPage'] = 'Data Tes Seleksi';
    $data['data_plug'] = 'datatable';
    $data['action'] = 'pmb/tes_seleksi';
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/tes_seleksi');
    $this->load->view('template/footer');
  }

  function pendaftar_valid()
  {
    $data['TitelPage'] = 'Data Valid PPDB';
    $data['data_plug'] = 'datatable';
    $data['action'] = 'pmb/pendaftar_valid_v3.4';
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/pendaftar_valid');
    $this->load->view('template/footer');
  }
  function datadiri($params = null)
  {
    if ($params != null) {
      $data['TitelPage'] = 'Data Diri Peserta';
      $data['data_plug'] = '';
      $data['token'] = $params;
      $data['action'] = '';
      $data['data'] = $this->get_data_pelajar($params);
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/datadiri');
      $this->load->view('template/footer');
    }
  }
  function cardprofile($params = null)
  {
    if ($params != null) {

      $id = $this->secure->decrypt_url($params);
      $data['TitelPage'] = 'Data Diri Peserta';
      $data['data_plug'] = '';
      $data['token'] = $params;
      $data['action'] = '';
      $data['data'] = $this->m_pendaftar->GetDataPelajarByNis($id)->row_object();
      $this->load->view('template/head', $data);
      // $this->load->view('template/loader');
      // $this->load->view('template/header');
      // $this->load->view('template/right_bar');
      // $this->load->view('template/left_bar');
      $this->load->view('pmb/card');
      $this->load->view('template/footer');
    }
  }
  function getdata($params = null)
  {
    if ($params != null) {
      $id = $this->secure->decrypt_url($params);
      $get_data = $this->m_pendaftar->get_dataPendaftarByID($id, 2)->row_object();
      $get_detail = $this->db->query("SELECT * FROM `master_pmb_reg` WHERE `nomor_reg`='$id' ORDER BY jns ASC")->result();

      $data['TitelPage'] = $get_data->nama_lengkap;
      $data['data'] = $get_data;
      $data['detail'] = $get_detail;
      $data['data_plug'] = '';
      $data['action'] = '';
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/pendaftar_list');
      $this->load->view('template/footer');
    } else {
      redirect(base_url("pmb/pendaftar/"));
    }
  }
  function getdata_valid($params = null)
  {
    if ($params != null) {
      $id = $this->secure->decrypt_url($params);
      $get_data = $this->m_pendaftar_valid->get_dataPendaftarByID($id)->row_object();
      $get_detail = $this->db->query("SELECT * FROM `master_pmb_reg` WHERE `nomor_reg`='$id' ORDER BY jns ASC")->result();

      $data['TitelPage'] = $get_data->nama_lengkap;
      $data['data'] = $get_data;
      $data['detail'] = $get_detail;
      $data['data_plug'] = '';
      $data['action'] = '';
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/pendaftar_valid_list');
      $this->load->view('template/footer');
    } else {
      redirect(base_url("pmb/pendaftar/"));
    }
  }

  function datadiri_valid($params = null)
  {
    if ($params != null) {
      $data['TitelPage'] = 'Data Diri Peserta';
      $data['data_plug'] = '';
      $data['token'] = $params;
      $data['action'] = '';
      $data['data'] = $this->get_data_pelajar($params);
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/datadiri_valid');
      $this->load->view('template/footer');
    }
  }

  function pembayaran($params = null)
  {
    if ($params != null) {
      $id = $this->secure->decrypt_url($params);
      $get_data = $this->m_pendaftar->get_dataPendaftarByID($id, 2)->row_object();
      $get_detail = $this->db->query("SELECT * FROM `master_pmb_pembayaran_seleksi` WHERE `tahun_id`='$get_data->id_tahun' and hapus=0 ORDER BY id_pembayaran_seleksi ASC")->result();

      $data['TitelPage'] = $get_data->nama_lengkap;
      $data['data'] = $get_data;
      $data['detail'] = $get_detail;
      $data['detail2'] = $get_detail;
      // $data['data_plug'] = 'datatable';
      // $data['action'] = 'pmb/pembayaran_v1';
      $this->load->view('template/head', $data);
      $this->load->view('template/loader');
      $this->load->view('template/header');
      $this->load->view('template/right_bar');
      $this->load->view('template/left_bar');
      $this->load->view('pmb/pembayaran_list');
      $this->load->view('template/footer');
    } else {
      redirect(base_url());
    }
  }

  function uploads_img()
  {
    $config['upload_path'] = './databerkas/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);
    if (!empty($_FILES['file']['name'])) {
      if ($this->upload->do_upload('file')) {
        $gbr = $this->upload->data();
        $config['image_library'] = 'gd2';
        $config['source_image'] = './databerkas/' . $gbr['file_name'];
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = false;
        $config['quality'] = 50;
        $config['new_image'] = './databerkas/' . $gbr['file_name'];
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

  function formulir($params = null)
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
    $getperiode = $this->db->where("active=1")->get("master_pmb_tahun_akademik")->result();
    $kota = $this->db->get("master_wilayah_kota")->result();
    $kecamatan = $this->db->get("master_wilayah_kecamatan")->result();
    $kelurahan = $this->db->get("master_wilayah_kelurahan")->result();

    $data['TitelPage'] = 'Data Profile';
    // $data['data_plug'] = 'datatable';
    // $data['action'] = 'profile';
    $data['cabang'] = $cabang;
    $data['periode'] = $getperiode;
    $data['kota'] = $kota;
    $data['kec'] =  $kecamatan;
    $data['kel'] =  $kelurahan;
    if ($params != null) {
      $id = $this->secure->decrypt_url($params);
      $data['idus'] = $id;
      $data['token'] = $params;
    }
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    if ($params != null) {
      $this->load->view('pmb/profile_pmb');
    } else {
      $this->load->view('pmb/formulir');
    }
    $this->load->view('template/footer');
  }

  function berkas($params)
  {
    $id = $this->secure->decrypt_url($params);
    $data['TitelPage'] = 'Upload Berkas';
    $data['idus'] = $id;
    $data['token'] = $params;
    $this->load->view('template/head', $data);
    $this->load->view('template/loader');
    $this->load->view('template/header');
    $this->load->view('template/right_bar');
    $this->load->view('template/left_bar');
    $this->load->view('pmb/upload_berkas');
    $this->load->view('template/footer');
  }

  function get_data_pelajar($params)
  {
    $id = $this->secure->decrypt_url($params);
    $dt = $this->m_pendaftar->GetDataPelajarByNis($id)->row_object();
    $gender = '-';
    if ($dt->jns_kelamin == 1) {
      $gender = 'Laki-Laki';
    } elseif ($dt->jns_kelamin == 2) {
      $gender = 'Perempuan';
    }
    $akte = '<span  class="btn btn-sm btn-secondary btn-block" > Data tidak ditemukan </span>';
    $kk = '<span  class="btn btn-sm btn-secondary btn-block" > Data tidak ditemukan </span>';
    $rapot = '<span  class="btn btn-sm btn-secondary btn-block" > Data tidak ditemukan </span>';
    if (file_exists(FCPATH . "./berkas/" . $dt->akte)) {
      if ($dt->akte != '') {
        $akte = '<a href="/berkas/' . ($dt->akte) . '" target="_blank" class="btn btn-sm btn-info btn-block"> Akte Kelahiran </a>';
      }
    }
    if (file_exists(FCPATH . "./berkas/" . $dt->kk)) {
      if ($dt->kk != '') {
        $kk = '<a href="/berkas/' . ($dt->kk) . '" target="_blank" class="btn btn-sm btn-info btn-block"> Kartu Keluarga </a>';
      }
    }
    if (file_exists(FCPATH . "./berkas/" . $dt->rapot)) {
      if ($dt->rapot != '') {
        $rapot = '<a href="/berkas/' . ($dt->rapot) . '" target="_blank" class="btn btn-sm btn-info btn-block" > Nilai Raport </a>';
      }
    }
    $data = '
    <div class="col-md-12 text-right">
        <a href="' . base_url('pmb/berkas/' . $this->secure->encrypt_url($dt->id_pelajar)) . '" class="badge badge-primary" data-option="Edit"><i class="dw dw-upload2"></i> Upload Berkas</a>
        <a href="' . base_url('pmb/formulir/' . $this->secure->encrypt_url($dt->id_pelajar)) . '" class="badge badge-primary" data-option="Edit"><i class="dw dw-edit2"></i> Edit Data</a>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
            <div class="pd-20 card-box height-100-p" style="text-align: center">
                <div class="row">
                    <div style="
        width: 80px;
        height: 90px;
        object-fit: cover;
        object-position: 20% 10%;
        border-radius: 10px;
        overflow: hidden;
        margin: 5px auto;
    ">
                        <img src="' . base_url('berkas/') . $dt->gambar . '" style="width: 80px" />
                    </div>
                </div>
                <h5 class="text-center h5 mb-0">' . $dt->nama_lengkap . '</h5>
                <div class="profile-info">
                    <ul>
                        <li>
                            <span>Jenjang:</span>
                            ' . $dt->nama_cabang . '
                        </li>
                        <li>
                            <span>Tanggal Pendaftaran:</span>
                            ' . date("d-m-Y", strtotime($dt->tgl_pendaftaran)) . '
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-sm-12 mb-3">
            <div class="card-box height-100-p overflow-hidden">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <table style="width: 100%; text-align: left">
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px;
          width: 130px;
          vertical-align:top;
        ">
                                            <b>Nama Lengkap</b>
                                        </td>
                                        <td style="width: 6px; vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . strtoupper($dt->nama_lengkap) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px;
          width: 130px; vertical-align:top;
        ">
                                            <b>Jenis Kelamin</b>
                                        </td>
                                        <td style="width: 6px; vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . strtoupper($gender) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px;
          width: 130px; vertical-align:top;
        ">
                                            <b>Tempat Lahir</b>
                                        </td>
                                        <td style="width: 6px; vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . strtoupper($dt->kota_lahir) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px;
          width: 130px; vertical-align:top;
        ">
                                            <b>Tanggal Lahir</b>
                                        </td>
                                        <td style="width: 6px; vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . date("d-m-Y", strtotime($dt->tgl_lahir)) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px; vertical-align:top;
        ">
                                            <b>Alamat Domisili</b>
                                        </td>
                                        <td style=" vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . $dt->alamat . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px; vertical-align:top;
        ">
                                            <b>Nama Ayah/Ibu</b>
                                        </td>
                                        <td style=" vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . $dt->wali_peserta . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px; vertical-align:top;
        ">
                                            <b>No. Telepon</b>
                                        </td>
                                        <td style=" vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . $dt->phone . '</td>
                                    </tr>
                                    <tr>
                                        <td style="
          font-weight: 900;
          font-size: 11pt;
          margin-bottom: 6px; vertical-align:top;
        ">
                                            <b>Email</b>
                                        </td>
                                        <td style=" vertical-align:top;">:</td>
                                        <td style=" vertical-align:top;">' . $dt->email . '</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <table class="w-100">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Akte Kelahiran</th>
                                            <th>Kartu Keluarga</th>
                                            <th>Nilai Raport </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>
                                            ' . $akte . '
                                        </td>
                                        <td>
                                            ' . $kk . '
                                        </td>
                                        <td>
                                            ' . $rapot . '
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <ul>
                                    <li>
                                        <span>Status Pendaftaran:</span>
                                        <div style="font-size:18pt; font-weight:bold">' . ($dt->status) . '</div>
                                    </li>
                                </ul>
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

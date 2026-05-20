<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['encryption', 'secure', 'user_agent']);
        $this->load->library('session');
        $this->load->model('m_dashboard');
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    function index()
    {
        $id = $this->session->userdata('id_user');
        $lvid = $this->session->userdata('idlevel');
        $cb = $this->session->userdata('fid_cabang');
        $ids = $this->session->userdata("fid_keterangan");

        $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object();
        $dateset = $periodesctiv->tahun_akademik;

        $ppdb_daftar = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' AND aff_id='$id' ")->row_object();
        $ppdb_valid = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset'  AND aff_id='$id' AND (status_pelajar>=3 AND status_pelajar<7);")->row_object();
        $ppdb_migrasi = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset'  AND aff_id='$id'  AND (status_pelajar>=5 AND status_pelajar<7)")->row_object();
        if ($lvid == 1) {
            $ppdb_daftar = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' ")->row_object();
            $ppdb_valid = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' AND (status_pelajar>=3 AND status_pelajar<7);")->row_object();
            $ppdb_migrasi = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset'  AND (status_pelajar>=5 AND status_pelajar<7)")->row_object();
        }
        $p_daftar = $ppdb_daftar->jumlah;
        $p_valid =  $ppdb_valid->jumlah;
        $p_migrasi =  $ppdb_migrasi->jumlah;

        $urlinfaq = "capaian/ziyadah";
        $urltarget = "#";
        $urlevaluasi = "#";
        $urlevaluasiMRJ = "#";
        $Hafalan = "#";
        // if ($lvid >= 30 && $lvid < 100) {
        //     // $urlinfaq = base_url('infaq/datainfaq');
        //     $urltarget = base_url("target/ziyadah");
        //     $urlevaluasi = base_url("evaluasi/ziyadah");
        //     $urlevaluasiMRJ = base_url("evaluasi/murojaah");
        //     $Hafalan = base_url("hafalan");
        // }
        // $urlinfaq = base_url('infaq/datainfaq');
        $urldtsantri = base_url('data/santri');
        // }

        $santri = 0;
        // $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =1  ")->row_object();
        $alumni = 0;
        // $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =2  ")->row_object();
        $asatidz = 0;
        // $this->db->query("SELECT COUNT(*) as guru from data_karyawan ")->row_object();
        $cabangs = 0;
        // $this->db->query("SELECT COUNT(*) as cabang from data_kantor_cabang ")->row_object();
        // if ($cb > 0) {
        //     $santri = $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =1 and cabang_id='$cb' ")->row_object();
        //     $alumni = $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =2 and cabang_id='$cb' ")->row_object();
        //     $asatidz = $this->db->query("SELECT COUNT(*) as guru from data_karyawan where  cabang_id='$cb'  ")->row_object();
        //     $cabangs = $this->db->query("SELECT COUNT(*) as cabang from data_kantor_cabang where id='$cb' ")->row_object();
        // } else {
        //     $santri = $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =1  ")->row_object();
        //     $alumni = $this->db->query("SELECT COUNT(*) as santri from data_pelajar where status_pelajar =2  ")->row_object();
        //     $asatidz = $this->db->query("SELECT COUNT(*) as guru from data_karyawan ")->row_object();
        //     $cabangs = $this->db->query("SELECT COUNT(*) as cabang from data_kantor_cabang ")->row_object();
        // }
        $data['pendaftar'] = $p_daftar;
        $data['valid'] = $p_valid;
        $data['migrasi'] = $p_migrasi;

        $data['urlinfaq'] = $urlinfaq;
        $data['urldtsantri'] = $urldtsantri;
        $data['urltarget'] = $urltarget;
        $data['urlevaluasi'] = $urlevaluasi;
        $data['urlevaluasiMRJ'] = $urlevaluasiMRJ;
        $data['Hafalan'] = $Hafalan;
        $data['tokenset'] = $this->db->query("SELECT * FROM `sys_user` WHERE `id_user`='$id' AND aktif='Y'")->row_object();
        $data['aktif'] = $santri;
        $data['alumni'] = $alumni;
        $data['guru'] = $asatidz;
        $data['cabang'] = $cabangs;
        $data['periode'] = $dateset;
        $data['mdata'] = $this->db->get_where("data_kantor_cabang", ['id' => $cb])->row_object();
        $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $data['TitelPage'] = 'Dashboard';
        $data['test'] = $this->encryption->decrypt($this->session->userdata("cc_token"));
        $data['data_plug'] = 'datatable';
        $data['action'] = 'home_v3.3';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('home');
        $this->load->view('template/footer');
    }

    function get_data_ta($ta_set = null)
    {
        $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object();
        $dateset = $periodesctiv->tahun_akademik;
        if ($ta_set != null) {
            if ($ta_set != 'null') {
                if ($ta_set != 'undefined') {
                    $dateset = $ta_set;
                }
            }
        }

        $ppdb_daftar = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' ")->row_object();
        $ppdb_valid = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset' AND (status_pelajar>=3 AND status_pelajar<7);")->row_object();
        $ppdb_migrasi = $this->db->query("SELECT COUNT(*) as jumlah FROM `master_pmb_register_pelajar` WHERE `periode`='$dateset'  AND (status_pelajar>=5 AND status_pelajar<7)")->row_object();

        $p_daftar = $ppdb_daftar->jumlah;
        $p_valid =  $ppdb_valid->jumlah;
        $p_migrasi =  $ppdb_migrasi->jumlah;
        $data['pendaftar'] = $p_daftar;
        $data['valid'] = $p_valid;
        $data['migrasi'] = $p_migrasi;
        $data['periode'] = $dateset;

        echo json_encode($data);
    }
}

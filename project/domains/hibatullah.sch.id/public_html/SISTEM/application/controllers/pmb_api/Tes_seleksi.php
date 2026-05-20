<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Tes_seleksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'secure', 'encryption']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
        $this->lang->load('auth');
        $this->load->model(['m_periodik', 'm_lembaga', 'pmb/m_pendaftar', 'm_mail']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function get_data($cb_set = null, $pr_set = null)
    {
        $data = [];
        if ($cb_set != null) {
            if ($cb_set != 'null') {
                $data = $this->m_pendaftar->get_dataPendaftarByCabang($cb_set)->result();
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        $data = $this->m_pendaftar->get_dataPendaftarByCBPeriode($cb_set, $pr_set)->result();
                    }
                }
            } else {
                if ($pr_set != null) {
                    if ($pr_set != 'null') {
                        $data = $this->m_pendaftar->get_dataPendaftarByPeriode($pr_set)->result();
                    }
                }
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $jnk = "-";
            if ($row->jns_kelamin == 1) {
                $jnk = "L";
            } elseif ($row->jns_kelamin == 2) {
                $jnk = "P";
            }
            if ($this->session->userdata("idlevel") <= 2) {
                $BTN_A = '  <a href="' . base_url('pmb/getdata/') . $this->secure->encrypt_url($row->nomor_registrasi) . '"  class="badge badge-sm rounded-circle badge-success" title="List Data"><i class="dw dw-file"></i></a>';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-file"></i></span>';
            }
            $res_data[] = [
                $row->nama_cabang,
                $no++,
                '<div>' . $row->nama_lengkap . '</div><div class="badge badge-primary">' . $row->nomor_registrasi . '</div>',
                $jnk,
                $row->tahun_akademik,
                $row->phone,
                $row->email,
                $row->status,
                $BTN_A,
                $row->status_pelajar
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }
    function get_master()
    {
        $dtcabang = $this->db->get("data_kantor_cabang")->result();
        $dtperiode = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY id_tahun DESC")->result();
        $dtpelajar = $this->db->query("SELECT * FROM `master_pmb_register_pelajar` WHERE status_pelajar=4 ORDER BY `nama_lengkap` ASC;");
    }
}

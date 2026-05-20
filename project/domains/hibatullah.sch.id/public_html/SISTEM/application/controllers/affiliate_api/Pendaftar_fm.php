<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pendaftar_fm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['affiliate/m_pendaftar_fm', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get_data($ta_set = null, $aff_set = null)
    {
        $ids = $this->session->userdata('id_user');

        $lvl = $this->session->userdata('idlevel');
        // if ($lvl == 1) {
        //     $data =  $this->m_pendaftar_fm->GetAllDataUser()->result();
        // } else {
        //     $data =  $this->m_pendaftar_fm->GetAllDataUserID($ids)->result();
        // }

        $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object();
        $ta = $periodesctiv->id_tahun;
        if ($ta_set != null) {
            if ($ta_set != 'null') {
                if ($ta_set != 'undefined') {
                    $ta = $ta_set;
                }
            }
        }
        if ($lvl == 1) {
            $data =  $this->m_pendaftar_fm->GetAllDataUserByTa($ta)->result();
        } else {
            $data =  $this->m_pendaftar_fm->GetAllDataUserIDBy($ids, $ta)->result();
        }

        if ($aff_set != null) {
            if ($aff_set != 'null') {
                if ($aff_set != 'all') {
                    if ($aff_set != 'undefined') {
                        $data =   $this->m_pendaftar_fm->GetAllDataUserIDBy($aff_set, $ta)->result();
                    }
                }
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $gender = "-";
            if ($row->jns_kelamin == 1) {
                $gender = "L";
            }
            if ($row->jns_kelamin == 2) {
                $gender = "P";
            }
            if ($row->id_status == 3) {
                $status = '<div class="badge badge-info">' . $row->status . '</div>';
            } elseif ($row->id_status == 5) {
                $status = '<div class="badge badge-success">' . $row->status . '</div>';
            } else {
                $status = $row->status;
            }
            $res_data[] = [
                $no++,
                $row->nama_lengkap,
                $gender,
                $row->phone,
                $row->periode,
                $row->nama_asli,
                $status,
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }
}

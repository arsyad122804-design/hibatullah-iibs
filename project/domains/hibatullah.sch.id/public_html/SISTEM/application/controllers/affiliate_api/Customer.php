<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['affiliate/m_customer', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get_data($ids_set = null)
    {
        $ids = $this->session->userdata('id_user');
        $lvl = $this->session->userdata('idlevel');
        if ($ids_set != null) {
            if ($ids_set != 'null') {
                if ($ids_set != 'undefined') {
                    $ids = $ids_set;
                }
            }
        }
        if ($lvl == 1) {
            $data =  $this->m_customer->GetAllDataUser()->result();
        } else {
            $data =  $this->m_customer->GetAllDataUserID($ids)->result();
        }
        if ($ids_set != null) {
            if ($ids_set != 'null') {
                if ($ids_set != 'undefined') {
                    $data =  $this->m_customer->GetAllDataUserID($ids)->result();
                }
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $daftar = '-';
            $check = $this->db->query("SELECT COUNT(*)as jml FROM master_pmb_register_pelajar WHERE phone='$row->hp'")->row_object();
            if ($check->jml > 0) {
                $daftar = $check->jml . "x Daftar";
            }
            $res_data[] = [
                $no++,
                $row->nama,
                $row->alamat,
                $row->hp,
                $row->nama_asli,
                $daftar,
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }
}

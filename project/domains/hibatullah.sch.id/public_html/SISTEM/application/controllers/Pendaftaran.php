<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->model('m_pendaftaran');
    }
    function index()
    {
        $cab = $this->session->userdata("fid_cabang");
        $data['mahasiswa'] = $this->m_pendaftaran->GetAllPmb($cab)->result();
        $this->load->view('admin_template/header', $data);
        $this->load->view('admin_template/sidebar');
        $this->load->view('admin_template/main');
        $this->load->view('pendaftaran/data-pendaftaran');
        $this->load->view('admin_template/footer');
        $this->load->view('admin_template/plugin');
    }
}

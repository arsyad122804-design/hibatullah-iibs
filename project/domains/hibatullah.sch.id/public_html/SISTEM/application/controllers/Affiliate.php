<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Affiliate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['m_slider', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        $this->load->library('upload');
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function user()
    {
        $data['TitelPage'] = 'Data User';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'affiliate/user';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('affiliate/user');
        $this->load->view('template/footer');
    }
    function pendaftar()
    {
        $data['TitelPage'] = 'Data Pendaftar';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'affiliate/pendaftar1';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('affiliate/pendaftar');
        $this->load->view('template/footer');
    }
    function pendaftar_fm()
    {
        $data['TitelPage'] = 'Data Pendaftar Lunas Formulir';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'affiliate/pendaftar_fm1';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('affiliate/pendaftar_fm');
        $this->load->view('template/footer');
    }
    function customer()
    {
        $data['TitelPage'] = 'Data Customer';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'affiliate/customer';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('affiliate/customer');
        $this->load->view('template/footer');
    }
    function withdraw()
    {
        $data['TitelPage'] = 'Data Pencairan Fee';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'affiliate/withdraw';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('affiliate/withdraw');
        $this->load->view('template/footer');
    }
}

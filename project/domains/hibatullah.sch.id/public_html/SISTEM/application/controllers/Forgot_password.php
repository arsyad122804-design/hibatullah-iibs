<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Forgot_password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure']);
        $this->load->helper(['url', 'language']);
        $this->load->model(['m_login',]);
        $this->lang->load('auth');
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function index()
    {
        $this->load->view("forgot_password");
    }
    function email_reset()
    {
        $username = $this->input->post('usn');
        $email = $this->input->post('eml');
        $cek = $this->db->get_where('sys_user', ['username' => $username, 'id_level!=1']);
        $data = [];
        if ($cek->num_rows() > 0) {
            $rs = $cek->row_object();
            $data = [
                'id' => $rs->id_user,
                'nama' => $rs->nama_asli,
                'username' => $username,
                'email' => $email
            ];
        };
        echo json_encode($data);
    }
    function reset($tokens)
    {
    }
}

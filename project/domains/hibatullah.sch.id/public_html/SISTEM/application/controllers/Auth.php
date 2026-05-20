<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure']);
        $this->load->helper(['url', 'language']);
        $this->load->model(['m_login',]);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function index()
    {
        if ($this->session->userdata('id_user') == null) {
            $data['message'] = ($this->session->flashdata('message')) ? $this->session->flashdata('message') : "LOGIN";
            $this->load->view('login', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }
    function chekingdata()
    {
        $usn = $this->input->post("usn");
        $pss = $this->input->post("pss");
        $this->db->select("a.*,b.level, (SELECT nama_cabang from data_kantor_cabang where id = a.fid_cabang) as nama_cabang");
        $this->db->join("sys_level b", "b.id_level=a.id_level");
        $checking = $this->db->get_where('sys_user a', ['a.username' => $usn]);
        if ($checking->num_rows() > 0) {
            $rs = $checking->row_object();
            if ($rs->aktif == "Y") {
                $password = $this->secure->decrypt_url($rs->password);
                if ($pss == $password) {
                    $rt = $checking->row_object();
                    $cc_token = $this->encryption->encrypt('##' . $this->get_client_ip() . '##' . $this->get_client_browser());
                    $data = [
                        'id_user' => $rt->id_user,
                        'fid_keterangan' => $rt->fid_keterangan,
                        'user' => $rt->username,
                        'nmuser' => $rt->nama_asli,
                        'idlevel' => $rt->id_level,
                        'nama_level' => $rt->level,
                        'fid_cabang' => $rt->fid_cabang,
                        'nama_cabang' => $rt->nama_cabang,
                        'pict' => $rt->icon,
                        'cc_token' => $cc_token,
                    ];
                    $this->session->set_userdata($data);
                    if ($rt->sess_id != $cc_token) {
                        $this->db->set(["sess_id" => $cc_token, 'last_login' => date('Y-m-d H:i:s')]);
                        $this->db->where('id_user', $rt->id_user);
                        $this->db->update('sys_user');
                    }
                    echo $this->output_json(['result' => true, 'url' => 'dashboard', 'status' => 'LOGIN SUCCESS']);
                } else {
                    echo $this->output_json(['result' => false,  'status' => 'Password salah!']);
                }
            } else {
                echo $this->output_json(['result' => false,  'status' => 'Akun Anda non-aktif!']);
            }
        } else {
            echo $this->output_json(['result' => false,  'status' => 'Username salah!']);
        }
    }
    function signout()
    {
        $data = [
            'id_user',
            'fid_keterangan',
            'user',
            'nmuser',
            'idlevel',
            'fid_cabang',
            'nama_cabang',
            'cc_token',
        ];
        $this->session->unset_userdata($data);
        $this->session->set_flashdata(['message' => "Logout Success..."]);
        redirect(base_url());
    }
    function logout()
    {
        $data = [
            'id_user',
            'fid_keterangan',
            'user',
            'nmuser',
            'idlevel',
            'fid_cabang',
            'nama_cabang',
            'cc_token',
        ];
        $this->session->unset_userdata($data);
        $this->session->set_flashdata(['message' => "Anda Sedang Logout..."]);
        redirect(base_url());
    }
    function relogin()
    {
        $data = [
            'id_user',
            'fid_keterangan',
            'user',
            'nmuser',
            'idlevel',
            'fid_cabang',
            'nama_cabang',
            'cc_token',
        ];
        $this->session->unset_userdata($data);
        $this->session->set_flashdata(['message' => "LOGIN"]);
        redirect(base_url());
    }
    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }
    function get_client_browser()
    {
        $browser = '';
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
            $browser = 'Netscape';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Firefox';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser = 'Chrome';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = 'Opera';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet Explorer';
        else
            $browser = $_SERVER['HTTP_USER_AGENT'];
        return $browser;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['affiliate/m_user_aff', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get_data($setcb = null)
    {
        $ids = $this->session->userdata('id_user');
        if ($setcb != null) {
            if ($setcb != 'null') {
                if ($setcb != '0') {
                    $cabang = $setcb;
                }
            }
        }
        $lvl = $this->session->userdata('idlevel');
        $a = 1;
        if ($lvl == 1) {
            $a = 2;
            $data =  $this->m_user_aff->GetAllDataUser()->result();
        } else {
            $a = 3;
            $data =  $this->m_user_aff->GetAllDataUserID($ids)->result();
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            if ($this->session->userdata("idlevel") == 5) {
                $BTN_A = '<button type="button" class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $row->id_user . '" data-lvl="' . $row->id_level . '"data-nm="' . $row->username . '" data-option="Edit"><i class="dw dw-edit2"></i></button>
                <button class="badge badge-sm rounded-circle btn-danger deleteUser" data-id="' . $row->id_user . '" data-nm="' . $row->username . '" ><i class="dw dw-delete-3"></i></button>
            ';
            } else {
                $BTN_A = '<button type="button" class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $row->id_user . '" data-lvl="' . $row->id_level . '"data-nm="' . $row->username . '" data-option="Edit"><i class="dw dw-edit2"></i></button>';
            }
            $res_data[] = [
                $no++,
                $row->nama_asli,
                $row->username,
                "*************",
                $row->tel_user,
                $row->email_user,
                '<div>
                    ' . $BTN_A . '
                </div>'
            ];
        }
        echo json_encode(['data' => $res_data, $ids], true);
    }
    function getdatausers()
    {
        $id = $this->input->post("id");
        $cb = $this->input->post("cb");
        $result = [];
        if ($id >= 30 && $id < 100) {
            $row = $this->db->get_where("data_pelajar", ['cabang_id' => $cb])->result();
            foreach ($row as $rp) {
                $result[] = [
                    'idk' => $rp->id_pelajar,
                    'nama' => strtoupper($rp->nama_lengkap)
                ];
            }
        }
        if ($id < 30 && $id > 1) {
            $row = $this->m_user_aff->GetDataKaryawan($cb)->result();
            foreach ($row as $rk) {
                $result[] = [
                    'idk' => $rk->id_karyawan,
                    'nama' => strtoupper($rk->nama_lengkap)
                ];
            }
        }
        echo json_encode(['result' => $result, $cb]);
    }

    function get_data_by()
    {
        $id =  $this->input->post("id");
        $lvl =  $this->input->post("lvl");
        $join = $this->db->query("SELECT * FROM sys_user a WHERE a.id_user = '$id'");

        $datalevel = [];
        if ($join->num_rows() > 0) {
            $rs = $join->row_object();
        } else {
            $rs = [];
        }
        echo $this->output_json(['dt' => $rs, 'level' => $datalevel]);
    }
    function chekinguser()
    {
        $usn = $this->input->post("usn");
        $data = $this->db->query("SELECT * FROM `sys_user` WHERE username='$usn'");
        if ($data->num_rows() > 0) {
            $rs = 200;
        } else {
            $rs = 500;
        }
        echo $this->output_json(['rs' => $rs]);
    }
    function chekingaff()
    {
        $kode = $this->input->post("kode");
        $id = $this->input->post("id");
        $whr = "";
        if ($id != 'new') {
            $whr = "AND id_user !='$id'";
        }
        $data = $this->db->query("SELECT * FROM `sys_user` WHERE aff_id='$kode' and id_level='22' $whr");
        if ($data->num_rows() > 0) {
            $rs = 200;
        } else {
            $rs = 500;
        }
        echo $this->output_json(['rs' => $rs]);
    }
    function new_user()
    {
        $idUser = $this->input->post("idUser");
        $Lembaga = 0;
        $Username = $this->input->post("Username");
        $Password1 = $this->input->post("Password1");
        $Password2 = $this->input->post("Password2");
        $Level = $this->input->post("Level");
        $Relation_id = 0;
        $Nama = $this->input->post("Nama");
        $Email = $this->input->post("Email");
        $Telepon = $this->input->post("Telepon");
        $aff_id = $this->input->post("AffCode");
        $Aktif = $this->input->post("Aktif");
        $SetPass = $this->secure->encrypt_url($Password2);
        if ($idUser == 'new') {
            $idu = $this->db->query("SELECT IFNULL(MAX(id_user),0)+1 as id FROM `sys_user`")->row_object();
            $result = [
                'id_user' => $idu->id,
                'username' => $Username,
                'password' => $SetPass,
                'id_level' => $Level,
                'sess_id' => $this->secure->encrypt_url(date("dmy") . '-' . $this->session->userdata("id_user")),
                'last_login' => '',
                'last_logout' => '',
                'fid_keterangan' => $Relation_id,
                'nama_asli' => $Nama,
                'email' => $Email,
                'tel_user' => $Telepon,
                'block_count' => 0,
                'block_exp' => '',
                'reset_token' => '',
                'reset_exp' => '',
                'konfirm' => 'Y',
                'aff_id' => $aff_id,
                'aktif' => $Aktif,
                'fid_cabang' => $Lembaga,
                'created_by' => $this->session->userdata("id_user"),
            ];
            $simpan = $this->m_user_aff->SaveData($result);
            if ($simpan) {
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => ' Success!',
                    'description' => 'Simpan Data User <b> ' . $Nama . '</b> Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            } else {
                $info = [
                    'icon' => 'frown-o',
                    'title' => 'Ooppss!',
                    'description' => 'Simpan Data User  <b> ' . $Nama . '</b>  Gagal!',
                    'color' => '#df0000',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            }
            echo $this->output_json(['result' => true, 'event' => $info]);
        } else {
            $chekuse = $this->db->get_where('sys_user', ['id_user' => $idUser])->row_object();
            if ($Password2 == $chekuse->password) {
                $result = [
                    'username' => $Username,
                    'id_level' => $Level,
                    'sess_id' => $this->encryption->encrypt(date("dmy") . '-' . $this->session->userdata("id_user")),
                    'last_login' => '',
                    'last_logout' => '',
                    'fid_keterangan' => $Relation_id,
                    'nama_asli' => $Nama,
                    'email' => $Email,
                    'tel_user' => $Telepon,
                    'block_count' => 0,
                    'block_exp' => '',
                    'reset_token' => '',
                    'reset_exp' => '',
                    'konfirm' => 'Y',
                    'aff_id' => $aff_id,
                    'aktif' => $Aktif,
                    'fid_cabang' => $Lembaga,
                    'created_by' => $this->session->userdata("id_user"),
                ];
            } else {
                $SetPass = $this->secure->encrypt_url($Password2);
                $result = [
                    'username' => $Username,
                    'password' => $SetPass,
                    'id_level' => $Level,
                    'sess_id' => $this->secure->encrypt_url(date("dmy") . '-' . $this->session->userdata("id_user")),
                    'last_login' => '',
                    'last_logout' => '',
                    'fid_keterangan' => $Relation_id,
                    'nama_asli' => $Nama,
                    'email' => $Email,
                    'block_count' => 0,
                    'block_exp' => '',
                    'reset_token' => '',
                    'reset_exp' => '',
                    'konfirm' => 'Y',
                    'aff_id' => $aff_id,
                    'aktif' => $Aktif,
                    'fid_cabang' => $Lembaga,
                    'created_by' => $this->session->userdata("id_user"),
                ];
            }
            $this->db->set($result);
            $this->db->where("id_user", $idUser);
            $update = $this->db->update("sys_user");
            if ($update) {
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => ' Success!',
                    'description' => 'Simpan Data User <b> ' . $Nama . '</b> Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            } else {
                $info = [
                    'icon' => 'frown-o',
                    'title' => 'Ooppss!',
                    'description' => 'Simpan Data User  <b> ' . $Nama . '</b>  Gagal!',
                    'color' => '#df0000',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
            }
            echo $this->output_json(['result' => true, 'event' => $info, 'data' => $result]);
        }
    }
    function delete_data()
    {
        $id = $this->input->post("id");
        $nm = $this->input->post("nm");
        $delet  = $this->m_user_aff->DeletData($id);
        if ($delet) {
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Delete Success!',
                'description' => 'Hapus Data  <b> ' . $nm . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Hapus Data  <b> ' . $nm . '</b> Gagal',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
}

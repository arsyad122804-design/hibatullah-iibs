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
        $this->load->model(['m_user', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function index()
    {
        $data['TitelPage'] = 'Data User';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'user_v3.2';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('user');
        $this->load->view('template/footer');
    }
    function getdatauser($setcb = null)
    {
        $cabang = $this->session->userdata('fid_cabang');
        if ($setcb != null) {
            if ($setcb != 'null') {
                if ($setcb != '0') {
                    $cabang = $setcb;
                }
            }
        }
        $lvl = $this->session->userdata('idlevel');
        if ($cabang > 0) {
            $data =  $this->m_user->GetAllDataUserBy($cabang)->result();
        } else {
            $data =  $this->m_user->GetAllDataUserLAZ()->result();
            if ($lvl == 1) {
                $data =  $this->m_user->GetAllDataUser()->result();
            }
        }
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $cabangs = "PUSAT";
            if ($row->nama_cabang != null) {
                $cabangs = $row->nama_cabang;
            }
            if ($this->session->userdata("idlevel") <= 5) {
                $BTN_A = '<button type="button" class="dropdown-item openform" data-id="' . $row->id_user . '" data-lvl="' . $row->id_level . '"data-nm="' . $row->username . '" data-option="Edit"><i class="dw dw-edit2"></i> Edit</button>
                <button class="dropdown-item deleteUser" data-id="' . $row->id_user . '" data-nm="' . $row->username . '" ><i class="dw dw-delete-3"></i> Delete</button>
            ';
            } else {
                $BTN_A = '';
            }
            $res_data[] = [
                $no++,
                $cabangs,
                $row->nama_asli,
                $row->username,
                "*************",
                $row->level,
                '<div class="dropdown">
                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="dw dw-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    ' . $BTN_A . '
                    </div>
                </div>'
            ];
        }
        echo json_encode(['data' => $res_data], true);
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
            $row = $this->m_user->GetDataKaryawan($cb)->result();
            foreach ($row as $rk) {
                $result[] = [
                    'idk' => $rk->id_karyawan,
                    'nama' => strtoupper($rk->nama_lengkap)
                ];
            }
        }
        echo json_encode(['result' => $result, $cb]);
    }

    function GetMaster()
    {
        $cabang = $this->session->userdata("fid_cabang");
        if ($cabang > 0) {
            $Getdata = $this->m_lembaga->GetAllDataLembagaById($cabang);
        } else {
            $Getdata = $this->m_lembaga->GetAllDataLembaga();
        }
        if ($Getdata->num_rows() > 0) {
            $result = true;
            $data = $Getdata->result();
        } else {
            $result = false;
            $data = 0;
        }
        $level = $this->session->userdata("idlevel");
        $datalevel = [];
        if ($level == 1) {
            $this->db->where("id_level", 2);
            $this->db->or_where("id_level", 100);
            $this->db->or_where("id_level", 101);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 2) {
            $this->db->where("id_level !=", 1);
            $this->db->where("id_level !=", 2);
            $this->db->where("id_level !=", 100);
            $this->db->where("id_level !=", 101);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 3) {
            $this->db->where("id_level", 8);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->or_where("id_level", 10);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 4) {
            $this->db->where("id_level", 9);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 5) {
            $this->db->where("id_level", 10);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        }
        echo $this->output_json(['result' => $result, 'dt' => $data, 'level' => $datalevel, 'lvl' => $level]);
    }

    function getFormOpenUserbyid()
    {
        $id =  $this->input->post("id");
        $lvl =  $this->input->post("lvl");
        if ($lvl >= 30) {
            $join = $this->db->query("SELECT * ,(SELECT nama_lengkap FROM data_pelajar WHERE id_pelajar = fid_keterangan) as namauser 
            FROM sys_user a 
            INNER JOIN data_kantor_cabang b ON b.id = fid_cabang 
            INNER JOIN sys_level d ON d.id_level = a.id_level WHERE a.id_user='$id' ");
        } elseif ($lvl < 30) {
            $join = $this->db->query("SELECT * ,(SELECT nama_lengkap FROM data_karyawan WHERE id_karyawan = fid_keterangan) as namauser FROM sys_user a INNER JOIN data_kantor_cabang c ON c.id = a.fid_cabang INNER JOIN sys_level d ON d.id_level = a.id_level WHERE a.id_user = '$id'");
        }
        $level = $this->session->userdata("idlevel");
        $datalevel = [];
        if ($level == 1) {
            $this->db->where("id_level", 2);
            $this->db->or_where("id_level", 100);
            $this->db->or_where("id_level", 101);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 2) {
            $this->db->where("id_level !=", 1);
            $this->db->where("id_level !=", 2);
            $this->db->where("id_level !=", 100);
            $this->db->where("id_level !=", 101);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 3) {
            $this->db->where("id_level", 8);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->or_where("id_level", 10);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 4) {
            $this->db->where("id_level", 9);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        } elseif ($level == 5) {
            $this->db->where("id_level", 10);
            $this->db->or_where("id_level", 30);
            $this->db->or_where("id_level", 31);
            $this->db->where("active", 1);
            $this->db->order_by("id_level", "ASC");
            $datalevel = $this->db->get_where("sys_level")->result();
        }
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
    function newUser()
    {
        $idUser = $this->input->post("idUser");
        $Lembaga = $this->input->post("Lembaga");
        $Username = $this->input->post("Username");
        $Password1 = $this->input->post("Password1");
        $Password2 = $this->input->post("Password2");
        $Level = $this->input->post("Level");
        $Relation_id = $this->input->post("Relation_id");
        $Nama = $this->input->post("Nama");
        $Email = $this->input->post("Email");
        $Aktif = $this->input->post("Aktif");
        $SetPass = md5($Password2 . "!@#$%^&*()_+ >> b(^_^)v");
        if ($idUser == 'new') {
            $idu = $this->db->query("SELECT IFNULL(MAX(id_user),0)+1 as id FROM `sys_user`")->row_object();
            $result = [
                'id_user' => $idu->id,
                'username' => $Username,
                'password' => $SetPass,
                'id_level' => $Level,
                'sess_id' => $this->encryption->encrypt(date("dmy") . '-' . $this->session->userdata("id_user")),
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
                'aktif' => $Aktif,
                'fid_cabang' => $Lembaga,
                'created_by' => $this->session->userdata("id_user"),
            ];
            $simpan = $this->m_user->SaveData($result);
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
                    'block_count' => 0,
                    'block_exp' => '',
                    'reset_token' => '',
                    'reset_exp' => '',
                    'konfirm' => 'Y',
                    'aktif' => $Aktif,
                    'fid_cabang' => $Lembaga,
                    'created_by' => $this->session->userdata("id_user"),
                ];
            } else {
                $setPass =  md5($Password2 . "!@#$%^&*()_+ >> b(^_^)v");
                $result = [
                    'username' => $Username,
                    'password' => $setPass,
                    'id_level' => $Level,
                    'sess_id' => $this->encryption->encrypt(date("dmy") . '-' . $this->session->userdata("id_user")),
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
        $delet  = $this->m_user->DeletData($id);
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

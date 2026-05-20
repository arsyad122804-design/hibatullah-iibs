<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Lembaga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model('m_lembaga');
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function index()
    {
        $data['TitelPage'] = 'Data Lembaga';
        $data['data_plug'] = 'datatable';
        $data['action'] = 'lembaga_v3.2';
        $this->load->view('template/head', $data);
        $this->load->view('template/loader');
        $this->load->view('template/header');
        $this->load->view('template/right_bar');
        $this->load->view('template/left_bar');
        $this->load->view('lembaga');
        $this->load->view('template/footer');
    }
    function datalembaga()
    {
        $cabang = $this->session->userdata('fid_cabang');
        $level = $this->session->userdata('idlevel');
        if ($cabang > 0) {
            $dt_lembaga = $this->m_lembaga->GetAllDataLembagaById($cabang)->result();
        } else {
            $dt_lembaga = $this->m_lembaga->GetAllDataLembaga()->result();
        }
        $lembaga = [];
        $no = 1;
        foreach ($dt_lembaga as $dr) {
            $get_santri = $this->db->query("SELECT COUNT(*) as santri FROM data_pelajar where cabang_id='$dr->id' AND status_pelajar=1")->row_object();
            if ($level == 1) {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $dr->id . '" data-option="Edit"><i class="dw dw-edit2"></i></span>
                <span  class="badge badge-sm rounded-circle btn-danger deletedata" data-id="' . $dr->id . '" data-nm="' . $dr->nama_cabang . '"><i class="dw dw-delete-3"></i></span>
                ';
            } elseif ($level == 2) {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $dr->id . '" data-option="Edit"><i class="dw dw-edit2"></i></span>
                <span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-delete-3"></i></span>
                ';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-edit2"></i></span>
                <span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-delete-3"></i></span>
                ';
            }
            if ($dr->active == 1) {
                $active = 'Aktif';
            } else {
                $active = 'Pasif';
            }
            $lembaga[] = [
                $no++,
                $dr->nama_cabang,
                intval($get_santri->santri) . ' Orang',
                $dr->pengurus,
                $dr->alamat,
                $dr->telepon,
                $active,
                $BTN_A
            ];
        };
        echo json_encode(['data' => $lembaga], true);
    }
    function getdatalembaga()
    {
        $id = $this->input->post("id");
        $chekinglembaga = $this->m_lembaga->GetAllDataLembagaById($id);
        if ($chekinglembaga->num_rows() > 0) {
            $dr = $chekinglembaga->row_object();
            $qrp = "SELECT * FROM `master_paket_kantor` where active =1";
            $qrpaket = $this->db->query($qrp)->result();
            $rpaket = '<option value="' . $dr->paket_id . '">' . $dr->paket . '</option>';
            $rpaket .= '<option value="">Pilih Paket lainya</option>';
            foreach ($qrpaket as $rp) {
                $rpaket .= '<option value="' . $rp->id . '">' . $rp->paket . '</option>';
            }
            $lembaga = [
                'nama' => $dr->nama_cabang,
                'pengurus' => $dr->pengurus,
                'alamat' => $dr->alamat,
                'kota' => $dr->kota,
                'email' => $dr->email,
                'telepon' => $dr->telepon,
                'cabang' => $dr->cabang_kode,
                'website' => $dr->website,
                'donatur' => $dr->kode_donatur,
                'paket' => $rpaket
            ];
            echo $this->output_json(['result' => true, 'data' => $lembaga]);
        } else {
            echo $this->output_json(['result' => true, 'data' => 'No data Result']);
        }
    }
    function newlembaga()
    {
        $id = $this->input->post("idlembaga");
        $lembaga = $this->input->post("lembaga");
        $pimpinan = $this->input->post("pimpinan");
        $alamat = $this->input->post("alamat");
        $kota = $this->input->post("kota");
        $telepon = $this->input->post("telepon");
        $website = $this->input->post("website");
        $email = $this->input->post("email");
        $paket = $this->input->post("paket");
        $kode_l = $this->input->post("kode_l");
        $kode_d = $this->input->post("kode_d");
        if ($id == 'new') {
            $data = [
                'cabang_kode' => $kode_l,
                'nama_cabang' => $lembaga,
                'paket_id' => $paket,
                'hapus' => 0,
                'pengurus' => $pimpinan,
                'alamat' => $alamat,
                'kota' => $kota,
                'telepon' => $telepon,
                'kode_donatur' => $kode_d,
                'email' => $email,
                'website' => $website,
                'datecreate' => date('Y-m-d H:i:s'),
                'dateupdate' => date('Y-m-d H:i:s'),
                'active' => 1,
                'user_create' => $this->session->userdata('id_user'),
                'user_update' => $this->session->userdata('id_user'),
                'last_action' => 0,
            ];
            $proses = $this->db->insert("data_kantor_cabang", $data);
            if ($proses) {

                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'New Data Success!',
                    'description' => 'Simpan Data Lembaga <b> ' . $lembaga . '</b> Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
            } else {
                $info = [
                    'icon' => 'frown-o',
                    'title' => 'Ooppss!',
                    'description' => 'Simpan Data Lembaga  <b> ' . $lembaga . '</b>  Gagal!',
                    'color' => '#df0000',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                echo $this->output_json(['result' => false, 'data' => $data, 'event' => $info]);
            }
        } else if ($id > 0) {
            $data = [
                'cabang_kode' => $kode_l,
                'nama_cabang' => $lembaga,
                'paket_id' => $paket,
                'hapus' => 0,
                'pengurus' => $pimpinan,
                'alamat' => $alamat,
                'kota' => $kota,
                'telepon' => $telepon,
                'kode_donatur' => $kode_d,
                'email' => $email,
                'website' => $website,
                'dateupdate' => date('Y-m-d H:i:s'),
                'active' => 1,
                'user_update' => $this->session->userdata('id_user'),
                'last_action' => 1,
            ];
            $this->db->where("id", $id);
            $proses = $this->db->update("data_kantor_cabang", $data);
            if ($proses) {
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'Update Success!',
                    'description' => 'Update Data Lembaga <b> ' . $lembaga . '</b> Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
            } else {
                $info = [
                    'icon' => 'frown-o',
                    'title' => 'Ooppss!',
                    'description' => 'Update Data Lembaga  <b> ' . $lembaga . '</b>  Gagal!',
                    'color' => '#df0000',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                echo $this->output_json(['result' => false, 'data' => $data, 'event' => $info]);
            }
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Error saat memproses data',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => false, 'event' => $info]);
        }
    }
    function deletedatalembaga()
    {
        $id = $this->input->post("id");
        $nm = $this->input->post("nm");
        $delet  = $this->m_lembaga->HapusData($id);
        if ($delet) {

            // $this->m_lembaga->DeleteAllData($id);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Update Success!',
                'description' => 'Hapus Data Lembaga <b> ' . $nm . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        } else {
            $info = [
                'icon' => 'frown-o',
                'title' => 'Ooppss!',
                'description' => 'Hapus Data Lembaga <b> ' . $nm . '</b> Gagal',
                'color' => '#df0000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
    function GetAllDataLembaga()
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
        echo $this->output_json(['result' => $result, 'dt' => $data]);
    }
}

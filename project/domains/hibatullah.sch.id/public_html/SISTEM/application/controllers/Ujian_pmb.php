<?php

use Mpdf\Tag\Tr;

defined('BASEPATH') or exit('No direct script access allowed');
class Ujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->model('m_soal');
    }
    function index($id = null)
    {
        if ($id != null) {
            $get_token = $this->input->get('C');
            $token = $this->encrypt->decode($get_token);
            $data['soalujian'] = $this->m_soal->getUjianByToken($token)->result();
            $data['idu'] = substr($id, 10) . $token;
        }
        print_r([$data]);
    }
    function setujian()
    {
        $data['tokens_ujian'] =  $this->encrypt->encode($this->random_tokens());
        $data['encrypturl'] =  $this->random_urls();
        $data['ujian'] = $this->m_soal->GetSoalUjian()->result();
        $this->load->view('admin_template/header', $data);
        $this->load->view('admin_template/sidebar');
        $this->load->view('admin_template/main');
        $this->load->view('ujian/data-ujian');
        $this->load->view('admin_template/footer');
        $this->load->view('admin_template/plugin');
    }
    function setting_soal($tokens = null)
    {
        if ($tokens != null) {
            $get_token = $this->input->get('SoS');
            $data['kode'] = $this->encrypt->decode($get_token);
            $data['modul'] = $this->db->get("mhs2_master_modul_soal")->result();
            $ids = $this->m_soal->GetkodeUji()->row_object();
            $data['ids'] = $this->encrypt->encode($ids->id);
            $this->load->view('admin_template/header', $data);
            $this->load->view('admin_template/sidebar');
            $this->load->view('admin_template/main');
            $this->load->view('ujian/setting-ujian');
            $this->load->view('admin_template/footer');
            $this->load->view('admin_template/plugin');
        }
    }
    function pertama()
    {
        $this->load->view('admin_template/header');
        $this->load->view('admin_template/sidebar');
        $this->load->view('admin_template/main');
        $this->load->view('test/pertama');
        $this->load->view('admin_template/footer');
        $this->load->view('admin_template/plugin');
    }
    function kedua()
    {
        $data['soal'] = $this->m_soal->GetAllSoalPertama();
        $this->load->view('admin_template/header', $data);
        $this->load->view('admin_template/sidebar');
        $this->load->view('admin_template/main');
        $this->load->view('test/kedua');
        $this->load->view('admin_template/footer');
        $this->load->view('admin_template/plugin');
    }
    function cbt1()
    {
        $data = [
            'OK' => 'OK',
        ];
        echo json_encode($data);
    }
    function random_tokens()
    {
        $alphabet = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $tokenujian = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alpha_length);
            $tokenujian[] = $alphabet[$n];
        }
        return implode($tokenujian);
    }
    function random_urls()
    {
        $alphabet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,-_@';
        $tokenujian = array();
        $alpha_length = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alpha_length);
            $tokenujian[] = $alphabet[$n];
        }
        return implode($tokenujian);
    }
    function get_autocomplete()
    {
        if ($this->input->post("token") != null) {
            $kode = $this->input->post("code");
            $token = $this->input->post("token");
            $res_token = $this->m_soal->getUjianByToken($token);
            $res = [0];
            if ($res_token->num_rows() > 0) {
                foreach ($res_token->result() as $rd) {
                    $res[] = $rd->soal_id;
                }
            }
            $result = $this->m_soal->cari_kategorList($kode, $res)->result();
            $data = [];
            $title = '';
            foreach ($result as $row) {
                $fill = '<span class="Soal-box" style="font-size:11px">
                <div class="p-1 mb-2 bg-gradient-primary rounded text-white" style="font-size:10px"> Kategori: ' . $row->kategori_soal . '</div>
                <p>' . substr($row->soal, 0, 100) . '...</p>
                </span>';
                $data[] = [
                    $row->id, $fill
                ];
                $title .= $row->kategori_soal . " | ";
            }
            $val["data"] = $data;
            $val["title"] = $title;
            echo json_encode($val);
        }
    }
    function allujianbytoken()
    {
        if ($this->input->post("token") != null) {
            $token = $this->input->post("token");
            $result = $this->m_soal->getDataUjianDTLBy($token)->result();
            $data = [];
            $no = 1;
            foreach ($result as $row) {
                $fill = '<span class="Soal-box" style="font-size:11px">
                <div class="p-1 mb-2 bg-gradient-success rounded text-white text-right " style="font-size:10px; font-weight:bold"> ' . strtoupper($row->kategori_soal) . ' </div>
                <p>' . $row->soal . '</p>
                </span>';
                $data[] = [
                    $no++, $fill
                ];
            }
            echo json_encode($data);
        }
    }
    function viewallujianbytoken()
    {
        if ($this->input->post("token") != null) {
            $token = $this->input->post("token");
            $result = $this->m_soal->getDataUjianDTLBy($token)->result();
            $data = [];
            $no = 1;
            foreach ($result as $row) {
                if ($row->tipesoal == 'pilihan') {
                    $jawab = '
                  <div class="col-6"><div class="mb-1"> A. ' . $row->a . '</div><div class="mb-1"> B. ' . $row->b . '</div></div>
                  <div class="col-6"><div class="mb-1"> C. ' . $row->c . '</div><div class="mb-1"> D. ' . $row->d . '</div></div>';
                } else  if ($row->tipesoal == 'uraian') {
                    $jawab = '<div><span>Jawaban:</span></div><textarea class="form-control " id="uraian" name="uraian" rows="6"></textarea>';
                }
                $fill = '<tr><td style="vertical-align: top;"><strong>' . $no++ . '. </strong></td>
                <td style="font-weight:400"> ' . $row->soal . '<br>
                <div class="row mt-2">
                ' . $jawab . '
                </div></td></tr>
                ';
                $data[] = [
                    $fill
                ];
            }
            echo json_encode($data);
        }
    }
    function set_data()
    {
        $string = $this->input->post("data");
        $id = $this->encrypt->decode($this->input->post("idu"));
        $token = $this->input->post("kode");
        $param = explode(",", $string);
        $data = [];
        for ($i = 0; $i < count($param); $i++) {
            if ($param[$i] != '') {
                $data[] = [
                    'soal_id' => $param[$i],
                    'ujian_id' => $id,
                    'token' => $token,
                ];
            }
        }
        if (!empty($data)) {
            $this->db->insert_batch("mhs2_master_ujian_detail", $data);
        }
        $getData = $this->m_soal->getDataUjianDTLBy($token)->result();
        $rdata = [];
        $no = 1;
        foreach ($getData as $row) {
            $fill = '<span class="Soal-box" style="font-size:12px">
            <div class="p-1 mb-2 bg-gradient-success rounded text-white text-right " style="font-size:10px; font-weight:bold">' . $row->kategori_soal . ' </div>
            <p>' . $row->soal . '</p>
            </span>';
            $rdata[] = [
                $no++, $fill
            ];
        }
        echo json_encode($rdata);
    }
    function prosesujiantoken()
    {
        if (($this->input->post("token") != null)) {
            $token  = $this->input->post("token");
            $modul  = $this->input->post("modul");
            $jenis  = $this->input->post("jenis");
            $waktu  = $this->input->post("waktu");
            $start  = $this->input->post("start");
            $finish    = $this->input->post("end");
            $id     = $this->encrypt->decode($this->input->post("id"));
            $res_token = $this->m_soal->getUjianByToken($token);
            $res = '';
            $data = [];
            $report = [];
            if ($res_token->num_rows() > 0) {
                $soal = $res_token->num_rows();
                foreach ($res_token->result() as $rd) {
                    $res .= $rd->soal_id . ",";
                }
                $data = [
                    "id" => $id,
                    "modul_id" => $modul,
                    "usr_id" => $this->session->userdata("id_user"),
                    "jumlah_soal" => $soal,
                    "datasoal" => $res,
                    "jenis" => $jenis,
                    "waktu" => $waktu,
                    "start" => $start,
                    "finish" => $finish,
                    "datecreate" => date("Y-m-d h:i:s"),
                    "token" => $token,
                ];
                if ($this->db->insert("mhs2_master_ujian", $data)) {
                    $report = [
                        "msg" => "success",
                        "status" => 200
                    ];
                } else {
                    $report = [
                        "msg" => "error",
                        "status" => 500
                    ];
                }
            } else {
                $report = [
                    "msg" => "error",
                    "status" => 304
                ];
            }
            echo json_encode($report);
        }
    }
    function hapusdataujian()
    {
        $id = $this->input->post("id");
        $token = $this->input->post("token");
        $tokens = [
            "token" => $token
        ];
        $idujian = [
            "id" => $id
        ];
        if (
            $this->db->delete('mhs2_master_ujian', $idujian) &&
            $this->db->delete('mhs2_master_ujian_detail', $tokens)
        ) {
            echo json_encode(["status" => '200']);
        } else {
            echo json_encode(["status" => '500']);
        }
    }
}

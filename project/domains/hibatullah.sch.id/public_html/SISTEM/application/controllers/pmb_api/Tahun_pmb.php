<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Tahun_pmb extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'secure']);
        $this->load->helper(['url', 'language']);
        $this->lang->load('auth');
        $this->load->model(['m_periodik', 'm_lembaga']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function get_data($act = null)
    {
        $open = "";
        if ($act != null) {
            $open = "AND active='$act'";
        }
        $data = [];
        $data =  $this->db->query("SELECT a.*,b.nama_cabang FROM master_pmb_tahun_akademik a
        LEFT JOIN data_kantor_cabang b on b.id = a.cabang_id
        Where a.hapus=0  $open ORDER BY angkatan DESC
         ")->result();
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            if ($this->session->userdata("idlevel") <= 2) {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $this->secure->encrypt_url($row->id_tahun) . '"data-nm="' . $row->tahun_akademik . '" data-option="Edit"><i class="dw dw-edit2"></i></span>
                    ';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-edit2"></i></span>';
            }
            if ($row->active == '1') {
                $bg = 'true';
                $active = 'Aktif';
            } else {
                $bg = 'false';
                $active = 'Tidak Aktif';
            }
            $formulir = 0;
            if ($row->nominal > 0) {
                $formulir = number_format($row->nominal);
            }
            $register = 0;
            if ($row->registrasi > 0) {
                $register = number_format($row->registrasi);
            }
            $res_data[] = [
                $no++,
                $row->nama_cabang,
                $row->tahun_akademik,
                $formulir,
                $register,
                $active,
                $BTN_A,
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }

    function get_data_periode()
    {
        $id = $this->input->post("id");
        $cb = $this->input->post("cb");
        $checking = $this->db->get_where("master_pmb_tahun_akademik", ['tahun_akademik' => $id, 'cabang_id' => $cb]);
        $data = 0;
        $info = "";
        if ($checking->num_rows() > 0) {
            $data = 1;
            $info = [
                'icon' => 'fa-frown-o',
                'title' => 'Opssss!',
                'description' => 'Tahun  Angkatan <b> ' . $id . '</b> Sudah Ada',
                'color' => '#e80000',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
        }

        echo $this->output_json(['result' => $data, 'event' => $info]);
    }
    function get_data_by()
    {
        $id = $this->secure->decrypt_url($this->input->post("id"));
        $data = $this->db->get_where("master_pmb_tahun_akademik", ['id_tahun' => $id])->row_object();
        echo $this->output_json($data);
    }

    function newdata()
    {
        $id = $this->input->post("idAkademik");
        $cabang = $this->input->post("Tingkat");
        $periode = $this->input->post("Periode");
        $Nominal = $this->input->post("Nominal");
        $Nominal2 = $this->input->post("Nominal2");
        $Aktif = $this->input->post("Aktif");
        $data = [
            'cabang_id' => $cabang,
            'nominal' => $Nominal,
            'registrasi' => $Nominal2,
            'tahun_akademik' => $periode,
            'active' => $Aktif,
            'hapus' => '0',
        ];

        if ($id == 'new') {
            $this->db->insert("master_pmb_tahun_akademik", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'New Data Success!',
                'description' => 'Simpan Tahun PMB <b> ' . $periode . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
        } else {
            $this->db->where("id_tahun", $this->secure->decrypt_url($id));
            $this->db->update("master_pmb_tahun_akademik", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'Update Success!',
                'description' => 'Update Data Tahun PMB <b> ' . $periode . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
        }
    }

    function hapusdata()
    {
        $id = $this->input->post("id");
        $nm = $this->input->post("nm");
        $this->db->where("id_akademik", $this->secure->decrypt_url($id));
        $this->db->delete("master_periodik_akademik");
        $info = [
            'icon' => 'thumbs-up',
            'title' => 'Delete Success!',
            'description' => 'Hapus  <b> ' . $nm . '</b> Berhasil..',
            'color' => '#a4cc00',
            'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
        ];
        echo $this->output_json(['result' => true, 'event' => $info]);
    }
}

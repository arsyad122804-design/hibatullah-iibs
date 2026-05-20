<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Pembayaran_seleksi extends CI_Controller
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
    function get_data($ta = null)
    {
        $open = "";
        if ($ta != null) {
            $open = "AND b.id_tahun ='$ta'";
        }
        $data = [];
        $data =  $this->db->query("SELECT *,a.active as act_set,a.nominal as pembayaran FROM master_pmb_pembayaran_seleksi a
        inner join master_pmb_tahun_akademik b on b.id_tahun = a.tahun_id
        Where a.hapus=0  $open ORDER BY a.id_pembayaran_seleksi ASC ")->result();
        $no = 1;
        $res_data = [];
        foreach ($data as $row) {
            $formulir = 0;
            if ($row->pembayaran > 0) {
                $formulir = number_format($row->pembayaran);
            }
            if ($this->session->userdata("idlevel") == 1) {
                $BTN_A = '
                <span  class="badge badge-sm rounded-circle btn-primary openform" data-id="' . $this->secure->encrypt_url($row->id_pembayaran_seleksi) . '"data-nm="' . $row->jenis . '" data-option="Edit"><i class="dw dw-edit2"></i></span>

                <span class="badge rounded-circle btn-danger deletedata" data-id="'  . $this->secure->encrypt_url($row->id_pembayaran_seleksi) .  '" data-nm="' . $row->jenis . '<br>' .  $formulir  . '" title="Hapus Data"><i class="dw dw-delete-3"></i> </span>
                    ';
            } else {
                $BTN_A = '<span  class="badge badge-sm rounded-circle btn-secondary "><i class="dw dw-edit2"></i></span>';
            }
            if ($row->act_set == 1) {
                $bg = 'true';
                $active = 'Aktif';
            } else {
                $bg = 'false';
                $active = 'Tidak Aktif';
            }
            $res_data[] = [
                $no++,
                $row->jenis,
                $formulir,
                $row->tahun_akademik,
                $active,
                $BTN_A,
            ];
        }
        echo json_encode(['data' => $res_data], true);
    }

    function get_master($cb_set = null)
    {
        $data = [];
        $d = 0;
        if ($cb_set != null) {
            $data =  $this->db->query("SELECT * FROM `master_pmb_tahun_akademik` Where  cabang_id='$cb_set'
            ORDER BY angkatan DESC ")->result();
            $d = 1;
        }
        echo $this->output_json(['result' => $data, $d]);
    }

    function get_data_periode()
    {
        $id = $this->input->post("id");
        $checking = $this->db->get_where("master_pmb_tahun_akademik", ['tahun_akademik' => $id]);
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
        $data = $this->db->query("SELECT *,a.active as act_set,a.nominal as pembayaran FROM master_pmb_pembayaran_seleksi a
        inner join master_pmb_tahun_akademik b on b.id_tahun = a.tahun_id
        Where a.id_pembayaran_seleksi='$id'")->row_object();
        echo $this->output_json($data);
    }

    function newdata()
    {
        $id = $this->input->post("idTes");
        $periode = $this->input->post("Periode");
        $Jenis = $this->input->post("Jenis");
        $Nominal = $this->input->post("Nominal");
        $Aktif = $this->input->post("Aktif");
        $data = [
            'tahun_id' => $periode,
            'jenis' => $Jenis,
            'nominal' => $Nominal,
            'active' => $Aktif,
            'hapus' => '0',
        ];

        if ($id == 'new') {
            $this->db->insert("master_pmb_pembayaran_seleksi", $data);
            $info = [
                'icon' => 'thumbs-up',
                'title' => 'New Data Success!',
                'description' => 'Simpan <b> ' . $Jenis . '</b> Berhasil',
                'color' => '#a4cc00',
                'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
            ];
            echo $this->output_json(['result' => true, 'data' => $data, 'event' => $info]);
        } else {
            $this->db->where("id_pembayaran_seleksi", $this->secure->decrypt_url($id));
            $this->db->update("master_pmb_pembayaran_seleksi", $data);
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
        $this->db->where("id_pembayaran_seleksi", $this->secure->decrypt_url($id));
        $this->db->update("master_pmb_pembayaran_seleksi", ['hapus' => 1]);
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

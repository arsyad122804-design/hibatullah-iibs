<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Withdraw extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'encryption', 'secure', 'user_agent']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(['affiliate/m_withdraw', 'm_lembaga']);
        $this->load->helper(['url', 'language', 'auth_helper']);
        is_auth_chek();
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get_data($pr_set = null, $aff_set = null)
    {

        $no = 1;
        $res_data = [];
        $ids = $this->session->userdata('id_user');
        $level = $this->session->userdata('idlevel');
        $periodesctiv = $this->db->query("SELECT * FROM master_pmb_tahun_akademik where active=1 ORDER BY tahun_akademik ASC")->row_object();
        $ta = $periodesctiv->id_tahun;
        if ($pr_set != null) {
            if ($pr_set != 'null') {
                if ($pr_set != 'undefined') {
                    $ta = $pr_set;
                }
            }
        }
        if ($level == 1) {
            $data =  $this->m_withdraw->GetAllDataUserByTa($ta)->result();
        } else {
            $data =  $this->m_withdraw->GetAllDataUserIDBy($ids, $ta)->result();
        }

        if ($aff_set != null) {
            if ($aff_set != 'null') {
                if ($aff_set != 'undefined') {
                    $data =  $this->m_withdraw->GetAllDataUserIDBy($aff_set, $ta)->result();
                }
            }
        }
        foreach ($data as $row) {
            $gender = "-";
            if ($row->jns_kelamin == 1) {
                $gender = "L";
            }
            if ($row->jns_kelamin == 2) {
                $gender = "P";
            }

            $fee = "-";
            $aff = "-";
            $status = "-";
            $button = "-";
            if ($row->aff_id > 1) {
                if ($row->fee > 0) {
                    $fee = number_format($row->fee);
                }
                $aff = $row->nama_asli;
                $status = "Belum terbayarkan";
                $cheking = $this->db->query("SELECT * FROM master_pmb_withdraw a 
                        INNER JOIN master_pmb_withdraw_status b ON b.id_st = a.status_id
                        WHERE a.id_pendaftar='$row->id_pelajar'");
                if ($cheking->num_rows() > 0) {
                    $str = $cheking->row_object();
                    if ($str->id_st == 0) {
                        $status = $str->nama_status;
                    } elseif ($str->id_st == 1) {
                        $status = '<div class="badge badge-success">' . $str->nama_status . '</div><small>' . date("d-m-Y H:i", strtotime($str->transaksi_at)) . '</small>';
                    }
                }

                $button = '
                    <span class="badge rounded btn-primary Confirm" data-dataset="' . $this->secure->encrypt_url(json_encode(['id_pelajar' => $row->id_pelajar, 'id_aff' => $row->aff_id, 'nominal' => $row->fee, 'status' => 1])) . '" title="Pencairan Dana" data-option="Cairkan"><i class="dw dw-money-2"></i> Terbayar</span>
                    <span class="badge rounded btn-danger Confirm" data-dataset="' . $this->secure->encrypt_url(json_encode(['id_pelajar' => $row->id_pelajar, 'id_aff' => $row->aff_id, 'nominal' => $row->fee, 'status' => 0])) . '" title="Batalkan Dana" data-option="Batalkan"><i class="dw dw-money-2"></i> Batalkan</span>
                    ';
            }
            $res_data[] = [
                $no++,
                $row->nama_lengkap,
                $gender,
                $fee,
                $aff,
                $status,
                $button,
            ];
        }

        echo json_encode(['data' => $res_data], true);
    }

    function confirm()
    {
        $params = $this->input->post("token");
        $dr = json_decode($this->secure->decrypt_url($params));

        $data = [
            'id_pendaftar' => $dr->id_pelajar,
            'fee' => $dr->nominal,
            'status_id' => $dr->status,
            'transaksi_at' => date("Y-m-d H:i:s")
        ];
        $cheking = $this->db->get_where("master_pmb_withdraw", ['id_pendaftar' => $dr->id_pelajar]);
        if ($cheking->num_rows() > 0) {
            $data = [
                'fee' => $dr->nominal,
                'status_id' => $dr->status,
                'transaksi_at' => date("Y-m-d H:i:s")
            ];
            try {
                $this->db->where('id_pendaftar', $dr->id_pelajar);
                $this->db->update("master_pmb_withdraw", $data);
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'Update Success!',
                    'description' => 'Update Data Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                $result = true;
            } catch (\Exception $e) {
            }
        } else {
            try {
                $this->db->insert("master_pmb_withdraw", $data);
                $info = [
                    'icon' => 'thumbs-up',
                    'title' => 'Update Success!',
                    'description' => 'Update Data Berhasil',
                    'color' => '#a4cc00',
                    'footer' => '<button type="button" class="btn btn-sm btn-secondary text-center" data-dismiss="modal">OK</button>'
                ];
                $result = true;
            } catch (\Exception $e) {
            }
        }
        echo $this->output_json(['result' => $result, 'data' => $data, 'event' => $info]);
    }
}

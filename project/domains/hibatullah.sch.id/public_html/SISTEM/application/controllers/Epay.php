<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Epay extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['session', 'encryption', 'secure']);
        $this->lang->load('auth');
        $this->load->model(['m_infaq_siswa', 'm_mail']);
        $this->load->helper(['url', 'language', 'auth', 'security']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    function cstudy($id = null)
    {
        if ($id != null) {
            $getIDS = $this->secure->decrypt_url($id);
            $gid = json_decode($getIDS);
            $GetData = $this->db->get_where("data_reg_pembayaran", ['order_id' => $gid->oid])->row_object();
            if (substr($gid->oid, 0, 2) == "ST") {
                $GetDetail = $this->db->get_where("data_registrasi", ['order_id' => $gid->oid])->result();
                $nmin = "INFAQ SANTRI";
            } elseif (substr($gid->oid, 0, 2) == "DN") {
                $nmin = "INFAQ DONATUR";
                $GetDetail = $this->db->get_where("data_reg_donatur", ['order_id' => $gid->oid])->result();
            }
            $data['infaq'] = $GetData;
            $data['nminfaq'] = $nmin;
            $data['detail'] = $GetDetail;
            $data['token_user'] = $this->secure->encrypt_url($gid->uid);
            $data['TitelPage'] = 'SIATA - ' . $nmin;
            $data['data_plug'] = 'null';
            $data['action'] = 'null';
            $this->load->view('template/head', $data);
            $this->load->view('template/loader');
            $this->load->view('template/header');
            $this->load->view('template/right_bar');
            $this->load->view('template/left_bar');
            $this->load->view('infaq/viewsiswa');
            $this->load->view('template/footer');
        }
    }
    function Validasi()
    {
        $id = $this->input->post("id");
        $st = $this->input->post("st");
        if ($st == "YA") {
            $STT = "COMPLETED";
            $STS = 1;
            $res = true;
        } else {
            $STT = "REJECTED";
            $STS = 2;
            $res = false;
        }
        $GetData = $this->db->get_where("data_reg_pembayaran", ['order_id' => $id]);
        if ($GetData->num_rows() > 0) {
            $data = $GetData->row_object();
            $this->UpdateBayar($id, $STT, $STS);
            if (substr($id, 0, 2) == "ST") {
                $GetDetail = $this->db->get_where("data_registrasi", ['order_id' => $id])->result();
                $nmin = "INFAQ SANTRI";
                $this->UpdateRegister($id, $STT, $STS);
            } elseif (substr($id, 0, 2) == "DN") {
                $nmin = "INFAQ DONATUR";
                $GetDetail = $this->db->get_where("data_reg_donatur", ['order_id' => $id])->result();
                $this->UpdateRegisterDonatur($id, $STT, $STS);
            }
        }
        echo $this->output_json(['res' => $res]);
    }
    function UpdateBayar($id, $STT, $STS)
    {
        $data = [
            'transaction_status' => $STT,
            'transaction_at' => date("Y-m-d H:i:s"),
        ];
        $this->db->set($data);
        $this->db->where("order_id", $id);
        $this->db->update("data_reg_pembayaran");
    }
    function UpdateRegister($id, $STT, $STS)
    {
        $data = [
            'status' => $STS,
            'keterangan' => $STT,
        ];
        $this->db->set($data);
        $this->db->where("order_id", $id);
        $this->db->update("data_registrasi");
    }
    function UpdateRegisterDonatur($id, $STT, $STS)
    {
        $data = [
            'status' => $STS,
            'keterangan' => "COMPLETED",
        ];
        $this->db->set($data);
        $this->db->where("order_id", $id);
        $this->db->update("data_reg_donatur");
    }
    function Report_MailNotif($id)
    {
        $cabang = $this->db->get_where("data_kantor_cabang", ['id' => $this->session->userdata("fid_cabang")])->row_object();
        if (substr($id, 0, 2) == "ST") {
            $GetData = $this->db->query("SELECT * FROM data_reg_pembayaran a INNER JOIN data_registrasi b ON b.order_id = a.order_id INNER JOIN data_pelajar c ON c.id_pelajar = b.pelajar_id WHERE a.order_id ='$id' GROUP BY c.id_pelajar")->row_object();
            $GetDetail = $this->db->get_where("data_registrasi", ['order_id' => $id])->result();
            $nmin = "INFAQ SANTRI";
        } elseif (substr($id, 0, 2) == "DN") {
            $GetData = $this->db->get_where("data_reg_pembayaran", ['order_id' => $id])->row_object();
            $nmin = "INFAQ DONATUR";
            $GetDetail = $this->db->get_where("data_reg_donatur", ['order_id' => $id])->result();
        }
        $datadtl = '';
        foreach ($GetDetail as $dt) {
            $datadtl .= '<tr>';
            $datadtl .= '<td style="border: 1px solid #ddd;
  padding: 8px; text-align:left">INFAQ ' . $dt->type . ' (' . $dt->nama_bulan . '-' . $dt->tahun . ')</td>';
            $datadtl .= '<td style="border: 1px solid #ddd;
  padding: 8px;text-align:right">' . number_format($dt->nominal) . '</td>';
            $datadtl .= '</tr>';
        }
        $nama = "TEST DATA";
        $cm = ""; // strlen($GetData->bank_code);
        if (strtoupper($GetData->transaction_status) == "SUCCESS" || strtoupper($GetData->transaction_status) == "SUCCESS_COMPLETED" || strtoupper($GetData->transaction_status) == "SETTLEMENT" || strtoupper($GetData->transaction_status) == "COMPLETED") {
            $color = " color:#3cc26f";
            $ss = '<div style="margin:20px 0;text-align: center; line-height:100%;">
    Infaq anda sudah kami terima.
</div>
<div style="text-align: justify; padding:10px; background-color:#b3df00; border-top:6px solid #aeaeae; border-bottom:6px solid #aeaeae">Terimakasi atas kepercayaan anda kepada kami. Untuk informasi lebih lanjut silahkan hubungi kami melalui: 08123456789 </div>
';
        } else {
            $color = " color: #eb4034";
            $ss = "";
        }
        $sendatamail = '
<div style="max-width:620px;">
    <div style="margin-left: auto;margin-right:auto">
        <div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #b3df00 double 8px;">
            <table style=" width: 100%;">
                <tr>
                    <td style="width: 100px;">
                        <img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
                    </td>
                    <td style="text-align: right;">
                    
<div style="text-decoration: none; color:#b3df00;font-weight:900;font-size: 22px; ">SIAKAD</div>
                        <div>
                            <div><span style="font-size: 12px; font-weight:700">' . $cabang->nama_cabang . '</span></div>
                        </div>
                        <div style="font-size: 11px;">No.Telepon : ' . $cabang->telepon . ' </div>
                        <div style="font-size: 11px;">Website : ' . $cabang->website . ' </div>
                    </td>
                </tr>
            </table>
        </div>
        <div style="background-color: #b3df00;color:#fff">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align:left;font-weight:700">Kode transaksi</td>
                    <td style="text-align:right;font-weight:700">' . $GetData->order_id . '</td>
                </tr>
            </table>
        </div>
        <div style="padding: 10px;background-color: #fff; border-bottom: #b3df00 double 2px;">
            <div class="col">
                <div style="margin-top:5%">
                    <div style="text-align: center; padding:0 0 10px 0">
                        <img src="' . base_url("assets/img/salam.png") . '" style="width:400px; text-align:center" alt="">
                    </div>
                    <div>
                        <div style="font-weight:500; font-size:14px; margin-bottom:6px">Sahabat dermawan yang di cintai allah.</div>
                        <table style="width:100%;text-align:left">
                            <tr>
                                <td tyle="font-weight:800; font-size:12px; margin-bottom:6px"><b>Nama</b></td>
                                <td>:</td>
                                <td>' . $nama . '</td>
                            </tr>
                            <tr>
                                <td tyle="font-weight:800; font-size:12px; margin-bottom:6px"><b>Whatsapp</b></td>
                                <td>:</td>
                                <td>' . $GetData->phone . '
                                </td>
                            </tr>
                            <tr>
                                <td tyle="font-weight:800; font-size:14px; margin-bottom:6px"><b>Email</b></td>
                                <td>:</td>
                                <td>' . $GetData->email . '</td>
                            </tr>
                        </table> 
                        <div style="margin-top: 20px; padding:10px; background-color:#e0ffa8">
                        <table style="width:100%;border-collapse: collapse;">
                        <tr>
                        <th style="border: 1px solid #ddd;
  padding: 8px;text-align:left">Nama Infaq</th>
                        <th style="border: 1px solid #ddd;
  padding: 8px;text-align:right">Nominal</th>
                        </tr>
                        <tbody>
                        ' . $datadtl . '
                        </tbody>
                        <br>
                        </table> 
                            <table style="width:100%">
                                <thead>
                                    <th style="text-align: left;font-weight:500; font-size:14px; "></th>
                                    <th style="text-align:right;font-weight:500; font-size:16px;font-weight:700 ">Total Infaq</th>
                                </thead>
                                <tr>
                                    <td style="text-align: left; font-size:14px;;font-weight:700"></td>
                                    <td style="text-align:right; font-size:32px; font-weight:800">
                                        ' . number_format($GetData->amount) . '</td>
                                </tr>
                            </table>
                        </div>
                        <div style="margin:20px 0;text-align: center; line-height:100%;">
                             PEMBAYARAN  <b>' . $GetData->method . '</b>
                            <div style="text-align: center; font-size:32px; font-weight:900; ' . $color . ' ; margin:20px">' . $GetData->transaction_status . '</div>
                        </div>
                    </div>
                    ' . $ss . '
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
</div>
		';
        echo  $sendatamail;
        // $GetDataSend = $this->m_mail->SendMail($GetData->email, 'INVOICE DONASI LAZDAU', $sendatamail);
    }
}

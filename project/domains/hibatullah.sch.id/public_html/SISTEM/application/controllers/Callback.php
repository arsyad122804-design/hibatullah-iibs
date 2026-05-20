<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Callback extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session', 'secure']);
        $params = array('server_key' => 'Mid-server-Abt88gw49JHKgOPVZDr457FI', 'production' => true);
        // $params = array('server_key' => '', 'production' => true);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper(['url', 'language', 'auth_helper', 'string']);
        $this->load->model(['m_mail']);
        // $this->load->library('cart');
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function notification()
    {
        $json = file_get_contents('php://input');
        $dr = json_decode($json);
        $get = $this->db->query("SELECT * FROM master_pmb_reg WHERE nota='$dr->order_id'");
        $vanumber = "-";
        $set_st = 0;
        $ga = 0;
        if ($dr->transaction_status == 'settlement') {
            $set_st = 1;
            $ga = $dr->gross_amount;
        }
        if ($get->num_rows() > 0) {
            $res = [
                'transaction_status' => $dr->transaction_status,
                'tgl_bayar' => date("Y-m-d H:i:s"),
                'status' => $set_st
            ];
        } else {
            $res = 0;
        }
        if (isset($dr->permata_va_number)) {
            $vanumber = $dr->permata_va_number;
        }
        if (isset($dr->va_numbers)) {
            $vanumber = $dr->va_numbers;
            if (is_array($vanumber)) {
                $vanumber = $dr->va_numbers[0]->va_number;
            };
        }
        if (isset($dr->biller_code)) {
            $vanumber = $dr->biller_code . " - " . $dr->bill_key;
        }

        if ($res != 0) {
            $this->db->where("nota", $dr->order_id);
            $this->db->update("master_pmb_reg", $res);
            $gdt = $get->row_object();
            $jns = $gdt->jns;
            $get_data = $this->db->query("SELECT *,a.email as email_reg,a.alamat as alamat_set FROM master_pmb_register_pelajar a 
            INNER JOIN master_pmb_tahun_akademik b ON b.tahun_akademik = a.periode
            LEFT JOIN master_wilayah_kota c ON c.id = a.id_kota
            LEFT JOIN data_kantor_cabang d ON d.id = a.cabang_id
            WHERE a.nomor_registrasi='$gdt->nomor_reg'");
            if ($dr->transaction_status == 'settlement') {
                if ($get_data->num_rows() > 0) {
                    $dtp = $get_data->row_object();
                    $stp = 1;
                    if ($jns == 1) {
                        $stp = 3;
                    } elseif ($jns == 2) {
                        $stp = 4;
                    } elseif ($jns == 3) {
                        $stp = 5;
                    }
                    $this->db->where('nomor_registrasi', $dtp->nomor_registrasi)->where('id_pelajar', $dtp->id_pelajar)->update("master_pmb_register_pelajar", ['status_pelajar' => $stp]);
                    if ($jns > 1) {
                        if ($this->send_MailNotif_2($dtp, $jns, $ga)) {
                            $this->send_MailNotif_Admin($dtp, $jns, $ga);
                        }
                    } else {
                        $this->setupakun($dtp, $jns, $ga);
                    }
                }
            }
            echo $this->output_json(['result' => 200, $vanumber]);
        } else {
            echo $this->output_json(['result' => 500]);
        }
        //$this->db->insert('donatur_snap_tes', ['id' => null, 'type' => 2, 'result' => json_encode($dr)]);
    }

    function setupakun($dtp, $jns, $ga)
    {
        $checking = $this->db->get_where("sys_user", ['username' => $dtp->nomor_registrasi, 'fid_keterangan' => $dtp->id_pelajar]);
        if ($checking->num_rows() > 0) {
            $this->db->where('username', $dtp->nomor_registrasi)->where('fid_keterangan', $dtp->id_pelajar)->update("sys_user", ['konfirm' => "Y", 'aktif' => 'Y']);
        } else {
            $SetPass = $this->secure->encrypt_url('123456');
            $result = [
                'username' => $dtp->nomor_registrasi,
                'password' => $SetPass,
                'id_level' => 50,
                'sess_id' =>  $this->secure->encrypt_url(date("dmy") . '-' . $this->session->userdata("id_user")),
                'last_login' => '',
                'last_logout' => '',
                'fid_keterangan' => $dtp->id_pelajar,
                'nama_asli' => $dtp->nama_lengkap,
                'email' => $dtp->email_reg,
                'block_count' => 0,
                'block_exp' => '',
                'reset_token' => '',
                'reset_exp' => '',
                'konfirm' => 'Y',
                'aktif' => 'Y',
                'icon' => 'pavicon.png',
                'fid_cabang' => $dtp->cabang_id,
                'created_by' => 0
            ];
            $this->db->insert("sys_user", $result);

            if ($this->send_MailNotif($dtp)) {
                $this->send_MailNotif_Admin($dtp, $jns, $ga);
            }
        }
    }

    function status_bayar($e)
    {
        switch ($e) {
            case 'pending':
                $result = [
                    'st' => 'Menunggu Pembayaran',
                    'msg' => 'Mohon Untuk Melakukan transaksi pembayaran sebelum masa <b>Expired</b>.'
                ];
                break;
            case 'settlement':
                $result = [
                    'st' =>  'Pembayaran Berhasil',
                    'msg' => 'Terimaksih sudah melakukan pembayaran sebelum masa berlaku habis..'
                ];
                break;
            case 'expire':
                $result = [
                    'st' =>  'Invoice Sudah Expired',
                    'msg' => 'Mohon Untuk Melakukan transaksi ulang karena sudah masa <b>Expired</b>.'
                ];
                break;
            case 'failure':
                $result = [
                    'st' =>  'Gagal',
                    'msg' => 'Mohon ma' . "'" . 'af transaksi tidak bisa dimuat, silahkan lakukan pemesanan ulang..'
                ];
                break;
            case 'cancel':
                $result = [
                    'st' =>  'Dibatalkan',
                    'msg' => 'Mohon ma' . "'" . 'af transaksi tidak bisa dimuat, silahkan lakukan pemesanan ulang..'
                ];
                break;
            default:
                $result = [
                    'st' => 'Menunggu Pembayaran',
                    'msg' => 'Mohon Untuk Melakukan transaksi pembayaran sebelum masa <b>Expired</b>.'
                ];
                break;
        }
        return json_encode($result);
    }

    function send_MailNotif($dtp)
    {
        $sendatamail = '
    	<div style="max-width:620px; margin:auto">
    		<div style="margin-left: auto;margin-right:auto">
    			<div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #094b8e double 8px;">
                <table style=" width: 100%;">
                <tr>
                    <td style="width: 100px;">
                        <img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
                    </td>
                    <td style="text-align: right;">
                        <div>
                            <h2 style="text-decoration: none; color:#094b8e;font-weight:900">
                               PPDB ' . $dtp->nama_cabang . '
                            </h2>
                        </div> 
                    </td>
                </tr>
            </table>
    			</div>
    			<div style="background-color: #fff; border-bottom: #094b8e double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:12pt; margin-bottom:6px">
                                Assalamuaiakum, Ayah/Bunda ' . $dtp->nama_lengkap . '. Terimakasih telah melakukan pembayaran Formulir PPDB. <br>
                                <div style="text-align:center">
                                Status Pembayaran 
                                <div style="font-weight:800; font-size:22pt;">BERHASIL</div></div>
                                </div>
                                <div style="margin-top:10px;font-weight:500; font-size:12pt; margin-bottom:6px">
                                Silahkan login ke sistem kami untuk melengkapi berkas yang diperlukan dan mengikuti tes seleksi peserta didik baru. Berikut adalah akun ananda untuk login ke sistem PPDB kami.</div>
    							<table style="width:100%;text-align:left">
    								<tr>
    									<td style="font-weight:900; font-size:12pt; margin-bottom:6px; width:130px"><b>Username</b></td>
    									<td style="width:10px">: </td>
    									<td>' . strtoupper($dtp->nomor_registrasi) . '</td>
    								</tr>
    								<tr>
    									<td style="font-weight:900; font-size:12pt; margin-bottom:6px; width:130px"><b>Password</b></td>
    									<td style="width:10px">: </td>
    									<td>123456</td>
    								</tr>
    								<tr>
    									<td style="font-weight:900; font-size:12pt; margin-bottom:6px"><b>Link Siakad</b></td>
    									<td>: </td>
    									<td>
                                        <a  style="
                                        text-decoration: none;
                                        cursor: pointer;" target="blank_" href="' . base_url() . '">' . base_url() . '</a></td>
    								</tr>
    							</table>
    							</div>
    							<div style="margin:20px 0;text-align: center; line-height:100%;">
    								Silahkan login melalui link di atas.
    							</div>
    						
    					</div>
    				</div>
    			</div>
    			<br>
                #PPDB HIBATULLAH IIBS
    		</div>
    	</div>
    	';
        // return $sendatamail;
        return $this->m_mail->SendMail([$dtp->email_reg,], 'AKUN SELEKSI PPDB', $sendatamail);
    }
    function send_MailNotif_2($dtp, $jns, $ga)
    {
        if ($jns == 2) {
            $pmby = "PEMBAYARAN TES SELEKSI";
        } elseif ($jns == 3) {
            $pmby = "PEMBAYARAN REGISTRASI ULANG";
        }
        $sendatamail = '
    	<div style="max-width:620px; margin:auto">
    		<div style="margin-left: auto;margin-right:auto">
    			<div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #094b8e double 8px;">
                <table style=" width: 100%;">
                <tr>
                    <td style="width: 100px;">
                        <img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
                    </td>
                    <td style="text-align: right;">
                        <div>
                            <h2 style="text-decoration: none; color:#094b8e;font-weight:900">
                                PPDB ' . $dtp->nama_cabang . '
                            </h2> 
                        </div> 
                    </td>
                </tr>
            </table>
    			</div>
    			<div style="background-color: #fff; border-bottom: #094b8e double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:12pt; margin-bottom:6px">
                                Assalamuaiakum, Ayah/Bunda ' . $dtp->nama_lengkap . '.
                                </div>
    							<div style="font-weight:500; font-size:16pt; margin-bottom:6px">
                                No. Register : ' . $dtp->nomor_registrasi . '
                                </div>
    							<div style="font-weight:500; font-size:22pt; margin-bottom:6px">
                               Rp. ' . $ga . '
                                </div>
    							<div style="font-weight:500; font-size:22pt; margin-bottom:6px">
                                Transaksi Berhasil.
                                </div>
    							</div>
    							<div style="margin:20px 0;line-height:100%;font-size:12pt;line-height:12pt">
                                Terimakasih sudah melakukan <b>' . $pmby . '</b>
    							</div>
    					</div>
    				</div>
    			</div>
    			<br>
                #PPDB HIBATULLAH
    		</div>
    	</div>
    	';
        // return $sendatamail;
        return $this->m_mail->SendMail([$dtp->email_reg,], $pmby, $sendatamail);
    }
    function send_MailNotif_Admin($data, $jns, $ga)
    {
        $gender = '-';
        if ($data->jns_kelamin == 1) {
            $gender = 'Laki-Laki';
        } elseif ($data->jns_kelamin == 2) {
            $gender = 'Perempuan';
        }
        $pmby = "PEMBAYARAN FORMULIR Rp." . $ga;
        if ($jns == 2) {
            $pmby = "PEMBAYARAN TES SELEKSI Rp." . $ga;;
        } elseif ($jns == 3) {
            $pmby = "PEMBAYARAN REGISTRASI ULANG Rp." . $ga;;
        }
        $sendatamail = '
    	<div style="max-width:620px; margin:auto">
    		<div style="margin-left: auto;margin-right:auto">
            <div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #094b8e double 8px;">
            <table style=" width: 100%;">
                <tr>
                    <td style="width: 100px;">
                        <img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
                    </td>
                    <td style="text-align: right;">
                        <div>
                            <h2  style="text-decoration: none; color:#094b8e;font-weight:900">
                            ' . $dtp->nama_cabang . '
                            </h2> 
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
    					<div style="font-weight:800; font-size:12pt; margin-bottom:6px;text-align:right">
                               ' . $data->nama_cabang . '
                                </div>
    			<div style="background-color: #fff; border-bottom: #094b8e double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:700; font-size:14pt; margin-bottom:6px">
                               ' . $pmby . '
                                </div>
                                <table style="width:100%;text-align:left">
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Nama Lengkap</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->nama_lengkap) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Tempat Lahir</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->kota) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Tanggal Lahir</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . date("d-m-Y", strtotime($data->tgl_lahir)) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($gender) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Alamat Domisili</b></td>
                                    <td>: </td>
                                    <td>' . $data->alamat_set . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Nama Ayah/Ibu</b></td>
                                    <td>: </td>
                                    <td>' . $data->wali_peserta . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
                                    <td>: </td>
                                    <td>' . $data->phone . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
                                    <td>: </td>
                                    <td>' . $data->email . '</td>
                                </tr>
                            </table>
                                
    							</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	';
        // return $sendatamail;officialsiata;kbtkhafizhquran
        return $this->m_mail->SendMail(['pesantrenhibatullah@gmail.com'], $pmby, $sendatamail);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
// import library dari REST_Controller
require_once(APPPATH . 'libraries/RestApi/src/RestController.php');
require_once(APPPATH . 'libraries/RestApi/src/Format.php');
// use namespace
use chriskacerguis\RestServer\RestController;
// extends class dari REST_Controller
class Pmb extends RestController
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_mail');
        $this->load->library(['secure']);
    }
    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function index_get()
    {
        // testing response
        $response['status'] = 200;
        $response['error'] = true;
        $response['message'] = 'Hai mau ngapain?';
        // tampilkan response
        $this->response($response);
    }
    public function program_get()
    {
        $data = $this->db->get_where("data_kantor_cabang", ['active' => 1, 'hapus' => 0]);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data program belum bibuat'
        ];
        if ($data->num_rows() > 0) {
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $data->result()
            ];
        }
        //tampilkan response
        $this->response($response);
    }
    public function user_get($params)
    {
        $param = json_decode($this->secure->decrypt_url($params));
        $id = $param->id;
        $data = $this->db->get_where("sys_user", ['id_user' => $id, 'aktif' => 'Y']);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data user tidak terdaftar atau tidak aktif.'

        ];
        if ($data->num_rows() > 0) {
            $dt = $data->row_object();
            $response = [
                'status' => 200,
                'error' => false,
                'data' => [
                    'id' => $dt->id_user,
                    'name' => $dt->nama_asli
                ],
            ];
        }
        //tampilkan response
        $this->response($response);
    }
    public function affiliate_get($id)
    {
        // $param = json_decode($this->secure->decrypt_url($params));
        // $id = $param->id;
        $data = $this->db->get_where("sys_user", ['aff_id' => $id, 'aktif' => 'Y']);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data user tidak terdaftar atau tidak aktif.'

        ];
        if ($data->num_rows() > 0) {
            $dt = $data->row_object();
            $response = [
                'status' => 200,
                'error' => false,
                'data' => [
                    'id' => $dt->id_user,
                    'name' => $dt->nama_asli
                ],
            ];
        }
        //tampilkan response
        $this->response($response);
    }
    public function kota_get()
    {
        $data = $this->db->get("master_wilayah_kota");
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data program belum bibuat'
        ];
        if ($data->num_rows() > 0) {
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $data->result()
            ];
        }
        //tampilkan response
        $this->response($response);
    }
    public function periode_get($id = null)
    {

        $getcabang = $this->db->get_where('data_kantor_cabang', ["id" => $id]);
        $namacabang = false;
        if ($getcabang->num_rows() > 0) {
            $cabang = $getcabang->row_object();
            $namacabang = $cabang->nama_cabang;
        }
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data yang anda cari tidak tersedia'
        ];
        if ($namacabang != false) {
            $response = [
                'status' => 500,
                'error' => true,
                'data' => "MOHON MAAF.. PPDB " . $namacabang . ' BELUM DIBUKA'
            ];
        }
        if ($id != null) {
            $data = $this->db->query("SELECT * FROM  master_pmb_tahun_akademik WHERE active=1 AND hapus = 0 AND cabang_id='$id' ");
            if ($data->num_rows() > 0) {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $data->result()
                ];
            }
        }
        //tampilkan response
        $this->response($response);
    }

    // public function periode_get()
    // {
    //     $data = $this->db->get_where('master_pmb_tahun_akademik', ["active" => 1, "hapus" => 0]);
    //     $response = [
    //         'status' => 500,
    //         'error' => true,
    //         'data' => 'Data tahun belum bibuat'
    //     ];
    //     if ($data->num_rows() > 0) {
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'data' => $data->result()
    //         ];
    //     }
    //     //tampilkan response
    //     $this->response($response);
    // }

    public function register_get($id)
    {
        $data = $this->db->query("SELECT a.*,b.*,c.*,d.nama_cabang FROM  
        master_pmb_register_pelajar a 
        INNER JOIN master_pmb_reg b ON b.nomor_reg = a.nomor_registrasi
        LEFT JOIN master_wilayah_kota c on c.id = a.id_kota
        LEFT JOIN data_kantor_cabang d on d.id = a.cabang_id
        WHERE a.nomor_registrasi ='$id' AND b.jns=1");
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Data tidak ditemukan'
        ];
        if ($data->num_rows() > 0) {
            $response = [
                'status' => 200,
                'error' => false,
                'data' => $data->row_object()
            ];
        }
        //tampilkan response
        $this->response($response);
    }
    public function register_post()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => [0]
        ];
        if (!empty($post)) {
            $proses =   $this->db->insert("master_pmb_register_pelajar", $post->data1);
            if ($proses) {
                $this->db->insert("master_pmb_reg", $post->data2);
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $post
                ];
            }
        }
        echo $this->output_json($post);
        $this->response($response);
    }
    public function register_put()
    {
        $nomor_reg = $this->put("nomor_reg");
        $jns = $this->put("jns");
        $norek = $this->put("norek");
        $atasnama = $this->put("atasnama");
        $nota = $this->put("nota");
        $status = $this->put("status");
        $data = [
            "norek"     => $norek,
            "atasnama"  => $atasnama,
            "nota"      => $nota,
            "status"    => $status
        ];
        $update = $this->db->where('nomor_reg', $nomor_reg)->where('jns', $jns)->update('master_pmb_reg', $data);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Update gagal!'
        ];
        if ($update) {
            $this->db->where("nomor_registrasi", $nomor_reg)->update("master_pmb_register_pelajar", ['status_pelajar' => 2]);
            $response = [
                'status' => 200,
                'error' => false,
                'data' => "Update Success!"
            ];
            $dtp = $this->db->query("SELECT a.*,b.*,c.*,d.nama_cabang FROM  
        master_pmb_register_pelajar a 
        INNER JOIN master_pmb_reg b ON b.nomor_reg = a.nomor_registrasi
        LEFT JOIN master_wilayah_kota c on c.id = a.id_kota
        LEFT JOIN data_kantor_cabang d on d.id = a.cabang_id
            WHERE a.nomor_registrasi='$nomor_reg'")->row_object();
            $this->send_MailNotif_Aamin($dtp, $data);
        }
        $this->response($response);
    }

    public function regtoken_put()
    {
        $nomor_reg          = $this->put("nomor_reg");
        $nota               = $this->put("nota");
        $jns                = $this->put("jns");
        $gross_amount       = $this->put("gross_amount");
        $payment_type       = $this->put("payment_type");
        $fraud_status       = $this->put("fraud_status");
        $transaction_status = $this->put("transaction_status");
        $expiry_at          = $this->put("expiry_at");
        $data = [
            'nomor_reg'             => $nomor_reg,
            'nota'                  => $nota,
            'jns'                   => $jns,
            'payment_type'          => $payment_type,
            'fraud_status'          => $fraud_status,
            'transaction_status'    => $transaction_status,
            'expiry_at'             => $expiry_at
        ];
        $update = $this->db->where('nomor_reg', $nomor_reg)->where('jns', $jns)->update('master_pmb_reg', $data);
        $response = [
            'status' => 500,
            'error' => true,
            'data' => 'Update gagal!'
        ];
        if ($update) {
            $response = [
                'status' => 200,
                'error' => false,
                'data' => "Update Success!"
            ];
            $this->response($response);
        }
    }


    function send_MailNotif_Aamin($data, $dt)
    {
        $gender = '-';
        if ($data->jns_kelamin == 1) {
            $gender = 'Laki-Laki';
        } elseif ($data->jns_kelamin == 2) {
            $gender = 'Perempuan';
        }
        $sendatamail = '
    	<div style="max-width:620px; margin:auto">
    		<div style="margin-left: auto;margin-right:auto">
    			<div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #027530 double 8px;">
    				<table style=" width: 100%;">
    					<tr>
    						<td style="width: 100px;">
    							<img src="' . base_url("assets/images/pavicon.png") . '" style="width:80px" alt="">
    						</td>
    						<td style="text-align: right;">
    								<h2  style="text-decoration: none; color:#027530;font-weight:900">
    								PPDB ' . strtoupper($data->nama_cabang) . '
    								</h2>
    						</td>
    					</tr>
    				</table>
    			</div>
    					<div style="font-weight:800; font-size:12pt; margin-bottom:6px;text-align:right">
                               ' . $data->nama_cabang . '
                                </div>
    			<div style="background-color: #fff; border-bottom: #027530 double 2px; padding:10px 0">
    				<div class="col">
    					<div style="margin-top:1%">
    						<div style="padding:4px 10px">
    							<div style="font-weight:500; font-size:14pt; margin-bottom:6px">
                                Pembayaran Formulir :
                                </div>
                                <table style="width:100%;text-align:left">
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Nama Lengkap</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->nama_lengkap) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Panggilan</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($data->nama_panggilan) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($gender) . '</td>
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
    							<div style="font-weight:500; font-size:14pt; margin-bottom:6px">
                                    Data Pengirim:
                                </div>
                                <table style="width:100%;text-align:left">
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Atas Nama</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . strtoupper($dt['atasnama']) . '</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>No. Rekening</b></td>
                                    <td style="width:6px">: </td>
                                    <td>' . ($dt['norek']) . '</td>
                                </tr>
                            </table>
    							</div>
    					</div>
    				</div>
    			</div>
    			<br>
                #PPDB Hibatullah
    		</div>
    	</div>
    	</div>
    	';
        // return $sendatamail;kbtkhafizhquran;officialsiata
        return $this->m_mail->SendMail(['pesantrenhibatullah@gmail.com',], 'PEMBAYARAN FORMULIR', $sendatamail);
    }
}

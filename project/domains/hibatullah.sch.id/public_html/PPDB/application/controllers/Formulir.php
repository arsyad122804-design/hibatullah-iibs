<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Formulir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['secure', 'session', 'upload']);
        $this->load->model('m_mail');
    }

    public function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function index()
    {
        $site_api = "https://sistem.hibatullah.sch.id/";
        $api_1 = $site_api . 'api/v1/pmb/program';
        $api_2 = $site_api . 'api/v1/pmb/periode';
        $api_3 = $site_api . 'api/v1/pmb/kota';
        // Read JSON file
        $program = file_get_contents($api_1);
        $periode = file_get_contents($api_2);
        $kota = file_get_contents($api_3);
        // Decode JSON data into PHP array
        $data['program'] = json_decode($program);
        $data['periode'] = json_decode($periode);
        $data['kota'] = json_decode($kota);
        $data['title'] = "Formulir Pendaftaran";
        $data['token'] = $this->secure->encrypt_url($site_api);;
        $this->load->view('template/head_in', $data);
        $this->load->view('formulir');
        $this->load->view('template/footer');
    }
    function get_periode($id)
    {
        $site_api = "https://sistem.hibatullah.sch.id/";
        $api_2 = $site_api . 'api/v1/pmb/periode/' . $id;
        $periode = $this->curl_data($api_2);
        $dt2 = json_decode($periode, true);
        echo json_encode($dt2);
    }

    function curl_data($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);
        return $data;
    }
    function register()
    {
        // API endpoint
        $params = $this->input->post('token');
        $aff = $this->secure->decrypt_url($this->session->userdata('aff_token_setting'));
        $aff_token = 0;
        if ($aff) {
            // $setparam = json_decode($param);
            $aff_token = $aff;
        }
        // var_dump($param);
        $site_api = $this->secure->decrypt_url($params);
        $apiUrl = $site_api . 'api/v1/pmb/register';
        // Headers for the request

        $headers = [
            'Authorization: key=sAaA79Nl0899spi.ksd2523623iof8923.3125239898asfiuy23947',
            'Content-Type: application/json',
        ];
        $Cabang = $this->input->post('Cabang');
        $periode = $this->input->post('periode');
        $tgllahir = $this->input->post('tgl_lahir');
        $nominal = $this->input->post('Nominal');
        $param = explode("-", $periode);
        $rand = rand(100, 999);
        $register =  substr($param[0], 2) . date('md') . $rand;
        $amount = ((int)$nominal + $rand);

        // Define the message body
        $data = [
            'nomor_registrasi'  => $register,
            'cabang_id'         => $this->input->post('program'),
            'periode'           => $periode,
            'nama_lengkap'      => $this->input->post('nm_lengkap'),
            'jns_kelamin'       => $this->input->post('gender'),
            'id_kota'           => $this->input->post('kota_lahir'),
            'tgl_lahir'         => date('Y-m-d', strtotime($tgllahir)),
            'alamat'            => $this->input->post('alamat'),
            'id_kelurahan'      => $this->input->post('Kelurahan'),
            'wali_peserta'      => $this->input->post('wali'),
            'phone'             => $this->input->post('telepon'),
            'email'             => $this->input->post('email'),
            'nama_sekolah'      => $this->input->post('sekolah_asal'),
            'tgl_pendaftaran'   => $param[0] . date('-m-d H:i'),
            'status_pelajar'    => 1,
            'aff_id'            => $aff_token,
        ];
        $data2 = [
            'jns'  => 1,
            'nomor_reg'  => $register,
            'nominal'  => $amount,
            'status'  => 0,
        ];
        $postdata = [
            'data1' => $data,
            'data2' => $data2,
        ];
        // // Initialize cURL session
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        // Execute cURL session and capture the response
        $response = curl_exec($ch);
        // Close cURL session
        curl_close($ch);
        $dr = json_decode($response);
        $params_set = [
            'site_api' => $site_api,
            'cabang' => $Cabang,
            'response' => $response
        ];
        if ($dr->status == 200) {
            $this->send_MailNotif($site_api, $Cabang, $response);
        }

        // redirect the response status

        header("Location:" . base_url('a/register/' . $this->secure->encrypt_url(json_encode($params_set))));
        die();

        // echo json_encode($data);
    }

    function send_MailNotif($site_api, $Cabang, $response)
    {
        $json = $this->secure->encrypt_url(json_encode(['site_api' => $site_api, 'cabang' => $Cabang, 'response' => $response]));

        $data = json_decode($response);
        $gender = '-';
        if ($data->data->data1->jns_kelamin == 1) {
            $gender = 'Laki-Laki';
        } elseif ($data->data->data1->jns_kelamin == 2) {
            $gender = 'Perempuan';
        }
        $sendatamail = '
		<div style="max-width:620px; margin:auto">
			<div style="margin-left: auto;margin-right:auto">
				<div style="padding: 20px 10px 0 10px;background-color: #fff;border-bottom: #e37b46 double 8px;">
					<table style=" width: 100%;">
						<tr>
							<td style="width: 100px;">
								<img src="' . base_url("assets/img/Logo.png") . '" style="width:80px" alt="">
							</td>
							<td style="text-align: right;">
								<div>
									<a target="_blank" href="https://hibatullah.sch.id/" style="text-decoration: none; color:#0744a9;font-weight:900">
										REGISTRASI PPDB
									</a>
									<div><span style="font-size: 12pt; font-weight:700;color:#0744a9;">' . strtoupper($Cabang) . '</span></div>
								</div> 
							</td>
						</tr>
					</table>
				</div>
				<div style="background-color: #adc4f8; padding:4px 10px">
					<table style="width: 100%;">
						<tr>
							<td style="text-align:left;font-weight:900">No. Registrasi</td>
							<td style="text-align:right;font-weight:900; font-size:14pt">#' . $data->data->data1->nomor_registrasi . '</td>
						</tr>
					</table>
				</div>
				<div style="background-color: #fff; padding:10px 0">
					<div class="col">
						<div style="margin-top:1%">
							<div style="padding:4px 10px">
								<div style="font-weight:500; font-size:14pt; margin-bottom:6px">Data Calon Peserta Didik Baru :</div>
								<table style="width:100%;text-align:left">
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:100px"><b>Nama Lengkap</b></td>
										<td style="width:10px">: </td>
										<td>' . strtoupper($data->data->data1->nama_lengkap) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Tanggal Lahir</b></td>
										<td style="width:6px">: </td>
										<td>' . date("d-m-Y", strtotime($data->data->data1->tgl_lahir)) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Jenis Kelamin</b></td>
										<td style="width:6px">: </td>
										<td>' . strtoupper($gender) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px; width:130px"><b>Alamat Domisili</b></td>
										<td style="width:6px">: </td>
										<td>' . ($data->data->data1->alamat) . '</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Nama Ayah/Ibu</b></td>
										<td>: </td>
										<td>' . strtoupper($data->data->data1->wali_peserta) . '
										</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>No. Telepon</b></td>
										<td>: </td>
										<td>' . $data->data->data1->phone . '
										</td>
									</tr>
									<tr>
										<td style="font-weight:900; font-size:11pt; margin-bottom:6px"><b>Email</b></td>
										<td>: </td>
										<td>' . $data->data->data1->email . '</td>
									</tr>
								</table>
								</div>
								<div style="margin-top: 20px; padding:10px; border-radius:10px; background-color:#adc4f8">
									<table style="width:100%">
										<thead>
											<th style="text-align: left;font-weight:500; font-size:14pt; ">Pembayaran</th>
											<th style="text-align:right;font-weight:500; font-size:14pt; ">Nominal</th>
										</thead>
										<tr>
											<td style="text-align: left; font-size:14pt;;font-weight:700">Formulir Registrasi</td>
											<td style="text-align:right; font-size:32px; font-weight:800">
												Rp. ' . number_format($data->data->data2->nominal) . '</td>
										</tr>
									</table>
								</div>
							<div  style="font-size: 13pt; font-weight:700; margin: 20px 0; align-item:center">Silahkan lakukan pembayaran melalui tombol di bawah ini.</div>
							<a  style="
                            background-color: #e37b46;
                            border: none;
                            color: white;
                            border-radius:8px;
                            padding: 12px 28px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            transition-duration: 0.4s;
                            cursor: pointer;
                            border: 2px solid #e37b46;" target="blank_" href="' . base_url('a/register/' . $json) . '">PROSES PEMBAYARAN</a>
						
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		</div>
		';
        // return $sendatamail;
        return $this->m_mail->SendMail([$data->data->data1->email,], 'FORMULIR PPDB', $sendatamail);
    }

    function testmail()
    {

        return $this->m_mail->SendMail(['apollogical@gmail.com'], 'TES PPDB', "HELLO WORLD");
    }

    function get_kecamatan()
    {
        $id = $this->input->post("id");
        $kecamatan = $this->db->get_where("master_wilayah_kecamatan", ['kota_id' => $id])->result();
        echo $this->output_json(['result' => true, 'kec' => $kecamatan]);
    }
    function get_kelurahan()
    {
        $id = $this->input->post("id");
        $kelurahan = $this->db->get_where("master_wilayah_kelurahan", ['kecamatan_id' => $id])->result();
        echo $this->output_json(['result' => true, 'kel' => $kelurahan]);
    }
}

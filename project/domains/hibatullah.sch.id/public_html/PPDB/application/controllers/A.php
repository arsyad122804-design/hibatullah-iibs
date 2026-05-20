<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class A extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(['secure', 'session']);
		$this->load->library('upload', 'language');
		// $this->config->set_item('language', 'arabic');
	}

	public function index($aff_token = null)
	{
		if ($aff_token != null) {


			$site_api = "https://sistem.hibatullah.sch.id/";
			$api_1 = $site_api . 'api/v1/pmb/affiliate/' . $aff_token;
			// Read JSON file
			$user = json_decode(file_get_contents($api_1));
			if (($user)) {
				($user->status == 200) ? $this->session->set_userdata(['aff_token_setting' => $this->secure->encrypt_url($user->data->id)]) : '';
				// var_dump($user);
				// echo $user->data->id;
			}
		}
		// echo $this->session->userdata('aff_token_setting');
		$data['title'] = "PPDB PONPES MODERN HIBATULLAH";
		// $this->load->view('landing/head', $data);
		$this->load->view('home-custom');
		// $this->load->view('landing/footer');

	}
	function register($params = null)
	{
		if ($params != null) :
			$json = $this->secure->decrypt_url($params);
			$dataset = json_decode($json);
			$site_api = $dataset->site_api;
			$response = json_decode($dataset->response);
			$api =  $site_api . 'api/v1/pmb/register/' . $response->data->data1->nomor_registrasi;
			// Read JSON file
			$datareg = file_get_contents($api);
			$data['site_api'] = $site_api;
			$data['data'] =  json_decode($datareg);
			$data['title'] = "REGISTER FINISH";

			$this->load->view('template/head_in', $data);
			$this->load->view('register');
			$this->load->view('template/footer');
		// echo $this->send_MailNotif($data);
		else :
			redirect(base_url());
		endif;
	}


	function konfirmasi($params = null)
	{
		if ($params != null) :
			$json = $this->secure->decrypt_url($params);
			$dataset = json_decode($json);
			$api =  $dataset->url . 'api/v1/pmb/register/' . $dataset->id;
			// Read JSON file
			$datareg = file_get_contents($api);
			// print_r($dataset);
			$data['token'] = $params;
			$data['data'] = json_decode($datareg);
			$data['title'] = "KONFIRMASI";
			$this->load->view('template/head_in', $data);
			$this->load->view('konfirmasi');
			$this->load->view('template/footer');
		else :
			redirect(base_url());
		endif;
	}


	function rekonfirmasi()
	{
		$token 			= $this->input->post("token");
		$jns 			= $this->input->post("jns");
		$noregister 	= $this->input->post("noregister");
		$rekpengirim 	= $this->input->post("rekpengirim");
		$atasnama 		= $this->input->post("atasnama");
		$nota 			= $this->input->post("nota");

		$json = $this->secure->decrypt_url($token);
		$dt = json_decode($json);
		// API endpoint
		$site_api = $dt->url;
		$apiUrl = $site_api . 'api/v1/pmb/register';
		// Headers for the FCM request
		$headers = [
			"cache-control: no-cache",
			"content-type: application/json",
			"x-api-key: 1234567"
		];
		// Define the message body
		$send_data = [
			'nomor_reg'  	=> $noregister,
			'jns'  			=> $jns,
			'norek'  		=> $rekpengirim,
			'atasnama'  	=> $atasnama,
			'nota'  		=> base_url('databerkas/') . $nota,
			'status'  		=> 1,
		];
		// Initialize cURL session
		$ch = curl_init();
		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_data));
		// Execute cURL session and capture the response
		$response = curl_exec($ch);
		// Close cURL session
		curl_close($ch);
		$err = curl_error($ch);
		$dr = json_decode($response);
		header("Location:" . base_url('pmb/konfirmasi/' . $token));
		die();
	}
	function uploads_img()
	{
		$config['upload_path'] = './databerkas/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!empty($_FILES['file']['name'])) {
			if ($this->upload->do_upload('file')) {
				$gbr = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = './databerkas/' . $gbr['file_name'];
				$config['create_thumb'] = false;
				$config['maintain_ratio'] = false;
				$config['quality'] = 50;
				$config['new_image'] = './databerkas/' . $gbr['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$photomhs = $gbr['file_name'];
				$response = [
					"img" => substr($config['new_image'], 1),
					"nimg" => $photomhs,
				];
				echo json_encode($response);
				exit;
			}
		} else {
			echo 0;
		}
	}
	function info()
	{
		$token = $this->input->post("token");
		$name = $this->input->post("name");
		$address = $this->input->post("address");
		$number = $this->input->post("number");
		$message = $this->input->post("message");
		$cid = 0;
		if ($token) {
			$ctoken = json_decode($this->secure->decrypt_url($token));
			$cid = $ctoken;
		}
		$data = [
			'id_aff' => $cid,
			'nama' => $name,
			'alamat' => $address,
			'hp' => $number,
		];
		$save = $this->db->insert("data_customer", $data);
		if ($save) {
			$message = "Assalamu%27alaikum%0A%0ASaya%20*$name*%20dari%20*$address*,%20mohon%20informasi%20lengkap terkait%20PPDB%20Pondok%20Pesantren%20Modern%20Hibatullah%20Bojonegoro.";
		}
		echo json_encode($message);
	}
}
